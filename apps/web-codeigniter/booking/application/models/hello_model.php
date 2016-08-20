<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  Hello_model
*/
class Hello_model extends CI_Model
{

    public function getProfile($name) {

        return array( "fullname" => "bernard Traquena", "age" => 38 , "address" => "singapore");
    }
}

?>