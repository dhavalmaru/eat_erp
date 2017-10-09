<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Transfer_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Transfer' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select G.*, H.depot_name as depot_in_name from 
            (select E.*, F.depot_name as depot_out_name from 
            (select C.*, D.product_name from 
            (select A.*, B.rm_name from 
            (select * from transfer".$cond.") A 
            left join 
            (select * from raw_material_master) B 
            on (A.raw_material_id=B.id)) C 
            left join 
            (select * from product_master) D 
            on (C.product_id=D.id)) E 
            left join 
            (select * from depot_master) F 
            on (E.depot_out_id=F.id)) G 
            left join 
            (select * from depot_master) H 
            on (G.depot_in_id=H.id) order by G.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_transfer=$this->input->post('date_of_transfer');
    if($date_of_transfer==''){
        $date_of_transfer=NULL;
    }
    else{
        $date_of_transfer=formatdate($date_of_transfer);
    }
    
    $data = array(
        'date_of_transfer' => $date_of_transfer,
        'depot_out_id' => $this->input->post('depot_out_id'),
        'item' => $this->input->post('item'),
        'raw_material_id' => $this->input->post('raw_material_id'),
        'product_id' => $this->input->post('product_id'),
        'qty' => format_number($this->input->post('qty'),2),
        'product_type' => $this->input->post('product_type'),
        'depot_in_id' => $this->input->post('depot_in_id'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('transfer',$data);
        $id=$this->db->insert_id();
        $action='Transfer Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('transfer',$data);
        $action='Transfer Entry Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Transfer';
    $logarray['cnt_name']='Transfer';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

}
?>