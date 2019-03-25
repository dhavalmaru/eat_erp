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
            input[readonly], input[disabled], select[disabled], textarea[disabled], textarea[readonly] {
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
  
		</style>
		
    </head>
    <body>								
         <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->

			<?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sample_out'; ?>" >Sample List </a>  &nbsp; &#10095; &nbsp; Sample Details</div>
                <!-- PAGE CONTENT WRAPPER -->
                <?php
                    /*echo "<br>";
                    print_r($data);
                    echo "</br>";*/
                ?>
                   <div class="page-content-wrap">
                      <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">	
                            <form id="form_distributor_out_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) {if(strrpos($data[0]->d_id, 'd_') !== false) echo base_url(). 'index.php/sample_out/update/' . $data[0]->id; else echo base_url(). 'index.php/sample_out/save';} else echo base_url().'index.php/sample_out/save'; ?>">
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
                                                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php if(isset($data)) { echo $data[0]->invoice_no; } ?>"/>
                                                <input type="hidden" name="voucher_no" id="voucher_no" value="<?php if(isset($data)) { echo $data[0]->voucher_no; } ?>"/>
                                                <input type="text" class="form-control datepicker1" name="date_of_processing" id="date_of_processing" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" >
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="depot_id" id="depot_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { ?>
                                                            <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <!-- <input type="hidden" name="depot_id" id="depot_id" value="<?php //if(isset($data)) { echo $data[0]->depot_id; } ?>"/>
                                                <input type="text" class="form-control load_depot" name="depot" id="depot" placeholder="Type To Select Depot...." value="<?php //if(isset($data)) { echo $data[0]->depot_name; } ?>"/> -->
                                            </div>
										</div>
									</div>
                                    <div class="form-group" style="display:none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="distributor_id" id="distributor_id" class="form-control">
                                                    
                                                    <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                            <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) { if($distributor[$k]->id==$data[0]->distributor_id) { echo 'selected'; } } ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <input type="hidden" name="sell_out" id="sell_out" value="<?php if(isset($data)) { echo $data[0]->sell_out; } ?>"/>
                                                 <input type="hidden" class="form-control" name="ref_id" id="ref_id" value="<?php if(isset($data)) echo $data[0]->ref_id;?>"/>
                                                <!-- <input type="hidden" name="state" id="state" value="<?php //if(isset($data)) { echo $data[0]->state; } ?>"/> -->
                                                <input type="hidden" name="class" id="class" value="<?php if(isset($data)) { echo $data[0]->class; } ?>"/>
                                                <!-- <input type="hidden" name="distributor_id" id="distributor_id" value="<?php //if(isset($data)) { echo $data[0]->distributor_id; } ?>"/>
                                                <input type="text" class="form-control load_distributor" name="distributor" id="distributor" placeholder="Type To Select Distributor...." value="<?php //if(isset($data)) { echo $data[0]->distributor_name; } ?>"/> -->
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" style="display:none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" readonly="true" class="form-control" id="distributor_name" placeholder="Distributor Name" value="<?php if(isset($data)) { echo $data[0]->distributor_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Representative <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="sales_rep_id" id="sales_rep_id" class="form-control">
                                                    <option value="" >Select</option>
                                                    <?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
                                                            <option value="<?php echo $sales_rep[$k]->id; ?>" <?php if(isset($data)) { if($sales_rep[$k]->id==$data[0]->sales_rep_id) { echo 'selected'; } } ?>><?php echo $sales_rep[$k]->sales_rep_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <!-- <input type="hidden" name="sales_rep_id" id="sales_rep_id" value="<?php //if(isset($data)) { echo $data[0]->sales_rep_id; } ?>"/>
                                                <input type="text" class="form-control load_sales_rep" name="sales_rep" id="sales_rep" placeholder="Type To Select Sales Representative...." value="<?php //if(isset($data)) { echo $data[0]->sales_rep_name; } ?>"/> -->
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" id="sample_distributor_div">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                         
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select name="sample_distributor_id" id="sample_distributor_id" class="form-control">
                                                        <option value="">Select</option>
                                                        <?php if(isset($distributor1)) { for ($k=0; $k < count($distributor1) ; $k++) { if(strtoupper(trim($distributor1[$k]->distributor_name))!='SAMPLE' && strtoupper(trim($distributor1[$k]->distributor_name))!='DIRECT') { ?>
                                                                <option value="<?php echo $distributor1[$k]->id; ?>" <?php if(isset($data)) { if($distributor1[$k]->id==$data[0]->sample_distributor_id) { echo 'selected'; } } ?>><?php echo $distributor1[$k]->distributor_name; ?></option>
                                                        <?php }}} ?>
                                                    </select>
                                                </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group" >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Type *</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<select class="form-control" name="sample_type" id="sample_type">
                                                <option value="">Select</option>
                                                <option value="Gifting" <?php if(isset($data)) {if ($data[0]->sample_type=='Gifting') echo 'selected';}?>>Gifting</option>
                                                <option value="Promoter" <?php if(isset($data)) {if ($data[0]->sample_type=='Promoter') echo 'selected';}?>>Promoter</option>
                                                <option value="Blogger" <?php if(isset($data)) {if ($data[0]->sample_type=='Blogger') echo 'selected';}?>>Blogger</option>
												</select>
											</div>
										</div>
                                    </div>
									<div id="gifting_div" style="<?php if(isset($data)) {if ($data[0]->sample_type=='Gifting') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>"  class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
										
												<label class="col-md-2 col-sm-2 col-xs-12 control-label">Gifting Remarks</label>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<input type="text" class="form-control" id="gifting_remarks" name="gifting_remarks" placeholder="Gifting Remarks" value="<?php if(isset($data)) { echo $data[0]->gifting_remarks; } ?>"/>
												</div>
										</div>
										
                                    </div>
							
									<div class="form-group" id="promoter_div" style="<?php if(isset($data)) {if ($data[0]->sample_type=='Promoter') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                      
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Promoter Sales Representative </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="promoter_sales_rep_id" id="promoter_sales_rep_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($promoter)) { for ($k=0; $k < count($promoter) ; $k++) { ?>
                                                            <option value="<?php echo $promoter[$k]->id; ?>" <?php if(isset($data)) { if($promoter[$k]->id==$data[0]->promoter_sales_rep_id) { echo 'selected'; } } ?>><?php echo $promoter[$k]->sales_rep_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                       
                                        </div>
                                    </div>
									
                                    <div id="blogger_div" style="<?php if(isset($data)) {if ($data[0]->sample_type=='Blogger') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Blgger Name </label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="text" class="form-control" name="blogger_name" id="blogger_name" placeholder="Blogger Name" value="<?php if (isset($data)) { echo $data[0]->blogger_name; } ?>" />
                                                </div>
											</div>
                                        </div>
										<div class="form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Blgger Address</label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="text" class="form-control" name="blogger_address" id="blogger_address" placeholder="Blogger Address" value="<?php if(isset($data)) echo $data[0]->blogger_address;?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Blgger Phone No </label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="text" class="form-control" name="blogger_phone_no" id="blogger_phone_no" placeholder="Blogger Phone No" value="<?php if (isset($data)) { echo $data[0]->blogger_phone_no; } ?>" />
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Blgger Email Id </label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="text" class="form-control" name="blogger_email_id" id="blogger_email_id" placeholder="Blogger Email Id" value="<?php if(isset($data)) echo $data[0]->blogger_email_id;?>"/>
                                                </div>
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
                                                <input type="text" class="form-control loadstatedropdown" name="state" id="state" placeholder="State" value="<?php if(isset($data)) { echo  $data[0]->state; } ?>"/>
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
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Discount </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="discount" id="discount" placeholder="Discount" value="<?php if(isset($data)) { echo $data[0]->discount; } ?>" />
                                            </div>
                                    </div>
                                   
                                   
                                    <div class="form-group" style="display:none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tax <span class="asterisk_sign">*</span></label>
											<div class="col-md-4  col-sm-4 col-xs-12 option-line-height">
                                                <input type="radio" name="tax"  value="vat" id="tax_vat" data-error="#err_tax" <?php if (isset($data)) { if($data[0]->tax=='vat') echo 'checked'; } ?>/>&nbsp;&nbsp;Vat&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="tax"  value="cst" id="tax_cst" data-error="#err_tax" <?php if (isset($data)) { if($data[0]->tax=='cst') echo 'checked'; } ?>/>&nbsp;&nbsp;Cst
                                                <div id="err_tax"></div>
                                            </div>
                                        </div>
									</div>
									<div class="form-group" style="display:none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tax (In %) <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="tax_per" id="tax_per" placeholder="Tax" value="<?php if (isset($data)) { echo $data[0]->tax_per; } ?>" readonly />
                                           </div>
                                        </div>
                                    </div>
                                	<div class="h-scroll">	
                                       <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px">Type <span class="asterisk_sign">*</span></th>
                                                <th style="width: 300px">Item <span class="asterisk_sign">*</span></th>
                                                <th>Qty <span class="asterisk_sign">*</span></th>
                                                <th>Rate (In Rs) </th>
                                                <th>Sell Rate (In Rs) <span class="asterisk_sign">*</span></th>
                                                <th style="display: none;">Grams</th>
                                                <th>Amount (In Rs)</th>
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
                                                    <input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_<?php echo $i; ?>" placeholder="Sell Rate" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->sell_rate; } ?>"/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->grams; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($distributor_out_items)) { echo $distributor_out_items[$i]->amount; } ?>" readonly />
                                                </td>
                                                 <td class="table_action" style="text-align:center;     vertical-align: middle;">
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
                                                    <input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_<?php echo $i; ?>" placeholder="Sell Rate" value=""/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                  <td class="table_action" style="text-align:center;     vertical-align: middle;">
                                                    <?php  
                                                    if(isset($data[0]->freezed)){
                                                        if($data[0]->freezed==1){
                                                            $style =  'display: none;';
                                                        }
                                                    }else
                                                        {
                                                             $style =  'display: block;';
                                                        }?>
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#" style="<?=$style?>"><span class="fa trash fa-trash-o"  ></span></a>
                                                   
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8">
                                                    <button type="button" class="btn btn-success" id="repeat-box"  >+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs)<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php //if (isset($data)) { echo $data[0]->amount; } ?>" readonly />
                                            </div> -->
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Due Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="due_date" id="due_date" placeholder="Due Date" value="<?php if(isset($data)) { echo (($data[0]->due_date!=null && $data[0]->due_date!='')?date('d/m/Y',strtotime($data[0]->due_date)):''); } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tax Amount (In Rs)</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">

                                                <input type="text" class="form-control" name="tax_amount" id="tax_amount" placeholder="Tax Amount" value="<?php if (isset($data)) { echo $data[0]->tax_amount; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Final Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="final_amount" id="final_amount" placeholder="Final Amount" value="<?php if(isset($data)) { echo $data[0]->final_amount; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Order No </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No" value="<?php if (isset($data)) { echo $data[0]->order_no; } ?>" />
                                            </div>
                                         </div>
                                    </div>
									<div class="form-group" style="display: none;">
                                         <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Order Date </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="order_date" id="order_date" placeholder="Order Date" value="<?php if(isset($data)) { echo (($data[0]->order_date!=null && $data[0]->order_date!='')?date('d/m/Y',strtotime($data[0]->order_date)):''); } ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Supplier Ref </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="supplier_ref" id="supplier_ref" placeholder="Supplier Ref" value="<?php if (isset($data)) { echo $data[0]->supplier_ref; } ?>" />
                                            </div>
										</div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Dispatch Doc No </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="despatch_doc_no" id="despatch_doc_no" placeholder="Dispatch Doc No" value="<?php if(isset($data)) { echo $data[0]->despatch_doc_no; } ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Dispatch Through </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="despatch_through" id="despatch_through" placeholder="Dispatch Through" value="<?php if (isset($data)) { echo $data[0]->despatch_through; } ?>" />
                                            </div>
                                        </div>
                                    </div>
											
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Destination </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="destination" id="destination" placeholder="Destination" value="<?php if(isset($data)) { echo $data[0]->destination; } ?>" />
                                            </div>
                                        </div>
                                    </div>
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
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Delivery Status *</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="delivery_status" id="delivery_status">
                                                    
                                                    <option value="Pending" <?php if(isset($data)) {if ($data[0]->delivery_status=='Pending') echo 'selected';}?>>Pending</option>
                                                    <option value="GP Issued" <?php if(isset($data)) {if ($data[0]->delivery_status=='GP Issued') echo 'selected';}?>>GP Issued</option>
                                                    <option value="Delivered Not Complete" <?php if(isset($data)) {if ($data[0]->delivery_status=='Delivered Not Complete') echo 'selected';}?>>Delivered Not Complete</option>
                                                    <option value="Delivered" <?php if(isset($data)) {if ($data[0]->delivery_status=='Delivered') echo 'selected';}?>>Delivered</option>
                                                    <option value="Cancelled" <?php if(isset($data)) {if ($data[0]->delivery_status=='Cancelled') echo 'selected';}?>>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Delivery Date *</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" disabled="true" class="form-control datepicker" name="delivery_date" id="delivery_date" placeholder="Delivery Date" value="<?php if(isset($data)) echo (($data[0]->delivery_date!=null && $data[0]->delivery_date!='')?date('d/m/Y',strtotime($data[0]->delivery_date)):date('d/m/Y')); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
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
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 ">
                                                <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
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
                                <div class="panel-footer">
                                    
									<a href="<?php echo base_url(); ?>index.php/sample_out" class="btn btn-danger pull-right" type="reset" id="reset">Cancel</a>
                                 
                                    <input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Submit For Approval"

                                    style="<?php 
                                    if(isset($access)) {
                                        if(isset($data)) {
                                            if($data[0]->freezed)
                                            {
                                                echo 'display: none;';
                                            }else
                                            {
                                             if($access[0]->r_edit=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved' || $data[0]->status=='InActive' || ($data[0]->depot_name=='' && $data[0]->status=='Pending'))) echo ''; else echo 'display: none;';
                                            }
                                        } else if($access[0]->r_insert=='1') echo ''; else echo 'display: none;'; ?>" />
                                    <?php } ?>
                                    <?php if(isset($data) && $data[0]->freezed!=1) { ?>
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_delete" name="btn_delete" value="Delete" style="<?php if(isset($access) ) {
                                        if(isset($data)) {if($access[0]->r_delete=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved' || ($data[0]->depot_name=='' && $data[0]->status=='Pending')) && $data[0]->status!='InActive') echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />

                                   <?php } ?>

                                    <input type="submit" class="btn btn-success btn-sm" id="btn_approve" name="btn_approve" value="Approve" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive' && $data[0]->depot_name!='')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_reject" name="btn_reject" value="Reject" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive' && $data[0]->depot_name!='')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
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
                    $("textarea").attr("readonly", true);
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
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });
                $('#distributor_id').click(function(event){
                    get_distributor_details($('#distributor_id').val());

                    if($('#distributor_id').val()==1){
                        $('#sample_distributor_div').show();
                    } else {
                        $('#sample_distributor_div').hide();
                    }
                });
                // $('#sample_distributor_id').click(function(event){
                //     get_distributor_details($('#sample_distributor_id').val());
                // });
                $("#discount").change(function(){
                    $('#sell_out').val($("#discount").val());
                });
                $('input[type=radio][name=tax]').on('change', function() {
                    switch($(this).val()) {
                        case 'vat':
                            $('#tax_per').val(6);
                            break;
                        case 'cst':
                            $('#tax_per').val(2);
                            break;
                    }

                    get_sell_rate();
                });
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                
                addMultiInputNamingRules('#form_distributor_out_details', 'select[name="box[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_out_details', 'select[name="bar[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_out_details', 'input[name="qty[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_out_details', 'input[name="sell_rate[]"]', { required: true }, "");

                get_distributor_details($('#distributor_id').val());

                if($('#distributor_id').val()==1){
                    $('#sample_distributor_div').show();
                } else {
                    $('#sample_distributor_div').hide();
                }

                // if($('#sample_distributor_id').val()!=''){
                //     get_distributor_details($('#sample_distributor_id').val());
                // }

                $("#sample_type").change(function(){
                    if($("#sample_type").val()=="Gifting"){
                        $("#gifting_div").show();
                        $("#promoter_div").hide();
                        $("#blogger_div").hide();
                    } else if($("#sample_type").val()=="Promoter"){
                        $("#gifting_div").hide();
                        $("#promoter_div").show();
                        $("#blogger_div").hide();
                    } else if($("#sample_type").val()=="Blogger"){
                        $("#gifting_div").hide();
                        $("#promoter_div").hide();
                        $("#blogger_div").show();
                    } else {
                        $("#gifting_div").hide();
                        $("#promoter_div").hide();
                        $("#blogger_div").hide();
                    }
                });
            });

            function show_item(elem){
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                if(elem.val()=="Bar"){
                    $("#bar_"+index).show();
                    $("#box_"+index).hide();
                } else {
                    $("#box_"+index).show();
                    $("#bar_"+index).hide();
                }

                $("#grams_"+index).val('');
                $("#rate_"+index).val('');

                // get_total();
            }

            function get_distributor_details(distributor_id){
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
                            if(distributor_id==42 || distributor_id==214 || distributor_id==550 || distributor_id==622 || distributor_id==626 || distributor_id==640 || distributor_id==1299 || distributor_id==1319 || distributor_id==1327){
                                $('#sell_out').val($("#discount").val());
                            } else {
                                $('#sell_out').val(data.sell_out);
                            }
                            
                            if($('#distributor_id').val()!=""){
                                $('#distributor_name').val(data.product_name);
                            }

                            $('#state').val(data.state);
                            $('#class').val(data.class);
                            //$('#sales_rep_id').val(data.sales_rep_id);

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
                            if($.trim($('#class').val()).toUpperCase()=="SAMPLE"){
                                $('#tax_vat').prop('checked', false);
                                $('#tax_cst').prop('checked', false);
                                tax_per = 0;
                            } else if($.trim($('#state').val()).toUpperCase()=="MAHARASHTRA"){
                                $('#tax_vat').prop('checked', true);
                                $('#tax_cst').prop('checked', false);
                                tax_per = 6;
                            } else {
                                $('#tax_vat').prop('checked', false);
                                $('#tax_cst').prop('checked', true);
                                tax_per = 2;
                            }
                            $('#tax_per').val(tax_per);

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

                if(distributor_id==42 || distributor_id==214 || distributor_id==550 || distributor_id==622 || distributor_id==626 || distributor_id==640 || distributor_id==1299 || distributor_id==1319 || distributor_id==1327){
                    $('.direct').show();
                } else {
                    $('.direct').hide();
                }
            }

            function get_sell_rate(){
                $('.rate').each(function(){
                    var elem = $(this);
                    var id = elem.attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    // var sell_out = parseFloat(get_number($("#sell_out").val(),2));
                    var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                    var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                    // var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                    // var sell_rate = rate-((rate*sell_out)/100);
                    // sell_rate = sell_rate/(100+tax_per)*100;

                    if (isNaN(qty)) qty=0;
                    if (isNaN(rate)) rate=0;
                    // if (isNaN(sell_rate)) sell_rate=0;

                    var amount = qty*rate;

                    $("#sell_rate_"+index).val(rate);
                    $("#amount_"+index).val(Math.round(amount*100)/100);
                });

                get_total();
            }

            function get_bar_details(elem){
                var box_id = elem.val();
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var sell_out = parseFloat(get_number($("#sell_out").val(),2));
                if (isNaN(sell_out)) sell_out=0;
                var grams_in_bar = 0;
                var rate = 0;

                $.ajax({
                    url:BASE_URL+'index.php/Product/get_data',
                    method:"post",
                    data:{id:box_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams = parseFloat(data.grams);
                            rate = parseFloat(data.cost);
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
                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var sell_rate = rate-((rate*sell_out)/100);
                sell_rate = sell_rate/(100+tax_per)*100;

                var amount = qty*sell_rate;
                $("#grams_"+index).val(grams);
                $("#rate_"+index).val(rate);
                $("#sell_rate_"+index).val(Math.round(sell_rate*100)/100);
                $("#amount_"+index).val(Math.round(amount*100)/100);

                get_total();
            }

            function get_box_details(elem){
                var box_id = elem.val();
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var sell_out = parseFloat(get_number($("#sell_out").val(),2));
                if (isNaN(sell_out)) sell_out=0;
                var grams_in_bar = 0;
                var rate = 0;

                $.ajax({
                    url:BASE_URL+'index.php/Box/get_data',
                    method:"post",
                    data:{id:box_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams = parseFloat(data.grams);
                            rate = parseFloat(data.cost);
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
                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var sell_rate = rate-((rate*sell_out)/100);
                sell_rate = sell_rate/(100+tax_per)*100;

                var amount = qty*sell_rate;
                $("#grams_"+index).val(grams);
                $("#rate_"+index).val(rate);
                $("#sell_rate_"+index).val(Math.round(sell_rate*100)/100);
                $("#amount_"+index).val(Math.round(amount*100)/100);

                get_total();
            }

            function get_amount(elem){
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var sell_rate = parseFloat(get_number($("#sell_rate_"+index).val(),2));
                var amount = qty*sell_rate;
                $("#amount_"+index).val(Math.round(amount*100)/100);

                get_total();
            }

            function get_total(){
                var total_amount = 0;

                $('.amount').each(function(){
                    amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amount = total_amount + amount;
                });

                // var tax_per = 0;
                // if($.trim($('#state').val()).toUpperCase()=="MAHARASHTRA"){
                //     tax_per = 6;
                // } else {
                //     tax_per = 2;
                // }

                var tax_per = parseFloat(get_number($('#tax_per').val(),2));

                var tax_amount = total_amount*tax_per/100;
                var final_amount = total_amount + tax_amount;

                $("#total_amount").val(Math.round(total_amount*100)/100);
                $("#tax_amount").val(Math.round(tax_amount*100)/100);
                $("#final_amount").val(Math.round(final_amount*100)/100);
            }

            jQuery(function(){
                var counter = $('.box').length;
                var newRow1;
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
                                                '<input type="text" class="form-control grams" name="grams[]" id="grams_'+counter+'" placeholder="Grams" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td class="table_action" style="text-align:center;">' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                        '</tr>');

                $('#box_details').append(newRow1);
                if(!$('#btn_submit').is(':visible')){
                    $('.table_action').hide();
                }

                $('#repeat-box').click(function(event){
                    event.preventDefault();
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
                                                '<input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_'+counter+'" placeholder="Sell Rate" value=""/>' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control grams" name="grams[]" id="grams_'+counter+'" placeholder="Grams" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />' + 
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