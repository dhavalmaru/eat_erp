<?php 
if(! defined ('BASEPATH') ){exit('No direct script access allowed');}

class Tax_master extends CI_controller{

	 function __construct(){
		parent :: __construct();
        $this->load->helper('common_functions');
		$this->load->model('tax_master_model');
	}

	function index(){
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Tax' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 ) {
                $data['access']=$result;

				$data['tax_detail']=$this->tax_master_model->getTaxDetail();
				load_view('tax_master/tax_master_list',$data);
			}
		}
	}

	function  tax_edit(){
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Tax' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
                $data['access']=$result;

				$tax_id=$this->uri->segment(3);
				if($tax_id !=''){
				$data['tax_detail']=$this->tax_master_model->getTaxDetail($tax_id);
				}
				$data['action']='edit_insert';
				//print_r($data);
				load_view('tax_master/tax_master_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo 'You donot have access to this page';
        }
	}

	function tax_view(){
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Tax' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 ) {
                $data['access']=$result;

                $tax_id=$this->uri->segment(3);
				$data['tax_detail']=$this->tax_master_model->getTaxDetail($tax_id);
				$data['action']='view';

				load_view('tax_master/tax_master_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo 'You donot have access to this page';
        }
	}

	function insertUpdateRecord(){
		$response=$this->tax_master_model->insertUpdateRecord();
		redirect('Tax_master','refresh');
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