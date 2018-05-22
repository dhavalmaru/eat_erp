<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class User_roles extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('user_role_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->user_role_model->get_access();
        if(count($result)>0) {
            $data['access'] = $result;
            $data['data'] = $this->user_role_model->get_data();

            load_view('user_role/user_role_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->user_role_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data = $this->get_report_groups();
                $data['access'] = $result;
                load_view('user_role/user_role_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->user_role_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data = $this->get_report_groups();
                $data['access'] = $result;

                $data['data'] = $this->user_role_model->get_data('', $id);
                $data['editoptions'] = $this->user_role_model->get_user_role_options($id);
                
                $query=$this->db->query("SELECT * FROM report_roles WHERE role_id = '$id'");
                $result=$query->result();
                if (count($result)>0) {
                    for($i=0;$i<count($result);$i++) {
                        $data['rep_' . $result[$i]->rep_id]=$result[$i]->rep_view;
                    }
                }

                $data['id']=$id;

                load_view('user_role/user_role_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function copy($id){
        $result=$this->user_role_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data = $this->get_report_groups();
                $data['access'] = $result;

                $data['data'] = $this->user_role_model->get_data('', $id);
                $data['editoptions'] = $this->user_role_model->get_user_role_options($id);
                
                $query=$this->db->query("SELECT * FROM report_roles WHERE role_id = '$id'");
                $result=$query->result();
                if (count($result)>0) {
                    for($i=0;$i<count($result);$i++) {
                        $data['rep_' . $result[$i]->rep_id]=$result[$i]->rep_view;
                    }
                }

                $data['id']=0;

                load_view('user_role/user_role_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->user_role_model->save_data();
        redirect(base_url().'index.php/user_roles');
    }

    public function update($id){
        $data = $this->get_report_groups();
        $this->user_role_model->save_data($id);
        redirect(base_url().'index.php/user_roles');
    }

    public function check_role_availablity(){
        $result = $this->user_role_model->check_role_availablity();
        echo $result;
    }

    public function get_report_groups(){
        for($i=1; $i<30; $i++) {
            $data['rep_' . $i . '_view'] = 1;
        }

        // $query=$this->db->query("SELECT * FROM report_groups where rep_grp_id = '$gid'");
        // $result=$query->result();

        // if (count($result)>0) {
        //     for($i=0; $i<count($result); $i++) {
        //         $data['rep_' . $result[$i]->rep_id . '_view'] = $result[$i]->rep_view;
        //     }
        // }

        $data['rep_grp_1']=0;
        $data['rep_grp_2']=0;
        $data['rep_grp_3']=0;
        $data['rep_grp_4']=0;
        // $data['rep_grp_5']=0;
        // $data['rep_grp_6']=0;

        //if (isset($data['rep_1_view'])) {if ($data['rep_1_view']==1) $data['rep_grp_1']=1;}
		if (isset($data['rep_18_view'])) {if ($data['rep_18_view']==1) $data['rep_grp_1']=1;}
		if (isset($data['rep_15_view'])) {if ($data['rep_15_view']==1) $data['rep_grp_1']=1;}
		
		if (isset($data['rep_5_view'])) {if ($data['rep_5_view']==1) $data['rep_grp_3']=1;}
        if (isset($data['rep_6_view'])) {if ($data['rep_6_view']==1) $data['rep_grp_3']=1;}
        if (isset($data['rep_7_view'])) {if ($data['rep_7_view']==1) $data['rep_grp_3']=1;}
        if (isset($data['rep_14_view'])) {if ($data['rep_14_view']==1) $data['rep_grp_3']=1;}
        if (isset($data['rep_17_view'])) {if ($data['rep_17_view']==1) $data['rep_grp_3']=1;}
        if (isset($data['rep_9_view'])) {if ($data['rep_9_view']==1) $data['rep_grp_3']=1;}
		
		
		if (isset($data['rep_2_view'])) {if ($data['rep_2_view']==1) $data['rep_grp_2']=1;}
        if (isset($data['rep_3_view'])) {if ($data['rep_3_view']==1) $data['rep_grp_2']=1;}
        if (isset($data['rep_4_view'])) {if ($data['rep_4_view']==1) $data['rep_grp_2']=1;}
        if (isset($data['rep_10_view'])) {if ($data['rep_10_view']==1) $data['rep_grp_2']=1;}

        if (isset($data['rep_11_view'])) {if ($data['rep_11_view']==1) $data['rep_grp_2']=1;}
        if (isset($data['rep_12_view'])) {if ($data['rep_12_view']==1) $data['rep_grp_2']=1;}
		
		
		
		
        if (isset($data['rep_13_view'])) {if ($data['rep_13_view']==1) $data['rep_grp_4']=1;}
		if (isset($data['rep_20_view'])) {if ($data['rep_20_view']==1) $data['rep_grp_4']=1;}
        if (isset($data['rep_21_view'])) {if ($data['rep_21_view']==1) $data['rep_grp_4']=1;}
		
		
		

        // if (isset($data['rep_15_view'])) {if ($data['rep_15_view']==1) $data['rep_grp_3']=1;}
        // if (isset($data['rep_16_view'])) {if ($data['rep_16_view']==1) $data['rep_grp_3']=1;}

        // if (isset($data['rep_17_view'])) {if ($data['rep_17_view']==1) $data['rep_grp_4']=1;}
        // if (isset($data['rep_18_view'])) {if ($data['rep_18_view']==1) $data['rep_grp_4']=1;}
        // if (isset($data['rep_19_view'])) {if ($data['rep_19_view']==1) $data['rep_grp_4']=1;}


        // if (isset($data['rep_21_view'])) {if ($data['rep_21_view']==1) $data['rep_grp_5']=1;}
        // if (isset($data['rep_22_view'])) {if ($data['rep_22_view']==1) $data['rep_grp_5']=1;}
        // if (isset($data['rep_23_view'])) {if ($data['rep_23_view']==1) $data['rep_grp_5']=1;}
        // if (isset($data['rep_24_view'])) {if ($data['rep_24_view']==1) $data['rep_grp_5']=1;}
        // if (isset($data['rep_25_view'])) {if ($data['rep_25_view']==1) $data['rep_grp_5']=1;}

        // if (isset($data['rep_26_view'])) {if ($data['rep_26_view']==1) $data['rep_grp_6']=1;}
        // if (isset($data['rep_27_view'])) {if ($data['rep_27_view']==1) $data['rep_grp_6']=1;}
        // if (isset($data['rep_28_view'])) {if ($data['rep_28_view']==1) $data['rep_grp_6']=1;}
        // if (isset($data['rep_29_view'])) {if ($data['rep_29_view']==1) $data['rep_grp_6']=1;}
        // if (isset($data['rep_30_view'])) {if ($data['rep_30_view']==1) $data['rep_grp_6']=1;}

        return $data;
    }

}
?>