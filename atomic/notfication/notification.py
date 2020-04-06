from flask import Flask, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

from datetime import datetime
import json
import pika
# import telegram
import requests
import os

#pip install python-telegram-bot

# This version of order.py uses a mysql DB via flask-sqlalchemy, instead of JSON files, as the data store.
#
# TODO: add appropriate flask routes to the respective functions in the file, so that
# - It allows HTTP GET or POST methods for retrieving all orders, one order, or creating a new order.
# TODO: modify the code as per the FIXME hints.

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/FoshiStonks'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class Notification(db.Model):
    __tablename__ = 'notifications'
 
    notification_id = db.Column(db.Integer, primary_key=True)
    project_id = db.Column(db.String(10), nullable=False)
    user_id = db.Column(db.String(10), nullable=False)
    message = db.Column(db.String(500), nullable=False)
    phone_number = db.Column(db.Integer, nullable=False)
    timestamp = db.Column(db.DateTime, nullable=False, default=datetime.now)
    
    def __init__(self, isbn13, title, price, availability):
        self.notification_id = notification_id
        self.project_id = project_id
        self.user_id = user_id
        self.message = message
        self.phone_number = phone_number
        self.timestamp = timestamp 


    def json(self):
        return{'notification_id': self.notification_id,'project_id': self.project_id,'user_id': self.user_id,'message': self.message,'phone_number': self.phone_number,'timestamp': self.timestamp}

#db.create_all() 

# @app.route("/noti/getAllNoti/", methods=['GET'])
# def get_all():
#     return {'noti': [noti.json() for noti in Notification.query.all()]}
 
# @app.route("/orders/<string:order_id>", methods=['GET'])
# def find_by_order_id(order_id):
#     order = Order.query.filter_by(order_id=order_id).first()
#     if order:
#         return order.json()
#     return {'message': 'Order not found for id ' + str(order_id)}, 404

# @app.route("/noti/create/", methods=['POST'])
   
def receiveNotiCreate():
    hostname = "localhost" # default broker hostname
    port = 5672 # default port
    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="noti_direct"
    channel.exchange_declare(exchange=exchangename, exchange_type='direct')

    # prepare a queue for receiving messages
    channelqueue = channel.queue_declare(queue="notiHandling", durable=True) # 'durable' makes the queue survive broker restarts
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchangename, queue=queue_name, routing_key='handle.noti') # bind the queue to the exchange via the key

    # set up a consumer and start to wait for coming messages
    channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
    channel.start_consuming() # an implicit loop waiting to receive messages; it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def callback(channel, method, properties, body): # required signature for the callback; no return
    print("Received an noti creation by " + __file__)
    print(send_noti(json.loads(body)))
    print() # print a new line feed

def send_noti(noti):
    # status in 2xx indicates success
    print("Proccessing...Sending noti now")
    status = 201
    result = {}
    chat_id = noti['user_id']
    message = noti['message']
    bot_token = '1058377172:AAHlRyWYvsyY0tOuYQIYdBKKZ-VmV3ptML4'
    url = 'https://api.telegram.org/bot'+bot_token+'/sendMessage?chat_id='+chat_id+'&text='+ message 
    # retrieve information about order and order items from the request
    # send(message,"571630186",my_token)
    
    return requests.post(url).json()

if __name__ == '__main__':
    #app.run(host="127.0.0.1", port=5001, debug=True)
    print("This is " + os.path.basename(__file__) + ": processing an noti creation...")
    receiveNotiCreate()
