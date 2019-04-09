<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Order_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('tax_invoice_model');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_Out' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id=''){
    $curusr = $this->session->userdata('session_id');

    if($status!=""){
        if ($status=="delivered"){
            $cond=" where (status='Approved' or status='Active') and delivery_status = 'Delivered' and 
                        ((distributor_id!='1' and distributor_id!='189' and distributor_id!='d_1' and 
                            distributor_id!='d_189') or distributor_id is null)";
        } else if ($status=="pending"){
            $cond=" where ((status='Approved' or status='Active') and (delivery_status is null or delivery_status = '')) and 
                        ((distributor_id!='1' and distributor_id!='189' and distributor_id!='d_1' and 
                            distributor_id!='d_189') or distributor_id is null)";
        } else if ($status=="cancelled"){
            $cond=" where (status='Approved' or status='Active') and delivery_status='Cancelled' and 
                        ((distributor_id!='1' and distributor_id!='189' and distributor_id!='d_1' and 
                            distributor_id!='d_189') or distributor_id is null)";
        } else {
            $cond=" where status='".$status."' and ((distributor_id!='1' and distributor_id!='189' and 
                        distributor_id!='d_1' and distributor_id!='d_189') or distributor_id is null)";
        }
    } else {
        $cond=" where ((distributor_id!='1' and distributor_id!='189' and distributor_id!='d_1' and 
                    distributor_id!='d_189') or distributor_id is null)";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }
    $sql = "select * from 
            (select C.id, C.date_of_processing, C.distributor_name, C.retailer_name, 
                concat('d_',C.selected_distributor) as distributor_id, C.created_by as sales_rep_id, 
                C.amount as final_amount, C.status, C.created_on, C.modified_by, C.modified_on, 
                C.delivery_status, C.location, C.amount as invoice_amount, C.state, 
                C.sell_out, C.contact_person, C.contact_no, C.gst_number, C.area, C.zone, C.remarks, 
                concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
                concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, 
                null as invoice_no, null as voucher_no, null as gate_pass_no, null as class, 
                null as client_name, null as depot_name, null as sample_distributor_id, 
                null as del_person_name, null as invoice_date, null as order_no from 
            (select A.*, B.retailer_name, B.state, B.sell_out, B.contact_person, B.contact_no, 
                B.area, B.location, B.gst_number, B.zone from 
            (select A.*, B.distributor_name from sales_rep_orders A left join distributor_master B 
                on (A.selected_distributor = B.id) where A.status = 'Approved' or A.status = 'Active') A 
            left join 
            (select G.*, H.zone from 
            (select E.*, F.location from 
            (select C.*, D.area from 
            (select concat('s_',A.id) as id, A.distributor_name as retailer_name, A.gst_number, 
                    A.state, A.margin as sell_out, A.contact_person, A.contact_no, 
                    A.area_id, A.location_id, A.zone_id 
                from sales_rep_distributors A 
            union all 
            select concat('d_',A.id) as id, A.distributor_name as retailer_name, A.gst_number, 
                    A.state, A.sell_out, group_concat(distinct B.contact_person) as contact_person, 
                    group_concat(distinct B.mobile) as contact_no, 
                    A.area_id, A.location_id, A.zone_id 
                from distributor_master A left join distributor_contacts B on (A.id = B.distributor_id) 
                    group by A.id, A.distributor_name, A.gst_number, A.state, A.sell_out, 
                        A.area_id, A.location_id, A.zone_id) C 
            left join 
            (select * from area_master) D 
            on (C.Area_id = D.id)) E 
            left join
            (select * from location_master) F 
            on (E.location_id = F.id)) G 
            left join
            (select * from zone_master) H 
            on (G.zone_id = H.id)) B 
            on (A.distributor_id = B.id)) C 
            left join 
            (select * from user_master) D 
            on (C.modified_by=D.id)) I".$cond."
            order by I.modified_on desc";

    // echo $sql;

    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributors($status='', $id=''){
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

    $sql = "select A.* from 
            (select concat('d_',id) as id, distributor_name, sell_out, status, sales_rep_id from distributor_master 
            union all 
            select concat('s_',id) as id, distributor_name, margin as sell_out, status, sales_rep_id from sales_rep_distributors) A 
            ".$cond." order by A.distributor_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_order_items($id){
    $sql = "select * from sales_rep_order_items where sales_rep_order_id = '".$id."'";
    $query=$this->db->query($sql);
    return $query->result();
}

function set_delivery_status() {
    $check1=$this->input->post('check');
    $delivery_status=$this->input->post('delivery_status');

    $check = array();
    $j=0;

    for($i=0; $i<count($check1); $i++){
        if($check1[$i]!='false'){
            $check[$j] = $check1[$i];
            $j = $j + 1;
        }
    }

    $order_id = implode(", ", $check);

    if($order_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        if($delivery_status=="Pending"){
            if($status!="InActive"){
                $status = "Approved";
            }
        }

        $sql = "update sales_rep_orders set delivery_status = '$delivery_status', 
                modified_by = '$curusr', modified_on = '$now' 
                where id in (".$order_id.")";
        
        $this->db->query($sql);
    }
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $submit_val = $this->input->post('submit');

    $data = array(
        'delivery_status' => $submit_val,
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    $this->db->where('id', $id);
    $this->db->update('sales_rep_orders',$data);
    $action='Order Entry '.$submit_val.'.';

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_Rep_Order';
    $logarray['cnt_name']='Sales_Rep_Order';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    return $id;
}
}
?>