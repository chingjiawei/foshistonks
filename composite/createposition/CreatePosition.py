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
CORS(app)


@app.route("/createposition/<string:username>", methods=['POST'])
def create_user_position(username):
    spoofname = request.json.get('spoofname')
    res = requests.get('http://stock:5010/stock/' + spoofname, json={"spoofname": spoofname})
    res_getstock = res.json()
    stockid = res_getstock["stockid"]
    price = request.json.get('price')
    purchasetype = request.json.get('purchasetype')
    amount = request.json.get('amount')
    content = {
        "stockid": stockid,
        "price": price,
        "stockName": spoofname,
        "purchasetype": purchasetype,
        "amount": amount
    }
    res = requests.post('http://position:5011/position/create/' + username, json=content)
    res_createpos = res.json()
    req = {
        "stonks": res_createpos["stonks"]
    }
    res_updatestonk = requests.post(
        'http://account:5000/account/update/stonks/' + username, json=req)
    if res_createpos and purchasetype == "sell":
        req = {
            "time_stamp": datetime.datetime.now(),
            "stockid": stockid,
            "amount": amount
        }
        res_updatepos = requests.post(
            'http://position:5011/position/updateSold/' + username, json=content)
    create_noti(username)
    create_log(username)
    return jsonify({"message": "Created Position Successfully!"}), 201


def create_noti(username):
    req = requests.get('http://account:5000/account/' + username)
    res_accountInfo = req.json()
    # assume status==200 indicates success
    status = 200
    message = "Success"

    # Create a new order: set up data fields in the order as a JSON object (i.e., a python dictionary)
    noti = dict()
    noti["message"] = "This is a notification to say that your stock transaction is succesful! Thank you!"
    noti["notification_id"] = None
    noti["phone_number"] = res_accountInfo["phoneNumber"]
    noti["timestamp"] = datetime.datetime.now()
    noti["telegram_id"] = res_accountInfo["telegramID"]

    notiJson = ({"message": noti["message"],
                 "notification_id": noti["notification_id"],
                 "phone_number": noti["phone_number"],
                 "timestamp": noti["timestamp"],
                 "telegram_id": noti["telegram_id"]
                 })
    # check if order creation is successful
    if len(notiJson) < 1:
        status = 404
        message = "Empty noti."
    # Simulate other errors in order creation via a random bit
    # result = bool(random.getrandbits(1))
    # if not result:
    #     status = 500
    #     message = "A simulated error occurred when creating the noti."

    if status != 200:
        print("Failed noti creation.")
        return {'status': status, 'message': message}

    # Append the newly created order to the existing orders
    # Order.orders["orders"].append(order)
    # Increment the last_order_id; if using a DB, DBMS can manage this
    #Order.last_order_id = Order.last_order_id + 1
    # Write the newly created order back to the file for permanent storage; if using a DB, this will be done by the DBMS
    # orders_save("orders.new.json")

    # Return the newly created order when creation is succssful
    if status == 200:
        print("OK order creation.")
        send_position(notiJson)


def send_position(position):
    hostname = "rabbitmq"
    port = 5672
    connection = pika.BlockingConnection(
        pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()
    exchangename = "noti_direct"
    channel.exchange_declare(exchange=exchangename, exchange_type="direct")
    message = json.dumps(position, default=str)
    channel.basic_publish(exchange=exchangename,
                          routing_key="handle.noti", body=message)
    # make sure the queue used by Shipping exist and durable
    channel.queue_declare(queue='notiHandling', durable=True)
    # make sure the queue is bound to the exchange
    channel.queue_bind(exchange=exchangename,
                       queue='notiHandling', routing_key='handle.noti')
    channel.basic_publish(exchange=exchangename, routing_key="handle.noti", body=message,
                          properties=pika.BasicProperties(delivery_mode=2,  # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange, which are ensured by the previous two api calls)
                                                          )
                          )
    print("Position sent to notification.")
    connection.close()

############################################
##monitoring
def create_log(username):
    req = requests.get('http://account:5000/account/' + username)
    res_accountInfo = req.json()
    # assume status==200 indicates success
    status = 200
    message = "Success"    
    logFrom = "Create Stock Position"
    email = res_accountInfo["email"]
    telegramId = res_accountInfo["telegramID"]
    logContent = "Successful Creation of Stock Position"
       
    logJson = ({       "log_from": logFrom,
                         "timestamp": datetime.datetime.now(),
                         "user_id":telegramId,
                         "email": email,
                         "log_content": logContent
        })
    # check if order creation is successful
    if len(logJson) <1:
        status = 404
        message = "Empty log."
    # Simulate other errors in order creation via a random bit
    # result = bool(random.getrandbits(1))
    # if not result:
    #     status = 500
    #     message = "A simulated error occurred when creating the noti."

    if status!=200:
        print("Failed log creation.")
        return {'status': status, 'message': message}

    # Return the newly created order when creation is succssful
    if status==200:
        # print("OK log creation.")
        send_log(logJson)
        return logJson

def send_log(log):
    #"""inform Shipping/Monitoring/Error as needed"""
    # default username / password to the borker are both 'guest'
    hostname = "rabbitmq" # default broker hostname. Web management interface default at http://localhost:15672
    port = 5672 # default messaging port.
    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
        # Note: various network firewalls, filters, gateways (e.g., SMU VPN on wifi), may hinder the connections;
        # If "pika.exceptions.AMQPConnectionError" happens, may try again after disconnecting the wifi and/or disabling firewalls
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="monitoring_direct"
    channel.exchange_declare(exchange=exchangename, exchange_type='direct')

    # prepare the message body content
    message = json.dumps(log, default=str) # convert a JSON object to a string

    # send the message
    # always inform Monitoring for logging no matter if successful or not
    channel.basic_publish(exchange=exchangename, routing_key="handle.monitoring", body=message)
        # By default, the message is "transient" within the broker;
        #  i.e., if the monitoring is offline or the broker cannot match the routing key for the message, the message is lost.
        # If need durability of a message, need to declare the queue in the sender (see sample code below).
    print("log sent")
    # close the connection to the broker
    connection.close()

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5012, debug=True)
