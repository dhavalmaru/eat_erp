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
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
		<!-- <link rel="stylesheet" type="text/css" id="theme" href="<?php //echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/> -->
		<!-- <link rel="stylesheet" type="text/css" id="theme" href="<?php //echo base_url().'css/custome_vj_css.css'; ?>"/>     -->
        <!-- EOF CSS INCLUDE -->
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
      	<div class="page-container page-navigation-top">                    
            <!-- PAGE CONTENT -->
		   	<?php $this->load->view('templates/menus');?>
           	<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
				<div class="heading-h3">
					<div class="heading-h3-heading">
						<a href="<?php echo base_url().'index.php/dashboard'; ?>" > Dashboard </a> &nbsp; &#10095; &nbsp; 
						Sales Rep Attendance List
					</div>
					<div class="heading-h3-heading">
						<div class="pull-right btn-margin">	
							<?php $this->load->view('templates/download');?>	
						</div>	
						<div class="pull-right btn-margin">
							<a class="btn btn-success btn-block btn-padding" href="<?php echo base_url().'index.php/Sales_Attendence/get_sales_attendance/modified'; ?>" target="_blank">
								<span class="fa fa-plus"></span> Send Updated Attendance
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
								<form id="form_sales_rep_attendance_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url().'index.php/sales_rep_attendance/save'; ?>">
								<div class="form-group">
									<h2 class="col-md-4 col-sm-4 col-xs-12 control-label">Attendance Details</h2>
								</div>
								<div class="form-group" >
									<div class="col-md-3 col-sm-3 col-xs-12">
										<label class="col-md-4 col-sm-4 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
										<div class="col-md-8 col-sm-8 col-xs-12">
											<input type="text" class="form-control datepicker1" name="check_in_date" id="check_in_date" placeholder="Date" value="<?php if(isset($data1)) echo (($data1[0]->check_in_time!=null && $data1[0]->check_in_time!='')?date('d/m/Y',strtotime($data1[0]->check_in_time)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
										</div>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label class="col-md-4 col-sm-4 col-xs-12 control-label">Sales Representative <span class="asterisk_sign">*</span></label>
										<div class="col-md-8 col-sm-8 col-xs-12">
											<div>
												<select name="sales_rep_id" id="sales_rep_id" class="form-control select2" data-error="#err_sales_rep_id">
													<option value="">Select</option>
													<?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
															<option value="<?php echo $sales_rep[$k]->id; ?>" <?php if(isset($data1)) { if($sales_rep[$k]->id==$data1[0]->sales_rep_id) { echo 'selected'; } } ?>><?php echo $sales_rep[$k]->sales_rep_name; ?></option>
													<?php }} ?>
												</select>
											</div>
											<br/>
											<div id="err_sales_rep_id"></div>
										</div>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<div class="col-md-3 col-sm-3 col-xs-12">
											<input type="checkbox" class="form-control" name="chk_absent" id="chk_absent" value="1" <?php if(isset($data1)) echo (($data1[0]->working_status=='Absent')?'Checked':''); ?> />
										</div>
										<label class="col-md-7 col-sm-7 col-xs-12 control-label">Absent <span class="asterisk_sign">*</span></label>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-12" id="div_check_in_time">
										<label class="col-md-4 col-sm-4 col-xs-12 control-label">Check In Time <span class="asterisk_sign">*</span></label>
										<div class="col-md-8 col-sm-8 col-xs-12">
											<input type="time" class="form-control" name="check_in_time" id="check_in_time" value="<?php if(isset($data1)) echo (($data1[0]->check_in_time!=null && $data1[0]->check_in_time!='')?date('H:i',strtotime($data1[0]->check_in_time)):date('H:i')); else echo date('H:i'); ?>">
										</div>
									</div>
                                </div>
								<div class="form-group" >
									<div class="col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
										<input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Save" />
									</div>
                                </div>
                                </form>

								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered" >
									<thead>
										<tr>
										   <th width="60" style="text-align:center;" >Sr. No.</th>
											<th width="65 " style="text-align:center;">Edit</th>
											<th width=" ">Date</th>
											<th width=" ">Sales Rep Name</th>
											<th width=" ">Status</th>
											<th width="60px; ">In Time</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/sales_rep_attendance/edit/'.$data[$i]->id; ?>"><i class="fa fa-edit"></i></a></td>
											<td>
												<span style="display:none;">
                                                    <?php echo (($data[$i]->check_in_time!=null && $data[$i]->check_in_time!='')?date('Ymd',strtotime($data[$i]->check_in_time)):''); ?>
                                                </span>
												<?php echo (($data[$i]->check_in_time!=null && $data[$i]->check_in_time!='')?date('d/m/Y',strtotime($data[$i]->check_in_time)):''); ?>
											</td>
											<td><?php echo $data[$i]->sales_rep_name; ?></td>
											<td><?php echo $data[$i]->working_status; ?></td>
											<td><span style="display:none;">
                                                    <?php echo (($data[$i]->check_in_time!=null && $data[$i]->check_in_time!='')?date('Hi',strtotime($data[$i]->check_in_time)):''); ?>
                                                </span>
												<?php echo (($data[$i]->check_in_time!=null && $data[$i]->check_in_time!='')?date('H:i',strtotime($data[$i]->check_in_time)):''); ?>
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

        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        	$(document).ready(function(){
        		$(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });

        		// set_absent();
        	});

        	// var set_absent = function() {
        	// 	if($('#chk_absent').is(':checked')){
        	// 		$('#div_check_in_time').hide();
        	// 	} else {
        	// 		$('#div_check_in_time').show();
        	// 	}
        	// }
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
		
    	<!-- END SCRIPTS -->      
    </body>
</html>