from flask import Flask, request, render_template, jsonify
import pandas as pd
import numpy as np
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import LSTM, Dense, Dropout
from sklearn.preprocessing import MinMaxScaler
from sklearn.model_selection import train_test_split
import mysql.connector

app = Flask(__name__)

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

# Function to preprocess data
def preprocess_data(df, article_input):
    # Cleaning data
    df['date'] = pd.to_datetime(df['date'])
    df = df.loc[df['quantity'] >= 0]

    # Filter data for selected article
    article_data = df[df['item_name'] == article_input]

    if article_data.empty:
        return None, None
    else:
        # Aggregate monthly sales
        article_data['month'] = article_data['date'].dt.to_period('M')
        monthly_data = article_data.groupby(['item_name', 'month']).agg({'quantity': 'sum'}).reset_index()
        monthly_data['month'] = monthly_data['month'].dt.to_timestamp()
        monthly_data.set_index('month', inplace=True)

        # Normalize data
        scaler = MinMaxScaler(feature_range=(0, 1))
        monthly_data['quantity'] = scaler.fit_transform(monthly_data[['quantity']])

        return monthly_data, scaler

# Function to create LSTM dataset
def create_dataset(data, look_back=1):
    dataX, dataY = [], []
    for i in range(len(data) - look_back):
        dataX.append(data.iloc[i:(i + look_back)].values)
        dataY.append(data.iloc[i + look_back])
    return np.array(dataX), np.array(dataY)

# Route for input and prediction
@app.route('/superadmin', methods=['POST'])
def predict():
    if request.method == 'POST':
        data = request.get_json()
        article_input = data.get('article')        

        # Load data from database
        df = load_data_from_db()
        
        # Preprocess data
        data, scaler = preprocess_data(df, article_input)
        
        if data is None:
            return jsonify({'error_message': f"Tidak ada data untuk artikel '{article_input}'."})
        
        # LSTM model code (same as your existing code)
        look_back = 12
        X, y = create_dataset(data['quantity'], look_back)
        X = np.reshape(X, (X.shape[0], X.shape[1], 1))
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

        model = Sequential()
        model.add(LSTM(200, return_sequences=True, input_shape=(look_back, 1)))
        model.add(Dropout(0.8))
        model.add(LSTM(200, return_sequences=False))
        model.add(Dropout(0.8))
        model.add(Dense(1))
        model.compile(loss='mean_squared_error', optimizer='adam')

        history = model.fit(X_train, y_train, epochs=200, batch_size=1, verbose=2, validation_data=(X_test, y_test))

        # Predict future sales (same as your existing code)
        future_input = data['quantity'][-look_back:].values.reshape((1, look_back, 1))
        future_predictions = []
        
        for i in range(12):
            next_prediction = model.predict(future_input)
            future_predictions.append(next_prediction)
            future_input = np.append(future_input[:, 1:, :], next_prediction.reshape((1, 1, 1)), axis=1)

        future_predictions = np.array(future_predictions).reshape(12, 1)
        future_predictions = scaler.inverse_transform(future_predictions)

        predicted_dates = pd.date_range(start=data.index.max(), periods=12, freq='M')

        return jsonify({
            'predictions': future_predictions.tolist(),
            'dates': predicted_dates.strftime('%Y-%m-%d').tolist()
        })

    # If request method is not POST
    return jsonify({'error_message': 'Metode request tidak diizinkan.'})

if __name__ == '__main__':
    app.run(debug=False)