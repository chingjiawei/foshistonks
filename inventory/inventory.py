from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS


app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/inventory'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)


class Inventory(db.Model):
    __tablename__ = 'inventory'

    username = db.Column(db.String(20), nullable = False)
    accessoryID = db.Column(db.Integer, nullable=False)
    quantity = db.Column(db.Integer, nullable=False)

    __table_args__ = (db.PrimaryKeyConstraint("username", "accessoryID"), )


    def __init__(self, username, accessoryID, quantity):
        self.username = username
        self.accessoryID = accessoryID
        self.quantity = quantity


    def json(self):
        return {
            'username': self.username,
            'accessoryID': self.accessoryID, 
            'quantity': self.quantity
        }


# Retrieve inventories of all users
@app.route("/inventory")
def get_all_inventories():
    inventories = Inventory.query.all()
    inventoriesDict = {}

    for inventory in inventories:
        if inventory.username not in inventoriesDict.keys():
            inventoriesDict[inventory.username] = [{"accessoryID": inventory.accessoryID, "quantity": inventory.quantity}]
        else:
            inventoriesDict[inventory.username] += [{"accessoryID": inventory.accessoryID, "quantity": inventory.quantity}]

    return jsonify({"Inventories": inventoriesDict})


# Retreive a user's inventory
@app.route("/inventory/<string:username>")
def find_by_username(username):
    inventory = Inventory.query.filter_by(username=username)

    if inventory:
        return jsonify({f"{username}": [{"accessoryID":accessory.accessoryID, "quantity": accessory.quantity} for accessory in inventory]})

    return jsonify({'message': 'There are no items in ' + username + "'s inventory."}), 404


# Add an accessory into a user's inventory
@app.route("/inventory/<string:username>", methods=['POST'])
def create_accessory_in_inventory(username):

    try:
        data = request.get_json()
        
        for key, value in data.items():
            if value == None:
                return jsonify({'message': f"An error occurred while creating the accessory. {key} cannot be None."}), 400
            elif key == 'quantity' and int(value) < 0:
                return jsonify({'message': f"An error occurred while creating the accessory. Please input a proper quantity."}), 400

        inventory = Inventory(username=username, **data)
        accessoryID=request.json.get('accessoryID')

        if (Inventory.query.filter_by(username=username, accessoryID=accessoryID).first()):
            return jsonify({"message": "An accessory with accessoryID '{}' already exists in your inventory.".format(accessoryID)}), 400

    except TypeError:
        return jsonify({'message': "An error occurred while creating the accessory. Please input a valid JSON."}), 400

    try:
        db.session.add(inventory)
        db.session.commit()
    except:
        return jsonify({"message": "An unknown error occurred while adding the accessory into your inventory."}), 500

    return jsonify(inventory.json()), 201


# update accessory quantity in user's inventory
@app.route("/inventory/<string:username>", methods=['PUT'])
def update_accessory_in_inventory(username):
    
    try:
        data = request.get_json()
        
        for key, value in data.items():
            if value == None:
                return jsonify({'message': f"An error occurred while updating the accessory. {key} cannot be None."}), 400

            elif key == 'quantity' and int(value) < 0:
                return jsonify({'message': f"An error occurred while updating the accessory. Please input a proper quantity."}), 400

        accessoryID = request.json.get('accessoryID')

        # create if it doesn't exist
        if not (Inventory.query.filter_by(username=username, accessoryID=accessoryID).first()):
            try:
                inventory = Inventory(username=username, **data)
                db.session.add(inventory)
                db.session.commit()
            except:
                return jsonify({"message": "An unknown error occurred while adding the accessory into your inventory."}), 500
            #return upon successful creation
            return jsonify(inventory.json()), 201

        accessory = Inventory.query.filter_by(username=username, accessoryID=accessoryID).first()
        accessory.quantity = request.json.get('quantity', accessory.quantity)

        db.session.commit()
    except:
        return jsonify({"message": "An unknown error occurred while updating the accessory."}), 500

    return jsonify(accessory.json()), 200


# Delete accessory in user's inventory
@app.route("/inventory/<string:username>/<int:accessoryID>", methods=['DELETE'])
def delete_accessory_in_inventory(username, accessoryID):

    if not (Inventory.query.filter_by(username=username, accessoryID=accessoryID).first()):
        return jsonify({"message": "An accessory with accessoryID '{}' does not exist in your inventory.".format(accessoryID)}), 404

    try:
        inventory = Inventory.query.filter_by(username=username, accessoryID=accessoryID).first()
        db.session.delete(inventory)
        db.session.commit()

    except KeyError:
        return jsonify({"message": "An unknown error occurred while deleting the accessory."}), 500

    inventory = Inventory.query.filter_by(username=username)

    if inventory:
        return jsonify({f"{username}": [{"accessoryID":accessory.accessoryID, "quantity": accessory.quantity} for accessory in inventory]})


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5002, debug=True)