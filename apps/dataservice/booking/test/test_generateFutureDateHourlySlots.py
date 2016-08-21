#!/usr/bin/python 

from Booking import Booking
import cjson

booking = Booking()
response = booking.adminGenerateFutureDateHourlySlots(userId = 'admin', dateFrom = '2016-09-25', dateTo = '2016-09-26')
print cjson.encode(response)

