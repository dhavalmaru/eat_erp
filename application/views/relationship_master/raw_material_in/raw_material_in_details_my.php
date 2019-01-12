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
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/raw_material_in'; ?>" > Raw Material In List </a>  &nbsp; &#10095; &nbsp; Raw Material In Details</div>
				   
                <!-- PAGE CONTENT WRAPPER -->
                    <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
							
                            <form id="form_raw_material_in_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/raw_material_in/update/' . $data[0]->id; else echo base_url().'index.php/raw_material_in/save'; ?>">
                              <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
								
								<div class="panel-body">
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Receipt <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control datepicker1" name="date_of_receipt" id="date_of_receipt" placeholder="Date Of Receipt" value="<?php if(isset($data)) echo (($data[0]->date_of_receipt!=null && $data[0]->date_of_receipt!='')?date('d/m/Y',strtotime($data[0]->date_of_receipt)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Vendor </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="vendor_id" id="vendor_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($vendor)) { for ($k=0; $k < count($vendor); $k++) { ?>
                                                            <option value="<?php echo $vendor[$k]->id; ?>" <?php if(isset($data)) { if($vendor[$k]->id==$data[0]->vendor_id) { echo 'selected'; } } ?>><?php echo $vendor[$k]->vendor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <!-- <input type="hidden" name="vendor_id" id="vendor_id" value="<?php //if(isset($data)) { echo  $data[0]->vendor_id; } ?>"/>
                                                <input type="text" class="form-control load_vendor" name="vendor" id="vendor" placeholder="Type To Select Vendor...." value="<?php //if(isset($data)) { echo  $data[0]->vendor_name; } ?>"/> -->
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Purchase Order <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="purchase_order_id" id="purchase_order_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($purchase_order)) { for ($k=0; $k < count($purchase_order); $k++) { ?>
                                                            <option value="<?php echo $purchase_order[$k]->id; ?>" <?php if(isset($data)) { if($purchase_order[$k]->id==$data[0]->purchase_order_id) { echo 'selected'; } } ?>><?php echo (($purchase_order[$k]->order_date!=null && $purchase_order[$k]->order_date!='')?date('d/m/Y',strtotime($purchase_order[$k]->order_date)):'') . ' - ' . $purchase_order[$k]->id; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <!-- <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="<?php //if(isset($data)) { echo  $data[0]->purchase_order_id; } ?>"/>
                                                <input type="text" class="form-control load_purchase_order" name="purchase_order" id="purchase_order" placeholder="Type To Select Vendor...." value="<?php //if(isset($data)) { echo  $data[0]->purchase_order_name; } ?>"/> -->
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="depot_id" id="depot_id" class="form-control">
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
                                                <th width="350">Raw Material <span class="asterisk_sign">*</span></th>
                                                <th width="150">Qty In Kg <span class="asterisk_sign">*</span></th>
                                                <th width="150">Rate (In Rs) <span class="asterisk_sign">*</span></th>
                                                <th width="150">Amount (In Rs) </th>
                                                <th align="center" width="75">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="raw_material_details">
                                        <?php $i=0; if(isset($raw_material_stock)) {
                                                for($i=0; $i<count($raw_material_stock); $i++) { ?>
                                            <tr id="raw_material_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="raw_material[]" class="form-control raw_material" id="raw_material_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                <option value="<?php echo $raw_material[$k]->id; ?>" <?php if($raw_material[$k]->id==$raw_material_stock[$i]->raw_material_id) { echo 'selected'; } ?>><?php echo $raw_material[$k]->rm_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($raw_material_stock)) { echo format_money($raw_material_stock[$i]->qty,2); } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($raw_material_stock)) { echo format_money($raw_material_stock[$i]->rate,2); } ?>" />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($raw_material_stock)) { echo format_money($raw_material_stock[$i]->amount,2); } ?>" readonly />
                                                </td>
                                              <td style="text-align:center; vertical-align: middle;">
                                                    <a id="raw_material_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="raw_material_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="raw_material[]" class="form-control raw_material" id="raw_material_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                <option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="" />
                                                </td>
                                                <td >
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                <td style="text-align:center; vertical-align: middle;">
                                                    <a id="raw_material_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <button type="button" class="btn btn-success" id="repeat-raw_material" >+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">VAT (In Rs) </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="vat" id="vat" placeholder="VAT" value="<?php if (isset($data)) { echo format_money($data[0]->vat,2); } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">CST (In Rs)</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="cst" id="cst" placeholder="CST" value="<?php if (isset($data)) { echo format_money($data[0]->cst,2); } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Excise (In Rs) </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="excise" id="excise" placeholder="Excise" value="<?php if (isset($data)) { echo format_money($data[0]->excise,2); } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Final Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="final_amount" id="final_amount" placeholder="Final Amount" value="<?php if (isset($data)) { echo format_money($data[0]->final_amount,2); } ?>" readonly />
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
                                            <div class="col-md-10  col-sm-10 col-xs-12">
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
									<a href="<?php echo base_url(); ?>index.php/raw_material_in" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
                $(".qty").blur(function(){
                    get_amount($(this));
                });
                $(".rate").blur(function(){
                    get_amount($(this));
                });
                $("#vat").blur(function(){
                    get_total();
                });
                $("#cst").blur(function(){
                    get_total();
                });
                $("#excise").blur(function(){
                    get_total();
                });
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });
                // $('#purchase_order_id').click(function(event){
                //     get_purchase_order_details();
                // });
                $('#purchase_order_id').on('change', function() {
                  // alert( this.value ); // or $(this).val()
                  get_purchase_order_details();
                });
                $('#vendor_id').on('change', function() {
                  // alert( this.value ); // or $(this).val()
                  get_purchase_order_nos();
                });
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                
                addMultiInputNamingRules('#form_raw_material_in_details', 'select[name="raw_material[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_raw_material_in_details', 'input[name="qty[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_raw_material_in_details', 'input[name="rate[]"]', { required: true }, "");
            });

            function get_purchase_order_nos(){
                var vendor_id = $('#vendor_id').val();
                $("#purchase_order_id").html('<option value="">Select</option>');

                $.ajax({
                    url:BASE_URL+'index.php/Purchase_order/get_purchase_order_nos',
                    method:"post",
                    data:{vendor_id:vendor_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){

                            var newRow = '<option value="">Select</option>';

                            for(var i=0; i<data.id.length; i++){
                                newRow = newRow + '<option value="'+data.id[i]+'">'+data.order_date[i]+' - '+data.id[i]+'</option>';
                            }

                            $("#purchase_order_id").html(newRow);
                        }
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });

                get_purchase_order_details();
            }

            function get_purchase_order_details(){
                var purchase_order_id = $('#purchase_order_id').val();

                $.ajax({
                    url:BASE_URL+'index.php/Purchase_order/get_data',
                    method:"post",
                    data:{id:purchase_order_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            // $('#vendor_id').val(data.vendor_id);
                            $('#depot_id').val(data.depot_id);
                        }
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });
                
                $.ajax({
                    url:BASE_URL+'index.php/Purchase_order/get_purchase_order_items',
                    method:"post",
                    data:{id:purchase_order_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            // $("#raw_material_details > tbody").html("");
                            // $("tbody", "#raw_material_details").remove();
                            $("#raw_material_details").empty();

                            var counter = $('.raw_material').length;
                            for(var i=0; i<data.item_id.length; i++){
                                var newRow = jQuery('<tr id="raw_material_'+counter+'_row">'+
                                            '<td>'+
                                                '<select name="raw_material[]" class="form-control raw_material" id="raw_material_'+counter+'">'+
                                                    '<option value="">Select</option>'+
                                                    '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>'+
                                                            '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>'+
                                                    '<?php }} ?>'+
                                                '</select>'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="'+data.qty[i]+'"/>'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="'+data.rate[i]+'" />'+
                                                '<!-- <span id="rate_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="'+data.amount[i]+'" readonly />'+
                                                '<!-- <span id="amount_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '<td style="text-align:center; vertical-align: middle;">'+
                                                '<a id="raw_material_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                            '</td>'+
                                        '</tr>');
                                $('#raw_material_details').append(newRow);
                                $("#raw_material_"+counter).val(data.item_id[i]);
                                counter++;
                            }

                            $('.format_number').keyup(function(){
                                format_number(this);
                            });
                            $(".qty").blur(function(){
                                get_amount($(this));
                            });
                            $(".rate").blur(function(){
                                get_amount($(this));
                            });
                            $('.delete_row').click(function(event){
                                delete_row($(this));
                                get_total();
                            });

                            get_total();
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

            function get_amount(elem){
                var id = elem.attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var rate = parseFloat(get_number($("#rate_"+index).val(),2));
                var amount = qty*rate;
                $("#amount_"+index).val(format_money(Math.round(amount*100)/100,2));

                get_total();
            }

            function get_total(){
                var total_amount = 0;
                $('.amount').each(function(){
                    amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amount = total_amount + amount;
                });

                var vat = parseFloat(get_number($("#vat").val(),2));
                var cst = parseFloat(get_number($("#cst").val(),2));
                var excise = parseFloat(get_number($("#excise").val(),2));
                total_amount = total_amount + vat + cst + excise;

                $("#final_amount").val(format_money(Math.round(total_amount*100)/100,2));
            }

            jQuery(function(){
                var counter = $('.raw_material').length;
                $('#repeat-raw_material').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="raw_material_'+counter+'_row">'+
                                            '<td>'+
                                                '<select name="raw_material[]" class="form-control raw_material" id="raw_material_'+counter+'">'+
                                                    '<option value="">Select</option>'+
                                                    '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>'+
                                                            '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>'+
                                                    '<?php }} ?>'+
                                                '</select>'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value=""/>'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" />'+
                                                '<!-- <span id="rate_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />'+
                                                '<!-- <span id="amount_label_'+counter+'"></span> -->'+
                                            '</td>'+
                                            '<td style="text-align:center; vertical-align: middle;">'+
                                                '<a id="raw_material_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                            '</td>'+
                                        '</tr>');
                    $('#raw_material_details').append(newRow);
                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    $(".qty").blur(function(){
                        get_amount($(this));
                    });
                    $(".rate").blur(function(){
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