<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Category_master_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
	$this->load->model('user_access_log_model');
}
function getCategoryDetails($category_id=''){
	$this->db->select('id ,category_name');
	if($category_id !=''){
		$this->db->where('id = '.$category_id.' ');
	}
	$this->db->where('status = "1" and is_deleted=1');
	$result=$this->db->get('category_master');
	//echo $this->db->last_query();
	return $result->result();
}


function insertUpdateRecord(){
	$category_name=$this->input->post('category_name');
	$category_id=$this->input->post('category_id');

	if($category_id!="")
	{
		$insert_array=array(
			"category_name" => $category_name,
			"modified_by"=>$this->session->userdata('session_id'),
			"modified_on"=>date('Y-m-d h:i:s'),
		);

		$this->db->where('id',$category_id)->update('category_master',$insert_array);
		$logarray['table_id']=$category_id;
	    $logarray['module_name']='Category';
	    $logarray['cnt_name']='Category';
	    $logarray['action']='Category Record Updated';
	    $this->user_access_log_model->insertAccessLog($logarray);
	}
	else
	{
	    $insert_array=array(
			"category_name" => $category_name,
			"created_by"=>$this->session->userdata('session_id'),
			"created_on"=>date('Y-m-d h:i:s'),
			"status"=>'1'
		);
		$this->db->insert('category_master',$insert_array);
		$this->db->last_query();
		$logarray['table_id']=$this->db->insert_id();
	    $logarray['module_name']='Category';
	    $logarray['cnt_name']='Category';
	    $logarray['action']='Category Record Inserted';
	    $this->user_access_log_model->insertAccessLog($logarray);
	}

	
		
	//return true;
}

function delete_record($category_id){
	$data = array("is_deleted"=>0);
	$this->db->where("id",$category_id)->update("category_master",$data);
}

}
?>