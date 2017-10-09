<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_location extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_location_model');
        $this->load->model('sales_rep_distributor_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_location_model->get_data();

            load_view('sales_rep_location/sales_rep_location_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_location_model->get_access();
                $data['distributor'] = $this->sales_rep_distributor_model->get_data1('Approved');

                load_view('sales_rep_location/sales_rep_location_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->sales_rep_location_model->get_data('', $id);
                $data['data1'] = $this->sales_rep_location_model->get_data_qty('', $id);
                $data['distributor'] = $this->sales_rep_distributor_model->get_data('Approved');

                load_view('sales_rep_location/sales_rep_location_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save($id=""){
       if($this->input->post('srld') == "Place Order") {
            if($id == ""){
                $this->sales_rep_location_model->save_data('','Place Order');
            } else {
                $this->sales_rep_location_model->save_data($id, 'Place Order');
            }
        }
        else if($this->input->post('srld') == "Follow Up") {
            if($id == ""){
                $this->sales_rep_location_model->save_data('','Follow Up');
            } else {
                $this->sales_rep_location_model->save_data($id,'Follow Up');
            }
        }
        else {
            if($id == ""){
                $this->sales_rep_location_model->save_data('','Not Interested');
            } else {
                $this->sales_rep_location_model->save_data($id,'Not Interested');
            }
        }

        if($this->input->post('srld') == "Place Order") {
            if($this->input->post('distributor_type')=="Old"){
                $id = $this->input->post('distributor_id');
                redirect(base_url().'index.php/Sales_rep_order/add_order/'.$id);
            } else {
                $result=$this->sales_rep_distributor_model->get_access();
                if(count($result)>0) {
                    if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                        $data['access'] = $result;
                        $data['distributor_name'] = $this->input->post('distributor_name');
                        load_view('sales_rep_distributor/sales_rep_distributor_details', $data);
                    }
                } 
            }
        }
        else {
            redirect(base_url().'index.php/sales_rep_location');
        }
        
    }

    public function check_date_of_visit(){
        $result = $this->sales_rep_location_model->check_date_of_visit();
        echo $result;
    }

    public function get_location(){
        $data = null;
        $query=$this->sales_rep_location_model->get_location();
        if(count($query)>0) {
            for($i=0; $i<count($query); $i++){
                $data[$i]['id'] = $query[$i]->id;
                $data[$i]['sales_rep_id'] = $query[$i]->sales_rep_id;
                $data[$i]['date_of_visit'] = $query[$i]->date_of_visit;
                $data[$i]['sales_rep_name'] = $query[$i]->sales_rep_name;
                $data[$i]['store_name'] = $query[$i]->store_name;
                $data[$i]['login_time'] = $query[$i]->modified_on;
                $data[$i]['login_latitude'] = $query[$i]->latitude;
                $data[$i]['login_longitude'] = $query[$i]->longitude;
                $data[$i]['logout_time'] = $query[$i]->logout_time;
                $data[$i]['logout_latitude'] = $query[$i]->logout_latitude;
                $data[$i]['logout_longitude'] = $query[$i]->logout_longitude;
            }
        }

        echo json_encode($data);
    }

}
?>