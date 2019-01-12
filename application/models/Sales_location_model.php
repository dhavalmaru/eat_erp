<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_location_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep_Location' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data1($status='', $id=''){
    $cond="";
    if($id!=""){
        if($cond=="") {
            $cond=" where m.id='".$id."' and m.dist_id=p.id";
        } else {
            $cond=$cond." and m.id='".$id."' and m.dist_id=p.id";
        }
    }

    $m_id=$this->session->userdata('sales_rep_id');
    if($m_id!=""){
        if($cond=="") {
            $cond=" where m.m_id='".$m_id."' and m.dist_id=p.id";
        } else {
            $cond=$cond." and m.m_id='".$m_id."' and m.dist_id=p.id";
        }
    }

    $sql = "select *,m.id as mid from merchandiser_stock m,promoter_stores p".$cond." order by m.created_date desc";
    $query=$this->db->query($sql);
    return $query->result();
}
function get_data($status='', $id='',$frequency=''){
	   $cond2="";
        if($status!=""){
            $cond=" Where status='".$status."'";
        } else {
            $cond="";
        }


        $sales_rep_id=$this->session->userdata('sales_rep_id');
        
        if($id!=""){
            $cond2=" Where bit_plan_id=$id ";
        }
        else
        {
            $cond2='';
        }

        $cons = " ";
    	if($frequency!=""){
            $cond=$cond." and frequency='$frequency'";
            $cons=" and frequency='$frequency'";
        }
	   
      $sql = "Select sequence from sales_rep_detailed_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id and date(date_of_visit)=date(now()) ";
      $result=$this->db->query($sql)->result_array();

      if(count($result)>0)
      {
            $sql = "Select sequence from sales_rep_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id ";
            $result2=$this->db->query($sql)->result_array();
            if($result==$result2)
            {
                $table_name = 'select * ,id as bit_plan_id from  sales_rep_beat_plan '.$cond.'and sales_rep_id='.$sales_rep_id;
            }
            else
            {
                $table_name = 'select * from  sales_rep_detailed_beat_plan '.$cond.' and  date(date_of_visit)=date(now())'.'and sales_rep_id='.$sales_rep_id;
            }
      }
      else
      {
             $table_name = 'select *, id as bit_plan_id  from sales_rep_beat_plan '.$cond.'and sales_rep_id='.$sales_rep_id;
      }
    //utf8mb4_unicode_ci
    // H.remarks,H.followup_date,H.distributor_type,H.location_id,H.area_id,H.zone_id
   $sql = "select G.*,H.date_of_visit,H.id as mid ,H.distributor_type,H.remarks,H.followup_date,H.distributor_type,H.location_id,H.area_id,H.zone_id  from (select E.*,F.sales_rep_name from(select C.* from (select A.*,B.distributor_name ,B.distributor_name as store_name ,B.google_address,B.latitude,B.longitude,B.gst_number,B.margin,B.doc_document,B.document_name from 
        (".$table_name.") A 
        left join 
        (Select Distinct C.* FROM(
            Select B.* from (
                Select concat('d_',A.id) as id , A.distributor_name ,A.google_address,A.latitude,A.longitude,'' as gst_number,'' as margin,'' as doc_document,' ' as document_name FROM
                (Select * from distributor_master )A
                LEFT JOIN sr_mapping B ON (A.area_id = B.area_id and A.zone_id = B.zone_id and  A.type_id = B.type_id) 
                Where A.status='approved' and A.class='normal'
            ) B
            Union 
            (
                Select concat('s_',A.id) as id , A.distributor_name ,'' as google_address,A.latitude,A.longitude,A.gst_number,A.margin,A.doc_document,A.document_name FROM
                (Select * from sales_rep_distributors )A
            )            
            ) C 
        ) B 
        on (A.store_id=B.id COLLATE utf8_unicode_ci))C)E
		 left join 
		(select * from sales_rep_master where sr_type='Sales Representative' order by sales_rep_name desc ) F 
        on (E.sales_rep_id=F.id))G
		left join
		(select * from sales_rep_location 
        Where date(date_of_visit)=date(now()) ".$cons.") H
		on(G.store_id=H.distributor_id)
        ".$cond2."
        order by G.sequence asc,G.modified_on Desc
        ";

    $query=$this->db->query($sql);
    return $query->result();
}

