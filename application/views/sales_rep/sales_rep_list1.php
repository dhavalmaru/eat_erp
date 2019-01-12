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
                   	<div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Sales Representative List  </div>						 
					  	<div class="heading-h3-heading mobile-head">
					  	<div class="pull-right btn-margin">	
							<?php $this->load->view('templates/download');?>	
						</div>
			     	</div>	      
                	</div>

                	<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
	                    	<div class="pull-left btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
								<a class="btn btn-success" href="<?php echo base_url() . 'index.php/sales_rep/add'; ?>">
									<span class="fa fa-plus"></span> Add Sales Representative
								</a>
							</div>
							<div class="pull-left   btn-margin" style="<?php if($access[0]->r_view=='0') echo 'display: none;';?>">
								<a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/sales_rep/sales_rep_route_plan">
									<span class="fa fa-plus"></span> Sales Representative Route Plan
								</a>
							</div>
							<div class="pull-left   btn-margin" style="<?php if($access[0]->r_view=='0') echo 'display: none;';?>">
								<a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/sales_rep/sales_rep_location">
									<span class="fa fa-plus"></span> Sales Representative Location
								</a>
							</div>
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
											<th width="65" style="text-align:center;">Sr. No.</th>
											<th width="300" >Sales Representative Name</th>
											<th width="120">PAN No</th>
											<th width="300"  >Email Id</th>
											<th width="110">Mobile No</th>
											<th width="190">Target Per Month (In Rs)</th>
											<th width="110">Creation Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<td><a href="<?php echo base_url().'index.php/sales_rep/edit/'.$data[$i]->id; ?>"><?php echo $data[$i]->sales_rep_name; ?></a></td>
											<td><?php echo $data[$i]->pan_no; ?></td>
											<td><?php echo $data[$i]->email_id; ?></td>
											<td><?php echo $data[$i]->mobile; ?></td>
											<td><?php echo format_money($data[$i]->target_pm,2); ?></td>
											<td><?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?></td>
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
		
    <!-- END SCRIPTS -->      
    </body>
</html>