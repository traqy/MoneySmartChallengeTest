<?php

$service_url = 'http://192.168.99.100:5000/mini-app-booking-ds/api/user/showdateslots';
$ch = curl_init( $service_url );
# Setup request to send json via POST.
$payload = json_encode( array( "Date"=> "2016-09-01" ) );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);
# Print response.
echo "<pre>$result</pre>";