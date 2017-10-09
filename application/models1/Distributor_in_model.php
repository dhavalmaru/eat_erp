<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Distributor_in_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_In' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select E.*, F.sales_rep_name from 
            (select C.*, D.depot_name from 
            (select A.*, B.distributor_name, B.sell_out from 
            (select * from distributor_in".$cond.") A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id)) E 
            left join 
            (select * from sales_rep_master) F 
            on (E.sales_rep_id=F.id) order by E.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_in_items($id){
    $sql = "select * from distributor_in_items where distributor_in_id = '$id'";
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

    $due_date=$this->input->post('due_date');
    if($due_date==''){
        $due_date=NULL;
    }
    else{
        $due_date=formatdate($due_date);
    }
    
    $data = array(
        'date_of_processing' => $date_of_processing,
        'depot_id' => $this->input->post('depot_id'),
        'distributor_id' => $this->input->post('distributor_id'),
        'sales_rep_id' => $this->input->post('sales_rep_id'),
        'amount' => format_number($this->input->post('total_amount'),2),
        'tax' => $this->input->post('tax'),
        'cst' => format_number($this->input->post('cst'),2),
        'cst_amount' => format_number($this->input->post('cst_amount'),2),
        'final_amount' => format_number($this->input->post('final_amount'),2),
        'due_date' => $due_date,
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('distributor_in',$data);
        $id=$this->db->insert_id();
        $action='Distributor In Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('distributor_in',$data);
        $action='Distributor In Entry Modified.';
    }

    $this->db->where('distributor_in_id', $id);
    $this->db->delete('distributor_in_items');

    $type=$this->input->post('type[]');
    $bar=$this->input->post('bar[]');
    $box=$this->input->post('box[]');
    $qty=$this->input->post('qty[]');
    $sell_rate=$this->input->post('sell_rate[]');
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
                        'distributor_in_id' => $id,
                        'type' => $type[$k],
                        'item_id' => $item_id,
                        'qty' => format_number($qty[$k],2),
                        'sell_rate' => format_number($sell_rate[$k],2),
                        'grams' => format_number($grams[$k],2),
                        'rate' => format_number($rate[$k],2),
                        'amount' => format_number($amount[$k],2)
                    );
            $this->db->insert('distributor_in_items', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_In';
    $logarray['cnt_name']='Distributor_In';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
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
        select id from transfer where status = 'Approved' and item = 'Product' and 
        depot_in_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id' 
        union all 
        select id from distributor_in where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id' and id!='$id'";
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

    // $id=2;
    // $depot_id=1;
    // $batch_id=1;
    // $product_id=1;
    // $product_type="Box";
    // $qty=100;

    if($product_type=="Bar"){
        $col_name="qty_in_bar";
        $num_of_bars_per_box=6;

        // $sql2=" union all 
        //     select sum(qty_in_box)*".$num_of_bars_per_box." as tot_qty_in_kg from distributor_in 
        //     where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id'";

        // $sql3=" union all 
        //     select sum(qty_in_box)*".$num_of_bars_per_box." as tot_qty_out from distributor_out 
        //     where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id' and id!='$id'";
        
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
        select sum(qty) as tot_qty_in_kg from transfer where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and depot_in_id = '$depot_id' and batch_id = '$batch_id' and 
        product_type = '$product_type' 
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
        (select sum(qty) as tot_qty_out from transfer where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and depot_out_id = '$depot_id' and batch_id = '$batch_id' and 
        product_type = '$product_type' 
        union all 
        select sum(".$col_name.") as tot_qty_out from distributor_out where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id' and id!='$id'".$sql3.") A";
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