<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Promoter_location_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep_Location' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_dist_list() {
    $sql = "select id,store_name from promoter_stores";
            
    $query=$this->db->query($sql);
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

    $sql = "select * from sales_rep_location".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data_qty($status='', $id=''){
    

    $sql = "select * from sales_rep_distributor_opening_stock where sales_rep_loc_id='$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $sales_rep_id=$this->session->userdata('sales_rep_id');
    $date_of_visit=$this->input->post('date_of_visit');
    if($date_of_visit==''){
        $date_of_visit=NULL;
    } else {
        $date_of_visit=formatdate($date_of_visit);
    }
    
    $data = array(
        'sales_rep_id' => $sales_rep_id,
        'date_of_visit' => $date_of_visit,
        'distributor_id' => $this->input->post('distributor_id'),
        'latitude' => $this->input->post('latitude'),
        'longitude' => $this->input->post('longitude'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'checkout_status' => 'checkin',
    );

    // $data1 = array(
    //     'orange_bar' => $this->input->post('orange_bar'),
    //     'mint_bar' => $this->input->post('mint_bar'),
    //     'butterscotch_bar' => $this->input->post('butterscotch_bar'),
    //     'chocopeanut_bar' => $this->input->post('chocopeanut_bar'),
    //     'bambaiyachaat_bar' => $this->input->post('bambaiyachaat_bar'),
    //     'mangoginger_bar' => $this->input->post('mangoginger_bar'),
    //     'type' => 'opening'
    // );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('promoter_location',$data);
        $id=$this->db->insert_id();
        $action='Sales Rep Location Created.';

        // $data1['promoter_loc_id']=$id;
        // $this->db->insert('promoter_stock',$data1);
    } else {
        $this->db->where('id', $id);
        $this->db->update('promoter_location',$data);
        $action='Sales Rep Location Modified.';

        // $this->db->where('promoter_loc_id', $id);
        // $this->db->update('promoter_stock',$data1);
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

}
?>