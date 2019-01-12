<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Attendence_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

public function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

public function get_employee_code()
{
	$result = $this->db->select('*')->get('user_master')->result();
	return $result;
}

public function get_employee_attendence($emp_no,$year,$month)
{	
	/*$emp_code = $this->input->post('emp_code');
	$year = $this->input->post('freezed_year');*/
	$month_date = intval(date('m',strtotime($month)));
	$where = array("emp_no"=>$emp_no,"MONTH(date)"=>$month_date,"YEAR(date)"=>$year);
	/*$result = $this->db->select("*")->get("employee_attendence")->result();*/
	$sql = "Select A.*,B.email_id,Case When Late_marks='L' Then (@cnt := @cnt + 1)  End as Late_marks_count,
		Case When Late_marks='L' AND @cnt>3 AND effective_time>=10 THEN 0.66 
		When Late_marks='L' AND @cnt>3 AND effective_time<10 THEN 0.5
		When Late_marks='H' THEN 0.5
		When Late_marks='N' AND (emp_status='Absent') THEN 0.00
		ELSE 1
		end as adjusted_time from 
		(SELECT *,
		Case 
		When emp_status='WeeklyOff' THEN 'WeeklyOff' 
		When emp_status='Absent' THEN 'Absent' 
		When emp_status='Present' Then (last_out-first_in) end as effective_time,
		Case When CAST(first_in As Time)>CAST('10:00:00' As Time) AND CAST(first_in As Time)<CAST('11:00:00' As Time)  Then 'L' 
		When CAST(first_in As Time)>CAST('11:00:00' As Time) Then 'H' 
		Else 'N' End as Late_marks
		from employee_attendence Where emp_no='OTBLLP00001' and MONTH(date)='9' and YEAR(date)='2018' ORDER BY date ASC) A
		CROSS JOIN (SELECT @cnt := 0) AS dummy
		left JOIN
		(SELECT emp_code,email_id from user_master) B on A.emp_no=B.emp_code";
	$result = $this->db->query($sql)->result();
	return $result;
}

public function attendence_list()
{
		$sql = "select C.emp_no, C.month_no,C.emp_name,C.`year`, case when D.status is null then 'Pending' when C.status='bal' then 'Balance Approval' else 'Done' end as status from 
	        (select A.emp_no, A.month_no, B.status,B.emp_name,B.year from 
	        (select emp_no,emp_name, month(date) as month_no,YEAR(date) as `year` from  employee_attendence Where YEAR(date)='2018' and month(date)=8  group by emp_no,emp_name, month(date),YEAR(date)) A 
	        left join 
	        (select emp_no,emp_name, month(date) as month_no, 'bal' as status,YEAR(date) as `year` from employee_attendence where status is null and YEAR(date)='2018' and month(date)=8  group by emp_no,emp_name, month(date),YEAR(date)) B 
	        on (A.emp_no=B.emp_no and A.month_no=B.month_no)) C 
	        left join 
	        (select emp_no,emp_name, month(date) as month_no, 'done' as status,YEAR(date) as `year` from employee_attendence where status is not null and  YEAR(date)='2018' and month(date)=8 group by emp_no,emp_name, month(date),YEAR(date)) D 
	        on (C.emp_no=D.emp_no and C.month_no=D.month_no)";

		$result = $this->db->query($sql)->result();

		return $result;
}


}
?>
