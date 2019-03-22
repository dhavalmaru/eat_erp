<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Distributor_in_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_In' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id=''){
    if($status!=""){
        if($status=="Pending"){
            $cond=" where A.status='Pending' or A.status='Deleted'";
        } else{
            $cond=" where A.status='".$status."'";
        }
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where A.id='".$id."'";
        } else {
            $cond=$cond." and A.id='".$id."'";
        }
    }

    $sql = "select G.*, H.first_name, H.last_name from 
            (select E.*, F.sales_rep_name from 
            (select C.*, D.depot_name, D.state as depot_state from 
            (select A.*, B.distributor_name, B.sell_out from 
            (select A.*, concat(B.first_name, ' ', B.last_name) as createdby, 
                concat(C.first_name, ' ', C.last_name) as modifiedby, 
                concat(D.first_name, ' ', D.last_name) as approvedby 
            from distributor_in A 
            left join user_master B on(A.created_by=B.id) 
            left join user_master C on(A.modified_by=C.id) 
            left join user_master D on(A.approved_by=D.id) ".$cond.") A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id)) E 
            left join 
            (select * from sales_rep_master) F 
            on (E.sales_rep_id=F.id)) G 
            left join 
            (select * from user_master) H 
            on(G.created_by=H.id) order by G.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_pending_data($id=''){
    $query=$this->db->query("SELECT * FROM distributor_in WHERE ref_id = '$id' and status!='InActive' AND status!='Rejected'");
    $result=$query->result();
    if (count($result)>0){
        $id = $result[0]->id;
    }

    return $id;
}

