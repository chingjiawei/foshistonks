from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ 
from sqlalchemy import Column, Integer, DateTime
from datetime import datetime

import requests
import datetime
import pika
import json

app = Flask(__name__)

@app.route("/login/<string:username>", methods=['POST'])
def login(username):
    password = request.json.get('password')
    res = requests.get('http://localhost:5000/account/' + username, json={"password": password})
    res_users = res.json()
    try:
        if res_users["password"] != password:
            return jsonify({"message":"Incorrect Password"}), 404
    except KeyError:
        return jsonify({"message":"User not found"}), 404
    return jsonify({"message":"Login Successful!"}), 201


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5013, debug=True)