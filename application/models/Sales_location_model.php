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

function get_data($status='', $id='',$frequency='',$temp_date=''){
	   /* $cond2="";
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
        }*/

    	/*if($frequency!=""){
            $cond=$cond." and CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
            OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
            THEN frequency = CONCAT('Every ',DAYNAME(date(now()))) 
            WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2) 
            THEN frequency = CONCAT('Alternate ',DAYNAME(date(now()))) 
            WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4) 
            THEN frequency = CONCAT('Alternate2 ',DAYNAME(date(now()))) end ";
            $cons=" and CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
            OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
            THEN frequency = CONCAT('Every ',DAYNAME(date(now()))) 
            WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2) 
            THEN frequency = CONCAT('Alternate ',DAYNAME(date(now()))) 
            WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4) 
            THEN frequency = CONCAT('Alternate2 ',DAYNAME(date(now()))) end  ";
        }*/
	   
     /*$sql = "Select sequence from sales_rep_detailed_beat_plan Where  sales_rep_id=$sales_rep_id 
            and CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
            OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
            THEN frequency = CONCAT('Every ',DAYNAME(date(now()))) 
            WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2) 
            THEN frequency = CONCAT('Alternate ',DAYNAME(date(now()))) 
            WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4) 
            THEN frequency = CONCAT('Alternate2 ',DAYNAME(date(now()))) end and date(date_of_visit)=date(now()) ";
      $result=$this->db->query($sql)->result_array();*/

      /*if(count($result)>0)
      {
            $sql = "Select sequence from sales_rep_beat_plan Where  CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
            OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
            THEN frequency = CONCAT('Every ',DAYNAME(date(now()))) 
            WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2) 
            THEN frequency = CONCAT('Alternate ',DAYNAME(date(now()))) 
            WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4) 
            THEN frequency = CONCAT('Alternate2 ',DAYNAME(date(now()))) end and sales_rep_id=$sales_rep_id ";
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
      }*/
        //utf8mb4_unicode_ci
        // H.remarks,H.followup_date,H.distributor_type,H.location_id,H.area_id,H.zone_id
        //Case When H.distributor_type IS NULL Then 'Old' else 'New' end as distributor_type
     $cond = '';  
     $cond2 = '';
     
    if($status!="")
    {
        $cond=" Where status='".$status."'";
    } else {
        $cond="";
    }

     $sales_rep_id=$this->session->userdata('sales_rep_id'); 
        if($id!="")
        {
            $cond2=" Where G.id=$id ";
        }
        else
        {
            $cond2='';
        }

  
  if($temp_date!='')
  {
    $temp_date = date("Y-m-d",strtotime($temp_date));
    $temp_date = '"'.$temp_date.'"';
  }
  else
  {
    $temp_date = '"'.date("Y-m-d").'"';
  }

     $sql = "Select sequence from sales_rep_detailed_beat_plan Where  sales_rep_id=$sales_rep_id  and  date(date_of_visit)=$temp_date";
    $result=$this->db->query($sql)->result_array();

    if(count($result)>0)
    {
            /*$sql = "Select sequence from sales_rep_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id";
            $result2=$this->db->query($sql)->result_array();
            if($result==$result2)
            {
               
                if($frequency!=""){
                    $cond.=" and frequency='$frequency'";
                }
           
                $table_name = 'select * ,id as bit_plan_id from  sales_rep_beat_plan ';
            }
            else
            {   
                $frequency;
                if($frequency!=""){
                    $cond.=" and frequency='$frequency' and  date(date_of_visit)=date(now())";
                }
                $table_name = 'select * from  sales_rep_detailed_beat_plan ';
            }*/

            if($frequency!=""){
                $cond.=" and frequency='$frequency' and  date(date_of_visit)=$temp_date";
            }

            $table_name = 'select * ,id as bit_id from  sales_rep_detailed_beat_plan ';
    }
    else
    {

            if($frequency!=""){
                $cond.=" and frequency='$frequency' ";
            }
             $table_name = 'select *,id as bit_plan_id ,id as bit_id  from sales_rep_beat_plan ';
    }



   $sql = "select distinct G.*,H.date_of_visit,H.id as mid ,H.distributor_type,H.remarks,H.followup_date,H.distributor_type  from (select E.*,F.sales_rep_name from(select C.* from (select A.*,B.distributor_name ,B.distributor_name as store_name ,B.google_address,B.latitude,B.longitude,B.gst_number,B.margin,B.doc_document,B.document_name from 
            (".$table_name.$cond.' and sales_rep_id='.$sales_rep_id.") A 
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
            Where date(date_of_visit)=$temp_date and sales_rep_id=$sales_rep_id ) H
            on(G.store_id=H.distributor_id and G.id=H.detailed_bit_plan_id)
            ".$cond2."
			group by H.date_of_visit,mid ,H.distributor_type,H.remarks,H.followup_date,H.distributor_type,G.store_id
            order by G.sequence asc,G.modified_on Desc
            ";

        $query=$this->db->query($sql);
        return $query->result();

        $query=$this->db->query($sql);
        return $query->result();
}

