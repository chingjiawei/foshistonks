from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ
from sqlalchemy import Column, Integer, DateTime
from datetime import datetime

import requests
import datetime

app = Flask(__name__)
# app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')#'mysql+mysqlconnector://root@localhost:3306/position'
# environ.get('dbURL')
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/position'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

CORS(app)


class Position(db.Model):
    __tablename__ = 'position'

    time_stamp = db.Column(db.DateTime, primary_key=True)
    stockid = db.Column(db.Integer, nullable=False)
    stockName = db.Column(db.String(20), nullable=False)
    username = db.Column(db.String(16), primary_key=True)
    price = db.Column(db.Float, nullable=False)
    purchasetype = db.Column(db.String(10), nullable=False)
    amount = db.Column(db.Integer, nullable=False)

    def __init__(self, time_stamp, stockid, stockName, username, price, purchasetype, amount):
        self.time_stamp = time_stamp
        self.stockid = stockid
        self.stockName = stockName
        self.username = username
        self.price = price
        self.purchasetype = purchasetype
        self.amount = amount

    def json(self):
        return {"time_stamp": self.time_stamp,
                "stockid": self.stockid,
                "stockName": self.stockName,
                "username": self.username,
                "price": self.price,
                "purchasetype": self.purchasetype,
                "amount": self.amount
                }


@app.route("/position")
def get_all():
    return jsonify({"position": [Position.json() for Position in Position.query.all()]})


@app.route("/position/<string:username>")
def get_user(username):
    return jsonify({"stock": [Position.json() for Position in Position.query.filter(username == username)]})


@app.route("/position/create/<string:username>", methods=["POST"])
def create_position(username):
    content = request.get_json()
    time_stamp = datetime.datetime.now()
    stockid = content["stockid"]
    stockName = content["stockName"]
    price = content["price"]
    purchasetype = content['purchasetype']
    amount = content['amount']
    if time_stamp and stockid and username and price and purchasetype and amount:
        existing_position = Position.query.filter(
            Position.stockid == stockid and Position.username == username).first()
        if existing_position != None and existing_position.purchasetype == purchasetype and purchasetype == 'sell':
            return jsonify({"message": "Stock has not been bought yet - unable to sell"}), 404

        new_position = Position(time_stamp=time_stamp,
                                stockid=stockid,
                                stockName=stockName,
                                username=username,
                                price=price,
                                purchasetype=purchasetype,
                                amount=amount)
        try:
            db.session.add(new_position)
            db.session.commit()
            amt = float(price) * int(amount)
            if purchasetype == "buy":
                amt = -amt
        except:
            return jsonify({"message": "An error occurred creating the position."}), 500

        return jsonify({"stonks": amt}), 201

    return jsonify({"message": "Fields incomplete!"}), 404


@app.route("/position/updateSold/<string:username>", methods=["POST"])
def updateSold_position(username):
    content = request.get_json()
    time_stamp = datetime.datetime.now()
    stockid = content["stockid"]
    stockName = content["stockName"]
    price = content["price"]
    purchasetype = content['purchasetype']
    amount = content['amount']
    if time_stamp and stockid and username and price and purchasetype and amount:
        existing_position = Position.query.filter(Position.stockName == stockName and Position.purchasetype == "buy" and Position.stockid == stockid and Position.username == username).first()
        if existing_position != None and existing_position.purchasetype == purchasetype and purchasetype == 'sell':
            return jsonify({"message": "Stock has not been bought yet - unable to sell"}), 404
        
        existing_position.purchasetype = "sold"
        try:
            # db.session.add(new_position)
            db.session.commit()
            amt = float(price) * int(amount)
            if purchasetype == "buy":
                amt = -amt
        except:
            return jsonify({"message": "An error occurred creating the position."}), 500

        return jsonify({"stonks": amt}), 201

    return jsonify({"message": "Fields incomplete!"}), 404


@app.route("/position/update/<string:username>", methods=["POST"])
def update_position(username):
    content = request.get_json()
    time_stamp = content["time_stamp"]
    stockid = content["stockid"]
    amount = content["amount"]
    # time_stamp = datetime.datetime.now().timestamp()
    # spoofname = request.json.get('spoofname')
    # stock = Stock.query.filter_by(spoofname = spoofname).first()
    # stockid = stock.stockid
    # price = request.json.get('price')
    # purchasetype = request.json.get('purchasetype')
    # amount = request.json.get('amount')
    position = Position.query.filter_by(
        time_stamp == time_stamp and stockid == stockid and username == username).first()
    try:
        position.amount = position.amount - amount
        db.session.commit()

    except:
        return jsonify({"message": "An error occurred updating the position information."}), 500

    return jsonify({"message": "Updated Successfully!"}), 201


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5011, debug=True)
