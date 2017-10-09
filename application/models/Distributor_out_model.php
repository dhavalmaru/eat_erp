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
            G.amount, G.tax, G.tax_per, G.tax_amount, G.final_amount, G.due_date, G.order_no, G.order_date, G.supplier_ref, 
            G.despatch_doc_no, G.despatch_through, G.destination, G.status, G.remarks, G.created_by, G.created_on, 
            G.modified_by, G.modified_on, G.approved_by, G.approved_on, G.rejected_by, G.rejected_on, G.client_name, G.address, 
            G.city, G.pincode, ifnull(G.state, G.distributor_state) as state, G.country, G.discount, 
            G.distributor_name, G.sell_out, G.class, G.depot_name, G.depot_address, G.depot_city, G.depot_pincode, 
            G.depot_state, G.depot_state_code, G.depot_country, G.sales_rep_name, 
            concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
            G.sample_distributor_id, G.delivery_status, G.delivery_date, G.receivable_doc, G.transport_type, 
            G.vehicle_number, G.cgst, G.sgst, G.igst, G.cgst_amount, G.sgst_amount, G.igst_amount, G.reverse_charge, 
            G.shipping_address, G.distributor_consignee_id, G.con_name, G.con_address, G.con_city, G.con_pincode, 
            G.con_state, G.con_country, G.con_state_code, G.con_gst_number, G.state_code, G.round_off_amount, G.invoice_amount from 
            (select E.*, F.sales_rep_name from 
            (select C.*, D.depot_name, D.address as depot_address, D.city as depot_city, D.pincode as depot_pincode, 
                D.state as depot_state, D.state_code as depot_state_code, D.country as depot_country from 
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

function get_dist_consignee($distributor_id){
    $sql = "select id, concat(con_address, ', ', con_city, ' - ', con_pincode, ', ', con_state) as address 
            from distributor_consignee where distributor_id = '$distributor_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_out_data1($status='', $id=''){
    if($status!=""){
        if ($status=="Approved"){
            // $cond=" where status='Approved' and (delivery_status='Delivered' or delivery_status is null or delivery_status = '') and distributor_name!='Sample'";
            $cond=" where status='Approved' and distributor_name!='Sample'";
        } else if ($status=="pending"){
            $cond=" where status='Pending' and (delivery_status='Pending' or delivery_status is null or delivery_status = '') and distributor_name!='Sample'";
        } else if ($status=="pending_for_approval"){
            $cond=" where status='Pending' and (delivery_status='GP Issued' or delivery_status='Delivered Not Complete' or delivery_status='Delivered') and distributor_name!='Sample'";
        } else if ($status=="pending_for_delivery"){
            $cond=" where (status='Approved' or status='Rejected') and delivery_status='Pending' and distributor_name!='Sample'";
        } else if ($status=="gp_issued"){
            $cond=" where (status='Approved' or status='Rejected') and delivery_status='GP Issued' and distributor_name!='Sample'";
        } else if ($status=="delivered_not_complete"){
            $cond=" where (status='Approved' or status='Rejected') and delivery_status='Delivered Not Complete' and distributor_name!='Sample'";
        } else {
            $cond=" where status='".$status."' and distributor_name!='Sample'";
        }
        
    } else {
        $cond=" where distributor_name!='Sample'";
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
            I.final_amount,  I.status, I.created_on, I.modified_on, I.class,
            I.client_name, I.depot_name,
            I.distributor_name, I.sales_rep_name, I.user_name, 
            I.sample_distributor_id, I.delivery_status, I.location, J.sales_rep_name as del_person_name, invoice_amount from 
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
            C.amount as final_amount, 'Pending' as status, C.created_on,  C.modified_on, null as class,
            null as client_name, null as depot_name, 
            C.distributor_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, 
            null as sample_distributor_id, null as delivery_status, C.location, null as del_person_name, C.amount invoice_amount from 
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

function get_distributor_out_data($status='', $id=''){
    if($status!=""){
        if ($status=="pending_for_delivery"){
            $cond=" where (status='Approved' or status='Rejected') and delivery_status='pending'";
        } else if ($status=="gp_issued"){
            $cond=" where (status='Approved' or status='Rejected') and delivery_status='GP Issued'";
        } else if ($status=="delivered_not_complete"){
            $cond=" where (status='Approved' or status='Rejected') and delivery_status='Delivered Not Complete'";
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
            G.amount, G.tax, G.tax_per, G.tax_amount, G.final_amount, G.due_date, G.order_no, G.order_date, G.supplier_ref, 
            G.despatch_doc_no, G.despatch_through, G.destination, G.status, G.remarks, G.created_by, G.created_on, 
            G.modified_by, G.modified_on, G.approved_by, G.approved_on, G.rejected_by, G.rejected_on, G.client_name, G.address, 
            G.city, G.pincode, ifnull(G.state, G.distributor_state) as state, G.country, G.discount, 
            G.distributor_name, G.sell_out, G.class, G.depot_name, G.depot_state, G.sales_rep_name, 
            concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
            G.sample_distributor_id, G.delivery_status, G.delivery_date, G.receivable_doc, G.location, G.transport_type, 
            G.vehicle_number, G.cgst, G.sgst, G.igst, G.cgst_amount, G.sgst_amount, G.igst_amount, G.reverse_charge, 
            G.shipping_address, G.distributor_consignee_id, G.con_name, G.con_address, G.con_city, G.con_pincode, G.con_state,
            G.con_country, G.con_state_code, G.con_gst_number, G.state_code, G.sample_type, G.gifting_remarks, 
            G.promoter_sales_rep_id, G.blogger_name, G.blogger_address, G.blogger_phone_no, G.blogger_email_id, 
            G.round_off_amount, G.invoice_amount from 
            (select E.*, F.sales_rep_name from 
            (select Q.*, D.depot_name, D.state as depot_state from 
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
            on (G.modified_by=H.id) 

            union all 

            select concat('s_',C.id) as d_id, null as id, C.date_of_processing, null as invoice_no, null as voucher_no, null as gate_pass_no, null as depot_id, 
            replace(C.distributor_id,'d_','') as distributor_id, C.created_by as sales_rep_id, C.amount, null as tax, null as tax_per, null as tax_amount, 
            C.amount as final_amount, null as due_date, null as order_no, null as order_date, null as supplier_ref, 
            null as despatch_doc_no, null as despatch_through, null as destination, 'Pending' as status, C.remarks, 
            C.created_by, C.created_on, C.modified_by, C.modified_on, C.approved_by, C.approved_on, C.rejected_by, C.rejected_on, 
            null as client_name, null as address, null as city, null as pincode, null as state, null as country, null as discount, 
            C.distributor_name, null as sell_out, null as class, null as depot_name, null as depot_state, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, null as sample_distributor_id, 
            null as delivery_status, null as delivery_date, null as receivable_doc,C.location, null as transport_type, 
            null as vehicle_number, null as cgst, null as sgst, null as igst, null as cgst_amount, null as sgst_amount, 
            null as igst_amount, null as reverse_charge, null as shipping_address, null as distributor_consignee_id, 
            null as con_name, null as con_address, null as con_city, null as con_pincode, null as on_state,
            null as con_country, null as con_state_code, null as con_gst_number, null as state_code, null as sample_type, 
            null as gifting_remarks, null as promoter_sales_rep_id, null as blogger_name, null as blogger_address, 
            null as blogger_phone_no, null as blogger_email_id, null as round_off_amount, null as invoice_amount from 
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

function get_distributor_out_expired_data($status='', $id=''){
    // if($status!=""){
    //     if ($status=="pending_for_delivery"){
    //         $cond=" where status='Approved' and delivery_status='pending' and distributor_name!='Sample'";
    //     } else if ($status=="gp_issued"){
    //         $cond=" where status='Approved' and delivery_status='GP Issued' and distributor_name!='Sample'";
    //     } else if ($status=="delivered_not_complete"){
    //         $cond=" where status='Approved' and delivery_status='Delivered Not Complete' and distributor_name!='Sample'";
    //     } else {
    //         $cond=" where status='".$status."' and distributor_name!='Sample'";
    //     }
        
    // } else {
    $cond=" where status='Approved' and distributor_name='Product Expired'";
    //}

    // if($id!=""){
    //     if($cond=="") {
    //         $cond=" where d_id='".$id."'";
    //     } else {
    //         $cond=$cond." and d_id='".$id."'";
    //     }
    // }

    $sql = "select * from 
            (select concat('d_',G.id) as d_id, G.id, G.date_of_processing, G.invoice_no, G.voucher_no, G.gate_pass_no,  
            G.distributor_id, G.sales_rep_id, 
            G.final_amount,  G.status, G.created_on, G.modified_on, G.class,
            G.client_name, G.depot_name,
            G.distributor_name, G.sales_rep_name, 
            concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
            G.sample_distributor_id, G.delivery_status, G.sample_distributor_name, G.location, G.transport_type, 
            G.vehicle_number, G.cgst, G.sgst, G.igst, G.cgst_amount, G.sgst_amount, G.igst_amount, G.reverse_charge from 
            (select E.*, F.sales_rep_name from 
            (select Q.*, D.depot_name from 
            (select N.*, P.location from 
            (select C.*, M.distributor_name as sample_distributor_name from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state,B.location_id, B.class from 
            (select * from distributor_out) A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            left join
            (select * from distributor_master) M 
            on (C.sample_distributor_id=M.id)) N 
            left join 
            (select * from location_master) P 
            on (N.location_id=P.id)) Q 
            left join
            (select * from depot_master) D 
            on (Q.depot_id=D.id)) E 
            left join 
            (select * from sales_rep_master) F 
            on (E.sales_rep_id=F.id)) G 
            left join 
            (select * from user_master) H 
            on (G.modified_by=H.id) 

            ) I".$cond."
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

    $delivery_date=$this->input->post('delivery_date');
    if($delivery_date==''){
        $delivery_date=NULL;
    } else {
        $delivery_date=formatdate($delivery_date);
    }
    
    $order_date=$this->input->post('order_date');
    if($order_date==''){
        $order_date=NULL;
    } else {
        $order_date=formatdate($order_date);
    }
    $delivery_status = $this->input->post('delivery_status');


    $distributor_consignee_id = $this->input->post('distributor_consignee_id');
    $con_name = null;
    $con_address = null;
    $con_city = null;
    $con_pincode = null;
    $con_state = null;
    $con_country = null;
    $con_state_code = null;
    $con_gst_number = null;
    $sql = "select * from distributor_consignee where id = '$distributor_consignee_id'";
    $query=$this->db->query($sql);
    $result = $query->result();
    if(count($result)>0){
        $con_name = $result[0]->con_name;
        $con_address = $result[0]->con_address;
        $con_city = $result[0]->con_city;
        $con_pincode = $result[0]->con_pincode;
        $con_state = $result[0]->con_state;
        $con_country = $result[0]->con_country;
        $con_state_code = $result[0]->con_state_code;
        $con_gst_number = $result[0]->con_gst_number;
    }

    if($this->input->post('sample_distributor_id')!=''){
        $sample_distributor_id = $this->input->post('sample_distributor_id');
    } else {
        $sample_distributor_id = null;
    }
    if($this->input->post('distributor_consignee_id')!=''){
        $distributor_consignee_id = $this->input->post('distributor_consignee_id');
    } else {
        $distributor_consignee_id = null;
    }

    $invoice_no=$this->input->post('invoice_no');
    if($invoice_no==null || $invoice_no==''){
        $sql="select * from series_master where type='Tax_Invoice'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $series=intval($result[0]->series)+1;

            $sql="update series_master set series = '$series' where type = 'Tax_Invoice'";
            $this->db->query($sql);
        } else {
            $series=1;

            $sql="insert into series_master (type, series) values ('Tax_Invoice', '$series')";
            $this->db->query($sql);
        }

        if (isset($date_of_processing)){
            $financial_year=calculateFiscalYearForDate($date_of_processing);
        } else {
            $financial_year="";
        }
        
        $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);
    }

    $data = array(
        'date_of_processing' => $date_of_processing,
        'invoice_no' => $invoice_no,
        'depot_id' => $this->input->post('depot_id'),
        'distributor_id' => $this->input->post('distributor_id'),
        'sales_rep_id' => $this->input->post('sales_rep_id'),
        'amount' => format_number($this->input->post('total_amount'),2),
        'tax' => $this->input->post('tax'),
        'tax_per' => format_number($this->input->post('tax_per'),2),
        'tax_amount' => format_number($this->input->post('tax_amount'),2),
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
        'sample_distributor_id' => $sample_distributor_id,
        'delivery_status' => $delivery_status,
        'delivery_date' => $delivery_date,
        'transport_type' => $this->input->post('transport_type'),
        'vehicle_number' => $this->input->post('vehicle_number'),
        'cgst' => format_number($this->input->post('cgst'),2),
        'sgst' => format_number($this->input->post('sgst'),2),
        'igst' => format_number($this->input->post('igst'),2),
        'cgst_amount' => format_number($this->input->post('cgst_amount'),2),
        'sgst_amount' => format_number($this->input->post('sgst_amount'),2),
        'igst_amount' => format_number($this->input->post('igst_amount'),2),
        'reverse_charge' => $this->input->post('reverse_charge'),
        'shipping_address' => $this->input->post('shipping_address'),
        'distributor_consignee_id' => $distributor_consignee_id,
        'con_name' => $con_name,
        'con_address' => $con_address,
        'con_city' => $con_city,
        'con_pincode' => $con_pincode,
        'con_state' => $con_state,
        'con_country' => $con_country,
        'con_state_code' => $con_state_code,
        'con_gst_number' => $con_gst_number,
        'round_off_amount' => format_number($this->input->post('round_off_amount'),2),
        'invoice_amount' => format_number($this->input->post('invoice_amount'),2)
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('distributor_out',$data);
        $id=$this->db->insert_id();
        $action='Distributor Out Entry Created. Delivery Status: ' . $delivery_status;
    } else {
        $this->db->where('id', $id);
        $this->db->update('distributor_out',$data);
        $action='Distributor Out Entry Modified. Delivery Status: ' . $delivery_status;
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
    $cgst_amt=$this->input->post('cgst_amt[]');
    $sgst_amt=$this->input->post('sgst_amt[]');
    $igst_amt=$this->input->post('igst_amt[]');
    $tax_amt=$this->input->post('tax_amt[]');
    $total_amt=$this->input->post('total_amt[]');

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
                        'amount' => format_number($amount[$k],2),
                        'cgst_amt' => format_number($cgst_amt[$k],2),
                        'sgst_amt' => format_number($sgst_amt[$k],2),
                        'igst_amt' => format_number($igst_amt[$k],2),
                        'tax_amt' => format_number($tax_amt[$k],2),
                        'total_amt' => format_number($total_amt[$k],2)
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


    $receivable_doc=$this->input->post('receivable_doc');
    $receivable_doc_file='receivable_doc_file';

    if(!empty($_FILES[$receivable_doc_file]['name'])) {
        $filePath='uploads/distributor_receivables/';
        $upload_path = './' . $filePath;
        if(!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $fileName = $_FILES[$receivable_doc_file]['name'];
        $extension = '';
        if(strrpos(".", $fileName)>0){
            $extension = substr($fileName, strrpos(".", $fileName)+1);
        }
        $fileName = 'doc_'.$id.$extension;

        $confi['upload_path']=$upload_path;
        $confi['allowed_types']='*';
        $confi['file_name']=$fileName;
        $confi['overwrite'] = TRUE;
        $this->load->library('upload', $confi);
        $this->upload->initialize($confi);
        $extension="";
    
        if($this->upload->do_upload($receivable_doc_file)) {
            // echo "Uploaded <br>";
        } else {
            // echo "Failed<br>";
            // echo $this->upload->data();
        }   

        $upload_data=$this->upload->data();
        $fileName=$upload_data['file_name'];
        $extension=$upload_data['file_ext'];

        $data = array(
                    'receivable_doc' => $filePath.$fileName,
                    'delivery_status' => 'Delivered'
                );
        $this->db->where('id', $id);
        $this->db->update('distributor_out', $data);
    }

    $status = $this->input->post('status');
    if($status=="InActive" || ($status=="Approved" && $delivery_status!="Pending" && $delivery_status!="GP Issued")){
        $this->set_ledger($id);
    }


    // $invoice_no = $this->tax_invoice_model->generate_tax_invoice($id);

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

function set_delivery_status() {
    $check1=$this->input->post('check');
    $delivery_status=$this->input->post('delivery_status');
    $sales_rep_id=$this->input->post('sales_rep_id');
    $status=$this->input->post('status');

    $check = array();
    $j=0;

    for($i=0; $i<count($check1); $i++){
        if($check1[$i]!='false'){
            $check[$j] = $check1[$i];
            $j = $j + 1;
        }
    }

    $distributor_out_id = implode(", ", $check);

    if($distributor_out_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        if($delivery_status=="Pending"){
            if($status!="InActive"){
                $status = "Approved";
            }
        }

        if(isset($sales_rep_id) && $sales_rep_id!=''){
            $sql = "update distributor_out set delivery_status = '$delivery_status', delivery_sales_rep_id = '$sales_rep_id', 
                    status = '$status', modified_by = '$curusr', modified_on = '$now' 
                    where id in (".$distributor_out_id.")";
        } else {
            $sql = "update distributor_out set delivery_status = '$delivery_status', status = '$status', 
                    modified_by = '$curusr', modified_on = '$now' 
                    where id in (".$distributor_out_id.")";
        }
        
        $this->db->query($sql);

        if($delivery_status=='GP Issued'){
            $this->tax_invoice_model->generate_gate_pass($distributor_out_id);
        }
    }
}

function approve_records() {
    $check1=$this->input->post('check');
    $dlvery_status1=$this->input->post('dlvery_status');
    $status=$this->input->post('status');

    $check = array();
    $dlvery_status = array();
    $j=0;

    for($i=0; $i<count($check1); $i++){
        if($check1[$i]!='false'){
            $check[$j] = $check1[$i];
            $dlvery_status[$j] = $dlvery_status1[$i];
            $j = $j + 1;
        }
    }

    // echo json_encode($check);
    // echo '<br/>';
    // echo json_encode($dlvery_status);
    // echo '<br/>';
    // echo $status;
    // echo '<br/>';

    $distributor_out_id = implode(", ", $check);

    if($distributor_out_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $sql = "update distributor_out set status = '$status', modified_by = '$curusr', modified_on = '$now' 
                    where id in (".$distributor_out_id.")";
        
        $this->db->query($sql);
    }

    $distributor_out_id = "";
    for($i=0; $i<count($check); $i++){
        if($dlvery_status[$i]=="GP Issued"){
            $distributor_out_id = $distributor_out_id . $check[$i] . ", ";
        }
    }

    if($distributor_out_id!=""){
        $distributor_out_id = substr($distributor_out_id, 0, strlen($distributor_out_id)-2);

        $this->tax_invoice_model->generate_gate_pass($distributor_out_id);
    }

    $distributor_out_id = "";
    for($i=0; $i<count($check); $i++){
        if($dlvery_status[$i]=="Delivered Not Complete"){
            $distributor_out_id = $check[$i];

            $this->set_ledger($distributor_out_id);
        }
    }
}

function set_ledger($id) {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $sql = "select A.*, B.id as acc_id, B.ledger_name from distributor_out A left join account_ledger_master B 
                on (A.distributor_id = B.ref_id and B.ref_type = 'Distributor') 
            where A.id = '$id' and B.status = 'Approved'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $data = array(
                    'ref_id' => $id,
                    'ref_type' => 'Distributor_Sales',
                    'entry_type' => 'Total Amount',
                    'invoice_no' => $result[0]->invoice_no,
                    'vendor_id' => $result[0]->distributor_id,
                    'acc_id' => $result[0]->acc_id,
                    'ledger_name' => $result[0]->ledger_name,
                    'type' => 'Debit',
                    'amount' => $result[0]->final_amount,
                    'status' => $result[0]->status,
                    'is_active' => '1',
                    'ledger_type' => 'Main Entry',
                    'narration' => $result[0]->remarks,
                    'ref_date' => $result[0]->date_of_processing,
                    'modified_by' => $curusr,
                    'modified_on' => $now
                );

        $ledger_array[0] = $data;
        $ledger_array[1] = $data;
        $ledger_array[2] = $data;

        // echo json_encode($ledger_array);
        // echo '<br/>';

        $ledger_array[1]['entry_type'] = 'Taxable Amount';
        $ledger_array[1]['acc_id'] = '1';
        $ledger_array[1]['ledger_name'] = 'Sales';
        $ledger_array[1]['type'] = 'Credit';
        $ledger_array[1]['amount'] = $result[0]->amount;
        $ledger_array[1]['ledger_type'] = 'Sub Entry';

        $ledger_array[2]['entry_type'] = 'Tax';
        $ledger_array[2]['acc_id'] = '2';
        $ledger_array[2]['ledger_name'] = 'GST';
        $ledger_array[2]['type'] = 'Credit';
        $ledger_array[2]['amount'] = $result[0]->tax_amount;
        $ledger_array[2]['ledger_type'] = 'Sub Entry';

        // echo json_encode($ledger_array);
        // echo '<br/>';


        $sql = "select * from account_ledger_entries where ref_id = '$id' and 
                ref_type = 'Distributor_Sales'";
        $query=$this->db->query($sql);
        $data =  $query->result();
        if (count($data)>0){
            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales');
            $this->db->where('entry_type', 'Total Amount');
            $this->db->update('account_ledger_entries', $ledger_array[0]);

            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales');
            $this->db->where('entry_type', 'Taxable Amount');
            $this->db->update('account_ledger_entries', $ledger_array[1]);

            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales');
            $this->db->where('entry_type', 'Tax');
            $this->db->update('account_ledger_entries', $ledger_array[2]);
        } else {
            $series = 1;
            $sql = "select * from series_master where type = 'Account_Voucher'";
            $query=$this->db->query($sql);
            $data =  $query->result();
            if (count($data)>0){
                $series = intval($data[0]->series) + 1;

                $sql = "update series_master set series = '$series' where type = 'Account_Voucher'";
                $this->db->query($sql);
            } else {
                $series = 1;

                $sql = "insert into series_master (type, series) values ('Account_Voucher', '".$series."')";
                $this->db->query($sql);
            }

            $voucher_id = $series;

            $ledger_array[0]['voucher_id'] = $voucher_id;
            $ledger_array[0]['created_by']=$curusr;
            $ledger_array[0]['created_on']=$now;

            $ledger_array[1]['voucher_id'] = $voucher_id;
            $ledger_array[1]['created_by']=$curusr;
            $ledger_array[1]['created_on']=$now;

            $ledger_array[2]['voucher_id'] = $voucher_id;
            $ledger_array[2]['created_by']=$curusr;
            $ledger_array[2]['created_on']=$now;

            $this->db->insert('account_ledger_entries', $ledger_array[0]);
            $this->db->insert('account_ledger_entries', $ledger_array[1]);
            $this->db->insert('account_ledger_entries', $ledger_array[2]);
        }

        // echo json_encode($ledger_array);
    }
}

function reject_records() {
    $check1=$this->input->post('check');
    // $dlvery_status=$this->input->post('dlvery_status');
    $status=$this->input->post('status');

    $check = array();
    $j=0;

    for($i=0; $i<count($check1); $i++){
        if($check1[$i]!='false'){
            $check[$j] = $check1[$i];
            $j = $j + 1;
        }
    }

    $distributor_out_id = implode(", ", $check);

    if($distributor_out_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $sql = "update distributor_out set delivery_status = case when delivery_status = 'Delivered Not Complete' then 'GP Issued' 
                                                                  when delivery_status = 'GP Issued' then 'Pending' 
                                                                  else 'Pending' end, 
                    status = '$status', modified_by = '$curusr', modified_on = '$now' 
                    where id in (".$distributor_out_id.")";
        
        $this->db->query($sql);
    }
}

}
?>