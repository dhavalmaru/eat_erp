<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Pincode_master_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
	$this->load->model('user_access_log_model');
}
function getPincodeDetails($id='', $start='', $length=''){
	$this->db->select('a.id id,a.pincode,b.state_name,a.state_id');
	if($id !=''){
		$this->db->where('a.id = '.$id.' ');
	}
	$this->db->where('a.status = "1" and b.id = a.state_id ');
	$this->db->from('pincode_master a, state_master b');
	$this->db->order_by('pincode', 'asc');
	if($start!='' && $length!=''){
		$this->db->limit($length, $start);
	}
	$result=$this->db->get();
	//echo $this->db->last_query();
	return $result->result();
}

function getStateList(){
	$this->db->select('id,state_name');
	$this->db->from('state_master');
	$this->db->where('status = 1');
	$result=$this->db->get();
	return $result->result();
}

function insertUpdateRecord(){
	$pincode=$this->input->post('pincode');
	$state_id=$this->input->post('state_name');
	$id=$this->input->post('id');
	$gid=$this->session->userdata('groupid');
	$i=0;

	
		if($id !='' ){
			$update_array=array(
				"pincode" => $pincode,
				"state_id"=> $state_id,
				"modified_by"=>$this->session->userdata('session_id'),
				"modified_on"=>date('Y-m-d h:i:s'),
				"status"=>'1'
			);
			$this->db->where('id = '.$id.' and status="1" ');
			$this->db->update('pincode_master',$update_array);

			$logarray['table_id']=$id;
	        $logarray['module_name']='Pincode';
	        $logarray['cnt_name']='Pincode';
	        $logarray['action']='Pincode Record Updated';
	        $this->user_access_log_model->insertAccessLog($logarray);
			//exit;
		} else {
			$insert_array=array(
				"pincode" => $pincode,
				"state_id"=> $state_id,
				"created_by"=>$this->session->userdata('session_id'),
				"created_on"=>date('Y-m-d h:i:s'),
				"status"=>'1'
			);
			$this->db->insert('pincode_master',$insert_array);
			$logarray['table_id']=$this->db->insert_id();
	        $logarray['module_name']='Pincode';
	        $logarray['cnt_name']='Pincode';
	        $logarray['action']='Pincode Record Inserted';
	        $this->user_access_log_model->insertAccessLog($logarray);
		}
		
	//return true;
}

function delete_record(){
	$gid=$this->session->userdata('groupid');
	$id=$this->uri->segment(3);
	$this->db->select('id');
	$this->db->from('pincode_master');
	$this->db->where('id = '.$id.' and status = 1 ');
	$result=$this->db->get();

	if($result->num_rows() > 0){
		$update_sql="update pincode_master set status = 3, g_id='$gid' where id =".$id;
		$this->db->query($update_sql);

		$logarray['table_id']=$id;
        $logarray['module_name']='Pincode';
        $logarray['cnt_name']='Pincode';
        $logarray['action']='Pincode Record Deleted';
        $this->user_access_log_model->insertAccessLog($logarray);
	}
	else{
		echo "<script>alert('No record Found')</script>";
	}
}

}
?>