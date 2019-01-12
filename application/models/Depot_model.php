<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Depot_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Depot' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from depot_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_depot_contacts($id){
    $sql = "select * from depot_contacts where depot_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'depot_name' => $this->input->post('depot_name'),
        'address' => $this->input->post('address'),
        'city' =>  $this->input->post('city'),
        'pincode' => $this->input->post('pincode'),
        'state' =>  $this->input->post('state'),
        'country' => $this->input->post('country'),
        'email_id' => $this->input->post('d_email_id'),
        'mobile' => $this->input->post('d_mobile'),
        'type' => $this->input->post('type'),
        'gst_no' => $this->input->post('gst_no'),
        'fssai_no' => $this->input->post('fssai_no'),
        'bank_acc_no' => $this->input->post('bank_acc_no'),
        'bank_name' => $this->input->post('bank_name'),
        'ifsc_code' => $this->input->post('ifsc_code'),
        // 'contact_person' => $this->input->post('contact_person'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'state_code' =>  $this->input->post('state_code')
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('depot_master',$data);
        $id=$this->db->insert_id();
        $action='Depot Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('depot_master',$data);
        $action='Depot Modified.';
    }

    $this->db->where('depot_id', $id);
    $this->db->delete('depot_contacts');

    $contact_person=$this->input->post('contact_person[]');
    $email_id=$this->input->post('email_id[]');
    $mobile=$this->input->post('mobile[]');

    for ($k=0; $k<count($contact_person); $k++) {
        if(isset($contact_person[$k]) and $contact_person[$k]!="") {
            $data = array(
                        'depot_id' => $id,
                        'contact_person' => $contact_person[$k],
                        'email_id' => $email_id[$k],
                        'mobile' => $mobile[$k]
                    );
            $this->db->insert('depot_contacts', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Depot';
    $logarray['cnt_name']='Depot';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_depot_availablity(){
    $id=$this->input->post('id');
    $depot_name=$this->input->post('depot_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM depot_master WHERE id!='".$id."' and depot_name='".$depot_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>