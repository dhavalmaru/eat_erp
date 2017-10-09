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
		/*.fa-eye  { font-size:21px; color:#333;}
.fa-file-pdf-o{ color:#e80b0b; font-size:21px;}
.fa-paper-plane-o{ color:#520fbb; font-size:21px;}
				  @media only screen and  (min-width:645px)  and (max-width:718px) { 
				.heading-h3-heading:first-child {     width: 44%!important;}
		   	.heading-h3-heading:last-child {     width: 56%!important;}		
			.heading-h3-heading .btn-margin{ margin-bottom:0px!important; }
		   }
		  @media only screen and  (min-width:709px)  and (max-width:718px) { 			 
			.heading-h3-heading .btn-margin{   }
		   }*/
		</style>
		<style>
		.nav-contacts { margin-top:-5px;}
		.heading-h3 { border:none!important;}
		@media only screen and (min-width:711px) and (max-width:722px) {.u-bgColorBreadcrumb {
		    background-color: #eee;
		    padding-bottom: 13px;
		}}
		@media only screen and (min-width:813px) and (max-width:822px) {.u-bgColorBreadcrumb {
		    background-color: #eee;
		    padding-bottom:50px!important;
		}}
		</style>	
    </head>
    <body>								
    	<!-- START PAGE CONTAINER -->
    	<div class="page-container page-navigation-top">            
    		<!-- PAGE CONTENT -->
    		<?php $this->load->view('templates/menus');?>
    		<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">

    			<div class="heading-h3"> 
    				<div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Distributor Out List  </div>						 
    				<div class="heading-h3-heading mobile-head">
    					<div class="pull-right btn-margin">	
    						<?php $this->load->view('templates/download');?>	
    					</div>	
    					<!-- <div class="pull-right btn-margin" style="<?php //if($access[0]->r_insert=='0') echo 'display: none;';?>">
    						<a class="btn btn-success " href="<?php //echo base_url() . 'index.php/distributor_out/add'; ?>">
    							<span class="fa fa-plus"></span> Add Distributor Out Entry
    						</a>
    					</div> -->
    				</div>	      
    			</div>

    			<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						<div class="pull-left   btn-top" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
    							<a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/distributor_out/add">
    								<span class="fa fa-plus"></span> Add Distributor Out Entry
    							</a>
    						</div>

    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<li class="all">
    								<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus">
    									<span class="ng-binding">All</span>
    									<span id="approved">  (<?php echo $all; ?>)  </span>
    								</a>
    							</li>

    							<li class="approved" >
    								<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/Approved">
    									<span class="ng-binding">Approved</span>
    									<span id="approved"> (<?php echo $active; ?>)</span>
    								</a>
    							</li>

    							<li class="inactive">
    								<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/InActive">
    									<span class="ng-binding">InActive</span>
    									<span id="approved"> (<?php echo $inactive; ?>) </span>
    								</a>
    							</li>

    							<li class="pending">
    								<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/Pending">
    									<span class="ng-binding">Pending</span>
    									<span id="approved"> (<?php echo $pending; ?>) </span>
    								</a>
    							</li>

                                <li class="pending_for_delivery">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending_for_delivery">
                                        <span class="ng-binding">Pending For Delivery</span>
                                        <span id="approved"> (<?php echo $pending_for_delivery; ?>) </span>
                                    </a>
                                </li>
    						</ul>
    						
    					</div>
    				</div>
    			</div>

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

    													<th width="65" align="center">Sr. No.</th>
    													<th width="156">Date Of processing</th>
    													<th width="130">Invoice No</th>
    													<th width="140">Depot Name</th>
    													<th width="140">Distributor Name</th>
    													<th width="220" >Sales Representative Name</th>
    													<th width="120" >Amount (In Rs)</th>
    													<th width="110" >Creation Date</th>
    													<th width="105" style="text-align:center;">View Invoice</th>
    													<th width="50" style="display:none;">Resend Invoice</th>
    												</tr>
    											</thead>
    											<tbody>
    												<?php for ($i=0; $i < count($data); $i++) { ?>
    												<tr>
    													<td  style="text-align:center;"><?php echo $i+1; ?></td>
    													<td><a href="<?php echo base_url().'index.php/distributor_out/edit/'.$data[$i]->d_id; ?>"><?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?></a></td>
    													<td><?php echo (strtoupper(trim($data[$i]->class))=='SAMPLE')?$data[$i]->voucher_no:$data[$i]->invoice_no; ?></td>
    													<td><?php echo $data[$i]->depot_name; ?></td>
    													<td><?php echo $data[$i]->distributor_name; ?></td>
    													<td><?php echo $data[$i]->sales_rep_name; ?></td>
    													<td><?php echo format_money($data[$i]->final_amount,2); ?></td>
    													<td><?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?></td>
    													<td style="text-align:center; vertical-align: middle;"><?php if (($data[$i]->invoice_no!=null && $data[$i]->invoice_no!='') || ($data[$i]->voucher_no!=null && $data[$i]->voucher_no!='')) { ?><a href="<?php echo base_url().'index.php/distributor_out/view_tax_invoice/'.$data[$i]->id; ?>" target="_blank">  <span class="fa fa-file-pdf-o"></span></a><?php } ?></td>
    													<td style="text-align:center; vertical-align: middle; display:none;"><a href="<?php //echo base_url().'index.php/distributor_out/view_payment_details/'.$data[$i]->id; ?>#"><span class="fa fa-eye">Resend Invoice</span></a></td>
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

    		if(url.includes('Approved')){
    			$('.approved').attr('class','active');
    		}
    		else  if(url.includes('InActive')){
    			$('.inactive').attr('class','active');
    		}
            else  if(url.includes('Pending')){
                $('.pending').attr('class','active');
            }
            else  if(url.includes('pending_for_delivery')){
                $('.pending_for_delivery').attr('class','active');
            }
    		else {
    			$('.all').attr('class','active');
    		} 
    		$('.ahrefall').click(function(){
    			alert(window.location.href );
                    //$('.a').attr('class','active');
                });
    	});
    	</script>

    	<!-- END SCRIPTS -->      
    </body>
</html>