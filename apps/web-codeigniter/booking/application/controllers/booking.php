<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Booking extends CI_Controller {

    public function index() {

    }

    public function register($name) {
        echo "<br>register is underconstruction.";
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

}
?>