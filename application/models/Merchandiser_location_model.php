<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Merchandiser_location_model Extends CI_Model{

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
	

  $sql = "Select sequence from merchandiser_detailed_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id  and  date(date_of_visit)=date(now())";
  $result=$this->db->query($sql)->result_array();

      if(count($result)>0)
      {
        $sql = "Select sequence from merchandiser_beat_plan Where frequency='$frequency' and sales_rep_id=$sales_rep_id";
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
            echo  'frequency'.$frequency;
            if($frequency!=""){
                $cond.=" and frequency='$frequency' and  date(date_of_visit)=date(now())";
            }
            $table_name = 'select * from  merchandiser_detailed_beat_plan ';
        }
      }
      else
      {
            if($frequency!=""){
                $cond.=" and frequency='$frequency' ";
            }
             $table_name = 'select *,id as bit_plan_id  from merchandiser_beat_plan ';
      }

     $sql = "select G.*,H.date_of_visit,H.dist_id,H.id as mid,H.location_id from (select E.*,F.sales_rep_name from(select C.*, D.google_address,D.latitude,D.longitude from (select A.*,B.store_name from 
            (".$table_name.$cond.' and sales_rep_id='.$sales_rep_id.") A 
            left join 
            (SELECT * FROM relationship_master where type_id ='4' or type_id='7') B 
            on (A.store_id=B.id))C
    		left join 
    		(select * from store_master) D 
            on (C.store_id=D.store_id))E
    		 left join 
    		(select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc ) F 
            on (E.sales_rep_id=F.id))G
    		left join
    		(select * from merchandiser_stock 
            Where date(date_of_visit)=date(now())) H
    		on(G.store_id=H.dist_id) and (G.location_id=H.location_id)
            ".$cond2."
            GROUP by store_id,frequency,sequence,sales_rep_id,
            bit_plan_id,status 
            order by G.sequence asc,G.modified_on Desc
            ";


    $query=$this->db->query($sql);
    return $query->result();
}

function get_dist_list() {
    $sql = "select id,store_name from promoter_stores";
            
    $query=$this->db->query($sql);
    return $query->result();
}

