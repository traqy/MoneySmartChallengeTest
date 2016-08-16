import sys, os


Class Booking(object):

    # Data Structure
    # * id - primary key ( Unique record for tennis court date schedule )
    # * Date - (Unique date)
    # * HourSlot - Hourly slot
    # * ReserveeId - User who reserved the slot (e.g. Fabebook, Google, Twitter, etc)
    # * ReserveeDesc - Additional details of the users.
    # * Status - (1 - Reserved, 0 - Available, -1 -Closed )
    # * Tstamp - datetime record updated

    db = MySQLdb.connect(db=booking, host=DBHOST,
                         port=3306, user=develop, passwd=develop,
                         cursorclass=MySQLdb.cursors.DictCursor)


    def __init__(self, **kwargs):

        id = kwargs['id']
        Date = kwargs['date']
        HourSlot = kwargs['hourslot']
        ReservedId = kwargs['ReservedId']
        ReserveeDesc = kwargs['ReserveeDesc']

    def add(self, booking):
        print "TODO"

    def view(self, date):
        print "TODO"

    def cancel(self, date):
        print "TODO"

    def isAvailable(self, booking):
        print "TODO"


        
