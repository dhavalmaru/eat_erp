<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_rep_location_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
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

    $sales_rep_id=$this->session->userdata('sales_rep_id');
    if($sales_rep_id!=""){
        if($cond=="") {
            $cond=" where sales_rep_id='".$sales_rep_id."'";
        } else {
            $cond=$cond." and sales_rep_id='".$sales_rep_id."'";
        }
    }

    $sql = "select * , id as mid,distributor_id as store_id from sales_rep_location".$cond."  order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data_qty($status='', $id=''){
    $sql = "select * from sales_rep_distributor_opening_stock where sales_rep_loc_id='$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id='',$status=''){
    $now=date('Y-m-d H:i:s');
    $now1=date('Y-m-d');
    $curusr=$this->session->userdata('session_id');
    $sales_rep_id=$this->session->userdata('sales_rep_id');
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

function check_date_of_visit(){
    $id=$this->input->post('id');
    $date_of_visit = formatdate($this->input->post('date_of_visit'));
    $distributor_name = $this->input->post('distributor_name');
    $sales_rep_id=$this->session->userdata('sales_rep_id');

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

function get_zone(){
    $sales_rep_id = $this->session->userdata('sales_rep_id');
    $sql = "select distinct A.zone_id, B.zone from sr_mapping A left join zone_master B on (A.zone_id = B.id) 
            where (A.reporting_manager_id = '$sales_rep_id' or A.sales_rep_id1 = '$sales_rep_id' or A.sales_rep_id2 = '$sales_rep_id') 
                    and B.type_id = '3'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_area($zone_id=''){
    $cond = '';
    if($zone_id!=''){
        $cond = $cond . " and B.zone_id = '$zone_id'";
    }
    $sales_rep_id = $this->session->userdata('sales_rep_id');
    $sql = "select distinct A.area_id, B.area from sr_mapping A left join area_master B on (A.area_id = B.id) 
            where (A.reporting_manager_id = '$sales_rep_id' or A.sales_rep_id1 = '$sales_rep_id' or A.sales_rep_id2 = '$sales_rep_id') 
                    and B.type_id = '3'" . $cond;
    $query=$this->db->query($sql);
    return $query->result();
}

function get_locations($zone_id='', $area_id=''){
    $cond = '';
    if($zone_id!=''){
        $cond = $cond . " and zone_id = '$zone_id'";
    }
    if($area_id!=''){
        $cond = $cond . " and area_id = '$area_id'";
    }
    $sql = "select * from location_master where status = 'Approved' and type_id = '3'" . $cond;
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributors($zone_id='', $area_id=''){
    $cond = '';
    if($zone_id!=''){
        $cond = $cond . " and zone_id = '$zone_id'";
    }
    if($area_id!=''){
        $cond = $cond . " and area_id = '$area_id'";
    }

    $sales_rep_id = $this->session->userdata('sales_rep_id');
    $sql = "select * from distributor_master where status = 'approved' and class = 'super stockist'" . $cond;
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

}
?>