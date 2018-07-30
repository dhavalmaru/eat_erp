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
                    <a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; 
                    <a href="<?php echo base_url().'index.php/order'; ?>" >Order List </a>  &nbsp; &#10095; &nbsp; Order Details
                </div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
				    <div class="main-container">           
                    <div class="box-shadow">	
                        <form id="form_order_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/order/save/' . $data[0]->id; else echo base_url().'index.php/order/save'; ?>">
                            <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
							
							<div class="panel-body">
								<div class="form-group" >
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="text" class="form-control datepicker1" name="date_of_processing" id="date_of_processing" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Order Number<span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="order_number" id="order_number" placeholder="Order Number" value="<?php if (isset($data)) { echo $data[0]->id; } ?>" />
                                        </div>
									</div>
								</div>
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Retailer Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="retailer_name" id="retailer_name" placeholder="Retailer Name" value="<?php if(isset($data)) { echo $data[0]->retailer_name; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Retailer Number <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="Retailer Name" value="<?php if(isset($data)) { echo $data[0]->contact_no; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">GST Number <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="gst_number" id="gst_number" placeholder="GST Number" value="<?php if(isset($data)) { echo $data[0]->gst_number; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Rep Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="sales_rep_name" id="sales_rep_name" placeholder="Sales Rep Name" value="<?php if(isset($data)) { echo $data[0]->sales_rep_name; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Location <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="location" id="location" placeholder="Location" value="<?php if(isset($data)) { echo $data[0]->location; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="area" id="area" placeholder="Area" value="<?php if(isset($data)) { echo $data[0]->area; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Zone <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="zone" id="zone" placeholder="Zone" value="<?php if(isset($data)) { echo $data[0]->zone; } ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="distributor_id" id="distributor_id" class="form-control">
                                                <option value="">Select</option>
                                                <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) {if($distributor[$k]->id==$data[0]->distributor_id) {echo 'selected';}} else if(isset($distributor_id)) {if($distributor[$k]->id==$distributor_id) {echo 'selected';}} ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                <?php }} ?>
                                            </select>
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
                                            <th style="display: none;">Rate (In Rs) </th>
                                            <th style="display: none;">Sell Rate (In Rs) <span class="asterisk_sign">*</span></th>
                                            <th style="display: none;">Grams</th>
                                            <th>Amount (In Rs)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="box_details">
                                    <?php $i=0; if(isset($order_items)) {
                                            for($i=0; $i<count($order_items); $i++) { ?>
                                        <tr id="box_<?php echo $i; ?>_row">
                                            <td>
                                                <select name="type[]" class="form-control type" id="type_<?php echo $i;?>">
                                                    <option value="">Select Type</option>
                                                    <option value="Bar" <?php if($order_items[$i]->type=="Bar") { echo 'selected'; } ?>>Bar</option>
                                                    <option value="Box" <?php if($order_items[$i]->type=="Box") { echo 'selected'; } ?>>Box</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="bar[]" class="form-control bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($order_items[$i]->type=="Box") { echo 'display: none;'; } ?>">
                                                    <option value="">Select Item</option>
                                                    <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                            <option value="<?php echo $bar[$k]->id; ?>" <?php if($order_items[$i]->type=="Bar" && $bar[$k]->id==$order_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $bar[$k]->product_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <select name="box[]" class="form-control box" id="box_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($order_items[$i]->type=="Bar") { echo 'display: none;'; } ?>">
                                                    <option value="">Select Item</option>
                                                    <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                            <option value="<?php echo $box[$k]->id; ?>" <?php if($order_items[$i]->type=="Box" && $box[$k]->id==$order_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $box[$k]->box_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_item_<?php echo $i;?>"></div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($order_items)) { echo $order_items[$i]->qty; } ?>"/>
                                            </td>
                                            <td style="display: none;">
                                                <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($order_items)) { echo $order_items[$i]->rate; } ?>" readonly />
                                            </td>
                                            <td style="display: none;">
                                                <input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_<?php echo $i; ?>" placeholder="Sell Rate" value="<?php if (isset($order_items)) { echo $order_items[$i]->sell_rate; } ?>"/>
                                            </td>
                                            <td style="display: none;">
                                                <input type="text" class="form-control grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="<?php if (isset($order_items)) { echo $order_items[$i]->grams; } ?>" readonly />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($order_items)) { echo $order_items[$i]->amount; } ?>" readonly />
                                            </td>
                                             <td style="text-align:center;     vertical-align: middle;">
                                                <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                            </td>
                                        </tr>
                                    <?php }} else { ?>
                                        <tr id="box_<?php echo $i; ?>_row">
                                            <td>
                                                <select name="type[]" class="form-control type" id="type_<?php echo $i;?>">
                                                    <option value="">Select Type</option>
                                                    <option value="Bar">Bar</option>
                                                    <option value="Box">Box</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="bar[]" class="form-control bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="">
                                                    <option value="">Select Item</option>
                                                    <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                            <option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->product_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <select name="box[]" class="form-control box" id="box_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="display: none;">
                                                    <option value="">Select Item</option>
                                                    <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                            <option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->box_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_item_<?php echo $i;?>"></div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value=""/>
                                            </td>
                                            <td style="display: none;">
                                                <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="" readonly />
                                            </td>
                                            <td style="display: none;">
                                                <input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_<?php echo $i; ?>" placeholder="Sell Rate" value=""/>
                                            </td>
                                            <td style="display: none;">
                                                <input type="text" class="form-control grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="" readonly />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                            </td>
                                              <td style="text-align:center;     vertical-align: middle;">
                                                <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
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
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs)<span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->invoice_amount; } ?>" readonly />
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
                                <input type="submit" class="btn btn-success pull-right" name="submit" value="Delivered" />
                                <input type="submit" class="btn btn-success pull-right" name="submit" value="Cancelled" style="margin-right: 10px;" />
                                <!-- <button class="btn btn-success pull-right" style="<?php //if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;'; else if(substr($data[0]->id,0,1)=="d") echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
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
                // $('#distributor_id').click(function(event){
                //     get_distributor_details($('#distributor_id').val());

                //     // if($('#distributor_id').val()==1){
                //     //     $('#sample_distributor_div').show();
                //     // } else {
                //     //     $('#sample_distributor_div').hide();
                //     // }
                // });
                // $('#sample_distributor_id').click(function(event){
                //     get_distributor_details($('#sample_distributor_id').val());
                // });
                $("#discount").change(function(){
                    $('#sell_out').val($("#discount").val());
                });
                $('input[type=radio][name=tax]').on('change', function() {
                    switch($(this).val()) {
                        case 'vat':
                            $('#cst').val(6);
                            break;
                        case 'cst':
                            $('#cst').val(2);
                            break;
                    }

                    get_sell_rate();
                });
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                
                addMultiInputNamingRules('#form_order_details', 'select[name="box[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_order_details', 'select[name="bar[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_order_details', 'input[name="qty[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_order_details', 'input[name="sell_rate[]"]', { required: true }, "");

                // get_distributor_details($('#distributor_id').val());

                if($('#distributor_id').val()==1){
                    $('#sample_distributor_div').show();
                } else {
                    $('#sample_distributor_div').hide();
                }

                // if($('#sample_distributor_id').val()!=''){
                //     get_distributor_details($('#sample_distributor_id').val());
                // }
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

            // function get_distributor_details(distributor_id){
            //     // var distributor_id = $('#distributor_id').val();
            //     var sell_out = 0;

            //     $.ajax({
            //         url:BASE_URL+'index.php/order/get_distributor_data',
            //         method:"post",
            //         data:{id:distributor_id},
            //         dataType:"json",
            //         async:false,
            //         success: function(data){
            //             if(data.result==1){
            //                 $('#sell_out').val(data.sell_out);

            //                 sell_out = parseFloat($('#sell_out').val());
            //                 if (isNaN(sell_out)) sell_out=0;

            //                 get_sell_rate();
            //             }
            //         },
            //         error: function (response) {
            //             var r = jQuery.parseJSON(response.responseText);
            //             alert("Message: " + r.Message);
            //             alert("StackTrace: " + r.StackTrace);
            //             alert("ExceptionType: " + r.ExceptionType);
            //         }
            //     });
            // }

            function get_sell_rate(){
                $('.rate').each(function(){
                    var elem = $(this);
                    var id = elem.attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var sell_out = parseFloat(get_number($("#sell_out").val(),2));
                    var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                    var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                    // var cst = parseFloat(get_number($("#cst").val(),2));
                    var cst = 6;
                    var sell_rate = rate-((rate*sell_out)/100);
                    sell_rate = sell_rate/(100+cst)*100;

                    if (isNaN(qty)) qty=0;
                    if (isNaN(rate)) rate=0;
                    if (isNaN(sell_rate)) sell_rate=0;

                    var amount = qty*sell_rate;

                    $("#sell_rate_"+index).val(Math.round(sell_rate*100)/100);
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
                if (isNaN(grams)) grams=0;
                if (isNaN(rate)) rate=0;
                // var cst = parseFloat(get_number($("#cst").val(),2));
                var cst = 6;
                var sell_rate = rate-((rate*sell_out)/100);
                sell_rate = sell_rate/(100+cst)*100;

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
                if (isNaN(grams)) grams=0;
                if (isNaN(rate)) rate=0;
                // var cst = parseFloat(get_number($("#cst").val(),2));
                var cst = 6;
                var sell_rate = rate-((rate*sell_out)/100);
                sell_rate = sell_rate/(100+cst)*100;

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

                // var cst = 0;
                // if($.trim($('#state').val()).toUpperCase()=="MAHARASHTRA"){
                //     cst = 6;
                // } else {
                //     cst = 2;
                // }

                // var cst = parseFloat(get_number($('#cst').val(),2));
                var cst = 6;

                var tax_amount = total_amount*cst/100;
                var final_amount = total_amount + tax_amount;

                // $("#total_amount").val(Math.round(total_amount*100)/100);
                // $("#tax_amount").val(Math.round(tax_amount*100)/100);
                // $("#final_amount").val(Math.round(final_amount*100)/100);
                
                $("#total_amount").val(Math.round(final_amount*100)/100);
            }

            jQuery(function(){
                var counter = $('.box').length;
                $('#repeat-box').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="box_'+counter+'_row">' + 
                                            '<td>' + 
                                                '<select name="type[]" class="form-control type" id="type_'+counter+'">' + 
                                                    '<option value="">Select Type</option>' + 
                                                    '<option value="Bar">Bar</option>' + 
                                                    '<option value="Box">Box</option>' + 
                                                '</select>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<select name="bar[]" class="form-control bar" id="bar_'+counter+'" data-error="#err_item_'+counter+'" style="">' + 
                                                    '<option value="">Select Item</option>' + 
                                                    '<?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->product_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<select name="box[]" class="form-control box" id="box_'+counter+'" data-error="#err_item_'+counter+'" style="display: none;">' + 
                                                    '<option value="">Select Item</option>' + 
                                                    '<?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->box_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<div id="err_item_'+counter+'"></div>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value=""/>' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_'+counter+'" placeholder="Sell Rate" value=""/>' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control grams" name="grams[]" id="grams_'+counter+'" placeholder="Grams" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="text-align:center;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#box_details').append(newRow);
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