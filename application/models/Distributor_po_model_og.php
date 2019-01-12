<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Distributor_po_model Extends CI_Model{

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
            $cond=" where status='Approved' and (distributor_id!='1' and distributor_id!='189')";
        } else if ($status=="pending"){
            $cond=" where ((status='Pending' and (delivery_status is null or delivery_status = '')) or status='Rejected') and 
                            (distributor_id!='1' and distributor_id!='189')";
        } else if ($status=="pending_for_approval"){
            $cond=" where ((status='Pending' and (delivery_status='' or delivery_status='GP Issued' or 
                                delivery_status='Delivered Not Complete' or delivery_status='Delivered')) or status='Deleted') and 
                                (distributor_id!='1' and distributor_id!='189')";
        } else if ($status=="delivered"){
            $cond=" where status='Approved' and delivery_status='Delivered' and (distributor_id!='1' and distributor_id!='189')";
        }
        else if ($status=="pending_for_delivery"){
            $cond=" where status='Approved' and delivery_status='' and (distributor_id!='1' and distributor_id!='189')";
        } 
        else if ($status=="pending_merchendiser_delivery"){
            $cond=" where status='Approved' and delivery_status='Pending' and (distributor_id!='1' and distributor_id!='189')";
        }
        else if ($status=="gp_issued"){
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
            $cond=" where id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }
    
    $sql = "select I.* from 
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
            on (G.modified_by=H.id)) I".$cond."
            order by I.modified_on desc";

    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_po_data($status='', $id=''){
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

function get_distributor_po_items($id){
    $sql = "select * from distributor_po_items where distributor_po_id = '$id'";
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
                                A.round_off_amount = B.round_off_amount, A.invoice_amount = B.invoice_amount ,
                                A.shipping_address=B.shipping_address,
                                A.distributor_consignee_id=B.distributor_consignee_id,
                                A.con_name=B.con_name,A.con_address=B.con_address,A.con_city=B.con_city,
                                A.con_pincode=B.con_pincode,A.con_state=B.con_state,A.con_country=B.con_country,A.con_state_code=B.con_state_code,A.con_gst_number=B.con_gst_number,
                                A.person_name=B.person_name,A.invoice_no=B.invoice_no
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
                        $sql = "insert into distributor_out (date_of_processing, invoice_no, depot_id, distributor_id, amount, tax, tax_per, tax_amount, final_amount, order_no, order_date, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, state, discount, delivery_status, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, state_code, round_off_amount, invoice_amount, distributor_po_id,shipping_address ,distributor_consignee_id ,con_name ,con_address,con_city,con_pincode,con_state,con_country,con_state_code,con_gst_number) 
                            select date_of_po, '$invoice_no', depot_id, distributor_id, amount, tax, tax_per, tax_amount, final_amount, po_number, date_of_po, 'pending', '$remarks', created_by, '$now', modified_by, '$now', '$curusr', '$now', state, discount, 'Pending', cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, state_code, round_off_amount, invoice_amount,  '$id' ,shipping_address ,distributor_consignee_id ,con_name ,con_address,con_city,con_pincode,con_state,con_country,con_state_code,con_gst_number
                            from distributor_po where id='$id'";
                        $this->db->query($sql);
                        $distributor_out_id=$this->db->insert_id();
                    } else {
                        $sql = "update distributor_out A, distributor_po B set A.date_of_processing=B.date_of_po, A.invoice_no = '$invoice_no', A.depot_id=B.depot_id, A.distributor_id=B.distributor_id, A.amount=B.amount, A.tax=B.tax, A.tax_per=B.tax_per, A.tax_amount=B.tax_amount, A.final_amount=B.final_amount, A.order_no=B.po_number, A.order_date=B.date_of_po, A.modified_by=B.modified_by, A.modified_on=B.modified_on, A.approved_by=B.approved_by, A.approved_on=B.approved_on, A.state=B.state, A.discount=B.discount, A.cgst=B.cgst, A.sgst=B.sgst, A.igst=B.igst, A.cgst_amount=B.cgst_amount, A.sgst_amount=B.sgst_amount, A.igst_amount=B.igst_amount, A.state_code=B.state_code, A.round_off_amount=B.round_off_amount, A.invoice_amount=B.invoice_amount, A.invoice_date='$invoice_date', 
                            A.shipping_address=B.shipping_address,
                            A.distributor_consignee_id=B.distributor_consignee_id,
                            A.con_name=B.con_name,A.con_address=B.con_address,A.con_city=B.con_city,
                            A.con_pincode=B.con_pincode,A.con_state=B.con_state,A.con_country=B.con_country,A.con_state_code=B.con_state_code,A.con_gst_number=B.con_gst_number
                        where A.id='$distributor_out_id' and A.distributor_po_id=B.id and B.id='$id'";
                        $this->db->query($sql);
                    }

                    $sql = "delete from distributor_out_items where distributor_out_id = '$distributor_out_id'";
                    $this->db->query($sql);

                    $sql = "insert into distributor_out_items (distributor_out_id, type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt,margin_per,tax_percentage) select '$distributor_out_id', type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt,margin_per,tax_percentage from distributor_po_items where distributor_po_id = '$id'";
                    $this->db->query($sql);
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


        $data = array(
            'date_of_po' => $date_of_po,
            'po_expiry_date' => $po_expiry_date,
            'po_number' => $this->input->post('po_number'),
            'depot_id' => $this->input->post('depot_id'),
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
            'ref_id' => $ref_id
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
                            'tax_percentage' => $tax_per[$k]
                        );
                $this->db->insert('distributor_po_items', $data);
            }
        }
    }
    
    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_Out';
    $logarray['cnt_name']='Distributor_Out';
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

    $person_receving=$this->input->post('person_receving');
    $invoice_number=$this->input->post('invoice_number');
    $remarks=$this->input->post('remarks');
    $delivery_remarks=$this->input->post('delivery_remarks');
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

        //,person_name='$person_receving',invoice_no='$invoice_number'
        if($delivery_status=="Cancelled"){
            $sql = "update distributor_po set delivery_status = '$delivery_status', cancelled_date = '$cancellation_date',
                    status = '$status', modified_by = '$curusr', modified_on = '$now', 
                    remarks = concat(remarks, '$remarks'), delivery_remarks = '$delivery_remarks' 
                    where id in (".$distributor_po_id.")";
        } else {
            $sql = "update distributor_po set delivery_status = '$delivery_status', delivery_date = '$delivery_date',person_name='$person_receving',invoice_no='$invoice_number',
                    status = '$status', modified_by = '$curusr', modified_on = '$now', 
                    remarks = concat(remarks, '$remarks'), delivery_remarks = '$delivery_remarks' 
                    where id in (".$distributor_po_id.")";
        }
        
        $this->db->query($sql);
    }
}

