<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class AccountGroup_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Acc_Group' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id='', $class=''){
    if($status!=""){
        $cond=" where status='".$status."' and flag=0";
    } else {
        $cond=" where flag=0";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where fk_id='".$id."' and flag=0";
        } else {
            $cond=$cond." and fk_id='".$id."' and flag=0";
        }
    }

    $sql = "select * from account_group_master ".$cond."";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_group_data($status='', $id='', $class=''){
    if($status!=""){
        $cond=" where status='".$status."' and flag=1";
    } else {
        $cond=" where flag=1";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where id='".$id."' and flag=1";
        } else {
            $cond=$cond." and id='".$id."' and flag=1";
        }
    }

    // $sql = "select * from account_group_master ".$cond." order by group_name asc";
    $sql = "select D.*, E.gname from 
            (select * from 
            ((select id, group_name, fk_id, created_by, created_date, status, flag 
                from account_group_master)) C ".$cond.") D 
            left join 
            (select group_name as gname,id from account_group_master) E 
            on (D.fk_id=E.id) order by D.group_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_contacts($id){
    $sql = "select * from distributor_contacts where distributor_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id='') {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $data = array(
        'group_name' => $this->input->post('group_name'),
        'fk_id' => $this->input->post('fk_primary_id'),
        'updated_by' => $curusr,
        'updated_date' => $now,
        'status' => $this->input->post('status'),
        'flag' => '1',
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_date']=$now;

        $this->db->insert('account_group_master',$data);
        $id=$this->db->insert_id();
        $action='Group Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('account_group_master',$data);
        $action='Group Modified.';
    }

    

    $logarray['table_id']=$id;
    $logarray['module_name']='Accounting Group';
    $logarray['cnt_name']='Accounting Group';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}


function check_group_availablity(){
    $id=$this->input->post('id');
    $group_name=$this->input->post('group_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM account_group_master WHERE id!='".$id."' and group_name='".$group_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>