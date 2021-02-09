<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Bar_to_bar_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Bar_to_box' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select A.*, B.depot_name as depot_name, D.product_name as product_out_name, E.product_name as product_in_name from 
            (select * from bar_to_bar".$cond.") A 
            left join 
            (select * from depot_master) B 
            on (A.depot_id=B.id) 
            left join 
            (select * from product_master) D 
            on (A.product_out_id=D.id) 
            left join 
            (select * from product_master) E 
            on (A.product_in_id=E.id) 
            order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_transfer=$this->input->post('date_of_transfer');
    if($date_of_transfer=='') {
        $date_of_transfer=NULL;
    } else {
        $date_of_transfer=formatdate($date_of_transfer);
    }
    
    $data = array(
        'date_of_transfer' => $date_of_transfer,
        'depot_id' => $this->input->post('depot_id'),
        'batch_no' => $this->input->post('batch_no'),
        'product_out_id' => $this->input->post('product_out_id'),
        'product_in_id' => $this->input->post('product_in_id'),
        'qty' => $this->input->post('qty'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('bar_to_bar',$data);
        $id=$this->db->insert_id();
        $action='Bar To Bar Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('bar_to_bar',$data);
        $action='Bar To Bar Entry Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Bar_to_bar';
    $logarray['cnt_name']='Bar_to_bar';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    redirect(base_url().'index.php/bar_to_bar');
}

function check_product_availablity(){
    $id=$this->input->post('id');
    $depot_id=$this->input->post('depot_id');
    $batch_id=$this->input->post('batch_id');
    $product_id=$this->input->post('product_id');

    // $id=1;
    // $depot_id=1;
    // $batch_id=1;
    // $product_id=1;

    $sql="select id from batch_processing 
        where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' and id='$batch_id' 
        union all 
        select id from bar_to_bar where status = 'Approved' and item = 'Product' and 
        depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id' and id!='$id' 
        union all 
        select id from distributor_in where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id'";
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
    $depot_id=$this->input->post('depot_id');
    $batch_id=$this->input->post('batch_id');
    $product_id=$this->input->post('product_id');
    $product_type=$this->input->post('product_type');
    $qty=floatval(format_number($this->input->post('qty')));

    // $id=1;
    // $depot_id=1;
    // $batch_id=1;
    // $product_id=1;
    // $product_type="Bar";
    // $qty=500;

    if($product_type=="Bar"){
        $col_name="qty_in_bar";
        $num_of_bars_per_box=6;

        // $sql2=" union all 
        //     select sum(qty_in_box)*".$num_of_bars_per_box." as tot_qty_in_kg from distributor_in 
        //     where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id'";

        // $sql3=" union all 
        //     select sum(qty_in_box)*".$num_of_bars_per_box." as tot_qty_out from distributor_out 
        //     where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id'";
            
        $sql2="";
        $sql3="";
    } else {
        $col_name="qty_in_box";
        $sql2="";
        $sql3="";
    }

    $sql="select sum(A.tot_qty_in_kg) as tot_qty_in_kg from 
        (select sum(".$col_name.") as tot_qty_in_kg from batch_processing 
        where status = 'Approved' and product_id = '$product_id' and depot_id = '$depot_id' and id='$batch_id' 
        union all 
        select sum(qty) as tot_qty_in_kg from bar_to_bar where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and depot_id = '$depot_id' and batch_id = '$batch_id' and 
        product_type = '$product_type' and id!='$id' 
        union all 
        select sum(".$col_name.") as tot_qty_in_kg from distributor_in where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id'".$sql2.") A";
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
        (select sum(qty) as tot_qty_out from bar_to_bar where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and depot_id = '$depot_id' and batch_id = '$batch_id' and 
        product_type = '$product_type' and id!='$id' 
        union all 
        select sum(".$col_name.") as tot_qty_out from distributor_out where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id'".$sql3.") A";
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