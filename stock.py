from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ 

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
        return {"stockid": self.stockid, 
                "stockname": self.stockname, 
                "spoofname": self.spoofname,  
                }   

class Position(db.Model):
    __tablename__ = 'position'

    timestamp = db.Column(db.timestamp, primary_key = True)
    stockid = db.Column(db.Integer, nullable = False)
    userid = db.Column(db.String(16), nullable = False)
    price = db.Column(db.Float, nullable = False)
    purchasetype = db.Column(db.String(10), nullable = False)
    amount = db.Column(db.Integer, nullable = False)

    
    def __init__(self, timestamp, stockid, userid, price, purchasetype, amount):
        self.timestamp = timestamp
        self.stockid = stockid
        self.userid = userid
        self.price = price
        self.purchasetype = purchasetype
        self.amount = amount

    def json(self):
        return {"timestamp": self.timestamp, 
                "stockid": self.stockid, 
                "userid": self.userid,  
                "price": self.price,
                "purchasetype": self.purchasetype,
                "amount": self.amount
                }   

#get all stocks
@app.route("/stock")
def get_all():
    return jsonify({"stock":[Stock.json() for Stock in Stock.query.all()]})

#return a stock
@app.route("/stock/<string:spoofname>")
def get_stocks(spoofname): 
    stock = Stock.query.filter_by(spoofname = spoofname).first()
    if stock:
        API_URL = "https://www.alphavantage.co/query"

        data = {
            "function": "TIME_SERIES_INTRADAY",
            "symbol": stock.stockname,
            "interval": "5min",
            "apikey": "2BAMKY2DJ4ZKBEK2",
            }
        response = requests.get(API_URL, data)
        return response.json()
    return jsonify({"message":"Stock not found"}), 404

#Add a Position
@app.route("position/create/<string:userid>", methods =['POST'])
def create_position(userid):
    time_stamp = request.json.get('timestamp')
    spoofname = request.json.get('spoofname')
    stock = Stock.query.filter_by(spoofname = spoofname).first()
    stockid = stock.stockid
    price = request.json.get('price')
    purchasetype = request.json.get('purchasetype')
    amount = request.json.get('amount')

    if time_stamp and stockid and userid and price and purchasetype and amount:
        existing_position = Position.query.filter(Position.stockid == stockid and Position.userid == userid).first()
        if existing_position.purchasetype == purchasetype and purchasetype == 'sell':
            return jsonify({"message": "Stock has not been bought yet - unable to sell"}), 404

        new_position = Position(timestamp = time_stamp,
                         stockid = stockid, 
                         userid = userid, 
                         price = price,
                         purchasetype = purchasetype,
                         amount = amount)

        try:
            db.session.add(new_position)
            db.session.commit()
            amt = round(price * amount, 2)
            if purchasetype == "buy":
                amt = -amt
            else:
                this.update_position(time_stamp, stockid, userid)
            query = {"stonks" : amt}
            requests.post("/account/update/stonks/" + userid, query)
        except:
            return jsonify({"message":"An error occurred creating the position."}), 500

        return jsonify(new_position.json()), 201

    return jsonify({"message": "Fields incomplete!"}), 404

#Update the position of the stock - if you want to sell some
@app.route("position/update/<string:userid>", methods =['POST'])
def update_position(time_stamp, stockid, userid):
    # time_stamp = datetime.datetime.now().timestamp()
    # spoofname = request.json.get('spoofname')
    # stock = Stock.query.filter_by(spoofname = spoofname).first()
    # stockid = stock.stockid
    # price = request.json.get('price')
    # purchasetype = request.json.get('purchasetype')
    # amount = request.json.get('amount')
    position = Position.query.filter_by(time_stamp == time_stamp and stockid == stockid and userid == userid).first()
    try:
        position.amount = position.amount - amount
        db.session.commit()

    except:
         return jsonify({"message":"An error occurred updating the position information."}), 500

    return jsonify({"message":"Updated Successfully!"}), 201






if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)