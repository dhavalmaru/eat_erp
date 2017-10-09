<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Distributor_transfer_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_Transfer' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select C.*, D.distributor_name as distributor_in_name from 
            (select A.*, B.distributor_name as distributor_out_name from 
            (select * from distributor_transfer".$cond.") A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_out_id=B.id)) C 
            left join 
            (select * from distributor_master) D 
            on (C.distributor_in_id=D.id) order by C.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_transfer_items($id){
    $sql = "select * from distributor_transfer_items where distributor_transfer_id = '$id'";
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
        'distributor_out_id' => $this->input->post('distributor_out_id'),
        'distributor_in_id' => $this->input->post('distributor_in_id'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('distributor_transfer',$data);
        $id=$this->db->insert_id();
        $action='Distributor Transfer Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('distributor_transfer',$data);
        $action='Distributor Transfer Entry Modified.';
    }

    $this->db->where('distributor_transfer_id', $id);
    $this->db->delete('distributor_transfer_items');
    
    $type=$this->input->post('type[]');
    $raw_material=$this->input->post('raw_material[]');
    $bar=$this->input->post('bar[]');
    $box=$this->input->post('box[]');
    $qty=$this->input->post('qty[]');

    for ($k=0; $k<count($type); $k++) {
        if(isset($type[$k]) and $type[$k]!="") {
            if($type[$k]=="Bar"){
                $item_id=$bar[$k];
            } else {
                $item_id=$box[$k];
            }
            $data = array(
                        'distributor_transfer_id' => $id,
                        'type' => $type[$k],
                        'item_id' => $item_id,
                        'qty' => format_number($qty[$k],2)
                    );
            $this->db->insert('distributor_transfer_items', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_transfer';
    $logarray['cnt_name']='Distributor_transfer';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_raw_material_availablity(){
    $id=$this->input->post('id');
    $distributor_id=$this->input->post('distributor_id');
    $raw_material_id=$this->input->post('raw_material_id');

    $sql="select id from raw_material_in 
        where status = 'Approved' and raw_material_id = '$raw_material_id' and distributor_id = '$distributor_id' 
        union all 
        select id from distributor_transfer where status = 'Approved' and item = 'Raw Material' and 
        raw_material_id = '$raw_material_id' and distributor_in_id = '$distributor_id' and id!='$id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)==0){
        return 1;
    } else {
        return 0;
    }
}

function check_raw_material_qty_availablity(){
    $id=$this->input->post('id');
    $distributor_id=$this->input->post('distributor_id');
    $raw_material_id=$this->input->post('raw_material_id');
    $qty=floatval(format_number($this->input->post('qty')));

    $sql="select sum(A.tot_qty_in_kg) as tot_qty_in_kg from 
        (select sum(qty_in_kg) as tot_qty_in_kg from raw_material_in 
        where status = 'Approved' and raw_material_id = '$raw_material_id' and distributor_id = '$distributor_id' 
        union all 
        select sum(qty) as tot_qty_in_kg from distributor_transfer where status = 'Approved' and item = 'Raw Material' and 
        raw_material_id = '$raw_material_id' and distributor_in_id = '$distributor_id' and id!='$id') A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_in_kg=floatval($result[0]->tot_qty_in_kg);
    } else {
        $tot_qty_in_kg=0;
    }

    $sql="select sum(A.tot_qty_out) as tot_qty_out from 
        (select sum(qty_out) as tot_qty_out from batch_raw_material 
        Where raw_material_id = '$raw_material_id' and batch_processing_id in (select distinct(id) as id from batch_processing 
        where status = 'Approved' and distributor_id = '$distributor_id') 
        union all 
        select sum(qty) as tot_qty_out from distributor_transfer where status = 'Approved' and item = 'Raw Material' and 
        raw_material_id = '$raw_material_id' and distributor_out_id = '$distributor_id' and id!='$id') A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_out=floatval($result[0]->tot_qty_out);
    } else {
        $tot_qty_out=0;
    }

    if (($tot_qty_in_kg-$tot_qty_out-$qty)<0){
        return 1;
    } else {
        return 0;
    }
}

function check_product_availablity(){
    $id=$this->input->post('id');
    $distributor_id=$this->input->post('distributor_id');
    $batch_id=$this->input->post('batch_id');
    $product_id=$this->input->post('product_id');

    // $id=1;
    // $distributor_id=1;
    // $batch_id=1;
    // $product_id=1;

    $sql="select id from batch_processing 
        where status = 'Approved' and distributor_id = '$distributor_id' and product_id = '$product_id' and id='$batch_id' 
        union all 
        select id from distributor_transfer where status = 'Approved' and item = 'Product' and 
        distributor_in_id = '$distributor_id' and product_id = '$product_id' and batch_id = '$batch_id' and id!='$id' 
        union all 
        select id from distributor_in where status = 'Approved' and 
        distributor_id = '$distributor_id' and product_id = '$product_id' and batch_id = '$batch_id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)==0){
        return 1;
    } else {
        return 0;
    }
}

