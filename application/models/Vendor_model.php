<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Vendor_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Vendors' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id=''){
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

    $sql = "select A.*, B.vendor_type from vendor_master A left join vendor_type_master B on A.type_id = B.id ".$cond."
             order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_vendor_contacts($id){
    $sql = "select * from vendor_contacts where vendor_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'vendor_name' => $this->input->post('vendor_name'),
        'address' => $this->input->post('address'),
        'city' =>  $this->input->post('city'),
        'pincode' => $this->input->post('pincode'),
        'state' =>  $this->input->post('state'),
        'country' => $this->input->post('country'),
        'email_id' => $this->input->post('v_email_id'),
        'mobile' => $this->input->post('v_mobile'),
        // 'contact_person' => $this->input->post('contact_person'),
        'tin_number' => $this->input->post('tin_number'),
        'cst_number' => $this->input->post('cst_number'),
        'status' => $this->input->post('status'),
        'type_id' => $this->input->post('type_id'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'gst_number' => $this->input->post('gst_number')
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('vendor_master',$data);
        $id=$this->db->insert_id();
        $action='Vendor Created.';

        // $data1 = array(
        //     'ledger_name' => $this->input->post('vendor_name'),
        //     'ledger_type' => 'Purchase Vendor',
        //     'created_by' => $curusr,
        //     'created_date' => $now,
        //     'status' => 'Pending',
        //     'vendor_id' => $id
        // );

        // $this->db->insert('account_ledger_master',$data1);

    } else {
        $this->db->where('id', $id);
        $this->db->update('vendor_master',$data);
        $action='Vendor Modified.';

        // $data1 = array(
        //     'ledger_name' => $this->input->post('vendor_name'),
        //     'ledger_type' => 'Purchase Vendor',
        //     'updated_by' => $curusr,
        //     'updated_date' => $now,
        //     'status' => 'Pending',
        // );

        // $this->db->where('vendor_id', $id);
        // $this->db->update('account_ledger_master',$data1);
    }

    $this->db->where('vendor_id', $id);
    $this->db->delete('vendor_contacts');

    $contact_person=$this->input->post('contact_person[]');
    $email_id=$this->input->post('email_id[]');
    $mobile=$this->input->post('mobile[]');

    for ($k=0; $k<count($contact_person); $k++) {
        if(isset($contact_person[$k]) and $contact_person[$k]!="") {
            $data = array(
                        'vendor_id' => $id,
                        'contact_person' => $contact_person[$k],
                        'email_id' => $email_id[$k],
                        'mobile' => $mobile[$k]
                    );
            $this->db->insert('vendor_contacts', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Vendor';
    $logarray['cnt_name']='Vendor';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_vendor_availablity(){
    $id=$this->input->post('id');
    $vendor_name=$this->input->post('vendor_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM vendor_master WHERE id!='".$id."' and vendor_name='".$vendor_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>