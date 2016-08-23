<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/utils.php');

class Booking extends CI_Controller {


    public function index() {
        $this->home();
    }

    public function viewSlotsByDate(){
        $this->home();
    }

    public function home($method=NULL){

        $this->load->library('session');

        $this->load->helper('url');

        $session_email = $this->session->userdata('session_email');
        if (!isset($session_email)){
            if ( $method == 'signup' ) {
                $this->signup();
            }
            else{
                echo "You are not logged in.";
                $this->onlogin();
            }
        }
        else{
            $access_level = $this->session->userdata('access_level');

            $data['session_email'] = $session_email;
            $data['access_level'] = $access_level;
        
            # load post variable parameters
            $date = $this->input->post('date');
            $action = $this->input->post('submit');

            $this->load->model("booking_model","model");

            $data['hour_label_map'] = Utils::getHourLabelMapping();

            //if ( $method == 'viewSlotsByDate' ) {
            if ( $action == 'ShowDateSlots' ) {
                $data['date'] = $date;
                if (!empty($date)){
                    $data['date'] = $date;
                    $data['session_email'] = $session_email;

                    $response = $this->model->viewSlotByDate($date);
                    $data['date_slots'] = $response;
                    $this->load->view('booking_home',$data);
                }
            }
            elseif ( $action == 'Book' ) {
                $hourly_slot = $this->input->post('hourly_slot');
                $reservee_id = $this->input->post('reservee_id');
                
                $data['date'] = $date;
                $data['hourly_slot'] = $hourly_slot;
                $data['reservee_id'] = $reservee_id;
                $data['session_email'] = $session_email;

                $this->load->view('booking_reserve_slot_form', $data);
            }
            elseif ( $action == 'Close' ) {
                $hourly_slot = $this->input->post('hourly_slot');
                $reservee_id = $this->input->post('reservee_id');

                $response = $this->model->close($date, $hourly_slot, $session_email);
                
                $data['date'] = $date;
                $data['hourly_slot'] = $hourly_slot;
                $data['reservee_id'] = $reservee_id;
                $data['session_email'] = $session_email;
                $jo = json_decode(trim($response),TRUE);
                $data['message'] = $jo['closeByDateHourlySlot']['message'];

                $response = $this->model->viewSlotByDate($date);                
                $data['date_slots'] = $response;

                $this->load->view('booking_home', $data);
            }
            elseif ($action == "Cancel"){
                $hourly_slot = $this->input->post('hourly_slot');
                $reservee_id = $this->input->post('reservee_id');

                $response = $this->model->cancel($date, $hourly_slot, $session_email);

                $jo = json_decode(trim($response),TRUE);
                $data['date'] = $date;
                $data['hourly_slot'] = $hourly_slot;
                $data['reservee_id'] = $reservee_id;
                $data['session_email'] = $session_email;
                $data['message'] = $jo['cancelByDateHourlySlot']['message'];

                $response = $this->model->viewSlotByDate($date);                
                $data['date'] = $date;
                $data['date_slots'] = $response;

                $this->load->view('booking_home',$data);

            }
            elseif ($action == "Open"){
                $hourly_slot = $this->input->post('hourly_slot');
                $reservee_id = $this->input->post('reservee_id');

                $response = $this->model->open($date, $hourly_slot, $session_email);

                $jo = json_decode(trim($response),TRUE);
                $data['date'] = $date;
                $data['hourly_slot'] = $hourly_slot;
                $data['reservee_id'] = $reservee_id;
                $data['session_email'] = $session_email;
                $data['message'] = $jo['openByDateHourlySlot']['message'];

                $response = $this->model->viewSlotByDate($date);                
                $data['date'] = $date;
                $data['date_slots'] = $response;

                $this->load->view('booking_home',$data);

            }            
            elseif ( $action == 'Update' ) {
                $hourly_slot = $this->input->post('hourly_slot');
                $reservee_id = $this->input->post('reservee_id');
                $reservee_comment = $this->input->post('reservee_comment');

                $this->load->model("booking_model","model");
                $response = $this->model->reserveSlot($date, $hourly_slot,$reservee_id, $reservee_comment);

                $jo = json_decode(trim($response),TRUE);
                $status = $jo['reserveByDateSlot']['status'];
                if ($status == 'success'){
                    $data['message'] = "You have successfully booked slot $date:$hourly_slot.";

                    if (!isset($date)){
                        $date = date("Y-m-d");
                    }

                    $response = $this->model->viewSlotByDate($date);

                    $data['date'] = $date;
                    $data['date_slots'] = $response;
                    $data['hourly_slot'] = $hourly_slot;
                    $data['reservee_id'] = $reservee_id;

                    $this->load->view('booking_home',$data);
                }
                else{
                    $data['date'] = $date;
                    $data['hourly_slot'] = $hourly_slot;
                    $data['reservee_id'] = $reservee_id;

                    $status_message =  $jo['reserveByDateSlot']['message'];
                    $data['message'] = "$date:$hourly_slot: $status_message";
                    $this->load->view('booking_home',$data);
                }
            
            }else{
                # default current date view slots
                if (!isset($date)){
                    $date = date("Y-m-d");
                }
                $data['date'] = $date;
                $data['session_email'] = $session_email;

                $response = $this->model->viewSlotByDate($date);
                $data['date_slots'] = $response;

                $this->load->view('booking_home', $data);
            }
        }
    }


