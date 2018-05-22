<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('dashboard_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $this->load->view('login/main_page');
    }

    public function check_credentials() {
        $uname=$this->input->post('email');
        $upass=$this->input->post('password');

        $query=$this->db->query("SELECT A.id,A.email_id,A.first_name,A.last_name,A.role_id,A.sales_rep_id,B.sr_type FROM user_master A left outer join sales_rep_master B on B.id=A.sales_rep_id WHERE A.email_id = '$uname' AND A.password = '$upass'");
        $result=$query->result();
        
        if(count($result) > 0 ) {
            $sessiondata = array(
                                'session_id' => $result[0]->id,
                                'user_name' => $result[0]->email_id,
                                'login_name' => $result[0]->first_name . ' ' . $result[0]->last_name,
                                'role_id' => $result[0]->role_id,
                                'sales_rep_id' => $result[0]->sales_rep_id,
                                'type' => $result[0]->sr_type
                            );

            $this->session->set_userdata($sessiondata);

            $logarray['table_id']='1';
            $logarray['module_name']='Login';
            $logarray['cnt_name']='Login';
            $logarray['action']='Logged in';
            $this->user_access_log_model->insertAccessLog($logarray);

            $srtype=$result[0]->sr_type;

            if(isset($result[0]->sales_rep_id) && $result[0]->sales_rep_id<>""){
                if($srtype==='Promoter') {
                    redirect(base_url().'index.php/Dashboard_promoter/');    
                }
                else if($srtype=='Merchandizer') {
                    redirect(base_url().'index.php/merchandiser_location');
                }
                else {
                    redirect(base_url().'index.php/Dashboard_sales_rep');
                }
            } else {
                 $result=$this->dashboard_model->get_access();
                 if(count($result)>0) {
					 //echo '<script>alert("'.$this->session->userdata('role_id').'");</script>';
                     redirect(base_url().'index.php/Dashboard');
                }
                else {
                     redirect(base_url().'index.php/Dashboard/Dashboardscreen');
                 }
				// echo $this->session->userdata('role_id');
            }
        } else {
            echo "<script>alert('Invalid Username or Password.');</script>";
			$this->load->view('login/main_page');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect();
    }

    public function forgot_password_email() {
        $to_email = $this->input->post('email');
        $query=$this->db->query("SELECT * FROM user_master WHERE email_id='" . $to_email . "'");
        $result=$query->result();
		if($to_email!=''){
			if (count($result) > 0) {
				$from_email = 'cs@eatanytime.in';
				$from_email_sender = 'Eat ERP';
				$subject = 'Your password for Eat ERP';
				$message = '<html><head></head><body>Hi,<br /><br />' .
							'Password: ' . $result[0]->password .
							'<br /><br />Thanks</body></html>';
				$mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
				if ($mailSent==1) {
					echo "Password has been mailed to your email id.";
				} else {
					echo "Mail sending failed.";
				}
			} else {
				echo "Please enter correct email id.";
			}
		}
		else {
				echo "Please enter email id.";
		}
        // $this->load->view('login/main_page');
    }

    public function password_email() {
        $query=$this->db->query("SELECT * FROM user_master WHERE email_id='swapnil.darekar@otbconsulting.co.in'");
        $result=$query->result();

        if (count($result) > 0) {
            $from_email = 'swapnil.darekar@eatanytime.in';
            $from_email_sender = 'Eat ERP';
            $to_email = $result[0]->email_id;
            $subject = 'Your password for property';
            $message = '<html><head></head><body>Hi,<br /><br />' .
                        'Password: ' . $result[0]->password .
                        '<br /><br />Thanks</body></html>';
            $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
            if ($mailSent==1) {
                echo "<script>alert('Password has been mailed to your email id.');</script>";
            } else {
                echo "<script>alert('Mail sending failed.');</script>";
            }
        } else {
            echo "<script>alert('Please enter correct email id.');</script>";
        }

        $this->load->view('login/main_page');
    }

    function send_password_email() {
        try {
            $from_email = 'cs@eatanytime.in'; //change this to yours

            $query=$this->db->query("SELECT * FROM user_master WHERE email_id='swapnil.darekar@otbconsulting.co.in'");
            $result=$query->result();

            if (count($result) > 0) {
                $to_email = $result[0]->email_id;
                $subject = 'Your password for Eat ERP';
                $message = '<html><head></head><body>Hi,<br /><br />' .
                            'Password: ' . $result[0]->password .
                            '<br /><br />Thanks</body></html>';

                //configure email settings
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'mail.eatanytime.in'; //smtp host name
                $config['smtp_port'] = '587'; //smtp port number
                $config['smtp_user'] = $from_email;
                $config['smtp_pass'] = 'Cs@12345#'; //$from_email password
                $config['mailtype'] = 'html';
                $config['charset'] = 'iso-8859-1';
                $config['wordwrap'] = TRUE;
                $config['newline'] = "\r\n"; //use double quotes
                $this->email->initialize($config);

                //send mail
                $this->email->from($from_email, 'Eat ERP');
                $this->email->to($to_email);
                $this->email->subject($subject);
                $this->email->message($message);
                return $this->email->send();
            }
        } catch (Exception $ex) {
            
        }
    }

    public function check_old_password() {
        $uid=$this->session->userdata('session_id');
        $upass=$this->input->post('password');

        $query=$this->db->query("SELECT * FROM user_master WHERE id = '$uid' AND password = '$upass'");
        $result=$query->result();
        
        if (count($result)>0){
            echo 1;
        } else {
            echo 0;
        }
    }

    public function change_password() {
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');

        $data = array(
            'password' => $this->input->post('new_password'),
            'modified_by' => $curusr,
            'modified_on' => $now
        );

        if($curusr!=''){
            $this->db->where('id', $curusr);
            $this->db->update('user_master',$data);
            $action='Password Modified.';

            $logarray['table_id']=$curusr;
            $logarray['module_name']='Login';
            $logarray['cnt_name']='Login';
            $logarray['action']=$action;
            $this->user_access_log_model->insertAccessLog($logarray);
        }

        echo 1;
    }

}
?>