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
		   @media only screen and  (min-width:645px)  and (max-width:718px) { 
				.heading-h3-heading:first-child {     width: 44%!important;}
				.heading-h3-heading:last-child {     width: 56%!important;}		
				.heading-h3-heading .btn-margin{ margin-bottom:0px!important; }
		   }
		  @media only screen and  (min-width:709px)  and (max-width:718px) { 			 
			.heading-h3-heading .btn-margin{   }
		   }
             .alert
             {
              padding:5px;
              border-radius:0px;
             }
             .alert-dismissable .close, .alert-dismissible .close
             {
                  position: relative;
             top: -2px;
             right: 0px;
             color: #fff;
             opacity: 1!important;
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
                   <div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Edit Beat Plan  </div>						 
						<div class="heading-h3-heading mobile-head">
					    	
					   
						</div>
				</div>
                
                 
                      <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">  
				   <div class="row" >
				   	 <div class="page-width">	
				   	 	<div class="col-md-3" sty>
                           <div class="input-field col s3">
							<label>Merchandiser Name<span class="asterisk_sign">*</span></label>
							</div> 
							<div class="input-field col s9">
						
                                <select name="sales_rep" class="form-control" id="sales_rep">
                                <?php 
                                	if(isset($sales_rep))
                                	{

                                		foreach ($sales_rep as $sales_rep_name) {
                                			if(isset($sales_rep_id) && $sales_rep_name->id==$sales_rep_id) 
                                				$selected = "selected='selected'";
                                			else
                                				$selected = '';

                                			echo "<option value='$sales_rep_name->id' $selected>$sales_rep_name->sales_rep_name</option>";
                                		}
                                	}
                                	
                                ?>	
                                </select>
							</div> 
                        </div>			
				   	 </div>
						
					</div>
                    <div class="row">
					
					  <div class="page-width">	
                        <div class="col-md-12">
							
					      <div class="panel panel-default">	
						   <div class="heading-h3-heading mobile-head">	<?php  $explode = explode(" ",$frequency);  echo $explode[1]?> </div>		
							<div class="pull-right btn-margin">
									<a class="btn btn-success " href="javascript:void(0)" id="copy">
										<span class="fa fa-plus"></span> Copy
									</a>
						
							</div><br><br>	
					<form id="form_sales_rep_location_details" role="form" class="" method="post" enctype="multipart/form-data" action="<?php echo base_url().'index.php/Merchandiser_beat_plan/save_changesequence'; ?>">					  
							<div class="panel-body">
							 
							 	<input type="hidden"  name="ispermenant" id="ispermenant" value=""/>
							 	<input type="hidden"  name="frequency" id="frequency" value="<?=$frequency?>"/>
							 	<input type="hidden"  name="sales_rep_id" id="sales_rep_id" value="<?=$sales_rep_id?>"/>
							 	<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered"  >
									<thead>
										<tr>
										
											
											<th width="150">Original Beat Plan</th>
											<th width="150"> Sales Representative Beat Plan</th>
											
										</tr>
									</thead>
									<tbody>
										<tr >
											<td>
												<table style="width: 100%;" id="admin_route_plan">
													<?php
														foreach ($admin_beat_plan as $data)
														{
															echo '<tr><td>'.$data['store_name'].'</td></tr>';
														}
													?>
												</table>
													
											</td>
											<td>
												<table  style="width: 100%;" id="merchendizer_route_plan">
													<?php
														foreach ($beat_plan as $data)
														{
															echo '<tr><td>'.$data['store_name'].'</td></tr>';
														}
													?>
												</table>
													
											</td>
										</tr>

									</tbody>
								</table>
								</div>
							</div>
							
							
							<br><br>	
							
							<div class="panel-footer">
								
                                <input type="Submit" class="btn btn-success pull-right" value="Save">
                            </div>
                    </form>
						
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
		<script type="text/javascript">
			var Base_url = '<?=base_url();?>';
			$(document).ready(function()
			{
				$('#copy').on('click',function(){					
					var r = confirm("Do you want ot change the sequence permenant??");
					if (r == true) {
						var  mer = $('#merchendizer_route_plan').html();
						$('#admin_route_plan').html('');
						$('#admin_route_plan').html(mer);
						 var ispermenant = "Yes";
						$('#ispermenant').val(ispermenant);
					} else {
						
					}
				});

				$('#sales_rep').on('change',function(){	
					location.href=Base_url+'index.php/Merchandiser_beat_plan/change_admin_sequence/'+$(this).val();
			    });
			 });
		</script>
    
    <!-- END SCRIPTS -->      
    </body>
</html>