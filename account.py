from flask import Flask, request,jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ 

# from os import environ

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/account'
# environ.get('dbURL')

app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)

CORS(app)

class Account(db.Model):
    __tablename__ = 'account'

    userid = db.Column(db.String(20), primary_key = True, unique = True, nullable = False)
    password = db.Column(db.String(20), nullable = False)
    email = db.Column(db.String(128), nullable = False)
    phoneNumber = db.Column(db.String(8), nullable = False)
    telegramid = db.Column(db.String(128), nullable = False)
    stonks = db.Column(db.Numeric(8,2), nullable = False)
    equipHead = db.Column(db.String(128), nullable = True)
    equipBody = db.Column(db.String(128), nullable = True)
    equipHand = db.Column(db.String(128), nullable = True)
    equipPet = db.Column(db.String(128), nullable = True)
    
    def __init__(self, userid, password, email, phoneNumber, telegramid, stonks, equipHead=None, equipBody=None, equipHand=None, equipPet=None):
        self.userid = userid
        self.password = password
        self.email = email
        self.phoneNumber = phoneNumber
        self.telegramid = telegramid
        self.stonks = stonks
        self.equipHead = equipHead
        self.equipBody = equipBody
        self.equipHand = equipHand
        self.equipPet = equipPet

    def json(self):
        return {"userid": self.userid,
                "password": self.password,
                "email": self.email ,
                "phoneNumber": self.phoneNumber,
                "telegramid": self.telegramid,
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
@app.route("/account/<string:userid>")
def find_by_userid(userid):
    account = Account.query.filter_by(userid = userid).first()
    if account:
        return jsonify(account.json())
    return jsonify({"message":"Account not found"}), 404


#create a new account (Input parameters. JSON password, email, telegramid, phoneNumber)
@app.route("/account/<string:userid>", methods =['POST'])
def create_account(userid):

    try:
        data = request.get_json()

        for key, value in data.items():
            if key in ['userid', 'telegramid', 'email', 'phoneNumber']:
                if value == None:
                    return jsonify({"message":f"{key} should not be NoneType."}), 400 
                else:
                    existing_account = Account.query.filter(Account.userid == userid or Account.email == request.json.get("email") or Account.telegramid == request.json.get("telegramid")).first()
                    if existing_account:
                        return jsonify({"message":"Account already exists."}), 400

                    if key == 'email' and (value.find("@") == -1 or value.find(".") == -1):
                        return jsonify({"message":"Please input a valid email."}), 400



        new_account = Account(userid = userid, stonks = 100, **data)

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
#       "telegramid": "45678",
#       "equipHead": "./src/img/1.png",
#       "equipBody": "./src/img/2.png",
#       "equipHand": "./src/img/3.png",
#       "equipPet": "./src/img/4.png",
#       "stonks": 100
#  }


@app.route("/account/<string:userid>", methods =['PUT'])
def update_account(userid):

    if not (Account.query.filter_by(userid = userid).first()):
        return jsonify({"message": "An account with userid '{}' does not exist.".format(userid)}), 404

    try:
        account = Account.query.filter_by(userid = userid).first()
        account.email = request.json.get('email', account.email)
        account.telegramid = request.json.get('telegramid', account.telegramid)
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
# {     "userid": "weihao",
#       "stonks": "0"
# }

@app.route("/account/update/stonks/<string:userid>", methods =['PUT'])
def update_stonks(userid):

    if not (Account.query.filter_by(userid = userid).first()):
        return jsonify({"message": "An account with userid '{}' does not exist.".format(userid)}), 404
    
    account = Account.query.filter_by(userid = userid).first()

    try:
        new_stonks = request.json.get('stonks')
        if float(new_stonks) < 0 or new_stonks == None:
            return jsonify({"message":"Please input a valid stonks balance."}), 400

        account.stonks = new_stonks
        db.session.commit()
    except:
         return jsonify({"message":"An unknown error occurred while updating the stonks balance."}), 500

    return jsonify({"message":"Updated Successfully!"}), 200


#JSON Input equipHead, equipBody, equipHand, equipPet src
@app.route("/account/update/equip/<string:userid>", methods =['PUT'])
def update_equipment(userid):

    if not (Account.query.filter_by(userid = userid).first()):
        return jsonify({"message": "An account with userid '{}' does not exist.".format(userid)}), 404
    
    account = Account.query.filter_by(userid = userid).first()

    try:
        account.equipHead = request.json.get('equipHead', account.equipHead)
        account.equipBody = request.json.get('equipBody', account.equipBody)
        account.equipHand = request.json.get('equipHand', account.equipHand)
        account.equipPet = request.json.get('equipPet', account.equipPet)
        db.session.commit()
    except:
         return jsonify({"message":"An unknown error occurred while updating the stonks balance."}), 500

    return jsonify({"message":"Updated Successfully!"}), 200


#delete account from database
# expected input: userid
@app.route("/account/<string:userid>",methods =['DELETE'])
def delete_account(userid):

    if not (Account.query.filter_by(userid = userid).first()):
        return jsonify({"message": "An account with userid '{}' does not exist.".format(userid)}), 404

    try:
        account = Account.query.filter_by(userid = userid).first()
        db.session.delete(account)
        db.session.commit()
    except:
        return jsonify({"message":"An unknown error occurred while deleting the account."}), 500

    return jsonify({"message":"Deleted Successfully!"}),200


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)