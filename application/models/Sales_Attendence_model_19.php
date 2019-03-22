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
		sum(Case When working_status='Absent' Then 1 Else 0 end) as absent_count, sum(Case When working_status='Present' Then 1 Else 0 end) as present_count,
        sum(Case When working_status='NL' Then 1 Else 0 end) as not_logged_in_count
        from 
		(
            Select A.id as sales_rep_id,check_in_time,A.zone,Case When (working_status='Absent') Then 'Absent'
            When (B.check_in_time is null) Then 'NL' 
            Else 'Present' end as working_status,
            Case When CAST(check_in_time As Time)>CAST('10:00:00' As Time) AND CAST(check_in_time As Time)<CAST('11:00:00' As Time )  AND check_in_time IS NOT NULL Then 'L'
            When  check_in_time IS NULL Then 'A' else 'O' end as  emp_time   from 
            (Select * from sales_rep_master Where status='Approved' and sr_type IN ('Sales Representative','Merchandizer')) A
            Left Join
            (Select sales_rep_id,check_in_time,working_status from sales_attendence Where  date(check_in_time)=date(now())) B
            On A.id=B.sales_rep_id
        ) A Group By zone";

	$result = $this->db->query($sql)->result();
	return $result;

}

public function sales_absent_attendence($value='')
{

	$sql = "Select A.id as sales_rep_id,sales_rep_name,causual_remark as reason,check_in_time,A.zone,Case When check_in_time is null Then 'Not Logged In' Else 'Absent' end as remark from 
			(Select * from sales_rep_master Where status='Approved' and sr_type IN ('Sales Representative','Merchandizer')) A
			Left Join
			(Select sales_rep_id,check_in_time,working_status,causual_remark from sales_attendence Where  date(check_in_time)=date(now())) B
			On A.id=B.sales_rep_id
			Where B.check_in_time is null OR working_status='Absent'
            Order by zone";

	$result = $this->db->query($sql)->result();
	return $result;

}

public function sales_emp_log($value='')
{
	$now=date('Y-m-d');
	 echo $prev_date = date('Y-m-d', strtotime($now .' -7 day'));
	$sql = "select G.*,H.logged_in_days from(select D.*,F.unplanned_count,F.planned_count,F.actual_count from (SELECT  A.sales_rep_name,A.zone as region ,A.sr_type,B.sales_rep_id ,B.date,B.week_days from(SELECT * from sales_rep_master where status='Approved' and sr_type IN ('Sales Representative','Merchandizer'))A
	left join
	(select distinct(sales_rep_id)as sales_rep_id,MAX(check_in_time) as date ,DAYNAME( MAX(check_in_time)) as Week_days from sales_attendence where sales_rep_id<>'' OR sales_rep_id<>'Null' GROUP by sales_rep_id)B
	on(A.id=B.sales_rep_id))D
	left join
		(select * from(select C.*,D.actual_count from (select A.*,B.unplanned_count from(SELECT sum(Case When created_by=sales_rep_id and (created_on)=now() Then 0 Else 1  end) as planned_count,sales_rep_id from sales_rep_beat_plan  GROUP By sales_rep_id)A
	left join
		(SELECT count(*) as unplanned_count,sales_rep_id from sales_rep_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit)BETWEEN '$prev_date' AND date(now()) and bit_plan_id=0 GROUP By sales_rep_id)B
		on(A.sales_rep_id=B.sales_rep_id))C
	left join
		(SELECT count(*) as actual_count,sales_rep_id from sales_rep_detailed_beat_plan B  WhERE date(date_of_visit)BETWEEN '$prev_date' AND date(now()) and bit_plan_id!=0  and  is_edit='edit' GROUP By sales_rep_id)D
		on(C.sales_rep_id=D.sales_rep_id)
		union
		select C.*,D.actual_count from (select A.*,B.unplanned_count from(SELECT sum(Case When created_by=sales_rep_id and (created_on)=now() Then 0 Else 1  end) as planned_count,sales_rep_id from merchandiser_beat_plan  GROUP By sales_rep_id)A
	left join
		(SELECT count(*) as unplanned_count,sales_rep_id from merchandiser_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit)BETWEEN '$prev_date' AND date(now()) and bit_plan_id=0 GROUP By sales_rep_id)B
		on(A.sales_rep_id=B.sales_rep_id))C
	left join
		(SELECT count(*) as actual_count,sales_rep_id from merchandiser_detailed_beat_plan B  WhERE date(date_of_visit)BETWEEN '$prev_date' AND date(now()) and bit_plan_id!=0  and  is_edit='edit' GROUP By sales_rep_id)D
		on(C.sales_rep_id=D.sales_rep_id))E)F
		on(D.sales_rep_id=F.sales_rep_id))G
	left join
		(SELECT sales_rep_id, GROUP_CONCAT(weekdays) as logged_in_days from (SELECT distinct(DAYNAME(check_in_time))  as weekdays,sales_rep_id FROM `sales_attendence` WHERE Date(`check_in_time`) BETWEEN ('$prev_date') and date(now())) A group by sales_rep_id)H
	on(G.sales_rep_id=H.sales_rep_id)";

	$result = $this->db->query($sql)->result();
	return $result;
}




public function user_login_list()
{
$now=date('Y-m-d');
		// echo $prev_date = date('Y-m-d', strtotime($now .' -15 day'));
/*$sql = "select concat(ifnull(A.first_name,''),' ',ifnull(A.last_name,'')) as user_name,A.email_id, B.date from
(select distinct(user_id),max(date) as date from user_access_log where date(date) BETWEEN '".$prev_date."' AND date(now()) and date!='NULL' and user_id!='NULL' GROUP by user_id) B
left JOIN
(SELECT * FROM `user_master`)A
on(A.id=B.user_id)order by date desc";*/


$sql = "select concat(ifnull(A.first_name,''),' ',ifnull(A.last_name,'')) as user_name,A.email_id, B.date from
(SELECT * FROM user_master WHERE status='Approved')A
left JOIN
(select distinct(user_id),max(date) as date from user_access_log  GROUP by user_id) B
on(A.id=B.user_id)order by date desc";

	$result = $this->db->query($sql)->result();
	return $result;

}



}
?>
