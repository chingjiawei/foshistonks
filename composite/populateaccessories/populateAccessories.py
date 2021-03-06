from flask import Flask, request, jsonify
from flask_cors import CORS
from os import environ

import requests

app = Flask(__name__)
CORS(app)

# populate shop accessories
@app.route('/populateShopAccessories/<int:shopID>', methods=['GET'])
def populate_shop_accessories(shopID):
    shopURL = f'http://shop:5003/shop/{shopID}'
    req = requests.get(shopURL)

    if (req.status_code == 200):
        shop = req.json()

        accessoryIDList = [int(accessory) for accessory in shop[str(shopID)]]

        accessoryURL = f'http://accessory:5001/accessory/list'
        accessory_req = requests.get(accessoryURL, params = {"accessoryIDList[]": accessoryIDList})
        
        if (accessory_req.status_code == 200):
     
            accessoryDetails = accessory_req.json()

            for accessory in accessoryDetails:
                shop[str(shopID)][str(accessory['accessoryID'])].update(accessory)
            
            return jsonify(shop)
    
    else:
        return jsonify({"status": req.status_code, "error": req.json()})


# populate inventory accessoris
@app.route('/populateInventoryAccessories/<string:username>', methods=['GET'])
def populate_inventory_accessories(username):
    inventoryURL = f'http://inventory:5002/inventory/{username}'
    req = requests.get(inventoryURL)

    if (req.status_code == 200):
        inventory = req.json()

        accessoryIDList = [int(accessory) for accessory in inventory[username]]
        # return jsonify(accessoryIDList)
        if len(accessoryIDList) == 0:
            return jsonify({"message" : "No Accessories"})

        accessoryURL = f'http://accessory:5001/accessory/list'
        accessory_req = requests.get(accessoryURL, params = {"accessoryIDList[]": accessoryIDList})
        
        if (accessory_req.status_code == 200):
            accessoryDetails = accessory_req.json()
            for accessory in accessoryDetails:
                inventory[str(username)][str(accessory['accessoryID'])].update(accessory)
            
            return jsonify(inventory)
    
    else:
        return jsonify({"status": req.status_code, "error": req.json()})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5100, debug=True)