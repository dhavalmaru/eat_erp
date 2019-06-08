<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_rep_attendance_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_Out' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($id=''){
    $cond="";

    if($id!=""){
        $cond=$cond." and A.id='".$id."'";
    }

    $sql = "select A.*, B.sales_rep_name from sales_attendence A left join sales_rep_master B on (A.sales_rep_id=B.id) 
            where A.entry_by_admin = '1' ".$cond." order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_sales_rep(){
    $sql = "select * from sales_rep_master where status='Approved'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $sales_rep_id = $this->input->post('sales_rep_id');
    $check_in_date = $this->input->post('check_in_date');
    $check_in_time = $this->input->post('check_in_time');
    $chk_absent = $this->input->post('chk_absent');

    if($chk_absent=='1'){
        $working_status='Absent';
    } else {
        $working_status='Present';
    }

    // echo $check_in_date;
    // echo '<br/><br/>';
    // echo $check_in_time;
    // echo '<br/><br/>';

    if($check_in_date=='' || $check_in_time==''){
        $check_in_time=NULL;
    } else {
        $d = DateTime::createFromFormat('d/m/Y', $check_in_date);
        
        if ($d && $d->format('d/m/Y') == $check_in_date) {
            $dateInput = explode('/',$check_in_date);
            $check_in_date = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
            $check_in_time = $check_in_date.' '.$check_in_time;
        } else {
            $check_in_date = null;
            $check_in_time = null;
        }
    }

    // echo $check_in_time;
    // echo '<br/><br/>';
    
    $data = array(
        'sales_rep_id' => $sales_rep_id,
        'working_status' => $working_status,
        'check_in_time' => $check_in_time,
        'updated_on' => $now,
        'entry_by_admin' => '1',
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    $id='';
    $sql = "select * from sales_attendence where sales_rep_id='$sales_rep_id' and date(check_in_time)='".$check_in_date."'";
    $result = $this->db->query($sql)->result();
    if(count($result)>0){
        $id = $result[0]->id;
    }

    if($id==''){
        $data['applied_in_keka']=Null;
        $data['causual_remark']='';
        $data['absent_remark']=Null;
        $data['latitude']='0';
        $data['longitude']='0';
        $data['check_out_time']=Null;
        $data['check_out']='0';
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sales_attendence',$data);
        $id=$this->db->insert_id();
        $action='Sales Rep Attendance Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('sales_attendence',$data);
        $action='Sales Rep Attendance Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_rep_attendance';
    $logarray['cnt_name']='Sales_rep_attendance';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

}
?>