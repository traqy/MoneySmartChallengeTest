<?php
    $date = '2016-08-18';
    $url = "http://192.168.99.100:5000/mini-app-booking-ds/api";
    $service_url = "$url/user/showdateslots";
    $ch = curl_init($service_url);
     
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    $data = array( "Date" => $date );
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    $response = curl_exec($ch);
    if ($response === false) {
        $info = curl_getinfo($ch);
        curl_close($ch);
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($ch);
    $decoded = json_decode($response);
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
        die('error occured: ' . $decoded->response->errormessage);
    }
    print_r($decoded);
?>