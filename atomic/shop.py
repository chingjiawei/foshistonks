from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/shop'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)

class Shop(db.Model):
    __tablename__ = 'shop'

    shopID = db.Column(db.Integer, nullable=False)
    accessoryID = db.Column(db.Integer, nullable=False)
    inStock = db.Column(db.Integer, nullable=False)
    price = db.Column(db.Numeric(8,2), nullable=False)

    __table_args__ = (db.PrimaryKeyConstraint("shopID", "accessoryID"), )

    def __init__(self, shopID, accessoryID, inStock, price):
        self.shopID = shopID
        self.accessoryID = accessoryID
        self.inStock = inStock
        self.price = price


    def json(self):
        return {
            "shopID" : self.shopID,
            "accessoryID" : self.accessoryID,
            "inStock" : self.inStock,
            "price" : str(self.price)
        }

# returns a list of shops with its accessories
@app.route('/shop')
def get_all_shops():
    shops = Shop.query.all()
    shopsDict = {}

    for shop in shops:
        if shop.shopID not in shopsDict:
            shopsDict[shop.shopID] = [{"accessoryID": shop.accessoryID, "inStock": shop.inStock, "price": str(shop.price)}]
        else:
            shopsDict[shop.shopID] += [{"accessoryID": shop.accessoryID, "inStock": shop.inStock, "price": str(shop.price)}]

    return jsonify({"Shops" : shopsDict})


# Retreive a shop's accessories
@app.route("/shop/<int:shopID>")
def find_by_shopID(shopID):
    shop = Shop.query.filter_by(shopID=shopID)

    if shop:
        shopAccessories = {shopID: {accessory.accessoryID: {"inStock": accessory.inStock, "price": str(accessory.price)} for accessory in shop}}
        return jsonify(shopAccessories)

    return jsonify({'message': 'There are no items available for sale in shop' + str(shopID)}), 404


# Retreive an accessory in a particular shop
@app.route("/shop/<int:shopID>/<int:accessoryID>")
def find_accessory_in_shopID(shopID, accessoryID):
    try:
        shop = Shop.query.filter_by(shopID=shopID,accessoryID=accessoryID).first()
    except:
        return jsonify({'message': "An unknown error occurred while retrieving accessory in shop."}), 500

    if shop:
        return jsonify(shop.json())

    return jsonify({'message': str(accessoryID) + ' cannot be found in shop ' + str(shopID)}), 404


# create accessory in shop
@app.route('/shop/<int:shopID>', methods=["POST"])
def create_item(shopID):

    try:
        data = request.get_json()
        accessoryID = data['accessoryID']
    except:
        return jsonify({'message': "Please input a valid JSON."}), 400  

    if (Shop.query.filter_by(shopID=shopID, accessoryID=accessoryID).first()):
        return jsonify({"message": "An accessory with accessoryID '{}' already exists in shopID '{}'.".format(accessoryID, shopID)}), 400
    
    try:
        shop = Shop(shopID=shopID, **data)
        
        for key, value in data.items():
            if value == None:
                return jsonify({'message': f"An error occurred while updating the item in the shop. {key} cannot be None."}), 400

            elif key in ['inStock', 'price'] and float(value) < 0:
                return jsonify({'message': f"An error occurred while updating the item in the shop. Please input a proper amount."}), 400

    except TypeError:
        return jsonify({'message': "An error has occurred while creating the accessory in the shop. Please input a valid JSON."}), 400

    try:
        db.session.add(shop)
        db.session.commit()
    except:
        return jsonify({"message": "An unknown error occurred while creating the accessory in the shop."}), 500

    return jsonify(shop.json()), 201


# update accessory price and stock
@app.route('/shop/<int:shopID>', methods=['PUT'])
def update_item(shopID):

    try:
        data = request.get_json()
        
        for key, value in data.items():
            if value == None:
                return jsonify({'message': f"An error occurred while updating the item in the shop. {key} cannot be None."}), 400

            elif key in ['inStock', 'price'] and float(value) < 0:
                return jsonify({'message': f"An error occurred while updating the item in the shop. Please input a proper amount."}), 400

        accessoryID = request.json.get('accessoryID')

        if not (Shop.query.filter_by(shopID=shopID, accessoryID=accessoryID).first()):
            return jsonify({"message": "The accessory with accessoryID '{}' does not exist in shop {}.".format(accessoryID, shopID)}), 404

        shopAccessory = Shop.query.filter_by(shopID=shopID, accessoryID=accessoryID).first()
        shopAccessory.inStock = request.json.get('inStock', shopAccessory.inStock)
        shopAccessory.price = request.json.get('price', shopAccessory.price)

        db.session.commit()

    except:
        return jsonify({"message": "An unknown error occurred while updating the accessory."}), 500

    return jsonify(shopAccessory.json()), 200


# Delete accessory in shop
@app.route("/shop/<int:shopID>/<int:accessoryID>", methods=['DELETE'])
def delete_accessory_in_shop(shopID, accessoryID):

    if not (Shop.query.filter_by(shopID=shopID, accessoryID=accessoryID).first()):
        return jsonify({"message": "The accessory with accessoryID '{}' does not exist in the shop {}.".format(accessoryID, shopID)}), 404

    try:
        shopAccessory = Shop.query.filter_by(shopID=shopID, accessoryID=accessoryID).first()
        db.session.delete(shopAccessory)
        db.session.commit()

    except KeyError:
        return jsonify({"message": "An unknown error occurred while deleting the accessory."}), 500

    shop = Shop.query.filter_by(shopID=shopID)

    if shop:
        shopAccessories = {shopID: {accessory.accessoryID: {"inStock": accessory.inStock, "price": str(accessory.price)} for accessory in shop}}
        return jsonify(shopAccessories)


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5003, debug=True)