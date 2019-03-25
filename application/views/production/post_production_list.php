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
                   <div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Production List  </div>						 
					  	<div class="heading-h3-heading mobile-head">
					  	<div class="pull-right btn-margin">	
							<?php $this->load->view('templates/download');?>	
						</div>	
        				<!-- <div class="pull-right btn-margin"  style="<?php //if($access[0]->r_insert=='0') echo 'display: none;';?>">
							<a class="btn btn-success  " href="<?php //echo base_url() . 'index.php/batch_master/add'; ?>">
								<span class="fa fa-plus"></span> Add Batch No
							</a>
						</div> -->
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
											<th width="65" style="text-align:center;">Edit</th>
											<th>Production Id</th>
                                            <th>Manufacturer Name</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Production Status</th>
                                            <th>Production Report</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/production/post_details/'.$data[$i]->id; ?>"><i class="fa fa-edit"></i></a></td>
											<td><?php echo $data[$i]->p_id; ?></td>
											<td><?php echo $data[$i]->manufacturer_name; ?></td>
											<td>
                                                <span style="display:none;">
                                                    <?php echo (($data[$i]->confirm_from_date!=null && $data[$i]->confirm_from_date!='')?date('Ymd',strtotime($data[$i]->confirm_from_date)):''); ?>
                                                </span>
                                                <?php echo (($data[$i]->confirm_from_date!=null && $data[$i]->confirm_from_date!='')?date('d/m/Y',strtotime($data[$i]->confirm_from_date)):''); ?>
                                            </td>
											<td>
                                                <span style="display:none;">
                                                    <?php echo (($data[$i]->confirm_to_date!=null && $data[$i]->confirm_to_date!='')?date('Ymd',strtotime($data[$i]->confirm_to_date)):''); ?>
                                                </span>
                                                <?php echo (($data[$i]->confirm_to_date!=null && $data[$i]->confirm_to_date!='')?date('d/m/Y',strtotime($data[$i]->confirm_to_date)):''); ?>
                                            </td>
                                            <td>
                                        	<?php 
                                                if($data[$i]->batch_master==null || $data[$i]->batch_master=='0') 
                                                    echo 'Confirm Batch Nos.';
                                                else if($data[$i]->production_details==null || $data[$i]->production_details=='0') 
                                                    echo 'Confirm Production Details.';
                                                else if($data[$i]->bar_conversion==null || $data[$i]->bar_conversion=='0') 
                                                    echo 'Perform Bar Conversion.';
                                                else if($data[$i]->depot_transfer==null || $data[$i]->depot_transfer=='0') 
                                                    echo 'Perform Depot Transfer.';
                                                else if($data[$i]->documents_upload==null || $data[$i]->documents_upload=='0') 
                                                    echo 'Perform Documents Upload.';
                                                else if($data[$i]->raw_material_recon==null || $data[$i]->raw_material_recon=='0') 
                                                    echo 'Perform Raw Material Recon.';
                                                else if($data[$i]->report_approved==null || $data[$i]->report_approved=='0') 
                                                    echo 'Approve Report.';
                                                else if($data[$i]->report_approved=='1') 
                                                    echo 'Approved.';
                                                else echo $data[$i]->p_status;
                                            ?>
                                            </td>
                                            <td>
                                            	<a href="<?php echo base_url().'index.php/production/view_production_report/'.$data[$i]->id; ?>" target="_blank"><span class="fa fa-file-pdf-o" style=""></span></a>
                                            </td>
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