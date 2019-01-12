<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sample_out_model Extends CI_Model{

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
            G.distributor_name, G.sell_out, G.class, G.depot_name, G.sales_rep_name, 
            concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
            G.sample_distributor_id, G.delivery_status, G.delivery_date, G.receivable_doc from 
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

function get_distributor_out_data1($status='', $id=''){
    if($status!=""){
        // if ($status=="Approved"){
        //     // $cond=" where status='Approved' and (delivery_status='Delivered' or delivery_status is null or delivery_status = '') and distributor_name='Sample'";
        //     $cond=" where status='Approved' and distributor_name='Sample'";
        // } else if ($status=="pending"){
        //     $cond=" where status='Pending' and (delivery_status='Pending' or delivery_status is null or delivery_status = '') and distributor_name='Sample'";
        // } else if ($status=="pending_for_approval"){
        //     $cond=" where status='Pending' and (delivery_status='GP Issued' or delivery_status='Delivered Not Complete' or delivery_status='Delivered') and distributor_name='Sample'";
        // } else if ($status=="pending_for_delivery"){
        //     $cond=" where (status='Approved' or status='Rejected') and delivery_status='Pending' and distributor_name='Sample'";
        // } else if ($status=="gp_issued"){
        //     $cond=" where (status='Approved' or status='Rejected') and delivery_status='GP Issued' and distributor_name='Sample'";
        // } else if ($status=="delivered_not_complete"){
        //     $cond=" where (status='Approved' or status='Rejected') and delivery_status='Delivered Not Complete' and distributor_name='Sample'";
        // } else {
        //     $cond=" where status='".$status."' and distributor_name='Sample'";
        // }

        if ($status=="Approved"){
            // $cond=" where status='Approved' and (delivery_status='Delivered' or delivery_status is null or delivery_status = '') and (distributor_id='1' or distributor_id='189')";
            $cond=" where status='Approved' and (distributor_id='1' or distributor_id='189')";
        } else if ($status=="pending"){
            $cond=" where status='Pending' and (delivery_status='Pending' or delivery_status is null or delivery_status = '') and (distributor_id='1' or distributor_id='189')";
        } else if ($status=="pending_for_approval"){
            $cond=" where status='Pending' and (delivery_status='GP Issued' or delivery_status='Delivered Not Complete' or delivery_status='Delivered') and (distributor_id='1' or distributor_id='189')";
        } else if ($status=="pending_for_delivery"){
            $cond=" where (status='Approved' or status='Rejected') and delivery_status='Pending' and (distributor_id='1' or distributor_id='189')";
        } else if ($status=="gp_issued"){
            $cond=" where (status='Approved' or status='Rejected') and delivery_status='GP Issued' and (distributor_id='1' or distributor_id='189')";
        } else if ($status=="delivered_not_complete"){
            $cond=" where (status='Approved' or status='Rejected') and delivery_status='Delivered Not Complete' and (distributor_id='1' or distributor_id='189')";
        } else {
            $cond=" where status='".$status."' and (distributor_id='1' or distributor_id='189')";
        }
        
    } else {
        // $cond=" where distributor_name='Sample'";
        $cond=" where (distributor_id='1' or distributor_id='189')";
    }

    if($id!=""){
        if($cond=="") {
            // $cond=" where d_id='".$id."' and distributor_name='Sample'";
            $cond=" where d_id='".$id."' and (distributor_id='1' or distributor_id='189')";
        } else {
            // $cond=$cond." and d_id='".$id."' and distributor_name='Sample'";
            $cond=$cond." and d_id='".$id."' and (distributor_id='1' or distributor_id='189')";
        }
    }

    $sql = "select * from 
            (select concat('d_',I.id) as d_id, I.id, I.date_of_processing, I.invoice_no, I.voucher_no, I.gate_pass_no,  
            I.distributor_id, I.sales_rep_id, 
            I.final_amount,  I.status, I.created_on, I.modified_on, I.class,
            I.client_name, I.depot_name,
            I.distributor_name, I.sales_rep_name, I.user_name, 
            I.sample_distributor_id, I.delivery_status, I.location, I.sample_type, I.gifting_remarks, I.promoter_sales_rep_id, 
            I.blogger_name, I.blogger_address, I.blogger_phone_no, I.blogger_email_id, J.sales_rep_name as del_person_name from 
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
            null as sample_distributor_id, null as delivery_status, C.location, null as sample_type, null as gifting_remarks, 
            null as promoter_sales_rep_id, null as blogger_name, null as blogger_address, null as blogger_phone_no, 
            null as blogger_email_id, null as del_person_name from 
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

        
    // $sql = "select * from 
    //         (select concat('d_',G.id) as d_id, G.id, G.date_of_processing, G.invoice_no, G.voucher_no, G.gate_pass_no, G.depot_id, 
    //         G.distributor_id, G.sales_rep_id, 
    //         G.amount, G.tax, G.tax_per, G.tax_amount, G.final_amount, G.due_date, G.order_no, G.order_date, G.supplier_ref, 
    //         G.despatch_doc_no, G.despatch_through, G.destination, G.status, G.remarks, G.created_by, G.created_on, 
    //         G.modified_by, G.modified_on, G.approved_by, G.approved_on, G.rejected_by, G.rejected_on, G.client_name, G.address, 
    //         G.city, G.pincode, ifnull(G.state, G.distributor_state) as state, G.country, G.discount, 
    //         G.distributor_name, G.sell_out, G.class, G.depot_name, G.sales_rep_name, 
    //         concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
    //         G.sample_distributor_id, G.delivery_status, G.delivery_date, G.receivable_doc, G.location from 
    //         (select E.*, F.sales_rep_name from 
    //         (select Q.*, D.depot_name from 
    //         (select C.*, P.location from 
    //         (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state,B.location_id, B.class from 
    //         (select * from distributor_out) A 
    //         left join 
    //         (select * from distributor_master) B 
    //         on (A.distributor_id=B.id)) C 
    //         left join 
    //         (select * from location_master) P 
    //         on (C.location_id=P.id)) Q 
    //         left join
    //         (select * from depot_master) D 
    //         on (Q.depot_id=D.id)) E 
    //         left join 
    //         (select * from sales_rep_master) F 
    //         on (E.sales_rep_id=F.id)) G 
    //         left join 
    //         (select * from user_master) H 
    //         on (G.modified_by=H.id) 

    //         union all 

    //         select concat('s_',C.id) as d_id, null as id, C.date_of_processing, null as invoice_no, null as voucher_no, null as gate_pass_no, null as depot_id, 
    //         replace(C.distributor_id,'d_','') as distributor_id, C.created_by as sales_rep_id, C.amount, null as tax, null as tax_per, null as tax_amount, 
    //         C.amount as final_amount, null as due_date, null as order_no, null as order_date, null as supplier_ref, 
    //         null as despatch_doc_no, null as despatch_through, null as destination, 'Pending' as status, C.remarks, 
    //         C.created_by, C.created_on, C.modified_by, C.modified_on, C.approved_by, C.approved_on, C.rejected_by, C.rejected_on, 
    //         null as client_name, null as address, null as city, null as pincode, null as state, null as country, null as discount, 
    //         C.distributor_name, null as sell_out, null as class, null as depot_name, 
    //         concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
    //         concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, 
    //         null as sample_distributor_id, null as delivery_status, null as delivery_date, null as receivable_doc,C.location  from 
    //         (select A.*, B.distributor_name, B.state, B.sell_out, B.contact_person, B.contact_no, B.area, B.location from 
    //         (select * from sales_rep_orders where status = 'Approved') A 
    //         left join 
    //         (select concat('s_',id) as id, distributor_name, state, margin as sell_out, contact_person, contact_no, city as area , null as location
    //             from sales_rep_distributors 
    //         union all 
    //         select concat('d_',E.id) as id, E.distributor_name, E.state, E.sell_out, E.contact_person, E.contact_no, E.area, E.location from 
    //         (select M.*, L.location from 
    //         (select C.*, D.area from 
    //         (select A.*, B.contact_person, B.mobile as contact_no from 
    //         (select id, distributor_name, state, sell_out, area_id, location_id from distributor_master) A 
    //         left join 
    //         (select * from distributor_contacts) B 
    //         on (A.id = B.distributor_id)) C 
    //         left join 
    //         (select * from area_master) D 
    //         on (C.Area_id = D.id)) M
    //         left join
    //         (select * from location_master) L 
    //         on (M.location_id = L.id))E) B 
    //         on (A.distributor_id = B.id)) C 
    //         left join 
    //         (select * from user_master) D 
    //         on (C.modified_by=D.id)) I".$cond."
    //         order by I.modified_on desc";
    // $sql = "select * from 
    //         (select concat('d_',G.id) as d_id, G.id, G.date_of_processing, G.invoice_no, G.voucher_no, G.gate_pass_no, G.depot_id, 
    //         G.distributor_id, G.sales_rep_id, 
    //         G.amount, G.tax, G.tax_per, G.tax_amount, G.final_amount, G.due_date, G.order_no, G.order_date, G.supplier_ref, 
    //         G.despatch_doc_no, G.despatch_through, G.destination, G.status, G.remarks, G.created_by, G.created_on, 
    //         G.modified_by, G.modified_on, G.approved_by, G.approved_on, G.rejected_by, G.rejected_on, G.client_name, G.address, 
    //         G.city, G.pincode, ifnull(G.state, G.distributor_state) as state, G.country, G.discount, 
    //         G.distributor_name, G.sell_out, G.class, G.depot_name, G.sales_rep_name, 
    //         concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
    //         G.sample_distributor_id, G.delivery_status, G.delivery_date, G.receivable_doc from 
    //         (select E.*, F.sales_rep_name from 
    //         (select C.*, D.depot_name from 
    //         (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state, B.class from 
    //         (select * from distributor_out) A 
    //         left join 
    //         (select * from distributor_master) B 
    //         on (A.distributor_id=B.id)) C 
    //         left join 
    //         (select * from depot_master) D 
    //         on (C.depot_id=D.id)) E 
    //         left join 
    //         (select * from sales_rep_master) F 
    //         on (E.sales_rep_id=F.id)) G 
    //         left join 
    //         (select * from user_master) H 
    //         on (G.modified_by=H.id) 

    //         union all 

    //         select concat('s_',C.id) as d_id, null as id, C.date_of_processing, null as invoice_no, null as voucher_no, null as gate_pass_no, null as depot_id, 
    //         replace(C.distributor_id,'d_','') as distributor_id, C.created_by as sales_rep_id, C.amount, null as tax, null as tax_per, null as tax_amount, 
    //         C.amount as final_amount, null as due_date, null as order_no, null as order_date, null as supplier_ref, 
    //         null as despatch_doc_no, null as despatch_through, null as destination, 'Pending' as status, C.remarks, 
    //         C.created_by, C.created_on, C.modified_by, C.modified_on, C.approved_by, C.approved_on, C.rejected_by, C.rejected_on, 
    //         null as client_name, null as address, null as city, null as pincode, null as state, null as country, null as discount, 
    //         C.distributor_name, null as sell_out, null as class, null as depot_name, 
    //         concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
    //         concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, 
    //         null as sample_distributor_id, null as delivery_status, null as delivery_date, null as receivable_doc from 
    //         (select A.*, B.distributor_name, B.state, B.sell_out, B.contact_person, B.contact_no, B.area from 
    //         (select * from sales_rep_orders where status = 'Approved') A 
    //         left join 
    //         (select concat('s_',id) as id, distributor_name, state, margin as sell_out, contact_person, contact_no, city as area 
    //             from sales_rep_distributors 
    //         union all 
    //         select concat('d_',E.id) as id, E.distributor_name, E.state, E.sell_out, E.contact_person, E.contact_no, E.area from 
    //         (select C.*, D.area from 
    //         (select A.*, B.contact_person, B.mobile as contact_no from 
    //         (select id, distributor_name, state, sell_out, area_id from distributor_master) A 
    //         left join 
    //         (select * from distributor_contacts) B 
    //         on (A.id = B.distributor_id)) C 
    //         left join 
    //         (select * from area_master) D 
    //         on (C.Area_id = D.id)) E) B 
    //         on (A.distributor_id = B.id)) C 
    //         left join 
    //         (select * from user_master) D 
    //         on (C.modified_by=D.id)) I".$cond."
    //         order by I.modified_on desc";
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
            G.distributor_name, G.sell_out, G.class, G.depot_name, G.sales_rep_name, 
            concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
            G.sample_distributor_id, G.delivery_status, G.delivery_date, G.receivable_doc, G.location, G.sample_type, 
            G.gifting_remarks, G.promoter_sales_rep_id, G.blogger_name, G.blogger_address, G.blogger_phone_no, 
            G.blogger_email_id from 
            (select E.*, F.sales_rep_name from 
            (select Q.*, D.depot_name from 
            (select C.*, P.location from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state,B.location_id, B.class from 
            (select * from distributor_out) A 
            left join 
            (select * from distributor_master) B 
            on (A.sample_distributor_id=B.id)) C 
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
            C.distributor_name, null as sell_out, null as class, null as depot_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
            concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, 
            null as sample_distributor_id, null as delivery_status, null as delivery_date, null as receivable_doc,C.location, 
            null as sample_type, null as gifting_remarks, null as promoter_sales_rep_id, null as blogger_name, 
            null as blogger_address, null as blogger_phone_no, null as blogger_email_id  from 
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
    // $sql = "select * from 
    //         (select concat('d_',G.id) as d_id, G.id, G.date_of_processing, G.invoice_no, G.voucher_no, G.gate_pass_no, G.depot_id, 
    //         G.distributor_id, G.sales_rep_id, 
    //         G.amount, G.tax, G.tax_per, G.tax_amount, G.final_amount, G.due_date, G.order_no, G.order_date, G.supplier_ref, 
    //         G.despatch_doc_no, G.despatch_through, G.destination, G.status, G.remarks, G.created_by, G.created_on, 
    //         G.modified_by, G.modified_on, G.approved_by, G.approved_on, G.rejected_by, G.rejected_on, G.client_name, G.address, 
    //         G.city, G.pincode, ifnull(G.state, G.distributor_state) as state, G.country, G.discount, 
    //         G.distributor_name, G.sell_out, G.class, G.depot_name, G.sales_rep_name, 
    //         concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name, 
    //         G.sample_distributor_id, G.delivery_status, G.delivery_date, G.receivable_doc from 
    //         (select E.*, F.sales_rep_name from 
    //         (select C.*, D.depot_name from 
    //         (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state, B.class from 
    //         (select * from distributor_out) A 
    //         left join 
    //         (select * from distributor_master) B 
    //         on (A.distributor_id=B.id)) C 
    //         left join 
    //         (select * from depot_master) D 
    //         on (C.depot_id=D.id)) E 
    //         left join 
    //         (select * from sales_rep_master) F 
    //         on (E.sales_rep_id=F.id)) G 
    //         left join 
    //         (select * from user_master) H 
    //         on (G.modified_by=H.id) 

    //         union all 

    //         select concat('s_',C.id) as d_id, null as id, C.date_of_processing, null as invoice_no, null as voucher_no, null as gate_pass_no, null as depot_id, 
    //         replace(C.distributor_id,'d_','') as distributor_id, C.created_by as sales_rep_id, C.amount, null as tax, null as tax_per, null as tax_amount, 
    //         C.amount as final_amount, null as due_date, null as order_no, null as order_date, null as supplier_ref, 
    //         null as despatch_doc_no, null as despatch_through, null as destination, 'Pending' as status, C.remarks, 
    //         C.created_by, C.created_on, C.modified_by, C.modified_on, C.approved_by, C.approved_on, C.rejected_by, C.rejected_on, 
    //         null as client_name, null as address, null as city, null as pincode, null as state, null as country, null as discount, 
    //         C.distributor_name, null as sell_out, null as class, null as depot_name, 
    //         concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as sales_rep_name, 
    //         concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name, 
    //         null as sample_distributor_id, null as delivery_status, null as delivery_date, null as receivable_doc from 
    //         (select A.*, B.distributor_name, B.state, B.sell_out, B.contact_person, B.contact_no, B.area from 
    //         (select * from sales_rep_orders where status = 'Approved') A 
    //         left join 
    //         (select concat('s_',id) as id, distributor_name, state, margin as sell_out, contact_person, contact_no, city as area 
    //             from sales_rep_distributors 
    //         union all 
    //         select concat('d_',E.id) as id, E.distributor_name, E.state, E.sell_out, E.contact_person, E.contact_no, E.area from 
    //         (select C.*, D.area from 
    //         (select A.*, B.contact_person, B.mobile as contact_no from 
    //         (select id, distributor_name, state, sell_out, area_id from distributor_master) A 
    //         left join 
    //         (select * from distributor_contacts) B 
    //         on (A.id = B.distributor_id)) C 
    //         left join 
    //         (select * from area_master) D 
    //         on (C.Area_id = D.id)) E) B 
    //         on (A.distributor_id = B.id)) C 
    //         left join 
    //         (select * from user_master) D 
    //         on (C.modified_by=D.id)) I".$cond."
    //         order by I.modified_on desc";
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

    $sample_type = $this->input->post('sample_type');
    $gifting_remarks = null;
    $promoter_sales_rep_id = null;
    $blogger_name = null;
    $blogger_address = null;
    $blogger_phone_no = null;
    $blogger_email_id = null;

    if($sample_type=='Gifting'){
        $gifting_remarks = $this->input->post('gifting_remarks');
    } else if($sample_type=='Promoter'){
        $promoter_sales_rep_id = $this->input->post('promoter_sales_rep_id');
    } else if($sample_type=='Blogger'){
        $blogger_name = $this->input->post('blogger_name');
        $blogger_address = $this->input->post('blogger_address');
        $blogger_phone_no = $this->input->post('blogger_phone_no');
        $blogger_email_id = $this->input->post('blogger_email_id');
    }

    $sql="select * from series_master where type='Voucher'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $series=intval($result[0]->series)+1;

        $sql="update series_master set series = '$series' where type = 'Voucher'";
        $this->db->query($sql);
    } else {
        $series=1;

        $sql="insert into series_master (type, series) values ('Voucher', '$series')";
        $this->db->query($sql);
    }

    if (isset($date_of_processing)){
        $financial_year=calculateFiscalYearForDate($date_of_processing);
    } else {
        $financial_year="";
    }
    
    $voucher_no = 'WHPL/'.$financial_year.'/voucher/'.strval($series);

    $sql="select * from series_master where type='Gate_Pass'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $series=intval($result[0]->series)+1;

        $sql="update series_master set series = '$series' where type = 'Gate_Pass'";
        $this->db->query($sql);
    } else {
        $series=1;

        $sql="insert into series_master (type, series) values ('Gate_Pass', '$series')";
        $this->db->query($sql);
    }

    if (isset($date_of_processing)){
        $financial_year=calculateFiscalYearForDate($date_of_processing);
    } else {
        $financial_year="";
    }
    
    $gate_pass_no = 'WHPL/'.$financial_year.'/gate_pass/'.strval($series);

    $sample_distributor_id = $this->input->post('sample_distributor_id');
    if($sample_distributor_id==""){
        $sample_distributor_id = null;
    }

    $data = array(
        'date_of_processing' => $date_of_processing,
        'invoice_no' => $this->input->post('invoice_no'),
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
        'sample_type' => $sample_type,
        'gifting_remarks' => $gifting_remarks,
        'promoter_sales_rep_id' => $promoter_sales_rep_id,
        'blogger_name' => $blogger_name,
        'blogger_address' => $blogger_address,
        'blogger_phone_no' => $blogger_phone_no,
        'blogger_email_id' => $blogger_email_id,
        'voucher_no' => $voucher_no,
        'gate_pass_no' => $gate_pass_no
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

function set_sku_batch(){
    $check1=$this->input->post('check');
    $delivery_status=$this->input->post('delivery_status');
    $sales_rep_id=$this->input->post('sales_rep_id');
    $status=$this->input->post('status');
    $distributor_out_id=$this->input->post('distributor_out_id');
    $sales_item_id=$this->input->post('sales_item_id');

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
                    modified_by = '$curusr', modified_on = '$now' 
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

function get_sku_details(){
    $check1=$this->input->post('check');

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
    $data = array();

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
                order by O.voucher_no";
        $query = $this->db->query($sql);
        $data = $query->result();
    }

    return $data;
}

function get_batch_details(){
    $date = date("Y-m-d", strtotime("-6 months"));

    $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
    $query = $this->db->query($sql);
    return $query->result();
}

function set_delivery_status() {
    $check=$this->input->post('check');
    $sales_rep_id=$this->input->post('sales_rep_id');
    $delivery_status=$this->input->post('delivery_status');
    $status=$this->input->post('status');

    $distributor_out_id = implode(", ", $check);

    if($distributor_out_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
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
    }
}

function approve_records() {
    $check=$this->input->post('check');
    $dlvery_status=$this->input->post('dlvery_status');
    $status=$this->input->post('status');

    // echo json_encode($check);
    // echo json_encode($dlvery_status);
    // echo $status;

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

    // echo $distributor_out_id;
}

function reject_records() {
    $check=$this->input->post('check');
    // $dlvery_status=$this->input->post('dlvery_status');
    $status=$this->input->post('status');

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