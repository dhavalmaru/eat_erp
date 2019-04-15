<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Email_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('document_model');
}

function get_email_details($id='', $email_type=''){
    $tbl_name = 'email_master';
    $cond = " where email_type = '$email_type'";
    if($id!=''){
        $tbl_name = 'email_details';
        $cond = $cond . " and email_ref_id = '$id'";
    }

    $sql="select * from ".$tbl_name.$cond. " order by id desc";
    $query=$this->db->query($sql);
    $result=$query->result();

    if(count($result)==0){
        $sql="select * from email_master where email_type = '$email_type' order by id desc";
        $query=$this->db->query($sql);
        $result=$query->result();
    }

    return $query->result();
}

function set_email_details($email_ref_id, $email_type, $email_from, $email_sender, $email_to, $email_subject, $email_body, $email_bcc, $email_cc) {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $login_name = $this->session->userdata('login_name');
    
    // $email_ref_id = '';
    // $email_type = 'distributor_po_mismatch';
    // $email_from = 'cs@eatanytime.in';
    // $email_sender = 'Wholesome Habits Pvt Ltd';
    // $email_to = 'prasad.bhisale@pecanreams.com';
    // $email_cc = 'prasad.bhisale@pecanreams.com';
    // $email_bcc = 'prasad.bhisale@pecanreams.com';
    // $email_subject = 'PO Amount Mismatch';
    // $email_body = 'Hi, PO Amount Mismatch Regards, Team EatAnyTime';
    
    $email_cc = 'dhaval.maru@pecanreams.com';

    $message = '<html>
                    <head>
                    <style type="text/css">
                        pre {
                            font: small/1.5 Arial,Helvetica,sans-serif;
                        }
                    </style>
                    </head>
                    <body><pre>'.$email_body.'</pre><br/><br/>
                    Team EAT Anytime<br/><br/>'.ucwords(trim($login_name)).'
                    </body>
                    </html>';

    $mailSent=send_email_new($email_from, $email_sender, $email_to, $email_subject, $message, $email_bcc, $email_cc);

    if($mailSent==1){
        $status = 1;
    } else {
        $status = 0;
    }

    $data = array(
        'email_ref_id' => ($email_ref_id==''?Null:$email_ref_id),
        'email_type' => $email_type,
        'email_from' => $email_from,
        'email_sender' => $email_sender,
        'email_to' => $email_to,
        'email_cc' => $email_cc,
        'email_bcc' => $email_bcc,
        'email_subject' => $email_subject,
        'email_body' => $email_body,
        'status' => $status,
        'created_by' => $curusr,
        'created_on' => $now,
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    $this->db->insert('email_details',$data);

    return $status;
}

}
?>