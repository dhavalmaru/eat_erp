<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Distributor_out_model Extends CI_Model{

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

    $sql = "select G.id, G.date_of_processing, G.invoice_no, G.voucher_no, G.gate_pass_no, G.depot_id, G.distributor_id, G.sales_rep_id, 
            G.amount, G.tax, G.cst, G.cst_amount, G.final_amount, G.due_date, G.order_no, G.order_date, G.supplier_ref, 
            G.despatch_doc_no, G.despatch_through, G.destination, G.status, G.remarks, G.created_by, G.created_on, 
            G.modified_by, G.modified_on, G.approved_by, G.approved_on, G.rejected_by, G.rejected_on, G.client_name, G.address, 
            G.city, G.pincode, ifnull(G.state, G.distributor_state) as state, G.country, G.discount, 
            G.distributor_name, G.sell_out, G.class, G.depot_name, G.sales_rep_name, 
            concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
            G.sample_distributor_id, G.delivery_status from 
            (select E.*, F.sales_rep_name from 
            (select C.*, D.depot_name from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state, B.class from 
            (select * from distributor_out".$cond.") A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id)) E 
            left join 
            (select * from sales_rep_master) F 
            on (E.sales_rep_id=F.id)) G 
            left join 
            (select * from user_master) H 
            on (G.modified_by=H.id) order by G.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_out_data($status='', $id=''){
    if($status!=""){
        if ($status=="pending_for_delivery"){
            $cond=" where status='Approved' and delivery_status='pending'";
        } else {
            $cond=" where status='".$status."'";
        }
        
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where d_id='".$id."'";
        } else {
            $cond=$cond." and d_id='".$id."'";
        }
    }

    $sql = "select * from 
            (select concat('d_',G.id) as d_id, G.id, G.date_of_processing, G.invoice_no, G.voucher_no, G.gate_pass_no, G.depot_id, 
            G.distributor_id, G.sales_rep_id, 
            G.amount, G.tax, G.cst, G.cst_amount, G.final_amount, G.due_date, G.order_no, G.order_date, G.supplier_ref, 
            G.despatch_doc_no, G.despatch_through, G.destination, G.status, G.remarks, G.created_by, G.created_on, 
            G.modified_by, G.modified_on, G.approved_by, G.approved_on, G.rejected_by, G.rejected_on, G.client_name, G.address, 
            G.city, G.pincode, ifnull(G.state, G.distributor_state) as state, G.country, G.discount, 
            G.distributor_name, G.sell_out, G.class, G.depot_name, G.sales_rep_name, 
            concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
            G.sample_distributor_id, G.delivery_status from 
            (select E.*, F.sales_rep_name from 
            (select C.*, D.depot_name from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state, B.class from 
            (select * from distributor_out) A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id)) E 
            left join 
            (select * from sales_rep_master) F 
            on (E.sales_rep_id=F.id)) G 
            left join 
            (select * from user_master) H 
            on (G.modified_by=H.id) 

            union all 

            select concat('s_',C.id) as d_id, null as id, C.date_of_processing, null as invoice_no, null as voucher_no, null as gate_pass_no, null as depot_id, 
            replace(C.distributor_id,'d_','') as distributor_id, C.created_by as sales_rep_id, C.amount, null as tax, null as cst, null as cst_amount, 
            C.amount as final_amount, null as due_date, null as order_no, null as order_date, null as supplier_ref, 
            null as despatch_doc_no, null as despatch_through, null as destination, 'Pending' as status, C.remarks, 
            C.created_by, C.created_on, C.modified_by, C.modified_on, C.approved_by, C.approved_on, C.rejected_by, C.rejected_on, 
            null as client_name, null as address, null as city, null as pincode, null as state, null as country, null as discount, 
            C.distributor_name, null as sell_out, null as class, null as depot_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, 
            null as sample_distributor_id, null as delivery_status from 
            (select A.*, B.distributor_name, B.state, B.sell_out, B.contact_person, B.contact_no, B.area from 
            (select * from sales_rep_orders where status = 'Approved') A 
            left join 
            (select concat('s_',id) as id, distributor_name, state, margin as sell_out, contact_person, contact_no, city as area 
                from sales_rep_distributors 
            union all 
            select concat('d_',E.id) as id, E.distributor_name, E.state, E.sell_out, E.contact_person, E.contact_no, E.area from 
            (select C.*, D.area from 
            (select A.*, B.contact_person, B.mobile as contact_no from 
            (select id, distributor_name, state, sell_out, area_id from distributor_master) A 
            left join 
            (select * from distributor_contacts) B 
            on (A.id = B.distributor_id)) C 
            left join 
            (select * from area_master) D 
            on (C.Area_id = D.id)) E) B 
            on (A.distributor_id = B.id)) C 
            left join 
            (select * from user_master) D 
            on (C.modified_by=D.id)) I".$cond."
            order by I.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_out_items($d_id){
    if(strrpos($d_id, "s_") !== false){
        $id = substr($d_id, 2);
        $sql = "select * from sales_rep_order_items where sales_rep_order_id = '$id'";
    } else {
        $id = substr($d_id, 2);
        $sql = "select * from distributor_out_items where distributor_out_id = '$id'";
    }
    
    $query=$this->db->query($sql);
    return $query->result();
}

