<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Merchandiser_beat_plan_model Extends CI_Model{

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

      $sql = "Select frequency,sales_rep_id from merchandiser_beat_plan $cond";
      $result=$this->db->query($sql)->result_array();

      if(count($result)>0)
      {
            $frequency = $result[0]['frequency'];
            $sales_rep_id = $result[0]['sales_rep_id'];
            $sql = "Select sequence from merchandiser_detailed_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id";
            $result=$this->db->query($sql)->result_array();

            if(count($result)>0)
            {
                $sql = "Select sequence from merchandiser_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id";
                $result2=$this->db->query($sql)->result_array();
                if($result==$result2)
                {
                    $table_name = 'select * ,id as bit_plan_id from  merchandiser_beat_plan '.$cond;;
                }
                else
                {   
                    $cond1 = '';
                    if($id!=""){
                         $cond1=" where bit_plan_id='".$id."'";
                    }
                    $table_name = 'select * from merchandiser_detailed_beat_plan'.$cond1;
                }
            }
            else
              {
                 $table_name = 'select *,id as bit_plan_id  from merchandiser_beat_plan'.$cond;
              }

      }
      else
      {
         $table_name = 'select *,id as bit_plan_id  from merchandiser_beat_plan'.$cond;
      }

    //Group By with all fields need to be done
    $sql = "select Distinct K.*,K.store_name as distributor_name from(select I.*,J.zone from(select G.*,H.location from (select E.*,F.sales_rep_name from (select C.*, D.google_address,D.latitude,D.longitude from (select A.*, B.store_name from 
            (".$table_name.") A 
            left join 
            (SELECT * FROM relationship_master) B 
            on (A.store_id=B.id))C
			 left join 
            (SELECT * FROM store_master) D
            on (C.store_id=D.store_id))E
			 left join 
			(select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc )F 
            on (E.sales_rep_id=F.id))G
			left join
			(select * from location_master)H 
            on (G.location_id=H.id))I
			left join
			(select * from zone_master)J 
            on (I.zone_id=J.id))K
			where K.status='Approved' 
            order by frequency,K.sequence asc";
    $query=$this->db->query($sql);
    return $query->result();
}


function get_beatplan($status='', $id=''){
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

    $table_name = 'select *,id as bit_plan_id  from merchandiser_beat_plan'.$cond;

    //Group By with all fields need to be done
    $sql = "select Distinct K.*,K.store_name as distributor_name from(select I.*,J.zone from(select G.*,H.location from (select E.*,F.sales_rep_name from (select C.*, D.google_address,D.latitude,D.longitude from (select A.*, B.store_name from 
            (".$table_name.") A 
            left join 
            (SELECT * FROM relationship_master) B 
            on (A.store_id=B.id))C
             left join 
            (SELECT * FROM store_master) D
            on (C.store_id=D.store_id))E
             left join 
            (select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc )F 
            on (E.sales_rep_id=F.id))G
            left join
            (select * from location_master)H 
            on (G.location_id=H.id))I
            left join
            (select * from zone_master)J 
            on (I.zone_id=J.id))K
            where K.status='Approved' 
            order by frequency,created_on,K.sequence asc";
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
        'store_id' => $this->input->post('store_id'),
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

        $this->db->insert('Merchandiser_beat_plan',$data);
        $id=$this->db->insert_id();
        $action='Distributor Sale Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('Merchandiser_beat_plan',$data);
        $action='Distributor Sale Entry Modified.';
    }

  

    $logarray['table_id']=$id;
    $logarray['module_name']='Merchandiser_beat_plan';
    $logarray['cnt_name']='Merchandiser_beat_plan';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function get_distributor_details(){
    $sql = "SELECT * FROM relationship_master where type_id ='4' or type_id='7' order by store_name desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_sales_rep_details(){
    $sql = "select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc 
";
    $query=$this->db->query($sql);
    return $query->result();
}

public function change_sequence($ispermenant)
{      
     $ispermenant;
     if($ispermenant=='Yes')
        {
            $sales_rep_id = $this->input->post('sales_rep_id');
            $frequency = $this->input->post('frequency');
            $sql = "UPDATE admin_merchendizer_beat_plan m1 
                    INNER JOIN 
                    merchandiser_beat_plan m2 ON m1.store_id=m2.store_id 
                    SET m1.sequence = m2.sequence
                    Where m2.sales_rep_id=$sales_rep_id and m2.frequency='$frequency'
                   ";
            $result = $this->db->query($sql);      
        }
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