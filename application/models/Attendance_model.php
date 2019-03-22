<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Attendance_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('accountledger_model');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id='', $class=''){
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

    if($class!=""){
        if($cond=="") {
            $cond=" where class='".$class."'";
        } else {
            $cond=$cond." and class='".$class."'";
        }
    }

    $sql = "select A.*, B.sales_rep_name from 
            (select * from distributor_master".$cond.") A 
            left join 
            (select * from sales_rep_master) B 
            on (A.sales_rep_id=B.id) order by A.distributor_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data_without_sample($status='', $id='', $class=''){
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

    if($class!=""){
        if($cond=="") {
            $cond=" where class='".$class."'";
        } else {
            $cond=$cond." and class='".$class."'";
        }
    }

    // $sql = "select A.*, B.sales_rep_name from 
    //         (select * from distributor_master".$cond.") A 
    //         left join 
    //         (select * from sales_rep_master) B 
    //         on (A.sales_rep_id=B.id) where A.distributor_name!='Sample' order by A.distributor_name asc";
    $sql = "select A.*, B.sales_rep_name from 
            (select * from distributor_master".$cond.") A 
            left join 
            (select * from sales_rep_master) B 
            on (A.sales_rep_id=B.id) where A.class!='sample' order by A.distributor_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data_with_sample($status='', $id='', $class=''){
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

    if($class!=""){
        if($cond=="") {
            $cond=" where class='".$class."'";
        } else {
            $cond=$cond." and class='".$class."'";
        }
    }

    // $sql = "select A.*, B.sales_rep_name from 
    //         (select * from distributor_master".$cond.") A 
    //         left join 
    //         (select * from sales_rep_master) B 
    //         on (A.sales_rep_id=B.id) where A.distributor_name='Sample' order by A.distributor_name asc";
    $sql = "select A.*, B.sales_rep_name from 
            (select * from distributor_master".$cond.") A 
            left join 
            (select * from sales_rep_master) B 
            on (A.sales_rep_id=B.id) where A.class='sample' order by A.id";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_data($status='', $id='', $class=''){
    if($status!=""){
        $cond=" where status='".$status."'";
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where d_id='".$id."'";
        } else {
            $cond=$cond." and d_id='".$id."'";
        }
    }

    if($class!=""){
        $cond2=" where class='".$class."'";
    } else {
        $cond2="";
    }

    $sql = "select D.*, E.sales_rep_name, G.location from 
            (select * from 
            ((select id, concat('d_', id) as d_id, distributor_name, address, city, pincode, state, country, email_id, mobile, 
                    tin_number, cst_number, contact_person, sales_rep_id, sell_out, send_invoice, credit_period, class, area_id, 
                    type_id, zone_id, location_id, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, 
                    rejected_by, rejected_on, google_address, doc_document, document_name, state_code, gst_number, latitude, longitude,tally_name, 
                    master_distributor_id 
                from distributor_master".$cond2.") 
              union all 
            (select id, concat('s_', id) as d_id, distributor_name, address, city, pincode, state, country, null as email_id, 
                    contact_no as mobile, vat_no as tin_number, null as cst_number, contact_person, sales_rep_id, 
                    margin as sell_out, null as send_invoice, null as credit_period, null as class, area_id, null as type_id, 
                    zone_id, location_id,'Pending' as status, remarks, created_by, created_on, modified_by, modified_on, 
                    approved_by, approved_on, rejected_by, rejected_on, null as google_address, doc_document, document_name, 
                    state_code, gst_number, null as latitude, null as longitude, null as tally_name, master_distributor_id 
                from sales_rep_distributors where status = 'Approved')) C ".$cond.") D 
            left join 
            (select * from sales_rep_master) E 
            on (D.sales_rep_id=E.id) 
            left join
            (select * from location_master) G
            on (G.id=D.location_id) order by D.distributor_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_contacts($id){
    $sql = "select * from distributor_contacts where distributor_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_consignee($id){
    $sql = "select * from distributor_consignee where distributor_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_shipping_state($id) {
    $sql = "select * from distributor_consignee where id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $distributor_name = $this->input->post('distributor_name');

    $data = array(
        'distributor_name' => $distributor_name,
        'address' => $this->input->post('address'),
        'city' => $this->input->post('city'),
        'pincode' => $this->input->post('pincode'),
        'state' => $this->input->post('state'),
        'country' => $this->input->post('country'),
        'google_address' => $this->input->post('google_address'),
        'email_id' => $this->input->post('d_email_id'),
        'mobile' => $this->input->post('d_mobile'),
        'tin_number' => $this->input->post('tin_number'),
        'cst_number' => $this->input->post('cst_number'),
        // 'contact_person' => $this->input->post('contact_person'),
        'sales_rep_id' => $this->input->post('sales_rep_id'),
        'sell_out' => $this->input->post('sell_out'),
        'send_invoice' => $this->input->post('send_invoice'),
        'credit_period' => $this->input->post('credit_period'),
        'class' => $this->input->post('class'),
        'area_id' => $this->input->post('area_id'),
        'type_id' => $this->input->post('type_id'),
        'zone_id' => $this->input->post('zone_id'),
        'location_id' => $this->input->post('location_id'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'doc_document' => $this->input->post('doc_document'),
        'document_name' => $this->input->post('document_name'),
        'state_code' => $this->input->post('state_code'),
        'gst_number' => $this->input->post('gst_number'),
        'latitude' => $this->input->post('d_latitude'),
        'longitude' => $this->input->post('d_longitude'),
        'tally_name' => $this->input->post('tally_name'),
        'master_distributor_id' => $this->input->post('master_distributor_id')
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        
        $this->db->insert('distributor_master',$data);
        $id=$this->db->insert_id();
        $action='Distributor Created.';


        // $data1 = array(
        //     'ledger_name' => $this->input->post('distributor_name'),
        //     'ledger_type' => 'Sales Distributor',
        //     'created_by' => $curusr,
        //     'created_date' => $now,
        //     'status' => 'Pending',
        //     'distributor_id' => $id
        // );

        // $this->db->insert('account_ledger_master',$data1);

    } else {
        $this->db->where('id', $id);
        $this->db->update('distributor_master',$data);
        $action='Distributor Modified.';

        // $data1 = array(
        //     'ledger_name' => $this->input->post('distributor_name'),
        //     'ledger_type' => 'Sales Distributor',
        //     'updated_by' => $curusr,
        //     'updated_date' => $now,
        //     'status' => 'Pending',
        // );

        // $this->db->where('distributor_id', $id);
        // $this->db->update('account_ledger_master',$data1);


    }

    if(isset($_FILES['doc_file']['name'])) {
        $filePath='uploads/Distributor/';
        $upload_path = './' . $filePath;
        if(!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $filePath='uploads/Distributor/Distributor_'.$id.'/';
        $upload_path = './' . $filePath;
        if(!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $filePath='uploads/Distributor/Distributor_'.$id.'/documents/';
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
            $this->db->update('distributor_master',$data);
        }
    }

    $this->db->where('distributor_id', $id);
    $this->db->delete('distributor_contacts');

    $contact_person=$this->input->post('contact_person[]');
    $email_id=$this->input->post('email_id[]');
    $mobile=$this->input->post('mobile[]');

    for ($k=0; $k<count($contact_person); $k++) {
        if(isset($contact_person[$k]) and $contact_person[$k]!="") {
            $data = array(
                        'distributor_id' => $id,
                        'contact_person' => $contact_person[$k],
                        'email_id' => $email_id[$k],
                        'mobile' => $mobile[$k]
                    );
            $this->db->insert('distributor_contacts', $data);
        }
    }

    $this->db->where('distributor_id', $id);
    $this->db->delete('distributor_consignee');

    $con_name=$this->input->post('con_name[]');
    $con_address=$this->input->post('con_address[]');
    $con_city=$this->input->post('con_city[]');
    $con_pincode=$this->input->post('con_pincode[]');
    $con_state=$this->input->post('con_state[]');
    $con_country=$this->input->post('con_country[]');
    $con_state_code=$this->input->post('con_state_code[]');
    $con_gst_number=$this->input->post('con_gst_number[]');

    for ($k=0; $k<count($con_name); $k++) {
        if(isset($con_name[$k]) and $con_name[$k]!="") {
            $data = array(
                        'distributor_id' => $id,
                        'con_name' => $con_name[$k],
                        'con_address' => $con_address[$k],
                        'con_city' => $con_city[$k],
                        'con_pincode' => $con_pincode[$k],
                        'con_state' => $con_state[$k],
                        'con_country' => $con_country[$k],
                        'con_state_code' => $con_state_code[$k],
                        'con_gst_number' => $con_gst_number[$k]
                    );
            $this->db->insert('distributor_consignee', $data);
        }
    }

    $d_id = $this->input->post('d_id');
    if(strrpos($d_id, "s_") !== false){
        $sql = "update sales_rep_distributors set status = 'Active', distributor_id = '$id', 
                modified_by = '$curusr', modified_on = '$now' 
                where id = '".substr($d_id, 2)."'";
        $this->db->query($sql);
    }

    $this->accountledger_model->set_ledger($id, 'Distributor', $distributor_name);

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor';
    $logarray['cnt_name']='Distributor';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_distributor_availablity(){
    $id=$this->input->post('id');
    $distributor_name=$this->input->post('distributor_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM distributor_master WHERE id!='".$id."' and distributor_name='".$distributor_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>