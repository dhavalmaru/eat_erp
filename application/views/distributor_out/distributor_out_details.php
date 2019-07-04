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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>build/css/bootstrap-datetimepicker.css"/>
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
            @media screen and (max-width:800px) {   
                .h-scroll { overflow-x:scroll;} .h-scroll .table-stripped{ width:806px!important;}
            }
			.form-group
			{
				padding:4px 0px!important;
			}
			#box_details .form-control[disabled], #box_details .form-control[readonly]
			{
				border:none!important;
				background-color:transparent!important;
				box-shadow:none!important;
			}
				#tax_per
			{
				border:none!important;
				background-color:transparent!important;
				box-shadow:none!important;
				font-size:14px;
				font-weight:700;
			}
			#round_off_amount1,#invoice_amount1
			{
				
				font-size:14px;
				font-weight:700;
			}

            .direct{
                display: none;
            }
		</style>
    </head>
    <body>								
         <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/distributor_out'; ?>" >Sales List </a>  &nbsp; &#10095; &nbsp; Sales Details</div>
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">
                      <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">	
                            <form id="form_distributor_out_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) {if(strrpos($data[0]->d_id, 'd_') !== false) echo base_url(). 'index.php/distributor_out/update/' . $data[0]->id; else echo base_url(). 'index.php/distributor_out/save';} else echo base_url().'index.php/distributor_out/save'; ?>">
                             <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
								
								<div class="panel-body">
									<div class="form-group" >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="d_id" id="d_id" value="<?php if(isset($data)) echo $data[0]->d_id;?>"/>
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) {if(strrpos($data[0]->d_id, "d_") !== false) echo $data[0]->id;}?>"/>
                                                <input type="hidden" class="form-control" name="ref_id" id="ref_id" value="<?php if(isset($data)) echo $data[0]->ref_id;?>"/>
                                                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php if(isset($data)) { echo $data[0]->invoice_no; } ?>"/>
                                                 <input type="hidden" name="distributor_in_type" value="<?php if(isset($data[0]->distributor_in_type)) { echo $data[0]->distributor_in_type; } ?>"/>
                                                <input type="text" class="form-control datepicker1" name="date_of_processing" id="date_of_processing" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" >
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="depot_id" id="depot_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { 
                                                            /*if($depot[$k]->id!='1') {*/
                                                    ?>
                                                            <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                    <?php /*}*/}} ?>
                                                </select>
                                                <input type="hidden" class="form-control" name="depot_state" id="depot_state" value="<?php if(isset($data)) { echo  $data[0]->depot_state; } ?>"/>
                                                <!-- <input type="hidden" name="depot_id" id="depot_id" value="<?php //if(isset($data)) { echo $data[0]->depot_id; } ?>"/>
                                                <input type="text" class="form-control load_depot" name="depot" id="depot" placeholder="Type To Select Depot...." value="<?php //if(isset($data)) { echo $data[0]->depot_name; } ?>"/> -->
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="distributor_id" id="distributor_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                            <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) { if($distributor[$k]->id==$data[0]->distributor_id) { echo 'selected'; } } ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <input type="hidden" name="sell_out" id="sell_out" value="<?php if(isset($data)) { if($data[0]->discount!=0) echo $data[0]->discount; /*else echo $data[0]->sell_out;*/ } ?>"/>
                                                <!-- <input type="hidden" name="state" id="state" value="<?php //if(isset($data)) { echo $data[0]->state; } ?>"/> -->
                                                <input type="hidden" name="class" id="class" value="<?php if(isset($data)) { echo $data[0]->class; } ?>"/>
                                                <!-- <input type="hidden" name="distributor_id" id="distributor_id" value="<?php //if(isset($data)) { echo $data[0]->distributor_id; } ?>"/>
                                                <input type="text" class="form-control load_distributor" name="distributor" id="distributor" placeholder="Type To Select Distributor...." value="<?php //if(isset($data)) { echo $data[0]->distributor_name; } ?>"/> -->
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" style="display: none;">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Representative <span class="asterisk_sign">*</span></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
    											<select name="sales_rep_id" id="sales_rep_id" class="form-control select2">
    												<option value="">Select</option>
    												<?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
    														<option value="<?php echo $sales_rep[$k]->id; ?>" <?php if(isset($data)) { if($sales_rep[$k]->id==$data[0]->sales_rep_id) { echo 'selected'; } } ?>><?php echo $sales_rep[$k]->sales_rep_name; ?></option>
    												<?php }} ?>
    											</select>
    											<!-- <input type="hidden" name="sales_rep_id" id="sales_rep_id" value="<?php //if(isset($data)) { echo $data[0]->sales_rep_id; } ?>"/>
    											<input type="text" class="form-control load_sales_rep" name="sales_rep" id="sales_rep" placeholder="Type To Select Sales Representative...." value="<?php //if(isset($data)) { echo $data[0]->sales_rep_name; } ?>"/> -->
    										</div>
										</div>
									</div>
                                    <div class="form-group" style="display:none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div style="display:none;">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor Name <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="text" readonly="true" class="form-control" id="distributor_name" placeholder="Distributor Name" value="<?php if(isset($data)) { echo $data[0]->distributor_name; } ?>"/>
                                                </div>
                                            </div>
                                            <div id="sample_distributor_div">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select name="sample_distributor_id" id="sample_distributor_id" class="form-control select2">
                                                        <option value="">Select</option>
                                                        <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { if(strtoupper(trim($distributor[$k]->distributor_name))!='SAMPLE' && strtoupper(trim($distributor[$k]->distributor_name))!='DIRECT') { ?>
                                                                <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) { if($distributor[$k]->id==$data[0]->sample_distributor_id) { echo 'selected'; } } ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                        <?php }}} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Transportation Type <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="transport_type" id="transport_type" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Hand delivery" <?php if(isset($data)) {if ($data[0]->transport_type=='Hand delivery') echo 'selected';} ?>>Hand delivery</option>
                                                    <option value="Transport" <?php if(isset($data)) {if ($data[0]->transport_type=='Transport') echo 'selected';} ?>>Transport</option>
                                                </select>
                                                <!-- <input type="hidden" name="sales_rep_id" id="sales_rep_id" value="<?php //if(isset($data)) { echo $data[0]->sales_rep_id; } ?>"/>
                                                <input type="text" class="form-control load_sales_rep" name="sales_rep" id="sales_rep" placeholder="Type To Select Sales Representative...." value="<?php //if(isset($data)) { echo $data[0]->sales_rep_name; } ?>"/> -->
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" style="display: none">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Vehicle Number </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="vehicle_number" id="vehicle_number" placeholder="Vehicle Number" value="<?php if (isset($data)) { echo $data[0]->vehicle_number; } ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group direct">
                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Name </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="client_name" id="client_name" placeholder="Name" value="<?php if (isset($data)) { echo $data[0]->client_name; } ?>" />
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group direct">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Address</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php if(isset($data)) echo $data[0]->address;?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group direct">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">City</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" name="city_id" id="city_id" />
                                                <input type="text" class="form-control autocompleteCity" name="city" id ="city" placeholder="City" value="<?php if(isset($data)) { echo  $data[0]->city; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group direct">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Pincode</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="pincode" placeholder="Pincode" value="<?php if (isset($data)) { echo $data[0]->pincode; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group direct">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">State</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" name="state_id" id="state_id" />
                                                <input type="hidden" name="state_code" id="state_code" value="<?php if(isset($data)) { echo  $data[0]->state_code; } ?>" />
                                                <input type="text" class="form-control loadstatedropdown" name="state" id="state" placeholder="State" value="<?php if(isset($data)) { echo  $data[0]->state; } ?>" />
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group direct">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Country</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" name="country_id" id="country_id">
                                                <input type="text" class="form-control loadcountrydropdown" name="country" id="country" placeholder="Country" value="<?php if(isset($data)) { echo  $data[0]->country; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group direct">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mobile No</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" value="<?php if(isset($data)) { echo  $data[0]->mobile_no; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Discount </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="discount" id="discount" placeholder="Discount" value="<?php if(isset($data)) { echo $data[0]->discount; } ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group direct">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">GSTIN </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="gstin" id="gstin" placeholder="GSTIN" value="<?php if(isset($data)) { echo $data[0]->gstin; } ?>" />
                                        </div>
                                    </div>
										
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tax <span class="asterisk_sign">*</span></label>
											<div class="col-md-4  col-sm-4 col-xs-12 option-line-height">
                                                <input type="radio" name="tax"  value="gst" id="tax_gst" disabled="true" data-error="#err_tax" <?php if (isset($data)) { if($data[0]->tax=='gst') echo 'checked'; } ?>/>&nbsp;&nbsp;Gst&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="tax"  value="vat" id="tax_vat" disabled="true" data-error="#err_tax" <?php if (isset($data)) { if($data[0]->tax=='vat') echo 'checked'; } ?>/>&nbsp;&nbsp;Vat&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="tax"  value="cst" id="tax_cst" disabled="true" data-error="#err_tax" <?php if (isset($data)) { if($data[0]->tax=='cst') echo 'checked'; } ?>/>&nbsp;&nbsp;Cst
                                                <div id="err_tax"></div>
                                            </div>
                                            
                                            <div style="display: none">
                                                <label class="col-md-1 col-sm-1 col-xs-12 control-label">Tax (In %) <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-5 col-sm-5 col-xs-12">
                                                    <input type="text" class="form-control" name="tax_per" id="tax_per" placeholder="Tax Percent" value="<?php if (isset($data)) { echo $data[0]->tax_per; } ?>" readonly />
                                                    <input type="hidden" class="form-control" name="cgst" id="cgst" placeholder="cgst" value="<?php if (isset($data)) { echo $data[0]->cgst; } ?>" readonly />
                                                    <input type="hidden" class="form-control" name="sgst" id="sgst" placeholder="sgst" value="<?php if (isset($data)) { echo $data[0]->sgst; } ?>" readonly />
                                                    <input type="hidden" class="form-control" name="igst" id="igst" placeholder="igst" value="<?php if (isset($data)) { echo $data[0]->igst; } ?>" readonly />
                                               </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                	<div class="h-scroll">	
                                       <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px">Type <span class="asterisk_sign">*</span></th>
                                                <th style="width: 250px">Item <span class="asterisk_sign">*</span></th>
                                                <th>Qty <span class="asterisk_sign">*</span></th>
                                                <th>Rate (In Rs) </th>
                                                <th>Sell Rate (In Rs) <span class="asterisk_sign">*</span></th>
                                                <th style="display: none;">Grams</th>
                                                <th>Amount (In Rs)</th>
                                                <th>CGST (In Rs)</th>
                                                <th>SGST (In Rs)</th>
                                                <th>IGST (In Rs)</th>
                                                <th>Tax (In Rs)</th>
                                                <th>Total Amount (In Rupees)</th>
                                                <th class="table_action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                            <?php $i=0; if(isset($distributor_out_items)) {
                                                    for($i=0; $i<count($distributor_out_items); $i++) { ?>
                                                <tr id="box_<?php echo $i; ?>_row">
                                                    <td>
                                                        <select name="type[]" class="form-control type" id="type_<?php echo $i;?>">
                                                            <option value="">Select</option>
                                                            <option value="Bar" <?php if($distributor_out_items[$i]->type=="Bar") { echo 'selected'; } ?>>Bar</option>
                                                            <option value="Box" <?php if($distributor_out_items[$i]->type=="Box") { echo 'selected'; } ?>>Box</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="bar[]" class="form-control bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($distributor_out_items[$i]->type=="Box") { echo 'display: none;'; } ?>">
                                                            <option value="">Select</option>
                                                            <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                    <option value="<?php echo $bar[$k]->id; ?>" <?php if($distributor_out_items[$i]->type=="Bar" && $bar[$k]->id==$distributor_out_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $bar[$k]->product_name; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                        <select name="box[]" class="form-control box" id="box_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($distributor_out_items[$i]->type=="Bar") { echo 'display: none;'; } ?>">
                                                            <option value="">Select</option>
                                                            <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                    <option value="<?php echo $box[$k]->id; ?>" <?php if($distributor_out_items[$i]->type=="Box" && $box[$k]->id==$distributor_out_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $box[$k]->box_name; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                        <div id="err_item_<?php echo $i;?>"></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->qty; } ?>"/>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->rate; } ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="hidden" class="form-control" name="cgst[]" id="cgst_<?php echo $i; ?>" placeholder="cgst" value="0" readonly />
                                                        <input type="hidden" class="form-control" name="sgst[]" id="sgst_<?php echo $i; ?>" placeholder="sgst" value="0" readonly />
                                                        <input type="hidden" class="form-control" name="igst[]" id="igst_<?php echo $i; ?>" placeholder="igst" value="0" readonly />
                                                        <input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_<?php echo $i; ?>" placeholder="tax_per" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->tax_percentage; } ?>"/>
                                                        <input type="hidden" class="form-control sell_margin" name="sell_margin[]" id="sell_margin_<?php echo $i; ?>" placeholder="Sell Margin" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->margin_per; } ?>"/>
                                                        <input type="hidden" class="form-control promo_margin" name="promo_margin[]" id="promo_margin_<?php echo $i; ?>" placeholder="Promotion Margin" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->promo_margin; } ?>"/>
                                                        <input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_<?php echo $i; ?>" placeholder="Sell Rate" value="0" readonly />
                                                    
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="text" class="form-control grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->grams; } ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->amount; } ?>" readonly />
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
                                                        <input type="text" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_<?php echo $i; ?>" placeholder="Tax Amount" value="" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                    </td>
                                                     <td class="table_action" style="text-align:center; vertical-align: middle;">
                                                           <?php  
                                                                $style = '';
                                                                if(isset($data[0]->freezed)){
                                                                    if($data[0]->freezed==1){
                                                                        $style =  'display: none;';
                                                                    }
                                                                }else
                                                                {
                                                                     $style =  'display: block;';
                                                                }
                                                            ?>

                                                        <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  style="<?=$style?>"></span></a>
                                                    </td>
                                                </tr>
                                            <?php }} else { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="type[]" class="form-control type" id="type_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <option value="Bar">Bar</option>
                                                        <option value="Box">Box</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="bar[]" class="form-control bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="">
                                                        <option value="">Select</option>
                                                        <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                <option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->product_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <select name="box[]" class="form-control box" id="box_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="display: none;">
                                                        <option value="">Select</option>
                                                        <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                <option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->box_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="hidden" class="form-control" name="cgst[]" id="cgst_<?php echo $i; ?>" placeholder="cgst" value="0" readonly />
                                                    <input type="hidden" class="form-control" name="sgst[]" id="sgst_<?php echo $i; ?>" placeholder="sgst" value="0" readonly />
                                                    <input type="hidden" class="form-control" name="igst[]" id="igst_<?php echo $i; ?>" placeholder="igst" value="0" readonly />
                                                    <input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_<?php echo $i; ?>" placeholder="tax_per" value="0"/>
                                                    <input type="hidden" class="form-control sell_margin" name="sell_margin[]" id="sell_margin_<?php echo $i; ?>" placeholder="Sell Margin" value="0"/>
                                                    <input type="hidden" class="form-control promo_margin" name="promo_margin[]" id="promo_margin_<?php echo $i; ?>" placeholder="Promotion Margin" value="0"/>
                                                    <input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_<?php echo $i; ?>" placeholder="Sell Rate" value="0" readonly />
                                                
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="" readonly />
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
                                                    <input type="text" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_<?php echo $i; ?>" placeholder="Tax Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_<?php echo $i; ?>" placeholder="Total Amount" value="" readonly />
                                                </td>
                                                <td class="table_action" style="text-align:center; vertical-align: middle;">
                                                    <?php  
                                                        if(isset($data[0]->freezed)){
                                                            if($data[0]->freezed==1){
                                                                $style =  'display: none;';
                                                            }
                                                        }else
                                                            {
                                                                 $style =  'display: block;';
                                                            }
                                                    ?>

                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  style="<?=$style?>"></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="12">
                                                    <button type="button" class="btn btn-success" id="repeat-box"  >+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
									</div>
									
									
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-6 col-sm-6 col-xs-12 control-label"  >Round Off Amount (In Rs)<span class="asterisk_sign">*</span>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="round_off_amount1"> <?php if (isset($data)) { echo $data[0]->round_off_amount; } ?></span></label>
                                          
                                                <input type="hidden" class="form-control" name="round_off_amount" id="round_off_amount" placeholder="Round Off Amount" value="<?php if (isset($data)) { echo $data[0]->round_off_amount; } ?>" readonly />
                                      
                                            <label class="col-md-6 col-sm-6 col-xs-12 control-label" id="">Invoice Amount (In Rs)<span class="asterisk_sign">*</span>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="invoice_amount1">  <?php if (isset($data)) { echo $data[0]->invoice_amount; } ?></span></label>
                                          
                                                <input type="hidden" class="form-control" name="invoice_amount" id="invoice_amount" placeholder="Invoice Amount" value="<?php if (isset($data)) { echo $data[0]->invoice_amount; } ?>" readonly />
										</div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                    
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Due Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="due_date" id="due_date" placeholder="Due Date" value="<?php if(isset($data)) { echo (($data[0]->due_date!=null && $data[0]->due_date!='')? ($data[0]->due_date):''); } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Reverse Charge <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="radio" name="reverse_charge"  value="yes" id="reverse_charge_yes" data-error="#err_reverse_charge" <?php if (isset($data)) { if($data[0]->reverse_charge=='yes') echo 'checked'; } ?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="reverse_charge"  value="no" id="reverse_charge_no" data-error="#err_reverse_charge" <?php if (isset($data)) { if($data[0]->reverse_charge=='no') echo 'checked'; else if($data[0]->reverse_charge!='yes') echo 'checked';} else echo 'checked'; ?>/>&nbsp;&nbsp;No&nbsp;&nbsp;&nbsp;
                                                <div id="err_reverse_charge"></div>
                                            </div>
                                        </div>
                                    </div>
									
									
                                   <!-- <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Round Off Amount (In Rs)<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="round_off_amount" id="round_off_amount" placeholder="Round Off Amount" value="<?php //if (isset($data)) { echo $data[0]->round_off_amount; } ?>" readonly />
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Invoice Amount (In Rs)<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="invoice_amount" id="invoice_amount" placeholder="Invoice Amount" value="<?php //if (isset($data)) { echo $data[0]->invoice_amount; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Due Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="due_date" id="due_date" placeholder="Due Date" value="<?php //if(isset($data)) { echo (($data[0]->due_date!=null && $data[0]->due_date!='')?date('d/m/Y',strtotime($data[0]->due_date)):''); } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Reverse Charge <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="radio" name="reverse_charge"  value="yes" id="reverse_charge_yes" data-error="#err_reverse_charge" <?php //if (isset($data)) { if($data[0]->reverse_charge=='yes') echo 'checked'; } ?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="reverse_charge"  value="no" id="reverse_charge_no" data-error="#err_reverse_charge" <?php //if (isset($data)) { if($data[0]->reverse_charge=='no') echo 'checked'; else if($data[0]->reverse_charge!='yes') echo 'checked';} else echo 'checked'; ?>/>&nbsp;&nbsp;No&nbsp;&nbsp;&nbsp;
                                                <div id="err_reverse_charge"></div>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-3 col-sm-3 col-xs-12 control-label">Shipping Address Same As Billing <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <input type="radio" name="shipping_address"  value="yes" id="shipping_address_yes" data-error="#err_shipping_address" <?php if (isset($data)) { if($data[0]->shipping_address=='yes') echo 'checked'; } else echo 'checked'; ?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="shipping_address"  value="no" id="shipping_address_no" data-error="#err_shipping_address" <?php if (isset($data)) { if($data[0]->shipping_address=='no') echo 'checked'; } ?>/>&nbsp;&nbsp;No&nbsp;&nbsp;&nbsp;
                                                <div id="err_shipping_address"></div>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div id="shipping_address_div" style="<?php if(isset($data)) {if($data[0]->shipping_address=='no') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Shipping Address <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select name="distributor_consignee_id" id="distributor_consignee_id" class="form-control">
                                                        <option value="">Select</option>
                                                        
                                                    </select>
                                                    <input type="hidden" name="distributor_consignee" id="distributor_consignee" value="<?php if(isset($data)) echo $data[0]->distributor_consignee_id; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group" style="display:none;">
                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">CST Amount (In Rs)</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">

                                                <input type="text" class="form-control" name="tax_amount" id="tax_amount" placeholder="CST Amount" value="<?php //if (isset($data)) { echo $data[0]->tax_amount; } ?>" readonly />
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Final Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="final_amount" id="final_amount" placeholder="Final Amount" value="<?php //if(isset($data)) { echo $data[0]->final_amount; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div> -->
									
									
										<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Option of Basis of Sales<span class="asterisk_sign">*</span></label>
													<div class="col-md-4 col-sm-4 col-xs-12">
														<select name="basis_of_sales" id="basis_of_sales" class="form-control select2">
															
														<option value="">Select</option>
														
														<option value="PO Number" <?php if(isset($data)){if($data[0]->basis_of_sales=='PO Number' || $data[0]->order_no!='')  echo 'selected'; } ?>>PO Number</option>
															<option value="Emails" <?php if(isset($data)){if($data[0]->basis_of_sales=='Emails') echo 'selected'; }?>>Emails</option>
														</select>
														
													</div>
												</div>
										</div>
									<br>
                                    <div class="form-group" id="po_num1">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Order No </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No" value="<?php if (isset($data)) { echo $data[0]->order_no; } ?>" />
                                            </div>
										</div>
                                    </div>
									<div class="form-group" id="po_num2">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Order Date </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="order_date" id="order_date" placeholder="Order Date" value="<?php if(isset($data)) { echo (($data[0]->order_date!=null && $data[0]->order_date!='')?date('d/m/Y',strtotime($data[0]->order_date)):''); } ?>" />
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" id="email_body1">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Email from</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="email_from" id="email_from" placeholder="Email from" value="<?php if (isset($data)) { echo $data[0]->email_from; } ?>" />
                                            </div>
										</div>
                                    </div>
									 <div class="form-group"id="email_body2">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Approved By</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="email_approved_by" id="email_approved_by" placeholder="Approved By" value="<?php if (isset($data)) { echo $data[0]->email_approved_by; } ?>" />
                                            </div>
										</div>
                                    </div>
									<div class="form-group" id="email_body3">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Date time of email</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                            
												
												  <input type="text" class="form-control" name="email_date_time" id="email_date_time" placeholder="Order Date" value="<?php if(isset($data)) { echo (($data[0]->email_date_time!=null && $data[0]->email_date_time!='')?date('d/m/y h:i:s A',strtotime($data[0]->email_date_time)):''); } ?>" />
												
                                            </div>
										</div>
                                    </div>					
									
								
									
                                    <!-- <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Supplier Ref </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="supplier_ref" id="supplier_ref" placeholder="Supplier Ref" value="<?php //if (isset($data)) { echo $data[0]->supplier_ref; } ?>" />
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Despatch Doc No </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="despatch_doc_no" id="despatch_doc_no" placeholder="Despatch Doc No" value="<?php //if(isset($data)) { echo $data[0]->despatch_doc_no; } ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Despatch Through </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="despatch_through" id="despatch_through" placeholder="Despatch Through" value="<?php //if (isset($data)) { echo $data[0]->despatch_through; } ?>" />
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Destination </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="destination" id="destination" placeholder="Destination" value="<?php //if(isset($data)) { echo $data[0]->destination; } ?>" />
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="form-group direct">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Payment <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="payment_id" id="payment_id" value="<?php //if(isset($distributor_payment_details[0])) echo $distributor_payment_details[0]->id;?>"/>
                                                <input type="text" class="form-control datepicker1" name="date_of_payment" id="date_of_payment" placeholder="Date" value="<?php //if(isset($distributor_payment_details[0])) echo (($distributor_payment_details[0]->date_of_payment!=null && $distributor_payment_details[0]->date_of_payment!='')?date('d/m/Y',strtotime($distributor_payment_details[0]->date_of_payment)):''); ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="bank_id" id="bank_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php //if(isset($bank)) { for ($k=0; $k < count($bank) ; $k++) { ?>
                                                            <option value="<?php //echo $bank[$k]->id; ?>" <?php //if(isset($distributor_payment_details[0])) { if($bank[$k]->id==$distributor_payment_details[0]->bank_id) { echo 'selected'; } } ?>><?php //echo $bank[$k]->b_name; ?></option>
                                                    <?php //}} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group direct">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Payment Mode <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="payment_mode">
                                                    <option value="">Select</option>
                                                    <option value="Cash" <?php //if(isset($distributor_payment_details[0])) {if ($distributor_payment_details[0]->payment_mode=='Cash') echo 'selected';}?>>Cash</option>
                                                    <option value="Cheque" <?php //if(isset($distributor_payment_details[0])) {if ($distributor_payment_details[0]->payment_mode=='Cheque') echo 'selected';}?>>Cheque</option>
                                                    <option value="NEFT" <?php //if(isset($distributor_payment_details[0])) {if ($distributor_payment_details[0]->payment_mode=='NEFT') echo 'selected';}?>>NEFT</option>
                                                </select>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Ref No </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="ref_no" id="ref_no" placeholder="Ref No" value="<?php //if(isset($distributor_payment_details[0])) { echo $distributor_payment_details[0]->ref_no; } ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group direct">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Payment Amount </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="payment_amount" id="payment_amount" placeholder="Payment Amount" value="<?php //if(isset($distributor_payment_details[0])) { echo $distributor_payment_details[0]->payment_amount; } ?>" />
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Deposit Date </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker1" name="deposit_date" id="deposit_date" placeholder="Deposit Date" value="<?php //if(isset($distributor_payment_details[0])) { echo $distributor_payment_details[0]->deposit_date; } ?>" />
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="form-group" style="<?php if(isset($data)) {if($data[0]->status=='Pending') echo 'display: none;'; else echo '';} else echo 'display: none;';?>">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Delivery Status *</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="delivery_status" id="delivery_status"  style="color:#000;">
                                                    <option value="Pending" <?php if(isset($data)) {if ($data[0]->delivery_status=='Pending') echo 'selected';}?>>Pending</option>
                                                    <option value="GP Issued" <?php if(isset($data)) {if ($data[0]->delivery_status=='GP Issued') echo 'selected';}?>>GP Issued</option>
                                                    <option value="Delivered Not Complete" <?php if(isset($data)) {if ($data[0]->delivery_status=='Delivered Not Complete') echo 'selected';}?>>Delivered Not Complete</option>
                                                    <option value="Delivered" <?php if(isset($data)) {if ($data[0]->delivery_status=='Delivered') echo 'selected';}?>>Delivered</option>
                                                    <option value="Cancelled" <?php if(isset($data)) {if ($data[0]->delivery_status=='Cancelled') echo 'selected';}?>>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
									</div>
											
									<div class="form-group" style="<?php if(isset($data)) {if($data[0]->status=='Pending') echo 'display: none;'; else echo '';} else echo 'display: none;';?>">
										<div class="col-md-12 col-sm-12 col-xs-12">
												<label class="col-md-2 col-sm-2 col-xs-12 control-label">Delivery Date *</label>
												<div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" disabled="true" class="form-control datepicker" name="delivery_date" id="delivery_date" placeholder="Delivery Date" value="<?php if(isset($data)) echo (($data[0]->delivery_date!=null && $data[0]->delivery_date!='')?date('d/m/Y',strtotime($data[0]->delivery_date)):''); ?>" />
												</div>
										</div>
									</div>
                                    <div class="form-group" style="<?php if(isset($data)) {if($data[0]->status=='Pending') echo 'display: none;'; else echo '';} else echo 'display: none;';?>">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div>
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Upload Receivable</label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <div class="col-md-8 col-sm-8 col-xs-12" >
                                                        <input type="hidden" class="form-control" name="receivable_doc" value="<?php if(isset($data)) {echo $data[0]->receivable_doc;} ?>" />
                                                        <input type="file" class="fileinput btn btn-info btn-small" name="receivable_doc_file" id="receivable_doc_file" data-error="#receivable_doc_error"/>
                                                        <div id="receivable_doc_error"></div>
                                                    </div>
                                                    
                                                    <div class="col-md-4 col-sm-4 col-xs-12 download-width"  >
                                                       <?php if(isset($data)) {if($data[0]->receivable_doc!= '') { ?><a target="_blank" id="receivable_doc_file_download" href="<?php echo base_url().$data[0]->receivable_doc; ?>"><span class="fa download fa-download" ></span></a><?php }} ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: none;">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select class="form-control" name="status">
                                                        <option value="Pending" <?php if(isset($data)) {if ($data[0]->status=='Pending') echo 'selected';} ?>>Pending</option>
                                                        <option value="Deleted" <?php if(isset($data)) {if ($data[0]->status=='Deleted') echo 'selected';}?>>Deleted</option>
                                                        <option value="Rejected" <?php if(isset($data)) {if ($data[0]->status=='Rejected') echo 'selected';}?>>Rejected</option>
                                                        <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';} ?>>Approved</option>
                                                        <option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';} ?>>Cancelled</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" <?php if(isset($data)) echo 'style="display:block;"'; else echo 'style="display:none;"';?> >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Invoice Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker1" name="invoice_date" id="invoice_date" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->invoice_date!=null && $data[0]->invoice_date!='')?date('d/m/Y',strtotime($data[0]->invoice_date)):''); else echo ''; ?>"/>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 ">
                                                <textarea class="form-control" id="remarks" name="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
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
                                    if(isset($data[0]->status)) {
                                        if(isset($access)) {
                                            if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) {
                                                if(isset($data[0]->status)) {
                                                    if($data[0]->status=='Deleted') {
                                                        echo '<label class="col-xs-12 control-label" style="color:#cc2127!important">Note : If clicked on approve button this entry will be deleted permanently </label>';
                                                    }    
                                                }     
                                            }
                                        }   
                                    }
                                ?>

                                <?php 
                                    $mismatch = (isset($data[0]->mismatch)?$data[0]->mismatch:'');
                                    $po_status = (isset($data[0]->po_status)?$data[0]->po_status:'');

                                    if($mismatch=='1' || (strtoupper(trim($po_status))!='APPROVED' && strtoupper(trim($po_status))!='')) {
                                        $strmsg = '';
                                        if($mismatch=='1') {
                                            $strmsg = 'Please clear Mismatch PO Entry.';
                                        } else if(strtoupper(trim($po_status))!='APPROVED') {
                                            $strmsg = 'Please Approve PO Entry First.';
                                        }
                                        echo '<label class="col-xs-12 control-label" style="color:#cc2127!important">Note : '.$strmsg.' </label>';
                                    }
                                ?>


                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/distributor_out" class="btn btn-danger pull-right" type="reset" id="reset">Cancel</a>

                                    <!-- <button class="btn btn-success pull-right" style="<?php //if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
                                    <?php $curusr=$this->session->userdata('session_id'); ?>
                                    
                                    <?php if($mismatch!='1' && (strtoupper(trim($po_status))=='APPROVED' || strtoupper(trim($po_status))=='')) { ?>
                                        <input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Submit For Approval" style="<?php if(isset($access)) { if(isset($data)) { if($data[0]->freezed) { echo 'display: none;'; } else { if($access[0]->r_edit=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved' || $data[0]->status=='InActive' || ($data[0]->depot_name=='' && $data[0]->status=='Pending'))) echo ''; else echo 'display: none;'; } } else if($access[0]->r_insert=='1') echo ''; } else echo 'display: none;'; ?>" />
                                        <?php if(isset($data) && $data[0]->freezed!=1) { ?>
                                            <input type="submit" class="btn btn-danger btn-sm" id="btn_delete" name="btn_delete" value="Delete" style="<?php if(isset($access)) { if(isset($data)) {if($access[0]->r_delete=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved' || ($data[0]->depot_name=='' && $data[0]->status=='Pending')) && $data[0]->status!='InActive') echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                        <?php } ?>
                                        <input type="submit" class="btn btn-success btn-sm" id="btn_approve" name="btn_approve" value="Approve" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive' && $data[0]->depot_name!='')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                        <input type="submit" class="btn btn-danger btn-sm" id="btn_reject" formnovalidate="formnovalidate" name="btn_reject" value="Reject" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive' && $data[0]->depot_name!='')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <?php } else {  ?>
                                        <br/><br/>
                                    <?php } ?>

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
            var newRow1;
            $(document).ready(function(){ 
                newRow1 = jQuery('<tr id="box row">' + 
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
                                        'Total' + 
                                    '</td>' + 
                                    '<td style="display: none;">' + 
                                        '&nbsp;' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amount; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="cgst_amount" id="cgst_amount" placeholder="CGST Amount" value="<?php if (isset($data)) { echo $data[0]->cgst_amount; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="sgst_amount" id="sgst_amount" placeholder="SGST Amount" value="<?php if (isset($data)) { echo $data[0]->sgst_amount; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="igst_amount" id="igst_amount" placeholder="IGST Amount" value="<?php if (isset($data)) { echo $data[0]->igst_amount; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="tax_amount" id="tax_amount" placeholder="Tax Amount" value="<?php if (isset($data)) { echo $data[0]->tax_amount; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td>' + 
                                        '<input type="text" class="form-control" name="final_amount" id="final_amount" placeholder="Final Amount" value="<?php if(isset($data)) { echo $data[0]->final_amount; } ?>" readonly />' + 
                                    '</td>' + 
                                    '<td class="table_action" style="text-align:center;">' + 
                                        '&nbsp;' + 
                                    '</td>' + 
                                '</tr>');

                $('#box_details').append(newRow1);
            });

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

                $(".type").change(function(){
                    show_item($(this));
                    // get_product_detail($(this));
					get_sell_rate();
                });
                $(".bar").change(function(){
                    // get_product_detail($(this));
                    get_bar_details($(this));
					get_sell_rate();
                });
                $(".box").change(function(){
                    // get_product_detail($(this));
                    get_box_details($(this));
					get_sell_rate();
                });
                $(".qty").blur(function(){
                    get_amount($(this));
					get_sell_rate();
                });
                $(".sell_rate").blur(function(){
                    get_amount($(this));
					get_sell_rate();
                });
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });
                $('#distributor_id').on('change', function(event){
                    set_distributor_details(true);
                    // $(".rate").each(function(){
                    //     // get_product_detail($(this));
                    //     get_bar_details($(this));
                    //     get_box_details($(this));
                    //     get_sell_rate();
                    // });

                    // $(".type").change(function(){
                    //     show_item($(this));
                    //     // get_product_detail($(this));
                    //     get_sell_rate();
                    // });
                });
                $('#depot_id').on('change', function(event){
                    get_depot_details($('#depot_id').val());
                    get_distributor_details($('#distributor_id').val(), false);
                    // console.log('1');
                    if($('#distributor_consignee_id').val()!='') {
                        get_consignee_details1($('#distributor_consignee_id').val());
                    }
                });
                $('#state').on('change', function(event){
                    get_sell_rate();
                });
				
				$('#city').on('change', function(event){
                    get_sell_rate();
                });

                $('#distributor_consignee_id').on('change', function(event) { 
                    if($('#distributor_consignee_id').val()!='') {
                        get_consignee_details1($('#distributor_consignee_id').val());
                    } else {
                        get_distributor_details($('#distributor_id').val(), false);
                        // console.log('2');
                    }
                    // alert('hi');
                });

                // $('#sample_distributor_id').click(function(event){
                //     get_distributor_details($('#sample_distributor_id').val());
                // });

                $("#discount").change(function(){
                    $('#sell_out').val($("#discount").val());
                    // get_sell_rate();

                    $('.type').each(function(){
                        show_item($(this));
                        // console.log('show_item');
                        // get_product_detail($(this));
                    });
                    get_sell_rate();
                });
                $('input[type=radio][name=tax]').on('change', function() {
                    switch($(this).val()) {
                        case 'gst':
                            /*$('#tax_per').val(5);*/
                            break;
                        case 'vat':
                            /*$('#tax_per').val(6);*/
                            break;
                        case 'cst':
                            /*$('#tax_per').val(2);*/
                            break;
                    }

                    get_sell_rate();
                });
                $('input[type=radio][name=shipping_address]').on('change', function() {
                    if($(this).val()=='no'){
                        $('#shipping_address_div').show();
                        if($('#distributor_consignee_id').val()!='') {
                            get_consignee_details1($('#distributor_consignee_id').val());
                        }
                    } else {
                        get_distributor_details($('#distributor_id').val(), false);
                        // console.log('3');
                        $('#shipping_address_div').hide();
                    }
                });
                
                addMultiInputNamingRules('#form_distributor_out_details', 'select[name="box[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_out_details', 'select[name="bar[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_out_details', 'input[name="qty[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_out_details', 'input[name="sell_rate[]"]', { required: true }, "");

                // get_distributor_details($('#distributor_id').val());
                set_distributor_details(false);

                if($('#distributor_consignee_id').val()!='') {
                    get_consignee_details1($('#distributor_consignee_id').val());
                }

                if($('#distributor_id').val()==1){
                    $('#sample_distributor_div').show();
                } else {
                    $('#sample_distributor_div').hide();
                }

				$('#email_body1').hide();
				$('#email_body2').hide();
				$('#email_body3').hide();
				$('#po_num1').hide();
				$('#po_num2').hide();
				
                if($('#sample_distributor_id').val()!=''){
                    get_distributor_details($('#sample_distributor_id').val());
                    // console.log('4');
                }
				$("#basis_of_sales").change(function(){
					if($('#basis_of_sales').val()=='PO Number' ) {
						$('#email_body1').hide();
						$('#email_body2').hide();
						$('#email_body3').hide();
						$('#po_num1').show();
						$('#po_num2').show();
					} else if($('#basis_of_sales').val()=='Emails' )  {
						$('#email_body1').show();
						$('#email_body2').show();
						$('#email_body3').show();
						$('#po_num1').hide();
						$('#po_num2').hide();
					}
				});				
				
				if($("#basis_of_sales option:selected").val() == 'Emails') {
					$('#email_body1').show();
					$('#email_body2').show();
					$('#email_body3').show();
					$('#po_num1').hide();
					$('#po_num2').hide();
				}
				if($("#basis_of_sales option:selected").val() == 'PO Number') {
					$('#email_body1').hide();
					$('#email_body2').hide();
					$('#email_body3').hide();
					$('#po_num1').show();
					$('#po_num2').show();
				}
                $('#email_date_time').datetimepicker({
					format: 'DD-MM-YYYY hh:mm:ss A',
					defaultDate:new Date()
				});
            });
            
            function get_consignee_details1(distributor_consignee_id) {
                // console.log(distributor_consignee_id);
                $.ajax({
                    url:BASE_URL+'index.php/Distributor/get_shipping_state',
                    method:"post",
                    data:{id:distributor_consignee_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        //if(data.result==1){
                            // console.log(data.state);
                            //alert($('#distributor_id').val());
                            if($('#distributor_id').val()!="214" && $('#distributor_id').val()!="550" && $('#distributor_id').val()!="622" && $('#distributor_id').val()!="626" && $('#distributor_id').val()!="640" && $('#distributor_id').val()!="1299" && $('#distributor_id').val()!="1319" && $('#distributor_id').val()!="1327" && $('#distributor_id').val()!="1352") {
                                // alert($('#distributor_id').val());
                                $('#state').val(data.state);
                                $('#state_code').val(data.state_code);
                            }
                            // alert(data.state);
                            get_sell_rate();

                            // console.log(data.state_code);
                        //}
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });
            }

            function set_distributor_details(set_discount){
                get_distributor_details($('#distributor_id').val(), set_discount);
                
                // console.log('5');

                if($('#distributor_id').val()==1){
                    $('#sample_distributor_div').show();
                } else {
                    $('#sample_distributor_div').hide();
                }

                get_distributor_consignee_details($('#distributor_id').val());
                    
                if($('#distributor_consignee_id').val()!='') {
                    get_consignee_details1($('#distributor_consignee_id').val());
                }
            }

            function show_item(elem){
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                if(elem.val()=="Bar"){
                    $("#bar_"+index).show();
                    $("#box_"+index).hide();
                    get_bar_details($("#bar_"+index));
                } else if(elem.val()=="Box") {
                    $("#box_"+index).show();
                    $("#bar_"+index).hide();
                    get_box_details($("#box_"+index));
                }

                // $("#grams_"+index).val('');
                // $("#rate_"+index).val('');

                // get_total();
            }

            function get_distributor_consignee_details(distributor_id){
                var dist_cons_id = $('#distributor_consignee').val();
                $.ajax({
                    url:BASE_URL+'index.php/distributor_out/get_dist_consignee',
                    method:"post",
                    data:{distributor_id: distributor_id, dist_cons_id: dist_cons_id},
                    dataType:"html",
                    async:false,
                    success: function(data){
                        // if(data!=''){
                        //     $('#distributor_consignee_id').html(data);
                        // } else {
                        //     $('#distributor_consignee_id').html(data);
                        // }

                        $('#distributor_consignee_id').val('');
                        $('#distributor_consignee_id').html(data);
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });
            }

            function get_depot_details(depot_id){
                $.ajax({
                    url:BASE_URL+'index.php/Depot/get_data',
                    method:"post",
                    data:{id:depot_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            $('#depot_state').val(data.state);
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

            function get_distributor_details(distributor_id, set_discount=true){
                // var distributor_id = $('#distributor_id').val();
                var sell_out = 0;

                $.ajax({
                    url:BASE_URL+'index.php/Distributor/get_data',
                    method:"post",
                    data:{id:distributor_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            // console.log('dist change');
                            // console.log(data.sell_out);

                            if(set_discount==true){
                                if(distributor_id==640){
                                    if($("#discount").val()==''){
                                        $("#discount").val(25);
                                        $("#sell_out").val(25);
                                    }
                                } else {
                                    $("#discount").val(data.sell_out);
                                    $("#sell_out").val(data.sell_out);
                                }
                            }
                            
                            // if(distributor_id==42 || distributor_id==214 || distributor_id==550 || distributor_id==622 || distributor_id==626 || distributor_id==640 || distributor_id==1299 || distributor_id==1319 || distributor_id==1327 || distributor_id==1352){
                            //     $('#sell_out').val($("#discount").val());
                            // } else {
                            //     $('#sell_out').val(data.sell_out);
                            // }

                            if($('#distributor_id').val()!=""){
                                $('#distributor_name').val(data.product_name);
                            }

                            if($('#distributor_id').val()!="214" && $('#distributor_id').val()!="550" && $('#distributor_id').val()!="622" && $('#distributor_id').val()!="626" && $('#distributor_id').val()!="640" && $('#distributor_id').val()!="1299" && $('#distributor_id').val()!="1319" && $('#distributor_id').val()!="1327" && $('#distributor_id').val()!="1352") {
                                $('#state').val(data.state);
                                $('#state_code').val(data.state_code);
                            }
                            $('#class').val(data.class);
                            $('#sales_rep_id').val(data.sales_rep_id);
                            $('#sales_rep_id').trigger('change');
                            // $("#sales_rep_id").select2("val", data.sales_rep_id);

                            var credit_period = data.credit_period;
                            if (credit_period==null || isNaN(credit_period)) credit_period=1;
                            var due_date = new Date();
                            due_date.setDate(due_date.getDate() + parseInt(credit_period));

                            var day = due_date.getDate();
                            var month = due_date.getMonth()+1;
                            var year = due_date.getFullYear();
                            if(day.toString().length==1){
                                day='0'+day.toString();
                            }
                            if(month.toString().length==1){
                                month='0'+month.toString();
                            }
                            $('#due_date').val(day + '/' + month + '/' + year);

                            sell_out = parseFloat($('#sell_out').val());
                            if (isNaN(sell_out)) sell_out=0;

                            var tax_per = 0;
                            // if($.trim($('#class').val()).toUpperCase()=="SAMPLE"){
                            //     $('#tax_vat').prop('checked', false);
                            //     $('#tax_cst').prop('checked', false);
                            //     tax_per = 0;
                            // } else if($.trim($('#state').val()).toUpperCase()=="MAHARASHTRA"){
                            //     $('#tax_vat').prop('checked', true);
                            //     $('#tax_cst').prop('checked', false);
                            //     tax_per = 6;
                            // } else {
                            //     $('#tax_vat').prop('checked', false);
                            //     $('#tax_cst').prop('checked', true);
                            //     tax_per = 2;
                            // }

                            $('#tax_gst').prop('checked', true);
                            $('#tax_vat').prop('checked', false);
                            $('#tax_cst').prop('checked', false);

                            tax_per = 5;

                            $('#tax_per').val(tax_per);

                            // get_sell_rate();

                            // console.log('distributor_id_change');

                            $('.type').each(function(){
                                show_item($(this));
                                // console.log('show_item');
                                // get_product_detail($(this));
                            });
                            get_sell_rate();
                        }
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });

                if(distributor_id==42 || distributor_id==214 || distributor_id==550 || distributor_id==622 || distributor_id==626 || distributor_id==640 || distributor_id==1299 || distributor_id==1319 || distributor_id==1327 || distributor_id==1352){
                    $('.direct').show();
                } else {
                    $('.direct').hide();
                }
            }

            function get_sell_rate(){
                var depot_state = $("#depot_state").val();
                var state = $("#state").val();

                $('.rate').each(function(){
                    var elem = $(this);
                    var id = elem.attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var sell_out = 0;
                    // if(distributor_id==42 || distributor_id==214 || distributor_id==550 || distributor_id==622 || distributor_id==626 || distributor_id==640 || distributor_id==1299 || distributor_id==1319 || distributor_id==1327 || distributor_id==1352){
                    //     sell_out = parseFloat($('#sell_out').val());
                    // } else {
                    //     sell_out = parseFloat(get_number($("#sell_margin_"+index).val(),2));
                    // }
                    sell_out = parseFloat(get_number($("#sell_margin_"+index).val(),2));
                    var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                    var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                    var cgst = 0;
                    var sgst = 0;
                    var igst = 0;
                    var tax_per = parseFloat(get_number($("#tax_per_"+index).val(),2));
                    if(depot_state==state){
                        cgst = parseFloat(tax_per/2,2);
                        sgst = parseFloat(tax_per/2,2);
                    } else {
                        igst = tax_per;
                    }
                    $("#cgst_"+index).val(cgst);
                    $("#sgst_"+index).val(sgst);
                    $("#igst_"+index).val(igst);   

                    if (isNaN(qty)) qty=0;
                    if (isNaN(rate)) rate=0;
                    if (isNaN(sell_out)) sell_out=0;

                    sell_out = sell_out + parseFloat(get_number($("#sell_out").val(),2));
                    if (isNaN(sell_out)) sell_out=0;

                    var sell_rate = rate-((rate*sell_out)/100);
                    sell_rate = sell_rate/(100+tax_per)*100;
                    if (isNaN(sell_rate)) sell_rate=0;

                    if (isNaN(cgst)) cgst=0;
                    if (isNaN(sgst)) sgst=0;
                    if (isNaN(igst)) igst=0;
                    if (isNaN(tax_per)) tax_per=0;

                    var cgst_amt = Math.round(qty*((sell_rate*cgst)/100)*100)/100;
                    var sgst_amt = Math.round(qty*((sell_rate*sgst)/100)*100)/100;
                    var igst_amt = Math.round(qty*((sell_rate*igst)/100)*100)/100;
                    // var tax_amt = Math.round(qty*((sell_rate*tax_per)/100)*100)/100;
                    var tax_amt = cgst_amt+sgst_amt+igst_amt;
                    
                    if (isNaN(cgst_amt)) cgst_amt=0;
                    if (isNaN(sgst_amt)) sgst_amt=0;
                    if (isNaN(igst_amt)) igst_amt=0;
                    if (isNaN(tax_amt)) tax_amt=0;

                    var amount = Math.round(qty*sell_rate*100)/100;
                    var total_amount = Math.round((parseFloat(amount,2) + parseFloat(tax_amt,2))*100)/100;

                    $("#sell_rate_"+index).val(Math.round(sell_rate*10000)/10000);
                    $("#amount_"+index).val(amount.toFixed(2));
                    $("#cgst_amt_"+index).val(cgst_amt.toFixed(2));
                    $("#sgst_amt_"+index).val(sgst_amt.toFixed(2));
                    $("#igst_amt_"+index).val(igst_amt.toFixed(2));
                    $("#tax_amt_"+index).val(tax_amt.toFixed(2));
                    $("#total_amt_"+index).val(total_amount.toFixed(2));
                });

                get_total();
            }

            function get_bar_details(elem){
                var box_id = elem.val();
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var sell_out = 0;
                // if(distributor_id==42 || distributor_id==214 || distributor_id==550 || distributor_id==622 || distributor_id==626 || distributor_id==640 || distributor_id==1299 || distributor_id==1319 || distributor_id==1327 || distributor_id==1352){
                //     sell_out = parseFloat($('#sell_out').val());
                // } else {
                //     sell_out = parseFloat(get_number($("#sell_margin_"+index).val(),2));
                // }
                sell_out = parseFloat(get_number($("#sell_margin_"+index).val(),2));
                if (isNaN(sell_out)) sell_out=0;

                var pro_margin = 0;
                pro_margin = parseFloat(get_number($("#promo_margin_"+index).val(),2));
                if (isNaN(pro_margin)) pro_margin=0;

                var tax_per = parseFloat(get_number($("#tax_per_"+index).val(),2));
                var distributor_id = $("#distributor_id").val();
                var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                var grams = parseFloat(get_number($("#grams_"+index).val(),2));

                $.ajax({
                    url:BASE_URL+'index.php/distributor_out/get_product_details',
                    method:"post",
                    data:{id:box_id, distributor_id:distributor_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams = parseFloat(data.grams);
                            rate = parseFloat(data.rate);
                            // if(distributor_id==42 || distributor_id==214 || distributor_id==550 || distributor_id==622 || distributor_id==626 || distributor_id==640 || distributor_id==1299 || distributor_id==1319 || distributor_id==1327 || distributor_id==1352){
                            //     sell_out = parseFloat($('#sell_out').val());
                            // } else {
                            //     sell_out = parseFloat(data.inv_margin);
                            // }
                            sell_out = parseFloat(data.inv_margin);
                            tax_per = parseFloat(data.tax_percentage);
                            pro_margin = parseFloat(data.pro_margin);
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
                if (isNaN(grams)) grams=0;
                if (isNaN(rate)) rate=0;
                if (isNaN(sell_out)) sell_out=0;
                if (isNaN(tax_per)) tax_per=0;
                if (isNaN(pro_margin)) pro_margin=0;

                var discount = parseFloat(get_number($("#sell_out").val(),2));
                if (isNaN(discount)) discount=0;

                var cgst = $("#cgst_"+index).val();
                var sgst = $("#sgst_"+index).val();
                var igst = $("#igst_"+index).val();

                var sell_rate = rate-((rate*(sell_out+discount))/100);
                sell_rate = sell_rate/(100+tax_per)*100;

                // console.log(sell_rate);

                var cgst_amt = Math.round(qty*((sell_rate*cgst)/100)*100)/100;
                var sgst_amt = Math.round(qty*((sell_rate*sgst)/100)*100)/100;
                var igst_amt = Math.round(qty*((sell_rate*igst)/100)*100)/100;
                // var tax_amt = Math.round(qty*((sell_rate*tax_per)/100)*100)/100;
                var tax_amt = cgst_amt+sgst_amt+igst_amt;
                
                if (isNaN(cgst_amt)) cgst_amt=0;
                if (isNaN(sgst_amt)) sgst_amt=0;
                if (isNaN(igst_amt)) igst_amt=0;
                if (isNaN(tax_amt)) tax_amt=0;

                var amount = Math.round(qty*sell_rate*100)/100;
                var total_amount = Math.round((parseFloat(amount,2) + parseFloat(tax_amt,2))*100)/100;

                $("#grams_"+index).val(grams);
                $("#rate_"+index).val(rate);
                $("#sell_margin_"+index).val(sell_out);
                $("#promo_margin_"+index).val(pro_margin);
                $("#tax_per_"+index).val(tax_per);
                $("#sell_rate_"+index).val(Math.round(sell_rate*10000)/10000);
                $("#amount_"+index).val(amount.toFixed(2));
                $("#cgst_amt_"+index).val(cgst_amt.toFixed(2));
                $("#sgst_amt_"+index).val(sgst_amt.toFixed(2));
                $("#igst_amt_"+index).val(igst_amt.toFixed(2));
                $("#tax_amt_"+index).val(tax_amt.toFixed(2));
                $("#total_amt_"+index).val(total_amount.toFixed(2));

                get_total();
            }

            function get_box_details(elem){
                var box_id = elem.val();
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var sell_out = 0;
                // if(distributor_id==42 || distributor_id==214 || distributor_id==550 || distributor_id==622 || distributor_id==626 || distributor_id==640 || distributor_id==1299 || distributor_id==1319 || distributor_id==1327 || distributor_id==1352){
                //     sell_out = parseFloat($('#sell_out').val());
                // } else {
                //     sell_out = parseFloat(get_number($("#sell_margin_"+index).val(),2));
                // }
                sell_out = parseFloat(get_number($("#sell_margin_"+index).val(),2));
                var pro_margin = parseFloat(get_number($("#promo_margin_"+index).val(),2));

                var tax_per = parseFloat(get_number($("#tax_per_"+index).val(),2));
                var distributor_id = $("#distributor_id").val();
                var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                var grams = parseFloat(get_number($("#grams_"+index).val(),2));
                
                $.ajax({
                    url:BASE_URL+'index.php/distributor_out/get_box_details',
                    method:"post",
                    data:{id:box_id, distributor_id:distributor_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams = parseFloat(data.grams);
                            rate = parseFloat(data.rate);
                            // if(distributor_id==42 || distributor_id==214 || distributor_id==550 || distributor_id==622 || distributor_id==626 || distributor_id==640 || distributor_id==1299 || distributor_id==1319 || distributor_id==1327 || distributor_id==1352){
                            //     sell_out = parseFloat($('#sell_out').val());
                            // } else {
                            //     sell_out = parseFloat(data.inv_margin);
                            // }
                            sell_out = parseFloat(data.inv_margin);
                            tax_per = parseFloat(data.tax_percentage);
                            pro_margin = parseFloat(data.pro_margin);
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
                if (isNaN(grams)) grams=0;
                if (isNaN(rate)) rate=0;
                if (isNaN(sell_out)) sell_out=0;
                if (isNaN(tax_per)) tax_per=0;
                if (isNaN(pro_margin)) pro_margin=0;

                var discount = parseFloat(get_number($("#sell_out").val(),2));
                if (isNaN(discount)) discount=0;

                var cgst = $("#cgst_"+index).val();
                var sgst = $("#sgst_"+index).val();
                var igst = $("#igst_"+index).val();

                var sell_rate = rate-((rate*(sell_out+discount))/100);
                sell_rate = sell_rate/(100+tax_per)*100;

                var cgst_amt = Math.round(qty*((sell_rate*cgst)/100)*100)/100;
                var sgst_amt = Math.round(qty*((sell_rate*sgst)/100)*100)/100;
                var igst_amt = Math.round(qty*((sell_rate*igst)/100)*100)/100;
                // var tax_amt = Math.round(qty*((sell_rate*tax_per)/100)*100)/100;
                var tax_amt = cgst_amt+sgst_amt+igst_amt;
                
                if (isNaN(cgst_amt)) cgst_amt=0;
                if (isNaN(sgst_amt)) sgst_amt=0;
                if (isNaN(igst_amt)) igst_amt=0;
                if (isNaN(tax_amt)) tax_amt=0;

                var amount = Math.round((qty*sell_rate)*100)/100;
                var total_amount = Math.round((parseFloat(amount,2) + parseFloat(tax_amt,2))*100)/100;

                $("#grams_"+index).val(grams);
                $("#rate_"+index).val(rate);
                $("#sell_margin_"+index).val(sell_out);
                $("#promo_margin_"+index).val(pro_margin);
                $("#tax_per_"+index).val(tax_per);
                $("#sell_rate_"+index).val(Math.round(sell_rate*10000)/10000);
                $("#amount_"+index).val(amount.toFixed(2));
                $("#cgst_amt_"+index).val(cgst_amt.toFixed(2));
                $("#sgst_amt_"+index).val(sgst_amt.toFixed(2));
                $("#igst_amt_"+index).val(igst_amt.toFixed(2));
                $("#tax_amt_"+index).val(tax_amt.toFixed(2));
                $("#total_amt_"+index).val(total_amount.toFixed(2));

                get_total();
            }

            // function get_product_detail(elem) {
            //     /*alert('entered');*/
            //     var box_id = elem.val();
            //     var id = elem.attr('id');
            //     var index = id.substr(id.lastIndexOf('_')+1);
            //     var box = box_id;
            //     var distributor_id = $("#distributor_id").val();  
            //     if(distributor_id!="") {
            //         $.ajax({
            //             url:BASE_URL+'index.php/Distributor_out/get_product_percentage/'+box+'/'+distributor_id,
            //             method:"GET",
            //             dataType:"json",
            //             async:false,
            //             success: function(data){
            //                 if(data!=0)
            //                 {
            //                     var obj = data;
            //                     var margin = parseFloat(obj.inv_margin);
            //                     /*alert(margin);*/
            //                     $('#sell_margin_'+index).val(margin);
            //                     var tax_percentage = parseFloat(obj.tax_percentage);
            //                     $('#tax_per_'+index).val(tax_percentage);  
            //                 }
            //             },
            //             error: function (response) {
            //                 var r = jQuery.parseJSON(response.responseText);
            //                 alert("Message: " + r.Message);
            //                 alert("StackTrace: " + r.StackTrace);
            //                 alert("ExceptionType: " + r.ExceptionType);
            //             }
            //         });
            //     }  
            // }

            function get_amount(elem){
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var sell_rate = parseFloat(get_number($("#sell_rate_"+index).val(),2));
                var tax_per = parseFloat(get_number($("#tax_per_"+index).val(),2));
                var cgst = parseFloat(get_number($("#cgst_"+index).val(),2));
                var sgst = parseFloat(get_number($("#sgst_"+index).val(),2));
                var igst = parseFloat(get_number($("#igst_"+index).val(),2));
                var amount = qty*sell_rate;
                var cgst_amt = Math.round((amount*cgst)*100)/100;
                var sgst_amt = Math.round((amount*sgst)*100)/100;
                var igst_amt = Math.round((amount*igst)*100)/100;
                // var tax_amt = Math.round((amount*tax_per)*100)/100;
                var tax_amt = cgst_amt+sgst_amt+igst_amt;

                $("#amount_"+index).val(amount.toFixed(2));
                $("#cgst_amt_"+index).val((cgst_amt).toFixed(2));
                $("#sgst_amt_"+index).val((sgst_amt).toFixed(2));
                $("#igst_amt_"+index).val((igst_amt).toFixed(2));
                $("#tax_amt_"+index).val((tax_amt).toFixed(2));

                var total_amt = Math.round((tax_amt+amount)*100)/100;
                $("#total_amt_"+index).val((total_amt).toFixed(2));

                get_total();
            }

            function get_total(){
                var total_amount = 0;
                var cgst_amt=0;
                var sgst_amt=0;
                var igst_amt=0;
                var tax_amt=0;
                var final_amt=0;
                var sell_out=0;

                $('.amount').each(function(){
                    amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amount = total_amount + amount;
                });

                $('.cgst_amt').each(function(){
                    cgstamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(cgstamt)) cgstamt=0;
                    cgst_amt = cgst_amt + cgstamt;
                });

                $('.sgst_amt').each(function(){
                    sgstamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(sgstamt)) sgstamt=0;
                    sgst_amt = sgst_amt + sgstamt;
                });

                $('.igst_amt').each(function(){
                    igstamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(igstamt)) igstamt=0;
                    igst_amt = igst_amt + igstamt;
                });

                $('.tax_amt').each(function(){
                    taxamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(taxamt)) taxamt=0;
                    tax_amt = tax_amt + taxamt;
                });

                $('.total_amt').each(function(){
                    finalamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(finalamt)) finalamt=0;
                    final_amt = final_amt + finalamt;
                });

                // var tax_per = 0;
                // if($.trim($('#state').val()).toUpperCase()=="MAHARASHTRA"){
                //     tax_per = 6;
                // } else {
                //     tax_per = 2;
                // }

                // var tax_per = parseFloat(get_number($('#tax_per').val(),2));

                // var tax_amount = total_amount*tax_per/100;
                // var final_amount = total_amount + tax_amount;

                // sell_out = $('#sell_out').val();
                // if (isNaN(sell_out)) sell_out=0;
                // final_amt = final_amt-((final_amt*sell_out)/100);
                // if (isNaN(final_amt)) final_amt=0;

                $("#total_amount").val(total_amount.toFixed(2));
                $("#cgst_amount").val(cgst_amt.toFixed(2));
                $("#sgst_amount").val(sgst_amt.toFixed(2));
                $("#igst_amount").val(igst_amt.toFixed(2));
                $("#tax_amount").val(tax_amt.toFixed(2));
                $("#final_amount").val(final_amt.toFixed(2));

                var round_off_amt = Math.round(final_amt) - (Math.round(final_amt*100)/100);

                $("#round_off_amount").val(round_off_amt.toFixed(2));
                $("#invoice_amount").val(final_amt.toFixed(0));
				$("#round_off_amount1").text(round_off_amt.toFixed(2));
                $("#invoice_amount1").text(final_amt.toFixed(0));
            }

            $(document).ready(function(){
                $.each($('.cgst_amt'), function(i, item) {
                    var amount =  $('#amount_'+i).val();
                    var cgst = parseFloat($('#cgst_'+i).val());
                    var cgst_amt = parseFloat(amount*cgst/100);
                    if(cgst_amt==0 || isNaN(cgst_amt)) {
                        $('#cgst_amt_'+i).val(0);    
                    }
                    else {
                        $('#cgst_amt_'+i).val(cgst_amt.toFixed(2));
                    }
                    // alert(tax_per);
                });
                $.each($('.sgst_amt'), function(i, item) {
                    var amount =  $('#amount_'+i).val();
                    var sgst = parseFloat($('#sgst_'+i).val());
                    var sgst_amt = parseFloat(amount*sgst/100);
                    if(sgst_amt==0 || isNaN(sgst_amt)) {
                        $('#sgst_amt_'+i).val(0);    
                    }
                    else {
                        $('#sgst_amt_'+i).val(sgst_amt.toFixed(2));
                    }
                    // alert(tax_per);
                });
                $.each($('.igst_amt'), function(i, item) {
                    var amount =  $('#amount_'+i).val();
                    var igst = parseFloat($('#igst_'+i).val());
                    var igst_amt = parseFloat(amount*igst/100);
                    if(igst_amt==0 || isNaN(igst_amt)) {
                        $('#igst_amt_'+i).val(0);    
                    }
                    else {
                        $('#igst_amt_'+i).val(igst_amt.toFixed(2));
                    }
                    // alert(tax_per);
                });
                $.each($('.tax_amt'), function(i, item) {
                    var amount =  $('#amount_'+i).val();
                    var tax_per = parseFloat($('#tax_per_'+i).val());
                    // var tax_amt = parseFloat(amount*tax_per/100);
                    var tax_amt = parseFloat($('#cgst_amt_'+i).val())+parseFloat($('#sgst_amt_'+i).val())+parseFloat($('#igst_amt_'+i).val());
                    
                    if(tax_amt==0 || isNaN(tax_amt)) {
                        $('#tax_amt_'+i).val(0);    
                    }
                    else {
                        $('#tax_amt_'+i).val(tax_amt.toFixed(2));
                    }
                    // alert(tax_per);
                });
                $.each($('.total_amt'), function(i, item) {
                    var amount =  parseFloat($('#amount_'+i).val());
                    var tax_amt = parseFloat($('#tax_amt_'+i).val());
                    var totamt1=parseFloat(amount+tax_amt);

                    if(isNaN(totamt1) || totamt1==0) {
                        totamt1=0;
                        $('#total_amt_'+i).val(totamt1);
                    }
                    else {
                        $('#total_amt_'+i).val(totamt1.toFixed(2));
                    }
                    // alert(totamt1);
                });
            });

            jQuery(function(){
                var counter = $('.box').length;
                
                $('#repeat-box').click(function(event){
                    event.preventDefault();
                    //$('#box_details').remove(newRow1);
                    var newRow = jQuery('<tr id="box_'+counter+'_row">' + 
                                            '<td>' + 
                                                '<select name="type[]" class="form-control type" id="type_'+counter+'">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<option value="Bar">Bar</option>' + 
                                                    '<option value="Box">Box</option>' + 
                                                '</select>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<select name="bar[]" class="form-control bar" id="bar_'+counter+'" data-error="#err_item_'+counter+'" style="">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->product_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<select name="box[]" class="form-control box" id="box_'+counter+'" data-error="#err_item_'+counter+'" style="display: none;">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->box_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<div id="err_item_'+counter+'"></div>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value=""/>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="hidden" class="form-control" name="cgst[]" id="cgst_'+counter+'" placeholder="cgst" value="0" readonly />' + 
                                                '<input type="hidden" class="form-control" name="sgst[]" id="sgst_'+counter+'" placeholder="sgst" value="0" readonly />' + 
                                                '<input type="hidden" class="form-control" name="igst[]" id="igst_'+counter+'" placeholder="igst" value="0" readonly />' + 
                                                '<input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_'+counter+'" placeholder="tax_per" value="0"/>' + 
                                                '<input type="hidden" class="form-control sell_margin" name="sell_margin[]" id="sell_margin_'+counter+'" placeholder="Sell Margin" value="0"/>' + 
                                                '<input type="hidden" class="form-control promo_margin" name="promo_margin[]" id="promo_margin_'+counter+'" placeholder="Promotion Margin" value="0"/>' + 
                                                '<input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_'+counter+'" placeholder="Sell Rate" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control grams" name="grams[]" id="grams_'+counter+'" placeholder="Grams" value="" readonly />' + 
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
                                                '<input type="text" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_'+counter+'" placeholder="VAT" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_'+counter+'" placeholder="Total Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="text-align:center;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#box_details').append(newRow);
                    $('#box_details').append(newRow1);
                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    $(".type").change(function(){
                        show_item($(this));
						get_sell_rate();
                    });
                    $(".bar").change(function(){
                        /*alert('eneterd');*/
                        // get_product_detail($(this));
                        get_bar_details($(this));
						get_sell_rate();
                    });
                    $(".box").change(function(){
                        // get_product_detail($(this));
                        get_box_details($(this));
						get_sell_rate();
                    });
                    $(".qty").blur(function(){
                        get_amount($(this));
						get_sell_rate();
                    });
                    $(".sell_rate").blur(function(){
                        get_amount($(this));
						get_sell_rate();
                    });
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                        get_total();
                    });
                    counter++;
                });
            });
        </script>
    </body>
</html>