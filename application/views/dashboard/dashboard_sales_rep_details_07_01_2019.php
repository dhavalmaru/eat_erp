
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
	.tabs
	{
		background-color: #1861b1!important;
		border-top:1px solid #fff;
	}

	.name  {
    font-size: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    line-height: 58px;
    color: #fff;
    margin-bottom: 15px;
    margin-top: 15px;
	align:center;
}
.color-n 
{
	color:#69f0ae green accent-2;
}
.carousel .carousel-item {
  width: 100%;
  height: 100%;
 
 overflow-y:scroll;
}
.carousel
{
	 height:1000px!important;
}
.row {
    margin-bottom: 7px;
    margin-top: 7px;
}
.wishlist .entry .s-title {
    border-top: 1px solid #ddd;
    padding-top: 0px;
}
#order_tabs .tab a:hover, #order_tabs .tab a.active
		{
			  color: #6FA7E4!important;
		}
		#order_tabs a 
		{
			  color: #6FA7E4!important;
		}
		#order_tabs .indicator
		{
			background-color:#6FA7E4!important; 
		}
		#order_tabs
		{
			background-color: transparent!important;
		}
		.tabs .tab a:hover, .tabs .tab a.active
{
	  color: #ffffff!important;
}
#location_tab a 
{
	  color: #ffffff!important;
}
#location_tab .indicator
{
	background-color:#ffffff!important; 

}
#location_tab .tab
{
	padding: 0px!important;
	
}
#location_tab .tab a
{

	padding: 0 10px!important;
}
#location_tab .tab a:hover, #location_tab .tab a.active
		{
			  color: #fff!important;
		}
.beat_plan h4
{
	font-size:12px!important;	
    display: inline;	
}
	</style>
</head>
<body class="home">								
        <!-- START PAGE CONTAINER -->
     <div id="loading"></div>
	<!-- end loading -->

	<!-- navbar -->
	<div class="navbar">
	
		 <?php $this->load->view('templates/header2');?>
	
		<ul id="tabs-swipe-demo" class="tabs">
		<li class="tab col s3"><a class="active" href="#swipe-1"><i class="material-icons">home</i></a></li>
		  <li class="tab col s3"><a href="#swipe-2"><i class="material-icons">place</i></a></li>
		  <li class="tab col s3"><a href="#swipe-3"><i class="material-icons">group</i></a></li>
		  <li class="tab col s3"><a href="#swipe-4"><i class="material-icons">shopping_cart</i></a></li>
		  	
		  
		</ul>
	</div>
	<!-- end navbar -->

	<!-- panel control left -->
	 <?php $this->load->view('templates/menu2');?>
	<!-- end panel control left -->

	
	<!-- slider
	<div class="the-slider">
		<div class="container">
			<div class="the-slider-entry">
				<div class="slider-slick">
					<div class="slider-entry">
						<img src="img/slider1.jpg" alt="">
						<div class="overlay"></div>
						<div class="caption">
							<div class="container">
								<h2><a href="">Xtra Modern Design</a></h2>
								<p>Find your need now and get Discount</p>
							</div>
						</div>
					</div>
					<div class="slider-entry">
						<div class="overlay"></div>
						<img src="img/slider2.jpg" alt="">
						<div class="caption">
							<div class="container">
								<h2>Mobile Design Template</h2>
								<p>Find your need now and get Discount</p>
							</div>
						</div>
					</div>
					<div class="slider-entry">
						<div class="overlay"></div>
						<img src="img/slider3.jpg" alt="">
						<div class="caption">
							<div class="container">
								<h2>Creative Xtra Design</h2>
								<p>Find your need now and get Discount</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end slider --

	<div class="features">
		<div class="container">
			<div class="row">
				<div class="col s4 f-left">
					<div class="entry e-left">
						<i class="fa fa-mobile"></i>
						<h5>Responsive</h5>
					</div>
				</div>
				<div class="col s4 f-center">
					<div class="entry e-center">
						<i class="fa fa-lightbulb-o"></i>
						<h5>Fresh Idea</h5>
					</div>
				</div>
				<div class="col s4 f-right">
					<div class="entry e-right">
						<i class="fa fa-user"></i>
						<h5>Support</h5>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- services 

	<div class="services">
		<div class="container">
			
			<div class="row">
				<div class="col s12">
					<div class="entry" style="text-align:center;">
					
						<div class="name green accent-2" style="text-align:center;margin:15px auto;">as</div>
						<h5>Android</h5>
						
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col s6">
					<div class="entry">
					<i class="fa fa-map-marker color-1"></i>
						<h5>Locations</h5>
						
					</div>
				</div>
				<div class="col s6">
					<div class="entry">
						<i class="fa fa-globe color-2"></i>
						<h5>Route Plan</h5>
						
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s6">
					<div class="entry">
						<i class="fa fa-group color-3"></i>
						<h5>Distributors</h5>
						
					</div>
				</div>
				<div class="col s6">
					<div class="entry">
						<i class="fa fa-shopping-cart color-4"></i>
						<h5>Orders</h5>
					
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- end services -->
                        <!-- START WIDGETS 

                                                           
                                    <div class="radio-style" style="display: none;">
                                
                                    <div class=" ">
                                            <input type="radio" name="period" id="weekly" value="weekly" /> &nbsp;&nbsp; Weekly &nbsp;&nbsp; 
                                            <input type="radio" name="period" id="monthly" value="monthly" /> &nbsp;&nbsp; Monthly &nbsp;&nbsp; 
                                            <input type="radio" name="period" id="all" value="all" /> &nbsp;&nbsp; All
                                    </div>
                                    
                                    </div>
                                   -->
                               
									
