<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class sr_mapping_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data( $id=''){
    // if($status!=""){
        // $cond=" where status='".$status."'";
    // } else {
        // $cond="";
    // }
$cond="";
    if($id!=""){
        if($cond=="") {
            $cond=" where id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }

    // $sales_rep_id=$this->session->userdata('id');
    // if($sales_rep_id!=""){
        // if($cond=="") {
            // $cond=" where sales_rep_id='".$sales_rep_id."'";
        // } else {
            // $cond=$cond." and sales_rep_id='".$sales_rep_id."'";
        // }
    // }

  $sql = "select K.*,L.store_name from(select I.*,j.sales_rep_name,(Select sales_rep_name from sales_rep_master where id=I.sales_rep_id1) as salesrepname,(Select sales_rep_name from sales_rep_master where id=I.sales_rep_id2) as salesrepname1 from (select G.*,H.distributor_type from (select E.*,F.location from(Select C.*,D.zone from
		(select A.*,B.area from 
            (select * from sr_mapping ".$cond.") A 
            left join 
            (select * from area_master) B 
            on (A.area_id = B.id or A.area_id1 = B.id )) C 
			left join 
			(select * from zone_master) D on D.id=C.zone_id) E
			left join
			(select * from location_master)F on F.id=E.location_id)G
			left join
			(select * from distributor_type_master)H on H.id=G.type_id)I
			left join
			(select * from sales_rep_master)j on j.id=I.reporting_manager_id)K
			left join
			(select * from relationship_master)L on L.id=K.area_id1
		
			order by K.modified_on desc
			";
			
			
    $query=$this->db->query($sql);
	//$this->db->last_query();
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $sales_rep_id=$this->session->userdata('sales_rep_id');
    $date_of_visit=$this->input->post('date_of_visit');
    if($date_of_visit==''){
        $date_of_visit=NULL;
    } else {
        $date_of_visit=formatdate($date_of_visit);
    }
    $area_id1 = $this->input->post('area_id1');
    if($area_id1==''){
        $area_id1 = 0;
    }
    
    $data = array(
    
        'class' => $this->input->post('class'),

        'type_id' => $this->input->post('type_id'),
        'area_id' =>$this->input->post('area_id'),
        'area_id1' =>$area_id1,
        'zone_id' => $this->input->post('zone_id'),
        'location_id' => $this->input->post('location_id'),
        'reporting_manager_id' => $this->input->post('reporting_manager_id'),
        'sales_rep_id1' =>$this->input->post('sales_rep_id1'),
        'sales_rep_id2' =>$this->input->post('sales_rep_id2'),
        'remarks' =>$this->input->post('remarks'),

       
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sr_mapping',$data);
        $id=$this->db->insert_id();
        $action='Sales Representative mapping Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('sr_mapping',$data);
        $action='Sales Representative mapping  Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_Rep';
    $logarray['cnt_name']='Sales_Rep';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

 function get_sr_name1($postData){
    $response = array();
 
    // Select record
    $this->db->select('id,sales_rep_name');
    $this->db->where('reporting_manager_id', $postData['reporting_manager_id']);
    $q = $this->db->get('sales_rep_master');
    $response = $q->result_array();

    return $response;
  }

  
  
  function get_location($area_id1,$zone_id){
    $sql = "Select  A.*,D.location from 
            (select * from store_master) A 
            left join 
            (select * from location_master)D
            on (A.location_id=D.id)
            where A.store_id='".$area_id1  ."' and  A.zone_id='". $zone_id ."' ";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_area_location($area_id,$zone_id){
    $sql = "Select A.* from location_master A where A.area_id='".$area_id."' and A.zone_id='". $zone_id ."'";
    $query=$this->db->query($sql);
    return $query->result();
}

  function get_zone($type_id){
    // $sql = "Select  A.*,D.zone from 
    //         (select * from sr_mapping) A 
    //         left join 
    //         (select * from zone_master)D
    //         on (A.zone_id=D.id)
    //         where A.type_id='".$type_id  ."' group by zone";
    $sql = "select * from zone_master where type_id='".$type_id  ."'";
    $query=$this->db->query($sql);
    return $query->result();
}

  function get_area($type_id, $zone_id){
    // $sql = "Select  A.*,D.area from 
    //         (select * from sr_mapping) A 
    //         left join 
    //         (select * from area_master)D
    //         on (A.area_id=D.id)
    //         where A.type_id='".$zone_id  ."' group by area";
    $sql = "select * from area_master where type_id='".$type_id  ."' and zone_id = '".$zone_id."'";
    $query=$this->db->query($sql);
    return $query->result();
}



  // function get_location($area_id1,){
    // $sql = "Select  A.*,D.location from 
            // (select * from store_master) A 
            // left join 
            // (select * from location_master)D
            // on (A.location_id=D.id)
            // where A.store_id='".$area_id1  ."'";
    // $query=$this->db->query($sql);
    // return $query->result();
// }

function get_store($zone_id){
    $sql = "Select distinct E.store_id, E.store_name from 
            (Select A.*,D.store_name from 
            (select * from store_master) A 
            left join 
            (select * from relationship_master) D 
            on (A.store_id=D.id)) E 
            left join 
            (select * from zone_master) F 
            on (E.zone_id=F.id) 
            where F.id='". $zone_id ."'";
    $query=$this->db->query($sql);
    return $query->result();
}
  
  // function get_area_normal($zone_id){
    // $sql = "select * from area_master";
    // $query=$this->db->query($sql);
    // return $query->result();
// }
  
  
  function check_mapping_availablity()
{
	
	 $id=$this->input->post('id');
	 $zone_id=$this->input->post('zone_id');
	 $type_id=$this->input->post('type_id'); 
	 $area_id=$this->input->post('area_id');
	 $area_id1=$this->input->post('area_id1');
	 $location_id=$this->input->post('location_id');
	 if(($type_id=="4")||($type_id=="7"))
	 {
		 $query=$this->db->query("SELECT * FROM sr_mapping WHERE id!='".$id."' and type_id='".$type_id."' and zone_id='".$zone_id."' and area_id1='".$area_id1."' and location_id='".$location_id."'");
		$result=$query->result();

		if (count($result)>0){
			return 1;
		} else {
			return 0;
		}
		  
	 }
	else
	{
		$query=$this->db->query("SELECT * FROM sr_mapping WHERE id!='".$id."' and type_id='".$type_id."' and zone_id='".$zone_id."' and area_id='".$area_id."' and location_id='".$location_id."'");
		$result=$query->result();

		if (count($result)>0){
			return 1;
		} else {
			return 0;
		}
	}
	// $id='0';
	 // $zone_id='5';
	 // $type_id= '7';
	 // $location_id='13';
	 // $area_id='1';


		  
		
}
  
  
  
function check_date_of_visit(){
    $id=$this->input->post('id');
    $date_of_visit = formatdate($this->input->post('date_of_visit'));
    $sales_rep_id=$this->session->userdata('sales_rep_id');

    // $id='2';
    // $date_of_visit = '2017-02-10';
    // $sales_rep_id='1';

    $sql="select * from sales_rep_area where date_of_visit = '$date_of_visit' and sales_rep_id = '$sales_rep_id' and id<>'$id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>