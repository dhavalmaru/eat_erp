<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Box_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Box' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from box_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_box_product($id){
    $sql = "select A.*, B.product_name from 
            (select * from box_product where box_id = '$id') A 
            left join 
            (select * from product_master) B 
            on (A.product_id=B.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_raw_material_stock($id){
    $sql = "select A.*, B.rm_name from 
            (select * from raw_material_stock where raw_material_in_id = '$id') A 
            left join 
            (select * from raw_material_master) B 
            on (A.product_id=B.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'box_name' => $this->input->post('box_name'),
        'barcode' => $this->input->post('barcode'),
        'grams' => $this->input->post('total_grams'),
        'rate' => $this->input->post('box_rate'),
        'cost' => $this->input->post('box_cost'),
        'amount' => $this->input->post('total_amount'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'hsn_code' => $this->input->post('hsn_code'),
        'hsn_name' => $this->input->post('hsn_name'),
        'short_name' => $this->input->post('short_name'),
        'category_id' => $this->input->post('category_id'),
        'tax_percentage' => $this->input->post('tax_percentage'),
        'asin' => $this->input->post('asin')
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('box_master',$data);
        $id=$this->db->insert_id();
        $action='Box Entry Created.';
    } else {

        $this->db->where('id', $id);
        $this->db->update('box_master',$data);
        $action='Box Entry Modified.';
        
    }

    $this->db->where('box_id', $id);
    $this->db->delete('box_product');

    $product_id=$this->input->post('product[]');
    $qty=$this->input->post('qty[]');
    $grams=$this->input->post('grams[]');
    $rate=$this->input->post('rate[]');
    $amount=$this->input->post('amount[]');

    for ($k=0; $k<count($product_id); $k++) {
        if(isset($product_id[$k]) and $product_id[$k]!="") {
            $data = array(
                        'box_id' => $id,
                        'product_id' => $product_id[$k],
                        'qty' => format_number($qty[$k],2),
                        'grams' => format_number($grams[$k],2),
                        'rate' => format_number($rate[$k],2),
                        'amount' => format_number($amount[$k],2)
                    );
            $this->db->insert('box_product', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Box';
    $logarray['cnt_name']='Box';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_box_name_availablity(){
    $id=$this->input->post('id');
    $box_name=$this->input->post('box_name');

    $query=$this->db->query("SELECT * FROM box_master WHERE id!='".$id."' and box_name='".$box_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

function check_barcode_availablity(){
    $id=$this->input->post('id');
    $barcode=$this->input->post('barcode');

    $query=$this->db->query("SELECT * FROM box_master WHERE id!='".$id."' and barcode='".$barcode."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}
}
?>