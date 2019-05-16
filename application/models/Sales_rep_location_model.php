<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_rep_location_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('email_model');
}

function get_access(){
    $role_id='';
    if($this->input->post('role_id')){
        $role_id=$this->input->post('role_id');
    } else if($this->session->userdata('role_id')){
        $role_id=$this->session->userdata('role_id');
    }
    
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep_Location' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sales_rep_id='';
    if($this->input->post('sales_rep_id')){
        $sales_rep_id=$this->input->post('sales_rep_id');
    } else if($this->session->userdata('sales_rep_id')){
        $sales_rep_id=$this->session->userdata('sales_rep_id');
    }
    // $sales_rep_id = '2';

    if($sales_rep_id!=""){
        if($cond=="") {
            $cond=" where sales_rep_id='".$sales_rep_id."'";
        } else {
            $cond=$cond." and sales_rep_id='".$sales_rep_id."'";
        }
    }

    $sql = "select distinct G.*, I.zone, J.area, K.location, '' as bit_plan_id, '' as sequence from 
            (select *, id as mid, distributor_id as store_id, distributor_name as store_name 
            from sales_rep_location".$cond.") G 
            left join 
            (select * from zone_master) I on (G.zone_id=I.id) 
            left join 
            (select * from area_master) J on (G.area_id=J.id) 
            left join 
            (select * from location_master) K on (G.location_id=K.id) order by G.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_mt_data($status='', $id=''){
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

    $sales_rep_id='';
    if($this->input->post('sales_rep_id')){
        $sales_rep_id=$this->input->post('sales_rep_id');
    } else if($this->session->userdata('sales_rep_id')){
        $sales_rep_id=$this->session->userdata('sales_rep_id');
    }

    // $sales_rep_id = '2';

    if($sales_rep_id!=""){
        if($cond=="") {
            $cond=" where m_id='".$sales_rep_id."'";
        } else {
            $cond=$cond." and m_id='".$sales_rep_id."'";
        }
    }

    $sql = "select * , id as mid,'Old' as distributor_type,dist_id as store_id from merchandiser_stock ".$cond."  order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data_qty($status='', $id=''){
    $sql = "select id, sales_rep_loc_id, ifnull(orange_bar,0) as orange_bar, ifnull(mint_bar,0) as mint_bar, 
            ifnull(butterscotch_bar,0) as butterscotch_bar, ifnull(chocopeanut_bar,0) as chocopeanut_bar, 
            ifnull(bambaiyachaat_bar,0) as bambaiyachaat_bar, ifnull(mangoginger_bar,0) as mangoginger_bar, 
            ifnull(berry_blast_bar,0) as berry_blast_bar, ifnull(chyawanprash_bar,0) as chyawanprash_bar, 
            ifnull(chocolate_cookies_box,0) as chocolate_cookies_box, ifnull(cranberry_orange_box,0) as cranberry_orange_box, 
            ifnull(dark_chocolate_cookies_box,0) as dark_chocolate_cookies_box, ifnull(fig_raisins_box,0) as fig_raisins_box, 
            ifnull(papaya_pineapple_box,0) as papaya_pineapple_box, ifnull(variety_box,0) as variety_box, 
            ifnull(mint_box,0) as mint_box, ifnull(butterscotch_box,0) as butterscotch_box, 
            ifnull(chocopeanut_box,0) as chocopeanut_box, ifnull(bambaiyachaat_box,0) as bambaiyachaat_box, 
            ifnull(berry_blast_box,0) as berry_blast_box, ifnull(mangoginger_box,0) as mangoginger_box, 
            ifnull(cranberry_cookies_box,0) as cranberry_cookies_box, ifnull(orange_box,0) as orange_box, 
            ifnull(chyawanprash_box,0) as chyawanprash_box 
            from sales_rep_distributor_opening_stock where sales_rep_loc_id='$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id='',$status=''){
    $now=date('Y-m-d H:i:s');
    $now1=date('Y-m-d');
    $curusr='';
    $sales_rep_id='';

    if($this->input->post('session_id')){
        $curusr=$this->input->post('session_id');
    } else if($this->session->userdata('session_id')){
        $curusr=$this->session->userdata('session_id');
    }
    if($this->input->post('sales_rep_id')){
        $sales_rep_id=$this->input->post('sales_rep_id');
    } else if($this->session->userdata('sales_rep_id')){
        $sales_rep_id=$this->session->userdata('sales_rep_id');
    }

    $date_of_visit=$this->input->post('date_of_visit');
    if($date_of_visit==''){
        $date_of_visit=NULL;
    } else {
        $date_of_visit=formatdate($date_of_visit);
    }
    $followup_date=$this->input->post('followup_date');
    if($followup_date==''){
        $followup_date=NULL;
    } else {
        $followup_date=formatdate($followup_date);
    }

    $data = array(
        'sales_rep_id' => $sales_rep_id,
        'date_of_visit' => $now1,
        'distributor_type' => $this->input->post('distributor_type'),
        'distributor_id' => $this->input->post('distributor_id'),
        'distributor_name' => $this->input->post('distributor_name'),
        'distributor_status' => $status,
        'latitude' => $this->input->post('latitude'),
        'longitude' => $this->input->post('longitude'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'followup_date' => $followup_date,
        'zone_id' => $this->input->post('zone_id'),
        'area_id' => $this->input->post('area_id'),
        'location_id' => $this->input->post('location_id')
    );

    $data1 = array(
        'orange_bar' => (($this->input->post('orange_bar')=='')?'0':$this->input->post('orange_bar')),
        'mint_bar' => (($this->input->post('mint_bar')=='')?'0':$this->input->post('mint_bar')),
        'butterscotch_bar' => (($this->input->post('butterscotch_bar')=='')?'0':$this->input->post('butterscotch_bar')),
        'chocopeanut_bar' => (($this->input->post('chocopeanut_bar')=='')?'0':$this->input->post('chocopeanut_bar')),
        'bambaiyachaat_bar' => (($this->input->post('bambaiyachaat_bar')=='')?'0':$this->input->post('bambaiyachaat_bar')),
        'mangoginger_bar' => (($this->input->post('mangoginger_bar')=='')?'0':$this->input->post('mangoginger_bar'))
        ,
        'mangoginger_bar' => (($this->input->post('mangoginger_bar')=='')?'0':$this->input->post('mangoginger_bar'))
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sales_rep_location',$data);
        $id=$this->db->insert_id();
        $action='Sales Rep Location Created.';

        $data1['sales_rep_loc_id']=$id;
        $this->db->insert('sales_rep_distributor_opening_stock',$data1);
    } else {
        $this->db->where('id', $id);
        $this->db->update('sales_rep_location',$data);
        $action='Sales Rep Location Modified.';

        $this->db->where('sales_rep_loc_id', $id);
        $this->db->update('sales_rep_distributor_opening_stock',$data1);
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_Rep_Location';
    $logarray['cnt_name']='Sales_Rep_Location';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function save_orders(){
    $now=date('Y-m-d H:i:s');
    
    $curusr='';
    $sales_rep_id='';

    if($this->input->post('session_id')){
        $curusr=$this->input->post('session_id');
    } else if($this->session->userdata('session_id')){
        $curusr=$this->session->userdata('session_id');
    }
    if($this->input->post('sales_rep_id')){
        $sales_rep_id=$this->input->post('sales_rep_id');
    } else if($this->session->userdata('sales_rep_id')){
        $sales_rep_id=$this->session->userdata('sales_rep_id');
    }

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    } else {
        $date_of_processing=formatdate($date_of_processing);
    }
}

function check_date_of_visit(){
    $id=$this->input->post('id');
    $date_of_visit = formatdate($this->input->post('date_of_visit'));
    $distributor_name = $this->input->post('distributor_name');
    
    $sales_rep_id='';
    if($this->input->post('sales_rep_id')){
        $sales_rep_id=$this->input->post('sales_rep_id');
    } else if($this->session->userdata('sales_rep_id')){
        $sales_rep_id=$this->session->userdata('sales_rep_id');
    }

    // $id='2';
    // $date_of_visit = '2017-02-11';
    // $sales_rep_id='1';
    // $distributor_name='Dist1';

    $sql="select * from sales_rep_location where date_of_visit = '$date_of_visit' and sales_rep_id = '$sales_rep_id' and 
         distributor_name = '$distributor_name' and id<>'$id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

function get_location(){
    // $from_date='2017-05-20';
    // $to_date='2017-05-25';

    $from_date=formatdate($this->input->post('from_date'));
    $to_date=formatdate($this->input->post('to_date'));

    $sql = "select A.*, B.sales_rep_name, C.store_name, D.modified_on as logout_time, D.latitude as logout_latitude, 
            D.longitude as logout_longitude from promoter_location A 
            left join sales_rep_master B on (A.sales_rep_id = B.id) 
            left join promoter_stores C on (A.distributor_id = C.id) 
            left join promoter_checkout D on (A.id = D.promoter_location_id) 
            where A.date_of_visit >= '$from_date' and A.date_of_visit <= '$to_date'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_zone($id='', $channel=''){
    $sales_rep_id='';
    $distributor_id='';
    $beat_id='';
    
    if($this->input->post('sales_rep_id')){
        $sales_rep_id=$this->input->post('sales_rep_id');
    } else if($this->session->userdata('sales_rep_id')){
        $sales_rep_id=$this->session->userdata('sales_rep_id');
    }
    if($this->input->post('distributor_id')){
        $distributor_id=$this->input->post('distributor_id');
    } else if($this->session->userdata('distributor_id')){
        $distributor_id=$this->session->userdata('distributor_id');
    }
    if($this->input->post('beat_id')){
        $beat_id=$this->input->post('beat_id');
    } else if($this->session->userdata('beat_id')){
        $beat_id=$this->session->userdata('beat_id');
    }

    // $sales_rep_id = '2';
    // $distributor_id = '1298';
    // $beat_id = '1';

    /*$sql = "select distinct A.zone_id, B.zone from sr_mapping A left join zone_master B on (A.zone_id = B.id) 
            where (A.reporting_manager_id = '$sales_rep_id' or A.sales_rep_id1 = '$sales_rep_id' or A.sales_rep_id2 = '$sales_rep_id') 
                    and B.type_id = '3'";*/

    $cond="";
    $cond2="";
    if($id!="") {
        $cond = " and id='$id'";
        $cond2 = " and B.id='$id'";
    }
	if($channel!="") {
		if($channel=="GT") {
			$cond = " and type_id='3'";
            $cond2 = " and B.type_id='3'";
		} else {
			$cond = " and type_id='7'";
            $cond2 = " and B.type_id='7'";
		}
    }

    if($beat_id!='') {
        $sql = "select distinct A.zone_id, B.zone from beat_master A 
                left join zone_master B on(A.zone_id=B.id) 
                where A.id='$beat_id' and B.status='Approved' and A.zone_id is not null ".$cond2;
    } else {
        $sql = "select id as zone_id, zone from zone_master where status='Approved' ".$cond;
    }
    $query = $this->db->query($sql);
    $result = $query->result();

    if(count($result)==0){
        $sql = "select id as zone_id, zone from zone_master where status='Approved' ".$cond;
        $query = $this->db->query($sql);
        $result = $query->result();
    }
    
    return $result;
}

function get_area($zone_id='',$id=''){
    $sales_rep_id='';
    $distributor_id='';
    $beat_id='';
    
    if($this->input->post('sales_rep_id')){
        $sales_rep_id=$this->input->post('sales_rep_id');
    } else if($this->session->userdata('sales_rep_id')){
        $sales_rep_id=$this->session->userdata('sales_rep_id');
    }
    if($this->input->post('distributor_id')){
        $distributor_id=$this->input->post('distributor_id');
    } else if($this->session->userdata('distributor_id')){
        $distributor_id=$this->session->userdata('distributor_id');
    }
    if($this->input->post('beat_id')){
        $beat_id=$this->input->post('beat_id');
    } else if($this->session->userdata('beat_id')){
        $beat_id=$this->session->userdata('beat_id');
    }

    // $sales_rep_id = '2';
    // $distributor_id = '1298';
    // $beat_id = '1';

    $cond = '';
    $cond2='';
    if($zone_id!='') {
        $cond = $cond . " and zone_id = '$zone_id'";
        $cond2 = $cond2 . " and C.zone_id = '$zone_id'";
    }

    if($id!='') {
        $cond.= ' And id='.$id;
        $cond2.= ' And C.id='.$id;
    }

    /*$sql = "select distinct A.area_id, B.area from sr_mapping A left join area_master B on (A.area_id = B.id) 
            where (A.reporting_manager_id = '$sales_rep_id' or A.sales_rep_id1 = '$sales_rep_id' or A.sales_rep_id2 = '$sales_rep_id') 
                    and B.type_id = '3'" . $cond;*/

    if($beat_id!='') {
        $sql = "select distinct B.area_id, C.area 
                from beat_locations A 
                left join location_master B on (A.location_id = B.id) 
                left join area_master C on (B.area_id = C.id) 
                Where A.beat_id='$beat_id' and C.status='Approved' and C.type_id IN (3,7) and 
                    B.area_id is not null ".$cond2;
    } else {
        $sql = "select id as area_id, area from area_master Where status='Approved' and 
                type_id IN (3,7) ".$cond;
    }
    $query = $this->db->query($sql);
    $result = $query->result();

    if(count($result)==0){
        $sql = "select id as area_id, area from area_master Where status='Approved' and 
                type_id IN (3,7) ".$cond;
        $query = $this->db->query($sql);
        $result = $query->result();
    }
    
    return $result;
}

function get_store($zone_id='', $store_id=''){
    $cond = '';
    if($zone_id!='') {
        $cond = $cond . " and zone_id='".$zone_id."' ";
    }
    if($store_id!='') {
        $cond = $cond . " and store_id='".$store_id."' ";
    }

    $sql = "select distinct A.store_id, B.store_name from 
            (select * from store_master where status='Approved' ".$cond.") A 
            left join 
            (select * from relationship_master where status='Approved') B 
            on (A.store_id=B.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_locations($zone_id='', $area_id='',$id='',$channel_type=''){
    $sales_rep_id='';
    $distributor_id='';
    $beat_id='';
    
    if($this->input->post('sales_rep_id')){
        $sales_rep_id=$this->input->post('sales_rep_id');
    } else if($this->session->userdata('sales_rep_id')){
        $sales_rep_id=$this->session->userdata('sales_rep_id');
    }
    if($this->input->post('distributor_id')){
        $distributor_id=$this->input->post('distributor_id');
    } else if($this->session->userdata('distributor_id')){
        $distributor_id=$this->session->userdata('distributor_id');
    }
    if($this->input->post('beat_id')){
        $beat_id=$this->input->post('beat_id');
    } else if($this->session->userdata('beat_id')){
        $beat_id=$this->session->userdata('beat_id');
    }

    // $sales_rep_id = '2';
    // $distributor_id = '1298';
    // $beat_id = '1';

    $cond = '';
    $cond2 = '';
    if($zone_id!=''){
        $cond = $cond . " and zone_id = '$zone_id'";
        $cond2 = $cond2 . " and B.zone_id = '$zone_id'";
    }
    if($area_id!=''){
        $cond = $cond . " and area_id = '$area_id'";
        $cond2 = $cond2 . " and B.area_id = '$area_id'";
    }

    if($id!=''){
        $cond.= ' And id='.$id;
        $cond2.= ' And B.id='.$id;
    }

    if($beat_id!=''){
        if($channel_type=="MT" || $id!=''){
            $sql = "select * from location_master where status = 'Approved' " . $cond; 
        } else {
            $sql = "select distinct B.* from beat_locations A 
                    left join location_master B on (A.location_id = B.id) 
                    where A.beat_id='$beat_id' and B.status = 'Approved' and B.type_id IN (3,7) " . $cond2;
        }
    } else {
        if($channel_type=="MT" || $id!=''){
            $sql = "select * from location_master where status = 'Approved' " . $cond; 
        } else {
            $sql = "select * from location_master where status = 'Approved' and type_id IN (3,7)" . $cond;
        }
    }
    $query=$this->db->query($sql);
    $result = $query->result();

    if(count($result)==0){
        if($channel_type=="MT" || $id!=''){
            $sql = "select * from location_master where status = 'Approved' " . $cond; 
        } else {
            $sql = "select * from location_master where status = 'Approved' and type_id IN (3,7) " . $cond;
        }
        $query = $this->db->query($sql);
        $result = $query->result();
    }

    // echo $sql;
    // echo '<br/><br/>';
    
    return $result;
}

function get_location_data($store_id, $zone_id, $id){
    $cond = '';
    if($id=='')
    {
      $cond = " and type_id IN (3,7)";
    }

    $sql = "Select  distinct A.*, D.location from 
            (select * from store_master Where status='Approved') A 
            left join 
            (select * from location_master Where status='Approved' ".$cond." ) D 
            on (A.location_id=D.id)
            where A.store_id='".$store_id  ."' and  A.zone_id='". $zone_id ."' and 
                D.location IS NOT NULL  ";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_po_nos($zone_id, $store_id, $location_id){
    $sql = "select distinct A.id, A.po_number 
            from distributor_po A 
            left join distributor_po_delivered_items B on (A.id=B.distributor_po_id) 
            where A.status='Approved' and A.delivery_through='Distributor' and ((A.delivery_status='Pending' and 
                (A.mismatch is null or A.mismatch!=1)) or (A.delivery_status='Delivered' and A.mismatch=1)) and 
                A.type_id='7' and A.zone_id='$zone_id' and A.store_id='$store_id' and A.location_id='$location_id' and 
                B.distributor_po_id is not null 
            order by A.id desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_pending_po_nos($zone_id, $store_id, $location_id){
    $sql = "select distinct A.id, A.po_number, A.modified_on 
            from distributor_po A 
            left join distributor_po_delivered_items B on (A.id=B.distributor_po_id) 
            where A.status='Approved' and A.delivery_status='Delivered' and A.delivery_through='Distributor' and 
                A.mismatch=1 and A.mismatch_type='Physical' and A.type_id='7' and A.zone_id='$zone_id' and 
                A.store_id='$store_id' and A.location_id='$location_id' and B.distributor_po_id is not null 
            order by A.id desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_po_data($zone_id, $store_id, $location_id, $po_id){
    $sql = "select E.id, E.po_number, sum(E.orange_bar_qty) as orange_bar_qty, 
                sum(E.butterscotch_bar_qty) as butterscotch_bar_qty, sum(E.chocopeanut_bar_qty) as chocopeanut_bar_qty, 
                sum(E.bambaiyachaat_bar_qty) as bambaiyachaat_bar_qty, 
                sum(E.mangoginger_bar_qty) as mangoginger_bar_qty, sum(E.berry_blast_bar_qty) as berry_blast_bar_qty, 
                sum(E.chyawanprash_bar_qty) as chyawanprash_bar_qty, sum(E.orange_box_qty) as orange_box_qty, 
                sum(E.butterscotch_box_qty) as butterscotch_box_qty, sum(E.chocopeanut_box_qty) as chocopeanut_box_qty, 
                sum(E.bambaiyachaat_box_qty) as bambaiyachaat_box_qty, sum(E.mangoginger_box_qty) as mangoginger_box_qty, 
                sum(E.berry_blast_box_qty) as berry_blast_box_qty, sum(E.chyawanprash_box_qty) as chyawanprash_box_qty, 
                sum(E.variety_box_qty) as variety_box_qty, sum(E.chocolate_cookies_qty) as chocolate_cookies_qty, 
                sum(E.dark_chocolate_cookies_qty) as dark_chocolate_cookies_qty, sum(E.cranberry_cookies_qty) as cranberry_cookies_qty, 
                sum(E.cranberry_orange_zest_qty) as cranberry_orange_zest_qty, sum(E.fig_raisins_qty) as fig_raisins_qty, 
                sum(E.papaya_pineapple_qty) as papaya_pineapple_qty, 
                sum(E.orange_bar_physical_qty) as orange_bar_physical_qty, 
                sum(E.butterscotch_bar_physical_qty) as butterscotch_bar_physical_qty, 
                sum(E.chocopeanut_bar_physical_qty) as chocopeanut_bar_physical_qty, 
                sum(E.bambaiyachaat_bar_physical_qty) as bambaiyachaat_bar_physical_qty, 
                sum(E.mangoginger_bar_physical_qty) as mangoginger_bar_physical_qty, 
                sum(E.berry_blast_bar_physical_qty) as berry_blast_bar_physical_qty, 
                sum(E.chyawanprash_bar_physical_qty) as chyawanprash_bar_physical_qty, 
                sum(E.orange_box_physical_qty) as orange_box_physical_qty, 
                sum(E.butterscotch_box_physical_qty) as butterscotch_box_physical_qty, 
                sum(E.chocopeanut_box_physical_qty) as chocopeanut_box_physical_qty, 
                sum(E.bambaiyachaat_box_physical_qty) as bambaiyachaat_box_physical_qty, 
                sum(E.mangoginger_box_physical_qty) as mangoginger_box_physical_qty, 
                sum(E.berry_blast_box_physical_qty) as berry_blast_box_physical_qty, 
                sum(E.chyawanprash_box_physical_qty) as chyawanprash_box_physical_qty, 
                sum(E.variety_box_physical_qty) as variety_box_physical_qty, 
                sum(E.chocolate_cookies_physical_qty) as chocolate_cookies_physical_qty, 
                sum(E.dark_chocolate_cookies_physical_qty) as dark_chocolate_cookies_physical_qty, 
                sum(E.cranberry_cookies_physical_qty) as cranberry_cookies_physical_qty, 
                sum(E.cranberry_orange_zest_physical_qty) as cranberry_orange_zest_physical_qty, 
                sum(E.fig_raisins_physical_qty) as fig_raisins_physical_qty, 
                sum(E.papaya_pineapple_physical_qty) as papaya_pineapple_physical_qty from 
            (select D.id, D.po_number, 
                case when D.type='Bar' and D.item_id='1' then D.tot_qty else 0 end as orange_bar_qty, 
                case when D.type='Bar' and D.item_id='3' then D.tot_qty else 0 end as butterscotch_bar_qty, 
                case when D.type='Bar' and D.item_id='5' then D.tot_qty else 0 end as chocopeanut_bar_qty, 
                case when D.type='Bar' and D.item_id='4' then D.tot_qty else 0 end as bambaiyachaat_bar_qty, 
                case when D.type='Bar' and D.item_id='6' then D.tot_qty else 0 end as mangoginger_bar_qty, 
                case when D.type='Bar' and D.item_id='9' then D.tot_qty else 0 end as berry_blast_bar_qty, 
                case when D.type='Bar' and D.item_id='10' then D.tot_qty else 0 end as chyawanprash_bar_qty, 
                case when D.type='Box' and D.item_id='1' then D.tot_qty else 0 end as orange_box_qty, 
                case when D.type='Box' and D.item_id='3' then D.tot_qty else 0 end as butterscotch_box_qty, 
                case when D.type='Box' and D.item_id='9' then D.tot_qty else 0 end as chocopeanut_box_qty, 
                case when D.type='Box' and D.item_id='8' then D.tot_qty else 0 end as bambaiyachaat_box_qty, 
                case when D.type='Box' and D.item_id='12' then D.tot_qty else 0 end as mangoginger_box_qty, 
                case when D.type='Box' and D.item_id='29' then D.tot_qty else 0 end as berry_blast_box_qty, 
                case when D.type='Box' and D.item_id='31' then D.tot_qty else 0 end as chyawanprash_box_qty, 
                case when D.type='Box' and D.item_id='32' then D.tot_qty else 0 end as variety_box_qty, 
                case when D.type='Box' and D.item_id='37' then D.tot_qty else 0 end as chocolate_cookies_qty, 
                case when D.type='Box' and D.item_id='38' then D.tot_qty else 0 end as dark_chocolate_cookies_qty, 
                case when D.type='Box' and D.item_id='39' then D.tot_qty else 0 end as cranberry_cookies_qty, 
                case when D.type='Box' and D.item_id='42' then D.tot_qty else 0 end as cranberry_orange_zest_qty, 
                case when D.type='Box' and D.item_id='41' then D.tot_qty else 0 end as fig_raisins_qty, 
                case when D.type='Box' and D.item_id='40' then D.tot_qty else 0 end as papaya_pineapple_qty, 
                case when D.type='Bar' and D.item_id='1' then D.tot_physical_qty else 0 end as orange_bar_physical_qty, 
                case when D.type='Bar' and D.item_id='3' then D.tot_physical_qty else 0 end as butterscotch_bar_physical_qty, 
                case when D.type='Bar' and D.item_id='5' then D.tot_physical_qty else 0 end as chocopeanut_bar_physical_qty, 
                case when D.type='Bar' and D.item_id='4' then D.tot_physical_qty else 0 end as bambaiyachaat_bar_physical_qty, 
                case when D.type='Bar' and D.item_id='6' then D.tot_physical_qty else 0 end as mangoginger_bar_physical_qty, 
                case when D.type='Bar' and D.item_id='9' then D.tot_physical_qty else 0 end as berry_blast_bar_physical_qty, 
                case when D.type='Bar' and D.item_id='10' then D.tot_physical_qty else 0 end as chyawanprash_bar_physical_qty, 
                case when D.type='Box' and D.item_id='1' then D.tot_physical_qty else 0 end as orange_box_physical_qty, 
                case when D.type='Box' and D.item_id='3' then D.tot_physical_qty else 0 end as butterscotch_box_physical_qty, 
                case when D.type='Box' and D.item_id='9' then D.tot_physical_qty else 0 end as chocopeanut_box_physical_qty, 
                case when D.type='Box' and D.item_id='8' then D.tot_physical_qty else 0 end as bambaiyachaat_box_physical_qty, 
                case when D.type='Box' and D.item_id='12' then D.tot_physical_qty else 0 end as mangoginger_box_physical_qty, 
                case when D.type='Box' and D.item_id='29' then D.tot_physical_qty else 0 end as berry_blast_box_physical_qty, 
                case when D.type='Box' and D.item_id='31' then D.tot_physical_qty else 0 end as chyawanprash_box_physical_qty, 
                case when D.type='Box' and D.item_id='32' then D.tot_physical_qty else 0 end as variety_box_physical_qty, 
                case when D.type='Box' and D.item_id='37' then D.tot_physical_qty else 0 end as chocolate_cookies_physical_qty, 
                case when D.type='Box' and D.item_id='38' then D.tot_physical_qty else 0 end as dark_chocolate_cookies_physical_qty, 
                case when D.type='Box' and D.item_id='39' then D.tot_physical_qty else 0 end as cranberry_cookies_physical_qty, 
                case when D.type='Box' and D.item_id='42' then D.tot_physical_qty else 0 end as cranberry_orange_zest_physical_qty, 
                case when D.type='Box' and D.item_id='41' then D.tot_physical_qty else 0 end as fig_raisins_physical_qty, 
                case when D.type='Box' and D.item_id='40' then D.tot_physical_qty else 0 end as papaya_pineapple_physical_qty 
            from
            (select C.id, C.po_number, C.type, C.item_id, sum(C.qty) as tot_qty, sum(physical_qty) as tot_physical_qty from 
            (select A.id, A.po_number, B.type, B.item_id, B.qty, C.qty as physical_qty 
            from distributor_po A 
            left join distributor_po_delivered_items B on (A.id=B.distributor_po_id) 
            left join distributor_po_physical_items C on (A.id=C.distributor_po_id and B.type=C.type and B.item_id=C.item_id) 
            where A.status='Approved' and A.delivery_through='Distributor' and ((A.delivery_status='Pending' and 
                (A.mismatch is null or A.mismatch!=1)) or (A.delivery_status='Delivered' and A.mismatch=1)) and 
                A.type_id='7' and A.zone_id='$zone_id' and A.store_id='$store_id' and A.location_id='$location_id' and 
                A.id='$po_id') C 
            group by C.id, C.po_number, C.type, C.item_id) D) E group by E.id, E.po_number";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_order_data($order_id){
    $sql = "select E.id, sum(E.orange_bar_qty) as orange_bar_qty, 
                sum(E.butterscotch_bar_qty) as butterscotch_bar_qty, sum(E.chocopeanut_bar_qty) as chocopeanut_bar_qty, 
                sum(E.bambaiyachaat_bar_qty) as bambaiyachaat_bar_qty, 
                sum(E.mangoginger_bar_qty) as mangoginger_bar_qty, sum(E.berry_blast_bar_qty) as berry_blast_bar_qty, 
                sum(E.chyawanprash_bar_qty) as chyawanprash_bar_qty, sum(E.orange_box_qty) as orange_box_qty, 
                sum(E.butterscotch_box_qty) as butterscotch_box_qty, sum(E.chocopeanut_box_qty) as chocopeanut_box_qty, 
                sum(E.bambaiyachaat_box_qty) as bambaiyachaat_box_qty, sum(E.mangoginger_box_qty) as mangoginger_box_qty, 
                sum(E.berry_blast_box_qty) as berry_blast_box_qty, sum(E.chyawanprash_box_qty) as chyawanprash_box_qty, 
                sum(E.variety_box_qty) as variety_box_qty, sum(E.chocolate_cookies_qty) as chocolate_cookies_qty, 
                sum(E.dark_chocolate_cookies_qty) as dark_chocolate_cookies_qty, 
                sum(E.cranberry_cookies_qty) as cranberry_cookies_qty, 
                sum(E.cranberry_orange_zest_qty) as cranberry_orange_zest_qty, sum(E.fig_raisins_qty) as fig_raisins_qty, 
                sum(E.papaya_pineapple_qty) as papaya_pineapple_qty from 
            (select D.id, 
                case when D.type='Bar' and D.item_id='1' then D.tot_qty else 0 end as orange_bar_qty, 
                case when D.type='Bar' and D.item_id='3' then D.tot_qty else 0 end as butterscotch_bar_qty, 
                case when D.type='Bar' and D.item_id='5' then D.tot_qty else 0 end as chocopeanut_bar_qty, 
                case when D.type='Bar' and D.item_id='4' then D.tot_qty else 0 end as bambaiyachaat_bar_qty, 
                case when D.type='Bar' and D.item_id='6' then D.tot_qty else 0 end as mangoginger_bar_qty, 
                case when D.type='Bar' and D.item_id='9' then D.tot_qty else 0 end as berry_blast_bar_qty, 
                case when D.type='Bar' and D.item_id='10' then D.tot_qty else 0 end as chyawanprash_bar_qty, 
                case when D.type='Box' and D.item_id='1' then D.tot_qty else 0 end as orange_box_qty, 
                case when D.type='Box' and D.item_id='3' then D.tot_qty else 0 end as butterscotch_box_qty, 
                case when D.type='Box' and D.item_id='9' then D.tot_qty else 0 end as chocopeanut_box_qty, 
                case when D.type='Box' and D.item_id='8' then D.tot_qty else 0 end as bambaiyachaat_box_qty, 
                case when D.type='Box' and D.item_id='12' then D.tot_qty else 0 end as mangoginger_box_qty, 
                case when D.type='Box' and D.item_id='29' then D.tot_qty else 0 end as berry_blast_box_qty, 
                case when D.type='Box' and D.item_id='31' then D.tot_qty else 0 end as chyawanprash_box_qty, 
                case when D.type='Box' and D.item_id='32' then D.tot_qty else 0 end as variety_box_qty, 
                case when D.type='Box' and D.item_id='37' then D.tot_qty else 0 end as chocolate_cookies_qty, 
                case when D.type='Box' and D.item_id='38' then D.tot_qty else 0 end as dark_chocolate_cookies_qty, 
                case when D.type='Box' and D.item_id='39' then D.tot_qty else 0 end as cranberry_cookies_qty, 
                case when D.type='Box' and D.item_id='42' then D.tot_qty else 0 end as cranberry_orange_zest_qty, 
                case when D.type='Box' and D.item_id='41' then D.tot_qty else 0 end as fig_raisins_qty, 
                case when D.type='Box' and D.item_id='40' then D.tot_qty else 0 end as papaya_pineapple_qty 
            from
            (select C.id, C.item_id, C.type, sum(C.qty) as tot_qty from 
            (select A.id, B.item_id, B.type, B.qty from sales_rep_orders A 
            left join sales_rep_order_items B on (A.id=B.sales_rep_order_id) 
            where A.id='$order_id') C 
            group by C.id, C.item_id, C.type) D) E group by E.id";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_sales_rep_distributors($zone_id='', $area_id='',$id='',$location_id=''){
    $cond = '';
    if($zone_id!=''){
        $cond = $cond . " and zone_id = '$zone_id'";
    }
    if($area_id!=''){
        $cond = $cond . " and area_id = '$area_id'";
    }

    if($id!='')
    {
        $cond.= ' And id='.$id;
    }

	if($location_id!=''){
        $cond = $cond . " and location_id = '$location_id'";
    }
    $sql = "select * from sales_rep_distributors" . $cond;
    $query=$this->db->query($sql);
    return $query->result();
}

function get_retailers($status='', $id=''){
    if($status!=""){
        $cond=" and status='".$status."'";
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" and id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }

    $sql = "select A.* from 
            (select concat('d_',id) as id, distributor_name, sell_out, status, sales_rep_id from distributor_master 
            union all 
            select concat('s_',id) as id, distributor_name, margin as sell_out, status, sales_rep_id from sales_rep_distributors) A 
            Where distributor_name is not null
            ".$cond." order by A.distributor_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributors($zone_id='', $area_id='',$id=''){
    $sales_rep_id='';
    $distributor_id='';
    $beat_id='';
    
    if($this->input->post('sales_rep_id')){
        $sales_rep_id=$this->input->post('sales_rep_id');
    } else if($this->session->userdata('sales_rep_id')){
        $sales_rep_id=$this->session->userdata('sales_rep_id');
    }
    if($this->input->post('distributor_id')){
        $distributor_id=$this->input->post('distributor_id');
    } else if($this->session->userdata('distributor_id')){
        $distributor_id=$this->session->userdata('distributor_id');
    }
    if($this->input->post('beat_id')){
        $beat_id=$this->input->post('beat_id');
    } else if($this->session->userdata('beat_id')){
        $beat_id=$this->session->userdata('beat_id');
    }

    $cond = '';
    $cond2 = '';
    /*if($zone_id!=''){
        $cond = $cond . " and zone_id = '$zone_id'";
    }*/
    /*
    if($area_id!=''){
        $cond = $cond . " and area_id = '$area_id'";
    }*/

    if($id!=''){
        $cond = $cond . " and id = '$id'";
        $cond2 = $cond2 . " and B.id = '$id'";
    }

    //and class = 'super stockist'
    if($beat_id!=''){
        $sql = "select * from distributor_beat_plans A 
                left join distributor_master B on (A.distributor_id = B.id) 
                where A.beat_id = '$beat_id' and B.status = 'approved' and B.class = 'super stockist' and 
                    B.distributor_name!='' " . $cond;
    } else {
        $sql = "select * from distributor_master where status = 'approved' and class = 'super stockist' 
                    and distributor_name!=''" . $cond;
    }
    
    $query=$this->db->query($sql);
    return $query->result();
}

function get_closing_stock(){
    $distributor_id = $this->input->post('distributor_id');
    $date_of_visit = formatdate($this->input->post('date_of_visit'));

    // $distributor_id = 'd_240';
    // $date_of_visit = formatdate('10/11/2017');

    $sql = "select * from sales_rep_distributor_opening_stock where sales_rep_loc_id = (select max(id) from sales_rep_location 
            where status = 'Approved' and distributor_id = '$distributor_id' and 
            date_of_visit = (select max(date_of_visit) from sales_rep_location where status = 'Approved' and 
                                distributor_id = '$distributor_id' and date_of_visit<'$date_of_visit'))";
    $query=$this->db->query($sql);
    $data['opening_stock'] = $query->result();

    // $zone_details = '<option value="">Select</option>';
    // $sql = "select distinct A.zone_id, B.zone from sr_mapping A left join zone_master B on (A.zone_id = B.id) 
    //         where A.status = 'Approved' and (A.reporting_manager_id = '$distributor_id' or 
    //             A.sales_rep_id1 = '$distributor_id' or A.sales_rep_id2 = '$distributor_id')";
    // $query=$this->db->query($sql);
    // $result = $query->result();
    // for($i=0; $i<count($result); $i++){
    //     $zone_details = $zone_details . '<option value="'.$result[$i]->zone_id.'">'.$result[$i]->zone.'</option>';
    // }

    // $area_details = '<option value="">Select</option>';
    // $sql = "select distinct A.area_id, B.area from sr_mapping A left join area_master B on (A.area_id = B.id) 
    //         where A.status = 'Approved' and (A.reporting_manager_id = '$distributor_id' or 
    //             A.sales_rep_id1 = '$distributor_id' or A.sales_rep_id2 = '$distributor_id')";
    // $query=$this->db->query($sql);
    // $result = $query->result();
    // for($i=0; $i<count($result); $i++){
    //     $area_details = $area_details . '<option value="'.$result[$i]->area_id.'">'.$result[$i]->area.'</option>';
    // }

    // $location_details = '<option value="">Select</option>';
    // $sql = "select distinct A.location_id, B.location from sr_mapping A left join location_master B on (A.location_id = B.id) 
    //         where A.status = 'Approved' and (A.reporting_manager_id = '$distributor_id' or 
    //             A.sales_rep_id1 = '$distributor_id' or A.sales_rep_id2 = '$distributor_id')";
    // $query=$this->db->query($sql);
    // $result = $query->result();
    // for($i=0; $i<count($result); $i++){
    //     $location_details = $location_details . '<option value="'.$result[$i]->location_id.'">'.$result[$i]->location.'</option>';
    // }

    // $data['zone'] = $zone_details;
    // $data['area'] = $area_details;
    // $data['location'] = $location_details;
    // $data['result'] = 1;

    return $data;
}

function get_store_name($id='',$zone_id=''){
    if($id!='')
        $cond = 'Where A.store_id='.$id;

    if($zone_id!='')
        $cond .= ' And  A.zone_id='.$zone_id;

    $sql = "select * from (select store_name, s.id as store_id, location_id, zone_id 
            from store_master s JOIN relationship_master rm on s.store_id=rm.id) A ".$cond;

    $result = $this->db->query($sql)->result();
    return $result;
}

function save_po_qty(){
    $now=date('Y-m-d H:i:s');
    $curusr='';
    if($this->input->post('session_id')){
        $curusr=$this->input->post('session_id');
    } else if($this->session->userdata('session_id')){
        $curusr=$this->session->userdata('session_id');
    }

    $po_id = $this->input->post('po_id');

    $po_orange_bar_qty = (($this->input->post('po_orange_bar_qty')=='')?0:$this->input->post('po_orange_bar_qty'));
    $po_orange_bar = (($this->input->post('po_orange_bar')=='')?0:$this->input->post('po_orange_bar'));
    $po_orange_bar_diff = (($this->input->post('po_orange_bar_diff')=='')?0:$this->input->post('po_orange_bar_diff'));
    $po_butterscotch_bar_qty = (($this->input->post('po_butterscotch_bar_qty')=='')?0:$this->input->post('po_butterscotch_bar_qty'));
    $po_butterscotch_bar = (($this->input->post('po_butterscotch_bar')=='')?0:$this->input->post('po_butterscotch_bar'));
    $po_butterscotch_bar_diff = (($this->input->post('po_butterscotch_bar_diff')=='')?0:$this->input->post('po_butterscotch_bar_diff'));
    $po_chocopeanut_bar_qty = (($this->input->post('po_chocopeanut_bar_qty')=='')?0:$this->input->post('po_chocopeanut_bar_qty'));
    $po_chocopeanut_bar = (($this->input->post('po_chocopeanut_bar')=='')?0:$this->input->post('po_chocopeanut_bar'));
    $po_chocopeanut_bar_diff = (($this->input->post('po_chocopeanut_bar_diff')=='')?0:$this->input->post('po_chocopeanut_bar_diff'));
    $po_bambaiyachaat_bar_qty = (($this->input->post('po_bambaiyachaat_bar_qty')=='')?0:$this->input->post('po_bambaiyachaat_bar_qty'));
    $po_bambaiyachaat_bar = (($this->input->post('po_bambaiyachaat_bar')=='')?0:$this->input->post('po_bambaiyachaat_bar'));
    $po_bambaiyachaat_bar_diff = (($this->input->post('po_bambaiyachaat_bar_diff')=='')?0:$this->input->post('po_bambaiyachaat_bar_diff'));
    $po_mangoginger_bar_qty = (($this->input->post('po_mangoginger_bar_qty')=='')?0:$this->input->post('po_mangoginger_bar_qty'));
    $po_mangoginger_bar = (($this->input->post('po_mangoginger_bar')=='')?0:$this->input->post('po_mangoginger_bar'));
    $po_mangoginger_bar_diff = (($this->input->post('po_mangoginger_bar_diff')=='')?0:$this->input->post('po_mangoginger_bar_diff'));
    $po_berry_blast_bar_qty = (($this->input->post('po_berry_blast_bar_qty')=='')?0:$this->input->post('po_berry_blast_bar_qty'));
    $po_berry_blast_bar = (($this->input->post('po_berry_blast_bar')=='')?0:$this->input->post('po_berry_blast_bar'));
    $po_berry_blast_bar_diff = (($this->input->post('po_berry_blast_bar_diff')=='')?0:$this->input->post('po_berry_blast_bar_diff'));
    $po_chyawanprash_bar_qty = (($this->input->post('po_chyawanprash_bar_qty')=='')?0:$this->input->post('po_chyawanprash_bar_qty'));
    $po_chyawanprash_bar = (($this->input->post('po_chyawanprash_bar')=='')?0:$this->input->post('po_chyawanprash_bar'));
    $po_chyawanprash_bar_diff = (($this->input->post('po_chyawanprash_bar_diff')=='')?0:$this->input->post('po_chyawanprash_bar_diff'));

    $po_orange_box_qty = (($this->input->post('po_orange_box_qty')=='')?0:$this->input->post('po_orange_box_qty'));
    $po_orange_box = (($this->input->post('po_orange_box')=='')?0:$this->input->post('po_orange_box'));
    $po_orange_box_diff = (($this->input->post('po_orange_box_diff')=='')?0:$this->input->post('po_orange_box_diff'));
    $po_butterscotch_box_qty = (($this->input->post('po_butterscotch_box_qty')=='')?0:$this->input->post('po_butterscotch_box_qty'));
    $po_butterscotch_box = (($this->input->post('po_butterscotch_box')=='')?0:$this->input->post('po_butterscotch_box'));
    $po_butterscotch_box_diff = (($this->input->post('po_butterscotch_box_diff')=='')?0:$this->input->post('po_butterscotch_box_diff'));
    $po_chocopeanut_box_qty = (($this->input->post('po_chocopeanut_box_qty')=='')?0:$this->input->post('po_chocopeanut_box_qty'));
    $po_chocopeanut_box = (($this->input->post('po_chocopeanut_box')=='')?0:$this->input->post('po_chocopeanut_box'));
    $po_chocopeanut_box_diff = (($this->input->post('po_chocopeanut_box_diff')=='')?0:$this->input->post('po_chocopeanut_box_diff'));
    $po_bambaiyachaat_box_qty = (($this->input->post('po_bambaiyachaat_box_qty')=='')?0:$this->input->post('po_bambaiyachaat_box_qty'));
    $po_bambaiyachaat_box = (($this->input->post('po_bambaiyachaat_box')=='')?0:$this->input->post('po_bambaiyachaat_box'));
    $po_bambaiyachaat_box_diff = (($this->input->post('po_bambaiyachaat_box_diff')=='')?0:$this->input->post('po_bambaiyachaat_box_diff'));
    $po_mangoginger_box_qty = (($this->input->post('po_mangoginger_box_qty')=='')?0:$this->input->post('po_mangoginger_box_qty'));
    $po_mangoginger_box = (($this->input->post('po_mangoginger_box')=='')?0:$this->input->post('po_mangoginger_box'));
    $po_mangoginger_box_diff = (($this->input->post('po_mangoginger_box_diff')=='')?0:$this->input->post('po_mangoginger_box_diff'));
    $po_berry_blast_box_qty = (($this->input->post('po_berry_blast_box_qty')=='')?0:$this->input->post('po_berry_blast_box_qty'));
    $po_berry_blast_box = (($this->input->post('po_berry_blast_box')=='')?0:$this->input->post('po_berry_blast_box'));
    $po_berry_blast_box_diff = (($this->input->post('po_berry_blast_box_diff')=='')?0:$this->input->post('po_berry_blast_box_diff'));
    $po_chyawanprash_box_qty = (($this->input->post('po_chyawanprash_box_qty')=='')?0:$this->input->post('po_chyawanprash_box_qty'));
    $po_chyawanprash_box = (($this->input->post('po_chyawanprash_box')=='')?0:$this->input->post('po_chyawanprash_box'));
    $po_chyawanprash_box_diff = (($this->input->post('po_chyawanprash_box_diff')=='')?0:$this->input->post('po_chyawanprash_box_diff'));
    $po_variety_box_qty = (($this->input->post('po_variety_box_qty')=='')?0:$this->input->post('po_variety_box_qty'));
    $po_variety_box = (($this->input->post('po_variety_box')=='')?0:$this->input->post('po_variety_box'));
    $po_variety_box_diff = (($this->input->post('po_variety_box_diff')=='')?0:$this->input->post('po_variety_box_diff'));

    $po_chocolate_cookies_qty = (($this->input->post('po_chocolate_cookies_qty')=='')?0:$this->input->post('po_chocolate_cookies_qty'));
    $po_chocolate_cookies = (($this->input->post('po_chocolate_cookies')=='')?0:$this->input->post('po_chocolate_cookies'));
    $po_chocolate_cookies_diff = (($this->input->post('po_chocolate_cookies_diff')=='')?0:$this->input->post('po_chocolate_cookies_diff'));
    $po_dark_chocolate_cookies_qty = (($this->input->post('po_dark_chocolate_cookies_qty')=='')?0:$this->input->post('po_dark_chocolate_cookies_qty'));
    $po_dark_chocolate_cookies = (($this->input->post('po_dark_chocolate_cookies')=='')?0:$this->input->post('po_dark_chocolate_cookies'));
    $po_dark_chocolate_cookies_diff = (($this->input->post('po_dark_chocolate_cookies_diff')=='')?0:$this->input->post('po_dark_chocolate_cookies_diff'));
    $po_cranberry_cookies_qty = (($this->input->post('po_cranberry_cookies_qty')=='')?0:$this->input->post('po_cranberry_cookies_qty'));
    $po_cranberry_cookies = (($this->input->post('po_cranberry_cookies')=='')?0:$this->input->post('po_cranberry_cookies'));
    $po_cranberry_cookies_diff = (($this->input->post('po_cranberry_cookies_diff')=='')?0:$this->input->post('po_cranberry_cookies_diff'));

    $po_cranberry_orange_zest_qty = (($this->input->post('po_cranberry_orange_zest_qty')=='')?0:$this->input->post('po_cranberry_orange_zest_qty'));
    $po_cranberry_orange_zest = (($this->input->post('po_cranberry_orange_zest')=='')?0:$this->input->post('po_cranberry_orange_zest'));
    $po_cranberry_orange_zest_diff = (($this->input->post('po_cranberry_orange_zest_diff')=='')?0:$this->input->post('po_cranberry_orange_zest_diff'));
    $po_fig_raisins_qty = (($this->input->post('po_fig_raisins_qty')=='')?0:$this->input->post('po_fig_raisins_qty'));
    $po_fig_raisins = (($this->input->post('po_fig_raisins')=='')?0:$this->input->post('po_fig_raisins'));
    $po_fig_raisins_diff = (($this->input->post('po_fig_raisins_diff')=='')?0:$this->input->post('po_fig_raisins_diff'));
    $po_papaya_pineapple_qty = (($this->input->post('po_papaya_pineapple_qty')=='')?0:$this->input->post('po_papaya_pineapple_qty'));
    $po_papaya_pineapple = (($this->input->post('po_papaya_pineapple')=='')?0:$this->input->post('po_papaya_pineapple'));
    $po_papaya_pineapple_diff = (($this->input->post('po_papaya_pineapple_diff')=='')?0:$this->input->post('po_papaya_pineapple_diff'));

    $po_orange_bar_diff = $po_orange_bar - $po_orange_bar_qty;
    $po_butterscotch_bar_diff = $po_butterscotch_bar - $po_butterscotch_bar_qty;
    $po_chocopeanut_bar_diff = $po_chocopeanut_bar - $po_chocopeanut_bar_qty;
    $po_bambaiyachaat_bar_diff = $po_bambaiyachaat_bar - $po_bambaiyachaat_bar_qty;
    $po_mangoginger_bar_diff = $po_mangoginger_bar - $po_mangoginger_bar_qty;
    $po_berry_blast_bar_diff = $po_berry_blast_bar - $po_berry_blast_bar_qty;
    $po_chyawanprash_bar_diff = $po_chyawanprash_bar - $po_chyawanprash_bar_qty;

    $po_orange_box_diff = $po_orange_box - $po_orange_box_qty;
    $po_butterscotch_box_diff = $po_butterscotch_box - $po_butterscotch_box_qty;
    $po_chocopeanut_box_diff = $po_chocopeanut_box - $po_chocopeanut_box_qty;
    $po_bambaiyachaat_box_diff = $po_bambaiyachaat_box - $po_bambaiyachaat_box_qty;
    $po_mangoginger_box_diff = $po_mangoginger_box - $po_mangoginger_box_qty;
    $po_berry_blast_box_diff = $po_berry_blast_box - $po_berry_blast_box_qty;
    $po_chyawanprash_box_diff = $po_chyawanprash_box - $po_chyawanprash_box_qty;
    $po_variety_box_diff = $po_variety_box - $po_variety_box_qty;

    $po_chocolate_cookies_diff = $po_chocolate_cookies - $po_chocolate_cookies_qty;
    $po_dark_chocolate_cookies_diff = $po_dark_chocolate_cookies - $po_dark_chocolate_cookies_qty;
    $po_cranberry_cookies_diff = $po_cranberry_cookies - $po_cranberry_cookies_qty;

    $po_cranberry_orange_zest_diff = $po_cranberry_orange_zest - $po_cranberry_orange_zest_qty;
    $po_fig_raisins_diff = $po_fig_raisins - $po_fig_raisins_qty;
    $po_papaya_pineapple_diff = $po_papaya_pineapple - $po_papaya_pineapple_qty;

    $mismatch = '0';
    $mismatch_type = '';
    // $delivery_status = 'Pending';
    $delivery_status = 'Delivered';

    if($po_orange_bar_diff!=0 || $po_butterscotch_bar_diff!=0 || $po_chocopeanut_bar_diff!=0 || 
        $po_bambaiyachaat_bar_diff!=0 || $po_mangoginger_bar_diff!=0 || $po_berry_blast_bar_diff!=0 || 
        $po_chyawanprash_bar_diff!=0 || $po_orange_box_diff!=0 || $po_butterscotch_box_diff!=0 || 
        $po_chocopeanut_box_diff!=0 || $po_bambaiyachaat_box_diff!=0 || $po_mangoginger_box_diff!=0 || 
        $po_berry_blast_box_diff!=0 || $po_chyawanprash_box_diff!=0 || $po_variety_box_diff!=0 || 
        $po_chocolate_cookies_diff!=0 || $po_dark_chocolate_cookies_diff!=0 || $po_cranberry_cookies_diff!=0 || 
        $po_cranberry_orange_zest_diff!=0 || $po_fig_raisins_diff!=0 || $po_papaya_pineapple_diff!=0) {
            $mismatch = '1';
            $mismatch_type = 'Physical';
    }

    $data = array(
        'delivery_status' => $delivery_status,
        'mismatch' => $mismatch,
        'mismatch_type' => $mismatch_type,
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    $this->db->where('id', $po_id);
    $this->db->update('distributor_po',$data);
    $action='Distributor PO Entry By Merchandiser. Delivery Status: ' . $delivery_status;

    $this->db->where('distributor_po_id', $po_id);
    $this->db->delete('distributor_po_physical_items');

    $i = 0;
    $type = array();
    $item_id = array();
    $qty = array();

    if($po_orange_bar>0){
        $type[$i]='Bar';
        $item_id[$i]='1';
        $qty[$i]=$po_orange_bar;
        $i = $i + 1;
    }
    if($po_butterscotch_bar>0){
        $type[$i]='Bar';
        $item_id[$i]='3';
        $qty[$i]=$po_butterscotch_bar;
        $i = $i + 1;
    }
    if($po_chocopeanut_bar>0){
        $type[$i]='Bar';
        $item_id[$i]='5';
        $qty[$i]=$po_chocopeanut_bar;
        $i = $i + 1;
    }
    if($po_bambaiyachaat_bar>0){
        $type[$i]='Bar';
        $item_id[$i]='4';
        $qty[$i]=$po_bambaiyachaat_bar;
        $i = $i + 1;
    }
    if($po_mangoginger_bar>0){
        $type[$i]='Bar';
        $item_id[$i]='6';
        $qty[$i]=$po_mangoginger_bar;
        $i = $i + 1;
    }
    if($po_berry_blast_bar>0){
        $type[$i]='Bar';
        $item_id[$i]='9';
        $qty[$i]=$po_berry_blast_bar;
        $i = $i + 1;
    }
    if($po_chyawanprash_bar>0){
        $type[$i]='Bar';
        $item_id[$i]='10';
        $qty[$i]=$po_chyawanprash_bar;
        $i = $i + 1;
    }

    if($po_orange_box>0){
        $type[$i]='Box';
        $item_id[$i]='1';
        $qty[$i]=$po_orange_box;
        $i = $i + 1;
    }
    if($po_butterscotch_box>0){
        $type[$i]='Box';
        $item_id[$i]='3';
        $qty[$i]=$po_butterscotch_box;
        $i = $i + 1;
    }
    if($po_chocopeanut_box>0){
        $type[$i]='Box';
        $item_id[$i]='9';
        $qty[$i]=$po_chocopeanut_box;
        $i = $i + 1;
    }
    if($po_bambaiyachaat_box>0){
        $type[$i]='Box';
        $item_id[$i]='8';
        $qty[$i]=$po_bambaiyachaat_box;
        $i = $i + 1;
    }
    if($po_mangoginger_box>0){
        $type[$i]='Box';
        $item_id[$i]='12';
        $qty[$i]=$po_mangoginger_box;
        $i = $i + 1;
    }
    if($po_berry_blast_box>0){
        $type[$i]='Box';
        $item_id[$i]='29';
        $qty[$i]=$po_berry_blast_box;
        $i = $i + 1;
    }
    if($po_chyawanprash_box>0){
        $type[$i]='Box';
        $item_id[$i]='31';
        $qty[$i]=$po_chyawanprash_box;
        $i = $i + 1;
    }
    if($po_variety_box>0){
        $type[$i]='Box';
        $item_id[$i]='32';
        $qty[$i]=$po_variety_box;
        $i = $i + 1;
    }

    if($po_chocolate_cookies>0){
        $type[$i]='Box';
        $item_id[$i]='37';
        $qty[$i]=$po_chocolate_cookies;
        $i = $i + 1;
    }
    if($po_dark_chocolate_cookies>0){
        $type[$i]='Box';
        $item_id[$i]='38';
        $qty[$i]=$po_dark_chocolate_cookies;
        $i = $i + 1;
    }
    if($po_cranberry_cookies>0){
        $type[$i]='Box';
        $item_id[$i]='39';
        $qty[$i]=$po_cranberry_cookies;
        $i = $i + 1;
    }

    if($po_cranberry_orange_zest>0){
        $type[$i]='Box';
        $item_id[$i]='42';
        $qty[$i]=$po_cranberry_orange_zest;
        $i = $i + 1;
    }
    if($po_fig_raisins>0){
        $type[$i]='Box';
        $item_id[$i]='41';
        $qty[$i]=$po_fig_raisins;
        $i = $i + 1;
    }
    if($po_papaya_pineapple>0){
        $type[$i]='Box';
        $item_id[$i]='40';
        $qty[$i]=$po_papaya_pineapple;
        $i = $i + 1;
    }

    for ($k=0; $k<count($type); $k++) {
        if(isset($type[$k]) and $type[$k]!="") {
            $data = array(
                        'distributor_po_id' => $po_id,
                        'type' => $type[$k],
                        'item_id' => $item_id[$k],
                        'qty' => format_number($qty[$k],2)
                    );
            $this->db->insert('distributor_po_physical_items', $data);
        }
    }

    // $this->send_po_physical_confirmation_email($po_id, $mismatch);

    $logarray['table_id']=$po_id;
    $logarray['module_name']='Distributor_PO';
    $logarray['cnt_name']='Distributor_PO';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    return $mismatch;
}

function send_po_physical_confirmation_email($id='', $mismatch='') {
    $email_type = 'distributor_po_confirm_physical';

    if(strtoupper(trim($mismatch))=="1"){
        $mismatch_status = "Mismatch";
    } else {
        $mismatch_status = "Verified";
    }
    $action='Distributor Po Physical Quantity '.$mismatch_status.' mail sending failed.';

    $result = $this->email_model->get_email_details('', $email_type);

    if(count($result)>0){
        $email_from = $result[0]->email_from;
        $email_sender = $result[0]->email_sender;
        $email_to = $result[0]->email_to;
        $email_cc = $result[0]->email_cc;
        $email_bcc = $result[0]->email_bcc;
        $email_subject = $result[0]->email_subject.' '.$mismatch_status;
        $email_body = $result[0]->email_body.' '.$mismatch_status;

        $mailSent=$this->email_model->set_email_details($id, $email_type, $email_from,  $email_sender, $email_to, $email_subject, $email_body, $email_bcc, $email_cc);

        if($mailSent==1){
            $action='Distributor Po '.$delivery_status.' mail sent.';
        }
    }
    
    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_PO';
    $logarray['cnt_name']='Distributor_PO';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    return $mailSent;
}


}
?>