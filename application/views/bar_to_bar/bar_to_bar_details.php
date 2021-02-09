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
		</style>
    </head>
    <body>								
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/bar_to_bar'; ?>" >Bar To Bar List </a>  &nbsp; &#10095; &nbsp; Bar To Bar Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
				    <div class="main-container">           
                    <div class="box-shadow">
                        <form id="form_bar_to_bar_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/bar_to_bar/update/' . $data[0]->id; else echo base_url().'index.php/bar_to_bar/save'; ?>">
                            <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
							    <div class="panel-body">
								<div class="form-group">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Transfer <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="module" id="module" value="<?php if(isset($module)) echo $module;?>"/>
                                            <input type="text" class="form-control datepicker1" name="date_of_transfer" id="date_of_transfer" placeholder="Date Of Transfer" value="<?php if(isset($data)) echo (($data[0]->date_of_transfer!=null && $data[0]->date_of_transfer!='')?date('d/m/Y',strtotime($data[0]->date_of_transfer)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
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
                                            <input type="hidden" name="prev_depo" id="prev_depo" value="<?php if(isset($data)) { echo  $data[0]->depot_id; } ?>"/>
                                        </div>
									</div>
								</div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Batch <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="batch_no" id="batch_no" class="form-control">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch); $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>" <?php if(isset($data)) { if($batch[$k]->id==$data[0]->batch_no) { echo 'selected'; } } ?> ><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Product Out <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="product_out_id" id="product_out_id" class="form-control select2" onchange="get_product_qty('out');">
                                                <option value="">Select</option>
                                                <?php if(isset($product)) { for ($k=0; $k < count($product) ; $k++) { ?>
                                                        <option value="<?php echo $product[$k]->id; ?>" <?php if(isset($data)) { if($product[$k]->id==$data[0]->product_out_id) { echo 'selected'; } } ?>><?php echo $product[$k]->product_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Quantity</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label" id="product_out_qty">0</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Product In <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="product_in_id" id="product_in_id" class="form-control select2" onchange="get_product_qty('in');">
                                                <option value="">Select</option>
                                                <?php if(isset($product)) { for ($k=0; $k < count($product) ; $k++) { ?>
                                                        <option value="<?php echo $product[$k]->id; ?>" <?php if(isset($data)) { if($product[$k]->id==$data[0]->product_in_id) { echo 'selected'; } } ?>><?php echo $product[$k]->product_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                            <input type="hidden" name="prev_product" id="prev_product" value="<?php if(isset($data)) { echo  $data[0]->product_in_id; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Quantity</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label" id="product_in_qty">0</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Quantity <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control format_number qty" name="qty" id="qty" placeholder="Qty" value="<?php if (isset($data)) { echo format_money($data[0]->qty,2); } ?>"/>
                                            <input type="hidden" name="prev_qty" id="prev_qty" value="<?php if(isset($data)) { echo  $data[0]->qty; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
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
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
							</div>
							</div>
                            </div>
                            <div class="panel-footer">
                                <a href="<?php echo base_url().'index.php/bar_to_bar'; ?>" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
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
                $("#depot_id").change(function(){
                    var res = check_product_qty(); 
                    if(res==false){
                        var validator = $("#form_bar_to_bar_details").validate();
                        var id = "depot_id";
                        var errors = {};
                        var name = $("#"+id).attr('name');
                        errors[name] = "Stock Will Be Negative";
                        validator.showErrors(errors);

                        var previous_val = $("#prev_depo").val();
                        $("#depot_id").val(previous_val);
                    } else {
                        get_product_qty('out');
                        get_product_qty('in');
                    }
                });

                $("#product_in_id").change(function(){
                    var res = check_product_qty(); 
                    if(res==false){
                        var validator = $("#form_bar_to_bar_details").validate();
                        var id = "product_in_id";
                        var errors = {};
                        var name = $("#"+id).attr('name');
                        errors[name] = "Stock Will Be Negative";
                        validator.showErrors(errors);

                        var previous_val = $("#prev_product").val();
                        $("#product_in_id").val(previous_val);
                        $("#product_in_id").select2();
                    } else {
                        get_product_qty('out');
                        get_product_qty('in');
                    }
                });

                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });

                get_product_qty('out');
                get_product_qty('in');
            });

            var check_product_qty = function() {
                var depot_id = $('#prev_depo').val();
                var product_id = $('#prev_product').val();
                var module = 'bar_to_bar';
                var result = true;

                $.ajax({
                    url: BASE_URL+'index.php/Stock/get_depot_bar_qty',
                    data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&product_id='+product_id,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        if(data.result) {
                            var qty = parseFloat(data.qty[0]);
                            if(qty<0) {
                                result = false;
                            }
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                return result;
            }

            var get_product_qty = function(method) {
                var depot_id = $('#depot_id').val();
                var product_id = $('#product_'+method+'_id').val();
                var module = 'bar_to_bar';

                if(depot_id!='' && product_id!='') {
                    $.ajax({
                        url: BASE_URL+'index.php/Stock/get_depot_bar_qty',
                        data: 'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&product_id='+product_id,
                        type: "POST",
                        dataType: 'json',
                        global: false,
                        async: false,
                        success: function (data) {
                            if(data.result) {
                                $('#product_'+method+'_qty').html(data.qty[0]);
                            } else {
                                $('#product_'+method+'_qty').html(0);
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });
                }
            }
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>