function get_merchandiser_stock_details($id){
    echo $sql = "select * from merchandiser_stock_details where merchandiser_stock_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

 function get_merchandiser_stock_images($id){
    $query=$this->db->query("SELECT * FROM merchandiser_images WHERE merchandiser_stock_id = '$id'");
    return $query->result();
 }

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $sales_rep_id=$this->session->userdata('sales_rep_id');
    $date_of_visit=$this->input->post('date_of_visit');
    $seq_id=$this->input->post('seq_id');
    $sequence=$this->input->post('sequence');
    $frequency=$this->input->post('frequency');
    $merchendiser_beat_plan_id=$this->input->post('merchendiser_beat_plan_id');

    if($date_of_visit==''){
        $date_of_visit=NULL;
    } else {
        $date_of_visit=formatdate($date_of_visit);
    }
    $ispermenant  = $this->input->post('ispermenant');
    $data = array(
        'm_id' => $sales_rep_id,
        'date_of_visit' => $date_of_visit,
        'dist_id' => $this->input->post('distributor_id'),
        'latitude' => $this->input->post('latitude'),
        'longitude' => $this->input->post('longitude'),
        'seq' => $this->input->post('seq'),
        'sequence' => $this->input->post('sequence'),
        'remarks' => $this->input->post('remarks'),
        'location_id' => $this->input->post('location_id'),
        'created_by' => $curusr,
        'created_date' => $now,
        // 'orange_bar' => $this->input->post('orange_bar'),
        //   'mint_bar' => $this->input->post('mint_bar'),
        // 'butterscotch_bar' => $this->input->post('butterscotch_bar'),
        // 'chocopeanut_bar' => $this->input->post('chocopeanut_bar'),
        // 'bambaiyachaat_bar' => $this->input->post('bambaiyachaat_bar'),
        // 'mangoginger_bar' => $this->input->post('mangoginger_bar'),
        // 'berry_bar' => $this->input->post('berry_bar'),
        // 'chywanprash_bar' => $this->input->post('chywanprash_bar'),
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_date']=$now;

        $this->db->insert('merchandiser_stock',$data);
        $id=$this->db->insert_id();
        $action='Merchandiser Location Created.';

        
        $sql = "Select max(sequence) as sequence from merchandiser_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and is_edit='edit'";
        $get_maxcount = $this->db->query($sql)->result_array();
        $visited_sequence = $get_maxcount[0]['sequence']+1;


        $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and date(date_of_visit)=date(now()) and frequency='$frequency'";
        $detailed_result = $this->db->query($sql)->result_array();
           
        if(count($detailed_result)>0)
         {
            echo $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) ";
              $result = $this->db->query($sql)->result_array();
              $this->db->last_query();
              for ($j=0; $j < count($result); $j++) 
              {   
                if($result[$j]['sequence']<$sequence && $result[$j]['is_edit']!='edit')
                {
                    $newsequence = $result[$j]['sequence']+1;
                    $new_id = $result[$j]['id'];
                     $data = array('sequence'=>$newsequence,
                                    'modified_on'=>$now);
                    $this->db->where('id', $new_id);
                    $this->db->update('merchandiser_detailed_beat_plan',$data);
                    echo $this->db->last_query();
                }
              }

                $data = array('sequence'=>$visited_sequence,
                         'date_of_visit'=> $now,
                         'modified_on'=>$now,
                         'is_edit'=>'edit');

                $where = array('bit_plan_id'=>$merchendiser_beat_plan_id,
                                'date(date_of_visit)'=>date('Y-m-d'));

                $this->db->where($where);
                $this->db->update('merchandiser_detailed_beat_plan',$data);
                echo $this->db->last_query();
         }
         else
         {
                $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                $result = $this->db->query($sql)->result_array();
                $this->db->last_query();

                for ($j=0; $j < count($result); $j++) 
                  { 
                    if($result[$j]['sequence']<$sequence)
                    {
                        $new_id = $result[$j]['id'];
                        $store_id = $result[$j]['store_id'];
                        $newsequence = $result[$j]['sequence']+1;
                        $location_id = $result[$j]['location_id'];
                        $zone_id = $result[$j]['zone_id'];
                        $data = array('date_of_visit'=> $now,
                                      'sales_rep_id'=>$sales_rep_id,
                                      'sequence'=>$newsequence,
                                      'frequency'=>$frequency,
                                      'modified_on'=>$now,
                                      'bit_plan_id'=>$new_id,
                                      'store_id'=>$store_id,
                                      'location_id'=>$location_id,
                                      'zone_id'=>$zone_id,
                                      'status'=>'Approved');
                        $this->db->insert('merchandiser_detailed_beat_plan',$data);
                        echo $this->db->last_query();
                    }
                    else if($result[$j]['sequence']>$sequence)
                    {
                        $new_id = $result[$j]['id'];
                        $store_id = $result[$j]['store_id'];
                        $newsequence = $result[$j]['sequence'];
                        $location_id = $result[$j]['location_id'];
                        $zone_id = $result[$j]['zone_id'];
                        $data = array('date_of_visit'=> $now,
                              'sales_rep_id'=>$sales_rep_id,
                              'sequence'=>$newsequence,
                              'frequency'=>$frequency,
                              'modified_on'=>$now,
                              'bit_plan_id'=>$new_id,
                              'store_id'=>$store_id,
                              'location_id'=>$location_id,
                              'zone_id'=>$zone_id,
                              'status'=>'Approved');
                        $this->db->insert('merchandiser_detailed_beat_plan',$data);
                        echo $this->db->last_query();
                    }
                   
                  }

                  echo '<br>'.$sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence=$sequence ";
                    $result = $this->db->query($sql)->result_array();
                    $data = array('date_of_visit'=> $now,
                                  'sales_rep_id'=>$sales_rep_id,
                                  'sequence'=>$visited_sequence,
                                  'is_edit'=>'edit',
                                  'frequency'=>$frequency,
                                  'modified_on'=>$now,
                                  'bit_plan_id'=>$result[0]['id'],
                                  'store_id'=>$result[0]['store_id'],
                                  'location_id'=>$result[0]['location_id'],
                                  'zone_id'=>$result[0]['zone_id'],
                                  'status'=>'Approved');
                    $this->db->insert('merchandiser_detailed_beat_plan',$data);
                    echo $this->db->last_query();
         }

        /*if(count($detailed_result)>0)
        {
            $data = array('sequence'=>$visited_sequence,
                         'date_of_visit'=> $now,
                         'modified_on'=>$now,
                         'is_edit'=>'edit');

            $where = array('bit_plan_id'=>$merchendiser_beat_plan_id,
                            'date(date_of_visit)'=>date('Y-m-d'));

            $this->db->where($where);
            $this->db->update('merchandiser_detailed_beat_plan',$data);
            echo $this->db->last_query();
        }
        else
        { 
            echo $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence=$sequence ";
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
            $this->db->insert('merchandiser_detailed_beat_plan',$data);
            echo $this->db->last_query();
        }*/

        if($ispermenant=='Yes')
        {
            $sql = "UPDATE merchandiser_beat_plan m1
                    INNER JOIN merchandiser_detailed_beat_plan m2 ON 
                    m1.id=m2.bit_plan_id
                    SET m1.sequence = m2.sequence
                    Where m1.sales_rep_id=$sales_rep_id and m1.frequency='$frequency'";
            $result = $this->db->query($sql);
            $this->db->last_query();      
        }
        
    } else {
        
        $this->db->where('id', $id);
        $this->db->update('merchandiser_stock',$data);
        $action='Merchandiser Location Modified.';
    }

    $this->db->where('merchandiser_stock_id', $id);
    $this->db->delete('merchandiser_stock_details');

    $bar=$this->input->post('bar[]');
    $qty=$this->input->post('qty[]');
    // $month=$this->input->post('month[]');
    // $year=$this->input->post('year[]');
    $batch_no=$this->input->post('batch_no[]');

    for ($k=0; $k<count($bar); $k++) {
        if(isset($bar[$k]) && $bar[$k]!="") {
            if(isset($qty[$k]) && $qty[$k]!="") {
                $data = array(
                            'merchandiser_stock_id' => $id,
                            'item_id' => $bar[$k],
                            'qty' => format_number($qty[$k],2),
                            // 'month' => $month[$k],
                            // 'year' => $year[$k],
                            'batch_no' => $batch_no[$k]
                        );
                $this->db->insert('merchandiser_stock_details', $data);
            }
        }
    }
	

	   $this->db->where('merchandiser_stock_id', $id);
       $this->db->delete('merchandiser_images');
	
	$title=$this->input->post('title[]');
    $image_path=$this->input->post('image_path[]');
	$receivable_doc=$this->input->post('receivable_doc[]');
	
    for ($k=0; $k<count($title); $k++) {
        if(isset($title[$k]) and $title[$k]!="") {
            $image='image_'.$k;

            if(!empty($_FILES[$image]['name'])) {
                $filePath='uploads/merchandiser_images/';
                $upload_path = './' . $filePath;
                if(!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $fileName = $_FILES[$image]['name'];
                $extension = '';
                if(strrpos(".", $fileName)>0){
                    $extension = substr($fileName, strrpos(".", $fileName)+1);
                }
                $fileName = 'doc_'.($k+1).$extension;

                $confi['upload_path']=$upload_path;
                $confi['allowed_types']='*';
                $confi['file_name']=$fileName;
                $confi['overwrite'] = TRUE;
                $this->load->library('upload', $confi);
                $this->upload->initialize($confi);
                $extension="";

                if($this->upload->do_upload($image)) {
                    echo "Uploaded <br>";
                } else {
                    echo "Failed<br>";
                    echo $this->upload->data();
                }   

                $upload_data=$this->upload->data();
                $fileName=$upload_data['file_name'];
                $extension=$upload_data['file_ext'];

                $data = array(
                            'merchandiser_stock_id'=> $id,	
                            'image' => $filePath.$fileName,
                            'title' => $title[$k],
                            'receivable_doc' =>$fileName
                        );

                $this->db->insert('merchandiser_images', $data);
            } else {
                $data = array(
                            'merchandiser_stock_id'=> $id,    
                            'image' => $image_path[$k],
                            'title' => $title[$k],
                            'receivable_doc' =>$receivable_doc[$k]
                        );

                $this->db->insert('merchandiser_images', $data);
            }
        }
    }

   
    $logarray['table_id']=$id;
    $logarray['module_name']='Merchandiser_Location';
    $logarray['cnt_name']='Merchandiser_Location';
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