<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Combo_box_model Extends CI_Model{

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

    $sql = "select * from combo_box_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_combo_box_items($id){
    $sql = "select A.*, case when A.type='Bar' then B.product_name else C.box_name end as item_name from 
            (select * from combo_box_items where combo_box_id = '$id') A 
            left join 
            (select * from product_master) B 
            on (A.type='Bar' and A.item_id=B.id) 
            left join 
            (select * from box_master) C 
            on (A.type='Box' and A.item_id=C.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $total_grams = $this->input->post('total_grams');
    $combo_box_rate = $this->input->post('combo_box_rate');
    $combo_box_cost = $this->input->post('combo_box_cost');
    $total_amount = $this->input->post('total_amount');
    $tax_percentage = $this->input->post('tax_percentage');
    $category_id = $this->input->post('category_id');

    if($total_grams==''){
        $total_grams = null;
    }
    if($combo_box_rate==''){
        $combo_box_rate = null;
    }
    if($combo_box_cost==''){
        $combo_box_cost = null;
    }
    if($total_amount==''){
        $total_amount = null;
    }
    if($tax_percentage==''){
        $tax_percentage = null;
    }
    if($category_id==''){
        $category_id = null;
    }
    
    $data = array(
        'combo_box_name' => $this->input->post('combo_box_name'),
        'barcode' => $this->input->post('barcode'),
        'grams' => $total_grams,
        'rate' => $combo_box_rate,
        'cost' => $combo_box_cost,
        'amount' => $total_amount,
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'hsn_code' => $this->input->post('hsn_code'),
        'hsn_name' => $this->input->post('hsn_name'),
        'short_name' => $this->input->post('short_name'),
        'category_id' => $category_id,
        'tax_percentage' => $tax_percentage,
        'asin' => $this->input->post('asin'),
        'sku_code' => $this->input->post('sku_code')
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('combo_box_master',$data);
        $id=$this->db->insert_id();
        $action='Combo_box Entry Created.';
    } else {

        $this->db->where('id', $id);
        $this->db->update('combo_box_master',$data);
        $action='Combo_box Entry Modified.';
        
    }

    $this->db->where('combo_box_id', $id);
    $this->db->delete('combo_box_items');

    $type=$this->input->post('type[]');
    $bar=$this->input->post('bar[]');
    $box=$this->input->post('box[]');
    $qty=$this->input->post('qty[]');
    $grams=$this->input->post('grams[]');
    $rate=$this->input->post('rate[]');
    $amount=$this->input->post('amount[]');

    for ($k=0; $k<count($type); $k++) {
        if(isset($type[$k]) and $type[$k]!="") {
            if($type[$k]=="Bar"){
                $item_id=$bar[$k];
            } else {
                $item_id=$box[$k];
            }

            $data = array(
                        'combo_box_id' => $id,
                        'type' => $type[$k],
                        'item_id' => $item_id,
                        'qty' => format_number($qty[$k],2),
                        'grams' => format_number($grams[$k],2),
                        'rate' => format_number($rate[$k],2),
                        'amount' => format_number($amount[$k],2)
                    );
            $this->db->insert('combo_box_items', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Combo box';
    $logarray['cnt_name']='Combo box';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_combo_box_name_availablity(){
    $id=$this->input->post('id');
    $combo_box_name=$this->input->post('combo_box_name');

    $query=$this->db->query("SELECT * FROM combo_box_master WHERE id!='".$id."' and combo_box_name='".$combo_box_name."'");
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

    $query=$this->db->query("SELECT * FROM combo_box_master WHERE id!='".$id."' and barcode='".$barcode."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

function check_sku_code_availablity(){
    $id=$this->input->post('id');
    $sku_code=$this->input->post('sku_code');

    $query=$this->db->query("SELECT * FROM combo_box_master WHERE id!='".$id."' and sku_code='".$sku_code."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

function check_asin_availablity(){
    $id=$this->input->post('id');
    $asin=$this->input->post('asin');
    $res = 0;

    $query=$this->db->query("SELECT * FROM combo_box_master WHERE id!='".$id."' and asin='".$asin."'");
    $result=$query->result();

    if (count($result)>0){
        $res = 1;
    }

    $query=$this->db->query("SELECT * FROM box_master WHERE id!='".$id."' and asin='".$asin."'");
    $result=$query->result();

    if (count($result)>0){
        $res = 1;
    }

    return $res;
}
}
?>