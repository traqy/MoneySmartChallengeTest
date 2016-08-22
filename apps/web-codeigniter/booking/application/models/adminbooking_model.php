<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  Hello_model
*/
class Adminbooking_model extends CI_Model
{


    public function generate($email, $datefrom, $dateto){

        $rest_url_path = "admin/generate";
        $method = "POST";
        $payload = json_encode( array( "UserId" => $email, "dateFrom" => $datefrom, "dateTo" => $dateto ) );
        $result = $this->api_booking_rest_call($rest_url_path, $method, $payload);
        return $result;

    }

    private function api_booking_rest_call($urlpath, $method, $payload){

        /*
            urlpath - '/user/showdateslots'
            method -> GET, POST, PUT
            payload -> json encoded string
        */

        $service_url = "http://192.168.99.100:5000/mini-app-booking-ds/api/$urlpath";
        $ch = curl_init( $service_url );
        # Setup request to send json via POST.
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        #echo "<pre>$result</pre>";        
        return $result;
    }

}