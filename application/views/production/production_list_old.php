<!DOCTYPE html>
<html lang="en">
    <head>
        <title>EAT ERP</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>
    </head>
    <body>
        <div class="page-container page-navigation-top">
		   	<?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
               	<div class="heading-h3">
                   	<div class="heading-h3-heading"> <a href="<?php echo base_url().'index.php/dashboard'; ?>"> Dashboard  </a> &nbsp; &#10095; &nbsp; Production List  </div>
					<div class="heading-h3-heading">
						<div class="pull-right btn-margin">	
							<?php $this->load->view('templates/download');?>	
						</div>	
						<div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
							<a class="btn btn-success  " href="<?php echo base_url() . 'index.php/production/add'; ?>">
								<span class="fa fa-plus"></span> Add Production
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
								<table id="customers2" class="table datatable table-bordered">
									<thead>
										<tr>
											<th width="65" style="text-align:center;">Sr. No.</th>
											<th width="65" style="text-align:center;">Action</th>
											<th>Production Id</th>
											<th>From Date</th>
											<th>To Date</th>
											<th>Manufacturer Name</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td  style="text-align:center;"><?php echo $i+1; ?></td>
											<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/production/edit/'.$data[$i]->id; ?>"><i class="fa fa-edit"></i></a></td>
											<td><?php echo $data[$i]->p_id; ?></td>
											<td><?php echo (($data[$i]->from_date!=null && $data[$i]->from_date!='')?date('d/m/Y',strtotime($data[$i]->from_date)):''); ?></td>
											<td><?php echo (($data[$i]->to_date!=null && $data[$i]->to_date!='')?date('d/m/Y',strtotime($data[$i]->to_date)):''); ?></td>
											<td><?php echo $data[$i]->manufacturer_name; ?></td>
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
            </div>
        </div>
						
        <?php $this->load->view('templates/footer');?>

    </body>
</html>