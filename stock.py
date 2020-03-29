from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ 
from sqlalchemy import Column, Integer, DateTime
from datetime import datetime

import requests
import datetime

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3308/stock'
# environ.get('dbURL')

app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

CORS(app)

class Stock(db.Model):
    __tablename__ = 'stock'

    stockid = db.Column(db.Integer, primary_key = True)
    stockname = db.Column(db.String(128), nullable = False)
    spoofname = db.Column(db.String(128), nullable = False)
    
    def __init__(self, stockid, stockname, spoofname):
        self.stockid = stockid
        self.stockname = stockname
        self.spoofname = spoofname

    def json(self):
        return jsonify({"stockid": self.stockid, 
                "stockname": self.stockname, 
                "spoofname": self.spoofname,  
                })   , 201


#get all stocks
@app.route("/stock")
def get_all():
    return jsonify({"stock":[Stock.json() for Stock in Stock.query.all()]})

#return a stock api
@app.route("/stock/api/<string:spoofname>")
def get_stock_api(spoofname): 
    stock = Stock.query.filter_by(spoofname = spoofname).first()
    if stock:
        API_URL = "https://www.alphavantage.co/query"

        data = {
            "function": "TIME_SERIES_INTRADAY", #Gets stock data at 5 min intervals
            "symbol": stock.stockname,
            "interval": "5min",
            "apikey": "2BAMKY2DJ4ZKBEK2",
            }
        response = requests.get(API_URL, data)
        return response.json()
    return jsonify({"message":"Stock not found"}), 404

#return a stock
@app.route("/stock/<string:spoofname>")
def get_stock(spoofname):
    content = request.get_json()
    spoofname = content["spoofname"]
    stock = Stock.query.filter_by(spoofname = spoofname).first()
    return jsonify({"stockid": stock.stockid})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5010, debug=True)