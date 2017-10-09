<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Portfolio Management</title>            
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
			.tile {padding: 0px;
				   min-height: 77px;}
		</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <?php $this->load->view('templates/menus');?>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- PAGE CONTENT WRAPPER -->
                <?php
                if($action == 'edit_insert'){?>
                <div class="page-content-wrap">
                <form id="form_tax" method="post" action="<?php echo base_url()?>index.php/Tax_master/insertUpdateRecord">
                    <div class="row">
					
						<div class="col-md-1">&nbsp;</div>
						
                        <div class="col-md-10">
						<div class="panel panel-default">
							
							<div class="panel-heading">
								<h3 class="panel-title"> <strong>Tax Master</strong></h3>
							</div>
							<div class="panel-body">                                                                        
                                <input type="hidden" name="tax_id[]" id="tax_id_1" value="<?php if(isset($tax_detail)){ echo $tax_detail[0]->tax_id; }  ?>">
								<div id="tax_divid_1">
								<div class="row tax_div_1" id="tax_div_1">
									<div class="form-group" style="float: left;width: 100%;border-top:1px solid #ddd;">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-4 position-name control-label">Tax Name *</label>
												<div class="col-md-8 position-view">
													<input type="text" class="form-control tax_name" name="tax_name[]" id="tax_name_1" placeholder="Tax Name" value="<?php if(isset($tax_detail)){ echo $tax_detail[0]->tax_name; } ?>"/>
												</div>
											</div>
										</div>
                                         <div class="col-md-6">
                                             <div class="">
                                                <label class="col-md-4 position-name control-label">Tax Percentage *</label>
                                                <div class="col-md-8 position-view">
                                                    <input type="text" class="form-control tax_perecnt" name="tax_perecnt[]" placeholder="Tax Perecenatge" value="<?php if(isset($tax_detail)){ echo $tax_detail[0]->tax_percent; } ?>"/>
                                                </div>
                                             </div>
                                        </div>
                                     </div>
                                     <div class="form-group" style="float: left;width: 100%;">
                                        <div class="col-md-6">
                                             <div class="">
                                                <label class="col-md-4 position-name control-label">Transaction Action *</label>
                                                    <div class="col-md-8 position-view">
                                                        <input type="radio" class="txn_action" data-error="#txn_action_1_error" name="txn_type_1" id="txn_type_add_1" value="1" <?php if(isset($tax_detail)){if($tax_detail[0]->tax_action == "1")  echo "checked='checked'";}?> >&nbsp;&nbsp;Add To Amount
                                                        <input type="radio" name="txn_type_1" id="txn_type_sub_1" value="0" <?php if(isset($tax_detail)){if($tax_detail[0]->tax_action == '0')  echo "checked='checked'";}?> >&nbsp;&nbsp;Subtract from Amount
                                                        <div id="txn_action_1_error"></div>
                                                    </div>
                                             </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-4 position-name control-label">Effective From *</label>
                                                <div class="col-md-8 position-view">
                                                    <input type="text" class="form-control datepicker" name="effective_date[]" id="effective_date_1" placeholder="Effective From" value="<?php if(isset($tax_detail)){if($tax_detail[0]->effective_date!=null && $tax_detail[0]->effective_date!='') echo date('d/m/Y',strtotime($tax_detail[0]->effective_date));}?>" required>
                                                    <div id="txn_action_1_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="col-md-12" >
                                    <button  type="button"  class="btn btn-success" style="margin-left: 10px;"  onclick="addNewRow(this)">+</button>
                                    <button  type="button"  class="btn btn-success" style="margin-left: 10px;"  onclick="removeNewRow(this)">-</button>
                                </div>
                                </div>

                                <div class="row">
                                	<div class="" style="float: left;width: 100%;"><br>
                                     	<div class="col-md-6" style="float:right;    text-align: right;">
                                     		<input type="submit" class="btn btn-success" value="Submit" />
                                     	</div>
                                    	<div class="col-md-6" style="float:left;    text-align: left;">
                                     		<a href="<?php echo base_url(); ?>index.php/tax_master" class="btn btn-default">Cancel</a>
                                     	</div>
                                    </div>
                                </div>
                            </div>
						</div>
						</div>

						<div class="col-md-1"></div>
                    </div>
                    </div>

                </form>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
                <?php } else{?>
                <div class="page-content-wrap">
                <form method="post" action="<?php echo base_url()?>index.php/Tax_master/insertUpdateRecord">
                    <div class="row">
    				
    					<div class="col-md-1">&nbsp;</div>
    					
                        <div class="col-md-10">
    					<div class="panel panel-default">
    						
    						<div class="panel-heading">
    							<h3 class="panel-title"><strong>Tax Master</strong></h3>
                                <a href="<?php echo base_url(); ?>index.php/tax_master" class=""><span class="btn btn-default pull-right btn-font"> Cancel </span>  </a>
                                <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?>
                                    <a href="<?php echo base_url(); ?>index.php/tax_master/tax_edit/<?php echo $tax_detail[0]->tax_id;?>" class=""><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>
                                <?php  }} ?>
                                 <a class="printdiv"> <span class="btn btn-default pull-right btn-font"> Print </span>  </a>
    						</div>
                      <div id="pdiv" >  
    						<div class="panel-body">
    							<div class="row">
    								<div class="form-group" style="float: left;width: 100%;border-top:1px solid #ddd;">
    									<div class="col-md-6">
    										<div class="">
    											<label class="col-md-4 control-label">Tax Name</label>
    											<div class="col-md-8">
    												<?php echo $tax_detail[0]->tax_name;?>
    											</div>
    										</div>
    									</div>
                                         <div class="col-md-6">
                                             <div class="">
                                                <label class="col-md-4 control-label">Tax Percentage</label>
                                                    <div class="col-md-8">
                                                        <?php echo $tax_detail[0]->tax_percent;?>  %
                                                    </div>
                                             </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                <div class="form-group" style="float: left;width: 100%;">
                                <div class="col-md-6">
                                <?php $tranasction_type=array("Subtract From Amount","Add To Amount"); ?>
                                    <div class="">
                                        <label class="col-md-4 control-label">Transaction Action</label>
                                            <div class="col-md-8">
                                                <?php echo $tranasction_type[$tax_detail[0]->tax_action];?>
                                            </div>
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-md-4 control-label">Effective Date</label>
                                    <div class="col-md-8">
                                        <?php if(isset($tax_detail)){if($tax_detail[0]->effective_date!=null && $tax_detail[0]->effective_date!='') echo date('d/m/Y',strtotime($tax_detail[0]->effective_date));}?>
                                    </div>
                                </div>
                                </div>
                                </div>
                               <!--   <div class="row">
                                 	<div class="form-group">
                                 	<div class="col-md-12" align="right">
                                 		<input type="submit" class="btn btn-success" value="Submit" />
                                 	</div>
                                 </div>
                                 </div> -->
                            </div>

    					</div>
                        </div>
                    
                        <div class="col-md-1"></div>

                    </div>
                </form>
                </div>
           
                <?php } ?>
            </div>
            <!-- END PAGE CONTENT WRAPPER -->     
        </div>
        <!-- END PAGE CONTENT -->

        <?php $this->load->view('templates/footer');?>
          <script type="text/javascript">
            
