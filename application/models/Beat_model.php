<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Beat_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id=''){
    if($status!=""){
        $cond=" where A.status='".$status."'";
    } else {
        $cond="";
    }

    $cond2="";
    if($id!=""){
        if($cond=="") {
            $cond=" where A.id='".$id."'";
        } else {
            $cond=$cond." and A.id='".$id."'";
        }
        if($cond2=="") {
            $cond2=" where A.beat_id='".$id."'";
        } else {
            $cond2=$cond2." and A.beat_id='".$id."'";
        }
    }

	$sql = "select A.*, B.distributor_type, C.zone, D.area, E.store_name, F.location_id, F.location 
            from beat_master A 
            left join distributor_type_master B on (A.type_id = B.id) 
            left join zone_master C on (A.zone_id = C.id) 
            left join area_master D on (A.area_id = D.id) 
            left join relationship_master E on (A.store_id = E.id) 
            left join 
            (select A.beat_id, group_concat(A.location_id) as location_id, group_concat(B.location) as location 
                from beat_locations A left join location_master B on (A.location_id=B.id)".$cond2." group by A.beat_id) F 
            on (A.id = F.beat_id) 
            ".$cond." 
            order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_beat_locations($id=''){
    $cond="";

    if($id!=""){
        if($cond=="") {
            $cond=" where A.beat_id='".$id."'";
        } else {
            $cond=$cond." and A.beat_id='".$id."'";
        }
    }

    $sql = "select * from beat_locations A ".$cond;
    $query=$this->db->query($sql);
    return $query->result();
}

function get_type(){
    $sql = "select * from distributor_type_master where status = 'Approved' order by distributor_type";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_zone($type_id=''){
    $cond = "";
    if($type_id!=""){
        $cond = $cond." and type_id = '$type_id'";
    }
    $sql = "select * from zone_master where status = 'Approved'".$cond." order by zone";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_area($type_id='', $zone_id=''){
    $cond = "";
    if($type_id!=""){
        $cond = $cond." and type_id = '$type_id'";
    }
    if($zone_id!=""){
        $cond = $cond." and zone_id = '$zone_id'";
    }
    $sql = "select * from area_master where status = 'Approved'".$cond." order by area";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_store($type_id='', $zone_id=''){
    $cond = "";
    if($type_id!=""){
        $cond = $cond." and A.type_id = '$type_id' and B.type_id = '$type_id'";
    }
    if($zone_id!=""){
        $cond = $cond." and zone_id = '$zone_id'";
    }
    $sql = "select distinct A.id, A.store_name from relationship_master A 
            left join store_master B on (A.id = B.store_id) 
            where A.status = 'Approved'".$cond." order by store_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_location($type_id='', $zone_id='', $area_id=''){
    $cond = "";
    $cond2 = "";
    if($type_id!=""){
        $cond = $cond." and type_id = '$type_id'";
    }
    if($zone_id!=""){
        $cond = $cond." and zone_id = '$zone_id'";
        $cond2 = $cond2." and B.zone_id = '$zone_id'";
    }
    if($area_id!=""){
        $cond = $cond." and area_id = '$area_id'";
    }

    if($type_id=='7'){
        $sql = "select distinct A.id, A.location from location_master A 
                left join store_master B on (A.id = B.location_id) 
                where A.status = 'Approved'".$cond2." order by location";
    } else {
        $sql = "select * from location_master where status = 'Approved'".$cond." order by location";
    }
    
    $query=$this->db->query($sql);
    return $query->result();
}

function get_retailer($beat_id='', $type_id='', $zone_id='', $area_id='', $location_id=''){
    $cond = "";
    $cond2 = "";
    $cond3 = "";
    $cond4 = "";
    if($type_id!=""){
        $cond = $cond." and type_id = '$type_id'";
    }
    if($zone_id!=""){
        $cond = $cond." and zone_id = '$zone_id'";
        $cond4 = $cond4." and zone_id = '$zone_id'";
        $cond2 = $cond2." and B.zone_id = '$zone_id'";
    }
    if($area_id!=""){
        $cond = $cond." and area_id = '$area_id'";
        $cond4 = $cond4." and area_id = '$area_id'";
    }

    if(count($location_id)>0){
        $location_id = implode(',', $location_id);
    }

    if($location_id!=""){
        $cond = $cond." and location_id in ($location_id)";
        $cond4 = $cond4." and location_id in ($location_id)";
        $cond2 = $cond2." and B.location_id in ($location_id)";
    }
    if($beat_id!=""){
        $cond3 = $cond3." where A.id = '$beat_id'";
    }

    if($type_id=='7'){
        $sql = "select A.*, case when B.dist_id is null then '0' else '1' end as is_selected, 
                    ifnull(B.sequence,'') as sequence, ifnull(C.no_of_beat,0) as no_of_beat from 
                (select distinct concat('m_', A.id) as id, A.store_name as distributor_name 
                from relationship_master A 
                left join store_master B on (A.id = B.store_id) 
                where A.status = 'Approved'".$cond2.") A 
                left join 
                (select A.id, B.dist_id, B.sequence from beat_master A 
                left join beat_details B on (A.id = B.beat_id)".$cond3.") B 
                on (A.id = B.dist_id) 
                left join 
                (select dist_id, count(id) as no_of_beat from beat_details group by dist_id) C 
                on (A.id = C.dist_id) 
                order by A.distributor_name";
    } else {
        $sql = "select A.*, case when B.dist_id is null then '0' else '1' end as is_selected, 
                    ifnull(B.sequence,'') as sequence, ifnull(C.no_of_beat,0) as no_of_beat from 
                (select concat('d_', id) as id, distributor_name from distributor_master 
                where status = 'Approved'".$cond." 
                union 
                select concat('s_', id) as id, distributor_name from sales_rep_distributors 
                where distributor_name is not null and distributor_name<>'' and 
                    (status <> 'Inactive' or status is null)".$cond4.") A 
                left join 
                (select A.id, B.dist_id, B.sequence from beat_master A 
                left join beat_details B on (A.id = B.beat_id)".$cond3.") B 
                on (A.id = B.dist_id) 
                left join 
                (select dist_id, count(id) as no_of_beat from beat_details group by dist_id) C 
                on (A.id = C.dist_id) 
                order by A.distributor_name";
    }

    $query=$this->db->query($sql);
    return $query->result();
}

function get_beat_id(){
    $sql="select * from series_master where type='Beat_Plan'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $series=intval($result[0]->series)+1;
    } else {
        $series=1;
    }
    
    $beat_id = 'B'.str_pad($series, 5, '0', STR_PAD_LEFT);

    return $beat_id;
}

function set_beat_id(){
    $sql="select * from series_master where type='Beat_Plan'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $series=intval($result[0]->series)+1;

        $sql="update series_master set series = '$series' where type = 'Beat_Plan'";
        $this->db->query($sql);
    } else {
        $series=1;

        $sql="insert into series_master (type, series) values ('Beat_Plan', '$series')";
        $this->db->query($sql);
    }
    
    $beat_id = 'B'.str_pad($series, 5, '0', STR_PAD_LEFT);

    return $beat_id;
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $beat_id = $this->input->post('beat_id')==''?null:$this->input->post('beat_id');
    $beat_name = $this->input->post('beat_name')==''?null:$this->input->post('beat_name');
    $type_id = $this->input->post('type_id')==''?null:$this->input->post('type_id');
    $zone_id = $this->input->post('zone_id')==''?null:$this->input->post('zone_id');
    $area_id = $this->input->post('area_id')==''?null:$this->input->post('area_id');
    $store_id = $this->input->post('store_id')==''?null:$this->input->post('store_id');

    if($id==''){
        $beat_id = $this->set_beat_id();
    }

    $data = array(
        'beat_id' => $beat_id,
        'beat_name' => $beat_name,
        'type_id' => $type_id,
        'zone_id' => $zone_id,
        'area_id' => $area_id,
        'store_id' => $store_id,
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('beat_master',$data);
        $id=$this->db->insert_id();
        $action='Beat Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('beat_master',$data);
        $action='Beat Modified.';
    }

    $this->db->where('beat_id', $id);
    $this->db->delete('beat_locations');

    $location_id=$this->input->post('location_id[]');
    
    for ($k=0; $k<count($location_id); $k++) {
        if(isset($location_id[$k]) and $location_id[$k]!="") {
            $data = array(
                        'beat_id' => $id,
                        'location_id' => $location_id[$k]
                    );
            $this->db->insert('beat_locations', $data);
        }
    }

    $this->db->where('beat_id', $id);
    $this->db->delete('beat_details');

    $is_selected=$this->input->post('is_selected[]');
    $dist_id=$this->input->post('distributor_id[]');
    $sequence=$this->input->post('sequence[]');
    $seq = 1;
    
    for ($k=0; $k<count($dist_id); $k++) {
        if(isset($dist_id[$k])) { if($dist_id[$k]!="") { if($is_selected[$k]=="1") {
            $data = array(
                        'beat_id' => $id,
                        'dist_id' => $dist_id[$k],
                        // 'sequence' => format_number($sequence[$k],2),
                        'sequence' => $seq++
                    );
            $this->db->insert('beat_details', $data);
        }}}
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Beat_Master';
    $logarray['cnt_name']='Beat_Master';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_beat_name_availablity(){
    $id=$this->input->post('id');
    $beat_name=$this->input->post('beat_name');

    $query=$this->db->query("select * from beat_master where id!='".$id."' and beat_name='".$beat_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>