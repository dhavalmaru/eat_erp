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
							
			 @media screen and (max-width:806px) {   
			   .h-scroll { overflow-x:scroll;} .h-scroll .table-stripped{ width:805px!important;}
			  }
		</style>
		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/payment'; ?>" >Payment List </a>  &nbsp; &#10095; &nbsp; Payment Details</div>
                
                
                 <!-- PAGE CONTENT WRAPPER -->
                     <div class="page-content-wrap">
                      <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                            <form id="form_payment_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/payment/update/' . $data[0]->id; else echo base_url().'index.php/payment/save'; ?>">
                                <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">								
							     	<div class="panel-body">
								    <div class="form-group" >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Deposit <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control datepicker1" name="date_of_deposit" id="date_of_deposit" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_deposit!=null && $data[0]->date_of_deposit!='')?date('d/m/Y',strtotime($data[0]->date_of_deposit)):''); ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="bank_id" id="bank_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($bank)) { for ($k=0; $k < count($bank) ; $k++) { ?>
                                                            <option value="<?php echo $bank[$k]->id; ?>" <?php if(isset($data)) { if($bank[$k]->id==$data[0]->bank_id) { echo 'selected'; } } ?>><?php echo $bank[$k]->b_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Payment Mode <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="payment_mode" class="form-control" id="payment_mode">
                                                    <option value="">Select</option>
                                                    <option value="Cash" <?php if(isset($data)) {if ($data[0]->payment_mode=="Cash") echo 'selected';} ?>>Cash</option>
                                                    <option value="Cheque" <?php if(isset($data)) {if ($data[0]->payment_mode=="Cheque") echo 'selected';} ?>>Cheque</option>
                                                    <option value="NEFT" <?php if(isset($data)) {if ($data[0]->payment_mode=="NEFT") echo 'selected';} ?>>NEFT</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

								    <div class="h-scroll">	
                                        <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 130px">Distributor Name <span class="asterisk_sign">*</span></th>
                                                <th style="width: 300px">Outstanding Amount <span class="asterisk_sign">*</span></th>
                                                <th style="width: 300px">Invoice No <span class="asterisk_sign">*</span></th>
                                                <th style="width: 300px">Name <span class="asterisk_sign">*</span></th>
                                                <th style="width: 300px">Amount <span class="asterisk_sign">*</span></th>
                                                <th style="width: 200px" class="ref_no_ref" id="ref_no_header">Ref No <span class="asterisk_sign">*</span></th>
                                                <th style="width: 200px" class="chq_ref">Bank Name <span class="asterisk_sign">*</span></th>
                                                <th style="width: 200px" class="chq_ref">Bank City <span class="asterisk_sign">*</span></th>
                                                <!-- <th>Payment Date <span class="asterisk_sign">*</span></th> -->
                                                <th style="width: 200px">Payment Amount (In Rs)  <span class="asterisk_sign">*</span></th>
                                                <th  width="70" style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($payment_items)) {
                                                for($i=0; $i<count($payment_items); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="distributor_id[]" class="form-control distributor" id="distributor_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                                <option value="<?php echo $distributor[$k]->id; ?>" <?php if($distributor[$k]->id==$payment_items[$i]->distributor_id) { echo 'selected'; } ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control outstanding_amount" name="outstanding_amount[]" id="outstanding_amount_<?php echo $i; ?>" placeholder="Outstanding Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="hidden" class="form-control inv_no" name="inv_no[]" id="inv_no_<?php echo $i; ?>" value="<?php if (isset($payment_items)) { echo $payment_items[$i]->invoice_no; } ?>"/>
                                                    <select name="invoice_no[]" class="form-control invoice_no" id="invoice_no_<?php echo $i;?>">
                                                        <option value="On Account">On Account</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control client_name" name="client_name[]" id="client_name_<?php echo $i; ?>" placeholder="Client Name" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control final_amount" name="final_amount[]" id="final_amount_<?php echo $i; ?>" placeholder="Final Amount" value="" readonly />
                                                </td>
                                                <td class="ref_no_ref">
                                                    <input type="text" class="form-control ref_no" name="ref_no[]" id="ref_no_<?php echo $i; ?>" placeholder="Ref No" value="<?php if (isset($payment_items)) { echo $payment_items[$i]->ref_no; } ?>"/>
                                                </td>
                                                <td class="chq_ref">
                                                    <input type="text" class="form-control bank_name" name="bank_name[]" id="bank_name_<?php echo $i; ?>" placeholder="Bank Name" value="<?php if (isset($payment_items)) { echo $payment_items[$i]->bank_name; } ?>"/>
                                                </td>
                                                <td class="chq_ref">
                                                    <input type="text" class="form-control bank_city" name="bank_city[]" id="bank_city_<?php echo $i; ?>" placeholder="Bank City" value="<?php if (isset($payment_items)) { echo $payment_items[$i]->bank_city; } ?>"/>
                                                </td>
                                                <!-- <td>
                                                    <input type="text" class="form-control datepicker1 payment_date" name="payment_date[]" id="payment_date_<?php //echo $i; ?>" placeholder="Payment Date" value="<?php //if(isset($payment_items)) echo (($payment_items[0]->payment_date!=null && $payment_items[0]->payment_date!='')?date('d/m/Y',strtotime($payment_items[0]->payment_date)):''); ?>"/>
                                                </td> -->
                                                <td>
                                                    <input type="text" class="form-control payment_amount" name="payment_amount[]" id="payment_amount_<?php echo $i; ?>" placeholder="Payment Amount" value="<?php if (isset($payment_items)) { echo $payment_items[$i]->payment_amount; } ?>" />
                                                </td>
                                                <td style="text-align:center;     vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="distributor_id[]" class="form-control distributor" id="distributor_<?php echo $i;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                                <option value="<?php echo $distributor[$k]->id; ?>"><?php echo $distributor[$k]->distributor_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control outstanding_amount" name="outstanding_amount[]" id="outstanding_amount_<?php echo $i; ?>" placeholder="Outstanding Amount" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="hidden" class="form-control inv_no" name="inv_no[]" id="inv_no_<?php echo $i; ?>" value=""/>
                                                    <select name="invoice_no[]" class="form-control invoice_no" id="invoice_no_<?php echo $i;?>">
                                                        <option value="On Account">On Account</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control client_name" name="client_name[]" id="client_name_<?php echo $i; ?>" placeholder="Client Name" value="" readonly />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control final_amount" name="final_amount[]" id="final_amount_<?php echo $i; ?>" placeholder="Final Amount" value="" readonly />
                                                </td>
                                                <td class="ref_no_ref">
                                                    <input type="text" class="form-control ref_no" name="ref_no[]" id="ref_no_<?php echo $i; ?>" placeholder="Ref No" value=""/>
                                                </td>
                                                <td class="chq_ref">
                                                    <input type="text" class="form-control bank_name" name="bank_name[]" id="bank_name_<?php echo $i; ?>" placeholder="Bank Name" value=""/>
                                                </td>
                                                <td class="chq_ref">
                                                    <input type="text" class="form-control bank_city" name="bank_city[]" id="bank_city_<?php echo $i; ?>" placeholder="Bank City" value=""/>
                                                </td>
                                                <!-- <td>
                                                    <input type="text" class="form-control datepicker1 payment_date" name="payment_date[]" id="payment_date_<?php //echo $i; ?>" placeholder="Payment Date" value=""/>
                                                </td> -->
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
                                                <td colspan="10">
                                                    <button type="button" class="btn btn-success" id="repeat-box" style=" ">+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                        </div>
    								</div>

                                    <div class="h-scroll" id="denomination_div" style="<?php if(isset($data)) {if ($data[0]->payment_mode=="Cash") echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>">  
                                        <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 200px">2000 </th>
                                                <th style="width: 200px">1000 </th>
                                                <th style="width: 200px">500 </th>
                                                <th style="width: 200px">100 </th>
                                                <th style="width: 200px">50 </th>
                                                <th style="width: 200px">20 </th>
                                                <th style="width: 200px">10 </th>
                                                <th style="width: 200px">Others </th>
                                                <th style="width: 200px">Others Amount </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="denomination_2000" placeholder="" value="<?php if (isset($denomination[0])) { echo $denomination[0]->denomination_2000; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="denomination_1000" placeholder="" value="<?php if (isset($denomination[0])) { echo $denomination[0]->denomination_1000; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="denomination_500" placeholder="" value="<?php if (isset($denomination[0])) { echo $denomination[0]->denomination_500; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="denomination_100" placeholder="" value="<?php if (isset($denomination[0])) { echo $denomination[0]->denomination_100; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="denomination_50" placeholder="" value="<?php if (isset($denomination[0])) { echo $denomination[0]->denomination_50; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="denomination_20" placeholder="" value="<?php if (isset($denomination[0])) { echo $denomination[0]->denomination_20; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="denomination_10" placeholder="" value="<?php if (isset($denomination[0])) { echo $denomination[0]->denomination_10; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="denomination_other" placeholder="" value="<?php if (isset($denomination[0])) { echo $denomination[0]->denomination_other; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="denomination_other_amount" placeholder="" value="<?php if (isset($denomination[0])) { echo $denomination[0]->denomination_other_amount; } ?>"/>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="" readonly />
                                            </div>
                                            <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Balance Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="balance_amount" id="balance_amount" placeholder="Balance Amount" value="" readonly />
                                            </div> -->
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
									<a href="<?php echo base_url(); ?>index.php/payment" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
                $(".payment_amount").change(function(){
                    get_balance_amount();
                });
                // $("#distributor_id").change(function(){
                //     get_distributor_details();
                // });
                $('#payment_mode').change(function(event){
                    if($('#payment_mode').val()=="Cheque"){
                        $('.ref_no_ref').show();
                        $('.chq_ref').show();
                        $('#ref_no_header').html('Cheque No <span class="asterisk_sign">*</span>');
                        $('#denomination_div').hide();
                    } else if($('#payment_mode').val()=="NEFT"){
                        $('.ref_no_ref').show();
                        $('.chq_ref').hide();
                        $('#ref_no_header').html('NEFT No <span class="asterisk_sign">*</span>');
                        $('#denomination_div').hide();
                    } else if($('#payment_mode').val()=="Cash"){
                        $('.ref_no_ref').hide();
                        $('.chq_ref').hide();
                        $('#ref_no_header').html('Ref No <span class="asterisk_sign">*</span>');
                        $('#denomination_div').show();
                    } else {
                        $('.ref_no_ref').hide();
                        $('.chq_ref').hide();
                        $('#ref_no_header').html('Ref No <span class="asterisk_sign">*</span>');
                        $('#denomination_div').hide();
                    }
                });

                $(".distributor").change(function(){
                    get_distributor_details($(this));
                });
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_balance_amount();
                });
                $('.invoice_no').change(function(event){
                    get_invoice_details($(this));
                });
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });

                addMultiInputNamingRules('#form_payment_details', 'select[name="distributor_id[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_payment_details', 'input[name="ref_no[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_payment_details', 'input[name="bank_name[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_payment_details', 'input[name="bank_city[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_payment_details', 'input[name="payment_date[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_payment_details', 'input[name="payment_amount[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_payment_details', 'input[name="deposit_date[]"]', { required: true }, "");

                $('#payment_mode').change();
                
                $('.distributor').each(function() {
                    get_distributor_details($(this));
                });
                $('.invoice_no').each(function() {
                    get_invoice_details($(this));
                });
            });

            function get_distributor_details(elem){
                var id = elem.attr('id');
                var distributor_id = elem.val();
                var index = id.substr(id.lastIndexOf('_')+1);
                var module = 'payment';
                $('#outstanding_amount_'+index).val('');
                
                if(distributor_id!=''){
                    $.ajax({
                        url:BASE_URL+'index.php/Payment/get_total_outstanding',
                        method:"post",
                        data:'id='+$("#id").val()+'&distributor_id='+distributor_id+'&module='+module,
                        dataType:"json",
                        async:false,
                        success: function(data){
                            if(data.result==1){
                                $('#outstanding_amount_'+index).val(Math.round(parseFloat(data.total_outstanding)));
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
                        url:BASE_URL+'index.php/Payment/get_invoice_nos',
                        method:"post",
                        data:'id='+$("#id").val()+'&distributor_id='+distributor_id,
                        dataType:"json",
                        async:false,
                        success: function(data){
                            if(data.result==1){
                                $('#invoice_no_'+index).html('');
                                strInvoice_no=$('#inv_no_'+index).val();
                                var strList='<option value="On Account">On Account</option>';
                                for(var i=0; i<data.invoice_no.length; i++){
                                    if(strInvoice_no==data.invoice_no[i]){
                                        strList = strList + '<option value="'+data.invoice_no[i]+'" selected>'+data.invoice_no[i]+'</option>';
                                    } else {
                                        strList = strList + '<option value="'+data.invoice_no[i]+'">'+data.invoice_no[i]+'</option>';
                                    }
                                }
                                $('#invoice_no_'+index).html(strList);

                                // $('.invoice_no').each(function(){
                                //     var elem = $(this);
                                //     var id = elem.attr('id');
                                //     var index = id.substr(id.lastIndexOf('_')+1);
                                //     $(this).html('');
                                //     strInvoice_no=$('#inv_no_'+index).val();
                                //     var strList='<option value="On Account">On Account</option>';
                                //     for(var i=0; i<data.invoice_no.length; i++){
                                //         if(strInvoice_no==data.invoice_no[i]){
                                //             strList = strList + '<option value="'+data.invoice_no[i]+'" selected>'+data.invoice_no[i]+'</option>';
                                //         } else {
                                //             strList = strList + '<option value="'+data.invoice_no[i]+'">'+data.invoice_no[i]+'</option>';
                                //         }
                                //     }
                                //     $(this).html(strList);
                                // });
                            }
                        },
                        error: function (response) {
                            var r = jQuery.parseJSON(response.responseText);
                            alert("Message: " + r.Message);
                            alert("StackTrace: " + r.StackTrace);
                            alert("ExceptionType: " + r.ExceptionType);
                        }
                    });

                    get_balance_amount();

                    if(distributor_id==42){
                        $('#client_name_'+index).show();
                    } else {
                        $('#client_name_'+index).hide();
                    }
                }
            }

            function get_balance_amount(){
                var total_amount = 0;

                $('.payment_amount').each(function(){
                    var amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amount = total_amount + amount;
                });

                // var total_outstanding = parseFloat(get_number($('#total_outstanding').val(),2));

                // var balance_amount = total_outstanding - total_amount;

                // $("#balance_amount").val(Math.round(balance_amount*100)/100);
                $("#total_amount").val(Math.round(total_amount*100)/100);
            }

            function get_invoice_details(elem){
                var id = elem.attr('id');
                var invoice_no = elem.val();
                var index = id.substr(id.lastIndexOf('_')+1);
                $('#client_name_'+index).val('');
                $('#final_amount_'+index).val('');

                if(invoice_no!=''){
                    $.ajax({
                        url:BASE_URL+'index.php/Payment/get_invoice_details',
                        method:"post",
                        data:'id='+$("#id").val()+'&invoice_no='+invoice_no,
                        dataType:"json",
                        async:false,
                        success: function(data){
                            if(data.result==1){
                                $('#client_name_'+index).val(data.client_name);
                                $('#final_amount_'+index).val(Math.round(parseFloat(data.final_amount)));
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
            }


            jQuery(function(){
                var counter = $('.distributor').length;
                $('#repeat-box').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="box_'+counter+'_row">' + 
                                            '<td>' + 
                                                '<select name="distributor_id[]" class="form-control distributor" id="distributor_'+counter+'">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $distributor[$k]->id; ?>"><?php echo $distributor[$k]->distributor_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control outstanding_amount" name="outstanding_amount[]" id="outstanding_amount_'+counter+'" placeholder="Outstanding Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="hidden" class="form-control inv_no" name="inv_no[]" id="inv_no_'+counter+'" value=""/>' + 
                                                '<select name="invoice_no[]" class="form-control invoice_no" id="invoice_no_'+counter+'">' + 
                                                    '<option value="On Account">On Account</option>' + 
                                                '</select>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control client_name" name="client_name[]" id="client_name_'+counter+'" placeholder="Client Name" value="" readonly />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control final_amount" name="final_amount[]" id="final_amount_'+counter+'" placeholder="Final Amount" value="" readonly />' + 
                                            '</td>' + 
                                            '<td class="ref_no_ref">' + 
                                                '<input type="text" class="form-control ref_no" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Ref No" value=""/>' + 
                                            '</td>' + 
                                            '<td class="chq_ref">' + 
                                                '<input type="text" class="form-control bank_name" name="bank_name[]" id="bank_name_'+counter+'" placeholder="Bank Name" value=""/>' + 
                                            '</td>' + 
                                            '<td class="chq_ref">' + 
                                                '<input type="text" class="form-control bank_city" name="bank_city[]" id="bank_city_'+counter+'" placeholder="Bank City" value=""/>' + 
                                            '</td>' + 
                                            '<!-- <td>' + 
                                                '<input type="text" class="form-control datepicker1 payment_date" name="payment_date[]" id="payment_date_'+counter+'" placeholder="Payment Date" value=""/>' + 
                                            '</td> -->' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control payment_amount" name="payment_amount[]" id="payment_amount_'+counter+'" placeholder="Payment Amount" value=""/>' + 
                                            '</td>' + 
                                            '<td style="text-align:center; vertical-align: middle;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#box_details').append(newRow);
                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                    $(".distributor").change(function(){
                        get_distributor_details($(this));
                    });
                    $(".payment_amount").change(function(){
                        get_balance_amount();
                    });
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                        get_balance_amount();
                    });
                    $('.invoice_no').change(function(event){
                        get_invoice_details($(this));
                    });
                    $('#payment_mode').change();

                    counter++;
                });
            });
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>