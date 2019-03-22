<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Raw_material_in_out_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Raw_Material_In' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_pending_data($id=''){
    $query=$this->db->query("SELECT * FROM batch_processing WHERE ref_id = '$id' and status!='InActive'");
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
    //,(select other_charges_amount from purchase_order Where id='purchase_order_id') as other_charges_amount
    $sql =  "SELECT A.*,D.depot_name from 
                (
                  select A.*, concat(B.first_name, ' ', B.last_name) as createdby, 
                 concat(C.first_name, ' ', C.last_name) as modifiedby, 
                 concat(D.first_name, ' ', D.last_name) as approvedby 
                 from raw_material_in_out A 
                 left join user_master B on(A.created_by=B.id) 
                 left join user_master C on(A.modified_by=C.id) 
                 left join user_master D on(A.approved_by=D.id) 
                 ".$cond."
                ) A
            left join 
            (select * from depot_master) D 
            on (A.depot_id=D.id) order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_raw_material_in_out($id){
    $sql = "Select B.* from 
            (SELECT * FROM `raw_material_in_out` Where id='$id') A
            Left JOIN
            (SELECT * from  raw_material_in_out_items ) B On A.id=B.raw_material_in_out_id";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    }
    else{
        $date_of_processing=formatdate($date_of_processing);
    }

    $ref_no = NULL;

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
            $sql = "Update raw_material_in_out Set status='$status', approved_by='$curusr', approved_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Raw Material IN Entry '.$status.'.';
        } else {
            if($id!='' || $ref_id!=''){
                /*if($ref_no==null || $ref_no=='')
                    {
                        echo "ref_no".$ref_no;

                        $sql="select * from series_master where type='Raw_Material_In_Out'";
                        $query=$this->db->query($sql);
                        $result=$query->result();
                        if(count($result)>0)
                        {
                            $series=intval($result[0]->series)+1;
                            $sql="update series_master set series = '$series' where type = 'Raw_Material_In_Out'";
                            $this->db->query($sql);
                            $ref_no = 'WHPL/RMIO/'.strval($series);
                        }
                        else
                        {
                            $series=1;
                            $sql="insert into series_master (type, series) values ('Raw_Material_In_Out', '$series')";
                            $this->db->query($sql);
                            $ref_no = 'WHPL/RMIO/'.strval($series);
                        } 
                    }*/

                if($ref_id!=null && $ref_id!=''){  

                    $sql = "Update raw_material_in_out A, raw_material_in_out B 
                            Set A.date_of_processing=B.date_of_processing,
                                A.depot_id=B.depot_id,
                                A.type=B.type,
                                A.ref_no='$ref_no',
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr',
                                A.approved_on='$now' 
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    $this->db->query($sql);
                                       

                    $sql = "Delete from raw_material_in_out where id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from raw_material_in_out_items WHERE raw_material_in_out_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update raw_material_in_out_items set raw_material_in_out_id='$ref_id' WHERE raw_material_in_out_id = '$id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {

                    $sql = "Update raw_material_in_out A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' ,A.ref_no='$ref_no'
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

                $action='Raw_Material_In_Out '.$status.'.';

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
            'type' => $this->input->post('r_type'),
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id,
            'status' => $status,
            'ref_no'=>$ref_no
        );

        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            $this->db->insert('raw_material_in_out',$data);
            $id=$this->db->insert_id();
            $action='Raw Material In Entry Created.';
        } else {
            $this->db->where('id', $id);
            $this->db->update('raw_material_in_out',$data);
            $action='Raw Material In Entry Modified.';
        }

        $this->db->where('raw_material_in_out_id', $id);
        $this->db->delete('raw_material_in_out_items');

        $type=$this->input->post('type[]');
        $qty=$this->input->post('qty[]');
        $raw_material_id=$this->input->post('raw_material[]');
        
        for ($k=0; $k<count($raw_material_id); $k++) {
            if(isset($raw_material_id[$k]) and $raw_material_id[$k]!="") {
                $data = array(
                            'raw_material_in_out_id' => $id,
                            'type' => $type[$k],
                            'raw_material_id' => $raw_material_id[$k],
                            'qty' => $qty[$k]
                        );
                $this->db->insert('raw_material_in_out_items', $data);
            }
        }
    }


    $logarray['table_id']=$id;
    $logarray['module_name']='Raw_Material_In_Out';
    $logarray['cnt_name']='Raw_Material_In_Out';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

}
?>