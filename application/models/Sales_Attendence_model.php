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
            (Select * from sales_rep_master Where status='Approved' and sr_type IN ('Sales Representative','Merchandizer','Promoter')) A
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
			(Select * from sales_rep_master Where status='Approved' and sr_type IN ('Sales Representative','Merchandizer','Promoter')) A
			Left Join
			(Select sales_rep_id,check_in_time,working_status,causual_remark from sales_attendence Where  date(check_in_time)=date(now())) B
			On A.id=B.sales_rep_id
			Where B.check_in_time is null OR working_status='Absent'
            Order by zone";

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

function weekOfMonth($date) {
    //Get the first day of the month.
   $sql = "Select CASE WHEN ((FLOOR((DayOfMonth('$date')-1)/7)+1 )=1 OR (FLOOR((DayOfMonth('$date')-1)/7)+1 )=3 
        OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
        THEN CONCAT('Every ',DAYNAME('$date')) 
        WHEN ((FLOOR((DayOfMonth('$date')-1)/7)+1 )=2 OR (FLOOR((DayOfMonth('$date')-1)/7)+1 )=4)
        THEN  CONCAT('Alternate ',DAYNAME('$date')) end  as frequency";
    $result = $this->db->query($sql)->result();

    return $frequency = $result[0]->frequency;
}



