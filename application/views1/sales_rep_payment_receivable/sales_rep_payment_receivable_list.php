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
</head>
<body>								
	<!-- START PAGE CONTAINER -->
	<div class="page-container page-navigation-top">            
		<!-- PAGE CONTENT -->
		<?php $this->load->view('templates/menus');?>
		<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
			<div class="heading-h3"> 
				<div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Receivable Payment List  </div>						 
				<div class="heading-h3-heading mobile-head">
					<div class="pull-right btn-margin">	
						<?php $this->load->view('templates/download');?>	
					</div>	
					<div class="pull-right btn-margin"  style="<?php echo 'display: none;';?>">
						<a class="btn btn-success  " href="<?php echo base_url() . 'index.php/sales_rep_payment_receivable/add'; ?>">
							<span class="fa fa-plus"></span> Add Route Plan
						</a>
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
													<th>Distributor Name</th>
													<th>30-45 Days</th>
													<th>46-60 Days</th>
													<th>61-90 Days</th>
													<th>Above 90 Days</th>
													<th>tot_receivable</th>
												</tr>
											</thead>
											<tbody>
												<?php for ($i=0; $i < count($data); $i++) { ?>
												<tr>
													<td style="text-align:center;"><?php echo $i+1; ?></td>
													<td><?php echo $data[$i]->distributor_name; ?></td>
													<td><?php echo $data[$i]->days_30_45; ?></td>
													<td><?php echo $data[$i]->days_46_60; ?></td>
													<td><?php echo $data[$i]->days_61_90; ?></td>
													<td><?php echo $data[$i]->days_91_above; ?></td>
													<td><?php echo $data[$i]->tot_receivable; ?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
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