# MoneySmartChallengeTest

## Booking Mini Application

## Technology Stack
  * Applications
    * Python - Backend Data Service
    * NodeJS - Web Front-End UI
  * Data Store
    * MySQL

## Architectural Diagram
  * Underconstruction
  * NodeJS Web Service <-> Data Service REST API <-> MySQL Data Store

## Requirements
  * Write a mini application for Tennis court booking. 
    * Bookings are 1 hr slots with no overlaps allowed.
    * you are free to make assumptions. pls document them.

## Assumptions
  * Authentication providers (Open Socials)
    * Facebook
    * Google+
    * Twitter

  * Bookings
    * Tennis court booking daily schedules for the calendar year shall be generated at least 6 months earlier.
    * Administrator can mark a particular date where tennis court unavailable due to the following:
      * Holiday
      * Scheduled Renovation
      * Unexpected events
    * User/Customer Capabilities upon booking
      * Add
      * View/Search
      * Cancel - Can cancel only the slot reserved by the same user

## Data Structure Design
  * DB
    * Booking
      * id - primary key ( Unique record for tennis court date schedule )
      * date - (Unique date)
      * Hour - Hourly slot
      * ReserveeId - User who reserved the slot (e.g. Fabebook, Google, Twitter, etc)
      * ReserveeDesc - Additional details of the users.
      * status - (1 - Reserved, 0 - Available, -1 -Closed )
      * tstamp - datetime record updated
    * BookingTemplate
      * Hour - Hourly slot



## Deployment using Docker
  * Build images
  * Run containers
    * DB - MySQL service
    * Web Server - NodeJS webapp service
    * REST API - Python Flask RESTFul service

