#!/bin/bash


/etc/init.d/apache2 restart
a2enmod rewrite
/etc/init.d/apache2 restart


/etc/init.d/tinc restart