public function get_merchendiser_detail($status='', $id='',$frequency='')
{
    $cond2="";
    if($status!="")
    {
        $cond=" Where status='".$status."'";
    } else {
        $cond="";
    }


    $sales_rep_id=$this->session->userdata('sales_rep_id');
    
    if($id!="")
    {
        $cond2=" Where G.id=$id ";
    }
    else
    {
        $cond2='';
    }
    

    $sql = "Select sequence from merchandiser_detailed_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id  and  date(date_of_visit)=date(now())";
    $result=$this->db->query($sql)->result_array();

    if(count($result)>0)
    {
            /*$sql = "Select sequence from merchandiser_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id";
            $result2=$this->db->query($sql)->result_array();
            if($result==$result2)
            {
               
                if($frequency!=""){
                    $cond.=" and frequency='$frequency'";
                }
           
                $table_name = 'select * ,id as bit_plan_id from  merchandiser_beat_plan ';
            }
            else
            {   
                $frequency;
                if($frequency!=""){
                    $cond.=" and frequency='$frequency' and  date(date_of_visit)=date(now())";
                }
                $table_name = 'select * from  merchandiser_detailed_beat_plan ';
            }*/

            if($frequency!=""){
                    $cond.=" and frequency='$frequency' and  date(date_of_visit)=date(now())";
                }
            $table_name = 'select * ,id as bit_id from  merchandiser_detailed_beat_plan ';

    }
    else
    {
            if($frequency!=""){
                $cond.=" and frequency='$frequency' ";
            }
             $table_name = 'select *,id as bit_plan_id ,id as bit_id from merchandiser_beat_plan ';
    }

    $sql = "select G.*,H.date_of_visit,H.dist_id,H.id as mid,H.location_id,B.location,'Old' as distributor_type  from (select E.*,F.sales_rep_name from(select C.*, D.google_address,D.latitude,D.longitude from (select A.*,B.store_name from 
            (".$table_name.$cond.' and sales_rep_id='.$sales_rep_id.") A 
    left join 
    (SELECT * FROM relationship_master where type_id ='4' or type_id='7') B 
    on (A.store_id=B.id))C
    left join 
    (select * from store_master) D 
    on (C.zone_id=D.zone_id and C.store_id=D.store_id and C.location_id=D.location_id))E
     left join 
    (select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc ) F 
    on (E.sales_rep_id=F.id))G
    left join
    (select * from merchandiser_stock 
    Where date(date_of_visit)=date(now())) H
    on(G.store_id=H.dist_id and G.location_id=H.location_id and G.zone_id=H.zone_id)
    left join
        (select * from location_master) B 
    on (G.location_id=B.id)
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

    $sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id=$sales_rep_id and is_edit='edit' and frequency='$frequency'";
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

               $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence>=$detailed_sequence";
                $result = $this->db->query($sql)->result_array();

                $this->db->last_query();

             
                if(count($get_data_result)==0)
                {   
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
                        if (strpos($frequency, 'Every') !== false) {

                            $explode_frequency = explode(' ',$frequency);
                            /*$new_frequency = 'Alternate '.$explode_frequency[1];*/
                            $selectfre = "SELECT (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                            $frequency_result = $this->db->query($selectfre)->result();

                            $frequency_result = $frequency_result[0]->daymonth;
                            if($frequency_result==2)
                            {
                               $new_frequency = 'Alternate '.$explode_frequency[1]; 
                            }
                            else
                            {
                                $new_frequency = 'Alternate2 '.$explode_frequency[1];
                            }
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();;

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$this->input->post('store_id'),
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id' => $this->input->post('location_id'),
                                                'zone_id' => $this->input->post('zone_id'),
                                               'area_id' => $this->input->post('area_id'),
                                               'created_on'=>$now);
                            $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                        }
                        
                        if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {

                            $explode_frequency = explode(' ',$frequency);
                            $new_frequency = 'Every '.$explode_frequency[1];
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$this->input->post('store_id'),
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id' => $this->input->post('location_id'),
                                                'zone_id' => $this->input->post('zone_id'),
                                               'area_id' => $this->input->post('area_id'),
                                               'created_on'=>$now);
                        $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                        }

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
                    if($get_maxcount_sales_rep==0)
                    {
                        $visited_sequence_sales_re = $get_maxcount_sales_rep[0]['sequence']+1;
                        $data1 = array('sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$visited_sequence_sales_re,
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'store_id'=>'s_'.$store_id,
                                  'status'=>'Approved',
                                  'created_by'=>$curusr,
                                  'modified_by' => $curusr,
                                  'location_id' => $this->input->post('location_id'),
                                  'zone_id' => $this->input->post('zone_id'),
                                  'area_id' => $this->input->post('area_id'),
                                  'created_on'=>$now);
                        $this->db->insert('sales_rep_beat_plan',$data1);
                        $lastinsertid=$this->db->insert_id();
                    }
                    else{
                        $data1 = array('sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$visited_sequence,
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'store_id'=>'s_'.$insertid,
                                  'status'=>'Approved',
                                  'created_by'=>$curusr,
                                  'modified_by' => $curusr,
                                  'location_id' => $this->input->post('location_id'),
                                  'zone_id' => $this->input->post('zone_id'),
                                  'area_id' => $this->input->post('area_id'),
                                  'created_on'=>$now);
                        $this->db->insert('sales_rep_beat_plan',$data1);
                        $lastinsertid=$this->db->insert_id();
                    }
                    
                   
                    if($lastinsertid)
                    {
                        if (strpos($frequency, 'Every') !== false) {

                            $explode_frequency = explode(' ',$frequency);
                            /*$new_frequency = 'Alternate '.$explode_frequency[1];*/
                            $selectfre = "SELECT (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                            $frequency_result = $this->db->query($selectfre)->result();
                            $frequency_result = $frequency_result[0]->daymonth;
                            if($frequency_result==2)
                            {
                               $new_frequency = 'Alternate '.$explode_frequency[1]; 
                            }
                            else
                            {
                                $new_frequency = 'Alternate2 '.$explode_frequency[1];
                            }

                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array(
                                           'sales_rep_id'=>$sales_rep_id,
                                           'sequence'=>$max_sequnece,
                                           'frequency'=>$new_frequency,
                                           'modified_on'=>$now,
                                           'store_id'=>'s_'.$insertid,
                                           'status'=>'Approved',
                                           'created_by'=>$curusr,
                                           'modified_by' => $curusr,
                                           'location_id' => $this->input->post('location_id'),
                                            'zone_id' => $this->input->post('zone_id'),
                                           'area_id' => $this->input->post('area_id'),
                                           'created_on'=>$now);
                            $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                        }
                        
                        if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {

                            $explode_frequency = explode(' ',$frequency);
                            $new_frequency = 'Every '.$explode_frequency[1];
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array(
                                           'sales_rep_id'=>$sales_rep_id,
                                           'sequence'=>$max_sequnece,
                                           'frequency'=>$new_frequency,
                                           'modified_on'=>$now,
                                           'store_id'=>'s_'.$insertid,
                                           'status'=>'Approved',
                                           'created_by'=>$curusr,
                                           'modified_by' => $curusr,
                                           'location_id' => $this->input->post('location_id'),
                                           'zone_id' => $this->input->post('zone_id'),
                                           'area_id' => $this->input->post('area_id'),
                                           'created_on'=>$now); 
                                 $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                        }
                        
                        if($visited_sequence==1)
                        {
                            $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                            
                            for ($j=0; $j < count($result); $j++) 
                              {
                                $new_id = $result[$j]['id'];
                                $store_id1 = $result[$j]['store_id'];
                                $newsequence = $result[$j]['sequence']+1;
                                $data22 = array('date_of_visit'=> $now,
                                      'sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$newsequence,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'bit_plan_id'=>$new_id,
                                      'store_id'=>$store_id1,
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
        'distributor_id' =>($this->input->post('store_id')==''?$this->input->post('distributor_id'):$this->input->post('store_id')),
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

               $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence>=$detailed_sequence";
                $result = $this->db->query($sql)->result_array();

                $this->db->last_query();
                
                if(count($get_data_result)==0)
                {
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

                    $store_id = $this->input->post('store_id');
                    $sql_get_detail = "SELECT * from 
                                    ( 
                                        Select * from (
                                                Select concat('d_',A.id) as id , A.distributor_name ,A.area_id,A.zone_id,A.location_id FROM
                                                (Select * from distributor_master )A
                                                LEFT JOIN sr_mapping B ON (A.area_id = B.area_id and A.zone_id = B.zone_id and  A.type_id = B.type_id) 
                                                Where A.status='approved' and A.class='normal'
                                        ) B
                                        Union 
                                        (
                                                Select concat('s_',A.id) as id , A.distributor_name ,A.area_id,A.zone_id,A.location_id FROM
                                                (Select * from sales_rep_distributors )A
                                        )
                                    ) A Where id='$store_id'";

                        $result_dist = $this->db->query($sql_get_detail)->result_array();

                    $after_temp_data1 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$detailed_sequence,
                                               'frequency'=>$frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$this->input->post('store_id'),
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id' => $result_dist[0]['location_id'],
                                                'zone_id' => $result_dist[0]['zone_id'],
                                               'area_id' => $result_dist[0]['area_id'],
                                               'created_on'=>$now);
                    $this->db->insert('sales_rep_beat_plan',$after_temp_data1);
                    $lastinsertid=$this->db->insert_id();             

                    if($lastinsertid)
                    {   
                        if (strpos($frequency, 'Every') !== false) {

                            $explode_frequency = explode(' ',$frequency);
                            $selectfre = "SELECT (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                            $frequency_result = $this->db->query($selectfre)->result();
                            $frequency_result = $frequency_result[0]->daymonth;
                            if($frequency_result==2)
                            {
                               $new_frequency = 'Alternate '.$explode_frequency[1]; 
                            }
                            else
                            {
                                $new_frequency = 'Alternate2 '.$explode_frequency[1];
                            }
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();;

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$this->input->post('store_id'),
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id' => $result_dist[0]['location_id'],
                                                'zone_id' => $result_dist[0]['zone_id'],
                                               'area_id' => $result_dist[0]['area_id'],
                                               'created_on'=>$now);
                        $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                        }
                        
                        if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {

                            $explode_frequency = explode(' ',$frequency);
                            $new_frequency = 'Every '.$explode_frequency[1];
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$this->input->post('store_id'),
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id' => $result_dist[0]['location_id'],
                                                'zone_id' => $result_dist[0]['zone_id'],
                                               'area_id' => $result_dist[0]['area_id'],
                                               'created_on'=>$now);
                        $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                        }

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
            $this->db->insert('sales_rep_location',$data);
            $id=$this->db->insert_id();
            $action='Sales Rep Location Created.';

            $data1['sales_rep_loc_id']=$id;
            $this->db->insert('sales_rep_distributor_opening_stock',$data1);

            if($this->input->post('store_id')=="")
            {
               $store_id = $this->input->post('distributor_id');


               if($status=='Follow Up' || ($status=='Place Order' && $place_order=='Yes'))
                  {
                        //if type is old then fetched  required detailed from distributer master 
                        $sql_get_detail = "SELECT * from 
                                    ( 
                                        Select * from (
                                                Select concat('d_',A.id) as id , A.distributor_name ,A.area_id,A.zone_id,A.location_id FROM
                                                (Select * from distributor_master )A
                                                LEFT JOIN sr_mapping B ON (A.area_id = B.area_id and A.zone_id = B.zone_id and  A.type_id = B.type_id) 
                                                Where A.status='approved' and A.class='normal'
                                        ) B
                                        Union 
                                        (
                                                Select concat('s_',A.id) as id , A.distributor_name ,A.area_id,A.zone_id,A.location_id FROM
                                                (Select * from sales_rep_distributors )A
                                        )
                                    ) A Where id='$store_id'";

                        $result_dist = $this->db->query($sql_get_detail)->result_array();


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
                        if(count($result_dist)>0)
                        {
                            $location_id = $result_dist[0]['location_id'];
                            $area_id = $result_dist[0]['area_id'];
                            $zone_id = $result_dist[0]['zone_id'];
                        }
                        else
                        {
                            $location_id = $this->input->post('location_id');
                            $area_id = $this->input->post('area_id');
                            $zone_id = $this->input->post('zone_id');
                        }

                        if($get_maxcount_sales_rep==0)
                        {
                            $visited_sequence_sales_re = $get_maxcount_sales_rep[0]['sequence']+1;


                            $data1 = array('sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$visited_sequence_sales_re,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'store_id'=>$store_id,
                                      'status'=>'Approved',
                                      'created_by'=>$curusr,
                                      'modified_by' => $curusr,
                                      'location_id' => $location_id,
                                      'zone_id' => $zone_id,
                                      'area_id' => $area_id,
                                      'created_on'=>$now);
                            $this->db->insert('sales_rep_beat_plan',$data1);
                            $lastinsertid=$this->db->insert_id();
                        }
                        else{
                            $data1 = array('sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$visited_sequence,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'store_id'=>$store_id,
                                      'status'=>'Approved',
                                      'created_by'=>$curusr,
                                      'modified_by' => $curusr,
                                      'location_id' => $location_id,
                                      'zone_id' => $zone_id,
                                      'area_id' => $area_id,
                                      'created_on'=>$now);
                            $this->db->insert('sales_rep_beat_plan',$data1);
                            $lastinsertid=$this->db->insert_id();
                        }


                        if($lastinsertid)
                        {
                            if (strpos($frequency, 'Every') !== false) {

                                $explode_frequency = explode(' ',$frequency);
                                $selectfre = "SELECT (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                                $frequency_result = $this->db->query($selectfre)->result();
                                $frequency_result = $frequency_result[0]->daymonth;
                                if($frequency_result==2)
                                {
                                   $new_frequency = 'Alternate '.$explode_frequency[1]; 
                                }
                                else
                                {
                                    $new_frequency = 'Alternate2 '.$explode_frequency[1];
                                }
                                $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                                $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                                $after_temp_data2 = array(
                                               'sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$store_id,
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id' => $area_id,
                                               'zone_id' => $zone_id,
                                               'area_id' => $area_id,
                                               'created_on'=>$now);

                                $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                            }
                            
                            if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {

                                $explode_frequency = explode(' ',$frequency);
                                $new_frequency = 'Every '.$explode_frequency[1];
                                $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                                $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                                $after_temp_data2 = array(
                                               'sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$store_id,
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id' => $this->input->post('location_id'),
                                               'zone_id' => $this->input->post('zone_id'),
                                               'area_id' => $this->input->post('area_id'),
                                               'created_on'=>$now); 
                                     $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                            }
                            
                            if($visited_sequence==1)
                            {
                                $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                                
                                for ($j=0; $j < count($result); $j++) 
                                  {
                                    $new_id = $result[$j]['id'];
                                    $store_id1 = $result[$j]['store_id'];
                                    $newsequence = $result[$j]['sequence']+1;
                                    $data22 = array('date_of_visit'=> $now,
                                          'sales_rep_id'=>$sales_rep_id,
                                          'sequence'=>$newsequence,
                                          'frequency'=>$frequency,
                                          'modified_on'=>$now,
                                          'bit_plan_id'=>$new_id,
                                          'store_id'=>$store_id1,
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
                                      'store_id'=>$store_id,
                                      'status'=>'Approved',
                                      'modified_on'=>$now,
                                      'date_of_visit' => $now);
                            $data2['bit_plan_id']=$lastinsertid;    
                            $data2['is_edit']='edit';
                            $this->db->insert('sales_rep_detailed_beat_plan',$data2);
                            echo $this->db->last_query();
                           

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
                                          'store_id'=>$store_id,
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
                                          'store_id'=>$store_id,
                                          'status'=>'Approved',
                                          'modified_on'=>$now,
                                          'date_of_visit' => $now);
                            $data2['bit_plan_id']='';    
                            $data2['is_edit']='edit';
                            $this->db->insert('sales_rep_detailed_beat_plan',$data2);
                    }
                }
            }
            else
            {
                if(count($detailed_result)>0)
                {
                     $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) ";
                     $result = $this->db->query($sql)->result_array();
                     $this->db->last_query();
                     for ($j=0; $j < count($result); $j++) 
                      {  
                        $result[$j]['sequence'];
                        echo '<br>sequence'.$sequence;
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
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_Rep_Location';
    $logarray['cnt_name']='Sales_Rep_Location';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

public function save_orders($value='')
{
    
}

function save_retailer_session(){
    $data = array(
        'margin' => $this->input->post('margin'),
        'retailer_remarks' => $this->input->post('remarks'),
        'gst_number' => $this->input->post('gst_number'),
        'master_distributor_id' => $this->input->post('distributor_id')
    );

    /*if(isset($_FILES['doc_file']['name'])) {
        $filePath='uploads/Sales_Rep_Distributors/temp';
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
        echo $_FILES['doc_file']['name'];
        if(!empty($_FILES[$file_nm]['name'])) {
            if($this->upload->do_upload($file_nm)) {
                // echo "Uploaded <br>";
            } 
            $upload_data=$this->upload->data();
            $data['file_name']= $file_nm;
        }
    }*/

    $this->session->set_userdata('retailer_detail', $data);
}

public function save_session()
{
	
    $channel_type  = $this->input->post('channel_type');
    $distributor_type  = $this->input->post('distributor_type');
    $distributor_name  = $this->input->post('distributor_name');
    $zone_id  = $this->input->post('zone_id');
    $area_id  = $this->input->post('area_id');
    $location_id  = $this->input->post('location_id');
    $longitude  = $this->input->post('longitude');
    $latitude  = $this->input->post('latitude');
    $remarks  = $this->input->post('remarks');
    $reation_id  = $this->input->post('reation_id');
    $distributor_id  = $this->input->post('distributor_id');
    $mid  = $this->input->post('mid');
    $beat_plan_id  = $this->input->post('beat_plan_id');
    $store_id  = $this->input->post('store_id');
    $distributor_status  = $this->input->post('distributor_status');
    $sales_rep_loc_id  = $this->input->post('sales_rep_loc_id');
    $sequence = $this->input->post('sequence');
    $follow_type = $this->input->post('follow_type');
    $merchandiser_stock_id  = $this->input->post('merchandiser_stock_id');

	//$this->session->sess_destroy();
	
	$this->session->unset_userdata('visit_detail');
	
    $newdata = array(
        'channel_type'  => $channel_type,
        'distributor_types'=> $distributor_type,
        'distributor_name' => $distributor_name,
        'zone_id' => $zone_id,
        'area_id' => $area_id,
        'location_id' => $location_id,
        'remarks' => trim($remarks),
        'longitude'=>$longitude,
        'latitude'=>$latitude,
        'distributor_id'=>$distributor_id,
        'mid'=>$mid,
        'reation_id'=>'',
        'beat_plan_id'=>$beat_plan_id,
        'store_id'=>$store_id,
        'distributor_status'=>$distributor_status,
        'sales_rep_loc_id'=>$sales_rep_loc_id,
        'sequence'=>$sequence,
        'follow_type'=>$follow_type,
        'merchandiser_stock_id'=>$merchandiser_stock_id
    );
    
    $this->session->set_userdata('visit_detail', $newdata);

    $orange_bar = $this->input->post('orange_bar');
    $orange_box = $this->input->post('orange_box');
    $butterscotch_bar = $this->input->post('butterscotch_bar');
    $butterscotch_box = $this->input->post('butterscotch_box');
    $chocopeanut_bar = $this->input->post('chocopeanut_bar');
    $chocopeanut_box = $this->input->post('chocopeanut_box');
    $bambaiyachaat_bar = $this->input->post('bambaiyachaat_bar');
    $bambaiyachaat_box = $this->input->post('bambaiyachaat_box');
    $mangoginger_bar = $this->input->post('mangoginger_bar');
    $mangoginger_box = $this->input->post('mangoginger_box');
    $berry_blast_bar = $this->input->post('berry_blast_bar');
    $berry_blast_box = $this->input->post('berry_blast_box');
    $chyawanprash_bar = $this->input->post('chyawanprash_bar');
    $chyawanprash_box = $this->input->post('chyawanprash_box');
    $variety_box = $this->input->post('variety_box');
    $chocolate_cookies = $this->input->post('chocolate_cookies');
    $dark_chocolate_cookies = $this->input->post('dark_chocolate_cookies');
    $cranberry_cookies = $this->input->post('cranberry_cookies');
    $cranberry_orange = $this->input->post('cranberry_orange');
    $fig_raisins = $this->input->post('fig_raisins');
    $papaya_pineapple = $this->input->post('papaya_pineapple');
    $cranberry_orange_zest = $this->input->post('cranberry_orange_zest');
         
    $batch_array = array();
    $temp_array = array();

    if($channel_type=='GT')
    {
        if($chocolate_cookies!='')
        {

            $batch_array['chocolate_cookies_box']=$chocolate_cookies;
        }

        if($dark_chocolate_cookies!='')
        {
           $batch_array['dark_chocolate_cookies_box']=$dark_chocolate_cookies;
        }

        if($cranberry_cookies!='')
        {
            $batch_array['cranberry_cookies_box']=$cranberry_cookies;
        }

        if($cranberry_orange_zest!='')
        {
            $batch_array['cranberry_orange_box'] = $cranberry_orange_zest;
        }
        
        if($fig_raisins!='')
        {
            $batch_array['fig_raisins_box'] = $fig_raisins;
        }

        if($papaya_pineapple!='')
        {
            $batch_array['papaya_pineapple_box'] = $papaya_pineapple;
        }

        if($orange_bar!=null)
        {
             $batch_array['orange_bar'] = $orange_bar;
        }

        if($orange_box!=null)
        {
            $batch_array['orange_box'] = $orange_box;
        }

        if($butterscotch_bar!=null)
        {
            $batch_array['butterscotch_bar'] = $butterscotch_bar;
        }

        if($butterscotch_box!=null)
        {
            $batch_array['butterscotch_box'] = $butterscotch_box;
        }

        if($chocopeanut_bar!=null)
        {
            $batch_array['chocopeanut_bar'] = $chocopeanut_bar;
        }

        if($chocopeanut_box!=null)
        {
           $batch_array['chocopeanut_box'] = $chocopeanut_box;
        }

        if($bambaiyachaat_bar!=null)
        {
            $batch_array['bambaiyachaat_bar'] = $bambaiyachaat_bar;
        }

        if($bambaiyachaat_box!=null)
        {
            $batch_array['bambaiyachaat_box'] = $bambaiyachaat_box;
        }

        if($mangoginger_bar!=null)
        {
           $batch_array['mangoginger_bar'] = $mangoginger_bar;
        }

         if($mangoginger_box!=null)
        {
            $batch_array['mangoginger_box'] = $mangoginger_box;
        }

        if($berry_blast_bar!=null)
        {
            $batch_array['berry_blast_bar'] = $berry_blast_bar;
        }

        if($berry_blast_box!=null)
        {
            $batch_array['berry_blast_box'] = $berry_blast_box;
        }

        if($chyawanprash_bar!=null)
        {
           $batch_array['chyawanprash_bar'] = $chyawanprash_bar;
        }

        if($chyawanprash_box!=null)
        {
            $batch_array['chyawanprash_box'] = $chyawanprash_box;
        }

        if($variety_box!=null)
        {
            $batch_array['variety_box'] = $variety_box;
        }  
 
        if(count($batch_array)!='')
        {
           $this->session->set_userdata('sales_rep_stock_detail', $batch_array);
        }  
    }
    else
    {

            if($chocolate_cookies!='')
            {
                $item_id =37;
                $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$chocolate_cookies
                                );
                $batch_array[] = $data;
            }

            if($dark_chocolate_cookies!='')
            {
                $item_id =45;
                $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$dark_chocolate_cookies
                                );
                $batch_array[] = $data;
            }

            if($cranberry_cookies!='')
            {
                $item_id = 39;
                $data = array( 'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$cranberry_cookies
                                );
                $batch_array[] = $data;
            }

            if($cranberry_orange_zest!='')
            {
                $item_id = 42;
                $data = array(  'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$cranberry_orange_zest
                                );
                $batch_array[] = $data;
            }
            
            if($fig_raisins!='')
            {
                $item_id = 41;
                $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$fig_raisins
                                );
                $batch_array[] = $data;
            }

            if($papaya_pineapple!='')
            {
                $item_id = 40;
                $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$papaya_pineapple
                                );
                $batch_array[] = $data;
            }

            if($orange_bar!=null)
            {
                $item_id = 1;
                $data = array(
                                'type'=>'Bar',
                                'item_id'=>$item_id,
                                'qty'=>$orange_bar
                                );
                $batch_array[] = $data;
            }

            if($orange_box!=null)
            {
                $item_id = 1;  

                $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$orange_box
                                );
                $batch_array[] = $data;
            }

            if($butterscotch_bar!=null)
            {
                $item_id = 3;
                $data = array(
                                'type'=>'Bar',
                                'item_id'=>$item_id,
                                'qty'=>$butterscotch_bar
                                );
                $batch_array[] = $data;
            }

            if($butterscotch_box!=null)
            {
                $item_id = 3;

                $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$butterscotch_box
                                );
                $batch_array[] = $data;
            }

            if($chocopeanut_bar!=null)
            {
                $item_id = 5;
                $data = array(
                                'type'=>'Bar',
                                'item_id'=>$item_id,
                                'qty'=>$chocopeanut_bar
                                );
                $batch_array[] = $data;
            }

            if($chocopeanut_box!=null)
            {
                $item_id = 9;
                $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$chocopeanut_box
                                );
                $batch_array[] = $data;
            }

            if($bambaiyachaat_bar!=null)
            {
                $item_id = 4;
                $data = array(
                                'type'=>'Bar',
                                'item_id'=>$item_id,
                                'qty'=>$bambaiyachaat_bar
                                );
                $batch_array[] = $data;
            }

            if($bambaiyachaat_box!=null)
            {
                $item_id = 8;
                $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$bambaiyachaat_box
                                );
                $batch_array[] = $data;
            }

            if($mangoginger_bar!=null)
            {
                $item_id = 6;
                
               $data = array(
                                'type'=>'Bar',
                                'item_id'=>$item_id,
                                'qty'=>$mangoginger_bar
                                );
                $batch_array[] = $data;
            }

            if($mangoginger_box!=null)
            {
               $item_id = 12;
               $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$mangoginger_box
                                );
                $batch_array[] = $data;
            }

            if($berry_blast_bar!=null)
            {
               $item_id = 9;
               $data = array(
                                'type'=>'Bar',
                                'item_id'=>$item_id,
                                'qty'=>$berry_blast_bar
                                );

                $batch_array[] = $data;
            }

            if($berry_blast_box!=null)
            {
               $item_id = 29;
               $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$berry_blast_box
                                );

                $batch_array[] = $data;
            }

            if($chyawanprash_bar!=null)
            {
               $item_id = 10;
               $data = array(
                                'type'=>'Bar',
                                'item_id'=>$item_id,
                                'qty'=>$chyawanprash_bar
                                );
                $batch_array[] = $data;
            }

            if($chyawanprash_box!=null)
            {
               $item_id = 31;
               $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$chyawanprash_box
                                );
                $batch_array[] = $data;
            }

            if($variety_box!=null)
            {
                $item_id = 32;
                
                $data = array(
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$variety_box
                                );
                $batch_array[] = $data;
            }  
            
             $this->session->set_userdata('merchandiser_stock_details', $batch_array);
            /*if(count($batch_array)!='')
             {
                $this->db->insert_batch('merchandiser_stock_details',$batch_array);
             }*/  
    }

    if($channel_type=='GT')
    {
        $temp_array['sales_rep_loc_id']=$sales_rep_loc_id;
    }
    else
    {
        $temp_array['merchandiser_stock_id']= $this->input->post('merchandiser_stock_id');

    }

    if($chocolate_cookies!='')
    {

        $temp_array['chocolate_cookies_box']=$chocolate_cookies.'_Box';
    }

    if($dark_chocolate_cookies!='')
    {
       $temp_array['dark_chocolate_cookies_box']=$dark_chocolate_cookies.'_Box';
    }

    if($cranberry_cookies!='')
    {
        $temp_array['cranberry_cookies_box']=$cranberry_cookies.'_Box';
    }

    if($cranberry_orange_zest!='')
    {
        $temp_array['cranberry_orange_box'] = $cranberry_orange_zest.'_Box';
    }
    
    if($fig_raisins!='')
    {
        $temp_array['fig_raisins_box'] = $fig_raisins.'_Box';
    }

    if($papaya_pineapple!='')
    {
        $temp_array['papaya_pineapple'] = $papaya_pineapple.'_Box';
    }

    if($orange_bar!=null)
    {
        $temp_array['orange_bar'] = $orange_bar.'_Bar';
    }

     if($orange_box!=null)
    {
         $temp_array['orange_box'] = $orange_box.'_Box';
    }

    if($butterscotch_bar!=null)
    {
        $temp_array['butterscotch_bar'] = $butterscotch_bar.'_Bar';
    }

    if($butterscotch_box!=null)
    {
         $temp_array['butterscotch_box'] = $butterscotch_box.'_Box';
    }

    if($chocopeanut_bar!=null)
    {
       $temp_array['chocopeanut_bar'] = $chocopeanut_bar.'_Bar';
    }

    if($chocopeanut_box!=null)
    {
       $temp_array['chocopeanut_box'] = $chocopeanut_box.'_Box';
    }

    if($bambaiyachaat_bar!=null)
    {
        $temp_array['bambaiyachaat_bar'] = $bambaiyachaat_bar.'_Bar';
    }

    if($bambaiyachaat_box!=null)
    {
       $temp_array['bambaiyachaat_box'] = $bambaiyachaat_box.'_Box';
    }

    if($mangoginger_bar!=null)
    {
        $temp_array['mangoginger_bar'] = $mangoginger_bar.'_Bar';
    }

    if($mangoginger_box!=null)
    {
        $temp_array['mangoginger_box'] = $mangoginger_box.'_Box';
    }

    if($berry_blast_bar!=null)
    {
       $temp_array['berry_blast_bar'] = $berry_blast_bar.'_Bar';
    }

    if($berry_blast_box!=null)
    {
        $temp_array['berry_blast_box'] = $berry_blast_box.'_Box';
    }

    if($chyawanprash_bar!=null)
    {
        $temp_array['chyawanprash_bar'] = $chyawanprash_bar.'_Bar';
    }

    if($chyawanprash_box!=null)
    {
        $temp_array['chyawanprash_box'] = $chyawanprash_box.'_Box';
    }

    if($variety_box!=null)
    {
        $temp_array['variety_box'] = $variety_box;
    } 

    if(count($temp_array)>0)
    {

        $this->session->set_userdata('temp_stock_details', $temp_array);
    }

}


