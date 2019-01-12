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
            input[readonly], input[disabled], select[disabled], textarea[disabled] {
                background-color: white !important; 
                color: #0b385f !important; 
                cursor: not-allowed !important;
            }
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
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/credit_debit_note'; ?>" >Credit Debit Note  List </a>  &nbsp; &#10095; &nbsp; Credit Debit Note Details</div>
				   
				   
                 <!-- PAGE CONTENT WRAPPER -->
                     <div class="page-content-wrap">
                      <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
							
                            <form id="form_credit_debit_note_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/credit_debit_note/update/' . $data[0]->id; else echo base_url().'index.php/credit_debit_note/save'; ?>">
                             <div class="box-shadow-inside">
                               <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">								
							     	<div class="panel-body">
									  <div class="form-group" >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Transaction <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="hidden" class="form-control" name="ref_id" id="ref_id" value="<?php if(isset($data)) echo $data[0]->ref_id;?>"/>
                                                <input type="hidden" class="form-control" name="ref_no" id="ref_no" value="<?php if(isset($data)) { echo $data[0]->ref_no; } ?>"/>
                                                <input type="hidden" class="form-control" name="ref_date" id="ref_date" value="<?php if(isset($data)) { echo (($data[0]->ref_date!=null && $data[0]->ref_date!='')?date('d/m/Y',strtotime($data[0]->ref_date)):''); } ?>"/>
                                                <input type="text" class="form-control datepicker1" name="date_of_transaction" id="date_of_transaction" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_transaction!=null && $data[0]->date_of_transaction!='')?date('d/m/Y',strtotime($data[0]->date_of_transaction)):''); ?>"/>

                                            </div>
										</div>
										</div>
									
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor Type <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="distributor_type" id="distributor_type">
                                                    <option value="Promotion" <?php if(isset($data)) {if ($data[0]->distributor_type=='Promotion') echo 'selected';}?>>Promotion</option>
                                                    <option value="Invoice" <?php if(isset($data)) {if ($data[0]->distributor_type=='Invoice') echo 'selected';}?>>Invoice</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="distributor_id" id="distributor_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                            <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) { if($distributor[$k]->id==$data[0]->distributor_id) { echo 'selected'; } } ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <input type="hidden" class="form-control" name="state" id="state" value=""/>
                                                <input type="hidden" class="form-control" name="state_code" id="state_code" value=""/>
                                                <!-- <input type="hidden" name="distributor_id" id="distributor_id" value="<?php //if(isset($data)) { echo $data[0]->distributor_id; } ?>"/>
                                                <input type="text" class="form-control load_distributor" name="distributor" id="distributor" placeholder="Type To Select Distributor...." value="<?php //if(isset($data)) { echo $data[0]->distributor_name; } ?>"/> -->
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Outstanding (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_outstanding" id="total_outstanding" placeholder="Total Outstanding" value="" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Transaction <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="transaction">
                                                    <option value="Credit Note" <?php if(isset($data)) {if ($data[0]->transaction=='Credit Note') echo 'selected';}?>>Credit Note</option>
                                                    <option value="Debit Note" <?php if(isset($data)) {if ($data[0]->transaction=='Debit Note') echo 'selected';}?>>Debit Note</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                    </div>
									
									<div class="form-group" id="invoice_no_div">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Invoice No. <span class="asterisk_sign"></span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="invoice_no" id="invoice_no" class="form-control">
                                                    <option value="">Select</option>
													 <?php if(isset($invoice)) { for ($k=0; $k < count($invoice) ; $k++) { ?>
                                                            <option value="<?php echo $invoice[$k]->invoice_no; ?>" <?php if (isset($data)) { if($invoice[$k]->invoice_no==$data[0]->invoice_no) { echo 'selected'; } } ?>><?php echo $invoice[$k]->invoice_no; ?></option>
                                                    <?php }} ?>
                                                </select>
                                          
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
									
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="amount_without_tax" id="amount_without_tax" placeholder="Amount" value="<?php if(isset($data)) echo $data[0]->amount_without_tax;?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tax (In %) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="tax" id="tax" placeholder="Tax" value="<?php if(isset($data)) echo $data[0]->tax;?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">IGST (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="igst" id="igst" placeholder="IGST" value="<?php if(isset($data)) echo $data[0]->igst;?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">CGST (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="cgst" id="cgst" placeholder="CGST" value="<?php if(isset($data)) echo $data[0]->cgst;?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">SGST (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="sgst" id="sgst" placeholder="SGST" value="<?php if(isset($data)) echo $data[0]->sgst;?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if(isset($data)) echo $data[0]->amount;?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select class="form-control" name="status">
                                                        <option value="Pending" <?php if(isset($data)) {if ($data[0]->status=='Pending') echo 'selected';}?>>Pending</option>
                                                        <option value="Deleted" <?php if(isset($data)) {if ($data[0]->status=='Deleted') echo 'selected';}?>>Deleted</option>
                                                        <option value="Rejected" <?php if(isset($data)) {if ($data[0]->status=='Rejected') echo 'selected';}?>>Rejected</option>
                                                        <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Approved</option>
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
                                                <textarea class="form-control" name="remarks" id="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                 </div>
						        <br clear="all"/>
				            </div>
							</div>
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/credit_debit_note" class="btn btn-danger btn-sm pull-right" type="reset" id="reset">Cancel</a>
                                    <?php $curusr=$this->session->userdata('session_id'); ?>
                                    <input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Submit For Approval" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_edit=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved' || $data[0]->status=='InActive')) echo ''; else echo 'display: none;';} else if($access[0]->r_insert=='1') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_delete" name="btn_delete" value="Delete" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_delete=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved') && $data[0]->status!='InActive') echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-success btn-sm" id="btn_approve" name="btn_approve" value="Approve" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_reject" name="btn_reject" value="Reject" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                </div>
							
							 </form>
						   </div>
                      </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
				 </div>
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
                if(!$('#btn_submit').is(':visible')){
                    $("input[type!='hidden']").attr("disabled", true);
                    // $("select:visible").attr("disabled", true);
                    $("textarea").attr("disabled", true);

                    $("#btn_approve").attr("disabled", false);
                    $("#btn_reject").attr("disabled", false);
                    $("#remarks").attr("disabled", false);
                }

                $("#distributor_id").change(function(){
                    get_distributor_details();
                    get_tax();
                });

                $("#amount_without_tax").change(function(){
                    get_tax();
                });

                $("#tax").change(function(){
                    get_tax();
                });

                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });

                get_distributor_details();
            });


            function get_tax(){
                $.ajax({
                    url:BASE_URL+'index.php/Distributor/get_data',
                    method:"post",
                    data:{id:$('#distributor_id').val()},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            // if(!isNaN($('#amount_without_tax').val()) && $('#amount_without_tax').val()!='' && !isNaN($('#tax').val()) && $('#tax').val()!=''){
                            //     // if($('#distributor_id').val()!="214" && $('#distributor_id').val()!="550") {
                            //         var state = data.state;
                            //         var state_code = data.state_code;
                            //         if (state_code=='27')
                            //         {
                            //             $('#igst').val("0");
                            //             var tax = $('#tax').val();
                            //             var amount = $('#amount_without_tax').val();
                            //             cgst=(tax/2)*amount/100;
                            //             sgst=(tax/2)*amount/100;
                            //             $('#cgst').val(cgst);
                            //             $('#sgst').val(sgst);
                            //             var total_amount = parseInt(amount)+parseInt(cgst)+parseInt(sgst);
                            //             $('#total_amount').val(total_amount);
                            //         }
                            //         else {
                            //             $('#cgst').val('0');
                            //             $('#sgst').val('0');
                            //             var tax = $('#tax').val();
                            //             var amount = $('#amount_without_tax').val();
                            //             igst=tax*amount/100;
                            //             $('#igst').val(igst);
                            //             var total_amount = parseInt(amount)+parseInt(igst);
                            //             $('#total_amount').val(total_amount);
                            //         }
                            //     // }
                            // }

                            var tax = 0;
                            var amount = 0;

                            if($('#amount_without_tax').val()!=''){
                                amount = get_number($('#amount_without_tax').val());
                            }
                            if($('#tax').val()!=''){
                                tax = get_number($('#tax').val());
                            }
                            var state = data.state;
                            var state_code = data.state_code;
                            if (state_code=='27')
                            {
                                $('#igst').val("0");
                                var cgst=Math.round(((tax/2)*amount/100)*100)/100;
                                var sgst=Math.round(((tax/2)*amount/100)*100)/100;
                                $('#cgst').val(cgst);
                                $('#sgst').val(sgst);
                                // var total_amount = parseInt(amount+cgst+sgst);
                                var total_amount = Math.round((amount+cgst+sgst)*100)/100;
                                $('#total_amount').val(total_amount);
                            } else {
                                $('#cgst').val('0');
                                $('#sgst').val('0');
                                var igst=Math.round((tax*amount/100)*100)/100;
                                $('#igst').val(igst);
                                // var total_amount = parseInt(amount+igst);
                                var total_amount = Math.round((amount+igst)*100)/100;
                                $('#total_amount').val(total_amount);
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
			
			
			$('#distributor_id').change(function(){
				  var distributor_id = $('#distributor_id').val();
					//console.log(reporting_manager_id);
				  // AJAX request
				  $.ajax({
					url:'<?=base_url()?>index.php/credit_debit_note/get_invoice',
					method: 'post',
					data: {distributor_id: distributor_id},
					dataType: 'json',
					success: function(response){

			 
					  $('#invoice_no').find('option').not(':first').remove();
				  

					  // Add options
					  // response = $.parseJSON(response);
					  // console.log(response);
					  $.each(response,function(index,data){
						 $('#invoice_no').append('<option value="'+data['invoice_no']+'">'+data['invoice_no']+'</option>');
					
					  });
					}
				 });
			   });
			

            function get_distributor_details(){
                var distributor_id = $('#distributor_id').val();
                var module = 'credit_debit_note';

                if(distributor_id!=''){
                    $.ajax({
                        url:BASE_URL+'index.php/Payment/get_total_outstanding',
                        method:"post",
                        data:'id='+$("#id").val()+'&distributor_id='+distributor_id+'&module='+module,
                        dataType:"json",
                        async:false,
                        success: function(data){
                            if(data.result==1){
                                $('#total_outstanding').val(data.total_outstanding);
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

    		$('#distributor_type').change(function(){	
        		if($('#distributor_type').val()=='Invoice') {
        			$('#invoice_no_div').show();
        			$('#tax').val('5');
        		} else {
        			$('#invoice_no_div').hide();
        			$('#tax').val('');
        		}
    		});
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>