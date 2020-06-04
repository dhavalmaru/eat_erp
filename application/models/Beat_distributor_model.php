<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Beat_distributor_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Area' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $beat_id=''){
    if($status!=""){
        $cond=" where A.status='".$status."'";
    } else {
        $cond="";
    }

    if($beat_id!=""){
        if($cond=="") {
            $cond=" where A.beat_id='".$beat_id."'";
        } else {
            $cond=$cond." and A.beat_id='".$beat_id."'";
        }
    }

	$sql = "select A.beat_id, concat(B.beat_id,' - ',B.beat_name) as beat_name, 
                A.status, A.remarks, group_concat(C.distributor_name) as distributor_name 
            from distributor_beat_plans A 
            left join beat_master B on (A.beat_id = B.id) 
            left join distributor_master C on (A.distributor_id = C.id) 
            ".$cond." 
            group by A.beat_id, B.beat_id, B.beat_name, A.status, A.remarks 
            order by A.beat_id";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_beat_plans($beat_id=''){
    $sql = "select distinct A.id, concat(A.beat_id,' - ',A.beat_name) as beat_name 
            from beat_master A
            order by A.id";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributors(){
    $sql = "select * from distributor_master 
            where status = 'Approved' and class='super stockist'
            order by distributor_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_beat_distributors($beat_id=''){
    $sql = "select group_concat(distributor_id) as distributor_id from distributor_beat_plans 
            where beat_id = '$beat_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($beat_id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $beat_id = $this->input->post('beat_id')==''?null:$this->input->post('beat_id');
    $distributor_id = $this->input->post('distributor_id');

    $this->db->where('beat_id', $beat_id);
    $this->db->delete('distributor_beat_plans');

    for ($k=0; $k<count($distributor_id); $k++) {
        if(isset($distributor_id[$k]) and $distributor_id[$k]!="") {
            $data = array(
                        'beat_id' => $beat_id,
                        'distributor_id' => $distributor_id[$k],
                        'status' => $this->input->post('status'),
                        'remarks' => $this->input->post('remarks'),
                        'created_by' => $curusr,
                        'created_on' => $now,
                        'modified_by' => $curusr,
                        'modified_on' => $now
                    );
            $this->db->insert('distributor_beat_plans', $data);
        }
    }

    $logarray['table_id']=$beat_id;
    $logarray['module_name']='Beat_Distributor';
    $logarray['cnt_name']='Beat_Distributor';
    $logarray['action']='Beat Distributor Assigned';
    $this->user_access_log_model->insertAccessLog($logarray);
}

}
?>