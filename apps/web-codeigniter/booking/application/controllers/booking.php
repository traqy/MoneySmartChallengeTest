<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function index() {
        $this->home();
    }


    public function home($method=NULL){

        $this->load->library('session');

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
            $data['session_email'] = $session_email;
        
            $date = $this->input->post('date');
            $this->load->model("booking_model","model");


            if ( $method == 'viewSlotsByDate' ) {

                $data['date'] = $date;
                if (!empty($date)){
                    $data['date'] = $date;
                    $data['date_slots'] = $this->model->viewSlotByDate($date);
                    $this->load->view('booking_view_slots_by_date',$data);
                }
            }
            elseif ( $method == 'logout' ) {
                $this->logout();
            }
            elseif ( $method == 'login' ) {
                $this->login();
            }
            elseif ( $method == 'reserveForm' ) {
                $hourly_slot = $this->input->post('hourly_slot');
                $reservee_id = $this->input->post('reservee_id');

                $data['date'] = $date;
                $data['hourly_slot'] = $hourly_slot;
                $data['reservee_id'] = $reservee_id;
                $data['session_email'] = $session_email;
                $this->load->view('booking_reserve_slot_form', $data);
            }
            elseif ( $method == 'reserveSlot' ) {
                $hourly_slot = $this->input->post('hourly_slot');
                $reservee_id = $this->input->post('reservee_id');
                $reservee_comment = $this->input->post('reservee_comment');

                $this->load->model("booking_model","model");
                $response = $this->model->reserveSlot($date, $hourly_slot,$reservee_id, $reservee_comment);
                //var_dump($response);

                $jo = json_decode(trim($response),TRUE);
                $status = $jo['reserveByDateSlot']['status'];
                if ($status == 'success'){
                    $data['message'] = "You have successfully booked slot $date:$hourly_slot.";
                    $this->load->view('booking_view_slots_by_date',$data);
                }
                else{
                    $data['date'] = $date;
                    $data['hourly_slot'] = $hourly_slot;
                    $data['reservee_id'] = $reservee_id;

                    $status_message =  $jo['reserveByDateSlot']['message'];
                    $data['message'] = "$date:$hourly_slot: $status_message";
                    //$this->load->view('booking_reserve_slot_form', $data);
                    $this->load->view('booking_view_slots_by_date',$data);
                }
            
            }else{
                $this->load->view('booking_home', $data);
            }
        }
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
                $this->session->set_userdata('session_email', $email);
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
            $this->load->view('booking_register_user', $data);

            /*
            $jo_response = json_decode($response);
            $status = $jo_response['register']['status'];
            if ($status == "failed" || $status == "error"){
                $data['message'] = $jo_response['register']['message'];
                $this->load->view('booking_signup', $data);
            }
            else{
                $data['response'] = $jo_response['register'];
                $this->load->view('booking_login', $data);
            }
            */
        }
        
    }

    public function signup(){

        $this->load->view('booking_signup');

    }

}
?>