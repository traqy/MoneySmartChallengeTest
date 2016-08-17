#!/usr/bin/python 

from Booking import Booking
import cjson

booking = Booking( UserId = 'usertest3' )
booking.register()
print cjson.encode(booking.getResponse())
