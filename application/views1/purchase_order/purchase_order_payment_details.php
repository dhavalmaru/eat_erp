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
        <!-- START PAGE CONTAINER -->
       <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/purchase_order'; ?>" > Purchase Order List </a>  &nbsp; &#10095; &nbsp; Purchase Order Payment Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                  <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                            <form id="form_purchase_order_payment_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/purchase_order/update_payment_details/' . $data[0]->id; else echo base_url().'index.php/purchase_order/save_payment_details'; ?>">
                               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
							     	<div class="panel-body">
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control datepicker" name="order_date" id="order_date" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->order_date!=null && $data[0]->order_date!='')?date('d/m/Y',strtotime($data[0]->order_date)):''); ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Vendor <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="vendor" id="vendor" placeholder="Distributor Name" value="<?php if(isset($data)) { echo $data[0]->vendor_name; } ?>" readonly />
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="depot" id="depot" placeholder="Depot Name" value="<?php if(isset($data)) { echo $data[0]->depot_name; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount  (In Rs) <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amount; } ?>" readonly />
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Delivery Date </label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="delivery_date" id="delivery_date" placeholder="Delivery Date" value="<?php if(isset($data)) { echo (($data[0]->delivery_date!=null && $data[0]->delivery_date!='')?date('d/m/Y',strtotime($data[0]->delivery_date)):''); } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Shipping Method </label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="shipping_method" id="shipping_method" placeholder="Shipping Method" value="<?php if (isset($data)) { echo $data[0]->shipping_method; } ?>" readonly />
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Shipping Term </label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="shipping_term" id="shipping_term" placeholder="Shipping Term" value="<?php if(isset($data)) { echo $data[0]->shipping_term; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>

                                     <div class="h-scroll">	
                                       <div class="table-stripped form-group" style="padding:15px;" >
                                           <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 180px">Payment Mode <span class="asterisk_sign">*</span></th>
                                                <th style="width: 300px">Ref No <span class="asterisk_sign">*</span></th>
                                                <th style="width: 150px">Payment Date <span class="asterisk_sign">*</span></th>
                                                <th style="width: 170px">Payment Amount (In Rs) <span class="asterisk_sign">*</span></th>
                                                <th style="text-align:center; width:60px;"> Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($purchase_order_payment_details)) {
                                                for($i=0; $i<count($purchase_order_payment_details); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="payment_mode[]" class="form-control payment_mode" id="payment_mode_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <option value="Cash" <?php if($purchase_order_payment_details[$i]->payment_mode=="Cash") { echo 'selected'; } ?>>Cash</option>
                                                        <option value="Cheque" <?php if($purchase_order_payment_details[$i]->payment_mode=="Cheque") { echo 'selected'; } ?>>Cheque</option>
                                                        <option value="NEFT" <?php if($purchase_order_payment_details[$i]->payment_mode=="NEFT") { echo 'selected'; } ?>>NEFT</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control ref_no" name="ref_no[]" id="ref_no_<?php echo $i; ?>" placeholder="Ref No" value="<?php if (isset($purchase_order_payment_details)) { echo $purchase_order_payment_details[$i]->ref_no; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control datepicker payment_date" name="payment_date[]" id="payment_date_<?php echo $i; ?>" placeholder="Payment Date" value="<?php if(isset($purchase_order_payment_details)) echo (($purchase_order_payment_details[0]->payment_date!=null && $purchase_order_payment_details[0]->payment_date!='')?date('d/m/Y',strtotime($purchase_order_payment_details[0]->payment_date)):''); ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control payment_amount" name="payment_amount[]" id="payment_amount_<?php echo $i; ?>" placeholder="Payment Amount" value="<?php if (isset($purchase_order_payment_details)) { echo $purchase_order_payment_details[$i]->payment_amount; } ?>" readonly />
                                                </td>
                                                  <td style="text-align:center;     vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="payment_mode[]" class="form-control payment_mode" id="payment_mode_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Cheque">Cheque</option>
                                                        <option value="NEFT">NEFT</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control ref_no" name="ref_no[]" id="ref_no_<?php echo $i; ?>" placeholder="Ref No" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control datepicker payment_date" name="payment_date[]" id="payment_date_<?php echo $i; ?>" placeholder="Payment Date" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control payment_amount" name="payment_amount[]" id="payment_amount_<?php echo $i; ?>" placeholder="Payment Amount" value=""/>
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
                                                    <button type="button" class="btn btn-success" id="repeat-box" style=" ">+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
									</div>
                                    <div class="form-group">
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Balance Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-10 col-sm-10 col-xs-12">
                                                <input type="text" class="form-control" name="balance_amount" id="balance_amount" placeholder="Balance Amount" value="" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
								<br clear="all"/>
								</div>
							</div>
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/purchase_order" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
							</form>
						</div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
		</div>			
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".payment_amount").change(function(){
                    get_balance_amount();
                });

                addMultiInputNamingRules('#form_purchase_order_payment_details', 'select[name="payment_mode[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_purchase_order_payment_details', 'input[name="ref_no[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_purchase_order_payment_details', 'input[name="payment_date[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_purchase_order_payment_details', 'input[name="payment_amount[]"]', { required: true }, "");
                
                get_balance_amount();
            });

            function get_balance_amount(){
                var total_amount = 0;

                $('.payment_amount').each(function(){
                    var amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amount = total_amount + amount;
                });

                var final_amount = parseFloat(get_number($('#final_amount').val(),2));

                var balance_amount = final_amount - total_amount;

                $("#balance_amount").val(balance_amount);
            }


            jQuery(function(){
                var counter = $('.payment_mode').length;
                $('#repeat-box').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="box_'+counter+'_row">' + 
                                            '<td>' + 
                                                '<select name="payment_mode[]" class="form-control payment_mode" id="payment_mode_'+counter+'">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<option value="Cash">Cash</option>' + 
                                                    '<option value="Cheque">Cheque</option>' + 
                                                    '<option value="NEFT">NEFT</option>' + 
                                                '</select>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control ref_no" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Ref No" value=""/>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control datepicker payment_date" name="payment_date[]" id="payment_date_'+counter+'" placeholder="Payment Date" value=""/>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control payment_amount" name="payment_amount[]" id="payment_amount_'+counter+'" placeholder="Payment Amount" value=""/>' + 
                                            '</td>' + 
                                            ' <td style="text-align:center;     vertical-align: middle;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#box_details').append(newRow);
                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    $('.datepicker').datepicker({changeMonth: true,changeYear: true});
                    $(".payment_amount").change(function(){
                        get_balance_amount();
                    });
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                        get_balance_amount();
                    });
                    counter++;
                });
            });
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>