<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Booking extends CI_Controller {

    public function index() {

    }

    public function home(){
        $this->load->view('booking_home');
    }
    public function onlogin(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->load->view('booking_user_onlogin');
    }

    public function login(){
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
                $this->load->view('booking_home', $data);
            }
        }

    }

    public function register() {


        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        //echo $email;

            

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

    public function view($p_type, $date) {

        $this->load->model("booking_model","model");

        if ( $p_type == 'viewSlotByDate' ) {

            $data['date'] = $date;
            $data['date_slots'] = $this->model->viewSlotByDate($date);

            $this->load->view('booking_view_by_date_slots',$data);
        }
        else{
            echo "TODO";
        }
    }

    public function signup(){

        $this->load->view('booking_signup');

    }

}
?>