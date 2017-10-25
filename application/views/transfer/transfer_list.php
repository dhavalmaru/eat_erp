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
								<h3 class="panel-title" style="text-align:center;    float: none;"><strong>Transfer Entry List</strong></h3>
							</div>
								
							<!-- <div class="row">
								<div class="col-md-3">                        
									<a href="#" class="tile tile-success tile-valign">
										<span id="approved"><?php //echo count($approved); ?></span>
										<div class="informer informer-default">Approved</div>
										<div class="informer informer-default dir-br"><span class="fa fa-users"></span></div>
									</a>                            
								</div>
								<div class="col-md-3">                        
									<a href="#" class="tile tile-info tile-valign">
										<span id="approved"><?php //echo count($pending); ?></span>
										<div class="informer informer-default">Pending</div>
										<div class="informer informer-default dir-br"><span class="fa fa-users"></span></div>
									</a>                            
								</div>
								<div class="col-md-3">                        
									<a href="#" class="tile tile-danger tile-valign">
										<span id="approved"><?php //echo count($rejected); ?></span>
										<div class="informer informer-default">Rejected</div>
										<div class="informer informer-default dir-br"><span class="fa fa-users"></span></div>
									</a>                            
								</div>
								<div class="col-md-3">                        
									<a href="#" class="tile tile-default tile-valign">
										<span id="approved"><?php //echo count($inprocess); ?></span>
										<div class="informer informer-default">In Process</div>
										<div class="informer informer-default dir-br"><span class="fa fa-users"></span></div>
									</a>                            
								</div>
							</div> -->
								
							<div class="panel-heading-bg">
								<div class="btn-group pull-left" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success btn-block" href="<?php echo base_url() . 'index.php/transfer/add'; ?>">
										<span class="fa fa-plus"></span> Add Transfer Entry
									</a>
								</div>
								<?php $this->load->view('templates/download');?>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered" style="border-top:none;">
									<thead>
										<tr>
											<th width="58">Sr. No.</th>
											<th width="50">Date Of Transfer</th>
											<th width="50">Depot Out</th>
											<th width="50">Item</th>
											<th width="50">Raw Material Name</th>
											<th width="50">Product Name</th>
											<th width="50">Qty</th>
											<th width="50">Product Type</th>
											<th width="50">Depot In</th>
											<th width="75">Creation Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td><?php echo $i+1; ?></td>
											<td>
                                                <span style="display:none;">
                                                    <?php echo (($data[$i]->date_of_transfer!=null && $data[$i]->date_of_transfer!='')?date('Ymd',strtotime($data[$i]->date_of_transfer)):''); ?>
                                                </span>
                                                <a href="<?php echo base_url().'index.php/transfer/edit/'.$data[$i]->id; ?>"><?php echo (($data[$i]->date_of_transfer!=null && $data[$i]->date_of_transfer!='')?date('d/m/Y',strtotime($data[$i]->date_of_transfer)):''); ?></a>
                                            </td>
											<td><?php echo $data[$i]->depot_out_name; ?></td>
											<td><?php echo $data[$i]->item; ?></td>
											<td><?php echo $data[$i]->rm_name; ?></td>
											<td><?php echo $data[$i]->product_name; ?></td>
											<td><?php echo format_money($data[$i]->qty,2); ?></td>
											<td><?php echo $data[$i]->product_type; ?></td>
											<td><?php echo $data[$i]->depot_in_name; ?></td>
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