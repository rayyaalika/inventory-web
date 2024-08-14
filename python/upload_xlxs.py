# import pandas as pd
# import mysql.connector
# from mysql.connector import Error

# # Baca file Excel
# file_path = 'C:/Users/User/Downloads/item_1tahun.xlsx'
# df = pd.read_excel(file_path)

# # Buat koneksi ke database MySQL
# try:
#     connection = mysql.connector.connect(
#         host='localhost',  # Ubah jika host MySQL Anda berbeda
#         user='root',       # Ubah jika user MySQL Anda berbeda
#         password='',  # Ganti dengan password MySQL Anda
#         database='db_inventory_web'
#     )

#     if connection.is_connected():
#         cursor = connection.cursor()
#         cursor.execute("SELECT DATABASE();")
#         record = cursor.fetchone()
#         print("Connected to database: ", record)

#         # Membuat tabel baru, misalnya 'bakery_sales'
#         cursor.execute("""
#         CREATE TABLE IF NOT EXISTS bakery_sale (
#             id INT AUTO_INCREMENT PRIMARY KEY,
#             id_bakery INT,
#             date DATE,
#             item_name VARCHAR(255),
#             quantity INT
#         )
#         """)

#         # Menghapus data jika ingin mengisi ulang tabel
#         cursor.execute("DELETE FROM bakery_sale")

#         # Masukkan data ke tabel
#         for i, row in df.iterrows():
#             cursor.execute("""
#             INSERT INTO bakery_sale (id_bakery, date, item_name, quantity) 
#             VALUES (%s, %s, %s, %s)
#             """, tuple(row))

#         connection.commit()
#         print("Data berhasil dimasukkan ke dalam tabel bakery_sale")

# except Error as e:
#     print("Error saat menghubungkan ke MySQL", e)
# finally:
#     if (connection.is_connected()):
#         cursor.close()
#         connection.close()
#         print("Koneksi MySQL ditutup")

import pandas as pd
import mysql.connector
from mysql.connector import Error

# Baca file Excel
file_path = 'D:/inventory-web/item_7hari.xlsx'
df = pd.read_excel(file_path)

# Konversi kolom 'date' ke format datetime jika belum
df['date'] = pd.to_datetime(df['date'])

# Konversi kolom 'date' ke string dengan format 'YYYY-MM-DD'
df['date'] = df['date'].dt.strftime('%Y-%m-%d')

# Buat koneksi ke database MySQL
try:
    connection = mysql.connector.connect(
        host='localhost',  # Ubah jika host MySQL Anda berbeda
        user='root',       # Ubah jika user MySQL Anda berbeda
        password='',  # Ganti dengan password MySQL Anda
        database='db_inventory_web'
    )

    if connection.is_connected():
        cursor = connection.cursor()
        cursor.execute("SELECT DATABASE();")
        record = cursor.fetchone()
        print("Connected to database: ", record)

        # Masukkan data ke tabel
        for i, row in df.iterrows():
            cursor.execute("""
            INSERT INTO bakery_sale (id_bakery, date, item_name, quantity) 
            VALUES (%s, %s, %s, %s)
            """, tuple(row))

        connection.commit()
        print("Data berhasil dimasukkan ke dalam tabel bakery_sale")

except Error as e:
    print("Error saat menghubungkan ke MySQL", e)
finally:
    if connection.is_connected():
        cursor.close()
        connection.close()
        print("Koneksi MySQL ditutup")