// function get_distributor_payment_details($id){
//     $sql = "select A.*, B.payment_mode, B.ref_no, B.invoice_no, B.payment_date, B.payment_amount, B.deposit_date from 
//             (select * from payment_details where distributor_out_id = '$id') A 
//             left join 
//             (select * from payment_details_items) B 
//             on (A.id=B.payment_id)";
//     $query=$this->db->query($sql);
//     return $query->result();
// }

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    } else {
        $date_of_processing=formatdate($date_of_processing);
    }

    $due_date=$this->input->post('due_date');
    if($due_date==''){
        $due_date=NULL;
    } else {
        $due_date=formatdate($due_date);
    }
    
    $order_date=$this->input->post('order_date');
    if($order_date==''){
        $order_date=NULL;
    } else {
        $order_date=formatdate($order_date);
    }
    $delivery_status = $this->input->post('delivery_status');
    
    $data = array(
        'date_of_processing' => $date_of_processing,
        'invoice_no' => $this->input->post('invoice_no'),
        'depot_id' => $this->input->post('depot_id'),
        'distributor_id' => $this->input->post('distributor_id'),
        'sales_rep_id' => $this->input->post('sales_rep_id'),
        'amount' => format_number($this->input->post('total_amount'),2),
        'tax' => $this->input->post('tax'),
        'cst' => format_number($this->input->post('cst'),2),
        'cst_amount' => format_number($this->input->post('cst_amount'),2),
        'final_amount' => format_number($this->input->post('final_amount'),2),
        'due_date' => $due_date,
        'order_no' => $this->input->post('order_no'),
        'order_date' => $order_date,
        'supplier_ref' => $this->input->post('supplier_ref'),
        'despatch_doc_no' => $this->input->post('despatch_doc_no'),
        'despatch_through' => $this->input->post('despatch_through'),
        'destination' => $this->input->post('destination'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'client_name' => $this->input->post('client_name'),
        'address' => $this->input->post('address'),
        'city' => $this->input->post('city'),
        'pincode' => $this->input->post('pincode'),
        'state' => $this->input->post('state'),
        'country' => $this->input->post('country'),
        'discount' => format_number($this->input->post('discount'),2),
        'sample_distributor_id' => $this->input->post('sample_distributor_id'),
        'delivery_status' => $delivery_status
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('distributor_out',$data);
        $id=$this->db->insert_id();
        $action='Distributor Out Entry Created. Delevery Status: ' . $delivery_status;
    } else {
        $this->db->where('id', $id);
        $this->db->update('distributor_out',$data);
        $action='Distributor Out Entry Modified. Delevery Status: ' . $delivery_status;
    }

    $this->db->where('distributor_out_id', $id);
    $this->db->delete('distributor_out_items');

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
                        'distributor_out_id' => $id,
                        'type' => $type[$k],
                        'item_id' => $item_id,
                        'qty' => format_number($qty[$k],2),
                        'sell_rate' => format_number($sell_rate[$k],2),
                        'grams' => format_number($grams[$k],2),
                        'rate' => format_number($rate[$k],2),
                        'amount' => format_number($amount[$k],2)
                    );
            $this->db->insert('distributor_out_items', $data);
        }
    }

    $d_id = $this->input->post('d_id');
    if(strrpos($d_id, "s_") !== false){
        $sql = "update sales_rep_orders set status = 'Active', order_id = '$id', 
                modified_by = '$curusr', modified_on = '$now' 
                where id = '".substr($d_id, 2)."'";
        $this->db->query($sql);
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_Out';
    $logarray['cnt_name']='Distributor_Out';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);


    $invoice_no = $this->tax_invoice_model->generate_tax_invoice($id);


    // $payment_mode=$this->input->post('payment_mode');

    // if(isset($payment_mode) and $payment_mode!="") {
    //     $payment_id=$this->input->post('payment_id');
    //     $ref_no=$this->input->post('ref_no');
    //     // $invoice_no=$this->input->post('invoice_no');
    //     // $payment_date=$this->input->post('payment_date[]');
    //     $payment_amount=$this->input->post('payment_amount');
    //     $date_of_payment=$this->input->post('date_of_payment');
    //     if($date_of_payment==''){
    //         $date_of_payment=NULL;
    //     } else {
    //         $date_of_payment=formatdate($date_of_payment);
    //     }
    //     $d_date=$this->input->post('deposit_date');
    //     if($d_date==''){
    //         $d_date=NULL;
    //     } else {
    //         $d_date=formatdate($d_date);
    //     }

    //     $data = array(
    //         'distributor_out_id' => $id,
    //         'date_of_payment' => $date_of_payment,
    //         'bank_id' => $this->input->post('bank_id'),
    //         'distributor_id' => $this->input->post('distributor_id'),
    //         'total_amount' => format_number($this->input->post('payment_amount'),2),
    //         'status' => $this->input->post('status'),
    //         'remarks' => $this->input->post('remarks'),
    //         'modified_by' => $curusr,
    //         'modified_on' => $now
    //     );

    //     if($payment_id=='' || $payment_id==null){
    //         $data['created_by']=$curusr;
    //         $data['created_on']=$now;

    //         $this->db->insert('payment_details',$data);
    //         $payment_id=$this->db->insert_id();
    //         $action='Payment Entry Created.';
    //     } else {
    //         $this->db->where('id', $payment_id);
    //         $this->db->update('payment_details',$data);
    //         $action='Payment Entry Modified.';
    //     }

    //     $this->db->where('payment_id', $payment_id);
    //     $this->db->delete('payment_details_items');
        
    //     $data = array(
    //                 'payment_id' => $payment_id,
    //                 'payment_mode' => $payment_mode,
    //                 'ref_no' => $ref_no,
    //                 'invoice_no' => $invoice_no,
    //                 'payment_amount' => format_number($payment_amount,2),
    //                 'deposit_date' => $d_date
    //             );
    //     $this->db->insert('payment_details_items', $data);
    // }

    // $logarray['table_id']=$payment_id;
    // $logarray['module_name']='Payment';
    // $logarray['cnt_name']='Payment';
    // $logarray['action']=$action;
    // $this->user_access_log_model->insertAccessLog($logarray);

}

