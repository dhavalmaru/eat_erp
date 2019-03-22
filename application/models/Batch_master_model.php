<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Batch_master_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Batch_Master' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from batch_master".$cond." order by updated_date desc";
    $query=$this->db->query($sql);
    return $query->result();
}

 function get_batch_doc($id){
    $query=$this->db->query("SELECT * FROM batch_master_doc WHERE batch_master_id = '$id'");
    return $query->result();
 }

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    } else {
        $date_of_processing=formatdate($date_of_processing);
    }
    
    $data = array(
        'batch_no' => $this->input->post('batch_no'),
        'production_id' => $this->input->post('production_id'),
        'date_of_processing' => $date_of_processing,
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'updated_by' => $curusr,
        'updated_date' => $now
    );
    // echo $data;
    if($id==''){
        $data['created_by']=$curusr;
        $data['created_date']=$now;

        $this->db->insert('batch_master',$data);
        $id=$this->db->insert_id();
        $action='Batch No Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('batch_master',$data);
        $action='Batch No Modified.';
    }

    if($id!="") {
	   $this->db->where('batch_master_id', $id);
       $this->db->delete('batch_master_doc');
    }
	
	$title=$this->input->post('title[]');
    $image_path=$this->input->post('image_path[]');
	$receivable_doc=$this->input->post('receivable_doc[]');
	
    for ($k=0; $k<count($title); $k++) {
        if(isset($title[$k]) and $title[$k]!="") {
            $doc_img='doc_img_'.$k;

            if(!empty($_FILES[$doc_img]['name'])) {
                $filePath='uploads/batch_master_doc/';
                $upload_path = './' . $filePath;
                if(!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $fileName = $_FILES[$doc_img]['name'];
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

                if($this->upload->do_upload($doc_img)) {
                    echo "Uploaded <br>";
                } else {
                    echo "Failed<br>";
                    echo $this->upload->data();
                }   

                $upload_data=$this->upload->data();
                $fileName=$upload_data['file_name'];
                $extension=$upload_data['file_ext'];

                $data = array(
                            'batch_master_id'=> $id,	
                            'doc_img' => $filePath.$fileName,
                            'title' => $title[$k],
                            'receivable_doc' =>$fileName
                        );

                $this->db->insert('batch_master_doc', $data);
            } else {
                $data = array(
                            'batch_master_id'=> $id,    
                            'doc_img' => $image_path[$k],
                            'title' => $title[$k],
                            'receivable_doc' =>$receivable_doc[$k]
                        );

                $this->db->insert('batch_master_doc', $data);
            }
        }
    }
	
    $logarray['table_id']=$id;
    $logarray['module_name']='Batch_Master';
    $logarray['cnt_name']='Batch_Master';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    $module = $this->input->post('module');
    $production_id = $this->input->post('production_id');
    if($module=='production'){
        $sql = "update production_details set batch_master = '1' where id = '$production_id'";
        $this->db->query($sql);

        redirect(base_url().'index.php/production/post_details/'.$production_id);
    } else {
        redirect(base_url().'index.php/batch_master');
    }
}

function check_batch_id_availablity(){
    $id=$this->input->post('id');
    $batch_no=$this->input->post('batch_no');

    // $id="";

    $query=$this->db->query("select * from batch_master where id!='".$id."' and batch_no='".$batch_no."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>