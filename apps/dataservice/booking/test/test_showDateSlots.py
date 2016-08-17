#!/usr/bin/python 

from Booking import Booking
import cjson

booking = Booking(Date = '2016-09-01' )
booking.viewBookingDateSlots()
print cjson.encode(booking.getResponse())
