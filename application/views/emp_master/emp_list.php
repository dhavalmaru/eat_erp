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
                   <div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Employee List  </div>	 
					 
					  <div class="heading-h3-heading">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                    	<div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success btn-block btn-padding"  href="<?php echo base_url() . 'index.php/emp_master/add'; ?>">
											<span class="fa fa-plus"></span> Add Employee
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
										   <th width="60" style="text-align:center;" >Sr. No.</th>
											<th width=" ">First Name</th>
											<th width=" ">Last Name</th>
											<th width="130px ">Marital Status</th>
											<th width="140px; ">Pan No</th>
											<th width="90px; ">Address 1</th>
											<th width="90px; ">City</th>
											<th width=" 195px;">Location</th>
											<!-- <th width="50">Rate Of Box</th> -->
											<th width="110px; ">Creation Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<td><a href="<?php echo base_url().'index.php/emp_master/edit/'.$data[$i]->id; ?>"><?php echo $data[$i]->first_name; ?></a></td>
											<td><?php echo $data[$i]->last_name; ?></td>
											<td><?php echo $data[$i]->marital_status; ?></td>
											<td><?php echo $data[$i]->pan_no; ?></td>
											<td><?php echo $data[$i]->permanant_address1; ?></td>
											<td><?php echo $data[$i]->city; ?></td>
											<td><?php echo $data[$i]->location; ?></td>
											<!-- <td><?php //echo $data[$i]->rate_of_box; ?></td> -->
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