function get_distributor_in_items($id){
    $sql = "select * from distributor_in_items where distributor_in_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_in_items_ex($id){
    $sql = "select * from distributor_out_exchange_items where distributor_in_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $checked = $this->input->post('expired');
    $exchanged = $this->input->post('exhanged');
    $checked_status="";
    $exchanged_status="";
    if($checked=='1') {
        $checked_status="yes";
    } else {
        $checked_status="no";   
    }

    if($exchanged=="1") {
        $exchanged_status="yes";
    } else {
        $exchanged_status="no";
    }

    $date_of_processing=$this->input->post('date_of_processing');
    if($date_of_processing==''){
        $date_of_processing=NULL;
    } else {
        $date_of_processing=formatdate($date_of_processing);
    }

    $due_date=$this->input->post('due_date');
    if($due_date==''){
        $due_date=NULL;
    } else {
        $due_date=formatdate($due_date);
    }
    
    if($this->input->post('btn_approve')!=null || $this->input->post('btn_reject')!=null){
        if($this->input->post('btn_approve')!=null){
            if($this->input->post('status')=="Deleted"){
                $status = 'InActive';
            } else {
                $status = 'Approved';
            }
        } else {
            $status = 'Rejected';
        }

        $ref_id = $this->input->post('ref_id');
        $sales_return_no = $this->input->post('sales_return_no');

        $remarks = $this->input->post('remarks');

        if($status == 'Rejected'){
            $sql = "Update distributor_in Set status='$status', remarks='$remarks', approved_by='$curusr', approved_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Distributor In Entry '.$status.'.';
        } else {
            if($id!='' || $ref_id!=''){
                if($sales_return_no==null || $sales_return_no==''){
                    $sql="select * from series_master where type='Sales_Return'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0){
                        $series=intval($result[0]->series)+1;

                        $sql="update series_master set series = '$series' where type = 'Sales_Return'";
                        $this->db->query($sql);
                    } else {
                        $series=1;

                        $sql="insert into series_master (type, series) values ('Sales_Return', '$series')";
                        $this->db->query($sql);
                    }

                    if (isset($date_of_processing)){
                        if($date_of_processing==''){
                            $financial_year="";
                        } else {
                            $financial_year=calculateFiscalYearForDate($date_of_processing);
                        }
                    } else {
                        $financial_year="";
                    }
                    
                    $sales_return_no = 'WHPL/'.$financial_year.'/sales_return/'.strval($series);
                }

                if($ref_id!=null && $ref_id!=''){
                    $sql = "select * from distributor_out where distributor_in_id = '$ref_id' and distributor_id = '189'";
                } else {
                    $sql = "select * from distributor_out where distributor_in_id = '$id' and distributor_id = '189'";
                }
                $query=$this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    $voucher_no = $result[0]->voucher_no;

                    if($voucher_no==null || $voucher_no==''){
                        $sql="select * from series_master where type='Voucher'";
                        $query=$this->db->query($sql);
                        $result=$query->result();
                        if(count($result)>0){
                            $series=intval($result[0]->series)+1;

                            $sql="update series_master set series = '$series' where type = 'Voucher'";
                            $this->db->query($sql);
                        } else {
                            $series=1;

                            $sql="insert into series_master (type, series) values ('Voucher', '$series')";
                            $this->db->query($sql);
                        }

                        if (isset($date_of_processing)){
                            $financial_year=calculateFiscalYearForDate($date_of_processing);
                        } else {
                            $financial_year="";
                        }
                        
                        $voucher_no = 'WHPL/'.$financial_year.'/voucher/'.strval($series);
                    }
                } else {
                    $voucher_no = '';
                }
                
                if($ref_id!=null && $ref_id!=''){

                    $modified_approved_date = NULL;
                    $get_modified_approved_date_result = $this->db->select('modified_approved_date')->where('id',$id)->get('distributor_in')->result();

                    if(count($get_modified_approved_date_result)>0)
                    {
                       $modified_approved_date = $get_modified_approved_date_result[0]->modified_approved_date;
                        
                        if($modified_approved_date!=null && $modified_approved_date!="")
                        {
                            $modified_approved_date = date("Y-m-d");
                        }else
                        {
                            $modified_approved_date = NULL;
                        }
                    }
                    else
                    {
                       $modified_approved_date = NULL;
                    }

                    if($modified_approved_date!=null && $modified_approved_date!=null)
                    {
                        $sql = "Update distributor_in A, distributor_in B 
                            Set A.date_of_processing=B.date_of_processing, A.depot_id=B.depot_id, A.distributor_id=B.distributor_id,
                                A.sales_rep_id=B.sales_rep_id, A.amount=B.amount, A.tax=B.tax, A.cst=B.cst, 
                                A.tax_amount=B.tax_amount, A.final_amount=B.final_amount, A.due_date=B.due_date, 
                                A.is_expired=B.is_expired, A.final_cost_amount=B.final_cost_amount, 
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now', A.sales_return_no = '$sales_return_no', 
                                A.cgst = B.cgst, A.sgst = B.sgst, A.igst = B.igst, A.cgst_amount = B.cgst_amount, 
                                A.sgst_amount = B.sgst_amount, A.igst_amount = B.igst_amount,A.round_off_amount=B.round_off_amount,A.freezed=B.freezed ,
                                A.sales_type=B.sales_type,
                                A.invoice_nos=B.invoice_nos,A.modified_approved_date='$modified_approved_date'
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    }
                    else
                    {
                        $sql = "Update distributor_in A, distributor_in B 
                            Set A.date_of_processing=B.date_of_processing, A.depot_id=B.depot_id, A.distributor_id=B.distributor_id,
                                A.sales_rep_id=B.sales_rep_id, A.amount=B.amount, A.tax=B.tax, A.cst=B.cst, 
                                A.tax_amount=B.tax_amount, A.final_amount=B.final_amount, A.due_date=B.due_date, 
                                A.is_expired=B.is_expired, A.final_cost_amount=B.final_cost_amount, 
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now', A.sales_return_no = '$sales_return_no', 
                                A.cgst = B.cgst, A.sgst = B.sgst, A.igst = B.igst, A.cgst_amount = B.cgst_amount, 
                                A.sgst_amount = B.sgst_amount, A.igst_amount = B.igst_amount,A.round_off_amount=B.round_off_amount,A.freezed=B.freezed,
                                A.sales_type=B.sales_type,A.invoice_nos=B.invoice_nos,A.modified_approved_date=NULL
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    }

                    
                    $this->db->query($sql);

                    $sql = "Delete from distributor_in where id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from distributor_in_items WHERE distributor_in_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update distributor_in_items set distributor_in_id='$ref_id' WHERE distributor_in_id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from distributor_out_exchange_items WHERE distributor_in_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update distributor_out_exchange_items set distributor_in_id='$ref_id' WHERE distributor_in_id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from distributor_out_items WHERE distributor_out_id in (select distinct id from 
                                distributor_out where distributor_in_id = '$ref_id')";
                    $this->db->query($sql);

                    $sql = "Delete from distributor_out WHERE distributor_in_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update distributor_out set distributor_in_id='$ref_id', status = '$status', 
                                    remarks='$remarks', approved_by='$curusr', approved_on='$now' 
                            WHERE distributor_in_id = '$id'";
                    $this->db->query($sql);

                    $sql = "Update distributor_out set voucher_no = '$voucher_no' WHERE distributor_in_id = '$ref_id' and distributor_id = '189'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {
                    $sql = "Update distributor_in A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now', 
                                A.sales_return_no = '$sales_return_no' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);

                    $sql = "Update distributor_out set status = '$status', 
                                    remarks='$remarks', approved_by='$curusr', approved_on='$now' 
                            WHERE distributor_in_id = '$id'";
                    $this->db->query($sql);

                    $sql = "Update distributor_out set voucher_no = '$voucher_no' WHERE distributor_in_id = '$id' and distributor_id = '189'";
                    $this->db->query($sql);
                }

                $this->set_ledger($id);
                
                $sql = "select * from distributor_out where distributor_in_id = '$id' and distributor_id != '189'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $distributor_out_id = $result[0]->id;
                    $this->set_ledger_sales($distributor_out_id);
                }
                echo '<script>var win = window.open("'.base_url().'index.php/distributor_in/view_sales_return_receipt/'.$id.'");
                win.print();</script>';
                $action='Distributor In Entry '.$status.'.';
				
            }
        }
        
    } else {
        if($this->input->post('btn_delete')!=null){
            if($this->input->post('status')=="Approved"){
                $status = 'Deleted';
            } else {
                $status = 'InActive';
            }
        } else {
            $status = 'Pending';
        }

        if($this->input->post('status')=="Approved"){
            $ref_id = $id;
            $id = '';
        } else {
            $ref_id = $this->input->post('ref_id');
        }

        if($ref_id==""){
            $ref_id = null;
        }

        $data = array(
                    'date_of_processing' => $date_of_processing,
                    'depot_id' => $this->input->post('depot_id'),
                    'distributor_id' => $this->input->post('distributor_id'),
                    'sales_rep_id' => $this->input->post('sales_rep_id'),
                    'amount' => format_number($this->input->post('total_amount'),2),
                    'tax' => $this->input->post('tax'),
                    'cst' => format_number($this->input->post('tax_per'),2),
                    'tax_amount' => format_number($this->input->post('tax_amount'),2),
                    'final_amount' => format_number($this->input->post('final_amount'),2),
                    'final_cost_amount' => format_number($this->input->post('cost_final_amount'),2),
                    'due_date' => $due_date,
                    'status' => $status,
                    'remarks' => $this->input->post('remarks'),
                    'modified_by' => $curusr,
                    'modified_on' => $now,
                    'is_expired' => $checked_status,
                    'is_exchanged' => $exchanged_status,
                    'ref_id' => $ref_id,
                    'sales_return_no' => $this->input->post('sales_return_no'),
                    'cgst' => format_number($this->input->post('cgst'),2),
                    'sgst' => format_number($this->input->post('sgst'),2),
                    'igst' => format_number($this->input->post('igst'),2),
                    'cgst_amount' => format_number($this->input->post('cgst_amount'),2),
                    'sgst_amount' => format_number($this->input->post('sgst_amount'),2),
                    'igst_amount' => format_number($this->input->post('igst_amount'),2),
                    'round_off_amount' => format_number($this->input->post('round_off_amount'),2),
                    'sales_type'=>$this->input->post('sales_type'),
                    'invoice_nos'=>$this->input->post('invoice_no')
                );

        $date_p=strtotime($date_of_processing);
        $current_d=strtotime($now);

        if($ref_id!=null && $ref_id!="")
        {
            $data['modified_approved_date']=$now;
        }

        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            $this->db->insert('distributor_in',$data);
            $id=$this->db->insert_id();
            $action='Distributor In Entry Created.';
        } else {
            $this->db->where('id', $id);
            $this->db->update('distributor_in',$data);
            $action='Distributor In Entry Modified.';
        }

        $this->db->where('distributor_in_id', $id);
        $this->db->delete('distributor_in_items');

        $type=$this->input->post('type[]');
        $bar=$this->input->post('bar[]');
        $box=$this->input->post('box[]');
        $qty=$this->input->post('qty[]');
        $sell_rate=$this->input->post('sell_rate[]');
        $sell_margin=$this->input->post('sell_margin[]');
        $tax_per=$this->input->post('tax_per[]');
        $grams=$this->input->post('grams[]');
        $rate=$this->input->post('rate[]');
        $amount=$this->input->post('amount[]');
        $cost_rate=$this->input->post('cost_rate[]');
        $cost_total_amt=$this->input->post('cost_total_amt[]');
        $cgst_amt=$this->input->post('cgst_amt[]');
        $sgst_amt=$this->input->post('sgst_amt[]');
        $igst_amt=$this->input->post('igst_amt[]');
        $tax_amt=$this->input->post('tax_amt[]');
        $total_amt=$this->input->post('total_amt[]');
        $batch_no=$this->input->post('batch_no[]');

        for ($k=0; $k<count($type); $k++) {
            if(isset($type[$k]) and $type[$k]!="") {
                if($type[$k]=="Bar"){
                    $item_id=$bar[$k];
                } else {
                    $item_id=$box[$k];
                }
                $data = array(
                            'distributor_in_id' => $id,
                            'type' => $type[$k],
                            'item_id' => $item_id,
                            'qty' => format_number($qty[$k],2),
                            'sell_rate' => format_number($sell_rate[$k],2),
                            'grams' => format_number($grams[$k],2),
                            'rate' => format_number($rate[$k],2),
                            'amount' => format_number($amount[$k],2),
                            'cost_rate' => format_number($cost_rate[$k],2),
                            'cost_amount' => format_number($cost_total_amt[$k],2),
                            'cgst_amt' => format_number($cgst_amt[$k],2),
                            'sgst_amt' => format_number($sgst_amt[$k],2),
                            'igst_amt' => format_number($igst_amt[$k],2),
                            'tax_amt' => format_number($tax_amt[$k],2),
                            'total_amt' => format_number($total_amt[$k],2),
                            'batch_no' => $batch_no[$k],
                            'margin_per' => $sell_margin[$k],
                            'tax_percentage' => $tax_per[$k]
                        );
                $this->db->insert('distributor_in_items', $data);
            }
        }


        if($checked=="1") {
            $data = array(
                        'date_of_processing' => $date_of_processing,
                        'depot_id' => $this->input->post('depot_id'),
                        'distributor_id' => '189',
                        'sample_distributor_id' => $this->input->post('distributor_id'),
                        'sales_rep_id' => $this->input->post('sales_rep_id'),
                        'amount' => format_number($this->input->post('cost_final_amount'),2),
                        'tax' => '0',
                        'tax_per' => '0',
                        'tax_amount' => '0',
                        'final_amount' => format_number($this->input->post('cost_final_amount'),2),
                        'status' => $status,
                        'delivery_status' => 'Delivered',
                        'remarks' => $this->input->post('remarks'),
                        'modified_by' => $curusr,
                        'modified_on' => $now,
                        'distributor_in_id' => $id,
                        'distributor_in_type' => 'expired'
                    );
            
            $sql = "select * from distributor_out where distributor_in_id = '$id' and distributor_in_type = 'expired'";
            $query=$this->db->query($sql);
            $result = $query->result();

            if(count($result)>0){
                $distributor_out_id = $result[0]->id;

                $this->db->where('id', $distributor_out_id);
                $this->db->update('distributor_out',$data);
            } else {
                $this->db->insert('distributor_out',$data);
                $distributor_out_id=$this->db->insert_id();
            }
            
            $this->db->where('distributor_out_id', $distributor_out_id);
            $this->db->delete('distributor_out_items');

            $type=$this->input->post('type[]');
            $bar=$this->input->post('bar[]');
            $box=$this->input->post('box[]');
            $qty=$this->input->post('qty[]');
            $cost_rate=$this->input->post('cost_rate[]');
            $grams=$this->input->post('grams[]');
            $rate=$this->input->post('rate[]');
            $amount=$this->input->post('cost_total_amt[]');

            for ($k=0; $k<count($type); $k++) {
                if(isset($type[$k]) and $type[$k]!="") {
                    if($type[$k]=="Bar"){
                        $item_id=$bar[$k];
                    } else {
                        $item_id=$box[$k];
                    }
                    $data = array(
                                'distributor_out_id' => $distributor_out_id,
                                'type' => $type[$k],
                                'item_id' => $item_id,
                                'qty' => format_number($qty[$k],2),
                                'sell_rate' => format_number($cost_rate[$k],2),
                                'grams' => format_number($grams[$k],2),
                                'rate' => format_number($cost_rate[$k],2),
                                'amount' => format_number($amount[$k],2)
                            );
                    $this->db->insert('distributor_out_items', $data);
                }
            }

        }


        if($exchanged=="1") {
            // $data = array(
            //             'date_of_processing' => $date_of_processing,
            //             'depot_id' => $this->input->post('depot_id'),
            //             'distributor_id' => $this->input->post('distributor_id'),
            //             'sales_rep_id' => $this->input->post('sales_rep_id'),
            //             'amount' => format_number($this->input->post('total_amount'),2),
            //             'tax' => $this->input->post('tax'),
            //             'cst' => format_number($this->input->post('tax_per'),2),
            //             'tax_amount' => format_number($this->input->post('tax_amount_ex'),2),
            //             'final_amount' => format_number($this->input->post('final_amount_ex'),2),
            //             'final_cost_amount' => format_number($this->input->post('cost_final_amount_ex'),2),
            //             'due_date' => $due_date,
            //             'status' => $this->input->post('status'),
            //             'remarks' => $this->input->post('remarks'),
            //             'modified_by' => $curusr,
            //             'modified_on' => $now
            //         );

            // if($id==''){
            //     $data['created_by']=$curusr;
            //     $data['created_on']=$now;

            //     $this->db->insert('distributor_out_exchange',$data);
            //     $id=$this->db->insert_id();
            //     $action='Distributor In Entry Created.';
            // } else {
            //     $this->db->where('dist_in_id', $id);
            //     $this->db->update('distributor_out_exchange',$data);
            //     // $action='Distributor Out Exc Entry Modified.';
            // }

            $this->db->where('distributor_in_id', $id);
            $this->db->delete('distributor_out_exchange_items');

            $type=$this->input->post('type_ex[]');
            $bar=$this->input->post('bar_ex[]');
            $box=$this->input->post('box_ex[]');
            $qty=$this->input->post('qty_ex[]');
            $sell_rate=$this->input->post('sell_rate_ex[]');
            $sell_margin=$this->input->post('sell_margin_ex[]');
            $tax_per=$this->input->post('tax_per_ex[]');
            $grams=$this->input->post('grams_ex[]');
            $rate=$this->input->post('rate_ex[]');
            $amount=$this->input->post('amount_ex[]');
            $cost_rate=$this->input->post('cost_rate_ex[]');
            $cost_total_amt=$this->input->post('cost_total_amt_ex[]');
            $cgst_amt_ex=$this->input->post('cgst_amt_ex[]');
            $sgst_amt_ex=$this->input->post('sgst_amt_ex[]');
            $igst_amt_ex=$this->input->post('igst_amt_ex[]');
            $tax_amt_ex=$this->input->post('tax_amt_ex[]');
            $batch_no_ex=$this->input->post('batch_no_ex[]');
            
            for ($k=0; $k<count($type); $k++) {
                if(isset($type[$k]) and $type[$k]!="") {
                    if($type[$k]=="Bar"){
                        $item_id=$bar[$k];
                    } else {
                        $item_id=$box[$k];
                    }
                    $data = array(
                                'distributor_in_id' => $id,
                                'type' => $type[$k],
                                'item_id' => $item_id,
                                'qty' => format_number($qty[$k],2),
                                'sell_rate' => format_number($sell_rate[$k],2),
                                'grams' => format_number($grams[$k],2),
                                'rate' => format_number($rate[$k],2),
                                'amount' => format_number($amount[$k],2),
                                'cost_rate' => format_number($cost_rate[$k],2),
                                'cost_amount' => format_number($cost_total_amt[$k],2),
                                'cgst_amount' => format_number($cgst_amt_ex[$k],2),
                                'sgst_amount' => format_number($sgst_amt_ex[$k],2),
                                'igst_amount' => format_number($igst_amt_ex[$k],2),
                                'tax_amount' => format_number($tax_amt_ex[$k],2),
                                'margin_per' => $sell_margin[$k],
                                'tax_percentage' => $tax_per[$k],
                                'batch_no_ex' => $batch_no_ex[$k]
                            );
                    $this->db->insert('distributor_out_exchange_items', $data);
                    /*echo $this->db->last_query().'<br>';*/
                }
            }

            $data = array(
                        'date_of_processing' => $date_of_processing,
                        'depot_id' => $this->input->post('depot_id'),
                        'distributor_id' => $this->input->post('distributor_id'),
                        'sales_rep_id' => $this->input->post('sales_rep_id'),
                        'amount' => format_number($this->input->post('total_amount_ex'),2),
                        'tax' => $this->input->post('tax'),
                        'tax_per' => format_number($this->input->post('tax_per'),2),
                        'tax_amount' => format_number($this->input->post('tax_amount_ex'),2),
                        'final_amount' => format_number($this->input->post('final_amount_ex'),2),
                        'status' => $status,
                        'delivery_status' => 'Pending',
                        'remarks' => $this->input->post('remarks'),
                        'modified_by' => $curusr,
                        'modified_on' => $now,
                        'distributor_in_id' => $id,
                        'distributor_in_type' => 'exchanged',
                        'cgst' => format_number($this->input->post('cgst'),2),
                        'sgst' => format_number($this->input->post('sgst'),2),
                        'igst' => format_number($this->input->post('igst'),2),
                        'cgst_amount' => format_number($this->input->post('cgst_amount'),2),
                        'sgst_amount' => format_number($this->input->post('sgst_amount'),2),
                        'igst_amount' => format_number($this->input->post('igst_amount'),2)
                    );
            
            $sql = "select * from distributor_out where distributor_in_id = '$id' and distributor_in_type = 'exchanged'";
            $query=$this->db->query($sql);
            $result = $query->result();

            if(count($result)>0){
                $distributor_out_id = $result[0]->id;

                $this->db->where('id', $distributor_out_id);
                $this->db->update('distributor_out',$data);
            } else {
                $this->db->insert('distributor_out',$data);
                $distributor_out_id=$this->db->insert_id();
            }

            $this->db->where('distributor_out_id', $distributor_out_id);
            $this->db->delete('distributor_out_items');

            $type=$this->input->post('type_ex[]');
            $bar=$this->input->post('bar_ex[]');
            $box=$this->input->post('box_ex[]');
            $qty=$this->input->post('qty_ex[]');
            $cost_rate=$this->input->post('cost_rate_ex[]');
            $sell_rate=$this->input->post('sell_rate_ex[]');
            $grams=$this->input->post('grams_ex[]');
            $rate=$this->input->post('rate_ex[]');
            $amount=$this->input->post('cost_total_amt_ex[]');
            $cgst_amt=$this->input->post('cgst_amt_ex[]');
            $sgst_amt=$this->input->post('sgst_amt_ex[]');
            $igst_amt=$this->input->post('igst_amt_ex[]');
            $tax_amt=$this->input->post('tax_amt_ex[]');
            $total_amt=$this->input->post('total_amt_ex[]');

            for ($k=0; $k<count($type); $k++) {
                if(isset($type[$k]) and $type[$k]!="") {
                    if($type[$k]=="Bar"){
                        $item_id=$bar[$k];
                    } else {
                        $item_id=$box[$k];
                    }
                    $data = array(
                                'distributor_out_id' => $distributor_out_id,
                                'type' => $type[$k],
                                'item_id' => $item_id,
                                'qty' => format_number($qty[$k],2),
                                'sell_rate' => format_number($sell_rate[$k],2),
                                'grams' => format_number($grams[$k],2),
                                'rate' => format_number($rate[$k],2),
                                'amount' => format_number($amount[$k],2),
                                'cgst_amt' => format_number($cgst_amt[$k],2),
                                'sgst_amt' => format_number($sgst_amt[$k],2),
                                'igst_amt' => format_number($igst_amt[$k],2),
                                'tax_amt' => format_number($tax_amt[$k],2),
                                'total_amt' => format_number($total_amt[$k],2)
                            );
                    $this->db->insert('distributor_out_items', $data);
                }
            }
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Distributor_In';
    $logarray['cnt_name']='Distributor_In';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function set_ledger($id) {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $sql = "select A.*, B.id as acc_id, B.ledger_name from distributor_in A left join account_ledger_master B 
                on (A.distributor_id = B.ref_id and B.ref_type = 'Distributor') 
            where A.id = '$id' and B.status = 'Approved'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $data = array(
                    'ref_id' => $id,
                    'ref_type' => 'Distributor_Sales_Return',
                    'entry_type' => 'Total Amount',
                    'invoice_no' => null,
                    'vendor_id' => $result[0]->distributor_id,
                    'acc_id' => $result[0]->acc_id,
                    'ledger_name' => $result[0]->ledger_name,
                    'type' => 'Credit',
                    'amount' => $result[0]->final_amount,
                    'status' => $result[0]->status,
                    'is_active' => '1',
                    'ledger_type' => 'Main Entry',
                    'narration' => $result[0]->remarks,
                    'ref_date' => $result[0]->date_of_processing,
                    'modified_by' => $curusr,
                    'modified_on' => $now
                );

        $ledger_array[0] = $data;
        $ledger_array[1] = $data;
        $ledger_array[2] = $data;

        // echo json_encode($ledger_array);
        // echo '<br/>';

        $ledger_array[1]['entry_type'] = 'Taxable Amount';
        $ledger_array[1]['acc_id'] = '1';
        $ledger_array[1]['ledger_name'] = 'Sales';
        $ledger_array[1]['type'] = 'Debit';
        $ledger_array[1]['amount'] = $result[0]->amount;
        $ledger_array[1]['ledger_type'] = 'Sub Entry';

        $ledger_array[2]['entry_type'] = 'Tax';
        $ledger_array[2]['acc_id'] = '2';
        $ledger_array[2]['ledger_name'] = 'GST';
        $ledger_array[2]['type'] = 'Debit';
        $ledger_array[2]['amount'] = $result[0]->tax_amount;
        $ledger_array[2]['ledger_type'] = 'Sub Entry';

        // echo json_encode($ledger_array);
        // echo '<br/>';


        $sql = "select * from account_ledger_entries where ref_id = '$id' and 
                ref_type = 'Distributor_Sales_Return'";
        $query=$this->db->query($sql);
        $data =  $query->result();
        if (count($data)>0){
            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales_Return');
            $this->db->where('entry_type', 'Total Amount');
            $this->db->update('account_ledger_entries', $ledger_array[0]);

            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales_Return');
            $this->db->where('entry_type', 'Taxable Amount');
            $this->db->update('account_ledger_entries', $ledger_array[1]);

            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales_Return');
            $this->db->where('entry_type', 'Tax');
            $this->db->update('account_ledger_entries', $ledger_array[2]);
        } else {
            $series = 1;
            $sql = "select * from series_master where type = 'Account_Voucher'";
            $query=$this->db->query($sql);
            $data =  $query->result();
            if (count($data)>0){
                $series = intval($data[0]->series) + 1;

                $sql = "update series_master set series = '$series' where type = 'Account_Voucher'";
                $this->db->query($sql);
            } else {
                $series = 1;

                $sql = "insert into series_master (type, series) values ('Account_Voucher', '".$series."')";
                $this->db->query($sql);
            }

            $voucher_id = $series;

            $ledger_array[0]['voucher_id'] = $voucher_id;
            $ledger_array[0]['created_by']=$curusr;
            $ledger_array[0]['created_on']=$now;

            $ledger_array[1]['voucher_id'] = $voucher_id;
            $ledger_array[1]['created_by']=$curusr;
            $ledger_array[1]['created_on']=$now;

            $ledger_array[2]['voucher_id'] = $voucher_id;
            $ledger_array[2]['created_by']=$curusr;
            $ledger_array[2]['created_on']=$now;

            $this->db->insert('account_ledger_entries', $ledger_array[0]);
            $this->db->insert('account_ledger_entries', $ledger_array[1]);
            $this->db->insert('account_ledger_entries', $ledger_array[2]);
        }

        // echo json_encode($ledger_array);
    }
}

