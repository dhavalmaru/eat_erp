<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Portfolio Management</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.tile {padding: 0px;
				   min-height: 77px;}
		</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <?php $this->load->view('templates/menus');?>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
					
						<div class="col-md-1">&nbsp;</div>
						
                        <div class="col-md-10">
						<div class="panel panel-default">
							
							<div class="panel-heading">
								<h3 class="panel-title" style="text-align:center;float:initial;"><strong>Tax Details List</strong></h3>
							</div>

								<div class="panel-heading-bg">
							      <div class="btn-group pull-left">
										<div class="c">
											<?php  if(isset($access)) { if($access[0]->r_insert == 1) {  ?>
											<a class="btn btn-success" href="<?php echo base_url(); ?>index.php/Tax_master/tax_edit">
												<span class="fa fa-plus"></span> Add Tax Details
											</a>
											<?php  }}  ?>
										</div>
									</div>
									<?php $this->load->view('templates/download');?>
								</div>
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered" style="border-top: none;">
									<thead>
										<tr>
											<th width="58">Sr. No.</th>
											<th width="50">Tax Name</th>
											<th width="50">Tax Percentage (%)  </th>
											<th width="75">Actions</th> 
										</tr>
									</thead>
									<tbody>
										<?php $tranasction_type=array("Subtract From Amount","Add To Amount");
										 for($i=0; $i < count($tax_detail); $i++) { ?>
										<tr id="trow_<?php echo $i;?>">
											<td><?php if(isset($tax_detail)){ echo ($i+1) ;} else {echo '1';} ?></td>
											
												<td>
														<a href="<?php echo base_url().'index.php/Tax_master/tax_view/'.$tax_detail[$i]->tax_id; ?>"><?php echo $tax_detail[$i]->tax_name; ?></a>
													
												</td>
												<td><?php echo $tax_detail[$i]->tax_percent;?></td>
												<td><?php echo $tranasction_type[$tax_detail[$i]->tax_action];?></td>
											
											<!-- <td>
												<?php //if(isset($access)) { if($access[0]->r_edit == 1) { ?>
												<button class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span></button></a>
												<?php //} if($access[0]->r_delete == 1) { ?>
												<a href=""><button class="btn btn-danger btn-rounded btn-sm" onClick="delete_row('trow_1');"><span class="fa fa-times"></span></button></a>
												<?php //} } ?>
											</td> -->
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->
                            
						</div>
						</div>
						
						<div class="col-md-1"></div>
						
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