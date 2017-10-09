<?php 
if(! defined ('BASEPATH') ){exit('No direct script access allowed');}

class City_master extends CI_controller{

	 function __construct(){
		parent :: __construct();
        $this->load->helper('common_functions');
		$this->load->model('city_master_model');
	}

	function index(){
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM user_role_options");
        $result=$query->result();
        if(count($result)>0) {
            $result[0]->r_export=1;
            $data['access']=$result;
			$data['city_details']=$this->city_master_model->getCityDetails();
			load_view('city_master/city_master_list',$data);
		}

        // $data['access'][0]->r_export=1;
        // $data['city_details']=$this->city_master_model->getCityDetails();
        // load_view('city_master/city_master_list',$data);
	}

	function  city_edit(){
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');
        $data['state_list']=$this->city_master_model->getStateList();

        // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Tax' AND role_id='$roleid'");
        // $result=$query->result();
        // if(count($result)>0) {
        //     if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
        //         $data['access']=$result;

				$city_id=$this->uri->segment(3);
				if($city_id !=''){
				$data['city_details']=$this->city_master_model->getCityDetails($city_id);
				}
				$data['action']='edit_insert';
				//print_r($data);
				load_view('city_master/city_master_view',$data);
        //     // } else {
        //     //     echo "Unauthorized access";
        //     // }
        // } else {
        //     echo 'You donot have access to this page';
        // }
	}

	function city_view(){
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');

        // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Tax' AND role_id='$roleid'");
        // $result=$query->result();
        // if(count($result)>0) {
        //     if($result[0]->r_view==1 ) {
        //         $data['access']=$result;

                $city_id=$this->uri->segment(3);
                $data['city_details']=$this->city_master_model->getCityDetails($city_id);
				
				$data['action']='view';

				load_view('city_master/city_master_view',$data);
        //     } else {
        //         echo "Unauthorized access";
        //     }
        // } else {
        //     echo 'You donot have access to this page';
        // }
	}

	function insertUpdateRecord(){
		$response=$this->city_master_model->insertUpdateRecord();
		redirect('city_master','refresh');
	}

    function delete_record(){
        $response=$this->city_master_model->delete_record();
        redirect('city_master','refresh');
        
    }


    function checkTaxNameAvailability() {
        $tax_id = html_escape($this->input->post('tax_id'));
        $tax_name = html_escape($this->input->post('tax_name'));

        $query = $this->db->query("SELECT * FROM tax_master WHERE tax_id != '$tax_id' AND tax_name = '$tax_name'");
        if($query->num_rows()!=0){
            echo 1;
        } else {
            echo 0;
        }
    }


}
?>