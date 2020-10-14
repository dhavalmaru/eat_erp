<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>EAT ERP</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- END META SECTION -->
         <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" />
		    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->    
		    <style type="text/css">
 body {background:none!important;}
.bootstrap-select.btn-group .dropdown-menu li > a {
    cursor: pointer;
    width: 100%;
}
.btn.btn-sm, .btn-group-sm > .btn {padding:0px 10px;}
.panel-heading{ background: #fff!important;  padding:8px  10px!important;  }
.panel  span { margin:0;}
 @media only screen and  (min-width:250px)  and (max-width:480px) {
  .custom-padding  .panel-heading .pull-right {/* margin:5px 20px; */}
  .panel-heading { min-height:60px;}

 }
 @media only screen and (min-width: 260px) and (max-width:767px) { 
.custom-padding .col-md-6 .control-label {
    margin-top:10px;
} }
 
@media only screen and (min-width:768px) and (max-width: 1020px) { 
.custom-padding .col-md-6 .control-label {
    margin-top:0;
} }

table {
      width: 80%;
}

caption {
  text-align: left;
  color: silver;
  font-weight: bold;
  text-transform: uppercase;
  padding: 5px;
}

thead {
  background: SteelBlue !important;
  color: white;
}

th{
    background: SteelBlue !important;
}

th,
td {
  padding: 5px 10px;
  border: 1px solid #e2e2e2;
  text-align: left;
}

tbody tr:nth-child(even) {
  background: WhiteSmoke;
}



tbody tr td:nth-child(3),
tbody tr td:nth-child(4),
tbody tr td:nth-child(5) {
  text-align: right;
  font-family: monospace;
}

tfoot {
  background: SeaGreen;
  color: white;
  text-align: right;
}

tfoot tr th:last-child {
  font-family: monospace;
}

 	
        </style>
    </head>
    <body>								
       <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">   
      <?php $this->load->view('templates/menus');?>         		
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                      
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Reports/view_reports'; ?>" >  Report List  </a>   &nbsp; &#10095; &nbsp; Report Details   </div>

                  <div class="container">
                      <?php if($this->session->flashdata('error')){?>
                      <div class="alert alert-info alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo rtrim($this->session->flashdata('error'),',');?>
                      </div>  
                      <?php } ?>
                  </div>
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap" >
                    <div class="row main-wrapper" style="">                  
                       <div class="main-container">           
                         <div class="box-shadow custom-padding">
						  <form id="form_download_report" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($report_id)) { echo base_url().'index.php/export/generate_report/'.$report_id; } ?>">
							
						  <div class="col-md-12" style="padding:0;">
                          <div class="box-shadow-inside">  
                        <div class="panel panel-default">
							<div class="panel-body panel-group accordion" >
                      		  	<div class="panel-primary"   >
                              	<div class="panel-heading" style="display:inline-block;">
	                              
	          						<h4 class="panel-title">  <span class="fa fa-file-text-o"> </span>  <?php if(isset($report_name)) echo $report_name; ?>  </h4>
	          						<input type="hidden" name="txn_type" id="txn_type" value="<?php if(isset($txn_type)) echo $txn_type; ?>" />
									<a style="display:none;" class="pull-right" href="<?php echo base_url() . '/assets/reports_sample/' . (isset($sample_report_name)?$sample_report_name:'') ;?>" target="_blank"> <span class="btn btn-danger pull-right btn-sm "><span class="fa fa-file-pdf-o"> </span>  View Sample </span>  </a>
                                </div>
								
								 <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
									                 <div class="form-group" style="border-top:1px solid #ddd; <?php if($report_type!='Owner Level') echo 'display:none;';?>">
                                        <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-5 col-sm-5 col-xs-12 control-label">Select Owner</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <select class="form-control select2" name="owner" id="owner">
                                                        <option value="">Select Owner</option>
                                                        <?php for ($i=0; $i < count($owner) ; $i++) { ?>
                                                            <option value="<?php echo $owner[$i]->pr_client_id; ?>"><?php echo $owner[$i]->owner_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php if($report_id !='30') echo 'display:none;';?>">
                                      <div class="col-md-6  col-sm-6 col-xs-12">
                                          <div class="">
                                             <label class="col-md-4 col-sm-4 col-xs-12  control-label">Select Region</label>
                                             <div class="col-md-6 col-sm-6  col-xs-12">
                                                  <select name="location[]" id="location" class="form-control select2" multiple>
                                                  <option value="ALL" selected>ALL</option>
                                                  <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                          <option value="<?php echo trim($location[$k]->location); ?>" ?><?php echo $location[$k]->location; ?></option>
                                                  <?php }} ?>
                                              </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php if($report_id !='27') echo 'display:none;';?>">
                                      <div class="col-md-6  col-sm-6 col-xs-12">
                                          <div class="">
                                             <label class="col-md-4 col-sm-4 col-xs-12  control-label">Select Depo</label>
                                             <div class="col-md-6 col-sm-6  col-xs-12">
                                                  <select name="depot_id" id="depot_id" class="form-control ">
                                                  <option value="ALL">ALL</option>
                                                  <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { ?>
                                                          <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                  <?php }} ?>
                                              </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php if($report_id !='5') echo 'display:none;';?>">
                                        <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-4 col-sm-4 col-xs-12  control-label">Select Distributor</label>
                                                <div class="col-md-6 col-sm-6  col-xs-12">
                                                    <select class="form-control select2" name="distributor_id" id="distributor_id">
                                                        <option value="">Select Distributor </option>
                                                        <?php if(isset($distributor)){
	                                                        	foreach($distributor as $row){
	                                                            	echo '<option value="'.$row->id.'" >'.$row->distributor_name.'</option>';                                                        	
	                                                        	}
                                                        	} 
                                                    	?>
                                                    </select>
                                                </div>
                                            </div>
										</div>
										   <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                
                                                   
													<label class="radio-inline">
													<input type="radio" name="remark_visibility" id="with_remark"  value="With Remark" checked>With Remark
													</label>
													<label class="radio-inline">
														<input type="radio" name="remark_visibility" id="without_remark" value="Without Remark">Without Remark
													</label>
                                                
                                            </div>
											</div>
                                    </div>

                                    <!-- <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php //if($report_id !='15') echo 'display:none;';?>">
                                         <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-4 col-sm-4 col-xs-12  control-label">Select Promoter</label>
                                                <div class="col-md-6 col-sm-6  col-xs-12">
                                                    <select class="form-control" name="promoter_id" id="promoter_id">
                                                        <option value="">Select Promoter </option>
                                                        <?php //if(isset($promoter)){
                                                            //foreach($promoter as $row){
                                                             //   echo '<option value="'.$row->id.'" >'.$row->sales_rep_name.'</option>';                                                         
                                                           // }
                                                          //} 
                                                      ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
									
							           <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php if($report_id !='13') echo 'display:none;';?>">
                                         <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-4 col-sm-4 col-xs-12  control-label">Select Sales Representative</label>
                                                <div class="col-md-6 col-sm-6  col-xs-12">
                                                    <select class="form-control select2" name="salesrep_id" id="salesrep_id">
                                                        <option value="">Select </option>
                                                        <?php if(isset($salesrep)){
	                                                        	foreach($salesrep as $row){
	                                                            	echo '<option value="'.$row->id.'" >'.$row->sales_rep_name.'</option>';                                                        	
	                                                        	}
                                                        	} 
                                                    	?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                      <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php if($report_id !='20') echo 'display:none;';?>">
                                         <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-4 col-sm-4 col-xs-12  control-label">Include</label>
                                                <div class="col-md-6 col-sm-6  col-xs-12">
                                                    <input type="checkbox" name="includes_zero" class='includes_zero' id="includes_zero" 
                                                    value='0'> 0 Closing Balance <br>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php if($report_id !='20') echo 'display:none;';?>">
                                         <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-4 col-sm-4 col-xs-12  control-label">Include</label>
                                                <div class="col-md-6 col-sm-6  col-xs-12">
                                                  <input type="checkbox" name="includes_twenty" class='includes_zero' id="includes_twenty" value='20'> Less Then 20  Closing Balance<br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php if($report_id !='18') echo 'display:none;';?>">
                                         <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-4 col-sm-4 col-xs-12  control-label">Include</label>
                                                <div class="col-md-6 col-sm-6  col-xs-12">
                                                    <input type="checkbox" name="sales" id="sales" value="Sales" checked> Sales <br>
                                                    <input type="checkbox" name="ssallocation" id="ssallocation" value="SS Allocation" checked> SS Allocation <br>
                                                    <input type="checkbox" name="salesreturn" id="salesreturn" value="Sales Return" checked> Sales Return <br>
                                                    <input type="checkbox" name="sample" id="sample" value="Sample & Product Expired" checked> Sample & Product Expired <br>
												                            <input type="checkbox" name="credit_debit" id="credit_debit" value="Credit Debit Note" checked> Credit Debit Note <br>
                                                    <input type="checkbox" name="dist_transfer" id="dist_transfer" value="Distributor Transfer" checked> Distributor Transfer <br>
												 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                
                                                <div class="col-md-6 col-sm-6  col-xs-12">
                                                    <input type="checkbox" id="invoicelevel" value="Invoice Level" name="invoicelevel"> Invoice Level <br>
                                                    <input type="checkbox" id="invoicelevelsalesreturn" value="Invoice Level Sales Return" name="invoicelevelsalesreturn"> Invoice Level Sales Return <br>
                                                    <span style="display: none;">
                                                    <input type="checkbox" id="invoicelevelsample" value="Invoice Level Sample & Product Expired" name="invoicelevelsample"> Invoice Level Sample & Product Expired <br>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php if($report_id !='18') echo 'display:none;';?>">
                                         <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                              <label class="col-md-4 col-sm-4 col-xs-12  control-label">Include</label>
                                                <div class="col-md-8 col-sm-8  col-xs-12">
                                              <input type="checkbox" name="date_of_processing" id="date_of_processing" value="Date Of Processing" checked> By Date Of Processing&nbsp;&nbsp;&nbsp;&nbsp;
                         <input type="checkbox" name="date_of_accounting" id="date_of_accounting" value="Date Of Accounting" checked> By Date Of Accounting <br>
                                            </div>
                                            </div>
                                          </div>
                                        </div>

                                    <!-- <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php //if($report_id !='16') echo 'display:none;';?>">
                                         <div class="col-md-6  col-sm-6 col-xs-12">
                                            <div class="">
                                                <label class="col-md-4 col-sm-4 col-xs-12  control-label">Select Ledger</label>
                                                <div class="col-md-6 col-sm-6  col-xs-12">
                                                    <select class="form-control" name="ledger_id" id="ledger_id">
                                                        <option value="">Select </option>
                                                        <?php //if(isset($ledger)){
                                                            //foreach($ledger as $row){
                                                                //echo '<option value="'.$row->id.'" >'.$row->ledger_name.'</option>';                                                         
                                                            //}
                                                          //} 
                                                      ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="form-group" style="border-top:1px solid #ddd; <?php if($report_type!='Asset Level') echo 'display:none;';?>">
                                        <div class="col-md-6 col-sm-6 col-xs-12" id="property_div" style="<?php if($report_type!='Asset Level') echo 'display:none;';?>">
											<div class="">
												<label class="col-md-4 col-sm-4 col-xs-12 control-label">Property Name</label>
												<div class="col-md-8 col-sm-8 col-xs-12">
													<select  class="form-control select2" id="property" name="property">
														<option value="">Select Property</option>
														<?php for($i=0; $i<count($purchase_data); $i++) { ?>
														<option value="<?php echo $purchase_data[$i]->txn_id; ?>"><?php echo $purchase_data[$i]->p_property_name; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12" id="sub_property_div" style="display: none;">
											<div class="">
												<label id="sub_property_label" class="col-md-4 col-sm-4 col-xs-12 control-label">Sub Property Name</label>
												<div class="col-md-8 col-sm-8 col-xs-12">
													<select id="sub_property select2" class="form-control" name="sub_property">
														<option value="">Select Sub Property</option>
													</select>
												</div>
											</div>
										</div>
                                    </div>

                                    <div class="form-group" style="border-top:1px solid #ddd; <?php if($report_type=='Aging Wise' || $report_type=='MT Stock Tracker' || $report_type=='gt_store') echo 'display:none;';?>">
										  <div class="col-md-6  col-sm-6 col-xs-12">
											<label class="col-md-4  col-sm-4 col-xs-12 control-label" >From</label>
											<div class="col-md-6  col-sm-6 col-xs-12">                                                                  
												<div class="input-group" style="display:block">
                                                    <input type="text" class="form-control datepicker" id="from_date" name="from_date" value="<?php echo "01/01/2020"; ?>">
                                                    <!--<span class="input-group-addon"><span class="fa fa-calendar"></span></span>-->
                                                </div>
											</div>
										</div>
                                        <div class="col-md-6  col-sm-6 col-xs-12">
											<label class="col-md-4  col-sm-4 col-xs-12 control-label">To</label>
											<div class="col-md-6  col-sm-6 col-xs-12">
											    <div class="input-group" style="<?php if($report_type=='gt_store') echo 'display:none;'; else echo 'display:block;'; ?>" >
                                            		<input type="text" class="form-control datepicker" id="to_date" name="to_date" value="<?php echo "15/01/2020"; // echo date('d/m/Y'); ?>">
                                               <!--<span class="input-group-addon"><span class="fa fa-calendar"></span></span>-->
                                        		</div>
											</div>
										</div>
									</div>

                                    <div class="form-group" style="border-top:1px solid #ddd; <?php if($report_type!='Aging Wise' && $report_type!='MT Stock Tracker') echo 'display:none;';?>">
                                          <div class="col-md-6  col-sm-6 col-xs-12">
                                            <label class="col-md-4  col-sm-4 col-xs-12 control-label" >Date</label>
                                            <div class="col-md-6  col-sm-6 col-xs-12">                                                                  
                                                <div class="input-group" style="display:block">
                                                    <input type="text" class="form-control datepicker" name="date" value="<?php echo date('d/m/Y')?>">
                                                    <!--<span class="input-group-addon"><span class="fa fa-calendar"></span></span>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    

                                  

								<div class="row" style="text-align:center; margin:15px 0;">
                                    	<input type="submit" name="download" class="btn btn-danger" value="Download Report" style=" <?php if($report_id =='20') echo 'display:none;';?>"/>
                                      <a class="btn btn-success" data-toggle="modal" href="#telly_report_uploaded" id="telly_popup" style=" <?php if($report_id!=20) echo 'display:none;';?>">
                                          <span class="fa fa-file-excel-o"></span> Download Report
                                      </a>


                                     <input type="submit" name="btn_adjus" class="btn btn-danger" value="Adjust Closing Balance" id="btn_adjus" style="<?php if($report_id!=20) echo 'display:none;';?>"/>

                                     <input type="button" name="download" class="btn btn-danger" value="View Report" id="view_tally" style=" <?php if($report_id !='20') echo 'display:none;';?>" />
                                      
                                        <!--<span class="fa fa-download"> </span>-->
                                      <a class="btn btn-success" data-toggle="modal" href="#myModal" style="<?php if($report_id !='20') echo 'display:none;';?>">
                                          <span class="fa fa-file-excel-o"></span> Upload Tally Report
                                      </a>    

                                      <input type="button" id="view_report" class="btn btn-danger" value="View Report" style="<?php if($report_id !='5') echo 'display:none;';?>" />
                                      <input type="button" id="print_report" class="btn btn-danger" value="Print Report" style="<?php if($report_id !='5') echo 'display:none;';?>" />

                                    <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php if($report_id !='5') echo 'display:none;';?>">
                                         <div class="col-md-12  col-sm-12 col-xs-12">
                                            <div class="">
                                                
                                                <div class="col-md-12 col-sm-12  col-xs-12 ledger_table datatable">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none;">
                                         <div class="col-md-12  col-sm-12 col-xs-12">
                                            <div class="">
                                                
                                                <div class="col-md-12 col-sm-12  col-xs-12 telly_table datatable">
                                                    
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                <br clear="all">                              
                            	</div>
							</div>
							</div>
							<br clear="all"/>
						</div>	
					
                            <div class="panel-footer">
						 
								<a href="<?php echo base_url(); ?>index.php/Reports/view_reports" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                            </div>

            <div class="modal fade" id="telly_report_uploaded" role="dialog" style="">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">
                          Download Ledger Balance
                        </h4>
                    </div>
                    <div>
                      <table style="width: 100%!important;">
                        <tr>
                          <th style="color:#fff">SR NO.</th>
                          <th style="color:#fff">File Name</th>
                          <th style="color:#fff">Telly Date</th>
                          <th style="color:#fff">Check</th>
                        </tr>
                        <?php
                        $j=0;

                        if(count($upload_telly_report)>0)
                        {
                            for ($i=0; $i <count($upload_telly_report); $i++) { 
                            echo "<tr><td>".($j+1)."</td>
                                  <td><a href='".base_url()."/uploads/excel_upload/".$upload_telly_report[$i]->file_name."'>".$upload_telly_report[$i]->file_name."</a></td>
                                  <td><input type='hidden' value='".$upload_telly_report[$i]->telly_report_upload_id."'>".date("Y-m-d h:i:s A" ,strtotime($upload_telly_report[$i]->added_on))."</td>
                                  <td><input type='radio' name='excel_upload' value='".$upload_telly_report[$i]->telly_report_upload_id."' > </td>
                                </tr>";

                                $j = $j+1;
                          }
                        }
                        else
                        {
                          echo "<input type='radio' name='excel_upload' value='Default' checked style='display:none'>";
                        }
                        
                      ?>
                      </table>
                      
                    </div>

                    <div class="modal-footer">
                       <input type="submit" name="download" class="btn btn-danger" value="Download Report" />     
                    </div>
                </div>
            </div>
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
		
		     

        <div class="modal fade" id="myModal" role="dialog" style="">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">
                           Upload Tally Report
                        </h4>
                    </div>
                    <form method="POST" action="<?php echo base_url();?>index.php/Export/upload_file" class="form-horizontal excelform" enctype="multipart/form-data">
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
						
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url();?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

        <script type="text/javascript">
            $( "#property" ).change(function() {
              getSubProperties();
            });

            function getSubProperties(){
              var property=$("#property").val();
              var txn_type=$("#txn_type").val();
              if(property==''){
                $("#sub_property").html('');
                $("#sub_property_div").hide();
              } else {
                // console.log(property);
                var status=$("#status").val();
                var dataString = 'property_id=' + property + '&txn_type=' + txn_type;

                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url() . 'index.php/export/get_sub_property' ?>",
                  data: dataString,
                  // async: false,
                  cache: false,
                  success: function(html){
                    $("#sub_property").html(html);

                    if(html==""){
                      $("#sub_property_div").hide();
                    } else {
                      $("#sub_property_div").show();
                    }
                  }
                });
              }
            }


            function printData()
            {
               var divToPrint=document.getElementById("printTable");
               newWin= window.open("");
               newWin.document.write(divToPrint.outerHTML);
               newWin.print();
               newWin.close();
            }

        </script>
        <!-- END SCRIPTS -->     
        <script>
          $(document).ready(function(){
            $('#view_report').click(function(){
              // alert($('#from_date').val());

              var remarks = '';
              if($("#with_remark").is(":checked")){
                  remarks = 'With Remark';
              } else {
                  remarks = 'Without Remark';
              }

              $.ajax({
                type: 'post',
                url: '<?php echo base_url();?>index.php/Export/generate_ledger_report',
                dataType:"html",
                async:false,
                data: { distributor_id: $('#distributor_id').val(), from_date: $('#from_date').val(), to_date: $('#to_date').val(), remark_visibility: remarks },
                success: function (data) {
                  // alert(data);
                  // var damt=0;
                  // var damttd=0;
                  // var camt=0;
                  // var camttd=0;
                  // var running_bal=0;
                  // var datatable='<table id="printTable" border="1" cellpadding="3" style="border-collapse: collapse;"><thead><th>Ref Date</th><th>Reference</th><th>Debit</th><th>Credit</th><th>Running Balance</th></thead><tbody>';
                  // $.each($.parseJSON(data), function(){
                  //   var debit_amount=this.debit_amount;
                  //   damttd=this.debit_amount;
                  //   if(debit_amount==null){
                  //     debit_amount="";
                  //   }
                  //   if(damttd==null){
                  //     damttd=0;
                  //   }

                  //   var credit_amount=this.credit_amount;
                  //   camttd=this.credit_amount;
                  //   if(credit_amount==null) {
                  //     credit_amount="";
                  //   }
                  //   if(camttd==null){
                  //     camttd=0;
                  //   }

                  //   if(damttd!=null && damttd!=0) {
                  //     running_bal = parseFloat(running_bal)+parseFloat(damttd);
                  //   }
                  //   else {
                  //     running_bal = parseFloat(running_bal)-parseFloat(camttd);
                  //   }
                  //   // alert(this.ref_date);
                  //   datatable=datatable+"<tr><td>"+this.ref_date+"</td><td>"+this.reference+"</td><td>"+debit_amount+"</td><td>"+credit_amount+"</td><td>"+(running_bal).toFixed(2)+"</td></tr>";
                  //   damt=(parseFloat(damt)+parseFloat(damttd)).toFixed(2);
                  //   camt=(parseFloat(camt)+parseFloat(camttd)).toFixed(2);

                  // });


                  // datatable=datatable+"<tr><td></td><td></td><td>"+damt+"</td><td>"+camt+"</td><td></td></tr>";
                  // var diff=0;
                  // if(damt>camt) {
                  //   diff=parseFloat(damt-camt).toFixed(2);
                  //   datatable=datatable+"<tr><td></td><td></td><td></td><td>"+diff+"</td><td></td></tr>";
                  // }
                  // if(camt>damt) {
                  //   diff=parseFloat(camt-damt).toFixed(2);
                  //   datatable=datatable+"<tr><td></td><td></td><td>"+diff+"</td><td></td><td></td></tr>";
                  // }
                  // datatable=datatable+"</tbody></table>";

                  $(".ledger_table").html(data);

                }
              });
            });

            $('#print_report').click(function(){
                printData();
            });
			
			
			$('#view_tally').click(function(){

            var includes_zero1 = $('input[name="includes_zero"]:checked').val();
            var includes_twenty1 = $('input[name="includes_twenty"]:checked').val();

            if(includes_zero1==undefined)
                includes_zero1='';

            if(includes_twenty1==undefined)
                includes_twenty1='';

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>index.php/Export/view_system_report/'+20,
                async:false,
                data: {excel_upload: '', from_date: $('#from_date').val(), to_date: $('#to_date').val(),includes_zero:includes_zero1,includes_twenty:includes_twenty1},
                success: function (data) {
                 $("#ledger_table").DataTable().destroy();;
                 $(".telly_table").html(data);
                 $("#ledger_table").DataTable();

                }
              });

          }); 
          });
        </script> 
        <script>
        $(document).ready(function(){

          $('#invoicelevel').change(function() {
            set_invoicelevel_checkboxes($(this));
          });
          $('#invoicelevelsalesreturn').change(function() {
            set_invoicelevel_checkboxes($(this));
          });
          $('#invoicelevelsample').change(function() {
            set_invoicelevel_checkboxes($(this));
          });

          $('#sales').change(function() {
            set_skulevel_checkboxes($(this));
          });
          $('#ssallocation').change(function() {
            set_skulevel_checkboxes($(this));
          });
          $('#salesreturn').change(function() {
            set_skulevel_checkboxes($(this));
          });
          $('#sample').change(function() {
            set_skulevel_checkboxes($(this));
          });

          var set_invoicelevel_checkboxes = function(elem){
            if($('#invoicelevel').is(":checked") || $('#invoicelevelsalesreturn').is(":checked") || $('#invoicelevelsample').is(":checked")) {
              $('#sales').removeAttr("checked");
              $('#ssallocation').removeAttr("checked");
              $('#salesreturn').removeAttr("checked");
              $('#sample').removeAttr("checked");
            }
          }

          var set_skulevel_checkboxes = function(elem){
            if($('#invoicelevel').is(":checked") || $('#invoicelevelsalesreturn').is(":checked") || $('#invoicelevelsample').is(":checked")) {
              $('#invoicelevel').removeAttr("checked");
              $('#invoicelevelsalesreturn').removeAttr("checked");
              $('#invoicelevelsample').removeAttr("checked");
            }
          }

        });
        </script>
    </body>
</html>