<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hello extends CI_Controller {

    public function index() {
        echo "This is my index function.";
    }

    public function one($name=NULL) {

        $this->load->model("hello_model");

        $profile = $this->hello_model->getProfile("Bernard");
        
        $this->load->view('header');


        $data = array("name" => $name);
        $data['profile'] = $profile;
        $this->load->view('one', $data);
    }

    public function two($p1,$p2){
        echo "<br>This is the two methoid";
        echo "<br>These are the params: $p1, $p2";

    }
}
?>