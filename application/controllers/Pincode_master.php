<?php 
if(! defined ('BASEPATH') ){exit('No direct script access allowed');}

class Pincode_master extends CI_controller{

	 function __construct(){
		parent :: __construct();
        $this->load->helper('common_functions');
		$this->load->model('pincode_master_model');
	}

	function index(){
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM user_role_options");
        $result=$query->result();
        if(count($result)>0) {
            $result[0]->r_export=1;
            $data['access']=$result;
            $data['pincode_details']=array();
			// $data['pincode_details']=$this->pincode_master_model->getPincodeDetails();
			load_view('pincode_master/pincode_master_list',$data);
		}

        // $data['access'][0]->r_export=1;
        // $data['pincode_details']=$this->pincode_master_model->getPincodeDetails();
        // load_view('pincode_master/pincode_master_list',$data);
	}

    public function get_data(){
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $cnt=$this->pincode_master_model->getPincodeDetails();
        $r = $this->pincode_master_model->getPincodeDetails('', $start, $length);
        $data = array();

        for($i=0;$i<count($r);$i++){
            $data[] = array(
                        $i+1,
                        '<a href="'.base_url().'index.php/pincode_master/pincode_view/'.$r[$i]->id.'"><i class="fa fa-edit"></i></a>',
                        $r[$i]->pincode,
                        $r[$i]->state_name
                    );
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => count($cnt),
                        "recordsFiltered" => count($cnt),
                        "data" => $data
                        // ,
                        // "columns" => $columns
                    );
        echo json_encode($output);
    }

	function  pincode_edit(){
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');
        $data['state_list']=$this->pincode_master_model->getStateList();

        // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Tax' AND role_id='$roleid'");
        // $result=$query->result();
        // if(count($result)>0) {
        //     if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
        //         $data['access']=$result;

				$pincode_id=$this->uri->segment(3);
				if($pincode_id !=''){
				$data['pincode_details']=$this->pincode_master_model->getPincodeDetails($pincode_id);
				}
				$data['action']='edit_insert';
				//print_r($data);
				load_view('pincode_master/pincode_master_view',$data);
        //     // } else {
        //     //     echo "Unauthorized access";
        //     // }
        // } else {
        //     echo 'You donot have access to this page';
        // }
	}

	function pincode_view(){
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');

        // $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Tax' AND role_id='$roleid'");
        // $result=$query->result();
        // if(count($result)>0) {
        //     if($result[0]->r_view==1 ) {
        //         $data['access']=$result;

                $pincode_id=$this->uri->segment(3);
                $data['pincode_details']=$this->pincode_master_model->getPincodeDetails($pincode_id);
				
				$data['action']='view';

				load_view('pincode_master/pincode_master_view',$data);
        //     } else {
        //         echo "Unauthorized access";
        //     }
        // } else {
        //     echo 'You donot have access to this page';
        // }
	}

	function insertUpdateRecord(){
		$response=$this->pincode_master_model->insertUpdateRecord();
		redirect('pincode_master','refresh');
	}

    function delete_record(){
        $response=$this->pincode_master_model->delete_record();
        redirect('pincode_master','refresh');
        
    }


    function check_pincode_availablity() {
        $id = html_escape($this->input->post('id'));
        $pincode = html_escape($this->input->post('pincode'));

        $query = $this->db->query("SELECT * FROM pincode_master WHERE id != '$id' AND pincode = '$pincode'");
        if($query->num_rows()!=0){
            echo 1;
        } else {
            echo 0;
        }
    }


}
?>