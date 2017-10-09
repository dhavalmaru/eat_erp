<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_route_plan extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_route_plan_model');
        $this->load->model('sales_rep_distributor_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_route_plan_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['sales_rep_id']=$this->session->userdata('sales_rep_id');

            load_view('sales_rep_route_plan/sales_rep_route_plan', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    
    public function get_route_plan(){
        $data = null;
        $query=$this->sales_rep_route_plan_model->get_route_plan();
        if(count($query)>0) {
            for($i=0; $i<count($query); $i++){
                $data[$i]['id'] = $query[$i]->id;
                $data[$i]['sales_rep_id'] = $query[$i]->sales_rep_id;
                $data[$i]['date_of_visit'] = $query[$i]->modified_on;
                $data[$i]['area'] = $query[$i]->area;
                $data[$i]['area_lat'] = $query[$i]->area_lat;
                $data[$i]['area_long'] = $query[$i]->area_long;
                $data[$i]['distributor_name'] = $query[$i]->distributor_name;
                $data[$i]['dist_lat'] = $query[$i]->dist_lat;
                $data[$i]['dist_long'] = $query[$i]->dist_long;
                $data[$i]['mdate'] = $query[$i]->mdate;
            }
        }

        echo json_encode($data);
    }


    public function get_route_plan_email(){
        $data = null;
        $query=$this->sales_rep_route_plan_model->get_route_plan_email();
        $body="<table><th>Sr. No</th><th>Name</th><th>Area</th><th>Location</th><th>Date</th>";
        if(count($query)>0) {
            for($i=0; $i<count($query); $i++){
                $data[$i]['id'] = $query[$i]->id;
                $data[$i]['sales_rep_id'] = $query[$i]->sales_rep_id;
                $data[$i]['date_of_visit'] = $query[$i]->modified_on;
                $data[$i]['area'] = $query[$i]->area;
                $data[$i]['area_lat'] = $query[$i]->area_lat;
                $data[$i]['area_long'] = $query[$i]->area_long;
                $data[$i]['distributor_name'] = $query[$i]->distributor_name;
                $data[$i]['dist_lat'] = $query[$i]->dist_lat;
                $data[$i]['dist_long'] = $query[$i]->dist_long;
                $data[$i]['mdate'] = $query[$i]->mdate;
                $data[$i]['sales_rep_name'] = $query[$i]->sales_rep_name;
                $body=$body+$data[$i]['sales_rep_name'];
				echo $data[$i]['sales_rep_name'];
            }

            echo $body;

            $CI =& get_instance();

            $from_email = 'webmaster@eatanytime.in';

            //configure email settings
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'mail.eatanytime.in'; //smtp host name
            $config['smtp_port'] = '25'; //smtp port number
            $config['smtp_user'] = "webmaster@eatanytime.in";
            $config['smtp_pass'] = '55921721dNM@'; //$from_email password
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n"; //use double quotes
            $CI->email->initialize($config);

            //send mail
            $CI->email->from($from_email,"EAT Anytime");
            $CI->email->to("dhaval.maru@otbconsulting.co.in");
            // $CI->email->to('prasad.bhisale@otbconsulting.co.in');
            $CI->email->subject("Sales Representative Route Plan as on ".date('d/m/y')."");
            $CI->email->message("Hi,<br><br>Please find below the details of Route Plan<br><br><img src='http://maps.googleapis.com/maps/api/staticmap?size=400x400&path=40.737102,-73.990318|40.749825,-73.987963|40.752946,-73.987384|40.755823,-73.986397&sensor=false' />");
            $CI->email->set_mailtype("html");
            // $CI->email->send();
        }

        // echo json_encode($data);
    }

}
?>