function set_ledger_sales($id) {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $sql = "select A.*, B.id as acc_id, B.ledger_name from distributor_out A left join account_ledger_master B 
                on (A.distributor_id = B.ref_id and B.ref_type = 'Distributor') 
            where A.id = '$id' and B.status = 'Approved'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        if(isset($result[0]->invoice_date) && $result[0]->invoice_date!=''){
            $ref_date = $result[0]->invoice_date;
        } else {
            $ref_date = $result[0]->date_of_processing;
        }
        
        $data = array(
                    'ref_id' => $id,
                    'ref_type' => 'Distributor_Sales',
                    'entry_type' => 'Total Amount',
                    'invoice_no' => $result[0]->invoice_no,
                    'vendor_id' => $result[0]->distributor_id,
                    'acc_id' => $result[0]->acc_id,
                    'ledger_name' => $result[0]->ledger_name,
                    'type' => 'Debit',
                    'amount' => $result[0]->final_amount,
                    'status' => $result[0]->status,
                    'is_active' => '1',
                    'ledger_type' => 'Main Entry',
                    'narration' => $result[0]->remarks,
                    'ref_date' => $ref_date,
                    'modified_by' => $curusr,
                    'modified_on' => $now
                );

        $ledger_array[0] = $data;
        $ledger_array[1] = $data;
        $ledger_array[2] = $data;

        // echo json_encode($ledger_array);
        // echo '<br/>';

        $ledger_array[1]['entry_type'] = 'Taxable Amount';
        $ledger_array[1]['acc_id'] = '1';
        $ledger_array[1]['ledger_name'] = 'Sales';
        $ledger_array[1]['type'] = 'Credit';
        $ledger_array[1]['amount'] = $result[0]->amount;
        $ledger_array[1]['ledger_type'] = 'Sub Entry';

        $ledger_array[2]['entry_type'] = 'Tax';
        $ledger_array[2]['acc_id'] = '2';
        $ledger_array[2]['ledger_name'] = 'GST';
        $ledger_array[2]['type'] = 'Credit';
        $ledger_array[2]['amount'] = $result[0]->tax_amount;
        $ledger_array[2]['ledger_type'] = 'Sub Entry';

        // echo json_encode($ledger_array);
        // echo '<br/>';


        $sql = "select * from account_ledger_entries where ref_id = '$id' and 
                ref_type = 'Distributor_Sales'";
        $query=$this->db->query($sql);
        $data =  $query->result();
        if (count($data)>0){
            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales');
            $this->db->where('entry_type', 'Total Amount');
            $this->db->update('account_ledger_entries', $ledger_array[0]);

            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales');
            $this->db->where('entry_type', 'Taxable Amount');
            $this->db->update('account_ledger_entries', $ledger_array[1]);

            $this->db->where('ref_id', $id);
            $this->db->where('ref_type', 'Distributor_Sales');
            $this->db->where('entry_type', 'Tax');
            $this->db->update('account_ledger_entries', $ledger_array[2]);
        } else {
            $series = 1;
            $sql = "select * from series_master where type = 'Account_Voucher'";
            $query=$this->db->query($sql);
            $data =  $query->result();
            if (count($data)>0){
                $series = intval($data[0]->series) + 1;

                $sql = "update series_master set series = '$series' where type = 'Account_Voucher'";
                $this->db->query($sql);
            } else {
                $series = 1;

                $sql = "insert into series_master (type, series) values ('Account_Voucher', '".$series."')";
                $this->db->query($sql);
            }

            $voucher_id = $series;

            $ledger_array[0]['voucher_id'] = $voucher_id;
            $ledger_array[0]['created_by']=$curusr;
            $ledger_array[0]['created_on']=$now;

            $ledger_array[1]['voucher_id'] = $voucher_id;
            $ledger_array[1]['created_by']=$curusr;
            $ledger_array[1]['created_on']=$now;

            $ledger_array[2]['voucher_id'] = $voucher_id;
            $ledger_array[2]['created_by']=$curusr;
            $ledger_array[2]['created_on']=$now;

            $this->db->insert('account_ledger_entries', $ledger_array[0]);
            $this->db->insert('account_ledger_entries', $ledger_array[1]);
            $this->db->insert('account_ledger_entries', $ledger_array[2]);
        }

        // echo json_encode($ledger_array);
    }
}

