<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class relationship_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Relationship_Master' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select A.*, B.distributor_type from 
            (select * from relationship_master".$cond.") A 
            left join 
            (select * from distributor_type_master) B 
            on (A.type_id=B.id) where A.status='Approved' order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

public function getRelationship_margin($relationship_id)
{
    
    return $this->db->select("*")->where("relationship_id",$relationship_id)->get('relationship_category_margin')->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'store_name' => $this->input->post('store_name'),
        'type_id' => $this->input->post('type_id'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('relationship_master',$data);
        $id=$this->db->insert_id();
        $action='Store Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('relationship_master',$data);
        $action='Store Modified.';
    }

    $margin=$this->input->post('margin[]');
    $category=$this->input->post('category_id[]');

    for ($j=0; $j<count($category); $j++) {
        if(isset($category[$j]) and $category[$j]!="") {
            $data = array(
                        'relationship_id' => $id,
                        'category_id' => $category[$j],
                        'margin' => $margin[$j],
                    );
            $this->db->insert('relationship_category_margin', $data);
        }
    }


    $logarray['table_id']=$id;
    $logarray['module_name']='Relationship_Master';
    $logarray['cnt_name']='Relationship_Master';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_store_availablity(){
    $id=$this->input->post('id');
    $store_name=$this->input->post('store_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM relationship_master WHERE id!='".$id."' and store_name='".$store_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>