<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_Attendence_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}



public function get_todays_attendence()
{
	$sales_rep_id=$this->session->userdata('sales_rep_id');
	$now1=date('Y-m-d');
	$where = array("date(check_in_time)"=>$now1,
				   "sales_rep_id"=>$sales_rep_id);
	
	$result = $this->db->select("sales_rep_id, working_status, id, check_in_time, check_out_time, check_out")
					->where($where)->get('sales_attendence')->result();
	return $result;
}



}
?>
