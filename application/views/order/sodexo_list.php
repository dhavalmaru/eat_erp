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
				<div class="heading-h3-heading"><a href="<?php echo base_url().'index.php/dashboard'; ?>"> Dashboard </a> &nbsp; &#10095; &nbsp; Sodexo Transactions </div>
				<div class="heading-h3-heading">
					<div class="pull-right btn-margin">	
						<?php $this->load->view('templates/download'); ?>	
					</div>	
					<!-- <div class="pull-right btn-margin" style="<?php //if($access[0]->r_insert=='0') echo 'display: none;';?>">
						<a class="btn btn-success  " href="<?php //echo base_url() . 'index.php/Sodexo/add'; ?>">
							<span class="fa fa-plus"></span> Add Sodexo
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
								<table id="customers2" class="table datatable table-bordered"  >
									<thead>
										<tr>
											<th width="65" style="text-align:center;">Sr. No.</th>
											<th width="65" style="text-align:center;">Order Id</th>
											<th>Email Id</th>
											<th>Amount</th>
											<th>Transaction State</th>
											<th>Failure Reason</th>
											<th>Error Message</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td  style="text-align:center;"><?php echo $i+1; ?></td>
											<td><?php echo $data[$i]->request_id; ?></td>
											<td><?php echo $data[$i]->email_id; ?></td>
											<td style="text-align:right;"><?php echo $data[$i]->amount; ?></td>
											<td><?php echo $data[$i]->transaction_state; ?></td>
											<td><?php echo $data[$i]->failure_reason; ?></td>
											<td><?php echo $data[$i]->error_message; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
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