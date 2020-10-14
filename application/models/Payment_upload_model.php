<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Payment_upload_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
    }

    function get_access(){
        $role_id=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Payment' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
        return $query->result();
    }

    function get_data($status='', $id=''){
        if($status!=""){
            $cond=" where status='".$status."'";
        } else {
            $cond="";
        }

        if($id!=""){
            if($cond=="") {
                $cond=" where id='".$id."'";
            } else {
                $cond=$cond." and id='".$id."'";
            }
        }

        $sql = "select * from payment_upload_files".$cond." order by modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function generate_payment_slip($file_id) {
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $sql = "select distinct id from payment_details where status = 'Approved' and file_id = '".$file_id."' order by id";
        $query=$this->db->query($sql);
        $query_result=$query->result();
        if(count($query_result)>0){
            for($a=0; $a<count($query_result); $a++){
                $id=$query_result[$a]->id;

                $data['id']=$id;

                $result=$this->payment_model->get_data('', $id);
                if(count($result)>0){
                    $date_of_deposit=$result[0]->date_of_deposit;
                    $total_amount=floatval($result[0]->total_amount);
                    $b_name=$result[0]->b_name;
                    $b_branch=$result[0]->b_branch;
                    $createdby=$result[0]->createdby;
                    $modifiedby=$result[0]->modifiedby;
                    $approvedby=$result[0]->approvedby;
                    $approved_on=$result[0]->approved_on;
                    $modified_on=$result[0]->modified_on;
                    $created_on=$result[0]->created_on;
                } else {
                    $date_of_deposit=null;
                    $total_amount=0;
                    $b_name='';
                    $b_branch='';
                }
                $data['total_amount']=round($total_amount,2);
                $data['date_of_deposit']=$date_of_deposit;
                $data['total_amount_in_words']=convert_number_to_words($total_amount) . ' Only';
                $data['b_name']=$b_name;
                $data['b_branch']=$b_branch;
                $data['createdby']=$createdby;
                $data['modifiedby']=$modifiedby;
                $data['approvedby']=$approvedby;
                $data['approved_on']=$approved_on;
                $data['modified_on']=$modified_on;
                $data['created_on']=$created_on;

                if(isset($date_of_deposit) && $date_of_deposit!=''){
                    $y1=substr($date_of_deposit, 0, 1);
                    $y2=substr($date_of_deposit, 1, 1);
                    $y3=substr($date_of_deposit, 2, 1);
                    $y4=substr($date_of_deposit, 3, 1);

                    $m1=substr($date_of_deposit, 5, 1);
                    $m2=substr($date_of_deposit, 6, 1);

                    $d1=substr($date_of_deposit, 8, 1);
                    $d2=substr($date_of_deposit, 9, 1);
                } else {
                    $y1="";
                    $y2="";
                    $y3="";
                    $y4="";

                    $m1="";
                    $m2="";

                    $d1="";
                    $d2="";
                }
        
                $data['y1']=$y1;
                $data['y2']=$y2;
                $data['y3']=$y3;
                $data['y4']=$y4;

                $data['m1']=$m1;
                $data['m2']=$m2;

                $data['d1']=$d1;
                $data['d2']=$d2;

                $sql = "select A.payment_mode, A.date_of_deposit, case when A.payment_mode='Cash' then null else B.ref_no end as cheque_no, 
                                B.id, B.payment_id, B.ref_no, case when A.payment_mode='Cheque' then B.bank_name else null end as bank_name, 
                                case when A.payment_mode='Cheque' then B.bank_city else null end as bank_city, B.invoice_no, 
                                B.payment_amount, A.status, A.remarks, A.created_by, A.created_on, A.modified_by, A.modified_on, 
                                A.approved_by, A.approved_on, A.rejected_by, A.rejected_on from 
                        (select * from payment_details where id = '$id') A 
                        left join 
                        (select * from payment_details_items where payment_id = '$id') B 
                        on (A.id = B.payment_id)";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $data['items']=$result;

                    // if($result[0]->payment_mode=='Cash'){
                    //     $data['denomination'] = $this->get_payment_slip_denomination($id);
                    // }
                }

                $sql = "select A.*, B.distributor_name from 
                        (select * from payment_details_items where payment_id = '$id') A 
                        left join 
                        (select * from distributor_master) B 
                        on (A.distributor_id = B.id)";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $data['distributor']=$result;
                }

                $final_data[$a] = $data;
            }
        }

        if(isset($final_data)){
            $data2['final_data'] = $final_data;

            $this->load->library('parser');
            $output = $this->parser->parse('payment/multiple_payment_slip.php',$data2,true);
            $pdf='';   
            if ($pdf=='print')
                $this->_gen_pdf($output);
            else
                $this->output->set_output($output);
        } else {
            echo 'No data found.';
        }
    }

    function generate_credit_debit_note($file_id) {
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $result_data = [];

        $sql = "select distinct A.id from credit_debit_note A left join payment_details B on(A.payment_id=B.id) where A.status = 'Approved' and B.file_id = '".$file_id."' and B.id is not null order by A.id";
        $query=$this->db->query($sql);
        $res=$query->result();
        if(count($res)>0){
            for($a=0; $a<count($res); $a++){
                $id=$res[$a]->id;

                $sql = "select A.*, concat(B.first_name, ' ', B.last_name) as createdby, 
                            concat(C.first_name, ' ', C.last_name) as modifiedby, 
                            concat(D.first_name, ' ', D.last_name) as approvedby 
                        from credit_debit_note A 
                        left join user_master B on(A.created_by=B.id) 
                        left join user_master C on(A.modified_by=C.id) 
                        left join user_master D on(A.approved_by=D.id) 
                        where A.id = '$id'";
                $query=$this->db->query($sql);
                $query_result=$query->result();
                if(count($query_result)>0){
                    $final_data['credit_debit_note'] = $query_result;

                    $distributor_id = $query_result[0]->distributor_id;

                    $final_data['total_amount_in_words']=convert_number_to_words($query_result[0]->amount) . ' Only';

                    $result = $this->distributor_model->get_data('', $distributor_id);
                    $data = array();
                    if(count($result)>0){
                        $send_invoice = $result[0]->send_invoice;
                        $class = $result[0]->class;
                        $distributor_name=$result[0]->distributor_name;
                        $state=$result[0]->state;
                        $email_id=$result[0]->email_id;
                        $mobile=$result[0]->mobile;
                        $tin_number=$result[0]->tin_number;
                        $cst_number=$result[0]->cst_number;
                        $sales_rep_name=$result[0]->sales_rep_name;
                        $state_code=$result[0]->state_code;
                        $gst_number=$result[0]->gst_number;

                        $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

                        $data['distributor_name']=$distributor_name;
                        $data['address']=$address;
                        $data['tin_number']=$tin_number;
                        $data['sales_rep_name']=$sales_rep_name;
                        
                        $data['state']=$state;
                        $data['state_code']=$state_code;
                        $data['gst_number']=$gst_number;
                    }

                    $final_data['distributor'] = $data;

                    $final_data2[$a] = $final_data;
                }
            }
        }

        if(isset($final_data)){
            $data2['final_data'] = $final_data2;

            $this->load->library('parser');
            $output = $this->parser->parse('payment/multiple_credit_debit_note.php',$data2,true);
            $pdf='';   
            if ($pdf=='print')
                $this->_gen_pdf($output);
            else
                $this->output->set_output($output);
        } else {
            echo 'No data found.';
        }
    }
}
?>