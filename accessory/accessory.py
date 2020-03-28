from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS


app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/accessory'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)


class Accessory(db.Model):
    __tablename__ = 'accessory'

    accessoryID = db.Column(db.Integer, primary_key=True, unique=True, nullable=False, autoincrement=True)
    accessoryName = db.Column(db.String(128), nullable=False)
    accessoryDesc = db.Column(db.String(256), nullable=False)
    category = db.Column(db.String(128), nullable=False)
    src = db.Column(db.String(128), nullable=False)


    def __init__(self, accessoryID, accessoryName, accessoryDesc, category, src):
        self.accessoryID = accessoryID
        self.accessoryName = accessoryName
        self.accessoryDesc = accessoryDesc
        self.category = category
        self.src = src


    def json(self):
        return {
            'accessoryID': self.accessoryID, 
            'accessoryName': self.accessoryName, 
            'accessoryDesc': self.accessoryDesc, 
            'category': self.category,
            'src': self.src
        }


# Retrieve all accessories
@app.route("/accessory")
def get_all_accessories():
    return jsonify({"Accessories": [accessory.json() for accessory in Accessory.query.all()]})


# Retreive accessory
@app.route("/accessory/<int:accessoryID>")
def find_by_accessoryID(accessoryID):
    accessory = Accessory.query.filter_by(accessoryID=accessoryID).first()
    if accessory:
        return accessory.json()
    return jsonify({'message': 'Accessory not found for id ' + str(accessoryID)}), 404


# Create accessory
@app.route("/accessory/<int:accessoryID>", methods=['POST'])
def create_accessory(accessoryID):

    if (Accessory.query.filter_by(accessoryID=accessoryID).first()):
        return jsonify({"message": "An accessory with accessoryID '{}' already exists.".format(accessoryID)}), 400

    try:
        data = request.get_json()
        accessory = Accessory(accessoryID, **data)
    except TypeError:
        return jsonify({'message': "An error occurred while creating the accessory. Please input a valid JSON."}), 400

    try:
        db.session.add(accessory)
        db.session.commit()
    except:
        return jsonify({"message": "An unknown error occurred while creating the accessory."}), 500

    return jsonify(accessory.json()), 201


# update accessory
@app.route("/accessory/<int:accessoryID>", methods=['PUT'])
def update_accessory(accessoryID):

    if not (Accessory.query.filter_by(accessoryID=accessoryID).first()):
        return jsonify({"message": "An accessory with accessoryID '{}' does not exist.".format(accessoryID)}), 404
    
    try:
        accessory = Accessory.query.get(accessoryID)
        accessory.accessoryName = request.json.get('accessoryName', accessory.accessoryName)
        accessory.accessoryDesc = request.json.get('accessoryDesc', accessory.accessoryDesc)
        accessory.category = request.json.get('category', accessory.category)
        accessory.src = request.json.get('src', accessory.src)
        db.session.commit()
    except:
        return jsonify({"message": "An unknown error occurred while updating the accessory."}), 500

    return jsonify(accessory.json()), 200


# Delete accessory
@app.route("/accessory/<int:accessoryID>", methods=['DELETE'])
def delete_accessory(accessoryID):

    if not (Accessory.query.filter_by(accessoryID=accessoryID).first()):
        return jsonify({"message": "An accessory with accessoryID '{}' does not exist.".format(accessoryID)}), 404

    try:
        Accessory.query.filter_by(accessoryID=accessoryID).delete()
        db.session.commit()

    except:
        return jsonify({"message": "An unknown error occurred while deleting the accessory."}), 500

    return jsonify({"Accessories": [accessory.json() for accessory in Accessory.query.all()]}), 200


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001, debug=True)