function check_product_availablity(){
    $id=$this->input->post('id');
    $depot_id=$this->input->post('depot_id');
    $batch_id=$this->input->post('batch_id');
    $product_id=$this->input->post('product_id');

    // $id=1;
    // $depot_id=1;
    // $batch_id=1;
    // $product_id=1;

    $sql="select id from batch_processing 
        where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' and id='$batch_id' 
        union all 
        select id from transfer where status = 'Approved' and item = 'Product' and 
        depot_in_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id' 
        union all 
        select id from distributor_in where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id' and id!='$id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)==0){
        return 1;
    } else {
        return 0;
    }
}

function check_product_qty_availablity(){
    $id=$this->input->post('id');
    $depot_id=$this->input->post('depot_id');
    $batch_id=$this->input->post('batch_id');
    $product_id=$this->input->post('product_id');
    $product_type=$this->input->post('product_type');
    $qty=floatval(format_number($this->input->post('qty')));

    // $id=2;
    // $depot_id=1;
    // $batch_id=1;
    // $product_id=1;
    // $product_type="Box";
    // $qty=100;

    if($product_type=="Bar"){
        $col_name="qty_in_bar";
        $num_of_bars_per_box=6;

        // $sql2=" union all 
        //     select sum(qty_in_box)*".$num_of_bars_per_box." as tot_qty_in_kg from distributor_in 
        //     where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id'";

        // $sql3=" union all 
        //     select sum(qty_in_box)*".$num_of_bars_per_box." as tot_qty_out from distributor_out 
        //     where status = 'Approved' and depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id' and id!='$id'";
        
        $sql2="";
        $sql3="";
    } else {
        $col_name="qty_in_box";
        $sql2="";
        $sql3="";
    }

    $sql="select sum(A.tot_qty_in_kg) as tot_qty_in_kg from 
        (select sum(".$col_name.") as tot_qty_in_kg from batch_processing 
        where status = 'Approved' and product_id = '$product_id' and depot_id = '$depot_id' and id='$batch_id' 
        union all 
        select sum(qty) as tot_qty_in_kg from transfer where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and depot_in_id = '$depot_id' and batch_id = '$batch_id' and 
        product_type = '$product_type' 
        union all 
        select sum(".$col_name.") as tot_qty_in_kg from distributor_in where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id'".$sql2.") A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_in_kg=floatval($result[0]->tot_qty_in_kg);
    } else {
        $tot_qty_in_kg=0;
    }
    // echo $this->db->last_query().'<br>';
    // echo $tot_qty_in_kg.'<br>';

    $sql="select sum(A.tot_qty_out) as tot_qty_out from 
        (select sum(qty) as tot_qty_out from transfer where status = 'Approved' and item = 'Product' and 
        product_id = '$product_id' and depot_out_id = '$depot_id' and batch_id = '$batch_id' and 
        product_type = '$product_type' 
        union all 
        select sum(".$col_name.") as tot_qty_out from distributor_out where status = 'Approved' and 
        depot_id = '$depot_id' and product_id = '$product_id' and batch_id = '$batch_id' and id!='$id'".$sql3.") A";
    $query=$this->db->query($sql);
    $result=$query->result();
    if (count($result)>0){
        $tot_qty_out=floatval($result[0]->tot_qty_out);
    } else {
        $tot_qty_out=0;
    }
    // echo $this->db->last_query().'<br>';
    // echo $tot_qty_out.'<br>';

    if (($tot_qty_in_kg-$tot_qty_out-$qty)<0){
        return 1;
    } else {
        return 0;
    }
}

