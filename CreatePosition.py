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

@app.route("/createposition/<string:username>", methods=['POST'])
def create_user_position(username):
    spoofname = request.json.get('spoofname')
    res = requests.get('http://localhost:5010/stock/' + spoofname, json={"spoofname": spoofname})
    res_getstock =  res.json()
    stockid = res_getstock["stockid"]
    price = request.json.get('price')
    purchasetype = request.json.get('purchasetype')
    amount = request.json.get('amount')
    content = {
                "stockid": stockid,
                "price": price,
                "purchasetype": purchasetype,
                "amount": amount
             }
    res = requests.post('http://localhost:5011/position/create/' + username, json=content)
    res_createpos = res.json()
    req = {
            "stonks": res_createpos["stonks"]
        }
    res_updatestonk = requests.post('http://localhost:5000/account/update/stonks/' + username, json=req)
    if res_createpos and purchasetype == "sell":
        req = {
            "time_stamp": res_createpos["time_stamp"],
            "stockid": stockid,
            "amount": amount
        }
        res_updatepos = requests.post('http://localhost:5011/position/create/' + username, json=content)
    send_position(res_createpos)
    return jsonify({"message":"Created Position Successfully!"}), 201

def send_position(position):
    hostname = "localhost"
    port = 5672
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()
    exchangename = "noti_direct"
    channel.exchange_declare(exchange = exchangename, exchange_type = "direct")
    message = json.dumps(position, default=str)
    channel.basic_publish(exchange = exchangename, routing_key = "handle.noti", body = message)
    channel.queue_declare(queue ='notiHandling', durable = True) # make sure the queue used by Shipping exist and durable
    channel.queue_bind(exchange = exchangename, queue='notiHandling', routing_key='handle.noti') # make sure the queue is bound to the exchange
    channel.basic_publish(exchange = exchangename, routing_key="handle.noti", body = message,
        properties=pika.BasicProperties(delivery_mode = 2, # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange, which are ensured by the previous two api calls)
        )
    )
    print("Position sent to notification.")
    connection.close()    

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5012, debug=True)