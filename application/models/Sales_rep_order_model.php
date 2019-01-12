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
    // if($status!=""){
    //     $cond=" where status='".$status."'";
    // } else {
    //     $cond="";
    // }

    $cond=" where status='Approved'";

    if(strtoupper(trim($status))=="PENDING"){
        if($cond=="") {
            $cond=" where delivery_status='pending'";
        } else {
            $cond=$cond." and delivery_status='pending'";
        }
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
                null as invoice_no, amount, status, remarks, modified_by, modified_on, delivery_status from sales_rep_orders 
            union all 
            select concat('d_',id) as id, sales_rep_id, date_of_processing, concat('d_',distributor_id) as distributor_id, 
                invoice_no, final_amount as amount, status, remarks, modified_by, modified_on, delivery_status from distributor_out) A
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
            and E.date_of_processing = date(now()) order by E.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}


function get_data1($status='', $id=''){
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
            on (C.modified_by=D.id)) E ".$cond." and
           E.date_of_processing = date(now()) order by E.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}


function get_distributor_out_data1($status='', $id=''){
    $curusr = $this->session->userdata('session_id');

    if($status!=""){
        // if ($status=="Approved"){
        //     // $cond=" where status='Approved' and (delivery_status='Delivered' or delivery_status is null or delivery_status = '') and distributor_name!='Sample'";
        //     $cond=" where status='Approved' and distributor_name!='Sample'";
        // } else if ($status=="pending"){
        //     $cond=" where status='Pending' and (delivery_status is null or delivery_status = '' or modified_by = '$curusr') and distributor_name!='Sample'";
        // } else if ($status=="pending_for_approval"){
        //     $cond=" where status='Pending' and (delivery_status='Pending' or delivery_status='GP Issued' or delivery_status='Delivered Not Complete' or delivery_status='Delivered') and distributor_name!='Sample' and modified_by != '$curusr'";
        // } else if ($status=="pending_for_delivery"){
        //     $cond=" where (status='Approved' or status='Rejected') and delivery_status='Pending' and distributor_name!='Sample'";
        // } else if ($status=="gp_issued"){
        //     $cond=" where (status='Approved' or status='Rejected') and delivery_status='GP Issued' and distributor_name!='Sample'";
        // } else if ($status=="delivered_not_complete"){
        //     $cond=" where (status='Approved' or status='Rejected') and delivery_status='Delivered Not Complete' and distributor_name!='Sample'";
        // } else {
        //     $cond=" where status='".$status."' and distributor_name!='Sample'";
        // }
        
        if ($status=="Approved"){
            $cond=" where status='Approved' and (distributor_id!='1' and distributor_id!='189')";
        } else if ($status=="pending"){
            $cond=" where ((status='Pending' and (delivery_status is null or delivery_status = '')) or status='Rejected') and 
                            (distributor_id!='1' and distributor_id!='189')";
        } else if ($status=="pending_for_approval"){
            $cond=" where ((status='Pending' and (delivery_status='Pending' or delivery_status='GP Issued' or 
                                delivery_status='Delivered Not Complete' or delivery_status='Delivered')) or status='Deleted') and 
                                (distributor_id!='1' and distributor_id!='189')";
        } else if ($status=="pending_for_delivery"){
            $cond=" where status='Approved' and delivery_status='Pending' and (distributor_id!='1' and distributor_id!='189')";
        } else if ($status=="gp_issued"){
            $cond=" where status='Approved' and delivery_status='GP Issued' and (distributor_id!='1' and distributor_id!='189')";
        } else if ($status=="delivered_not_complete"){
            $cond=" where status='Approved' and delivery_status='Delivered Not Complete' and 
                            (distributor_id!='1' and distributor_id!='189')";
        } else {
            $cond=" where status='".$status."' and (distributor_id!='1' and distributor_id!='189')";
        }
    } else {
        // $cond=" where distributor_name!='Sample'";
        $cond=" where (distributor_id!='1' and distributor_id!='189')";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where d_id='".$id."'";
        } else {
            $cond=$cond." and d_id='".$id."'";
        }
    }
    
    $sql = "select * from 
            (select concat('d_',I.id) as d_id, I.id, I.date_of_processing, I.invoice_no, I.voucher_no, I.gate_pass_no,  
            I.distributor_id, I.sales_rep_id, 
            I.final_amount,  I.status, I.created_on, I.modified_by, I.modified_on, I.class,
            I.client_name, I.depot_name,
            I.distributor_name, I.sales_rep_name, I.user_name, I.sample_distributor_id, I.delivery_status, I.location, 
            J.sales_rep_name as del_person_name, I.invoice_amount, I.invoice_date,I.order_no from 
            (select G.*, concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name from 
            (select E.*, F.sales_rep_name from 
            (select Q.*, D.depot_name from 
            (select C.*, P.location from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state,B.location_id, B.class from 
            (select * from distributor_out) A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            left join 
            (select * from location_master) P 
            on (C.location_id=P.id)) Q 
            left join
            (select * from depot_master) D 
            on (Q.depot_id=D.id)) E 
            left join 
            (select * from sales_rep_master) F 
            on (E.sales_rep_id=F.id)) G 
            left join 
            (select * from user_master) H 
            on (G.modified_by=H.id)) I 
            left join 
            (select * from sales_rep_master) J 
            on (I.delivery_sales_rep_id=J.id) 

            union all 

            select concat('s_',C.id) as d_id, null as id, C.date_of_processing, null as invoice_no, null as voucher_no, null as gate_pass_no, 
            replace(C.distributor_id,'d_','') as distributor_id, C.created_by as sales_rep_id, 
            C.amount as final_amount, 'Pending' as status, C.created_on, C.modified_by, C.modified_on, null as class,
            null as client_name, null as depot_name, 
            C.distributor_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, 
            null as sample_distributor_id, null as delivery_status, C.location, null as del_person_name, C.amount as invoice_amount, 
            null as invoice_date,null as order_no from 
            (select A.*, B.distributor_name, B.state, B.sell_out, B.contact_person, B.contact_no, B.area, B.location from 
            (select * from sales_rep_orders where status = 'Approved') A 
            left join 
            (select concat('s_',id) as id, distributor_name, state, margin as sell_out, contact_person, contact_no, city as area , null as location
                from sales_rep_distributors 
            union all 
            select concat('d_',E.id) as id, E.distributor_name, E.state, E.sell_out, E.contact_person, E.contact_no, E.area, E.location from 
            (select M.*, L.location from 
            (select C.*, D.area from 
            (select A.*, B.contact_person, B.mobile as contact_no from 
            (select id, distributor_name, state, sell_out, area_id, location_id from distributor_master) A 
            left join 
            (select * from distributor_contacts) B 
            on (A.id = B.distributor_id)) C 
            left join 
            (select * from area_master) D 
            on (C.Area_id = D.id)) M
            left join
            (select * from location_master) L 
            on (M.location_id = L.id))E) B 
            on (A.distributor_id = B.id)) C 
            left join 
            (select * from user_master) D 
            on (C.modified_by=D.id)) I".$cond."
            order by I.modified_on desc";

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