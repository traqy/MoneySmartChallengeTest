#!/usr/bin/python 

import cjson
import traceback

from flask import Flask, request, jsonify
app = Flask(__name__)

from Booking import Booking


'''
api method for registering or adding user

example curl
    curl -s -H 'Content-Type: application/json' -X PUT -d '{ "UserId" : "btraquena@gmail.com" , "Password" : "123432" }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/login
'''
@app.route('/mini-app-booking-ds/api/user/login', methods=["PUT", "POST"])
def login():
    content = cjson.decode(request.data)
    booking = Booking( UserId = content.get('UserId'), Password = content.get('Password') )
    booking.login()
    json_retval = cjson.encode(booking.getResponse())

    return json_retval


'''
api method for registering or adding user

example curl
    curl -s -H 'Content-Type: application/json' -X PUT -d '{ "username" : "usertest2" }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/register
'''
@app.route('/mini-app-booking-ds/api/user/register', methods=["PUT", "POST"])
def register():
    content = cjson.decode(request.data)
    booking = Booking( UserId = content.get('username') )
    booking.register()
    json_retval = cjson.encode(booking.getResponse())

    return json_retval


'''
api method for registering or adding user

example curl
    curl -s -H 'Content-Type: application/json' -X PUT -d '{ "UserId" : "usertest2" , "Password" : "123456789"}' http://192.168.99.100:5000/mini-app-booking-ds/api/user/registerlatest
'''
@app.route('/mini-app-booking-ds/api/user/registerlatest', methods=["PUT", "POST"])
def registerlatest():
    content = cjson.decode(request.data)
    booking = Booking( UserId = content.get('UserId'), Password = content.get('Password'), FirstName = content.get('FirstName'), LastName = content.get('LastName'), Status = 1 )
    booking.register_latest()
    json_retval = cjson.encode(booking.getResponse())

    return json_retval



'''
api method to reserve a slot

example curl:
     curl -s -H 'Content-Type: application/json' -X PUT -d '{"Date" : "2016-08-18", "HourlySlot" : 7, "ReserveeId" : "usertest1", "ReserveeComment" : "Test Reserve comment" }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/reserve
'''
@app.route('/mini-app-booking-ds/api/user/reserve', methods=["PUT", "POST"])
def reserve():
    content = cjson.decode(request.data)
    booking = Booking( Date = content.get('Date'), HourlySlot = content.get('HourlySlot'), ReserveeId = content.get('ReserveeId'), ReserveeComment=content.get('ReserveeComment') )
    booking.reserve()
    json_retval = cjson.encode(booking.getResponse())

    return json_retval

'''
api method to reserve a slot

example curl:
     curl -s -H 'Content-Type: application/json' -X PUT -d '{"Date" : "2016-09-01", "HourlySlot" : 7, "ReserveeId" : "usertest1", "ReserveeComment" : "Test Reserve comment" }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/reservebydateslot
'''
@app.route('/mini-app-booking-ds/api/user/reservebydateslot', methods=["PUT", "POST"])
def reserve_by_date_slot():
    content = cjson.decode(request.data)
    booking = Booking( Date = content.get('Date'), HourlySlot = content.get('HourlySlot'), ReserveeId = content.get('ReserveeId'), ReserveeComment=content.get('ReserveeComment') )
    booking.reserveByDateSlot()
    json_retval = cjson.encode(booking.getResponse())

    return json_retval



'''
api method for canceling existing booking by the user

example curl:
    curl -s -H 'Content-Type: application/json' -X PUT -d '{ "username" : "usertest1" , "id" : 1 }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/cancel
'''
@app.route('/mini-app-booking-ds/api/user/cancel', methods=["PUT", "POST"])
def cancel():
    content = cjson.decode(request.data)
    booking = Booking( id = content.get('id'), UserId = content.get('username'))
    booking.cancel()
    json_retval = cjson.encode(booking.getResponse())

    return json_retval

'''
Admin API for generating future date slots

example curl:
    curl -s -H 'Content-Type: application/json' -X PUT -d '{ "UserId" : "admin" , "dateFrom" : "2016-09-01", "dateTo" : "2016-09-30" }' http://192.168.99.100:5000/mini-app-booking-ds/api/admin/generate
'''
@app.route('/mini-app-booking-ds/api/admin/generate', methods=["PUT", "POST"])
def generate():
    content = cjson.decode(request.data)
    userId = content.get('UserId')
    dateFrom = content.get('dateFrom')
    dateTo = content.get('dateTo')

    booking = Booking()
    booking.adminGenerateFutureDateHourlySlots(userId = userId, dateFrom = dateFrom, dateTo = dateTo)
    json_retval = cjson.encode(booking.getResponse())

    return json_retval


'''
Admin API for generating future date slots

example curl:
    curl -H 'Content-Type: application/json' -X PUT -d '{ "Date" : "2016-09-01" }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/showdateslots
'''
@app.route('/mini-app-booking-ds/api/user/showdateslots', methods=["PUT", "POST", "GET"])
def showDateSlots():
    content = cjson.decode(request.data)
    booking = Booking( Date = content.get('Date') )
    booking.viewBookingDateSlots()
    json_retval = cjson.encode(booking.getResponse())
    return json_retval
    #return content.get('Date')

@app.route("/mini-app-booking-ds/api/testping")
def bookingtest():
    retval = cjson.encode(Booking.testping())
    return retval


if __name__ == "__main__":
    app.run(host='0.0.0.0', debug=True)