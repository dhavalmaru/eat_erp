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
		.submitLink 
		{
			  background-color: transparent;
			  text-decoration: none;
			  border: none;
			  color: #428bca;
			  cursor: pointer;
			  font-size:16px!important;
		}
	</style>

<body>								
	<!-- START PAGE CONTAINER -->
	   <div id="loading"></div>
		<div class="navbar">
		 <?php $this->load->view('templates/header2');?>
		</div>

		<?php $this->load->view('templates/menu2');?>
	
	
	<div class="contact app-pages app-section" style="margin:0 auto">
		<div class="container">
			
            <div id="basic-form" class="section">
              <div class="row">
                <div class="col s12">
             <div class="card-panel">
              
                <div class="row">
                    <form id="form_purchase_order_details" role="form" >

                            <div class="app-title">
							<h5><a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sales_rep_route_plan'; ?>" >Route Plan</a>  </h5>
							</div><hr>
                              
									
									
									<div class="row">
									<div class="input-field col s6">
									<input type="date" class=" datepicker" name="from_date" id="from_date" value="<?php echo date('d/m/Y')?>"style="background: url(<?php echo base_url(); ?>img/calendar-hover.png) 99% 50% no-repeat!important;"/>
									
									<label for="dob">From Date</label>
									</div>
									<div class="input-field col s6">
									<input type="date" class=" datepicker" name="to_date" id="to_date" value="<?php echo date('d/m/Y')?>"style="background: url(<?php echo base_url(); ?>img/calendar-hover.png) 99% 50% no-repeat!important;"/>
									<label for="dob">To Date</label>
									</div>
									</div>
                      
                                     <div class="row">
                                      	<div class="input-field col s12">
                                             
                                            <div class="col-md-2 col-sm-2   col-xs-offset-4 col-md-offset-5 col-sm-offset-5  Route ">
                                                <input type="hidden" class="form-control" name="sales_rep_id" id="sales_rep_id" value="<?php if(isset($sales_rep_id)) echo $sales_rep_id;?>"/>
                                                <a class="submitLink" id="get_route_plan">
                                                    Get Route Plan
                                                </a>
                                            </div>
                                            
                                        </div>
                                    </div>


                                    <div class="table-responsive">
                                        <table class="table datatable table-bordered"  >
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center; width:100px;">Sr. No.</th>
                                                    <th>Date</th>
                                                    <th>Area</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Distance</th>
                                                    <th>Duration</th>
                                                    <th>Destination Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="route_details">
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                      	<div class="input-field col s12">
                                            <div id="map_wrapper">
                                                <div id="map_canvas" class="mapping" style="width:100%; height:375px"></div>
                                                <!-- <div id="directionsPanel" style="float:right;width:30%;height 100%"></div> -->
                                            </div>
                                        </div>
                                    </div>

                               
								
									<div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/sales_rep_route_plan" class="submitLink" type="reset" id="reset">Cancel</a>
									</div>
								
                           
                          
							
                  </form>
                </div>
              </div>
          
                </div>
                </div>
                </div>
                </div>
    </div>

			<!-- PAGE CONTENT WRAPPER -->
				
		<!-- END PAGE CONTENT -->
	</div>
	<!-- END PAGE CONTAINER -->
     <?php $this->load->view('templates/footer2');?>
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw&sensor=false">
    </script>
	<script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/route.js"></script>
	<script> 
			   
		$('.datepicker').pickadate({
		selectMonths: true, // Creates a dropdown to control month
		selectYears: 15 // Creates a dropdown of 15 years to control year
		});   
	</script>
	<!-- END SCRIPTS -->      
</body>
</html>