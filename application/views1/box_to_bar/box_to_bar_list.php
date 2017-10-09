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
				  @media only screen and  (min-width:495px)  and (max-width:540px) { 
				.heading-h3-heading:first-child {     width: 45%!important;}
		   	.heading-h3-heading:last-child {     width: 55%!important;}		
			.heading-h3-heading .btn-margin{ margin-bottom:5px!important; }
		   }
		   
		     @media only screen and  (min-width:541px)  and (max-width:718px) { 
				.heading-h3-heading:first-child {     width: 40%!important;}
		   	.heading-h3-heading:last-child {     width: 60%!important;}		
			.heading-h3-heading .btn-margin{ margin-bottom:0px!important; }
		   }
		  @media only screen and  (min-width:709px)  and (max-width:718px) { 			 
			.heading-h3-heading .btn-margin{   }
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
                   <div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Box To Bar  List  </div>						 
					  <div class="heading-h3-heading">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                       	<div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success " href="<?php echo base_url() . 'index.php/box_to_bar/add'; ?>">
										<span class="fa fa-plus"></span> Add Box To Bar Entry
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
											<th width="65" style="text-align:center;" >Sr. No.</th>
											<th width="140">Date Of processing</th>
											<th> Depot Name</th>
											<th width="110">Qty</th>
											<th width="110">Grams</th>
											<th width="120">Amount (In Rs) </th>
											<th width="110">Creation Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<td><a href="<?php echo base_url().'index.php/box_to_bar/edit/'.$data[$i]->id; ?>"><?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?></a></td>
											<td><?php echo $data[$i]->depot_name; ?></td>
											<td><?php echo format_money($data[$i]->qty,2); ?></td>
											<td><?php echo format_money($data[$i]->grams,2); ?></td>
											<td><?php echo format_money($data[$i]->amount,2); ?></td>
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