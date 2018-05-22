<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Emp_master_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Emp_master' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from emp_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $date_of_birth=$this->input->post('date_of_birth');
    if($date_of_birth==''){
        $date_of_birth=NULL;
    } else {
        $date_of_birth=formatdate($date_of_birth);
    }
    $dob_as_per_aadhar=$this->input->post('dob_as_per_aadhar');
    if($dob_as_per_aadhar==''){
        $dob_as_per_aadhar=NULL;
    } else {
        $dob_as_per_aadhar=formatdate($dob_as_per_aadhar);
    }
    $dob_of_spouse=$this->input->post('dob_of_spouse');
    if($dob_of_spouse==''){
        $dob_of_spouse=NULL;
    } else {
        $dob_of_spouse=formatdate($dob_of_spouse);
    }
    $dob_of_kids=$this->input->post('dob_of_kids');
    if($dob_of_kids==''){
        $dob_of_kids=NULL;
    } else {
        $dob_of_kids=formatdate($dob_of_kids);
    }
    $date_of_joining=$this->input->post('date_of_joining');
    if($date_of_joining==''){
        $date_of_joining=NULL;
    } else {
        $date_of_joining=formatdate($date_of_joining);
    }
    $confirmation_date=$this->input->post('confirmation_date');
    if($confirmation_date==''){
        $confirmation_date=NULL;
    } else {
        $confirmation_date=formatdate($confirmation_date);
    }
    $date_of_resignation=$this->input->post('date_of_resignation');
    if($date_of_resignation==''){
        $date_of_resignation=NULL;
    } else {
        $date_of_resignation=formatdate($date_of_resignation);
    }
    $last_working_date=$this->input->post('last_working_date');
    if($last_working_date==''){
        $last_working_date=NULL;
    } else {
        $last_working_date=formatdate($last_working_date);
    }
    
    
    $data = array(
        // 'id' => $this->input->post('id'),
        'offer_letter_id' => $this->input->post('offer_letter_id'),
        'acceptance_id' => $this->input->post('acceptance_id'),
        'emp_id' => $this->input->post('emp_id'),
        'emp_code' => $this->input->post('emp_code'),
        'salutation' => $this->input->post('salutation'),
        'first_name' => $this->input->post('first_name'),
        'middle_name' => $this->input->post('middle_name'),
        'last_name' => $this->input->post('last_name'),
        'full_name' => $this->input->post('full_name'),
        'name_as_per_aadhar' => $this->input->post('name_as_per_aadhar'),
        'gender' => $this->input->post('gender'),
        'blood_group' => $this->input->post('blood_group'),
        'marital_status' => $this->input->post('marital_status'),
        'date_of_birth' => $date_of_birth,
        'dob_as_per_aadhar' => $dob_as_per_aadhar,
        'pan_no' => $this->input->post('pan_no'),
        'aadhar_card_no' => $this->input->post('aadhar_card_no'),
        'permanant_address1' => $this->input->post('permanant_address1'),
        'permanant_address2' => $this->input->post('permanant_address2'),
        'permanant_address3' => $this->input->post('permanant_address3'),
        'station' => $this->input->post('station'),
        'city' => $this->input->post('city'),
        'pincode' => $this->input->post('pincode'),
        'state' => $this->input->post('state'),
        'country' => $this->input->post('country'),
        'mobile_no' => $this->input->post('mobile_no'),
        'personal_email_id' => $this->input->post('personal_email_id'),
        'present_address1' => $this->input->post('present_address1'),
        'present_address2' => $this->input->post('present_address2'),
        'present_address3' => $this->input->post('present_address3'),
        'present_station' => $this->input->post('present_station'),
        'present_city' => $this->input->post('present_city'),
        'present_state' => $this->input->post('present_state'),
        'present_country' => $this->input->post('present_country'),
        'present_pincode' => $this->input->post('present_pincode'),
        'father_title' => $this->input->post('father_title'),
        'father_name' => $this->input->post('father_name'),
        'spouse_title' => $this->input->post('spouse_title'),
        'spouse_name' => $this->input->post('spouse_name'),
        'dob_of_spouse' => $dob_of_spouse,
        'kids_name' => $this->input->post('kids_name'),
        'dob_of_kids' => $dob_of_kids,
        'ctc' => ($this->input->post('ctc')==''?NULL:$this->input->post('ctc')),
        'basic' => ($this->input->post('basic')==''?NULL:$this->input->post('basic')),
        'hra' => ($this->input->post('hra')==''?NULL:$this->input->post('hra')),
        'conveyance' => ($this->input->post('conveyance')==''?NULL:$this->input->post('conveyance')),
        'medical_reimb' => ($this->input->post('medical_reimb')==''?NULL:$this->input->post('medical_reimb')),
        'vehicle_reimb' => ($this->input->post('vehicle_reimb')==''?NULL:$this->input->post('vehicle_reimb')),
        'city_comp' => ($this->input->post('city_comp')==''?NULL:$this->input->post('city_comp')),
        'employee_pf' => ($this->input->post('employee_pf')==''?NULL:$this->input->post('employee_pf')),
        'employee_esic' => ($this->input->post('employee_esic')==''?NULL:$this->input->post('employee_esic')),
        'date_of_joining' => $date_of_joining,
        'months' => ($this->input->post('months')==''?NULL:$this->input->post('months')),
        'reporting_manager' => $this->input->post('reporting_manager'),
        'emp_no_of_reporting_manager' => $this->input->post('emp_no_of_reporting_manager'),
        'official_email' => $this->input->post('official_email'),
        'hod' => $this->input->post('hod'),
        'division' => $this->input->post('division'),
        'location' => $this->input->post('location'),
        'branch' => $this->input->post('branch'),
        'grade' => $this->input->post('grade'),
        'designation' => $this->input->post('designation'),
        'department' => $this->input->post('department'),
        'sub_department' => $this->input->post('sub_department'),
        'esic_med' => $this->input->post('esic_med'),
        'esic_med_no' => $this->input->post('esic_med_no'),
        'pf_no' => $this->input->post('pf_no'),
        'uan' => $this->input->post('uan'),
        'confirmation_date' => $confirmation_date,
        'date_of_resignation' => $date_of_resignation,
        'last_working_date' => $last_working_date,
        'ta_ra' => ($this->input->post('ta_ra')==''?NULL:$this->input->post('ta_ra')),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('emp_master',$data);
        $id=$this->db->insert_id();
        $action='Employee Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('emp_master',$data);
        $action='Employee Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Employee';
    $logarray['cnt_name']='Employee';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_product_availablity(){
    $id=$this->input->post('id');
    $product_name=$this->input->post('product_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM product_master WHERE id!='".$id."' and product_name='".$product_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>