<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class sr_beat_plan_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_Sale' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select C.*, D.sales_rep_name,E.zone,F.location,G.area from (select A.*, B.distributor_name from 
            (select * from admin_sales_rep_beat_plan".$cond.") A 
            left join 
            (select * ,concat('d_',id) as d_id from distributor_master) B 
            on (A.store_id=B.d_id COLLATE utf8_unicode_ci)
            )C
			left join 
			(select * from sales_rep_master) D 
            on (C.sales_rep_id=D.id)
            left join 
            (select * from zone_master) E 
            on (C.zone_id=E.id)
            left join 
            (select * from area_master) G 
            on (C.area_id=G.id)
            left join 
            (select * from location_master) F
            on (C.location_id=F.id)
			where C.status='Approved' order by frequency,sequence,modified_on asc ";
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

    $due_date=$this->input->post('due_date');
    if($due_date==''){
        $due_date=NULL;
    }
    else{
        $due_date=formatdate($due_date);
    }
    
	
	
    $data = array(
        'date_of_processing' => $date_of_processing,
        'distributor_id' => $this->input->post('distributor_id'),
        'sales_rep_id' => $this->input->post('sales_rep_id'),
        'frequency' => $this->input->post('frequency'),
        'sequence' => $this->input->post('sequence'),
 
    
        'status' => 'Approved',
     
        'modified_by' => $curusr,
        'modified_on' => $now,
      
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sales_rep_beat_plan',$data);
        $id=$this->db->insert_id();
        $action='Distributor Sale Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('sales_rep_beat_plan',$data);
        $action='Distributor Sale Entry Modified.';
    }

  

    $logarray['table_id']=$id;
    $logarray['module_name']='sales_rep_beat_plan';
    $logarray['cnt_name']='sales_rep_beat_plan';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function get_distributor_details(){
    $sql = "select * from distributor_master order by distributor_name desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_sales_rep_details(){
    $sql = "select * from sales_rep_master order by sales_rep_name desc";
    $query=$this->db->query($sql);
    return $query->result();
}






// function get_location_data($postData){
    // $sql = "Select  A.*,D.location from 
            // (select * from store_master) A 
            // left join 
            // (select * from location_master)D
            // on (A.location_id=D.id)
            // where A.store_id='". $postData['store_id'] ."'";
    // $query=$this->db->query($sql);
    // return $query->result();
// }




}
?>