
#!/usr/bin/env python3
# The above shebang (#!) operator tells Unix-like environments
# to run this file as a python3 script

import json
import sys
import os
import random
import datetime
import pika 
import uuid
import csv


# Communication patterns:
# Use HTTP calls to enable interaction with shipping
# Use language-level function calls to enable interaction with monitoring and error_handling
import requests
notiURL = "http://127.0.0.1:5001/noti/create"

class CreateProject:
    # Load existing orders from a JSON file (for simplificity here). In reality, orders will be stored in DB. 
    with open('projectDetails.json') as noti_json_file:
        noti = json.load(noti_json_file)
    noti_json_file.close()

    # Find the max of all existing "order_id" to be used as the last order_id; if in actual DB, the uniqueness of "order_id" will be managed by DBMS
    last_noti_id = max([ o["notification_id"] for o in noti["noti"] ])

# def orders_json():
#     """return all orders as a JSON object (not a string)"""
#     return Order.orders
    
# def orders_save(orders_file):
#     """ save all orders to a file"""
#     with open(orders_file, 'w') as order_json_outfile:
#         json.dump(Order.orders, order_json_outfile, indent=2, default=str) # convert a JSON object to a string
#     order_json_outfile.close()

# class Order_Item:
#     def __init__(self):
#         self.item_id = 0
#         self.book_id = "0123456789abc"
#         self.quantity = 0
#         self.order_id = 0

#     # return an order item as a JSON object
#     def json(self):
#         return {'item_id': self.item_id, 'book_id': self.book_id, 'quantity': self.quantity, 'order_id': self.order_id}

# def get_all():
#     """Return all orders as a JSON object"""
#     return Order.orders
 
# def find_by_order_id(order_id):
#     """Return an order (orders) of the order_id"""
#     order = [ o for o in Order.orders["orders"] if o["order_id"]==order_id ]
#     if len(order)==1:
#         return order[0]
#     elif len(order)>1:
#         return {'message': 'Multiple orders found for id ' + str(order_id), 'orders': order}
#     else:
#         return {'message': 'Order not found for id ' + str(order_id)}
 
def create_noti():
    # assume status==200 indicates success
    status = 200
    message = "Success"

    # Load the order info from a cart (from a file in this case; can use DB too, or receive from HTTP requests)
    # try:
    #     with open(noti_input) as sample_noti_file:
    #         cart_order = json.load(sample_noti_file)
    # except:
    #     status = 501
    #     message = "An error occurred in loading the noti file."
    # finally:
    #     sample_order_file.close()
    # if status!=200:
    #     print("Failed noti creation.")
    #     return {'status': status, 'message': message}

    # Create a new order: set up data fields in the order as a JSON object (i.e., a python dictionary)
    noti = dict()
    noti["message"] = "This is a notification to say that your project creation is succesful! Thank you!"
    noti["notification_id"] = "1"
    noti["phone_number"] = "96139139"
    noti["project_id"] = "12345"
    noti["timestamp"] = datetime.datetime.now()
    noti["user_id"] = "571630186"
    
       
    notiJson = ({"message":noti["message"] ,
                         "notification_id": noti["notification_id"],
                         "phone_number": noti["phone_number"] ,
                         "project_id": noti["project_id"],
                         "timestamp": noti["timestamp"],
                         "user_id": noti["user_id"]
        })
    # check if order creation is successful
    if len(notiJson) <1:
        status = 404
        message = "Empty noti."
    # Simulate other errors in order creation via a random bit
    # result = bool(random.getrandbits(1))
    # if not result:
    #     status = 500
    #     message = "A simulated error occurred when creating the noti."

    if status!=200:
        print("Failed noti creation.")
        return {'status': status, 'message': message}

    # Append the newly created order to the existing orders
    #Order.orders["orders"].append(order)
    # Increment the last_order_id; if using a DB, DBMS can manage this
    #Order.last_order_id = Order.last_order_id + 1
    # Write the newly created order back to the file for permanent storage; if using a DB, this will be done by the DBMS
    #orders_save("orders.new.json")

    # Return the newly created order when creation is succssful
    if status==200:
        print("OK order creation.")
        return notiJson

