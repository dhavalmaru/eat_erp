<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Distributor_po_model Extends CI_Model{

function __Construct(){
    parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('tax_invoice_model');
    $this->load->model('distributor_out_model');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_Out' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_pending_data($id=''){
    $query=$this->db->query("SELECT * FROM distributor_po WHERE ref_id = '$id' and status!='InActive' and  status!='Rejected'");
    $result=$query->result();
    if (count($result)>0){
        $id = $result[0]->id;
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

    $sql = "select G.*, concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name from 
            (select C.*, D.depot_name, D.address as depot_address, D.city as depot_city, D.pincode as depot_pincode, 
                D.state as depot_state, D.state_code as depot_state_code, D.country as depot_country from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state, B.class from 
            (select * from distributor_po".$cond.") A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id)) G 
            left join 
            (select * from user_master) H 
            on (G.modified_by=H.id) order by G.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_zone_data($status='', $type_id=''){
    if($status!=""){
        $cond=" where status='".$status."'";
    } else {
        $cond="";
    }

    if($type_id!=""){
        if($cond=="") {
            $cond=" where type_id='$type_id'";
        } else {
            $cond=$cond." and type_id='$type_id'";
        }
    }

    $sql = "select A.*, B.distributor_type from 
            (select * from zone_master".$cond.") A 
            left join 
            (select * from distributor_type_master) B 
            on (A.type_id=B.id) where A.status='Approved' order by A.zone";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_store_data($status='', $type_id='', $zone_id=''){
    if($status!=""){
        $cond=" where A.status='".$status."'";
    } else {
        $cond="";
    }

    if($type_id!=""){
        if($cond=="") {
            $cond=" where B.type_id='$type_id'";
        } else {
            $cond=$cond." and B.type_id='$type_id'";
        }
    }

    if($zone_id!=""){
        if($cond=="") {
            $cond=" where A.zone_id='$zone_id'";
        } else {
            $cond=$cond." and A.zone_id='$zone_id'";
        }
    }

   /* $sql = "select distinct A.store_id, B.store_name ,B.id from 
            (select A.* from store_master A ".$cond.") A 
            left join 
            (select * from relationship_master) B 
            on (A.store_id=B.id) where A.status='Approved' order by B.store_name";*/
    $sql = "Select Distinct B.store_name,B.id as store_id ,B.id from 
            (Select * from store_master )A
            Left JOIN relationship_master B On (A.store_id=B.id) 
            ".$cond." order by B.store_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_location_data($status='', $type_id='', $zone_id='', $store_id=''){
    if($status!=""){
        $cond=" where A.status='".$status."'";
    } else {
        $cond="";
    }

    $cond2='';

    if($type_id!=""){
        $cond2=" and B.type_id='$type_id'";
    }

    if($zone_id!=""){
        if($cond=="") {
            $cond=" where A.zone_id='$zone_id'";
        } else {
            $cond=$cond." and A.zone_id='$zone_id'";
        }
    }

    if($store_id!=""){
        if($cond=="") {
            $cond=" where A.store_id='$store_id'";
        } else {
            $cond=$cond." and A.store_id='$store_id'";
        }
    }

    $sql = "select distinct A.location_id, B.location,B.id from 
            (select A.* from store_master A ".$cond.") A 
            Left JOIN relationship_master C On (A.store_id=C.id) 
            left join 
            (select * from location_master) B 
            on (A.location_id=B.id) where A.status='Approved' order by B.location";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_dist_consignee($distributor_id){
    $sql = "select id, concat(con_address, ', ', con_city, ' - ', con_pincode, ', ', con_state) as address 
            from distributor_consignee where distributor_id = '$distributor_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_po_data1($status='', $id=''){
    $curusr = $this->session->userdata('session_id');

    if($status!=""){
        if ($status=="Approved"){
            $cond=" where status='Approved' and (distributor_id!='1' and distributor_id!='189') and delivery_through!='WHPL'";
        } else if ($status=="mismatch"){
            $cond=" where mismatch='1' and (distributor_id!='1' and distributor_id!='189')";
        } else if ($status=="pending_for_approval"){
            $cond=" where (status='Pending' or status='Deleted') and (distributor_id!='1' and distributor_id!='189') and (mismatch!='1' or mismatch is null)";
        } else if ($status=="delivered"){
            $cond=" where status='Approved' and delivery_status='Delivered' and (distributor_id!='1' and distributor_id!='189') and 
                        delivery_through!='WHPL' and (mismatch!='1' or mismatch is null)";
        } else if ($status=="pending_for_delivery"){
            $cond=" where status='Approved' and delivery_status='' and (distributor_id!='1' and distributor_id!='189') and 
                        delivery_through!='WHPL' and type_id='7' and (mismatch!='1' or mismatch is null)";
        } else if ($status=="gt_dp"){
            $cond=" where status='Approved' and delivery_status='' and (distributor_id!='1' and distributor_id!='189') and 
                        delivery_through!='WHPL' and type_id='3' and (mismatch!='1' or mismatch is null)";
        } else if ($status=="pending_merchendiser_delivery"){
            $cond=" where status='Approved' and delivery_status='Pending' and (distributor_id!='1' and distributor_id!='189') and 
                        delivery_through!='WHPL' and (mismatch!='1' or mismatch is null)";
        } else if ($status=="gp_issued"){
            $cond=" where status='Approved' and delivery_status='GP Issued' and (distributor_id!='1' and distributor_id!='189') and 
                        delivery_through!='WHPL' and (mismatch!='1' or mismatch is null)";
        } else if ($status=="delivered_not_complete"){
            $cond=" where status='Approved' and delivery_status='Delivered Not Complete' and 
                            (distributor_id!='1' and distributor_id!='189') and delivery_through!='WHPL' and (mismatch!='1' or mismatch is null)";
        } else if ($status=="InActive"){
            $cond=" where status='Inactive' and delivery_status='Cancelled' and 
                            (distributor_id!='1' and distributor_id!='189')";
        } else {
            $cond=" where status='".$status."' and (distributor_id!='1' and distributor_id!='189' and delivery_through!='WHPL') and (mismatch!='1' or mismatch is null)";
        }
    } else {
        // $cond=" where distributor_name!='Sample'";
        $cond=" where (distributor_id!='1' and distributor_id!='189')";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }
    
    /*$sql = "select I.* from 
            (select G.*, concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name from 
            (select Q.*, D.depot_name from 
            (select C.*, P.location from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state, B.class from 
            (select *, datediff(po_expiry_date, curdate()) as days_to_expiry from distributor_po) A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            left join 
            (select * from location_master) P 
            on (C.location_id=P.id)) Q 
            left join
            (select * from depot_master) D 
            on (Q.depot_id=D.id)) G 
            left join 
            (select * from user_master) H 
            on (G.modified_by=H.id)) I ".$cond."
            order by I.modified_on desc";*/

        $sql = "select I.* from 
            (select G.*, concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name from 
            (select Q.*, D.depot_name from 
            (select C.*, P.location ,E.store_name from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state, B.class from 
            (select *, datediff(po_expiry_date, curdate()) as days_to_expiry from distributor_po) A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            LEFT join 
            (
            SELECT A.*,B.store_name,B.type_id from 
            (SELECT store_id,zone_id,location_id from store_master Where `status`='Approved')A
            Left JOIN
            (SELECT * from relationship_master WHERE `status`='Approved')B
            On (A.store_id=B.id)
            ) E
            On (C.type_id=E.type_id and C.store_id=E.store_id and C.location_id=E.location_id
            and C.zone_id=E.zone_id)
            left join 
            (select * from location_master) P 
            on (C.location_id=P.id)) Q 
            left join
            (select * from depot_master) D 
            on (Q.depot_id=D.id)) G 
            left join 
            (select * from user_master) H 
            on (G.modified_by=H.id)) I ".$cond."
            order by I.modified_on desc";

    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_po_data($status='', $id=''){
    if($status!=""){
        if ($status=="pending_for_delivery"){
            $cond=" where (status='Approved' or status='Rejected') and type_id='7' and delivery_status='pending'";
        } else if ($status=="gt_dp"){
            $cond=" where (status='Approved' or status='Rejected') and type_id='3' and delivery_status='pending'";
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
            $cond=" where id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }
    //query for approved ,approval pending, and all 
    $sql = "select * from 
            (select G.*, concat(ifnull(H.first_name,''),' ',ifnull(H.last_name,'')) as user_name from 
            (select Q.*, D.depot_name, D.state as depot_state from 
            (select C.*, P.location from 
            (select A.*, B.distributor_name, B.sell_out, B.state as distributor_state, B.class from 
            (select * from distributor_po) A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            left join 
            (select * from location_master) P 
            on (C.location_id=P.id)) Q 
            left join
            (select * from depot_master) D 
            on (Q.depot_id=D.id)) G 
            left join 
            (select * from user_master) H 
            on (G.modified_by=H.id)) I".$cond."
            order by I.modified_on desc";//query for nly pending
    
    $query=$this->db->query($sql);
    return $query->result();
}

function get_email_details($id=''){
    $tbl_name = 'email_master';
    $cond = " where email_type = 'distributor_po_mismatch'";
    if($id!=''){
        $tbl_name = 'email_details';
        $cond = $cond . " and email_ref_id = '$id'";
    }

    $sql = "select * from ".$tbl_name.$cond. " order by id desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_po_items($id){
    $sql = "select * from distributor_po_items where distributor_po_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_po_recon_items($id){
    $sql = "select A.*, case when B.qty is null then A.qty else B.qty end as d_qty, 
                case when B.sell_rate is null then A.sell_rate else B.sell_rate end as d_sell_rate, 
                case when B.amount is null then A.amount else B.amount end as d_amount, 
                case when B.cgst_amt is null then A.cgst_amt else B.cgst_amt end as d_cgst_amt, 
                case when B.sgst_amt is null then A.sgst_amt else B.sgst_amt end as d_sgst_amt, 
                case when B.igst_amt is null then A.igst_amt else B.igst_amt end as d_igst_amt, 
                case when B.tax_amt is null then A.tax_amt else B.tax_amt end as d_tax_amt, 
                case when B.total_amt is null then A.total_amt else B.total_amt end as d_total_amt 
            from distributor_po_items A left join distributor_po_delivered_items B 
                on (A.distributor_po_id=B.distributor_po_id and A.type=B.type and A.item_id=B.item_id) 
            where A.distributor_po_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_po=$this->input->post('date_of_po');
    if($date_of_po==''){
        $date_of_po=NULL;
    } else {
        $date_of_po=formatdate($date_of_po);
    }

    $po_expiry_date=$this->input->post('po_expiry_date');
    if($po_expiry_date==''){
        $po_expiry_date=NULL;
    } else {
        $po_expiry_date=formatdate($po_expiry_date);
    }

    $estimate_delivery_date=$this->input->post('estimate_delivery_date');
    if($estimate_delivery_date==''){
        $estimate_delivery_date=NULL;
    } else {
        $estimate_delivery_date=formatdate($estimate_delivery_date);
    }
    
    $dispatch_date=$this->input->post('dispatch_date');
    if($dispatch_date==''){
        $dispatch_date=NULL;
    } else {
        $dispatch_date=formatdate($dispatch_date);
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
    
    $email_date_time=$this->input->post('email_date_time');
    if($email_date_time==''){
        $email_date_time=NULL;
    } else {
        $email_date_time= date('Y-m-d H:i:s',strtotime($email_date_time));
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
        $remarks = $this->input->post('remarks');

        if($status == 'Rejected'){
            $sql = "Update distributor_po Set status='$status', remarks='$remarks', approved_by='$curusr', approved_on='$now', 
                            rejected_by='$curusr', rejected_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Distributor PO Entry '.$status.'. Delivery Status: ' . $delivery_status;
        } else {
            if($id!='' || $ref_id!='') { 
                if($ref_id!=null && $ref_id!=''){
                    $sql = "Update distributor_po A, distributor_po B 
                            Set A.date_of_po=B.date_of_po, A.po_expiry_date=B.po_expiry_date, A.po_number=B.po_number, 
                                A.depot_id=B.depot_id, A.delivery_through=B.delivery_through, 
                                A.distributor_id=B.distributor_id, A.type_id=B.type_id, A.zone_id=B.zone_id, 
                                A.store_id=B.store_id, A.location_id=B.location_id, A.amount=B.amount, A.tax=B.tax, 
                                A.tax_per=B.tax_per, A.tax_amount=B.tax_amount, A.final_amount=B.final_amount, 
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now', A.state=B.state, A.discount=B.discount, 
                                A.estimate_delivery_date=B.estimate_delivery_date, A.tracking_id=B.tracking_id, 
                                A.dispatch_date=B.dispatch_date, A.delivery_status=B.delivery_status, A.delivery_date=B.delivery_date, 
                                A.state_code = B.state_code, A.cgst = B.cgst, A.sgst = B.sgst, A.igst = B.igst, 
                                A.cgst_amount = B.cgst_amount, A.sgst_amount = B.sgst_amount, A.igst_amount = B.igst_amount, 
                                A.round_off_amount = B.round_off_amount, A.invoice_amount = B.invoice_amount, 
                                A.shipping_address=B.shipping_address, A.distributor_consignee_id=B.distributor_consignee_id, 
                                A.con_name=B.con_name, A.con_address=B.con_address, A.con_city=B.con_city, 
                                A.con_pincode=B.con_pincode, A.con_state=B.con_state, A.con_country=B.con_country, 
                                A.con_state_code=B.con_state_code, A.con_gst_number=B.con_gst_number, 
                                A.basis_of_sales=B.basis_of_sales, 
                                A.email_from=B.email_from, A.email_approved_by=B.email_approved_by, A.email_date_time=B.email_date_time,
                                A.comments=B.comments, A.doc_document=B.doc_document, A.document_name=B.document_name, 
                                A.entered_invoice_amount=B.entered_invoice_amount, 
                                A.mismatch=B.mismatch, A.mismatch_type=B.mismatch_type 
                                WHERE A.id = '$ref_id' and B.id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from distributor_po where id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from distributor_po_items WHERE distributor_po_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update distributor_po_items set distributor_po_id='$ref_id' WHERE distributor_po_id = '$id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {
                    $sql = "Update distributor_po A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

                $delivery_through = '';
                $sql = "select * from distributor_po where id = '$id'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $delivery_through = $result[0]->delivery_through;
                }

                if(strtoupper(trim($delivery_through))=='WHPL'){
                    $invoice_no = '';
                    $invoice_date = NULL;
                    $distributor_out_id = '';
                    $sql = "select * from distributor_out where distributor_po_id = '$id'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0){
                        $invoice_no = $result[0]->invoice_no;
                        $invoice_date = $result[0]->invoice_date;
                        $distributor_out_id = $result[0]->id;
                    }

                    if($distributor_out_id==null || $distributor_out_id==''){
                        $sql = "insert into distributor_out (date_of_processing, invoice_no, depot_id, distributor_id, amount, tax, tax_per, tax_amount, final_amount, order_no, order_date, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, state, discount, delivery_status, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, state_code, round_off_amount, invoice_amount, distributor_po_id,shipping_address ,distributor_consignee_id ,con_name ,con_address,con_city,con_pincode,con_state,con_country,con_state_code,con_gst_number,basis_of_sales,email_from,email_approved_by,email_date_time) 
                            select date_of_po, '$invoice_no', depot_id, distributor_id, amount, tax, tax_per, tax_amount, final_amount, po_number, date_of_po, 'pending', '$remarks', created_by, '$now', modified_by, '$now', '$curusr', '$now', state, discount, 'Pending', cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, state_code, round_off_amount, invoice_amount,  '$id' ,shipping_address ,distributor_consignee_id ,con_name ,con_address,con_city,con_pincode,con_state,con_country,con_state_code,con_gst_number,basis_of_sales,email_from,email_approved_by,email_date_time
                            from distributor_po where id='$id'";
                        $this->db->query($sql);
                        $distributor_out_id=$this->db->insert_id();                       
                    } else {
                        $sql = "update distributor_out A, distributor_po B set A.date_of_processing=B.date_of_po, A.invoice_no = '$invoice_no', A.depot_id=B.depot_id, A.distributor_id=B.distributor_id, A.amount=B.amount, A.tax=B.tax, A.tax_per=B.tax_per, A.tax_amount=B.tax_amount, A.final_amount=B.final_amount, A.order_no=B.po_number, A.order_date=B.date_of_po, A.modified_by=B.modified_by, A.modified_on=B.modified_on, A.approved_by=B.approved_by, A.approved_on=B.approved_on, A.state=B.state, A.discount=B.discount, A.cgst=B.cgst, A.sgst=B.sgst, A.igst=B.igst, A.cgst_amount=B.cgst_amount, A.sgst_amount=B.sgst_amount, A.igst_amount=B.igst_amount, A.state_code=B.state_code, A.round_off_amount=B.round_off_amount, A.invoice_amount=B.invoice_amount, 
                            A.shipping_address=B.shipping_address,
                            A.distributor_consignee_id=B.distributor_consignee_id,
                            A.con_name=B.con_name,A.con_address=B.con_address,A.con_city=B.con_city,A.basis_of_sales=B.basis_of_sales,
                            A.email_from=B.email_from,
                            A.email_approved_by=B.email_approved_by,
                            A.email_date_time=B.email_date_time,
                            A.con_pincode=B.con_pincode,A.con_state=B.con_state,A.con_country=B.con_country,A.con_state_code=B.con_state_code,A.con_gst_number=B.con_gst_number
                        where A.id='$distributor_out_id' and A.distributor_po_id=B.id and B.id='$id' and B.status='Approved'";
                        $this->db->query($sql);
                    }

                    $sql = "delete from distributor_out_items where distributor_out_id = '$distributor_out_id'";
                    $this->db->query($sql);

                    $sql = "insert into distributor_out_items (distributor_out_id, type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt,margin_per,tax_percentage,promo_margin ) select '$distributor_out_id', type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt,margin_per,tax_percentage,promo_margin from distributor_po_items where distributor_po_id = '$id'";
                    $this->db->query($sql);

                     /*$this->distributor_out_model->set_credit_note($distributor_out_id);*/
                }
                

                $action='Distributor PO Entry '.$status.'. Delivery Status: ' . $delivery_status;
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

        $distributor_consignee_id = ($this->input->post('distributor_consignee_id')==''?Null:$this->input->post('distributor_consignee_id'));
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


        $data = array(
            'date_of_po' => $date_of_po,
            'po_expiry_date' => $po_expiry_date,
            'po_number' => $this->input->post('po_number'),
            'depot_id' => ($this->input->post('depot_id')==''?Null:$this->input->post('depot_id')),
            'delivery_through' => $this->input->post('delivery_through'),
            'distributor_id' => $this->input->post('distributor_id'),
            'type_id' => $this->input->post('type_id'),
            'zone_id' => $this->input->post('zone_id'),
            'store_id' => $this->input->post('store_id'),
            'location_id' => $this->input->post('location_id'),
            'state' => $this->input->post('state'),
            'discount' => format_number($this->input->post('discount'),2),
            'amount' => format_number($this->input->post('total_amount'),2),
            'tax' => $this->input->post('tax'),
            'tax_per' => format_number($this->input->post('tax_per'),2),
            'tax_amount' => format_number($this->input->post('tax_amount'),2),
            'final_amount' => format_number($this->input->post('final_amount'),2),
            'status' => $status,
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'estimate_delivery_date' => $estimate_delivery_date,
            'tracking_id' => $this->input->post('tracking_id'),
            'dispatch_date' => $dispatch_date,
            'delivery_status' => $delivery_status,
            'delivery_date' => $delivery_date,
            'state_code' => $this->input->post('state_code'),
            'cgst' => format_number($this->input->post('cgst'),2),
            'sgst' => format_number($this->input->post('sgst'),2),
            'igst' => format_number($this->input->post('igst'),2),
            'cgst_amount' => format_number($this->input->post('cgst_amount'),2),
            'sgst_amount' => format_number($this->input->post('sgst_amount'),2),
            'igst_amount' => format_number($this->input->post('igst_amount'),2),
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
            'invoice_amount' => format_number($this->input->post('invoice_amount'),2),
            'ref_id' => $ref_id,
            'email_date_time' => $email_date_time,
            'basis_of_sales' => $this->input->post('basis_of_sales'),
            'email_from' => $this->input->post('email_from'),
            'email_approved_by' => $this->input->post('email_approved_by'),
            'doc_document' => $this->input->post('doc_document'),
            'document_name' => $this->input->post('document_name'),
            'entered_invoice_amount' => format_number($this->input->post('entered_invoice_amount'),2),
            'mismatch' => ($this->input->post('mismatch')==''?'0':$this->input->post('mismatch')),
            'mismatch_type' => $this->input->post('mismatch_type')
        );

        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            $this->db->insert('distributor_po',$data);
            $id=$this->db->insert_id();
            $action='Distributor PO Entry Created. Delivery Status: ' . $delivery_status;
        } else {
            $this->db->where('id', $id);
            $this->db->update('distributor_po',$data);
            $action='Distributor PO Entry Modified. Delivery Status: ' . $delivery_status;
        }

        $this->db->where('distributor_po_id', $id);
        $this->db->delete('distributor_po_items');

        $type=$this->input->post('type[]');
        $bar=$this->input->post('bar[]');
        $box=$this->input->post('box[]');
        $qty=$this->input->post('qty[]');
        $sell_rate=$this->input->post('sell_rate[]');
        $sell_margin=$this->input->post('sell_margin[]');
        $cgst=$this->input->post('cgst[]');
        $sgst=$this->input->post('sgst[]');
        $igst=$this->input->post('igst[]');
        $tax_per=$this->input->post('tax_per[]');
        $grams=$this->input->post('grams[]');
        $rate=$this->input->post('rate[]');
        $amount=$this->input->post('amount[]');
        $cgst_amt=$this->input->post('cgst_amt[]');
        $sgst_amt=$this->input->post('sgst_amt[]');
        $igst_amt=$this->input->post('igst_amt[]');
        $tax_amt=$this->input->post('tax_amt[]');
        $total_amt=$this->input->post('total_amt[]');
        $promo_margin=$this->input->post('promo_margin[]');

        for ($k=0; $k<count($type); $k++) {
            if(isset($type[$k]) and $type[$k]!="") {
                if($type[$k]=="Bar"){
                    $item_id=$bar[$k];
                } else {
                    $item_id=$box[$k];
                }
                $data = array(
                            'distributor_po_id' => $id,
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
                            'tax_percentage' => $tax_per[$k],
                            'cgst' => $cgst[$k],
                            'sgst' => $sgst[$k],
                            'igst' => $igst[$k]
                        );
                $this->db->insert('distributor_po_items', $data);
            }
        }

        if(isset($_FILES['doc_file']['name'])) {
            $filePath='uploads/Distributor/';
            $upload_path = './' . $filePath;
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $filePath='uploads/Distributor_PO/Distributor_PO_'.$id.'/';
            $upload_path = './' . $filePath;
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $confi['upload_path']=$upload_path;
            $confi['allowed_types']='*';
            $this->load->library('upload', $confi);
            $this->upload->initialize($confi);
            $extension="";

            $file_nm='doc_file';

            if(!empty($_FILES[$file_nm]['name'])) {
                if($this->upload->do_upload($file_nm)) {
                    // echo "Uploaded <br>";
                } else {
                    // echo "Failed<br>";
                    // echo $this->upload->data();
                }   

                $upload_data=$this->upload->data();
                $fileName=$upload_data['file_name'];
                $extension=$upload_data['file_ext'];
                    
                $data = array(
                    'doc_document' => $filePath.$fileName,
                    'document_name' => $fileName
                );

                $this->db->where('id', $id);
                $this->db->update('distributor_po',$data);
            }
        }

        if($this->input->post('mismatch')=="1"){
            $sql = "update email_details set email_ref_id = '$id' 
                    where email_type = 'distributor_po_mismatch' and created_by = '$curusr' and 
                        (email_ref_id is null or email_ref_id = '')";
            $this->db->query($sql);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_PO';
    $logarray['cnt_name']='Distributor_PO';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function update_recon($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $delivery_status = $this->input->post('delivery_status');
    if($delivery_status=='' || $delivery_status==null){
        $delivery_status = 'Pending';
    }

    $remarks = $this->input->post('remarks');
    $status=$this->input->post('status');

    $delivery_date=$this->input->post('delivery_date');
    if($delivery_date==''){
        $delivery_date=NULL;
    } else {
        $delivery_date=formatdate($delivery_date);
    }

    $dispatch_date=$this->input->post('dispatch_date');
    if($dispatch_date==''){
        $dispatch_date=NULL;
    } else {
        $dispatch_date=formatdate($dispatch_date);
    }

    $person_name=$this->input->post('person_name');
    $invoice_no=$this->input->post('invoice_no');
    $remarks=$this->input->post('remarks');
    
    $delivery_remarks=$this->input->post('delivery_remarks');
    // if($delivery_remarks==''){
    //     $delivery_remarks=$this->input->post('cancellation_reason');
    // }
    
    $cancellation_date=$this->input->post('cancellation_date');
    if($cancellation_date==''){
        $cancellation_date=NULL;
    } else {
        $cancellation_date=formatdate($cancellation_date);
    }

    if($delivery_status=="Cancelled"){
        $status = "InActive";
    }

    if($delivery_status=="Cancelled"){
    } else {
        $sql = "update distributor_po set 
                modified_by = '$curusr', modified_on = '$now', remarks = concat(remarks, '$remarks') 
                where  id = '$id'";
    }
    
    $this->db->query($sql);

    $data = array(
        'd_amount' => format_number($this->input->post('total_amount'),2),
        'd_cgst_amount' => format_number($this->input->post('cgst_amount'),2),
        'd_sgst_amount' => format_number($this->input->post('sgst_amount'),2),
        'd_igst_amount' => format_number($this->input->post('igst_amount'),2),
        'd_tax_amount' => format_number($this->input->post('tax_amount'),2),
        'd_final_amount' => format_number($this->input->post('final_amount'),2),
        'd_round_off_amount' => format_number($this->input->post('round_off_amount'),2),
        'd_invoice_amount' => format_number($this->input->post('invoice_amount'),2),
        'delivery_status' => $delivery_status,
        'delivery_date' => $delivery_date,
        'dispatch_date' => $dispatch_date,
        'cancelled_date' => $cancellation_date,
        'delivery_remarks' => $delivery_remarks,
        'person_name' => $person_name,
        'invoice_no' => $invoice_no,
        'status' => $status,
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    $this->db->where('id', $id);
    $this->db->update('distributor_po',$data);
    $action='Distributor PO Entry Modified. Delivery Status: ' . $delivery_status;

    $this->db->where('distributor_po_id', $id);
    $this->db->delete('distributor_po_delivered_items');

    $type=$this->input->post('type[]');
    $bar=$this->input->post('bar[]');
    $box=$this->input->post('box[]');
    $qty=$this->input->post('qty[]');
    $sell_rate=$this->input->post('sell_rate[]');
    $sell_margin=$this->input->post('sell_margin[]');
    $cgst=$this->input->post('cgst[]');
    $sgst=$this->input->post('sgst[]');
    $igst=$this->input->post('igst[]');
    $tax_per=$this->input->post('tax_per[]');
    $grams=$this->input->post('grams[]');
    $rate=$this->input->post('rate[]');
    $amount=$this->input->post('amount[]');
    $cgst_amt=$this->input->post('cgst_amt[]');
    $sgst_amt=$this->input->post('sgst_amt[]');
    $igst_amt=$this->input->post('igst_amt[]');
    $tax_amt=$this->input->post('tax_amt[]');
    $total_amt=$this->input->post('total_amt[]');
    $promo_margin=$this->input->post('promo_margin[]');

    for ($k=0; $k<count($type); $k++) {
        if(isset($type[$k]) and $type[$k]!="") {
            if($type[$k]=="Bar"){
                $item_id=$bar[$k];
            } else {
                $item_id=$box[$k];
            }
            $data = array(
                        'distributor_po_id' => $id,
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
                        'tax_percentage' => $tax_per[$k],
                        'cgst' => $cgst[$k],
                        'sgst' => $sgst[$k],
                        'igst' => $igst[$k]
                    );
            $this->db->insert('distributor_po_delivered_items', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_PO';
    $logarray['cnt_name']='Distributor_PO';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function set_delivery_status() {
    $check1=$this->input->post('check');
    $delivery_status=$this->input->post('delivery_status');
    $status=$this->input->post('status');
    $delivery_date=$this->input->post('delivery_date');
    if($delivery_date==''){
        $delivery_date=NULL;
    } else {
        $delivery_date=formatdate($delivery_date);
    }

    $dispatch_date=$this->input->post('dispatch_date');
    if($dispatch_date==''){
        $dispatch_date=NULL;
    } else {
        $dispatch_date=formatdate($dispatch_date);
    }


    $person_name=$this->input->post('person_name');
    $invoice_no=$this->input->post('invoice_no');
    $remarks=$this->input->post('remarks');
    $delivery_remarks=$this->input->post('delivery_remarks');
		if($delivery_remarks=='')
		{
			$delivery_remarks=$this->input->post('cancellation_reason');
		}

    $cancellation_date=$this->input->post('cancellation_date');

    if($cancellation_date==''){
        $cancellation_date=NULL;
    } else {
        $cancellation_date=formatdate($cancellation_date);
    }

    $check = array();
    $j=0;

    for($i=0; $i<count($check1); $i++){
        if($check1[$i]!='false'){
            $check[$j] = $check1[$i];
            $j = $j + 1;
        }
    }

    $distributor_po_id = implode(", ", $check);

    if($distributor_po_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        if($delivery_status=="Pending"){
            if($status!="InActive"){
                $status = "Approved";
            }
        } else if($delivery_status=="Cancelled"){
            $status = "InActive";
        }

        //,person_name='$person_name',invoice_no='$invoice_no'
        if($delivery_status=="Cancelled"){
            $sql = "update distributor_po set delivery_status = '$delivery_status', cancelled_date = '$cancellation_date',
                    status = '$status', modified_by = '$curusr', modified_on = '$now', 
                    remarks = concat(remarks, '$remarks'), delivery_remarks = '$delivery_remarks' 
                    where id in (".$distributor_po_id.")";
        } else {
            $sql = "update distributor_po set delivery_status = '$delivery_status', delivery_date = '$delivery_date',person_name='$person_name',invoice_no='$invoice_no',
                    status = '$status', modified_by = '$curusr', modified_on = '$now', 
                    remarks = concat(remarks, '$remarks'), delivery_remarks = '$delivery_remarks' , dispatch_date='$dispatch_date'
                    where id in (".$distributor_po_id.")";
        }
        
        $this->db->query($sql);
    }
}

function generate_po_delivery_report() {
    $sql = "Select Distinct * from (Select * from 
    (select AA.id, AA.date_of_po, AA.po_expiry_date, AA.order_no as po_number, AA.status, AA.remarks, 
        AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, 
        Case When (AA.delivery_status='Delivered Not Complete' and AA.status='Approved') Then 'Delivered' 
            When ((AA.delivery_status='Pending' and AA.status='Approved') OR (AA.delivery_status='Pending' and AA.status='pending')) Then 'Inprocess'
            When (AA.status='Inactive' OR AA.status='Rejected' and distributor_po_id IS NOT NULL) Then 'Cancelled'
            Else AA.delivery_status end as delivery_status, AA.delivery_through, 
        AA.delivery_date, case when AA.delivery_remarks is null or AA.delivery_remarks = '' then AA.remarks else AA.delivery_remarks end as delivery_remarks, 
        AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
        '' as store_name , AA.location, AA.item_type, AA.item_id,
        Case When (AA.status='Inactive' OR AA.status='Rejected' and distributor_po_id IS NOT NULL) Then AA.modified_on Else AA.cancelled_date end as cancelled_date, 
        sum(AA.item_qty) as tot_qty , AA.date_of_processing,AA.distributor_po_id,AA.comments from 
        (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name,
        case when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45) )) then E.type else 'Bar' end as item_type, 
        case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.item_id else F.product_id end as item_id, 
        case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.qty else (E.qty*F.qty) end as item_qty ,P.location
        from (Select A.*,B.po_expiry_date ,B.estimate_delivery_date,A.date_of_dispatch as dispatch_date,B.delivery_through,B.delivery_remarks,B.cancelled_date,B.date_of_po
        from distributor_out  A 
        join distributor_po  B on A.distributor_po_id=B.id
        Where (A.status='Approved' and (A.delivery_status='Delivered Not Complete' OR A.delivery_status='GP Issued' OR  A.delivery_status='Pending')
        OR A.status='pending' and (A.delivery_status='Pending'))
        OR (A.status = 'Inactive' and distributor_po_id IS NOT NULL)
        OR (A.status = 'Rejected' and distributor_po_id IS NOT NULL)
        and (A.distributor_id!='1' and A.distributor_id!='189'))A
        left join distributor_master B on(A.distributor_id=B.id)
        left join location_master P on (B.location_id=P.id)
        left join distributor_out_items E on (A.id=E.distributor_out_id) 
        left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id NOT IN (4,26,27,13,14,32,37,38,39,43,44,45)) 
        where CASE When (A.status = 'Inactive' OR A.status = 'Rejected') Then distributor_po_id IS NOT NULL ELSE 1=1 end and (CASE When A.delivery_status='Delivered Not Complete' Then distributor_po_id IS NOT NULL ELSE 1=1 end)
        and (CASE When A.status = 'Approved' Then distributor_po_id IS NOT NULL ELSE 1=1 end)
        ) AA 
        group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.order_no, AA.status, AA.remarks, 
            AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
            AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name,AA.item_type, AA.item_id, AA.cancelled_date ) AA
        Union
        Select * from 
            (select AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, 
                AA.delivery_date, AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
                AA.store_name, AA.location, AA.item_type, AA.item_id, AA.cancelled_date, 
                sum(AA.item_qty) as tot_qty,'' as date_of_processing,'' as distributor_po_id,AA.comments from 
            (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name, C.store_name, D.location, 
            case when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.type else 'Bar' end as item_type, 
            case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.item_id else F.product_id end as item_id, 
            case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.qty else (E.qty*F.qty) end as item_qty 
            from distributor_po A 
            left join distributor_master B on(A.distributor_id=B.id) 
            left join relationship_master C on(A.store_id=C.id) 
            left join location_master D on(A.location_id=D.id) 
            left join distributor_po_items E on (A.id=E.distributor_po_id) 
            left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id NOT IN (4,26,27,13,14,32,37,38,39,43,44,45)) 
            where A.delivery_through!='WHPL' and (A.status='Approved' or (A.status='InActive' and A.delivery_status='Cancelled'))) AA 
            group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
                AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, AA.store_name, 
                AA.location, AA.item_type, AA.item_id, AA.cancelled_date ,AA.comments
            order by AA.id, AA.distributor_id ) AA
            ) AA order by
            AA.id, AA.distributor_id";
    $query=$this->db->query($sql);
    $data=$query->result();

     if(count($data)>0) {
        $template_path=$this->config->item('template_path');
        $file = $template_path.'PO_Delivery_Master.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $delivered_row = 1;
        $cancelled_row = 1;
        $whpl_row = 9;
        $central_row = 9;
        $sarvodaya_row = 9;
        $allied_row = 9;
        $deepa_row = 9;
        $heera_row = 9;
        $steward_row = 9;
        $amoha_row = 9;
        $articolo_row = 9;
        $preduence_row = 9;
        $kosher_row = 9;

        $col_name[]=array();
        for($i=0; $i<=50; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $col=0;
        $prv_po_id='';
        $prv_po_id2='';
        $po_id='';
        $prv_distributor_id='';
        $distributor_id='';

        for($i=0; $i<count($data); $i++){
            $po_id=$data[$i]->id;
            $comments = $data[$i]->comments;
            if($po_id!=$prv_po_id){
                $prv_po_id = $po_id;
                $date_of_po = '';
                $po_expiry_date = '';
                $estimate_delivery_date = '';
                $dispatch_date = '';
                $delivery_date = '';
                $cancelled_date = '';
                if($data[$i]->date_of_po!=''){
                    $date_of_po = date("d-m-Y", strtotime($data[$i]->date_of_po));
                }
                if($data[$i]->po_expiry_date!=''){
                    $po_expiry_date = date("d-m-Y", strtotime($data[$i]->po_expiry_date));
                }
                if($data[$i]->estimate_delivery_date!=''){
                    $estimate_delivery_date = date("d-m-Y", strtotime($data[$i]->estimate_delivery_date));
                }
                if($data[$i]->dispatch_date!='' && $data[$i]->dispatch_date!='0000-00-00'){
                    $dispatch_date = date("d-m-Y", strtotime($data[$i]->dispatch_date));
                }
                if($data[$i]->delivery_date!=''){
                    $delivery_date = date("d-m-Y", strtotime($data[$i]->delivery_date));
                }
                if($data[$i]->cancelled_date!=''){
                    $cancelled_date = date("d-m-Y", strtotime($data[$i]->cancelled_date));
                }

                if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING'){
                    $objPHPExcel->setActiveSheetIndexByName('PO DELIVERD');
                    $delivered_row = $delivered_row + 1;
                    $row = $delivered_row;
                } else if(strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                    $objPHPExcel->setActiveSheetIndexByName('PO CANCELLED');
                    $cancelled_row = $cancelled_row + 1;
                    $row = $cancelled_row;
                }
                
                if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING' || strtoupper(trim($data[$i]->delivery_status))=='CANCELLED' ){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $date_of_po);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $po_expiry_date);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->days_to_expiry);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->store_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->po_number);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->location);
                    if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);*/
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $data[$i]->tracking_id);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+27].$row, $dispatch_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+28].$row, $delivery_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+29].$row, $comments);
                    } else if(strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $data[$i]->delivery_remarks);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+27].$row, $cancelled_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+28].$row, $comments);
                    }
                }
            }

            if(($data[$i]->status=='Approved' || strtoupper(trim($data[$i]->status))=='INACTIVE') && strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING' || strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                if(strtoupper(trim($data[$i]->item_type))=='BOX' && (strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING'|| strtoupper(trim($data[$i]->delivery_status))=='CANCELLED') && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27'  || $data[$i]->item_id=='13'  || $data[$i]->item_id=='14'  || $data[$i]->item_id=='32'  || $data[$i]->item_id=='4' )){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->tot_qty);
                } else if(strtoupper(trim($data[$i]->item_type))=='BOX' && (strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING') && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27'  || $data[$i]->item_id=='13'  || $data[$i]->item_id=='14'  || $data[$i]->item_id=='32'  || $data[$i]->item_id=='4' )){
                    $tot_qty = $objPHPExcel->getActiveSheet()->getCell($col_name[$col+15].$row)->getValue();
                    if($tot_qty=='') $tot_qty = 0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, (intval($tot_qty) + intval($data[$i]->tot_qty)));
                } else if($data[$i]->item_id=='3'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='1'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='5'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='6'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='4' && strtoupper(trim($data[$i]->item_type))=='BAR'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='10'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='9'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='21'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, $data[$i]->tot_qty);
                }  
                else if($data[$i]->item_id=='20'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='19'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='37'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='38'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='39'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='43'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='44'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='45'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $data[$i]->tot_qty);
                }
            }


            if(strtoupper(trim($data[$i]->delivery_status))!='DELIVERED' && strtoupper(trim($data[$i]->delivery_status))!='PENDING' && strtoupper(trim($data[$i]->delivery_status))!='CANCELLED' || strtoupper(trim($data[$i]->delivery_status))=='GP ISSUED' || strtoupper(trim($data[$i]->delivery_status))=='INPROCESS' ){
                $distributor_id=$data[$i]->distributor_id;

                if($distributor_id!=$prv_distributor_id || $po_id!=$prv_po_id2){
                    if($po_id!=$prv_po_id2){
                        $prv_po_id2 = $po_id;
                    }
                    if($distributor_id!=$prv_distributor_id){
                        $prv_distributor_id = $distributor_id;
                    }
                    
                    if(strtoupper(trim($data[$i]->delivery_through))=='WHPL'){
                        $objPHPExcel->setActiveSheetIndexByName('WHPL');
                        $whpl_row = $whpl_row + 1;
                        $row = $whpl_row;
                    } else if($distributor_id=='107'){
                        $objPHPExcel->setActiveSheetIndexByName('Central Distributor');
                        $central_row = $central_row + 1;
                        $row = $central_row;
                    } else if($distributor_id=='617'){
                        $objPHPExcel->setActiveSheetIndexByName('Sarvodaya Sales');
                        $sarvodaya_row = $sarvodaya_row + 1;
                        $row = $sarvodaya_row;
                    } else if($distributor_id=='184' || $distributor_id=='453' || $distributor_id=='454'){
                        $objPHPExcel->setActiveSheetIndexByName('Allied');
                        $allied_row = $allied_row + 1;
                        $row = $allied_row;
                    } else if($distributor_id=='413'){
                        $objPHPExcel->setActiveSheetIndexByName('Deepa');
                        $deepa_row = $deepa_row + 1;
                        $row = $deepa_row;
                    } else if($distributor_id=='567'){
                        $objPHPExcel->setActiveSheetIndexByName('Heera Impex');
                        $heera_row = $heera_row + 1;
                        $row = $heera_row;
                    } else if($distributor_id=='609'){
                        $objPHPExcel->setActiveSheetIndexByName('Steward');
                        $steward_row = $steward_row + 1;
                        $row = $steward_row;
                    } else if($distributor_id=='630'){
                        $objPHPExcel->setActiveSheetIndexByName('Amoha');
                        $amoha_row = $amoha_row + 1;
                        $row = $amoha_row;
                    }
                    else if($distributor_id=='648'){
                        $objPHPExcel->setActiveSheetIndexByName('Articolo');
                        $articolo_row = $articolo_row + 1;
                        $row = $articolo_row;
                    }
                    else if($distributor_id=='1303'){
                        $objPHPExcel->setActiveSheetIndexByName('Prudencee Beverages');
                        $preduence_row = $preduence_row + 1;
                        $row = $preduence_row;
                    }
                    else if($distributor_id=='1302'){
                        $objPHPExcel->setActiveSheetIndexByName('Kosher Beverages');
                        $kosher_row = $kosher_row + 1;
                        $row = $kosher_row;
                    }

                    

                    
                    $date_of_po = '';
                    $po_expiry_date = '';
                    $estimate_delivery_date = '';
                    $dispatch_date = '';
                    $delivery_date = '';
                    $cancelled_date = '';
                    if($data[$i]->date_of_po!=''){
                        $date_of_po = date("d-m-Y", strtotime($data[$i]->date_of_po));
                    }
                    if($data[$i]->po_expiry_date!=''){
                        $po_expiry_date = date("d-m-Y", strtotime($data[$i]->po_expiry_date));
                    }
                    if($data[$i]->estimate_delivery_date!=''){
                        $estimate_delivery_date = date("d-m-Y", strtotime($data[$i]->estimate_delivery_date));
                    }
                    if($data[$i]->dispatch_date!=''){
                        $dispatch_date = date("d-m-Y", strtotime($data[$i]->dispatch_date));
                    }
                    if($data[$i]->delivery_date!=''){
                        $delivery_date = date("d-m-Y", strtotime($data[$i]->delivery_date));
                    }
                    if($data[$i]->cancelled_date!=''){
                        $cancelled_date = date("d-m-Y", strtotime($data[$i]->cancelled_date));
                    }
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $date_of_po);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $po_expiry_date);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->days_to_expiry);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->store_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->po_number);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->location);
                    if(strtoupper(trim($data[$i]->delivery_through))=='WHPL'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                       /* $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);*/
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $data[$i]->tracking_id);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+27].$row, $dispatch_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+28].$row, $delivery_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+29].$row, $comments);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);*/
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $comments);
                    }
                }

                if(strtoupper(trim($data[$i]->item_type))=='BOX' && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27' || $data[$i]->item_id=='13'  || $data[$i]->item_id=='14'  || $data[$i]->item_id=='32'  || $data[$i]->item_id=='4')){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->tot_qty);
                } else if(strtoupper(trim($data[$i]->item_type))=='BOX' && strtoupper(trim($data[$i]->delivery_through))=='WHPL' && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27' || $data[$i]->item_id=='13'  || $data[$i]->item_id=='14'  || $data[$i]->item_id=='32'  || $data[$i]->item_id=='4')){
                    $tot_qty = $objPHPExcel->getActiveSheet()->getCell($col_name[$col+22].$row)->getValue();
                    if($tot_qty=='') $tot_qty = 0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, (intval($tot_qty) + intval($data[$i]->tot_qty)));
                } else if($data[$i]->item_id=='3'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='1'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='5'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='6'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='4' && strtoupper(trim($data[$i]->item_type))=='BAR'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='10'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='9'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='21'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, $data[$i]->tot_qty);
                }  
                else if($data[$i]->item_id=='20'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='19'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='37'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='38'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='39'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='43'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='44'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='45'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $data[$i]->tot_qty);
                }
            }
        }

        $objPHPExcel->setActiveSheetIndexByName('PO DELIVERD');
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+29].$delivered_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        /*for($col = 'A'; $col <= 'U'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $objPHPExcel->setActiveSheetIndexByName('PO CANCELLED');
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+28].$cancelled_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        /*for($col = 'A'; $col <= 'R'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $objPHPExcel->setActiveSheetIndexByName('WHPL');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+29].$whpl_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        /*for($col = 'A'; $col <= 'U'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $objPHPExcel->setActiveSheetIndexByName('Central Distributor');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$central_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        /*for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $objPHPExcel->setActiveSheetIndexByName('Sarvodaya Sales');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$sarvodaya_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        /*for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $objPHPExcel->setActiveSheetIndexByName('Allied');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$allied_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        /*for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $objPHPExcel->setActiveSheetIndexByName('Deepa');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+24].$deepa_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        /*for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $objPHPExcel->setActiveSheetIndexByName('Heera Impex');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$heera_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        /*for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $objPHPExcel->setActiveSheetIndexByName('Steward');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$steward_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        /*for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $objPHPExcel->setActiveSheetIndexByName('Amoha');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$amoha_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->setActiveSheetIndexByName('Articolo');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$articolo_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->setActiveSheetIndexByName('Prudencee Beverages');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$preduence_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->setActiveSheetIndexByName('Kosher Beverages');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$kosher_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        /*for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }*/

        $filename='PO_Delivery_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='PO Delivery report generated.';
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function send_po_delivery_report() {
    $sql = "Select Distinct * from (Select * from 
    (select AA.id, AA.date_of_po, AA.po_expiry_date, AA.order_no as po_number, AA.status, AA.remarks, 
        AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, Case When 
            (AA.delivery_status='Delivered Not Complete' and AA.status='Approved') Then 'Delivered' 
            When ((AA.delivery_status='Pending' and AA.status='Approved') OR (AA.delivery_status='Pending' and AA.status='pending')) Then 'Inprocess'
            When (AA.status='Inactive' OR AA.status='Rejected' and distributor_po_id IS NOT NULL) Then 'Cancelled'
            Else AA.delivery_status end as delivery_status, AA.delivery_through, 
        AA.delivery_date, AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
        '' as store_name , AA.location, AA.item_type, AA.item_id, Case When (AA.status='Inactive' OR AA.status='Rejected' and distributor_po_id IS NOT NULL) Then AA.modified_on Else AA.cancelled_date end as cancelled_date , 
        sum(AA.item_qty) as tot_qty , AA.date_of_processing,AA.distributor_po_id,AA.comments from 
        (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name,
        case when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45) )) then E.type else 'Bar' end as item_type, 
        case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.item_id else F.product_id end as item_id, 
        case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.qty else (E.qty*F.qty) end as item_qty ,P.location
        from (Select A.*,B.po_expiry_date ,B.estimate_delivery_date,A.date_of_dispatch as dispatch_date,B.delivery_through,B.delivery_remarks,B.cancelled_date,B.date_of_po
        from distributor_out  A 
        join distributor_po  B on A.distributor_po_id=B.id
        Where (A.status='Approved' and (A.delivery_status='Delivered Not Complete' OR A.delivery_status='GP Issued' OR  A.delivery_status='Pending')
        OR A.status='pending' and (A.delivery_status='Pending'))
        OR (A.status = 'Inactive' and distributor_po_id IS NOT NULL)
        OR (A.status = 'Rejected' and distributor_po_id IS NOT NULL)
        and (A.distributor_id!='1' and A.distributor_id!='189'))A
        left join distributor_master B on(A.distributor_id=B.id)
        left join location_master P on (B.location_id=P.id)
        left join distributor_out_items E on (A.id=E.distributor_out_id) 
        left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id NOT IN (4,26,27,13,14,32,37,38,39,43,44,45)) 
        where CASE When A.status = 'Inactive' Then distributor_po_id IS NOT NULL ELSE 1=1 end and (CASE When A.delivery_status='Delivered Not Complete' Then distributor_po_id IS NOT NULL ELSE 1=1 end)
        and (CASE When A.status = 'Approved' Then distributor_po_id IS NOT NULL ELSE 1=1 end)
        ) AA 
        group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.order_no, AA.status, AA.remarks, 
            AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
            AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name,AA.item_type, AA.item_id, AA.cancelled_date ) AA
        Union
        Select * from 
            (select AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, 
                AA.delivery_date, AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
                AA.store_name, AA.location, AA.item_type, AA.item_id, AA.cancelled_date, 
                sum(AA.item_qty) as tot_qty,'' as date_of_processing,'' as distributor_po_id,AA.comments from 
            (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name, C.store_name, D.location, 
            case when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.type else 'Bar' end as item_type, 
            case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.item_id else F.product_id end as item_id, 
            case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.qty else (E.qty*F.qty) end as item_qty 
            from distributor_po A 
            left join distributor_master B on(A.distributor_id=B.id) 
            left join relationship_master C on(A.store_id=C.id) 
            left join location_master D on(A.location_id=D.id) 
            left join distributor_po_items E on (A.id=E.distributor_po_id) 
            left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id NOT IN (4,26,27,13,14,32,37,38,39,43,44,45)) 
            where A.delivery_through!='WHPL' and (A.status='Approved' or (A.status='InActive' and A.delivery_status='Cancelled'))) AA 
            group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
                AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, AA.store_name, 
                AA.location, AA.item_type, AA.item_id, AA.cancelled_date ,AA.comments
            order by AA.id, AA.distributor_id ) AA
            ) AA order by
            AA.id, AA.distributor_id";
    $query=$this->db->query($sql);
    $data=$query->result();

     if(count($data)>0) {
        $template_path=$this->config->item('template_path');
        $file = $template_path.'PO_Delivery_Master.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $delivered_row = 1;
        $cancelled_row = 1;
        $whpl_row = 9;
        $central_row = 9;
        $sarvodaya_row = 9;
        $allied_row = 9;
        $deepa_row = 9;
        $heera_row = 9;
        $steward_row = 9;
        $amoha_row = 9;
        $articolo_row = 9;
        $preduence_row = 9;
        $kosher_row = 9;

        $col_name[]=array();
        for($i=0; $i<=50; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $col=0;
        $prv_po_id='';
        $prv_po_id2='';
        $po_id='';
        $prv_distributor_id='';
        $distributor_id='';

        for($i=0; $i<count($data); $i++){
            $po_id=$data[$i]->id;
            $comments = $data[$i]->comments;
            if($po_id!=$prv_po_id){
                $prv_po_id = $po_id;
                $date_of_po = '';
                $po_expiry_date = '';
                $estimate_delivery_date = '';
                $dispatch_date = '';
                $delivery_date = '';
                $cancelled_date = '';
                if($data[$i]->date_of_po!=''){
                    $date_of_po = date("d-m-Y", strtotime($data[$i]->date_of_po));
                }
                if($data[$i]->po_expiry_date!=''){
                    $po_expiry_date = date("d-m-Y", strtotime($data[$i]->po_expiry_date));
                }
                if($data[$i]->estimate_delivery_date!=''){
                    $estimate_delivery_date = date("d-m-Y", strtotime($data[$i]->estimate_delivery_date));
                }
                if($data[$i]->dispatch_date!='' && $data[$i]->dispatch_date!='0000-00-00'){
                    $dispatch_date = date("d-m-Y", strtotime($data[$i]->dispatch_date));
                }
                if($data[$i]->delivery_date!=''){
                    $delivery_date = date("d-m-Y", strtotime($data[$i]->delivery_date));
                }
                if($data[$i]->cancelled_date!=''){
                    $cancelled_date = date("d-m-Y", strtotime($data[$i]->cancelled_date));
                }

                if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING'){
                    $objPHPExcel->setActiveSheetIndexByName('PO DELIVERD');
                    $delivered_row = $delivered_row + 1;
                    $row = $delivered_row;
                } else if(strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                    $objPHPExcel->setActiveSheetIndexByName('PO CANCELLED');
                    $cancelled_row = $cancelled_row + 1;
                    $row = $cancelled_row;
                }
                
                if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING' || strtoupper(trim($data[$i]->delivery_status))=='CANCELLED' ){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $date_of_po);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $po_expiry_date);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->days_to_expiry);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->store_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->po_number);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->location);
                    if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);*/
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $data[$i]->tracking_id);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+27].$row, $dispatch_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+28].$row, $delivery_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+29].$row, $comments);
                    } else if(strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $data[$i]->delivery_remarks);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+27].$row, $cancelled_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+28].$row, $comments);
                    }
                }
            }

            if(($data[$i]->status=='Approved' || strtoupper(trim($data[$i]->status))=='INACTIVE') && strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING' || strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                if(strtoupper(trim($data[$i]->item_type))=='BOX' && (strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING' || strtoupper(trim($data[$i]->delivery_status))=='CANCELLED') && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27'  || $data[$i]->item_id=='13'  || $data[$i]->item_id=='14'  || $data[$i]->item_id=='32'  || $data[$i]->item_id=='4' )){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->tot_qty);
                } else if(strtoupper(trim($data[$i]->item_type))=='BOX' && (strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING') && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27'  || $data[$i]->item_id=='13'  || $data[$i]->item_id=='14'  || $data[$i]->item_id=='32'  || $data[$i]->item_id=='4' )){
                    $tot_qty = $objPHPExcel->getActiveSheet()->getCell($col_name[$col+15].$row)->getValue();
                    if($tot_qty=='') $tot_qty = 0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, (intval($tot_qty) + intval($data[$i]->tot_qty)));
                } else if($data[$i]->item_id=='3'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='1'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='5'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='6'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='4' && strtoupper(trim($data[$i]->item_type))=='BAR'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='10'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='9'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='21'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, $data[$i]->tot_qty);
                }  
                else if($data[$i]->item_id=='20'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='19'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='37'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='38'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='39'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='43'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='44'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='45'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $data[$i]->tot_qty);
                }
            }


            if(strtoupper(trim($data[$i]->delivery_status))!='DELIVERED' && strtoupper(trim($data[$i]->delivery_status))!='PENDING' && strtoupper(trim($data[$i]->delivery_status))!='CANCELLED' || strtoupper(trim($data[$i]->delivery_status))=='GP ISSUED' || strtoupper(trim($data[$i]->delivery_status))=='INPROCESS' ){
                $distributor_id=$data[$i]->distributor_id;

                if($distributor_id!=$prv_distributor_id || $po_id!=$prv_po_id2){
                    if($po_id!=$prv_po_id2){
                        $prv_po_id2 = $po_id;
                    }
                    if($distributor_id!=$prv_distributor_id){
                        $prv_distributor_id = $distributor_id;
                    }
                    
                    if(strtoupper(trim($data[$i]->delivery_through))=='WHPL'){
                        $objPHPExcel->setActiveSheetIndexByName('WHPL');
                        $whpl_row = $whpl_row + 1;
                        $row = $whpl_row;
                    } else if($distributor_id=='107'){
                        $objPHPExcel->setActiveSheetIndexByName('Central Distributor');
                        $central_row = $central_row + 1;
                        $row = $central_row;
                    } else if($distributor_id=='617'){
                        $objPHPExcel->setActiveSheetIndexByName('Sarvodaya Sales');
                        $sarvodaya_row = $sarvodaya_row + 1;
                        $row = $sarvodaya_row;
                    } else if($distributor_id=='184' || $distributor_id=='453' || $distributor_id=='454'){
                        $objPHPExcel->setActiveSheetIndexByName('Allied');
                        $allied_row = $allied_row + 1;
                        $row = $allied_row;
                    } else if($distributor_id=='413'){
                        $objPHPExcel->setActiveSheetIndexByName('Deepa');
                        $deepa_row = $deepa_row + 1;
                        $row = $deepa_row;
                    } else if($distributor_id=='567'){
                        $objPHPExcel->setActiveSheetIndexByName('Heera Impex');
                        $heera_row = $heera_row + 1;
                        $row = $heera_row;
                    } else if($distributor_id=='609'){
                        $objPHPExcel->setActiveSheetIndexByName('Steward');
                        $steward_row = $steward_row + 1;
                        $row = $steward_row;
                    } else if($distributor_id=='630'){
                        $objPHPExcel->setActiveSheetIndexByName('Amoha');
                        $amoha_row = $amoha_row + 1;
                        $row = $amoha_row;
                    }
                    else if($distributor_id=='648'){
                        $objPHPExcel->setActiveSheetIndexByName('Articolo');
                        $articolo_row = $articolo_row + 1;
                        $row = $articolo_row;
                    }
                    else if($distributor_id=='1303'){
                        $objPHPExcel->setActiveSheetIndexByName('Prudencee Beverages');
                        $preduence_row = $preduence_row + 1;
                        $row = $preduence_row;
                    }
                    else if($distributor_id=='1302'){
                        $objPHPExcel->setActiveSheetIndexByName('Kosher Beverages');
                        $kosher_row = $kosher_row + 1;
                        $row = $kosher_row;
                    }
                    
                    $date_of_po = '';
                    $po_expiry_date = '';
                    $estimate_delivery_date = '';
                    $dispatch_date = '';
                    $delivery_date = '';
                    $cancelled_date = '';
                    if($data[$i]->date_of_po!=''){
                        $date_of_po = date("d-m-Y", strtotime($data[$i]->date_of_po));
                    }
                    if($data[$i]->po_expiry_date!=''){
                        $po_expiry_date = date("d-m-Y", strtotime($data[$i]->po_expiry_date));
                    }
                    if($data[$i]->estimate_delivery_date!=''){
                        $estimate_delivery_date = date("d-m-Y", strtotime($data[$i]->estimate_delivery_date));
                    }
                    if($data[$i]->dispatch_date!=''){
                        $dispatch_date = date("d-m-Y", strtotime($data[$i]->dispatch_date));
                    }
                    if($data[$i]->delivery_date!=''){
                        $delivery_date = date("d-m-Y", strtotime($data[$i]->delivery_date));
                    }
                    if($data[$i]->cancelled_date!=''){
                        $cancelled_date = date("d-m-Y", strtotime($data[$i]->cancelled_date));
                    }
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $date_of_po);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $po_expiry_date);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->days_to_expiry);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->store_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->po_number);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->location);
                    if(strtoupper(trim($data[$i]->delivery_through))=='WHPL'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                       /* $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);*/
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $data[$i]->tracking_id);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+27].$row, $dispatch_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+28].$row, $delivery_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+29].$row, $comments);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);*/
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $comments);
                    }
                }

                if(strtoupper(trim($data[$i]->item_type))=='BOX' && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27' || $data[$i]->item_id=='13'  || $data[$i]->item_id=='14'  || $data[$i]->item_id=='32'  || $data[$i]->item_id=='4')){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->tot_qty);
                } else if(strtoupper(trim($data[$i]->item_type))=='BOX' && strtoupper(trim($data[$i]->delivery_through))=='WHPL' && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27' || $data[$i]->item_id=='13'  || $data[$i]->item_id=='14'  || $data[$i]->item_id=='32'  || $data[$i]->item_id=='4')){
                    $tot_qty = $objPHPExcel->getActiveSheet()->getCell($col_name[$col+22].$row)->getValue();
                    if($tot_qty=='') $tot_qty = 0;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, (intval($tot_qty) + intval($data[$i]->tot_qty)));
                } else if($data[$i]->item_id=='3'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='1'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='5'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='6'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='4' && strtoupper(trim($data[$i]->item_type))=='BAR'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='10'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->tot_qty);
                } else if($data[$i]->item_id=='9'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='21'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, $data[$i]->tot_qty);
                }  
                else if($data[$i]->item_id=='20'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='19'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='37'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='38'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='39'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='43'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='44'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='45'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $data[$i]->tot_qty);
                }
            }
        }

        $objPHPExcel->setActiveSheetIndexByName('PO DELIVERD');
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+29].$delivered_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('PO CANCELLED');
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+28].$cancelled_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('WHPL');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+29].$whpl_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Central Distributor');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$central_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Sarvodaya Sales');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$sarvodaya_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Allied');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$allied_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Deepa');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+24].$deepa_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Heera Impex');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$heera_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Steward');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$steward_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Amoha');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$amoha_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Articolo');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$amoha_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        for($col = 'A'; $col <= 'G'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        
        $filename='PO_Delivery_Report'.date('Y-F-d').'.xls';
        $path  = '/home/eatangcp/public_html/test/assets/uploads/daily_sales_rep_reports/';
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save($path.$filename); 
        $attachment = $path.$filename;

		 $to_email = 'priti.tripathi@eatanytime.in,operations@eatanytime.in,rishit.sanghvi@eatanytime.in,dhaval.maru@pecanreams.com,swapnil.darekar@eatanytime.in, ashwini.patil@pecanreams.com';
        /*$to_email = 'sangeeta.yadav@pecanreams.com';*/
        $from_email = 'cs@eatanytime.co.in';
        $from_email_sender = 'Wholesome Habits Pvt Ltd';
        $subject = 'PO Tracker Report - '.date('dS F Y');
        $table = $this->po_summary_report();
        $tbody = "<html><head>
                    <style>
                    #customers {
                        font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
                        border-collapse: collapse;
                        font-size: 12px;
                        word-spacing: 0.5px;
                        width:2400px!important;
                    }

                    #customers td, #customers th {
                        border: 1px solid #ddd;
                        padding: 2.4px;
                    }


                    #customers th {
                        padding-top: 4px;
                        padding-bottom: 4px;
                        text-align: center;
                        background-color: #002060;
                        color: white;
						vertical-align:middle;
                    }
                    </style>
                </head>
                <body>Hii ,<br /><br />
                Please find the PO tracker report attached for ".date('dS F Y')."
                <br>
                ".$table."
                <br /><br />Thanks,<br />Team EAT Anytime
                </body></html>";
        $bcc = 'sangeeta.yadav@pecanreams.com';

      echo 'mailsent'.$mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $tbody, $bcc,'',$attachment);
      if ($mailSent==1) {
          echo "Send";
      } else {
          echo "NOT Send".$mailSent;
      }

    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function set_sku_batch(){
    $check1=$this->input->post('check');
    $delivery_status=$this->input->post('delivery_status');
    $sales_rep_id=$this->input->post('sales_rep_id');
    $status=$this->input->post('status');
    $distributor_po_id=$this->input->post('distributor_po_id');
    $sales_item_id=$this->input->post('sales_item_id');

    if($distributor_po_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        if($delivery_status=="Pending"){
            if($status!="InActive"){
                $status = "Approved";
            }
        }

        if(isset($sales_rep_id) && $sales_rep_id!=''){
            $sql = "update distributor_po set delivery_status = '$delivery_status', delivery_sales_rep_id = '$sales_rep_id', 
                    status = '$status', modified_by = '$curusr', modified_on = '$now', gatepass_date = '$now'
                    where id in (".$distributor_po_id.")";
        } else {
            $sql = "update distributor_po set delivery_status = '$delivery_status', status = '$status', 
                    modified_by = '$curusr', modified_on = '$now' 
                    where id in (".$distributor_po_id.")";
        }
        
        $this->db->query($sql);

        for($i=0; $i<count($sales_item_id); $i++){
            $batch_no_qty=$this->input->post('batch_no_qty_'.$i);
            $batch_no_no=$this->input->post('batch_no_no_'.$i);

            $total_batch_no_qty = implode(", ", $batch_no_qty);
            $total_batch_no_no = implode(", ", $batch_no_no);

            if($sales_item_id[$i]!=''){
                $item_id = $sales_item_id[$i];
                $sql = "update distributor_po_items set batch_no = '$total_batch_no_no', batch_qty = '$total_batch_no_qty' 
                        where id = '$item_id'";
                $this->db->query($sql);
            }
            
        }

        if($delivery_status=='GP Issued'){
            $this->tax_invoice_model->generate_gate_pass($distributor_po_id);
        }
    }
}

