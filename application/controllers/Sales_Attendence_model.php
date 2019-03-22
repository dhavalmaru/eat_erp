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

public function sales_attendence_list()
{

	$sql = "Select Sum(Case When emp_time='L' Then 1 else 0 end ) as late_mark_count ,sum(Case When emp_time='O' Then 1 else 0 end) as on_time_count,zone,
		sum(Case When working_status='Absent' Then 1 Else 0 end) as absent_count, sum(Case When working_status='Present' Then 1 Else 0 end) as present_count from 
		(
		Select A.id as sales_rep_id,check_in_time,A.zone,Case When (B.check_in_time is null || working_status='Absent') Then 'Absent' Else 'Present' end as working_status,
		Case When CAST(check_in_time As Time)>CAST('10:00:00' As Time) AND CAST(check_in_time As Time)<CAST('11:00:00' As Time )  AND check_in_time IS NOT NULL Then 'L'
		When  check_in_time IS NULL Then 'A' else 'O' end as  emp_time   from 
		(Select * from sales_rep_master Where status='Approved' and sr_type is not null and sr_type!='') A
		Left Join
		(Select sales_rep_id,check_in_time,working_status from sales_attendence Where  date(check_in_time)=date(now())) B
		On A.id=B.sales_rep_id
		) A Group By zone";

	$result = $this->db->query($sql)->result();
	return $result;

}

public function sales_absent_attendence($value='')
{

	$sql = "Select A.id as sales_rep_id,sales_rep_name,check_in_time,A.zone,causual_remark as remark from 
			(Select * from sales_rep_master Where status='Approved' and sr_type is not null and sr_type!='') A
			Left Join
			(Select sales_rep_id,check_in_time,working_status,causual_remark from sales_attendence Where  date(check_in_time)=date(now())) B
			On A.id=B.sales_rep_id
			Where B.check_in_time is null OR working_status='Absent'";

	$result = $this->db->query($sql)->result();
	return $result;

}

public function user_login_list()
{
		$now=date('Y-m-d');
		echo $prev_date = date('Y-m-d', strtotime($now .' -15 day'));
	$sql = "select concat(A.first_name,' ', A.last_name) as user_name,A.email_id, B.date from
(select distinct(user_id),max(date) as date from user_access_log where date(date) BETWEEN '".$prev_date."' AND date(now()) and date!='NULL' and user_id!='NULL' GROUP by user_id) B
left JOIN
(SELECT * FROM `user_master`)A
on(A.id=B.user_id)";

	$result = $this->db->query($sql)->result();
	return $result;

}



}
?>