def send_noti(noti):
    #"""inform Shipping/Monitoring/Error as needed"""
    # default username / password to the borker are both 'guest'
    hostname = "localhost" # default broker hostname. Web management interface default at http://localhost:15672
    port = 5672 # default messaging port.
    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
        # Note: various network firewalls, filters, gateways (e.g., SMU VPN on wifi), may hinder the connections;
        # If "pika.exceptions.AMQPConnectionError" happens, may try again after disconnecting the wifi and/or disabling firewalls
    channel = connection.channel()

    # set up the exchange if the exchange doesn't exist
    exchangename="noti_direct"
    channel.exchange_declare(exchange=exchangename, exchange_type='direct')

    # prepare the message body content
    message = json.dumps(noti, default=str) # convert a JSON object to a string

    # send the message
    # always inform Monitoring for logging no matter if successful or not
    channel.basic_publish(exchange=exchangename, routing_key="handle.noti", body=message)
        # By default, the message is "transient" within the broker;
        #  i.e., if the monitoring is offline or the broker cannot match the routing key for the message, the message is lost.
        # If need durability of a message, need to declare the queue in the sender (see sample code below).

    # if "status" in noti: # if some error happened in order creation
    #     # inform Error handler
    #     channel.queue_declare(queue='errorhandler', durable=True) # make sure the queue used by the error handler exist and durable
    #     channel.queue_bind(exchange=exchangename, queue='errorhandler', routing_key='shipping.error') # make sure the queue is bound to the exchange
    #     channel.basic_publish(exchange=exchangename, routing_key="shipping.error", body=message,
    #         properties=pika.BasicProperties(delivery_mode = 2) # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange)
    #     )
    #     print("Order status ({:d}) sent to error handler.".format(order["status"]))
    # else: # inform Shipping and exit, leaving it to order_reply to handle replies
    #     # Prepare the correlation id and reply_to queue and do some record keeping
    #     corrid = str(uuid.uuid4())
    #     row = {"order_id": order["order_id"], "correlation_id": corrid}
    #     csvheaders = ["order_id", "correlation_id", "status"]
    #     with open("corrids.csv", "a+", newline='') as corrid_file: # 'with' statement in python auto-closes the file when the block of code finishes, even if some exception happens in the middle
    #         csvwriter = csv.DictWriter(corrid_file, csvheaders)
    #         csvwriter.writerow(row)
    #     replyqueuename = "shipping.reply"
    #     # prepare the channel and send a message to Shipping
    #     channel.queue_declare(queue='shipping', durable=True) # make sure the queue used by Shipping exist and durable
    #     channel.queue_bind(exchange=exchangename, queue='shipping', routing_key='shipping.order') # make sure the queue is bound to the exchange
    #     channel.basic_publish(exchange=exchangename, routing_key="shipping.order", body=message,
    #         properties=pika.BasicProperties(delivery_mode = 2, # make message persistent within the matching queues until it is received by some receiver (the matching queues have to exist and be durable and bound to the exchange, which are ensured by the previous two api calls)
    #             reply_to=replyqueuename, # set the reply queue which will be used as the routing key for reply messages
    #             correlation_id=corrid # set the correlation id for easier matching of replies
    #         )
    #     )
    #     print("Order sent to shipping.")
    print("noti sent")
    # close the connection to the broker
    connection.close()

# Execute this program if it is run as a main script (not by 'import')
if __name__ == "__main__":
    print("This is " + os.path.basename(__file__) + ": creating an Noti...")
    noti = create_noti()
    send_noti(noti)
#    print(get_all())
#    print(find_by_order_id(3))
