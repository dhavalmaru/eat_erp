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
		   @media only screen and  (min-width:495px)  and (max-width:524px) { 
			.heading-h3-heading:first-child {     width: 46%!important;}
		   	.heading-h3-heading:last-child {     width: 54%!important;}
			.heading-h3-heading .btn-margin{ }
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
                   <div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; City Details List  </div>						 
					  <div class="heading-h3-heading">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                    	<div class="pull-right btn-margin">
						<div class="c">
											<?php  //if(isset($access)) { if($access[0]->r_insert == 1) {  ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>index.php/city_master/city_edit">
												<span class="fa fa-plus"></span> Add City 
											</a>
											<?php // }}  ?>
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
											<th width="65" style="text-align:center;" >Sr. No.</th>
											<th width="65" style="text-align:center;" >Edit</th>
											<th >City </th>
											<th> State</th>
											
										</tr>
									</thead>
									<tbody>
										<?php 
										if(isset($city_details)){
										 for($i=0; $i < count($city_details); $i++) { ?>
										<tr id="trow_<?php echo $i;?>">
											<td style="text-align:center;"><?php if(isset($city_details)){ echo ($i+1) ;} else {echo '1';} ?></td>
											<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/city_master/city_view/'.$city_details[$i]->city_id; ?>"><i class="fa fa-edit"></i></a></td>
											
											<td>
													<?php echo $city_details[$i]->city_name; ?>
													
											</td>
											<td><?php echo $city_details[$i]->state_name;?></td>
												
												
										</tr>
										<?php } 
									}?>
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