<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Eat-ERP</title>
	<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1  maximum-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="HandheldFriendly" content="True">
	
	<link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.png">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/font-awesome.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/fakeLoader.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/slick.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/slick-theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.transitions.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/style.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/font/material-design-icons/Material-Design-Icons.woff" rel="stylesheet">
	
	<style>
		.submitLink 
		{
			  background-color: transparent;
			  text-decoration: none;
			  border: none;
			  color: #428bca;
			  cursor: pointer;
			  font-size:16px!important;
		}

        .input-field label {
            color: #000;
            font-size:12px!important;
        }

        label.error {
            margin-top: 37px;
            color: red !important;
            transform: translateY(0%) !important; 
           font-size:12px!important;
        }

        input::-webkit-input-placeholder
        { 
            font-size:0.8rem!important;
            color: #000!important;
        }

        input:not([type]), input[type=text], input[type=password], input[type=email], input[type=url], input[type=time], input[type=date], input[type=datetime], input[type=datetime-local], input[type=tel], input[type=number], input[type=search], textarea.materialize-textarea
        {
            color: #000;
            font-size:12px!important;
        }

        th{
            font-size:0.8rem!important;
            color: #000;
        }
        

        select
        {
            color: #000!important;
            font-size:0.8rem!important;
        }

        .control-label{
            color: #000!important;
        }
	 textarea.materialize-textarea
		 {
			 border: 1px solid #f2f2f2;
		
		 }
		  textarea.materialize-textarea
		 {
			 padding:0;
			 height:70px!important;
		 }

         
	</style>

<body>								
	<!-- START PAGE CONTAINER -->
	
		<div class="navbar">
		 <?php $this->load->view('templates/header2');?>
		</div>

		<?php $this->load->view('templates/menu2');?>	

	