function generate_po_delivery_report() {
    $sql = "select AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, 
                AA.delivery_date, AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
                AA.store_name, AA.location, AA.item_type, AA.item_id, AA.cancelled_date, 
                sum(AA.item_qty) as tot_qty from 
            (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name, C.store_name, D.location, 
            case when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.type else 'Bar' end as item_type, 
            case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.item_id else F.product_id end as item_id, 
            case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.qty else (E.qty*F.qty) end as item_qty 
            from distributor_po A 
            left join distributor_master B on(A.distributor_id=B.id) 
            left join relationship_master C on(A.store_id=C.id) 
            left join location_master D on(A.location_id=D.id) 
            left join distributor_po_items E on (A.id=E.distributor_po_id) 
            left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id!='4' and E.item_id!='26' and E.item_id!='27') 
            where (A.status='Approved' or (A.status='InActive' and A.delivery_status='Cancelled'))) AA 
            group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
                AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, AA.store_name, 
                AA.location, AA.item_type, AA.item_id, AA.cancelled_date 
            order by AA.id, AA.distributor_id";
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
                if($data[$i]->dispatch_date!=''){
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
                
                if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING' || strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $date_of_po);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $po_expiry_date);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->days_to_expiry);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->store_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->po_number);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->location);
                    if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $data[$i]->tracking_id);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, $dispatch_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $delivery_date);
                    } else if(strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $data[$i]->delivery_remarks);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $cancelled_date);
                    }
                }
            }

            if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING' || strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                if(strtoupper(trim($data[$i]->item_type))=='BOX' && $data[$i]->item_id=='4'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->tot_qty);
                } else if(strtoupper(trim($data[$i]->item_type))=='BOX' && (strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING') && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27')){
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
                } else if($data[$i]->item_id=='4'){
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
                else if($data[$i]->item_id=='18'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='16'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='17'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->tot_qty);
                }
            }


            if(strtoupper(trim($data[$i]->delivery_status))!='DELIVERED' && strtoupper(trim($data[$i]->delivery_status))!='PENDING' && strtoupper(trim($data[$i]->delivery_status))!='CANCELLED'){
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
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $data[$i]->tracking_id);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, $dispatch_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $delivery_date);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);
                    }
                }

                if(strtoupper(trim($data[$i]->item_type))=='BOX' && $data[$i]->item_id=='4'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->tot_qty);
                } else if(strtoupper(trim($data[$i]->item_type))=='BOX' && strtoupper(trim($data[$i]->delivery_through))=='WHPL' && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27')){
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
                } else if($data[$i]->item_id=='4'){
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
                else if($data[$i]->item_id=='18'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='16'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='17'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->tot_qty);
                }
            }
        }

        $objPHPExcel->setActiveSheetIndexByName('PO DELIVERD');
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+26].$delivered_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'U'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('PO CANCELLED');
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+24].$cancelled_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'R'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('WHPL');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$whpl_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'U'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Central Distributor');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$central_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Sarvodaya Sales');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$sarvodaya_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Allied');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$allied_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Deepa');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$deepa_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Heera Impex');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$heera_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Steward');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$steward_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Amoha');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$amoha_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

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
    $sql = "select AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, 
                AA.delivery_date, AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
                AA.store_name, AA.location, AA.item_type, AA.item_id, AA.cancelled_date, 
                sum(AA.item_qty) as tot_qty from 
            (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name, C.store_name, D.location, 
            case when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.type else 'Bar' end as item_type, 
            case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.item_id else F.product_id end as item_id, 
            case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.qty else (E.qty*F.qty) end as item_qty 
            from distributor_po A 
            left join distributor_master B on(A.distributor_id=B.id) 
            left join relationship_master C on(A.store_id=C.id) 
            left join location_master D on(A.location_id=D.id) 
            left join distributor_po_items E on (A.id=E.distributor_po_id) 
            left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id!='4' and E.item_id!='26' and E.item_id!='27') 
            where (A.status='Approved' or (A.status='InActive' and A.delivery_status='Cancelled'))) AA 
            group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
                AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
                AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, AA.store_name, 
                AA.location, AA.item_type, AA.item_id, AA.cancelled_date 
            order by AA.id, AA.distributor_id";
            
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
                if($data[$i]->dispatch_date!=''){
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
                
                if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING' || strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $date_of_po);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $po_expiry_date);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->days_to_expiry);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->store_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->po_number);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->location);
                    if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $data[$i]->tracking_id);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, $dispatch_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $delivery_date);
                    } else if(strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $data[$i]->delivery_remarks);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $cancelled_date);
                    }
                }
            }

            if(strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING' || strtoupper(trim($data[$i]->delivery_status))=='CANCELLED'){
                if(strtoupper(trim($data[$i]->item_type))=='BOX' && $data[$i]->item_id=='4'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->tot_qty);
                } else if(strtoupper(trim($data[$i]->item_type))=='BOX' && (strtoupper(trim($data[$i]->delivery_status))=='DELIVERED' || strtoupper(trim($data[$i]->delivery_status))=='PENDING') && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27')){
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
                } else if($data[$i]->item_id=='4'){
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
                else if($data[$i]->item_id=='18'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='16'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='17'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->tot_qty);
                }
            }


            if(strtoupper(trim($data[$i]->delivery_status))!='DELIVERED' && strtoupper(trim($data[$i]->delivery_status))!='PENDING' && strtoupper(trim($data[$i]->delivery_status))!='CANCELLED'){
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
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $data[$i]->tracking_id);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, $dispatch_date);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $delivery_date);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, '=SUBTOTAL(9,H'.$row.':V'.$row.')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $estimate_delivery_date);
                    }
                }

                if(strtoupper(trim($data[$i]->item_type))=='BOX' && $data[$i]->item_id=='4'){
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->tot_qty);
                } else if(strtoupper(trim($data[$i]->item_type))=='BOX' && strtoupper(trim($data[$i]->delivery_through))=='WHPL' && ($data[$i]->item_id=='26' || $data[$i]->item_id=='27')){
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
                } else if($data[$i]->item_id=='4'){
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
                else if($data[$i]->item_id=='18'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->tot_qty);
                } 
                else if($data[$i]->item_id=='16'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->tot_qty);
                }
                else if($data[$i]->item_id=='17'){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->tot_qty);
                }
            }
        }

        $objPHPExcel->setActiveSheetIndexByName('PO DELIVERD');
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+26].$delivered_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'U'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('PO CANCELLED');
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+24].$cancelled_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'R'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('WHPL');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+26].$whpl_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'U'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Central Distributor');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$central_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Sarvodaya Sales');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$sarvodaya_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Allied');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$allied_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Deepa');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$deepa_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Heera Impex');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$heera_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Steward');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$steward_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->setActiveSheetIndexByName('Amoha');
        $objPHPExcel->getActiveSheet()->getStyle('A9:'.$col_name[$col+23].$amoha_row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col <= 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $filename='PO_Delivery_Report'.date('Y-F-d').'.xls';
        $path  = '/home/eatangcp/public_html/test/assets/uploads/daily_sales_rep_reports/';
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save($path.$filename); 
        $attachment = $path.$filename;

        $to_email = 'priti.tripathi@eatanytime.in,operations@eatanytime.in,rishit.sanghvi@eatanytime.in,dhaval.maru@pecanreams.com';
       /* $to_email = 'dhaval.maru@pecanreams.com';*/
        $from_email = 'cs@eatanytime.co.in';
        $from_email_sender = 'Wholesome Habits Pvt Ltd';
        $subject = 'PO Tracker Report - '.date('dS F Y');
        $table = $this->po_summary_report();
        $tbody = "<html><head>
                    <style>
                    #customers {
                        font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }

                    #customers td, #customers th {
                        border: 1px solid #ddd;
                        padding: 8px;
                    }

                    #customers tr:hover {background-color: #ddd;}

                    #customers th {
                        padding-top: 12px;
                        padding-bottom: 12px;
                        text-align: left;
                        background-color: #002060;
                        color: white;
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

    $sql = "select A.*, B.margin from product_master A left join relationship_category_margin B 
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

    $sql = "select A.*, B.margin from box_master A left join relationship_category_margin B 
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

    $sql = "select A.*, B.margin from product_master A left join distributor_category_margin B 
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

    $sql = "select A.*, B.margin from box_master A left join distributor_category_margin B 
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


