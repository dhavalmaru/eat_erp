<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>EAT ERP</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
            <!-- CSS INCLUDE -->        
         <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->     
        
        <style>
             
            th{text-align:center;}
            .center{text-align:center;}
            input[readonly] {background-color: white !important; 
                            color: #0b385f !important; 
                            cursor: not-allowed !important;}
			#gst_in.form-control[disabled],#gst_in.form-control[readonly]
			{
				border:none!important;
				background-color:transparent!important;
				box-shadow:none!important;
				font-size: 18px!important;
			}
			.gst_in1
			{
					font-size: 14px!important;
			}

      #po_status.form-control[disabled],#po_status.form-control[readonly]
      {
        border:none!important;
        background-color:transparent!important;
        box-shadow:none!important;
        font-size: 18px!important;
      }
        </style>
    </head>
    <body>                              
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
               <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Payment_voucher'; ?>" > Payment Voucher  In List </a>  &nbsp; &#10095; &nbsp;Payment Voucher Details</div>
                   
                <!-- PAGE CONTENT WRAPPER -->
                    <div class="page-content-wrap">
                    <div class="row main-wrapper">
                        <div class="main-container">           
                         <div class="box-shadow">
                            
                            <form id="form_payment_voucher" role="form" class="form-horizontal" method="post" action="<?php echo base_url(). 'index.php/payment_voucher/save'; ?>">
                            <input type="hidden" name="id" value="<?php if(isset($data)){echo $data[0]->payment_voucher_id;}?>">
                            <input type="hidden" name="tdsamount" id="tdsamount" value="<?php if(isset($data)){echo $data[0]->tdsamount;}?>">
                            
                              <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
                                
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                          <label class="col-md-2 col-sm-2 col-xs-12 control-label">Purchase<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                
                                                 <input type="radio" name="type"  value="Purchase" class="type_purchase" id="type_purchase" data-error="#err_type" <?php if (isset($data[0]->type)) { if($data[0]->type=='Purchase'){  echo 'checked'; }else{
                                                      echo 'disabled ';
                                                    } } ?>/>&nbsp;&nbsp;Purchase&nbsp;&nbsp;&nbsp;

                                                 <!--<input type="radio" name="type"  value="Fixed Asset" id="type_purchase" data-error="#err_type"  <?php //if (isset($data[0]->type)) { if($data[0]->type=='Fixed Asset') echo 'checked'; } ?> />&nbsp;&nbsp;Fixed Asset&nbsp;&nbsp;&nbsp;-->

                                                  <input type="radio" name="type"  value="Expense" class="type_purchase" id="type_expense"  data-error="#err_type" <?php if (isset($data[0]->type)) { if($data[0]->type=='Expense'){ echo 'checked '; }else { echo 'disabled ';  } } ?>/>&nbsp;&nbsp;Expense&nbsp;&nbsp;&nbsp;
                                               <div id="err_type"></div>     
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" >
                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Requestor Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="user_name" id="user_name" value="<?php if(isset($data)){ echo $data[0]->user_name;} else { echo $this->session->userdata('login_name'); }?>" readonly/>
                                        </div>
                                       </div>
                                    </div>
                                    <div class="form-group" style="<?php if(isset($data)){ echo 'display: block';}else{ echo 'display: none';}?>">
                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="<?php if(isset($data)){ echo 'display: block';}else{ echo 'display: none';}?>">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Voucher No <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="voucher_no" id="voucher_no" value="<?php if(isset($data)){ echo $data[0]->voucher_no;}?>" readonly/>
                                            </div>
                                       </div>
                                      </div>
                                   </div>
                                   <div class="form-group vendor_selection" style="<?php if (isset($data[0]->type)) {
                                              if($data[0]->type=='Purchase')
                                                 { echo 'display: block';}
                                              else
                                                { 
                                                  echo 'display: none';
                                                 } 
                                              }else
                                              {
                                                echo 'display: none';
                                              } 
                                       ?>">
                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                       <label class="col-md-2 col-sm-2 col-xs-12 control-label">Vendor </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="vendor_id" id="vendor_id" class="form-control" > <option value="">Select</option>
                                                    <?php if(isset($vendor)) { for ($k=0; $k < count($vendor); $k++) { ?>
                                                            <option value="<?php echo $vendor[$k]->id; ?>" <?php if(isset($data)) { if($vendor[$k]->id==$data[0]->vendor_id) { echo 'selected'; } } ?>><?php echo $vendor[$k]->vendor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                        </div> 
                               
                                           <label class="col-md-6 col-sm-6 col-xs-12 control-label gst_in1">GSTIN<span class="asterisk_sign">*</span> : &nbsp;&nbsp;&nbsp;&nbsp;<span id="gst_in1"> <?php if(isset($data)){ echo $data[0]->gst_number;}?> </span></label>
                                       </div>
                                   </div>  
                                    <input  type="hidden" id="vendor_state" name="vendor_state" 
                                                 value="<?php if(isset($data)){
                                                    echo $data[0]->vendor_state;
                                                 }?>" />
                                                 <input type="hidden" id="depot_state" name="depot_state" value="<?php if(isset($data)){
                                                    echo $data[0]->default_state;
                                                 } else { echo 'Maharashtra'; }?>" />
                                   <div class="form-group expense_selection" style="<?php if (isset($data[0]->type)) {
                                              if($data[0]->type=='Expense')
                                                 { echo 'display: block';}
                                              else
                                                { 
                                                  echo 'display: none';
                                                 } 
                                              }else
                                              {
                                                echo 'display: none';
                                              } 
                                       ?>">
                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                       <label class="col-md-2 col-sm-2 col-xs-12 control-label">Vendor </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">

                                                <input type="text" class="form-control " name="vendor_name" id="vendor_name" value="<?php if(isset($data)){ echo $data[0]->vendor_name;}?>" aria-required="true" aria-invalid="true">
                                        </div> 
                                       </div>
                                   </div>

                                   <div class="form-group expense_selection" style="<?php if (isset($data[0]->type)) {
                                              if($data[0]->type=='Expense')
                                                 { echo 'display: block';}
                                              else
                                                { 
                                                  echo 'display: none';
                                                 } 
                                              }else
                                              {
                                                echo 'display: none';
                                              } 
                                       ?>">
                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                       <label class="col-md-2 col-sm-2 col-xs-12 control-label">GSTIN </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">

                                                <input type="text" class="form-control " name="gst_in" id="gst_in" value="<?php if(isset($data)){ echo $data[0]->gst_number;}?>" aria-required="true" aria-invalid="true">
                                        </div> 
                                       </div>
                                   </div>

                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Invoice Date<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                              <input type="text" class="form-control datepicker" name="invoice_date" id="invoice_date" value="<?php if(isset($data)){ echo date('d/m/Y',strtotime($data[0]->invoice_date));}?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Invoice No <span class="asterisk_sign">*</span></label>
                                            <div class="col-sm-4 col-xs-4" >
                                             <input type="text" class="form-control" name="invoice_no" id="invoice_no" value="<?php if(isset($data)){ echo $data[0]->invoice_no;}?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type of Use<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                              <input type="text" class="form-control" name="type_use" id="type_use" value="<?php if(isset($data)){ echo $data[0]->type_use;}?>"/>
                                            </div>
                                       </div>
                                    </div> -->
                                    <div class="form-group expense_selection" style="<?php if (isset($data[0]->type)) {
                                              if($data[0]->type=='Expense')
                                                 { echo 'display: block';}
                                              else
                                                { 
                                                  echo 'display: none';
                                                 } 
                                              }else
                                              {
                                                echo 'display: none';
                                              } 
                                       ?>">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                          <label class="col-md-2 col-sm-2 col-xs-12 control-label">PO No<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                              <input type="text" class="form-control" name="po_no" id="po_no" value="<?php if(isset($data)){ echo $data[0]->po_no;}?>"/>
                                            </div> 
                                        </div>
                                    </div>


                                    <div class="form-group vendor_selection"  style="<?php if (isset($data[0]->type)) {
                                              if($data[0]->type=='Purchase')
                                                 { echo 'display: block';}
                                              else
                                                { 
                                                  echo 'display: none';
                                                 } 
                                              }
                                              else
                                              { 
                                                echo 'display: none';
                                              } 
                                       ?>">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                          <label class="col-md-2 col-sm-2 col-xs-12 control-label">PO No<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                             <select name="purchase_order_id" 
                                             id="purchase_order_id" class="form-control">
                                             <?php if(isset($purchase_order)) { for ($k=0; $k < count($purchase_order); $k++) { ?>
                                                    <option value="<?php echo $purchase_order[$k]->id; ?>" <?php if(isset($data)) { if($purchase_order[$k]->id==$data[0]->po_id) { echo 'selected'; } } ?>><?php if($purchase_order[$k]->po_no!=''){
                                                        echo $purchase_order[$k]->po_no;
                                                      }else{ echo $purchase_order[$k]->order_date.'-'.$purchase_order[$k]->id; } ?></option>
                                                    <?php }} ?>
                                             </select>                  
                                             <!--  <input type="text" class="form-control" name="po_no" id="po_no" value="<?php if(isset($data)){ echo $data[0]->po_no;}?>"/> -->
                                            </div> 

                                             <label class="col-md-2 col-sm-2 col-xs-12  col-xs-12 control-label po_status">PO Status<span class="asterisk_sign">*</span> : &nbsp;&nbsp;&nbsp;&nbsp;<span > </span><span id="po_state_text"></span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12 po_status">
                                              
                                              <input type="hidden" name="po_state" value="<?php if(isset($data)){ echo $data[0]->po_previous_state;}?>" id="po_state">
                                              <input type="text" class="form-control" name="po_status" id="po_status" value="<?php if(isset($data)){ echo $data[0]->po_status;}?>" readonly/>
                                              
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Attached <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="radio" name="attached"  value="yes" id="attached_yes" data-error="#attached" <?php if (isset($data[0]->attached)) { if($data[0]->attached=='yes') echo 'checked'; }?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="attached"  value="no" id="attached_no" data-error="#attached" <?php if (isset($data[0]->attached)) { if($data[0]->attached=='no') echo 'checked'; } ?>/>&nbsp;&nbsp;No&nbsp;&nbsp;&nbsp;
                                                <div id="attached"></div>
                                            </div>
                                        </div>
                                    </div>                                 
                                    
                                    <div class="h-scroll">  
                                    <h2 style="padding:20px;padding-bottom:0px;">Accounts</h2>
                                        <div class="table-stripped form-group" style="padding:15px;" >
                                            <table class="table table-bordered" style="margin-bottom: 0px; ">
                                            <thead>
                                                <tr>
                                                    <th style="width: 320px">particulars <span class="asterisk_sign">*</span></th>
                                                    <th>Qty <span class="asterisk_sign">*</span></th>
                                                    <th class="print_hide">Rate (In Rs)</th>
                                                    <th class="print_hide">Amount (In Rs)</th>
                                                    <th class="print_hide">Tax (%)</th>
                                                    <th class="print_hide">CGST (In Rs)</th>
                                                    <th class="print_hide">SGST (In Rs)</th>
                                                    <th class="print_hide">IGST (In Rs)</th>
                                                    <th>Total Amount (In Rs)</th>
                                                    <th style="text-align:center;" class="print_hide">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="raw_material_details">
                                            <?php 

                                                if(isset($payment_voucher))
                                                {

                                                 for ($i=0; $i <count($payment_voucher) ; $i++) { ?> 
                                                     <tr id="row_<?php echo $i; ?>">
                                                        <td>
                                                          <?php if($data[0]->type=='Expense'){?><input type="text" class="form-control" name="particulars[]" id="particulars_<?=$i?>" value="<?=$payment_voucher[$i]->particulars?>"><?php } else { ?>

                                                            <select name="particulars_id[]" class="form-control raw_material" id="particulars_<?=$i?>"><?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                            <option value="<?php echo $raw_material[$k]->id; ?>" <?=($raw_material[$k]->id==$payment_voucher[$i]->particular_id)?'selected':''?>>
                                                              <?php echo $raw_material[$k]->rm_name; ?>
                                                                
                                                              </option><?php }} ?>
                                                            </select>


                                                            <input type="hidden" class="form-control" name="particulars[]" id="particulars_<?=$i?>" value="<?=$payment_voucher[$i]->particulars?>"><?php } ?>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control qty" name="qty[]" id="qty_<?=$i?>" placeholder="Qty" value="<?=$payment_voucher[$i]->qty?>" onkeypress="return isNumberKey(event)"/>
                                                        </td>
                                                        <td class="print_hide">
                                                            <input type="text" class="form-control rate" name="rate[]" id="rate_<?=$i?>" placeholder="Rate" value="<?=$payment_voucher[$i]->rate?>"  onblur="get_amount(this)"  onkeypress="return isNumberKey(event)"/>
                                                        </td>
                                                        
                                                        <td class="print_hide">
                                                            <input type="text" class="form-control amount" name="amount[]" id="amount_<?=$i?>" placeholder="Amount" value="<?=$payment_voucher[$i]->amount?>" readonly />
                                                        </td>

                                                        <td class="print_hide">
                                                            <input type="text" class="form-control tax" name="tax[]" id="tax_per_<?=$i?>" placeholder="Tax" value="<?=$payment_voucher[$i]->tax_per?>" onblur="get_amount(this)" onkeypress="return isNumberKey(event)"/>
                                                        </td>

                                                        <td class="print_hide">
                                                            <input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_<?=$i?>" 
                                                            placeholder="CGST Amount" value="<?=$payment_voucher[$i]->cgst_amt?>" onblur="get_amount(this)" />
                                                        </td>
                                                        <td class="print_hide">
                                                            <input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_<?=$i?>" 
                                                            placeholder="SGST Amount" value="<?=$payment_voucher[$i]->sgst_amt?>" onblur="get_amount(this)" />
                                                        </td>
                                                        <td class="print_hide">
                                                            <input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_<?=$i?>" 
                                                            placeholder="IGST Amount" value="" onblur="get_amount(this)" value="<?=$payment_voucher[$i]->igst_amt?>"/>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_<?=$i?>" 
                                                            placeholder="Total Amount" value="<?=$payment_voucher[$i]->total_amt?>" readonly />
                                                        </td>
                                                        <td class="table_action" style="text-align:center; vertical-align: middle;">
                                                               <?php  
                                                                    $style = 'display: none;';
                                                                    if(isset($data[0]->freezed)){
                                                                        if($data[0]->freezed==1){
                                                                            $style =  'display: none;';
                                                                        }
                                                                    } elseif($i>=1) {
                                                                         $style =  'display: block;';
                                                                    }
                                                                ?>

                                                            <a id="row_<?php echo $i; ?>_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  style="<?=$style?>"></span></a>
                                                        </td>
                                                    </tr>
                                                <?php } }
                                                else
                                                {?>
                                                 <tr id="row_0">
                                                    <td>
                                                      <input type="text" class="form-control" name="particulars[]" id="particulars_0" value="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control qty" name="qty[]" id="qty_0" placeholder="Qty" value="" onkeypress="return isNumberKey(event)"/>
                                                    </td>
                                                    <td class="print_hide">
                                                        <input type="text" class="form-control rate" name="rate[]" id="rate_0" placeholder="Rate" value=""  onblur="get_amount(this)" onkeypress="return isNumberKey(event)"/>
                                                    </td>
                                                    
                                                    <td class="print_hide">
                                                        <input type="text" class="form-control amount" name="amount[]" id="amount_0" placeholder="Amount" value="" readonly />
                                                    </td>

                                                    <td class="print_hide">
                                                        <input type="text" class="form-control tax" name="tax[]" id="tax_per_0" placeholder="Tax" value="" onblur="get_amount(this)" onkeypress="return isNumberKey(event)"/>
                                                    </td>

                                                    <td class="print_hide">
                                                        <input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_0" placeholder="CGST Amount" value="" onblur="get_amount(this)" />
                                                    </td>
                                                    <td class="print_hide">
                                                        <input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_0" placeholder="SGST Amount" value="" onblur="get_amount(this)" />
                                                    </td>
                                                    <td class="print_hide">
                                                        <input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_0" placeholder="IGST Amount" value="" onblur="get_amount(this)" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_0" placeholder="Total Amount" value="" readonly />
                                                    </td>
                                                    <td class="table_action" style="text-align:center; vertical-align: middle;">
                                                        <?php  
                                                            if(isset($data[0]->freezed)){
                                                                if($data[0]->freezed==1){
                                                                    $style =  'display: none;';
                                                                }
                                                            }else
                                                                {
                                                                     $style =  'display: none;';
                                                                }
                                                        ?>

                                                        <a id="row_0_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  style="<?=$style?>"></span></a>
                                                    </td>
                                                </tr>
                                                <?php }
                                                ?>
                                               <!--  }?> -->
                                            </tbody>
                                            <tfoot>
                                                <tr class="repeat-box" style="<?php if (isset($data[0]->type)) { if($data[0]->type=='Purchase') { echo 'display: none'; } } ?>">
                                                    <td colspan="10">
                                                        <button type="button" class="btn btn-success" id="repeat-box" >+</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                   
                                            

                                    <div class="form-group">
                                      <input type="hidden" id="final_amount" name="final_amount"  value="><?php if(isset($data[0]->final_amount)){ echo $data[0]->final_amount; }?>">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12 ">
                                                <textarea  class="form-control"  name="remark" id="remark"><?php if(isset($data[0]->remark)){ echo $data[0]->remark; }?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                 </div>
                                 <br clear="all"/>
                                 </div>
                           
                              </div>
                                <div class="panel-footer">
                                    <a href="<?php echo base_url(); ?>index.php/Payment_voucher/" class="btn btn-danger" type="reset" id="reset">Cancel</a>

                                    <input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Submit" >
                                  
                                </div>
                            </form>
                            
                         </div>
                        </div>
                    </div>
                        
                   </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
                        
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript">
            
        
            
            
            $(document).ready(function(){
            
                 if(!$('#btn_submit').is(':visible')){
                    // $("input[type!='hidden']").attr("disabled", true);
                    $('input[type="text"').attr("readonly", true);
                    $('input[type="checkbox"]').attr("disabled", true);
                    $("select:visible").attr("disabled", true);
                    $("textarea").attr("disabled", true);

                    $("#btn_approve").attr("disabled", false);
                    $("#btn_reject").attr("disabled", false);
                    $("#remarks").attr("disabled", false);
                } else {
                    $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                }

               $('.type_purchase').on('click',function(){

                if($(this).val()=='Purchase')
                {
                  $('.vendor_selection').show();
                  $('.expense_selection').hide();
                  $('#repeat-box').hide();
                  $('.repeat-box').hide();
                }else
                {

                  $('.vendor_selection').hide();
                  $('.expense_selection').show();
                  $('#repeat-box').show();
                  $('.repeat-box').show();
                }

               });   
                
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });
                
                $('#vendor_id').on('change', function() {
                  // alert( this.value ); // or $(this).val()
                  get_purchase_order_nos();
                  get_purchase_order_details_nos();
                  $('#vendor_name').val($('#vendor_id option:selected').text());
                });


                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
            });
            
            function get_purchase_order_details_nos(){
                var vendor_id = $('#vendor_id').val();
                $("#purchase_order_id").html('<option value="">Select</option>');
                $.ajax({
                    url:BASE_URL+'index.php/Payment_voucher/get_purchase_order_nos',
                    method:"post",
                    data:{vendor_id:vendor_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){

                            var newRow = '<option value="">Select</option>';

                            for(var i=0; i<data.id.length; i++){
                                if(data.po_no[i]!='')
                                    {
                                        newRow = newRow + '<option value="'+data.id[i]+'">'+data.po_no[i]+'</option>';
                                    }
                                    else
                                    {
                                        newRow = newRow + '<option value="'+data.id[i]+'">'+data.order_date[i]+' - '+data.id[i]+'</option>';
                                    }
                            }
                            /*console.log(newRow);*/
                            $("#purchase_order_id").html(newRow);
                        }
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });
            }
            function get_purchase_order_nos(){
                var vendor_id = $('#vendor_id').val();
                $("#purchase_order_id").html('<option value="">Select</option>');
                
                $.ajax({
                   url:BASE_URL+'index.php/Payment_voucher/get_gstin',
                    method:"post",
                    data:{vendor_id:vendor_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        /*obj =$.parseJSON(data[0]);*/
                        console.log(data[0].gst_number+data[0].state);
                        $('#gst_in').val(data[0].gst_number);
                        $('#gst_in1').text(data[0].gst_number);
                        $('#vendor_state').val(data[0].state);
                        get_amount('');
                       /* if(vendor_state!='Maharashtra')
                        {
                            $('#state_type').val('INTRA');
                        }
                        else
                        {
                            $('#state_type').val('INTER');
                        }*/
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });
            }

            $('#purchase_order_id').on('change', function() {
                // alert( this.value ); // or $(this).val()
                get_purchase_order_details();
                $('#po_no').val($('#purchase_order_id option:selected').text());
            });

            function get_purchase_order_details(){
                var purchase_order_id = $('#purchase_order_id').val();
                var postatus;
                var other_charges_amount = 0;
                var other_charges_reson='';
                $.ajax({
                  url:BASE_URL+'index.php/Purchase_order/get_po_status',
                  method:"post",
                  data:{id:purchase_order_id},
                  dataType:"json",
                  async:false,
                  success: function(data){
                    if(data!=0)
                    {
                      postatus = data.po_status;
                      if(data.other_charges_amount!=null)
                          other_charges_amount = data.other_charges_amount;
                      other_charges_reason = data.other_charges;

                    }
                  }
                });

                console.log(postatus);
                var url ;
                if(postatus=='Open' || postatus=='Advance')
                {
                  $('#po_status').val('Advance');
                  $('#po_state_text').text(postatus);
                  $('#po_state').val(postatus);
                  url = BASE_URL+'index.php/Purchase_order/get_purchase_order_items';
                }
                else
                {
                  $('#po_status').val(postatus);
                  $('#po_state').val(postatus);
                  url = BASE_URL+'index.php/Purchase_order/get_raw_material_in_items';
                }
                
                
                $.ajax({
                    url:url,
                    method:"post",
                    data:{id:purchase_order_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                      console.log(data);
                        if(data.result==1){
                            // $("#raw_material_details > tbody").html("");
                            // $("tbody", "#raw_material_details").remove();
                            $("#raw_material_details").empty();
                            var counter = $('.raw_material').length;
                            for(var i=0; i<data.item_id.length; i++){
                                $('.po_stock').show();

                                if(postatus=='Open' || postatus=='Advance')
                                {
                                  var qty = data.qty[i];
                                  var rate = data.rate[i];
                                  var amount = data.amount[i];
                                  var tax_per = data.tax_per[i];
                                  var cgst_amt = data.cgst_amt[i];
                                  var sgst_amt = data.sgst_amt[i];
                                  var igst_amt = data.igst_amt[i];
                                  var total_amt = data.total_amt[i];
                                }
                                else
                                {
                                  var qty = data.qty[i];
                                  var rate = data.rate[i];
                                  var amount = data.amount[i];
                                  var tax_per = data.tax_per[i];
                                  var cgst_amt = data.cgst_amt[i];
                                  var sgst_amt = data.sgst_amt[i];
                                  var igst_amt = data.igst_amt[i];
                                  var total_amt = data.total_amt[i];
                                  other_charges_amount = data.other_charges_amount[i];
                                }
                                var newRow = jQuery('<tr id="box_'+counter+'_row">'+
                                            '<td>' + 
                                                /*'<input type="text" class="form-control" name="particulars[]" id="particulars_'+counter+'" value="">'*/
                                                 '<select name="particulars_id[]" class="form-control raw_material" id="particulars_selected_'+counter+'">'+
                                                '</select><select  class="form-control raw_material" id="particulars_'+counter+'" style="display:none">'+
                                                    '<option value="">Select</option>'+
                                                    '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>'+
                                                            '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>'+
                                                    '<?php }} ?>'+
                                                '</select><input type="hidden" name="particulars[]" id="particulars_text_'+counter+'">' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="'+qty+'" onkeypress="return isNumberKey(event)" onblur="get_amount(this)"   readonly/>' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="'+rate+'" onblur="get_amount(this)" onkeypress="return isNumberKey(event)" readonly/>' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="'+amount+'" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                            '<input type="text" class="form-control tax" name="tax[]" id="tax_per_'+counter+'" placeholder="Tax %" value="'+tax_per+'" onblur="get_amount(this)"   onkeypress="return isNumberKey(event)" readonly/>'+
                                            '</td>' +  
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_'+counter+'" placeholder="CGST Amount" value="'+cgst_amt+'" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_'+counter+'" placeholder="SGST Amount" value="'+sgst_amt+'" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_'+counter+'" placeholder="IGST Amount" value="'+igst_amt+'" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_'+counter+'" placeholder="Total Amount" value="'+total_amt+'" readonly />' + 
                                            '</td>' + 
                                            '<td style="text-align:center;" class="print_hide">' + 
                                                '<a id="box_'+counter+'_row_delete" " class="delete_row" href="javascript:void(0)"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' +  
                                        '</tr>');
                                $('#raw_material_details').append(newRow);
                                $("#particulars_"+counter).val(data.item_id[i]);
                                var selecttext = $("#particulars_"+counter+" option[value='"+data.item_id[i]+"']").text();
                                $('#particulars_text_'+counter).val(selecttext);
                                var selected_val = $("#particulars_"+counter).val();


                                $("#particulars_selected_"+counter).append('<option value="'+selected_val+'">'+selecttext+'</option>')
                                counter++;
                            }

                            var newRow1;
                            var newRow2;
                            $('#repeat-box').hide();
                            $('#box_row1').remove();
                            $('#box_row2').remove();
                            newRow1 = jQuery('<tr id="box_row1">' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control " name="other_charges" id="other_charges" placeholder="Other Charges" value="'+other_charges_reson+'" readonly/>' +
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '</td>' +
                                                        '<td>' + 
                                                            '( + ) Other Charges Amount' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control " name="other_charges_amount" id="other_charges_amount" placeholder="Other Charges" value="'+other_charges_amount+'" onblur="get_amount(this)" readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                    '</tr>'+
                                                    '<tr id="box_row1">' + 
                                                        
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '</td>' +
                                                        '<td>' + 
                                                            '( - ) TDS(%)' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control " name="tds_per" id="tds_per" placeholder="TDS" value="<?php if(isset($data[0]->tds_per)){ echo $data[0]->tds_per; }?>" onblur="get_amount(this)"/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                    '</tr>');
                            $('#raw_material_details').append(newRow1);
                    
                            newRow2 = jQuery('<tr id="box_row2">' + 
                                                        
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '</td>' +
                                                        '<td>' + 
                                                            'Total' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control" name="total_payable" id="total_payable" placeholder="Total Payable" value="<?php if(isset($data)) { echo $data[0]->total_payable; } ?>" readonly />' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                    '</tr>');
                            $('#raw_material_details').append(newRow2);

                           /* $('#raw_material_details').append(newRow1);*/
                            $('.format_number').keyup(function(){
                                format_number(this);
                            });
                            // $(".qty").blur(function(){
                                // get_amount($(this));
                            // });
                            // $(".rate").blur(function(){
                                // get_amount($(this));
                            // });
                            $('.delete_row').click(function(event){
                                delete_row($(this));
                                get_total();
                            });

                            console.log('other_charges'+other_charges_reason);
                            $('#other_charges').val(other_charges_reason);

                            get_total();
                        }
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });
            }
       
            var set_total = function (){
                var depot_state = $("#depot_state").val();
                var vendor_state = $("#vendor_state").val();
                
                
                $('.rate').each(function(){
                    var elem = $(this);
                    var id = elem.attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                    var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                    var tax_per = parseFloat(get_number($("#tax_per_"+index).val(),2));

                    if (isNaN(qty)) qty=0;
                    if (isNaN(rate)) rate=0;
                    if (isNaN(tax_per)) tax_per=0;

                    var cgst = 0;
                    var sgst = 0;
                    var igst = 0;

                    if(depot_state==vendor_state){
                        cgst = tax_per/2;
                        sgst = tax_per/2;
                    } else {
                        igst = tax_per;
                    }

                    if (isNaN(cgst)) cgst=0;
                    if (isNaN(sgst)) sgst=0;
                    if (isNaN(igst)) igst=0;

                    var cgst_amt = (qty*((rate*cgst)/100)).toFixed(2);
                    var sgst_amt = (qty*((rate*sgst)/100)).toFixed(2);
                    var igst_amt = (qty*((rate*igst)/100)).toFixed(2);
                    var tax_amt = parseFloat(cgst_amt,2)+parseFloat(sgst_amt,2)+parseFloat(igst_amt,2);
                    
                    if (isNaN(cgst_amt)) cgst_amt=0;
                    if (isNaN(sgst_amt)) sgst_amt=0;
                    if (isNaN(igst_amt)) igst_amt=0;
                    if (isNaN(tax_amt)) tax_amt=0;

                    var amount = (qty*rate).toFixed(2);
                    var total_amt = parseFloat(amount,2) + parseFloat(tax_amt,2);

                    $("#amount_"+index).val(amount);
                    $("#cgst_amt_"+index).val(cgst_amt);
                    $("#sgst_amt_"+index).val(sgst_amt);
                    $("#igst_amt_"+index).val(igst_amt);
                    $("#tax_amt_"+index).val(tax_amt);
                    $("#total_amt_"+index).val(total_amt.toFixed(2));
                });

                get_total();
            }
            function get_raw_material_details(elem){
                var depot_state = $("#depot_state").val();
                var vendor_state = $("#vendor_state").val();
                var raw_material_id = elem.value;
                var id = elem.id;
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var rate = 0;
                var tax_per = 0;
                var hsn_code = '';

                $.ajax({
                    url:BASE_URL+'index.php/Raw_material/get_data',
                    method:"post",
                    data:{id:raw_material_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            rate = parseFloat(data.rate);
                            tax_per = parseFloat(data.tax_per);
                            hsn_code = data.hsn_code;
                        }
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });

                if (isNaN(qty)) qty=0;
                if (isNaN(rate)) rate=0;
                if (isNaN(tax_per)) tax_per=0;

                var cgst = 0;
                var sgst = 0;
                var igst = 0;
                
                if(depot_state==vendor_state){
                    cgst = tax_per/2;
                    sgst = tax_per/2;
                } else {
                    igst = tax_per;
                }

                if (isNaN(cgst)) cgst=0;
                if (isNaN(sgst)) sgst=0;
                if (isNaN(igst)) igst=0;

                var cgst_amt = (qty*((rate*cgst)/100)).toFixed(2);
                var sgst_amt = (qty*((rate*sgst)/100)).toFixed(2);
                var igst_amt = (qty*((rate*igst)/100)).toFixed(2);
                var tax_amt = parseFloat(cgst_amt,2)+parseFloat(sgst_amt,2)+parseFloat(igst_amt,2);
                
                if (isNaN(cgst_amt)) cgst_amt=0;
                if (isNaN(sgst_amt)) sgst_amt=0;
                if (isNaN(igst_amt)) igst_amt=0;
                if (isNaN(tax_amt)) tax_amt=0;

                var amount = (qty*rate).toFixed(2);

                var total_amt = parseFloat(amount,2) + parseFloat(tax_amt,2);

                $("#rate_"+index).val(rate);
                $("#tax_per_"+index).val(tax_per);
                $("#hsn_code_"+index).val(hsn_code);
                $("#amount_"+index).val(amount);
                $("#cgst_amt_"+index).val(cgst_amt);
                $("#sgst_amt_"+index).val(sgst_amt);
                $("#igst_amt_"+index).val(igst_amt);
                $("#tax_amt_"+index).val(tax_amt);
                $("#total_amt_"+index).val(total_amt.toFixed(2));

                get_total();
            }
            function get_amount(elem){
                if(elem=='')
                {
                    $('.rate').each(function(){
                        var id = $(this).attr('id');
                        var index = id.substr(id.lastIndexOf('_')+1);
                        var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                        var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                        var tax_per = parseFloat(get_number($("#tax_per_"+index).val(),2));

                        if (isNaN(qty)) qty=0;
                        if (isNaN(rate)) rate=0;
                        if (isNaN(tax_per)) tax_per=0;

                        var cgst = 0;
                        var sgst = 0;
                        var igst = 0;
                        if(vendor_state!='')
                        {
                          if(depot_state==vendor_state){
                            cgst = tax_per/2;
                            sgst = tax_per/2;
                          } else {
                              igst = tax_per;
                          }

                          if (isNaN(cgst)) cgst=0;
                          if (isNaN(sgst)) sgst=0;
                          if (isNaN(igst)) igst=0;

                          var cgst_amt = (qty*((rate*cgst)/100)).toFixed(2);
                          var sgst_amt = (qty*((rate*sgst)/100)).toFixed(2);
                          var igst_amt = (qty*((rate*igst)/100)).toFixed(2);
                        }else{
                          var cgst_amt = parseFloat(get_number($("#cgst_amt_"+index).val(),2));
                          var sgst_amt =  parseFloat(get_number($("#sgst_amt_"+index).val(),2));
                          var igst_amt =  parseFloat(get_number($("#igst_amt_"+index).val(),2));
                        }

                        var tax_amt = parseFloat(cgst_amt,2)+parseFloat(sgst_amt,2)+parseFloat(igst_amt,2);
                        
                        if (isNaN(cgst_amt)) cgst_amt=0;
                        if (isNaN(sgst_amt)) sgst_amt=0;
                        if (isNaN(igst_amt)) igst_amt=0;
                        if (isNaN(tax_amt)) tax_amt=0;

                        var amount = (qty*rate).toFixed(2);
                        var total_amt = parseFloat(amount,2) + parseFloat(tax_amt,2);
                        
                        $("#amount_"+index).val(amount);
                        $("#cgst_amt_"+index).val(cgst_amt);
                        $("#sgst_amt_"+index).val(sgst_amt);
                        $("#igst_amt_"+index).val(igst_amt);
                        $("#tax_amt_"+index).val(tax_amt);
                        $("#total_amt_"+index).val(total_amt);
                    }); 
                }
                else
                {
                    var depot_state = $("#depot_state").val();
                    var vendor_state = $("#vendor_state").val();
                    var id = elem.id;
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                    var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                    var tax_per = parseFloat(get_number($("#tax_per_"+index).val(),2));

                    if (isNaN(qty)) qty=0;
                    if (isNaN(rate)) rate=0;
                    if (isNaN(tax_per)) tax_per=0;

                    var cgst = 0;
                    var sgst = 0;
                    var igst = 0;
                    if(vendor_state!='')
                    {
                      if(depot_state==vendor_state){
                        cgst = tax_per/2;
                        sgst = tax_per/2;
                      } else {
                          igst = tax_per;
                      }

                      if (isNaN(cgst)) cgst=0;
                      if (isNaN(sgst)) sgst=0;
                      if (isNaN(igst)) igst=0;

                      var cgst_amt = (qty*((rate*cgst)/100)).toFixed(2);
                      var sgst_amt = (qty*((rate*sgst)/100)).toFixed(2);
                      var igst_amt = (qty*((rate*igst)/100)).toFixed(2);
                    }else{
                      var cgst_amt = parseFloat(get_number($("#cgst_amt_"+index).val(),2));
                      var sgst_amt =  parseFloat(get_number($("#sgst_amt_"+index).val(),2));
                      var igst_amt =  parseFloat(get_number($("#igst_amt_"+index).val(),2));
                    }


                    var tax_amt = parseFloat(cgst_amt,2)+parseFloat(sgst_amt,2)+parseFloat(igst_amt,2);
                    
                    if (isNaN(cgst_amt)) cgst_amt=0;
                    if (isNaN(sgst_amt)) sgst_amt=0;
                    if (isNaN(igst_amt)) igst_amt=0;
                    if (isNaN(tax_amt)) tax_amt=0;

                    var amount = (qty*rate).toFixed(2);
                    var total_amt = parseFloat(amount,2) + parseFloat(tax_amt,2);
                    
                    $("#amount_"+index).val(amount);
                    $("#cgst_amt_"+index).val(cgst_amt);
                    $("#sgst_amt_"+index).val(sgst_amt);
                    $("#igst_amt_"+index).val(igst_amt);
                    $("#tax_amt_"+index).val(tax_amt);
                    $("#total_amt_"+index).val(total_amt);
                }

                get_total();
            }
       
       
            function get_total(){
                var total_amt = 0;
                $('.amount').each(function(){
                    amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amt = total_amt + amount;
                });
                
                
                 var cgst_amount = 0;
                 $('.cgst_amt').each(function(){
                    cgst_amt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(cgst_amt)) cgst_amt=0;
                    cgst_amount = cgst_amount + cgst_amt;
                });
                
                 var sgst_amount = 0;
                 $('.sgst_amt').each(function(){
                    sgst_amt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(sgst_amt)) sgst_amt=0;
                    sgst_amount = sgst_amount + sgst_amt;
                });

                 var igst_amount = 0;
                 $('.igst_amt').each(function(){
                    igst_amt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(igst_amt)) igst_amt=0;
                    igst_amount = igst_amount + igst_amt;
                });
                
                  var tax_amt=0;
                  $('.tax_amt').each(function(){
                    taxamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(taxamt)) taxamt=0;
                    tax_amt = tax_amt + taxamt;
                });

                
                
                var final_amt=0;
                $('.final_amt').each(function(){
                    finalamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(finalamt)) finalamt=0;
                    final_amt = final_amt + finalamt;
                });

                
                 $("#final_amt").val(final_amt.toFixed(2));

                // var excise = parseFloat(get_number($("#excise").val(),2));
                var other_charges_amount = 0;
                if($('#other_charges_amount').val()!="" && $('#other_charges_amount').val()!='null')
                {
                   other_charges_amount = parseFloat(get_number($("#other_charges_amount").val(),2));
                }


                final_amount = total_amt + cgst_amount + sgst_amount + igst_amount+other_charges_amount;

                $("#final_amount").val(format_money(Math.round(final_amount*100)/100,2));
                 $("#total_amount").val(format_money(Math.round(total_amt*100)/100,2));
                  $("#cgst_amount").val(format_money(Math.round(cgst_amount*100)/100,2));
                   $("#sgst_amount").val(format_money(Math.round(sgst_amount*100)/100,2));
                    $("#igst_amount").val(format_money(Math.round(igst_amount*100)/100,2));

                if($('#tds_per').val()!="")
                {
                    var tdsamount  = ((total_amt*$('#tds_per').val())/100).toFixed(2);
                }
                else
                   var tdsamount  = 0;

                $('#tdsamount').val(tdsamount);
                var total_payable  = (final_amount-tdsamount).toFixed(2);
                 
                $('#total_payable').val(total_payable);
            }


          
           jQuery(function(){
              var counter = $('.qty').length;
              var counter = $('.box').length;

                var newRow1;
                var newRow2;

                var checkpurchase = '<?php if(isset($data[0]->type)){ if($data[0]->type=='Purchase'){ echo 1 ;} }?>';

                if(checkpurchase==1)
                {
                  newRow1 = jQuery('<tr id="box_row1">' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control " name="other_charges" id="other_charges" placeholder="Other Charges" value="<?php if(isset($data[0]->other_charges)){ echo $data[0]->other_charges; }?>" readonly/>' +
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                        '</td>' +
                                                        '<td>' + 
                                                            '( + ) Other Charges Amount' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                          '<input type="text" class="form-control " name="other_charges_amount" id="other_charges_amount" placeholder="Other Charges" value="<?php if(isset($data[0]->other_charges_amount)){ echo $data[0]->other_charges_amount; }?>" onblur="get_amount(this)" readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '&nbsp;' + 
                                                        '</td>' + 
                                                    '</tr>');
                $('#raw_material_details').append(newRow1);
                }

                newRow1 = jQuery('<tr id="box_row1">' + 
                                            
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '</td>' +
                                            '<td>' + 
                                                '( - ) TDS(%)' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control " name="tds_per" id="tds_per" placeholder="TDS" value="<?php if(isset($data[0]->tds_per)){ echo $data[0]->tds_per; }?>" onblur="get_amount(this)"/>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                        '</tr>');
                $('#raw_material_details').append(newRow1);
				
				        newRow2 = jQuery('<tr id="box_row2">' + 
                                            
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '</td>' +
                                            '<td>' + 
                                                'Total' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control" name="total_payable" id="total_payable" placeholder="Total Payable" value="<?php if(isset($data)) { echo $data[0]->total_payable; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                        '</tr>');
                $('#raw_material_details').append(newRow2);

                $('#repeat-box').click(function(event){
                      var counter = $('.qty').length;
                      event.preventDefault();
                      var newRow = jQuery('<tr id="box_'+counter+'_row">' + 
                                            
                                              '<td>' + 
                                                  '<input type="text" class="form-control" name="particulars[]" id="particulars_'+counter+'" value="">' + 
                                              '</td>' + 
                                              '<td>' + 
                                                  '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="" onkeypress="return isNumberKey(event)" onblur="get_amount(this)"   />' + 
                                              '</td>' + 
                                              '<td class="print_hide">' + 
                                                  '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" onblur="get_amount(this)" onkeypress="return isNumberKey(event)"/>' + 
                                              '</td>' + 
                                              '<td class="print_hide">' + 
                                                  '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />' + 
                                              '</td>' + 
                                              '<td>' + 
                                              '<input type="text" class="form-control tax" name="tax[]" id="tax_per_'+counter+'" placeholder="Tax %" value="" onblur="get_amount(this)"   onkeypress="return isNumberKey(event)"/>'+
                                              '</td>' +  
                                              '<td class="print_hide">' + 
                                                  '<input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_'+counter+'" placeholder="CGST Amount" value="" onblur="get_amount(this)" />' + 
                                              '</td>' + 
                                              '<td class="print_hide">' + 
                                                  '<input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_'+counter+'" placeholder="SGST Amount" value="" onblur="get_amount(this)" />' + 
                                              '</td>' + 
                                              '<td class="print_hide">' + 
                                                  '<input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_'+counter+'" placeholder="IGST Amount" value="" onblur="get_amount(this)" />' + 
                                              '</td>' + 
                                              '<td>' + 
                                                  '<input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_'+counter+'" placeholder="Total Amount" value="" readonly />' + 
                                              '</td>' + 
                                              '<td style="text-align:center;" class="print_hide">' + 
                                                  '<a id="box_'+counter+'_row_delete" " class="delete_row" href="javascript:void(0)"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                              '</td>' + 
                                          '</tr>');
                      $('#box_row1').remove();
                      $('#box_row2').remove();
                      $('#raw_material_details').append(newRow);
                      $('#box_row1').remove();
                      $('#raw_material_details').append(newRow1);
                      $('#raw_material_details').append(newRow2);
                      $('.format_number').keyup(function(){
                          format_number(this);
                      });
                      $(".type").change(function(){
                          show_item($(this));
                      });
                      $(".bar").change(function(){
                          get_bar_details($(this));
                      });
                      $(".box").change(function(){
                          get_box_details($(this));
                      });
                      $(".qty").blur(function(){
                          get_amount($(this));
                      });
                      $(".sell_rate").blur(function(){
                          get_amount($(this));
                      });
                      // $(".cost_rate").blur(function(){
                      //     get_amount($(this));
                      // });
                      $('.delete_row').click(function(event){
                          delete_row($(this));
                          get_total();
                      });
                      get_total();
                      counter++;
                });

            
  
            });

        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && ((charCode < 48 || charCode > 57) && charCode!=46 && charCode!=45 ))
                return false;
            return true;
        }
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>