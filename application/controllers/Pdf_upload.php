<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Pdf_upload extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('Pdf_upload_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->Pdf_upload_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            // $data['data'] = $this->Pdf_upload_model->get_data();

            load_view('pdf_upload/pdf_upload', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data(){
        // $status = 'Approved';

        // $draw = intval($this->input->get("draw"));
        // $start = intval($this->input->get("start"));
        // $length = intval($this->input->get("length"));
        // $status = intval($this->input->get("status"));

        // $draw = 1;
        // $start = 0;
        // $length = 10;
        // $search_value = '';
        // $status = '';

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $status = $this->input->post("status");

        $search_val = $search['value'];

        // echo $draw;
        // echo '<br/><br/>';
        // echo $start;
        // echo '<br/><br/>';
        // echo $length;
        // echo '<br/><br/>';
        // echo json_encode($search);
        // echo '<br/><br/>';
        // echo $status;
        // echo '<br/><br/>';
        // echo $search_val;
        // echo '<br/><br/>';

        $result = $this->Pdf_upload_model->get_list_data($start, $length, $search_val);
        // echo json_encode($result);
        // echo '<br/><br/>';

        $totalRecords = 0;
        $count = $result['count'];
        if(count($count)>0) $totalRecords = $count[0]->total_records;

        $r = $result['rows'];

        $data = array();

        for($i=0;$i<count($r);$i++){
            $data[] = array(
                        $i+$start+1,

                        '<span style="display:none;">'.
                            (($r[$i]->upload_date!=null && $r[$i]->upload_date!='')?date('Ymd',strtotime($r[$i]->upload_date)):'')
                        .'</span>'.
                        (($r[$i]->upload_date!=null && $r[$i]->upload_date!='')?date('d/m/Y',strtotime($r[$i]->upload_date)):''),

                        $r[$i]->file_name,

                        $r[$i]->status,

                        $r[$i]->remarks,

                        (($r[$i]->file_name!=null && $r[$i]->file_name!='')? '<a href="'.base_url().'assets/uploads/pdf_upload/'.$r[$i]->file_name.'" target="_blank">
                            <span class="fa fa-download" style="font-size:20px;"></span>
                        </a>': ''),

                        (($r[$i]->check_file_name!=null && $r[$i]->check_file_name!='')? '<a href="'.base_url().'assets/uploads/pdf_upload/'.$r[$i]->check_file_name.'" target="_blank">
                            <span class="fa fa-download" style="font-size:20px;"></span>
                        </a>': '')
                    );
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => $totalRecords,
                        "recordsFiltered" => $totalRecords,
                        "data" => $data
                        // ,
                        // "columns" => $columns
                    );
        echo json_encode($output);
    }

    public function upload_file(){
        $now=date('Y-m-d H:i:s');
        $curdate=date('Y-m-d');
        $curusr=$this->session->userdata('session_id');

        $upload_path=$this->config->item('upload_path');
        $path=$upload_path.'pdf_upload';
        if(!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        $path = $path . '/';
        $config = array(
            'upload_path' => $path,
            'allowed_types' => "pdf",
            'overwrite' => TRUE,
            'max_size' => "1000000", 
            'max_height' => "1024000",
            'max_width' => "768000"
        );

        $file_name = $_FILES["upload"]['name'];
        if(strrpos($file_name, '.')>0){
            $file_ext = substr($file_name, strrpos($file_name, '.'));
        } else {
            $file_ext = '.pdf';
        }
        $file_name = substr($file_name, 0, strrpos($file_name, '.'));
        $file_name = str_replace(' ', "_", $file_name);
        $file_name = preg_replace('/[^A-Za-z0-9_\-]/', '', $file_name);
        $new_name = time().'_'.$file_name.$file_ext;

        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('upload')){ 
            $this->upload->display_errors();
        } else {
            $uploadDetailArray = $this->upload->data();
        }

        sleep(1);

        $file_name = $uploadDetailArray['file_name'];
        // print_r($file_name); echo '<br/><br/>';
        $filename = $path.$uploadDetailArray['file_name'];
        // $this->upload_file_data($filename);
        // print_r($filename);
        // $filename = str_replace('/', '\\', $filename);
        // print_r($filename);
        // exit;

        $output_file_name = '';

        if($filename!='') {
                $sql = "insert into pdf_upload_files (file_name, file_path, upload_date, status, created_by, created_on, modified_by, modified_on) VALUES ('".$file_name."', '".$path."', '".$curdate."', 'Uploading', '".$curusr."', '".$now."', '".$curusr."', '".$now."')";
            $this->db->query($sql);
            $file_id = $this->db->insert_id();

            sleep(1);

            // php_pdf($file_id);
            $output_file_name = $this->Pdf_upload_model->edit_pdf($file_id);
        }
        
        sleep(4);

        if($output_file_name!='') {
            $this->session->set_flashdata('success', 'File Upload Succeded.<br/>Please check  output file <a href="'.base_url().'assets/uploads/pdf_upload/'.$output_file_name.'" target="_blank">'.$output_file_name.'</a>');
            $this->session->keep_flashdata('success');
        } else {
            $sql = "UPDATE pdf_upload_files SET status='Failed', remarks='File Upload Failed.' WHERE id='$file_id'";
            $this->db->query($sql);

            $this->session->set_flashdata('error', 'File Upload Failed.');
            $this->session->keep_flashdata('error');
        }
        
        redirect(base_url().'index.php/Pdf_upload');
    }
}
?>