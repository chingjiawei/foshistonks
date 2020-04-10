from flask import Flask, request, jsonify
from flask_cors import CORS
from os import environ 

import requests
import json

app = Flask(__name__)
CORS(app)

@app.route("/login/<string:username>", methods=['POST'])
def login(username):
    # password = request.json.get('password')
    data = request.get_json()
    password = data["password"]
<<<<<<< Updated upstream
    res = requests.get('http://172.17.0.3:5000/account/' + username)
=======
    res = requests.get('http://account:5000/account/' + username)
>>>>>>> Stashed changes
    res_users = res.json()
    try:
        if res_users["password"] != password:
            return jsonify({"message":"Incorrect Password"}), 401
    except KeyError:
        return jsonify({"message":"User not found"}), 401
    return jsonify({"message":"Login Successful!"}), 201


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5013, debug=True)