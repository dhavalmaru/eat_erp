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
            @media screen and (max-width:806px) {   
                .h-scroll { overflow-x:scroll;} .h-scroll .table-stripped{ width:805px!important;}
            }
            .delete_row_ex .trash {
                font-size: 21px;
                color: #cc2127;
            }
            @media print {
                body * {
                    visibility: hidden;
                }
                #form_distributor_in_details * {
                    visibility: visible;
                }
                #form_distributor_in_details {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
                .print_hide {
                    display: none;
                }
                .col-md-4 {
                    width: 50%;
                    display: inline-flex;
                }
                .col-md-2 {
                    display: inline-flex;
                }
            }
		</style>
    </head>
    <body>								
       <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/distributor_in'; ?>" >Distributor In List </a>  &nbsp; &#10095; &nbsp; Distributor In Details</div>
       
                
                <!-- PAGE CONTENT WRAPPER -->
                     <div class="page-content-wrap">
                      <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">							
                            <form id="form_distributor_in_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/distributor_in/update/' . $data[0]->id; else echo base_url().'index.php/distributor_in/save'; ?>">
                                <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default">
								
							 	<div class="panel-body">
									<div class="form-group" >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="hidden" class="form-control" name="ref_id" id="ref_id" value="<?php if(isset($data)) echo $data[0]->ref_id;?>"/>
                                                <input type="hidden" class="form-control" name="sales_return_no" id="sales_return_no" value="<?php if(isset($data)) echo $data[0]->sales_return_no;?>"/>
                                                <input type="text" class="form-control datepicker1" name="date_of_processing" id="date_of_processing" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="distributor_id" id="distributor_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                            <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) { if($distributor[$k]->id==$data[0]->distributor_id) { echo 'selected'; } } ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <input type="hidden" name="sell_out" id="sell_out" value="<?php if(isset($data)) { echo $data[0]->sell_out; } ?>"/>
                                                <!-- <input type="hidden" name="distributor_id" id="distributor_id" value="<?php //if(isset($data)) { echo $data[0]->distributor_id; } ?>"/>
                                                <input type="text" class="form-control load_distributor" name="distributor" id="distributor" placeholder="Type To Select Distributor...." value="<?php //if(isset($data)) { echo $data[0]->distributor_name; } ?>"/> -->
                                                <input type="hidden" class="form-control" name="state" id="state" placeholder="State" value="" />
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="depot_id" id="depot_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { ?>
                                                            <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <input type="hidden" class="form-control" name="depot_state" id="depot_state" value="<?php if(isset($data)) { echo  $data[0]->depot_state; } ?>"/>
                                                <!-- <input type="hidden" name="depot_id" id="depot_id" value="<?php //if(isset($data)) { echo $data[0]->depot_id; } ?>"/>
                                                <input type="text" class="form-control load_depot" name="depot" id="depot" placeholder="Type To Select Depot...." value="<?php //if(isset($data)) { echo $data[0]->depot_name; } ?>"/> -->
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Representative <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="sales_rep_id" id="sales_rep_id" class="form-control">
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
                                    <div class="form-group">
                                      	<div class="col-md-12 col-sm-12 col-xs-12">
                                           <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tax <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-4 col-sm-4 col-xs-12 option-line-height">
                                                <input type="radio" name="tax" disabled="true" class="" value="gst" id="tax_gst" data-error="#err_tax" <?php if (isset($data)) { if($data[0]->tax=='gst') echo 'checked'; } ?>/>&nbsp;&nbsp;Gst&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="tax" disabled="true" class="" value="vat" id="tax_vat" data-error="#err_tax" <?php if (isset($data)) { if($data[0]->tax=='vat') echo 'checked'; } ?>/>&nbsp;&nbsp;Vat&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="tax" disabled="true" class="" value="cst" id="tax_cst" data-error="#err_tax" <?php if (isset($data)) { if($data[0]->tax=='cst') echo 'checked'; } ?>/>&nbsp;&nbsp;Cst
                                                <div id="err_tax"></div>
                                            </div>
                                          <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tax (In %) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="tax_per" id="tax_per" placeholder="Tax Percent" value="<?php if (isset($data)) { echo $data[0]->cst; } ?>" readonly />
                                                <input type="hidden" class="form-control" name="cgst" id="cgst" placeholder="cgst" value="<?php if (isset($data)) { echo $data[0]->cgst; } ?>" readonly />
                                                <input type="hidden" class="form-control" name="sgst" id="sgst" placeholder="sgst" value="<?php if (isset($data)) { echo $data[0]->sgst; } ?>" readonly />
                                                <input type="hidden" class="form-control" name="igst" id="igst" placeholder="igst" value="<?php if (isset($data)) { echo $data[0]->igst; } ?>" readonly />
                                                <!-- <input type="text" class="form-control" name="cst" id="cst" placeholder="Tax" value="<?php //if (isset($data)) { echo $data[0]->cst; } ?>" readonly /> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php //if (isset($data)) { echo $data[0]->amount; } ?>" readonly />
                                            </div> -->
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Is stock expired?<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input <?php if (isset($data)) { if($data[0]->is_expired=='yes') { echo 'checked'; } } ?> type="checkbox" class="form-select" name="expired" id="expired" value="<?php if (isset($data)) { if($data[0]->is_expired=='yes') { echo '1'; } } else { echo '1'; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"  >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php //if (isset($data)) { echo $data[0]->amount; } ?>" readonly />
                                            </div> -->
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Is there exchange of stock?<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="checkbox" <?php if (isset($data)) { if($data[0]->is_exchanged=='yes') { echo 'checked'; } } ?> class="form-select" name="exhanged" id="exchanged" value="<?php if (isset($data)) { if($data[0]->is_exchanged=='yes') { echo '1'; } } else { echo '1'; } ?>"/>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="h-scroll">	
                                    <h2 style="padding:20px;padding-bottom:0px;">Stock In</h2>
                                    <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 75px">Type <span class="asterisk_sign">*</span></th>
                                                <th style="width: 200px">Item <span class="asterisk_sign">*</span></th>
                                                <th>Qty <span class="asterisk_sign">*</span></th>
                                                <th class="print_hide">Rate (In Rs)</th>
                                                <th>Sell Rate (In Rs) <span class="asterisk_sign">*</span></th>
                                                <th style="display:none;">Cost Rate (In Rs) <span class="asterisk_sign">*</span></th>
                                                <th style="display: none;">Grams</th>
                                                <th class="print_hide">Amount (In Rs)</th>
                                                <th class="print_hide">CGST (In Rs)</th>
                                                <th class="print_hide">SGST (In Rs)</th>
                                                <th class="print_hide">IGST (In Rs)</th>
                                                <th class="print_hide">Tax (In Rs)</th>
                                                <!-- <th>VAT (In Rs)</th> -->
                                                <th>Total Amount (In Rs)</th>
                                                <th style="display:none;">Cost Total Amount (In Rs)</th>
                                                <th style="width: 100px">Batch</th>
                                                <th style="text-align:center;" class="print_hide">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($distributor_in_items)) {
                                                for($i=0; $i<count($distributor_in_items); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="type[]" class="form-control type" id="type_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <option value="Bar" <?php if($distributor_in_items[$i]->type=="Bar") { echo 'selected'; } ?>>Bar</option>
                                                        <option value="Box" <?php if($distributor_in_items[$i]->type=="Box") { echo 'selected'; } ?>>Box</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="bar[]" class="form-control bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($distributor_in_items[$i]->type=="Box") { echo 'display: none;'; } ?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                <option value="<?php echo $bar[$k]->id; ?>" <?php if($distributor_in_items[$i]->type=="Bar" && $bar[$k]->id==$distributor_in_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $bar[$k]->product_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <select name="box[]" class="form-control box" id="box_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($distributor_in_items[$i]->type=="Bar") { echo 'display: none;'; } ?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                <option value="<?php echo $box[$k]->id; ?>" <?php if($distributor_in_items[$i]->type=="Box" && $box[$k]->id==$distributor_in_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $box[$k]->box_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($distributor_in_items)) { echo $distributor_in_items[$i]->qty; } ?>"/>
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($distributor_in_items)) { echo $distributor_in_items[$i]->rate; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_<?php echo $i; ?>" placeholder="Sell Rate" value="<?php if (isset($distributor_in_items)) { echo $distributor_in_items[$i]->sell_rate; } ?>"/>
                                                </td>
                                                <td style="display:none;">
                                                    <input type="text" class="form-control cost_rate" name="cost_rate[]" id="cost_rate_<?php echo $i; ?>" placeholder="Cost Rate" value="<?php if (isset($distributor_in_items)) { echo $distributor_in_items[$i]->cost_rate; } ?>"/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="<?php if (isset($distributor_in_items)) { echo $distributor_in_items[$i]->grams; } ?>" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($distributor_in_items)) { echo $distributor_in_items[$i]->amount; } ?>" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_<?php echo $i; ?>" placeholder="CGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_<?php echo $i; ?>" placeholder="SGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_<?php echo $i; ?>" placeholder="IGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_<?php echo $i; ?>" placeholder="Tax Amount" value="" readonly />
                                                </td>
                                                <!-- <td>
                                                    <input type="text" class="form-control vat1" name="VAT1[]" id="vat1_<?php //echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td> -->
                                                <td>
                                                    <input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control cost_total_amt" name="cost_total_amt[]" id="cost_total_amt_<?php echo $i; ?>" placeholder="Total Amount" value="<?php if (isset($distributor_in_items)) { echo $distributor_in_items[$i]->cost_amount; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <select name="batch_no[]" class="form-control batch_no" id="batch_no_<?php echo $i;?>" data-error="#err_batch_no_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch); $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$distributor_in_items[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_batch_no_<?php echo $i;?>"></div>
                                                </td>

                                                <td style="text-align:center; vertical-align: middle;" class="print_hide">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
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
                                                <td class="print_hide">
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_<?php echo $i; ?>" placeholder="Sell Rate" value=""/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control sell_rate" name="cost_rate[]" id="cost_rate_<?php echo $i; ?>" placeholder="Cost Rate" value=""/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_<?php echo $i; ?>" placeholder="CGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_<?php echo $i; ?>" placeholder="SGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_<?php echo $i; ?>" placeholder="IGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_<?php echo $i; ?>" placeholder="Tax Amount" value="" readonly />
                                                </td>
                                                <!-- <td>
                                                    <input type="text" class="form-control vat1" name="VAT1[]" id="vat1_<?php //echo $i; ?>" placeholder="VAT" value="" readonly />
                                                </td> -->
                                                <td>
                                                    <input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_<?php echo $i; ?>" placeholder="Total Amount" value="" readonly />
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control cost_total_amt" name="cost_total_amt[]" id="cost_total_amt_<?php echo $i; ?>" placeholder="Total Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <select name="batch_no[]" class="form-control batch_no" id="batch_no_<?php echo $i;?>" data-error="#err_batch_no_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch); $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_batch_no_<?php echo $i;?>"></div>
                                                </td>

                                                <td style="text-align:center; vertical-align: middle;" class="print_hide">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="16">
                                                    <button type="button" class="btn btn-success" id="repeat-box" >+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
									</div>





                                    <div class="h-scroll exc_table" style="display:none;">  
                                        <h2 style="padding:20px;padding-bottom:0px;">Stock Out</h2>
                                       <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px">Type <span class="asterisk_sign">*</span></th>
                                                <th style="width: 250px">Item <span class="asterisk_sign">*</span></th>
                                                <th>Qty <span class="asterisk_sign">*</span></th>
                                                <th class="print_hide">Rate (In Rs)</th>
                                                <th>Sell Rate (In Rs) <span class="asterisk_sign">*</span></th>
                                                <th style="display: none;" class="print_hide">Cost Rate (In Rs) <span class="asterisk_sign">*</span></th>
                                                <th style="display: none;" class="print_hide">Grams</th>
                                                <th class="print_hide">Amount (In Rs)</th>
                                                <th class="print_hide">CGST (In Rs)</th>
                                                <th class="print_hide">SGST (In Rs)</th>
                                                <th class="print_hide">IGST (In Rs)</th>
                                                <th class="print_hide">Tax (In Rs)</th>
                                                <!-- <th>VAT (In Rs)</th> -->
                                                <th>Total Amount (In Rs)</th>
                                                <th style="display: none;">Cost Total Amount (In Rs)</th>
                                                <th style="text-align:center;" class="print_hide">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details_ex">
                                        <?php $i=0; if(isset($distributor_in_items_ex)) {
                                                for($i=0; $i<count($distributor_in_items_ex); $i++) { ?>
                                            <tr id="box_ex_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="type_ex[]" class="form-control type" id="type_ex_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <option value="Bar" <?php if($distributor_in_items_ex[$i]->type=="Bar") { echo 'selected'; } ?>>Bar</option>
                                                        <option value="Box" <?php if($distributor_in_items_ex[$i]->type=="Box") { echo 'selected'; } ?>>Box</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="bar_ex[]" class="form-control bar_ex" id="bar_ex_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($distributor_in_items_ex[$i]->type=="Box") { echo 'display: none;'; } ?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                <option value="<?php echo $bar[$k]->id; ?>" <?php if($distributor_in_items_ex[$i]->type=="Bar" && $bar[$k]->id==$distributor_in_items_ex[$i]->item_id) { echo 'selected'; } ?>><?php echo $bar[$k]->product_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <select name="box_ex[]" class="form-control box_ex" id="box_ex_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($distributor_in_items_ex[$i]->type=="Bar") { echo 'display: none;'; } ?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                <option value="<?php echo $box[$k]->id; ?>" <?php if($distributor_in_items_ex[$i]->type=="Box" && $box[$k]->id==$distributor_in_items_ex[$i]->item_id) { echo 'selected'; } ?>><?php echo $box[$k]->box_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty_ex" name="qty_ex[]" id="qty_ex_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($distributor_in_items_ex)) { echo $distributor_in_items_ex[$i]->qty; } ?>"/>
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control rate_ex" name="rate_ex[]" id="rate_ex_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($distributor_in_items_ex)) { echo $distributor_in_items_ex[$i]->rate; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control sell_rate_ex" name="sell_rate_ex[]" id="sell_rate_ex_<?php echo $i; ?>" placeholder="Sell Rate" value="<?php if (isset($distributor_in_items_ex)) { echo $distributor_in_items_ex[$i]->sell_rate; } ?>"/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control cost_rate_ex" name="cost_rate_ex[]" id="cost_rate_ex_<?php echo $i; ?>" placeholder="Cost Rate" value="<?php if (isset($distributor_in_items_ex)) { echo $distributor_in_items_ex[$i]->cost_rate; } ?>"/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control grams_ex" name="grams_ex[]" id="grams_ex_<?php echo $i; ?>" placeholder="Grams" value="<?php if (isset($distributor_in_items_ex)) { echo $distributor_in_items_ex[$i]->grams; } ?>" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control amount_ex" name="amount_ex[]" id="amount_ex_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($distributor_in_items_ex)) { echo $distributor_in_items_ex[$i]->amount; } ?>" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control cgst_amt_ex" name="cgst_amt_ex[]" id="cgst_amt_ex_<?php echo $i; ?>" placeholder="CGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control sgst_amt_ex" name="sgst_amt_ex[]" id="sgst_amt_ex_<?php echo $i; ?>" placeholder="SGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control igst_amt_ex" name="igst_amt_ex[]" id="igst_amt_ex_<?php echo $i; ?>" placeholder="IGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control tax_amt_ex" name="tax_amt_ex[]" id="tax_amt_ex_<?php echo $i; ?>" placeholder="Tax Amount" value="" readonly />
                                                </td>
                                                <!-- <td>
                                                    <input type="text" class="form-control vat1_ex" name="VAT1_ex[]" id="vat1_ex_<?php //echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td> -->
                                                <td>
                                                    <input type="text" class="form-control total_amt_ex" name="total_amt_ex[]" id="total_amt_ex_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control cost_total_amt_ex" name="cost_total_amt_ex[]" id="cost_total_amt_ex_<?php echo $i; ?>" placeholder="Total Amount" value="<?php if (isset($distributor_in_items_ex)) { echo $distributor_in_items_ex[$i]->cost_amount; } ?>" readonly />
                                                </td>

                                                <td style="text-align:center; vertical-align: middle;" class="print_hide">
                                                    <a id="box_ex_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="box_ex_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="type_ex[]" class="form-control type_ex" id="type_ex_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <option value="Bar">Bar</option>
                                                        <option value="Box">Box</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="bar_ex[]" class="form-control bar_ex" id="bar_ex_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="">
                                                        <option value="">Select</option>
                                                        <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                <option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->product_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <select name="box_ex[]" class="form-control box_ex" id="box_ex_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="display: none;">
                                                        <option value="">Select</option>
                                                        <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                <option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->box_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty_ex" name="qty_ex[]" id="qty_ex_<?php echo $i; ?>" placeholder="Qty" value=""/>
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control rate_ex" name="rate_ex[]" id="rate_ex_<?php echo $i; ?>" placeholder="Rate" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control sell_rate_ex" name="sell_rate_ex[]" id="sell_rate_ex_<?php echo $i; ?>" placeholder="Sell Rate" value=""/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control cost_rate_ex" name="cost_rate_ex[]" id="cost_rate_ex_<?php echo $i; ?>" placeholder="Cost Rate" value=""/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control grams_ex" name="grams_ex[]" id="grams_ex_<?php echo $i; ?>" placeholder="Grams" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control amount_ex" name="amount_ex[]" id="amount_ex_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control cgst_amt_ex" name="cgst_amt_ex[]" id="cgst_amt_ex_<?php echo $i; ?>" placeholder="CGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control sgst_amt_ex" name="sgst_amt_ex[]" id="sgst_amt_ex_<?php echo $i; ?>" placeholder="SGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control igst_amt_ex" name="igst_amt_ex[]" id="igst_amt_ex_<?php echo $i; ?>" placeholder="IGST Amount" value="" readonly />
                                                </td>
                                                <td class="print_hide">
                                                    <input type="text" class="form-control tax_amt_ex" name="tax_amt_ex[]" id="tax_amt_ex_<?php echo $i; ?>" placeholder="Tax Amount" value="" readonly />
                                                </td>
                                                <!-- <td>
                                                    <input type="text" class="form-control vat1_ex" name="VAT1_ex[]" id="vat1_ex_<?php //echo $i; ?>" placeholder="VAT" value="" readonly />
                                                </td> -->
                                                <td>
                                                    <input type="text" class="form-control total_amt_ex" name="total_amt_ex[]" id="total_amt_ex_<?php echo $i; ?>" placeholder="Total Amount" value="" readonly />
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control cost_total_amt_ex" name="cost_total_amt_ex[]" id="cost_total_amt_ex_<?php echo $i; ?>" placeholder="Total Amount" value="" readonly />
                                                </td>
                                                <td style="text-align:center; vertical-align: middle;" class="print_hide">
                                                    <a id="box_ex_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="15">
                                                    <button type="button" class="btn btn-success" id="repeat-box_ex" >+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php //if (isset($data)) { echo $data[0]->amount; } ?>" readonly />
                                            </div> -->
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Due Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="due_date" id="due_date" placeholder="Due Date" value="<?php if(isset($data)) { echo (($data[0]->due_date!=null && $data[0]->due_date!='')?date('d/m/Y',strtotime($data[0]->due_date)):''); } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">CST Amount (In Rs) </label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="tax_amount" id="tax_amount" placeholder="CST Amount" value="<?php// if (isset($data)) { echo $data[0]->tax_amount; } ?>" readonly />
                                            </div>
                                            <label class="col-md-2 control-label">Final Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="final_amount" id="final_amount" placeholder="Final Amount" value="<?php //if(isset($data)) { echo $data[0]->final_amount; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div> -->
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
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 ">
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
                                <div class="panel-footer print_hide">
                                    <a href="<?php echo base_url(); ?>index.php/distributor_in" class="btn btn-danger btn-sm pull-right" type="reset" id="reset">Cancel</a>
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

                $(".type").change(function(){
                    show_item($(this));
                });
                $(".type_ex").change(function(){
                    show_item_ex($(this));
                });
                $(".bar").change(function(){
                    get_bar_details($(this));
                });
                $(".bar_ex").change(function(){
                    get_bar_details_ex($(this));
                });
                $(".box").change(function(){
                    get_box_details($(this));
                });
                $(".box_ex").change(function(){
                    get_box_details_ex($(this));
                });
                $(".qty").blur(function(){
                    get_amount($(this));
                });
                $(".qty_ex").blur(function(){
                    get_amount_ex($(this));
                });
                $(".sell_rate").blur(function(){
                    get_amount($(this));
                });
                $(".sell_rate_ex").blur(function(){
                    get_amount_ex($(this));
                });
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });
                // $('#distributor_id').click(function(event){
                //     get_distributor_details();
                // });
                $('#distributor_id').on('change', function(event){
                    get_distributor_details($('#distributor_id').val());
                });
                $('#depot_id').on('change', function(event){
                    get_depot_details($('#depot_id').val());
                    get_distributor_details($('#distributor_id').val());
                });
                $('input[type=radio][name=tax]').on('change', function() {
                    switch($(this).val()) {
                        case 'gst':
                            $('#tax_per').val(5);
                            break;
                        case 'vat':
                            $('#cst').val(6);
                            break;
                        case 'cst':
                            $('#cst').val(2);
                            break;
                    }

                    get_sell_rate();
                });
                
                
                addMultiInputNamingRules('#form_distributor_in_details', 'select[name="type[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_in_details', 'select[name="bar[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_in_details', 'select[name="box[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_in_details', 'input[name="qty[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_in_details', 'input[name="sell_rate[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_in_details', 'input[name="batch_no[]"]', { required: true }, "");

                addMultiInputNamingRules('#form_distributor_in_details', 'select[name="type_ex[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_in_details', 'select[name="bar_ex[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_in_details', 'select[name="box_ex[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_in_details', 'input[name="qty_ex[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_in_details', 'input[name="sell_rate_ex[]"]', { required: true }, "");

                get_distributor_details($('#distributor_id').val());
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

            function show_item_ex(elem){
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                if(elem.val()=="Bar"){
                    $("#bar_ex_"+index).show();
                    $("#box_ex_"+index).hide();
                } else {
                    $("#box_ex_"+index).show();
                    $("#bar_ex_"+index).hide();
                }

                $("#grams_ex_"+index).val('');
                $("#rate_ex_"+index).val('');

                // get_total();
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

            function get_distributor_details(distributor_id){
                // var distributor_id = $('#distributor_id').val();
                var sell_out = 0;
                // console.log(distributor_id);

                $.ajax({
                    url:BASE_URL+'index.php/Distributor/get_data',
                    method:"post",
                    data:{id:distributor_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            $('#sell_out').val(data.sell_out);
                            $('#sales_rep_id').val(data.sales_rep_id);
                            $('#state').val(data.state);

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

                            sell_out = parseFloat(data.sell_out);
                            if (isNaN(sell_out)) sell_out=0;

                            // var cst = 0;
                            // if((data.state).toUpperCase()=="MAHARASHTRA"){
                            //     $('#tax_vat').prop('checked', true);
                            //     $('#tax_cst').prop('checked', false);
                            //     cst = 6;
                            // } else {
                            //     $('#tax_vat').prop('checked', false);
                            //     $('#tax_cst').prop('checked', true);
                            //     cst = 2;
                            // }
                            // $('#cst').val(cst);

                            var tax_per = 0;
                            $('#tax_gst').prop('checked', true);
                            $('#tax_vat').prop('checked', false);
                            $('#tax_cst').prop('checked', false);

                            tax_per = 5;

                            $('#tax_per').val(tax_per);

                            get_sell_rate();
                            get_sell_rate_ex();
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

            function get_sell_rate(){
                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var depot_state = $("#depot_state").val();
                var state = $("#state").val();

                // console.log(depot_state);
                // console.log(state);

                var cgst = 0;
                var sgst = 0;
                var igst = 0;
                if(depot_state==state){
                    cgst = parseFloat(tax_per/2,2);
                    sgst = parseFloat(tax_per/2,2);
                } else {
                    igst = 5;
                }
                $("#cgst").val(cgst);
                $("#sgst").val(sgst);
                $("#igst").val(igst);

                $('.rate').each(function(){
                    var elem = $(this);
                    var id = elem.attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var sell_out = parseFloat(get_number($("#sell_out").val(),2));
                    var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                    var rate = parseFloat(get_number($("#rate_"+index).val(),2));

                    if (isNaN(qty)) qty=0;
                    if (isNaN(rate)) rate=0;
                    if (isNaN(sell_out)) sell_out=0;

                    // var cst = parseFloat(get_number($("#cst").val(),2));
                    // var sell_rate = rate-((rate*sell_out)/100);
                    // sell_rate = sell_rate/(100+cst)*100;
                    // if (isNaN(sell_rate)) sell_rate=0;

                    // var amount = qty*sell_rate;

                    var sell_rate = rate-((rate*sell_out)/100);
                    sell_rate = sell_rate/(100+tax_per)*100;
                    if (isNaN(sell_rate)) sell_rate=0;

                    if (isNaN(cgst)) cgst=0;
                    if (isNaN(sgst)) sgst=0;
                    if (isNaN(igst)) igst=0;
                    if (isNaN(tax_per)) tax_per=0;

                    var cgst_amt = (qty*((sell_rate*cgst)/100)).toFixed(2);
                    var sgst_amt = (qty*((sell_rate*sgst)/100)).toFixed(2);
                    var igst_amt = (qty*((sell_rate*igst)/100)).toFixed(2);
                    var tax_amt = (qty*((sell_rate*tax_per)/100)).toFixed(2);
                    // var tax_amt = cgst_amt+sgst_amt+igst_amt;
                    
                    if (isNaN(cgst_amt)) cgst_amt=0;
                    if (isNaN(sgst_amt)) sgst_amt=0;
                    if (isNaN(igst_amt)) igst_amt=0;
                    if (isNaN(tax_amt)) tax_amt=0;

                    var amount = (qty*sell_rate).toFixed(2);
                    var total_amount = parseFloat(amount,2) + parseFloat(tax_amt,2);

                    // $("#sell_rate_"+index).val(Math.round(sell_rate*100)/100);
                    // $("#amount_"+index).val(Math.round(amount*100)/100);
                    
                    $("#sell_rate_"+index).val(Math.round(sell_rate*10000)/10000);
                    $("#amount_"+index).val(amount);
                    $("#cgst_amt_"+index).val(cgst_amt);
                    $("#sgst_amt_"+index).val(sgst_amt);
                    $("#igst_amt_"+index).val(igst_amt);
                    $("#tax_amt_"+index).val(tax_amt);
                    $("#total_amt_"+index).val(total_amount.toFixed(2));
                });

                get_total();
            }

            function get_sell_rate_ex(){
                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var depot_state = $("#depot_state").val();
                var state = $("#state").val();
                var cgst = 0;
                var sgst = 0;
                var igst = 0;
                if(depot_state==state){
                    cgst = parseFloat(tax_per/2,2);
                    sgst = parseFloat(tax_per/2,2);
                } else {
                    igst = 5;
                }
                $("#cgst").val(cgst);
                $("#sgst").val(sgst);
                $("#igst").val(igst);

                $('.rate').each(function(){
                    var elem = $(this);
                    var id = elem.attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var sell_out = parseFloat(get_number($("#sell_out").val(),2));
                    var qty = parseFloat(get_number($("#qty_ex_"+index).val(),2));
                    var rate = parseFloat(get_number($("#rate_ex_"+index).val(),2));

                    if (isNaN(qty)) qty=0;
                    if (isNaN(rate)) rate=0;
                    if (isNaN(sell_out)) sell_out=0;

                    // var cst = parseFloat(get_number($("#cst").val(),2));
                    // var sell_rate = rate-((rate*sell_out)/100);
                    // sell_rate = sell_rate/(100+cst)*100;
                    // if (isNaN(sell_rate)) sell_rate=0;

                    // var amount = qty*sell_rate;

                    var sell_rate = rate-((rate*sell_out)/100);
                    sell_rate = sell_rate/(100+tax_per)*100;
                    if (isNaN(sell_rate)) sell_rate=0;

                    if (isNaN(cgst)) cgst=0;
                    if (isNaN(sgst)) sgst=0;
                    if (isNaN(igst)) igst=0;
                    if (isNaN(tax_per)) tax_per=0;

                    var cgst_amt = (qty*((sell_rate*cgst)/100)).toFixed(2);
                    var sgst_amt = (qty*((sell_rate*sgst)/100)).toFixed(2);
                    var igst_amt = (qty*((sell_rate*igst)/100)).toFixed(2);
                    var tax_amt = (qty*((sell_rate*tax_per)/100)).toFixed(2);
                    // var tax_amt = cgst_amt+sgst_amt+igst_amt;
                    
                    if (isNaN(cgst_amt)) cgst_amt=0;
                    if (isNaN(sgst_amt)) sgst_amt=0;
                    if (isNaN(igst_amt)) igst_amt=0;
                    if (isNaN(tax_amt)) tax_amt=0;

                    var amount = (qty*sell_rate).toFixed(2);
                    var total_amount = parseFloat(amount,2) + parseFloat(tax_amt,2);

                    // $("#sell_rate_ex_"+index).val(Math.round(sell_rate*100)/100);
                    // $("#amount_ex_"+index).val(Math.round(amount*100)/100);

                    $("#sell_rate_ex_"+index).val(Math.round(sell_rate*10000)/10000);
                    $("#amount_ex_"+index).val(amount);
                    $("#cgst_amt_ex_"+index).val(cgst_amt);
                    $("#sgst_amt_ex_"+index).val(sgst_amt);
                    $("#igst_amt_ex_"+index).val(igst_amt);
                    $("#tax_amt_ex_"+index).val(tax_amt);
                    $("#total_amt_ex_"+index).val(total_amount.toFixed(2));
                });

                get_total_ex();
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
                var cost = 0;

                $.ajax({
                    url:BASE_URL+'index.php/Product/get_data',
                    method:"post",
                    data:{id:box_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams = parseFloat(data.grams);
                            rate = parseFloat(data.rate);
                            cost = parseFloat(data.cost);
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
                if (isNaN(cost)) cost=0;

                // var cst = parseFloat(get_number($("#cst").val(),2));
                // var sell_rate = rate-((rate*sell_out)/100);
                // sell_rate = sell_rate/(100+cst)*100;

                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var cgst = $("#cgst").val();
                var sgst = $("#sgst").val();
                var igst = $("#igst").val();

                var sell_rate = rate-((rate*sell_out)/100);
                sell_rate = sell_rate/(100+tax_per)*100;

                var cgst_amt = (qty*((sell_rate*cgst)/100)).toFixed(2);
                var sgst_amt = (qty*((sell_rate*sgst)/100)).toFixed(2);
                var igst_amt = (qty*((sell_rate*igst)/100)).toFixed(2);
                var tax_amt = (qty*((sell_rate*tax_per)/100)).toFixed(2);
                // var tax_amt = cgst_amt+sgst_amt+igst_amt;
                
                if (isNaN(cgst_amt)) cgst_amt=0;
                if (isNaN(sgst_amt)) sgst_amt=0;
                if (isNaN(igst_amt)) igst_amt=0;
                if (isNaN(tax_amt)) tax_amt=0;

                // var amount = qty*sell_rate;
                // $("#grams_"+index).val(grams);
                // $("#rate_"+index).val(rate);
                // $("#sell_rate_"+index).val(Math.round(sell_rate*100)/100);
                // $("#amount_"+index).val(Math.round(amount*100)/100);
                // $("#cost_rate_"+index).val(Math.round(cost*100)/100);

                var amount = (qty*sell_rate).toFixed(2);
                var total_amount = parseFloat(amount,2) + parseFloat(tax_amt,2);

                $("#grams_"+index).val(grams);
                $("#rate_"+index).val(rate);
                $("#sell_rate_"+index).val(Math.round(sell_rate*10000)/10000);
                $("#amount_"+index).val(amount);
                $("#cost_rate_"+index).val(Math.round(cost*100)/100);
                $("#cgst_amt_"+index).val(cgst_amt);
                $("#sgst_amt_"+index).val(sgst_amt);
                $("#igst_amt_"+index).val(igst_amt);
                $("#tax_amt_"+index).val(tax_amt);
                $("#total_amt_"+index).val(total_amount.toFixed(2));

                get_total();
            }

            function get_bar_details_ex(elem){
                var box_id = elem.val();
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_ex_"+index).val(),2));
                var sell_out = parseFloat(get_number($("#sell_out").val(),2));
                if (isNaN(sell_out)) sell_out=0;
                var grams_in_bar = 0;
                var rate = 0;
                var cost = 0;

                $.ajax({
                    url:BASE_URL+'index.php/Product/get_data',
                    method:"post",
                    data:{id:box_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams = parseFloat(data.grams);
                            rate = parseFloat(data.rate);
                            cost = parseFloat(data.cost);
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
                if (isNaN(cost)) cost=0;

                // var cst = parseFloat(get_number($("#cst").val(),2));
                // var sell_rate = rate-((rate*sell_out)/100);
                // sell_rate = sell_rate/(100+cst)*100;

                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var cgst = $("#cgst").val();
                var sgst = $("#sgst").val();
                var igst = $("#igst").val();

                var sell_rate = rate-((rate*sell_out)/100);
                sell_rate = sell_rate/(100+tax_per)*100;

                var cgst_amt = (qty*((sell_rate*cgst)/100)).toFixed(2);
                var sgst_amt = (qty*((sell_rate*sgst)/100)).toFixed(2);
                var igst_amt = (qty*((sell_rate*igst)/100)).toFixed(2);
                var tax_amt = (qty*((sell_rate*tax_per)/100)).toFixed(2);
                // var tax_amt = cgst_amt+sgst_amt+igst_amt;
                
                if (isNaN(cgst_amt)) cgst_amt=0;
                if (isNaN(sgst_amt)) sgst_amt=0;
                if (isNaN(igst_amt)) igst_amt=0;
                if (isNaN(tax_amt)) tax_amt=0;

                // var amount = qty*sell_rate;
                // $("#grams_ex_"+index).val(grams);
                // $("#rate_ex_"+index).val(rate);
                // $("#sell_rate_ex_"+index).val(Math.round(sell_rate*100)/100);
                // $("#amount_ex_"+index).val(Math.round(amount*100)/100);
                // $("#cost_rate_ex_"+index).val(Math.round(cost*100)/100);

                var amount = (qty*sell_rate).toFixed(2);
                var total_amount = parseFloat(amount,2) + parseFloat(tax_amt,2);

                $("#grams_ex_"+index).val(grams);
                $("#rate_ex_"+index).val(rate);
                $("#sell_rate_ex_"+index).val(Math.round(sell_rate*10000)/10000);
                $("#amount_ex_"+index).val(amount);
                $("#cost_rate_ex_"+index).val(Math.round(cost*100)/100);
                $("#cgst_amt_ex_"+index).val(cgst_amt);
                $("#sgst_amt_ex_"+index).val(sgst_amt);
                $("#igst_amt_ex_"+index).val(igst_amt);
                $("#tax_amt_ex_"+index).val(tax_amt);
                $("#total_amt_ex_"+index).val(total_amount.toFixed(2));

                get_total_ex();
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
                var cost = 0;

                $.ajax({
                    url:BASE_URL+'index.php/Box/get_data',
                    method:"post",
                    data:{id:box_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams = parseFloat(data.grams);
                            rate = parseFloat(data.rate);
                            cost = parseFloat(data.cost);
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
                if (isNaN(cost)) cost=0;

                // var cst = parseFloat(get_number($("#cst").val(),2));
                // var sell_rate = rate-((rate*sell_out)/100);
                // sell_rate = sell_rate/(100+cst)*100;

                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var cgst = $("#cgst").val();
                var sgst = $("#sgst").val();
                var igst = $("#igst").val();

                var sell_rate = rate-((rate*sell_out)/100);
                sell_rate = sell_rate/(100+tax_per)*100;

                var cgst_amt = (qty*((sell_rate*cgst)/100)).toFixed(2);
                var sgst_amt = (qty*((sell_rate*sgst)/100)).toFixed(2);
                var igst_amt = (qty*((sell_rate*igst)/100)).toFixed(2);
                var tax_amt = (qty*((sell_rate*tax_per)/100)).toFixed(2);
                // var tax_amt = cgst_amt+sgst_amt+igst_amt;
                
                if (isNaN(cgst_amt)) cgst_amt=0;
                if (isNaN(sgst_amt)) sgst_amt=0;
                if (isNaN(igst_amt)) igst_amt=0;
                if (isNaN(tax_amt)) tax_amt=0;

                // var amount = qty*sell_rate;
                // $("#grams_"+index).val(grams);
                // $("#rate_"+index).val(rate);
                // $("#sell_rate_"+index).val(Math.round(sell_rate*100)/100);
                // $("#amount_"+index).val(Math.round(amount*100)/100);
                // $("#cost_rate_"+index).val(Math.round(cost*100)/100);

                var amount = (qty*sell_rate).toFixed(2);
                var total_amount = parseFloat(amount,2) + parseFloat(tax_amt,2);

                $("#grams_"+index).val(grams);
                $("#rate_"+index).val(rate);
                $("#sell_rate_"+index).val(Math.round(sell_rate*10000)/10000);
                $("#amount_"+index).val(amount);
                $("#cost_rate_"+index).val(Math.round(cost*100)/100);
                $("#cgst_amt_"+index).val(cgst_amt);
                $("#sgst_amt_"+index).val(sgst_amt);
                $("#igst_amt_"+index).val(igst_amt);
                $("#tax_amt_"+index).val(tax_amt);
                $("#total_amt_"+index).val(total_amount.toFixed(2));

                get_total();
            }

            function get_box_details_ex(elem){
                var box_id = elem.val();
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_ex_"+index).val(),2));
                var sell_out = parseFloat(get_number($("#sell_out").val(),2));
                if (isNaN(sell_out)) sell_out=0;
                var grams_in_bar = 0;
                var rate = 0;
                var cost = 0;

                $.ajax({
                    url:BASE_URL+'index.php/Box/get_data',
                    method:"post",
                    data:{id:box_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams = parseFloat(data.grams);
                            rate = parseFloat(data.rate);
                            cost = parseFloat(data.cost);
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
                if (isNaN(cost)) cost=0;

                // var cst = parseFloat(get_number($("#cst").val(),2));
                // var sell_rate = rate-((rate*sell_out)/100);
                // sell_rate = sell_rate/(100+cst)*100;

                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var cgst = $("#cgst").val();
                var sgst = $("#sgst").val();
                var igst = $("#igst").val();

                var sell_rate = rate-((rate*sell_out)/100);
                sell_rate = sell_rate/(100+tax_per)*100;

                var cgst_amt = (qty*((sell_rate*cgst)/100)).toFixed(2);
                var sgst_amt = (qty*((sell_rate*sgst)/100)).toFixed(2);
                var igst_amt = (qty*((sell_rate*igst)/100)).toFixed(2);
                var tax_amt = (qty*((sell_rate*tax_per)/100)).toFixed(2);
                // var tax_amt = cgst_amt+sgst_amt+igst_amt;
                
                if (isNaN(cgst_amt)) cgst_amt=0;
                if (isNaN(sgst_amt)) sgst_amt=0;
                if (isNaN(igst_amt)) igst_amt=0;
                if (isNaN(tax_amt)) tax_amt=0;

                // var amount = qty*sell_rate;
                // $("#grams_ex_"+index).val(grams);
                // $("#rate_ex_"+index).val(rate);
                // $("#sell_rate_ex_"+index).val(Math.round(sell_rate*100)/100);
                // $("#amount_ex_"+index).val(Math.round(amount*100)/100);
                // $("#cost_rate_ex_"+index).val(Math.round(cost*100)/100);

                var amount = (qty*sell_rate).toFixed(2);
                var total_amount = parseFloat(amount,2) + parseFloat(tax_amt,2);

                $("#grams_ex_"+index).val(grams);
                $("#rate_ex_"+index).val(rate);
                $("#sell_rate_ex_"+index).val(Math.round(sell_rate*10000)/10000);
                $("#amount_ex_"+index).val(amount);
                $("#cgst_amt_ex_"+index).val(cgst_amt);
                $("#sgst_amt_ex_"+index).val(sgst_amt);
                $("#igst_amt_ex_"+index).val(igst_amt);
                $("#tax_amt_ex_"+index).val(tax_amt);
                $("#total_amt_ex_"+index).val(total_amount.toFixed(2));
                $("#cost_rate_ex_"+index).val(Math.round(cost*100)/100);

                get_total_ex();
            }

            function get_amount(elem){
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var sell_rate = parseFloat(get_number($("#sell_rate_"+index).val(),2));
                var cost_rate = parseFloat(get_number($("#cost_rate_"+index).val(),2));

                // var cst = parseFloat(get_number($("#cst").val(),2));
                // var amount = qty*sell_rate;
                // var cost_amount = qty*cost_rate;
                // $("#amount_"+index).val(Math.round(amount*100)/100);

                // var cst_amt1 = parseFloat((amount*cst)/100);
                // $("#vat1_"+index).val((cst_amt1).toFixed(2));

                // var total_amt = parseFloat(cst_amt1+amount);
                // $("#total_amt_"+index).val((total_amt).toFixed(2));

                // $("#cost_total_amt_"+index).val((cost_amount).toFixed(2));

                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var cgst = parseFloat(get_number($("#cgst").val(),2));
                var sgst = parseFloat(get_number($("#sgst").val(),2));
                var igst = parseFloat(get_number($("#igst").val(),2));
                var amount = qty*sell_rate;
                var cost_amount = qty*cost_rate;
                var cgst_amt = parseFloat((amount*cgst)/100);
                var sgst_amt = parseFloat((amount*sgst)/100);
                var igst_amt = parseFloat((amount*igst)/100);
                var tax_amt = parseFloat((amount*tax_per)/100);
                // var tax_amt = cgst_amt+sgst_amt+igst_amt;

                $("#amount_"+index).val(amount.toFixed(2));
                $("#cgst_amt_"+index).val((cgst_amt).toFixed(2));
                $("#sgst_amt_"+index).val((sgst_amt).toFixed(2));
                $("#igst_amt_"+index).val((igst_amt).toFixed(2));
                $("#tax_amt_"+index).val((tax_amt).toFixed(2));

                var total_amt = parseFloat(tax_amt+amount);
                $("#total_amt_"+index).val((total_amt).toFixed(2));

                $("#cost_total_amt_"+index).val((cost_amount).toFixed(2));

                get_total();
            }

            function get_amount_ex(elem){
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_ex_"+index).val(),2));
                var sell_rate = parseFloat(get_number($("#sell_rate_ex_"+index).val(),2));
                var cost_rate = parseFloat(get_number($("#cost_rate_ex_"+index).val(),2));

                // var cst = parseFloat(get_number($("#cst").val(),2));
                // var amount = qty*sell_rate;
                // var cost_amount = qty*cost_rate;
                // $("#amount_ex_"+index).val(Math.round(amount*100)/100);

                // var cst_amt1 = parseFloat((amount*cst)/100);
                // $("#vat1_ex_"+index).val((cst_amt1).toFixed(2));

                // var total_amt = parseFloat(cst_amt1+amount);
                // $("#total_amt_ex_"+index).val((total_amt).toFixed(2));

                // $("#cost_total_amt_ex_"+index).val((cost_amount).toFixed(2));

                var tax_per = parseFloat(get_number($("#tax_per").val(),2));
                var cgst = parseFloat(get_number($("#cgst").val(),2));
                var sgst = parseFloat(get_number($("#sgst").val(),2));
                var igst = parseFloat(get_number($("#igst").val(),2));
                var amount = qty*sell_rate;
                var cost_amount = qty*cost_rate;
                var cgst_amt = parseFloat((amount*cgst)/100);
                var sgst_amt = parseFloat((amount*sgst)/100);
                var igst_amt = parseFloat((amount*igst)/100);
                var tax_amt = parseFloat((amount*tax_per)/100);
                // var tax_amt = cgst_amt+sgst_amt+igst_amt;

                $("#amount_ex_"+index).val(amount.toFixed(2));
                $("#cgst_amt_ex_"+index).val((cgst_amt).toFixed(2));
                $("#sgst_amt_ex_"+index).val((sgst_amt).toFixed(2));
                $("#igst_amt_ex_"+index).val((igst_amt).toFixed(2));
                $("#tax_amt_ex_"+index).val((tax_amt).toFixed(2));

                var total_amt = parseFloat(tax_amt+amount);
                $("#total_amt_ex_"+index).val((total_amt).toFixed(2));

                $("#cost_total_amt_ex_"+index).val((cost_amount).toFixed(2));
                
                get_total_ex();
            }

            function get_total(){
                var total_amount = 0;

                // var vat_amt=0;
                // var tot_amt=0;

                var cgst_amt=0;
                var sgst_amt=0;
                var igst_amt=0;
                var tax_amt=0;
                var final_amt=0;

                var cost_tot_amt=0;
                
                $('.amount').each(function(){
                    amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amount = total_amount + amount;
                });

                // $('.vat1').each(function(){
                //     vatamt = parseFloat(get_number($(this).val(),2));
                //     if (isNaN(vatamt)) vatamt=0;
                //     vat_amt = vat_amt + vatamt;
                // });

                // $('.total_amt').each(function(){
                //     totamt = parseFloat(get_number($(this).val(),2));
                //     if (isNaN(totamt)) totamt=0;
                //     tot_amt = tot_amt + totamt;
                // });

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

                $('.cost_total_amt').each(function(){
                    costtotamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(costtotamt)) costtotamt=0;
                    cost_tot_amt = cost_tot_amt + costtotamt;
                });

                // var cst = 0;
                // if($.trim($('#state').val()).toUpperCase()=="MAHARASHTRA"){
                //     cst = 6;
                // } else {
                //     cst = 2;
                // }

                // var cst = parseFloat(get_number($('#cst').val(),2));

                // var tax_amount = total_amount*cst/100;
                // var final_amount = total_amount + tax_amount;

                // $("#total_amount").val(Math.round(total_amount*100)/100);
                // $("#tax_amount").val(Math.round(vat_amt*100)/100);
                // $("#final_amount").val(Math.round(tot_amt*100)/100);
                // $("#cost_final_amount").val(Math.round(cost_tot_amt*100)/100);

                $("#total_amount").val(total_amount.toFixed(2));
                $("#cgst_amount").val(cgst_amt.toFixed(2));
                $("#sgst_amount").val(sgst_amt.toFixed(2));
                $("#igst_amount").val(igst_amt.toFixed(2));
                $("#tax_amount").val(tax_amt.toFixed(2));
                $("#final_amount").val(final_amt.toFixed(2));
                $("#cost_final_amount").val(cost_tot_amt.toFixed(2));
            }

            function get_total_ex(){
                var total_amount = 0;

                // var vat_amt=0;
                // var tot_amt=0;
                
                var cgst_amt=0;
                var sgst_amt=0;
                var igst_amt=0;
                var tax_amt=0;
                var final_amt=0;

                var cost_tot_amt=0;
                
                $('.amount_ex').each(function(){
                    amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amount = total_amount + amount;
                });

                // $('.vat1_ex').each(function(){
                //     vatamt = parseFloat(get_number($(this).val(),2));
                //     if (isNaN(vatamt)) vatamt=0;
                //     vat_amt = vat_amt + vatamt;
                // });

                // $('.total_amt_ex').each(function(){
                //     totamt = parseFloat(get_number($(this).val(),2));
                //     if (isNaN(totamt)) totamt=0;
                //     tot_amt = tot_amt + totamt;
                // });

                $('.cgst_amt_ex').each(function(){
                    cgstamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(cgstamt)) cgstamt=0;
                    cgst_amt = cgst_amt + cgstamt;
                });

                $('.sgst_amt_ex').each(function(){
                    sgstamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(sgstamt)) sgstamt=0;
                    sgst_amt = sgst_amt + sgstamt;
                });

                $('.igst_amt_ex').each(function(){
                    igstamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(igstamt)) igstamt=0;
                    igst_amt = igst_amt + igstamt;
                });

                $('.tax_amt_ex').each(function(){
                    taxamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(taxamt)) taxamt=0;
                    tax_amt = tax_amt + taxamt;
                });

                $('.total_amt_ex').each(function(){
                    finalamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(finalamt)) finalamt=0;
                    final_amt = final_amt + finalamt;
                });

                $('.cost_total_amt_ex').each(function(){
                    costtotamt = parseFloat(get_number($(this).val(),2));
                    if (isNaN(costtotamt)) costtotamt=0;
                    cost_tot_amt = cost_tot_amt + costtotamt;
                });

                // var cst = 0;
                // if($.trim($('#state').val()).toUpperCase()=="MAHARASHTRA"){
                //     cst = 6;
                // } else {
                //     cst = 2;
                // }

                // var cst = parseFloat(get_number($('#cst').val(),2));

                // var tax_amount = total_amount*cst/100;
                // var final_amount = total_amount + tax_amount;

                // $("#total_amount_ex").val(Math.round(total_amount*100)/100);
                // $("#tax_amount_ex").val(Math.round(vat_amt*100)/100);
                // $("#final_amount_ex").val(Math.round(tot_amt*100)/100);
                // $("#cost_final_amount_ex").val(Math.round(cost_tot_amt*100)/100);

                $("#total_amount_ex").val(total_amount.toFixed(2));
                $("#cgst_amount_ex").val(cgst_amt.toFixed(2));
                $("#sgst_amount_ex").val(sgst_amt.toFixed(2));
                $("#igst_amount_ex").val(igst_amt.toFixed(2));
                $("#tax_amount_ex").val(tax_amt.toFixed(2));
                $("#final_amount_ex").val(final_amt.toFixed(2));
                $("#cost_final_amount_ex").val(cost_tot_amt.toFixed(2));

                var round_off_amt = final_amt.toFixed(0) - final_amt.toFixed(2);

                $("#round_off_amount").val(round_off_amt.toFixed(2));
                $("#invoice_amount").val(final_amt.toFixed(0));
            }

            $(document).ready(function(){
                // $.each($('.vat1'), function(i, item) {
                //     var amount =  $('#amount_'+i).val();
                //     var cstperc = parseFloat($('#cst').val());
                //     var cst = parseFloat(amount*cstperc/100);
                //     if(cst==0 || isNaN(cst)) {
                //         $('#vat1_'+i).val(0);    
                //     }
                //     else {
                //         $('#vat1_'+i).val(cst.toFixed(2));
                //     }
                    
                //     // alert('f');
                // });
                // $.each($('.total_amt'), function(i, item) {
                //     var amount =  parseFloat($('#amount_'+i).val());
                //     var cst = parseFloat($('#vat1_'+i).val());
                //     var totamt1=parseFloat(amount+cst);
                //     if(isNaN(totamt1) || totamt1==0) {
                //         totamt1=0;
                //         $('#total_amt_'+i).val(totamt1);
                //     }
                //     else {
                //         $('#total_amt_'+i).val(totamt1.toFixed(2));
                //     }
                //     // alert(totamt1);
                // });

                $.each($('.cgst_amt'), function(i, item) {
                    var amount =  $('#amount_'+i).val();
                    var cgst = parseFloat($('#cgst').val());
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
                    var sgst = parseFloat($('#sgst').val());
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
                    var igst = parseFloat($('#igst').val());
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
                    var tax_per = parseFloat($('#tax_per').val());
                    var cgst = parseFloat($('#cgst').val());
                    var cgst_amt = parseFloat(amount*cgst/100);
                    var sgst = parseFloat($('#sgst').val());
                    var sgst_amt = parseFloat(amount*sgst/100);
                    var igst = parseFloat($('#igst').val());
                    var igst_amt = parseFloat(amount*igst/100);
                    var tax_amt = parseFloat(amount*tax_per/100);
                    // var tax_amt = cgst_amt+sgst_amt+igst_amt;
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


                // $.each($('.vat1_ex'), function(i, item) {
                //     var amount =  $('#amount_ex_'+i).val();
                //     var cstperc = parseFloat($('#cst').val());
                //     var cst = parseFloat(amount*cstperc/100);
                //     if(cst==0 || isNaN(cst)) {
                //         $('#vat1_ex_'+i).val(0);    
                //     }
                //     else {
                //         $('#vat1_ex_'+i).val(cst.toFixed(2));
                //     }
                    
                //     // alert('f');
                // });
                // $.each($('.total_amt_ex'), function(i, item) {
                //     var amount =  parseFloat($('#amount_ex_'+i).val());
                //     var cst = parseFloat($('#vat1_ex_'+i).val());
                //     var totamt1=parseFloat(amount+cst);
                //     if(isNaN(totamt1) || totamt1==0) {
                //         totamt1=0;
                //         $('#total_amt_ex_'+i).val(totamt1);
                //     }
                //     else {
                //         $('#total_amt_ex_'+i).val(totamt1.toFixed(2));
                //     }
                //     // alert(totamt1);
                // });

                $.each($('.cgst_amt_ex'), function(i, item) {
                    var amount =  $('#amount_ex_'+i).val();
                    var cgst = parseFloat($('#cgst').val());
                    var cgst_amt = parseFloat(amount*cgst/100);
                    if(cgst_amt==0 || isNaN(cgst_amt)) {
                        $('#cgst_amt_ex_'+i).val(0);    
                    }
                    else {
                        $('#cgst_amt_ex_'+i).val(cgst_amt.toFixed(2));
                    }
                    // alert(tax_per);
                });
                $.each($('.sgst_amt_ex'), function(i, item) {
                    var amount =  $('#amount_ex_'+i).val();
                    var sgst = parseFloat($('#sgst').val());
                    var sgst_amt = parseFloat(amount*sgst/100);
                    if(sgst_amt==0 || isNaN(sgst_amt)) {
                        $('#sgst_amt_ex_'+i).val(0);    
                    }
                    else {
                        $('#sgst_amt_ex_'+i).val(sgst_amt.toFixed(2));
                    }
                    // alert(tax_per);
                });
                $.each($('.igst_amt_ex'), function(i, item) {
                    var amount =  $('#amount_ex_'+i).val();
                    var igst = parseFloat($('#igst').val());
                    var igst_amt = parseFloat(amount*igst/100);
                    if(igst_amt==0 || isNaN(igst_amt)) {
                        $('#igst_amt_ex_'+i).val(0);    
                    }
                    else {
                        $('#igst_amt_ex_'+i).val(igst_amt.toFixed(2));
                    }
                    // alert(tax_per);
                });
                $.each($('.tax_amt_ex'), function(i, item) {
                    var amount =  $('#amount_ex_'+i).val();
                    var tax_per = parseFloat($('#tax_per').val());
                    var cgst = parseFloat($('#cgst').val());
                    var cgst_amt = parseFloat(amount*cgst/100);
                    var sgst = parseFloat($('#sgst').val());
                    var sgst_amt = parseFloat(amount*sgst/100);
                    var igst = parseFloat($('#igst').val());
                    var igst_amt = parseFloat(amount*igst/100);
                    var tax_amt = parseFloat(amount*tax_per/100);
                    // var tax_amt = cgst_amt+sgst_amt+igst_amt;
                    if(tax_amt==0 || isNaN(tax_amt)) {
                        $('#tax_amt_ex_'+i).val(0);    
                    }
                    else {
                        $('#tax_amt_ex_'+i).val(tax_amt.toFixed(2));
                    }
                    // alert(tax_per);
                });
                $.each($('.total_amt_ex'), function(i, item) {
                    var amount =  parseFloat($('#amount_ex_'+i).val());
                    var tax_amt = parseFloat($('#tax_amt_'+i).val());
                    var totamt1=parseFloat(amount+tax_amt);
                    if(isNaN(totamt1) || totamt1==0) {
                        totamt1=0;
                        $('#total_amt_ex_'+i).val(totamt1);
                    }
                    else {
                        $('#total_amt_ex_'+i).val(totamt1.toFixed(2));
                    }
                    // alert(totamt1);
                });


                $('#exchanged').change(function() {
                    if($(this).is(":checked")) {
                        $('.exc_table').show();
                    }
                    else {
                        $('.exc_table').hide();
                    }    
                });
            });

            jQuery(function(){
                if($('#exchanged').is(":checked")) {
                    $('.exc_table').show();
                } else {
                    $('.exc_table').hide();
                }

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
                                            '<td class="print_hide">' + 
                                                '&nbsp;' + 
                                            '</td>' +
                                            '<td>' + 
                                                'Total' + 
                                            '</td>' + 
                                            '<td style="display: none;" class="print_hide">' + 
                                                '<input type="text" class="form-control grams" name="grams[]" id="grams_'+counter+'" placeholder="Grams" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<!-- <td>' + 
                                                '<input type="text" class="form-control" name="tax_amount" id="tax_amount" placeholder="CST Amount" value="<?php //if (isset($data)) { echo $data[0]->tax_amount; } ?>" readonly />' + 
                                            '</td> -->' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="cgst_amount" id="cgst_amount" placeholder="CGST Amount" value="<?php if (isset($data)) { echo $data[0]->cgst_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="sgst_amount" id="sgst_amount" placeholder="SGST Amount" value="<?php if (isset($data)) { echo $data[0]->sgst_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="igst_amount" id="igst_amount" placeholder="IGST Amount" value="<?php if (isset($data)) { echo $data[0]->igst_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="tax_amount" id="tax_amount" placeholder="Tax Amount" value="<?php if (isset($data)) { echo $data[0]->tax_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control" name="final_amount" id="final_amount" placeholder="Final Amount" value="<?php if(isset($data)) { echo $data[0]->final_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control" name="cost_final_amount" id="cost_final_amount" placeholder="Cost Final Amount" value="<?php if(isset($data)) { echo $data[0]->final_cost_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td style="text-align:center;">' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td style="text-align:center;" class="print_hide">' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                        '</tr>');
                $('#box_details').append(newRow1);

                var newRow1_ex;
                newRow1_ex = jQuery('<tr id="box row">' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '&nbsp;' + 
                                            '</td>' +
                                            '<td>' + 
                                                'Total' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control grams" name="grams_ex[]" id="grams_ex_'+counter+'" placeholder="Grams" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="total_amount_ex" id="total_amount_ex" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<!-- <td>' + 
                                                '<input type="text" class="form-control" name="tax_amount_ex" id="tax_amount_ex" placeholder="CST Amount" value="<?php //if (isset($data)) { echo $data[0]->tax_amount; } ?>" readonly />' + 
                                            '</td> -->' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="cgst_amoun_ex" id="cgst_amount_ex" placeholder="CGST Amount" value="<?php if (isset($data)) { echo $data[0]->cgst_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="sgst_amount_ex" id="sgst_amount_ex" placeholder="SGST Amount" value="<?php if (isset($data)) { echo $data[0]->sgst_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="igst_amount_ex" id="igst_amount_ex" placeholder="IGST Amount" value="<?php if (isset($data)) { echo $data[0]->igst_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control" name="tax_amount_ex" id="tax_amount_ex" placeholder="Tax Amount" value="<?php if (isset($data)) { echo $data[0]->tax_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control" name="final_amount_ex" id="final_amount_ex" placeholder="Final Amount" value="<?php if(isset($data)) { echo $data[0]->final_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control" name="cost_final_amount_ex" id="cost_final_amount_ex" placeholder="Cost Final Amount" value="<?php if(isset($data)) { echo $data[0]->final_cost_amount; } ?>" readonly />' + 
                                            '</td>' + 
                                            '<td style="text-align:center;" class="print_hide">' + 
                                                '&nbsp;' + 
                                            '</td>' + 
                                        '</tr>');
                $('#box_details_ex').append(newRow1_ex);

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
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_'+counter+'" placeholder="Sell Rate" value=""/>' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control cost_rate" name="cost_rate[]" id="cost_rate_'+counter+'" placeholder="Cost Rate" value=""/>' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control grams" name="grams[]" id="grams_'+counter+'" placeholder="Grams" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<!-- <td>' + 
                                                '<input type="text" class="form-control vat1" name="vat1[]" id="vat1_'+counter+'" placeholder="VAT" value="" readonly />' + 
                                            '</td> -->' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_'+counter+'" placeholder="CGST Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_'+counter+'" placeholder="SGST Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_'+counter+'" placeholder="IGST Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_'+counter+'" placeholder="VAT" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_'+counter+'" placeholder="Total Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control cost_total_amt" name="cost_total_amt[]" id="cost_total_amt_'+counter+'" placeholder="Cost Total Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<select name="batch_no[]" class="form-control batch_no" id="batch_no_'+counter+'" data-error="#err_batch_no_'+counter+'">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php if(isset($batch)) { for ($k=0; $k < count($batch); $k++) { ?>' + 
                                                            '<option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<div id="err_batch_no_'+counter+'"></div>' + 
                                            '</td>' + 
                                            '<td style="text-align:center;" class="print_hide">' + 
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
                    // $(".cost_rate").blur(function(){
                    //     get_amount($(this));
                    // });
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                        get_total();
                    });
                    counter++;
                });

                $('#repeat-box_ex').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="box_ex_'+counter+'_row">' + 
                                            '<td>' + 
                                                '<select name="type_ex[]" class="form-control type_ex" id="type_ex_'+counter+'">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<option value="Bar">Bar</option>' + 
                                                    '<option value="Box">Box</option>' + 
                                                '</select>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<select name="bar_ex[]" class="form-control bar_ex" id="bar_ex_'+counter+'" data-error="#err_item_'+counter+'" style="">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->product_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<select name="box_ex[]" class="form-control box_ex" id="box_ex_'+counter+'" data-error="#err_item_'+counter+'" style="display: none;">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->box_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<div id="err_item_'+counter+'"></div>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control qty_ex" name="qty_ex[]" id="qty_ex_'+counter+'" placeholder="Qty" value=""/>' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control rate_ex" name="rate_ex[]" id="rate_ex_'+counter+'" placeholder="Rate" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control sell_rate_ex" name="sell_rate_ex[]" id="sell_rate_ex_'+counter+'" placeholder="Sell Rate" value=""/>' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control cost_rate_ex" name="cost_rate_ex[]" id="cost_rate_ex_'+counter+'" placeholder="Cost Rate" value=""/>' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control grams_ex" name="grams_ex[]" id="grams_ex_'+counter+'" placeholder="Grams" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control amount_ex" name="amount_ex[]" id="amount_ex_'+counter+'" placeholder="Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<!-- <td>' + 
                                                '<input type="text" class="form-control vat1_ex" name="vat1_ex[]" id="vat1_ex_'+counter+'" placeholder="VAT" value="" readonly />' + 
                                            '</td> -->' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control cgst_amt_ex" name="cgst_amt_ex[]" id="cgst_amt_ex_'+counter+'" placeholder="CGST Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control sgst_amt_ex" name="sgst_amt_ex[]" id="sgst_amt_ex_'+counter+'" placeholder="SGST Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control igst_amt_ex" name="igst_amt_ex[]" id="igst_amt_ex_'+counter+'" placeholder="IGST Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="print_hide">' + 
                                                '<input type="text" class="form-control tax_amt_ex" name="tax_amt_ex[]" id="tax_amt_ex_'+counter+'" placeholder="VAT" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control total_amt_ex" name="total_amt_ex[]" id="total_amt_ex_'+counter+'" placeholder="Total Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control cost_total_amt_ex" name="cost_total_amt_ex[]" id="cost_total_amt_ex_'+counter+'" placeholder="Cost Total Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="text-align:center;" class="print_hide">' + 
                                                '<a id="box_ex_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#box_details_ex').append(newRow);
                    $('#box_details_ex').append(newRow1_ex);
                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    $(".type_ex").change(function(){
                        show_item_ex($(this));
                    });
                    $(".bar_ex").change(function(){
                        get_bar_details_ex($(this));
                    });
                    $(".box_ex").change(function(){
                        get_box_details_ex($(this));
                    });
                    $(".qty_ex").blur(function(){
                        get_amount_ex($(this));
                    });
                    $(".sell_rate_ex").blur(function(){
                        get_amount_ex($(this));
                    });
                    // $(".cost_rate").blur(function(){
                    //     get_amount($(this));
                    // });
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                        get_total_ex();
                    });
                    counter++;
                });
            });


    // $('#savedata').click(function(){
    //     var in_amt=$('#final_amount').val();
    //     var out_amt=$('#final_amount_ex').val();

    //     if(in_amt!="" && out_amt!="") {
    //         if(in_amt==out_amt) {
    //            $('#form_distributor_in_details').submit();
    //            // alert("Total");
    //         }
    //         else {
    //             alert("Total amounts does not match");
    //         }
    //     }
    // });
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>