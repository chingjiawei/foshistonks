from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

import requests

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

CORS(app)

@app.route('/populateShopAccessories/<int:shopID>', methods=['GET'])
def populate_shop_accessories(shopID):
    shopURL = f'http://localhost:5003/shop/{shopID}'
    req = requests.get(shopURL)

    if (req.status_code == 200):
        shop = req.json()

        accessoryIDList = [int(accessory) for accessory in shop[str(shopID)]]
        shopAccessoriesList = []

        accessoryURL = f'http://localhost:5001/accessory/list'
        accessory_req = requests.get(accessoryURL, params = {"accessoryIDList[]": accessoryIDList})
        
        if (accessory_req.status_code == 200):
     
            accessoryDetails = accessory_req.json()

            for accessory in accessoryDetails:
                shop[str(shopID)][str(accessory['accessoryID'])].update(accessory)
            
            return jsonify(shop)
    
    else:
        return jsonify({"status": req.status_code, "error": req.json()})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5100, debug=True)