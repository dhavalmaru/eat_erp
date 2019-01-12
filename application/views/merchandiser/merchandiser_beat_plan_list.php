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
        <!-- EOF CSS INCLUDE -->    
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
            <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                   	<div class="heading-h3"> 
                   	<div class="heading-h3-heading mobile-head"  style="width: 25%;">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Sales Representative List  </div>						 
					  	<div class="heading-h3-heading mobile-head"  style="width: 75%;">
					  	<div class="pull-right btn-margin">	
							<?php $this->load->view('templates/download');?>	
						</div>
                        <div class="container u-posRelative u-textRight">
                            <div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
                                <a class="btn btn-success" href="<?php echo base_url() . 'index.php/sales_rep/add'; ?>">
                                    <span class="fa fa-plus"></span> Add Sales Representative
                                </a>
                            </div>
                           <!-- <div class="pull-right   btn-margin" style="<?php if($access[0]->r_view=='0') echo 'display: none;';?>">
                                <a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/sales_rep/sales_rep_route_plan">
                                    <span class="fa fa-plus"></span> Sales Representative Route Plan
                                </a>
                            </div>
                            <div class="pull-right   btn-margin" style="<?php if($access[0]->r_view=='0') echo 'display: none;';?>">
                                <a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/sales_rep/sales_rep_location">
                                    <span class="fa fa-plus"></span> Promoters Location
                                </a>
                            </div>-->
							
                        </div>
			     	</div>	      
                	</div>

                	<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					
    				</div>
    				</div>
					
					<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						

    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<!--<li class="all">
    								<a  href="<?php //echo base_url(); ?>index.php/distributor_in/checkstatus/All">
    									<span class="ng-binding">All</span>
    									<span id="approved">  (<?php //echo $all; ?>)  </span>
    								</a>
    							</li>-->

    							<li class="Monday" >
    								<a  href="<?php echo base_url(); ?>index.php/Merchandiser_beat_plan/checkstatus/Monday">
    									<span class="ng-binding"> Monday </span>
    									<span id="Monday"> (<?php echo $Monday; ?>)</span>
    								</a>
    							</li>

    							<li class="Tuesday">
    								<a  href="<?php echo base_url(); ?>index.php/Merchandiser_beat_plan/checkstatus/Tuesday">
    									<span class="ng-binding"> Tuesday</span>
    									<span id="Tuesday"> (<?php echo $Tuesday; ?>) </span>
    								</a>
    							</li>

                                <li class="Wednesday">
                                    <a  href="<?php echo base_url(); ?>index.php/Merchandiser_beat_plan/checkstatus/Wednesday">
                                        <span class="ng-binding">Wednesday</span>
                                        <span id="Wednesday"> (<?php echo $Wednesday; ?>) </span>
                                    </a>
                                </li>

                                <li class="Thursday">
                                    <a  href="<?php echo base_url(); ?>index.php/Merchandiser_beat_plan/checkstatus/Thursday">
                                        <span class="ng-binding">Thursday</span>
                                        <span id="Thursday"> (<?php echo $Thursday; ?>) </span>
                                    </a>
                                </li>
								
								  <li class="Friday">
                                    <a  href="<?php echo base_url(); ?>index.php/Merchandiser_beat_plan/checkstatus/Friday">
                                        <span class="ng-binding">Friday</span>
                                        <span id="Friday"> (<?php echo $Friday; ?>) </span>
                                    </a>
                                </li>
								
								  <li class="Saturday">
                                    <a  href="<?php echo base_url(); ?>index.php/Merchandiser_beat_plan/checkstatus/Saturday">
                                        <span class="ng-binding">Saturday</span>
                                        <span id="Saturday"> (<?php echo $Saturday; ?>) </span>
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
													<th width="65" style="text-align:center;">Sr. No.</th>
													<th>Date</th>
													<th>store_name</th>
													<th>Map</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
                                                if(count($data)>0)
                                                {
                                                     for ($i=0; $i < count($data); $i++) { ?>
                                                        <tr>
                                                            <td style="text-align:center;"><?php echo $i+1; ?></td>
                                                            <td>
                                                                <span style="display:none;">
                                                                    <?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('Ymd',strtotime($data[$i]->date_of_processing)):''); ?>
                                                                </span>
                                                                <a href="<?php echo base_url().'index.php/merchandiser_location/edit/'.$data[$i]->date_of_processing; ?>"><?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?></a>
                                                            </td>
                                                            <td><?php echo $data[$i]->distributor_name; ?></td>
                                                            <td>Direction</td>
                                                            <td>Check In</td>
                                                        </tr>  
                                                }
                                             
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

                if(url.includes('Tuesday')){
                    $('.Tuesday').attr('class','active');
                }
                else if(url.includes('Wednesday')){
                    $('.Wednesday').attr('class','active');
                }
                else  if(url.includes('Thursday')){
                    $('.Thursday').attr('class','active');
                } 
				else  if(url.includes('Friday')){
                    $('.Friday').attr('class','active');
                } 
				else  if(url.includes('Saturday')){
                    $('.Saturday').attr('class','active');
                } 
                else {
                    $('.Monday').attr('class','active');
                }
            });
        </script>
		
    <!-- END SCRIPTS -->      
    </body>
</html>