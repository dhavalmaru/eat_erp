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

function get_pending_data($id=''){
    if(strpos($id, "_")!==false){
        $id = substr($id, strpos($id, "_")+1);
    }

    $query=$this->db->query("SELECT * FROM distributor_out WHERE ref_id = '$id' and status!='InActive' and  status!='Rejected'");
    $result=$query->result();
    if (count($result)>0){
        $id = $result[0]->id;
    } else {
        $id = '';
    }

    return $id;
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

    $sql = "select G.id, G.date_of_processing, G.invoice_no, G.voucher_no, G.gate_pass_no, G.depot_id, G.distributor_id, 
            G.sales_rep_id, G.amount, G.tax, G.tax_per, G.tax_amount, G.final_amount, G.due_date, 
            G.order_no, G.order_date, G.ref_invoice_no, G.ref_invoice_details, G.ref_invoice_date, G.supplier_ref, 
            G.despatch_doc_no, G.despatch_through, G.destination, G.status, G.remarks, G.created_by, G.created_on, 
            G.modified_by, G.modified_on, G.approved_by, G.approved_on, G.rejected_by, G.rejected_on, G.client_name, G.address, 
            G.city, G.pincode, ifnull(G.state, G.distributor_state) as state, G.country, G.mobile_no, G.discount, 
            G.distributor_name, G.sell_out, G.class, G.depot_name, G.depot_address, G.depot_city, G.depot_pincode, 
            G.depot_state, G.depot_state_code, G.depot_country, G.depot_gst_no, G.sales_rep_name, 
            concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
            concat(ifnull(I.first_name,''),' ',ifnull(I.last_name,'')) as approver_name, 
            G.sample_distributor_id, G.delivery_status, G.delivery_date, G.receivable_doc, G.transport_type, 
            G.vehicle_number, G.cgst, G.sgst, G.igst, G.cgst_amount, G.sgst_amount, G.igst_amount, G.reverse_charge, 
            G.shipping_address, G.distributor_consignee_id, G.con_name, G.con_address, G.con_city, G.con_pincode, 
            G.con_state, G.con_country, G.con_state_code, G.con_gst_number, G.state_code, G.round_off_amount, G.invoice_amount, G.ref_id, 
            G.invoice_date,G.gatepass_date,G.freezed,G.gstin,G.shipping_charges from 
            (select E.*, F.sales_rep_name from 
            (select C.*, D.depot_name, D.address as depot_address, D.city as depot_city, D.pincode as depot_pincode, 
                D.state as depot_state, D.state_code as depot_state_code, D.country as depot_country, 
                D.gst_no as depot_gst_no from 
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
            on (G.modified_by=H.id) 
            left join 
            (select * from user_master) I 
            on (G.approved_by=I.id) order by G.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_dist_consignee($distributor_id){
    $sql = "select id, concat(con_address, ', ', con_city, ' - ', con_pincode, ', ', con_state) as address 
            from distributor_consignee where distributor_id = '$distributor_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_all_data(){
    $sql = "select * from distributor_out where (distributor_id!='1' and distributor_id!='189')";
    $query = $this->db->query($sql);
    return $query->result();
}

function get_data_count(){
    $sql = "select count(id) as total_count, sum(case when status='Approved' then 1 else 0 end) as active, sum(case when ((status='Pending' and (delivery_status='Pending' or delivery_status='GP Issued' or delivery_status='Delivered Not Complete' or delivery_status='Delivered')) or status='Deleted') then 1 else 0 end) as pending_for_approval, sum(case when status='Inactive' then 1 else 0 end) as inactive, sum(case when (status='Pending' and (delivery_status='' or delivery_status=null)) then 1 else 0 end) as pending, sum(case when (status='Approved' and delivery_status='Pending') then 1 else 0 end) as pending_for_delivery, sum(case when (status='Approved' and delivery_status='GP Issued') then 1 else 0 end) as gp_issued, sum(case when (status='Approved' and delivery_status='Delivered Not Complete') then 1 else 0 end) as delivered_not_complete from distributor_out where (distributor_id!='1' and distributor_id!='189')";
    $query = $this->db->query($sql);
    return $query->result();
}

function get_list_data($status='', $start=0, $length=0, $search_val=''){
    $curusr = $this->session->userdata('session_id');

    if($status!=""){
        if ($status=="Approved"){
            $cond=" where A.status='Approved' and (A.distributor_id!='1' and A.distributor_id!='189')";
        } else if ($status=="pending"){
            $cond=" where (A.status='Pending' and (A.delivery_status is null or A.delivery_status = '')) and (A.distributor_id!='1' and A.distributor_id!='189')";
        } else if ($status=="pending_for_approval"){
            $cond=" where ((A.status='Pending' and (A.delivery_status='Pending' or A.delivery_status='GP Issued' or A.delivery_status='Delivered Not Complete' or A.delivery_status='Delivered')) or A.status='Deleted') and (A.distributor_id!='1' and A.distributor_id!='189')";
        } else if ($status=="pending_for_delivery"){
            $cond=" where A.status='Approved' and A.delivery_status='Pending' and (A.distributor_id!='1' and A.distributor_id!='189')";
        } else if ($status=="gp_issued"){
            $cond=" where A.status='Approved' and A.delivery_status='GP Issued' and (A.distributor_id!='1' and A.distributor_id!='189')";
        } else if ($status=="delivered_not_complete"){
            $cond=" where A.status='Approved' and A.delivery_status='Delivered Not Complete' and (A.distributor_id!='1' and A.distributor_id!='189')";
        } else {
            $cond=" where A.status='".$status."' and (A.distributor_id!='1' and A.distributor_id!='189')";
        }
    } else {
        $cond=" where (A.distributor_id!='1' and A.distributor_id!='189')";
    }

    $cond2="";
    if($search_val!=''){
        $cond2=" and (A.id like '%".$search_val."%' or DATE_FORMAT(A.date_of_processing, '%d/%m/%Y') like '%".$search_val."%' or A.invoice_no like '%".$search_val."%' or A.voucher_no like '%".$search_val."%' or A.gate_pass_no like '%".$search_val."%' or A.final_amount like '%".$search_val."%' or A.status like '%".$search_val."%' or A.client_name like '%".$search_val."%' or A.delivery_status like '%".$search_val."%' or A.invoice_amount like '%".$search_val."%' or DATE_FORMAT(A.invoice_date, '%d/%m/%Y') like '%".$search_val."%' or A.order_no like '%".$search_val."%' or A.tracking_id like '%".$search_val."%' or A.proof_of_delivery like '%".$search_val."%' or A.shipping_charges like '%".$search_val."%' or B.distributor_name like '%".$search_val."%' or B.class like '%".$search_val."%')";
    }

    $data = array();

    $sql = "select count(A.id) as total_records from distributor_out A left join distributor_master B on (A.distributor_id=B.id) ".$cond.$cond2;
    $query=$this->db->query($sql);
    $data['count']=$query->result();

    $limit = "";
    if($start>0 && $length>0) $limit .= " limit ".$start.", ".$length;
    elseif($length>0) $limit .= " limit ".$length;

    $sql = "select concat('d_',A.id) as d_id, A.id, A.date_of_processing, A.invoice_no, A.voucher_no, A.gate_pass_no, 
                A.distributor_id, A.final_amount, A.status, A.client_name, A.delivery_status, A.invoice_amount, 
                A.invoice_date, A.order_no, A.tracking_id, A.proof_of_delivery, A.shipping_charges, A.modified_on, 
                A.distributor_name, A.class, C.location, D.depot_name, E.id as credit_debit_note_id from 
            (select A.id, A.date_of_processing, A.invoice_no, 
                A.voucher_no, A.gate_pass_no, A.distributor_id, A.depot_id, A.final_amount, A.status,
                A.client_name, A.delivery_status, A.invoice_amount, A.invoice_date, A.order_no, A.tracking_id, 
                A.proof_of_delivery, A.shipping_charges, A.modified_on, B.distributor_name, B.class, B.location_id 
            from distributor_out A 
            left join distributor_master B on (A.distributor_id=B.id) ".$cond.$cond2." 
            order by A.modified_on desc ".$limit.") A 
            left join location_master C on (A.location_id=C.id) 
            left join depot_master D on (A.depot_id=D.id) 
            left join credit_debit_note E on (A.id=E.distributor_out_id)";
    $query=$this->db->query($sql);
    $data['rows']=$query->result();

    return $data;
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
            $cond=" where (status='Pending' and (delivery_status is null or delivery_status = '')) and (distributor_id!='1' and distributor_id!='189')";
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
    
    $sql = "select Z.*, Y.id as credit_debit_note_id from 
            (select * from 
            (select concat('d_',I.id) as d_id, I.id, I.date_of_processing, I.invoice_no, 
                I.voucher_no, I.gate_pass_no, I.distributor_id, I.sales_rep_id, 
                I.final_amount,  I.status, I.created_on, I.modified_by, I.modified_on, I.class,
                I.client_name, I.depot_name, I.distributor_name, I.sales_rep_name, I.user_name, 
                I.sample_distributor_id, I.delivery_status, I.location, 
                J.sales_rep_name as del_person_name, I.invoice_amount, I.invoice_date, 
                I.order_no, I.tracking_id, I.proof_of_delivery, I.shipping_charges from 
            (select G.*, concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name from 
            (select E.*, F.sales_rep_name from 
            (select Q.*, D.depot_name from 
            (select C.*, P.location from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state, 
                B.location_id, B.class from 
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

            select concat('s_',C.id) as d_id, null as id, C.date_of_processing, null as invoice_no, 
                null as voucher_no, null as gate_pass_no, 
                replace(C.distributor_id,'d_','') as distributor_id, C.created_by as sales_rep_id, 
                C.amount as final_amount, 'Pending' as status, C.created_on, C.modified_by, 
                C.modified_on, null as class,null as tracking_id, null as client_name, 
                null as depot_name, C.distributor_name, 
                concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
                concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, 
                null as sample_distributor_id, null as delivery_status, C.location, 
                null as del_person_name, C.amount as invoice_amount, null as invoice_date, 
                null as order_no,null as proof_of_delivery, null as shipping_charges from 
            (select A.*, B.distributor_name, B.state, B.sell_out, B.contact_person, B.contact_no, 
                B.area, B.location from 
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
            on (C.modified_by=D.id)) I ".$cond." )Z
            left join
            (select * from credit_debit_note where status = 'Approved')Y
            on (Z.id=Y.distributor_out_id) 
            order by Z.modified_on desc";

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
    //query for approved ,approval pending, and all 
    $sql = "select * from 
            (select concat('d_',G.id) as d_id, G.id, G.date_of_processing, G.invoice_no, G.voucher_no, G.gate_pass_no, 
            G.depot_id, G.distributor_id, G.sales_rep_id, G.amount, G.tax, G.tax_per, G.tax_amount, G.final_amount, G.due_date, 
            G.order_no, G.order_date, G.ref_invoice_no, G.ref_invoice_details, G.ref_invoice_date, G.supplier_ref, 
            G.despatch_doc_no, G.despatch_through, G.destination, G.status, G.remarks, G.created_by, G.created_on, 
            G.modified_by, G.modified_on, G.approved_by, G.approved_on, G.rejected_by, G.rejected_on, G.client_name, G.address, 
            G.city, G.pincode, ifnull(G.state, G.distributor_state) as state, G.country, G.mobile_no, G.discount, 
            G.distributor_name, G.sell_out, G.class, G.depot_name, G.depot_state, G.sales_rep_name, 
            concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
            G.sample_distributor_id, G.delivery_status, G.delivery_date, G.receivable_doc, G.location, G.transport_type, 
            G.vehicle_number, G.cgst, G.sgst, G.igst, G.cgst_amount, G.sgst_amount, G.igst_amount, G.reverse_charge, 
            G.shipping_address, G.distributor_consignee_id, G.con_name, G.con_address, G.con_city, G.con_pincode, G.con_state,
            G.con_country, G.con_state_code, G.con_gst_number, G.state_code, G.sample_type, G.gifting_remarks, 
            G.promoter_sales_rep_id, G.blogger_name, G.blogger_address, G.blogger_phone_no, G.blogger_email_id, 
            G.round_off_amount, G.invoice_amount, G.ref_id, G.invoice_date, G.freezed, 
            G.distributor_in_type, G.basis_of_sales, G.email_from, G.email_approved_by, G.email_date_time,
            G.gstin, I.status as po_status, I.mismatch, G.shipping_charges from 
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
            left join 
            (select * from distributor_po) I 
            on (G.distributor_po_id=I.id)

            union all 

            select concat('s_',C.id) as d_id, null as id, C.date_of_processing, null as invoice_no, null as voucher_no, 
            null as gate_pass_no, null as depot_id, replace(C.distributor_id,'d_','') as distributor_id, 
            C.created_by as sales_rep_id, C.amount, null as tax, null as tax_per, null as tax_amount, 
            C.amount as final_amount, null as due_date, null as order_no, null as order_date, null as ref_invoice_no, 
            null as ref_invoice_details, null as ref_invoice_date, null as supplier_ref, 
            null as despatch_doc_no, null as despatch_through, null as destination, 'Pending' as status, C.remarks, 
            C.created_by, C.created_on, C.modified_by, C.modified_on, C.approved_by, C.approved_on, 
            C.rejected_by, C.rejected_on, null as client_name, null as address, null as city, 
            null as pincode, null as state, null as country, null as mobile_no, null as discount, 
            C.distributor_name, null as sell_out, null as class, null as depot_name, null as depot_state, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, null as sample_distributor_id, 
            null as delivery_status, null as delivery_date, null as receivable_doc,C.location, null as transport_type, 
            null as vehicle_number, null as cgst, null as sgst, null as igst, null as cgst_amount, null as sgst_amount, 
            null as igst_amount, null as reverse_charge, null as shipping_address, null as distributor_consignee_id, 
            null as con_name, null as con_address, null as con_city, null as con_pincode, null as on_state,
            null as con_country, null as con_state_code, null as con_gst_number, null as state_code, null as sample_type, 
            null as gifting_remarks, null as promoter_sales_rep_id, null as blogger_name, null as blogger_address, 
            null as blogger_phone_no, null as blogger_email_id, null as round_off_amount, null as invoice_amount, null as ref_id, 
            null as invoice_date,null as freezed, null as distributor_in_type, null as basis_of_sales, null as email_from, 
            null as email_approved_by, null as email_date_time, null as gstin, null as po_status, null as mismatch, null as shipping_charges from 
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
            order by I.modified_on desc";//query for nly pending
    
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
    //}
    // $cond=" where status='Approved' and distributor_name='Product Expired'";
    $cond=" where status='Approved' and (distributor_id='189' or sample_distributor_id='189')";

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
            G.vehicle_number, G.cgst, G.sgst, G.igst, G.cgst_amount, G.sgst_amount, G.igst_amount, G.reverse_charge, G.invoice_date from 
            (select E.*, F.sales_rep_name from 
            (select Q.*, D.depot_name from 
            (select N.*, P.location from 
            (select C.*, M.distributor_name as sample_distributor_name from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state,B.location_id, B.class from 
            (select * from distributor_out".$cond.") A 
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

            ) I 
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
	
    $ref_invoice_date=$this->input->post('ref_invoice_date');
    if($ref_invoice_date==''){
        $ref_invoice_date=NULL;
    } else {
        $ref_invoice_date=formatdate($ref_invoice_date);
    }
    
	$email_date_time=$this->input->post('email_date_time');
    if($email_date_time==''){
        $email_date_time=NULL;
    } else {
        $email_date_time= date('Y-m-d H:i:s',strtotime($email_date_time));
    }
	
    $invoice_date=$this->input->post('invoice_date');
    if($invoice_date==''){
        $invoice_date=NULL;
    } else {
        $invoice_date=formatdate($invoice_date);
    }

    $delivery_status = $this->input->post('delivery_status');

    if($this->input->post('btn_approve')!=null || $this->input->post('btn_reject')!=null){
        if($this->input->post('btn_approve')!=null){
            if($this->input->post('status')=="Deleted"){
                $status = 'InActive';
            } else {
                $status = 'Approved';
            }
        } else {
            $status = 'Rejected';
        }

        $ref_id = $this->input->post('ref_id');
        $invoice_no = $this->input->post('invoice_no');
        $distributor_in_type = $this->input->post('distributor_in_type');
        
        $remarks = str_replace("'", "", $this->input->post('remarks'));

        if($status == 'Rejected'){
            $sql = "Update distributor_out Set status='$status', remarks='$remarks', approved_by='$curusr', approved_on='$now', 
                            rejected_by='$curusr', rejected_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Distributor Out Entry '.$status.'. Delivery Status: ' . $delivery_status;
        } else {
            if($id!='' || $ref_id!=''){
                if(($invoice_no==null || $invoice_no=='' ) && $distributor_in_type!='exchanged'){
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

                    if($invoice_date==null || $invoice_date==''){
                        $invoice_date = date('Y-m-d');
                    }

                    if (isset($invoice_date)){
                        if($invoice_date==''){
                            $financial_year="";
                        } else {
                            $financial_year=calculateFiscalYearForDate($invoice_date);
                        }
                    } else {
                        $financial_year="";
                    }
                    
                    $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);
                }

                if($ref_id!=null && $ref_id!=''){
                    $modified_approved_date = NULL;
                    $get_modified_approved_date_result = $this->db->select('modified_approved_date')->where('id',$id)->get('distributor_out')->result();

                    if(count($get_modified_approved_date_result)>0){
                        $modified_approved_date = $get_modified_approved_date_result[0]->modified_approved_date;
                        
                        if($modified_approved_date!=null && $modified_approved_date!=""){
                            $modified_approved_date = date("Y-m-d");
                        } else {
                            $modified_approved_date = NULL;
                        }
                    } else {
                       $modified_approved_date = NULL;
                    }
                    
                    if($modified_approved_date!=null && $modified_approved_date!=null){
                        $sql = "Update distributor_out A, distributor_out B 
                                Set A.date_of_processing=B.date_of_processing, A.depot_id=B.depot_id, 
                                A.distributor_id=B.distributor_id,
                                A.sales_rep_id=B.sales_rep_id, A.amount=B.amount, A.tax=B.tax, A.tax_per=B.tax_per, 
                                A.tax_amount=B.tax_amount, A.final_amount=B.final_amount, A.due_date=B.due_date, 
                                A.order_no=B.order_no, A.order_date=B.order_date, A.ref_invoice_no=B.ref_invoice_no, 
                                A.ref_invoice_details=B.ref_invoice_details, A.ref_invoice_date=B.ref_invoice_date, 
                                A.supplier_ref=B.supplier_ref, A.despatch_doc_no=B.despatch_doc_no, 
                                A.despatch_through=B.despatch_through, A.destination=B.destination, 
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now', A.invoice_no = '$invoice_no', 
                                A.client_name=B.client_name, A.address=B.address, A.city=B.city, 
                                A.pincode=B.pincode, A.state=B.state, A.country=B.country, A.mobile_no=B.mobile_no, 
                                A.discount=B.discount, A.sample_distributor_id=B.sample_distributor_id, A.delivery_status=B.delivery_status, 
                                A.delivery_date=B.delivery_date, A.receivable_doc=B.receivable_doc, A.transport_type=B.transport_type, 
                                A.vehicle_number = B.vehicle_number, A.cgst = B.cgst, A.sgst = B.sgst, A.igst = B.igst, 
                                A.cgst_amount = B.cgst_amount, A.sgst_amount = B.sgst_amount, A.igst_amount = B.igst_amount, 
                                A.reverse_charge = B.reverse_charge, A.shipping_address = B.shipping_address, A.distributor_consignee_id = B.distributor_consignee_id, 
                                A.con_name = B.con_name, A.con_address = B.con_address, A.con_city = B.con_city, 
                                A.con_pincode = B.con_pincode, A.con_state = B.con_state, A.con_country = B.con_country, 
                                A.con_state_code = B.con_state_code, A.con_gst_number = B.con_gst_number, A.state_code = B.state_code, 
                                A.sample_type = B.sample_type, A.gifting_remarks = B.gifting_remarks, A.promoter_sales_rep_id = B.promoter_sales_rep_id, 
                                A.blogger_name = B.blogger_name, A.blogger_address = B.blogger_address, A.blogger_phone_no = B.blogger_phone_no, 
                                A.blogger_email_id = B.blogger_email_id, A.round_off_amount = B.round_off_amount, A.invoice_amount = B.invoice_amount, 
                                A.invoice_date = '$invoice_date',A.modified_approved_date='$modified_approved_date' ,
                                A.gstin=B.gstin, A.shipping_charges = B.shipping_charges 
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    } else {
                        $sql = "Update distributor_out A, distributor_out B 
                            Set A.date_of_processing=B.date_of_processing, A.depot_id=B.depot_id, A.distributor_id=B.distributor_id,
                                A.sales_rep_id=B.sales_rep_id, A.amount=B.amount, A.tax=B.tax, A.tax_per=B.tax_per, 
                                A.tax_amount=B.tax_amount, A.final_amount=B.final_amount, A.due_date=B.due_date, 
                                A.order_no=B.order_no, A.order_date=B.order_date, A.ref_invoice_no=B.ref_invoice_no, 
                                A.ref_invoice_details=B.ref_invoice_details, A.ref_invoice_date=B.ref_invoice_date, 
                                A.supplier_ref=B.supplier_ref, A.despatch_doc_no=B.despatch_doc_no, 
                                A.despatch_through=B.despatch_through, A.destination=B.destination, 
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now', A.invoice_no = '$invoice_no', 
                                A.client_name=B.client_name, A.address=B.address, A.city=B.city, 
                                A.pincode=B.pincode, A.state=B.state, A.country=B.country, A.mobile_no=B.mobile_no, 
                                A.discount=B.discount, A.sample_distributor_id=B.sample_distributor_id, 
                                A.delivery_status=B.delivery_status, 
                                A.delivery_date=B.delivery_date, A.receivable_doc=B.receivable_doc, 
                                A.transport_type=B.transport_type, 
                                A.vehicle_number = B.vehicle_number, A.cgst = B.cgst, A.sgst = B.sgst, A.igst = B.igst, 
                                A.cgst_amount = B.cgst_amount, A.sgst_amount = B.sgst_amount, A.igst_amount = B.igst_amount, 
                                A.reverse_charge = B.reverse_charge, A.shipping_address = B.shipping_address, 
                                A.distributor_consignee_id = B.distributor_consignee_id, 
                                A.con_name = B.con_name, A.con_address = B.con_address, A.con_city = B.con_city, 
                                A.con_pincode = B.con_pincode, A.con_state = B.con_state, A.con_country = B.con_country, 
                                A.con_state_code = B.con_state_code, A.con_gst_number = B.con_gst_number, A.state_code = B.state_code, 
                                A.sample_type = B.sample_type, A.gifting_remarks = B.gifting_remarks, A.promoter_sales_rep_id = B.promoter_sales_rep_id, 
                                A.blogger_name = B.blogger_name, A.blogger_address = B.blogger_address, A.blogger_phone_no = B.blogger_phone_no, 
                                A.blogger_email_id = B.blogger_email_id, A.round_off_amount = B.round_off_amount, A.invoice_amount = B.invoice_amount, 
                                A.invoice_date = '$invoice_date',
                                A.gstin=B.gstin,A.modified_approved_date=NULL, A.shipping_charges = B.shipping_charges 
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    }

                    
                    $this->db->query($sql);

                    $sql = "Delete from distributor_out where id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from distributor_out_items WHERE distributor_out_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update distributor_out_items set distributor_out_id='$ref_id' WHERE distributor_out_id = '$id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {
                    $sql = "Update distributor_out A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now', 
                                A.invoice_no = '$invoice_no', A.invoice_date = '$invoice_date' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

                $this->set_ledger($id);
                $this->set_credit_note($id);

                // $distributor_id = '';
                // $sql = "Select * from distributor_out where id = '$id'";
                // $query = $this->db->query($sql);
                // $result = $query->result();
                // if(count($result)>0) {
                //     $distributor_id = $result[0]->distributor_id;
                // }
                // if($distributor_id=='214'){
                //     $this->set_amazon_fba_delivery($id);
                // }

                // echo '<script>var win= window.open("'.base_url().'index.php/distributor_out/view_tax_invoice/'.$id.'");
                // win.print();
                // </script>';
                
                $action='Distributor Out Entry '.$status.'. Delivery Status: ' . $delivery_status;
            }
        }
        
    } else {
        if($this->input->post('btn_delete')!=null){
            if($this->input->post('status')=="Approved"){
                $status = 'Deleted';
            } else {
                $status = 'InActive';
            }
        } else {
            $status = 'Pending';
        }

        if($this->input->post('status')=="Approved"){
            $ref_id = $id;
            $id = '';
        } else {
            $ref_id = $this->input->post('ref_id');
        }

        if($ref_id==""){
            $ref_id = null;
        }

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

        // $invoice_no=$this->input->post('invoice_no');
        // if($invoice_no==null || $invoice_no==''){
        //     $sql="select * from series_master where type='Tax_Invoice'";
        //     $query=$this->db->query($sql);
        //     $result=$query->result();
        //     if(count($result)>0){
        //         $series=intval($result[0]->series)+1;

        //         $sql="update series_master set series = '$series' where type = 'Tax_Invoice'";
        //         $this->db->query($sql);
        //     } else {
        //         $series=1;

        //         $sql="insert into series_master (type, series) values ('Tax_Invoice', '$series')";
        //         $this->db->query($sql);
        //     }

        //     if (isset($date_of_processing)){
        //         $financial_year=calculateFiscalYearForDate($date_of_processing);
        //     } else {
        //         $financial_year="";
        //     }
            
        //     $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);
        // }

        $data = array(
            'date_of_processing' => $date_of_processing,
            'invoice_no' => $this->input->post('invoice_no'),
            'depot_id' => $this->input->post('depot_id'),
            'distributor_id' => $this->input->post('distributor_id'),
            'sales_rep_id' => ($this->input->post('sales_rep_id')==''?null:$this->input->post('sales_rep_id')),
            'amount' => format_number($this->input->post('total_amount'),2),
            'tax' => $this->input->post('tax'),
            'tax_per' => format_number($this->input->post('tax_per'),2),
            'tax_amount' => format_number($this->input->post('tax_amount'),2),
            'final_amount' => format_number($this->input->post('final_amount'),2),
            'due_date' => $due_date,
            'order_no' => $this->input->post('order_no'),
            'order_date' => $order_date,
            'ref_invoice_no' => $this->input->post('ref_invoice_no'),
            'ref_invoice_details' => $this->input->post('ref_invoice_details'),
            'ref_invoice_date' => $ref_invoice_date,
            'supplier_ref' => $this->input->post('supplier_ref'),
            'despatch_doc_no' => $this->input->post('despatch_doc_no'),
            'despatch_through' => $this->input->post('despatch_through'),
            'destination' => $this->input->post('destination'),
            'status' => $status,
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'client_name' => $this->input->post('client_name'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'pincode' => $this->input->post('pincode'),
            'state' => $this->input->post('state'),
            'country' => $this->input->post('country'),
            'mobile_no' => $this->input->post('mobile_no'),
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
            'state_code' => $this->input->post('state_code'),
            'round_off_amount' => format_number($this->input->post('round_off_amount'),2),
            'invoice_amount' => format_number($this->input->post('invoice_amount'),2),
            'ref_id' => $ref_id,
            'invoice_date' => $invoice_date,
            'email_date_time' => $email_date_time,
            'basis_of_sales' => $this->input->post('basis_of_sales'),
            'email_from' => $this->input->post('email_from'),
            'email_approved_by' => $this->input->post('email_approved_by'),
            'gstin'=> $this->input->post('gstin'),
            'shipping_charges' => format_number($this->input->post('shipping_charges'),2)
            //'tracking_id' => $this->input->post('tracking_id')
        );

        if($ref_id!=null && $ref_id!=""){
            $data['modified_approved_date']=$now;
        }

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

            /*if($status=='InActive')
            {
               $result = $this->db->select('distributor_po_id')->where('id',$id)->get('distributor_out')->result();
               
                $delivery_status = 'Cancelled';
                $remarks = $this->input->post('remarks');
                $remarks =$remarks.' , Deleted From Sales';
                if(count($result)>0)
                {
                    $po_id = $result[0]->distributor_po_id;
                    $sql1 = "update distributor_po set delivery_status = '$delivery_status', 
                        modified_by = '$curusr', modified_on = '$now',delivery_remarks='$remarks'
                        where id in (".$po_id.")";
                    $this->db->query($sql1);
                }
            }*/
        }

        $this->db->where('distributor_out_id', $id);
        $this->db->delete('distributor_out_items');

        $type=$this->input->post('type[]');
        $bar=$this->input->post('bar[]');
        $box=$this->input->post('box[]');
        $qty=$this->input->post('qty[]');
        $sell_rate=$this->input->post('sell_rate[]');
        $sell_margin=$this->input->post('sell_margin[]');
        $promo_margin=$this->input->post('promo_margin[]');
        $tax_per=$this->input->post('tax_per[]');
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
                            'total_amt' => format_number($total_amt[$k],2),
                            'margin_per' => $sell_margin[$k],
                            'promo_margin' => $promo_margin[$k],
                            'tax_percentage' => $tax_per[$k]
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

        // $status = $this->input->post('status');
        // if($status=="InActive" || ($status=="Approved" && $delivery_status!="Pending" && $delivery_status!="GP Issued")){
        //     $this->set_ledger($id);
        // }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_Out';
    $logarray['cnt_name']='Distributor_Out';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function save_approved_data($id=''){
    // $now=date('Y-m-d H:i:s', strtotime('-1 days'));
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    // $curusr=148;

    $invoice_no = '';
    $invoice_date = '';
    $delivery_status = '';
    $remarks = '';
    $distributor_in_type = '';

    $status = 'Approved';

    $sql = "select * from distributor_out where id='$id'";
    $result = $this->db->query($sql)->result();
    if(count($result)>0){
        // echo 'found';
        // echo '<br/><br/>';
        // echo $result[0]->id;
        // echo '<br/><br/>';
        $invoice_no = $result[0]->invoice_no;
        $invoice_date = $result[0]->invoice_date;
        $delivery_status = $result[0]->delivery_status;
        $remarks = $result[0]->remarks;
        $distributor_in_type = $result[0]->distributor_in_type;
    }

    $remarks = str_replace("'", "", $remarks);

    // echo $now;
    // echo '<br/><br/>';
    // echo $curusr;
    // echo '<br/><br/>';
    // echo $invoice_no;
    // echo '<br/><br/>';
    // echo $invoice_date;
    // echo '<br/><br/>';
    // echo $delivery_status;
    // echo '<br/><br/>';
    // echo $remarks;
    // echo '<br/><br/>';
    // echo $distributor_in_type;
    // echo '<br/><br/>';

    if(($invoice_no==null || $invoice_no=='' ) && $distributor_in_type!='exchanged'){
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

        if($invoice_date==null || $invoice_date==''){
            $invoice_date = date('Y-m-d');
            // $invoice_date = date('Y-m-d', strtotime('-1 days'));
        }

        if (isset($invoice_date)){
            if($invoice_date==''){
                $financial_year="";
            } else {
                $financial_year=calculateFiscalYearForDate($invoice_date);
            }
        } else {
            $financial_year="";
        }
        
        $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);
    }
    
    // $sql = "Update distributor_out A 
    //         Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now', 
    //             A.invoice_no = '$invoice_no', A.invoice_date = '$invoice_date' 
    //         WHERE A.id = '$id'";
    $sql = "Update distributor_out A 
            Set A.status='$status', A.approved_by='$curusr', A.approved_on='$now', 
                A.invoice_no = '$invoice_no', A.invoice_date = '$invoice_date' 
            WHERE A.id = '$id'";
    $this->db->query($sql);

    $this->set_ledger($id);
    $this->set_credit_note($id);

    $action='Distributor Out Entry '.$status.'. Delivery Status: ' . $delivery_status;

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_Out';
    $logarray['cnt_name']='Distributor_Out';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function set_amazon_fba_delivery($id=''){
    $delivery_status='Delivered';
    $sales_rep_id='104';
    $status='Approved';
    $tracking_id='';
    $date_of_dispatch=date('Y-m-d');
    $proof_of_dispatch = '';

    if($id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $sql = "update distributor_out set delivery_status = '$delivery_status', delivery_sales_rep_id = '$sales_rep_id', 
                status = '$status', tracking_id = '$tracking_id', modified_by = '$curusr', modified_on = '$now', 
                gatepass_date = '$now', date_of_dispatch = '$date_of_dispatch', proof_of_dispatch = '$proof_of_dispatch', 
                delivery_date = '$date_of_dispatch', proof_of_delivery = '' 
                where id = '$id'";
        $this->db->query($sql);

        $sql = "update distributor_out_items set batch_no = '182', batch_qty = qty 
                where distributor_out_id = '$id'";
        $this->db->query($sql);
    }
}

function set_credit_note($id=''){
    $sql = "select * from distributor_out where id = '$id'";
    $query = $this->db->query($sql);
    $result = $query->result();
    if(count($result)>0){
        // $date_of_processing = $result[0]->date_of_processing;
        if(isset($result[0]->invoice_date) && $result[0]->invoice_date!=''){
            $date_of_processing = $result[0]->invoice_date;
        } else {
            $date_of_processing = $result[0]->date_of_processing;
        }
        $invoice_no = $result[0]->invoice_no;
        $distributor_id = $result[0]->distributor_id;
        $created_by = $result[0]->created_by;
        $created_on = $result[0]->created_on;
        $modified_by = $result[0]->modified_by;
        $modified_on = $result[0]->modified_on;
        $approved_by = $result[0]->approved_by;
        $approved_on = $result[0]->approved_on;
        $rejected_by = $result[0]->rejected_by;
        $rejected_on = $result[0]->rejected_on;
        $discount = $result[0]->discount;

        if($discount==null || $discount==''){
            $discount = 0;
        }

        $sql = "select * from distributor_out_items where distributor_out_id = '$id'";
        $query = $this->db->query($sql);
        $result = $query->result();

        $total_inv_amount = 0;
        $total_amount = 0;
        $tax_type = 'Intra';
        $promo_margin = 0;
        $bal_amount = 0;

        // echo json_encode($result);
        // echo '<br/>';

        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                $qty = floatval($result[$i]->qty);
                $rate = floatval($result[$i]->rate);
                $total_amt = floatval($result[$i]->total_amt);
                $margin_per = floatval($result[$i]->margin_per);
                $tax_percentage = floatval($result[$i]->tax_percentage);
                $promo_margin = floatval($result[$i]->promo_margin);
                $cgst_amt = floatval($result[$i]->cgst_amt);
                $sgst_amt = floatval($result[$i]->sgst_amt);
                $igst_amt = floatval($result[$i]->igst_amt);

                if($igst_amt>0){
                    $tax_type = 'Inter';
                }

                $total_inv_amount = $total_inv_amount + $total_amt;

                $total_margin = $margin_per + $promo_margin + $discount;
                $sell_rate = $rate - (($rate*$total_margin)/100);
                // $sell_rate = $sell_rate/(100+$tax_percentage)*100;

                $tot_amt = $qty * $sell_rate;
                $total_amount = $total_amount + $tot_amt;

                // echo $total_margin.'<br/>';
                // echo $rate.'<br/>';
                // echo $sell_rate.'<br/>';
                // echo $tot_amt.'<br/>';
            }
        }

        $bal_amount = round($total_inv_amount - $total_amount, 0);

        $credit_debit_note_id = '';
        $ref_no = '';
        $ref_date = null;
        $modified_approved_date = null;

        $sql = "select * from credit_debit_note where distributor_out_id = '$id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)==0){
            if($bal_amount!=0){
                $sql="select * from series_master where type='Credit_debit_note'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $series=intval($result[0]->series)+1;

                    $sql="update series_master set series = '$series' where type = 'Credit_debit_note'";
                    $this->db->query($sql);
                } else {
                    $series=1;

                    $sql="insert into series_master (type, series) values ('Credit_debit_note', '$series')";
                    $this->db->query($sql);
                }

                $ref_date = date('Y-m-d');

                if (isset($ref_date)){
                    if($ref_date==''){
                        $financial_year="";
                    } else {
                        $financial_year=calculateFiscalYearForDate($ref_date);
                        if(strpos($financial_year,'-')!==false){
                            $financial_year = substr($financial_year, 0, strpos($financial_year,'-'));
                        }
                    }
                } else {
                    $financial_year="";
                }
                
                // $ref_no = 'WHPL/exp/'.$financial_year.'/'.strval($series);
                $ref_no = 'WHPL/'.$financial_year.'-EXP/'.strval($series);
                $modified_approved_date = null;
            }
        } else {
            $credit_debit_note_id = $result[0]->id;
            $ref_no = $result[0]->ref_no;
            $ref_date = $result[0]->ref_date;
            $modified_approved_date = $result[0]->modified_approved_date;
        }

        if($bal_amount!=0){
            $bal_amount = round($total_inv_amount - $total_amount, 0);

            // echo $total_inv_amount.'<br/>';
            // echo $total_amount.'<br/>';
            // echo $bal_amount.'<br/>';

            $tax_per = 18;
            $amount_without_tax = round($bal_amount/(1+($tax_per/100)), 4);
            $cgst_amt = 0;
            $sgst_amt = 0;
            $igst_amt = 0;
            if($tax_type == 'Intra'){
                $cgst_amt = round(($amount_without_tax*($tax_per/2))/100, 4);
                $sgst_amt = round(($amount_without_tax*($tax_per/2))/100, 4);
            } else {
                $igst_amt = round(($amount_without_tax*$tax_per)/100, 4);
            }

            $amount = round(($amount_without_tax + $cgst_amt + $sgst_amt + $igst_amt), 0);

            // echo $amount_without_tax.'<br/>';
            // echo $cgst_amt.'<br/>';
            // echo $sgst_amt.'<br/>';
            // echo $igst_amt.'<br/>';
            // echo $amount.'<br/>';

            $data = array(
                'date_of_transaction' => $date_of_processing,
                'distributor_id' => $distributor_id,
                'transaction' => 'Expense Voucher',
                'invoice_no' => $invoice_no,
                'distributor_type' => 'Invoice',
                'amount' => $amount,
                'tax' => $tax_per,
                'igst' => $igst_amt,
                'cgst' => $cgst_amt,
                'sgst' => $sgst_amt,
                'amount_without_tax' => $amount_without_tax,
                'status' => 'Approved',
                'remarks' => 'SG - Promotion Charges Expense Voucher against invoice no '.$invoice_no,
                'created_by' => $created_by,
                'created_on' => $created_on,
                'modified_by' => $modified_by,
                'modified_on' => $modified_on,
                'approved_by' => $approved_by,
                'approved_on' => $approved_on,
                'rejected_by' => $rejected_by,
                'rejected_on' => $rejected_on,
                'ref_no' => $ref_no,
                'ref_date' => $ref_date,
                'modified_approved_date' => $modified_approved_date,
                'distributor_out_id' => $id,
                'exp_category_id' => '1'
            );

            if($credit_debit_note_id==''){
                $this->db->insert('credit_debit_note',$data);
                $credit_debit_note_id=$this->db->insert_id();
                $action='Credit_debit_note Entry Created.';
            } else {
                $this->db->where('id', $credit_debit_note_id);
                $this->db->update('credit_debit_note',$data);
                $action='Credit_debit_note Entry Modified.';
            }

            $logarray['table_id']=$credit_debit_note_id;
            $logarray['module_name']='Credit_debit_note';
            $logarray['cnt_name']='Credit_debit_note';
            $logarray['action']=$action;
            $this->user_access_log_model->insertAccessLog($logarray);
        } else {
            if($credit_debit_note_id!=''){
                $sql = "update credit_debit_note set status = 'InActive' where id = '$credit_debit_note_id'";
                $this->db->query($sql);
            }
        }
    }
}

function set_delivery_status() {
    $check1=$this->input->post('check');
    $delivery_status=$this->input->post('delivery_status');
    $sales_rep_id=$this->input->post('sales_rep_id');
    $status=$this->input->post('status');
    $person_receiving=$this->input->post('person_receving');
    $delivery_date=$this->input->post('delivery_date');
    if($delivery_date==''){
        $delivery_date=NULL;
    } else {
        $delivery_date=formatdate($delivery_date);
    }
   
    $proof_of_delivery = '';

    if(!empty($_FILES["upload"]['name']))
    {
        $path=FCPATH.'assets/uploads/delivery_proof/';
        $config = array(
        'upload_path' => $path,
        'allowed_types' => "*",
        'overwrite' => TRUE
        );
        $proof_of_delivery = str_replace(' ', "_", $_FILES["upload"]['name']);
        $config['file_name'] = $proof_of_delivery;

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('upload'))
        { 
             $this->upload->display_errors();

        }
    }

    $check = array();
    $j=0;

    for($i=0; $i<count($check1); $i++){
        if($check1[$i]!='false'){
            $check[$j] = $check1[$i];
            $j = $j + 1;
        }
    }

    $distributor_out_id = $check1;//implode(", ", $check);

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
                    status = '$status', modified_by = '$curusr', modified_on = '$now', gatepass_date = '$now'
                    where id in (".$distributor_out_id.")";
        } else {
            $sql = "update distributor_out set delivery_status = '$delivery_status', status = '$status', 
                    modified_by = '$curusr', modified_on = '$now',person_receiving='$person_receiving',proof_of_delivery='$proof_of_delivery', delivery_date = '$delivery_date'
                    where id in (".$distributor_out_id.")";
           /* $result = $this->db->select('distributor_po_id')->where('id',$distributor_out_id)->get('distributor_out')->result();
            if($delivery_status=='Delivered Not Complete')
            {
                $delivery_status = 'Delivered';
            }

            if(count($result)>0)
            {
                $po_id = $result[0]->distributor_po_id;
                $sql1 = "update distributor_po set delivery_status = '$delivery_status', 
                    modified_by = '$curusr', modified_on = '$now'
                    where id in (".$po_id.")";
                $this->db->query($sql1);
            }*/
        }
        
        $this->db->query($sql);

        if($delivery_status=='GP Issued'){
            $this->tax_invoice_model->generate_gate_pass($distributor_out_id);
        }
    }
}

function set_sku_batch(){
    $check1=$this->input->post('check');
    $delivery_status=$this->input->post('delivery_status');
    $sales_rep_id=$this->input->post('sales_rep_id');
    $status=$this->input->post('status');
    $distributor_out_id=$this->input->post('distributor_out_id');
    $sales_item_id=$this->input->post('sales_item_id');
    $tracking_id=$this->input->post('tracking_id');
    $date_of_dispatch=$this->input->post('date_of_dispatch');

    if($date_of_dispatch==''){
        $date_of_dispatch=NULL;
    } else {
        $date_of_dispatch=formatdate($date_of_dispatch);
    }

    $proof_of_dispatch = '';

    if(!empty($_FILES["upload"]['name']))
    {
        $path=FCPATH.'assets/uploads/dispatch_proof/';
        $config = array(
        'upload_path' => $path,
        'allowed_types' => "*",
        'overwrite' => TRUE
        );
        $proof_of_dispatch = time().'_'.str_replace(' ', "_", $_FILES["upload"]['name']);
        $config['file_name'] = $proof_of_dispatch;

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('upload'))
        { 
             $this->upload->display_errors();

        }
    }
    
    
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
                    status = '$status',tracking_id='$tracking_id', modified_by = '$curusr', modified_on = '$now', gatepass_date = '$now',date_of_dispatch='$date_of_dispatch',proof_of_dispatch='$proof_of_dispatch'
                    where id in (".$distributor_out_id.")";
        } else {

            $sql = "update distributor_out set delivery_status = '$delivery_status', status = '$status', 
                    modified_by = '$curusr',tracking_id='$tracking_id', modified_on = '$now' 
                    where id in (".$distributor_out_id.")";
        }
        
        $this->db->query($sql);


        for($i=0; $i<count($sales_item_id); $i++){
            $batch_no_qty=$this->input->post('batch_no_qty_'.$i);
            $batch_no_no=$this->input->post('batch_no_no_'.$i);

            $total_batch_no_qty = implode(", ", $batch_no_qty);
            $total_batch_no_no = implode(", ", $batch_no_no);

            if($sales_item_id[$i]!=''){
                $item_id = $sales_item_id[$i];
                $sql = "update distributor_out_items set batch_no = '$total_batch_no_no', batch_qty = '$total_batch_no_qty' 
                        where id = '$item_id'";
                $this->db->query($sql);
            }
            
        }

        if($delivery_status=='GP Issued'){
            $this->tax_invoice_model->generate_gate_pass($distributor_out_id);
        }
    }
}

function get_sku_details($distributor_out_id){
    /*$check1=$this->input->post('check');
    $tracking_id=$this->input->post('tracking_id');
    // $check1=['1'];

    $check = array();
    $j=0;

    for($i=0; $i<count($check1); $i++){
        if($check1[$i]!='false'){
            $check[$j] = $check1[$i];
            $j = $j + 1;
        }
    }

    $distributor_out_id = implode(", ", $check);

    $table = '';
    $data = array();*/

    if($distributor_out_id!=""){
        $sql = "select O.* from 
                (select M.*, N.location from 
                (select K.*, L.sales_rep_name from 
                (select I.*, J.depot_name, J.address as depot_address, J.city as depot_city, J.pincode as depot_pincode, 
                    J.state as depot_state, J.state_code as depot_state_code, J.country as depot_country from 
                (select G.*, H.distributor_name, H.sell_out, H.state as distributor_state, H.class, H.location_id from 
                (select E.*, F.product_name from 
                (select C.*, D.box_name from 
                (select A.*, B.id as sales_item_id, B.type, B.item_id, B.qty, B.rate, B.sell_rate, B.amount as item_amt from 
                (select * from distributor_out where id in (".$distributor_out_id.")) A 
                left join 
                (select * from distributor_out_items where distributor_out_id in (".$distributor_out_id.")) B 
                on (A.id = B.distributor_out_id)) C 
                left join 
                (select * from box_master) D 
                on (C.type = 'Box' and C.item_id = D.id)) E 
                left join 
                (select * from product_master) F 
                on (E.type = 'Bar' and E.item_id = F.id)) G 
                left join 
                (select * from distributor_master) H 
                on (G.distributor_id=H.id)) I 
                left join 
                (select * from depot_master) J 
                on (I.depot_id=J.id)) K 
                left join 
                (select * from sales_rep_master) L 
                on (K.sales_rep_id=L.id)) M 
                left join 
                (select * from location_master) N 
                on (M.location_id=N.id)) O 
                order by O.invoice_no";
        $query = $this->db->query($sql);
        $data = $query->result();
    }

    return $data;
}

function get_batch_details(){
    $date = date("Y-m-d", strtotime("-9 months"));

    $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
    $query = $this->db->query($sql);
    return $query->result();
}

function approve_records() {
    $check1=$this->input->post('check');
    $dlvery_status1=$this->input->post('dlvery_status');
    $invoice_no1=$this->input->post('invoice_no');
    $date_of_processing1=$this->input->post('date_of_processing');
    $status=$this->input->post('status');
    $invoice_date1=$this->input->post('invoice_date');

    $check = array();
    $dlvery_status = array();
    $j=0;

    for($i=0; $i<count($check1); $i++){
        if($check1[$i]!='false'){
            $check[$j] = $check1[$i];
            $dlvery_status[$j] = $dlvery_status1[$i];
            $invoice_no[$j] = $invoice_no1[$i];
            $date_of_processing[$j] = $date_of_processing1[$i];
            $invoice_date[$j] = $invoice_date1[$i];
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
        $sql = "update distributor_out set status = '$status', approved_by = '$curusr', approved_on = '$now' 
                    where id in (".$distributor_out_id.")";
        
        $this->db->query($sql);
    }

    if($status=='Approved'){
        for($i=0; $i<count($check); $i++){
            if($invoice_no[$i]==null || $invoice_no[$i]==''){
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

                if($invoice_date[$i]==null || $invoice_date[$i]==''){
                    $invoice_date[$i] = date('Y-m-d');
                }

                if (isset($invoice_date[$i])){
                    if($invoice_date[$i]==''){
                        $financial_year="";
                    } else {
                        $financial_year=calculateFiscalYearForDate($invoice_date[$i]);
                    }
                } else {
                    $financial_year="";
                }
                
                $invoice_no[$i] = 'WHPL/'.$financial_year.'/'.strval($series);
                $invoice_date[$i] = date('Y-m-d');

                $sql = "update distributor_out set invoice_no = '".$invoice_no[$i]."', invoice_date = '".$invoice_date[$i]."' where id = ".$check[$i];
                $this->db->query($sql);
            }
        }
    }
    

    // $distributor_out_id = "";
    // for($i=0; $i<count($check); $i++){
    //     if($dlvery_status[$i]=="GP Issued"){
    //         $distributor_out_id = $distributor_out_id . $check[$i] . ", ";
    //     }
    // }

    // if($distributor_out_id!=""){
    //     $distributor_out_id = substr($distributor_out_id, 0, strlen($distributor_out_id)-2);

    //     $this->tax_invoice_model->generate_gate_pass($distributor_out_id);
    // }

    // $distributor_out_id = "";
    // for($i=0; $i<count($check); $i++){
    //     if($dlvery_status[$i]=="Delivered Not Complete"){
    //         $distributor_out_id = $check[$i];

    //         $this->set_ledger($distributor_out_id);
    //     }
    // }
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
        if(isset($result[0]->invoice_date) && $result[0]->invoice_date!=''){
            $ref_date = $result[0]->invoice_date;
        } else {
            $ref_date = $result[0]->date_of_processing;
        }
        
        $data = array(
                    'ref_id' => $id,
                    'ref_type' => 'Distributor_Sales',
                    'entry_type' => 'Total Amount',
                    'invoice_no' => $result[0]->invoice_no,
                    'vendor_id' => $result[0]->distributor_id,
                    'acc_id' => $result[0]->acc_id,
                    'ledger_name' => $result[0]->ledger_name,
                    'type' => 'Debit',
                    // 'amount' => $result[0]->final_amount,
                    'amount' => $result[0]->invoice_amount,
                    'status' => $result[0]->status,
                    'is_active' => '1',
                    'ledger_type' => 'Main Entry',
                    'narration' => $result[0]->remarks,
                    'ref_date' => $ref_date,
                    'modified_by' => $curusr,
                    'modified_on' => $now
                );

        $ledger_array[0] = $data;
        $ledger_array[1] = $data;
        $ledger_array[2] = $data;
        $ledger_array[3] = $data;

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

        $ledger_array[3]['entry_type'] = 'Shipping Charges';
        $ledger_array[3]['acc_id'] = '2';
        $ledger_array[3]['ledger_name'] = 'Shipping Charges';
        $ledger_array[3]['type'] = 'Credit';
        $ledger_array[3]['amount'] = $result[0]->shipping_charges;
        $ledger_array[3]['ledger_type'] = 'Sub Entry';

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

            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales');
            $this->db->where('entry_type', 'Shipping Charges');
            $this->db->update('account_ledger_entries', $ledger_array[3]);
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

            $ledger_array[3]['voucher_id'] = $voucher_id;
            $ledger_array[3]['created_by']=$curusr;
            $ledger_array[3]['created_on']=$now;

            $this->db->insert('account_ledger_entries', $ledger_array[0]);
            $this->db->insert('account_ledger_entries', $ledger_array[1]);
            $this->db->insert('account_ledger_entries', $ledger_array[2]);
            $this->db->insert('account_ledger_entries', $ledger_array[3]);
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

function check_order_id_availablity(){
    $id=$this->input->post('id');
    $order_no=$this->input->post('order_no');
    $ref_id=$this->input->post('ref_id');

    // $id="";

    $query=$this->db->query("select * from distributor_out where id!='".$id."' and order_no='".$order_no."' and id!='".$ref_id."' and status!='InActive' and status!='Rejected'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

public function get_product_percentage($product_id,$distributor_id){
    $sql = "select B.inv_margin, A.category_id, A.tax_percentage, B.pro_margin from
            (select category_id,tax_percentage from product_master Where id=$product_id ) A
            left join 
            (select * from distributor_category_margin ) B
            on A.category_id=B.category_id
            where B.distributor_id=$distributor_id";
    $result = $this->db->query($sql)->result();

    return $result;
}

public function get_product_details($status='', $id='', $distributor_id=''){
    if($status!=""){
        $cond=" where A.status='".$status."'";
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where A.id='".$id."'";
        } else {
            $cond=$cond." and A.id='".$id."'";
        }
    }

    $cond2 = '';

    if($distributor_id!=""){
        /*if($cond=="") {
            $cond=" where (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";
        } else {
            $cond=$cond." and (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";
        }*/

        $cond2 = " and (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";
    } else {
        /*if($cond=="") {
            $cond=" where B.distributor_id is null";
        } else {
            $cond=$cond." and B.distributor_id is null";
        }*/

        $cond2 = " and (B.distributor_id is null)";
    }

    $sql = "select A.*, B.inv_margin, B.pro_margin from product_master A left join distributor_category_margin B 
            on(A.category_id=B.category_id ".$cond2.") 
            ".$cond." order by A.product_name";
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_distributor_box_details($status='', $id='', $distributor_id=''){
    if($status!=""){
        $cond=" where A.status='".$status."'";
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where A.id='".$id."'";
        } else {
            $cond=$cond." and A.id='".$id."'";
        }
    }

    $cond2 = '';

    if($distributor_id!=""){
        /*if($cond=="") {
            $cond=" where (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";
        } else {
            $cond=$cond." and (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";
        }*/
        $cond2 = " and (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";

    } else {
        $cond2 = " and (B.distributor_id is null)";
        /*if($cond=="") {
            $cond=" where B.distributor_id is null";
        } else {
            $cond=$cond." and B.distributor_id is null";
        }*/
    }

    $sql = "select A.*, B.inv_margin, B.pro_margin from box_master A left join distributor_category_margin B 
            on(A.category_id=B.category_id ".$cond2.") 
            ".$cond." order by A.box_name";
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_box_details($status='', $id='', $distributor_id=''){
    if($status!=""){
        $cond=" where A.status='".$status."'";
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where A.id='".$id."'";
        } else {
            $cond=$cond." and A.id='".$id."'";
        }
    }

    $cond2 = '';

    if($distributor_id!=""){
        /*if($cond=="") {
            $cond=" where (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";
        } else {
            $cond=$cond." and (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";
        }*/
        $cond2 = " and (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";

    } else {
        $cond2 = " and (B.distributor_id is null)";
        /*if($cond=="") {
            $cond=" where B.distributor_id is null";
        } else {
            $cond=$cond." and B.distributor_id is null";
        }*/
    }

    $sql = "select A.*, B.inv_margin, B.pro_margin from box_master A left join distributor_category_margin B 
            on(A.category_id=B.category_id ".$cond2.") 
            ".$cond." order by A.box_name";
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_comments($id){
    $result = $this->db->select('comments')->where('id',$id)->get('distributor_out')->result();
    return $result;
}

public function save_comments(){
   $id=$this->input->post('delivery_comments_id');
   echo $delivery_comments=$this->input->post('delivery_comments');
  

   if($delivery_comments!="")
   {
     $data = array( 
        'comments' => $delivery_comments
        );
      $this->db->where('id', $id);
      $this->db->update('distributor_out',$data);
   }
}

public function get_sales_item_data($status){
    if ($status=="pending_for_delivery"){
        $cond=" where status='Approved' and delivery_status='Pending' and (distributor_id!='1' and distributor_id!='189')";
    }

    $sql = "select A.*, B.distributor_name, B.location_id, C.location, D.depot_name, 
            E.sales_item_id, E.type, E.item_id, E.qty, E.item_name from 
            (select id, date_of_processing, distributor_id, depot_id, modified_on from distributor_out".$cond.") A 
            left join 
            (select id, distributor_name, location_id from distributor_master) B 
            on (A.distributor_id=B.id) 
            left join 
            (select id, location from location_master) C 
            on (B.location_id=C.id) 
            left join
            (select id, depot_name from depot_master) D 
            on (A.depot_id=D.id) 
            left join 
            (select A.id as sales_item_id, A.distributor_out_id, A.type, A.item_id, A.qty, 
                case when A.type='Bar' then B.product_name else C.box_name end as item_name 
            from distributor_out_items A 
            left join product_master B on (A.type='Bar' and A.item_id=B.id) 
            left join box_master C on (A.type='Box' and A.item_id=C.id)) E 
            on (A.id=E.distributor_out_id) 
            order by A.id desc, E.sales_item_id desc";

    $query=$this->db->query($sql);
    return $query->result();
}

public function get_pending_sales_data($status){
    if ($status=="pending_for_approval"){
        $cond=" where ((A.status='Pending' and (A.delivery_status='Pending' or A.delivery_status='GP Issued' or A.delivery_status='Delivered Not Complete' or A.delivery_status='Delivered')) or A.status='Deleted') and (A.distributor_id!='1' and A.distributor_id!='189') and (A.ref_id is null or A.ref_id='')";
    }

    $sql = "select A.*, B.distributor_name, B.location_id, C.location, D.depot_name from 
            (select A.id, A.date_of_processing, A.distributor_id, A.depot_id, A.invoice_amount, A.delivery_status, A.status, A.modified_on from distributor_out A".$cond.") A 
            left join 
            (select id, distributor_name, location_id from distributor_master) B 
            on (A.distributor_id=B.id) 
            left join 
            (select id, location from location_master) C 
            on (B.location_id=C.id) 
            left join
            (select id, depot_name from depot_master) D 
            on (A.depot_id=D.id) 
            order by A.id desc";

    $query=$this->db->query($sql);
    return $query->result();
}

public function approve_pending_sales_data($id){
    $invoice_no = '';
    $invoice_date = '';

    $sql="select * from distributor_out where id='$id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $invoice_no = $result[0]->invoice_no;
        $invoice_date = $result[0]->invoice_date;
    }

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

        if($invoice_date==null || $invoice_date==''){
            $invoice_date = date('Y-m-d');
        }

        if (isset($invoice_date)){
            if($invoice_date==''){
                $financial_year="";
            } else {
                $financial_year=calculateFiscalYearForDate($invoice_date);
            }
        } else {
            $financial_year="";
        }
        
        $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);

        $sql = "Update distributor_out A 
                Set A.invoice_no = '$invoice_no', A.invoice_date = '$invoice_date' 
                Where A.id = '$id'";
        $this->db->query($sql);
    }

    $this->set_ledger($id);
    $this->set_credit_note($id);
}

public function approve_records_from_backend($distributor_out_id){
    foreach ($distributor_out_id as $id){
        $invoice_no = '';
        $invoice_date = '';

        $sql="select * from distributor_out where id='$id'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $invoice_no = $result[0]->invoice_no;
            $invoice_date = $result[0]->invoice_date;
        }

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

            if($invoice_date==null || $invoice_date==''){
                $invoice_date = date('Y-m-d');
            }

            if (isset($invoice_date)){
                if($invoice_date==''){
                    $financial_year="";
                } else {
                    $financial_year=calculateFiscalYearForDate($invoice_date);
                }
            } else {
                $financial_year="";
            }
            
            $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);
        }

        $status = 'Approved';
        $remarks = 'Approved form backend.';
        $now = date('Y-m-d H:i:s');
        $curusr = $this->session->userdata('session_id');

        $sql = "Update distributor_out A 
                Set A.status='$status', A.remarks=concat(A.remarks,'$remarks'), A.approved_by='$curusr', A.approved_on='$now', A.invoice_no = '$invoice_no', A.invoice_date = '$invoice_date' 
                WHERE A.id = '$id'";
        $this->db->query($sql);

        $this->set_ledger($id);
        $this->set_credit_note($id);
    }
}

}
?>