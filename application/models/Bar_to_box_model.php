<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Bar_to_box_model Extends CI_Model{

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

    $sql = "select A.*, B.depot_name from 
            (select * from bar_to_box".$cond.") A 
            left join 
            (select * from depot_master) B 
            on (A.depot_id=B.id) order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_bar_to_box_qty($id){
    $sql = "select A.*, B.box_name from 
            (select * from bar_to_box_qty where bar_to_box_id = '$id') A 
            left join 
            (select * from box_master) B 
            on (A.box_id=B.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    }
    else{
        $date_of_processing=formatdate($date_of_processing);
    }
    
    $data = array(
        'date_of_processing' => $date_of_processing,
        'depot_id' => $this->input->post('depot_id'),
        'qty' => format_number($this->input->post('total_qty'),2),
        'grams' => format_number($this->input->post('total_grams'),2),
        'amount' => format_number($this->input->post('total_amount'),2),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('bar_to_box',$data);
        $id=$this->db->insert_id();
        $action='Bar to box Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('bar_to_box',$data);
        $action='Bar to box Entry Modified.';
    }

    $this->db->where('bar_to_box_id', $id);
    $this->db->delete('bar_to_box_qty');

    $box_id=$this->input->post('box[]');
    $qty=$this->input->post('qty[]');
    $grams=$this->input->post('grams[]');
    $rate=$this->input->post('rate[]');
    $amount=$this->input->post('amount[]');
    $batch_no=$this->input->post('batch_no[]');
    
    for ($k=0; $k<count($box_id); $k++) {
        if(isset($box_id[$k]) and $box_id[$k]!="") {
            $data = array(
                        'bar_to_box_id' => $id,
                        'box_id' => $box_id[$k],
                        'qty' => format_number($qty[$k],2),
                        'grams' => format_number($grams[$k],2),
                        'rate' => format_number($rate[$k],2),
                        'amount' => format_number($amount[$k],2),
                        'batch_no' => $batch_no[$k]
                    );
            $this->db->insert('bar_to_box_qty', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Bar_to_box';
    $logarray['cnt_name']='Bar_to_box';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_product_availablity(){
    $id=$this->input->post('id');
    $depot_id=$this->input->post('depot_id');
    $product_id=$this->input->post('product_id');

    // $id=1;
    // $depot_id=1;
    // $product_id=1;

    $sql="select id from batch_processing 
        where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' 
        union all 
        select id from transfer where status = 'Approved' and item = 'Product' and 
        depot_in_id = '$depot_id' and product_id = '$product_id' 
        union all 
        select id from distributor_in where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' and id!='$id'";
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
    $product_id=$this->input->post('product_id');
    $qty=floatval(format_number($this->input->post('qty')));

    // $id=2;
    // $depot_id=1;
    // $batch_id=1;
    // $product_id=1;
    // $qty=100;

    $sql="select sum(A.tot_qty_in) as tot_qty_in from 
        (select sum(qty_in_bar) as tot_qty_in from batch_processing 
        where status = 'Approved' and product_id = '$product_id' and depot_id = '$depot_id' 
        union all 
        select sum(qty) as tot_qty_in from transfer where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and depot_in_id = '$depot_id' and product_type = 'Bar' 
        union all 
        select sum(qty_in_bar) as tot_qty_in from distributor_in where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id') A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_in=floatval($result[0]->tot_qty_in);
    } else {
        $tot_qty_in=0;
    }
    // echo $this->db->last_query().'<br>';
    // echo $tot_qty_in_kg.'<br>';

    $sql="select sum(A.tot_qty_out) as tot_qty_out from 
        (select sum(qty) as tot_qty_out from transfer where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and depot_out_id = '$depot_id' and product_type = 'Bar' 
        union all 
        select sum(qty_in_bar) as tot_qty_out from distributor_out where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' 
        union all 
        select sum(box_qty*product_qty) as tot_qty_out from 
        (select A.box_id, B.product_id, ifnull(sum(A.qty),0) as box_qty, ifnull(sum(B.qty),0) as product_qty from 
        (select * from bar_to_box_qty where bar_to_box_id in (select distinct id from bar_to_box 
            where status = 'Approved' and depot_id = '$depot_id' and id!='$id')) A 
        left join 
        (select * from box_product) B 
        on (A.box_id = B.box_id) group by A.box_id, B.product_id) C where C.product_id = '$product_id') A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_out=floatval($result[0]->tot_qty_out);
    } else {
        $tot_qty_out=0;
    }
    // echo $this->db->last_query().'<br>';
    // echo $tot_qty_out.'<br>';

    if (($tot_qty_in-$tot_qty_out-$qty)<0){
        return 1;
    } else {
        return 0;
    }
}
}
?>