public function save_followup()
{
    $channel_type  = $this->input->post('channel_type');
    $distributor_type  = $this->input->post('distributor_type');
    $reation_id  = $this->input->post('reation_id');
    $zone_id  = $this->input->post('zone_id');
    $area_id  = $this->input->post('area_id');
    $location_id  = $this->input->post('location_id');
    $longitude  = $this->input->post('longitude');
    $latitude  = $this->input->post('latitude');
    $remarks  = trim($this->input->post('remarks'));
    $sales_rep_id=$this->session->userdata('sales_rep_id');
    $now=date('Y-m-d H:i:s');
    $now1=date('Y-m-d');
    $curusr=$this->session->userdata('session_id');
    $followup_date=$this->input->post('followup_date');
    $retailer_id = $this->input->post('distributor_id');
    $sales_rep_loc_id = $this->input->post('sales_rep_loc_id');

    if($followup_date==''){
        $followup_date=NULL;
    } else {
        $followup_date=formatdate($followup_date);
    }

    $visit_detail = array(
        'channel_type'  => $channel_type,
        'distributor_types'=> $distributor_type,
        'reation_id'=>$reation_id,
        'zone_id' => $zone_id,
        'location_id' => $location_id,
        'remarks' => $remarks,
        'longitude'=>$longitude,
        'latitude'=>$latitude,
        'distributor_name' => $this->input->post('distributor_name'),
        'distributor_id'=> '',
        'area_id'=>$area_id,
        'sales_rep_loc_id'=>$sales_rep_loc_id
    );


    $retailer_detail = array(
        'margin' => '',
        'retailer_remarks' => '',
        'gst_number' => '',
        'master_distributor_id' => ''
    );

    $orange_bar = $this->input->post('orange_bar');
    $butterscotch_bar = $this->input->post('butterscotch_bar');
    $chocopeanut_bar = $this->input->post('chocopeanut_bar');
    $bambaiyachaat_bar = $this->input->post('bambaiyachaat_bar');
    $mangoginger_bar = $this->input->post('mangoginger_bar');
    $berry_blast_bar = $this->input->post('berry_blast_bar');
    $chyawanprash_bar = $this->input->post('chyawanprash_bar');
    $variety_box = $this->input->post('variety_box');
    $chocolate_cookies = $this->input->post('chocolate_cookies');
    $dark_chocolate_cookies = $this->input->post('dark_chocolate_cookies');
    $cranberry_cookies = $this->input->post('cranberry_cookies');
    $cranberry_orange = $this->input->post('cranberry_orange');
    $fig_raisins = $this->input->post('fig_raisins');
    $papaya_pineapple = $this->input->post('papaya_pineapple');
    $cranberry_orange_zest = $this->input->post(' cranberry_orange_zest');


    if($this->input->post('channel_type')=='MT')
    {
        $data = array(
                        'dist_id' => $reation_id,
                        'distributor_status' => 'Follow Up',
                        'latitude' => $visit_detail['latitude'],
                        'longitude' => $visit_detail['longitude'],
                        'remarks' => $visit_detail['remarks'],
                        'modified_by' => $curusr,
                        'modified_on' => $now,
                        'zone_id' => $visit_detail['zone_id'],
                        'area_id' => $visit_detail['area_id'],
                        'location_id' => $visit_detail['location_id'],
                        'followup_date' => $followup_date
                    );
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('merchandiser_stock',$data);
        $id=$this->db->insert_id();
        if($id)
        {
            if($chocolate_cookies!='')
            {
                $item_id =37;
                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$chocolate_cookies
                                );
                $batch_array[] = $data;
            }

            if($dark_chocolate_cookies!='')
            {
                $item_id =45;
                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$dark_chocolate_cookies
                                );
                $batch_array[] = $data;
            }

            if($cranberry_cookies!='')
            {
                $item_id = 39;
                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$cranberry_cookies
                                );
                $batch_array[] = $data;
            }

            if($cranberry_orange_zest!='')
            {
                $item_id = 42;
                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$cranberry_orange_zest
                                );
                $batch_array[] = $data;
            }
            
            if($fig_raisins!='')
            {
                $item_id = 41;
                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$fig_raisins
                                );
                $batch_array[] = $data;
            }

            if($papaya_pineapple!='')
            {
                $item_id = 40;
                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>'Box',
                                'item_id'=>$item_id,
                                'qty'=>$papaya_pineapple
                                );
                $batch_array[] = $data;
            }

            if($orange_bar!=null)
            {
                $type = $this->input->post('type_0');
                if($type=='Box'){
                    $item_id = 1;
                }
                else{
                     $item_id = 1;
                }
                    

                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>$type,
                                'item_id'=>$item_id,
                                'qty'=>$orange_bar
                                );
                $batch_array[] = $data;
            }

            if($butterscotch_bar!=null)
            {
                $type = $this->input->post('type_1');
                if($type=='Box')
                    $item_id = 1;
                else
                    $item_id = 3;

                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>$type,
                                'item_id'=>$item_id,
                                'qty'=>$butterscotch_bar
                                );
                $batch_array[] = $data;
            }

            if($chocopeanut_bar!=null)
            {
                $type = $this->input->post('type_3');
                if($type=='Box')
                    $item_id = 9;
                else
                    $item_id = 5;
                
                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>$type,
                                'item_id'=>$item_id,
                                'qty'=>$chocopeanut_bar
                                );
                $batch_array[] = $data;
            }

            if($bambaiyachaat_bar!=null)
            {
                $type = $this->input->post('type_4');
                if($type=='Box')
                    $item_id = 8;
                else
                    $item_id = 4;
                
                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>$type,
                                'item_id'=>$item_id,
                                'qty'=>$bambaiyachaat_bar
                                );
                $batch_array[] = $data;
            }

            if($mangoginger_bar!=null)
            {
                $type = $this->input->post('type_5');
                if($type=='Box')
                    $item_id = 21;
                else
                    $item_id = 6;
                
               $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>$type,
                                'item_id'=>$item_id,
                                'qty'=>$mangoginger_bar
                                );
                $batch_array[] = $data;
            }

            if($berry_blast_bar!=null)
            {
                $type = $this->input->post('type_5');
                if($type=='Box')
                    $item_id = 29;
                else
                    $item_id = 16;
                
               $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>$type,
                                'item_id'=>$item_id,
                                'qty'=>$berry_blast_bar
                                );

                $batch_array[] = $data;
            }

            if($chyawanprash_bar!=null)
            {
                $type = $this->input->post('type_6');
                if($type=='Box')
                    $item_id = 31;
                else
                    $item_id = 10;
                
               $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>$type,
                                'item_id'=>$item_id,
                                'qty'=>$chyawanprash_bar
                                );
                $batch_array[] = $data;
            }

            if($variety_box!=null)
            {
                $item_id = 32;
                
                $data = array(
                                'merchandiser_stock_id' => $id,
                                'type'=>'Box',
                                'item_id'=>32,
                                'qty'=>$variety_box
                                );
                $batch_array[] = $data;
            }  
         
         if(count($batch_array)!='')
         {
            $this->db->insert_batch('merchandiser_stock_details',$batch_array);
         }  
        } 
    }
    else
    {
        if($distributor_type=='New')
        {
            $retailer_details = array(
                                'sales_rep_id' => $sales_rep_id,
                                'distributor_name' => $visit_detail['distributor_name'],
                                'modified_by' => $curusr,
                                'modified_on' => $now,
                                'location_id' => $visit_detail['location_id'],
                                'zone_id' =>     $visit_detail['zone_id'],
                                'area_id' =>     $visit_detail['area_id'],
                                'latitude' =>    $visit_detail['latitude'],
                                'longitude' =>   $visit_detail['longitude'],
                                'status'=>'Inactive'
                            );
            $this->db->insert('sales_rep_distributors',$retailer_details);
            $insertid=$this->db->insert_id();

            $action='Sales Rep Distributor Created.';
            $store_id = $insertid;
            $retailer_id = 's_'.$store_id;
        }
        else
        {
            
                 
            $batch_array = array();

            
                if($chocolate_cookies!='')
                {

                    $batch_array['chocopeanut_box']=$chocolate_cookies;
                }

                if($dark_chocolate_cookies!='')
                {
                   $batch_array['dark_chocolate_cookies_box']=$dark_chocolate_cookies;
                }

                if($cranberry_cookies!='')
                {
                    $batch_array['cranberry_cookies_box']=$cranberry_cookies;
                }

                if($cranberry_orange_zest!='')
                {
                    $batch_array['cranberry_orange_box'] = $cranberry_orange_zest;
                }
                
                if($fig_raisins!='')
                {
                    $batch_array['fig_raisins_box'] = $fig_raisins;
                }

                if($papaya_pineapple!='')
                {
                    $batch_array['papaya_pineapple_box'] = $papaya_pineapple;
                }

                if($orange_bar!=null)
                {
                     $type = $this->input->post('type_0');
                     if($type=='Box')
                     {
                        $batch_array['orange_box'] = $orange_bar;
                     }
                     else
                     {
                        $batch_array['orange_bar'] = $orange_bar;
                     }
                }

                if($butterscotch_bar!=null)
                {
                    $type = $this->input->post('type_1');    
                    if($type=='Box')
                     {
                        $batch_array['butterscotch_bar'] = $chocolate_cookies;
                     }
                     else
                     {
                        $batch_array['butterscotch_box'] = $orange_bar;
                     }
                }

                if($chocopeanut_bar!=null)
                {
                    $type = $this->input->post('type_3');
                    if($type=='Box')
                     {
                        $batch_array['chocopeanut_box'] = $chocopeanut_bar;
                     }
                     else
                     {
                        $batch_array['chocopeanut_bar'] = $chocopeanut_bar;
                     }
                }

                if($bambaiyachaat_bar!=null)
                {
                    $type = $this->input->post('type_4');
                     if($type=='Box')
                     {
                        $batch_array['bambaiyachaat_box'] = $bambaiyachaat_bar;
                     }
                     else
                     {
                        $batch_array['bambaiyachaat_bar'] = $bambaiyachaat_bar;
                     }
                }

                if($mangoginger_bar!=null)
                {
                    $type = $this->input->post('type_5');
                    if($type=='Box')
                     {
                        $batch_array['mangoginger_box'] = $mangoginger_box;
                     }
                     else
                     {
                        $batch_array['mangoginger_bar'] = $mangoginger_bar;
                     }
                }

                if($berry_blast_bar!=null)
                {
                    $type = $this->input->post('type_5');
                    if($type=='Box')
                     {
                        $batch_array['berry_blast_box'] = $berry_blast_bar;
                     }
                     else
                     {
                        $batch_array['berry_blast_bar'] = $berry_blast_bar;
                     }
                }

                if($chyawanprash_bar!=null)
                {
                    $type = $this->input->post('type_6');
                    if($type=='Box')
                     {
                        $batch_array['chyawanprash_box'] = $berry_blast_bar;
                     }
                     else
                     {
                        $batch_array['chyawanprash_bar'] = $berry_blast_bar;
                     }
                }

                if($variety_box!=null)
                {
                    $batch_array['variety_box'] = $variety_box;
                }  
        }

        $data = array(
                        'sales_rep_id' => $sales_rep_id,
                        'date_of_visit' => $now1,
                        'distributor_type' => $visit_detail['distributor_types'],
                        'distributor_id' => $retailer_id,
                        'distributor_name' => $visit_detail['distributor_name'],
                        'distributor_status' => 'Follow Up',
                        'latitude' => $visit_detail['latitude'],
                        'longitude' => $visit_detail['longitude'],
                        'status' => 'Approved',
                        'remarks' => $visit_detail['remarks'],
                        'modified_by' => $curusr,
                        'modified_on' => $now,
                        'zone_id' => $visit_detail['zone_id'],
                        'area_id' => $visit_detail['area_id'],
                        'location_id' => $visit_detail['location_id'],
                        'followup_date' => $followup_date
                    );

        
        if($visit_detail['sales_rep_loc_id']=='')
            {
                 $data['created_by']=$curusr;
                 $data['created_on']=$now;
                $this->db->insert('sales_rep_location',$data);
                $sales_rep_loc_id=$this->db->insert_id();
                $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;
                $this->db->insert('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);    
            }
            else
            {
                $this->db->where('id',$visit_detail['sales_rep_loc_id'])->update('sales_rep_location',$data);
                $sales_rep_loc_id=$visit_detail['sales_rep_loc_id'];  

                $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;

                $this->db->where('sales_rep_loc_id',$visit_detail['sales_rep_loc_id'])->update('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);  
            }

        /*$data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sales_rep_location',$data);
        $insertid=$this->db->insert_id();
        $batch_array['sales_rep_loc_id'] = $insertid;
        $this->db->insert('sales_rep_distributor_opening_stock',$batch_array); */
    }
}

public function save_entry($value='')
{
    $distributor_type  = $this->input->post('distributor_type');
    $orange_bar = $this->input->post('orange_bar');
    $butterscotch_bar = $this->input->post('butterscotch_bar');
    $chocopeanut_bar = $this->input->post('chocopeanut_bar');
    $bambaiyachaat_bar = $this->input->post('bambaiyachaat_bar');
    $mangoginger_bar = $this->input->post('mangoginger_bar');
    $berry_blast_bar = $this->input->post('berry_blast_bar');
    $chyawanprash_bar = $this->input->post('chyawanprash_bar');
    $variety_box = $this->input->post('variety_box');
    $chocolate_cookies = $this->input->post('chocolate_cookies');
    $dark_chocolate_cookies = $this->input->post('dark_chocolate_cookies');
    $cranberry_cookies = $this->input->post('cranberry_cookies');
    $cranberry_orange = $this->input->post('cranberry_orange');
    $fig_raisins = $this->input->post('fig_raisins');
    $papaya_pineapple = $this->input->post('papaya_pineapple');
    $cranberry_orange_zest = $this->input->post(' cranberry_orange_zest');
         
    $batch_array = array();

    if($distributor_type=='Old')
    {
        if($chocolate_cookies!='')
        {

            $batch_array['chocopeanut_box']=$chocolate_cookies;
        }

        if($dark_chocolate_cookies!='')
        {
           $batch_array['dark_chocolate_cookies_box']=$dark_chocolate_cookies;
        }

        if($cranberry_cookies!='')
        {
            $batch_array['cranberry_cookies_box']=$cranberry_cookies;
        }

        if($cranberry_orange_zest!='')
        {
            $batch_array['cranberry_orange_box'] = $cranberry_orange_zest;
        }
        
        if($fig_raisins!='')
        {
            $batch_array['fig_raisins_box'] = $fig_raisins;
        }

        if($papaya_pineapple!='')
        {
            $batch_array['papaya_pineapple_box'] = $papaya_pineapple;
        }

        if($orange_bar!=null)
        {
             $type = $this->input->post('type_0');
             if($type=='Box')
             {
                $batch_array['orange_box'] = $orange_bar;
             }
             else
             {
                $batch_array['orange_bar'] = $orange_bar;
             }
        }

        if($butterscotch_bar!=null)
        {
            $type = $this->input->post('type_1');    
            if($type=='Box')
             {
                $batch_array['chocolate_cookies_box'] = $chocolate_cookies;
             }
             else
             {
                $batch_array['chocolate_cookies_bar'] = $chocolate_cookies;
             }
        }

        if($chocopeanut_bar!=null)
        {
            $type = $this->input->post('type_3');
            if($type=='Box')
             {
                $batch_array['chocopeanut_box'] = $chocopeanut_bar;
             }
             else
             {
                $batch_array['chocopeanut_bar'] = $chocopeanut_bar;
             }
        }

        if($bambaiyachaat_bar!=null)
        {
            $type = $this->input->post('type_4');
             if($type=='Box')
             {
                $batch_array['bambaiyachaat_box'] = $bambaiyachaat_bar;
             }
             else
             {
                $batch_array['bambaiyachaat_bar'] = $bambaiyachaat_bar;
             }
        }

        if($mangoginger_bar!=null)
        {
            $type = $this->input->post('type_5');
            if($type=='Box')
             {
                $batch_array['mangoginger_box'] = $mangoginger_bar;
             }
             else
             {
                $batch_array['mangoginger_bar'] = $mangoginger_bar;
             }
        }

        if($berry_blast_bar!=null)
        {
            $type = $this->input->post('type_5');
            if($type=='Box')
             {
                $batch_array['berry_blast_box'] = $berry_blast_bar;
             }
             else
             {
                $batch_array['berry_blast_bar'] = $berry_blast_bar;
             }
        }

        if($chyawanprash_bar!=null)
        {
            $type = $this->input->post('type_6');
            if($type=='Box')
             {
                $batch_array['chyawanprash_box'] = $berry_blast_bar;
             }
             else
             {
                $batch_array['chyawanprash_bar'] = $berry_blast_bar;
             }
        }

        if($variety_box!=null)
        {
            $batch_array['variety_box'] = $variety_box;
        }  
 
        if(count($batch_array)!='')
        {
           $this->session->set_userdata('sales_rep_stock_detail', $batch_array);
        }  



        $channel_type  = $this->input->post('channel_type');
        $distributor_type  = $this->input->post('distributor_type');
        $reation_id  = $this->input->post('reation_id');
        $zone_id  = $this->input->post('zone_id');
        $area_id  = $this->input->post('area_id');
        $location_id  = $this->input->post('location_id');
        $longitude  = $this->input->post('longitude');
        $latitude  = $this->input->post('latitude');
        $remarks  = trim($this->input->post('remarks'));

        $visit_detail = array(
            'channel_type'  => $channel_type,
            'distributor_types'=> $distributor_type,
            'reation_id'=>$reation_id,
            'zone_id' => $zone_id,
            'location_id' => $location_id,
            'remarks' => $remarks,
            'longitude'=>$longitude,
            'latitude'=>$latitude,
            'distributor_name' => '',
            'distributor_id'=> '',
            'area_id'=>''
        );


        $retailer_detail = array(
            'margin' => '',
            'retailer_remarks' => '',
            'gst_number' => '',
            'master_distributor_id' => ''
        );


       if($visit_detail['channel_type']=='MT')
        {
            
           
            $data = array(
                'store_name' => $visit_detail['distributor_name'],
                'type_id' => 7,
                'status' => 'Active',
                'remarks' => $visit_detail['remarks'],
                'created_on' => $now,
                'created_by' => $curusr,
                'modified_by' => $curusr,
                'modified_on' => $now
            );
            $this->db->insert('relationship_master',$data);
            $insertid=$this->db->insert_id();
            $retailer_id = $insertid;
            
            /*insertid is the relationship id*/

            $sql = "Select max(sequence) as sequence from merchandiser_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id=$sales_rep_id and is_edit='edit' and frequency='$frequency'";
            $get_maxcount = $this->db->query($sql)->result_array();
            $visited_sequence = $get_maxcount[0]['sequence']+1;

           if($visit_detail!=null)
           {
                $data = array(
                    'store_id' => $insertid,
                    'zone_id' => $visit_detail['zone_id'],
                    'location_id' => $visit_detail['location_id'],
                    'latitude' =>  $visit_detail['latitude'],
                    'longitude' => $visit_detail['longitude'],
                    'status' => 'Active',
                    'modified_by' => $curusr,
                    'modified_on' => $now
                );

                $this->db->insert('store_master',$data);
                echo $this->db->last_query();
                echo 'insertid'.$insertid=$this->db->insert_id();
                $store_id = $insertid;


                /*insertid is the store_id id*/

                if($insertid)
                { 
                    echo "enterd1";

                    $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence>=$visited_sequence";
                        $result = $this->db->query($sql)->result_array();
                      echo '<br>'.$this->db->last_query();
                      for ($j=0; $j < count($result); $j++) 
                      {   
                        $newsequence = $result[$j]['sequence']+1;
                        $new_id = $result[$j]['id'];
                        $data1 = array('sequence'=>$newsequence,
                                        'modified_on'=>$now);
                        $this->db->where('id', $new_id);
                        $this->db->update('merchandiser_beat_plan',$data1);
                        $this->db->last_query();
                      }

                    $sql = "Select count(*) as sequence from merchandiser_beat_plan WHERE frequency='$frequency' and sales_rep_id=$sales_rep_id";
                    $get_maxcount_sales_rep = $this->db->query($sql)->result_array();
                      echo '<br>'.$this->db->last_query();
                    if($get_maxcount_sales_rep==0)
                    {
                        $visited_sequence_sales_re = $get_maxcount_sales_rep[0]['sequence']+1;
                        $data1 = array('sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$visited_sequence_sales_re,
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'store_id'=>$store_id,
                                  'status'=>'Approved',
                                  'created_by'=>$curusr,
                                  'modified_by' => $curusr,
                                  'location_id' => $visit_detail['location_id'],
                                  'zone_id' => $visit_detail['zone_id'],
                                  'created_on'=>$now);
                        $this->db->insert('merchandiser_beat_plan',$data1);
                        $lastinsertid=$this->db->insert_id();
                    }
                    else{
                        $data1 = array('sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$visited_sequence,
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'store_id'=>$insertid,
                                  'status'=>'Approved',
                                  'created_by'=>$curusr,
                                  'modified_by' => $curusr,
                                  'location_id' => $visit_detail['location_id'],
                                  'zone_id' => $visit_detail['zone_id'],
                                  'created_on'=>$now);
                        $this->db->insert('merchandiser_beat_plan',$data1);
                        $lastinsertid=$this->db->insert_id();
                    }
                    
                   
                    if($lastinsertid)
                    {
                        if (strpos($frequency, 'Every') !== false) {

                            $explode_frequency = explode(' ',$frequency);
                            /*$new_frequency = 'Alternate '.$explode_frequency[1];*/
                            $selectfre = "SELECT (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                            $frequency_result = $this->db->query($selectfre)->result();
                            $frequency_result = $frequency_result[0]->daymonth;
                            if($frequency_result==2)
                            {
                               $new_frequency = 'Alternate '.$explode_frequency[1]; 
                            }
                            else
                            {
                                $new_frequency = 'Alternate2 '.$explode_frequency[1];
                            }

                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('merchandiser_beat_plan')->result_array();

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array(
                                           'sales_rep_id'=>$sales_rep_id,
                                           'sequence'=>$max_sequnece,
                                           'frequency'=>$new_frequency,
                                           'modified_on'=>$now,
                                           'store_id'=>$insertid,
                                           'status'=>'Approved',
                                           'created_by'=>$curusr,
                                           'modified_by' => $curusr,
                                           'location_id' => $visit_detail['location_id'],
                                           'zone_id' => $visit_detail['zone_id'],
                                           'created_on'=>$now);
                            $this->db->insert('merchandiser_beat_plan',$after_temp_data2);
                        }
                        
                        if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {

                            $explode_frequency = explode(' ',$frequency);
                            $new_frequency = 'Every '.$explode_frequency[1];
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('merchandiser_beat_plan')->result_array();

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array(
                                           'sales_rep_id'=>$sales_rep_id,
                                           'sequence'=>$max_sequnece,
                                           'frequency'=>$new_frequency,
                                           'modified_on'=>$now,
                                           'store_id'=>$insertid,
                                           'status'=>'Approved',
                                           'created_by'=>$curusr,
                                           'modified_by' => $curusr,
                                           'location_id' => $visit_detail['location_id'],
                                           'zone_id' => $visit_detail['zone_id'],
                                           'created_on'=>$now); 
                                 $this->db->insert('merchandiser_beat_plan',$after_temp_data2);
                        }
                        
                        if($visited_sequence==1)
                        {
                            $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                            
                            for ($j=0; $j < count($result); $j++) 
                              {
                                $new_id = $result[$j]['id'];
                                $store_id1 = $result[$j]['store_id'];
                                $location_id = $result[$j]['location_id'];
                                $zone_id = $result[$j]['zone_id'];
                                $newsequence = $result[$j]['sequence']+1;
                                $data22 = array('date_of_visit'=> $now,
                                      'sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$newsequence,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'bit_plan_id'=>$new_id,
                                      'store_id'=>$store_id1,
                                      'zone_id'=>$zone_id,
                                      'location_id'=>$location_id,
                                      'status'=>'Approved');
                                $this->db->insert('merchandiser_detailed_beat_plan',$data22);
                               
                              }
                        }
                        else
                        {
                            $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>=$visited_sequence";
                            $result = $this->db->query($sql)->result_array();
                              $this->db->last_query();
                              for ($j=0; $j < count($result); $j++) 
                              {   
                                $newsequence = $result[$j]['sequence']+1;
                                $new_id = $result[$j]['id'];
                                 $data1 = array('sequence'=>$newsequence,
                                                'modified_on'=>$now);
                                $this->db->where('id', $new_id);
                                $this->db->update('merchandiser_detailed_beat_plan',$data1);
                                $this->db->last_query();
                             }
                        }

                        $data2 = array('sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$visited_sequence,
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'store_id'=>$store_id,
                                  'status'=>'Approved',
                                  'modified_on'=>$now,
                                  'zone_id'=>$visit_detail['zone_id'],
                                  'location_id'=>$visit_detail['location_id'],
                                  'date_of_visit' => $now);
                        $data2['bit_plan_id']=$lastinsertid;    
                        $data2['is_edit']='edit';
                        $this->db->insert('merchandiser_detailed_beat_plan',$data2);
                    }
                }

                $data = array(
                    'm_id' => $sales_rep_id,
                    'date_of_visit' => $now,
                    'dist_id' => $store_id,
                    'latitude' => $visit_detail['latitude'],
                    'longitude' => $visit_detail['longitude'],
                    'remarks' => trim($visit_detail['remarks']),
                    'location_id' => $visit_detail['location_id'],
                    'created_by' => $curusr,
                );
                $this->db->insert('merchandiser_stock',$data);
                echo '<br>last_query'.$this->db->last_query();
                $id=$this->db->insert_id(); 
               /*Stock is inserted*/      
           }        
        }
        else
        {   /*If distype is old and isedit is empty*/
            if($visit_detail['beat_plan_id']!='')
            {
                $retailer_id = $visit_detail['retailer_id'];
                $data = array(
                        'sales_rep_id' => $sales_rep_id,
                        'date_of_visit' => $now1,
                        'distributor_type' => $visit_detail['distributor_types'],
                        'distributor_id' => $visit_detail['retailer_id'],
                        'distributor_name' => $visit_detail['distributor_name'],
                        'distributor_status' => 'Place Order',
                        'latitude' => $visit_detail['latitude'],
                        'longitude' => $visit_detail['longitude'],
                        'status' => 'Approved',
                        'remarks' => $visit_detail['remarks'],
                        'modified_by' => $curusr,
                        'modified_on' => $now,
                        'zone_id' => $visit_detail['zone_id'],
                        'area_id' => $visit_detail['area_id'],
                        'location_id' => $visit_detail['location_id'],
                        'frequency'=>$frequency
                    );
                $data['created_by']=$curusr;
                $data['created_on']=$now;
                $this->db->insert('sales_rep_location',$data);
                $sales_rep_loc_id=$this->db->insert_id();    

                $sales_rep_stock_detail = $visit_detail['sales_rep_stock_detail'];
                $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;

                $this->db->insert('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);

                /*Add beatplan*/

                $sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id=$sales_rep_id and is_edit='edit' and frequency='$frequency'";
                $get_maxcount = $this->db->query($sql)->result_array();
                $visited_sequence = $get_maxcount[0]['sequence']+1;


                $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and date(date_of_visit)=date(now()) and frequency='$frequency'";
                $detailed_result = $this->db->query($sql)->result_array();

                if(count($detailed_result)>0)
                {
                     $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) ";
                     $result = $this->db->query($sql)->result_array();
                     $this->db->last_query();
                     for ($j=0; $j < count($result); $j++) 
                      {  
                        $result[$j]['sequence'];
                        echo '<br>sequence'.$sequence;
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

                $ispermenant  ='Yes';    
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
            else
            {
                $sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id=$sales_rep_id and is_edit='edit' and frequency='$frequency'";
                $get_maxcount = $this->db->query($sql)->result_array();
                $visited_sequence = $get_maxcount[0]['sequence']+1;
                $retailer_id = 0;

               if($visit_detail!=null)
               {
                    $retailer_details = array(
                        'sales_rep_id' => $sales_rep_id,
                        'distributor_name' => $visit_detail['distributor_name'],
                        'modified_by' => $curusr,
                        'modified_on' => $now,
                        'location_id' => $visit_detail['location_id'],
                        'zone_id' =>     $visit_detail['zone_id'],
                        'area_id' =>     $visit_detail['area_id'],
                        'latitude' =>    $visit_detail['latitude'],
                        'longitude' =>   $visit_detail['longitude'],
                        'gst_number' =>  $retailer_detail['gst_number'],
                        'margin' =>  $retailer_detail['margin'],
                        'remarks' =>  $retailer_detail['retailer_remarks'],
                        'master_distributor_id'=>$retailer_detail['master_distributor_id'],
                        'status'=>'Approved'
                    );
                    $this->db->insert('sales_rep_distributors',$retailer_details);
                    $insertid=$this->db->insert_id();

                    $action='Sales Rep Distributor Created.';
                    $store_id = $insertid;
                    $retailer_id = 's_'.$store_id;

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
                        if($get_maxcount_sales_rep==0)
                        {
                            $visited_sequence_sales_re = $get_maxcount_sales_rep[0]['sequence']+1;
                            $data1 = array('sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$visited_sequence_sales_re,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'store_id'=>'s_'.$store_id,
                                      'status'=>'Approved',
                                      'created_by'=>$curusr,
                                      'modified_by' => $curusr,
                                      'location_id' => $visit_detail['location_id'],
                                      'zone_id' => $visit_detail['zone_id'],
                                      'area_id' => $visit_detail['area_id'],
                                      'created_on'=>$now);
                            $this->db->insert('sales_rep_beat_plan',$data1);
                            $lastinsertid=$this->db->insert_id();
                        }
                        else{
                            $data1 = array('sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$visited_sequence,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'store_id'=>'s_'.$insertid,
                                      'status'=>'Approved',
                                      'created_by'=>$curusr,
                                      'modified_by' => $curusr,
                                      'location_id' => $visit_detail['location_id'],
                                      'zone_id' => $visit_detail['zone_id'],
                                      'area_id' => $visit_detail['area_id'],
                                      'created_on'=>$now);
                            $this->db->insert('sales_rep_beat_plan',$data1);
                            $lastinsertid=$this->db->insert_id();
                        }
                        
                       
                        if($lastinsertid)
                        {
                            if (strpos($frequency, 'Every') !== false) {

                                $explode_frequency = explode(' ',$frequency);
                                /*$new_frequency = 'Alternate '.$explode_frequency[1];*/
                                $selectfre = "SELECT (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                                $frequency_result = $this->db->query($selectfre)->result();
                                $frequency_result = $frequency_result[0]->daymonth;
                                if($frequency_result==2)
                                {
                                   $new_frequency = 'Alternate '.$explode_frequency[1]; 
                                }
                                else
                                {
                                    $new_frequency = 'Alternate2 '.$explode_frequency[1];
                                }

                                $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                                $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                                $after_temp_data2 = array(
                                               'sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>'s_'.$insertid,
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id' => $visit_detail['location_id'],
                                               'zone_id' => $visit_detail['zone_id'],
                                               'area_id' => $visit_detail['area_id'],
                                               'created_on'=>$now);
                                $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                            }
                            
                            if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {

                                $explode_frequency = explode(' ',$frequency);
                                $new_frequency = 'Every '.$explode_frequency[1];
                                $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                                $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                                $after_temp_data2 = array(
                                               'sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>'s_'.$insertid,
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id' => $visit_detail['location_id'],
                                               'zone_id' => $visit_detail['zone_id'],
                                               'area_id' => $visit_detail['area_id'],
                                               'created_on'=>$now); 
                                     $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                            }
                            
                            if($visited_sequence==1)
                            {
                                $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                                
                                for ($j=0; $j < count($result); $j++) 
                                  {
                                    $new_id = $result[$j]['id'];
                                    $store_id1 = $result[$j]['store_id'];
                                    $newsequence = $result[$j]['sequence']+1;
                                    $data22 = array('date_of_visit'=> $now,
                                          'sales_rep_id'=>$sales_rep_id,
                                          'sequence'=>$newsequence,
                                          'frequency'=>$frequency,
                                          'modified_on'=>$now,
                                          'bit_plan_id'=>$new_id,
                                          'store_id'=>$store_id1,
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

                    $followup_date=$this->input->post('followup_date');

                    if($followup_date==''){
                        $followup_date=NULL;
                    } else {
                        $followup_date=formatdate($followup_date);
                    }

                    $data = array(
                        'sales_rep_id' => $sales_rep_id,
                        'date_of_visit' => $now1,
                        'distributor_type' => $visit_detail['distributor_types'],
                        'distributor_id' => 's_'.$insertid,
                        'distributor_name' => $visit_detail['distributor_name'],
                        'distributor_status' => 'Place Order',
                        'latitude' => $visit_detail['latitude'],
                        'longitude' => $visit_detail['longitude'],
                        'status' => 'Approved',
                        'remarks' => $visit_detail['remarks'],
                        'modified_by' => $curusr,
                        'modified_on' => $now,
                        'zone_id' => $visit_detail['zone_id'],
                        'area_id' => $visit_detail['area_id'],
                        'location_id' => $visit_detail['location_id'],
                        'followup_date' => $followup_date,
                        'frequency'=>$frequency
                    );
                    $data['created_by']=$curusr;
                    $data['created_on']=$now;

                    $this->db->insert('sales_rep_location',$data);
                    $id=$this->db->insert_id();
               }
            }
        }

        
    }
}

public function save_relation_session()
{
    $channel_type  = $this->input->post('channel_type');
    $distributor_type  = $this->input->post('distributor_type');
    $reation_id  = $this->input->post('reation_id');
    $zone_id  = $this->input->post('zone_id');
    $area_id  = $this->input->post('area_id');
    $location_id  = $this->input->post('location_id');
    $longitude  = $this->input->post('longitude');
    $latitude  = $this->input->post('latitude');
    $remarks  = trim($this->input->post('remarks'));
    $mid  = trim($this->input->post('mid'));
    $beat_plan_id  = $this->input->post('beat_plan_id');
    $distributor_status  = $this->input->post('distributor_status');
    $merchandiser_stock_id  = $this->input->post('merchandiser_stock_id');
    $sequence = $this->input->post('sequence');
    $follow_type = $this->input->post('follow_type');
    $sales_rep_loc_id = $this->input->post('sales_rep_loc_id');

    $newdata = array(
        'channel_type'  => $channel_type,
        'distributor_types'=> $distributor_type,
        'reation_id'=>$reation_id,
        'zone_id' => $zone_id,
        'location_id' => $location_id,
        'remarks' => $remarks,
        'longitude'=>$longitude,
        'latitude'=>$latitude,
        'distributor_name' => '',
        'distributor_id'=> '',
        'area_id'=>'',
        'mid'=>$mid,
        'beat_plan_id'=>$beat_plan_id,
        'distributor_status'=>$distributor_status,
        'merchandiser_stock_id'=>$merchandiser_stock_id,
        'sequence'=>$sequence,
        'follow_type'=>$follow_type,
        'sales_rep_loc_id'=>$sales_rep_loc_id
    );
    
    $this->session->set_userdata('visit_detail', $newdata);
    $visit_detail = $this->session->userdata('visit_detail');

   

    $orange_bar = $this->input->post('orange_bar');
    $orange_box = $this->input->post('orange_box');
    $butterscotch_bar = $this->input->post('butterscotch_bar');
    $butterscotch_box = $this->input->post('butterscotch_box');
    $chocopeanut_bar = $this->input->post('chocopeanut_bar');
    $chocopeanut_box = $this->input->post('chocopeanut_box');
    $bambaiyachaat_bar = $this->input->post('bambaiyachaat_bar');
    $bambaiyachaat_box = $this->input->post('bambaiyachaat_box');
    $mangoginger_bar = $this->input->post('mangoginger_bar');
    $mangoginger_box = $this->input->post('mangoginger_box');
    $berry_blast_bar = $this->input->post('berry_blast_bar');
    $berry_blast_box = $this->input->post('berry_blast_box');
    $chyawanprash_bar = $this->input->post('chyawanprash_bar');
    $chyawanprash_box = $this->input->post('chyawanprash_box');
    $variety_box = $this->input->post('variety_box');
    $chocolate_cookies = $this->input->post('chocolate_cookies');
    $dark_chocolate_cookies = $this->input->post('dark_chocolate_cookies');
    $cranberry_cookies = $this->input->post('cranberry_cookies');
    $cranberry_orange = $this->input->post('cranberry_orange');
    $fig_raisins = $this->input->post('fig_raisins');
    $papaya_pineapple = $this->input->post('papaya_pineapple');
    $cranberry_orange_zest = $this->input->post('cranberry_orange_zest');
         
    $batch_array = array();

    if($chocolate_cookies!='')
    {
        $item_id =37;
        $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$chocolate_cookies
                        );
        $batch_array[] = $data;
    }

    if($dark_chocolate_cookies!='')
    {
        $item_id =45;
        $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$dark_chocolate_cookies
                        );
        $batch_array[] = $data;
    }

    if($cranberry_cookies!='')
    {
        $item_id = 39;
        $data = array( 'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$cranberry_cookies
                        );
        $batch_array[] = $data;
    }

    if($cranberry_orange_zest!='')
    {
        $item_id = 42;
        $data = array(  'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$cranberry_orange_zest
                        );
        $batch_array[] = $data;
    }
    
    if($fig_raisins!='')
    {
        $item_id = 41;
        $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$fig_raisins
                        );
        $batch_array[] = $data;
    }

    if($papaya_pineapple!='')
    {
        $item_id = 40;
        $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$papaya_pineapple
                        );
        $batch_array[] = $data;
    }

    if($orange_bar!=null)
    {
        $item_id = 1;   
        $data = array(
                        'type'=>'Bar',
                        'item_id'=>$item_id,
                        'qty'=>$orange_bar
                        );
        $batch_array[] = $data;
    }

    if($orange_box!=null)
    {
        $item_id = 1;
        $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$orange_box
                        );
        $batch_array[] = $data;
    }

    if($butterscotch_bar!=null)
    {
        $item_id = 3;
        $data = array(
                        'type'=>'Bar',
                        'item_id'=>$item_id,
                        'qty'=>$butterscotch_bar
                        );
        $batch_array[] = $data;
    }

    if($butterscotch_box!=null)
    {
        $item_id = 3;
        $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$butterscotch_box
                        );
        $batch_array[] = $data;
    }

    if($chocopeanut_bar!=null)
    {
        $item_id = 5;
        $data = array(
                        'type'=>'Bar',
                        'item_id'=>$item_id,
                        'qty'=>$chocopeanut_bar
                        );
        $batch_array[] = $data;
    }

    if($chocopeanut_box!=null)
    {
        $item_id = 9;
        $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$chocopeanut_box
                        );
        $batch_array[] = $data;
    }

    if($bambaiyachaat_bar!=null)
    {
        $item_id = 4;
        $data = array(
                        'type'=>'Bar',
                        'item_id'=>$item_id,
                        'qty'=>$bambaiyachaat_bar
                        );
        $batch_array[] = $data;
    }

    if($bambaiyachaat_box!=null)
    {
        $item_id = 8;
        $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$bambaiyachaat_box
                        );
        $batch_array[] = $data;
    }

    if($mangoginger_bar!=null)
    {
       $item_id = 6;
       $data = array(
                        'type'=>'Bar',
                        'item_id'=>$item_id,
                        'qty'=>$mangoginger_bar
                        );
        $batch_array[] = $data;
    }

    if($mangoginger_box!=null)
    {
       $item_id = 12;
       $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$mangoginger_box
                        );
        $batch_array[] = $data;
    }

    if($berry_blast_bar!=null)
    {
       $item_id = 9; 
       $data = array(
                        'type'=>'Bar',
                        'item_id'=>$item_id,
                        'qty'=>$berry_blast_bar
                        );

        $batch_array[] = $data;
    }

    if($berry_blast_box!=null)
    {
       $item_id = 29;
       $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$berry_blast_box
                        );

        $batch_array[] = $data;
    }

    if($chyawanprash_bar!=null)
    {
       $item_id = 10; 
       $data = array(
                        'type'=>'Bar',
                        'item_id'=>$item_id,
                        'qty'=>$chyawanprash_bar
                        );
        $batch_array[] = $data;
    }

    if($chyawanprash_box!=null)
    {
       $item_id = 31; 
       $data = array(
                        'type'=>'Box',
                        'item_id'=>$item_id,
                        'qty'=>$chyawanprash_box
                        );
        $batch_array[] = $data;
    }

    if($variety_box!=null)
    {
        $item_id = 32;
        
        $data = array(
                        'type'=>'Box',
                        'item_id'=>32,
                        'qty'=>$variety_box
                        );
        $batch_array[] = $data;
    }  
            
    
    $this->session->set_userdata('merchandiser_stock_details', $batch_array);
    /*if(count($batch_array)!='')
     {
        $this->db->insert_batch('merchandiser_stock_details',$batch_array);
     }*/ 

    /*die();*/

    /*print_r($this->session->all_userdata());

    die();*/
}


