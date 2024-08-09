from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
import tensorflow as tf
from tensorflow.keras.models import Sequential, load_model
from tensorflow.keras.layers import LSTM, Dense, Dropout
from sklearn.preprocessing import MinMaxScaler
from sklearn.model_selection import train_test_split
from tensorflow.keras.callbacks import ModelCheckpoint
import os
import mysql.connector

app = Flask(__name__)

def set_seed(seed=42):
    import random
    import tensorflow as tf
    random.seed(seed)
    np.random.seed(seed)
    tf.random.set_seed(seed)

set_seed()

def load_data_from_db():
    conn = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="db_inventory_web"
    )
    cursor = conn.cursor()
    query = "SELECT id_bakery, date, item_name, quantity FROM bakery_sale"
    cursor.execute(query)
    columns = [col[0] for col in cursor.description]
    data = cursor.fetchall()
    df = pd.DataFrame(data, columns=columns)
    cursor.close()
    conn.close()
    return df

def create_dataset(data, look_back=1):
    dataX, dataY = [], []
    for i in range(len(data) - look_back):
        dataX.append(data.iloc[i:(i + look_back)].values)
        dataY.append(data.iloc[i + look_back])
    return np.array(dataX), np.array(dataY)

def preprocess_data(df):
    df['date'] = pd.to_datetime(df['date'])
    df['quantity'] = pd.to_numeric(df['quantity'], errors='coerce')
    df = df.dropna()  # Drop rows with NaN values
    
    # Hapus duplikat dengan menjumlahkan quantity per item_name, date, dan id_bakery
    df = df.groupby(['item_name', 'date', 'id_bakery']).agg({'quantity': 'sum'}).reset_index()
    
    # Set 'date' as the index
    df.set_index('date', inplace=True)
    
    # Agregasi lebih lanjut berdasarkan item_name dan tanggal untuk data harian
    daily_data = df.groupby(['item_name']).resample('D').sum().fillna(0).reset_index()

    print("Preprocessed data:")
    print(daily_data.head())
    print(f"Total number of records after preprocessing: {len(daily_data)}")
    
    return daily_data

@app.route('/update_model', methods=['POST'])
def update_model():
    df = load_data_from_db()
    df = preprocess_data(df)
    
    if df.empty:
        return jsonify({"error": "No valid data after filtering."})

    # Ambil semua item yang unik
    items = df['item_name'].unique()

    for item in items:
        print(f"Training model for item: {item}")
        
        # Filter data untuk item yang dipilih
        article_data = df[df['item_name'] == item]

        if article_data.empty:
            print(f"No data available for item '{item}'. Skipping...")
            continue

        # Menentukan frekuensi data
        article_data.set_index('date', inplace=True)
        article_data = article_data.resample('D').sum().fillna(0)

        if article_data.empty:
            print(f"No daily data available for item '{item}'. Skipping...")
            continue

        num_days = len(article_data)
        print(f"Data available for item '{item}': {num_days} days")

        # Normalisasi data
        scaler = MinMaxScaler(feature_range=(0, 1))
        article_data['quantity'] = scaler.fit_transform(article_data[['quantity']])

        # Gunakan seluruh data untuk pelatihan
        look_back = min(num_days, 7)
        X, y = create_dataset(article_data['quantity'], look_back)

        if X.size == 0 or y.size == 0:
            print(f"Not enough data to train model for item '{item}'. Skipping...")
            continue

        # Reshape input menjadi [samples, time steps, features]
        X = np.reshape(X, (X.shape[0], X.shape[1], 1))

        # Membagi data menjadi training dan testing set
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

        # Membuat model LSTM
        model = Sequential()
        model.add(LSTM(100, return_sequences=True, input_shape=(look_back, 1)))
        model.add(Dropout(0.8))
        model.add(LSTM(100, return_sequences=False))
        model.add(Dropout(0.8))
        model.add(Dense(1))

        # Kompilasi model
        model.compile(loss='mean_squared_error', optimizer='adam')

        # Gunakan ModelCheckpoint untuk menyimpan model terbaik
        model_path = f'models/{item.replace(" ", "_")}_best_model.keras'
        checkpoint = ModelCheckpoint(model_path, monitor='val_loss', save_best_only=True, mode='min')

        # Melatih model LSTM dan menyimpan riwayat loss
        model.fit(X_train, y_train, epochs=10, batch_size=1, verbose=2, validation_data=(X_test, y_test), callbacks=[checkpoint])

    return jsonify({"message": "Model untuk semua item telah berhasil dibuat dan disimpan."})

@app.route('/superadmin', methods=['POST'])
def predict():
    data = request.get_json()
    article_input = data.get('article')
    
    # Memuat model yang sesuai dengan artikel
    model_path = f'models/{article_input.replace(" ", "_")}_best_model.keras'
    
    if not os.path.exists(model_path):
        return jsonify({"error": f"Model untuk artikel '{article_input}' tidak ditemukan."})

    model = load_model(model_path)
    
    # Load data for the specified article
    df = load_data_from_db()
    df = df[df['item_name'] == article_input]
    df = preprocess_data(df)
    
    if df.empty:
        return jsonify({"error": f"Tidak ada data untuk artikel '{article_input}'."})

    # Mengatur indeks sebagai datetime dan menjumlahkan pembelian produk per bulan
    df.set_index('date', inplace=True)
    df['month'] = df.index.to_period('M')
    monthly_data = df.groupby(['item_name', 'month']).agg({'quantity': 'sum'}).reset_index()
    monthly_data['month'] = monthly_data['month'].dt.to_timestamp()

    # Tambahkan bulan yang tidak ada dengan nilai 0
    all_months = pd.date_range(start=monthly_data['month'].min(), end=monthly_data['month'].max(), freq='M')
    monthly_data = monthly_data.set_index('month').reindex(all_months, fill_value=0).reset_index()
    monthly_data['item_name'] = article_input
    monthly_data.set_index('index', inplace=True)

    # Normalisasi data
    scaler = MinMaxScaler(feature_range=(0, 1))
    monthly_data['quantity'] = scaler.fit_transform(monthly_data[['quantity']])

    # Menggunakan seluruh data yang tersedia untuk memprediksi
    look_back = len(monthly_data)
    dataX = np.array(monthly_data['quantity']).reshape((1, look_back, 1))

    # Prediksi untuk 7 hari ke depan
    future_input = dataX
    future_predictions = []

    for _ in range(7):
        next_prediction = model.predict(future_input)
        future_predictions.append(next_prediction)
        future_input = np.append(future_input[:, 1:, :], next_prediction.reshape((1, 1, 1)), axis=1)

    # Balikkan skala prediksi ke nilai aslinya
    future_predictions = np.array(future_predictions).reshape(7, 1)
    future_predictions = scaler.inverse_transform(future_predictions)

    # Create dates for predictions
    last_date = monthly_data.index[-1]
    predicted_dates = pd.date_range(start=last_date + pd.DateOffset(days=1), periods=7)

    # Return predictions and dates
    return jsonify({
        'predictions': future_predictions.flatten().tolist(),
        'dates': predicted_dates.strftime('%Y-%m-%d').tolist()
    })


if __name__ == '__main__':
    if not os.path.exists('models'):
        os.makedirs('models')
    app.run(debug=False)
