<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Attendence_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

/*public function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}*/

public function get_employee_code()
{
	$result = $this->db->select('*')->get('user_master')->result();
	return $result;
}

public function get_employee_attendence($emp_no,$year,$month)
{	
	/*$emp_code = $this->input->post('emp_code');
	$year = $this->input->post('freezed_year');*/
	/*echo 'month'.$month.'<br>';
	echo 'month_date'.$month_date = intval(date('m',strtotime($month)));*/

	$month_date = $month;
	$where = array("emp_no"=>$emp_no,"MONTH(date)"=>$month_date,"YEAR(date)"=>$year);
	/*$result = $this->db->select("*")->get("employee_attendence")->result();*/
	/*$sql = "Select A.*,B.email_id,Case When Late_marks='L' Then (@cnt := @cnt + 1)  End as Late_marks_count,
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
		from employee_attendence Where emp_no='$emp_no' and MONTH(date)='$month_date' and YEAR(date)='$year' ORDER BY date ASC) A
		CROSS JOIN (SELECT @cnt := 0) AS dummy
		left JOIN
		(SELECT emp_code,email_id from user_master) B on A.emp_no=B.emp_code";*/

		/*A.emp_id,A.emp_no,A.emp_name,A.date,A.`first_in`,A.`last_out`,A.emp_status*/

	/*if($status=='approved')
		{
			$cond= "Where status='$status'";
		}
		else
		{
			$cond = '';
		}*/

	$sql = "Select A.*,B.adjusted_late_marks,B.adjusted_late_marks_count,B.employee_adjusted_time,B.adjusted_effective_time from (Select A.emp_id,A.emp_no,A.emp_name,A.date,A.`first_in`,
		A.`last_out`,A.emp_status,A.status,A.Late_marks,A.adjusted_in_time,A.adjusted_out_time,A.remark,A.department,B.email_id,Case When Late_marks='L' Then (@cnt := @cnt + 1)  End as Late_marks_count,
		Case When Late_marks='L' AND @cnt>3 AND CAST(effective_time As Time)>=CAST('10:00:00' As Time) THEN 0.66 
		When Late_marks='L' AND @cnt>3 AND CAST(effective_time As Time)<CAST('10:00:00' As Time) THEN 0.5
		When Late_marks='H' THEN 0.5
		When Late_marks='N' AND  ((CAST(effective_time As Time)<CAST('4:00:00' As Time) AND (emp_status!='WeeklyOff' AND emp_status!='Absent' AND emp_status!='Holiday')) OR (emp_status='Absent'))  THEN 0.00
		When (A.effective_time=0 AND (emp_status!='WeeklyOff' AND emp_status!='Absent' AND emp_status!='Holiday')) THEN 0.00
		ELSE 1
		end as adjusted_time ,Case When ((A.`first_in`!='' OR CAST(A.`first_in` As Time)!=CAST('00:00:00' As Time )) && (A.`last_out`='' OR CAST(A.`last_out` As Time)=CAST('00:00:00' As Time ))) Then '0' 
		When ((A.`last_out`!='' OR CAST(A.`last_out` As Time)!=CAST('00:00:00' As Time )) && (A.`first_in`='' OR CAST(A.`first_in` As Time)= CAST('00:00:00' As Time ))) Then '0'
		 Else  A.effective_time end as effective_time from 
		(SELECT *, 
		Case 
		When emp_status='WeeklyOff' THEN 'WeeklyOff' 
		When emp_status='Absent' THEN 'Absent' 
		When emp_status='Present' AND (((first_in!=0 AND first_in!='') And (last_out!=0 AND last_out!='')) ) Then (Case When CAST(last_out As Time)<CAST(first_in As Time ) Then (CAST(ADDTIME(TIMEDIFF(last_out,'00:00'),TIMEDIFF('24:00:00',first_in)) as Time))  Else cast(TIMEDIFF(last_out, first_in) as time)  end ) 
			else 0  
			end as effective_time,
		Case When CAST(first_in As Time)>CAST('10:00:00' As Time) AND CAST(first_in As Time)<CAST('11:00:00' As Time )  AND cast(TIMEDIFF(last_out, first_in) as time)>=CAST('9:00:00' AS TIME)   Then 'L' 
		When (CAST(first_in As Time)>CAST('11:00:00' As Time) OR  (cast(TIMEDIFF(last_out, first_in) as time) < CAST('9:00:00' AS TIME) AND cast(TIMEDIFF(last_out, first_in) as time)>CAST('4:00:00' AS TIME))) AND (emp_status!='WeeklyOff' AND emp_status!='Absent' AND emp_status!='Holiday') Then 'H' 
		Else 'N' End as Late_marks
		from employee_attendence Where emp_no='$emp_no' and MONTH(date)='$month_date' and YEAR(date)='$year') A
		CROSS JOIN (SELECT @cnt := 0) AS dummy
		left JOIN
		(SELECT emp_code,email_id from user_master) B on A.emp_no=B.emp_code ) A
		left join
			(Select A.emp_no,A.date, A.Late_marks as adjusted_late_marks,Case When Late_marks='L' Then (@cnt1 := @cnt1 + 1)  End as adjusted_late_marks_count,
			Case When Late_marks='L' AND @cnt1>3 AND CAST(effective_time As Time)>=CAST('10:00:00' As Time) THEN 0.66 
			When Late_marks='L' AND @cnt1>3 AND CAST(effective_time As Time)<CAST('10:00:00' As Time) THEN 0.5
			When Late_marks='H' THEN 0.5
			When Late_marks='N' AND ((CAST(effective_time As Time)<CAST('4:00:00' As Time) AND (emp_status!='WeeklyOff' AND emp_status!='Absent' AND emp_status!='Holiday')) OR (emp_status='Absent'))  THEN 0.00
			When (A.effective_time=0 AND (emp_status!='WeeklyOff' AND emp_status!='Absent' AND emp_status!='Holiday')) THEN 0.00
			ELSE 1
			end as employee_adjusted_time ,
			Case When ((A.`adjusted_in_time`!='' OR CAST(A.`adjusted_in_time` As Time)!=CAST('00:00:00' As Time )) && (A.`adjusted_out_time`='' OR CAST(A.`adjusted_out_time` As Time)=CAST('00:00:00' As Time ))) Then '0' 
				When ((A.`adjusted_out_time`!='' OR CAST(A.`adjusted_out_time` As Time)!=CAST('00:00:00' As Time )) && (A.`adjusted_in_time`='' OR CAST(A.`adjusted_in_time` As Time)= CAST('00:00:00' As Time ))) Then '0'
				 Else  A.effective_time end as adjusted_effective_time from 
			(SELECT *, 
			Case 
			When emp_status='WeeklyOff' THEN 'WeeklyOff' 
			When emp_status='Absent' THEN 'Absent' 
			When emp_status='Present' AND (((adjusted_in_time!=0 AND adjusted_in_time!='') And (adjusted_out_time!=0 AND adjusted_out_time!='')) ) Then (Case When (CAST(adjusted_out_time As Time)
			>=CAST('00:00:00' As Time ) AND CAST(adjusted_out_time As Time)
			<=CAST('08:00:00' As Time )) Then (CAST(ADDTIME(TIMEDIFF(adjusted_out_time,'00:00'),TIMEDIFF('24:00:00',adjusted_in_time)) as Time))  Else cast(TIMEDIFF(adjusted_out_time, adjusted_in_time) as time)  end ) 
			Else 0
			end as effective_time,
			Case When CAST(adjusted_in_time As Time)>CAST('10:00:00' As Time) AND CAST(adjusted_in_time As Time)<CAST('11:00:00' As Time )  AND cast(TIMEDIFF(adjusted_out_time, adjusted_in_time) as time)>=CAST('9:00:00' AS TIME)   Then 'L' 
			When (CAST(adjusted_in_time As Time)>CAST('11:00:00' As Time) OR   (cast(TIMEDIFF(adjusted_out_time, adjusted_in_time) as time) < CAST('9:00:00' AS TIME) AND cast(TIMEDIFF(adjusted_out_time, adjusted_in_time) as time)>CAST('4:00:00' AS TIME)) ) AND (emp_status!='WeeklyOff' AND emp_status!='Absent' AND emp_status!='Holiday') Then 'H' 
			Else 'N' End as Late_marks
			from employee_attendence  Where emp_no='$emp_no' and MONTH(date)='$month_date' and YEAR(date)='$year') A
			CROSS JOIN (SELECT @cnt1 := 0) AS dummy
			left JOIN
			(SELECT emp_code,email_id from user_master) B on A.emp_no=B.emp_code ) B 
			on A.emp_no=B.emp_no and A.date=B.date ";
			
	$result = $this->db->query($sql)->result();
	return $result;
}

