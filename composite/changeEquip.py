from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

import requests

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

CORS(app)

# input (username, accessoryID)

# change the player's equipment
@app.route('/changeEquip/<string:username>', methods=['POST'])
def change_equipment(username):

    # load json body
    accessoryID = request.json.get('accessoryID')

    if accessoryID == None:
        return jsonify({'message': 'Please input a valid JSON'}), 400

    accountURL = f"http://localhost:5000/account/{username}"
    accessoryURL = f'http://localhost:5001/accessory/{accessoryID}'

    # retrieve accessory source
    accessory_req = requests.get(accessoryURL)

    if not (accessory_req.status_code == 200):
        return jsonify(accessory_req.json()), accessory_req.status_code

    accessory = accessory_req.json()

    category = accessory['category']
    src = accessory['src']

    # update the equipment
    account_req = requests.put(accountURL, json={category: src})
    if not (account_req.status_code == 200):
        return jsonify(account_req.json()), account_req.status_code

    return jsonify({"message": "Accessory equipped successfully!"}), 200


    # unequip player's equipment
@app.route('/unequip/<string:username>', methods=['POST'])
def remove_equipment(username):

    try:
        # load json body
        category = request.json.get('category')

        if category == None:
            return jsonify({'message': 'Please input a valid JSON'}), 400

        accountURL = f"http://localhost:5000/account/{username}"

        # update the equipment
        account_req = requests.put(accountURL, json={category: None})
        if not (account_req.status_code == 200):
            return jsonify(account_req.json()), account_req.status_code

        return jsonify({"message": "Accessory unequipped successfully!"}), 200

    except:
        return jsonify({"message": "An unknown error has occurred while unequipping player."}), 500


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5102, debug=True)