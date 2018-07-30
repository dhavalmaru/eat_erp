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
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->      
		
		<!-- <style>
 
            input[readonly] {background-color: white !important; 
                            color: #0b385f !important; 
                            cursor: not-allowed !important;}
		</style>
		<style>
        #map_wrapper {
            
        }
        #map_canvas {
            width: 100%;
            height: 100%;
        }
        </style> --> 
        <style>     

            input[type=radio], input[type=checkbox] { margin: 8px 0px 0px;      vertical-align: text-bottom;}
            th{text-align:center;}
            .center{text-align:center;}
            input[readonly] {background-color: white !important; 
                            color: #0b385f !important; 
                            cursor: not-allowed !important;}



             @media screen and (max-width:800px) {   
   .h-scroll { overflow-x:scroll;} .h-scroll .table-stripped{ width:806px!important;}
   .Route { margin: 10px auto 0!important; text-align: center; }
   }
   
   		.form-group
			{
				border-bottom:none!important;
				background-color:white;
			}
			.panel {
		   box-shadow: none;
		   border:none!important; 
		   border-top: none!important; 
		  
		}.submitLink {
		  background-color: transparent;
		  text-decoration: none;
		  border: none;
		  color: #428bca;
		  cursor: pointer;
		}
		.panel-footer
		{
			background-color:#fff!important;
		}
		.heading-h2
		{
			display:none!important;
		}
        </style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Route Plan </div>
                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                    
							
                            <form id="form_purchase_order_details" role="form" class="form-horizontal">
                            <div class="box-shadow-inside" style="margin-top: 120px;">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default">
					     	    <div class="panel-body">
                                    <div class="form-group" >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">From <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="from_date" id="from_date" value="<?php echo date('d/m/Y')?>"style="background: url(<?php echo base_url(); ?>img/calendar-hover.png) 99% 50% no-repeat!important;"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">To <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="to_date" id="to_date" value="<?php echo date('d/m/Y')?>"style="background: url(<?php echo base_url(); ?>img/calendar-hover.png) 99% 50% no-repeat!important;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                             
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

                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div id="map_wrapper">
                                                <div id="map_canvas" class="mapping" style="width:100%; height:375px"></div>
                                                <!-- <div id="directionsPanel" style="float:right;width:30%;height 100%"></div> -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
								
									<div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/sales_rep_route_plan" class="submitLink" type="reset" id="reset">Cancel</a>
									</div>
								
                                </div>
								<br clear="all"/>
				            </div>
                            </div>
                          
							</form>
				
						</div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>

        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw&sensor=false">
        </script>

        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/route.js"></script>

        <!-- END SCRIPTS -->      
    </body>
</html>