<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Login extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
		$this->load->helper('cookie');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('dashboard_model');
        $this->load->model('user_access_log_model');
        $this->load->database();
    }

    //index function
    public function index() {
		if(get_cookie('email')!=NULL || get_cookie('email')!=''){
			$this->check_credentials();
		} else {
			$this->load->view('login/main_page');
		}
		//set_cookie('cookie_name','cookie_value','3600');
    }

    public function check_credentials() {
		if(get_cookie('email')!=NULL || get_cookie('password')!=''){
            $uname=get_cookie('email');
            $upass=get_cookie('password');

            $query=$this->db->query("SELECT A.id,A.emp_code,A.email_id,A.first_name,A.last_name,A.role_id,A.sales_rep_id,B.sr_type,A.status FROM user_master A left outer join sales_rep_master B on B.id=A.sales_rep_id WHERE A.email_id = '$uname' AND A.password = '$upass' AND A.status IS NOT NULL ");
            $result=$query->result();
		} else {
            $uname=$this->input->post('email');
            $upass=$this->input->post('password');

            $query=$this->db->query("SELECT A.id,A.emp_code,A.email_id,A.first_name,A.last_name,A.role_id,A.sales_rep_id,B.sr_type,A.status FROM user_master A left outer join sales_rep_master B on B.id=A.sales_rep_id WHERE A.email_id = '$uname' AND A.password = '$upass' AND A.status IS NOT NULL ");
            $result=$query->result();
		}
		
        if(count($result) > 0 ) {
            if($result[0]->status!='InActive') {
                $sessiondata = array(
                                    'session_id' => $result[0]->id,
                                    'user_name' => $result[0]->email_id,
                                    'login_name' => $result[0]->first_name . ' ' . $result[0]->last_name,
                                    'role_id' => $result[0]->role_id,
                                    'sales_rep_id' => $result[0]->sales_rep_id,
                                    'type' => $result[0]->sr_type,
                                    'emp_code' => $result[0]->emp_code
                                );

                $this->session->set_userdata($sessiondata);
                $unexpired_cookie_exp_time = 2147483647 - time();
                set_cookie('email',$uname,$unexpired_cookie_exp_time); 
                set_cookie('password',$upass,$unexpired_cookie_exp_time);
                
                $logarray['table_id']='1';
                $logarray['module_name']='Login';
                $logarray['cnt_name']='Login';
                $logarray['action']='Logged in';
                $this->user_access_log_model->insertAccessLog($logarray);

                $srtype=$result[0]->sr_type;
                $role_id=$result[0]->role_id;

                if(isset($result[0]->sales_rep_id) && $result[0]->sales_rep_id<>""){
                    // echo 'index.php/Sales_Attendence/';
                    redirect(base_url().'index.php/Sales_Attendence/');    
                    /*if($srtype==='Promoter') {
                        redirect(base_url().'index.php/Dashboard_promoter/');    
                    }
                    else if($srtype=='Merchandizer') {
                        redirect(base_url().'index.php/merchandiser_location');
                    }
                    else {
                        redirect(base_url().'index.php/Dashboard_sales_rep');
                    }*/
                } else {
                    if($role_id==10){
                        redirect(base_url().'index.php/Dashboard/production');
                    } else {
                        $result=$this->dashboard_model->get_access();
                        if(count($result)>0) {
                            //echo '<script>alert("'.$this->session->userdata('role_id').'");</script>';
                            redirect(base_url().'index.php/Dashboard');
                        } else {
                            redirect(base_url().'index.php/Dashboard/Dashboardscreen');
                        }
                    }
                    
                    // echo $this->session->userdata('role_id');
                }   
            } else {
                echo "<script>alert('User is Inactive');</script>";
                $this->load->view('login/main_page');
            }
        } else {
            echo "<script>alert('Invalid Username or Password.');</script>";
			$this->load->view('login/main_page');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
		delete_cookie('email'); 
		delete_cookie('password'); 
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
	
    public function chk_coockie() {
        $unexpired_cookie_exp_time = 2147483647 - time();

        $cookie = array(
            'name' => 'cookie_name',
            'value' => 'cookie_value',
            'expire'=> $unexpired_cookie_exp_time
        );

        $CI->input->set_cookie($cookie);
    }

    public function check_credentials_api() {
        $uname=urldecode($this->input->post('email'));
        $upass=urldecode($this->input->post('password'));

        // $uname='raveer66@gmail.com';
        // $upass='pass@123';

        $sql = "select A.id, A.emp_code, A.email_id, ifnull(A.first_name,'') as first_name, 
                    ifnull(A.last_name,'') as last_name, A.role_id, 
                    A.sales_rep_id, A.status, B.sr_type, C.check_in_time, C.check_out_time 
                from user_master A 
                left join sales_rep_master B on (A.sales_rep_id=B.id) 
                left join sales_attendence C on (A.sales_rep_id=C.sales_rep_id and date(check_in_time)=curdate()) 
                where A.email_id = '$uname' and A.password = '$upass' and 
                    A.status is not null";
        $query=$this->db->query($sql);
        $result=$query->result();
        
        if(count($result) > 0) {
            if(isset($result[0]->sales_rep_id)==false || $result[0]->sales_rep_id=='') {
                $data['result'] = '0';
                $data['msg'] = 'You do not have access of this application.';
            } else if($result[0]->status!='InActive') {
                $sessiondata = array(
                                    'session_id' => $result[0]->id,
                                    'user_name' => $result[0]->email_id,
                                    'login_name' => (isset($result[0]->first_name)?$result[0]->first_name:'') . ' ' . (isset($result[0]->last_name)?$result[0]->last_name:''),
                                    'role_id' => $result[0]->role_id,
                                    'sales_rep_id' => $result[0]->sales_rep_id,
                                    'type' => $result[0]->sr_type,
                                    'emp_code' => $result[0]->emp_code,
                                    'first_name' => (isset($result[0]->first_name)?$result[0]->first_name:''),
                                    'last_name' => (isset($result[0]->last_name)?$result[0]->last_name:''),
                                    'check_in_time' => $result[0]->check_in_time,
                                    'check_out_time' => $result[0]->check_out_time
                                );

                // $this->session->set_userdata($sessiondata);
                // $unexpired_cookie_exp_time = 2147483647 - time();
                // set_cookie('email',$uname,$unexpired_cookie_exp_time); 
                // set_cookie('password',$upass,$unexpired_cookie_exp_time);
                
                $logarray['table_id']='1';
                $logarray['module_name']='Mobile App Login';
                $logarray['cnt_name']='Login';
                $logarray['action']='Mobile App Logged in';
                $this->user_access_log_model->insertAccessLog($logarray);

                $data['sessiondata'] = $sessiondata;
                $data['result'] = '1';
                $data['data'] = $result;
                $data['msg'] = 'Login Successfull.';
            } else {
                $data['result'] = '0';
                $data['msg'] = 'User is Inactive.';
            }
        } else {
            $data['result'] = '0';
            $data['msg'] = 'Invalid Username or Password.';
        }

        echo json_encode($data);
    }

    public function send_password_email_api() {
        try {
            $uname='prasad.bhisale@otbconsulting.co.in';
            if($this->input->post('email')){
                $uname=urldecode($this->input->post('email'));
            }

            $query=$this->db->query("SELECT * FROM user_master WHERE email_id='$uname'");
            $result=$query->result();
            if (count($result) > 0) {
                $from_email_sender = 'Wholesome Habits Pvt Ltd';
                $from_email = 'cs@eatanytime.co.in';
                $to_email = $result[0]->email_id;
                $subject = 'Your password for Eat ERP';
                $message = '<html><head></head><body>Hi,<br /><br />' .
                            'Password: ' . $result[0]->password .
                            '<br /><br />Thanks</body></html>';

                $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message);

                if($mailSent==1){
                    echo 'Valid';
                } else {
                    echo 'Invalid';
                }
            } else {
                echo 'Invalid';
            }
        } catch (Exception $ex) {
            echo 'Invalid';
        }
    }

    public function test_email() {
        try {
                $from_email_sender = 'Wholesome Habits Pvt Ltd';
                $from_email = 'cs@eatanytime.co.in';
                // $to_email = 'prasad.bhisale@otbconsulting.co.in';
                $to_email = 'ashwini.patil@otbconsulting.co.in';
                // $to_email = 'priti.tripathi@eatanytime.in';
                $subject = 'Your password for Eat ERP';

                $message = '<html>
                            <head></head>
                            <body>
                                <div style="background-color:#7bceeb;">
                                    <!--[if gte mso 9]>
                                    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                                    <v:fill type="tile" src="https://i.imgur.com/YJOX1PC.png" color="#7bceeb"/>
                                    </v:background>
                                    <![endif]-->
                                    <table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td valign="top" align="left" background="https://i.imgur.com/YJOX1PC.png">
                                            Password
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </body>
                            </html>';

                // $message = '<html>
                //             <head></head>
                //             <body>
                //                 <div style="background-color:#ffffff;">
                //                     <!--[if gte mso 9]>
                //                     <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                //                     <v:fill type="tile" src="https://www.eatanytime.in/BG.png" color="#ffffff"/>
                //                     </v:background>
                //                     <![endif]-->
                //                     <table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0">
                //                         <tr>
                //                             <td valign="top" align="left" background="https://www.eatanytime.in/BG.png">
                //                             Password
                //                             </td>
                //                         </tr>
                //                     </table>
                //                 </div>
                //             </body>
                //             </html>';

                $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message);

                echo $message.'<br/><br/>';

                if($mailSent==1){
                    echo 'Valid';
                } else {
                    echo 'Invalid';
                }
        } catch (Exception $ex) {
            echo 'Invalid';
        }
    }
}
	  
?>