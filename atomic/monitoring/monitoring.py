#!/usr/bin/env python3
# The above shebang (#!) operator tells Unix-like environments
# to run this file as a python3 script
import json
import sys
import os
from flask import Flask, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ

from datetime import datetime
import json
import pika
import requests
import os
# Communication patterns:
# Use a message-broker with 'direct' exchange to enable interaction
#import pika

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class MonitoringLog(db.Model):
    __tablename__ = 'monitoring'
 
    log_id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.String(20), nullable=False)
    log_content = db.Column(db.String(500), nullable=False)
    log_from = db.Column(db.String(128), nullable=False)
    timestamp = db.Column(db.DateTime, nullable=False, default=datetime.now)
    
    def __init__(self, log_id, user_id,log_content,log_from,timestamp):
        self.log_id = log_id
        self.user_id = user_id
        self.log_content = log_content
        self.log_from = log_from
        self.timestamp = timestamp 


    # def json(self):
    #     return{'notification_id': self.notification_id,'project_id': self.project_id,'user_id': self.user_id,'message': self.message,'phone_number': self.phone_number,'timestamp': self.timestamp}
# db.create_all() 

def receiveLog():
    hostname = "172.18.0.15" # default host
    port = 5672 # default port
    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="monitoring_direct"
    channel.exchange_declare(exchange=exchangename, exchange_type='direct')

    # prepare a queue for receiving messages
    channelqueue = channel.queue_declare(queue='', exclusive=True) # '' indicates a random unique queue name; 'exclusive' indicates the queue is used only by this receiver and will be deleted if the receiver disconnects.
        # If no need durability of the messages, no need durable queues, and can use such temp random queues.
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchangename, queue=queue_name, routing_key='handle.monitoring') # bind the queue to the exchange via the key
        # Can bind the same queue to the same exchange via different keys

    # set up a consumer and start to wait for coming messages
    channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
    channel.start_consuming() # an implicit loop waiting to receive messages; it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def callback(channel, method, properties, body): # required signature for the callback; no return
    print("Received an log by " + __file__)
    processLog(json.loads(body))
    print() # print a new line feed

def processLog(log):
    print("Recording an incoming log:")
    print("Storing Log to DB:")
    #Inserting record one by one
    monitoringLog = MonitoringLog(None, log["user_id"], log["log_content"], log["log_from"],log["timestamp"]) 
    db.session.add(monitoringLog) 
    db.session.commit()
    print("Data stored in DB successfully")
    print("this is a log from " + log["log_from"])
    print(log)

@app.teardown_appcontext
def shutdown_session(exception=None):
    db.session.remove()
if __name__ == "__main__":  # execute this program only if it is run as a script (not by 'import')
    print("This is " + os.path.basename(__file__) + ": monitoring everything...")
    receiveLog()
