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
             input[type=radio], input[type=checkbox] { margin: 8px 0px 0px;      vertical-align: text-bottom;}
            th{text-align:center;}
            .center{text-align:center;}
            input[readonly], input[disabled], select[disabled], textarea[disabled] {
                background-color: white !important; 
                color: #0b385f !important; 
                cursor: not-allowed !important;
            }

            
				#total_amount
			{
				border:none!important;
				background-color:transparent!important;
				box-shadow:none!important;
				font-size:14px;
				font-weight:700;
			}
		</style>
		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/purchase_order'; ?>" > Purchase Order List </a>  &nbsp; &#10095; &nbsp; Purchase Order Details</div>
                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
							
                            <form id="form_purchase_order_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/purchase_order/update/' . $data[0]->id; else echo base_url().'index.php/purchase_order/save'; ?>">
                              <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default">
							     	<div class="panel-body">
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="hidden" class="form-control" name="ref_id" id="ref_id" value="<?php if(isset($data)) echo $data[0]->ref_id;?>"/>
                                                <input type="hidden" class="form-control" name="po_no" id="po_no" value="<?php if(isset($data)) echo $data[0]->po_no;?>"/>
                                                <input type="text" class="form-control datepicker1" name="order_date" id="order_date" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->order_date!=null && $data[0]->order_date!='')?date('d/m/Y',strtotime($data[0]->order_date)):''); else echo date('d/m/Y'); ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Vendor <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="vendor_id" id="vendor_id" class="form-control select2" onchange="get_vendor_details();">
                                                    <option value="00">Select</option>
                                                    <?php if(isset($vendor)) { for ($k=0; $k < count($vendor) ; $k++) { ?>
                                                            <option value="<?php echo $vendor[$k]->id; ?>" <?php if(isset($data)) { if($vendor[$k]->id==$data[0]->vendor_id) { echo 'selected'; } } ?>><?php echo $vendor[$k]->vendor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <input type="hidden" id="vendor_state" name="vendor_state" value="" />
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="depot_id" id="depot_id" class="form-control select2" onchange="get_depot_details();">
                                                    <option value="">Select</option>
                                                    <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { ?>
                                                            <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <input type="hidden" id="depot_state" name="depot_state" value="" />
                                            </div>
                                        </div>
                                    </div>
                                   <div class="h-scroll">	
                                    <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th width="600">Item <span class="asterisk_sign">*</span></th>
                                                <th width="600">Item Description <span class="asterisk_sign">*</span></th>
                                                <th width="180">Qty In Kg <span class="asterisk_sign">*</span></th>
												<th width="180">HSN Code </th>
                                                <th width="180">Rate </th>
                                                <th width="180">Amount (In Rs) </th>
                                                <th width="180">CGST (In Rs) </th>
												<th width="180">SGST (In Rs) </th>
												<th width="180">IGST (In Rs) </th>
                                                <th width="180">Total Amount (In Rs) </th>
                                                <th style="width:60px; text-align:center;">Action </th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($purchase_order_items)) {
                                                for($i=0; $i<count($purchase_order_items); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="raw_material[]" class="form-control raw_material select2" id="raw_material_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>"  onChange="get_raw_material_details(this);">
                                                        <option value="">Select</option>
                                                        <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                <option value="<?php echo $raw_material[$k]->id; ?>" <?php if($raw_material[$k]->id==$purchase_order_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $raw_material[$k]->rm_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="item_desc[]" id="item_desc_<?php echo $i; ?>" placeholder="Item Description" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->item_desc; } ?>" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->qty; } ?>" onchange="get_amount(this)" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_<?php echo $i; ?>" placeholder="HSN Code" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->hsn_code; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->rate; } ?>"  />
                                                    <input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_<?php echo $i; ?>" placeholder="Tax %" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->tax_per; } ?>"  />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->amount; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_<?php echo $i; ?>" placeholder="CGST Amount" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->cgst_amt; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_<?php echo $i; ?>" placeholder="SGST Amount" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->sgst_amt; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_<?php echo $i; ?>" placeholder="IGST Amount" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->igst_amt; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_<?php echo $i; ?>" placeholder="Total Amount" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->total_amt; } ?>" readonly />
                                                    <input type="hidden" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_<?php echo $i; ?>" placeholder="Tax Amount" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->tax_amt; } ?>" readonly />
                                                </td>
                                                <td style="text-align:center; vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>
                                                </td>
                                            </tr>
											
                                        <?php }} else { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="raw_material[]" class="form-control raw_material select2" id="raw_material_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>"  onChange="get_raw_material_details(this);">
                                                        <option value="">Select</option>
                                                        <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                <option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="item_desc[]" id="item_desc_<?php echo $i; ?>" placeholder="Item Description" value="" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="" onchange="get_amount(this)" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_<?php echo $i; ?>" placeholder="HSN Code" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value=""  onchange="get_amount(this)"/>
                                                    <input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_<?php echo $i; ?>" placeholder="Tax %" value=""  />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_<?php echo $i; ?>" placeholder="CGST Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_<?php echo $i; ?>" placeholder="SGST Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_<?php echo $i; ?>" placeholder="IGST Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_<?php echo $i; ?>" placeholder="Total Amount" value="" readonly />
                                                    <input type="hidden" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_<?php echo $i; ?>" placeholder="Tax Amount" value="" readonly />
                                                </td>
                                                <td style="text-align:center; vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="11">
                                                    <button type="button" class="btn btn-success" id="repeat-box" style=" ">+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Other Charges Description </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                 <input type="text" class="form-control" name="other_charges" id="other_charges" placeholder="Other Charges" value="<?php if (isset($data[0]->other_charges)) { echo $data[0]->other_charges; } ?>"  />
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Other Charges Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="other_charges_amount" id="other_charges_amount" placeholder="Other Charges Amount" value="<?php if (isset($data[0]->other_charges_amount)) { echo $data[0]->other_charges_amount; } ?>" onkeypress="return isNumberKey(event)" onchange="get_amount(this)"/>
                                            </div>
                                        </div>
                                    </div>
									
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Delivery Date </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="delivery_date" id="delivery_date" placeholder="Delivery Date" value="<?php if(isset($data)) { echo (($data[0]->delivery_date!=null && $data[0]->delivery_date!='')?date('d/m/Y',strtotime($data[0]->delivery_date)):''); } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amount; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Shipping Method </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="shipping_method" id="shipping_method" placeholder="Shipping Method" value="<?php if (isset($data)) { echo $data[0]->shipping_method; } ?>" />
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Shipping Term </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="shipping_term" id="shipping_term" placeholder="Shipping Term" value="<?php if(isset($data)) { echo $data[0]->shipping_term; } ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                   <select class="form-control" name="status">
                                                        <option value="Pending" <?php if(isset($data)) {if ($data[0]->status=='Pending') echo 'selected';}?>>Pending</option>
                                                        <option value="Deleted" <?php if(isset($data)) {if ($data[0]->status=='Deleted') echo 'selected';}?>>Deleted</option>
                                                        <option value="Rejected" <?php if(isset($data)) {if ($data[0]->status=='Rejected') echo 'selected';}?>>Rejected</option>
                                                        <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Approved</option>
                                                        <option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                            <div class="col-md-10 col-sm-10 col-xs-12">
                                                <textarea class="form-control" name="remarks" id="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
								<br clear="all"/>
							  </div>
                                </div>
                                <!-- <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/purchase_order" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div> -->
                                  <?php
                                if(isset($data[0]->po_status))
                                        {
                                            if($data[0]->po_status=='Raw Material IN' || $data[0]->po_status=='Closed' || $data[0]->po_status=='Advance')
                                            {
                                                $style="display:none";
                                            }
                                            else
                                            {
                                                $style="display:block";
                                            }
                                        }
                                        else
                                        {
                                                $style="display:block";
                                        }
                                ?>

                                <?php $curusr=$this->session->userdata('session_id'); ?>
                                <?php 
                                        if(isset($data[0]->status))
                                        {
                                         if(isset($access)) {
                                            if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive'))
                                                {
                                                  if(isset($data[0]->status))
                                                    {
                                                         if($data[0]->status=='Deleted'){
                                                            echo '<label class="col-xs-12 control-label" style="color:#cc2127!important">Note : If clicked on approve button this entry will be deleted permanently </label>';

                                                         }    
                                                    }     
                                                }
                                            }   
                                        }
                                ?>
                                 <div class="panel-footer">
                                    <a href="<?php echo base_url(); ?>index.php/Purchase_order" class="btn btn-danger btn-sm pull-right" type="reset" id="reset">Cancel</a>
                                    <?php $curusr=$this->session->userdata('session_id'); ?>
                                    <div style="<?=$style?>">
                                        <input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Submit For Approval" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_edit=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved' || $data[0]->status=='InActive')) echo ''; else echo 'display: none;';} else if($access[0]->r_insert=='1') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_delete" name="btn_delete" value="Delete" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_delete=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved') && $data[0]->status!='InActive') echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-success btn-sm" id="btn_approve" name="btn_approve" value="Approve" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_reject" name="btn_reject" value="Reject" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    </div>
                                    
                                    <!-- <button class="btn btn-success pull-right" style="<?php //if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
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
                    $('input[type="file"]').attr("disabled", true);
                    $('input[type="radio"]').attr("disabled", true);
                    $("select:visible").attr("disabled", true);
                    $("textarea").attr("disabled", true);
                    $(".datepicker").attr("disabled", true);

                    $("#btn_approve").attr("disabled", false);
                    $("#btn_reject").attr("disabled", false);
                    $("#remarks").attr("disabled", false);

                    $('tfoot').hide();
                    $('.table_action').hide();
                } else {
                    $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                }
                set_total();
            });
            var get_vendor_details = function(){
                $.ajax({
                    url:BASE_URL+'index.php/Vendor/get_data',
                    method:"post",
                    data:{id:$('#vendor_id').val()},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            $('#vendor_state').val(data.state.trim().toUpperCase());
                            set_total();
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
            var get_depot_details = function(){
                $.ajax({
                    url:BASE_URL+'index.php/Depot/get_data',
                    method:"post",
                    data:{id:$('#depot_id').val()},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            $('#depot_state').val(data.state.trim().toUpperCase());
                            set_total();
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
                    //alert('j');
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
                    var total_amount = parseFloat(amount,2) + parseFloat(tax_amt,2);

                    $("#amount_"+index).val(amount);
                    $("#cgst_amt_"+index).val(cgst_amt);
                    $("#sgst_amt_"+index).val(sgst_amt);
                    $("#igst_amt_"+index).val(igst_amt);
                    $("#tax_amt_"+index).val(tax_amt);
                    $("#total_amt_"+index).val(total_amount.toFixed(2));
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

                var total_amount = parseFloat(amount,2) + parseFloat(tax_amt,2);

                $("#rate_"+index).val(rate);
                $("#tax_per_"+index).val(tax_per);
                $("#hsn_code_"+index).val(hsn_code);
                $("#amount_"+index).val(amount);
                $("#cgst_amt_"+index).val(cgst_amt);
                $("#sgst_amt_"+index).val(sgst_amt);
                $("#igst_amt_"+index).val(igst_amt);
                $("#tax_amt_"+index).val(tax_amt);
                $("#total_amt_"+index).val(total_amount.toFixed(2));

                get_total();
            }
            function get_amount(elem){
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
                var total_amount = parseFloat(amount,2) + parseFloat(tax_amt,2);

                $("#amount_"+index).val(amount);
                $("#cgst_amt_"+index).val(cgst_amt);
                $("#sgst_amt_"+index).val(sgst_amt);
                $("#igst_amt_"+index).val(igst_amt);
                $("#tax_amt_"+index).val(tax_amt);
                $("#total_amt_"+index).val(total_amount);

                get_total();
            }
            function get_total(){
                var final_amt=0;

                $('.total_amt').each(function(){
                    finalamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(finalamt)) finalamt=0;
                    final_amt = final_amt + finalamt;
                });                
                other_charges_amount = 0;
                if($("#other_charges_amount").val()!='')
                  {
                    other_charges_amount = parseFloat(get_number($("#other_charges_amount").val(),2));
                  }

                final_amt = (final_amt+other_charges_amount);
                $("#total_amount").val(final_amt = final_amt.toFixed(2));
            }
			$('#repeat-box').click(function(event){
				var counter = $('.raw_material').length;

                event.preventDefault();
                var newRow = jQuery('<tr id="box_'+counter+'_row">' + 
                                        '<td>' + 
                                            '<select name="raw_material[]" class="form-control raw_material select2" id="raw_material_'+counter+'" data-error="#err_item_'+counter+'"  onChange="get_raw_material_details(this);" >' + 
                                                '<option value="">Select</option>' + 
                                                '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>' + 
                                                        '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>' + 
                                                '<?php }} ?>' + 
                                            '</select>' + 
                                            '<div id="err_item_'+counter+'"></div>' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control" name="item_desc[]" id="item_desc_'+counter+'" placeholder="Item Description" value="" />' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="" onchange="get_amount(this)" />' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_'+counter+'" placeholder="HSN Code" value="" readonly />' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" onchange="get_amount(this)" />' + 
                                            '<input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_'+counter+'" placeholder="Tax %" value=""  />' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_'+counter+'" placeholder="CGST Amount" value="" readonly />' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_'+counter+'" placeholder="SGST Amount" value="" readonly />' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_'+counter+'" placeholder="IGST Amount" value="" readonly />' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_'+counter+'" placeholder="Total Amount" value="" readonly />' + 
                                            '<input type="hidden" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_'+counter+'" placeholder="Tax Amount" value="" readonly />' + 
                                        '</td>' + 
                                        '<td style="text-align:center; vertical-align: middle;">' + 
                                            '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>' + 
                                        '</td>' + 
                                    '</tr>');
                $('#box_details').append(newRow);
               $('.select2').select2();
                $('.format_number').keyup(function(){
                    format_number(this);
                });
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });

                removeMultiInputNamingRules('#form_purchase_order_details', 'select[alt="raw_material[]"]');
                removeMultiInputNamingRules('#form_purchase_order_details', 'input[alt="qty[]"]');

                addMultiInputNamingRules('#form_purchase_order_details', 'select[name="raw_material[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_purchase_order_details', 'input[name="qty[]"]', { required: true, number: true }, "");
            });

            function isNumberKey(evt){
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && ((charCode < 48 || charCode > 57) && charCode!=46 ))
                    return false;
                return true;
            }

        </script>
    </body>
</html>