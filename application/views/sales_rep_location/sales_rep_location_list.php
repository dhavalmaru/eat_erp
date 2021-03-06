<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Eat-ERP</title>
	<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1  maximum-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="HandheldFriendly" content="True">
	
	<link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.png">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/font-awesome.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/fakeLoader.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/slick.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/slick-theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.transitions.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/style.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/font/material-design-icons/Material-Design-Icons.woff" rel="stylesheet">

<body>								
	<!-- START PAGE CONTAINER -->
	
		<div class="navbar">
		 <?php $this->load->view('templates/header2');?>
		</div>

		<?php $this->load->view('templates/menu2');?>
	
	
	
	<div class="wishlist app-section app-pages">
		<div class="container">
			
			<div class="entry shadow">
			<div class="app-title">
				<h4>Visit List</h4>
			</div>
			
				<?php for ($i=0; $i < count($data); $i++) { 
				$date = date('Y-m-d');
				if($data[$i]->date_of_visit == $date)
					{ ?>
				<div class="wishlist-title s-title">
					<div class="row">
						
						<div class="col s5">
							<h5><?php echo $data[$i]->distributor_name; ?></h5>
						</div>
						<div class="col s2">
							<h6>Date:</h6>
						</div>
						<div class="col s5">
							<h6><?php echo (($data[$i]->date_of_visit!=null && $data[$i]->date_of_visit!='')?date('d/m/Y',strtotime($data[$i]->date_of_visit)):''); ?></h6>
						</div>
					</div>
					
			
					
				
				
					
					
					<div class="row">
						<div class="col s5">
						<a class="button shadow orange  lighten-1" href="<?php echo base_url().'index.php/sales_rep_location/edit/'.$data[$i]->id; ?>">View</a>
						</div>
						
						<div class="col s2">
							
						</div>
						<div class="col s5">
							
						</div>
					</div>
					
				</div><?php } }?>
				
			
				
			</div>
		</div>
	</div>

			<!-- PAGE CONTENT WRAPPER -->
		
				
		<div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
		  <a class="btn-floating  pink waves-effect waves-light" href="<?php echo base_url() . 'index.php/sales_rep_location/add'; ?>">
			<i class="large material-icons">add</i>
		  </a>

		</div>				
		<!-- END PAGE CONTENT -->
	</div>
	<!-- END PAGE CONTAINER -->

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/fakeLoader.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/loading.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/slick.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/owl.carousel.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/custom.js"></script>
	
	<!-- END SCRIPTS -->      
</body>
</html>