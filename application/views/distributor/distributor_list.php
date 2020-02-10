<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>EAT ERP</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url().'favicon.ico'; ?>" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/theme-blue.css'; ?>"/> 
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/> 
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
    				<div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Distributor/Retailer List  </div>	 

    				<div class="heading-h3-heading">
    					<div class="pull-right btn-margin">	
    						<?php $this->load->view('templates/download');?>	
    					</div>
    				</div>	      
    			</div>	 





    			<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						<div class="pull-left btn-top" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?> margin-right: 5px;">
    							<a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/Distributor/add">
    								<span class="fa fa-plus"></span> Add Distributor/Retailer
    							</a>
    						</div>
    						<div class="pull-left btn-top" style="<?php if($access[0]->r_view=='0') echo 'display: none;';?>">
    							<a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/Distributor/locations" target="_blank">
    								<span class="fa fa-plus"></span> Distributor Locations
    							</a>
    						</div>

    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<li class="all">
    								<a  href="<?php echo base_url(); ?>index.php/Distributor/checkstatus/Approved">
    									<span class="ng-binding">Distributor</span>
    									<span id="approved">  (<?php echo $active; ?>)  </span>
    								</a>
    							</li>

    							<li class="approved" >
    								<a  href="<?php echo base_url(); ?>index.php/Distributor/checkstatus/Retailer">
    									<span class="ng-binding">Retailer</span>
    									<span id="approved"> (<?php echo $retailer; ?>)</span>
    								</a>
    							</li>

    							<li class="inactive">
    								<a  href="<?php echo base_url(); ?>index.php/Distributor/checkstatus/InActive">
    									<span class="ng-binding">InActive</span>
    									<span id="approved"> (<?php echo $inactive; ?>) </span>
    								</a>
    							</li>

    							<li class="pending">
    								<a  href="<?php echo base_url(); ?>index.php/Distributor/checkstatus/Pending">
    									<span class="ng-binding">Pending</span>
    									<span id="approved"> (<?php echo $pending; ?>) </span>
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
    										<table id="customers2" class="table datatable table-bordered" >
    											<thead>
    												<tr>
    													<th width="65"  style="text-align:center;" >Sr. No.</th>
														<th width="65" style="text-align:center;">Edit</th>
														<th width="80" style="">Action</th>
    													<th width=" ">Distributor Name</th>
    													<!--th width=" ">Sales Representative</th-->
                                                        <th width=" ">Location</th>
    													<th width=" ">Sell Out (In %)</th>
    													<th width=" ">Credit Period (In Days)</th>
    													<th width=" ">Status</th>
    													<!--<th width=" ">Creation Date</th>-->
    													
    												</tr>
    											</thead>
    											<tbody>
    												<?php for ($i=0; $i < count($data); $i++) { ?>
    												<tr>
    													<td style="text-align:center;"><?php echo $i+1; ?></td>
														<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/distributor/edit/'.$data[$i]->d_id; ?>"><i class="fa fa-edit"></i></a></td>
														<td><a href="<?php echo base_url().'index.php/distributor/single_locations/'.$data[$i]->id; ?>">View Map</a></td>
    													<td><?php echo $data[$i]->distributor_name; ?></td>
    													<!--td><?php //echo $data[$i]->sales_rep_name; ?></td-->
                                                        <td><?php echo $data[$i]->location; ?></td>
    													<td><?php echo $data[$i]->sell_out; ?></td>
    													<td><?php echo $data[$i]->credit_period; ?></td>
    													<td><?php echo ($data[$i]->status=='Approved')?'Active':$data[$i]->status; ?></td>
    													<!--<td>
                                                            <span style="display:none;">
                                                                <?php// echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('Ymd',strtotime($data[$i]->modified_on)):''); ?>
                                                            </span>
                                                            <?php// echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?></td>-->
															
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
    		<!-- END PAGE CONTAINER -->
    	</div>					
    	<?php $this->load->view('templates/footer');?>
    	<script>
    	$(document).ready(function() {               

    		var url = window.location.href;

    		if(url.includes('Approved')){
    			$('.all').attr('class','active');
    		} else  if(url.includes('InActive')){
    			$('.inactive').attr('class','active');
    		} else  if(url.includes('Retailer')){
                $('.approved').attr('class','active');
            } else  if(url.includes('Pending')){
                $('.pending').attr('class','active');
            } else {
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