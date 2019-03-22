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
            $cond=" where A.status='Pending' or A.status='Deleted'";
        } else{
            $cond=" where A.status='".$status."'";
        }
    } else {
        $cond="";
    }


    if($id!=""){
        if($cond=="") {
            $cond=" where A.id='".$id."'";
        } else {
            $cond=$cond." and A.id='".$id."'";
        }
    }

    $sql = "select C.*, D.depot_name, E.batch_no from 
            (select A.*, B.product_name from 
            (select A.*, concat(B.first_name, ' ', B.last_name) as createdby, 
                concat(C.first_name, ' ', C.last_name) as modifiedby, 
                concat(D.first_name, ' ', D.last_name) as approvedby 
            from batch_processing A 
            left join user_master B on(A.created_by=B.id) 
            left join user_master C on(A.modified_by=C.id) 
            left join user_master D on(A.approved_by=D.id) ".$cond.") A 
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
    } else {
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
                                A.approved_by='$curusr', A.approved_on='$now', 
                                A.production_id=B.production_id, 
                                A.no_of_batch=B.no_of_batch, 
                                A.anticipated_water_loss=B.anticipated_water_loss, 
                                A.anticipated_output_in_kg=B.anticipated_output_in_kg, 
                                A.anticipated_grams=B.anticipated_grams, 
                                A.anticipated_output_in_bars=B.anticipated_output_in_bars, 
                                A.difference_in_bars=B.difference_in_bars, 
                                A.actual_water_loss=B.actual_water_loss, 
                                A.total_wastage=B.total_wastage, 
                                A.actual_wastage_percent=B.actual_wastage_percent 
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
                    $sql = "Update batch_processing A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

                $module = $this->input->post('module');
                $production_id = $this->input->post('production_id');
                if($module=='production'){
                    $sql = "update production_details set production_details = '1' where id = '$production_id'";
                    $this->db->query($sql);
                }

                $action='batch_raw_material '.$status.'.';
				echo '<script>var win = window.open("'.base_url().'index.php/batch_processing/view_batch_processing_receipt/'.$id.'") 	win.print();</script>';
            }
        }
    } else {
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
            'ref_id' => $ref_id,
            'production_id' => ($this->input->post('production_id')==''?'0':$this->input->post('production_id')),
            'anticipated_water_loss' => format_number($this->input->post('anticipated_water_loss'),2),
            'anticipated_output_in_kg' => format_number($this->input->post('anticipated_output_in_kg'),2),
            'anticipated_grams' => format_number($this->input->post('anticipated_grams'),2),
            'anticipated_output_in_bars' => format_number($this->input->post('anticipated_output_in_bars'),2),
            'difference_in_bars' => format_number($this->input->post('difference_in_bars'),2),
            'actual_water_loss' => format_number($this->input->post('actual_water_loss'),2),
            'total_wastage' => format_number($this->input->post('total_wastage'),2),
            'actual_wastage_percent' => format_number($this->input->post('actual_wastage_percent'),2)
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
            $action='Batch Processing Entry Modified.';
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
    
    $logarray['table_id']=$id;
    $logarray['module_name']='Batch_Processing';
    $logarray['cnt_name']='Batch_Processing';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    $module = $this->input->post('module');
    $production_id = $this->input->post('production_id');
    if($module=='production'){
        echo '<script>window.open("'.base_url().'index.php/production/post_details/'.$production_id.'", "_parent")</script>';
    } else {
        echo '<script>window.open("'.base_url().'index.php/batch_processing", "_parent")</script>';
    }
}

function get_batch_raw_material1($product_id){
	$product_id=$this->input->post('id');
	   
    $sql = "select C.rm_id,C.qty_per_batch, D.rm_name from 
            (select A.*, B.ing_id,B.rm_id,B.qty_per_batch,B.rm_name from 
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