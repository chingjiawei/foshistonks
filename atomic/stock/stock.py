from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ 
from sqlalchemy import Column, Integer, DateTime
from datetime import datetime

import requests
import datetime
import json
from flask.json import dump
from json import dumps

app = Flask(__name__)
#app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')#'mysql+mysqlconnector://root@localhost:3306/stock'
# environ.get('dbURL')
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
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
        return {"stockid": self.stockid, 
                "stockname": self.stockname, 
                "spoofname": self.spoofname,  
                }


#get all stocks
@app.route("/stock")
def get_all():
    #data = {"stock":[Stock.json() for Stock in Stock.query.all()]}
    #response = json.dumps(data)
    #response.status_code = 200 # or 400 or whatever
    #result = {"stock":[Stock.json() for Stock in Stock.query.all()]}
    #return response
    #data = [Stock.json() for Stock in Stock.query.all()]
    # data = {"stock":[{"stockid":"1","stockName":"A","spoofname":"DKBank Inc"},{"stockid":"2","stockName":"AA","spoofname":"ThisKong Pte Ltd"},{"stockid":"3","stockName":"DAL","spoofname":"Yeet and Yeehaw Advisor"}]}
    return jsonify({"stock":[Stock.json() for Stock in Stock.query.all()]})
    # return jsonify(data)

#return a stock api
@app.route("/stock/api/<string:spoofname>")
def get_stock_api(spoofname): 
    stock = Stock.query.filter_by(spoofname = spoofname).first()
    if stock:
        API_URL = "https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=" + stock.stockname + "&interval=1min&apikey=6X8I6CEA4ESMED9G"

        # data = {
        #     "function": "TIME_SERIES_INTRADAY", #Gets stock data at 5 min intervals
        #     "symbol": stock.stockname,
        #     "interval": "1min",
        #     "apikey": "6X8I6CEA4ESMED9G",
        #     }
        response = requests.get(API_URL, verify=False) #, data
        response_data =  response.json() 
        formattedData = {}
        for i in response_data["Time Series (1min)"]:
            formattedData.update({i:response_data["Time Series (1min)"][i]["4. close"]})
        # return json.dumps(listOfDate)
        return json.dumps(formattedData)
        #return response.json()
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