public function get_lat_long($store_id)
{
    $sql ="Select Distinct C.* FROM(
            Select B.* from (
                Select concat('d_',A.id) as id , A.distributor_name ,A.google_address,A.latitude,A.longitude,'' as gst_number,'' as margin,'' as doc_document,' ' as document_name FROM
                (Select * from distributor_master )A
                LEFT JOIN sr_mapping B ON (A.area_id = B.area_id and A.zone_id = B.zone_id and  A.type_id = B.type_id) 
                Where A.status='approved' and A.class='normal'
            ) B
            Union 
            (
                Select concat('s_',A.id) as id , A.distributor_name ,'' as google_address,A.latitude,A.longitude,A.gst_number,A.margin,A.doc_document,A.document_name FROM
                (Select * from sales_rep_distributors )A
            )            
            ) C Where id='$store_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_dist_list() {
    $sql = "select id,store_name from promoter_stores";
            
    $query=$this->db->query($sql);
    return $query->result();
}

function get_merchandiser_stock_details($id){
    $sql = "select * from merchandiser_stock_details where merchandiser_stock_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

 function get_merchandiser_stock_images($id){
    $query=$this->db->query("SELECT * FROM merchandiser_images WHERE merchandiser_stock_id = '$id'");
    return $query->result();
 }


function save_data($id='',$status=''){
   
    $now=date('Y-m-d H:i:s');
    $now1=date('Y-m-d');
    $curusr=$this->session->userdata('session_id');
    //$sales_rep_id=$this->session->userdata('sales_rep_id');
    $date_of_visit=$this->input->post('date_of_visit');
    $sales_rep_id=$this->session->userdata('sales_rep_id');
    $sequence=$this->input->post('sequence');
    $frequency=$this->input->post('frequency');
    $merchendiser_beat_plan_id=$this->input->post('beat_plan_id');
    $ispermenant  = $this->input->post('ispermenant');
    $place_order  = $this->input->post('place_order');


    if($date_of_visit==''){
        $date_of_visit=NULL;
    } else {
        $date_of_visit=formatdate($date_of_visit);
    }
     $followup_date=$this->input->post('followup_date');

    if($followup_date==''){
        $followup_date=NULL;
    } else {
        $followup_date=formatdate($followup_date);
    }

    $mid = $this->input->post('mid');


    $data1 = array(
        'orange_bar' => (($this->input->post('orange_bar')=='')?'0':$this->input->post('orange_bar')),
        'mint_bar' => (($this->input->post('mint_bar')=='')?'0':$this->input->post('mint_bar')),
        'butterscotch_bar' => (($this->input->post('butterscotch_bar')=='')?'0':$this->input->post('butterscotch_bar')),
        'chocopeanut_bar' => (($this->input->post('chocopeanut_bar')=='')?'0':$this->input->post('chocopeanut_bar')),
        'bambaiyachaat_bar' => (($this->input->post('bambaiyachaat_bar')=='')?'0':$this->input->post('bambaiyachaat_bar')),
        'mangoginger_bar' => (($this->input->post('mangoginger_bar')=='')?'0':$this->input->post('mangoginger_bar')),
         'chyawanprash_bar' => (($this->input->post('chyawanprash_bar')=='')?'0':$this->input->post('chyawanprash_bar')),
        'berry_blast_bar' => (($this->input->post('berry_blast_bar')=='')?'0':$this->input->post('berry_blast_bar'))
    );

    $sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and is_edit='edit' and frequency='$frequency'";
    $get_maxcount = $this->db->query($sql)->result_array();
    $visited_sequence = $get_maxcount[0]['sequence']+1;


    $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and date(date_of_visit)=date(now()) and frequency='$frequency'";
    $detailed_result = $this->db->query($sql)->result_array(); 

    if($this->input->post('distributor_type')=='New'){
        
        if($status=='Place Order' && $place_order=='Yes')
        {
            $state = 'Approved';
        }
        else
        {
            $state = 'Inactive';
        }

         $data_dist = array(
                'sales_rep_id' => $sales_rep_id,
                'distributor_name' => $this->input->post('distributor_name'),
                /*'margin' => $this->input->post('margin'),
                'doc_document' => $this->input->post('doc_document'),
                'document_name' => $this->input->post('document_name'),
                'remarks' => $this->input->post('remarks'),*/
                'modified_by' => $curusr,
                'modified_on' => $now,
                /*'gst_number' => $this->input->post('gst_number'),*/
                'location_id' => $this->input->post('location_id'),
                'zone_id' => $this->input->post('zone_id'),
                'area_id' => $this->input->post('area_id'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'status'=>$state
            );

        if($mid!="")
        {   
            $store_id = explode('_',$this->input->post('store_id'));
           
            $insertid = $store_id[1];
            $this->db->where('id', $store_id[1]);
            $this->db->update('sales_rep_distributors',$data_dist);

            $data = array(
                'sales_rep_id' => $sales_rep_id,
                'date_of_visit' => $now1,
                'distributor_type' => $this->input->post('distributor_type'),
                'distributor_id' => $this->input->post('store_id'),
                'distributor_name' => $this->input->post('distributor_name'),
                'distributor_status' => $status,
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'remarks' => $this->input->post('remarks'),
                'modified_by' => $curusr,
                'modified_on' => $now,
                'followup_date' => $followup_date,
                'zone_id' => $this->input->post('zone_id'),
                'area_id' => $this->input->post('area_id'),
                'location_id' => $this->input->post('location_id'),
                'frequency'=>$frequency
            );

            $this->db->where('id', $mid);
            $this->db->update('sales_rep_location',$data);
            $action='Sales Rep Location Modified.';

            $where2 = array('store_id'=>$this->input->post('store_id'),'date(date_of_visit)'=>$now1,'sales_rep_id'=>$sales_rep_id,'frequency'=>$frequency);
            $result = $this->db->select('*')->where($where2)->get('sales_rep_detailed_beat_plan')->result_array(); 
           
            $detailed_id = $result[0]['id'];
            $detailed_sequence= $result[0]['sequence'];
            $bit_plan_id = $result[0]['bit_plan_id'];  
            /*$store_id = $this->input->post('store_id') ;*/


            
           if($status=='Follow Up' || ($status=='Place Order' && $place_order=='Yes'))
            {
                /* if data is edited and clicked on place order and store id is not  present in sales_rep_beat_plan */

                $sales_rep_beat_where =  array(
                    'store_id'=>$this->input->post('store_id'),
                    'sales_rep_id'=>$sales_rep_id,
                    'frequency'=>$frequency);
                $get_data_result = $this->db->select("*")->where($sales_rep_beat_where)->get('sales_rep_beat_plan')->result();

                $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence>$detailed_sequence";
                $result = $this->db->query($sql)->result_array();

                    $this->db->last_query();

                    for ($j=0; $j < count($result); $j++) 
                        {
                            $newsequence = $result[$j]['sequence']+1;
                            $new_id = $result[$j]['id'];
                            $data1 = array('sequence'=>$newsequence,
                                            'modified_on'=>$now);
                            $this->db->where('id', $new_id);
                            $this->db->update('sales_rep_beat_plan',$data1);
                            $this->db->last_query();
                        }
                    if(count($get_data_result)==0)
                    {
                        $after_temp_data1 = array('sales_rep_id'=>$sales_rep_id,
                                                   'sequence'=>$detailed_sequence,
                                                   'frequency'=>$frequency,
                                                   'modified_on'=>$now,
                                                   'store_id'=>$this->input->post('store_id'),
                                                   'status'=>'Approved',
                                                   'created_by'=>$curusr,
                                                   'modified_by' => $curusr,
                                                   'location_id' => $this->input->post('location_id'),
                                                    'zone_id' => $this->input->post('zone_id'),
                                                   'area_id' => $this->input->post('area_id'),
                                                   'created_on'=>$now);
                        $this->db->insert('sales_rep_beat_plan',$after_temp_data1);
                        $lastinsertid=$this->db->insert_id();             

                        if($lastinsertid)
                        {

                             if($bit_plan_id==0)
                             {
                                $data1 = array('bit_plan_id'=>$lastinsertid,'modified_on'=>$now);
                                $this->db->where('id', $detailed_id);
                                $this->db->update('sales_rep_detailed_beat_plan',$data1);
                                $this->db->last_query();
                             }
                        
                        }        
                    }        
                      
            }
        }
        else
        {
            $this->db->insert('sales_rep_distributors',$data_dist);
            $insertid=$this->db->insert_id();

            $data = array(
                'sales_rep_id' => $sales_rep_id,
                'date_of_visit' => $now1,
                'distributor_type' => $this->input->post('distributor_type'),
                'distributor_id' => 's_'.$insertid,
                'distributor_name' => $this->input->post('distributor_name'),
                'distributor_status' => $status,
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'status' => 'Approved',
                'remarks' => $this->input->post('remarks'),
                'modified_by' => $curusr,
                'modified_on' => $now,
                'followup_date' => $followup_date,
                'zone_id' => $this->input->post('zone_id'),
                'area_id' => $this->input->post('area_id'),
                'location_id' => $this->input->post('location_id'),
                'frequency'=>$frequency
            );

            $data['created_by']=$curusr;
            $data['created_on']=$now;



            $action='Sales Rep Distributor Created.';
            $store_id = $insertid;    
            if($status=='Follow Up' || ($status=='Place Order' && $place_order=='Yes'))
            {       
                $place_order = 'Yes';
                if($insertid)
                { 
                    $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence>=$visited_sequence";
                        $result = $this->db->query($sql)->result_array();
                          $this->db->last_query();
                          for ($j=0; $j < count($result); $j++) 
                          {   
                            $newsequence = $result[$j]['sequence']+1;
                            $new_id = $result[$j]['id'];
                            $data1 = array('sequence'=>$newsequence,
                                            'modified_on'=>$now);
                            $this->db->where('id', $new_id);
                            $this->db->update('sales_rep_beat_plan',$data1);
                            $this->db->last_query();
                          }

                     $sql = "Select count(*) as sequence from sales_rep_beat_plan WHERE frequency='$frequency' and sales_rep_id=$sales_rep_id";
                    $get_maxcount_sales_rep = $this->db->query($sql)->result_array();
                    $visited_sequence_sales_re = $get_maxcount_sales_rep[0]['sequence']+1;
                    $data1 = array('sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$visited_sequence_sales_re,
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'store_id'=>'s_'.$insertid,
                                  'status'=>'Approved',
                                  'created_by'=>$curusr,
                                  'modified_by' => $curusr,
                                  'created_on'=>$now);
                    $this->db->insert('sales_rep_beat_plan',$data1);
                    $lastinsertid=$this->db->insert_id();
                    if($lastinsertid)
                    {
                        
                        if($visited_sequence==1)
                        {
                            $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                            
                            for ($j=0; $j < count($result); $j++) 
                              {
                                $new_id = $result[$j]['id'];
                                $store_id = $result[$j]['store_id'];
                                $newsequence = $result[$j]['sequence']+1;
                                $data22 = array('date_of_visit'=> $now,
                                      'sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$newsequence,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'bit_plan_id'=>$new_id,
                                      'store_id'=>$store_id,
                                      'status'=>'Approved');
                                $this->db->insert('sales_rep_detailed_beat_plan',$data22);
                               
                              }
                        }
                        else
                        {
                            $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>=$visited_sequence";
                            $result = $this->db->query($sql)->result_array();
                              $this->db->last_query();
                              for ($j=0; $j < count($result); $j++) 
                              {   
                                $newsequence = $result[$j]['sequence']+1;
                                $new_id = $result[$j]['id'];
                                 $data1 = array('sequence'=>$newsequence,
                                                'modified_on'=>$now);
                                $this->db->where('id', $new_id);
                                $this->db->update('sales_rep_detailed_beat_plan',$data1);
                                $this->db->last_query();
                             }

                        }


                         $data2 = array('sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$visited_sequence,
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'store_id'=>'s_'.$store_id,
                                  'status'=>'Approved',
                                  'modified_on'=>$now,
                                  'date_of_visit' => $now);
                        $data2['bit_plan_id']=$lastinsertid;    
                        $data2['is_edit']='edit';
                        $this->db->insert('sales_rep_detailed_beat_plan',$data2);


                    }
                }
            }
            else
            {
                if(count($detailed_result)>0)
                {


                    $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>=$visited_sequence";
                    $result = $this->db->query($sql)->result_array();
                      $this->db->last_query();
                      for ($j=0; $j < count($result); $j++) 
                      {   
                        $newsequence = $result[$j]['sequence']+1;
                        $new_id = $result[$j]['id'];
                         $data1 = array('sequence'=>$newsequence,
                                        'modified_on'=>$now);
                        $this->db->where('id', $new_id);
                        $this->db->update('sales_rep_detailed_beat_plan',$data1);
                        $this->db->last_query();
                     }

                    $data2 = array('sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$visited_sequence,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'store_id'=>'s_'.$store_id,
                                      'status'=>'Approved',
                                      'modified_on'=>$now,
                                      'date_of_visit' => $now);
                    $data2['bit_plan_id']='';    
                    $data2['is_edit']='edit';
                    $this->db->insert('sales_rep_detailed_beat_plan',$data2);
                }
                else
                {
                     if($visited_sequence==1)
                        {
                            $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                            $result = $this->db->query($sql)->result_array();
                            for ($j=0; $j < count($result); $j++) 
                              {
                                $new_id = $result[$j]['id'];
                                $store_id = $result[$j]['store_id'];
                                $newsequence = $result[$j]['sequence']+1;
                                $data22 = array('date_of_visit'=> $now,
                                      'sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$newsequence,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'bit_plan_id'=>$new_id,
                                      'store_id'=>$store_id,
                                      'status'=>'Approved');
                                $this->db->insert('sales_rep_detailed_beat_plan',$data22);
                               
                              }
                        }

                        $data2 = array('sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$visited_sequence,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'store_id'=>'s_'.$insertid,
                                      'status'=>'Approved',
                                      'modified_on'=>$now,
                                      'date_of_visit' => $now);
                        $data2['bit_plan_id']='';    
                        $data2['is_edit']='edit';
                        $this->db->insert('sales_rep_detailed_beat_plan',$data2);
                }
            }

            $this->db->insert('sales_rep_location',$data);
            $id=$this->db->insert_id();
        }

        if(isset($_FILES['doc_file']['name'])) {
                $filePath='uploads/Sales_Rep_Distributors/';
                $upload_path = './' . $filePath;
                if(!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $filePath='uploads/Sales_Rep_Distributors/Distributor_'.$insertid.'/';
                $upload_path = './' . $filePath;
                if(!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $filePath='uploads/Sales_Rep_Distributors/Distributor_'.$insertid.'/documents/';
                $upload_path = './' . $filePath;
                if(!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $confi['upload_path']=$upload_path;
                $confi['allowed_types']='*';
                $this->load->library('upload', $confi);
                $this->upload->initialize($confi);
                $extension="";

                $file_nm='doc_file';

                 $_FILES[$file_nm]['name'];
                if(!empty($_FILES[$file_nm]['name'])) {
                    if($this->upload->do_upload($file_nm)) {
                        echo "Uploaded <br>";
                    } else {
                        echo "Failed<br>";
                        echo $this->upload->data();
                    }   

                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    $extension=$upload_data['file_ext'];
                        
                    $data = array(
                        'doc_document' => $filePath.$fileName,
                        'document_name' => $fileName
                    );

                    $this->db->where('id', $insertid);
                    $this->db->update('sales_rep_distributors',$data);
                }
            }

        
        /*$action='Sales Rep Location Created.';
        $data1['sales_rep_loc_id']=$id;
        $this->db->insert('sales_rep_distributor_opening_stock',$data1);*/


    } else {

        //$this->input->post('distributor_id')    
        $data = array(
        'sales_rep_id' => $sales_rep_id,
        'date_of_visit' => $now1,
        'distributor_type' => $this->input->post('distributor_type'),
        'distributor_id' => $this->input->post('store_id'),
        'distributor_name' => $this->input->post('distributor_name'),
        'distributor_status' => $status,
        'latitude' => $this->input->post('latitude'),
        'longitude' => $this->input->post('longitude'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'followup_date' => $followup_date,
        'zone_id' => $this->input->post('zone_id'),
        'area_id' => $this->input->post('area_id'),
        'location_id' => $this->input->post('location_id'),
        'frequency'=>$frequency
        );

        $data_dist = array(
            'sales_rep_id' => $sales_rep_id,
            'distributor_name' => $this->input->post('distributor_name'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'status' => $status,
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'zone_id' => $this->input->post('zone_id'),
            'area_id' => $this->input->post('area_id'),
            'location_id' => $this->input->post('location_id'),
            'status'=>'Approved'
        );
        "Entered IN else Condition";
        if($mid!="")
        {
            $this->db->where('id', $mid);
            $this->db->update('sales_rep_location',$data);
            $action='Sales Rep Location Modified.';
            $this->db->where('sales_rep_loc_id', $mid);
            $this->db->update('sales_rep_distributor_opening_stock',$data1);

        }
        else
        {
            $this->db->insert('sales_rep_location',$data);
            $id=$this->db->insert_id();
            $action='Sales Rep Location Created.';

            $data1['sales_rep_loc_id']=$id;
            $this->db->insert('sales_rep_distributor_opening_stock',$data1);

            if(count($detailed_result)>0)
            {
                 $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) ";
                 $result = $this->db->query($sql)->result_array();
                 $this->db->last_query();
                 for ($j=0; $j < count($result); $j++) 
                  {  
                    $result[$j]['sequence'];
                    $sequence;
                    if($result[$j]['sequence']<$sequence && $result[$j]['is_edit']!='edit')
                    {
                        $newsequence = $result[$j]['sequence']+1;
                        $new_id = $result[$j]['id'];
                         $data = array('sequence'=>$newsequence,
                                        'modified_on'=>$now);
                        $this->db->where('id', $new_id);
                        $this->db->update('sales_rep_detailed_beat_plan',$data);
                        $this->db->last_query();
                    }
                  }


                 $data = array('sequence'=>$visited_sequence,
                             'date_of_visit'=> $now,
                             'modified_on'=>$now,
                             'is_edit'=>'edit');

                 $where = array('bit_plan_id'=>$merchendiser_beat_plan_id,
                                'date(date_of_visit)'=>$now1);

                 $this->db->where($where);
                 $this->db->update('sales_rep_detailed_beat_plan',$data);
                 $this->db->last_query();
            }
            else
            {
               $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
               $result = $this->db->query($sql)->result_array();
                    

               for ($j=0; $j < count($result); $j++) 
                      { 
                        if($result[$j]['sequence']<$sequence)
                        {
                            $new_id = $result[$j]['id'];
                            $store_id = $result[$j]['store_id'];
                            $newsequence = $result[$j]['sequence']+1;
                            $data = array('date_of_visit'=> $now,
                                  'sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$newsequence,
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'bit_plan_id'=>$new_id,
                                  'store_id'=>$store_id,
                                  'status'=>'Approved');
                            $this->db->insert('sales_rep_detailed_beat_plan',$data);
                            $this->db->last_query();
                        }
                        else if($result[$j]['sequence']>$sequence)
                        {
                            $new_id = $result[$j]['id'];
                            $store_id = $result[$j]['store_id'];
                            $newsequence = $result[$j]['sequence'];
                            $data = array('date_of_visit'=> $now,
                                  'sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$newsequence,
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'bit_plan_id'=>$new_id,
                                  'store_id'=>$store_id,
                                  'status'=>'Approved');
                            $this->db->insert('sales_rep_detailed_beat_plan',$data);
                            $this->db->last_query();
                        }
                       
                      }


               $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence=$sequence ";

              
                $result = $this->db->query($sql)->result_array();
                $data = array('date_of_visit'=> $now,
                              'sales_rep_id'=>$sales_rep_id,
                              'sequence'=>$visited_sequence,
                              'is_edit'=>'edit',
                              'frequency'=>$frequency,
                              'modified_on'=>$now,
                              'bit_plan_id'=>$result[0]['id'],
                              'store_id'=>$result[0]['store_id'],
                              'status'=>'Approved');
                $this->db->insert('sales_rep_detailed_beat_plan',$data);
                $this->db->last_query();
            }

            if($ispermenant=='Yes' || $place_order=='Yes')
            {
                
                $count_spdb_sql = "select count(*) as count from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0 and date(date_of_visit)=date(now())";
                $result_spdb_count = $this->db->query($count_spdb_sql)->result_array();

                if($result_spdb_count[0]['count']>0)
                {
                    $count = $result_spdb_count[0]['count'];
                    $sequence_spdb_sql = "select sequence,id from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0  order by id asc Limit 0,1";
                    $sequence_result = $this->db->query($sequence_spdb_sql)->result_array();
                    $sequence_spdb = $sequence_result[0]['sequence'];  

                    $condition  = "Case When m2.sequence>=$sequence_spdb Then (m2.sequence-$count) Else  m2.sequence end ";
                }
                else
                {
                    $condition = "m2.sequence";    
                }

                $sql = "UPDATE sales_rep_beat_plan m1
                        INNER JOIN sales_rep_detailed_beat_plan m2 ON 
                        m1.id=m2.bit_plan_id
                        SET m1.sequence=$condition
                        Where m1.sales_rep_id=$sales_rep_id 
                        and m1.frequency='$frequency' and bit_plan_id<>0
                        and date(m2.date_of_visit)=date(now())";
                    $result = $this->db->query($sql);      
                

                $this->db->last_query();      
            }
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_Rep_Location';
    $logarray['cnt_name']='Sales_Rep_Location';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}




function get_location(){
    // $from_date='2017-05-20';
    // $to_date='2017-05-25';

    $from_date=formatdate($this->input->post('from_date'));
    $to_date=formatdate($this->input->post('to_date'));

    $sql = "select A.*, B.sales_rep_name, C.store_name, D.modified_on as logout_time, D.latitude as logout_latitude, 
            D.longitude as logout_longitude from promoter_location A 
            left join sales_rep_master B on (A.sales_rep_id = B.id) 
            left join promoter_stores C on (A.distributor_id = C.id) 
            left join promoter_checkout D on (A.id = D.promoter_location_id) 
            where A.date_of_visit >= '$from_date' and A.date_of_visit <= '$to_date'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_closing_stock(){
    $distributor_id = $this->input->post('distributor_id');
    $date_of_visit = formatdate($this->input->post('date_of_visit'));

    // $distributor_id = 'd_240';
    // $date_of_visit = formatdate('10/11/2017');

    $sql = "select * from sales_rep_distributor_opening_stock where sales_rep_loc_id = (select max(id) from sales_rep_location 
            where status = 'Approved' and distributor_id = '$distributor_id' and 
            date_of_visit = (select max(date_of_visit) from sales_rep_location where status = 'Approved' and 
                                distributor_id = '$distributor_id' and date_of_visit<'$date_of_visit'))";
    $query=$this->db->query($sql);
    return $query->result();
}

}
?>