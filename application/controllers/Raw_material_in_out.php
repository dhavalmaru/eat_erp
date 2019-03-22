<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Raw_material_in_out extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('Raw_material_in_out_model');
        $this->load->model('vendor_model');
        $this->load->model('depot_model');
        $this->load->model('raw_material_model');
        $this->load->model('purchase_order_model');
        $this->load->model('Raw_material_in_out_model','raw_material_in_out_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->Raw_material_in_out_model->get_access();
        if(count($result)>0) {
            
            $this->checkstatus('Approved');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status=''){
        $result=$this->Raw_material_in_out_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            /*$data['data']=$this->Raw_material_in_out_model->get_data($status);*/

            $count_data=$this->Raw_material_in_out_model->get_data();

      
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

            load_view('raw_material_in_out/raw_material_in_out_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->Raw_material_in_out_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->Raw_material_in_out_model->get_access();
                $data['vendor'] = $this->vendor_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['raw_material'] =$raw_material= $this->raw_material_model->get_data('Approved');
                load_view('raw_material_in_out/raw_material_in_out_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->Raw_material_in_out_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->Raw_material_in_out_model->get_access();
                $data['data'] = $this->Raw_material_in_out_model->get_data('', $id);
                $data['vendor'] = $this->vendor_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');;
                $data['purchase_order'] = $this->purchase_order_model->get_data('Approved');
                $data['raw_material_in_out'] = $this->Raw_material_in_out_model->get_raw_material_in_out($id);

                load_view('raw_material_in_out/raw_material_in_out_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->raw_material_in_out_model->save_data();
        redirect(base_url().'index.php/raw_material_in_out');
    }

    public function update($id){
        $this->Raw_material_in_out_model->save_data($id);
        // redirect(base_url().'index.php/raw_material_in');
		echo '<script>window.open("'.base_url().'index.php/raw_material_in_out", "_parent")</script>';
    }

    public function get_data_ajax($status='')
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $data=$this->Raw_material_in_out_model->get_data($status);

        $records = array();
        for ($i=0; $i < count($data); $i++) { 
                $records[] =  array(
                        $i+1,                       
                    (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''),
					'<a href="'.base_url().'index.php/raw_material_in_out/edit/'.$data[$i]->id.'"><i class="fa fa-edit"></i></a>',
					
                    ''.$data[$i]->depot_name.'',
                    ''.$data[$i]->type.'',
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

    public function raw_material_receipt($id)
    {
        $result=$this->Raw_material_in_out_model->get_access();
		if(count($result)>0)
		{
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->Raw_material_in_out_model->get_access();
                $result = $this->Raw_material_in_out_model->get_data('',$id);
                $depo_id = $result[0]->depot_id;
                $vendor_id = $result[0]->vendor_id;
                $data['data']= $result;
                $data['vendor'] = $this->vendor_model->get_data('Approved',$vendor_id);
                $data['depot'] = $this->depot_model->get_data('Approved',$depo_id);
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['purchase_order'] = $this->purchase_order_model->get_data('Approved');
                $data['raw_material_stock'] = $this->Raw_material_in_out_model->get_raw_material_stock($id);

                  load_view('raw_material_in/raw_material_in_receipt', $data);
            } else {
                echo "Unauthorized access";
            }
        } 
		else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function test()
    {
        /*$array = array(1,2,32,5,69);
        $this->test5($array);*/
    }

    public function test5($array='')
    {
        /*echo "<pre>";
        print_r($array);
        echo "</pre>";*/
    }


}
?>