// function save_payment_details($id=''){
//     $now=date('Y-m-d H:i:s');
//     $curusr=$this->session->userdata('session_id');

//     $this->db->where('distributor_out_id', $id);
//     $this->db->delete('distributor_payment_details');

//     $payment_mode=$this->input->post('payment_mode[]');
//     $ref_no=$this->input->post('ref_no[]');
//     $payment_date=$this->input->post('payment_date[]');
//     $payment_amount=$this->input->post('payment_amount[]');
//     $deposit_date=$this->input->post('deposit_date[]');

//     for ($k=0; $k<count($payment_mode); $k++) {
//         if(isset($payment_mode[$k]) and $payment_mode[$k]!="") {
//             $p_date=$payment_date[$k];
//             if($p_date==''){
//                 $p_date=NULL;
//             }
//             else{
//                 $p_date=formatdate($p_date);
//             }
//             $d_date=$deposit_date[$k];
//             if($d_date==''){
//                 $d_date=NULL;
//             }
//             else{
//                 $d_date=formatdate($d_date);
//             }

//             $data = array(
//                         'distributor_out_id' => $id,
//                         'payment_mode' => $payment_mode[$k],
//                         'ref_no' => $ref_no[$k],
//                         'payment_date' => $p_date,
//                         'payment_amount' => format_number($payment_amount[$k],2),
//                         'deposit_date' => $d_date
//                     );
//             $this->db->insert('distributor_payment_details', $data);
//         }
//     }

//     $action='Distributor Payment Details Modified.';

//     $logarray['table_id']=$id;
//     $logarray['module_name']='Distributor_Out';
//     $logarray['cnt_name']='Distributor_Out';
//     $logarray['action']=$action;
//     $this->user_access_log_model->insertAccessLog($logarray);
// }
}
?>