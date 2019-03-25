<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Raw_material_recon_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Batch_Processing' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_pending_data($id=''){
    $query=$this->db->query("SELECT * FROM raw_material_recon WHERE ref_id = '$id' and status!='InActive'");
    $result=$query->result();
    if (count($result)>0){
        $id = $result[0]->id;
    }

    return $id;
}

function get_data($status='', $id=''){
    if($status!=""){
        if($status=="Pending"){
            $cond=" where A.status='Pending' or A.status='Deleted'";
        } else{
            $cond=" where A.status='".$status."'";
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

    $sql = "select A.*, E.depot_name, 
                concat(B.first_name, ' ', B.last_name) as createdby, 
                concat(C.first_name, ' ', C.last_name) as modifiedby, 
                concat(D.first_name, ' ', D.last_name) as approvedby 
            from raw_material_recon A 
            left join user_master B on(A.created_by=B.id) 
            left join user_master C on(A.modified_by=C.id) 
            left join user_master D on(A.approved_by=D.id) 
            left join depot_master E on(A.depot_id=E.id) ".$cond." order by E.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_raw_material_stock($depot_id='', $date='') {
    $cond = "";
    if($depot_id!=''){
        $cond = " and H.depot_id='$depot_id' ";
    }
    if($date==''){
        $date = date('Y-m-d');
    }
    $sql="select H.*, I.rm_name, I.status from
        (select F.*, G.depot_name from 
        (select E.depot_id, E.raw_material_id, sum(tot_qty) as tot_qty from 
        (select C.depot_id, C.raw_material_id, ifnull(C.qty_in,0)-ifnull(D.qty_out,0) as tot_qty from 
        (select AA.depot_id, AA.raw_material_id, sum(AA.qty) as qty_in from 
        (select A.depot_id, B.raw_material_id, 0 as qty from 
        (select * from batch_processing where status = 'Approved' and date_of_processing > '2018-10-22' and date_of_processing <= '$date') A 
        inner join 
        (select * from batch_raw_material) B 
        on (A.id = B.batch_processing_id) 
        union all 
        select A.depot_id, B.raw_material_id, B.qty from 
        (select * from raw_material_in where status = 'Approved' and date_of_receipt > '2018-10-22' and date_of_receipt <= '$date') A 
        inner join 
        (select * from raw_material_stock) B 
        on (A.id = B.raw_material_in_id) 
        union all 
        select A.depot_id, B.raw_material_id, B.qty from 
        (select * from raw_material_in_out where status = 'Approved' and date_of_processing > '2018-10-22' and date_of_processing <= '$date') A 
        inner join 
        (select * from raw_material_in_out_items Where type='Stock IN') B 
        on (A.id = B.raw_material_in_out_id)
        union all 
        select A.depot_in_id as depot_id, B.item_id as raw_material_id, B.qty from 
        (select * from depot_transfer where status = 'Approved' and date_of_transfer > '2018-10-22' and date_of_transfer <= '$date') A 
        inner join 
        (select * from depot_transfer_items where type = 'Raw Material') B 
        on (A.id = B.depot_transfer_id)) AA group by AA.depot_id, AA.raw_material_id) C 
        left join 
        (select BB.depot_id, BB.raw_material_id, sum(BB.qty) as qty_out from 
        (select A.depot_id, B.raw_material_id, B.qty from 
        (select * from batch_processing where status = 'Approved' and date_of_processing > '2018-10-22' and date_of_processing <= '$date') A 
        inner join 
        (select * from batch_raw_material) B 
        on (A.id = B.batch_processing_id) 
        union all 
        select A.depot_id, B.raw_material_id, B.qty from 
        (select * from raw_material_in_out where status = 'Approved' and date_of_processing > '2018-10-22' and date_of_processing <= '$date') A 
        inner join 
        (select * from raw_material_in_out_items Where type='Stock Out') B 
        on (A.id = B.raw_material_in_out_id)
        union all 
        select A.depot_out_id as depot_id, B.item_id as raw_material_id, B.qty from 
        (select * from depot_transfer where status = 'Approved' and date_of_transfer > '2018-10-22' and date_of_transfer <= '$date') A 
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
        on (H.raw_material_id=I.id) where I.status = 'Approved'".$cond." order by I.rm_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_raw_material_recon_items($id){
    $sql = "select A.*, B.rm_name from 
            (select * from raw_material_recon_items where raw_material_recon_id = '$id') A 
            left join 
            (select * from raw_material_master) B 
            on (A.raw_material_id=B.id) order by B.rm_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_batch_images($id){
    $query=$this->db->query("SELECT * FROM batch_images WHERE raw_material_recon_id = '$id'");
    return $query->result();
}

function save_data($id='') {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    } else {
        $date_of_processing=formatdate($date_of_processing);
    }

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
            $sql = "Update raw_material_recon Set status='$status', approved_by='$curusr', approved_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Payment Entry '.$status.'.';
        } else {
            if($id!='' || $ref_id!=''){
                if($ref_id!=null && $ref_id!=''){
                    $sql = "update raw_material_recon A, raw_material_recon B 
                            set A.date_of_processing=B.date_of_processing, A.depot_id=B.depot_id, 
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now', 
                                A.production_id=B.production_id 
                            where A.id = '$ref_id' and B.id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from raw_material_recon where id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from raw_material_recon_items WHERE raw_material_recon_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update raw_material_recon_items set raw_material_recon_id = '$ref_id' WHERE raw_material_recon_id = '$id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {
                    $sql = "Update raw_material_recon A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

                $this->set_raw_material_in_out($id);

                $module = $this->input->post('module');
                $production_id = $this->input->post('production_id');
                if($module=='production'){
                    $sql = "update production_details set raw_material_recon = '1' where id = '$production_id'";
                    $this->db->query($sql);
                }

                $action='batch_raw_material '.$status.'.';
				echo '<script>var win = window.open("'.base_url().'index.php/raw_material_recon/view_raw_material_recon_receipt/'.$id.'") 	win.print();</script>';
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

        $this->input->post('status');

        if($this->input->post('status')=="Approved"){
            $ref_id = $id;
            $id = '';
        } else {
            $ref_id = $this->input->post('ref_id');
        }

        if($ref_id==""){
            $ref_id = null;
        }

        $data = array(
            'date_of_processing' => $date_of_processing,
            'depot_id' => $this->input->post('depot_id'),
            'status' =>  $status,
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id,
            'production_id' => $this->input->post('production_id')
        );

        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            if($this->input->post('status')=="Approved"){
                $action='Raw Material Recon Entry Modified.';
            } else {
                $action='Raw Material Recon Entry Created.';
            }

            $this->db->insert('raw_material_recon',$data);
            $id=$this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('raw_material_recon',$data);
            $action='Payment Entry Modified.';
        }

        $this->db->where('raw_material_recon_id', $id);
        $this->db->delete('raw_material_recon_items');

        $raw_material_id=$this->input->post('raw_material_id[]');
        $system_qty=$this->input->post('system_qty[]');
        $physical_qty=$this->input->post('physical_qty[]');
        $difference_qty=$this->input->post('difference_qty[]');
        $item_status=$this->input->post('item_status[]');

        for ($k=0; $k<count($raw_material_id); $k++) {
            if(isset($raw_material_id[$k]) and $raw_material_id[$k]!="") {
                $data = array(
                            'raw_material_recon_id' => $id,
                            'raw_material_id' => $raw_material_id[$k],
                            'system_qty' => format_number($system_qty[$k],2),
                            'physical_qty' => format_number($physical_qty[$k],2),
                            'difference_qty' => format_number($difference_qty[$k],2)
                        );
                $this->db->insert('raw_material_recon_items', $data);
            }
        }
    }
    
    $logarray['table_id']=$id;
    $logarray['module_name']='Raw_Material_Recon';
    $logarray['cnt_name']='Raw_Material_Recon';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    $module = $this->input->post('module');
    $production_id = $this->input->post('production_id');
    if($module=='production'){
        echo '<script>window.open("'.base_url().'index.php/production/post_details/'.$production_id.'", "_parent")</script>';
    } else {
        echo '<script>window.open("'.base_url().'index.php/raw_material_recon", "_parent")</script>';
    }
}

function set_raw_material_in_out($id='') {
    $sql = "delete from raw_material_in_out_items where raw_material_in_out_id in 
            (select distinct id from raw_material_in_out where production_id = '$id')";
    $this->db->query($sql);

    $sql = "delete from raw_material_in_out where production_id = '$id'";
    $this->db->query($sql);

    $p_id = '';
    $sql = "select * from production_details where id = '$id'";
    $result = $this->db->query($sql)->result();
    if(count($result)>0){
        $p_id = $result[0]->p_id;
    }

    $sql = "insert into raw_material_in_out (date_of_processing, depot_id, status, type, remarks, 
            created_by, created_on, modified_by, modified_on, approved_by, approved_on, production_id) 
            select date_of_processing, depot_id, status, 'Adjustment', 
            'System generated adjustment entry for Production - ".$p_id.".', created_by, created_on, 
            modified_by, modified_on, approved_by, approved_on, '$id' from raw_material_recon where id = '$id'";
    $this->db->query($sql);

    $raw_material_in_out_id = '';
    $sql = "select max(id) id from raw_material_in_out";
    $result = $this->db->query($sql)->result();
    if(count($result)>0){
        $raw_material_in_out_id = $result[0]->id;
    }

    $sql = "select * from raw_material_recon_items where raw_material_recon_id = '$id'";
    $result = $this->db->query($sql)->result();
    if(count($result)>0){
        for($i=0; $i<count($result); $i++){
            $raw_material_id = $result[$i]->raw_material_id;
            $difference_qty = floatval($result[$i]->difference_qty);
            $type = '';

            if($difference_qty!=0){
                if($difference_qty>0){
                    $type = 'Stock IN';
                } else {
                    $type = 'Stock OUT';
                    $difference_qty = $difference_qty * -1;
                }
                $data = array(
                            'raw_material_in_out_id' => $raw_material_in_out_id,
                            'type' => $type,
                            'raw_material_id' => $raw_material_id,
                            'qty' => $difference_qty
                        );
                $this->db->insert('raw_material_in_out_items', $data);
            }
        }
    }
}
}
?>