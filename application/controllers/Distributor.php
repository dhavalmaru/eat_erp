<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Distributor extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('distributor_model');
        $this->load->model('sales_rep_model');
        $this->load->model('area_model');
        $this->load->model('distributor_type_model');
        $this->load->model('zone_model');
        $this->load->model('location_model');
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->distributor_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->distributor_model->get_data();

        //     load_view('distributor/distributor_list', $data);
        // } else {
        //     echo "You donot have access to this page.";
        // }

        $this->checkstatus();
    }

    public function checkstatus($status=''){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->distributor_model->get_distributor_data($status);

            $count_data=$this->distributor_model->get_distributor_data();
            $active=0;
            $inactive=0;
            $pending=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $active=$active+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING")
                        $pending=$pending+1;
                }
            }

            $data['active']=$active;
            $data['inactive']=$inactive;
            $data['pending']=$pending;
            $data['all']=count($count_data);

            load_view('distributor/distributor_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function locations($status=''){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            
            load_view_without_data('distributor/distributor_loc_map');

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	    public function single_locations($status=''){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            
            load_view_without_data('distributor/distributor_single_loc_map');

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


    public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->distributor_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['product_name'] = $result[0]->distributor_name;
            $data['sell_out'] = $result[0]->sell_out;
            $data['state'] = $result[0]->state;
            $data['state_code'] = $result[0]->state_code;
            $data['sales_rep_id'] = $result[0]->sales_rep_id;
            $data['credit_period'] = $result[0]->credit_period;
            $data['class'] = $result[0]->class;
        }

        echo json_encode($data);
    }

    public function get_distributor_locations(){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            $query=$this->distributor_model->get_data();
            if(count($query)>0) {
                for($i=0; $i<count($query); $i++){
                    $data[$i][0] = $query[$i]->distributor_name;
                    $data[$i][1] = $query[$i]->google_address;
                    $data[$i][2] = 'Location 1 URL';
                }
            }

            echo json_encode($data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	 public function get_distributor_single_locations(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->distributor_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['google_address'] = $result[0]->google_address;
            $data['latitude'] = $result[0]->latitude;
            $data['longitude'] = $result[0]->longitude;
           
        }

        echo json_encode($data);
    }
	

    public function add(){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $result;
                $data['sales_rep'] = $this->sales_rep_model->get_data_dist('Approved');
                $data['area'] = $this->area_model->get_data('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                $data['zone'] = $this->zone_model->get_data('Approved');
                $data['location'] = $this->location_model->get_data('Approved');

                load_view('distributor/distributor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($d_id){
        $result=$this->distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->distributor_model->get_distributor_data('', $d_id);
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
                $data['area'] = $this->area_model->get_data('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                $data['zone'] = $this->zone_model->get_data('Approved');
                $data['location'] = $this->location_model->get_data('Approved');
                if(strrpos($d_id, "d_") !== false){
                    $id = substr($d_id, 2);
                    $data['distributor_contacts'] = $this->distributor_model->get_distributor_contacts($id);
                    $data['distributor_consignee'] = $this->distributor_model->get_distributor_consignee($id);
                }

                load_view('distributor/distributor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->distributor_model->save_data();
        redirect(base_url().'index.php/distributor');
    }

    public function update($id){
        $this->distributor_model->save_data($id);
        redirect(base_url().'index.php/distributor');
    }

    public function check_distributor_availablity(){
        $result = $this->distributor_model->check_distributor_availablity();
        echo $result;
    }

	public function get_zone(){ 
   
    $postData = $this->input->post();

    $data = $this->area_model->get_zone($postData);
    echo json_encode($data); 
	}

	public function get_area(){ 
   
    $postData = $this->input->post();

    $data = $this->location_model->get_area($postData);
    echo json_encode($data); 
	}
	
    public function get_shipping_state() {
        $id=$this->input->post('id');
        // $id=1;
		$data=array();
        $result=$this->distributor_model->get_shipping_state($id);
        if(count($result)>0) {
            $data['state'] = $result[0]->con_state;
            $data['state_code'] = $result[0]->con_state_code;
        }
        // if(count($result)>0) {
        //     $data['result'] = 1;
        //     $data['product_name'] = $result[0]->distributor_name;
        //     $data['sell_out'] = $result[0]->sell_out;
        //     $data['state'] = $result[0]->state;
        //     $data['sales_rep_id'] = $result[0]->sales_rep_id;
        //     $data['credit_period'] = $result[0]->credit_period;
        //     $data['class'] = $result[0]->class;
        // }

        echo json_encode($data);
    }
}
?>