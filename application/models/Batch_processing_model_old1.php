<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Batch_processing_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Batch_Processing' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_pending_data($id=''){
    $query=$this->db->query("SELECT * FROM batch_processing WHERE ref_id = '$id' and status!='InActive'");
    $result=$query->result();
    if (count($result)>0){
        $id = $result[0]->id;
    }

    return $id;
}


function get_data($status='', $id=''){
     if($status!=""){
        if($status=="Pending"){
            $cond=" where status='Pending' or status='Deleted'";
        } else{
            $cond=" where status='".$status."'";
        }
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

    $sql = "select C.*, D.depot_name, E.batch_no from 
            (select A.*, B.product_name from 
            (select * from batch_processing".$cond.") A 
            left join 
            (select * from product_master) B 
            on (A.product_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id)
            left join 
            (select * from batch_master) E 
            on (C.batch_no_id=E.id) order by C.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_batch_raw_material($id){
    $sql = "select A.*, B.rm_name from 
            (select * from batch_raw_material where batch_processing_id = '$id') A 
            left join 
            (select * from raw_material_master) B 
            on (A.raw_material_id=B.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

 function get_batch_images($id){
    $query=$this->db->query("SELECT * FROM batch_images WHERE batch_processing_id = '$id'");
               return $query->result();
 }
	  
               


function save_data($id='') {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    }
    else{
        $date_of_processing=formatdate($date_of_processing);
    }

      if($this->input->post('btn_approve')!=null || $this->input->post('btn_reject')!=null){
        if($this->input->post('btn_approve')!=null){
            if($this->input->post('status')=="Deleted"){
                $status = 'InActive';
            } else {
                $status = 'Approved';
            }
        } else {
            $status = 'Rejected';
        }

        $ref_id = $this->input->post('ref_id');

        $remarks = $this->input->post('remarks');

        if($status == 'Rejected'){
            $sql = "Update batch_processing Set status='$status', approved_by='$curusr', approved_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Payment Entry '.$status.'.';
        } else {
            if($id!='' || $ref_id!=''){
                if($ref_id!=null && $ref_id!=''){
                    $sql = "Update batch_processing A, batch_processing B 
                            Set A.batch_id_as_per_fssai=B.batch_id_as_per_fssai, A.batch_no_id=B.batch_no_id, A.date_of_processing=B.date_of_processing,
                                A.depot_id=B.depot_id,
                                A.product_id=B.product_id,
                                A.qty_in_bar=B.qty_in_bar,
                                A.actual_wastage=B.actual_wastage,
                                A.wastage_percent=B.wastage_percent,
                                A.anticipated_wastage=B.anticipated_wastage,
                                A.wastage_variance=B.wastage_variance,
                                A.total_kg=B.total_kg,
                                A.output_kg=B.output_kg,
                                A.avg_grams=B.avg_grams,
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from batch_processing where id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from batch_raw_material WHERE batch_processing_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update batch_raw_material set batch_processing_id='$ref_id' WHERE batch_processing_id = '$id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {
                    $sql = "Update batch_raw_material A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

                $action='batch_raw_material '.$status.'.';
            }
        }
    }
    else
    {

        if($this->input->post('btn_delete')!=null){
            if($this->input->post('status')=="Approved"){
                $status = 'Deleted';
            } else {
                $status = 'InActive';
            }
        } else {
            $status = 'Pending';
        }

        $this->input->post('status');

        if($this->input->post('status')=="Approved"){
            $ref_id = $id;
            $id = '';
        } else {
            $ref_id = $this->input->post('ref_id');
        }

        if($ref_id==""){
            $ref_id = null;
        }

        $data = array(
            'batch_id_as_per_fssai' => $this->input->post('batch_id_as_per_fssai'),
            'batch_no_id' => $this->input->post('batch_no_id'),
            'date_of_processing' => $date_of_processing,
            'depot_id' => $this->input->post('depot_id'),
            'no_of_batch' => $this->input->post('no_of_batch'),
            'product_id' => $this->input->post('product_id'),
         

            'qty_in_bar' => format_number($this->input->post('qty_in_bar'),2),
            'actual_wastage' => format_number($this->input->post('actual_wastage'),2),
            'wastage_percent' => format_number($this->input->post('wastage_percent'),2),
            'anticipated_wastage' => format_number($this->input->post('anticipated_wastage'),2),
            'wastage_variance' => format_number($this->input->post('wastage_variance'),2),
            'total_kg' => format_number($this->input->post('total_kg'),2),
            'output_kg' => format_number($this->input->post('output_kg'),2),
            'avg_grams' => format_number($this->input->post('avg_grams'),2),
            'status' =>  $status,
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id
        );

        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            if($this->input->post('status')=="Approved"){
                $action='Batch Processing Entry Modified.';
            } else {
                $action='Batch Processing Entry Created.';
            }

           $this->db->insert('batch_processing',$data);
            $id=$this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('batch_processing',$data);
            $action='Payment Entry Modified.';
        }


        $this->db->where('batch_processing_id', $id);
        $this->db->delete('batch_raw_material');

        $raw_material_id=$this->input->post('raw_material_id[]');
        $qty=$this->input->post('qty[]');

        for ($k=0; $k<count($raw_material_id); $k++) {
            if(isset($raw_material_id[$k]) and $raw_material_id[$k]!="") {
                $data = array(
                            'batch_processing_id' => $id,
                            'raw_material_id' => $raw_material_id[$k],
                            'qty' => format_number($qty[$k],2)
                        );
                $this->db->insert('batch_raw_material', $data);
            }
        }
        
        if($id!="") {
           $this->db->where('batch_processing_id', $id);
           $this->db->delete('batch_images');
        }
        
        $title=$this->input->post('title[]');
        $image_path=$this->input->post('image_path[]');
        $receivable_doc=$this->input->post('receivable_doc[]');
        
        for ($k=0; $k<count($title); $k++) {
            if(isset($title[$k]) and $title[$k]!="") {
                $image='image_'.$k;

                if(!empty($_FILES[$image]['name'])) {
                    $filePath='uploads/batch_doc/';
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
                                'batch_processing_id'=> $id,    
                                'image' => $filePath.$fileName,
                                'title' => $title[$k],
                                'receivable_doc' =>$fileName
                            );

                    $this->db->insert('batch_images', $data);
                } else {
                    $data = array(
                                'batch_processing_id'=> $id,    
                                'image' => $image_path[$k],
                                'title' => $title[$k],
                                'receivable_doc' =>$receivable_doc[$k]
                            );

                    $this->db->insert('batch_images', $data);
                }
            }
        }

    }
    
  

            // for ($k=0; $k<count($title); $k++) {
                // if(isset($docname[$k]) and $docname[$k]!="") {
                // if(isset($title[$k]) and $title[$k]!="") {
             

                   
                  // $filePath='uploads/distributor_receivables/';
					// $upload_path = './' . $filePath;
					// if(!is_dir($upload_path)) {
					// mkdir($upload_path, 0777, TRUE);
				// }

                   

                    // $confi['upload_path']=$upload_path;
                    // $confi['allowed_types']='*';
                    // $this->load->library('upload', $confi);
                    // $this->upload->initialize($confi);
                    // $extension="";

                    // $file_nm='doc_'.$doccnt;

                    // while (!isset($_FILES[$file_nm])) {
                        // $doccnt = $doccnt + 1;
                        // $file_nm = 'doc_'.$doccnt;
                    // }

                    // if(!empty($_FILES[$file_nm]['name'])) {
                        // if($this->upload->do_upload($file_nm)) {
                            // echo "Uploaded <br>";
                        // } else {
                            // echo "Failed<br>";
                            // echo $this->upload->data();
                        // }   

                        // $upload_data=$this->upload->data();
                        // $fileName=$upload_data['file_name'];
                        // $extension=$upload_data['file_ext'];
                            
                        // $data = array(
                         
                            // 'title' => $title[$k],
                          
                          
                            // 'doc_document' => $filePath.$fileName,
                            // 'document_name' => $fileName
                        // );
                        // $this->db->insert('batch_images', $data);
                    // } else {
                        // if($file_path_count>=$k) {
                            // $path=$file_path_db[$k]['docpath'];
                            // $flnm=$file_path_db[$k]['docfilename'];
                        // } else {
                            // $path="";
                            // $flnm="";
                        // }

                        // $data = array(
                         // 'title' => $title[$k],
                            // 'doc_document' => $docdocument[$k],
                            // 'document_name' => $documentname[$k]
                        // );
                        // $this->db->insert('batch_images', $data);
                    // }
                // }

                // $doccnt = $doccnt + 1;

                // if($k!=count($docname)-1) {
                    // $file_nm='doc_'.$doccnt;

                    // while (!isset($_FILES[$file_nm])) {
                        // $doccnt = $doccnt + 1;
                        // $file_nm = 'doc_'.$doccnt;
                    // }
                // }
            // }

    $logarray['table_id']=$id;
    $logarray['module_name']='Batch_Processing';
    $logarray['cnt_name']='Batch_Processing';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

}

function get_batch_raw_material1($product_id){
	     $product_id=$this->input->post('id');
	   
     $sql = 
			"select C.rm_id,C.qty_per_batch, D.rm_name from (select A.*, B.ing_id,B.rm_id,B.qty_per_batch,B.rm_name from 
			( select * from ingredients_master) A 
            left join 
            (select * from ingredients_details) B 
            on (B.ing_id=A.id))C
			 left join 
            (select * from raw_material_master) D
            on (C.rm_id=D.id)  where  C.product_id='$product_id'";
			
	// $sql = "select A.*, B.rm_name from 
            // (select * from ingredients_details where ing_id = '$id') A 
            // left join 
            // (select * from raw_material_master) B 
            // on (A.rm_id=B.id)";		
    $query=$this->db->query($sql);
    return $query->result();
}
	

	

function check_batch_id_availablity(){
    $id=$this->input->post('id');
    $batch_id_as_per_fssai=$this->input->post('batch_id_as_per_fssai');

    // $id="";

    $query=$this->db->query("SELECT * FROM batch_processing WHERE id!='".$id."' and batch_id_as_per_fssai='".$batch_id_as_per_fssai."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}
}
?>