<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Raw_material_in_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Raw_Material_In' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}


function get_pending_data($id=''){
    $query=$this->db->query("SELECT * FROM batch_processing WHERE ref_id = '$id' and status!='InActive'");
    $result=$query->result();
    if (count($result)>0){
        $id = $result[0]->id;
    }

    return $id;
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
    //,(select other_charges_amount from purchase_order Where id='purchase_order_id') as other_charges_amount
    $sql = "select C.*, D.depot_name from 
            (select A.*, B.vendor_name from 
            (Select A.* ,B.other_charges_amount,B.po_status,B.po_no,B.approved_on as raw_approved  from
                (select * from raw_material_in ".$cond.") A
            left join 
            (Select other_charges_amount,po_status,id,po_no,approved_on from  purchase_order) B 
            on B.id=A.purchase_order_id
            ) A 
            left join 
            (select * from vendor_master) B 
            on (A.vendor_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id) order by C.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_raw_material_stock($id){
    $sql = "select A.*, B.rm_name from 
            (select * from raw_material_stock where raw_material_in_id = '$id') A 
            left join 
            (select * from raw_material_master) B 
            on (A.raw_material_id=B.id)";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_receipt=$this->input->post('date_of_receipt');
    if($date_of_receipt==''){
        $date_of_receipt=NULL;
    }
    else{
        $date_of_receipt=formatdate($date_of_receipt);
    }

    $ref_no = $this->input->post('row_material_in_no');

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

        $remarks = $this->input->post('remarks');



        if($status == 'Rejected'){
            $sql = "Update raw_material_in Set status='$status', approved_by='$curusr', approved_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Raw Material IN Entry '.$status.'.';
        } else {
            if($id!='' || $ref_id!=''){
                if($ref_no==null || $ref_no=='')
                    {
                        echo "ref_no".$ref_no;

                        $sql="select * from series_master where type='Raw_Material_In'";
                        $query=$this->db->query($sql);
                        $result=$query->result();
                        if(count($result)>0)
                        {
                            $series=intval($result[0]->series)+1;
                            $sql="update series_master set series = '$series' where type = 'Raw_Material_In'";
                            $this->db->query($sql);
                            $ref_no = 'WHPL/RMI/'.strval($series);
                        }
                        else
                        {
                            $series=1;
                            $sql="insert into series_master (type, series) values ('Raw_Material_In', '$series')";
                            $this->db->query($sql);
                            $ref_no = 'WHPL/RMI/'.strval($series);
                        } 
                    }

                if($ref_id!=null && $ref_id!=''){  

                    $res1 = $this->db->select('purchase_order_id')->where('id',$ref_id)->get('raw_material_in')->result();
                    if(count($res1)>0)
                    {
                        echo 'purchase_order_id'.$purchase_order_id = $res1[0]->purchase_order_id;
                        $res = $this->db->select('po_status')->where('id',$purchase_order_id)->get('purchase_order')->result();

                        if(count($res)>0)
                        {
                            $po_status = $res[0]->po_status;

                            if($po_status=='Advance')
                            {
                                $sql = "Update purchase_order SET po_status='Closed' Where id='$purchase_order_id' ";
                                $this->db->query($sql);
                            }
                            else
                            {
                                $sql = "Update purchase_order SET po_status='Raw Material In' Where id='$purchase_order_id' ";
                                $this->db->query($sql);
                            }
                        }
                        else
                        {
                            $sql = "Update purchase_order SET po_status='Raw Material In' Where id='$purchase_order_id' ";
                            $this->db->query($sql);
                        }
                    }

                    $sql = "Update raw_material_in A, raw_material_in B 
                            Set A.date_of_receipt=B.date_of_receipt, A.purchase_order_id=B.purchase_order_id, A.vendor_id=B.vendor_id,
                                A.depot_id=B.depot_id,
                                A.vat=B.vat,
                                A.cst=B.cst,
                                A.excise=B.excise,
                                A.final_amount=B.final_amount,
                                A.amt=B.amt,
                                A.gate_pass_no=B.gate_pass_no,
                                A.row_material_in_no='$ref_no',
                                A.cgst_amt=B.cgst_amt,
                                A.sgst_amt=B.sgst_amt,
                                A.igst_amt=B.igst_amt,
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr',
                                A.approved_on='$now' 
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    $this->db->query($sql);
                                       

                    $sql = "Delete from raw_material_in where id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from raw_material_stock WHERE raw_material_in_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update raw_material_stock set raw_material_in_id='$ref_id' WHERE raw_material_in_id = '$id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {

                    $res1 = $this->db->select('purchase_order_id')->where('id',$id)->get('raw_material_in')->result();

                    if(count($res1)>0)
                    {
                        $purchase_order_id = $res1[0]->purchase_order_id;
                        $res = $this->db->select('po_status')->where('id',$purchase_order_id)->get('purchase_order')->result();

                        if(count($res)>0)
                        {
                            $po_status = $res[0]->po_status;

                            if($po_status=='Advance')
                            {
                                $sql = "Update purchase_order SET po_status='Closed' Where id='$purchase_order_id' ";
                                $this->db->query($sql);
                            }
                            else
                            {
                                $sql = "Update purchase_order SET po_status='Raw Material In' Where id='$purchase_order_id' ";
                                $this->db->query($sql);
                            }
                        }
                        else
                        {
                            $sql = "Update purchase_order SET po_status='Raw Material In' Where id='$purchase_order_id' ";
                            $this->db->query($sql);
                        }

                        echo $this->db->last_query();   
                    }

                    $sql = "Update raw_material_in A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' ,A.row_material_in_no='$ref_no'
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

                $action='Raw_Material_In '.$status.'.';

            }
        }
    }else {
        if($this->input->post('btn_delete')!=null){
            if($this->input->post('status')=="Approved"){
                $status = 'Deleted';
            } else {
                $status = 'InActive';
            }
        } else {
            $status = 'Pending';
        }

        $this->input->post('status');

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
            'date_of_receipt' => $date_of_receipt,
            'purchase_order_id' => $this->input->post('purchase_order_id'),
            'vendor_id' => $this->input->post('vendor_id'),
            'amt' =>format_number($this->input->post('total_amount'),2),
            'cgst_amt' =>format_number($this->input->post('cgst_amount'),2),
            'sgst_amt' =>format_number($this->input->post('sgst_amount'),2),
            'igst_amt' =>format_number($this->input->post('igst_amount'),2),
            'final_amount' => format_number($this->input->post('final_amount'),2),
            'depot_id' => $this->input->post('depot_id'),
            'status' => $this->input->post('status'),
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id,
            'status' => $status,
            'gate_pass_no'=>$this->input->post('gate_pass_no'),
            'row_material_in_no'=>$ref_no
        );

        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            $this->db->insert('raw_material_in',$data);
            $id=$this->db->insert_id();
            $action='Raw Material In Entry Created.';
        } else {
            $this->db->where('id', $id);
            $this->db->update('raw_material_in',$data);
            $action='Raw Material In Entry Modified.';
        }

        $this->db->where('raw_material_in_id', $id);
        $this->db->delete('raw_material_stock');

        $raw_material_id=$this->input->post('raw_material[]');
        $qty=$this->input->post('qty[]');
        $rate=$this->input->post('rate[]');
        $hsn_code=$this->input->post('hsn_code[]');
        $tax_per=$this->input->post('tax_per[]');
        $amount=$this->input->post('amount[]');
        $cgst_amt=$this->input->post('cgst_amt[]');
        $sgst_amt=$this->input->post('sgst_amt[]');
        $igst_amt=$this->input->post('igst_amt[]');
        $tax_amt=$this->input->post('tax_amt[]');
        $total_amt=$this->input->post('total_amt[]');
        $po_amount=$this->input->post('po_amount[]');
        $po_quantity=$this->input->post('po_qty[]');
        $po_rate=$this->input->post('po_rate[]');
        $po_cgst_amt=$this->input->post('po_cgst_amt[]');
        $po_sgst_amt=$this->input->post('po_sgst_amt[]');
        $po_igst_amt=$this->input->post('po_igst_amt[]');
        $po_tax_amt=$this->input->post('po_tax_amt[]');
        $po_total_amt=$this->input->post('po_total_amt[]');
        $other_charges_amount=$this->input->post('other_charges_amount');
        $po_other_charges_amount=$this->input->post('po_other_charges_amount');
        for ($k=0; $k<count($raw_material_id); $k++) {
            if(isset($raw_material_id[$k]) and $raw_material_id[$k]!="") {
                $data = array(
                            'raw_material_in_id' => $id,
                            'raw_material_id' => $raw_material_id[$k],
                            'qty' => format_number($qty[$k],2),
                            'rate' => format_number($rate[$k],2),
                            'hsn_code'=>$hsn_code[$k],
                            'tax_per' => format_number($tax_per[$k],2),
                            'amount' => format_number($amount[$k],2),
                            'cgst_amt' => format_number($cgst_amt[$k],2),
                            'sgst_amt' => format_number($sgst_amt[$k],2),
                            'igst_amt' => format_number($igst_amt[$k],2),
                            'tax_amt' => format_number($tax_amt[$k],2),
                            'total_amt' => format_number($total_amt[$k],2),
                            'po_quantity' => format_number($po_quantity[$k],2),
                            'po_rate' => format_number($po_rate[$k],2),
                            'po_amount' => format_number($po_amount[$k],2),
                            'po_cgst_amt' => format_number($po_cgst_amt[$k],2),
                            'po_sgst_amt' => format_number($po_sgst_amt[$k],2),
                            'po_igst_amt' => format_number($po_igst_amt[$k],2),
                            'po_tax_amt' => format_number($po_tax_amt[$k],2),
                            'po_total_amt' => format_number($po_total_amt[$k],2),
                            'other_charges_amt' => format_number($other_charges_amount,2),
                            'po_other_charges_amount'=>format_number($po_other_charges_amount,2),
                            //'final_amt' => format_number($final_amt[$k],2)
                        );
                $this->db->insert('raw_material_stock', $data);
            }
        }
    }


    $logarray['table_id']=$id;
    $logarray['module_name']='Raw_Material_In';
    $logarray['cnt_name']='Raw_Material_In';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

}
?>