public function FunctionName($value='')
{
    # code...
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


function getWeeks($date, $rollover)
{
    $cut = substr($date, 0, 8);
    $daylen = 86400;

    $timestamp = strtotime($date);
    $first = strtotime($cut . "00");
    $elapsed = ($timestamp - $first) / $daylen;

    $weeks = 1;

    for ($i = 1; $i <= $elapsed; $i++)
    {
        $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
        $daytimestamp = strtotime($dayfind);

        $day = strtolower(date("l", $daytimestamp));

        if($day == strtolower($rollover))  $weeks ++;
    }

    return $weeks;
}

function get_distributors(){
        $sales_rep_id = $this->session->userdata('sales_rep_id');
        $sql = "SELECT * from distributor_master Where type_id=8 and `status`='Approved'";
        $query=$this->db->query($sql);
        return $query->result();
}


public function get_mtfollowup($id='',$temp_date='')
{
    $cond= '';
	$sales_rep_id=$this->session->userdata('sales_rep_id');
    if($id!='')
        $cond=" and id=".$id;

    if($temp_date!='')
    {
        //$date = date('Y-m');
        $date = '"'.$temp_date.'"';
    }
    else
    {
        $date = "date(now())";
    }

    $sql = "SELECT Distinct A.*, D.is_edit, D.is_visited  from 
            (Select A.dist_id as store_id, R.store_name, D.zone, A.zone_id, R.store_name as relation, C.location, 
                A.location_id, A.id as merchandiser_stock_id, 'Old' as distributor_type, distributor_status,A.remarks from 
            (SELECT * from merchandiser_stock Where date(followup_date)=$date  and m_id=$sales_rep_id ".$cond.")A
            left JOIN
            (Select * from relationship_master) R
            ON (A.dist_id=R.id) 
            Left join
            (select * from store_master) M  
            On (A.dist_id=M.store_id and A.zone_id=M.zone_id and A.location_id=M.location_id) 
            left join
            (select * from location_master) C
            On A.location_id=C.id
            left join
            (select * from zone_master) D
            On A.zone_id=D.id ) A
            left JOIN
            (SELECT dist_id, created_on, id as is_edit, is_visited, zone_id, location_id from merchandiser_stock ) D 
            on (D.dist_id=A.store_id and D.zone_id=A.zone_id and D.location_id=A.location_id and D.is_visited=1)";;
    $result = $this->db->query($sql)->result();
    return $result;
}

public function get_gtfollowup($id='',$temp_date='')
{
   $cond= '';
   $sales_rep_id=$this->session->userdata('sales_rep_id');
   if($id!='')
        $cond="Where id=".$id;

    if($temp_date!='')
    {
        //$date = date('Y-m');
        $date = '"'.$temp_date.'"';
    }
    else
    {
        $date = "date(now())";
    }


   $sql = "SELECT Distinct A.*,B.*,D.is_edit,D.is_visited from 
            (SELECT A.*,B.distributor_name from 
            (SELECT id ,id as sales_rep_loc_id  ,zone_id,location_id,area_id,distributor_id as store_id,followup_date,distributor_type,distributor_status,remarks
                from  sales_rep_location Where date(followup_date)=$date and sales_rep_id=$sales_rep_id) A
            left JOIN
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
            ) B On A.store_id=B.id
            ) A
            Left JOIN
            (SELECT id as stock_id , sales_rep_loc_id 
 from  sales_rep_distributor_opening_stock) B On A.id=B.sales_rep_loc_id 
 left JOIN
(SELECT distributor_id,created_on,id as is_edit,is_visited from  sales_rep_location ) D on (D.distributor_id=A.store_id and D.is_visited=1)
 ".$cond;
    $result = $this->db->query($sql)->result();
    return $result;
}


