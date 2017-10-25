<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_model');
        $this->load->model('document_model');
        $this->load->model('export_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_model->get_data();

            load_view('sales_rep/sales_rep_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_model->get_access();

                load_view('sales_rep/sales_rep_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sales_rep_model->get_access();
                $data['data'] = $this->sales_rep_model->get_data('', $id);

                $docs=$this->document_model->edit_view_doc('', $id, 'Sales_Rep');
                $data=array_merge($data, $docs);

                load_view('sales_rep/sales_rep_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->sales_rep_model->save_data();
        redirect(base_url().'index.php/sales_rep');
    }

    public function update($id){
        $this->sales_rep_model->save_data($id);
        redirect(base_url().'index.php/sales_rep');
    }

    public function check_sales_rep_availablity(){
        $result = $this->sales_rep_model->check_sales_rep_availablity();
        echo $result;
    }

    public function sales_rep_route_plan(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            $data['access'] = $result;
            $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
            load_view('sales_rep/sales_rep_route_plan', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_route_plan($id, $date){
        // $result=$this->sales_rep_model->get_access();
        // if(count($result)>0) {
        //     $data['access'] = $result;

            $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
            $data['sales_rep_id'] = $id;
            $data['date'] = $date;
            load_view('sales_rep/sales_rep_date_wise_route_plan', $data);

        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }
    }

    public function email_route_plan(){
        // $date = date('Y-m-d');
        // // $date = '2017-04-15';
        // $from_email = 'cs@eatanytime.in';
        // $from_email_sender = 'Eat ERP';
        // // $to_email = 'rishit.sanghvi@otbconsulting.co.in';
        // // $to_email = 'prasad.bhisale@otbconsulting.co.in';
        // $to_email = 'dhaval.maru@otbconsulting.co.in';
        // $subject = 'Route Plan For - ' . $date;
        // $links = '';

        // $data = $this->sales_rep_model->get_sales_rep_details($date);
        // for($i=0; $i<count($data); $i++){
        //     $links = $links.($i+1).'. <a href="'.base_url().'index.php/sales_rep/get_route_plan/'.$data[$i]->sales_rep_id.'/'.$date.'" target="_new">'.$data[$i]->sales_rep_name.'</a><br/>';
        // }

        // if($links!=''){
        //     $message = '<html><head></head><body>Hi,<br /><br />
        //             Please find Sales Representative Route Plan For - '.$date.'. <br /><br />'.$links.'<br/>
        //             <br />Thanks</body></html>';
        //     $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        //     echo $message;
        //     echo '<br/>';
        //     echo $mailSent;
        // }

        $this->email_sales_rep_loc();
    }

    public function email_sales_rep_loc(){
        $date = date('Y-m-d');
        // $date = '2017-03-22';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'Eat ERP';
        // $bcc = 'prasad.bhisale@otbconsulting.co.in';
        // $bcc = 'rishit.sanghvi@otbconsulting.co.in, swapnil.darekar@otbconsulting.co.in';
        $subject = 'Route Plan For - ' . $date;
        $links = '';
        $table = '';
        $tr = '';

        $product_data = $this->export_model->get_product_data($date, $date);
        $product_th = '';
        $product_cnt = count($product_data);
        for($k=0; $k<count($product_data); $k++){
            $product_name = $product_data[$k]->product_name;
            $product_name = str_replace('E.A.T', '', $product_name);
            $product_name = str_replace('Anytime', '', $product_name);
            $product_name = str_replace('  ', '', $product_name);
            $product_name = str_replace(' Bar', '', $product_name);
            $product_th = $product_th . '<th style="text-align:center;">'.$product_name.'</th>';
        }

        $product_data = $this->export_model->get_sales_rep_order_data($date, $date);
        $data = $this->sales_rep_model->get_sales_rep_details($date);
        for($i=0; $i<count($data); $i++){

            $loc_data = $this->export_model->get_sales_rep_loc_data($data[$i]->sales_rep_id, $date, $date);
            if(count($loc_data)>0){
                $tr = '';

                for($j=0; $j<count($loc_data); $j++){
                    $tr = $tr . '<tr>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->date_of_visit.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->sales_rep_name.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->distributor_name.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->distributor_type.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->distributor_status.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->remarks.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->modified_on.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->modified_on_time.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->diff.' minutes</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->orange_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->mint_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->butterscotch_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->bambaiyachaat_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->chocopeanut_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->mangoginger_bar.'</td>';

                    $product_1_td = '<td style="text-align:center;"></td>';
                    $product_2_td = '<td style="text-align:center;"></td>';
                    $product_3_td = '<td style="text-align:center;"></td>';
                    $product_4_td = '<td style="text-align:center;"></td>';
                    $product_5_td = '<td style="text-align:center;"></td>';
                    $product_6_td = '<td style="text-align:center;"></td>';

                    if($loc_data[$j]->distributor_status == 'Place Order'){
                        for($k=0; $k<count($product_data); $k++){
                            if($product_data[$k]->date_of_processing==$loc_data[$j]->date_of_visit && 
                                $product_data[$k]->distributor_id==$loc_data[$j]->distributor_id){
                                    if($product_data[$k]->product_id == '1'){
                                        $product_1_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '2'){
                                        $product_2_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '3'){
                                        $product_3_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '4'){
                                        $product_4_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '5'){
                                        $product_5_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '6'){
                                        $product_6_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    }
                            }
                        }
                    }
                    
                    $tr = $tr . $product_1_td . $product_2_td . $product_3_td . $product_4_td . $product_5_td . $product_6_td;

                    $tr = $tr . '</tr>';
                }


                $table = '<table border="1" style="border-collapse: collapse;">
                            <tr>
                                <th style="text-align:center;">Date of Visit</th>
                                <th style="text-align:center;">Sales Representative Name</th>
                                <th style="text-align:center;">Distributor Name</th>
                                <th style="text-align:center;">Distributor Type</th>
                                <th style="text-align:center;">Visit Status</th>
                                <th style="text-align:center;">Remarks</th>
                                <th style="text-align:center;">Creation Date</th>
                                <th style="text-align:center;">Time</th>
                                <th style="text-align:center;">Time Difference</th>
                                <th colspan="'.$product_cnt.'">Available Stock</th>
                                <th colspan="'.$product_cnt.'">Ordered Stock</th>
                            </tr>
                            <tr>
                                <th colspan="9">&nbsp;</th>
                                '.$product_th.'
                                '.$product_th.'
                            </tr>
                            '.$tr.'
                        </table>';


                $message = '<html><head></head><body>Hi,<br /><br />
                            Please find below '.$data[$i]->sales_rep_name.' Location For - '.$date.'. <br /><br />'.$table.'<br/>
                            <br />Thanks</body></html>';
                // $to_email = $data[$i]->email_id.',rishit.sanghvi@otbconsulting.co.in,swapnil.darekar@otbconsulting.co.in';
                $bcc="dhaval.maru@otbconsulting.co.in";
                // $to_email = 'dhaval.maru@otbconsulting.co.in,dhavalbright@gmail.com';
                $to_email = 'dhaval.maru@otbconsulting.co.in';
                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc);

                echo $message;
                echo '<br/>';
                echo $mailSent;
                echo '<br/><br/>';
            }

        }
    }

    public function sales_rep_location(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            $data['access'] = $result;
            $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
            load_view('sales_rep/sales_rep_location', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

}
?>