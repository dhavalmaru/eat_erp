<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class User extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('user_model');
        $this->load->model('user_role_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->user_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->user_model->get_data();

            load_view('user/user_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->user_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->user_model->get_access();
                $data['roles'] = $this->user_role_model->get_data('Approved');

                load_view('user/user_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->user_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->user_model->get_access();
                $data['roles'] = $this->user_role_model->get_data('Approved');
                $data['data'] = $this->user_model->get_data('', $id);

                load_view('user/user_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->user_model->save_data();
        redirect(base_url().'index.php/user');
    }

    public function update($id){
        $this->user_model->save_data($id);
        redirect(base_url().'index.php/user');
    }

    public function check_email_availablity(){
        $result = $this->user_model->check_email_availablity();
        echo $result;
    }

    public function send_password() {
        $f_name = $this->input->post('con_first_name');
        $to_email = $this->input->post('con_email_id');
        $password = 'Pass@123';

        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'Property Management';
        $subject = 'Login credentials for property management';
        $message = '<html><head></head><body>Hi '. $f_name .',<br /><br /> Login credentials are as follows<br /><br />' .
                    'User Name: ' . $to_email . '<br />' .
                    'Password: ' . $password .
                    '<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
    }

    public function updatepassword($uid){
        $gid=$this->session->userdata('groupid');
        $modnow=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $data = array(
            'assigned_status' => 'Active',
            'gu_password' => 'Pass@123',
            'modified_by' => $curusr,
            'modified_date' => $modnow
        );
        $this->db->where('gu_id', $uid);
        $this->db->update('group_users', $data);

        $query=$this->db->query("SELECT A.*, concat_ws(' ',B.c_name,B.c_last_name) as gu_name FROM group_users A, user_master B WHERE A.gu_id='$uid' and A.gu_cid=B.c_id");
        $result=$query->result();
        if (count($result)>0) {
            $cid = $result[0]->gu_cid;
            $f_name = $result[0]->gu_name;
            $to_email = $result[0]->gu_email;
            $password = 'Pass@123';

            $from_email = 'cs@eatanytime.in';
            $from_email_sender = 'Property Management';
            $subject = 'Password changed for property management';
            $message = '<html><head></head><body>Hi '. $f_name .',<br /><br /> Password changed. New login credentials are as follows, <br /><br />' .
                        'User Name: ' . $to_email . '<br />' .
                        'Password: ' . $password .
                        '<br /><br />Thanks</body></html>';
            $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
            $logarray['table_id']=$cid;
            $logarray['module_name']='Users';
            $logarray['cnt_name']='Users';
            $logarray['action']='User Password Resetted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);
        }
        
        echo 1;
    }

}
?>