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

			#box_details .form-control[disabled], #box_details .form-control[readonly],#bar_details .form-control[disabled], #bar_details .form-control[readonly]
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
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/bar_to_box'; ?>" > Bar To Box List </a>  &nbsp; &#10095; &nbsp; Bar To Box Details</div>
                <!-- PAGE CONTENT WRAPPER -->
                     <div class="page-content-wrap">
                      <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">							
                            <form id="form_bar_to_box_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/bar_to_box/update/' . $data[0]->id; else echo base_url().'index.php/bar_to_box/save'; ?>">
                               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
								
							 	<div class="panel-body">
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Processing <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker1" name="date_of_processing" id="date_of_processing" placeholder="Date Of Processing" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                                <input type="hidden" class="form-control" name="id" id="id" placeholder="Id" value="<?php if (isset($data)) { echo $data[0]->id; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="depot_id" id="depot_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { ?>
                                                            <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <!-- <input type="hidden" name="depot_id" id="depot_id" value="<?php //if(isset($data)) { echo  $data[0]->depot_id; } ?>"/>
                                                <input type="text" class="form-control load_depot" name="depot" id="depot" placeholder="Type To Select Depot...." value="<?php //if(isset($data)) { echo  $data[0]->depot_name; } ?>"/> -->
                                            </div>
										</div>
									</div>

                                  <div class="h-scroll">	
                                       <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th>Bar</th>
                                                <th>Available Qty</th>
                                                <th>Qty</th>
                                                <th>Balance Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bar_details">
                                            
                                        </tbody>
                                        </table>
                                    </div>

                                  <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th>Box</th>
                                                <th width="250">Qty</th>
                                                <th style="display:none;">Grams</th>
                                                <th style="display:none;">Rate (In Rs)</th>
                                                <th style="display:none;">Amount (In Rs)</th>
                                                <th width="20%" >Batch</th>
                                                <th style="text-align:center; width:75px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($bar_to_boxes)) {
                                                for($i=0; $i<count($bar_to_boxes); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="box[]" class="form-control box select2" id="box_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                <option value="<?php echo $box[$k]->id; ?>" <?php if($box[$k]->id==$bar_to_boxes[$i]->box_id) { echo 'selected'; } ?>><?php echo $box[$k]->box_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control format_number qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($bar_to_boxes)) { echo format_money($bar_to_boxes[$i]->qty,2); } ?>"/>
                                                </td>
                                                <td style="display:none;">
                                                    <input type="text" class="form-control format_number grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="<?php if (isset($bar_to_boxes)) { echo format_money($bar_to_boxes[$i]->grams,2); } ?>" readonly />
                                                </td>
                                                <td style="display:none;">
                                                    <input type="text" class="form-control format_number rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($bar_to_boxes)) { echo format_money($bar_to_boxes[$i]->rate,2); } ?>" readonly />
                                                </td>
                                                <td style="display:none;">
                                                    <input type="text" class="form-control format_number amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($bar_to_boxes)) { echo format_money($bar_to_boxes[$i]->amount,2); } ?>" readonly />
                                                </td>
                                                <td >
                                                    <select name="batch_no[]" class="form-control batch_no" id="batch_no_<?php echo $i;?>" data-error="#err_batch_no_<?php echo $i;?>" >
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch); $k++) {   ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$bar_to_boxes[$i]->batch_no) { echo 'selected'; }?> ><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_batch_no_<?php echo $i;?>"></div>
                                               </td> 
                                                  <td style="text-align:center;     vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="box[]" class="form-control box select2" id="box_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>
                                                                <option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->box_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control format_number qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value=""/>
                                                </td>
                                                <td style="display:none;">
                                                    <input type="text" class="form-control format_number grams" name="grams[]" id="grams_<?php echo $i; ?>" placeholder="Grams" value="" readonly />
                                                </td>
                                                <td style="display:none;">
                                                    <input type="text" class="form-control format_number rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="" readonly />
                                                </td>
                                                <td style="display:none;">
                                                    <input type="text" class="form-control format_number amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                <td >
                                                    <select name="batch_no[]" class="form-control batch_no" id="batch_no_<?php echo $i;?>" data-error="#err_batch_no_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch); $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>" ><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_batch_no_<?php echo $i;?>"></div>
                                               </td>
                                                 <td style="text-align:center;     vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <button type="button" class="btn btn-success" id="repeat-box"  >+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
									</div>
                                    <div class="form-group" style="display:none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Qty <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="total_qty" id="total_qty" placeholder="Total Qty" value="<?php if (isset($data)) { echo format_money($data[0]->qty,2); } ?>" readonly />
                                            </div>
                                            <div style="display: none;">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Grams <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="text" class="form-control format_number" name="total_grams" id="total_grams" placeholder="Total Grams" value="<?php if (isset($data)) { echo format_money($data[0]->grams,2); } ?>" readonly />
                                                </div>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo format_money($data[0]->amount,2); } ?>" readonly />
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
									<a href="<?php echo base_url(); ?>index.php/bar_to_box" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
                $(".box").change(function(){
                    get_box_details($(this));
                });
                $(".qty").change(function(){
                    get_amount($(this));
                });
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });
                $("#depot_id").change(function(){
                    get_bar_details();
                });
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                
                addMultiInputNamingRules('#form_bar_to_box_details', 'select[name="box[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_bar_to_box_details', 'input[name="qty[]"]', { required: true }, "");

                get_bar_details();
                get_total();
            });

            function get_bar_details(){
                var depot_id = $('#depot_id').val();
                var module = "bar_to_box";

                $.ajax({
                    url:BASE_URL+'index.php/Stock/get_depot_bar_qty',
                    method:"post",
                    data:'id='+$("#id").val()+'&depot_id='+depot_id+'&module='+module,
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            $("#bar_details").empty();

                            var counter = $('.bar_id').length;
                            for(var i=0; i<data.product_id.length; i++){
                                var newRow = jQuery('<tr id="bar_'+counter+'_row">'+
                                            '<td>'+
                                                '<input type="hidden" class="form-control bar_id" name="bar_id[]" id="bar_id_'+counter+'" placeholder="Bar Id" value="'+data.product_id[i]+'" readonly />'+
                                                '<input type="text" class="form-control bar_name" name="bar_name[]" id="bar_name_'+counter+'" placeholder="Bar Name" value="'+data.product_name[i]+'" readonly />'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control total_bar_qty" name="total_bar_qty[]" id="total_bar_qty_'+counter+'" placeholder="Total Bar Qty" value="'+data.qty[i]+'" readonly />'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control used_bar_qty" name="used_bar_qty[]" id="used_bar_qty_'+counter+'" placeholder="Used Bar Qty" value="" readonly />'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control bal_bar_qty" name="bal_bar_qty[]" id="bal_bar_qty_'+counter+'" placeholder="Balance Bar Qty" value="" readonly />'+
                                            '</td>'+
                                        '</tr>');
                                $('#bar_details').append(newRow);
                                counter++;
                            }
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

            function get_bal_bar_details(){
                var tot_product_id = [];
                var tot_qty = [];
                var k=0;

                $('.box').each(function(){
                    var elem = $(this);
                    var box_id = elem.val();
                    var id = elem.attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                    
                    $.ajax({
                        url:BASE_URL+'index.php/Box/get_products',
                        method:"post",
                        data:{id:box_id},
                        dataType:"json",
                        async:false,
                        success: function(data){
                            if(data.result==1){
                                for(var i=0; i<data.product.length; i++){
                                    var product_id=data.product[i];
                                    var product_qty=parseFloat(data.qty[i]);
                                    var flag=false;

                                    for(var j=0; j<tot_product_id.length; j++){
                                        if(product_id==tot_product_id[j]){
                                            tot_qty[j]=parseFloat(tot_qty[j])+product_qty*qty;
                                            flag=true;
                                        }
                                    }

                                    if(flag==false){
                                        tot_product_id[k]=product_id;
                                        tot_qty[k]=product_qty*qty;
                                        k=k+1;
                                    }
                                }
                            }
                        },
                        error: function (response) {
                            var r = jQuery.parseJSON(response.responseText);
                            alert("Message: " + r.Message);
                            alert("StackTrace: " + r.StackTrace);
                            alert("ExceptionType: " + r.ExceptionType);
                        }
                    });
                });

                $('.bar_id').each(function(){
                    var elem = $(this);
                    var bar_id = elem.val();
                    var id = elem.attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var qty = parseFloat(get_number($("#total_bar_qty_"+index).val(),2));

                    for(var j=0; j<tot_product_id.length; j++){
                        if(bar_id==tot_product_id[j]){
                            qty=qty-parseFloat(tot_qty[j]);
                            $("#used_bar_qty_"+index).val(tot_qty[j]);
                            $("#bal_bar_qty_"+index).val(qty);
                        }
                    }
                });
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

                var amount = qty*rate;
                $("#grams_"+index).val(format_money(grams,2));
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
                var total_qty = 0;
                $('.qty').each(function(){
                    qty = parseFloat(get_number($(this).val(),2));
                    if (isNaN(qty)) qty=0;
                    total_qty = total_qty + qty;
                });

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

                $("#total_qty").val(format_money(total_qty,2));
                $("#total_grams").val(format_money(total_grams,2));
                $("#total_amount").val(format_money(total_amount,2));

                get_bal_bar_details();
            }

            jQuery(function(){
                var counter = $('.box').length;
                $('#repeat-box').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="box_'+counter+'_row">'+
                                            '<td>'+
                                                '<select name="box[]" class="form-control box select2" id="box_'+counter+'">'+
                                                    '<option value="">Select</option>'+
                                                    '<?php if(isset($box)) { for ($k=0; $k < count($box) ; $k++) { ?>'+
                                                            '<option value="<?php echo $box[$k]->id; ?>"><?php echo $box[$k]->box_name; ?></option>'+
                                                    '<?php }} ?>'+
                                                '</select>'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control format_number qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value=""/>'+
                                            '</td>'+
                                            '<td style="display:none;">'+
                                                '<input type="text" class="form-control format_number grams" name="grams[]" id="grams_'+counter+'" placeholder="Grams" value="" readonly />'+
                                                '<!-- <span id="grams_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '<td style="display:none;">'+
                                                '<input type="text" class="form-control format_number rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" readonly />'+
                                                '<!-- <span id="rate_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '<td style="display:none;">'+
                                                '<input type="text" class="form-control format_number amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />'+
                                                '<!-- <span id="amount_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '<td >' + 
                                                '<select name="batch_no[]" class="form-control batch_no" id="batch_no_'+counter+'" data-error="#err_batch_no_'+counter+'" >' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php if(isset($batch)) { for ($k=0; $k < count($batch); $k++) { ?>' + 
                                                            '<option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<div id="err_batch_no_'+counter+'"></div>' + 
                                            '</td>' +
                                            '  <td style="text-align:center;     vertical-align: middle;">'+
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                            '</td>'+
                                        '</tr>');
                    $('#box_details').append(newRow);
                    $('.select2').select2();
                    $('.format_number').keyup(function(){
                        format_number(this);
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