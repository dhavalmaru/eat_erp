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
            input[readonly] {background-color: white !important; 
                            color: #0b385f !important; 
                            cursor: not-allowed !important;}
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
							
                            <form id="form_distributor_payment_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/distributor_out/update_payment_details/' . $data[0]->id; else echo base_url().'index.php/distributor_out/save_payment_details'; ?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Distributor Payment Details</strong></h3>
                                </div>
								
								<div class="panel-body">
									<div class="form-group" style="border-top:1px dotted #ddd;">
										<div class="col-md-12">
											<label class="col-md-2 control-label">Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control datepicker" name="date_of_processing" id="date_of_processing" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):''); ?>"/>
                                            </div>
                                            <label class="col-md-2 control-label">Depot <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="depot" id="depot" placeholder="Depot Name" value="<?php if(isset($data)) { echo $data[0]->depot_name; } ?>" readonly />
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">Distributor <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="distributor" id="distributor" placeholder="Distributor Name" value="<?php if(isset($data)) { echo $data[0]->distributor_name; } ?>" readonly />
                                            </div>
                                            <label class="col-md-2 control-label">Sales Representative <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="sales_rep" id="sales_rep" placeholder="Sales Rep Name" value="<?php if(isset($data)) { echo $data[0]->sales_rep_name; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">Total Amount <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amount; } ?>" readonly />
                                            </div>
                                            <label class="col-md-2 control-label">Due Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control datepicker" name="due_date" id="due_date" placeholder="Due Date" value="<?php if(isset($data)) { echo (($data[0]->due_date!=null && $data[0]->due_date!='')?date('d/m/Y',strtotime($data[0]->due_date)):''); } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">CST Amount <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="cst_amount" id="cst_amount" placeholder="CST Amount" value="<?php if (isset($data)) { echo $data[0]->cst_amount; } ?>" readonly />
                                            </div>
                                            <label class="col-md-2 control-label">Final Amount <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="final_amount" id="final_amount" placeholder="Final Amount" value="<?php if(isset($data)) { echo $data[0]->final_amount; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-stripped form-group" style="border-left:none;border-right:none;">
                                        <table class="table table-bordered" style="margin-bottom: 0px;">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px">Payment Mode <span class="asterisk_sign">*</span></th>
                                                <th style="width: 300px">Ref No <span class="asterisk_sign">*</span></th>
                                                <th>Payment Date <span class="asterisk_sign">*</span></th>
                                                <th>Payment Amount <span class="asterisk_sign">*</span></th>
                                                <th>Deposit Date </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($distributor_payment_details)) {
                                                for($i=0; $i<count($distributor_payment_details); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="payment_mode[]" class="form-control payment_mode" id="payment_mode_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <option value="Cash" <?php if($distributor_payment_details[$i]->payment_mode=="Cash") { echo 'selected'; } ?>>Cash</option>
                                                        <option value="Cheque" <?php if($distributor_payment_details[$i]->payment_mode=="Cheque") { echo 'selected'; } ?>>Cheque</option>
                                                        <option value="NEFT" <?php if($distributor_payment_details[$i]->payment_mode=="NEFT") { echo 'selected'; } ?>>NEFT</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control ref_no" name="ref_no[]" id="ref_no_<?php echo $i; ?>" placeholder="Ref No" value="<?php if (isset($distributor_payment_details)) { echo $distributor_payment_details[$i]->ref_no; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control datepicker payment_date" name="payment_date[]" id="payment_date_<?php echo $i; ?>" placeholder="Payment Date" value="<?php if(isset($distributor_payment_details)) echo (($distributor_payment_details[0]->payment_date!=null && $distributor_payment_details[0]->payment_date!='')?date('d/m/Y',strtotime($distributor_payment_details[0]->payment_date)):''); ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control payment_amount" name="payment_amount[]" id="payment_amount_<?php echo $i; ?>" placeholder="Payment Amount" value="<?php if (isset($distributor_payment_details)) { echo $distributor_payment_details[$i]->payment_amount; } ?>" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control datepicker deposit_date" name="deposit_date[]" id="deposit_date_<?php echo $i; ?>" placeholder="Deposit Date" value="<?php if(isset($distributor_payment_details)) echo (($distributor_payment_details[0]->deposit_date!=null && $distributor_payment_details[0]->deposit_date!='')?date('d/m/Y',strtotime($distributor_payment_details[0]->deposit_date)):''); ?>"/>
                                                </td>
                                                <td>
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#">Delete</a>
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
                                                <td>
                                                    <input type="text" class="form-control datepicker deposit_date" name="deposit_date[]" id="deposit_date_<?php echo $i; ?>" placeholder="Deposit Date" value=""/>
                                                </td>
                                                <td>
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#">Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8">
                                                    <button type="button" class="btn btn-success" id="repeat-box" style="margin-left: 10px;">+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label">Balance Amount <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="balance_amount" id="balance_amount" placeholder="Balance Amount" value="" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/distributor_out" class="btn btn-default" type="reset" id="reset">Cancel</a>
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
                $(".payment_amount").change(function(){
                    get_balance_amount();
                });

                addMultiInputNamingRules('#form_distributor_payment_details', 'select[name="payment_mode[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_payment_details', 'input[name="ref_no[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_payment_details', 'input[name="payment_date[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_payment_details', 'input[name="payment_amount[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_payment_details', 'input[name="deposit_date[]"]', { required: true }, "");

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
                                            '<td>' + 
                                                '<input type="text" class="form-control datepicker deposit_date" name="deposit_date[]" id="deposit_date_'+counter+'" placeholder="Deposit Date" value=""/>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#">Delete</a>' + 
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