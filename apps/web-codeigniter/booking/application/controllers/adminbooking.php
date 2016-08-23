<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/utils.php');
require_once(APPPATH.'libraries/router.php');

include_once (dirname(__FILE__) . "/booking.php");

class Adminbooking extends CI_Controller {

    public function index() {
        echo "This admin index page.";
    }

    public function home(){

        $this->load->helper('html','url','assets');

        $this->load->library('session');

        $datefrom = $this->input->post('datefrom');
        $dateto = $this->input->post('dateto');

        
        $session_email = $this->session->userdata('session_email');
        if (!isset($session_email)){
            // redirect to Booking login
            echo "Booking->logout";
            $this->logout();
        }else{
            $access_level = $this->session->userdata('access_level');

            // tentatively direct home -> to manage page
            $this->manage();
        }

    }

    public function manage($method=NULL){

        $this->load->helper('html','url','assets');

        $this->load->library('session');
        
        $session_email = $this->session->userdata('session_email');
        $access_level = $this->session->userdata('access_level');
        if (!isset($session_email)){
            if ( $method == 'signup' ) {
                $this->signup();
            }
            else{
                echo "You are not logged in.";
            }
        }else{
            $access_level = $this->session->userdata('access_level');
            if ( $access_level != 2 ){
                echo "Permission denied.";
            }
            else{
                $data['session_email']=$session_email;
                $data['access_level'] = $access_level;

                $this->load->helper('url');

                $this->load->view('admin_manage_schedule', $data);
            }
        }

    }

    public function generate(){

        $this->load->helper('html','url','assets');

        $this->load->library('session');

        $datefrom = $this->input->post('datefrom');
        $dateto = $this->input->post('dateto');

        
        $session_email = $this->session->userdata('session_email');
        if (!isset($session_email)){
            if ( $method == 'signup' ) {
                $this->signup();
            }
            else{
                echo "You are not logged in.";
                $this->onlogin();
            }
        }else{
            $access_level = $this->session->userdata('access_level');
            if ( $access_level != 2 ){
                echo "Permission denied.";
            }
            else{

                $this->load->model("adminbooking_model","model");

                $access_level = $this->session->userdata('access_level');

                $response = $this->model->generate($session_email, $datefrom, $dateto);
                $jo = json_decode(trim($response),TRUE);
                $array_dates = $jo['adminGenerateFutureDateHourlySlots'];
                $data['dates'] = $array_dates;
                $data['session_email'] = $session_email;
                $data['access_level'] = $access_level;

                $this->load->helper('url');
                $this->load->view('admin_manage_schedule', $data);
            }
        }        
    }

}
?>