<main style="margin-top: 115px;">
<div id="swipe-1" class="col s12 ">

	<div class="services">
		<div class="container">
			
			<div class="row">
				<div class="col s12">
					<div class="entry" style="text-align:center;">
						
						<div class="name green accent-2" style="text-align:center;margin:15px auto;"><?php if(isset($userdata['login_name'])) {echo substr($userdata['login_name'], 0, 1);} if(isset($userdata['last_name'])) {echo substr($userdata['last_name'], 0, 1);} ?></div>
					
						<h5><?php if(isset($userdata['login_name'])) {echo $userdata['login_name'];}?></h5>
					</div>
				</div>
				
			</div>
			<div class="row" style="margin-top:30px">
				<div class="col s12">
					<div class="entry" style="text-align:center">
					<a href="<?php echo base_url() . 'index.php/Sales_rep_store_plan'; ?>"><i class="fa fa-map-marker color-1"></i>
						<h5>Add Visits</h5></a>
						
					</div>
				</div>
			</div>
				
			<div class="row">
				<div class="col s6">
					<div class="entry">
						<a href="<?php echo base_url() . 'index.php/sales_rep_distributor/add'; ?>"><i class="fa fa-group color-3"></i>
						<h5>Add  Retailers</h5></a>
						
					</div>
				</div>
				<div class="col s6">
					<div class="entry">
						<a href="<?php echo base_url() . 'index.php/sales_rep_order/add'; ?>"><i class="fa fa-shopping-cart color-4"></i>
						<h5>Add  Orders</h5></a>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="swipe-2" class="col s12">
	<div class="wishlist app-section">
		<div class="container">
			
			<div class="entry shadow">
			<div class="app-title">
				<h4>Visit List</h4>
					<a href="<?php echo base_url().'index.php/Sales_rep_store_plan';?>" class="right"  style="margin-top: -16px;">View All</a>
			</div>
				<ul	class="tabs" id="location_tab">
					  		<?php $explode =  explode(" ",$checkstatus);
									$checkstatus  = $explode[1];
					  		
					  		 ?>
							<li class="tab"><a class="<?php if($checkstatus=='Monday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Dashboard_sales_rep/checkstatus/Monday" target="_self">Mon</a></li>

							<li class="tab"><a class="<?php if($checkstatus=='Tuesday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Dashboard_sales_rep/checkstatus/Tuesday" target="_self">Tues</a></li>
							
							<li class="tab"><a class="<?php if($checkstatus=='Wednesday') echo 'active'; ?>"href="<?php echo base_url(); ?>index.php/Dashboard_sales_rep/checkstatus/Wednesday" target="_self">Wed</a></li>
							
							<li class="tab"><a class="<?php if($checkstatus=='Thursday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Dashboard_sales_rep/checkstatus/Thursday" target="_self">Thur</a></li>
							
							<li class="tab"><a class="<?php if($checkstatus=='Friday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Dashboard_sales_rep/checkstatus/Friday" target="_self">Fri</a></li>
							
							<li class="tab"><a class="<?php if($checkstatus=='Saturday') echo 'active'; ?>"  href="<?php echo base_url(); ?>index.php/Dashboard_sales_rep/checkstatus/Saturday" target="_self">Sat</a></li>
						  </ul>
		
				`<?php $counter=0;?>
		
						
						  
								
							<?php 	
							
							for ($i=0; $i <count($data3); $i++)
							 {
									 
								?>
							
					
										<div class="wishlist-title s-title beat_plan">
											<div class="row">
												<div class="col s1">
													<h4><?php echo $data3[$i]->sequence;?></h4>
												</div>
											
												<div class="col s2">
													<a href="<?php echo base_url().'index.php/Sales_rep_store_plan/locations/'.$data3[$i]->store_id; ?> "class=""><i class="fa fa-map-marker"></i></a>
												</div>
												<div class="col s5">
													<h5><?php echo $data3[$i]->distributor_name; ?></h5>
												</div>
												<div class="col s4">
												
												<?php 
												$date= $data3[$i]->date_of_visit;
												if($date==null){?>
												<a href="<?php echo base_url().'index.php/Sales_rep_store_plan/add/'.$data3[$i]->bit_plan_id;?>"class="button shadow orange  lighten-1">Check In</a>
												
												<?php
											
												}
												
													else
												{
													
												?>
												<?php 
												  if($data3[$i]->bit_plan_id!=0)
												  { ?>
												  	<a href="<?php echo base_url().'index.php/Sales_rep_store_plan/edit/'.$data3[$i]->bit_plan_id;?>"class="button shadow orange  lighten-1">Edit</a>
												  <?php }
												  else 
												  {?>
												  		<a href="<?php echo base_url().'index.php/sales_rep_location/edit/'.$data3[$i]->mid;?>"class="button shadow orange  lighten-1">Edit</a>
												 <?php }
												?>
												
												<?php
												
												}?>
												</div>
												
											</div>
											
									
											
										</div>
								
									
							<?php 
							}?>
				
			
				
			</div>
		</div>
	</div>

</div>
<div id="swipe-3" class="col s12 ">
	<div class="wishlist app-section">
		<div class="container">
			
			<div class="entry shadow">
			<div class="app-title">
				<h4> Retailer List</h4>
					<a href="<?php echo base_url().'index.php/sales_rep_distributor';?>" class="right"  style="margin-top: -16px;">View All</a>
			</div>
		
				<?php for ($i=0; $i < count($data1); $i++) {
				  $date1 = date('Y-m-d');
				  $modified_on1 = date('Y-m-d', strtotime($data1[$i]->modified_on));
				
					if($modified_on1== $date1)
					{ ?>					
				<div class="wishlist-title s-title">
					<div class="row">
						<div class="col s2">
							<td style="text-align:center;"><?php echo $i+1; ?></td>
						</div>
						<div class="col s5">
							<h5><?php echo $data1[$i]->distributor_name; ?></h5>
						</div>
					
						<div class="col s5" style="text-align: right;">
						<a href="<?php echo base_url() . 'index.php/sales_rep_distributor/edit/'.$data1[$i]->id; ?>" class="button shadow orange  lighten-1">View</a>
					
						</div>
					</div>
				
					
					
					
					
				</div><?php }} ?>
				
			
				
			</div>
		</div>
	</div>
</div>

<div id="swipe-4" class="col s12 ">
	<div class="wishlist app-section">
		<div class="container">
			
				<div class="entry shadow">
			<div class="app-title">
				<h4>Order List</h4>
			</div>
			
			
						
			<ul class="tabs tab" id="order_tabs">

				<li class="tab"><a class="active" href="#order_1">Todays Order</a></li>

				<li class="tab"><a href="#order_2">Pending </a></li>
			</ul>
				
							
								<div id="order_1" class="col s12">
									<?php 
									$date = date('Y-m-d');
							
									
									for ($i=0; $i <count($data2); $i++){
										  if($data2[$i]->date_of_processing == date('Y-m-d')){
									?>
										<div class="wishlist-title s-title">
											<div class="row">
												<div class="col s2">
													<td style="text-align:center;"><?php echo $i+1; ?></td>
												</div>
												<div class="col s5">
													<h5><?php echo $data2[$i]->distributor_name; ?></h5>
												</div>
												
												<div class="col s5" style="text-align: right;">
													<a href="<?php echo base_url().'index.php/sales_rep_order/edit/'.$data2[$i]->id; ?> "class="button shadow orange  lighten-1">View</a>
												</div>
											</div>
										</div>
									<?php 
									}
									}
									?>
								
								</div>
							
								<div id="order_2" class="col s12">
									<?php 
									$sr_no = 1;
									for ($i=0; $i <count($data2); $i++){
									if(strtoupper(trim($data2[$i]->delivery_status))!='DELIVERED'){
									?>
										<div class="wishlist-title s-title">
											<div class="row">
												<div class="col s2">
													<td style="text-align:center;"><?php echo $sr_no++; ?></td>
												</div>
												<div class="col s5" >
													<h5><?php echo $data2[$i]->distributor_name; ?></h5>
												</div>
												
												<div class="col s5" style="text-align: right;">
												<a href="<?php echo base_url().'index.php/sales_rep_order/edit/'.$data2[$i]->id; ?> "class="button shadow orange  lighten-1">View</a>
												</div>
											</div>
										</div>
									<?php 
									}
									}
									?>
								
								</div>
							
					
  
		
				
		
				
			
				
			</div>
		</div>
	</div>
</div>

    
	
	</main>		
 

    <!-- moris js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/fakeLoader.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/loading.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/slick.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/owl.carousel.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/custom.js"></script>
	<script>


		$('#tabs-swipe-demo').tabs({
		swipeable: true,
		responsiveThreshold: Infinity,
		});

		// $('.owl-carousel').owlCarousel({
			// items:1,
			// margin:10, 
			// full_width: true,
			
		// });
	</script>