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
	.fa-eye  { font-size:21px; color:#333;}
	.fa-file-pdf-o{ color:#e80b0b; font-size:21px;}
	.fa-paper-plane-o{ color:#520fbb; font-size:21px;}
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
				<div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Order List  </div>						 
				<div class="heading-h3-heading mobile-head">
					<div class="pull-right btn-margin">	
						<?php $this->load->view('templates/download');?>	
					</div>	
					<div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
						<a class="btn btn-success " href="<?php echo base_url() . 'index.php/sales_rep_order/add'; ?>">
							<span class="fa fa-plus"></span> Add Order Entry
						</a>
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
													<th>Date Of processing</th>
													<th>Distributor Name</th>
													<th>Area</th>
													<th width="125">Amount (In Rs)</th>
													<th>Contact Person</th>
													<th>Contact No</th>
													<th>Creation By</th>
													<th width="110">Creation Date</th>
												</tr>
											</thead>
											<tbody>
												<?php for ($i=0; $i < count($data); $i++) { ?>
												<tr>
													<td  style="text-align:center;"><?php echo $i+1; ?></td>
													<td>
		                                                <span style="display:none;">
		                                                    <?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('Ymd',strtotime($data[$i]->date_of_processing)):''); ?>
		                                                </span>
		                                                <a href="<?php echo base_url().'index.php/sales_rep_order/edit/'.$data[$i]->id; ?>"><?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?></a>
		                                            </td>
													<td><?php echo $data[$i]->distributor_name; ?></td>
													<td><?php echo $data[$i]->area; ?></td>
													<td><?php echo format_money($data[$i]->amount,2); ?></td>
													<td><?php echo $data[$i]->contact_person; ?></td>
													<td><?php echo $data[$i]->contact_no; ?></td>
													<td><?php echo $data[$i]->user_name; ?></td>
													<td>
														<span style="display:none;">
                                                            <?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('Ymd',strtotime($data[$i]->modified_on)):''); ?>
                                                        </span>
														<?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?></td>
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