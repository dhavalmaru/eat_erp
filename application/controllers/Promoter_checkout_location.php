<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Promoter_checkout_location extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('promoter_checkout_location_model');
        $this->load->model('export_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->promoter_checkout_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->promoter_checkout_location_model->get_data();

            load_view('promoter_location/promoter_checkout_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add($id){
        $data['id'] = $id;
        $data['dist_name'] = $this->promoter_checkout_location_model->get_dist_name($id);
		
        $result=$this->promoter_checkout_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->promoter_checkout_location_model->get_access();
                $data['distributor'] = $this->promoter_checkout_location_model->get_dist_list('Approved');

                load_view('promoter_location/promoter_checkout_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->promoter_checkout_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->promoter_checkout_location_model->get_data('', $id);
                $data['data1'] = $this->promoter_checkout_location_model->get_data_qty('', $id);
                $data['distributor'] = $this->promoter_checkout_location_model->get_data('Approved');

                load_view('promoter_location/promoter_checkout_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function update_checkout() {
		// $id= $this->input->post('id');
		// $date_of_visit=$this->input->post('date_of_visit');
   
		$data['data4'] =$this->promoter_checkout_location_model->update_checkout1();

		// $data = array(
		
            // 'checkout_status'=> $this->input->post('checkout_status'),

        // );
    }  

	
    public function save($id=""){
        if($id == ""){
            $this->promoter_checkout_location_model->save_data('');
        } else {
            $this->promoter_checkout_location_model->save_data($id);
        }

        redirect(base_url().'index.php/dashboard_promoter');
        
    }

    public function check_date_of_visit(){
        $result = $this->promoter_checkout_location_model->check_date_of_visit();
        echo $result;
    }

    public function email_promoter_stock(){
        $date = date('Y-m-d');
        // $date = '2017-06-10';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'Eat ERP';
        // $bcc = 'dhaval.maru@otbconsulting.co.in';
        // $bcc = 'rishit.sanghvi@otbconsulting.co.in, swapnil.darekar@otbconsulting.co.in';
        $subject = 'Promoter Stock Report For - ' . $date;
        $links = '';
        $table = '';
        $tr = '';

        // $data = $this->sales_rep_model->get_sales_rep_details($date);
        // for($i=0; $i<count($data); $i++){

        $loc_data = $this->export_model->generate_promoter_stock_report_cron($date, $date);
        // echo count($loc_data);
        if(count($loc_data)>0){
            $tr = '';

            for($j=0; $j<count($loc_data); $j++){
                $total_amount = $loc_data[$j]->butterscotch + $loc_data[$j]->mint + $loc_data[$j]->orange + $loc_data[$j]->chocopeanut +$loc_data[$j]->bambaiyachaat + $loc_data[$j]->mangoginger;

                $tr = $tr . '<tr>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->date_of_visit.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->sales_rep_name.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->store_name.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->in_time.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->out_time.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->orange.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->butterscotch.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->mint.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->chocopeanut.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->bambaiyachaat.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->mangoginger.'</td>';
                $tr = $tr . '<td style="text-align:center;">'.$total_amount.'</td>';
                $tr = $tr . '</tr>';
            }

            $table = '<table border="1" style="border-collapse: collapse;">
                        <tr>
                            <th style="text-align:center;">Date of Visit</th>
                            <th style="text-align:center;">Promoter Name</th>
                            <th style="text-align:center;">Store Name</th>
                            <th style="text-align:center;">In Time</th>
                            <th style="text-align:center;">Out Time</th>
                            <th style="text-align:center;">Orange Bar</th>
                            <th style="text-align:center;">Butterscotch Bar</th>
                            <th style="text-align:center;">Mint Bar</th>
                            <th style="text-align:center;">Choco Peanut Bar</th>
                            <th style="text-align:center;">Bambaiya Chaat Bar</th>
                            <th style="text-align:center;">Mango Ginger Bar</th>
                            <th style="text-align:center;">Total</th>
                        </tr>
                        '.$tr.'
                    </table>';

            $message = '<html><head></head><body>Hi,<br /><br />
                        Please find below Promoters Stock Report for - '.$date.'. <br /><br />'.$table.'<br/>
                        <br />Thanks</body></html>';
            $to_email = 'rishit.sanghvi@eatanytime.in,swapnil.darekar@eatanytime.in';
            $bcc="dhaval.maru@otbconsulting.co.in";
            //$to_email = 'dhaval.maru@otbconsulting.co.in';
            $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc);

            echo $message;
            echo '<br/>';
            echo $mailSent;
            echo '<br/><br/>';
        }
        // echo 'd'/;
        // }
    }

    public function email_promoter_check_in(){
        $date = date('Y-m-d');
        // $date = '2017-08-22';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'Eat ERP';
        // $bcc = 'dhaval.maru@otbconsulting.co.in';
        // $bcc = 'rishit.sanghvi@otbconsulting.co.in, swapnil.darekar@otbconsulting.co.in';
        $subject = 'Promoter Checkin For - ' . $date;
        $links = '';
        $table = '';
        $tr = '';

        // $data = $this->sales_rep_model->get_sales_rep_details($date);
        // for($i=0; $i<count($data); $i++){

            $loc_data = $this->export_model->generate_promoter_stock_report_cron($date, $date);
            // echo count($loc_data);
            if(count($loc_data)>0){
                $tr = '';

                for($j=0; $j<count($loc_data); $j++){
                    // $total_amount = $loc_data[$j]->butterscotch + $loc_data[$j]->mint + $loc_data[$j]->orange + $loc_data[$j]->chocopeanut +$loc_data[$j]->bambaiyachaat + $loc_data[$j]->mangoginger;

                    $tr = $tr . '<tr>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->date_of_visit.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->sales_rep_name.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->store_name.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->in_time.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->out_time.'</td>';
                    // $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->orange.'</td>';
                    // $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->butterscotch.'</td>';
                    // $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->mint.'</td>';
                    // $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->chocopeanut.'</td>';
                    // $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->bambaiyachaat.'</td>';
                    // $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->mangoginger.'</td>';
                    // $tr = $tr . '<td style="text-align:center;">'.$total_amount.'</td>';
                    $tr = $tr . '</tr>';
                }


                $table = '<table border="1" style="border-collapse: collapse;">
                            <tr>
                                <th style="text-align:center;">Date of Visit</th>
                                <th style="text-align:center;">Promoter Name</th>
                                <th style="text-align:center;">Store Name</th>
                                <th style="text-align:center;">In Time</th>
                                <th style="text-align:center;">Out Time</th>                                
                            </tr>
                            '.$tr.'
                        </table>';


                $message = '<html><head></head><body>Hi,<br /><br />
                            Please find below Promoters Check in Report for - '.$date.'. <br /><br />'.$table.'<br/>
                            <br />Thanks</body></html>';
                            // echo $message;
                $to_email = 'rishit.sanghvi@eatanytime.in,swapnil.darekar@eatanytime.in';
                $bcc="dhaval.maru@otbconsulting.co.in";
                // $to_email = 'dhaval.maru@otbconsulting.co.in';
                // $to_email = 'dhaval.maru@otbconsulting.co.in';
                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc);

                echo $message;
                echo '<br/>';
                echo $mailSent;
                echo '<br/><br/>';
            }
            // echo 'd'/;
        // }
    }
}
?>