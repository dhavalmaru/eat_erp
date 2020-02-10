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

function get_distributors(){
    $sales_rep_id = $this->session->userdata('sales_rep_id');
    $sql = "select B.* from sr_mapping A inner join distributor_master B 
            on (A.type_id = B.type_id and A.zone_id = B.zone_id and A.area_id = B.area_id) 
            where (A.reporting_manager_id = '$sales_rep_id' or A.sales_rep_id1 = '$sales_rep_id' or A.sales_rep_id2 = '$sales_rep_id') 
                and B.status = 'Approved' and B.class = 'super stockist'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_zone(){
    $sales_rep_id = $this->session->userdata('sales_rep_id');
    $sql = "select distinct A.zone_id, B.zone from sr_mapping A left join zone_master B on (A.zone_id = B.id) 
            where (A.reporting_manager_id = '$sales_rep_id' or A.sales_rep_id1 = '$sales_rep_id' or A.sales_rep_id2 = '$sales_rep_id') 
                    and B.type_id = '3'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_area($zone_id=''){
    $cond = '';
    if($zone_id!=''){
        $cond = $cond . " and B.zone_id = '$zone_id'";
    }
    $sales_rep_id = $this->session->userdata('sales_rep_id');
    $sql = "select distinct A.area_id, B.area from sr_mapping A left join area_master B on (A.area_id = B.id) 
            where (A.reporting_manager_id = '$sales_rep_id' or A.sales_rep_id1 = '$sales_rep_id' or A.sales_rep_id2 = '$sales_rep_id') 
                    and B.type_id = '3'" . $cond;
    $query=$this->db->query($sql);
    return $query->result();
}

function get_loc($zone_id='', $area_id=''){
    $cond = '';
    if($zone_id!=''){
        $cond = $cond . " and zone_id = '$zone_id'";
    }
    if($area_id!=''){
        $cond = $cond . " and area_id = '$area_id'";
    }
    $sql = "select * from location_master where status = 'Approved' and type_id = '3'" . $cond;
    $query=$this->db->query($sql);
    return $query->result();
}

function get_locations($zone_id='', $area_id=''){
    $sql = "select * from location_master where status  = 'Approved' and type_id = '3' and zone_id = '$zone_id' and area_id = '$area_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data($status='', $id=''){
    if($status!=""){
        $cond=" and status='".$status."'";
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" and id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }

    $sales_rep_id=$this->session->userdata('sales_rep_id');
    if($sales_rep_id!=""){
        $cond2=" where reporting_manager_id = '$sales_rep_id' or sales_rep_id1 = '$sales_rep_id' or sales_rep_id2 = '$sales_rep_id'";
    } else {
        $cond2="";
    }

    // if($cond2=="") {
    //     $cond2=" where status != 'Active'";
    // } else {
    //     $cond2=$cond2." and status != 'Active'";
    // }

    $sql = "select I.* from 
            (select G.*, H.zone_id as mapped_zone_id, H.area_id as mapped_area_id from 
            (select E.*, concat(ifnull(F.first_name,''),' ',ifnull(F.last_name,'')) as user_name from 
            (select C.id, C.sales_rep_id, C.distributor_name, C.address, C.city, C.pincode, C.state, 
            C.country, C.vat_no, C.contact_person, C.contact_no, C.margin, C.doc_document, C.document_name, 
            C.area_id, C.zone_id, C.location_id, D.area, C.status, C.remarks, C.distributor_id, 
            C.modified_by, C.modified_on, C.state_code, C.gst_number from 
            (select concat('d_',A.id) as id, A.sales_rep_id, A.distributor_name, A.address, A.city, A.pincode, A.state, 
            A.country, A.tin_number as vat_no, B.contact_person, B.mobile as contact_no, A.sell_out as margin, 
            null as doc_document, null as document_name, A.area_id, A.zone_id, A.location_id, A.status, A.remarks, 
            A.id as distributor_id, A.modified_by, A.modified_on, state_code, gst_number from 
            (select * from distributor_master) A 
            left join 
            (select * from distributor_contacts) B 
            on (A.id = B.distributor_id)) C 
            left join 
            (select * from area_master) D 
            on (C.Area_id = D.id)) E 
            left join 
            (select * from user_master) F 
            on (E.modified_by=F.id)) G 
            left join 
            (select distinct zone_id, area_id from sr_mapping".$cond2.") H 
            on (G.zone_id=H.zone_id and G.area_id=H.area_id)) I 
            where I.mapped_zone_id is not null and I.mapped_area_id is not null ".$cond." 
            order by distributor_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data1($status='', $id=''){
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
	
	
	

    // $sql = "select G.* from 
            // (select E.*, concat(ifnull(F.first_name,''),' ',ifnull(F.last_name,'')) as user_name from 
            // (
            // (select C.id, C.sales_rep_id, C.distributor_name, C.address, C.city, C.pincode, C.state, 
            // C.country, C.vat_no, C.contact_person, C.contact_no, C.margin, C.doc_document, C.document_name, 
            // D.area, C.status, C.remarks, C.modified_by, C.modified_on from 
            // (select concat('d_',A.id) as id, A.sales_rep_id, A.distributor_name, A.address, A.city, A.pincode, A.state, 
            // A.country, A.tin_number as vat_no, B.contact_person, B.mobile as contact_no, A.sell_out as margin, 
            // null as doc_document, null as document_name, A.area_id, A.status, A.remarks, A.modified_by, A.modified_on from 
            // (select * from distributor_master".$cond2.") A 
            // left join 
            // (select * from distributor_contacts) B 
            // on (A.id = B.distributor_id)) C 
            // left join 
            // (select * from area_master) D 
            // on (C.Area_id = D.id))) E 
            // left join 
            // (select * from user_master) F 
            // on (E.modified_by=F.id)) G ".$cond." 
            // order by distributor_name asc";
	
	$sql = "select C.* from 
            
            (select concat('d_',A.id) as id, A.sales_rep_id, A.distributor_name, A.address, A.city, A.pincode, A.state, 
            A.country, A.tin_number as vat_no, A.sell_out as margin, 
            null as doc_document, null as document_name, A.area_id, A.status, A.remarks, 
            A.modified_by, A.modified_on, state_code, gst_number from 
            (select * from distributor_master".$cond2.") A 
            left join 
            (select * from sr_mapping) D 
            on (A.area_id = D.area_id and A.zone_id = D.zone_id and A.location_id = D.location_id and  (A.sales_rep_id = D.reporting_manager_id OR A.sales_rep_id = D.sales_rep_id1 OR A.sales_rep_id = D.sales_rep_id2))) C   ".$cond." 
            order by distributor_name asc";
			
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data2($status='',$id='', $zone_id='', $area_id='', $location_id=''){
	$cond = '';
	if($id!=""){
        if($cond=="") {
            $cond=" and id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }
	
	if($status!=""){
        if($cond=="") {
            $cond=" and status='".$status."'";
        } else {
            $cond=$cond." and status='".$status."'";
        }
    }
	if($zone_id!=""){
        if($cond=="") {
            $cond=" and zone_id='".$zone_id."'";
        } else {
            $cond=$cond." and zone_id='".$zone_id."'";
        }
    }
	
    if($area_id!=''){
        $cond = $cond . " and area_id = '$area_id'";
    }
	 if($location_id!=''){
        $cond = $cond . " and location_id = '$location_id'";
    }
	
	$sql = "Select * from (select * from (
        SELECT  Distinct concat('d_',A.id) as id, A.sales_rep_id, A.distributor_name, 
            A.address, A.city, A.pincode, A.state, 
            A.country, A.tin_number as vat_no, A.sell_out as margin, 
            null as doc_document, null as document_name, A.area_id, A.status, A.remarks, 
            A.zone_id, A.location_id, 
            A.modified_by, A.modified_on FROM distributor_master A 
            where  A.type_id=3  and A.class in ('normal', 'direct') and A.distributor_name<>'' 
        Union All
        select Distinct concat('s_',id) as id, B.sales_rep_id, B.distributor_name, 
            B.address, B.city, B.pincode, B.state, 
            B.country, '' as vat_no, '' as margin, 
            null as doc_document, null as document_name, B.area_id, B.status, B.remarks, 
            B.zone_id, B.location_id,
            B.modified_by, B.modified_on 
                from sales_rep_distributors B where B.distributor_name<>'') A 
            where A.distributor_name<>'') A Where A.distributor_name<>'' ".$cond;
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
        // 'address' => $this->input->post('address'),
        // 'city' => $this->input->post('city'),
        // 'pincode' => $this->input->post('pincode'),
        // 'state' => $this->input->post('state'),
        // 'country' => $this->input->post('country'),
        // 'vat_no' => $this->input->post('vat_no'),
        // 'contact_person' => $this->input->post('contact_person'),
        // 'contact_no' => $this->input->post('contact_no'),
        'margin' => $this->input->post('margin'),
        'doc_document' => $this->input->post('doc_document'),
        'document_name' => $this->input->post('document_name'),
        'status' => 'Approved',
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        // 'state_code' => $this->input->post('state_code'),
        'gst_number' => $this->input->post('gst_number'),
        'zone_id' => $this->input->post('zone_id'),
        'area_id' => $this->input->post('area_id'),
        'location_id' => $this->input->post('location_id'),
        'master_distributor_id' => $this->input->post('distributor_id')
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


function check_distributor_availablity(){
    $id=$this->input->post('id');
    $distributor_name=$this->input->post('distributor_name');
    $zone_id=$this->input->post('zone_id');
    $area_id=$this->input->post('area_id');
    $location_id=$this->input->post('location_id');

    // $id="";

    $query=$this->db->query("SELECT * FROM sales_rep_distributors WHERE id!='".$id."' and distributor_name='".$distributor_name."' and  zone_id ='".$zone_id."' and area_id ='".$area_id."' and  location_id='".$location_id."' ");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>