$(document).ready(function(){
        $('.table').addClass('table-active table table-bordered');    
  });

      </script>

 <script>

       $('.printdiv').click(function(){

            var divToPrint=document.getElementById('pdiv');

              var newWin=window.open('','Print-Window');

              newWin.document.open();
                 $('th').css("border","1px solid #ddd !important");
            $('th').css("border-right","1px solid #ddd !important")

              newWin.document.write('<html><link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css" media="print"/><scr'+'ipt>$(".table").removeClass("table table-bordered").addClass("table-active")</scr'+'ipt><style>body {text-align:justify;  word-break: break-all;}table, tr, th, td{border:1px solid #ddd !important;border-left:1px solid #ddd !important;border-right:1px solid #ddd !important;}table, th {font-weight:600; font-size:13px;}.position-main{width:50% !important;}.dates{position:absolute;left:40%;} .position-main .col-md-5{width:35% !important;}  .position-main .col-md-7{width:60% !important;} .position-main-1{width:100%!important; padding:5px 10px; border:1px solid #eee !important; margin-top:3px!important;} .position-main-1 .col-md-8{ position:absolute;left:10%;}table, td {font-weight:500; }table{width:100%!important;} table th, td{padding:5px;}.table th{ border1px solid #ddd !important;}#pdiv{position:relative;}.position-view-1{position:absolute; Width:100%;!important; left:10%;overflow-x:hidden !important;}.th{display:none;}.form-group{border:1px solid #eee !important;} .sp-large{width:200px !important;height:120px!important;} #map {width:200px !important; margin-top:50px !important;} .td{display:none;} .position-address{position:absolute;right:-5%; top:0;} .panel-body {padding:0px;max-width:800px;background:#fff;margin:auto;}table, th {font-weight:600; font-size:13px;} table, td {font-weight:500; } .table-active{width:100% !important;} table {width:100% !important;} .print-left{margin-left:0px !important;}.panel-heading {padding:15px 0!important;border:0px solid transparent!important;background:#F5F5F5; max-width:800px; margin:auto;border-radius:0;}.table-active{width:100%!important;}.position-name{width:50%!important; padding: 0!important; overflow-x:hidden;} .position-parking{width:44% !important; padding:0!important; overflow-x:hidden; }.position-view{  position:absolute; overflow-x:hidden; left:30%; }.form-group{border:1px solid #ddd;border-bottom:1px dotted #ddd;border-top:none;padding:8px 0;background:#fcfdfd; margin-bottom:0; display:flex; clear:both; min-height:auto!important;}.panel-body {padding:0px;background: #fff;}.position{position:absolute; width:72%; overflow-x:hidden!important; left:28%;}.position-email{position:absolute; width:100% !important; overflow-x:hidden !important; left:20%;}.col-md-1 {width:8%; float:left;}.col-md-2 {width:16%;float:left;}.col-md-3  {float:left;} .col-md-4 {width:37%;float:left;} .col-md-5 {width:41%;float:left;} .col-md-6 { width:50%; float:left; } .col-md-7 {width:58%;float:left;}.col-md-8 {width:63%;float:left;}.col-md-9 { }.col-md-10 {width:100%;float:left;} .clear-all{clear:both !important;} .dataTables_length{display:none!important;} .dataTables_filter{display:none;}.downloads{display:none !important;}.table-bordered{border-top: 1px solid #ddd !important;}.sorting,.datatable {border: 1px solid #ddd !important;}@media print {a[href]:after { content: none !important; sp-thumbs{display:none;}.sorting_1,.Contact_name {padding:5px !important;} </style><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script>
            var div_master = "";

            function addNewRow(mydiv){
            //alert(mydiv);
            	var newdiv = 0;
            	var $maindiv = $(mydiv).parents('div[id^="tax_divid_"]');
            	var $div = $($maindiv).find('div[id^="tax_div_"]:last'); 

            	var lastdivid = $div.attr("id");
            	var slice_divid = lastdivid.split("_");
            	var new_divid = parseInt(slice_divid[2]) + 1;
            	var $newdiv = $div.clone().find("input:text").val("").end().find("input:checkbox").attr('checked', false).end().find("input:radio").attr('checked', false).end().prop('id', 'tax_div_'+new_divid );
                //var $newdiv.("#tax_id_1").val(' ');
            	//var $newremovebutton = $($newdiv).find('button[id^="removebutton_"]');
                var $newtextboxtaxname = $($newdiv).find('input[id^="tax_name_"]');
                // var $newcheckbox = $($newdiv).find('input[name^="txn_for_"]');
                // var $newcheckboxpurchase = $($newdiv).find('input[id^="txn_purchase_"]');
                // var $newcheckboxsale = $($newdiv).find('input[id^="txn_sale_"]');
                // var $newcheckboxrent = $($newdiv).find('input[id^="txn_rent_"]');
                // var $newcheckboxloan = $($newdiv).find('input[id^="txn_loan_"]');
                // var $newcheckboxmaintenance = $($newdiv).find('input[id^="txn_maintenance_"]');
                // var $newcheckboxvaluation = $($newdiv).find('input[id^="txn_valuation_"]');
                // var $newcheckboxerror = $($newdiv).find('div[id^="txn_type_"]');
                var $newrediobutton = $($newdiv).find('input[id^="txn_type_add_"]');
                var $newrediobutton2 = $($newdiv).find('input[id^="txn_type_sub_"]');
                var $newradioerror = $($newdiv).find('div[id^="txn_action_"]');

                //console.log($newrediobutton);

                $($newtextboxtaxname).prop('id','tax_name_'+new_divid);
                // $($newcheckbox).prop('name','txn_for_'+new_divid+'[]');
                // $($newcheckboxpurchase).prop('id','txn_purchase_'+new_divid);
                // $($newcheckboxpurchase).attr('data-error','#txn_type_'+new_divid+'_error');
                // $($newcheckboxsale).prop('id','txn_sale_'+new_divid);
                // $($newcheckboxrent).prop('id','txn_rent_'+new_divid);
                // $($newcheckboxloan).prop('id','txn_loan_'+new_divid);
                // $($newcheckboxmaintenance).prop('id','txn_maintenance_'+new_divid);
                // $($newcheckboxvaluation).prop('id','txn_valuation_'+new_divid);
                // $($newcheckboxerror).prop('id','txn_type_'+new_divid+'_error');
                $($newrediobutton).prop('name','txn_type_'+new_divid).prop('id','txn_type_add_'+new_divid).attr('data-error','#txn_action_'+new_divid+'_error');
                $($newrediobutton2).prop('name','txn_type_'+new_divid).prop('id','txn_type_sub_'+new_divid);
                $($newradioerror).prop('id','txn_action_'+new_divid+'_error');
                $($newdiv).find('input[id^="effective_date_"]').prop('id','effective_date_'+new_divid);
 $newdiv.find('#effective_date_'+new_divid).removeClass('hasDatepicker').removeData('datepicker').datepicker({autoclose:true, dateFormat: "dd/mm/yy",  yearRange: "-100:+0",changeMonth: true, changeYear: true });  

                // $($newremovebutton).prop('id','removebutton_'+new_divid);
                $newdiv.insertAfter($div);
                // $($div).find('.div_master').select2();
                // $($newdiv).find('.div_master').select2();

            }

            function removeNewRow(mydiv){
                //alert(mydiv);
                var newdiv = 0;
                var $maindiv = $(mydiv).parents('div[id^="tax_divid_"]');
                var $div = $($maindiv).find('div[id^="tax_div_"]:last'); 

                var lastdivid = $div.attr("id");
                if (lastdivid!="tax_div_1"){
                    $('#' + lastdivid).remove();
                }
            }
        </script>
        <!-- END SCRIPTS -->
      <!-- END SCRIPTS -->      
  
    </body>
</html>