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

function get_data($status='', $id=''){
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

function get_dist_list() {
    $sql = "select id,store_name from promoter_stores";
            
    $query=$this->db->query($sql);
    return $query->result();
}

function get_merchandiser_stock_details($id){
    $sql = "select * from merchandiser_stock_details where merchandiser_stock_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $sales_rep_id=$this->session->userdata('sales_rep_id');
    $date_of_visit=$this->input->post('date_of_visit');
    if($date_of_visit==''){
        $date_of_visit=NULL;
    } else {
        $date_of_visit=formatdate($date_of_visit);
    }
    
    $data = array(
        'm_id' => $sales_rep_id,
        'date_of_visit' => $date_of_visit,
        'dist_id' => $this->input->post('distributor_id'),
        'latitude' => $this->input->post('latitude'),
        'longitude' => $this->input->post('longitude'),
        'remarks' => $this->input->post('remarks'),
        'created_by' => $curusr,
        'created_date' => $now,
        // 'orange_bar' => $this->input->post('orange_bar'),
        // 'mint_bar' => $this->input->post('mint_bar'),
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