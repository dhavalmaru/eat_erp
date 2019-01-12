<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Production_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
    }

    function get_access(){
        $role_id=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Purchase_Order' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    function get_manufacturer(){
        $sql="select * from depot_master where status='Approved' and type='Manufacturer'";
        $query=$this->db->query($sql);
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

        $sql = "select A.*, B.depot_name as manufacturer_name from production_details A left join depot_master B 
                on (A.manufacturer_id=B.id) ".$cond." order by A.modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_batch_items($id){
        $sql = "select * from production_batch_details where production_id = '$id'";
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
        
        $data = array(
            'p_status' => $this->input->post('p_status'),
            'p_id' => $this->input->post('p_id'),
            'from_date' =>  $from_date,
            'to_date' => $to_date,
            'manufacturer_id' =>  $this->input->post('manufacturer_id'),
            'status' => $this->input->post('status'),
            'remarks' => $this->input->post('remarks'),
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
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now
        );

        $this->db->where('id', $id);
        $this->db->update('production_details',$data);
        $action='Production Confirmed.';

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
            'status' => $this->input->post('status'),
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now
        );

        $this->db->where('id', $id);
        $this->db->update('production_details',$data);
        $action='Production Confirmed.';

        $this->db->where('production_id', $id);
        $this->db->delete('production_batch_details');

        $bar=$this->input->post('bar[]');
        $qty=$this->input->post('qty[]');
        
        for ($k=0; $k<count($bar); $k++) {
            if(isset($bar[$k]) and $bar[$k]!="") {
                $data = array(
                            'production_id' => $id,
                            'bar_id' => $bar[$k],
                            'qty' => format_number($qty[$k],2)
                        );
                $this->db->insert('production_batch_details', $data);
            }
        }

        $logarray['table_id']=$id;
        $logarray['module_name']='Production';
        $logarray['cnt_name']='Production';
        $logarray['action']=$action;
        $this->user_access_log_model->insertAccessLog($logarray);
    }

    function confirm_raw_material($id=''){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $data = array(
            'p_status' => $this->input->post('p_status'),
            'status' => $this->input->post('status'),
            'remarks' => $this->input->post('remarks'),
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

        $logarray['table_id']=$id;
        $logarray['module_name']='Production';
        $logarray['cnt_name']='Production';
        $logarray['action']=$action;
        $this->user_access_log_model->insertAccessLog($logarray);
    }
}
?>