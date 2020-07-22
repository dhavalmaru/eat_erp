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
            .form-control[disabled], .form-control[readonly]
			{
				border:none!important;
				background-color:transparent!important;
				box-shadow:none!important;
			}
            #total_amount,#total_grams
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
                <div class="heading-h2">
                    <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; 
                    <a href="<?php echo base_url().'index.php/combo_box'; ?>" > Combo Box List </a>  &nbsp; &#10095; &nbsp; Combo Box Details
                </div>
				   
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                            <form id="form_combo_box_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/combo_box/update/' . $data[0]->id; else echo base_url().'index.php/combo_box/save'; ?>">
                          
							   <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
							     	<div class="panel-body">
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Combo Box Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) { echo  $data[0]->id; } ?>"/>
                                                <input type="text" class="form-control" name="combo_box_name" id="combo_box_name" placeholder="Combo Box Name" value="<?php if(isset($data)) { echo  $data[0]->combo_box_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Barcode <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" value="<?php if(isset($data)) { echo $data[0]->barcode; } ?>"/>
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Short Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="short_name" id="short_name" placeholder="Short Name" value="<?php if(isset($data)) { echo $data[0]->short_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">ASIN <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="asin" id="asin" placeholder="ASIN" value="<?php if(isset($data)) { echo $data[0]->asin; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">SKU Code <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="sku_code" id="sku_code" placeholder="SKU Code" value="<?php if(isset($data)) { echo $data[0]->sku_code; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="h-scroll">	
                                    <div class="table-stripped form-group" style="padding:15px;" >
									
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th>Type <span class="asterisk_sign">*</span></th>
                                                <th>Item <span class="asterisk_sign">*</span></th>
                                                <th>Qty <span class="asterisk_sign">*</span></th>
                                                <th>Grams</th>
                                                <th>Rate (In Rs)</th>
                                                <th>Amount (In Rs)</th>
                                                <th style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="combo_box_details">
                                        <?php $i=0; if(isset($combo_box_items)) {
                                                for($i=0; $i<count($combo_box_items); $i++) { ?>
                                            <tr id="combo_box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="type[]" class="form-control type" id="type_<?php echo $i;?>" counter="<?php echo $i; ?>">
                                                        <option value="">Select</option>
                                                        <option value="Bar" <?php if($combo_box_items[$i]->type=="Bar") { echo 'selected'; } ?>>Bar</option>
                                                        <option value="Box" <?php if($combo_box_items[$i]->type=="Box") { echo 'selected'; } ?>>Box</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="bar[]" class="form-control bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($combo_box_items[$i]->type=="Box") { echo 'display: none;'; } ?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                <option value="<?php echo $bar[$k]->id; ?>" <?php if($combo_box_items[$i]->type=="Bar" && $bar[$k]->id==$combo_box_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $bar[$k]->product_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <select name="box[]" class="form-control box" id="box_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($combo_box_items[$i]->type=="Bar") { echo 'display: none;'; } ?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                <option value="<?php echo $box[$k]->id; ?>" <?php if($combo_box_items[$i]->type=="Box" && $box[$k]->id==$combo_box_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $box[$k]->box_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control format_number qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($combo_box_items)) { echo format_money($combo_box_items[$i]->qty,2); } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control format_number grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="<?php if (isset($combo_box_items)) { echo format_money($combo_box_items[$i]->grams,2); } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control format_number rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($combo_box_items)) { echo format_money($combo_box_items[$i]->rate,2); } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control format_number amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($combo_box_items)) { echo format_money($combo_box_items[$i]->amount,2); } ?>" readonly />
                                                </td>
                                             <td style="text-align:center;     vertical-align: middle;">
                                                  <a id="combo_box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="combo_box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="type[]" class="form-control type" id="type_<?php echo $i;?>" counter="<?php echo $i; ?>">
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
                                                    <input type="text" class="form-control format_number qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control format_number grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control format_number rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control format_number amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                               <td style="text-align:center;     vertical-align: middle;">
                                                    <a id="combo_box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7">
                                                    <button type="button" class="btn btn-success" id="repeat-item" style=" ">+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
										</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Grams </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="total_grams" id="total_grams" placeholder="Total Grams" value="<?php if (isset($data)) { echo format_money($data[0]->grams,2); } ?>" readonly />
                                            </div>
                                        
								
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs)</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo format_money($data[0]->amount,2); } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Combo Box Rate (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="combo_box_rate" id="combo_box_rate" placeholder="Combo Box Rate" value="<?php if (isset($data)) { echo format_money($data[0]->rate,2); } ?>" />
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" style="display: none;">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <div>
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Combo Box Cost (In Rs) <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="text" class="form-control format_number" name="combo_box_cost" id="combo_box_cost" placeholder="Combo Box Cost" value="<?php if (isset($data)) { echo format_money($data[0]->cost,2); } ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">HSN Code <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="hsn_code" id="hsn_code" placeholder="HSN Code" value="<?php if(isset($data)) { echo  $data[0]->hsn_code; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" style="display: none;">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">HSN Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="hsn_name" id="hsn_name" placeholder="HSN Name" value="<?php if(isset($data)) { echo $data[0]->hsn_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Category<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <select class="form-control" name="category_id" id="category_id">
                                                <option value="" >Select</option>
                                                 <?php 
                                                 for ($i=0; $i <count($category_detail) ; $i++) { 
                                                       $selected = '';
                                                       if(isset($data)) {if ($category_detail[$i]->id==$data[0]->category_id){ $selected = 'selected';}}
                                                        echo '<option value="'.$category_detail[$i]->id.'" '.$selected.'>'.$category_detail[$i]->category_name.'</option>';
                                                      } ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tax (In %) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control tax_percent" name="tax_percentage" id="tax_percentage" placeholder="Tax Percent"   onkeypress="return StopNonNumeric(this,event)" value="<?php
                                                                  if(isset($data[0]->tax_percentage)) { echo $data[0]->tax_percentage; } ?>"/>
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
									<br clear="all"/>
								</div>
							  </div>
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/combo_box" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
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
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });
                
                addMultiInputNamingRules('#form_combo_box_details', 'select[name="type[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_combo_box_details', 'select[name="bar[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_combo_box_details', 'select[name="box[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_combo_box_details', 'input[name="qty[]"]', { required: true }, "");
            });

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

            function get_bar_details(elem){
                var product_id = elem.val();
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var grams_in_bar = 0;
                var rate = 0;

                $.ajax({
                    url:BASE_URL+'index.php/Product/get_data',
                    method:"post",
                    data:{id:product_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams_in_bar = parseFloat(data.grams);
                            rate = parseFloat(data.rate);
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
                if (isNaN(grams_in_bar)) grams_in_bar=0;
                if (isNaN(rate)) rate=0;

                var amount = qty*rate;
                $("#grams_"+index).val(format_money(grams_in_bar,2));
                $("#rate_"+index).val(format_money(rate,2));
                $("#amount_"+index).val(format_money(amount,2));

                get_total();
            }

            function get_box_details(elem){
                var box_id = elem.val();
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
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
                            grams_in_bar = parseFloat(data.grams);
                            rate = parseFloat(data.rate);
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
                if (isNaN(grams_in_bar)) grams_in_bar=0;
                if (isNaN(rate)) rate=0;

                var amount = qty*rate;
                $("#grams_"+index).val(format_money(grams_in_bar,2));
                $("#rate_"+index).val(format_money(rate,2));
                $("#amount_"+index).val(format_money(amount,2));

                get_total();
            }

            function get_amount(elem){
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                var amount = qty*rate;
                $("#amount_"+index).val(format_money(amount,2));

                get_total();
            }

            function get_total(){
                var total_grams = 0;
                $('.grams').each(function(){
                    var elem = $(this);
                    var id = elem.attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                    grams = parseFloat(get_number($(this).val(),2));
                    if (isNaN(qty)) qty=0;
                    if (isNaN(grams)) grams=0;
                    total_grams = total_grams + (qty*grams);
                });

                var total_amount = 0;
                $('.amount').each(function(){
                    amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amount = total_amount + amount;
                });

                $("#total_grams").val(format_money(total_grams,2));
                $("#total_amount").val(format_money(total_amount,2));
            }

            jQuery(function(){
                var counter = $('.type').length;
                $('#repeat-item').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="combo_box_'+counter+'_row">'+
                                            '<td>'+
                                                '<select name="type[]" class="form-control type" id="type_'+counter+'" counter="'+counter+'">'+
                                                    '<option value="">Select</option>'+
                                                    '<option value="Bar">Bar</option>'+
                                                    '<option value="Box">Box</option>'+
                                                '</select>'+
                                            '</td>'+
                                            '<td>'+
                                                '<select name="bar[]" class="form-control bar" id="bar_'+counter+'" data-error="#err_item_'+counter+'" style="">'+
                                                    '<option value="">Select</option>'+
                                                    '<?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>'+
                                                            '<option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->product_name; ?></option>'+
                                                    '<?php }} ?>'+
                                                '</select>'+
                                                '<select name="box[]" class="form-control box" id="box_'+counter+'" data-error="#err_item_'+counter+'" style="display: none;">'+
                                                    '<option value="">Select</option>'+
                                                    '<?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>'+
                                                            '<option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->box_name; ?></option>'+
                                                    '<?php }} ?>'+
                                                '</select>'+
                                                '<div id="err_item_'+counter+'"></div>'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control format_number qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value=""/>'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control format_number grams" name="grams[]" id="grams_'+counter+'" placeholder="Grams" value="" readonly />'+
                                                '<!-- <span id="grams_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control format_number rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" readonly />'+
                                                '<!-- <span id="rate_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control format_number amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />'+
                                                '<!-- <span id="amount_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '   <td style="text-align:center;     vertical-align: middle;">'+
                                                '<a id="combo_box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                            '</td>'+
                                        '</tr>');
                    $('#combo_box_details').append(newRow);
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