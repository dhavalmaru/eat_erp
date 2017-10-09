<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Product_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Product' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from product_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'product_name' => $this->input->post('product_name'),
        'barcode' => $this->input->post('barcode'),
        'grams' => format_number($this->input->post('grams'),2),
        'avg_grams' => format_number($this->input->post('avg_grams'),2),
        'rate' => format_number($this->input->post('rate'),2),
        'cost' => format_number($this->input->post('cost'),2),
        'anticipated_wastage' => format_number($this->input->post('anticipated_wastage'),2),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'hsn_code' => $this->input->post('hsn_code'),
        'hsn_name' => $this->input->post('hsn_name')
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('product_master',$data);
        $id=$this->db->insert_id();
        $action='Product Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('product_master',$data);
        $action='Product Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Product';
    $logarray['cnt_name']='Product';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_product_availablity(){
    $id=$this->input->post('id');
    $product_name=$this->input->post('product_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM product_master WHERE id!='".$id."' and product_name='".$product_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>