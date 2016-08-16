import sys, os
import mysql.connector
import traceback
from mysql.connector import errorcode
import cjson

# MySQL Config
# TODO- put it on a configuration external file
DBHOST='192.168.99.100'
DBNAME='Booking'
DBUSER='develop'
DBPASS='develop'


cnx = mysql.connector.connect(user=DBUSER, password=DBPASS,
                              host=DBHOST,
                              database='Booking')

class Booking(object):

    # Data Structure
    # * id - primary key ( Unique record for tennis court date schedule )
    # * Date - (Unique date)
    # * HourlySlot - Hourly slot
    # * ReserveeId - User who reserved the slot (e.g. Fabebook, Google, Twitter, etc)
    # * ReserveeComment - Additional details of the users.
    # * Status - (1 - Reserved, 0 - Available, -1 -Closed )
    # * Tstamp - datetime record updated


    def __init__(self, **kwargs):

        #self.id = kwargs['id']
        self.id = kwargs.get('id')
        self.Date = kwargs.get('Date')
        self.HourlySlot = kwargs.get('HourlySlot')
        self.ReserveeId = kwargs.get('ReserveeId')
        self.ReserveeComment = kwargs.get('ReserveeComment')


        self.response = {}
        self.error = "";

    def reserve(self):

        if self.isSlotAvailable():

            cursor = cnx.cursor()
            try:
                query_data = {
                    'id' : self.id,
                    'ReserveeId' : self.ReserveeId,
                    'ReserveeComment' : self.ReserveeComment,
                }
                reserve_booking_sql = ( " UPDATE Booking SET ReserveeId=%(ReserveeId)s, ReserveeComment=%(ReserveeComment)s, Status=1 WHERE id = %(id)s" )        

                cursor.execute(reserve_booking_sql, query_data )
                cnx.commit()

                self.response = { 'reserve' : { 'status' : 'success' } }
            except:
                self.error = traceback.print_exception()
                self.response = { 'reserve' : { 'status' : 'failed' , 'message' : 'exception error encountered.' } }
                pass
            finally:
                cursor.close()
        else:
            self.response = { 'reserve' : { 'status' : 'failed', 'message' : 'Slot is not available.' } }

    def getResponse(self):
        return self.response
        
    def cancel(self, userid):

        cursor = cnx.cursor()

        try:
            if self.isOwner(userid):
                query_data = {
                    'id' : self.id
                }                

                cancel_sql = ( " UPDATE Booking SET ReserveeId='', ReserveeComment='', status = 0 WHERE id = %(id)s" )        
                cursor.execute(cancel_sql, query_data )
                cnx.commit()

                self.response = { 'cancel' : { 'status' : 'success' } }

            else:
                self.response = { 'cancel' : { 'status' : 'failed' , 'message' : 'Userid does not match ReserveeId.' } }
        except:
            self.response = { 'cancel' : { 'status' : 'failed' , 'message' : 'exception error encountered.' } }
        finally:
            cursor.close()


    def viewBookingDateSlots(self):

        cursor = cnx.cursor()        
        try:
            query_data = {
                'Date' : self.Date
            }
            query_stmt = ( " SELECT Date, HourlySlot, ReserveeId, ReserveeComment, Status FROM Booking WHERE Date = %(Date)s " )                
            cursor.execute(query_stmt, query_data )
            data = []
            for row in cursor:
                row = { 'Date' : row[0], 'ReserveeId' : row[1], 'ReserveeComment' : row[2], 'Status' : row[3] }
                data.append(row)

            self.response = { 'viewBookingDateSlots' : { 'status' : 'ok' , 'data' : data } }
        except:
            traceback.print_exc()
            self.response = { 'viewBookingDateSlots' : { 'status' : 'error' , 'message' : 'exception error encountered.' } }
        finally:
            cursor.close()


    def viewSlot(self):
        print "TODO"

    def isSlotAvailable(self):

        retval = False

        cursor = cnx.cursor()
        try:
            query_isSlotAvailable =  (" SELECT status FROM Booking WHERE id = %(id)s ")
            query_data = {
                'id' : self.id
            }
            cursor.execute(query_isSlotAvailable, query_data )
            row = cursor.fetchone()
            status = row[0]
            if status == 0:
                retval = True
        except:
            self.error = traceback.print_exc()
        finally:
            cursor.close()
            return retval



    def isOwner(self, userid):

        retval = False        
        try:

            is_owner_sql = ( "SELECT ReserveeId FROM Booking WHERE id = %(id)s AND ReserveeId = %(ReserveeId)s" )
            query_data = {
                'id' : self.id,
                'ReserveeId' : self.ReserveeId
            }

            cursor = cnx.cursor()
            cursor.execute(is_owner_sql, query_data )
            
        except:
            self.error = traceback.print_exception()
            pass

    @staticmethod
    def testping():
        retval = { 'testping' : {'status' : 'ok' } }
        #retval = 'errrr'
        return retval


if __name__ == '__main__':

    #booking = Booking(id ='1', Date="2016-08-18", HourlySlot = "7", ReserveeId="btraquena@gmail.com", ReserveeComment="Test comment message")
    #booking.isSlotAvailable()
    #booking.reserve()
    booking = Booking( Date="2016-08-18")
    booking.viewBookingDateSlots()