function get_merchendiser_data($status='', $id='',$frequency='',$temp_date=''){
        $cond2="";
      if($status!=""){
          $cond=" Where status='".$status."'";
      } else {
          $cond="";
      }


      $sales_rep_id=$this->session->userdata('sales_rep_id');
      
      if($id!=""){
          $cond2=" Where G.id=$id ";
      }
      else
      {
          $cond2='';
      }
	  
	  if($temp_date!='')
  {
    $temp_date = date("Y-m-d",strtotime($temp_date));
    // $temp_date = '"'.$temp_date.'"';
  }
  else
  {
    $temp_date = date("Y-m-d");
  }
    

     $sql = "Select sequence from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id  and  date(date_of_visit)='$temp_date'";
     $result=$this->db->query($sql)->result_array();

    if(count($result)>0)
    {
      /*$sql = "Select sequence from merchandiser_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id";
      $result2=$this->db->query($sql)->result_array();
      if($result==$result2)
      {
         
          if($frequency!=""){
              $cond.=" and frequency='$frequency'";
          }
     
          $table_name = 'select * ,id as bit_plan_id from  merchandiser_beat_plan ';
      }
      else
      {   
          $frequency;
          if($frequency!=""){
              $cond.=" and frequency='$frequency' and  date(date_of_visit)=date(now())";
          }
          $table_name = 'select * from  merchandiser_detailed_beat_plan ';
      }*/

      $frequency;
      if($frequency!=""){
          $cond.=" and frequency='$frequency' and  date(date_of_visit)='$temp_date'";
      }
      $table_name = 'select * ,id as bit_id  from  merchandiser_detailed_beat_plan ';
      
    }
    else
    {
          if($frequency!=""){
              $cond.=" and frequency='$frequency' ";
          }
           $table_name = 'select *,id as bit_plan_id,id as bit_id  from merchandiser_beat_plan ';
    }

    $sql = "select Distinct G.*,H.date_of_visit,H.dist_id,H.id as mid,B.location,'Old' as distributor_type,H.remarks from (select E.*,F.sales_rep_name from(select C.*, D.google_address,D.latitude,D.longitude from (select A.*,B.store_name from 
      (".$table_name.$cond.' and sales_rep_id='.$sales_rep_id.") A 
      left join 
      (SELECT * FROM relationship_master where type_id ='4' or type_id='7') B 
      on (A.store_id=B.id))C
        left join 
        (select * from store_master) D 
          on (C.zone_id=D.zone_id and C.store_id=D.store_id and C.location_id=D.location_id))E
         left join 
        (select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc ) F 
          on (E.sales_rep_id=F.id))G
        left join
        (select * from merchandiser_stock 
          Where date(date_of_visit)='$temp_date') H
        on(G.store_id=H.dist_id and G.location_id=H.location_id and G.zone_id=H.zone_id and G.id=H.detailed_bit_plan_id)
      left join
          (select * from location_master) B 
      on (G.location_id=B.id )
          ".$cond2." 
      order by G.sequence asc,G.modified_on Desc
      ";

      // echo $sql;
      // echo '<br/>';

      $query=$this->db->query($sql);
      return $query->result();
}

