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
            input[readonly] {background-color: white !important; 
                            color: #0b385f !important; 
                            cursor: not-allowed !important;}
            @media screen and (max-width:800px) {
               .h-scroll { overflow-x:scroll;} .h-scroll .table-stripped{ width:806px!important;}
            }
            .form-control[disabled] {
                color: #245478;
                background-color: white;
            }
		</style>
		
		<style>
            @media 
            only screen and (max-width: 760px),
            (min-device-width: 768px) and (max-device-width: 1024px)  {

            	/* Force table to not be like tables anymore */
            	table, thead, tbody, th, td, tr { 
            		display: block; 
            		width:100%;
            	}
            	
            	.h-scroll .table-stripped{
            		width: 100% !important
            	}
            	
            	/* Hide table headers (but not display: none;, for accessibility) */
            	thead tr { 
            		position: absolute;
            		top: -9999px;
            		left: -9999px;
            	}
            	
            	tr { border: 1px solid #ccc; }
            	
            	td { 
            		/* Behave  like a "row" */
            		border: none;
            		border-bottom: 1px solid #eee; 
            		position: relative;
            		padding-left: 50%; 
            	}
            	
            	td:before { 
            		/* Now like a table header */
            		position: absolute;
            		/* Top/left values mimic padding */
            		top: 6px;
            		left: 6px;
            		width: 45%; 
            		padding-right: 10px; 
            		white-space: nowrap;
            	}
            	
            	/*
            	Label the data
            	
            	td:nth-of-type(1):before { content: "Type"; }
            	td:nth-of-type(2):before { content: "Item"; }
            	td:nth-of-type(3):before { content: "Qty"; }
            	*/
            }
		</style>
    </head>
    <body>
        <div class="page-container page-navigation-top">
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2">
                    <a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Offer Data
                </div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
				    <div class="main-container">           
                    <div class="box-shadow">	
                        <form id="form_offer_data" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/order/set_offer_data'; ?>">
                            <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
							
							<div class="panel-body">
								<div class="form-group" >
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label class="col-md-2 col-sm-2 col-xs-12 control-label">Phone <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="secret_key" id="secret_key" value="MzE1NDE=" />
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="<?php if(isset($data)) echo $data[0]->phone; ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Offer Id<span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="offer_id" id="offer_id" placeholder="Offer Id" value="<?php if (isset($data)) { echo $data[0]->offer_id; } ?>" />
                                        </div>
									</div>
								</div>
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">order_id <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="order_id" id="order_id" placeholder="order_id" value="<?php if(isset($data)) { echo $data[0]->order_id; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">customer_name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="customer_name" value="<?php if(isset($data)) { echo $data[0]->customer_name; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">shipping_address_line1 <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="shipping_address_line1" id="shipping_address_line1" placeholder="shipping_address_line1" value="<?php if(isset($data)) { echo $data[0]->shipping_address_line1; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">shipping_address_line2 <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="shipping_address_line2" id="shipping_address_line2" placeholder="shipping_address_line2" value="<?php if(isset($data)) { echo $data[0]->shipping_address_line2; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">shipping_address_email <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="shipping_address_email" id="shipping_address_email" placeholder="shipping_address_email" value="<?php if(isset($data)) { echo $data[0]->shipping_address_email; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">shipping_address_phone <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="shipping_address_phone" id="shipping_address_phone" placeholder="shipping_address_phone" value="<?php if(isset($data)) { echo $data[0]->shipping_address_phone; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">shipping_address_pincode <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="shipping_address_pincode" id="shipping_address_pincode" placeholder="shipping_address_pincode" value="<?php if(isset($data)) { echo $data[0]->shipping_address_pincode; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">shipping_address_city <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="shipping_address_city" id="shipping_address_city" placeholder="shipping_address_city" value="<?php if(isset($data)) { echo $data[0]->shipping_address_city; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">shipping_address_state <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="shipping_address_state" id="shipping_address_state" placeholder="shipping_address_state" value="<?php if(isset($data)) { echo $data[0]->shipping_address_state; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">order_SKU <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="order_SKU" id="order_SKU" placeholder="order_SKU" value="<?php if(isset($data)) { echo $data[0]->order_SKU; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">order_sales_value<span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="order_sales_value" id="order_sales_value" placeholder="order_sales_value" value="<?php if (isset($data)) { echo $data[0]->order_sales_value; } ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="<?php echo 'display: none;';?>">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="<?php echo 'display: none;';?>">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="status">
                                                    <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Active</option>
                                                    <option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
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
                            <div class="panel-footer">
								<a href="<?php echo base_url(); ?>index.php/order" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                <input type="submit" class="btn btn-success pull-right" name="submit" value="Save" />
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
    </body>
</html>