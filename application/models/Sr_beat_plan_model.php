<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class sr_beat_plan_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_Sale' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id=''){
    if($status!=""){
        $cond=" where status='".$status."'";
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }

    $sql = "select C.*, D.sales_rep_name,E.zone,F.location,G.area from (select A.*, B.distributor_name from 
            (select * from admin_sales_rep_beat_plan".$cond.") A 
            left join 
            (select * ,concat('d_',id) as d_id from distributor_master) B 
            on (A.store_id=B.d_id COLLATE utf8_unicode_ci)
            )C
			left join 
			(select * from sales_rep_master) D 
            on (C.sales_rep_id=D.id)
            left join 
            (select * from zone_master) E 
            on (C.zone_id=E.id)
            left join 
            (select * from area_master) G 
            on (C.area_id=G.id)
            left join 
            (select * from location_master) F
            on (C.location_id=F.id)
			where C.status='Approved' order by frequency,sequence,modified_on asc ";
    $query=$this->db->query($sql);
    return $query->result();
}


function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    }
    else{
        $date_of_processing=formatdate($date_of_processing);
    }

    $due_date=$this->input->post('due_date');
    if($due_date==''){
        $due_date=NULL;
    }
    else{
        $due_date=formatdate($due_date);
    }
    
	
	
    $data = array(
        'date_of_processing' => $date_of_processing,
        'distributor_id' => $this->input->post('distributor_id'),
        'sales_rep_id' => $this->input->post('sales_rep_id'),
        'frequency' => $this->input->post('frequency'),
        'sequence' => $this->input->post('sequence'),
 
    
        'status' => 'Approved',
     
        'modified_by' => $curusr,
        'modified_on' => $now,
      
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sales_rep_beat_plan',$data);
        $id=$this->db->insert_id();
        $action='Distributor Sale Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('sales_rep_beat_plan',$data);
        $action='Distributor Sale Entry Modified.';
    }

  

    $logarray['table_id']=$id;
    $logarray['module_name']='sales_rep_beat_plan';
    $logarray['cnt_name']='sales_rep_beat_plan';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function get_distributor_details(){
    $sql = "select * from distributor_master order by distributor_name desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_sales_rep_details(){
    $sql = "select * from sales_rep_master order by sales_rep_name desc";
    $query=$this->db->query($sql);
    return $query->result();
}






// function get_location_data($postData){
    // $sql = "Select  A.*,D.location from 
            // (select * from store_master) A 
            // left join 
            // (select * from location_master)D
            // on (A.location_id=D.id)
            // where A.store_id='". $postData['store_id'] ."'";
    // $query=$this->db->query($sql);
    // return $query->result();
// }

