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

# returns a list of shops
@app.route('/shop')
def get_all_shops():
    return jsonify({"Shops" : [shop.json() for shop in Shop.query.all()]})


# create item in shop
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
        shop = Shop(shopID, **data)
    except TypeError:
        return jsonify({'message': "An error has occurred while creating the accessory in the shop. Please input a valid JSON."}), 400

    try:
        db.session.add(shop)
        db.session.commit()
    except:
        return jsonify({"message": "An unknown error occurred while creating the accessory in the shop."}), 500

    return jsonify(shop.json()), 201



if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5001, debug=True)