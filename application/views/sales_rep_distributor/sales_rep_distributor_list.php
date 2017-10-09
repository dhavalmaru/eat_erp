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
				<div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Distributor List  </div>						 
				<div class="heading-h3-heading mobile-head">
					<div class="pull-right btn-margin">	
						<?php $this->load->view('templates/download');?>	
					</div>	
					<div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
						<a class="btn btn-success  " href="<?php echo base_url() . 'index.php/sales_rep_distributor/add'; ?>">
							<span class="fa fa-plus"></span> Add Distributor
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
													<th>Address</th>
													<th>City</th>
													<th>Area</th>
													<th>Vat No</th>
													<th>Contact Person</th>
													<th>Contact No</th>
													<th>Status</th>
													<th width="65">Margin</th>
													<th width="110">Created By</th>
													<th width="110">Creation Date</th>
												</tr>
											</thead>
											<tbody>
												<?php for ($i=0; $i < count($data); $i++) { ?>
												<tr>
													<td style="text-align:center;"><?php echo $i+1; ?></td>
													<td><a href="<?php echo base_url().'index.php/sales_rep_distributor/edit/'.$data[$i]->id; ?>"><?php echo $data[$i]->distributor_name; ?></a></td>
													<td><?php echo $data[$i]->address; ?></td>
													<td><?php echo $data[$i]->city; ?></td>
													<td><?php echo $data[$i]->area; ?></td>
													<td><?php echo $data[$i]->vat_no; ?></td>
													<td><?php echo $data[$i]->contact_person; ?></td>
													<td><?php echo $data[$i]->contact_no; ?></td>
													<td><?php echo $data[$i]->status; ?></td>
													<td><?php echo $data[$i]->margin; ?></td>
													<td><?php echo $data[$i]->user_name; ?></td>
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