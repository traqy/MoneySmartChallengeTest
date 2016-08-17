#!/usr/bin/python 

from Booking import Booking
import cjson

booking = Booking()
response = booking.adminGenerateFutureDateHourlySlots(userId = 'admin', dateFrom = '2016-08-16', dateTo = '2016-08-21')
print cjson.encode(response)


response = booking.adminGenerateFutureDateHourlySlots(userId = 'admin', dateFrom = '2016-08-21', dateTo = '2016-08-19')
print cjson.encode(response)


response = booking.adminGenerateFutureDateHourlySlots(userId = 'admin', dateFrom = '2016-08-19', dateTo = '2016-08-25')
print cjson.encode(response)
