<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_rep_order_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('tax_invoice_model');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep_Orders' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sales_rep_id=$this->session->userdata('sales_rep_id');
    if($sales_rep_id!=""){
        if($cond=="") {
            $cond=" where sales_rep_id='".$sales_rep_id."'";
        } else {
            $cond=$cond." and sales_rep_id='".$sales_rep_id."'";
        }
    }

    $sql = "select E.* from 
            (select C.*, concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name from 
            (select A.*, B.distributor_name, B.sell_out, B.contact_person, B.contact_no, B.area from 
            (select concat('s_',id) as id, sales_rep_id, date_of_processing, distributor_id, 
                null as invoice_no, amount, status, remarks, modified_by, modified_on from sales_rep_orders 
            union all 
            select concat('d_',id) as id, sales_rep_id, date_of_processing, concat('d_',distributor_id) as distributor_id, 
                invoice_no, final_amount as amount, status, remarks, modified_by, modified_on from distributor_out) A
            left join 
            (select concat('s_',id) as id, distributor_name, margin as sell_out, contact_person, contact_no, city as area 
                from sales_rep_distributors
            union all 
            select concat('d_',E.id) as id, E.distributor_name, E.sell_out, E.contact_person, E.contact_no, E.area from 
            (select C.*, D.area from 
            (select A.*, B.contact_person, B.mobile as contact_no from 
            (select id, distributor_name, sell_out, area_id from distributor_master) A 
            left join 
            (select * from distributor_contacts) B 
            on (A.id = B.distributor_id)) C 
            left join 
            (select * from area_master) D 
            on (C.Area_id = D.id)) E) B 
            on (A.distributor_id = B.id)) C 
            left join 
            (select * from user_master) D 
            on (C.modified_by=D.id)) E ".$cond." 
            order by E.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_sales_rep_order_items($id){
    if(substr($id, 0, 1)=="d"){
        $sql = "select * from distributor_out_items where distributor_out_id = '".substr($id, 2)."'";
    } else {
        $sql = "select * from sales_rep_order_items where sales_rep_order_id = '".substr($id, 2)."'";
    }
    
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $sales_rep_id=$this->session->userdata('sales_rep_id');

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    } else {
        $date_of_processing=formatdate($date_of_processing);
    }

    $data = array(
        'sales_rep_id' => $sales_rep_id,
        'date_of_processing' => $date_of_processing,
        'distributor_id' => $this->input->post('distributor_id'),
        'amount' => format_number($this->input->post('total_amount'),2),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sales_rep_orders',$data);
        $id=$this->db->insert_id();
        $action='Order Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('sales_rep_orders',$data);
        $action='Order Entry Modified.';
    }

    $this->db->where('sales_rep_order_id', $id);
    $this->db->delete('sales_rep_order_items');

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
                        'sales_rep_order_id' => $id,
                        'type' => $type[$k],
                        'item_id' => $item_id,
                        'qty' => format_number($qty[$k],2),
                        'sell_rate' => format_number($sell_rate[$k],2),
                        'grams' => format_number($grams[$k],2),
                        'rate' => format_number($rate[$k],2),
                        'amount' => format_number($amount[$k],2)
                    );
            $this->db->insert('sales_rep_order_items', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_Rep_Order';
    $logarray['cnt_name']='Sales_Rep_Order';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    return $id;
}
}
?>