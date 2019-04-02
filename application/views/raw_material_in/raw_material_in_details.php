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
            input[type=radio], input[type=checkbox] { margin: 8px 0px 0px;      vertical-align: text-bottom;}
            th{text-align:center;}
            .center{text-align:center;}
            /*input[readonly], input[disabled], select[disabled], textarea[disabled] {
                background-color: white !important; 
                color: #0b385f !important; 
                cursor: not-allowed !important;
            }*/

            input[readonly], input[disabled], select[readonly],  select[disabled], textarea[disabled] {
                background-color: white !important; 
                color: #0b385f !important; 
                cursor: not-allowed !important;
            }


            table input[type='text']{
                        font-size: 11px!important;
		
            }
			
			table
			{
				overflow:scroll!important;
			}
			tfoot
			{
				display:none!important;
				
			}

            <?php if(isset($raw_material_stock)) { ?>
                .po_stock{
                 display: block;       
                }
            <?php } else {?>
                .po_stock{
                  display: none;   
                }
            <?php  } ?>
		</style>
    </head>
    <body>								
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/raw_material_in'; ?>" > Raw Material In List </a>  &nbsp; &#10095; &nbsp; Raw Material In Details</div>
				   
                <!-- PAGE CONTENT WRAPPER -->
                    <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
							
                            <form id="form_raw_material_in_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/raw_material_in/update/' . $data[0]->id; else echo base_url().'index.php/raw_material_in/save'; ?>">
                              <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
								
								<div class="panel-body">
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Receipt <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                  <input type="hidden" class="form-control" name="ref_id" id="ref_id" value="<?php if(isset($data)) echo $data[0]->ref_id;?>"/>
                                                  <input type="hidden" class="form-control" name="row_material_in_no" id="row_material_in_no" value="<?php if(isset($data[0]->row_material_in_no)) echo $data[0]->row_material_in_no;?>"/>  
                                                  
                                                <input type="text" class="form-control datepicker1" name="date_of_receipt" id="date_of_receipt" placeholder="Date Of Receipt" value="<?php if(isset($data)) echo (($data[0]->date_of_receipt!=null && $data[0]->date_of_receipt!='')?date('d/m/Y',strtotime($data[0]->date_of_receipt)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                            </div>
										</div>
                                    </div>
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Vendor </label>
												<div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="vendor_id" id="vendor_id" class="form-control select2">
                                                    <option value="00">Select</option>
                                                    <?php if(isset($vendor)) { for ($k=0; $k < count($vendor); $k++) { ?>
                                                            <option value="<?php echo $vendor[$k]->id; ?>" <?php if(isset($data)) { if($vendor[$k]->id==$data[0]->vendor_id) { echo 'selected'; } } ?>><?php echo $vendor[$k]->vendor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
												<input type="hidden" id="vendor_state" name="vendor_state" value="<?php if(isset($data[0]->vendor_state)) echo $data[0]->vendor_state; ?>" />
                                                <!-- <input type="hidden" name="vendor_id" id="vendor_id" value="<?php //if(isset($data)) { echo  $data[0]->vendor_id; } ?>"/>
                                                <input type="text" class="form-control load_vendor" name="vendor" id="vendor" placeholder="Type To Select Vendor...." value="<?php //if(isset($data)) { echo  $data[0]->vendor_name; } ?>"/> -->
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Purchase Order <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">

                                                <select name="purchase_order_id" id="purchase_order_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($purchase_order)) { for ($k=0; $k < count($purchase_order); $k++) { ?>
                                                            <option value="<?php echo $purchase_order[$k]->id; ?>" <?php if(isset($data)) { if($purchase_order[$k]->id==$data[0]->purchase_order_id) { echo 'selected'; } } ?>><?php echo $purchase_order[$k]->po_no; ?><?php //echo (($purchase_order[$k]->order_date!=null && $purchase_order[$k]->order_date!='')?date('d/m/Y',strtotime($purchase_order[$k]->order_date)):'') . ' - ' . $purchase_order[$k]->id; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <input type="hidden" name="po_id" id="po_id" value="<?php if(isset($data)) { echo  $data[0]->purchase_order_id; } ?>"/>

                                                <!-- <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="<?php //if(isset($data)) { echo  $data[0]->purchase_order_id; } ?>"/>
                                                <input type="text" class="form-control load_purchase_order" name="purchase_order" id="purchase_order" placeholder="Type To Select Vendor...." value="<?php //if(isset($data)) { echo  $data[0]->purchase_order_name; } ?>"/> -->
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                            <?php // onchange="get_depot_details()" ?>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="depot_id" id="depot_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { ?>
                                                            <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                    <?php }} ?>
                                                </select>
												<input type="hidden" id="depot_state" name="depot_state" value="MAHARASHTRA" />
                                                <!-- <input type="hidden" name="depot_id" id="depot_id" value="<?php //if(isset($data)) { echo  $data[0]->depot_id; } ?>"/>
                                                <input type="text" class="form-control load_depot" name="depot" id="depot" placeholder="Type To Select Depot...." value="<?php //if(isset($data)) { echo  $data[0]->depot_name; } ?>"/> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Gate Pass No <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="gate_pass_no" id="gate_pass_no" placeholder="Gate Pass No" value="<?php if(isset($data[0]->gate_pass_no)) echo $data[0]->gate_pass_no;?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">COA</label>
                                            <div class="col-md-2 col-sm-2 col-xs-12" >
                                                <input type="hidden" class="form-control" name="doc_document" value="<?php if(isset($data)) echo $data[0]->doc_document; ?>" />
                                                <input type="hidden" class="form-control" name="document_name" value="<?php if(isset($data)) echo $data[0]->document_name; ?>" />
                                                <!-- <input type="file" class="fileinput btn btn-info btn-small doc_file" name="doc_file" id="doc_file" data-error="#doc_file_error"/> -->
                                                <input type="file" class="fileinput btn btn-info btn-small doc_file" name="doc_file" id="doc_file" data-error="#doc_file_error"/>
                                                <div id="doc_file_error"></div>
                                            </div>          
                                            <div class="col-md-1 col-sm-1 col-xs-12 download-width" >
                                                <?php if(isset($data)) { if($data[0]->doc_document!= '') { ?><a target="_blank" id="doc_file_download" href="<?php if(isset($data)) echo base_url().$data[0]->doc_document; ?>"><span class="fa download fa-download" ></span></a></a><?php }} ?>
                                            </div>
                                        </div>
                                    </div>
									<div class="h-scroll">	
                                       <div class="table-stripped form-group" style="padding:15px;" >
									
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th width="600" colspan="2">  <span class="asterisk_sign"> </span></th>
                                                <th width="150" colspan="7">As Per PO<span class="asterisk_sign">*</span></th>
                                                <th width="150" colspan="7">As Per RIN <span class="asterisk_sign">*</span></th>
                                                <th width="60" class="table_action">Action</th>
                                            </tr>
                                            <tr>
                                                <th width="600">Item <span class="asterisk_sign">*</span></th>
                                                <th width="180">HSN Code </th>
                                                <th width="150">Qty In Kg <span class="asterisk_sign">*</span></th>
                                                <th width="180">Rate </th>
                                                <th width="180">Amount (In Rs) </th>
                                                <th width="100">CGST (In Rs) </th>
                                                <th width="100">SGST (In Rs) </th>
                                                <th width="100">IGST (In Rs) </th>
                                                <th width="180">Total Amount (In Rs) </th>
                                                <th width="150">Qty In Kg <span class="asterisk_sign">*</span></th>
                                                <th width="180">Rate </th>
                                                <th width="180">Amount (In Rs) </th>
                                                <th width="100">CGST (In Rs) </th>
                                                <th width="100">SGST (In Rs) </th>
                                                <th width="100">IGST (In Rs) </th>
                                                <th width="180">Total Amount (In Rs) </th>
                                                <th  class="table_action" style="width:20px; text-align:center;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="raw_material_details">
                                        <?php $i=0; if(isset($raw_material_stock)) {
                                                for($i=0; $i<count($raw_material_stock); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="raw_material[]" class="form-control raw_material select2" id="raw_material_<?php echo $i;?>" onchange="get_raw_material_details(this);" readonly>
                                                        <!-- <option value="">Select</option> -->
                                                        <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { 
                                                            if($raw_material[$k]->id==$raw_material_stock[$i]->raw_material_id){
                                                            ?>

                                                                <option value="<?php echo $raw_material[$k]->id; ?>" <?php if($raw_material[$k]->id==$raw_material_stock[$i]->raw_material_id) { echo 'selected'; } ?>><?php echo $raw_material[$k]->rm_name; ?></option>
                                                        <?php }}} ?>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_<?php echo $i; ?>" placeholder="HSN Code" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->hsn_code; } ?>" readonly />
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control po_qty" name="po_qty[]" id="po_qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->po_quantity; } ?>" readonly/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_rate" name="po_rate[]" id="po_rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->po_rate; } ?>"  readonly/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_amount" name="po_amount[]" id="po_amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->po_amount; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_cgst_amt" name="po_cgst_amt[]" id="po_cgst_amt_<?php echo $i; ?>" placeholder="CGST Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->po_cgst_amt; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_sgst_amt" name="po_sgst_amt[]" id="po_sgst_amt_<?php echo $i; ?>" placeholder="SGST Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->po_sgst_amt; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_igst_amt" name="po_igst_amt[]" id="po_igst_amt_<?php echo $i; ?>" placeholder="IGST Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->po_igst_amt; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_total_amt" name="po_total_amt[]" id="po_total_amt_<?php echo $i; ?>" placeholder="Total Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->po_total_amt; } ?>" readonly />
                                                   
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->qty; } ?>" onchange="get_amount(this)" />
                                                </td>
                                               
                                                <td>
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->rate; } ?>" onchange="get_amount(this)" />
                                                    <input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_<?php echo $i; ?>" placeholder="Tax %" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->tax_per; } ?>"  onchange="get_amount(this)" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->amount; } ?>"  readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_<?php echo $i; ?>" placeholder="CGST Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->cgst_amt; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_<?php echo $i; ?>" placeholder="SGST Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->sgst_amt; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_<?php echo $i; ?>" placeholder="IGST Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->igst_amt; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_<?php echo $i; ?>" placeholder="Total Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->total_amt; } ?>" readonly />
                                                    <input type="hidden" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_<?php echo $i; ?>" placeholder="Tax Amount" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->tax_amt; } ?>" readonly />
                                                </td>
                                               <td  class="table_action" style="text-align:center; vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>
                                                </td>
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="raw_material[]" class="form-control raw_material select2" id="raw_material_<?php echo $i;?>" onchange="get_raw_material_details(this);">
                                                        <option value="">Select</option>
                                                        <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                <option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </td>
                                             
                                                <td>
                                                    <input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_<?php echo $i; ?>" placeholder="HSN Code" value="" readonly />
                                                </td>
                                                 <td>
                                                    <input type="text" class="form-control qty" name="po_qty[]" id="po_qty_<?php echo $i; ?>" placeholder="Qty" value="" readonly/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_rate" name="po_rate[]" id="po_rate_<?php echo $i; ?>" placeholder="Rate" value=""  readonly/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_amount" name="po_amount[]" id="po_amount_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_cgst_amt " name="po_cgst_amt[]" id="po_cgst_amt_<?php echo $i; ?>" placeholder="CGST Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_sgst_amt" name="po_sgst_amt[]" id="po_sgst_amt_<?php echo $i; ?>" placeholder="SGST Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_igst_amt" name="po_igst_amt[]" id="po_igst_amt_<?php echo $i; ?>" placeholder="IGST Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control po_total_amt" name="po_total_amt[]" id="po_total_amt_<?php echo $i; ?>" placeholder="Total Amount" value="" readonly />
                                                   
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="" onchange="get_amount(this)" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="" onchange="get_amount(this)" />
                                                    <input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_<?php echo $i; ?>" placeholder="Tax %" value="" />
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
                                            <tr style="<?php if(isset($raw_material_stock)) { echo 'display: none'; } else  echo 'display: block'; ?>"> 
                                                <td colspan="18">
                                                    <button type="button" class="btn btn-success" id="repeat-raw_material" >+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
									</div>
                                    <!--<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">VAT (In Rs) </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="vat" id="vat" placeholder="VAT" value="<?php //if (isset($data)) { echo format_money($data[0]->vat,2); } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">CST (In Rs)</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="cgst_amt" id="cgst_amt" placeholder="CST" value="<?php //if (isset($data)) { echo format_money($data[0]->cgst_amt,2); } ?>"/>
                                            </div>
                                        </div>
                                    </div>-->
                                    <!--<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Excise (In Rs) </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="excise" id="excise" placeholder="Excise" value="<?php //if (isset($data)) { echo format_money($data[0]->excise,2); } ?>"/>
                                            </div>
											
											
											
											
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Final Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="final_amt" id="final_amount" placeholder="Final Amount" value="<?php //if (isset($data)) { echo format_money($data[0]->final_amt,2); } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>-->
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
                                            <div class="col-md-10  col-sm-10 col-xs-12">
                                                <textarea class="form-control" name="remarks" id="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								 </div>
								 <br clear="all"/>
                                 </div>
						   
						      </div>

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

                                <?php
                                if(isset($data[0]->po_status))
                                        {
                                            if($data[0]->po_status=='Closed')
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
                                 <div class="panel-footer" >
                                    <a href="<?php echo base_url(); ?>index.php/raw_material_in" class="btn btn-danger btn-sm pull-right" type="reset" id="reset">Cancel</a>
                                    <?php $curusr=$this->session->userdata('session_id'); ?>
                                    <div style="<?=$style?>">
                                        <input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Submit For Approval" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_edit=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved' || $data[0]->status=='InActive')) echo ''; else echo 'display: none;';} else if($access[0]->r_insert=='1') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_delete" name="btn_delete" value="Delete" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_delete=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved') && $data[0]->status!='InActive') echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-success btn-sm" id="btn_approve" name="btn_approve" value="Approve" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_reject" name="btn_reject" value="Reject" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
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
            var stock_flag = "<?php if(isset($raw_material_stock)) { echo 1;}else{ echo 0;} ?>"
        </script>
        <script type="text/javascript">
			var newRow1;
            $(document).ready(function(){ 
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
                                        'Other Charges' + 
                                    '</td>' + 
                                    '<td style="display: none;">' + 
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
                                        '<input type="text" class="form-control" name="po_other_charges_amount" id="po_other_charges_amount" placeholder="Othet  Charges" value="<?php if(isset($raw_material_stock[0]->po_other_charges_amount)) { echo $raw_material_stock[0]->po_other_charges_amount ; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td class="" style="text-align:center;">' + 
                                        '&nbsp;' + 
                                    '</td>' + 
                                    '<td>' + 
                                        'Other Charges' + 
                                    '</td>' + 
                                    '<td style="display: none;">' + 
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
                                        '<input type="text" class="form-control" name="other_charges_amount" id="other_charges_amount" placeholder="" value="<?php if (isset($raw_material_stock[0]->other_charges_amt)) { echo $raw_material_stock[0]->other_charges_amt; } ?>"  onchange="get_amount(this)" />' + 
                                    '</td>' +
                                    '<td>' + 
                                        '&nbsp;' + 
                                    '</td>' +
                                '</tr>'+
                                '<tr id="box_row">' + 
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
                                        'Total' + 
                                    '</td>' + 
                                    '<td style="display: none;">' + 
                                        '&nbsp;' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="po_total_amount[]" id="po_total_amount" placeholder="Total Amount" value="" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="po_cgst_amount[]" id="po_cgst_amount" placeholder="CGST Amount" value="" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="po_sgst_amount[]" id="po_sgst_amount" placeholder="SGST Amount" value="" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="po_igst_amount[]" id="po_igst_amount" placeholder="IGST Amount" value="" readonly />' + 
                                    '</td>' + 
                                    
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="final_amount" id="po_final_amount" placeholder="Final Amount" value="" readonly />' + 
                                    '</td>' + 
                                    '<td class="" style="text-align:center;">' + 
                                        '&nbsp;' + 
                                    '</td>' + 
                                    '<td>' + 
                                        'Total' + 
                                    '</td>' + 
                                    '<td style="display: none;">' + 
                                        '&nbsp;' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amt; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="cgst_amount" id="cgst_amount" placeholder="CGST Amount" value="<?php if (isset($data)) { echo $data[0]->cgst_amt; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="sgst_amount" id="sgst_amount" placeholder="SGST Amount" value="<?php if (isset($data)) { echo $data[0]->sgst_amt; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="igst_amount" id="igst_amount" placeholder="IGST Amount" value="<?php if (isset($data)) { echo $data[0]->igst_amt; } ?>" readonly />' + 
                                    '</td>' + 
                                    
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="final_amount" id="final_amount" placeholder="Final Amount" value="<?php if(isset($data)) { echo $data[0]->final_amount; } ?>" readonly />' + 
                                    '</td>' +
                                    '<td>' + 
                                        '&nbsp;' + 
                                    '</td>' +
                                '</tr>');

                $('#raw_material_details').append(newRow1);
                get_po_total();
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
            });

            $(document).ready(function(){
                // $(".qty").blur(function(){
                    // get_amount($(this));
                // });
                // $(".rate").blur(function(){
                    // get_amount($(this));
                // });
                // $("#vat").blur(function(){
                    // get_total();
                // });
                // $("#cst").blur(function(){
                    // get_total();
                // });
                // $("#excise").blur(function(){
                    // get_total();
                // });
				
				 // $(".box").change(function(){
                    // get_box_details($(this));
                // });
				
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });
                // $('#purchase_order_id').click(function(event){
                //     get_purchase_order_details();
                // });
                $('#purchase_order_id').on('change', function() {
                    // alert( this.value ); // or $(this).val()
                    get_purchase_order_details();
                });
                $('#vendor_id').on('change', function() {
                    // alert( this.value ); // or $(this).val()
                    get_purchase_order_nos();
                });
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                
                // get_purchase_order_details();
                // get_depot_details();

                addMultiInputNamingRules('#form_raw_material_in_details', 'select[name="raw_material[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_raw_material_in_details', 'input[name="qty[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_raw_material_in_details', 'input[name="rate[]"]', { required: true }, "");
            });
			
			var get_depot_details = function(){
                // console.log($('#depot_id').val());
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
			
            function get_purchase_order_nos(){
                var vendor_id = $('#vendor_id').val();
                $("#purchase_order_id").html('<option value="">Select</option>');
				
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

                $.ajax({
                    url:BASE_URL+'index.php/Purchase_order/get_purchase_order_nos',
                    method:"post",
                    data:{vendor_id:vendor_id, po_id:$('#po_id').val()},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){

                            var newRow = '<option value="">Select</option>';

                            for(var i=0; i<data.id.length; i++)
							{
                                // newRow = newRow + '<option value="'+data.id[i]+'">'+data.order_date[i]+' - '+data.id[i]+'</option>';
								if(data.po_no[i]!='')
                                    {
                                        newRow = newRow + '<option value="'+data.id[i]+'">'+data.po_no[i]+'</option>';
                                    }
                                    else
                                    {
                                        newRow = newRow + '<option value="'+data.id[i]+'">'+data.order_date[i]+' - '+data.id[i]+'</option>';
                                    }

                            }

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

                get_purchase_order_details();
            }

            function get_purchase_order_details(){
                var purchase_order_id = $('#purchase_order_id').val();

                $.ajax({
                    url:BASE_URL+'index.php/Purchase_order/get_data',
                    method:"post",
                    data:{id:purchase_order_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            // $('#vendor_id').val(data.vendor_id);
                            // $('#depot_id').val(data.depot_id);
                            $('#depot_id').select2('val', data.depot_id);
							// get_depot_details();
                        }
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });

                var other_charges_amount = 0;
                var other_charges_reson = '';
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
                      other_charges_amount = data.other_charges_amount;
                      other_charges_reson = data.other_charges;

                      $('#other_charges_amount').val(other_charges_amount);
                      $('#po_other_charges_amount').val(other_charges_amount);
                            
                    }
                  }
                });

                // console.log('other_charges_amount'+other_charges_amount);
                
                $.ajax({
                    url:BASE_URL+'index.php/Purchase_order/get_purchase_order_items',
                    method:"post",
                    data:{id:purchase_order_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            // $("#raw_material_details > tbody").html("");
                            // $("tbody", "#raw_material_details").remove();
                            $("#raw_material_details").empty();

                            var counter = $('.raw_material').length;
                            for(var i=0; i<data.item_id.length; i++){

                                $('.po_stock').show();
                                var material = data.item_id[i];
                                var newRow = jQuery('<tr id="box_'+counter+'_row">'+
                                                        '<td>'+
                                                            '<select type="hidden" name="raw_material[]" class="form-control raw_material" id="raw_material_selected_'+counter+'" readonly>'+
                                                            '</select><select class="form-control raw_material" id="raw_material_'+counter+'" style="display:none">'+
                                                                '<option value="">Select</option>'+
                                                                '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>'+
                                                                        '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>'+
                                                                '<?php }} ?>'+
                                                            '</select>'+
                                                        '</td>'+
                                                         '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_'+counter+'" placeholder="HSN Code" value="' + data.hsn_code[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control po_qty" name="po_qty[]" id="po_qty_'+counter+'" placeholder="PO Qty" value="' + data.qty[i] + '"  onchange="get_amount(this)" readonly/>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control po_rate" name="po_rate[]" id="po_rate_'+counter+'" placeholder=" PO Rate" value="' + data.rate[i] + '"  readonly/>' + 
                                                            '<input type="hidden" class="form-control po_tax_per" name="po_tax_per[]" id="po_tax_per_'+counter+'" placeholder="Tax %" value="' + data.tax_per[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control po_amount" name="po_amount[]" id="po_amount_'+counter+'" placeholder="PO Amount" value="' + data.amount[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control po_cgst_amt" name="po_cgst_amt[]" id="po_cgst_amt_'+counter+'" placeholder="PO CGST Amount" value="' + data.cgst_amt[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control po_sgst_amt" name="po_sgst_amt[]" id="po_sgst_amt_'+counter+'" placeholder="PO SGST Amount" value="' + data.sgst_amt[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control po_igst_amt" name="po_igst_amt[]" id="po_igst_amt_'+counter+'" placeholder=" PO IGST Amount" value="' + data.igst_amt[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control po_total_amt" name="po_total_amt[]" id="po_total_amt_'+counter+'" placeholder="PO Total Amount" value="' + data.total_amt[i] + '"  readonly/>' + 
                                                            '<input type="hidden" class="form-control po_tax_amt" name="po_tax_amt[]" id="po_tax_amt_'+counter+'" placeholder="Tax Amount" value="' + data.tax_amt[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="' + data.qty[i] + '"  onchange="get_amount(this)" />' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="' + data.rate[i] + '"  onchange="get_amount(this)"/>' + 
                                                            '<input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_'+counter+'" placeholder="Tax %" value="' + data.tax_per[i] + '"  />' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="' + data.amount[i] + '"  onchange="get_amount(this)"/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_'+counter+'" placeholder="CGST Amount" value="' + data.cgst_amt[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_'+counter+'" placeholder="SGST Amount" value="' + data.sgst_amt[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_'+counter+'" placeholder="IGST Amount" value="' + data.igst_amt[i] + '"  readonly/>' + 
                                                        '</td>' + 
                                                        '<td>' + 
                                                            '<input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_'+counter+'" placeholder="Total Amount" value="' + data.total_amt[i] + '"  readonly/>' + 
                                                            '<input type="hidden" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_'+counter+'" placeholder="Tax Amount" value="' + data.tax_amt[i] + '"  />' + 
                                                        '</td>' + 
                                                        '<td style="text-align:center; vertical-align: middle;">' + 
                                                            '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>' + 
                                                        '</td>' + 
                                                        '</tr>');
                                $('#raw_material_details').append(newRow);
                                $("#raw_material_"+counter).val(data.item_id[i]);
                                var raw_material_val = $("#raw_material_"+counter).val();
                                var raw_material_text = $("#raw_material_"+counter+' :selected').text();
                                $("#raw_material_selected_"+counter).append('<option value="'+raw_material_val+'">'+raw_material_text+'</option>')
                                
                                counter++;
                            }                          
							
							$('#raw_material_details').append(newRow1);
					        
                            $('#repeat-raw_material').hide();
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

                            get_po_total();
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
                    var rate = parseFloat(get_number($("#rate_"+index).val(),4));
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
                var depot_state = $("#depot_state").val();
                var vendor_state = $("#vendor_state").val();
                var id = elem.id;
                var index = id.substr(id.lastIndexOf('_')+1);
				
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var rate = parseFloat(get_number($("#rate_"+index).val(),4));
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
                $("#total_amt_"+index).val(total_amt);

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
                final_amount = total_amt + cgst_amount + sgst_amount + igst_amount;

                var other_charges_amount = 0;
                if($('#other_charges_amount').val()!='') {
                    other_charges_amount = parseFloat(get_number($('#other_charges_amount').val(),2));
                }

                final_amount = other_charges_amount+final_amount;

                $("#final_amount").val(format_money(Math.round(final_amount*100)/100,2));
                $("#total_amount").val(format_money(Math.round(total_amt*100)/100,2));
                $("#cgst_amount").val(format_money(Math.round(cgst_amount*100)/100,2));
                $("#sgst_amount").val(format_money(Math.round(sgst_amount*100)/100,2));
                $("#igst_amount").val(format_money(Math.round(igst_amount*100)/100,2));
            }

            function get_po_total(){
                var total_amt = 0;
                $('.po_amount').each(function(){
                    amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amt = total_amt + amount;
                });
                
                var cgst_amount = 0;
                $('.po_cgst_amt').each(function(){
                    cgst_amt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(cgst_amt)) cgst_amt=0;
                    cgst_amount = cgst_amount + cgst_amt;
                });
                
                var sgst_amount = 0;
                $('.po_sgst_amt').each(function(){
                    sgst_amt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(sgst_amt)) sgst_amt=0;
                    sgst_amount = sgst_amount + sgst_amt;
                });

                var igst_amount = 0;
                $('.po_igst_amt').each(function(){
                    igst_amt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(igst_amt)) igst_amt=0;
                    igst_amount = igst_amount + igst_amt;
                });
                
                var tax_amt=0;
                $('.po_tax_amt').each(function(){
                    taxamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(taxamt)) taxamt=0;
                    tax_amt = tax_amt + taxamt;
                });

                var final_amt=0;
                $('.po_final_amt').each(function(){
                    finalamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(finalamt)) finalamt=0;
                    final_amt = final_amt + finalamt;
                });

                $("#po_final_amt").val(final_amt.toFixed(2));
                final_amount = total_amt + cgst_amount + sgst_amount + igst_amount;

                var po_other_charges_amount = 0;
                if($('#po_other_charges_amount').val()!='') {
                    po_other_charges_amount = parseFloat(get_number($('#po_other_charges_amount').val(),2));
                }

                final_amount = po_other_charges_amount+final_amount;

                $("#po_final_amount").val(format_money(Math.round(final_amount*100)/100,2));
                $("#po_total_amount").val(format_money(Math.round(total_amt*100)/100,2));
                $("#po_cgst_amount").val(format_money(Math.round(cgst_amount*100)/100,2));
                $("#po_sgst_amount").val(format_money(Math.round(sgst_amount*100)/100,2));
                $("#po_igst_amount").val(format_money(Math.round(igst_amount*100)/100,2));
            }
           
            jQuery(function(){
                $('#repeat-raw_material').click(function(event){
					var counter = $('.raw_material').length;
                    event.preventDefault();

                    var newRow = jQuery('<tr id="box_'+counter+'_row">'+
                                            '<td>'+
                                                '<select name="raw_material[]" class="form-control raw_material select2" id="raw_material_'+counter+'" onchange="get_raw_material_details(this);">'+
                                                    '<option value="">Select</option>'+
                                                    '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>'+
                                                            '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>'+
                                                    '<?php }} ?>'+
                                                '</select>'+
                                            '</td>'+ 
                                        '<td>' + 
                                            '<input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_'+counter+'" placeholder="HSN Code" value="" readonly />' + 
                                        '</td>' +
                                        '<td>' + 
                                            '<input type="text" class="form-control po_qty" name="po_qty[]" id="po_qty_'+counter+'" placeholder="Qty" value=""  readonly>' + 
                                        '</td>' +
                                        '<td>' + 
                                            '<input type="text" class="form-control po_rate" name="po_rate[]" id="po_rate_'+counter+'" placeholder="Rate" value=" "  readonly/>' +  
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control po_amount" name="po_amount[]" id="po_amount_'+counter+'" placeholder="Amount" value=""  readonly/>' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control po_cgst_amt" name="po_cgst_amt[]" id="po_cgst_amt_'+counter+'" placeholder="CGST Amount" value=""  readonly/>' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control po_sgst_amt" name="po_sgst_amt[]" id="po_sgst_amt_'+counter+'" placeholder="SGST Amount" value=""  readonly/>' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control po_igst_amt" name="po_igst_amt[]" id="po_igst_amt_'+counter+'" placeholder=" IGST Amount" value=""  readonly/>' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control po_total_amt" name="po_total_amt[]" id="po_total_amt_'+counter+'" placeholder="PO Total Amount" value=""  readonly/>' +
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="" onchange="get_amount(this)" />' + 
                                        '</td>' +  
                                        '<td>' + 
                                            '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value=""  onchange="get_amount(this)" />' + 
                                            '<input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_'+counter+'" placeholder="Tax %" value=""  />' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value=""  />' + 
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
                                            '<a id="box_'+counter+'_row_delete" class="delete_row" href="javascript:void(0)"><span class="fa trash fa-trash-o"></span></a>' + 
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
                    // $(".qty").blur(function(){
                        // get_amount($(this));
                    // });
                    // $(".rate").blur(function(){
                        // get_amount($(this));
                    // });
					/*$('.select2').select2();*/
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                        get_total();
                    });
                    counter++;
                });
            });
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>