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
        <!-- EOF CSS INCLUDE -->       
		<style>
			.report-expand { display:none ; border:1px dotted #ddd; margin-top:-10px; background:#fff; border-top:1px solid #fff; }
			.list-group-item-reports {
			    position: relative; text-decoration:none; color:#555;
			    display: block; font-size:12px; font-weight:600;
			    padding: 8px 15px; border-top:1px solid #eee;
			    margin-bottom: -1px;
			    background-color: #fff;
			}
			.list-group-item-reports { font-size:13px;}
			.list-group-item-reports:hover { text-decoration:none; /* background-color: #2f3c48; color:#fff;*/}
			.btn-clr { background:#fff; color:#000; margin-top:-10px; }
			.push { margin-top:3px; margin-left:5px;}
			.selectAllLabel { font-size: larger; font-weight: bold; margin-bottom:-10px; }
		 	#checkboxes, #log { min-width: 250px;  vertical-align: middle; padding: 10px;  }
			#selectall-1, #selectall-2, #selectall-3, #selectall-4, #selectall-5, #selectall-6 { margin-top:4px; margin-left:6px;}
			.selectAllLabel {     font-size: larger;    font-weight: bold;    margin-bottom: 0px;}
			td:first-child{text-align:left;}
			td{text-align:center;}
			@media screen and (max-width: 500px) {
			.h-scroll { padding-bottom:10px;  overflow-x: hidden; } }
			.panel  span { margin-bottom:0;}
			.list-group { border-bottom:1px solid #ddd!important; margin-bottom:20px;}
			@media screen and (max-width:767px) {  .selectAllLabel { margin-top:20px;} .list-group { border-bottom:1px solid #ddd!important; margin-bottom:20px;}}
		</style>
		
    </head>
    <body>								
     	<!-- START PAGE CONTAINER -->
     	<div class="page-container page-navigation-top">            
     		<!-- PAGE CONTENT -->
     		<?php $this->load->view('templates/menus');?>
     		<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
     			<div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/user_roles'; ?>" > User Role  List </a>  &nbsp; &#10095; &nbsp; User Role Details</div>

     			<!-- PAGE CONTENT WRAPPER -->
     			<div class="page-content-wrap">
     				<div class="row main-wrapper">
     					<div class="main-container">           
     						<div class="box-shadow">

     							<form id="form_user_role_details" role="form" class="form-horizontal" method="post" action="<?php if(isset($data)) { if($id==0) echo base_url().'index.php/user_roles/save'; else echo base_url().'index.php/user_roles/update/'.$id;} else {echo base_url().'index.php/user_roles/save';} ?>">
     								<div class="box-shadow-inside">
     									<div class="col-md-12 custom-padding" style="padding:0;" >
     										<div class="panel panel-default">
     											<div class="panel-body">
     												<div class="form-group">
     													<div class="col-md-12 col-sm-12 col-xs-12">
     														<label class="col-md-2 col-sm-2 col-xs-12 control-label">Role <span class="asterisk_sign">*</span></label>
     														<div class="col-md-4 col-sm-4 col-xs-12">
     															<input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) { if($id==0) echo ''; else echo $id; } ?>"/>
     															<input type="text" class="form-control" name="role_name" id="role_name" value="<?php if(isset($data)) { if($id==0) echo ($data[0]->role_name).' 1'; else echo $data[0]->role_name; } ?>" placeholder="Role"/>
     														</div>
     														<div  style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
     															<label class="col-md-2 col-sm-2 col-xs-12 control-label"> Status<span class="asterisk_sign">*</span></label>
     															<div class="col-md-4 col-sm-4 col-xs-12">
     																<select class="form-control" name="status">
     																	<option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Active</option>
     																	<option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
     																</select>
     															</div>
     														</div>
     													</div>
     												</div>

     												<div class="form-group">
     													<div class="col-md-12 col-sm-12 col-xs-12">
     														<label class="col-md-2 col-sm-2 col-xs-12 control-label">Role Description </label>
     														<div class="col-md-4 col-sm-4 col-xs-12 ">
     															<input type="text" class="form-control" name="description" placeholder="Description" value="<?php if(isset($data)) { echo $data[0]->description; } ?>"/>
     														</div>
     													</div>
     												</div>

     												<div class="panel-body">
     													<div class="h-scroll">	
     														<div class="table-responsive">
     															<table id="role_details_table" class="table table-bordered">
     																<thead>
     																	<tr>
     																		<th width="50">Module</th>
     																		<th width="50"><input type="checkbox" id="view" onchange="selectall(1);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View</th>
     																		<th width="50"><input type="checkbox" id="insert" onchange="selectall(2);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Insert</th>
     																		<th width="50"><input type="checkbox" id="update" onchange="selectall(3);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update</th>
     																		<th width="50"><input type="checkbox" id="delete" onchange="selectall(4);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete</th>
     																		<th width="50"><input type="checkbox" id="approval" onchange="selectall(5);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approval</th>
     																		<th width="50"><input type="checkbox" id="export" onchange="selectall(6);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Download</th>
     																	</tr>
     																</thead>
     																<tbody>
                                                                                          <tr id="trow_28">
                                                                                               <td>Dashboard</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="0" <?php if(isset($editoptions[27])) { if($editoptions[27]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"></td>
                                                                                               <td class="center"></td>
                                                                                               <td class="center"></td>
                                                                                               <td class="center"></td>
                                                                                               <td class="center"></td>
                                                                                          </tr>
																						  
																						    <tr id="">
                                                                                               <td colspan="7" style="font-weight:bold;font-size:18px">Master</td>
                                                                                              
                                                                                            
                                                                                          </tr>
																						    <tr id="">
                                                                                        
                                                                                                <td colspan="7" style="font-weight:500;font-size:15px">Product</td>
                                                                                          	</tr>
                                                                                          
     																	<tr id="trow_1">
     																		<td>Vendors</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_2">
     																		<td>Depot</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_3">
     																		<td>Raw Material</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_4" style="display:none;">
     																		<td>Tax</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_5">
     																		<td>Product</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="4" <?php if(isset($editoptions[4])) { if($editoptions[4]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="4" <?php if(isset($editoptions[4])) { if($editoptions[4]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="4" <?php if(isset($editoptions[4])) { if($editoptions[4]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="4" <?php if(isset($editoptions[4])) { if($editoptions[4]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="4" <?php if(isset($editoptions[4])) { if($editoptions[4]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="4" <?php if(isset($editoptions[4])) { if($editoptions[4]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_6">
     																		<td>Box</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="5" <?php if(isset($editoptions[5])) { if($editoptions[5]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="5" <?php if(isset($editoptions[5])) { if($editoptions[5]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="5" <?php if(isset($editoptions[5])) { if($editoptions[5]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="5" <?php if(isset($editoptions[5])) { if($editoptions[5]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="5" <?php if(isset($editoptions[5])) { if($editoptions[5]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="5" <?php if(isset($editoptions[5])) { if($editoptions[5]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
																		
																				
																				<tr id="trow_36">
     																		<td>Ingredients  Master</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="35" <?php if(isset($editoptions[35])) { if($editoptions[35]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="35" <?php if(isset($editoptions[35])) { if($editoptions[35]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="35" <?php if(isset($editoptions[35])) { if($editoptions[35]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="35" <?php if(isset($editoptions[35])) { if($editoptions[35]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="35" <?php if(isset($editoptions[35])) { if($editoptions[35]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="35" <?php if(isset($editoptions[35])) { if($editoptions[35]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
																		
																		
     																
																		
																		<tr id="">
                                                                                        
                                                                        <td colspan="7" style="font-weight:500;font-size:15px">Sales</td>  </tr>
     																	<tr id="trow_7">
     																		<td>Sales Representative</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_8">
     																		<td>Distributor</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="7" <?php if(isset($editoptions[7])) { if($editoptions[7]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="7" <?php if(isset($editoptions[7])) { if($editoptions[7]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="7" <?php if(isset($editoptions[7])) { if($editoptions[7]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="7" <?php if(isset($editoptions[7])) { if($editoptions[7]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="7" <?php if(isset($editoptions[7])) { if($editoptions[7]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="7" <?php if(isset($editoptions[7])) { if($editoptions[7]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
																		
																		   <tr id="trow_31">
                                                                                               <td>Distributor Type</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="30" <?php if(isset($editoptions[30])) { if($editoptions[30]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="30" <?php if(isset($editoptions[30])) { if($editoptions[30]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="30" <?php if(isset($editoptions[30])) { if($editoptions[30]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="30" <?php if(isset($editoptions[30])) { if($editoptions[30]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="30" <?php if(isset($editoptions[30])) { if($editoptions[30]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="30" <?php if(isset($editoptions[30])) { if($editoptions[30]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
																						  
																						      <tr id="trow_32">
                                                                                               <td>Zone</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="31" <?php if(isset($editoptions[31])) { if($editoptions[31]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="31" <?php if(isset($editoptions[31])) { if($editoptions[31]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="31" <?php if(isset($editoptions[31])) { if($editoptions[31]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="31" <?php if(isset($editoptions[31])) { if($editoptions[31]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="31" <?php if(isset($editoptions[31])) { if($editoptions[31]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="31" <?php if(isset($editoptions[31])) { if($editoptions[31]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
     															
                                                                                          <tr id="trow_30">
                                                                                               <td>Area</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="29" <?php if(isset($editoptions[29])) { if($editoptions[29]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="29" <?php if(isset($editoptions[29])) { if($editoptions[29]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="29" <?php if(isset($editoptions[29])) { if($editoptions[29]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="29" <?php if(isset($editoptions[29])) { if($editoptions[29]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="29" <?php if(isset($editoptions[29])) { if($editoptions[29]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="29" <?php if(isset($editoptions[29])) { if($editoptions[29]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
																						  
																						   <tr id="trow_37">
                                                                                               <td>Location</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="36" <?php if(isset($editoptions[36])) { if($editoptions[36]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="36" <?php if(isset($editoptions[36])) { if($editoptions[36]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="36" <?php if(isset($editoptions[36])) { if($editoptions[36]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="36" <?php if(isset($editoptions[36])) { if($editoptions[36]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="36" <?php if(isset($editoptions[36])) { if($editoptions[36]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="36" <?php if(isset($editoptions[36])) { if($editoptions[36]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
																						  
																						  
																						    <tr id="trow_38">
                                                                                               <td>Sr Mapping </td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="37" <?php if(isset($editoptions[37])) { if($editoptions[37]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="37" <?php if(isset($editoptions[37])) { if($editoptions[37]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="37" <?php if(isset($editoptions[37])) { if($editoptions[37]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="37" <?php if(isset($editoptions[37])) { if($editoptions[37]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="37" <?php if(isset($editoptions[37])) { if($editoptions[37]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="37" <?php if(isset($editoptions[37])) { if($editoptions[37]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
																						  
																						  
																						    <tr id="trow_39">
                                                                                               <td>Relationship Master</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="38" <?php if(isset($editoptions[38])) { if($editoptions[38]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="38" <?php if(isset($editoptions[38])) { if($editoptions[38]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="38" <?php if(isset($editoptions[38])) { if($editoptions[38]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="38" <?php if(isset($editoptions[38])) { if($editoptions[38]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="38" <?php if(isset($editoptions[38])) { if($editoptions[38]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="38" <?php if(isset($editoptions[38])) { if($editoptions[38]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
																						  
																						      <tr id="trow_40">
                                                                                               <td>Store Master</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="39" <?php if(isset($editoptions[39])) { if($editoptions[39]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="39" <?php if(isset($editoptions[39])) { if($editoptions[39]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="39" <?php if(isset($editoptions[39])) { if($editoptions[39]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="39" <?php if(isset($editoptions[39])) { if($editoptions[39]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="39" <?php if(isset($editoptions[39])) { if($editoptions[39]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="39" <?php if(isset($editoptions[39])) { if($editoptions[39]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
                                                                                       
                                                                                       
                                                                            
                                                                                        
																						  
																		<tr id="">
                                                                                        
																			<td colspan="7" style="font-weight:500;font-size:15px">Global</td>	
																			<tr id="trow_9">
     																		<td>City Master</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="8" <?php if(isset($editoptions[8])) { if($editoptions[8]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="8" <?php if(isset($editoptions[8])) { if($editoptions[8]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="8" <?php if(isset($editoptions[8])) { if($editoptions[8]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="8" <?php if(isset($editoptions[8])) { if($editoptions[8]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="8" <?php if(isset($editoptions[8])) { if($editoptions[8]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="8" <?php if(isset($editoptions[8])) { if($editoptions[8]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
                                                                                          <tr id="trow_29">
                                                                                               <td>Bank Master</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="28" <?php if(isset($editoptions[28])) { if($editoptions[28]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="28" <?php if(isset($editoptions[28])) { if($editoptions[28]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="28" <?php if(isset($editoptions[28])) { if($editoptions[28]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="28" <?php if(isset($editoptions[28])) { if($editoptions[28]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="28" <?php if(isset($editoptions[28])) { if($editoptions[28]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="28" <?php if(isset($editoptions[28])) { if($editoptions[28]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
																		</tr>																		<tr id="">
                                                                                        
																			<td colspan="7" style="font-weight:500;font-size:15px">Accounting</td>	
																			
																			      <tr id="trow_41">
                                                                                               <td>Vendor Type</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="40" <?php if(isset($editoptions[40])) { if($editoptions[40]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="40" <?php if(isset($editoptions[40])) { if($editoptions[40]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="40" <?php if(isset($editoptions[40])) { if($editoptions[40]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="40" <?php if(isset($editoptions[40])) { if($editoptions[40]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="40" <?php if(isset($editoptions[40])) { if($editoptions[40]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="40" <?php if(isset($editoptions[40])) { if($editoptions[40]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
																			
																			</tr>
																			
																			<tr id="">
                                                                                        
																			<td colspan="7"   style="font-weight:bold;font-size:18px">Transaction</td>	
																			</tr>
																			<tr id="">
                                                                                        
																			<td colspan="7" style="font-weight:500;font-size:15px">Production</td>	
																			
																			
																			<tr id="trow_42">
     																		<td>Batch Master</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="41" <?php if(isset($editoptions[41])) { if($editoptions[41]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="41" <?php if(isset($editoptions[41])) { if($editoptions[41]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="41" <?php if(isset($editoptions[41])) { if($editoptions[41]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="41" <?php if(isset($editoptions[41])) { if($editoptions[41]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="41" <?php if(isset($editoptions[41])) { if($editoptions[41]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="41" <?php if(isset($editoptions[41])) { if($editoptions[41]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
																			
     																	<tr id="trow_10">
     																		<td>Purchase Order</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="9" <?php if(isset($editoptions[9])) { if($editoptions[9]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="9" <?php if(isset($editoptions[9])) { if($editoptions[9]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="9" <?php if(isset($editoptions[9])) { if($editoptions[9]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="9" <?php if(isset($editoptions[9])) { if($editoptions[9]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="9" <?php if(isset($editoptions[9])) { if($editoptions[9]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="9" <?php if(isset($editoptions[9])) { if($editoptions[9]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_11">
     																		<td>Raw Material In</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="10" <?php if(isset($editoptions[10])) { if($editoptions[10]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="10" <?php if(isset($editoptions[10])) { if($editoptions[10]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="10" <?php if(isset($editoptions[10])) { if($editoptions[10]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="10" <?php if(isset($editoptions[10])) { if($editoptions[10]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="10" <?php if(isset($editoptions[10])) { if($editoptions[10]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="10" <?php if(isset($editoptions[10])) { if($editoptions[10]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_12">
     																		<td>Batch Processing</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="11" <?php if(isset($editoptions[11])) { if($editoptions[11]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="11" <?php if(isset($editoptions[11])) { if($editoptions[11]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="11" <?php if(isset($editoptions[11])) { if($editoptions[11]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="11" <?php if(isset($editoptions[11])) { if($editoptions[11]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="11" <?php if(isset($editoptions[11])) { if($editoptions[11]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="11" <?php if(isset($editoptions[11])) { if($editoptions[11]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
																		
																		
																		</tr>
																		<tr id="">
																		<td colspan="7" style="font-weight:500;font-size:15px">Sales</td>	
																	
																	
     																	<tr id="trow_13">
     																		<td>Sales</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="12" <?php if(isset($editoptions[12])) { if($editoptions[12]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="12" <?php if(isset($editoptions[12])) { if($editoptions[12]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="12" <?php if(isset($editoptions[12])) { if($editoptions[12]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="12" <?php if(isset($editoptions[12])) { if($editoptions[12]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="12" <?php if(isset($editoptions[12])) { if($editoptions[12]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="12" <?php if(isset($editoptions[12])) { if($editoptions[12]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_14">
     																		<td>Sales Return</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="13" <?php if(isset($editoptions[13])) { if($editoptions[13]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="13" <?php if(isset($editoptions[13])) { if($editoptions[13]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="13" <?php if(isset($editoptions[13])) { if($editoptions[13]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="13" <?php if(isset($editoptions[13])) { if($editoptions[13]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="13" <?php if(isset($editoptions[13])) { if($editoptions[13]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="13" <?php if(isset($editoptions[13])) { if($editoptions[13]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
																		
																			<tr id="trow_19">
     																		<td>Super Stockist Sale</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="18" <?php if(isset($editoptions[18])) { if($editoptions[18]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="18" <?php if(isset($editoptions[18])) { if($editoptions[18]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="18" <?php if(isset($editoptions[18])) { if($editoptions[18]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="18" <?php if(isset($editoptions[18])) { if($editoptions[18]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="18" <?php if(isset($editoptions[18])) { if($editoptions[18]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="18" <?php if(isset($editoptions[18])) { if($editoptions[18]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
																		
																		
																			<tr id="trow_43">
     																		<td>Super Stockist Sale Return</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="42" <?php if(isset($editoptions[42])) { if($editoptions[42]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="42" <?php if(isset($editoptions[42])) { if($editoptions[42]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="42" <?php if(isset($editoptions[42])) { if($editoptions[42]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="42" <?php if(isset($editoptions[42])) { if($editoptions[42]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="42" <?php if(isset($editoptions[42])) { if($editoptions[42]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="42" <?php if(isset($editoptions[42])) { if($editoptions[42]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
																		
     																	</tr>
																		
																		<tr id="">
																		<td colspan="7" style="font-weight:500;font-size:15px">Bank</td>	
																		
																		
																		
                                                                                          <tr id="trow_33">
                                                                                               <td>Payment Details</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="32" <?php if(isset($editoptions[32])) { if($editoptions[32]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="32" <?php if(isset($editoptions[32])) { if($editoptions[32]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="32" <?php if(isset($editoptions[32])) { if($editoptions[32]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="32" <?php if(isset($editoptions[32])) { if($editoptions[32]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="32" <?php if(isset($editoptions[32])) { if($editoptions[32]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="32" <?php if(isset($editoptions[32])) { if($editoptions[32]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
                                                                                          <tr id="trow_34">
                                                                                               <td>Credit Debit Note</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="33" <?php if(isset($editoptions[33])) { if($editoptions[33]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="33" <?php if(isset($editoptions[33])) { if($editoptions[33]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="33" <?php if(isset($editoptions[33])) { if($editoptions[33]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="33" <?php if(isset($editoptions[33])) { if($editoptions[33]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="33" <?php if(isset($editoptions[33])) { if($editoptions[33]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="33" <?php if(isset($editoptions[33])) { if($editoptions[33]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
                                                                                          </tr>
																						  
																		<tr id="">
																		<td colspan="7" style="font-weight:500;font-size:15px">Transfer</td>	</tr>		  
																						  
     																	<tr id="trow_15">
     																		<td>Depot Transfer</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="14" <?php if(isset($editoptions[14])) { if($editoptions[14]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="14" <?php if(isset($editoptions[14])) { if($editoptions[14]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="14" <?php if(isset($editoptions[14])) { if($editoptions[14]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="14" <?php if(isset($editoptions[14])) { if($editoptions[14]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="14" <?php if(isset($editoptions[14])) { if($editoptions[14]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="14" <?php if(isset($editoptions[14])) { if($editoptions[14]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_16">
     																		<td>Distributor Transfer</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="15" <?php if(isset($editoptions[15])) { if($editoptions[15]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="15" <?php if(isset($editoptions[15])) { if($editoptions[15]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="15" <?php if(isset($editoptions[15])) { if($editoptions[15]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="15" <?php if(isset($editoptions[15])) { if($editoptions[15]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="15" <?php if(isset($editoptions[15])) { if($editoptions[15]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="15" <?php if(isset($editoptions[15])) { if($editoptions[15]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_17">
     																		<td>Bar To Box Transfer</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="16" <?php if(isset($editoptions[16])) { if($editoptions[16]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="16" <?php if(isset($editoptions[16])) { if($editoptions[16]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="16" <?php if(isset($editoptions[16])) { if($editoptions[16]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="16" <?php if(isset($editoptions[16])) { if($editoptions[16]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="16" <?php if(isset($editoptions[16])) { if($editoptions[16]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="16" <?php if(isset($editoptions[16])) { if($editoptions[16]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_18">
     																		<td>Box To Bar Transfer</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="17" <?php if(isset($editoptions[17])) { if($editoptions[17]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="17" <?php if(isset($editoptions[17])) { if($editoptions[17]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="17" <?php if(isset($editoptions[17])) { if($editoptions[17]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="17" <?php if(isset($editoptions[17])) { if($editoptions[17]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="17" <?php if(isset($editoptions[17])) { if($editoptions[17]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="17" <?php if(isset($editoptions[17])) { if($editoptions[17]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	
     																	<tr id="">
																		<td colspan="7"  style="font-weight:bold;font-size:18px">Users</td></tr>
     																	<tr id="trow_20">
     																		<td>User</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="19" <?php if(isset($editoptions[19])) { if($editoptions[19]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="19" <?php if(isset($editoptions[19])) { if($editoptions[19]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="19" <?php if(isset($editoptions[19])) { if($editoptions[19]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="19" <?php if(isset($editoptions[19])) { if($editoptions[19]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="19" <?php if(isset($editoptions[19])) { if($editoptions[19]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="19" <?php if(isset($editoptions[19])) { if($editoptions[19]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_21">
     																		<td>User Roles</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="20" <?php if(isset($editoptions[20])) { if($editoptions[20]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="20" <?php if(isset($editoptions[20])) { if($editoptions[20]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="20" <?php if(isset($editoptions[20])) { if($editoptions[20]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="20" <?php if(isset($editoptions[20])) { if($editoptions[20]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="20" <?php if(isset($editoptions[20])) { if($editoptions[20]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="20" <?php if(isset($editoptions[20])) { if($editoptions[20]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>

     														
																		
																			<tr id="">
																		<td colspan="7"  style="font-weight:bold;font-size:18px">Sales Rep Target</td>	      </tr>
                                                                                          <tr id="trow_35">
                                                                                               <td>Sales Rep Target</td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="34" <?php if(isset($editoptions[34])) { if($editoptions[34]->r_view == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="34" <?php if(isset($editoptions[34])) { if($editoptions[34]->r_insert == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="34" <?php if(isset($editoptions[34])) { if($editoptions[34]->r_edit == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="34" <?php if(isset($editoptions[34])) { if($editoptions[34]->r_delete == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="34" <?php if(isset($editoptions[34])) { if($editoptions[34]->r_approvals == 1) { echo 'checked';} } ?> /></td>
                                                                                               <td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="34" <?php if(isset($editoptions[34])) { if($editoptions[34]->r_export == 1) { echo 'checked';} } ?> /></td>
                                                                                          </tr>
                                                                                    
     																	<tr id="trow_24" style="display:none;">
     																		<td>Sales Rep Route Plan</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="23" <?php if(isset($editoptions[23])) { if($editoptions[23]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="23" <?php if(isset($editoptions[23])) { if($editoptions[23]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="23" <?php if(isset($editoptions[23])) { if($editoptions[23]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="23" <?php if(isset($editoptions[23])) { if($editoptions[23]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="23" <?php if(isset($editoptions[23])) { if($editoptions[23]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="23" <?php if(isset($editoptions[23])) { if($editoptions[23]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_25" style="display:none;">
     																		<td >Sales Rep Distributors</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="24" <?php if(isset($editoptions[24])) { if($editoptions[24]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="24" <?php if(isset($editoptions[24])) { if($editoptions[24]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="24" <?php if(isset($editoptions[24])) { if($editoptions[24]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="24" <?php if(isset($editoptions[24])) { if($editoptions[24]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="24" <?php if(isset($editoptions[24])) { if($editoptions[24]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="24" <?php if(isset($editoptions[24])) { if($editoptions[24]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_26" style="display:none;">
     																		<td>Sales Rep Orders</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="25" <?php if(isset($editoptions[25])) { if($editoptions[25]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="25" <?php if(isset($editoptions[25])) { if($editoptions[25]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="25" <?php if(isset($editoptions[25])) { if($editoptions[25]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="25" <?php if(isset($editoptions[25])) { if($editoptions[25]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="25" <?php if(isset($editoptions[25])) { if($editoptions[25]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="25" <?php if(isset($editoptions[25])) { if($editoptions[25]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
     																	<tr id="trow_27" style="display:none;">
     																		<td>Sales Rep Payment Receivables</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="26" <?php if(isset($editoptions[26])) { if($editoptions[26]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="insert[]" value="26" <?php if(isset($editoptions[26])) { if($editoptions[26]->r_insert == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="update[]" value="26" <?php if(isset($editoptions[26])) { if($editoptions[26]->r_edit == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="delete[]" value="26" <?php if(isset($editoptions[26])) { if($editoptions[26]->r_delete == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="approval[]" value="26" <?php if(isset($editoptions[26])) { if($editoptions[26]->r_approvals == 1) { echo 'checked';} } ?> /></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="export[]" value="26" <?php if(isset($editoptions[26])) { if($editoptions[26]->r_export == 1) { echo 'checked';} } ?> /></td>
     																	</tr>
																		
																			<tr id="">
																		<td colspan="7"  style="font-weight:bold;font-size:18px"> Log</td>	
     																	<tr id="trow_22">
     																		<td>Log</td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="21" <?php if(isset($editoptions[21])) { if($editoptions[21]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td colspan="5" class="center">&nbsp;</td>
     																	</tr>
     																	</tr>
																		<tr id="">
																		<td colspan="7"  style="font-weight:bold;font-size:18px"> Reports
     																	<tr id="trow_23">
     																		<td> <span class="">Reports</span> <a class="reports" href="javascript:void(0);"><span class="badge badge-info pull-right"> View Reports</span></a></td>
     																		<td class="center"><input type="checkbox" class="cls_chk" name="view[]" value="22" <?php if(isset($editoptions[22])) { if($editoptions[22]->r_view == 1) { echo 'checked';} } ?> /></td>
     																		<td colspan="5" class="center">&nbsp;</td>
     																	</tr>
																		</td>	
     																	</tr>
     																</tbody>
     															</table>
     														</div>
     													</div>
     												</div>
     											</div>

     											<div class="panel report-expand selectreport">  
     												<div class="panel-heading ui-draggable-handle" style="padding:15px; display:block;">
     													<span class="btn btn-default btn-clr bt-xs pull-left"> <label class="" style="padding:0; margin:0;"> Select All &nbsp; <input type="checkbox" id="checkAll" class="check-box" /> </label> </span>
     													<a class="reports" href="javascript:void(0);" ><span class="badge  pull-right" style="margin-top:-5px;"> X </span></a>
     												</div> 
     												<br clear="all"/>

     												<div class="row push-up-10">
     													<div id="checkboxes">
     														<div class="col-md-4 col-sm-4 col-xs-12" <?php if(isset($rep_grp_1)) {if($rep_grp_1==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
     															<div class="">
     																<label class="selectAllLabel">
     																	<h3 class=" pull-left">Stock Report</h3> 
     																	<input type="checkbox" id="selectall-1"/>
     																</label>
     															</div> 
     															<div class="panel panel-success">
     																<div class="panel-body list-group" id="friendslist-1">
     																	<label class="list-group-item-reports" <?php if(isset($rep_1_view)) {if($rep_1_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group1_a" name="report[]" value="1" <?php if(isset($rep_1)) {if($rep_1==1) echo 'checked';} ?> /> Sale Invoice </label>
     																	<label class="list-group-item-reports" <?php if(isset($rep_2_view)) {if($rep_2_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group1_b" name="report[]" value="2" <?php if(isset($rep_2)) {if($rep_2==1) echo 'checked';} ?> /> Raw Material Stock </label>
     																	<label class="list-group-item-reports" <?php if(isset($rep_3_view)) {if($rep_3_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_c" name="report[]" value="3" <?php if(isset($rep_3)) {if($rep_3==1) echo 'checked';} ?> /> Production </label>
     																	<label class="list-group-item-reports" <?php if(isset($rep_4_view)) {if($rep_4_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_d" name="report[]" value="4" <?php if(isset($rep_4)) {if($rep_4==1) echo 'checked';} ?> /> Product Stock </label>
     																</div>
     															</div>
     														</div>
     														<br clear="all"/>
     													</div>
     												</div>
     											</div>
     										</div>
     										<br clear="all"/>	
     									</div>
     								</div>
     								<div class="panel-footer">
     									<a href="<?php echo base_url(); ?>index.php/user_roles" class="btn btn-danger" id="reset" >Cancel</a>
     									<button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
     								</div>
     							</form>

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
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        
		<script type="text/javascript">
			function selectall(num) {
				if(num == 1 ) {
					$('#role_details_table').find('input[name^=view]').prop('checked', document.getElementById('view').checked);
				} else if(num == 2 ) {
					var insert_check = document.getElementById('insert').checked;
					$('#role_details_table').find('input[name^=insert]').prop('checked', document.getElementById('insert').checked);
				} else if(num == 3 ) {
					var update_check = document.getElementById('update').checked;
					$('#role_details_table').find('input[name^=update]').prop('checked', document.getElementById('update').checked);
				} else if(num == 4 ) {
					var delete_check = document.getElementById('delete').checked;
					$('#role_details_table').find('input[name^=delete]').prop('checked', document.getElementById('delete').checked);
				} else if(num == 5 ) {
					var approve_check = document.getElementById('approval').checked;
					$('#role_details_table').find('input[name^=approval]').prop('checked', document.getElementById('approval').checked);
				} else if(num == 6 ) {
					var export_check = document.getElementById('export').checked;
					$('#role_details_table').find('input[name^=export]').prop('checked', document.getElementById('export').checked);
				}
			}
		</script>
        <script>
			$(document).ready(function(){
			    $(".reports").click(function(){
			        $(".report-expand").slideToggle();
			    });
			});
		</script>   
		<script type="text/javascript" >
				$("#checkAll").change(function () {
				$('.selectreport').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));
			});
        </script>


        <script type="text/javascript" >
	       	$('#selectall-1').change(function() {      
	            $('#friendslist-1').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			$('#selectall-2').change(function() {      
	            $('#friendslist-2').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			$('#selectall-3').change(function() {      
	            $('#friendslist-3').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			$('#selectall-4').change(function() {      
	            $('#friendslist-4').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			$('#selectall-5').change(function() {      
	            $('#friendslist-5').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			$('#selectall-6').change(function() {      
	            $('#friendslist-6').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
      	</script>
    <!-- END SCRIPTS -->      
    </body>
</html>