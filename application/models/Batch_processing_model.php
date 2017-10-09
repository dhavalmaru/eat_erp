<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Batch_processing_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Batch_Processing' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select C.*, D.depot_name from 
            (select A.*, B.product_name from 
            (select * from batch_processing".$cond.") A 
            left join 
            (select * from product_master) B 
            on (A.product_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id) order by C.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_batch_raw_material($id){
    $sql = "select A.*, B.rm_name from 
            (select * from batch_raw_material where batch_processing_id = '$id') A 
            left join 
            (select * from raw_material_master) B 
            on (A.raw_material_id=B.id)";
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
    
    $data = array(
        'batch_id_as_per_fssai' => $this->input->post('batch_id_as_per_fssai'),
        'date_of_processing' => $date_of_processing,
        'depot_id' => $this->input->post('depot_id'),
        'product_id' => $this->input->post('product_id'),
        'qty_in_bar' => format_number($this->input->post('qty_in_bar'),2),
        'actual_wastage' => format_number($this->input->post('actual_wastage'),2),
        'wastage_percent' => format_number($this->input->post('wastage_percent'),2),
        'anticipated_wastage' => format_number($this->input->post('anticipated_wastage'),2),
        'wastage_variance' => format_number($this->input->post('wastage_variance'),2),
        'total_kg' => format_number($this->input->post('total_kg'),2),
        'output_kg' => format_number($this->input->post('output_kg'),2),
        'avg_grams' => format_number($this->input->post('avg_grams'),2),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('batch_processing',$data);
        $id=$this->db->insert_id();
        $action='Batch Processing Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('batch_processing',$data);
        $action='Batch Processing Entry Modified.';
    }


    $this->db->where('batch_processing_id', $id);
    $this->db->delete('batch_raw_material');

    $raw_material_id=$this->input->post('raw_material_id[]');
    $qty=$this->input->post('qty[]');

    for ($k=0; $k<count($raw_material_id); $k++) {
        if(isset($raw_material_id[$k]) and $raw_material_id[$k]!="") {
            $data = array(
                        'batch_processing_id' => $id,
                        'raw_material_id' => $raw_material_id[$k],
                        'qty' => format_number($qty[$k],2)
                    );
            $this->db->insert('batch_raw_material', $data);
        }
    }


    $logarray['table_id']=$id;
    $logarray['module_name']='Batch_Processing';
    $logarray['cnt_name']='Batch_Processing';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_batch_id_availablity(){
    $id=$this->input->post('id');
    $batch_id_as_per_fssai=$this->input->post('batch_id_as_per_fssai');

    // $id="";

    $query=$this->db->query("SELECT * FROM batch_processing WHERE id!='".$id."' and batch_id_as_per_fssai='".$batch_id_as_per_fssai."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}
}
?>