public function sales_emp_log($value='')
{
	
	$now1=date('Y-m-d');
	/*$now = date('Y-m-d', strtotime($now1 .' -1 day'));
	$prev_date = date('Y-m-d', strtotime($now1 .' -7 day'));*/
    
	$now = date('Y-m-d', strtotime($now1));
	$prev_date = date('Y-m-d', strtotime($now1 .' -4 day'));
	

	$prev_date1 = strtotime($prev_date);
    $now2  = strtotime($now);
    
    $batch_array = [];

    for ($i=$prev_date1; $i<=$now2; $i+=86400) 
    {  
        $e_day =  date('l', $i); 
        $date =  date('Y-m-d', $i);  
        $frequency = $this->weekOfMonth($date);
        $batch_array[]=$frequency;
    }

    /* for ($i=$prev_date1; $i<=$now2; $i+=86400) 
    {  
        echo "sdsds<br>".$e_day =  date('l', $i); 
        echo "sdsds<br>". $date =  date('Y-m-d', $i);  

        $e_week = date('w', strtotime($date));

        echo 'e_week<br>'.$e_week;


        if ($e_week % 2 == 0) {
            $day = 'Alternate '.$e_day;
        }
        else
        {
            $day = 'Every '.$e_day;
        }

        if(!in_array($day,$batch_array))
        {
            if (strpos($day, 'Sunday') !== false) {
                
            }
            else
            {
                $batch_array[]=$day;
            }
        }
    }*/
    $infrequency = "'" . implode ( "', '", $batch_array ) . "'";
	$sql = "select G.*,H.logged_in_days from(select D.*,F.unplanned_count,F.planned_count,F.actual_count from (SELECT  A.sales_rep_name,A.zone as region ,A.sr_type,B.sales_rep_id ,B.date,B.week_days from(SELECT * from sales_rep_master where status='Approved' and sr_type IN ('Sales Representative','Merchandizer'))A
		left join
		(select distinct(sales_rep_id)as sales_rep_id,MAX(check_in_time) as date ,DAYNAME( MAX(check_in_time)) as Week_days from sales_attendence where sales_rep_id<>'' OR sales_rep_id<>'Null' GROUP by sales_rep_id)B
		on(A.id=B.sales_rep_id))D
		left join
		(select * from(select C.*,D.actual_count from (select A.*,B.unplanned_count 
		from
		(
			Select SUM(planned_count) as planned_count , sales_rep_id from (
			Select planned_count,A.sales_rep_id,A.frequency,B.check_in_time,B.working_status from 
			(SELECT SUM(Case When A.created_by=U.id and date(A.created_on) BETWEEN  '$prev_date' AND '$now' Then 0 Else 1  end) as planned_count,A.sales_rep_id ,
			trim(Case When LOCATE('Alternate',frequency)=1 Then REPLACE(frequency,'Alternate ', '')  Else REPLACE(frequency,'Every ', '') end) as frequency
			from sales_rep_beat_plan A
			Left join user_master U On A.created_by=U.id
			Where A.frequency IN ($infrequency ) GROUP By A.sales_rep_id,frequency ) A
			Left Join
			(SELECT DAYNAME(check_in_time)  as weekdays,check_in_time,sales_rep_id,working_status FROM `sales_attendence` 
			WHERE Date(`check_in_time`) BETWEEN '$prev_date' and '2019-03-07' and working_status='present'
			) B On A.sales_rep_id=B.sales_rep_id and A.frequency=B.weekdays COLLATE utf8_unicode_ci
			)A GROUP BY sales_rep_id
		)A
		left join
		(
		 SELECT  sum(unplanned_count) as unplanned_count,sales_rep_id from 
			(
			SELECT count(*) as unplanned_count,A.sales_rep_id from
			(Select * from sales_rep_beat_plan Where frequency IN ($infrequency) 
			and date(created_on) BETWEEN '$prev_date' AND '$now' ) A
			Left join
			(Select * from sales_rep_detailed_beat_plan Where frequency IN ($infrequency)  and is_edit='edit' and bit_plan_id!=0 )B
			On (A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
			GROUP By A.sales_rep_id
			UNION
			SELECT count(*) as unplanned_count,sales_rep_id from sales_rep_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit) BETWEEN '$prev_date' AND '$now' and bit_plan_id=0 GROUP By sales_rep_id
			Union
			Select count(*) as unplanned_count,sales_rep_id from sales_rep_location Where followup_date IS NOT NULL and date(date_of_visit) BETWEEN '$prev_date' AND '$now' GROUP By sales_rep_id
			) A GROUP BY sales_rep_id
		)B
		on(A.sales_rep_id=B.sales_rep_id)

		)C
		left join
		(
			SELECT  count(A.store_id) as actual_count ,A.sales_rep_id from 
				(SELECT store_id,location_id,sales_rep_id,date_of_visit from sales_rep_detailed_beat_plan Where  bit_plan_id!=0 and is_edit='edit' 
				and date(date_of_visit) BETWEEN '$prev_date' AND '$now')A
				left join
				(
					SELECT store_id,location_id,A.sales_rep_id,U.id
					from sales_rep_beat_plan  A
					left join user_master U On A.created_by=U.id
					Where (A.frequency IN ($infrequency ) 
					and date(A.created_on)>='$prev_date' AND  date(A.created_on)<='$now' and A.created_by<>U.id) or 
					(A.frequency IN ($infrequency )  
					and date(A.created_on) NOT  BETWEEN '$prev_date' AND '$now')

				) B On 
			(A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
			Where B.store_id is not null
			GROUP BY A.sales_rep_id
		)D
		on(C.sales_rep_id=D.sales_rep_id)


		union
		select C.*,D.actual_count from (select A.*,B.unplanned_count from(
			Select SUM(planned_count) as planned_count , sales_rep_id from (
			Select planned_count,A.sales_rep_id,A.frequency,B.check_in_time,B.working_status from 
			(SELECT SUM(Case When A.created_by=U.id and date(A.created_on) BETWEEN  '$prev_date' AND '$now' Then 0 Else 1  end) as planned_count,A.sales_rep_id ,
			trim(Case When LOCATE('Alternate',frequency)=1 Then REPLACE(frequency,'Alternate ', '')  Else REPLACE(frequency,'Every ', '') end) as frequency
			from merchandiser_beat_plan A
			Left join user_master U On A.created_by=U.id
			Where A.frequency IN ($infrequency ) GROUP By A.sales_rep_id,frequency ) A
			Left Join
			(SELECT DAYNAME(check_in_time)  as weekdays,check_in_time,sales_rep_id,working_status FROM `sales_attendence` 
			WHERE Date(`check_in_time`) BETWEEN '$prev_date' and '2019-03-07' and working_status='present'
			) B On A.sales_rep_id=B.sales_rep_id and A.frequency=B.weekdays COLLATE utf8_unicode_ci
			)A GROUP BY sales_rep_id
		)A
		left join
		(
			SELECT  sum(unplanned_count) as unplanned_count,sales_rep_id from 
			(
			SELECT count(*) as unplanned_count,A.sales_rep_id from
			(Select * from merchandiser_beat_plan Where frequency IN ($infrequency) 
			and date(created_on) BETWEEN '$prev_date' AND '$now' ) A
			Left join
			(Select * from merchandiser_detailed_beat_plan Where frequency IN ($infrequency)  and is_edit='edit' and bit_plan_id!=0 )B
			On (A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
			GROUP By A.sales_rep_id
			UNION
			SELECT count(*) as unplanned_count,sales_rep_id from merchandiser_detailed_beat_plan B  Where bit_plan_id=0 and date(date_of_visit) BETWEEN '$prev_date' AND '$now' and bit_plan_id=0 GROUP By sales_rep_id
			Union
			Select count(*) as unplanned_count,m_id as sales_rep_id from merchandiser_stock Where followup_date IS NOT NULL and date(date_of_visit) BETWEEN '$prev_date' AND '$now' GROUP By m_id
			) A GROUP BY sales_rep_id			
		)B
		on(A.sales_rep_id=B.sales_rep_id))C
		left join
		(
			SELECT  count(A.store_id) as actual_count ,A.sales_rep_id from 
			(SELECT store_id,location_id,sales_rep_id,date_of_visit from merchandiser_detailed_beat_plan Where  bit_plan_id!=0 and is_edit='edit' 
			and date(date_of_visit) BETWEEN '$prev_date' AND '$now')A
			left join
			(
				SELECT store_id,location_id,A.sales_rep_id,U.id
				from merchandiser_beat_plan  A
				left join user_master U On A.created_by=U.id
				Where (A.frequency IN ($infrequency ) 
				and date(A.created_on)>='$prev_date' AND  date(A.created_on)<='$now' and A.created_by<>U.id) or 
				(A.frequency IN ($infrequency )  
				and date(A.created_on) NOT  BETWEEN '$prev_date' AND '$now')

			) B On 
			(A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.location_id=B.location_id)
			Where B.store_id is not null
			GROUP BY A.sales_rep_id
		)D
		on(C.sales_rep_id=D.sales_rep_id))E)F
		on(D.sales_rep_id=F.sales_rep_id)
		)G
		left join
		(SELECT sales_rep_id, GROUP_CONCAT(weekdays) as logged_in_days from (SELECT distinct(DAYNAME(check_in_time))  as weekdays,sales_rep_id FROM `sales_attendence` WHERE Date(`check_in_time`) BETWEEN '$prev_date' AND '$now') A group by sales_rep_id)H
		on(G.sales_rep_id=H.sales_rep_id)";

	$result = $this->db->query($sql)->result();
	return $result;
}




}
?>
