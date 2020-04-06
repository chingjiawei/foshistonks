from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ

import requests

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

CORS(app)

# check if there is enough money in the account
@app.route('/checkBalance/<string:username>', methods=['GET'])
def check_account_balance(username):


    accountURL = f"http://172.17.0.3:5000/account/{username}"
    account_req = requests.get(accountURL)

    if (account_req.status_code == 200):
        account = account_req.json()

        stonks = float(account['stonks'])
        return jsonify(stonks)

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5101, debug=True)