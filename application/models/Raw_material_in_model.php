<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Raw_material_in_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Raw_Material_In' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select C.*, D.depot_name from 
            (select A.*, B.vendor_name from 
            (select * from raw_material_in".$cond.") A 
            left join 
            (select * from vendor_master) B 
            on (A.vendor_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id) order by C.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_raw_material_stock($id){
    $sql = "select A.*, B.rm_name from 
            (select * from raw_material_stock where raw_material_in_id = '$id') A 
            left join 
            (select * from raw_material_master) B 
            on (A.raw_material_id=B.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_receipt=$this->input->post('date_of_receipt');
    if($date_of_receipt==''){
        $date_of_receipt=NULL;
    }
    else{
        $date_of_receipt=formatdate($date_of_receipt);
    }
    
    $data = array(
        'date_of_receipt' => $date_of_receipt,
        'purchase_order_id' => $this->input->post('purchase_order_id'),
        'vendor_id' => $this->input->post('vendor_id'),
        'cst' => format_number($this->input->post('cst'),2),
        'excise' => format_number($this->input->post('excise'),2),
        'final_amount' => format_number($this->input->post('final_amount'),2),
        'depot_id' => $this->input->post('depot_id'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('raw_material_in',$data);
        $id=$this->db->insert_id();
        $action='Raw Material In Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('raw_material_in',$data);
        $action='Raw Material In Entry Modified.';
    }

    $this->db->where('raw_material_in_id', $id);
    $this->db->delete('raw_material_stock');

    $raw_material_id=$this->input->post('raw_material[]');
    $qty=$this->input->post('qty[]');
    $rate=$this->input->post('rate[]');
    $amount=$this->input->post('amount[]');

    for ($k=0; $k<count($raw_material_id); $k++) {
        if(isset($raw_material_id[$k]) and $raw_material_id[$k]!="") {
            $data = array(
                        'raw_material_in_id' => $id,
                        'raw_material_id' => $raw_material_id[$k],
                        'qty' => format_number($qty[$k],2),
                        'rate' => format_number($rate[$k],2),
                        'amount' => format_number($amount[$k],2)
                    );
            $this->db->insert('raw_material_stock', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Raw_Material_In';
    $logarray['cnt_name']='Raw_Material_In';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

}
?>