function check_product_qty_availablity(){
    $id=$this->input->post('id');
    $distributor_id=$this->input->post('distributor_id');
    $batch_id=$this->input->post('batch_id');
    $product_id=$this->input->post('product_id');
    $product_type=$this->input->post('product_type');
    $qty=floatval(format_number($this->input->post('qty')));

    // $id=1;
    // $distributor_id=1;
    // $batch_id=1;
    // $product_id=1;
    // $product_type="Bar";
    // $qty=500;

    if($product_type=="Bar"){
        $col_name="qty_in_bar";
        $num_of_bars_per_box=6;

        // $sql2=" union all 
        //     select sum(qty_in_box)*".$num_of_bars_per_box." as tot_qty_in_kg from distributor_in 
        //     where status = 'Approved' and distributor_id = '$distributor_id' and product_id = '$product_id' and batch_id = '$batch_id'";

        // $sql3=" union all 
        //     select sum(qty_in_box)*".$num_of_bars_per_box." as tot_qty_out from distributor_out 
        //     where status = 'Approved' and distributor_id = '$distributor_id' and product_id = '$product_id' and batch_id = '$batch_id'";
            
        $sql2="";
        $sql3="";
    } else {
        $col_name="qty_in_box";
        $sql2="";
        $sql3="";
    }

    $sql="select sum(A.tot_qty_in_kg) as tot_qty_in_kg from 
        (select sum(".$col_name.") as tot_qty_in_kg from batch_processing 
        where status = 'Approved' and product_id = '$product_id' and distributor_id = '$distributor_id' and id='$batch_id' 
        union all 
        select sum(qty) as tot_qty_in_kg from distributor_transfer where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and distributor_in_id = '$distributor_id' and batch_id = '$batch_id' and 
        product_type = '$product_type' and id!='$id' 
        union all 
        select sum(".$col_name.") as tot_qty_in_kg from distributor_in where status = 'Approved' and 
        distributor_id = '$distributor_id' and product_id = '$product_id' and batch_id = '$batch_id'".$sql2.") A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_in_kg=floatval($result[0]->tot_qty_in_kg);
    } else {
        $tot_qty_in_kg=0;
    }
    // echo $this->db->last_query().'<br>';
    // echo $tot_qty_in_kg.'<br>';

    $sql="select sum(A.tot_qty_out) as tot_qty_out from 
        (select sum(qty) as tot_qty_out from distributor_transfer where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and distributor_out_id = '$distributor_id' and batch_id = '$batch_id' and 
        product_type = '$product_type' and id!='$id' 
        union all 
        select sum(".$col_name.") as tot_qty_out from distributor_out where status = 'Approved' and 
        distributor_id = '$distributor_id' and product_id = '$product_id' and batch_id = '$batch_id'".$sql3.") A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_out=floatval($result[0]->tot_qty_out);
    } else {
        $tot_qty_out=0;
    }
    // echo $this->db->last_query().'<br>';
    // echo $tot_qty_out.'<br>';

    if (($tot_qty_in_kg-$tot_qty_out-$qty)<0){
        return 1;
    } else {
        return 0;
    }
}
}
?>