public function attendence_list($status,$year,$month)
{
	if($status!="")
		if($status=="pending_for_approval")
			$cond = "Where status='Pending For Approval'";
		else
			$cond = "Where status='$status'";
	else
		$cond='';

	if($this->session->userdata("user_name")!='rishit.sanghvi@otbconsulting.co.in')
	{
		if($cond!='')
		{
			$emp_code = $this->session->userdata("emp_code");
			$cond.=" AND emp_no='$emp_code'";
		}else
		{
			$emp_code = $this->session->userdata("emp_code");
			$cond.=" Where emp_no='$emp_code'";
		}
	}


	$sql = "SELECT * from (select E.emp_no, E.month_no,E.emp_name,E.`year`, case when E.status = 'bal' then 'Pending' when E.pending_status='pending' then 'Pending For Approval' 
	when F.rejected_status='rejected' then 'Rejected' else 'Approved' end as status from 
	(select C.*, D.pending_status from 
	(select A.*, B.status from 
	(select emp_no,emp_name, month(date) as month_no,YEAR(date) as `year` from employee_attendence Where year(date)='$year' and month(date)='$month' group by emp_name, emp_no, month(date)) A 
	left join 
	(select emp_no,month(date) as month_no, 'bal' as status from employee_attendence where status is null and year(date)='$year' and month(date)='$month' group by emp_no, month(date)) B 
	on (A.emp_no=B.emp_no and A.month_no=B.month_no)) C 
	left join 
	(select emp_no,month(date) as month_no, 'pending' as pending_status from employee_attendence where status = 'pending' and year(date)='$year' and month(date)='$month' group by emp_no, month(date)) D 
	on (C.emp_no=D.emp_no and C.month_no=D.month_no)) E 
	left join 
	(select emp_no,month(date) as month_no, 'rejected' as rejected_status from employee_attendence where status = 'rejected' and year(date)='$year' and month(date)='$month' group by emp_no, month(date)) F 
	on (E.emp_no=F.emp_no and E.month_no=F.month_no) )A ".$cond;

	$result = $this->db->query($sql)->result();

	return $result;
}

