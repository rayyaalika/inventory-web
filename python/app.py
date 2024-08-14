from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
import joblib
import os
import mysql.connector
from sklearn.preprocessing import MinMaxScaler
from tensorflow.keras.models import Sequential, load_model
from tensorflow.keras.layers import LSTM, Dense
import tensorflow as tf
from datetime import timedelta

app = Flask(__name__)

def set_seed(seed=42):
    import random
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

def preprocess_data(df):
    df['date'] = pd.to_datetime(df['date'])
    df['quantity'] = pd.to_numeric(df['quantity'], errors='coerce')
    df = df.dropna()  # Drop rows with NaN values
    
    df = df.groupby(['item_name', 'date', 'id_bakery']).agg({'quantity': 'sum'}).reset_index()
    df.set_index('date', inplace=True)
    daily_data = df.groupby(['item_name']).resample('D').sum().reset_index(level=0, drop=True).fillna(0).reset_index()
    return daily_data

def create_dataset(data, look_back=7):
    dataX, dataY = [], []
    for i in range(len(data) - look_back):
        dataX.append(data[i:(i + look_back)])
        dataY.append(data[i + look_back])
    return np.array(dataX), np.array(dataY)

def build_model(input_shape):
    model = Sequential()
    model.add(LSTM(50, return_sequences=True, input_shape=input_shape))
    model.add(LSTM(50))
    model.add(Dense(1))
    model.compile(loss='mean_squared_error', optimizer='adam')
    return model

def predict_sales(model, data, scaler, look_back, prediction_days):
    dataX, _ = create_dataset(data, look_back)
    dataX = np.reshape(dataX, (dataX.shape[0], look_back, 1))
    
    predictions = []
    input_sequence = data[-look_back:]
    
    for _ in range(prediction_days):
        input_sequence = np.reshape(input_sequence, (1, look_back, 1))
        next_prediction = model.predict(input_sequence)[0][0]
        predictions.append(next_prediction)
        input_sequence = np.append(input_sequence[:, 1:, :], [[[next_prediction]]], axis=1)
    
    if scaler:
        predictions = scaler.inverse_transform(np.array(predictions).reshape(-1, 1))
    
    return predictions


models = {}

@app.route('/update_model', methods=['POST'])
def update_model():
    df = load_data_from_db()
    df_processed = preprocess_data(df)
    
    look_back = 7
    
    for item_name in df_processed['item_name'].unique():
        df_item = df_processed[df_processed['item_name'] == item_name].copy()
        df_item = df_item[['quantity']]
        scaler = MinMaxScaler(feature_range=(0, 1))
        df_item['quantity'] = scaler.fit_transform(df_item[['quantity']])
        
        X, y = create_dataset(df_item['quantity'].values, look_back)
        if X.shape[0] == 0 or X.shape[1] == 0:
            # print(f"Skipping item: {item_name} due to insufficient data after preprocessing.")
            continue
        X = np.reshape(X, (X.shape[0], X.shape[1], 1))
        
        train_size = int(len(X) * 0.8)
        X_train, X_test = X[:train_size], X[train_size:]
        y_train, y_test = y[:train_size], y[train_size:]
        
        model = build_model((look_back, 1))
        model.fit(X_train, y_train, epochs=20, batch_size=512, validation_data=(X_test, y_test))
        
        models[item_name] = (model, scaler)
    
    # Save all models and scalers to a single .pkl file
    joblib.dump(models, 'models/models_dicts.pkl')
    
    return jsonify({'message': 'Models updated successfully'}), 200

@app.route('/superadmin', methods=['POST'])
def predict():
    item_name_code = request.json.get('item_name')
    prediction_days = 7
    
    if not os.path.exists('D:/inventory-web/models/models_dicts.pkl'):
        return jsonify({'error': 'Models file not found'}), 503

    models = joblib.load('D:/inventory-web/models/models_dicts.pkl')
    
    if item_name_code in models:
        model, scaler = models[item_name_code]
        df = load_data_from_db()
        df_processed = preprocess_data(df)
        
        df_item = df_processed[df_processed['item_name'] == item_name_code].copy()
        df_date = df_item[['date']]
        df_item = df_item[['quantity']]
        
        if len(df_item) < 7:
            return jsonify({'error': 'Insufficient data for prediction'}), 400
        
        df_item['quantity'] = scaler.transform(df_item[['quantity']])
        
        predictions = predict_sales(model, df_item['quantity'].values, scaler, 7, prediction_days)

         # Ambil tanggal terakhir dari data
        last_date = pd.to_datetime(df_date.iloc[-1].date)
    
        future_dates = [last_date + timedelta(days=i) for i in range(1, len(predictions) + 1)]
        
        return jsonify({
            'predictions': predictions.tolist(),
            'dates': future_dates
        }), 200
    else:
        return jsonify({'error': 'Model for the specified item not found'}), 422

if __name__ == '__main__':
    if not os.path.exists('models'):
        os.makedirs('models')
    app.run(debug=False)