<div class="contact app-pages app-section" style="margin:50 auto">
	<div class="container">
			
		<div id="basic-form" class="section">
              <div class="row">
                <div class="col s12">
				<div class="card-panel">
              
				<div class="row">

		
         <!-- START PAGE CONTAINER -->
       
            <!-- PAGE CONTENT -->
			 
            <div class="app-title">
				<h5>Order Details</h5>
			</div>
			
                  <hr>
                <!-- PAGE CONTENT WRAPPER -->
                          
                      
                            <form id="form_sales_rep_order_details" role="form" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/sales_rep_order/save/' . $data[0]->id; else echo base_url().'index.php/sales_rep_order/save'; ?>">
                         
						 
						  <div class="row"  >
                                    <div class="col s12">
                                       <div class="input-field col s3">
											<label for="dob">Date</label>
										</div> 
											<div class="input-field col s9"   style="top:0.8rem;color:#000!important;">
												<input type="hidden" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
												
												
												<input type="hidden"  name="date_of_processing" id="date_of_processing" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
												<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>
											
										  
												
											</div>
                                    </div>
                                </div>
								
							
									<div class="row" >
										<div class="col s12">
										
                                           
                                            <div class="input-field col s12">
										
                                                <select name="distributor_id" class="browser-default" id="distributor_id">
                                                    <option value="">Select Retailer</option>
                                                    <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                            <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) {if($distributor[$k]->id==$data[0]->distributor_id) {echo 'selected';}} else if(isset($distributor_id)) {if($distributor[$k]->id==$distributor_id) {echo 'selected';}} ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
												 
												  
											</div> 
                                                <input type="hidden" name="sell_out" id="sell_out" value="<?php if(isset($data)) { echo $data[0]->sell_out; } ?>"/>
                                                
                                            </div>
									</div>
									

                                	<div class="h-scroll">	
                                       <div class="table-stripped form-group"   >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 80px;">Type <span class="asterisk_sign">*</span></th>
                                                <th style="width: 125px;">Item <span class="asterisk_sign">*</span></th>
                                                <th>Qty <span class="asterisk_sign">*</span></th>
                                                <th style="display: none;">Rate (In Rs) </th>
                                                <th style="display: none;">Sell Rate (In Rs) <span class="asterisk_sign">*</span></th>
                                                <th style="display: none;">Grams</th>
                                                <th style="display: none;">Amount (In Rs)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($sales_rep_order_items)) {
                                                for($i=0; $i<count($sales_rep_order_items); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td> 

                                                    <select name="type[]" id="type_<?php echo $i;?>" class="browser-default type">
                                                        <option value="">Select Type</option>
                                                        <option value="Bar" <?php if($sales_rep_order_items[$i]->type=="Bar") { echo 'selected'; } ?>>Bar</option>
                                                        <option value="Box" <?php if($sales_rep_order_items[$i]->type=="Box") { echo 'selected'; } ?>>Box</option>
                                                    </select>
                                                </td>
                                                <td>
												<span class="bar_field" style="<?php if($sales_rep_order_items[$i]->type=="Box") { echo 'display: none;'; } ?>">
                                                    <select name="bar[]" class="browser-default bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($sales_rep_order_items[$i]->type=="Box") { echo 'display: none;'; } ?>">
                                                        <option value="">Select Item</option>
                                                        <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                <option value="<?php echo $bar[$k]->id; ?>" <?php if($sales_rep_order_items[$i]->type=="Bar" && $bar[$k]->id==$sales_rep_order_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $bar[$k]->short_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
												</span>
												<span class="bar_field" style="<?php if($sales_rep_order_items[$i]->type=="Bar") { echo 'display: none;'; } ?>">
                                                    <select name="box[]" class="browser-default box"  id="box_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="<?php if($sales_rep_order_items[$i]->type=="Bar") { echo 'display: none;'; } ?>">
                                                        <option value="">Select Item</option>
                                                        <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                <option value="<?php echo $box[$k]->id; ?>" <?php if($sales_rep_order_items[$i]->type=="Box" && $box[$k]->id==$sales_rep_order_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $box[$k]->short_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
												</span>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="0" value="<?php if (isset($sales_rep_order_items)) { echo $sales_rep_order_items[$i]->qty; } ?>"/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($sales_rep_order_items)) { echo $sales_rep_order_items[$i]->rate; } ?>" readonly />
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_<?php echo $i; ?>" placeholder="Sell Rate" value="<?php if (isset($sales_rep_order_items)) { echo $sales_rep_order_items[$i]->sell_rate; } ?>"/>
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="<?php if (isset($sales_rep_order_items)) { echo $sales_rep_order_items[$i]->grams; } ?>" readonly />
                                                </td>
                                                <td style="display: none;">
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($sales_rep_order_items)) { echo $sales_rep_order_items[$i]->amount; } ?>" readonly />
                                                </td>
                                                 <td style="text-align:center;     vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="type[]" class="browser-default type"   id="type_<?php echo $i;?>">
                                                        <option value="">Select Type</option>
                                                        <option value="Bar">Bar</option>
                                                        <option value="Box">Box</option>
                                                    </select>
                                                </td>
                                                <td>
												
                                                    <select name="bar[]" class="browser-default bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="">
                                                        <option value="">Select Item</option>
                                                        <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                <option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->short_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
													
												
												
                                                    <select name="box[]" class="browser-default box" id="box_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" style="display: none;">
                                                        <option value="">Select Item</option>
                                                        <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                <option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->short_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
											
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="0" value=""/>
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
                                                <td style="display: none;">
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
                                                    <button type="button" class="btn button shadow btn_color" style="padding: 0px 15px;" id="repeat-box"  >+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
									</div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs)<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amount; } ?>" readonly />
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
                                   
									
									<div class="row">
										<div class="col s12">
										<div class="input-field col s3">
											<label>Remarks <span class="asterisk_sign"></span></label>
										</div> 
									<div class="input-field col s9">
                                     <!--store_id is a Retailer id-->
										
										 <textarea id="textarea1" class="materialize-textarea" class="" name="remarks" id="remarks" value="<?php if(isset($data[0]->remarks)) echo $data[0]->remarks;?>"></textarea>
                                           
											
									</div> 
									</div> 
									</div>
                              
								<div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/sales_rep_order" class="button shadow btn_color1" style="display: inline-block;" type="reset" id="reset">Cancel</a>
                                    <button class="right button shadow btn_color2" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;'; else if(substr($data[0]->id,0,1)=="d") echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
					
                                
							</form>
							
						
					           
           
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
		
		
		

		
       
   <?php $this->load->view('templates/footer2');?>

        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".type").change(function(){
                   // alert('f');
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

                    // if($('#distributor_id').val()==1){
                    //     $('#sample_distributor_div').show();
                    // } else {
                    //     $('#sample_distributor_div').hide();
                    // }
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
                            $('#cst').val(6);
                            break;
                        case 'cst':
                            $('#cst').val(2);
                            break;
                    }

                    get_sell_rate();
                });
                
                addMultiInputNamingRules('#form_sales_rep_order_details', 'select[name="box[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_sales_rep_order_details', 'select[name="bar[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_sales_rep_order_details', 'input[name="qty[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_sales_rep_order_details', 'input[name="sell_rate[]"]', { required: true }, "");

                get_distributor_details($('#distributor_id').val());

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
                //alert('h');
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
                    url:BASE_URL+'index.php/Sales_rep_order/get_distributor_data',
                    method:"post",
                    data:{id:distributor_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            $('#sell_out').val(data.sell_out);

                            sell_out = parseFloat($('#sell_out').val());
                            if (isNaN(sell_out)) sell_out=0;

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
            }

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
                                                '<select name="type[]" class="browser-default type" id="type_'+counter+'">' + 
                                                    '<option value="">Select Type</option>' + 
                                                    '<option value="Bar">Bar</option>' + 
                                                    '<option value="Box">Box</option>' + 
                                                '</select>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<select name="bar[]" class="browser-default bar" id="bar_'+counter+'" data-error="#err_item_'+counter+'" style="">' + 
                                                    '<option value="">Select Item</option>' + 
                                                    '<?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->short_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<select name="box[]" class="browser-default box" id="box_'+counter+'" data-error="#err_item_'+counter+'" style="display: none;">' + 
                                                    '<option value="">Select Item</option>' + 
                                                    '<?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->short_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<div id="err_item_'+counter+'"></div>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="number" class="qty" name="qty[]" id="qty_'+counter+'" placeholder="0" value=""/>' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class=" rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="browser-default sell_rate" name="sell_rate[]" id="sell_rate_'+counter+'" placeholder="Sell Rate" value=""/>' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="browser-default grams" name="grams[]" id="grams_'+counter+'" placeholder="Grams" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="display: none;">' + 
                                                '<input type="text" class="browser-default amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="text-align:center;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><i class="fa fa-trash-o "  ></i></a>' + 
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
				 
          $('select').material_select();
        </script>
        <script>
			 $('.datepicker').pickadate({
				selectMonths: true, // Creates a dropdown to control month
				selectYears: 15 // Creates a dropdown of 15 years to control year
			  });
          $('select').material_select();
        </script>
		
    <!-- END SCRIPTS -->      
    </body>
</html>