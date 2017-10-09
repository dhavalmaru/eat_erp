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
            }
        }

        echo json_encode($data);
    }

}
?>