#!/usr/bin/python 

import cjson
import traceback

from flask import Flask, request, jsonify
app = Flask(__name__)

from Booking import Booking

@app.route('/mini-app-booking-ds/api/reserve', methods=["PUT", "POST"])
def reserve():
    content = cjson.decode(request.data)
    booking = Booking( Date = content.get('Date'), HourlySlot = content.get('HourlySlot'), ReserveeId = content.get('ReserveeId'), ReserveeComment=content.get('ReserveeComment') )
    booking.reserve()
    json_retval = cjson.encode(booking.getResponse())

    return json_retval

    #return content.get['ReserveeId']
    #return cjson.encode(content_json)
    

@app.route('/mini-app-booking-ds/api/cancel', methods=['GET', 'POST'])
def cancel():
    content = request.get_json(silent=True)
    return 'TODO'

@app.route("/mini-app-booking-ds/api/testping")
def bookingtest():
    retval = cjson.encode(Booking.testping())
    return retval


if __name__ == "__main__":
    app.run(host='0.0.0.0', debug=True)