public function po_summary_report()
{
    $sql = "Select * from (Select * from 
    (select AA.id, AA.date_of_po, AA.po_expiry_date, AA.order_no as po_number, AA.status, AA.remarks, 
        AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, 
        AA.delivery_date, AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
        '' as store_name , '' as location, AA.item_type, AA.item_id, AA.cancelled_date, 
        sum(AA.item_qty) as tot_qty , AA.date_of_processing from 
    (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name,
    case when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.type else 'Bar' end as item_type, 
    case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.item_id else F.product_id end as item_id, 
    case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.qty else (E.qty*F.qty) end as item_qty 
    from (Select A.*,B.po_expiry_date ,B.estimate_delivery_date,B.dispatch_date,B.delivery_through,B.delivery_remarks,B.cancelled_date,B.date_of_po
    from distributor_out  A 
    left join distributor_po  B on A.distributor_po_id=B.id
    Where A.status='Approved' and A.delivery_status='GP Issued'
     and (A.distributor_id!='1' and A.distributor_id!='189'))A
    left join distributor_master B on(A.distributor_id=B.id) 
    left join distributor_out_items E on (A.id=E.distributor_out_id) 
    left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id!='4' and E.item_id!='26' and E.item_id!='27') 
    where A.status = 'Approved' ) AA 
    group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.order_no, AA.status, AA.remarks, 
        AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
        AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name,AA.item_type, AA.item_id, AA.cancelled_date ) AA
   
