<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_rep_distributor_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep_Distributors' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sales_rep_id=$this->session->userdata('sales_rep_id');
    if($sales_rep_id!=""){
        $cond2=" where sales_rep_id='".$sales_rep_id."'";
    } else {
        $cond2="";
    }

    if($cond2=="") {
        $cond2=" where status != 'Active'";
    } else {
        $cond2=$cond2." and status != 'Active'";
    }

    $sql = "select G.* from 
            (select E.*, concat(ifnull(F.first_name,''),' ',ifnull(F.last_name,'')) as user_name from 
            (select concat('s_',id) as id, sales_rep_id, distributor_name, address, city, pincode, state, country, 
            vat_no, contact_person, contact_no, margin, doc_document, document_name, city as area, status, remarks, 
            modified_by, modified_on from sales_rep_distributors".$cond2." 
            union all 
            (select C.id, C.sales_rep_id, C.distributor_name, C.address, C.city, C.pincode, C.state, 
            C.country, C.vat_no, C.contact_person, C.contact_no, C.margin, C.doc_document, C.document_name, 
            D.area, C.status, C.remarks, C.modified_by, C.modified_on from 
            (select concat('d_',A.id) as id, A.sales_rep_id, A.distributor_name, A.address, A.city, A.pincode, A.state, 
            A.country, A.tin_number as vat_no, B.contact_person, B.mobile as contact_no, A.sell_out as margin, 
            null as doc_document, null as document_name, A.area_id, A.status, A.remarks, A.modified_by, A.modified_on from 
            (select * from distributor_master".$cond2.") A 
            left join 
            (select * from distributor_contacts) B 
            on (A.id = B.distributor_id)) C 
            left join 
            (select * from area_master) D 
            on (C.Area_id = D.id))) E 
            left join 
            (select * from user_master) F 
            on (E.modified_by=F.id)) G ".$cond." 
            order by distributor_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $sales_rep_id=$this->session->userdata('sales_rep_id');
    
    $data = array(
        'sales_rep_id' => $sales_rep_id,
        'distributor_name' => $this->input->post('distributor_name'),
        'address' => $this->input->post('address'),
        'city' => $this->input->post('city'),
        'pincode' => $this->input->post('pincode'),
        'state' => $this->input->post('state'),
        'country' => $this->input->post('country'),
        'vat_no' => $this->input->post('vat_no'),
        'contact_person' => $this->input->post('contact_person'),
        'contact_no' => $this->input->post('contact_no'),
        'margin' => $this->input->post('margin'),
        'doc_document' => $this->input->post('doc_document'),
        'document_name' => $this->input->post('document_name'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sales_rep_distributors',$data);
        $id=$this->db->insert_id();
        $action='Sales Rep Distributor Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('sales_rep_distributors',$data);
        $action='Sales Rep Distributor Modified.';
    }

    if(isset($_FILES['doc_file']['name'])) {
        $filePath='uploads/Sales_Rep_Distributors/';
        $upload_path = './' . $filePath;
        if(!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $filePath='uploads/Sales_Rep_Distributors/Distributor_'.$id.'/';
        $upload_path = './' . $filePath;
        if(!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $filePath='uploads/Sales_Rep_Distributors/Distributor_'.$id.'/documents/';
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

        if(!empty($_FILES[$file_nm]['name'])) {
            if($this->upload->do_upload($file_nm)) {
                // echo "Uploaded <br>";
            } else {
                // echo "Failed<br>";
                // echo $this->upload->data();
            }   

            $upload_data=$this->upload->data();
            $fileName=$upload_data['file_name'];
            $extension=$upload_data['file_ext'];
                
            $data = array(
                'doc_document' => $filePath.$fileName,
                'document_name' => $fileName
            );

            $this->db->where('id', $id);
            $this->db->update('sales_rep_distributors',$data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_Rep_Distributor';
    $logarray['cnt_name']='Sales_Rep_Distributor';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    return $id;
}

}
?>