function get_sales_rep_order_email(){
    $sql = "select sum(A.amount)as od_value,sum(B.qty)as od_units from (select * from sales_rep_orders where date(date_of_processing)=date(now()))A left join (select * from sales_rep_order_items) B on(A.id=B.sales_rep_order_id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_sales_rep_total_visits_email($frequency=''){
	  $day = date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }
    $sql = "SELECT (A.unplan+A.temp_count) as unplan, sales_rep_id from (SELECT count(store_id) as unplan,(Select count(id) as tem_visit_count from sales_rep_detailed_beat_plan Where bit_plan_id=0 and is_edit='edit' and date(date_of_visit)=date(now()) and frequency='".$frequency."' ) as temp_count,sales_rep_id from sales_rep_detailed_beat_plan Where date(date_of_visit)=date(now()) and store_id IN ( Select DISTINCT store_id from sales_rep_beat_plan Where date(created_on)= date(now()))and frequency='".$frequency."'  ) A UNION SELECT count(store_id) as unplan,sales_rep_id from sales_rep_detailed_beat_plan Where date(date_of_visit)=date(now()) and store_id IN ( Select DISTINCT store_id from sales_rep_beat_plan Where date(created_on)<>date(now())) and frequency='".$frequency."' UNION SELECT count(store_id) as unplan,sales_rep_id from sales_rep_detailed_beat_plan Where date(date_of_visit)=date(now()) and store_id IN ( Select DISTINCT store_id from sales_rep_beat_plan Where date(created_on)<>date(now()))and is_edit='edit' and frequency='".$frequency."'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_sales_rep_email($frequency=''){
      $day = date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }

    
     $sql="
            select * from (SELECT A.*,(IFNULL(T.tem_visit_count, 0)+IFNULL(F.unplanned_count, 0)) as unplanned_count,E.p_call, B.sales_rep_name,  C.planned_count, D.actual_count,'Present' as emp_status   from 
                        (SELECT DISTINCT sales_rep_id,frequency from sales_rep_detailed_beat_plan Where frequency='".$frequency."' and date(date_of_visit)=date(now())) A 
                                LEFT join ( 
                        Select `count`  as unplanned_count ,sales_rep_id,frequency from 
                        (
                                SELECT count(id) as `count` ,sales_rep_id,frequency from sales_rep_detailed_beat_plan A Where frequency= '".$frequency."' and store_id 
                                IN (Select DISTINCT store_id from sales_rep_beat_plan Where frequency='".$frequency."' and date(created_on)=date(now()) and sales_rep_id=A.sales_rep_id) 
                                and date(date_of_visit)=date(now()) GROUP BY sales_rep_id,frequency 
                        )A GROUP BY sales_rep_id,frequency )F on  F.sales_rep_id=A.sales_rep_id 
                                left join (SELECT sales_rep_name,id from sales_rep_master Where status='Approved') B 
                        on B.id=A.sales_rep_id 
                        left join (SELECT count(id) as p_call,sales_rep_id from sales_rep_orders where date(date_of_processing)=date(now())) E 
                        on A.sales_rep_id=E.sales_rep_id
                        LEFT JOIN 
                        (
                        SELECT count(*) as planned_count ,sales_rep_id from ( SELECT store_id,sales_rep_id,date_of_visit from sales_rep_detailed_beat_plan 
                        Where frequency= '".$frequency."' and store_id IN (Select DISTINCT store_id from sales_rep_beat_plan Where frequency='".$frequency."'
                        and date(created_on)<>date(now()) ) and date(date_of_visit)=date(now()) and is_edit='edit') B GROUP BY sales_rep_id 
                        ) C on C.sales_rep_id=A.sales_rep_id 
                        LEFT JOIN ( 
                        SELECT count(*) as actual_count ,sales_rep_id from ( 
                                                        SELECT store_id,sales_rep_id,date_of_visit from sales_rep_detailed_beat_plan 
                                                        Where frequency= '".$frequency."' and store_id IN (Select DISTINCT store_id from sales_rep_beat_plan Where frequency= '".$frequency."'
                                                        and date(created_on)<>date(now()) ) and date(date_of_visit)=date(now()) 
                         ) B GROUP BY sales_rep_id 
                        ) D 
                        on D.sales_rep_id=A.sales_rep_id
                        LEFT JOIN
                (Select count(id) as tem_visit_count,sales_rep_id,frequency  
                from sales_rep_detailed_beat_plan Where  bit_plan_id=0 and is_edit='edit'  
                and date(date_of_visit)=date(now())
                GROUP By sales_rep_id,frequency) T on (A.sales_rep_id=T.sales_rep_id)
                UNION
                SELECT A.sales_rep_id,'' as frequency,'' as unplanned_count,'' as p_call,B.sales_rep_name,'' as planned_count,
                 '' as actual_count,'Absent' as emp_status        
                From
                (Select DISTINCT sales_rep_id 
                from sales_rep_beat_plan Where frequency='".$frequency."' and sales_rep_id NOT IN(
                SELECT DISTINCT sales_rep_id from sales_rep_detailed_beat_plan Where frequency='".$frequency."' and date(date_of_visit)=date(now()) ) )  A
                join (SELECT sales_rep_name,id from sales_rep_master Where status='Approved') B 
                on B.id=A.sales_rep_id)J where sales_rep_id<>'2';
            ";
        $query=$this->db->query($sql);
        return $query->result();
}


