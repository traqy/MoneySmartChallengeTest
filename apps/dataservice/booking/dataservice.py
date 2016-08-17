#!/usr/bin/python 

import cjson
import traceback

from flask import Flask, request, jsonify
app = Flask(__name__)

from Booking import Booking


'''
api method to reserve a slot

example curl:
     curl -H 'Content-Type: application/json' -X PUT -d '{"Date" : "2016-08-18", "HourlySlot" : 7, "ReserveeId" : "usertest1", "ReserveeComment" : "Test Reserve comment" }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/reserve
'''
@app.route('/mini-app-booking-ds/api/user/reserve', methods=["PUT", "POST"])
def reserve():
    content = cjson.decode(request.data)
    booking = Booking( Date = content.get('Date'), HourlySlot = content.get('HourlySlot'), ReserveeId = content.get('ReserveeId'), ReserveeComment=content.get('ReserveeComment') )
    booking.reserve()
    json_retval = cjson.encode(booking.getResponse())

    return json_retval
    

'''
api for canceling existing booking

example curl:
    curl -H 'Content-Type: application/json' -X PUT -d '{ "username" : "usertest1" , "id" : 1 }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/cancel
'''
@app.route('/mini-app-booking-ds/api/user/cancel', methods=["PUT", "POST"])
def cancel():
    content = cjson.decode(request.data)
    booking = Booking( id = content.get('id') )
    booking.cancel( content.get('Username') )
    json_retval = cjson.encode(booking.getResponse())


'''
Admin API for generating future date slots

example curl:
    curl -H 'Content-Type: application/json' -X PUT -d '{ "UserId" : "admin" , "dateFrom" : "2016-09-01", "dateTo" : "2016-09-30" }' http://192.168.99.100:5000/mini-app-booking-ds/api/admin/generate
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
@app.route('/mini-app-booking-ds/api/user/showdateslots', methods=["PUT", "POST"])
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