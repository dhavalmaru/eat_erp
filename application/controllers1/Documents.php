<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Documents extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->database();
    }

    //index function
    public function index(){
        $query=$this->db->query("SELECT * FROM user_role_options");
        $result=$query->result();
        if(count($result)>0) {
            $result[0]->r_export=1;
            $data['access']=$result;
        }
        
        $query=$this->db->query("SELECT * FROM document_master order by d_add_date desc");
        $result=$query->result();
        $data['documents']=$result;

        $data['doccatlist']=NULL;
        $data['$doctypelist']=NULL;

        for ($i=0; $i < count($result) ; $i++) { 
            $listcategory="";
            if ($result[$i]->d_cat_individual=="Yes") {
                $listcategory=$listcategory.'Individual, ';
            }
            if ($result[$i]->d_cat_huf=="Yes") {
                $listcategory=$listcategory.'HUF, ';
            }
            if ($result[$i]->d_cat_privateltd=="Yes") {
                $listcategory=$listcategory.'Private Ltd, ';
            }
            if ($result[$i]->d_cat_limited=="Yes") {
                $listcategory=$listcategory.'Limited, ';
            }
            if ($result[$i]->d_cat_lpp=="Yes") {
                $listcategory=$listcategory.'LLP, ';
            }
            if ($result[$i]->d_cat_partnership=="Yes") {
                $listcategory=$listcategory.'Partnership, ';
            }
            if ($result[$i]->d_cat_aop=="Yes") {
                $listcategory=$listcategory.'AOP, ';
            }
            if ($result[$i]->d_cat_trust=="Yes") {
                $listcategory=$listcategory.'Trust, ';
            }
            if ($result[$i]->d_cat_proprietorship=="Yes") {
                $listcategory=$listcategory.'Proprietorship, ';
            }
            $data['doccatlist'][$i]=$listcategory;

            $listtypecategory="";
            if($result[$i]->d_type_building=="Yes"){
                $listtypecategory=$listtypecategory."Building, ";
            }
            if($result[$i]->d_type_apartment=="Yes"){
                $listtypecategory=$listtypecategory."Apartment, ";
            }
            if($result[$i]->d_type_bunglow=="Yes"){
                $listtypecategory=$listtypecategory."Bunglow, ";
            }
            if($result[$i]->d_type_commercial=="Yes"){
                $listtypecategory=$listtypecategory."Commercial, ";
            }
            if($result[$i]->d_type_retail=="Yes"){
                $listtypecategory=$listtypecategory."Retail, ";
            }
            if($result[$i]->d_type_industry=="Yes"){
                $listtypecategory=$listtypecategory."Industry, ";
            }
            if($result[$i]->d_type_landagriculture=="Yes"){
                $listtypecategory=$listtypecategory."Land Agriculture, ";
            }
            if($result[$i]->d_type_landnonagricultural=="Yes"){
                $listtypecategory=$listtypecategory."Land Non Agriculture, ";
            }

            $data['doctypelist'][$i]=$listtypecategory;
            
        }
        load_view('documents/document_list', $data);
    }
    
    public function addDocument($value='') {
        $query=$this->db->query("SELECT * FROM document_type_master");
        $result=$query->result();
        $data['document_type']=$result;

        load_view('documents/document_master', $data);
    }

    public function viewDocument($did) {
        $query=$this->db->query("SELECT * FROM document_type_master");
        $result=$query->result();
        $data['document_type']=$result;

        $query=$this->db->query("SELECT * FROM document_types WHERE d_id='$did'");
        $result=$query->result();
        if(count($result)>0){
            for ($i=0; $i < count($result); $i++) { 
                $data['selected_document_type'][$i]=$result[$i]->d_type_id;
            }
        } else {
            $data['selected_document_type']=array();
        }

        $query=$this->db->query("SELECT * FROM document_master WHERE d_id='$did'");
        $result=$query->result();
        $data['editdocuments']=$result;

        $data['doccatlist']=NULL;
        $data['doctypelist']=NULL;

        for ($i=0; $i < count($result) ; $i++) { 
            $listcategory="";
            if ($result[$i]->d_cat_individual=="Yes") {
                $listcategory=$listcategory.'Individual, ';
            }
            if ($result[$i]->d_cat_huf=="Yes") {
                $listcategory=$listcategory.'HUF, ';
            }
            if ($result[$i]->d_cat_privateltd=="Yes") {
                $listcategory=$listcategory.'Private Ltd, ';
            }
            if ($result[$i]->d_cat_limited=="Yes") {
                $listcategory=$listcategory.'Limited, ';
            }
            if ($result[$i]->d_cat_lpp=="Yes") {
                $listcategory=$listcategory.'LLP, ';
            }
            if ($result[$i]->d_cat_partnership=="Yes") {
                $listcategory=$listcategory.'Partnership, ';
            }
            if ($result[$i]->d_cat_aop=="Yes") {
                $listcategory=$listcategory.'AOP, ';
            }
            if ($result[$i]->d_cat_trust=="Yes") {
                $listcategory=$listcategory.'Trust, ';
            }
            if ($result[$i]->d_cat_proprietorship=="Yes") {
                $listcategory=$listcategory.'Proprietorship, ';
            }
            $data['doccatlist'][$i]=$listcategory;


            $listtypecategory="";
            if($result[$i]->d_type_building=="Yes"){
                $listtypecategory=$listtypecategory."Building, ";
            }
            if($result[$i]->d_type_apartment=="Yes"){
                $listtypecategory=$listtypecategory."Apartment, ";
            }
            if($result[$i]->d_type_bunglow=="Yes"){
                $listtypecategory=$listtypecategory."Bunglow, ";
            }
            if($result[$i]->d_type_commercial=="Yes"){
                $listtypecategory=$listtypecategory."Commercial, ";
            }
            if($result[$i]->d_type_retail=="Yes"){
                $listtypecategory=$listtypecategory."Retail, ";
            }
            if($result[$i]->d_type_industry=="Yes"){
                $listtypecategory=$listtypecategory."Industry, ";
            }
            if($result[$i]->d_type_landagriculture=="Yes"){
                $listtypecategory=$listtypecategory."Land Agriculture, ";
            }
            if($result[$i]->d_type_landnonagricultural=="Yes"){
                $listtypecategory=$listtypecategory."Land Non Agriculture, ";
            }
            $data['doctypelist'][$i]=$listtypecategory;
        }

        load_view('documents/document_view',$data);
    }

    public function saveRecord(){
        $now=date('Y-m-d H:i:s');
        $d_status=$this->input->post('status');
        $d_type="";
        $d_t_type="";

        if($this->input->post('purchase')=="Yes"){
            $d_t_type="purchase, ";
        } 
        if($this->input->post('sale')=="Yes"){
            $d_t_type=$d_t_type . "sale, ";
        } 
        if($this->input->post('rent')=="Yes"){
            $d_t_type=$d_t_type . "rent, ";
        } 
        if($this->input->post('loan')=="Yes"){
            $d_t_type=$d_t_type . "loan, ";
        } 
        if($this->input->post('owner')=="Yes"){
            $d_t_type="owner, ";
        }

        $d_t_type = substr($d_t_type, 0, strrpos($d_t_type, ", "));

        if($d_status=='Transactional'){
            $data = array(
                'd_documentName' => $this->input->post('doc_name'),
                'd_description' => $this->input->post('doc_desc'),
                'd_status' =>  $this->input->post('status'),
                'd_type' =>  $d_type,
                'd_show_expiry_date' =>  $this->input->post('show_expiry_date'),
                'd_t_type' =>  $d_t_type,
                'd_cat_individual' => 'No',
                'd_cat_huf' => 'No',
                'd_cat_privateltd' => 'No',
                'd_cat_limited' => 'No',
                'd_cat_lpp' => 'No',
                'd_cat_partnership' => 'No',
                'd_cat_aop' => 'No',
                'd_cat_trust' => 'No',
                'd_cat_proprietorship' => 'No',
                'd_type_building' => $this->input->post('building'),
                'd_type_apartment' => $this->input->post('apartment'),
                'd_type_bunglow' => $this->input->post('bunglow'),
                'd_type_commercial' => $this->input->post('commercial'),
                'd_type_retail' => $this->input->post('retail'),
                'd_type_industry' => $this->input->post('industry'),
                'd_type_landagriculture' => $this->input->post('landagri'),
                'd_type_landnonagricultural' => $this->input->post('landnonagri'),
                'd_add_date' => $now,
            );
        }else{
            $data = array(
                'd_documentName' => $this->input->post('doc_name'),
                'd_description' => $this->input->post('doc_desc'),
                'd_status' =>  $this->input->post('status'),
                'd_type' =>  $d_type,
                'd_show_expiry_date' =>  $this->input->post('show_expiry_date'),
                'd_t_type' =>  $d_t_type,
                'd_cat_individual' => $this->input->post('individual'),
                'd_cat_huf' => $this->input->post('huf'),
                'd_cat_privateltd' => $this->input->post('privateltd'),
                'd_cat_limited' => $this->input->post('ltd'),
                'd_cat_lpp' => $this->input->post('llp'),
                'd_cat_partnership' => $this->input->post('partnership'),
                'd_cat_aop' => $this->input->post('aop'),
                'd_cat_trust' => $this->input->post('trust'),
                'd_cat_proprietorship' => $this->input->post('proprietorship'),
                'd_type_building' => 'No',
                'd_type_apartment' => 'No',
                'd_type_bunglow' => 'No',
                'd_type_commercial' => 'No',
                'd_type_retail' => 'No',
                'd_type_industry' => 'No',
                'd_type_landagriculture' => 'No',
                'd_type_landnonagricultural' => 'No',
                'd_add_date' => $now,
                'd_gid' => $this->session->userdata('groupid')
            );
        }

        $this->db->insert('document_master',$data);
        $did=$this->db->insert_id();

        $d_type=$this->input->post('d_type[]');
        for ($i=0; $i < count($d_type); $i++) {
            $data = array(
                        'd_id' => $did,
                        'd_type_id' => $d_type[$i],
                    );
            $this->db->insert('document_types', $data);
        }

        redirect(base_url().'index.php/Documents');
    }

    public function editRecord($did){
        $query=$this->db->query("SELECT * FROM document_type_master");
        $result=$query->result();
        $data['document_type']=$result;

        $query=$this->db->query("SELECT * FROM document_master");
        $result=$query->result();
        $data['documents']=$result;

        $query=$this->db->query("SELECT * FROM document_types WHERE d_id='$did'");
        $result=$query->result();
        if(count($result)>0){
            for ($i=0; $i < count($result); $i++) { 
                $data['selected_document_type'][$i]=$result[$i]->d_type_id;
            }
        } else {
            $data['selected_document_type']=array();
        }
        
        $query=$this->db->query("SELECT * FROM document_master WHERE d_id='$did'");
        $result=$query->result();
        $data['editdocuments']=$result;

        $data['doccatlist']=NULL;
        $data['doctypelist']=NULL;
        
        for ($i=0; $i < count($result) ; $i++) { 
            $listcategory="";
            if ($result[$i]->d_cat_individual=="Yes") {
                $listcategory=$listcategory.'Individual, ';
            }
            if ($result[$i]->d_cat_huf=="Yes") {
                $listcategory=$listcategory.'HUF, ';
            }
            if ($result[$i]->d_cat_privateltd=="Yes") {
                $listcategory=$listcategory.'Private Ltd, ';
            }
            if ($result[$i]->d_cat_limited=="Yes") {
                $listcategory=$listcategory.'Limited, ';
            }
            if ($result[$i]->d_cat_lpp=="Yes") {
                $listcategory=$listcategory.'LLP, ';
            }
            if ($result[$i]->d_cat_partnership=="Yes") {
                $listcategory=$listcategory.'Partnership, ';
            }
            if ($result[$i]->d_cat_aop=="Yes") {
                $listcategory=$listcategory.'AOP, ';
            }
            if ($result[$i]->d_cat_trust=="Yes") {
                $listcategory=$listcategory.'Trust, ';
            }
            if ($result[$i]->d_cat_proprietorship=="Yes") {
                $listcategory=$listcategory.'Proprietorship, ';
            }
            $data['doccatlist'][$i]=$listcategory;

            $listtypecategory="";
            if($result[$i]->d_type_building=="Yes"){
                $listtypecategory=$listtypecategory."Building, ";
            }
            if($result[$i]->d_type_apartment=="Yes"){
                $listtypecategory=$listtypecategory."Apartment, ";
            }
            if($result[$i]->d_type_bunglow=="Yes"){
                $listtypecategory=$listtypecategory."Bunglow, ";
            }
            if($result[$i]->d_type_commercial=="Yes"){
                $listtypecategory=$listtypecategory."Commercial, ";
            }
            if($result[$i]->d_type_retail=="Yes"){
                $listtypecategory=$listtypecategory."Retail, ";
            }
            if($result[$i]->d_type_industry=="Yes"){
                $listtypecategory=$listtypecategory."Industry, ";
            }
            if($result[$i]->d_type_landagriculture=="Yes"){
                $listtypecategory=$listtypecategory."Land Agriculture, ";
            }
            if($result[$i]->d_type_landnonagricultural=="Yes"){
                $listtypecategory=$listtypecategory."Land Non Agriculture, ";
            }

            $data['doctypelist'][$i]=$listtypecategory;
            
        }

        $data['d_id']=$did;
        load_view('documents/document_master', $data);

    }

    public function updateRecord($did){
        $now=date('Y-m-d H:i:s');
		$d_status=$this->input->post('status');
        $d_type="";
        $d_t_type="";

        if($this->input->post('purchase')=="Yes"){
            $d_t_type="purchase, ";
        }
        if($this->input->post('sale')=="Yes"){
            $d_t_type=$d_t_type . "sale, ";
        }
        if($this->input->post('rent')=="Yes"){
            $d_t_type=$d_t_type . "rent, ";
        }
        if($this->input->post('loan')=="Yes"){
            $d_t_type=$d_t_type . "loan, ";
        }
        if($this->input->post('owner')=="Yes"){
            $d_t_type="owner, ";
        }

        $d_t_type = substr($d_t_type, 0, strrpos($d_t_type, ", "));

		if($d_status=='Transactional'){
			$data = array(
				'd_documentName' => $this->input->post('doc_name'),
				'd_description' => $this->input->post('doc_desc'),
				'd_status' =>  $this->input->post('status'),
				'd_type' =>  $d_type,
				'd_show_expiry_date' =>  $this->input->post('show_expiry_date'),
				'd_t_type' =>  $d_t_type,
				'd_cat_individual' => 'No',
				'd_cat_huf' => 'No',
				'd_cat_privateltd' => 'No',
				'd_cat_limited' => 'No',
				'd_cat_lpp' => 'No',
				'd_cat_partnership' => 'No',
				'd_cat_aop' => 'No',
				'd_cat_trust' => 'No',
                'd_cat_proprietorship' => 'No',
                'd_type_building' => $this->input->post('building'),
				'd_type_apartment' => $this->input->post('apartment'),
				'd_type_bunglow' => $this->input->post('bunglow'),
				'd_type_commercial' => $this->input->post('commercial'),
				'd_type_retail' => $this->input->post('retail'),
				'd_type_industry' => $this->input->post('industry'),
				'd_type_landagriculture' => $this->input->post('landagri'),
				'd_type_landnonagricultural' => $this->input->post('landnonagri'),
				'd_add_date' => $now,
			);
		}else{
			$data = array(
				'd_documentName' => $this->input->post('doc_name'),
				'd_description' => $this->input->post('doc_desc'),
				'd_status' =>  $this->input->post('status'),
				'd_type' =>  $d_type,
				'd_show_expiry_date' =>  $this->input->post('show_expiry_date'),
				'd_t_type' =>  $d_t_type,
				'd_cat_individual' => $this->input->post('individual'),
				'd_cat_huf' => $this->input->post('huf'),
				'd_cat_privateltd' => $this->input->post('privateltd'),
				'd_cat_limited' => $this->input->post('ltd'),
				'd_cat_lpp' => $this->input->post('llp'),
				'd_cat_partnership' => $this->input->post('partnership'),
				'd_cat_aop' => $this->input->post('aop'),
				'd_cat_trust' => $this->input->post('trust'),
                'd_cat_proprietorship' => $this->input->post('proprietorship'),
                'd_type_building' => 'No',
				'd_type_apartment' => 'No',
				'd_type_bunglow' => 'No',
				'd_type_commercial' => 'No',
				'd_type_retail' => 'No',
				'd_type_industry' => 'No',
				'd_type_landagriculture' => 'No',
				'd_type_landnonagricultural' => 'No',
				'd_add_date' => $now,
			);
		}
        $this->db->where('d_id',$did);
        $this->db->update('document_master',$data);

        $this->db->where('d_id', $did);
        $this->db->delete('document_types');

        $d_type=$this->input->post('d_type[]');
        for ($i=0; $i < count($d_type); $i++) {
            $data = array(
                        'd_id' => $did,
                        'd_type_id' => $d_type[$i],
                    );
            $this->db->insert('document_types', $data);
        }

        redirect(base_url().'index.php/Documents/index');
    }

    function checkDocumentAvailability() {
        $doc_id = html_escape($this->input->post('doc_id'));
        $doc_name = html_escape($this->input->post('doc_name'));
        // $doc_type = html_escape($this->input->post('doc_type'));
        $status = html_escape($this->input->post('status'));
        // $type = html_escape($this->input->post('type'));
        $individual = html_escape($this->input->post('individual'));
        $huf = html_escape($this->input->post('huf'));
        $privateltd = html_escape($this->input->post('privateltd'));
        $ltd = html_escape($this->input->post('ltd'));
        $llp = html_escape($this->input->post('llp'));
        $partnership = html_escape($this->input->post('partnership'));
        $aop = html_escape($this->input->post('aop'));
        $trust = html_escape($this->input->post('trust'));
        $proprietorship = html_escape($this->input->post('proprietorship'));
        $building = html_escape($this->input->post('building'));
        $apartment = html_escape($this->input->post('apartment'));
        $bunglow = html_escape($this->input->post('bunglow'));
        $commercial = html_escape($this->input->post('commercial'));
        $retail = html_escape($this->input->post('retail'));
        $industry = html_escape($this->input->post('industry'));
        $landagri = html_escape($this->input->post('landagri'));
        $landnonagri = html_escape($this->input->post('landnonagri'));

        $cond = "";

        if($individual=="true"){
            $cond = "d_cat_individual='Yes'";
        }
        if($huf=="true"){
            if($cond=="") $cond = $cond . "d_cat_huf='Yes'";
            else $cond = $cond . " or d_cat_huf='Yes'";
        }
        if($privateltd=="true"){
            if($cond=="") $cond = $cond . "d_cat_privateltd='Yes'";
            else $cond = $cond . " or d_cat_privateltd='Yes'";
        }
        if($ltd=="true"){
            if($cond=="") $cond = $cond . "d_cat_limited='Yes'";
            else $cond = $cond . " or d_cat_limited='Yes'";
        }
        if($llp=="true"){
            if($cond=="") $cond = $cond . "d_cat_lpp='Yes'";
            else $cond = $cond . " or d_cat_lpp='Yes'";
        }
        if($partnership=="true"){
            if($cond=="") $cond = $cond . "d_cat_partnership='Yes'";
            else $cond = $cond . " or d_cat_partnership='Yes'";
        }
        if($aop=="true"){
            if($cond=="") $cond = $cond . "d_cat_aop='Yes'";
            else $cond = $cond . " or d_cat_aop='Yes'";
        }
        if($trust=="true"){
            if($cond=="") $cond = $cond . "d_cat_trust='Yes'";
            else $cond = $cond . " or d_cat_trust='Yes'";
        }
        if($proprietorship=="true"){
            if($cond=="") $cond = $cond . "d_cat_proprietorship='Yes'";
            else $cond = $cond . " or d_cat_proprietorship='Yes'";
        }
        if($building=="true"){
            if($cond=="") $cond = $cond . "d_type_building='Yes'";
            else $cond = $cond . " or d_type_building='Yes'";
        }
        if($apartment=="true"){
            if($cond=="") $cond = $cond . "d_type_apartment='Yes'";
            else $cond = $cond . " or d_type_apartment='Yes'";
        }
        if($bunglow=="true"){
            if($cond=="") $cond = $cond . "d_type_bunglow='Yes'";
            else $cond = $cond . " or d_type_bunglow='Yes'";
        }
        if($commercial=="true"){
            if($cond=="") $cond = $cond . "d_type_commercial='Yes'";
            else $cond = $cond . " or d_type_commercial='Yes'";
        }
        if($retail=="true"){
            if($cond=="") $cond = $cond . "d_type_retail='Yes'";
            else $cond = $cond . " or d_type_retail='Yes'";
        }
        if($industry=="true"){
            if($cond=="") $cond = $cond . "d_type_industry='Yes'";
            else $cond = $cond . " or d_type_industry='Yes'";
        }
        if($landagri=="true"){
            if($cond=="") $cond = $cond . "d_type_landagriculture='Yes'";
            else $cond = $cond . " or d_type_landagriculture='Yes'";
        }
        if($landnonagri=="true"){
            if($cond=="") $cond = $cond . "d_type_landnonagricultural='Yes'";
            else $cond = $cond . " or d_type_landnonagricultural='Yes'";
        }

        if($cond!=""){
            $cond = " AND (" . $cond . ")";
        }

        // $query = $this->db->query("SELECT * FROM document_master WHERE d_id != '$doc_id' AND d_documentname = '$doc_name'" . $cond);
        $query = $this->db->query("SELECT * FROM document_master WHERE d_id != '$doc_id' AND d_documentname = '$doc_name' AND d_status = '$status'");
        if($query->num_rows()!=0){
            echo 1;
        } else {
            echo 0;
        }
    }

    public function deleteRecord($did){
        $this->db->where('d_id',$did);
        $this->db->delete('document_master');
        redirect(base_url().'index.php/Documents/index');
    }


    public function loadDocuments() {
        $term = "t";
                
        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        
        $gid=$this->session->userdata('groupid');
        $query=$this->db->query("select * from document_master where d_documentname like '%" . $term . "%';");
        $result=$query->result();
        
        foreach($result as $row) {
            $abc[] = array('value' => $row->d_id , 'label' => $row->d_documentname, 'd_show_expiry_date' => $row->d_show_expiry_date);
        }
        
        echo json_encode($abc);
    }

    public function getDocumentDetails() {
        $did = html_escape($this->input->post('doc_name'));
        $query=$this->db->query("select * from document_master where d_id = '$did';");
        $result=$query->result();
        if(count($result)>0) {
            $d_show_expiry_date = $result[0]->d_show_expiry_date;
        } else {
            $d_show_expiry_date = 'No';
        }
        
        echo $d_show_expiry_date;
    }
    
}
?>