public function get_sales_rep_daily_route_plan($frequency='')
{
    $day = date('l');
    $m = date('F');
    $year = date('Y');
    $get_alternate  = $this->get_alternate($day,$m,$year);
    if($get_alternate)
    {
        $frequency = 'Alternate '.$day;
    }
    else
    {
        $frequency = 'Every '.$day;
    }

    $sql = "Select A.*,C.od_units,D.betweennooforders,G.sales_rep_name from (SELECT DISTINCT A.*,B.distributor_name 
            from (Select * from (Select Distinct A.store_id,A.sales_rep_id, Case When is_edit='edit' Then 'Visited' Else 'Not Visited' end as plan_status,Case When (date(A.created_on)=date(now()))  Then 'Unplanned' ELSE A.frequency end as frequency  FROM
            (SELECT store_id,sales_rep_id,frequency,created_on from sales_rep_beat_plan Where frequency='".$frequency."')A
            left JOIN
            (Select store_id,sales_rep_id,frequency,is_edit,bit_plan_id from sales_rep_detailed_beat_plan Where 
            frequency='".$frequency."' and date(date_of_visit)=date(now()))B
            ON (A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id and A.frequency=B.frequency)
            UNION
            SELECT Distinct store_id,sales_rep_id,Case When is_edit='edit' Then 'Visited' Else 'Not Visited' end as plan_status,
             'Unplanned' as  frequency From sales_rep_detailed_beat_plan Where bit_plan_id=0 and frequency='".$frequency."' and date(date_of_visit)=date(now())) A ORDER By sales_rep_id,frequency) A
            Left JOIN
            (Select Distinct C.* FROM(
                    Select B.* from (
                            Select concat('d_',A.id) as id , A.distributor_name   FROM
                            (Select * from distributor_master )A
                            LEFT JOIN sr_mapping B ON (A.area_id = B.area_id and A.zone_id = B.zone_id and  A.type_id = B.type_id) 
                            Where A.status='approved' and A.class='normal'
                    ) B
                    Union 
                    (
                            Select concat('s_',A.id) as id , A.distributor_name  FROM
                            (Select * from sales_rep_distributors )A
                    )            
            ) C ) B On (A.store_id=B.id COLLATE utf8_unicode_ci) 
            WHERE distributor_name is NOT NULL )A
            left JOIN
            (select sum(B.qty)as od_units,sales_rep_id,distributor_id 
            from (select * from sales_rep_orders Where date(created_on)=date(now()))A 
            left join (
                    select C.sales_rep_order_id, case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 
                from sales_rep_order_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)

            ) B on(A.id=B.sales_rep_order_id)
            GROUP BY sales_rep_id,distributor_id) C on (A.sales_rep_id=C.sales_rep_id and A.store_id=C.distributor_id )
            LEFT JOIN
            (select sales_rep_id,distributor_id,count(id) as betweennooforders from sales_rep_orders 
                Where  date(created_on)=date(now()) GROUP BY sales_rep_id,distributor_id) D
            on(A.sales_rep_id=D.sales_rep_id and A.store_id=D.distributor_id)
            Join 
            (SELECT sales_rep_name,id from sales_rep_master Where status='Approved') G
            On A.sales_rep_id=G.id
            Where A.sales_rep_id IS NOT NULL and A.sales_rep_id!=2
            ORDER  By A.sales_rep_id,A.store_id ";
        $query=$this->db->query($sql);
        return $query->result();
}


function get_sales_rep1_email($frequency=''){
	 $day = date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }
    $sql = "select count(distinct(sales_rep_id)) as total_sales_rep from sales_rep_detailed_beat_plan where frequency='".$frequency."' and sales_rep_id NOT IN(2) ";
    $query=$this->db->query($sql);
    return $query->result();
}
function get_sales_rep2_email($frequency=''){
		 $day = date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }
    $sql = "select count(distinct(sales_rep_id)) as present_sales_rep from sales_rep_detailed_beat_plan Where date(date_of_visit)=date(now()) and frequency='".$frequency."' and sales_rep_id NOT IN(2)";
    $query=$this->db->query($sql);
    return $query->result();
}

 public function get_alternate($day,$m,$year)
    {
        
        $date1 = date('d-m-Y', strtotime('second '.$day.' of '.$m.' '.$year));
        $date2 = date('d-m-Y', strtotime('fourth '.$day.' of '.$m.' '.$year));

        $todaysdate = date('d-m-Y');
        if($date1==$todaysdate) 
        {
            return true;
        }
        elseif($date2==$todaysdate)
        {
            return true;
        }
        else
        {
           return false;
        }
    }
}
?>