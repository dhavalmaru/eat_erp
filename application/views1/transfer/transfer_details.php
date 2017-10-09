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
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr{display: block;
			float: left;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 10px;
			border-color: #BDBDBD;}
			th{text-align:center;}
			.center{text-align:center;}
		</style>
		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <?php $this->load->view('templates/menus');?>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
					
						<div class="col-md-1">&nbsp;</div>
						
                        <div class="col-md-10">
						<div class="panel panel-default">
							
                            <form id="form_transfer_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/transfer/update/' . $data[0]->id; else echo base_url().'index.php/transfer/save'; ?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Transfer Details</strong></h3>
                                </div>
								
								<div class="panel-body">
									<div class="form-group" style="border-top:1px dotted #ddd;">
										<div class="col-md-12">
											<label class="col-md-2 control-label">Date Of Transfer <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control datepicker1" name="date_of_transfer" id="date_of_transfer" placeholder="Date Of Transfer" value="<?php if(isset($data)) echo (($data[0]->date_of_transfer!=null && $data[0]->date_of_transfer!='')?date('d/m/Y',strtotime($data[0]->date_of_transfer)):'');?>"/>
                                            </div>
                                            <label class="col-md-2 control-label">Depot Out <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="hidden" name="depot_out_id" id="depot_out_id" value="<?php if(isset($data)) { echo  $data[0]->depot_out_id; } ?>"/>
                                                <input type="text" class="form-control load_depot" name="depot_out" id="depot_out" placeholder="Type To Select Depot...." value="<?php if(isset($data)) { echo  $data[0]->depot_out_name; } ?>"/>
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">Item <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="item" id="item">
                                                    <option value="Raw Material" <?php if(isset($data)) {if ($data[0]->item=='Raw Material') echo 'selected';}?>>Raw Material</option>
                                                    <option value="Product" <?php if(isset($data)) {if ($data[0]->item=='Product') echo 'selected';}?>>Product</option>
                                                </select>
                                            </div>
                                            <div id="raw_material_div" style="<?php if(isset($data)) {if ($data[0]->item=='Product') echo 'display: none;';} ?>">
                                                <label class="col-md-2 control-label">Raw Material <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="hidden" name="raw_material_id" id="raw_material_id" value="<?php if(isset($data)) { echo  $data[0]->raw_material_id; } ?>"/>
                                                    <input type="text" class="form-control load_raw_material" name="raw_material" id="raw_material" placeholder="Type To Select Raw Material...." value="<?php if(isset($data)) { echo  $data[0]->rm_name; } ?>"/>
                                                </div>
                                            </div>
                                            <div id="batch_div" style="<?php if(isset($data)) {if ($data[0]->item=='Product') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>">
                                                <label class="col-md-2 control-label">Batch Id <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="hidden" name="batch_id" id="batch_id" value="<?php if(isset($data)) { echo $data[0]->batch_id; } ?>"/>
                                                    <input type="text" class="form-control load_batch" name="batch" id="batch" placeholder="Type To Select Batch...." value="<?php if(isset($data)) { echo  $data[0]->batch_id_as_per_fssai; } ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="product_div" style="<?php if(isset($data)) {if ($data[0]->item=='Product') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">Product <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="hidden" name="product_id" id="product_id" value="<?php if(isset($data)) { echo  $data[0]->product_id; } ?>"/>
                                                <input type="text" class="form-control load_product" name="product" id="product" placeholder="Type To Select Product...." value="<?php if(isset($data)) { echo  $data[0]->product_name; } ?>"/>
                                            </div>
                                            <label class="col-md-2 control-label">Product Type <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="product_type" id="product_type">
                                                    <option value="">Select</option>
                                                    <option value="Bar" <?php if(isset($data)) {if ($data[0]->product_type=='Bar') echo 'selected';}?>>Bar</option>
                                                    <option value="Box" <?php if(isset($data)) {if ($data[0]->product_type=='Box') echo 'selected';}?>>Box</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">Qty <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control format_number" name="qty" id="qty" placeholder="Qty" value="<?php if (isset($data)) { echo format_money($data[0]->qty,2); } ?>"/>
                                            </div>
                                            <label class="col-md-2 control-label">Depot In <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="hidden" name="depot_in_id" id="depot_in_id" value="<?php if(isset($data)) { echo  $data[0]->depot_in_id; } ?>"/>
                                                <input type="text" class="form-control load_depot" name="depot_in" id="depot_in" placeholder="Type To Select Depot...." value="<?php if(isset($data)) { echo  $data[0]->depot_in_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                        <div class="col-md-12">
                                            <div style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                                <label class="col-md-2 control-label">Status <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="status">
                                                        <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Active</option>
                                                        <option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">Remarks </label>
                                            <div class="col-md-6">
                                                <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/transfer" class="btn btn-default" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-primary pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
							</form>
							
						</div>
						</div>
						
						<div class="col-md-1"></div>
						
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
                $("#item").change(function(){
                    if($("#item").val()=="Product"){
                        $("#raw_material").val("");
                        $("#raw_material_id").val("");
                        $("#product_div").show();
                        $("#batch_div").show();
                        $("#raw_material_div").hide();
                    } else {
                        $("#product").val("");
                        $("#product_id").val("");
                        $("#product_type").val("");
                        $("#batch").val("");
                        $("#batch_id").val("");
                        $("#product_div").hide();
                        $("#batch_div").hide();
                        $("#raw_material_div").show();
                    }
                });
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
            });
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>