function get_distributor_in_items_for_receipt($id){
    $sql = "select D.*, E.batch_no from 
            (select C.*, case when C.type='Box' then C.box_name else C.product_name end as description, 
                    case when C.type='Box' then C.box_hsn_code else C.product_hsn_code end as hsn_code from 
            (select C.*, B.box_name, B.hsn_code as box_hsn_code from 
            (select A.*, B.product_name, B.hsn_code as product_hsn_code from 
            (select type, qty, sell_rate, grams, rate, amount, cost_rate, cost_amount, cgst_amt, sgst_amt, igst_amt, total_amt, batch_no, 
                case when type='Box' then item_id else null end as box_id, 
                case when type='Bar' then item_id else null end as bar_id from distributor_in_items 
                where distributor_in_id = '$id') A 
            left join 
            (select * from product_master) B 
            on (A.bar_id=B.id)) C 
            left join 
            (select * from box_master) B 
            on (C.box_id=B.id)) C) D 
            left join 
            (select * from batch_master) E 
            on (D.batch_no=E.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_out_items_for_exchange($id){
    $sql = "select C.*, case when C.type='Box' then C.box_name else C.product_name end as description, 
                    case when C.type='Box' then C.box_hsn_code else C.product_hsn_code end as hsn_code from 
            (select C.*, B.box_name, B.hsn_code as box_hsn_code from 
            (select A.*, B.product_name, B.hsn_code as product_hsn_code from 
            (select type, qty, sell_rate, grams, rate, amount, cost_rate, cost_amount, cgst_amount, sgst_amount, igst_amount, tax_amount, 
                case when type='Box' then item_id else null end as box_id, 
                case when type='Bar' then item_id else null end as bar_id from distributor_out_exchange_items 
                where distributor_in_id = '$id') A 
            left join 
            (select * from product_master) B 
            on (A.bar_id=B.id)) C 
            left join 
            (select * from box_master) B 
            on (C.box_id=B.id)) C";
    $query=$this->db->query($sql);
    return $query->result();
}


public function get_product_percentage($product_id,$distributor_id)
{
    $sql = "SELECT B.margin,A.category_id,A.tax_percentage from
            (Select category_id,tax_percentage from product_master Where id=$product_id ) A
            Left JOIN
            (SELECT * from distributor_category_margin ) B
            on A.category_id=B.category_id
            Where B.distributor_id=$distributor_id";
    $result = $this->db->query($sql)->result();

    return $result;

}


public function get_box_percentage($product_id,$distributor_id)
{
    $sql = "SELECT B.margin,A.category_id,A.tax_percentage from
            (Select category_id,tax_percentage from box_master Where id=$product_id ) A
            Left JOIN
            (SELECT * from distributor_category_margin ) B
            on A.category_id=B.category_id
            Where B.distributor_id=$distributor_id";
    $result = $this->db->query($sql)->result();

    return $result;

}
}
?>