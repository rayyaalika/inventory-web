from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
import tensorflow as tf
from tensorflow.keras.models import Sequential, load_model
from tensorflow.keras.layers import LSTM, Dense, Dropout
from sklearn.preprocessing import MinMaxScaler
from sklearn.model_selection import train_test_split
from tensorflow.keras.callbacks import ModelCheckpoint
import joblib
import random
import os
import math
import mysql.connector

app = Flask(__name__)

# Menetapkan seed untuk semua sumber pengacakan
def set_seed(seed=42):
    random.seed(seed)
    np.random.seed(seed)
    tf.random.set_seed(seed)

set_seed()

# Function to load data from database (example using MySQL)
def load_data_from_db():
    conn = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="db_inventory_web"
    )
    
    cursor = conn.cursor()
    query = "SELECT date, item_name, quantity FROM bakery_sale"
    cursor.execute(query)
    
    # Fetch all rows into a pandas DataFrame
    columns = [col[0] for col in cursor.description]
    data = cursor.fetchall()
    df = pd.DataFrame(data, columns=columns)
    
    # Close cursor and connection
    cursor.close()
    conn.close()
    
    return df

# Fungsi untuk membuat dataset sesuai dengan format LSTM
def create_dataset(data, look_back=1):
    dataX, dataY = [], []
    for i in range(len(data) - look_back):
        dataX.append(data.iloc[i:(i + look_back)].values)
        dataY.append(data.iloc[i + look_back])
    return np.array(dataX), np.array(dataY)

@app.route('/superadmin', methods=['POST'])
def predict():
    data = request.get_json()
    article_input = data.get('article')
    
    df = load_data_from_db()
    df['date'] = pd.to_datetime(df['date'])
    df = df.loc[df['quantity'] >= 0]

    # Filter data untuk artikel yang dipilih pengguna
    article_data = df[df['item_name'] == article_input]

    if article_data.empty:
        return jsonify({"error": f"Tidak ada data untuk artikel '{article_input}'."})

    # Menjumlahkan pembelian produk per bulan
    article_data['month'] = article_data['date'].dt.to_period('M')
    monthly_data = article_data.groupby(['item_name', 'month']).agg({'quantity': 'sum'}).reset_index()
    monthly_data['month'] = monthly_data['month'].dt.to_timestamp()

    monthly_data.set_index('month', inplace=True)
    
    # Normalisasi data
    scaler = MinMaxScaler(feature_range=(0, 1))
    monthly_data['quantity'] = scaler.fit_transform(monthly_data[['quantity']])

    # Menggunakan 12 bulan sebelumnya untuk memprediksi bulan berikutnya
    look_back = 12
    X, y = create_dataset(monthly_data['quantity'], look_back)

    if X.size == 0 or y.size == 0:
        return jsonify({"error": f"Tidak cukup data untuk melakukan prediksi pada artikel '{article_input}'."})

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
    checkpoint = ModelCheckpoint('best_model.keras', monitor='val_loss', save_best_only=True, mode='min')

    # Melatih model LSTM dan menyimpan riwayat loss
    history = model.fit(X_train, y_train, epochs=200, batch_size=1, verbose=2, validation_data=(X_test, y_test), callbacks=[checkpoint])

    # Memuat model terbaik yang disimpan selama pelatihan
    model = load_model('best_model.keras')

    # Membuat prediksi menggunakan model pada data pengujian
    testPredict = model.predict(X_test)

    # Mengembalikan skala data ke dalam bentuk awal
    testPredict = scaler.inverse_transform(testPredict)
    y_test = scaler.inverse_transform(np.array(y_test).reshape(-1, 1))

    # Prediksi untuk data ke depan
    future_input = monthly_data['quantity'][-look_back:].values.reshape((1, look_back, 1))
    future_predictions = []

    for i in range(12):  # Prediksi untuk 12 bulan ke depan
        next_prediction = model.predict(future_input)
        future_predictions.append(next_prediction)
        future_input = np.append(future_input[:, 1:, :], next_prediction.reshape((1, 1, 1)), axis=1)

    # Balikkan skala prediksi ke nilai aslinya
    future_predictions = np.array(future_predictions).reshape(12, 1)
    future_predictions = scaler.inverse_transform(future_predictions)

    # Create data for plot
    predicted_dates = pd.date_range(start=monthly_data.index.max(), periods=12, freq='M')

    # Return predictions and dates
    return jsonify({
        'predictions': future_predictions.tolist(),
        'dates': predicted_dates.strftime('%Y-%m-%d').tolist()
    })

if __name__ == '__main__':
    app.run(debug=False)