    public function cancel(){

        $this->load->library('session');

        $this->load->helper('url');

        $session_email = $this->session->userdata('session_email');
        if (!isset($session_email)){
            if ( $method == 'signup' ) {
                $this->signup();
            }
            else{
                echo "You are not logged in.";
                $this->onlogin();
            }
        }
        else{

            $access_level = $this->session->userdata('access_level');

            $data['session_email'] = $session_email;
            $data['access_level'] = $access_level;
        
            $date = $this->input->post('date');
            $hourly_slot = $this->input->post('hourly_slot');

            $this->load->model("booking_model","model");

            $this->model->cancel($date, $hourly_slot, $email);

        }
    }

    public function openslot($param=NULL){

        echo "TODO-reopen slot.";

    }

    public function onlogin(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->load->view('booking_user_onlogin');
    }

    public function login(){

        $this->load->library('session');

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if (! isset($email) || !isset($password)){
            //$data['message'] = "Email or Password is empty.";
            $data['message'] = "";
            $this->load->view('booking_user_onlogin', $data);
        }
        elseif ( empty($email) ){
            $data['message'] = "Email is empty. Please enter your email.";
            $this->load->view('booking_user_onlogin', $data);
        }
        elseif ( empty($password) ){
            $data['message'] = "Password is empty. Please enter your password.";
            $this->load->view('booking_user_onlogin', $data);
        }
        else{
            $data['message'] = "$email:$password";
            
            $this->load->model("booking_model","model");

            $response = $this->model->login($email, $password);

            $jo = json_decode(trim($response),TRUE);
            #var_dump($jo);

            $message = $jo['login']['message'];
            $status =  $jo['login']['status'];
            $data['message'] = $message;

            if ($status == "failed" || $status == "error"){
                $data['message'] = $message;
                $this->load->view('booking_user_onlogin', $data);
            }else{

                $this->load->library('session');

                $access_level =  $jo['login']['access_level'];

                $this->session->set_userdata('session_email', $email);
                $this->session->set_userdata('access_level', $access_level);

                $this->home();
            }
        }

    }

    public function logout(){
        $this->load->library('session');

        $this->session->unset_userdata('session_email');

        $this->session->sess_destroy();

        $this->login();
    }

    public function register() {


        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
            

        if (! isset($email) || !isset($password)){
            $data['message'] = "Email or Password is empty.";
            $this->load->view('booking_signup', $data);
        }
        elseif ( empty($email) ){
            $data['message'] = "Email is empty. Please try again.";
            $this->load->view('booking_signup', $data);
        }
        elseif ( empty($password) ){
            $data['message'] = "Password is empty. Please try again.";
            $this->load->view('booking_signup', $data);
        }
        else{
            $this->load->model("booking_model","model");

            $response = $this->model->register($email, $password, $firstname, $lastname);

            $jo = json_decode(trim($response),TRUE);

            $message = $jo['register']['message'];
            $data['message'] = $message;
            $status = $jo['register']['status'];

            //$this->load->view('booking_register_user', $data);

            if ($status == "failed" || $status == "error"){
                $data['message'] = $message;
                $this->load->view('booking_signup', $data);
            }
            else{
                $data['message'] = $message;
                $this->load->view('booking_user_onlogin', $data);
            }
            
        }
        
    }

    public function signup(){

        $this->load->view('booking_signup');

    }

}
?>