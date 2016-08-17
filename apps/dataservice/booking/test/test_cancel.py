#!/usr/bin/python 

from Booking import Booking
import cjson

booking = Booking( id = 3, UserId = 'usertest1' )
booking.cancel()
print cjson.encode(booking.getResponse())
