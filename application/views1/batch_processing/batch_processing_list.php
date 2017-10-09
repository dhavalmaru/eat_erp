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
		  @media only screen and  (min-width:709px)  and (max-width:734px) { 
			.heading-h3-heading:first-child {     width: 44%!important;}
		   	.heading-h3-heading:last-child {     width: 56%!important;}		  
			.heading-h3-heading .btn-margin{ margin-bottom:5px; }
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
                   <div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Batch Processing List  </div>						 
					  <div class="heading-h3-heading  mobile-head">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                       	<div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success " href="<?php echo base_url() . 'index.php/batch_processing/add'; ?>">
										<span class="fa fa-plus"> </span> Add Batch Processing Entry
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
								<table id="customers2" class="table datatable table-bordered" >
									<thead>
										<tr>
									        <th width="65" style="text-align:center;" >Sr. No.</th>
											<th  width="145" >Batch Id As Per Fssai</th>
											<th width="135">Date Of processing</th>
											<th  width="175">Depot Name</th>
											<th width="175" >Product Name</th>
											<th width="80">Qty In Bar</th>
											<th width="150">Actual Wastage (In Kg)</th>
											<th width="100">Creation Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td  style="text-align:center;"><?php echo $i+1; ?></td>
											<td><a href="<?php echo base_url().'index.php/batch_processing/edit/'.$data[$i]->id; ?>"><?php echo $data[$i]->batch_id_as_per_fssai; ?></a></td>
											<td><?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?></td>
											<td><?php echo $data[$i]->depot_name; ?></td>
											<td><?php echo $data[$i]->product_name; ?></td>
											<td><?php echo format_money($data[$i]->qty_in_bar,2); ?></td>
											<td><?php echo format_money($data[$i]->actual_wastage,2); ?></td>
											<td><?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?></td>
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