public function get_todaysorder()
{
    $sales_rep_id=$this->session->userdata('sales_rep_id');
      
  $sql = "select * from(select H.*, I.distributor_name as distributor from (select F.*, G.location from (select D.*, E.location_id from (SELECT C.distributor_name ,A.visit_id, A.selected_distributor, A.id as order_id from 
            (SELECT * from sales_rep_orders Where date(created_on)=date(now()) and sales_rep_id=$sales_rep_id and channel_type='GT' and id IN (Select Distinct sales_rep_order_id from sales_rep_order_items))A
            Left join 
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
            ) C ) C
            On A.distributor_id=C.id)D 
			left join(select * from sales_rep_location)E
			on(D.visit_id=E.id))F left join
			(select * from location_master)G
			on(F.location_id=G.id))H left join
			 (Select * from distributor_master )I
			 on(H.selected_distributor=I.id)
            Union
			select H.*, I.distributor_name as distributor from (select F.*, G.location from (select D.*, E.location_id from (SELECT C.distributor_name ,A.visit_id, A.selected_distributor, A.id as order_id from 
            ( SELECT * from sales_rep_orders Where date(created_on)=date(now()) and sales_rep_id=$sales_rep_id and channel_type='GT' and id IN (Select Distinct sales_rep_order_id from sales_rep_order_items))A
            left join 
            (SELECT * from sales_rep_distributors) C
            On A.distributor_id=C.id)D 
			left join(select * from sales_rep_location)E
			on(D.visit_id=E.id))F left join
			(select * from location_master)G
			on(F.location_id=G.id))H left join
			 (Select * from distributor_master )I
			 on(H.selected_distributor=I.id)
			Union	
			select H.*, I.distributor_name as distributor from (select F.*, G.location from (select D.*, E.location_id from (SELECT C.store_name as distributor_name ,A.visit_id, A.selected_distributor, A.id as order_id from 
            ( SELECT * from sales_rep_orders Where date(created_on)=date(now()) and sales_rep_id=$sales_rep_id and channel_type='MT' and id IN (Select Distinct sales_rep_order_id from sales_rep_order_items))A
            left join 
            (SELECT * from relationship_master) C
            On A.distributor_id=C.id)D 
			left join(select * from merchandiser_stock)E
			on(D.visit_id=E.id))F left join
			(select * from location_master)G
			on(F.location_id=G.id))H left join
			 (Select * from distributor_master )I
			 on(H.selected_distributor=I.id))J where distributor_name<>'Null'
            ";
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_pendingsorder()
{
    $sales_rep_id=$this->session->userdata('sales_rep_id');
      
    $sql = "select * from(select H.*, I.distributor_name as distributor from (select F.*, G.location from (select D.*, E.location_id from (SELECT C.distributor_name ,A.visit_id, A.selected_distributor, A.id as order_id from 
            (SELECT * from sales_rep_orders Where date(created_on)> date('2019-01-01') and sales_rep_id=$sales_rep_id and channel_type='GT' and id IN (Select Distinct sales_rep_order_id from sales_rep_order_items))A
            Left join 
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
            ) C ) C
            On A.distributor_id=C.id)D 
			left join(select * from sales_rep_location)E
			on(D.visit_id=E.id))F left join
			(select * from location_master)G
			on(F.location_id=G.id))H left join
			 (Select * from distributor_master )I
			 on(H.selected_distributor=I.id)
            Union
			select H.*, I.distributor_name as distributor from (select F.*, G.location from (select D.*, E.location_id from (SELECT C.distributor_name ,A.visit_id, A.selected_distributor, A.id as order_id from 
            ( SELECT * from sales_rep_orders Where date(created_on)> date('2019-01-01') and sales_rep_id=$sales_rep_id and channel_type='GT' and id IN (Select Distinct sales_rep_order_id from sales_rep_order_items))A
            left join 
            (SELECT * from sales_rep_distributors) C
            On A.distributor_id=C.id)D 
			left join(select * from sales_rep_location)E
			on(D.visit_id=E.id))F left join
			(select * from location_master)G
			on(F.location_id=G.id))H left join
			 (Select * from distributor_master )I
			 on(H.selected_distributor=I.id)
			Union	
			select H.*, I.distributor_name as distributor from (select F.*, G.location from (select D.*, E.location_id from (SELECT C.store_name as distributor_name ,A.visit_id, A.selected_distributor, A.id as order_id from 
            ( SELECT * from sales_rep_orders Where date(created_on)>date('2019-01-01') and sales_rep_id=$sales_rep_id and channel_type='MT' and id IN (Select Distinct sales_rep_order_id from sales_rep_order_items))A
            left join 
            (SELECT * from relationship_master) C
            On A.distributor_id=C.id)D 
			left join(select * from merchandiser_stock)E
			on(D.visit_id=E.id))F left join
			(select * from location_master)G
			on(F.location_id=G.id))H left join
			 (Select * from distributor_master )I
			 on(H.selected_distributor=I.id))J where distributor_name<>'Null'
            ";
    $query=$this->db->query($sql);
    return $query->result();
}

}
?>