Union
Select * from 
    (select AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
        AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, 
        AA.delivery_date, AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, 
        AA.store_name, AA.location, AA.item_type, AA.item_id, AA.cancelled_date, 
        sum(AA.item_qty) as tot_qty , '' as date_of_processing from 
    (select A.*, datediff(A.po_expiry_date, curdate()) as days_to_expiry, B.distributor_name, C.store_name, D.location, 
    case when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.type else 'Bar' end as item_type, 
    case when E.type='Bar' then E.item_id when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.item_id else F.product_id end as item_id, 
    case when E.type='Bar' then E.qty when (E.type='Box' and (E.item_id='4' or E.item_id='26' or E.item_id='27')) then E.qty else (E.qty*F.qty) end as item_qty 
    from distributor_po A 
    left join distributor_master B on(A.distributor_id=B.id) 
    left join relationship_master C on(A.store_id=C.id) 
    left join location_master D on(A.location_id=D.id) 
    left join distributor_po_items E on (A.id=E.distributor_po_id) 
    left join box_product F on(E.type='Box' and E.item_id=F.box_id and E.item_id!='4' and E.item_id!='26' and E.item_id!='27') 
    where ((A.status='Approved' and (A.delivery_status='Delivered' OR A.delivery_status='Pending') and date(A.modified_on)=date(now()))
           or (A.status='Inactive' and A.delivery_status='Cancelled' and date(A.modified_on)=date(now()))
           )) AA 
    group by AA.id, AA.date_of_po, AA.po_expiry_date, AA.po_number, AA.status, AA.remarks, 
        AA.estimate_delivery_date, AA.tracking_id, AA.dispatch_date, AA.delivery_status, AA.delivery_through, AA.delivery_date, 
        AA.delivery_remarks, AA.days_to_expiry, AA.distributor_id, AA.distributor_name, AA.store_name, 
        AA.location, AA.item_type, AA.item_id, AA.cancelled_date ) AA
    ) AA order by  CASE When AA.delivery_status='GP Issued' Then 1 When (AA.delivery_status='Delivered' OR AA.delivery_status='Pending') Then 2 Else 3 end,AA.id, AA.distributor_id";
            
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
    if(count($data)>0) {
        $table .= "
        <p><b>PO IN TRANSIT</b> : </p>
        <table id='customers'>
        <tr>
        <th>Date of PO</th>
        <th>PO Expiry</th>
        <th>Day to Expiry</th>
        <th>MT Name</th>
        <th>Distributor</th>
        <th>PO Number</th>
        <th>Location</th>
        <th>BS</th>
        <th>O</th>
        <th>CP</th>
        <th>MG</th>
        <th>BC</th>
        <th>CHY</th>
        <th>BB</th>
        <th>VP</th>
        <th>DP</th>
        <th>TN (P&P) (200 gm)</th>
        <th>TN (F&R) (200 gm)</th>
        <th>TN (C&O) (200 gm)</th>
        <th>cookies CR</th>
        <th>cookies CH</th>
        <th>cookies DR CH</th>
        <th>Total</th>
        <th>Appointment Date</th>
        <th>Tracking ID</th>
        <th>Date of Dispatch</th>
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
        $po_id=$data[$i]->id;
        $count_data = count($data);
        $count_data = $count_data-1;

        for($i=0; $i<count($data); $i++){
            $po_id=$data[$i]->id;
            $distributor_id=$data[$i]->distributor_id;
            $delivery_status=$data[$i]->delivery_status;
            
             if($po_id!=$prv_po_id || $distributor_id!=$prv_distributor_id){
                 if($prv_po_id!="")
                    {
                        $table .=  "<td>".$BS."</td>
                            <td>".$O."</td>
                            <td>".$CP."</td>
                            <td>".$MG."</td>
                            <td>".$BC."</td>
                            <td>".$CHY."</td>
                            <td>".$BB."</td>
                            <td>".$VP."</td>
                            <td>".$DP."</td>
                            <td>".$TN_pp."</td>
                            <td>".$TN_fr."</td>
                            <td>".$TN_co."</td>
                            <td>".$cookies_CR."</td>
                            <td>".$cookies_CH."</td>
                            <td>".$cookies_DR_CH."</td>
                            <td>".$Total."</td>
                            <td>".$Appointment_Date."</td>
                            <td>".$Tracking_ID."</td>
                            <td>".$Date_of_Dispatc."</td>
                            </tr>
                        ";
                    }
             }

            if($delivery_status!=$prv_delivery_status && $delivery_status=='Cancelled')
            {
              $table .=  "
                        <tr style='border:none'><td colspan='26' style='border:none'>&nbsp;</td></tr>
                        <tr style='border:none'>
                            <td colspan='26' style='border:none'><b>PO CANCELLED :</b></td>
                        </tr>

                        <tr style='border:none' ><td colspan='26' style='border:none'>&nbsp;</td></tr>";
            }

             if($delivery_status!=$prv_delivery_status && ($delivery_status=='Delivered' || $delivery_status=='Pending'))
            {
              $table .= "<tr style='border:none'>
                        <td td colspan='26' style='border:none'>&nbsp;</td></tr>
                        <tr style='border:none'>
                            <td colspan='26' style='border:none'><b>PO Delivered :</b></td>
                        </tr>
                        <tr style='border:none'><td colspan='26' style='border:none'>&nbsp;</td></tr>";
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
                    $Total=0;
                    $Appointment_Date='';
                    $Tracking_ID='';
                    $Date_of_Dispatc='';
                    
                    $prv_po_id = $po_id;

                    if($data[$i]->date_of_po!=''){
                        $date_of_po = date("d-F-Y", strtotime($data[$i]->date_of_po));
                    }
                    else if($data[$i]->date_of_po=='' && $data[$i]->delivery_status=='GP Issued')
                    {
                         $date_of_po = date("d-F-Y", strtotime($data[$i]->date_of_processing));
                    }

                    if($data[$i]->po_expiry_date!=''){
                        $po_expiry_date = date("d-F-Y", strtotime($data[$i]->po_expiry_date));
                    }
                    if($data[$i]->estimate_delivery_date!=''){
                        $estimate_delivery_date = date("d-F-Y", strtotime($data[$i]->estimate_delivery_date));
                    }
                    if($data[$i]->dispatch_date!=''){
                        $dispatch_date = date("d-F-Y", strtotime($data[$i]->dispatch_date));
                    }
                    if($data[$i]->delivery_date!=''){
                        $delivery_date = date("d-F-Y", strtotime($data[$i]->delivery_date));
                    }
                    if($data[$i]->cancelled_date!=''){
                        $cancelled_date = date("d-F-Y", strtotime($data[$i]->cancelled_date));
                    }

                    $Date_of_Dispatc = $data[$i]->dispatch_date;
                    $Tracking_ID = $data[$i]->tracking_id;

                    $style = '';
                    if (strpos($data[$i]->days_to_expiry, '-') !== false) {
                        $style = 'style="background-color: #e0a8a8"';
                    }


                    $table .=  "<tr>
                    <td>".$date_of_po."</td>
                    <td>".$po_expiry_date."</td>
                    <td ".$style.">".$data[$i]->days_to_expiry."</td>
                    <td>".$data[$i]->store_name."</td>
                    <td>".$data[$i]->distributor_name."</td>
                    <td>".$data[$i]->po_number."</td>
                    <td>".$data[$i]->location."</td>
                    ";

                    $Tracking_ID = $data[$i]->tracking_id;
                    $dispatch_date = $data[$i]->dispatch_date;

                    $row2 = $row;
                    $row = $row+1;
                    
                }

           if(strtoupper(trim($data[$i]->item_type))=='BOX' && $data[$i]->item_id=='4'){
               $VP = $data[$i]->tot_qty;
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
            } else if($data[$i]->item_id=='4'){
                $BC = $data[$i]->tot_qty;
                $Total = $Total+$BC;
                /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row2, $data[$i]->tot_qty);*/
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
            else if($data[$i]->item_id=='18'){
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
            }

            /*if($distributor_id!=$prv_distributor_id || $po_id!=$prv_po_id2){
                if($po_id!=$prv_po_id2){
                    $prv_po_id2 = $po_id;
                    $row =$row+1;
                }
            }*/

            if($count_data==$i)
            {
               $table .=  "<td>".$BS."</td>
                            <td>".$O."</td>
                            <td>".$CP."</td>
                            <td>".$MG."</td>
                            <td>".$BC."</td>
                            <td>".$CHY."</td>
                            <td>".$BB."</td>
                            <td>".$VP."</td>
                            <td>".$DP."</td>
                            <td>".$TN_pp."</td>
                            <td>".$TN_fr."</td>
                            <td>".$TN_co."</td>
                            <td>".$cookies_CR."</td>
                            <td>".$cookies_CH."</td>
                            <td>".$cookies_DR_CH."</td>
                            <td>".$Total."</td>
                            <td>".$Appointment_Date."</td>
                            <td>".$Tracking_ID."</td>
                            <td>".$Date_of_Dispatc."</td>
                            </tr>
                        "; 
            }
        }
        
        $table .=  "</table>";
    }

    echo $tbody = "<html><head>
                    <style>
                    #customers {
                        font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }

                    #customers td, #customers th {
                        border: 1px solid #ddd;
                        padding: 8px;
                    }

                    #customers tr:hover {background-color: #ddd;}

                    #customers th {
                        padding-top: 12px;
                        padding-bottom: 12px;
                        text-align: left;
                        background-color: #002060;
                        color: white;
                    }
                    </style>
                </head>
                <body>Hii ,<br /><br />
                Please find the PO tracker report attached for ".date('dS F Y')."
                <br>
                ".$table."
                <br /><br />Thanks,<br />Team EAT Anytime
                </body></html>";
    /*return $table;*/
}


}
?>