public function get_summary($status,$year,$month)
{
	if($status!="")
		if($status=="pending_for_approval")
			$cond = "Where status='Pending For Approval'";
		else
			$cond = "Where status='$status'";
	else
		$cond='';

	$session_email = $this->session->userdata("user_name");
	
	if($this->session->userdata("user_name")!='rishit.sanghvi@otbconsulting.co.in')
	{
		if($cond!='')
		{
			$emp_code = $this->session->userdata("emp_code");
			$cond.=" AND A.emp_no IN ((SELECT emp_code From user_master WHERE email_id2='$session_email' OR email_id='$session_email'))";
		}else
		{
			$emp_code = $this->session->userdata("emp_code");
			$cond.=" Where  A.emp_no IN ((SELECT emp_code From user_master WHERE email_id2='$session_email' OR email_id='$session_email'))";
		}
	}


	$sql = "SELECT * from (select E.emp_no, E.month_no,E.emp_name,E.`year`, case when E.status = 'bal' then 'Pending' when E.pending_status='pending' then 'Pending For Approval' 
	when F.rejected_status='rejected' then 'Rejected' else 'Approved' end as status from 
	(select C.*, D.pending_status from 
	(select A.*, B.status from 
	(select emp_no,emp_name, month(date) as month_no,YEAR(date) as `year` from employee_attendence Where year(date)='$year' and month(date)='$month' group by emp_name, emp_no, month(date)) A 
	left join 
	(select emp_no,month(date) as month_no, 'bal' as status from employee_attendence where status is null and year(date)='$year' and month(date)='$month' group by emp_no, month(date)) B 
	on (A.emp_no=B.emp_no and A.month_no=B.month_no)) C 
	left join 
	(select emp_no,month(date) as month_no, 'pending' as pending_status from employee_attendence where status = 'pending' and year(date)='$year' and month(date)='$month' group by emp_no, month(date)) D 
	on (C.emp_no=D.emp_no and C.month_no=D.month_no)) E 
	left join 
	(select emp_no,month(date) as month_no, 'rejected' as rejected_status from employee_attendence where status = 'rejected' and year(date)='$year' and month(date)='$month' group by emp_no, month(date)) F 
	on (E.emp_no=F.emp_no and E.month_no=F.month_no) )A 
	left JOIN
	(SELECT sum(adjusted_time) as total_days , sum(CASE WHEN emp_status='Holiday' THEN 1 Else 0  END ) as `no_of_holiday` 
	,sum(CASE WHEN emp_status='WeeklyOff' THEN 1 Else 0  END ) as `weekly_off` 
	, sum(CASE WHEN emp_status='Absent' THEN 1 Else 0  END ) as `no_of_leave` ,emp_no
	from (
	Select A.emp_id,A.emp_no,@prv_emp_no,A.status,A.Late_marks,A.emp_status,
	(@cnt := (case when A.emp_no=@prv_emp_no then Case When Late_marks='L' Then @cnt + 1 else @cnt end else Case When Late_marks='L' Then 1 else 0 end end)) as Late_marks_count, (@prv_emp_no:=A.emp_no), 
	Case When Late_marks='L' AND @cnt>3 AND CAST(effective_time As Time)>=CAST('10:00:00' As Time) THEN 0.66 
	When Late_marks='L' AND @cnt>3 AND CAST(effective_time As Time)<CAST('10:00:00' As Time) THEN 0.5
	When Late_marks='H' THEN 0.5
	When Late_marks='N' AND  ((CAST(effective_time As Time)<CAST('4:00:00' As Time) AND (emp_status!='WeeklyOff' AND emp_status!='Absent' AND emp_status!='Holiday')) OR (emp_status='Absent'))  THEN 0.00
	When (A.effective_time=0 AND (emp_status!='WeeklyOff' AND emp_status!='Absent' AND emp_status!='Holiday')) THEN 0.00
	ELSE 1
	end as adjusted_time ,Case When ((A.`adjusted_in_time`!='' OR CAST(A.`adjusted_in_time` As Time)!=CAST('00:00:00' As Time )) && (A.`adjusted_out_time`='' OR CAST(A.`adjusted_out_time` As Time)=CAST('00:00:00' As Time ))) Then '0' 
	When ((A.`adjusted_out_time`!='' OR CAST(A.`adjusted_out_time` As Time)!=CAST('00:00:00' As Time )) && (A.`adjusted_in_time`='' OR CAST(A.`adjusted_in_time` As Time)= CAST('00:00:00' As Time ))) Then '0'
	 Else  A.effective_time end as effective_time from 
	(SELECT *, 
	Case 
	When emp_status='WeeklyOff' THEN 'WeeklyOff' 
	When emp_status='Absent' THEN 'Absent' 
	When emp_status='Present' AND (((adjusted_in_time!=0 AND adjusted_in_time!='') And (adjusted_out_time!=0 AND adjusted_out_time!='')) ) Then (Case When CAST(adjusted_out_time As Time)<CAST(adjusted_in_time As Time ) Then (CAST(ADDTIME(TIMEDIFF(adjusted_out_time,'00:00'),TIMEDIFF('24:00:00',adjusted_in_time)) as Time))  Else cast(TIMEDIFF(adjusted_out_time, adjusted_in_time) as time)  end ) 
		else 0  
		end as effective_time,
	Case When CAST(adjusted_in_time As Time)>CAST('10:00:00' As Time) AND CAST(adjusted_in_time As Time)<CAST('11:00:00' As Time )  AND cast(TIMEDIFF(adjusted_out_time, adjusted_in_time) as time)>=CAST('9:00:00' AS TIME)   Then 'L' 
	When (CAST(adjusted_in_time As Time)>CAST('11:00:00' As Time) OR  (cast(TIMEDIFF(adjusted_out_time, adjusted_in_time) as time) < CAST('9:00:00' AS TIME) AND cast(TIMEDIFF(adjusted_out_time, adjusted_in_time) as time)>CAST('4:00:00' AS TIME))) AND (emp_status!='WeeklyOff' AND emp_status!='Absent' AND emp_status!='Holiday') Then 'H' 
	Else 'N' End as Late_marks
	from employee_attendence  Where MONTH(date)='$month' and YEAR(date)='$year') A
	CROSS JOIN (SELECT @cnt := 0, @prv_emp_no:=0) AS dummy
	ORDER BY emp_no,date) A  GROUP BY emp_no ) B on A.emp_no=B.emp_no ".$cond;
	$result = $this->db->query($sql)->result();

	return $result;	
}


}
?>
