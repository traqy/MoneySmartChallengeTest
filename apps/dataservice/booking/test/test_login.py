#!/usr/bin/python 

from Booking import Booking
import cjson

booking = Booking( UserId = 'btraquena@gmail.com', Password = '123432' )
booking.login()
print cjson.encode(booking.getResponse())
