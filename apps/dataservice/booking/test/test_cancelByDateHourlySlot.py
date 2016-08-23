#!/usr/bin/python 

from Booking import Booking
import cjson

booking = Booking( Date = '2016-08-24', HourlySlot = 14 , UserId = 'btraquena@gmail.com' )
booking.cancelByDateHourlySlot()
print cjson.encode(booking.getResponse())
