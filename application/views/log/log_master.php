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
                   <div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;   Log Master </div>						 
					  <div class="heading-h3-heading">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                   
				     </div>	      
                </div>
                <!-- PAGE CONTENT WRAPPER -->
                     <div class="page-content-wrap">                
                    <div class="row">
					   <div class="page-width">	
                        <div class="col-md-12">
					       <div class="panel panel-default">
                         <form id="form_log" method="post" action="#">
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered"  >
									<thead>
										<tr>
										    <th width="65" style="text-align:center;" >Sr. No.</th>
											<th >Section</th>
											<th  >Action</th>
											<th >Reference</th>
											<th  >Created By</th>
											<th width="110">Action Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i=0;$i<count($log); $i++) {?>
										<tr id="trow_1">
											<td  style="text-align:center;"><?php echo ($i + 1); ?></td>
											<td><?php echo $log[$i]->module_name; ?></td>
											<td><?php echo $log[$i]->action; ?></td>
											<td><?php echo $log[$i]->ref_name; ?></td>
											<td><?php echo $log[$i]->email_id; ?></td>
											<td>
                                                <span style="display:none;">
                                                    <?php echo (($log[$i]->date!=null && $log[$i]->date!='')?date('Ymd',strtotime($log[$i]->date)):''); ?>
                                                </span>
                                                <?php echo ($log[$i]->date!=null && $log[$i]->date!='')?date('d/m/Y H:i:s',strtotime($log[$i]->date)):''; ?>
                                            </td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->                  
						  </form>	 
                <!-- END PAGE CONTENT WRAPPER -->
                       </div>            
            <!-- END PAGE CONTENT -->
                         </div>     
						</div>     
                     </div>
					</div>     
	   <!-- END PAGE CONTAINER -->
				</div>     
			</div>     
        <?php $this->load->view('templates/footer');?>  
    
    </body>
</html>