function approve_records() {
    $check1=$this->input->post('check');
    $dlvery_status1=$this->input->post('dlvery_status');
    $date_of_po=$this->input->post('date_of_po');
    $status=$this->input->post('status');
    $invoice_date1=$this->input->post('invoice_date');

    $check = array();
    $dlvery_status = array();
    $j=0;

    for($i=0; $i<count($check1); $i++){
        if($check1[$i]!='false'){
            $check[$j] = $check1[$i];
            $dlvery_status[$j] = $dlvery_status1[$i];
            $date_of_po[$j] = $date_of_po[$i];
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

    $distributor_po_id = implode(", ", $check);

    if($distributor_po_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $sql = "update distributor_po set status = '$status', approved_by = '$curusr', approved_on = '$now' 
                    where id in (".$distributor_po_id.")";
        
        $this->db->query($sql);
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

    $distributor_po_id = implode(", ", $check);

    if($distributor_po_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $sql = "update distributor_po set delivery_status = case when delivery_status = 'Delivered Not Complete' then 'GP Issued' 
                                                                  when delivery_status = 'GP Issued' then 'Pending' 
                                                                  else 'Pending' end, 
                    status = '$status', modified_by = '$curusr', modified_on = '$now' 
                    where id in (".$distributor_po_id.")";
        
        $this->db->query($sql);
    }
}

function send_email() {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $login_name = $this->session->userdata('login_name');
    $email_sender = 'Wholesome Habits Pvt Ltd';

    $email_ref_id = $this->input->post('email_ref_id');
    $email_type = $this->input->post('email_type');
    $email_from = $this->input->post('email_from');
    $email_to = $this->input->post('email_to');
    $email_cc = $this->input->post('email_cc');
    $email_bcc = $this->input->post('email_bcc');
    $email_subject = $this->input->post('email_subject');
    $email_body = $this->input->post('email_body');

    // $email_ref_id = '';
    // $email_type = 'distributor_po_mismatch';
    // $email_from = 'cs@eatanytime.in';
    // $email_to = 'prasad.bhisale@pecanreams.com';
    // $email_cc = 'prasad.bhisale@pecanreams.com';
    // $email_bcc = 'prasad.bhisale@pecanreams.com';
    // $email_subject = 'PO Amount Mismatch';
    // $email_body = 'Hi, 

    //                 PO Amount Mismatch

    //                 Regards,

    //                 Team EatAnyTime';

    $message = '<html>
                    <head>
                    <style type="text/css">
                        pre {
                            font: small/1.5 Arial,Helvetica,sans-serif;
                        }
                    </style>
                    </head>
                    <body><pre>'.$email_body.'</pre><br/><br/>
                    Team EAT Anytime<br/><br/>'.ucwords(trim($login_name)).'
                    </body>
                    </html>';

    $mailSent=send_email_new($email_from,  $email_sender, $email_to, $email_subject, $message, $email_bcc, $email_cc);

    if($mailSent==1){
        $status = 1;
        $action='Distributor Po amount mismatch mail sent.';
    } else {
        $status = 0;
        $action='Distributor Po amount mismatch mail sending failed.';
    }
    $data = array(
        'email_ref_id' => ($email_ref_id==''?Null:$email_ref_id),
        'email_type' => $email_type,
        'email_from' => $email_from,
        'email_to' => $email_to,
        'email_cc' => $email_cc,
        'email_bcc' => $email_bcc,
        'email_subject' => $email_subject,
        'email_body' => $email_body,
        'status' => $status,
        'created_by' => $curusr,
        'created_on' => $now,
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    $this->db->insert('email_details',$data);
    $id=$this->db->insert_id();

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_PO';
    $logarray['cnt_name']='Distributor_PO';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    return $status;
}

public function get_relationship_product_details($status='', $id='', $relationship_id=''){
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

    if($relationship_id!=""){
        $cond2 = " and (B.relationship_id='".$relationship_id."' or B.relationship_id is null)";
    } else {
        $cond2 = " and (B.relationship_id is null)";
    }

    $sql = "select A.*, B.margin ,'0' as pro_margin from product_master A left join relationship_category_margin B 
            on(A.category_id=B.category_id ".$cond2.") 
            ".$cond." order by A.product_name";
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_relationship_box_details($status='', $id='', $relationship_id=''){
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

    if($relationship_id!=""){
        $cond2 = " and (B.relationship_id='".$relationship_id."' or B.relationship_id is null)";
    } else {
        $cond2 = " and (B.relationship_id is null)";
    }

    $sql = "select A.*, B.margin,'0' as pro_margin from box_master A left join relationship_category_margin B 
            on(A.category_id=B.category_id ".$cond2.") 
            ".$cond." order by A.box_name";
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_distributor_product_details($status='', $id='', $distributor_id=''){
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
       
        $cond2 = " and (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";
    } else {
        

        $cond2 = " and (B.distributor_id is null)";
    }

    $sql = "select A.*, B.inv_margin,B.pro_margin from product_master A left join distributor_category_margin B 
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
      
        $cond2 = " and (B.distributor_id='".$distributor_id."' or B.distributor_id is null)";

    } else {

        $cond2 = " and (B.distributor_id is null)";
    }

    $sql = "select A.*, B.inv_margin,B.pro_margin from box_master A left join distributor_category_margin B 
            on(A.category_id=B.category_id ".$cond2.") 
            ".$cond." order by A.box_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor($status='', $id='', $class=''){
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

    if($class!=""){
        if($class=='normal')
            {
                if($cond=="") {
                  $cond=" where class IN ('normal','super stockist')";
                } else {
                    $cond=$cond." and class IN ('normal','super stockist')";
                }
        }
        else
        {
            if($cond=="") {
                 $cond=" where class='".$class."'";
            } else {
                $cond=$cond." and class='".$class."'";
            }
        }
    }

    $sql = "select A.*, B.sales_rep_name from 
            (select * from distributor_master ".$cond.") A 
            left join 
            (select * from sales_rep_master) B 
            on (A.sales_rep_id=B.id) order by A.distributor_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

public function po_summary_report(){
    //(A.status='Inactive' and distributor_po_id IS NOT NULL)  
    $sql = "Select * from (Select * from 
    (select AA.id, AA.date_of_po, AA.po_expiry_date, AA.order_no as po_number, AA.status, AA.remarks, 
        AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, 
        Case When (AA.status='Inactive' OR AA.status='Rejected') and distributor_po_id IS NOT NULL  Then 'Cancelled'
        When AA.delivery_status='Delivered Not Complete' Then 'Delivered'
        Else AA.delivery_status end as delivery_status, AA.delivery_through, 
        AA.delivery_date, Case When AA.status='Inactive' and distributor_po_id IS NOT NULL  
        Then 'Deleted PO from Sales' Else AA.delivery_remarks end as delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
        '' as store_name , AA.location, AA.item_type, AA.item_id, 
        Case When (AA.status = 'Inactive' OR AA.status = 'Rejected') and distributor_po_id IS NOT NULL  
        Then AA.modified_on Else AA.cancelled_date end as cancelled_date, 
        sum(AA.item_qty) as tot_qty , AA.date_of_processing,AA.distributor_po_id,AA.comments from 
        (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name,
        case when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.type else 'Bar' end as item_type, 
        case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.item_id else F.product_id end as item_id, 
        case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.qty else (E.qty*F.qty) end as item_qty ,P.location
        from (Select A.*,B.po_expiry_date ,B.estimate_delivery_date,A.date_of_dispatch as dispatch_date,B.delivery_through,B.delivery_remarks,B.cancelled_date,B.date_of_po
        from distributor_out  A 
        left join distributor_po  B on A.distributor_po_id=B.id
        Where (A.status='Approved' and (A.delivery_status='GP Issued' or A.delivery_status='Delivered Not Complete'))
         and (A.distributor_id!='1' and A.distributor_id!='189'))A
        left join distributor_master B on(A.distributor_id=B.id)
        left join location_master P on (B.location_id=P.id)
        left join distributor_out_items E on (A.id=E.distributor_out_id) 
        left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id NOT IN (4,26,27,13,14,32)) 
        where CASE When (A.status = 'Inactive' OR A.status = 'Rejected') Then distributor_po_id IS NOT NULL and date(A.modified_on)=date(now())  ELSE 1=1 end
                and (CASE When A.delivery_status='Delivered Not Complete' Then distributor_po_id IS NOT NULL and date(A.modified_on)=date(now()) ELSE 1=1 end)) AA 
        group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.order_no, AA.status, AA.remarks, 
            AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
            AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name,AA.item_type, AA.item_id, AA.cancelled_date ) AA
        Union
        Select * from 
            (select AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, 
                AA.delivery_date, AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
                AA.store_name, AA.location, AA.item_type, AA.item_id, AA.cancelled_date, 
                sum(AA.item_qty) as tot_qty , '' as date_of_processing,'' as distributor_po_id,AA.comments from 
            (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name, C.store_name, D.location, 
            case when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.type else 'Bar' end as item_type, 
            case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.item_id else F.product_id end as item_id, 
            case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id IN (4,26,27,13,14,32,37,38,39,43,44,45))) then E.qty else (E.qty*F.qty) end as item_qty 
            from distributor_po A 
            left join distributor_master B on(A.distributor_id=B.id) 
            left join relationship_master C on(A.store_id=C.id) 
            left join location_master D on(A.location_id=D.id) 
            left join distributor_po_items E on (A.id=E.distributor_po_id) 
            left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id NOT IN (4,26,27,13,14,32)) 
            where ((A.status='Approved' and (A.delivery_status='Delivered' OR A.delivery_status='Pending') and date(A.modified_on)=date(now()))
                   or (A.status='Inactive' and A.delivery_status='Cancelled' and date(A.modified_on)=date(now()))
                   )) AA 
            group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
                AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, AA.store_name, 
                AA.location, AA.item_type, AA.item_id, AA.cancelled_date ) AA
            ) AA order by  CASE When (AA.delivery_status='GP Issued' and AA.distributor_po_id IS NOT NULL and AA.status='Approved') Then 1 
                When (AA.delivery_status='GP Issued' and (AA.distributor_po_id IS NULL OR AA.distributor_po_id='') and AA.status='Approved') Then 2
                When (AA.delivery_status='Delivered' OR AA.delivery_status='Pending' OR AA.delivery_status='Delivered Not Complete') Then 3 Else 4 end,AA.id, AA.distributor_id";
            
    $query=$this->db->query($sql);
    $data=$query->result();
    $prv_po_id='';
    $prv_po_id2='';
    $po_id='';
    $prv_distributor_id='';
    $distributor_id='';
    $po_status = '';
    $row = 2;
    $prv_delivery_status = '';

    
    $table = '';
    /*<p><b>PO IN TRANSIT</b> : </p>*/
    if(count($data)>0) {
        $table .= "
        <br>
        <table id='customers'>
        <tr>
        <th style='width:64px'>Date of PO</th>
        <th style='width:64px'>PO Expiry</th>
        <th style='width: 40px;'>Day to Expiry</th>
        <th style='width: 52px;'>MT Name</th>
        <th style='width: 206px;'>Distributor</th>
        <th style='width:93px;'>PO Number</th>
        <th style='width: 66px;'>Location</th>
        <th style='width: 29px;'>BS</th>
        <th style='width: 29px;'>O</th>
        <th style='width: 29px;'>CP</th>
        <th style='width: 29px;'>MG</th>
        <th style='width: 29px;'>BC</th>
        <th style='width: 29px;'>CHY</th>
        <th style='width: 29px;'>BB</th>
        <th style='width: 29px;'>VP</th>
        <th style='width: 29px;'>DP</th>
        <th style='width: 60px;'>TN (P&P) (200 gm)</th>
        <th style='width: 60px;'>TN (F&R) (200 gm)</th>
        <th style='width: 60px;'>TN (C&O) (200 gm)</th>
        <th style='width: 60px;'>cookies CR  (PK 4)</th>
        <th style='width: 60px;'>cookies CH  (PK 4)</th>
        <th style='width:81px;'>cookies DR CH  (PK 4)</th>
        <th style='width: 60px;'>cookies CR  (PK 8)</th>
        <th style='width: 60px;'>cookies CH  (PK 8)</th>
        <th style='width:81px;'>cookies DR CH  (PK 8)</th>
        <th style='width:30px;'>Total</th>
        <th style='width: 62px;'>Tracking ID</th>
        <th style='width:94px;'>Date of Dispatch</th>
        <th style='width:102px;'>Cancellation Date</th>
        <th style='width:102px;'>Delivery Remarks</th>
        <th style='width:94px;'>Delivery Date</th>
        <th style='width:94px;'>Comments</th>
      </tr>
        ";
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Delivery_po_summary.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $col_name[]=array();
        for($i=0; $i<=26; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $col=0;
        $flag=0;
        /*$po_id=$data[$i]->id;*/
        $count_data = count($data);
        $count_data = $count_data-1;
        $transitprimary = 0;
        $transitdirect = 0;
        $delivered  = 0;
        $cancelled = 0;
        $boolprimary = 0;
        $booldirect = 0;
        $booldelivered = 0;
        $boolcancelled = 0;


        for($i=0; $i<count($data); $i++){
            $po_id=$data[$i]->id;
            $distributor_id=$data[$i]->distributor_id;
            $delivery_status=$data[$i]->delivery_status;
            $distributor_po_id=$data[$i]->distributor_po_id;

            if($delivery_status=='Cancelled')
            {
                $cancelled = $cancelled+1;
            }
            elseif(($delivery_status=='Delivered' || $delivery_status=='Pending'))
            {
                $delivered = $delivered+1;
            }
            elseif($delivery_status=='GP Issued' && ($distributor_po_id!=NULL && $distributor_po_id!=''))
            {
                $transitprimary = $transitprimary+1;
            }
            elseif($delivery_status=='GP Issued' && $distributor_po_id==NULL)
            {
                $transitdirect = $transitdirect+1;
            }            
            
            if($po_id!=$prv_po_id || $distributor_id!=$prv_distributor_id){
                 if($prv_po_id!="")
                    {
                        $table .=  "<td  style='text-align:right'>".$BS."</td>
                            <td style='text-align:right'>".$O."</td>
                            <td style='text-align:right'>".$CP."</td>
                            <td style='text-align:right'>".$MG."</td>
                            <td style='text-align:right'>".$BC."</td>
                            <td style='text-align:right'>".$CHY."</td>
                            <td style='text-align:right'>".$BB."</td>
                            <td style='text-align:right'>".$VP."</td>
                            <td style='text-align:right'>".$DP."</td>
                            <td style='text-align:right'>".$TN_pp."</td>
                            <td style='text-align:right'>".$TN_fr."</td>
                            <td style='text-align:right'>".$TN_co."</td>
                            <td style='text-align:right'>".$cookies_CR."</td>
                            <td style='text-align:right'>".$cookies_CH."</td>
                            <td style='text-align:right'>".$cookies_DR_CH."</td>
                            <td style='text-align:right'>".$cookies_CR_8."</td>
                            <td style='text-align:right'>".$cookies_CH_8."</td>
                            <td style='text-align:right'>".$cookies_DR_CH_8."</td>
                            <td style='text-align:right'>".$Total."</td>
                            <td style='text-align:left'>".$Tracking_ID."</td>
                            <td style='text-align:left'>".$Date_of_Dispatc."</td>
                            <td style='text-align:left'>".$cancellation_date."</td>
                            <td style='text-align:left'> ".$remarks."</td>
                            <td style='text-align:left'> ".$delivery_date."</td>
                            <td style='text-align:left;width:200px'> ".$comments."</td>
                            </tr>
                        ";
                    }
             }

            if($transitprimary==1 && $boolprimary==0)
            {
              $table .=  "
                        <tr style='border:none'><td colspan='30' style='border:none'>&nbsp;</td></tr>
                        <tr style='border:none'>
                            <td colspan='30' style='border:none'><b>PO IN TRANSIT PRIMARY :</b></td>
                        </tr>

                        <tr style='border:none' ><td colspan='30' style='border:none'>&nbsp;</td></tr>";
             $boolprimary = 1;
            }

            if($transitdirect==1 && $booldirect==0)
            {
              $table .=  "
                        <tr style='border:none'><td colspan='30' style='border:none'>&nbsp;</td></tr>
                        <tr style='border:none'>
                            <td colspan='30' style='border:none'><b>PO IN TRANSIT DIRECT :</b></td>
                        </tr>

                        <tr style='border:none' ><td colspan='30' style='border:none'>&nbsp;</td></tr>";
                $booldirect = 1;
            }

            
            if($delivery_status=='Cancelled')
            {
               echo '<br>delivery_status_cancelled'.$delivery_status; 
            }

            if($delivery_status=='Delivered')
            {
                echo '<br>delivery_status_delivery'.$delivery_status;
            }

            if($delivery_status!=$prv_delivery_status && $delivery_status=='Cancelled' && $boolcancelled==0)
            {
                $table .=  "
                        <tr style='border:none'><td colspan='30' style='border:none'>&nbsp;</td></tr>
                        <tr style='border:none'>
                            <td colspan='30' style='border:none'><b>PO CANCELLED :</b></td>
                        </tr>

                        <tr style='border:none' ><td colspan='30' style='border:none'>&nbsp;</td></tr>";
                $boolcancelled = 1;
            }

            

             if($delivery_status!=$prv_delivery_status && ($delivery_status=='Delivered' || $delivery_status=='Pending') &&  $booldelivered==0)
            {
                $table .= "<tr style='border:none'>
                        <td td colspan='30' style='border:none'>&nbsp;</td></tr>
                        <tr style='border:none'>
                            <td colspan='30' style='border:none'><b>PO DELIVERED :</b></td>
                        </tr>
                        <tr style='border:none'><td colspan='30' style='border:none'>&nbsp;</td></tr>";
                $booldelivered = 1;
            }

             if($po_id!=$prv_po_id){                
                    $date_of_po = '';
                    $po_expiry_date = '';
                    $estimate_delivery_date = '';
                    $dispatch_date = '';
                    $delivery_date = '';
                    $cancelled_date = '';
                    $prv_delivery_status=$data[$i]->delivery_status;
                    $prv_distributor_id=$data[$i]->distributor_id;  
                    $BS='';
                    $O='';
                    $CP='';
                    $MG='';
                    $BC='';
                    $CHY='';
                    $BB='';
                    $VP='';
                    $DP='';
                    $TN_pp='';
                    $TN_fr='';
                    $TN_co='';
                    $cookies_CR='';
                    $cookies_CH='';
                    $cookies_DR_CH='';
                    $cookies_CR_8='';
                    $cookies_CH_8='';
                    $cookies_DR_CH_8='';
                    $Total=0;
                    $Appointment_Date='';
                    $Tracking_ID='';
                    $Date_of_Dispatc='';
                    $cancellation_date='';
                    $delivery_date='';
                    $remarks='';
                    $comments='';
                    
                    $prv_po_id = $po_id;

                    if($data[$i]->date_of_po!=''){
                        $date_of_po = date("d-m-Y", strtotime($data[$i]->date_of_po));
                    }
                    else if($data[$i]->date_of_po=='' && $data[$i]->delivery_status=='GP Issued')
                    {
                         $date_of_po = date("d-m-Y", strtotime($data[$i]->date_of_processing));
                    }

                    if($data[$i]->po_expiry_date!=''){
                        $po_expiry_date = date("d-m-Y", strtotime($data[$i]->po_expiry_date));
                    }
                    if($data[$i]->estimate_delivery_date!=''){
                        $estimate_delivery_date = date("d-m-Y", strtotime($data[$i]->estimate_delivery_date));
                    }
                    if($data[$i]->dispatch_date!='' && $data[$i]->dispatch_date!='0000-00-00'){
                        $Date_of_Dispatc = date("d-m-Y", strtotime($data[$i]->dispatch_date));;
                    }
                    if($data[$i]->delivery_date!=''){
                        $delivery_date = date("d-m-Y", strtotime($data[$i]->delivery_date));
                    }
                    if($data[$i]->cancelled_date!=''){
                        $cancellation_date = date("d-m-Y", strtotime($data[$i]->cancelled_date));
                    }

                    $remarks = $data[$i]->delivery_remarks;

                    
                    $Tracking_ID = $data[$i]->tracking_id;
                    $comments = $data[$i]->comments;


                    $style = '';
                    if (strpos($data[$i]->days_to_expiry, '-') !== false) {
                        $style = 'style="background-color: #e0a8a8"';
                    }


                    $table .=  "<tr>
                    <td>".$date_of_po."</td>
                    <td>".$po_expiry_date."</td>
                    <td ".$style.">".$data[$i]->days_to_expiry."</td>
                    <td style='text-align:center'>".$data[$i]->store_name."</td>
                    <td style='text-align:center'>".$data[$i]->distributor_name."</td>
                    <td style='text-align:center'>".$data[$i]->po_number."</td>
                    <td style='text-align:left'>".$data[$i]->location."</td>
                    ";

                    $Tracking_ID = $data[$i]->tracking_id;
                    $dispatch_date = $data[$i]->dispatch_date;

                    $row2 = $row;
                    $row = $row+1;
                    
                }

           if(strtoupper(trim($data[$i]->item_type))=='BOX' && ($data[$i]->item_id=='4' ||$data[$i]->item_id=='13' ||  $data[$i]->item_id=='14' || $data[$i]->item_id=='32')){
               $VP = $data[$i]->tot_qty;
               $Total = $Total+$VP;
                /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row2, $data[$i]->tot_qty);*/
            } /*else if(strtoupper(trim($data[$i]->item_type))=='BOX' && (strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING') && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27')){
                $tot_qty = $objPHPExcel->getActiveSheet()->getCell($col_name[$col+15].$row2)->getValue();
                if($tot_qty=='') $tot_qty = 0;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row2, (intval($tot_qty) + intval($data[$i]->tot_qty)));
            }*/ else if($data[$i]->item_id=='3'){
                $BS = $data[$i]->tot_qty;
                $Total = $Total+$BS;
                /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row2, $data[$i]->tot_qty);*/
            } else if($data[$i]->item_id=='1'){
                $O = $data[$i]->tot_qty;
                $Total = $Total+$O;
                /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row2, $data[$i]->tot_qty);*/
            } else if($data[$i]->item_id=='5'){
                $CP = $data[$i]->tot_qty;
                $Total = $Total+$CP;
                /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row2, $data[$i]->tot_qty);*/
            } else if($data[$i]->item_id=='6'){
                $MG = $data[$i]->tot_qty;
                $Total = $Total+$MG;
                /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row2, $data[$i]->tot_qty);*/
            } else if($data[$i]->item_id=='4' && strtoupper(trim($data[$i]->item_type))=='BAR'){
                $BC = $data[$i]->tot_qty;
                $Total = $Total+$BC;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row2, $data[$i]->tot_qty);
            } else if($data[$i]->item_id=='10'){
                $CHY = $data[$i]->tot_qty;
                $Total = $Total+$CHY;
                /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row2, $data[$i]->tot_qty);*/
            } else if($data[$i]->item_id=='9'){
                $BB = $data[$i]->tot_qty;
                $Total = $Total+$BB;
                /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row2, $data[$i]->tot_qty);*/
            } else if($data[$i]->item_id=='21'){
                $TN_pp = $data[$i]->tot_qty;
                $Total = $Total+$TN_pp;
                /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row2, $data[$i]->tot_qty);*/
            }  
            else if($data[$i]->item_id=='20'){
               $TN_fr = $data[$i]->tot_qty;
               $Total = $Total+$TN_fr;
            } 
            else if($data[$i]->item_id=='19'){
               $TN_co = $data[$i]->tot_qty;
               $Total = $Total+$TN_co;
            }
            /*else if($data[$i]->item_id=='18'){
               $cookies_CR = $data[$i]->tot_qty;
               $Total = $Total+$cookies_CR;
            } 
            else if($data[$i]->item_id=='16'){
               $cookies_CH = $data[$i]->tot_qty;
               $Total = $Total+$cookies_CH;
            }
            else if($data[$i]->item_id=='17'){
               $cookies_DR_CH = $data[$i]->tot_qty;
               $Total = $Total+$cookies_DR_CH;
            }*/
            else if($data[$i]->item_id=='37'){
                $cookies_CR = $data[$i]->tot_qty;
                $Total = $Total+$cookies_CR;
            } 
            else if($data[$i]->item_id=='38'){
                $cookies_CH = $data[$i]->tot_qty;
                $Total = $Total+$cookies_CH;
            }
            else if($data[$i]->item_id=='39'){
                $cookies_DR_CH = $data[$i]->tot_qty;
                $Total = $Total+$cookies_DR_CH;
            }
            else if($data[$i]->item_id=='43'){
                $cookies_CH_8 = $data[$i]->tot_qty;
                $Total = $Total+$cookies_CH_8;
            }
            else if($data[$i]->item_id=='44'){
                $cookies_CH_8 = $data[$i]->tot_qty;
                $Total = $Total+$cookies_CH_8;
            }
            else if($data[$i]->item_id=='45'){
                $cookies_DR_CH_8 = $data[$i]->tot_qty;
                $Total = $Total+$cookies_DR_CH_8;
            }

            /*if($distributor_id!=$prv_distributor_id || $po_id!=$prv_po_id2){
                if($po_id!=$prv_po_id2){
                    $prv_po_id2 = $po_id;
                    $row =$row+1;
                }
            }*/

            if($count_data==$i)
            {
               $table .=  "<td  style='text-align:right'>".$BS."</td>
                            <td style='text-align:right'>".$O."</td>
                            <td style='text-align:right'>".$CP."</td>
                            <td style='text-align:right'>".$MG."</td>
                            <td style='text-align:right'>".$BC."</td>
                            <td style='text-align:right'>".$CHY."</td>
                            <td style='text-align:right'>".$BB."</td>
                            <td style='text-align:right'>".$VP."</td>
                            <td style='text-align:right'>".$DP."</td>
                            <td style='text-align:right'>".$TN_pp."</td>
                            <td style='text-align:right'>".$TN_fr."</td>
                            <td style='text-align:right'>".$TN_co."</td>
                            <td style='text-align:right'>".$cookies_CR."</td>
                            <td style='text-align:right'>".$cookies_CH."</td>
                            <td style='text-align:right'>".$cookies_DR_CH."</td>
                            <td style='text-align:right'>".$cookies_CR_8."</td>
                            <td style='text-align:right'>".$cookies_CH_8."</td>
                            <td style='text-align:right'>".$cookies_DR_CH_8."</td>
                            <td style='text-align:right'>".$Total."</td>
                            <td style='text-align:left'>".$Tracking_ID."</td>
                            <td style='text-align:left'>".$Date_of_Dispatc."</td>
                            <td style='text-align:left'>".$cancellation_date."</td>
                            <td style='text-align:left'> ".$remarks."</td>
                            <td style='text-align:left'> ".$delivery_date."</td>
                            <td style='text-align:left;width:100px'> ".$comments."</td>
                            </tr>
                        "; 
            }
        }
        
        if($transitprimary==0)
        {
             $table .= "<tr style='border:none'>
                    <td td colspan='30' style='border:none'>&nbsp;</td></tr>
                    <tr style='border:none'>
                        <td colspan='30' style='border:none'><b>PO IN TRANSIT PRIMARY :</b></td>
                    </tr>
                    <tr ><td colspan='30'>No data available</td></tr>";
        }

         if($transitdirect==0)
        {
           $table .= "<tr style='border:none'>
                    <td td colspan='30' style='border:none'>&nbsp;</td></tr>
                    <tr style='border:none'>
                        <td colspan='30' style='border:none'><b>PO IN TRANSIT DIRECT :</b></td>
                    </tr>
                    <tr ><td colspan='30'>No data available</td></tr>";
        }

        if($delivered==0)
        {
          $table .= "<tr style='border:none'>
                    <td td colspan='30' style='border:none'>&nbsp;</td></tr>
                    <tr style='border:none'>
                        <td colspan='30' style='border:none'><b>PO DELIVERED :</b></td>
                    </tr>
                    <tr ><td colspan='30'>No data available</td></tr>";
        }

        if($cancelled==0)
        {
          $table .=  "
                    <tr style='border:none'><td colspan='30' style='border:none'>&nbsp;</td></tr>
                    <tr style='border:none'>
                        <td colspan='30' style='border:none'><b>PO CANCELLED :</b></td>
                    </tr>

                    <tr ><td colspan='30'>No data available</td></tr>";
        }
        $table .=  "</table>";
    }

    echo $tbody = "<html><head>
                    <style>
                    #customers {
                        font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
                        border-collapse: collapse;
                        font-size: 12px;
                        word-spacing: 0.5px;
                        width:2400px!important;
                    }

                    #customers td, #customers th {
                        border: 1px solid #ddd;
                        padding: 2.4px;
                    }


                    #customers th {
                        padding-top: 6px;
                        padding-bottom: 6px;
                      
                        vertical-align: middle;
                        background-color: #002060;
                        color: white;
						text-align:center;
                    }
                    </style>
                </head>
                <body>Hii ,<br /><br />
                Please find the PO tracker report attached for ".date('dS F Y')." ,
                <br>
                ".$table."
                <br /><br />Thanks,<br />Team EAT Anytime
                </body></html>";
    return $table;
}

public function get_comments($id){
    $result = $this->db->select('comments')->where('id',$id)->get('distributor_po')->result();
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
      $this->db->update('distributor_po',$data);
   }
}

function check_po_number_availablity(){
    $id=$this->input->post('id');
    $po_number=$this->input->post('po_number');
    $ref_id=$this->input->post('ref_id');

    // $id="";

    $query=$this->db->query("select * from distributor_po where id!='".$id."' and po_number='".$po_number."' and id!='".$ref_id."' and status!='InActive' and status!='Rejected'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

function check_po_number_availablity_whpl(){
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

}
?>