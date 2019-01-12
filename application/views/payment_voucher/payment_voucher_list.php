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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>    
        <!-- EOF CSS INCLUDE -->    
		<style> 
		   	@media only screen and  (min-width:645px)  and (max-width:718px) { 
				.heading-h3-heading:first-child {     width: 44%!important;}
				.heading-h3-heading:last-child {     width: 56%!important;}		
				.heading-h3-heading .btn-margin{ margin-bottom:0px!important; }
		   	}
		  	@media only screen and  (min-width:709px)  and (max-width:718px) { 			 
				.heading-h3-heading .btn-margin{   }
		   	}
		</style>	
    </head>
    <body>								
     	<!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                   <div class="heading-h3"> 
                   <div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Payment List  </div>						 
					  <div class="heading-h3-heading mobile-head">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                       	<div class="pull-right btn-margin" style="<?php //if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success " href="<?php echo base_url() . 'index.php/Payment_voucher/add'; ?>">
										<span class="fa fa-plus"></span> Add Payment Voucher
									</a>
								</div>
				     </div>	      
                </div>	
                
    			<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						

    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<!--<li class="all">
    								<a  href="<?php //echo base_url(); ?>index.php/payment/checkstatus/All">
    									<span class="ng-binding">All</span>
    									<span id="approved">  (<?php //echo $all; ?>)  </span>
    								</a>
    							</li>-->

    							<li class="approved" >
    								<a  href="<?php echo base_url(); ?>index.php/Payment_voucher/checkstatus">
    									<span class="ng-binding">All</span>
    									<span id="approved"> (<?php echo $all; ?>)</span>
    								</a>
    							</li>
    						</ul>
    						
    					</div>
    				</div>
    			</div>

                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">                
                    <div class="row">
					  <div class="page-width">	
                        <div class="col-md-12">
					      <div class="panel panel-default">		
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered"  >
									<thead>
										<tr>
										    <th width="50" style="text-align:center;"> Sr. No.</th>
										    <th width="50" style="text-align:center;">Edit </th>
											<th width="110">Type</th>
											<th width="125">Party Name</th>
											<th width="100">Invoice No</th>
											<th width="100">Total Payable Amount</th>
									      	<!-- <th width="125"> Total Amount (In Rs) </th> -->
									      	
											<th width="50"  style="text-align:center;">Invoice</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<td style="text-align:center;"> <a href="<?=base_url()?>index.php/Payment_voucher/edit/<?=$data[$i]->payment_voucher_id?>"><i class="fa fa-edit"></i></a></td>
											<td><?php echo $data[$i]->type; ?></td>
											<td><?php echo $data[$i]->vendor_name; ?></td>
											<td><?php echo $data[$i]->invoice_no; ?></td>
											<td><?php echo $data[$i]->total_payable; ?></td>
											<!-- <td><?php echo $data[$i]->final_amount; ?></td> -->
											
											<td class="view_payment_slip" style="text-align:center;vertical-align: middle;">
												<a href="<?=base_url()?>index.php/Payment_voucher/payment_voucher_receipt/<?=$data[$i]->payment_voucher_id?>" target="_blank"><span class="fa fa-file-pdf-o" style="font-size:20px;"></span></a>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->
                            
						</div>
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
		<script>
	    	$(document).ready(function() {
	    		var url = window.location.href;

	    		if(url.includes('All')){
	                $('.all').attr('class','active');
	                $('.view_payment_slip').hide();
	            }
	            else if(url.includes('InActive')){
	                $('.inactive').attr('class','active');
	                $('.view_payment_slip').hide();
	            }
	            else if(url.includes('Approved')){
	                $('.approved').attr('class','active');
	            }
	            else if(url.includes('Pending')){
	                $('.pending').attr('class','active');
	                $('.view_payment_slip').hide();
	            }
	            else  if(url.includes('Rejected')){
	                $('.rejected').attr('class','active');
	                $('.view_payment_slip').hide();
	            } 
	            else {
	                $('.approved').attr('class','active');
	            }
	    	});
		</script>
    <!-- END SCRIPTS -->      
    </body>
</html>