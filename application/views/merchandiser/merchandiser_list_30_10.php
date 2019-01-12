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

<style>
.tabs .tab a:hover, .tabs .tab a.active
{
	  color: #ffffff!important;
}
.tabs a 
{
	  color: #ffffff!important;
}
.tabs .indicator
{
	background-color:#ffffff!important; 

}
.tabs
{
	height:auto!important;
	background-color: #1861b1;
}
.beat_plan h4
{
	font-size:12px!important;	
    display: inline;	
}
.app-pages {
    margin-top: 100px;
}
.tabs .tab {
    padding: 0px!important;
}
.wishlist .entry .s-title
{
	padding-top:0px;
	padding-bottom:0px;
}
.row
{
	margin-bottom: 7px;
	margin-top: 7px;
}
.button
{
	font-size:10px;
}
</style>
<body>								
	<!-- START PAGE CONTAINER -->
	
		<div class="navbar">
		 <?php $this->load->view('templates/header2');?>
		 <ul class="tabs">
					  		<?php $explode =  explode(" ",$checkstatus);
									$checkstatus  = $explode[1];
					  		
					  		 ?>
							<li class="tab"><a class="<?php if($checkstatus=='Monday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/merchandiser_location/checkstatus/Monday" target="_self">Mon</a></li>

							<li class="tab"><a class="<?php if($checkstatus=='Tuesday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/merchandiser_location/checkstatus/Tuesday" target="_self">Tue</a></li>
							
							<li class="tab"><a class="<?php if($checkstatus=='Wednesday') echo 'active'; ?>"href="<?php echo base_url(); ?>index.php/merchandiser_location/checkstatus/Wednesday" target="_self">Wed</a></li>
							
							<li class="tab"><a class="<?php if($checkstatus=='Thursday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/merchandiser_location/checkstatus/Thursday" target="_self">Thu</a></li>
							
							<li class="tab"><a class="<?php if($checkstatus=='Friday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/merchandiser_location/checkstatus/Friday" target="_self">Fri</a></li>
							
							<li class="tab"><a class="<?php if($checkstatus=='Saturday') echo 'active'; ?>"  href="<?php echo base_url(); ?>index.php/merchandiser_location/checkstatus/Saturday" target="_self">Sat</a></li>
						  </ul>
		</div>

		<?php $this->load->view('templates/menu2');?>
	

        
	
	<div class="wishlist app-section app-pages">
		<div class="container">
			
			<div class="entry shadow">
			<div class="app-title">
				<h4>Visit List</h4>
			</div>
			<?php $counter=0;?>
		
						
						  
								
							<?php 	
							
						
							for ($i=0; $i <count($data); $i++)
							 {
									 
								?>
							
								<div class="col s12">
										<div class="wishlist-title s-title beat_plan">
											<div class="row">
												<div class="col s1">
													<h4><?php echo $data[$i]->sequence;?></h4>
												</div>
											
												<div class="col s2">
													<a href="<?php echo base_url().'index.php/merchandiser_location/locations/'.$data[$i]->id; ?> "class=""><i class="fa fa-map-marker"></i></a>
												</div>
												<div class="col s5">
													<h5><?php echo $data[$i]->store_name.' - ( '.$data[$i]->location.' )'; ?></h5>
												</div>
												
												<div class="col s4">
												
												<?php 
												$dist= $data[$i]->dist_id;
												$date= $data[$i]->date_of_visit;
												
												if($dist==null && $date==null){?>
												<a href="<?php echo base_url().'index.php/merchandiser_location/add/'.$data[$i]->bit_plan_id;?>"class="button shadow orange  lighten-1">Check In</a>
												
												<?php
											
												}
												
													else
												{
													
												?>
													
												<a href="<?php echo base_url().'index.php/merchandiser_location/edit/'.$data[$i]->bit_plan_id;?>"class="button shadow orange  lighten-1">Edit</a>
												<?php
												
												}?>
												</div>
											</div>
											
									
											
										</div>
								
									</div>
							<?php 
							}?>
							
						
			</div>
		</div>
	</div>

			<!-- PAGE CONTENT WRAPPER -->
		
				

				
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
	
	<script>
		$('ul.tab').tabs({
			swipeable: true,
			responsiveThreshold: Infinity,
			});
	</script>
	
	<!-- END SCRIPTS -->      
</body>
</html>