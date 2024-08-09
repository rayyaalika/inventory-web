from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
from tensorflow.keras.models import Sequential, load_model
from tensorflow.keras.layers import LSTM, Dense, Dropout
from sklearn.preprocessing import MinMaxScaler
from sklearn.model_selection import train_test_split
import mysql.connector
import os

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
    query = "SELECT date, item_name, quantity FROM bakery_sale"
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

@app.route('/update_model', methods=['POST'])
def update_model():
    df = load_data_from_db()
    df['date'] = pd.to_datetime(df['date'])
    df = df.loc[df['quantity'] >= 0]
    articles = df['item_name'].unique()
    for article in articles:
        article_data = df[df['item_name'] == article]
        if article_data.empty:
            continue
        article_data['month'] = article_data['date'].dt.to_period('M')
        monthly_data = article_data.groupby(['item_name', 'month']).agg({'quantity': 'sum'}).reset_index()
        monthly_data['month'] = monthly_data['month'].dt.to_timestamp()
        all_months = pd.date_range(start=monthly_data['month'].min(), end=monthly_data['month'].max(), freq='M')
        monthly_data = monthly_data.set_index('month').reindex(all_months, fill_value=0).reset_index()
        monthly_data['item_name'] = article
        monthly_data.set_index('index', inplace=True)
        scaler = MinMaxScaler(feature_range=(0, 1))
        monthly_data['quantity'] = scaler.fit_transform(monthly_data[['quantity']])
        look_back = len(monthly_data)
        X, y = create_dataset(monthly_data['quantity'], look_back)
        if X.size == 0 or y.size == 0:
            continue
        X = np.reshape(X, (X.shape[0], X.shape[1], 1))
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
        model = Sequential()
        model.add(LSTM(100, return_sequences=True, input_shape=(look_back, 1)))
        model.add(Dropout(0.8))
        model.add(LSTM(100, return_sequences=False))
        model.add(Dropout(0.8))
        model.add(Dense(1))
        model.compile(loss='mean_squared_error', optimizer='adam')
        checkpoint_path = f'public/models/best_model_{article.replace(" ", "_")}.keras'
        checkpoint = ModelCheckpoint(checkpoint_path, monitor='val_loss', save_best_only=True, mode='min')
        history = model.fit(X_train, y_train, epochs=200, batch_size=1, verbose=2, validation_data=(X_test, y_test), callbacks=[checkpoint])
        model.save(checkpoint_path)
    return jsonify({"status": "Model updated successfully."})

if __name__ == '__main__':
    app.run(debug=False)
