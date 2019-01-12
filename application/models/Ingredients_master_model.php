<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Ingredients_master_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Ingredient_Master' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select C.* from 
            (select A.*,A.id as aid, B.product_name from 
            (select * from ingredients_master".$cond.") A 
            left join 
            (select * from product_master) B 
            on (A.product_id=B.id)) C 
            order by C.updated_date desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_batch_raw_material($id){
    $sql = "select A.*, B.rm_name from 
            (select * from ingredients_details where ing_id = '$id') A 
            left join 
            (select * from raw_material_master) B 
            on (A.rm_id=B.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    // $date_of_processing=$this->input->post('date_of_processing');
    // if($date_of_processing==''){
    //     $date_of_processing=NULL;
    // }
    // else{
    //     $date_of_processing=formatdate($date_of_processing);
    // }
    
    $data = array(
        'product_id' => $this->input->post('product_id'),
        'total_batch_in_grams' => format_number($this->input->post('total_batch_in_grams'),2),
        'per_bar' => format_number($this->input->post('per_bar'),2),
        'total_batch_bar' => format_number($this->input->post('total_batch_bar'),2),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'updated_by' => $curusr,
        'updated_date' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_date']=$now;

        $this->db->insert('ingredients_master',$data);
        $id=$this->db->insert_id();
        $action='Ingredients Master Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('ingredients_master',$data);
        $action='Ingredients Master Entry Modified.';
    }


    $this->db->where('ing_id', $id);
    $this->db->delete('ingredients_details');

    $raw_material_id=$this->input->post('raw_material_id[]');
    $qty=$this->input->post('qty[]');

    for ($k=0; $k<count($raw_material_id); $k++) {
        if(isset($raw_material_id[$k]) and $raw_material_id[$k]!="") {
            $data = array(
                        'ing_id' => $id,
                        'rm_id' => $raw_material_id[$k],
                        'qty_per_batch' => format_number($qty[$k],3)
                    );
            $this->db->insert('ingredients_details', $data);
        }
    }


    $logarray['table_id']=$id;
    $logarray['module_name']='Ingredient_Master';
    $logarray['cnt_name']='Ingredient_Master';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}
function get_batch_raw_material1($id){
	    $product_id=$this->input->post('product_id');
	   
    $sql = 
			"select C.*, D.rm_name from (select A.*, B.ing_id,B.rm_id,B.rm_name from 
			( select * from ingredients_master) A 
            left join 
            (select * from ingredients_details) B 
            on (B.ing_id=A.id))C
			 left join 
            (select * from raw_material_master) D
            on (C.rm_id=D.id)";	
			
			
		
    $query=$this->db->query($sql);
    return $query->result();
}

function check_product_id_availablity()
{
	 $id=$this->input->post('id');
	 $product_id=$this->input->post('product_id');
		  
		$query=$this->db->query("SELECT * FROM ingredients_master WHERE id!='".$id."' and product_id='".$product_id."'");
		$result=$query->result();

		if (count($result)>0){
			return 1;
		} else {
			return 0;
		}
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