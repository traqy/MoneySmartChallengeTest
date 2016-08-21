#!/usr/bin/python 

from Booking import Booking
import cjson

booking = Booking()
response = booking.adminGenerateFutureDateHourlySlots(userId = 'admin', dateFrom = '2016-08-22', dateTo = '2016-08-31')
print cjson.encode(response)

