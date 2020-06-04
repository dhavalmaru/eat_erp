<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Beat_allocation_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Area' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $sales_rep_id=''){
    if($status!=""){
        $cond=" where A.status='".$status."'";
    } else {
        $cond="";
    }

    if($sales_rep_id!=""){
        if($cond=="") {
            $cond=" where A.sales_rep_id='".$sales_rep_id."'";
        } else {
            $cond=$cond." and A.sales_rep_id='".$sales_rep_id."'";
        }
    }

	$sql = "select A.type_id, G.distributor_type, A.sales_rep_id, F.sales_rep_name, 
                A.reporting_manager_id, H.sales_rep_name as reporting_manager_name, 
                A.status, A.remarks, 
                group_concat(A.weekday) as weekday, 
                group_concat(A.frequency) as frequency, 
                group_concat(B.distributor_name) as distributor_name1, 
                group_concat(concat(C.beat_id,' - ',C.beat_name)) as beat_name1, 
                group_concat(D.distributor_name) as distributor_name2, 
                group_concat(concat(E.beat_id,' - ',E.beat_name)) as beat_name2 
            from beat_allocations A 
            left join distributor_master B on (A.dist_id1 = B.id) 
            left join beat_master C on (A.beat_id1 = C.id) 
            left join distributor_master D on (A.dist_id2 = D.id) 
            left join beat_master E on (A.beat_id2 = E.id) 
            left join sales_rep_master F on (A.sales_rep_id = F.id) 
            left join distributor_type_master G on (A.type_id = G.id) 
            left join sales_rep_master H on (A.reporting_manager_id = H.id) 
            ".$cond." 
            group by A.type_id, G.distributor_type, A.sales_rep_id, F.sales_rep_name, 
                A.reporting_manager_id, H.sales_rep_name, A.status, A.remarks 
            order by F.sales_rep_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_beat_allocations($sales_rep_id=''){
    $sql = "select A.*, B.frequency, B.dist_id1, B.beat_id1, B.dist_id2, B.beat_id2 
            from weekday_master A left join beat_allocations B 
            on (A.id = B.weekday_id and B.sales_rep_id = '$sales_rep_id') 
            order by A.id";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_type(){
    $sql = "select * from distributor_type_master where status = 'Approved' order by distributor_type";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_sales_rep($sales_rep_id=''){
    $sql = "select distinct A.id, A.sales_rep_name 
            from sales_rep_master A 
            left join beat_allocations B on (A.id = B.sales_rep_id) 
            where A.status = 'Approved' and (B.id is null or B.sales_rep_id='$sales_rep_id') 
            order by A.sales_rep_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_reporting_manager($sales_rep_id=''){
    $sql = "select distinct A.id, A.sales_rep_name 
            from sales_rep_master A where A.status = 'Approved' order by A.sales_rep_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributors(){
    $sql = "select * from distributor_master 
            where status = 'Approved' and class='super stockist'
            order by distributor_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_beat_plan($distributor_id='', $type_id=''){
    $cond = "";
    if($distributor_id!=''){
        //$cond = " and A.distributor_id = '$distributor_id'";
    }
    if($type_id!=''){
        //$cond = " and B.type_id = '$type_id'";
    }
    $sql = "select B.id, B.beat_id, B.beat_name 
            from beat_master B 
            order by B.id";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($sales_rep_id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $type_id = $this->input->post('type_id')==''?null:$this->input->post('type_id');
    $sales_rep_id = $this->input->post('sales_rep_id')==''?null:$this->input->post('sales_rep_id');
    $reporting_manager_id = $this->input->post('reporting_manager_id')==''?null:$this->input->post('reporting_manager_id');
    $weekday_id = $this->input->post('weekday_id');
    $weekday = $this->input->post('weekday');
    $frequency = $this->input->post('frequency');
    $dist_id1 = $this->input->post('dist_id1');
    $beat_id1 = $this->input->post('beat_id1');
    $dist_id2 = $this->input->post('dist_id2');
    $beat_id2 = $this->input->post('beat_id2');

    $this->db->where('sales_rep_id', $sales_rep_id);
    $this->db->delete('beat_allocations');

    for ($k=0; $k<count($frequency); $k++) {
        if(isset($frequency[$k]) and $frequency[$k]!="") {
            $weekday_id[$k] = $weekday_id[$k]==''?null:$weekday_id[$k];
            $dist_id1[$k] = $dist_id1[$k]==''?null:$dist_id1[$k];
            $beat_id1[$k] = $beat_id1[$k]==''?null:$beat_id1[$k];

            if($frequency[$k]=='Alternate'){
                $dist_id2[$k] = $dist_id2[$k]==''?null:$dist_id2[$k];
                $beat_id2[$k] = $beat_id2[$k]==''?null:$beat_id2[$k];
            } else {
                $dist_id2[$k] = null;
                $beat_id2[$k] = null;
            }

            $data = array(
                        'type_id' => $type_id,
                        'sales_rep_id' => $sales_rep_id,
                        'reporting_manager_id' => $reporting_manager_id,
                        'weekday_id' => $weekday_id[$k],
                        'weekday' => $weekday[$k],
                        'frequency' => $frequency[$k],
                        'dist_id1' => $dist_id1[$k],
                        'beat_id1' => $beat_id1[$k],
                        'dist_id2' => $dist_id2[$k],
                        'beat_id2' => $beat_id2[$k],
                        'status' => $this->input->post('status'),
                        'remarks' => $this->input->post('remarks'),
                        'created_by' => $curusr,
                        'created_on' => $now,
                        'modified_by' => $curusr,
                        'modified_on' => $now
                    );
            $this->db->insert('beat_allocations', $data);
        }
    }

    if($type_id=='7') {
        $this->set_merchandiser_beat_plan('admin_merchendizer_beat_plan', $sales_rep_id);
        $this->set_merchandiser_beat_plan('merchandiser_beat_plan', $sales_rep_id);
    } else {
        $this->set_sales_rep_beat_plan('admin_sales_rep_beat_plan', $sales_rep_id);
        $this->set_sales_rep_beat_plan('sales_rep_beat_plan', $sales_rep_id);
    }

    $logarray['table_id']=$sales_rep_id;
    $logarray['module_name']='Beat_Allocation';
    $logarray['cnt_name']='Beat_Allocation';
    $logarray['action']='Beat Plan Assigned';
    $this->user_access_log_model->insertAccessLog($logarray);
}

function set_sales_rep_beat_plan($tablename='', $sales_rep_id='') {
    $sql = "delete from ".$tablename." where sales_rep_id = '".$sales_rep_id."'";
    $this->db->query($sql);
    // echo $sql.'<br/><br/>';

    $sql = "insert into ".$tablename." (store_id, frequency, sequence, created_by, created_on, 
                modified_by, modified_on, status, zone_id, location_id, sales_rep_id, area_id, beat_id) 
            select AA.dist_id, AA.frequency, AA.sequence, AA.created_by, AA.created_on, AA.modified_by, AA.modified_on, 
                AA.status, AA.zone_id, AA.location_id, AA.sales_rep_id, AA.area_id, AA.beat_id from 
            (select AA.dist_id, concat('Every ', AA.weekday) as frequency, AA.sequence, AA.created_by, AA.created_on, 
                AA.modified_by, AA.modified_on, AA.status, AA.zone_id, AA.location_id, AA.sales_rep_id, AA.area_id, AA.beat_id from 
            (select A.id, A.sales_rep_id, A.weekday, A.frequency, A.status, A.created_by, A.created_on, 
                A.modified_by, A.modified_on, A.beat_id1 as beat_id, B.beat_name, 
                C.dist_id, C.sequence, D.zone_id, D.area_id, D.location_id 
            from beat_allocations A 
            left join beat_master B on (A.beat_id1 = B.id) 
            left join beat_details C on (A.beat_id1 = C.beat_id) 
            left join 
            (select concat('d_', id) as id, distributor_name, zone_id, area_id, location_id 
            from distributor_master where status = 'Approved' 
            union 
            select concat('s_', id) as id, distributor_name, zone_id, area_id, location_id 
            from sales_rep_distributors where distributor_name is not null and 
                distributor_name<>'' and (status <> 'Inactive' or status is null) 
            union 
            select concat('m_', A.store_id) as id, B.store_name as distributor_name, 
                A.zone_id, null as area_id, A.location_id 
            from store_master A left join relationship_master B on (A.store_id = B.id) 
            where A.status = 'Approved') D 
            on (C.dist_id = D.id) 
            where A.status = 'Approved' and A.sales_rep_id = '$sales_rep_id') AA 
            union all 
            select AA.dist_id, concat('Alternate ', AA.weekday) as frequency, AA.sequence, AA.created_by, AA.created_on, 
                AA.modified_by, AA.modified_on, AA.status, AA.zone_id, AA.location_id, AA.sales_rep_id, AA.area_id, AA.beat_id from 
            (select A.id, A.sales_rep_id, A.weekday, A.frequency, A.status, A.created_by, A.created_on, A.modified_by, A.modified_on, 
                A.beat_id, A.beat_name, C.dist_id, C.sequence, D.zone_id, D.area_id, D.location_id from 
            (select A.id, A.sales_rep_id, A.weekday, A.frequency, A.status, A.created_by, A.created_on, A.modified_by, A.modified_on, 
                case when A.frequency='Every' then A.beat_id1 else A.beat_id2 end as beat_id, B.beat_name 
            from beat_allocations A 
            left join beat_master B on (A.beat_id1 = B.id)) A 
            left join beat_details C on (A.beat_id = C.beat_id) 
            left join 
            (select concat('d_', id) as id, distributor_name, zone_id, area_id, location_id 
            from distributor_master where status = 'Approved' 
            union 
            select concat('s_', id) as id, distributor_name, zone_id, area_id, location_id 
            from sales_rep_distributors where distributor_name is not null and 
                distributor_name<>'' and (status <> 'Inactive' or status is null) 
            union 
            select concat('m_', A.store_id) as id, B.store_name as distributor_name, 
                A.zone_id, null as area_id, A.location_id 
            from store_master A left join relationship_master B on (A.store_id = B.id) 
            where A.status = 'Approved') D 
            on (C.dist_id = D.id) 
            where A.status = 'Approved' and A.sales_rep_id = '$sales_rep_id') AA) AA";
    $this->db->query($sql);
    // echo $sql.'<br/><br/>';
}

function set_merchandiser_beat_plan($tablename='', $sales_rep_id='') {
    $sql = "delete from ".$tablename." where sales_rep_id = '".$sales_rep_id."'";
    $this->db->query($sql);
    // echo $sql.'<br/><br/>';
    
    $sql = "insert into ".$tablename." (store_id, frequency, sequence, created_by, created_on, 
                modified_by, modified_on, status, zone_id, location_id, sales_rep_id, area_id, beat_id) 
            select AA.dist_id, AA.frequency, AA.sequence, AA.created_by, AA.created_on, AA.modified_by, AA.modified_on, 
                AA.status, AA.zone_id, AA.location_id, AA.sales_rep_id, AA.area_id, AA.beat_id from 
            (select mid(AA.dist_id, position('_' in AA.dist_id)+1) as dist_id, concat('Every ', AA.weekday) as frequency, 
                AA.sequence, AA.created_by, AA.created_on, AA.modified_by, AA.modified_on, 
                AA.status, AA.zone_id, AA.location_id, AA.sales_rep_id, AA.area_id, AA.beat_id from 
            (select A.id, A.sales_rep_id, A.weekday, A.frequency, A.status, A.created_by, A.created_on, 
                A.modified_by, A.modified_on, A.beat_id1 as beat_id, B.beat_name, 
                C.dist_id, C.sequence, B.zone_id, D.location_id 
            from beat_allocations A 
            left join beat_master B on (A.beat_id1 = B.id) 
            left join beat_details C on (A.beat_id1 = C.beat_id) 
            left join beat_locations D on (A.beat_id1 = D.beat_id) 
            left join 
            (select concat('d_', id) as id, distributor_name, type_id, zone_id, area_id, location_id 
            from distributor_master where status = 'Approved' 
            union 
            select concat('s_', id) as id, distributor_name, type_id, zone_id, area_id, location_id 
            from sales_rep_distributors where distributor_name is not null and 
                distributor_name<>'' and (status <> 'Inactive' or status is null) 
            union 
            select concat('m_', A.store_id) as id, B.store_name as distributor_name, 
                A.type_id, A.zone_id, null as area_id, A.location_id 
            from store_master A left join relationship_master B on (A.store_id = B.id) 
            where A.status = 'Approved') E 
            on (C.dist_id=E.id and B.zone_id=E.zone_id and D.location_id=E.location_id) 
            where A.status = 'Approved' and A.sales_rep_id = '$sales_rep_id' and E.id is not null) AA 
            union all 
            select mid(AA.dist_id, position('_' in AA.dist_id)+1) as dist_id, concat('Alternate ', AA.weekday) as frequency, 
                AA.sequence, AA.created_by, AA.created_on, AA.modified_by, AA.modified_on, 
                AA.status, AA.zone_id, AA.location_id, AA.sales_rep_id, AA.area_id, AA.beat_id from 
            (select A.id, A.sales_rep_id, A.weekday, A.frequency, A.status, A.created_by, A.created_on, A.modified_by, A.modified_on, 
                A.beat_id, A.beat_name, C.dist_id, C.sequence, A.zone_id, D.location_id from 
            (select A.id, A.sales_rep_id, A.weekday, A.frequency, A.status, A.created_by, A.created_on, A.modified_by, A.modified_on, 
                case when A.frequency='Every' then A.beat_id1 else A.beat_id2 end as beat_id, B.beat_name, B.zone_id 
            from beat_allocations A 
            left join beat_master B on (A.beat_id1 = B.id)) A 
            left join beat_details C on (A.beat_id = C.beat_id) 
            left join beat_locations D on (A.beat_id1 = D.beat_id) 
            left join 
            (select concat('d_', id) as id, distributor_name, zone_id, area_id, location_id 
            from distributor_master where status = 'Approved' 
            union 
            select concat('s_', id) as id, distributor_name, zone_id, area_id, location_id 
            from sales_rep_distributors where distributor_name is not null and 
                distributor_name<>'' and (status <> 'Inactive' or status is null) 
            union 
            select concat('m_', A.store_id) as id, B.store_name as distributor_name, 
                A.zone_id, null as area_id, A.location_id 
            from store_master A left join relationship_master B on (A.store_id = B.id) 
            where A.status = 'Approved') E 
            on (C.dist_id=E.id and A.zone_id=E.zone_id and D.location_id=E.location_id) 
            where A.status = 'Approved' and A.sales_rep_id = '$sales_rep_id' and E.id is not null) AA) AA";
    $this->db->query($sql);
    // echo $sql.'<br/><br/>';
}

}
?>