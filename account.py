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

    userid = db.Column(db.String(20), primary_key = True)
    password = db.Column(db.String(10), nullable = False)
    email = db.Column(db.String(20), nullable = False)
    phoneNumber = db.Column(db.Integer,nullable = False)
    telegramid = db.Column(db.Integer,nullable = False)
    type = db.Column(db.Integer,nullable = False)
    stonks = db.Column(db.Float,nullable = False)
    
    def __init__(self,userid,password,email,phoneNumber,telegramid,type,stonks):
        self.userid = userid
        self.password = password
        self.email = email
        self.phoneNumber = phoneNumber
        self.telegramid = telegramid
        self.type = type
        self.stonks = stonks


    def json(self):
        return {"userid": self.userid, 
                "password": self.password, 
                "email": self.email , 
                "phoneNumber": self.phoneNumber,
                "telegramid": self.telegramid, 
                "type": self.type, 
                "stonks": self.stonks ,    
                }    

#retrieve all account
@app.route("/account")
def get_all():
    return jsonify({"accounts":[account.json() for account in Account.query.all()]})

#retrieve one account
@app.route("/account/<string:userid>")
def find_by_userid(userid):
    account = Account.query.filter_by(userid = userid).first()
    if account:
        return jsonify(account.json())
    return jsonify({"message":"Account not found"}), 404
    return {'message': 'Order not found for id ' + str(order_id)}, 404


#create new account
@app.route("/account/<string:userid>", methods =['POST'])
def create_account(userid):
    email = request.json.get('email')
    telegramid = request.json.get('telegramid')
    password = request.json.get('password')
    phoneNumber = request.json.get('phoneNumber')

    if userid and email and telegramid:
        exisitng_account = Account.query.filter(Account.userid == userid or Account.email == email or Account.telegramid == telegramid).first()
        if exisitng_account: 
            return jsonify({"message":"Account already exists."}),400 
    
    new_account = Account(userid = userid,
                         email = email, 
                        telegramid = telegramid, 
                        password = password,
                        phoneNumber = phoneNumber,
                        type = 0,
                        stonks = 100)

    try:
        db.session.add(new_account)
        db.session.commit()
    except:
         return jsonify({"message":"An error occurred creating the account."}), 500

    return jsonify(new_account.json()), 201

#update stonks amount
@app.route("/account/update/<string:userid>", methods =['POST'])
def update_stonks(userid):
    new_stonks = request.json.get('stonks')
    account = Account.query.filter_by(userid = userid).first()
    stonks = account.stonks + new_stonks

    try:
        account.query.filter_by(userid = userid).update({'stonks':stonks })
        db.session.commit()
    except:
         return jsonify({"message":"An error occurred updating the stonks balance."}), 500

    return jsonify(stonks), 201

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)