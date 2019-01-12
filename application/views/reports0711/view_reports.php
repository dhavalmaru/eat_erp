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
        <style>
		html,
body {
  min-height: 100%;
  padding: 0px;
margin: 0px; background: #fff!important; }
		
		</style>
            <!-- CSS INCLUDE -->        
         <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->                                    
		
		<style>
			.tile {padding: 0px;
				   min-height: 77px;}
			.list-group-item-reports {
    position: relative; text-decoration:none; color:#555;
    display: block; font-size:12px; font-weight:600;
    padding: 8px 15px; border-top:1px solid #eee;
    margin-bottom: -1px;
    background-color: #fff;
    
}
.list-group-item-reports:hover { text-decoration:none;  background-color: #245478; color:#fff;}
.message-box .mb-container .mb-middle {
    width: 100%; 
    left: 0%;
    position: relative;
    color: #000;
}
.message-box .mb-container {
    position: absolute;
    left:31%;
    top: 19%;
    border-radius:2px;
    background: rgba(0, 0, 0, 0.9);
    padding: 20px;
    width: 36%;
}
#divCheckAll label { padding-left:5px; font-size:15px;}
#divCheckAll {
    background-color: #F2F2F2; height:40px;
    border: #e1e1e1 1px solid; 
    padding:8px 10px;
}
#divCheckboxList .divCheckboxItem label { padding-left:5px; position:relative; font-weight:500; font-size:13px; } 
#divCheckboxList { height:185px; z-index:9; overflow-y:scroll; margin-bottom:15px; }
#divCheckboxList .divCheckboxItem { background:#f9f9f9; padding:6px 0 5px 10px; z-index:0; border-bottom:1px solid #eee;  border-top:1px solid #fff; border-left:1px solid #eee; border-right:1px solid #eee;  }
#divCheckboxList .divCheckboxItem:nth-child(odd) { background:#fff;}
.option { font-size:13px; }
.text-decoration:hover { text-decoration:none; color:#000;}
a { text-decoration:none;}
.text-decoration a { text-decoration:none;}
.selected { background:#f00;}
		</style>
    </head>
    <body>
 <!-- START PAGE CONTAINER -->
           <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
               <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Reports</div>                  
                
                <!-- PAGE CONTENT WRAPPER -->
					 <div class="box-shadow-inside">
						<div class="col-md-12 custom-padding" style="padding:0;" >
						 <div class="panel panel-default">
							<div class="panel-body">  
								<div class="row push-up-10" style="padding:10px;">
									<div class="col-md-4 col-sm-4 col-xs-12" <?php if(isset($rep_grp_1)) {if($rep_grp_1==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <h3 class="">Stock Details</h3>
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/1'?>" id="report_1" class="list-group-item-reports" <?php if(isset($rep_1_view)) {if($rep_1_view==1) {if(isset($rep_1)) {if($rep_1==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sale Invoice </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/2'?>" id="report_2" class="list-group-item-reports" <?php if(isset($rep_2_view)) {if($rep_2_view==1) {if(isset($rep_2)) {if($rep_2==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Raw Material Stock </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/3'?>" id="report_3" class="list-group-item-reports" <?php if(isset($rep_3_view)) {if($rep_3_view==1) {if(isset($rep_3)) {if($rep_3==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Production </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/4'?>" id="report_4" class="list-group-item-reports" <?php if(isset($rep_4_view)) {if($rep_4_view==1) {if(isset($rep_4)) {if($rep_4==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Product Stock </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/5'?>" id="report_5" class="list-group-item-reports" <?php if(isset($rep_5_view)) {if($rep_5_view==1) {if(isset($rep_5)) {if($rep_5==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Distributor Ledger </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/6'?>" id="report_6" class="list-group-item-reports" <?php if(isset($rep_6_view)) {if($rep_6_view==1) {if(isset($rep_6)) {if($rep_6==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Aging Wise </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/18'?>" id="report_18" class="list-group-item-reports" <?php if(isset($rep_18_view)) {if($rep_18_view==1) {if(isset($rep_18)) {if($rep_18==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sale Invoice SKU </a>
                                               <!-- <button class="btn btn-default" data-toggle="modal" data-target="#modal_large">Large</button> -->
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
                                    </div>
									<div class="col-md-4 col-sm-4 col-xs-12" <?php if(isset($rep_grp_2)) {if($rep_grp_2==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <h3 class="">Other Reports</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/7'?>" id="report_7" class="list-group-item-reports" <?php if(isset($rep_7)) {if($rep_7==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Distributor wise </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/8'?>" id="report_8" class="list-group-item-reports" <?php if(isset($rep_8)) {if($rep_8==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sales Return </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/9'?>" id="report_9" class="list-group-item-reports" <?php if(isset($rep_9)) {if($rep_9==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Payment Receivable </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/10'?>" id="report_10" class="list-group-item-reports" <?php if(isset($rep_10)) {if($rep_10==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Purchase Order </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/11'?>" id="report_11" class="list-group-item-reports" <?php if(isset($rep_11)) {if($rep_11==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Production Data </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/12'?>" id="report_12" class="list-group-item-reports" <?php if(isset($rep_12)) {if($rep_12==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Purchase Variance </a>
												<a href="<?php echo base_url() . 'index.php/export/set_report_criteria/13'?>" id="report_13" class="list-group-item-reports" <?php if(isset($rep_13)) {if($rep_13==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sales Representative Location </a>
												<a href="<?php echo base_url() . 'index.php/export/set_report_criteria/14'?>" id="report_14" class="list-group-item-reports" <?php if(isset($rep_14)) {if($rep_14==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Credit / Debit </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/15'?>" id="report_15" class="list-group-item-reports" <?php if(isset($rep_15)) {if($rep_15==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Promoter Stock </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/16'?>" id="report_16" class="list-group-item-reports" <?php if(isset($rep_16)) {if($rep_16==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Ledger Report </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/17'?>" id="report_17" class="list-group-item-reports" <?php if(isset($rep_17)) {if($rep_17==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Trial Balance Report </a>
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
                                    </div>
									<div class="col-md-4 col-sm-4 col-xs-12" <?php if(isset($rep_grp_3)) {if($rep_grp_3==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <h3 class="">Asset Level</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/11'?>" id="report_11" class="list-group-item-reports" <?php if(isset($rep_11)) {if($rep_11==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Profitability </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/12'?>" id="report_12" class="list-group-item-reports" <?php if(isset($rep_12)) {if($rep_12==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Purchase Variance </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/13'?>" id="report_13" class="list-group-item-reports" <?php if(isset($rep_13)) {if($rep_13==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/14'?>" id="report_14" class="list-group-item-reports" <?php if(isset($rep_14)) {if($rep_14==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Rent </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/15'?>" id="report_15" class="list-group-item-reports" <?php if(isset($rep_15)) {if($rep_15==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sale </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/16'?>" id="report_16" class="list-group-item-reports" <?php if(isset($rep_16)) {if($rep_16==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sale Variance </a>
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
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
    </body>
</html>