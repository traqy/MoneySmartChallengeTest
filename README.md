# MoneySmartChallengeTest

## Booking Mini Application

## Technology Stack
  * Applications
    * HaProxy - Load Balancer
    * Python - Backend Data Service
    * Web UI Server Side (PHP5 Codeigniter Framework)
  * Data Store
    * MySQL

## Architectural Diagram
  * HAProxy Load Balancer <-> PHP Web Service(CodeIgniter) <-> Data Service REST API <-> MySQL Data Store

## Requirements
  * Write a mini application for Tennis court booking. 
    * Bookings are 1 hr slots with no overlaps allowed.
    * you are free to make assumptions. pls document them.

## Assumptions
  * Bookings
    * Tennis court booking daily schedules for the calendar year shall be generated at least 6 months earlier.
    * Administrator can mark a particular date where tennis court unavailable due to the following:
      * Holiday
      * Scheduled Renovation
      * Unexpected events
    * User and Admin Functions
      * User
        * Reserve
        * View Date Slots
        * Cancel owned booked slots
      * Admin
        * Cancel existing booking
        * View Date Slots
        * Generate future dates slots

  * User Registration
    * Local Sign Up registration

## Data Structure Design
  * DB
    * Booking
      * id - primary key
      * Date - (Unique date)
      * HourlySlot - Hourly slot (1-23)
      * ReserveeId - User who reserved the slot (e.g. Fabebook, Google, Twitter, etc)
      * ReserveeDesc - Additional details of the users.
      * Status - (1 - Reserved, 0 - Available, -1 -Closed )
      * Tstamp - datetime record updated
    * BookingTemplate
      * Hour - Hourly slot
    * User
      * id - primary key
      * Username - Email address
      * Firstname
      * Lastname
      * AccessLevel - Level of access to the application. (0 - Anonymous, 1 - Registered Users, 2 - Admin)
      * tstamp - datetime record updated


## Deployment using Docker
  * Pre-requisites
    * Docker tools: docker, docker-machine, and docker-compose
  * Build images
    * DB - MySQL Service
    
```
cd docker/mysql
./build.sh
```

    * Dataservice REST API
    
```
cd docker/dataservice
./build.sh
```

  * Web App - NodeJS Frontend UI (UNDER CONSTRUCTION)
  
```
```

  * Run containers
    * DB - MySQL service
    
```
cd docker/mysql
./run.sh
```

  * REST API - Python Flask RESTFul service
    
```
cd docker/mysql
./run.sh
```

  * Web Server - NodeJS webapp service ( http://192.168.99.100:8080/ )
  
```
cd docker/web-codeigniter
./run.sh
```

  * Show running containers
  
```
CONTAINER ID        IMAGE                               COMMAND                  CREATED             STATUS              PORTS                    NAMES
bb8dd8192c69        3d4c64ef8262                        "/bin/sh -c 'apt-get "   24 seconds ago      Up 23 seconds       80/tcp                   fervent_torvalds
ac17fcf4134a        traqy/booking-miniapp-dataservice   "/bin/bash"              12 hours ago        Up 12 hours         0.0.0.0:5000->5000/tcp   booking-miniapp-dataservice
1975e3ab8757        traqy/booking-miniapp-web-ci        "/bin/bash"              19 hours ago        Up 19 hours         0.0.0.0:80->80/tcp       booking-miniapp-web-ci
949927845f28        traqy/booking-miniapp-mysql         "/root/scripts/run-my"   4 days ago          Up 22 hours         0.0.0.0:3306->3306/tcp   booking-miniapp-mysql
```


## Dataservice RESTful-API Endpoints
  * Register
    * Request
    
```
    curl -s -H 'Content-Type: application/json' -X PUT -d '{ "username" : "usertest2" }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/register
```

    * Response
    
```
    {"register": {"status": "success", "message": "User usertest2 is successfully registered."}}
```
  * Reserve
    * Request
    
```
    curl -s -H 'Content-Type: application/json' -X PUT -d '{"Date" : "2016-08-18", "HourlySlot" : 7, "ReserveeId" : "usertest1", "ReserveeComment" : "Test Reserve comment" }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/reserve
```

    * Response
    
```
{"reserve": {"status": "failed", "message": "Slot is not available."}}%    
```    
  * View Date Slots
    * Request
    ```
 curl -H 'Content-Type: application/json' -X PUT -d '{ "Date" : "2016-09-01" }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/showdateslots
```    
    * Response truncated
    ```
{
    "viewBookingDateSlots": {
        "data": [
            {
                "Date": "2016-09-01",
                "HourlySlot": 7,
                "ReserveeComment": "",
                "ReserveeId": "",
                "Status": 0
            },
            {
                "Date": "2016-09-01",
                "HourlySlot": 8,
                "ReserveeComment": "",
                "ReserveeId": "",
                "Status": 0
            },
...
...
            {
                "Date": "2016-09-01",
                "HourlySlot": 23,
                "ReserveeComment": "",
                "ReserveeId": "",
                "Status": 0
            }
        ],
        "status": "ok"
    }
}    
```
  * Cancel owned booked slots
    * Request
    
```
curl -s -H 'Content-Type: application/json' -X PUT -d '{ "username" : "usertest1" , "id" : 1 }' http://192.168.99.100:5000/mini-app-booking-ds/api/user/cancel    
```    

    * Response
    
```
{"cancel": {"status": "failed", "message": "Login Userid does not match ReserveeId.", "id": 1}}    
```
  * Generate future dates slots
    * Request
    
```
curl -s -H 'Content-Type: application/json' -X PUT -d '{ "UserId" : "admin" , "dateFrom" : "2016-08-25", "dateTo" : "2016-08-31" }' http://192.168.99.100:5000/mini-app-booking-ds/api/admin/generate
```

    * Response
    
```
{"adminGenerateFutureDateHourlySlots": [{"2016-08-25": {"status": "success"}}, {"2016-08-26": {"status": "success"}}, {"2016-08-27": {"status": "success"}}, {"2016-08-28": {"status": "success"}}, {"2016-08-29": {"status": "success"}}, {"2016-08-30": {"status": "success"}}]}root@1c2c4d782fd8:~/apps/dataservice/booking
```


## Access Web UI
  * Edit your /etc/hosts
    * AWS EC2 Haproxy Public facing load balancer
    
```
52.221.248.211 booking.techtest-moneysmart.com  
```

    * If you do not want to use public facing IP loadbalancer
    
```
192.168.99.100 booking.techtest-moneysmart.com
```

  * Browse http://booking.techtest-moneysmart.com/index.php/booking/login
    * Admin account user/pass
      * admin/admin123



