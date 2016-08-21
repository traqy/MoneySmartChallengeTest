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

from datetime import timedelta, date, datetime

def daterange(start_date, end_date):
    retval = []
    for n in range(int ((end_date - start_date).days)):
         retval.append(start_date + timedelta(n))

    return retval

class Booking(object):

    # Data Structure
    # * id - primary key ( Unique record for tennis court date schedule )
    # * Date - (Unique date)
    # * HourlySlot - Hourly slot
    # * ReserveeId - Local Sign-Up
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
        self.UserId = kwargs.get('UserId')
        self.Password = kwargs.get('Password')
        self.FirstName = kwargs.get('FirstName')
        self.LastName = kwargs.get('LastName')
        self.Status = kwargs.get('Status')


        self.response = {}
        self.error = "";


    def register(self):
        cursor = cnx.cursor()

        if self.isRegistered():
            message = "{0} is already registered.".format(self.UserId)
            self.response = { 'register' : { 'status' : 'failed', 'message' : message } }
        else:
            try:
                query_sql = ( "INSERT INTO User (Username, AccessLevel) VALUES (%(UserId)s, 1)" )
                query_data = {
                    'UserId' : self.UserId
                }
                cursor = cnx.cursor()
                cursor.execute(query_sql, query_data )
                cnx.commit()
                message = "User {0} is successfully registered.".format(self.UserId)
                self.response = { 'register' : { 'status' : 'success', 'message' : message } }
            except:
                traceback.print_exc()
                self.response = { 'register' : { 'status' : 'failed', 'message' : 'Exception error encountered.' } }

        cursor.close()

    def register_latest(self):
        cursor = cnx.cursor()

        if self.isRegistered():
            message = "{0} is already registered.".format(self.UserId)
            self.response = { 'register' : { 'status' : 'failed', 'message' : message } }
        elif not self.Password:
            message = "Password is empty."
            self.response = { 'register' : { 'status' : 'failed', 'message' : message } }
        elif len(self.Password) < 8:
            message = "Password is too short. Password should be at least 8 characters."
            self.response = { 'register' : { 'status' : 'failed', 'message' : message } }
        else:
            try:
                query_sql = ( "INSERT INTO User (Username, Password, Firstname, Lastname, Status, AccessLevel) VALUES (%(UserId)s,%(Password)s, %(FirstName)s,%(LastName)s, 1, 1)" )
                query_data = {
                    'UserId' : self.UserId,
                    'Password' : self.Password,
                    'FirstName' : self.FirstName,
                    'LastName' : self.LastName,
                    'Status' : self.Status,
                }
                cursor = cnx.cursor()
                cursor.execute(query_sql, query_data )
                cnx.commit()
                message = "User {0} is successfully registered.".format(self.UserId)
                self.response = { 'register' : { 'status' : 'success', 'message' : message } }
            except:
                traceback.print_exc()
                self.response = { 'register' : { 'status' : 'failed', 'message' : 'Exception error encountered.' } }

        cursor.close()

    def isRegistered(self):
        cursor = cnx.cursor()

        retval = False
        try:

            query_sql = ( "SELECT Username FROM User WHERE Username = %(UserId)s" )
            query_data = {
                'UserId' : self.UserId
            }

            cursor = cnx.cursor()
            cursor.execute(query_sql, query_data )
            row = cursor.fetchone()

            if row:
                retval = True
            else:
                retval = False
        except:
            self.error = traceback.print_exception()
            pass
        finally:
            cursor.close()
            return retval

    def login(self):
        cursor = cnx.cursor()

        try:

            query_sql = ( "SELECT Password FROM User WHERE Username = %(UserId)s " )
            query_data = {
                'UserId' : self.UserId
            }

            cursor = cnx.cursor()
            cursor.execute(query_sql, query_data )
            row = cursor.fetchone()

            if row is None:
                self.response = { 'login' : { 'status' : 'failed', 'message' : "UserId not registered. Please sign up." } }
            elif row[0] == self.Password:
                self.response = { 'login' : { 'status' : 'ok', 'message' : "Login succeeded." , 'sessionid' : "todo" } }
            else:
                self.response = { 'login' : { 'status' : 'failed', 'message' : "Login failed." } }
        except:
            #self.error = traceback.print_exception()
            self.response = { 'login' : { 'status' : 'failed', 'message' : "Internal Server Error." } }
            pass
        finally:
            cursor.close()

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


    def reserveByDateSlot(self):

        if self.isDateSlotAvailable():

            cursor = cnx.cursor()
            try:
                query_data = {
                    'Date' : self.Date,
                    'HourlySlot' : self.HourlySlot,
                    'ReserveeId' : self.ReserveeId,
                    'ReserveeComment' : self.ReserveeComment,
                }
                reserve_booking_sql = ( " UPDATE Booking SET ReserveeId=%(ReserveeId)s, ReserveeComment=%(ReserveeComment)s, Status=1 WHERE Date = %(Date)s and HourlySlot = %(HourlySlot)s" )        

                cursor.execute(reserve_booking_sql, query_data )
                cnx.commit()

                self.response = { 'reserveByDateSlot' : { 'status' : 'success' } }
            except:
                self.error = traceback.print_exception()
                self.response = { 'reserveByDateSlot' : { 'status' : 'failed' , 'message' : 'exception error encountered.' } }
                pass
            finally:
                cursor.close()
        else:
            self.response = { 'reserveByDateSlot' : { 'status' : 'failed', 'message' : 'Slot is not available.' } }

    def getResponse(self):
        return self.response

    def isSlotDateFinished(self):
        cursor = cnx.cursor()

        try:

            query_sql = ( "SELECT Date FROM Booking WHERE id=%(id)s" )
            query_data = {
                'id' : self.id
            }

            cursor = cnx.cursor()
            cursor.execute(query_sql, query_data )

            row = cursor.fetchone()
            slot_date = row[0]

            present = datetime.now().date()

            if present > slot_date:
                return True
            else:
                return False
        except:
            self.error = traceback.print_exception()
            pass
        cursor.close()

    def cancel(self):

        cursor = cnx.cursor()

        try:

            if self.isSlotAvailable():
                self.response = { 'cancel' : { 'status' : 'failed' , 'message' : 'Slot is already available.' } }
            elif self.isSlotDateFinished():
                self.response = { 'cancel' : { 'status' : 'failed' , 'message' : 'You cannot cancel past reservation.' } }
            elif self.isOwner():
                query_data = {
                    'id' : self.id
                }                

                query_sql = ( " UPDATE Booking SET ReserveeId='', ReserveeComment='', status = 0 WHERE id = %(id)s" )        
                cursor.execute(query_sql, query_data )
                cnx.commit()

                self.response = { 'cancel' : {  'status' : 'success', 'id' : self.id } }

            else:
                self.response = { 'cancel' : { 'status' : 'failed' , 'message' : 'Login Userid does not match ReserveeId.', 'id' : self.id } }
        except:
            self.response = { 'cancel' : { 'status' : 'failed' , 'message' : 'exception error encountered.' } }
        finally:
            cursor.close()


    def viewBookingDateSlots(self):

        cursor = cnx.cursor()        

        self.reserve = {}
        try:
            query_data = {
                'Date' : self.Date
            }
            query_stmt = ( " SELECT Date, HourlySlot, ReserveeId, ReserveeComment, Status FROM Booking WHERE Date = %(Date)s " )                
            cursor.execute(query_stmt, query_data )
            data = []
            for row in cursor:
                row_json = { 'Date' : self.Date, 'HourlySlot': row[1], 'ReserveeId' : row[2], 'ReserveeComment' : row[3], 'Status' : row[4] }
                data.append(row_json)

            self.response = { 'viewBookingDateSlots' : { 'status' : 'ok' , 'data' : data } }
        except:
            #traceback.print_exc()
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


    def isDateSlotAvailable(self):

        retval = False

        cursor = cnx.cursor()
        try:
            query_isSlotAvailable =  (" SELECT status FROM Booking WHERE Date = %(Date)s and HourlySlot = %(HourlySlot)s ")
            query_data = {
                'Date' : self.Date,
                'HourlySlot' : self.HourlySlot
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

    def isOwner(self):

        try:

            query_sql = ( "SELECT ReserveeId FROM Booking WHERE id = %(id)s" )
            query_data = {
                'id' : self.id
            }

            cursor = cnx.cursor()
            cursor.execute(query_sql, query_data )

            row = cursor.fetchone()
            reservee_id = row[0]
            if reservee_id == self.UserId:
                return True
            else:
                return False
        except:
            self.error = traceback.print_exception()
            pass

    def isAdmin(self, userid):

        retval = False        
        try:

            query_sql = ( "SELECT AccessLevel FROM User WHERE Username = %(userId)s" )
            query_data = {
                'userId' : userid
            }

            cursor = cnx.cursor()
            cursor.execute(query_sql, query_data )
            row = cursor.fetchone()
            if row[0] == 2:
                retval = True
            
        except:
            retval = False
            self.error = traceback.print_exception()
            pass
        finally:
            return retval


    def adminGenerateFutureDateHourlySlots(self, **kwargs):

        userId = kwargs.get('userId')
        dateFrom = kwargs.get('dateFrom')
        dateTo = kwargs.get('dateTo')

        retval = {}
        try:
            if self.isAdmin(userId):
                dfrom = datetime.strptime(dateFrom, '%Y-%m-%d')
                dto = datetime.strptime(dateTo, '%Y-%m-%d')

                dnow = datetime.now()
                if dfrom > dto:
                    self.response = { 'adminGenerateFutureDateHourlySlots' : {'status' : 'error', 'message' : 'Invalid date range.' } }
                elif dfrom <= dnow:
                    self.response = { 'adminGenerateFutureDateHourlySlots' : {'status' : 'error', 'message' : 'Date from should be future date.' } }
                else:
                    cursor = cnx.cursor()
        
                    response_data = []
                    for single_date in daterange(dfrom, dto):
                        dateString = single_date.strftime("%Y-%m-%d")
                        query_sql = ( "INSERT INTO Booking (Date, HourlySlot, Status) SELECT %(Date)s, HourlySlot, Status FROM BookingTemplate" )
                        query_data = {
                            'Date' : dateString
                        }
                        response_data_row = {}
                        try:
                            cursor.execute(query_sql, query_data )
                            response_data_row = { dateString : { 'status' : 'success' } }
                            cnx.commit()
                        except:
                            #print traceback.print_exc()
                            response_data_row = { dateString : { 'status' : 'failed', 'message' : 'Exception error encountered.' } }
                            pass
                        finally:
                            response_data.append(response_data_row)


                    self.response = { 'adminGenerateFutureDateHourlySlots' : response_data }
                    cursor.close()

            else:
                self.response = { 'adminGenerateFutureDateHourlySlots' : {'status' : 'failed', 'message' : 'Permission denied.' } }
        except:
            self.error = traceback.print_exception()
            self.response = { 'adminGenerateFutureDateHourlySlots' : {'status' : 'failed', 'message' : 'Exception error encountered.' } }
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
