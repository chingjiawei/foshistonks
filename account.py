from flask import Flask, request,jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ 

import decimal

# from os import environ

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/account'
# environ.get('dbURL')

app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

CORS(app)

class Account(db.Model):
    __tablename__ = 'account'

    username = db.Column(db.String(20), primary_key = True, unique = True, nullable = False)
    password = db.Column(db.String(20), nullable = False)
    email = db.Column(db.String(128), unique = True, nullable = False)
    phoneNumber = db.Column(db.String(8), nullable = False)
    telegramID = db.Column(db.String(128), unique = True, nullable = False)
    stonks = db.Column(db.Numeric(8,2), nullable = False)
    equipHead = db.Column(db.String(128), nullable = True)
    equipBody = db.Column(db.String(128), nullable = True)
    equipHand = db.Column(db.String(128), nullable = True)
    equipPet = db.Column(db.String(128), nullable = True)
    
    def __init__(self, username, password, email, phoneNumber, telegramID, stonks, equipHead=None, equipBody=None, equipHand=None, equipPet=None):
        self.username = username
        self.password = password
        self.email = email
        self.phoneNumber = phoneNumber
        self.telegramID = telegramID
        self.stonks = stonks
        self.equipHead = equipHead
        self.equipBody = equipBody
        self.equipHand = equipHand
        self.equipPet = equipPet

    def json(self):
        return {
            "username": self.username,
            "password": self.password,
            "email": self.email ,
            "phoneNumber": self.phoneNumber,
            "telegramID": self.telegramID,
            "stonks": str(self.stonks),
            "equipHead": self.equipHead,
            "equipBody": self.equipBody,
            "equipHand": self.equipHand,
            "equipPet": self.equipPet
        }    


#get all accounts
@app.route("/account")
def get_all():
    return jsonify({"accounts":[account.json() for account in Account.query.all()]})


#get an account
@app.route("/account/<string:username>")
def find_by_username(username):
    account = Account.query.filter_by(username = username).first()
    if account:
        return jsonify(account.json())
    return jsonify({"message":"Account not found"}), 404

#create a new account (Input parameters. JSON password, email, telegramID, phoneNumber)
@app.route("/account/<string:username>", methods =['POST'])
def create_account(username):

    try:
        data = request.get_json()

        for key, value in data.items():
            if key in ['username', 'telegramID', 'email', 'phoneNumber']:
                if value == None:
                    return jsonify({"message":f"{key} should not be NoneType."}), 400 
                else:
                    existing_account = Account.query.filter(Account.username == username or Account.email == request.json.get("email") or Account.telegramID == request.json.get("telegramID")).first()
                    if existing_account:
                        return jsonify({"message":"Account already exists."}), 400

                    if key == 'email' and (value.find("@") == -1 or value.find(".") == -1):
                        return jsonify({"message":"Please input a valid email."}), 400



        new_account = Account(username = username, stonks = 100, **data)

    except:
        return jsonify({"message": "Please input a valid JSON."}), 400

    try:
        db.session.add(new_account)
        db.session.commit()

    except:
         return jsonify({"message":"An unknown error occurred creating the account."}), 500

    return jsonify(new_account.json()), 201


#update an account information
# expected input:
# {
#       "email": "xyzhang@gmail.com",
#       "password": "xyzhang123",
#       "phoneNumber": "67009000",
#       "telegramID": "45678",
#       "equipHead": "./src/img/1.png",
#       "equipBody": "./src/img/2.png",
#       "equipHand": "./src/img/3.png",
#       "equipPet": "./src/img/4.png",
#       "stonks": 100
#  }


@app.route("/account/<string:username>", methods =['PUT'])
def update_account(username):

    if not (Account.query.filter_by(username = username).first()):
        return jsonify({"message": "An account with username '{}' does not exist.".format(username)}), 404

    try:
        account = Account.query.filter_by(username = username).first()
        account.email = request.json.get('email', account.email)
        account.telegramID = request.json.get('telegramID', account.telegramID)
        account.password = request.json.get('password', account.password)
        account.phoneNumber = request.json.get('phoneNumber', account.phoneNumber)
        account.stonks = request.json.get('stonks', account.stonks)
        account.equipHead = request.json.get('equipHead', account.equipHead)
        account.equipBody = request.json.get('equipBody', account.equipBody)
        account.equipHand = request.json.get('equipHand', account.equipHand)
        account.equipPet = request.json.get('equipPet', account.equipPet)
        db.session.commit()
    except:
         return jsonify({"message":"An unknown error occurred updating the account information."}), 500

    return jsonify(account.json()), 200


# update stonks balance for a particular account
# expected input: 
# {     "username": "weihao",
#       "stonks": "0"
# }

@app.route("/account/update/stonks/<string:username>", methods =['POST'])
def update_stonks(username):

    if not (Account.query.filter_by(username = username).first()):
        return jsonify({"message": "An account with username '{}' does not exist.".format(username)}), 404
    
    account = Account.query.filter_by(username = username).first()

    try:
        content = request.get_json()
        new_stonks = content["stonks"]
        if new_stonks == None:
            return jsonify({"message":"Please input a valid stonks balance."}), 400
        account.stonks = account.stonks + decimal.Decimal(new_stonks)
        db.session.commit()
    except:
         return jsonify({"message":"An unknown error occurred while updating the stonks balance."}), 500

    return jsonify({"message":"Updated Successfully!"}), 200


#JSON Input equipHead, equipBody, equipHand, equipPet src
@app.route("/account/update/equip/<string:username>", methods =['PUT'])
def update_equipment(username):

    if not (Account.query.filter_by(username = username).first()):
        return jsonify({"message": "An account with username '{}' does not exist.".format(username)}), 404
    
    account = Account.query.filter_by(username = username).first()

    try:
        account.equipHead = request.json.get('equipHead', account.equipHead)
        account.equipBody = request.json.get('equipBody', account.equipBody)
        account.equipHand = request.json.get('equipHand', account.equipHand)
        account.equipPet = request.json.get('equipPet', account.equipPet)
        db.session.commit()
    except:
         return jsonify({"message":"An unknown error occurred while updating the equipment sources."}), 500

    return jsonify({"message":"Updated Successfully!"}), 200


#delete account from database
# expected input: username
@app.route("/account/<string:username>",methods =['DELETE'])
def delete_account(username):

    if not (Account.query.filter_by(username = username).first()):
        return jsonify({"message": "An account with username '{}' does not exist.".format(username)}), 404

    try:
        account = Account.query.filter_by(username = username).first()
        db.session.delete(account)
        db.session.commit()
    except:
        return jsonify({"message":"An unknown error occurred while deleting the account."}), 500

    return jsonify({"message":"Deleted Successfully!"}),200


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)