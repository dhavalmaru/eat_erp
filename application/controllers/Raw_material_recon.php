<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Raw_material_recon extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('raw_material_recon_model');
        $this->load->model('dashboard_model');
        $this->load->model('product_model');
        $this->load->model('depot_model');
        $this->load->model('batch_master_model');
        $this->load->model('raw_material_model');
        // $this->load->model('ingredients_master');
        $this->load->model('stock_model');
        $this->load->model('production_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->raw_material_recon_model->get_access();
        if(count($result)>0) {
           $this->checkstatus('Approved');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status=''){
        $result=$this->raw_material_recon_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->raw_material_recon_model->get_data($status);

            $count_data=$this->raw_material_recon_model->get_data();
            $approved=0;
            $pending=0;
            $rejected=0;
            $inactive=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING" || strtoupper(trim($count_data[$i]->status))=="DELETED")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inactive']=$inactive;
            $data['status']=$status;
            $data['all']=count($count_data);

            load_view('raw_material_recon/raw_material_recon_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data_ajax($status=''){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $data=$this->raw_material_recon_model->get_data($status);
        $records = array();
        for ($i=0; $i < count($data); $i++) { 
                $records[] =  array(
                        $i+1,   
                        '<span style="display:none;">'.(($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('Ymd',strtotime($data[$i]->date_of_processing)):'').'</span>'.(($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''),							
                        '<a href="'.base_url().'index.php/raw_material_recon/edit/'.$data[$i]->id.'"><i class="fa fa-edit"></i></a>',
                        ''.$data[$i]->depot_name.''
                    );
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => count($data),
                        "recordsFiltered" => count($data),
                        "data" => $records
                    );
        echo json_encode($output); 
    }

    // public function get_data(){
    // $id=$this->input->post('id');
    // $id=1;

    // $result=$this->raw_material_recon_model->get_data('', $id);
    // $data['result'] = 0;
    // if(count($result)>0) {
        // $data['result'] = 1;
        // $data['product_id'] = $result[0]->product_id;
        // $data['no_of_batch'] = $result[0]->no_of_batch;
      
    // }

    // echo json_encode($data);
    // }

    public function add($p_id='', $module=''){
        $result=$this->raw_material_recon_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->raw_material_recon_model->get_access();
                $data['product'] = $this->product_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['batch_no'] = $this->batch_master_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['p_id'] = $p_id;
                $data['production'] = $this->production_model->get_data('Approved');
                $data['module'] = $module;
                if($p_id!=''){
                    $data['p_data'] = $this->production_model->get_data('', $p_id);
                }

                load_view('raw_material_recon/raw_material_recon_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id, $module=''){
        $result=$this->raw_material_recon_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->raw_material_recon_model->get_access();
                $id = $this->raw_material_recon_model->get_pending_data($id);
                $data['data'] = $this->raw_material_recon_model->get_data('', $id);
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['raw_material_stock'] = $this->raw_material_recon_model->get_raw_material_recon_items($id);
                $data['production'] = $this->production_model->get_data('Approved');
                $data['module'] = $module;
				
				// $query=$this->db->query("SELECT * FROM batch_images WHERE raw_material_recon_id = '$id'");
                // $result=$query->result();
                // if(count($result)>0){
                    // $data['batch_images']=$result;
                // }

                load_view('raw_material_recon/raw_material_recon_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_depot_stock(){
        $date_of_processing=$this->input->post('date_of_processing');
        if($date_of_processing==''){
            $date_of_processing=NULL;
        } else {
            $date_of_processing=formatdate($date_of_processing);
        }
        $depot_id=$this->input->post('depot_id');
        $raw_material_stock=$this->raw_material_recon_model->get_raw_material_stock($depot_id, $date_of_processing);
        $raw_material = $this->raw_material_model->get_data('Approved');

        $tbody = '';
        if(count($raw_material_stock)>0){
            for($i=0; $i<count($raw_material_stock); $i++){
                $tbody = $tbody.
                        '<tr id="raw_material_'.$i.'_row">
                            <td>
                                <select name="raw_material_id[]" class="form-control raw_material select2" id="raw_material_'.$i.'">
                                    <option value="">Select</option>';
                                    if(isset($raw_material)) { 
                                        for ($k=0; $k < count($raw_material) ; $k++) { 
                                            if($raw_material[$k]->id==$raw_material_stock[$i]->raw_material_id) {
                                                $tbody = $tbody.'<option value="'.$raw_material[$k]->id.'" selected >'.$raw_material[$k]->rm_name.'</option>';
                                            }
                                        }
                                    }
                $tbody = $tbody.'</select>
                            </td>
                            <td>
                                <input type="text" class="form-control system_qty" name="system_qty[]" id="system_qty_'.$i.'" placeholder="System Qty" value="'.round($raw_material_stock[$i]->tot_qty, 2).'" readonly />
                            </td>
                            <td>
                                <input type="text" class="form-control physical_qty" name="physical_qty[]" id="physical_qty_'.$i.'" placeholder="Physical Qty" value="'.round($raw_material_stock[$i]->tot_qty, 2).'" onchange="get_difference(this);" />
                            </td>
                            <td>
                                <input type="text" class="form-control difference_qty" name="difference_qty[]" id="difference_qty_'.$i.'" placeholder="Difference Qty" value="0" readonly />
                            </td>
                            <td class="text-center" style="display: none;">
                                <input type="checkbox" class="check_qty" id="check_qty_'.$i.'" onchange="set_check_qty_val(this);" />
                                <input type="hidden" class="form-control" name="check_qty[]" id="check_qty_val_'.$i.'" placeholder="Check Qty" value="0">
                            </td>
                            <td style="display: none;">
                                <input type="text" class="form-control item_status" name="item_status[]" id="item_status_'.$i.'" placeholder="Status" value="Pending" />
                            </td>
                        </tr>';
            }
        }

        echo $tbody;
    }
	
    public function save(){
        $this->raw_material_recon_model->save_data();
        // redirect(base_url().'index.php/raw_material_recon');
    }

    public function update($id){
        $this->raw_material_recon_model->save_data($id);
        //  redirect(base_url().'index.php/raw_material_recon');
	    // echo '<script>window.open("'.base_url().'index.php/raw_material_recon", "_parent")</script>';
    }

    public function check_batch_id_availablity(){
        $result = $this->raw_material_recon_model->check_batch_id_availablity();
        echo $result;
    }
    
    public function check_raw_material_availablity(){
        $result = $this->stock_model->check_raw_material_availablity();
        echo $result;
    }
	
    public function check_raw_material_qty_availablity(){
        $result = $this->stock_model->check_raw_material_qty_availablity();
        echo $result;
    }
}
?>