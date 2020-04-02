from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

import requests

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

CORS(app)

# input (username, accessoryID, shopID, currentStonks, price)

# process (check availability and balance, add item to inventory, deduct stonks from account, reduce inStock in shop)

# output (message: successful / error), 200/500

@app.route("/purchaseAccessories/<int:accessoryID>", methods =['POST'])
def purchase_accessory (accessoryID):
    
    # load json body
    purchaseData = request.get_json()
    for key, value in purchaseData.items():
        if key not in ['username', 'shopID', 'currentStonks', 'price', 'inStock'] or value == None:
            return jsonify({'message': 'Please input a valid JSON'}), 400

    username = purchaseData['username']
    shopID = purchaseData['shopID']
    currentStonks = purchaseData['currentStonks']
    price = purchaseData['price']
    inStock = purchaseData['inStock']

    # generate URLs
    accessoryURL = f'http://localhost:5001/accessory/{accessoryID}'

    shopURL = f'http://localhost:5003/shop/{shopID}'

    accountStonkURL = f'http://localhost:5000/account/{username}'

    inventoryURL = f'http://localhost:5002/inventory/{username}'


    # deduct stonks from account
    updated_stonks = float(currentStonks) - float(price)

    res_accountStonk = requests.put(accountStonkURL, json = {"stonks": updated_stonks})

    if not (res_accountStonk.status_code == 200):
        return jsonify(res_accountStonk.json()), res_accountStonk.status_code

    #add accessory into inventory (accessoryID, quantity = 1)
    res_inventory = requests.put(inventoryURL, json = {"accessoryID": accessoryID, "quantity": 1})

    if not (res_inventory.status_code == 201 or res_inventory.status_code == 200):
        return jsonify(res_inventory.json()), res_inventory.status_code

    # reduce inStock in shop
    res_shop = requests.put(shopURL, json = {"accessoryID": accessoryID, "inStock": int(inStock)-1})
    if not (res_shop.status_code == 200):
        return jsonify(res_shop.json()), res_shop.status_code

    return jsonify({'message': "Accessory purchased successfully!"}), 200

    


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5200, debug=True)