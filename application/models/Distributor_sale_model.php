<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Distributor_sale_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_Sale' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select A.*, B.distributor_name, B.sell_out from 
            (select * from distributor_sale".$cond.") A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id) where A.status='Approved' order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_sale_items($id){
    $sql = "select * from distributor_sale_items where distributor_sale_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    }
    else{
        $date_of_processing=formatdate($date_of_processing);
    }

    $due_date=$this->input->post('due_date');
    if($due_date==''){
        $due_date=NULL;
    }
    else{
        $due_date=formatdate($due_date);
    }
    
	$to_distributor_id=$this->input->post('to_distributor_id');
	$store_id=$this->input->post('store_id');
	$zone_id=$this->input->post('zone_id');
	$location_id=$this->input->post('location_id');
	
    $sql = "select * from store_master where store_id = '$store_id' and zone_id = '$zone_id' and location_id = '$location_id'";
    $query=$this->db->query($sql);
    $result = $query->result();
    if(count($result)>0){
        $to_distributor_id = $result[0]->id;
    } else {
        if($to_distributor_id=='') {
            $to_distributor_id = null;
        }
    }
	
    $data = array(
        'date_of_processing' => $date_of_processing,
        'distributor_id' => $this->input->post('distributor_id'),
        'amount' => format_number($this->input->post('total_amount'),2),
        'due_date' => $due_date,
        'status' => $this->input->post('status'),
        'location_id' => $this->input->post('location_id'),
        'zone_id' => $this->input->post('zone_id'),
        'store_id' => $this->input->post('store_id'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'to_distributor_id' => $to_distributor_id
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('distributor_sale',$data);
        $id=$this->db->insert_id();
        $action='Distributor Sale Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('distributor_sale',$data);
        $action='Distributor Sale Entry Modified.';
    }

    $this->db->where('distributor_sale_id', $id);
    $this->db->delete('distributor_sale_items');

    $type=$this->input->post('type[]');
    $bar=$this->input->post('bar[]');
    $box=$this->input->post('box[]');
    $qty=$this->input->post('qty[]');
    $sell_rate=$this->input->post('sell_rate[]');
    $grams=$this->input->post('grams[]');
    $rate=$this->input->post('rate[]');
    $amount=$this->input->post('amount[]');

    for ($k=0; $k<count($type); $k++) {
        if(isset($type[$k]) and $type[$k]!="") {
            if($type[$k]=="Bar"){
                $item_id=$bar[$k];
            } else {
                $item_id=$box[$k];
            }
            $data = array(
                        'distributor_sale_id' => $id,
                        'type' => $type[$k],
                        'item_id' => $item_id,
                        'qty' => format_number($qty[$k],2),
                        'sell_rate' => format_number($sell_rate[$k],2),
                        'grams' => format_number($grams[$k],2),
                        'rate' => format_number($rate[$k],2),
                        'amount' => format_number($amount[$k],2)
                    );
            $this->db->insert('distributor_sale_items', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_Sale';
    $logarray['cnt_name']='Distributor_Sale';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function get_distributor_details($distributor_id){
    $sql = "select * from distributor_master where id = '$distributor_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_zone($type_id){
    $sql = "select * from zone_master where type_id = '$type_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_store($zone_id){
    $sql = "Select E.store_id, E.store_name from(Select  A.*,D.store_name,D.id as did from 
            (select * from store_master) A 
            left join 
            (select * from relationship_master)D
            on (A.store_id=D.id))E
             left join 
            (select * from zone_master)F
            on (E.zone_id=F.id)
            where F.id='". $zone_id ."' group by E.store_id, E.store_name";
    $query=$this->db->query($sql);
    return $query->result();
}


// function get_location_data($postData){
    // $sql = "Select  A.*,D.location from 
            // (select * from store_master) A 
            // left join 
            // (select * from location_master)D
            // on (A.location_id=D.id)
            // where A.store_id='". $postData['store_id'] ."'";
    // $query=$this->db->query($sql);
    // return $query->result();
// }
function get_location_data($store_id,$zone_id){
    $sql = "Select  A.*,D.location from 
            (select * from store_master) A 
            left join 
            (select * from location_master) D 
            on (A.location_id=D.id)
            where A.store_id='".$store_id  ."' and  A.zone_id='". $zone_id ."' ";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_zone(){
    $sql = "select * from zone_master";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_location(){
    $sql = "select * from location_master";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_super_stockist_distributor(){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $super_stockist_distributor_id=$this->input->post('super_stockist_distributor_id[]');
    $super_stockist_distributor_name=$this->input->post('super_stockist_distributor_name[]');
    $super_stockist_distributor_location=$this->input->post('super_stockist_distributor_location[]');
    $super_stockist_distributor_type=$this->input->post('super_stockist_distributor_type[]');

    for ($k=0; $k<count($super_stockist_distributor_name); $k++) {
        if(isset($super_stockist_distributor_name[$k]) and $super_stockist_distributor_name[$k]!="") {
            $data = array(
                        'distributor_name' => $super_stockist_distributor_name[$k],
                        'distributor_location' => $super_stockist_distributor_location[$k],
                        'distributor_type' => $super_stockist_distributor_type[$k],
                        'status' => 'Approved',
                        'modified_by' => $curusr,
                        'modified_on' => $now
                    );

            if($super_stockist_distributor_id[$k]==null || $super_stockist_distributor_id[$k]==''){
                $data['created_by']=$curusr;
                $data['created_on']=$now;

                $this->db->insert('super_stockist_distributor',$data);
                $id=$this->db->insert_id();
            } else {
                $this->db->where('id', $super_stockist_distributor_id[$k]);
                $this->db->update('super_stockist_distributor',$data);
            }
        }
    }
}
}
?>