import os
import mysql.connector as database

connection = database.connect(
    user= 'ibarr',
    password='Password',
    host = 'localhost',
    database="betting")

