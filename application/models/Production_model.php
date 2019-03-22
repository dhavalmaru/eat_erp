<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Production_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
        $this->load->model('notification_model');
    }

    function get_access(){
        $role_id=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Batch_Processing' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
        return $query->result();
    }

    function get_data($status='', $id=''){
        if($status!=""){
            if ($status=="requested"){
                $cond=" where A.status='Approved' and A.p_status='Requested' ";
            } else if ($status=="confirmed"){
                $cond=" where A.status='Approved' and A.p_status='Confirmed' ";
            } else if ($status=="batch_confirmed"){
                $cond=" where A.status='Approved' and A.p_status='Batch Confirmed' ";
            } else if ($status=="raw_material_confirmed"){
                $cond=" where A.status='Approved' and A.p_status='Raw Material Confirmed' ";
            } else if ($status=="inactive"){
                $cond=" where A.status='InActive'";
            } else {
                $cond=" where A.status='".$status."' ";
            }
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

        $sql = "select A.*, B.depot_name as manufacturer_name, concat(C.first_name, ' ', C.last_name) as modifiedby, 
                    concat(D.first_name, ' ', D.last_name) as approvedby 
                from production_details A 
                left join depot_master B on (A.manufacturer_id=B.id) 
                left join user_master C on (A.modified_by=C.id) 
                left join user_master D on (A.approved_by=D.id) 
                ".$cond." order by A.modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_post_production_data(){
        $sql = "select A.*, B.depot_name as manufacturer_name from production_details A left join depot_master B 
                on (A.manufacturer_id=B.id) where A.status='Approved' and A.p_status = 'Raw Material Confirmed' 
                order by A.modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_production_batch_nos($id){
        $sql = "select * from batch_master where production_id = '$id' order by updated_date desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_production_batch_processing($id){
        $sql = "select C.*, D.depot_name, E.batch_no from 
            (select A.*, B.product_name, B.short_name from 
            (select A.*, concat(B.first_name, ' ', B.last_name) as createdby, 
                concat(C.first_name, ' ', C.last_name) as modifiedby, 
                concat(D.first_name, ' ', D.last_name) as approvedby 
            from batch_processing A 
            left join user_master B on(A.created_by=B.id) 
            left join user_master C on(A.modified_by=C.id) 
            left join user_master D on(A.approved_by=D.id) where A.production_id = '$id') A 
            left join 
            (select * from product_master) B 
            on (A.product_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id)
            left join 
            (select * from batch_master) E 
            on (C.batch_no_id=E.id) order by C.modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_production_bar_to_box($id){
        $sql = "select A.*, B.depot_name from 
            (select * from bar_to_box where production_id = '$id') A 
            left join 
            (select * from depot_master) B 
            on (A.depot_id=B.id) order by A.modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_production_depot_transfer($id){
        $sql = "select C.*, D.depot_name as depot_in_name from 
            (select A.*, B.depot_name as depot_out_name from 
            (select * from depot_transfer where production_id = '$id') A 
            left join 
            (select * from depot_master) B 
            on (A.depot_out_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_in_id=D.id) order by C.modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_production_documents($id, $type){
        $sql = "select * from production_doc_details where production_id = '$id' and doc_type = '$type'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_production_raw_material_recon($id){
        $sql = "select A.*, E.depot_name, 
                    concat(B.first_name, ' ', B.last_name) as createdby, 
                    concat(C.first_name, ' ', C.last_name) as modifiedby, 
                    concat(D.first_name, ' ', D.last_name) as approvedby 
                from raw_material_recon A 
                left join user_master B on(A.created_by=B.id) 
                left join user_master C on(A.modified_by=C.id) 
                left join user_master D on(A.approved_by=D.id) 
                left join depot_master E on(A.depot_id=E.id)
                where A.production_id = '$id'
                order by A.modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_production_id(){
        $sql="select * from series_master where type='Production'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $series=intval($result[0]->series)+1;
        } else {
            $series=1;
        }
        
        $p_id = 'P'.str_pad($series, 5, '0', STR_PAD_LEFT);

        return $p_id;
    }

    function set_production_id(){
        $sql="select * from series_master where type='Production'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $series=intval($result[0]->series)+1;
            $sql="update series_master set series = '$series' where type = 'Production'";
            $this->db->query($sql);
        } else {
            $series=1;
            $sql="insert into series_master (type, series) values ('Production', '$series')";
            $this->db->query($sql);
        }

        $p_id = 'P'.str_pad($series, 5, '0', STR_PAD_LEFT);

        return $p_id;
    }

    function get_manufacturer($id=''){
        $cond = "";
        if($id!=''){
            $cond = " and id = '$id'";
        }

        $sql="select * from depot_master where status='Approved' and type='Manufacturer'" . $cond;
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_manufacturer_contacts($id=''){
        $sql="select * from depot_contacts where depot_id='$id'";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_manufacturer_emails($id=''){
        $email_to = '';

        $sql = "select * from production_details where id = '$id'";
        $query = $this->db->query($sql);
        $data = $query->result();
        if(count($data)>0) {
            $manufacturer_id = $data[0]->manufacturer_id;

            $depot_details = $this->get_manufacturer($manufacturer_id);
            $depot_contacts = $this->get_manufacturer_contacts($manufacturer_id);

            if(isset($depot_details)){
                if(count($depot_details)>0){
                    if($depot_details[0]->email_id!=''){
                        $email_to = $email_to . $depot_details[0]->email_id . ', ';
                    }
                }
            }

            // echo $manufacturer_id;
            // echo '<br/>';
            // echo count($depot_contacts);
            // echo '<br/>';

            if(isset($depot_contacts)){
                if(count($depot_contacts)>0){
                    for($i=0; $i<count($depot_contacts); $i++){
                        if($depot_contacts[$i]->email_id!=''){
                            $email_to = $email_to . $depot_contacts[$i]->email_id . ', ';
                        }
                    }
                }
            }

            if($email_to!=''){
                $email_to = substr($email_to, 0, strrpos($email_to, ','));
            }
        }

        return $email_to;
    }

    function get_preliminary_details($production_id=''){
        $sql="select * from production_preliminary_details where production_id='$production_id'";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_batch_items($id){
        $sql = "select A.*, B.product_name, B.short_name from production_batch_details A left join product_master B 
                on (A.bar_id = B.id) where production_id = '$id'";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_batch_raw_materials($id){
        $sql = "select * from production_raw_material_details where production_id = '$id'";
        $query=$this->db->query($sql);
        $result=$query->result();
        
        if(count($result)==0){
            $sql = "select AA.rm_id, sum(required_qty) as required_qty, sum(available_qty) as available_qty, sum(difference_qty) as difference_qty from 
                    (select A.id, A.manufacturer_id, A.bar_id, A.rm_id, round(A.tot_qty,3) as required_qty, round(B.tot_qty,3) as available_qty, 
                        round(ifnull(B.tot_qty,0)-ifnull(A.tot_qty,0),3) as difference_qty from 
                    (select A.id, A.manufacturer_id, B.bar_id, D.rm_id, ifnull(B.qty,0)*ifnull(D.qty_per_batch,0) as tot_qty 
                    from production_details A 
                    left join production_batch_details B on (A.id=B.production_id) 
                    left join ingredients_master C on (B.bar_id=C.product_id) 
                    left join ingredients_details D on (C.id=D.ing_id) 
                    where A.id='$id' and B.production_id='$id') A 
                    left join 
                    (select H.*, I.rm_name from 
                    (select F.*, G.depot_name from 
                    (select E.depot_id, E.raw_material_id, sum(tot_qty) as tot_qty from 
                    (select C.depot_id, C.raw_material_id, ifnull(C.qty_in,0)-ifnull(D.qty_out,0) as tot_qty from 
                    (select AA.depot_id, AA.raw_material_id, sum(AA.qty) as qty_in from 
                    (select B.id as depot_id, A.id as raw_material_id, 0 as qty 
                        from raw_material_master A left join depot_master B on(1=1) 
                    union all 
                    select A.depot_id, B.raw_material_id, B.qty from 
                    (select * from raw_material_in where status = 'Approved' and date_of_receipt > '2018-10-22') A 
                    inner join 
                    (select * from raw_material_stock) B 
                    on (A.id = B.raw_material_in_id) 
                    union all 
                    select A.depot_id, B.raw_material_id, B.qty from 
                    (select * from raw_material_in_out where status = 'Approved' and date_of_processing > '2018-10-22') A 
                    inner join 
                    (select * from raw_material_in_out_items Where type='Stock IN') B 
                    on (A.id = B.raw_material_in_out_id) 
                    union all 
                    select A.depot_in_id as depot_id, B.item_id as raw_material_id, B.qty from 
                    (select * from depot_transfer where status = 'Approved' and date_of_transfer > '2018-10-22') A 
                    inner join 
                    (select * from depot_transfer_items where type = 'Raw Material') B 
                    on (A.id = B.depot_transfer_id)) AA group by AA.depot_id, AA.raw_material_id) C 
                    left join 
                    (select BB.depot_id, BB.raw_material_id, sum(BB.qty) as qty_out from 
                    (select A.depot_id, B.raw_material_id, B.qty from 
                    (select * from batch_processing where status = 'Approved' and date_of_processing > '2018-10-22') A 
                    inner join 
                    (select * from batch_raw_material) B 
                    on (A.id = B.batch_processing_id) 
                    union all 
                    select A.depot_id, B.raw_material_id, B.qty from 
                    (select * from raw_material_in_out where status = 'Approved' and date_of_processing > '2018-10-22') A 
                    inner join 
                    (select * from raw_material_in_out_items Where type='Stock Out') B 
                    on (A.id = B.raw_material_in_out_id) 
                    union all 
                    select A.depot_out_id as depot_id, B.item_id as raw_material_id, B.qty from 
                    (select * from depot_transfer where status = 'Approved' and date_of_transfer > '2018-10-22') A 
                    inner join 
                    (select * from depot_transfer_items where type = 'Raw Material') B 
                    on (A.id = B.depot_transfer_id)) BB group by BB.depot_id, BB.raw_material_id) D 
                    on (C.depot_id=D.depot_id and C.raw_material_id=D.raw_material_id)) E 
                    group by E.depot_id, E.raw_material_id) F 
                    left join 
                    (select * from depot_master) G 
                    on (F.depot_id=G.id)) H 
                    left join 
                    (select * from raw_material_master) I 
                    on (H.raw_material_id=I.id) 
                    where H.tot_qty<>0) B 
                    on (A.manufacturer_id=B.depot_id and A.rm_id=B.raw_material_id)) AA 
                    group by AA.rm_id";
            $query=$this->db->query($sql);
            $result=$query->result();
        }

        return $result;
    }

    function get_product_details($product_id=''){
        $sql = "select * from ingredients_master where product_id = '$product_id'";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function save_data($id=''){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $from_date=$this->input->post('from_date');
        if($from_date==''){
            $from_date=NULL;
        } else {
            $from_date=formatdate($from_date);
        }
        $to_date=$this->input->post('to_date');
        if($to_date==''){
            $to_date=NULL;
        } else {
            $to_date=formatdate($to_date);
        }

        if($id==''){
            $p_id = $this->set_production_id();
        } else {
            $p_id = $this->input->post('p_id');
        }
        
        $data = array(
            'p_status' => $this->input->post('p_status'),
            'p_id' => $p_id,
            'from_date' =>  $from_date,
            'to_date' => $to_date,
            'manufacturer_id' =>  $this->input->post('manufacturer_id'),
            'status' => $this->input->post('status'),
            'request_remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now
        );

        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            $this->db->insert('production_details',$data);
            $id=$this->db->insert_id();
            $action='Production Created.';
        } else {
            $this->db->where('id', $id);
            $this->db->update('production_details',$data);
            $action='Production Modified.';
        }

        $this->notification_model->delete_notification('2', $id);

        $sql = "select * from notification_master where id = '2'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $notification=$result[0]->notification;
            $notification_type=$result[0]->notification_type;

            $this->notification_model->add_notification('2', $notification, $now, $notification_type, 'All', '', $id);
        }

        $this->send_email($id, 'request_date');

        $logarray['table_id']=$id;
        $logarray['module_name']='Production';
        $logarray['cnt_name']='Production';
        $logarray['action']=$action;
        $this->user_access_log_model->insertAccessLog($logarray);
    }

    function confirm($id=''){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $confirm_from_date=$this->input->post('confirm_from_date');
        if($confirm_from_date==''){
            $confirm_from_date=NULL;
        } else {
            $confirm_from_date=formatdate($confirm_from_date);
        }
        $confirm_to_date=$this->input->post('confirm_to_date');
        if($confirm_to_date==''){
            $confirm_to_date=NULL;
        } else {
            $confirm_to_date=formatdate($confirm_to_date);
        }
        
        $data = array(
            'p_status' => $this->input->post('p_status'),
            'confirm_from_date' =>  $confirm_from_date,
            'confirm_to_date' => $confirm_to_date,
            'status' => $this->input->post('status'),
            'confirmation_remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now
        );

        $this->db->where('id', $id);
        $this->db->update('production_details',$data);
        $action='Production Confirmed.';

        $this->notification_model->delete_notification('2', $id);
        $this->notification_model->delete_notification('3', $id);
        $this->notification_model->delete_notification('4', $id);

        $sql = "select * from notification_master where id = '3'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $notification=$result[0]->notification;
            $notification_type=$result[0]->notification_type;
            $duration_in_days=$result[0]->duration_in_days;

            $notification_date=date('Y-m-d', strtotime($confirm_from_date. ' - '.$duration_in_days.' day'));

            $this->notification_model->add_notification('3', $notification, $notification_date, $notification_type, 'All', '', $id);
        }

        $sql = "select * from notification_master where id = '4'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $notification=$result[0]->notification;
            $notification_type=$result[0]->notification_type;
            $duration_in_days=$result[0]->duration_in_days;

            $notification_date=date('Y-m-d', strtotime($confirm_from_date. ' - '.$duration_in_days.' day'));

            $this->notification_model->add_notification('4', $notification, $notification_date, $notification_type, 'All', '', $id);
        }

        $this->send_email($id, 'confirm_date');

        $logarray['table_id']=$id;
        $logarray['module_name']='Production';
        $logarray['cnt_name']='Production';
        $logarray['action']=$action;
        $this->user_access_log_model->insertAccessLog($logarray);
    }

    function confirm_batch($id=''){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $data = array(
            'p_status' => $this->input->post('p_status'),
            'batch_rivision' => $this->input->post('batch_rivision'),
            'status' => $this->input->post('status'),
            'confirm_batch_remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'batch_confirm_date' => $now
        );

        $this->db->where('id', $id);
        $this->db->update('production_details',$data);
        $action='Production Batch Confirmed.';

        $this->db->where('production_id', $id);
        $this->db->delete('production_batch_details');

        $bar=$this->input->post('bar[]');
        $qty=$this->input->post('qty[]');
        $bar_qty=$this->input->post('bar_qty[]');
        
        for ($k=0; $k<count($bar); $k++) {
            if(isset($bar[$k]) and $bar[$k]!="") {
                $data = array(
                            'production_id' => $id,
                            'bar_id' => $bar[$k],
                            'qty' => format_number($qty[$k],2),
                            'bar_qty' => format_number($bar_qty[$k],2)
                        );
                $this->db->insert('production_batch_details', $data);
            }
        }

        $this->notification_model->delete_notification('4', $id);
        $this->notification_model->delete_notification('5', $id);

        $sql = "select * from notification_master where id = '5'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $notification=$result[0]->notification;
            $notification_type=$result[0]->notification_type;
            $duration_in_days=$result[0]->duration_in_days;

            $notification_date=date('Y-m-d', strtotime($confirm_from_date. ' - '.$duration_in_days.' day'));

            $this->notification_model->add_notification('5', $notification, $notification_date, $notification_type, 'All', '', $id);
        }

        $this->send_email($id, 'confirm_batch');

        $logarray['table_id']=$id;
        $logarray['module_name']='Production';
        $logarray['cnt_name']='Production';
        $logarray['action']=$action;
        $this->user_access_log_model->insertAccessLog($logarray);
    }

    function confirm_raw_material($id=''){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $confirm_from_date=$this->input->post('confirm_from_date');
        if($confirm_from_date==''){
            $confirm_from_date=NULL;
        } else {
            $confirm_from_date=formatdate($confirm_from_date);
        }

        $data = array(
            'p_status' => $this->input->post('p_status'),
            'status' => $this->input->post('status'),
            'confirm_raw_material_remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now
        );

        $this->db->where('id', $id);
        $this->db->update('production_details',$data);
        $action='Production Confirmed.';

        $this->db->where('production_id', $id);
        $this->db->delete('production_raw_material_details');

        $raw_material=$this->input->post('raw_material[]');
        $required_qty=$this->input->post('required_qty[]');
        $available_qty=$this->input->post('available_qty[]');
        $difference_qty=$this->input->post('difference_qty[]');
        
        for ($k=0; $k<count($raw_material); $k++) {
            if(isset($raw_material[$k]) and $raw_material[$k]!="") {
                $data = array(
                            'production_id' => $id,
                            'rm_id' => $raw_material[$k],
                            'required_qty' => format_number($required_qty[$k],2),
                            'available_qty' => format_number($available_qty[$k],2),
                            'difference_qty' => format_number($difference_qty[$k],2)
                        );
                $this->db->insert('production_raw_material_details', $data);
            }
        }

        $this->notification_model->delete_notification('4', $id);
        $this->notification_model->delete_notification('5', $id);

        $sql = "select * from notification_master where id = '6'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                $notification_id=$result[$i]->id;
                $notification=$result[$i]->notification;
                $duration_in_days=$result[$i]->duration_in_days;
                $notification_type=$result[$i]->notification_type;

                $notification_date=date('Y-m-d', strtotime($confirm_from_date. ' + '.$duration_in_days.' day'));

                // $date = new DateTime($confirm_from_date);
                // $date->modify('+'.$duration_in_days.' day');
                // $notification_date = $date->format('Y-m-d');

                $this->notification_model->delete_notification($notification_id, $id);
                $this->notification_model->add_notification($notification_id, $notification, $notification_date, $notification_type, 'All', '', $id);
            }
            
        }

        $this->send_email($id, 'confirm_raw_material');

        $logarray['table_id']=$id;
        $logarray['module_name']='Production';
        $logarray['cnt_name']='Production';
        $logarray['action']=$action;
        $this->user_access_log_model->insertAccessLog($logarray);
    }

    function get_batch_details($id=''){
        $sql = "select * from batch_master where production_id = '$id'";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function preliminary_check($id=''){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $production_id = $this->input->post('production_id');

        $data = array(
            'production_id' => $production_id,
            'email_to' => $this->input->post('email_to'),
            'email_cc' =>  $this->input->post('email_cc'),
            'email_bcc' =>  $this->input->post('email_bcc'),
            'email_subject' =>  $this->input->post('email_subject'),
            'email_body' =>  $this->input->post('email_body'),
            'status' => $this->input->post('status'),
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now
        );

        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            $this->db->insert('production_preliminary_details',$data);
            $id=$this->db->insert_id();
            $action='Production Preliminary Details Created.';
        } else {
            $this->db->where('id', $id);
            $this->db->update('production_preliminary_details',$data);
            $action='Production Preliminary Details Modified.';
        }

        $mail_sent = $this->send_preliminary_email($id);
        // echo $mail_sent;
        // echo '<br/>';
        if($mail_sent==1){
            $data = array(
                'mail_sent' => $mail_sent
            );

            $this->db->where('id', $id);
            $this->db->update('production_preliminary_details',$data);

            $this->notification_model->delete_notification('3', $production_id);
            // echo 'Delete Notification.';
            // echo '<br/>';
            // echo $id;
            // echo '<br/>';
        }

        $logarray['table_id']=$id;
        $logarray['module_name']='Production';
        $logarray['cnt_name']='Production';
        $logarray['action']=$action;
        $this->user_access_log_model->insertAccessLog($logarray);
    }

    function send_preliminary_email($id){
        $login_name = $this->session->userdata('login_name');
        $mailSent=0;
        $sql = "select * from production_preliminary_details where id = '$id'";
        $query=$this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $from_email = 'cs@eatanytime.co.in';
            $from_email_sender = 'Wholesome Habits Pvt Ltd';
            $to_email = $result[0]->email_to;
            $cc = $result[0]->email_cc;
            $bcc = $result[0]->email_bcc;
            $subject = $result[0]->email_subject;
            $message = $result[0]->email_body;
            $remarks = $result[0]->remarks;
            $message = '<html>
                        <head>
                        <style type="text/css">
                            pre {
                                font: small/1.5 Arial,Helvetica,sans-serif;
                            }
                        </style>
                        </head>
                        <body><pre>'.$message.'</pre><br/>
                        Remarks - '.$remarks.'<br/><br/>
                        Team EAT Anytime<br/><br/>'.ucwords(trim($login_name)).'
                        </body>
                        </html>';

            $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc);
        }

        return $mailSent;
    }

    function send_email($id='', $email_type=''){
        $mailSent=0;
        $curusr_email=$this->session->userdata('user_name');

        // $sql = "select * from production_details where id = '$id'";
        // $query=$this->db->query($sql);
        // $result = $query->result();

        $result = $this->get_data('', $id);
        if(count($result)>0){
            $from_email = 'cs@eatanytime.co.in';
            $from_email_sender = 'Wholesome Habits Pvt Ltd';
            $p_id = $result[0]->p_id;
            $manufacturer_name = $result[0]->manufacturer_name;
            
            $to_email = $this->get_manufacturer_emails($id);
            $cc = 'vaibhav.desai@eatanytime.in, rahul.rathod@eatanytime.co.in, rishit.sanghvi@eatanytime.in, dinesh.parkhi@eatanytime.in';
            // $bcc = $curusr_email . ', prasad.bhisale@pecanreams.com';
            $bcc = 'prasad.bhisale@pecanreams.com';

            // $to_email = 'prasad.bhisale@pecanreams.com';
            // $cc = 'prasad.bhisale@pecanreams.com';
            // $bcc = 'rishit.sanghvi@eatanytime.in';
            // $bcc = 'prasad.bhisale@pecanreams.com';

            if($email_type=='request_date'){
                $login_name = $this->session->userdata('login_name');
                $from_date = date('d/m/Y', strtotime($result[0]->from_date));
                $to_date = date('d/m/Y', strtotime($result[0]->to_date));
                $remarks = $result[0]->request_remarks;
                $datetime1 = new DateTime($result[0]->from_date);
                $datetime2 = new DateTime($result[0]->to_date);
                $difference = $datetime1->diff($datetime2);
                $days = $difference->d;
                if(isset($days)){
                    if($days!=''){
                        if(is_numeric($days)){
                            $days = intval($days) + 1;
                        }
                    }
                }
                if($days=='' || $days=='0'){
                    $days = 1;
                }

                $subject = 'Request for Confirmation of Production - '.$from_date.' to '.$to_date.' - '.$p_id;
                $message = '<html><body>
                            Hi '.ucwords(trim($manufacturer_name)).', <br/><br/> 
                            Request you to confirm the production availability for the below mentioned dates.<br/><br/>
                            Dates - '.$from_date.' to '.$to_date.'<br/>
                            Total No of Days - '.$days.'<br/>
                            Remarks - '.$remarks.'<br/><br/>
                            Please confirm the same asap so that we can start the Raw Material Procurement asap. 
                            Also please send us the closing stock of Raw Material immediately.<br/><br/>
                            Team EAT Anytime<br/><br/>'.ucwords(trim($login_name)).'
                            </body></html>';
            } else if($email_type=='confirm_date'){
                $login_name = $this->session->userdata('login_name');
                $confirm_from_date = date('d/m/Y', strtotime($result[0]->confirm_from_date));
                $confirm_to_date = date('d/m/Y', strtotime($result[0]->confirm_to_date));
                $remarks = $result[0]->confirmation_remarks;
                $datetime1 = new DateTime($result[0]->confirm_from_date);
                $datetime2 = new DateTime($result[0]->confirm_to_date);
                $difference = $datetime1->diff($datetime2);
                $days = $difference->d;
                if(isset($days)){
                    if($days!=''){
                        if(is_numeric($days)){
                            $days = intval($days) + 1;
                        }
                    }
                }
                if($days=='' || $days=='0'){
                    $days = 1;
                }

                $subject = 'Confirmation of Production - '.$confirm_from_date.' to '.$confirm_to_date.' - '.$p_id;
                $message = '<html><body>
                            Hi '.ucwords(trim($manufacturer_name)).', <br/><br/> 
                            Thanks for your email. We confirm the production as per the below details.<br/><br/>
                            Dates - '.$confirm_from_date.' to '.$confirm_to_date.'<br/>
                            Total No of Days - '.$days.'<br/>
                            Remarks - '.$remarks.'<br/><br/>
                            We shall send the Batch details asap. 
                            Please send the closing stock of Raw Material (if not provided) immediately. 
                            This shall help us manage the production better.<br/><br/>
                            Team EAT Anytime<br/><br/>'.ucwords(trim($login_name)).'
                            </body></html>';
            } else if($email_type=='confirm_batch'){
                $login_name = $this->session->userdata('login_name');
                $batch_rivision = $result[0]->batch_rivision;
                $confirm_from_date = date('d/m/Y', strtotime($result[0]->confirm_from_date));
                $confirm_to_date = date('d/m/Y', strtotime($result[0]->confirm_to_date));
                $remarks = $result[0]->confirm_batch_remarks;
                $datetime1 = new DateTime($result[0]->confirm_from_date);
                $datetime2 = new DateTime($result[0]->confirm_to_date);
                $difference = $datetime1->diff($datetime2);
                $days = $difference->d;
                if(isset($days)){
                    if($days!=''){
                        if(is_numeric($days)){
                            $days = intval($days) + 1;
                        }
                    }
                }
                if($days=='' || $days=='0'){
                    $days = 1;
                }

                $batch_items = $this->get_batch_items($id);
                $batch_details = '';
                if(isset($batch_items)){
                    if(count($batch_items)>0){
                        $batch_details = $batch_details . 
                                        '<table border="1" style="border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th>SKU Name</th>
                                                <th>No Of Bathches</th>
                                                <th>No Of Bars</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                        for($i=0; $i<count($batch_items); $i++){
                            $batch_details = $batch_details . 
                                            '<tr>
                                                <td>'.$batch_items[$i]->short_name.'</td>
                                                <td style="text-align: center;">'.$batch_items[$i]->qty.'</td>
                                                <td style="text-align: center;">'.$batch_items[$i]->bar_qty.'</td>
                                            </tr>';
                        }

                        $batch_details = $batch_details . 
                                        '</tbody>
                                        </table>';
                    }
                }

                if($batch_rivision!='0'){
                    $subject = 'REVISION '.$batch_rivision.' - Batch and SKU Confirmation - '.$confirm_from_date.' to '.$confirm_to_date.' - '.$p_id;
                } else {
                    $subject = 'Batch and SKU Confirmation - '.$confirm_from_date.' to '.$confirm_to_date.' - '.$p_id;
                }
                
                $message = '<html>
                            <head><style>th, td { padding: 10px; } </style></head>
                            <body>
                            Hi '.ucwords(trim($manufacturer_name)).', <br/><br/> 
                            Please find attached/Appended Details of Batch and SKU for the below production:<br/><br/>
                            Dates - '.$confirm_from_date.' to '.$confirm_to_date.'<br/>
                            Total No of Days - '.$days.'<br/><br/>'.$batch_details.'<br/>
                            Remarks - '.$remarks.'<br/><br/>
                            Team EAT Anytime<br/><br/>'.ucwords(trim($login_name)).'
                            </body></html>';

            } else if($email_type=='confirm_raw_material'){
                $login_name = $this->session->userdata('login_name');
                $confirm_from_date = date('d/m/Y', strtotime($result[0]->confirm_from_date));
                $confirm_to_date = date('d/m/Y', strtotime($result[0]->confirm_to_date));
                $remarks = $result[0]->confirm_raw_material_remarks;
                $datetime1 = new DateTime($result[0]->confirm_from_date);
                $datetime2 = new DateTime($result[0]->confirm_to_date);
                $difference = $datetime1->diff($datetime2);
                $days = $difference->d;
                if(isset($days)){
                    if($days!=''){
                        if(is_numeric($days)){
                            $days = intval($days) + 1;
                        }
                    }
                }
                if($days=='' || $days=='0'){
                    $days = 1;
                }

                $subject = 'Raw Material Confirmation - '.$confirm_from_date.' to '.$confirm_to_date.' - '.$p_id;
                $message = '<html>
                            <body>
                            Hi All<br/><br/>
                            I '.ucwords(trim($login_name)).', 
                            Confirm that all required Raw Material for the below mentioned Production are received at the Factory.<br/><br/>
                            Dates - '.$confirm_from_date.' to '.$confirm_to_date.'<br/>
                            Total No of Days - '.$days.'<br/><br/>
                            Remarks - '.$remarks.'<br/><br/>
                            Team EAT Anytime<br/><br/>'.ucwords(trim($login_name)).'
                            </body></html>';
            } 

            $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc);
        }

        return $mailSent;
    }

    function upload_documents($id){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        if($id!="") {
           $this->db->where('production_id', $id);
           $this->db->delete('production_doc_details');
        }

        $this->upload_doc_by_type($id, 'raw_material_check');
        $this->upload_doc_by_type($id, 'sorting');
        $this->upload_doc_by_type($id, 'processing');
        $this->upload_doc_by_type($id, 'quality_control');
        $this->upload_doc_by_type($id, 'packaging');
        $this->upload_doc_by_type($id, 'qc_report');
        $this->upload_doc_by_type($id, 'erp_updating');
        $this->upload_doc_by_type($id, 'physical_rm');
        $this->upload_doc_by_type($id, 'recon_of_rm');

        $sql = "update production_details set documents_upload = '1' where id = '$id'";
        $this->db->query($sql);
    }

    function upload_doc_by_type($id, $type){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $doc_type=$this->input->post($type.'_doc_type[]');
        $doc_title=$this->input->post($type.'_doc_title[]');
        $doc_name=$this->input->post($type.'_doc_name[]');
        $doc_path=$this->input->post($type.'_doc_path[]');
        $remarks=$this->input->post($type.'_remarks');
        $remarks2='';

        if($type=='quality_control' || $type=='packaging'){
            $remarks2=$this->input->post($type.'_remarks2');
        }
        
        for ($k=0; $k<count($doc_type); $k++) {
            if(isset($doc_type[$k]) and $doc_type[$k]!="") {
                $doc_img=$type.'_doc_img_'.$k;

                if(!empty($_FILES[$doc_img]['name'])) {
                    $filePath='uploads/production_doc/';
                    $upload_path = './' . $filePath;
                    if(!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }
                    $filePath='uploads/production_doc/'.$id.'/';
                    $upload_path = './' . $filePath;
                    if(!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }

                    $fileName = $_FILES[$doc_img]['name'];
                    // $extension = '';
                    // if(strrpos(".", $fileName)>0){
                    //     $extension = substr($fileName, strrpos(".", $fileName)+1);
                    // }
                    // $fileName = 'doc_'.($k+1).$extension;

                    $confi['upload_path']=$upload_path;
                    $confi['allowed_types']='*';
                    $confi['file_name']=$fileName;
                    $confi['overwrite'] = TRUE;
                    $this->load->library('upload', $confi);
                    $this->upload->initialize($confi);
                    $extension="";

                    if($this->upload->do_upload($doc_img)) {
                        echo "Uploaded <br>";
                    } else {
                        echo "Failed<br>";
                        echo $this->upload->data();
                    }   

                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    $extension=$upload_data['file_ext'];

                    $data = array(
                                'production_id'=> $id,
                                'doc_type' => $doc_type[$k],
                                'doc_title' => $doc_title[$k],
                                'doc_path' => $filePath.$fileName,
                                'doc_name' => $fileName,
                                'status' => 'Approved',
                                'remarks' => $remarks,
                                'created_by' => $curusr,
                                'created_on' => $now,
                                'modified_by' => $curusr,
                                'modified_on' => $now,
                                'remarks2' => $remarks2
                            );

                    $this->db->insert('production_doc_details', $data);
                } else {
                    $data = array(
                                'production_id'=> $id,
                                'doc_type' => $doc_type[$k],
                                'doc_title' => $doc_title[$k],
                                'doc_path' => $doc_path[$k],
                                'doc_name' => $doc_name[$k],
                                'status' => 'Approved',
                                'remarks' => $remarks,
                                'created_by' => $curusr,
                                'created_on' => $now,
                                'modified_by' => $curusr,
                                'modified_on' => $now,
                                'remarks2' => $remarks2
                            );

                    $this->db->insert('production_doc_details', $data);
                }
            }
        }
    }

    function get_purchased_raw_material($id){
        $to_date = date('Y-m-d');
        $depot_id = '';
        $sql = "select * from production_details where id = '$id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            $to_date = $result[0]->confirm_to_date;
            $depot_id = $result[0]->manufacturer_id;
        }

        $from_date = '2019-01-01';
        $sql = "select * from production_details where manufacturer_id = '$depot_id' and id < '$id' order by id desc";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            $from_date = $result[0]->confirm_to_date;
        }

        $preliminary_check_date = $to_date;
        $sql = "select * from production_preliminary_details where production_id = '$id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            $preliminary_check_date = date('Y-m-d', strtotime($result[0]->created_on));
        }
        // echo $preliminary_check_date;
        // echo '<br/>';

        $sql = "select A.date_of_receipt, B.raw_material_id, B.qty, C.rm_name, 
                    case when A.date_of_receipt<='$preliminary_check_date' then 'In Time' else 'Late' end as rm_status 
                from raw_material_in A 
                left join raw_material_stock B on (A.id = B.raw_material_in_id) 
                left join raw_material_master C on (B.raw_material_id = C.id) 
                where A.status = 'Approved' and A.depot_id = '$depot_id' and B.qty<>0 and 
                    A.date_of_receipt>'$from_date' and A.date_of_receipt<='$to_date' 
                order by A.date_of_receipt, C.rm_name";
        $result = $this->db->query($sql)->result();
        // echo $sql;
        // echo '<br/>';
        return $result;
    }

    function generate_production_report($id='', $approve='') {
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $data['id']=$id;
        $data['data']=$this->get_data('', $id);
        $data['batch_master'] = $this->get_production_batch_nos($id);
        $data['purchased_rm'] = $this->get_purchased_raw_material($id, 'recon_of_rm');
        $batch_processing = $this->get_production_batch_processing($id);
        $data['batch_processing'] = $batch_processing;
        $data['bar_to_box'] = $this->get_production_bar_to_box($id);
        $data['depot_transfer'] = $this->get_production_depot_transfer($id);
        $data['raw_material_check_doc'] = $this->get_production_documents($id, 'raw_material_check');
        $data['sorting_doc'] = $this->get_production_documents($id, 'sorting');
        $data['processing_doc'] = $this->get_production_documents($id, 'processing');
        $data['quality_control_doc'] = $this->get_production_documents($id, 'quality_control');
        $data['packaging_doc'] = $this->get_production_documents($id, 'packaging');
        $data['qc_report_doc'] = $this->get_production_documents($id, 'qc_report');
        $data['erp_updating_doc'] = $this->get_production_documents($id, 'erp_updating');
        $data['physical_rm_doc'] = $this->get_production_documents($id, 'physical_rm');
        $data['recon_of_rm_doc'] = $this->get_production_documents($id, 'recon_of_rm');
        $data['approve'] = $approve;
        $data['access'] = $this->get_access();
        
        $batch_processing_qty = array();
        for($i=0; $i<count($batch_processing); $i++){
            $pack_of_20 = 0;
            $variety_pack = 0;
            $pack_of_6 = 0;
            $single_bars = 0;
            $serjana_bars = 0;
            $total_bars = 0;
            $gate_pass_in = 0;
            $difference_bars = 0;
            $transfer_to_warehouse = 0;
            $transfer_to_ho = 0;

            $product_id = $batch_processing[$i]->product_id;
            $total_bars = $batch_processing[$i]->qty_in_bar;
            $short_name = $batch_processing[$i]->short_name;
            $batch_no = $batch_processing[$i]->batch_no;

            $pack_of_20_id = '';
            $sql = "select A.*, B.qty from box_master A left join box_product B on (A.id = B.box_id) 
                    where A.status='Approved' and B.qty = '20' and B.product_id='$product_id' order by A.id";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $pack_of_20_id = $result[0]->id;
            }
            if($pack_of_20_id!=''){
                $sql = "select sum(B.qty) as pack_of_20 from depot_transfer A 
                        left join depot_transfer_items B on (A.id = B.depot_transfer_id) 
                        where A.status='Approved' and A.production_id='$id' and 
                            B.type = 'Box' and B.item_id = '$pack_of_20_id'";
                $result = $this->db->query($sql)->result();
                if(count($result)>0){
                    $pack_of_20 = $result[0]->pack_of_20;
                }
            }

            $variety_pack_id = '';
            $sql = "select A.*, B.qty from box_master A left join box_product B on (A.id = B.box_id) 
                    where A.status='Approved' and A.id='32' and B.product_id='$product_id' order by A.id";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $variety_pack_id = $result[0]->id;
            }
            if($variety_pack_id!=''){
                $sql = "select sum(B.qty) as variety_pack from depot_transfer A 
                        left join depot_transfer_items B on (A.id = B.depot_transfer_id) 
                        where A.status='Approved' and A.production_id='$id' and 
                            B.type = 'Box' and B.item_id = '$variety_pack_id'";
                $result = $this->db->query($sql)->result();
                if(count($result)>0){
                    $variety_pack = $result[0]->variety_pack;
                }
            }

            $pack_of_6_id = '';
            $sql = "select A.*, B.qty from box_master A left join box_product B on (A.id = B.box_id) 
                    where A.status='Approved' and B.product_id='$product_id' and B.qty = '6' order by A.id";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $pack_of_6_id = $result[0]->id;
            }
            if($pack_of_6_id!=''){
                $sql = "select sum(B.qty) as pack_of_6 from depot_transfer A 
                        left join depot_transfer_items B on (A.id = B.depot_transfer_id) 
                        where A.status='Approved' and A.production_id='$id' and 
                            B.type = 'Box' and B.item_id = '$pack_of_6_id'";
                $result = $this->db->query($sql)->result();
                if(count($result)>0){
                    $pack_of_6 = $result[0]->pack_of_6;
                }
            }

            $sql = "select sum(B.qty) as single_bars from depot_transfer A 
                    left join depot_transfer_items B on (A.id = B.depot_transfer_id) 
                    where A.status='Approved' and A.production_id='$id' and B.type = 'Bar' and B.item_id = '$product_id'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $single_bars = $result[0]->single_bars;
            }

            $sql = "select sum(AA.qty) as transfer_to_warehouse from 
                    (select case when B.type = 'Bar' then B.item_id else C.product_id end as item_id, 
                        case when B.type = 'Bar' then B.qty else ifnull(B.qty,0)*ifnull(C.qty,0) end as qty
                    from depot_transfer A 
                    left join depot_transfer_items B on (A.id = B.depot_transfer_id) 
                    left join box_product C on (B.type = 'Box' and B.item_id = C.box_id) 
                    where A.status='Approved' and A.production_id='$id' and A.depot_in_id='5') AA  
                    where AA.item_id = '$product_id'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $transfer_to_warehouse = $result[0]->transfer_to_warehouse;
            }

            $sql = "select sum(AA.qty) as transfer_to_ho from 
                    (select case when B.type = 'Bar' then B.item_id else C.product_id end as item_id, 
                        case when B.type = 'Bar' then B.qty else ifnull(B.qty,0)*ifnull(C.qty,0) end as qty
                    from depot_transfer A 
                    left join depot_transfer_items B on (A.id = B.depot_transfer_id) 
                    left join box_product C on (B.type = 'Box' and B.item_id = C.box_id) 
                    where A.status='Approved' and A.production_id='$id' and A.depot_in_id='2') AA  
                    where AA.item_id = '$product_id'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $transfer_to_ho = $result[0]->transfer_to_ho;
            }

            // $serjana_bars = $total_bars-($pack_of_20*20)-($variety_pack*1)-($pack_of_6*6)-$single_bars;
            // $gate_pass_in = $total_bars-$serjana_bars;

            $serjana_bars = $total_bars-$transfer_to_warehouse-$transfer_to_ho;
            $gate_pass_in = $transfer_to_warehouse+$transfer_to_ho;

            $difference_bars = $gate_pass_in-$total_bars+$serjana_bars;

            $batch_processing_qty[$i]['product_id'] = $product_id;
            $batch_processing_qty[$i]['short_name'] = $short_name;
            $batch_processing_qty[$i]['batch_no'] = $batch_no;
            $batch_processing_qty[$i]['pack_of_20'] = $pack_of_20;
            $batch_processing_qty[$i]['variety_pack'] = $variety_pack;
            $batch_processing_qty[$i]['pack_of_6'] = $pack_of_6;
            $batch_processing_qty[$i]['single_bars'] = $single_bars;
            $batch_processing_qty[$i]['serjana_bars'] = $serjana_bars;
            $batch_processing_qty[$i]['total_bars'] = $total_bars;
            $batch_processing_qty[$i]['gate_pass_in'] = $gate_pass_in;
            $batch_processing_qty[$i]['difference_bars'] = $difference_bars;
            $batch_processing_qty[$i]['transfer_to_warehouse'] = $transfer_to_warehouse;
            $batch_processing_qty[$i]['transfer_to_ho'] = $transfer_to_ho;
        }

        $data['batch_processing_qty'] = $batch_processing_qty;

        // echo json_encode($data['access']);

        $this->load->library('parser');
        $output = $this->parser->parse('production/report.php', $data, true);
        $pdf='';   
        if ($pdf=='print')
            $this->_gen_pdf($output);
        else
            $this->output->set_output($output);
    }

    function update_report($id=''){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $report_remarks=$this->input->post('report_remarks');

        // $ref_no = NULL;

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

            // $ref_id = $this->input->post('ref_id');
            // $remarks = $this->input->post('remarks');

            if($status == 'Rejected'){
                $sql = "Update production_details Set report_status='$status', report_remarks='$report_remarks', 
                        rejected_by='$curusr', rejected_on='$now' where id = '$id'";
                $this->db->query($sql);

                $action='Production Report '.$status.'.';
            } else {
                if($id!='' || $ref_id!=''){
                    // if($ref_id!=null && $ref_id!=''){  

                    //     $sql = "Update raw_material_in_out A, raw_material_in_out B 
                    //             Set A.date_of_processing=B.date_of_processing,
                    //                 A.depot_id=B.depot_id,
                    //                 A.type=B.type,
                    //                 A.ref_no='$ref_no',
                    //                 A.status='$status', A.remarks='$remarks', 
                    //                 A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                    //                 A.approved_by='$curusr',
                    //                 A.approved_on='$now' 
                    //             WHERE A.id = '$ref_id' and B.id = '$id'";
                    //     $this->db->query($sql);
                                           

                    //     $sql = "Delete from raw_material_in_out where id = '$id'";
                    //     $this->db->query($sql);

                    //     $sql = "Delete from raw_material_in_out_items WHERE raw_material_in_out_id = '$ref_id'";
                    //     $this->db->query($sql);

                    //     $sql = "Update raw_material_in_out_items set raw_material_in_out_id='$ref_id' WHERE raw_material_in_out_id = '$id'";
                    //     $this->db->query($sql);

                    //     $id = $ref_id;
                    // } else {

                    //     $sql = "Update raw_material_in_out A 
                    //             Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' ,A.ref_no='$ref_no'
                    //             WHERE A.id = '$id'";
                    //     $this->db->query($sql);
                    // }

                    $sql = "Update production_details A Set A.report_approved='1', A.report_status='$status', 
                            A.report_remarks='$report_remarks', A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                    $action='Production Report '.$status.'.';

                    $this->notification_model->delete_notification('6', $id);
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

            // if($this->input->post('status')=="Approved"){
            //     $ref_id = $id;
            //     $id = '';
            // } else {
            //     $ref_id = $this->input->post('ref_id');
            // }

            // if($ref_id==""){
            //     $ref_id = null;
            // }

            $data = array(
                'report_status' => $status,
                'report_remarks' => $report_remarks,
                'modified_by' => $curusr,
                'modified_on' => $now,
                // 'ref_id' => $ref_id
            );

            // if($id==''){
            //     $data['created_by']=$curusr;
            //     $data['created_on']=$now;

            //     $this->db->insert('production_details',$data);
            //     $id=$this->db->insert_id();
            //     $action='Production Report Created.';
            // } else {
            //     $this->db->where('id', $id);
            //     $this->db->update('production_details',$data);
            //     $action='Production Report Modified.';
            // }

            $this->db->where('id', $id);
            $this->db->update('production_details',$data);
            $action='Production Report Modified.';
        }


        $logarray['table_id']=$id;
        $logarray['module_name']='Production';
        $logarray['cnt_name']='Production';
        $logarray['action']=$action;
        $this->user_access_log_model->insertAccessLog($logarray);
    }

}
?>