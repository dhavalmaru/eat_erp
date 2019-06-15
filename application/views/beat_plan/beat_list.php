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
                   	<div class="heading-h3-heading mobile-head">
                   		<a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Beat List 
                   	</div>
				  	<div class="heading-h3-heading mobile-head">
					  	<div class="pull-right btn-margin">
							<?php $this->load->view('templates/download');?>
						</div>
                    	<div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
							<a class="btn btn-success  " href="<?php echo base_url() . 'index.php/beat_master/add'; ?>">
								<span class="fa fa-plus"></span> Add Beat
							</a>
						</div>
                    	<div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
	                   		<a class="btn btn-default-danger pull-right" style="margin-right:8px!important;" href="<?php echo base_url('index.php/Beat_master/download_csv');?>">
	                   			<i class="fa fa-file-pdf-o "></i> Download Sample
	                   		</a>
						</div>
                    	<div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
	                   		<a class="btn btn-success" data-toggle="modal" href="#myModal">
	                            <span class="fa fa-file-excel-o"></span> Upload Excel
	                        </a>
						</div>
				    </div>
                </div>

                <div class="modal fade" id="myModal" role="dialog" style="">
					<div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style="">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                               Upload Beat Details
                            </h4>
                        </div>
                        <form id="form_beat_plan_upload" method="POST" action="<?php echo base_url();?>index.php/Beat_master/upload_file" class="form-horizontal excelform" enctype="multipart/form-data">
                        <div class="modal-body">
					 	<div class="form-group">
							<label class="col-md-4 col-sm-4 col-xs-12 control-label">Add Excel <span class="asterisk_sign"></span></label>
							<input type="file" class="fileinput btn btn-info btn-small  bar_image" name="upload" id="image" placeholder="image" value=""/>
                     	</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <!-- <button id="btn_save" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
                            <input type="submit"  class="btn btn-success pull-right"  value="Save" />
                        </div>
                        </form>
                    </div>
	                </div>
	            </div>

	            <div class="container">
					<?php if($this->session->flashdata('error')){?>
					<div class="alert alert-danger alert-dismissible fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $this->session->flashdata('error');?></div>  
					<?php } else if($this->session->flashdata('success')){?>
					<div class="alert alert-success alert-dismissible fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $this->session->flashdata('success');?></div>  
					<?php } ?>
				</div>
              	
                <!-- PAGE CONTENT WRAPPER -->
             	<div class="page-content-wrap">
                    <div class="row">
					  	<div class="page-width">	
                        <div class="col-md-12">
						<div class="panel panel-default">
						 	<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered">
									<thead>
										<tr>
											<th width="65" style="text-align:center;">Sr. No.</th>
											<th width="65" style="text-align:center;">Edit</th>
											<th>Beat Id</th>
											<th>Beat Name</th>
											<th>Distributor Type</th>
											<th>Zone</th>
											<th>Location</th>
											<!--<th width="110">Creation Date</th>-->
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/beat_master/edit/'.$data[$i]->id; ?>"><i class="fa fa-edit"></i></a></td>
											<td><?php echo $data[$i]->beat_id; ?></td>
											<td><?php echo $data[$i]->beat_name; ?></td>
											<td><?php echo $data[$i]->distributor_type; ?></td>
											<td><?php echo $data[$i]->zone; ?></td>
											<td><?php echo $data[$i]->location; ?></td>
											<!--<td>
												<span style="display:none;">
                                                    <?php// echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('Ymd',strtotime($data[$i]->modified_on)):''); ?>
                                                </span>
												<?php //echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?>
											</td>-->
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
    </body>
</html>