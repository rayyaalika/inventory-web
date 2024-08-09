from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
from tensorflow.keras.models import load_model
from sklearn.preprocessing import MinMaxScaler
import mysql.connector
import os
from datetime import timedelta

app = Flask(__name__)

# Function to load data from database (example using MySQL)
def load_data_from_db(item_name):
    conn = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="db_inventory_web"
    )
    
    cursor = conn.cursor()
    query = "SELECT date, item_name, quantity FROM bakery_sale WHERE item_name = %s"
    cursor.execute(query, (item_name,))
    
    # Fetch all rows into a pandas DataFrame
    columns = [col[0] for col in cursor.description]
    data = cursor.fetchall()
    df = pd.DataFrame(data, columns=columns)
    
    # Close cursor and connection
    cursor.close()
    conn.close()
    
    return df

# Endpoint untuk prediksi
@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()
    article_input = data.get('article')
    
    # Memuat model yang sesuai dengan artikel
    model_path = f'models/best_model_{article_input.replace(" ", "_")}.keras'
    
    if not os.path.exists(model_path):
        return jsonify({"error": f"Model untuk artikel '{article_input}' tidak ditemukan."})

    model = load_model(model_path)
    
    # Load data for the specified article
    df = load_data_from_db(article_input)
    df['date'] = pd.to_datetime(df['date'])
    df = df.loc[df['quantity'] >= 0]

    if df.empty:
        return jsonify({"error": f"Tidak ada data untuk artikel '{article_input}'."})

    # Menjumlahkan pembelian produk per bulan
    df['month'] = df['date'].dt.to_period('M')
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

    # Menggunakan semua data yang tersedia untuk memprediksi
    look_back = len(monthly_data)
    dataX = np.array(monthly_data['quantity']).reshape((1, look_back, 1))

    # Prediksi untuk 7 hari ke depan (mulai dari Senin hingga Minggu)
    future_input = dataX
    future_predictions = []

    for _ in range(7):
        next_prediction = model.predict(future_input)
        future_predictions.append(next_prediction)
        future_input = np.append(future_input[:, 1:, :], next_prediction.reshape((1, 1, 1)), axis=1)

    # Balikkan skala prediksi ke nilai aslinya
    future_predictions = np.array(future_predictions).reshape(7, 1)
    future_predictions = scaler.inverse_transform(future_predictions)

    # Create data for plot
    last_date = monthly_data.index[-1]
    predicted_dates = pd.date_range(start=last_date + pd.DateOffset(days=1), periods=7)

    # Return predictions and dates
    return jsonify({
        'predictions': future_predictions.flatten().tolist(),
        'dates': predicted_dates.strftime('%Y-%m-%d').tolist()
    })

if __name__ == '__main__':
    app.run(debug=False)
