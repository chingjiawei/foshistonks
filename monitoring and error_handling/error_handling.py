##!/usr/bin/env python3
# The above shebang (#!) operator tells Unix-like environments
# to run this file as a python3 script

import json
import sys
import os

# Communication patterns:
# Use a message-broker with 'direct' exchange to enable interaction
import pika


def receiveError():
    hostname = "localhost" # default broker hostname
    port = 5672 # default port
    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="error_direct"
    channel.exchange_declare(exchange=exchangename, exchange_type='direct')

    # prepare a queue for receiving messages
    channelqueue = channel.queue_declare(queue="errorhandler", durable=True) # 'durable' makes the queue survive broker restarts
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchangename, queue=queue_name, routing_key='handle.error') # bind the queue to the exchange via the key

    # set up a consumer and start to wait for coming messages
    channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
    channel.start_consuming() # an implicit loop waiting to receive messages; it doesn't exit by default. Use Ctrl+C in the command window to terminate it.

def callback(channel, method, properties, body): # required signature for the callback; no return
    print("Received an error by " + __file__)
    processError(json.loads(body))
    print() # print a new line feed

def processError(request):
    errorMessage = {"creatingStocks":{"There is an error in creating position, please try again later!"},
                    "sellingStocks":{"There is an error in selling position, please try again later!"},
                    "buyingStuff":{"There is an error buying stuff, please try again later!"},
                    "sendingNoti":{"There is an error sending notification, please try again later"}}
    print("Processing an error:")
    print(errorMessage[request["errorFrom"]])
    


if __name__ == "__main__":  # execute this program only if it is run as a script (not by 'import')
    print("This is " + os.path.basename(__file__) + ": processing an order error...")
    receiveError()
