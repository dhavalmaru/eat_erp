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
		  <link rel="stylesheet" type="text/css" id="theme" href="https://www.pecanreams.com/app/assets/plugins/wickedpicker/stylesheets/wickedpicker.css"/>
		
		<style>
		  @media only screen and  (min-width:240px)  and (max-width:441px) { 
					.btn-top-margin {   margin:10px 18px!important;     }	
		   }
		
		  @media only screen and  (min-width:442px)  and (max-width:575px) { 
					.btn-top-margin {   margin-top:-40px!important;     }	
		   }
		</style>
		<style>
			.panel { box-shadow:none; border:1px dotted #e7e7e7; border-top:0px solid #33414e!important;}
			.input-padding { line-height:30px;}
			@media only screen and (max-width:780px) {.input-padding { line-height:15px;}}
			
			<style type="text/css">
  body {
    scrollbar-base-color: #222;
    scrollbar-3dlight-color: #222;
    scrollbar-highlight-color: #222;
    scrollbar-track-color: #3e3e42;
    scrollbar-arrow-color: #111;
    scrollbar-shadow-color: #222;
    scrollbar-dark-shadow-color: #222; 
    -ms-overflow-style: -ms-autohiding-scrollbar;  
  }
  .form-control { padding:6px!important;  }
  body{ overflow:initial; }
  .fonts {
    font-size:35px; 
    text-align: center;
    width: 60px;
    line-height: 48px;
  }
  .x-navigation {overflow-x: hidden;}
  .x-navigation li > a .fa, .x-navigation li > a .glyphicon  {font-size: 20px;}
  .left-menu {  }
  /*.left-menu li{ padding-left:25px!important; }*/
 
  .left-menu li .fa{ font-size: 16px!important; padding-right:15px; }
  .left-menu li .glyphicon { font-size: 16px!important; padding-right:15px;  }
  .left-menu li .glyphicon { font-size: 16px!important; }
  .left-menu li:hover{ background: #23303b!important;}
  .scroller .x-navigation ul li { display: inline-block!important; visibility: visible!important; }
  .x-navigation.x-navigation-horizontal { float:none!important; left: 0;  position: fixed; overflow:hidden; }
  .x-navigation { float: none!important }
  .menu-wrapper { top:61px;
    /* background-image: -webkit-linear-gradient(bottom, #008161 0%, #2F5F5B 23%, #343347 100%);
      background-image: linear-gradient(to top, #008161 0%, #2F5F5B 23%, #343347 100%);*/
    background-image: linear-gradient(to top, #05131f 0%, #13202c 23%, #33414e 100%);
  }
  .menu-wrapper ul { background: none!important }
  .menu { background: none!important }
   .menu 
   {
     max-height:800px!important;
   }
  #ng-toggle {
    position: fixed;
  }
  .menu-wrapper ul li a span {opacity: 1;}
  .menu-wrapper .menu--faq {
    position: absolute;  
    left: 0;     text-shadow: 0px 1px 1px #000;
    bottom: 0;  line-height: 50px;
    z-index: 99999;
    width: 240px; }
  .menu--faq  li { font-size: 1rem; }
  .gn-icon .icon-fontello:before {
    font-size: 20px;
    line-height: 50px;
    width: 50px;
  }
  .fa-sign-out {   }
  #edit{  display: inline-block; padding: 0 5px; cursor:pointer;    }
  .text-info { color:#fff!important; display: inline-block; line-height: 20px; }
  .grp_change{ display: none; }
  .menu-wrapper .scroller {
    position: absolute;
    overflow-y: scroll;
    width: 240px;
    height:80%;
  }

  .header-fixed-style {  width: 100%;  height: 61px; left:0;   position: fixed;  /*background: #33414e!important;*/ background:#245478!important;   z-index: 999; display:block;   }
  .logo-container { width:200px;  float:left; background:#fff; text-align:center; padding:6px 0;}
 
  .useremail-container {width:300px; float:left;}
  .useremail-container a { font-size:18px; color:#fff; padding:15px 10px; display: block;}
  .dropdown-selector { width:35%; float:right;   display:block; tex-align:right;}
  .dropdown-selector-left    { font-size:18px; color:#fff; padding:10px 19px;  display: block; float:right;     text-align: right;}
  .useremail-login { font-size:12px; color:#fff; display: block;}
  .useremail-login:hover{color:#fff; } 
  .logout-section { float:right; display:block;  }
  .logout-section a { color:#fff; font-size:25px;  padding:13px 15px;  display: block;  float:left; border-left:1px solid #0d3553;  }
  .logout-section a:hover { background:#0d3553!important; color:#fff;}

  ::-webkit-scrollbar {
    width: 0.5em;
    height: 0.5em;
  }
  ::-webkit-scrollbar-button:start:decrement,
  ::-webkit-scrollbar-button:end:increment  {
    display: none;
  }
  ::-webkit-scrollbar-track-piece  {
    background-color: #ccc;
    -webkit-border-radius: 6px;
  }
  ::-webkit-scrollbar-thumb:vertical {
    -webkit-border-radius: 6px;
    background: #072c48 url("https://www.pecanreams.com/app/img/scrollbar_thumb_bg.png") no-repeat center;
  }
  ::-webkit-scrollbar-thumb:horizontal {
    -webkit-border-radius: 6px;
    background: #072c48 url("https://www.pecanreams.com/app/img/scrollbar_thumb_bg.png") no-repeat center;
  } 
  ::-webkit-scrollbar-track, 
  ::-moz-scrollbar-track, 
  ::-o-scrollbar-track{
    box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -moz-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -o-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 10px;
    background-color: #F5F5F5;
  } 
  .vertical_nav .bottom-menu-fixed {
    /*bottom: 0!important;*/
    position: absolute;
    /* top: initial!important; */background:#245478!important;      border-top: 1px solid #0d3553;
    top:84.2%!important;
    width: 100%;
    margin: 0;
    padding: 0;
    list-style-type: none;
    /* max-height: 329px; */
    z-index: 0;
  }
  .toggle_menu {
    display: none;
  }
  @media only screen and (max-width: 991px){
    .toggle_menu {
      display: block;
      float: left;
      padding:16px 10px; 
      color: #fff; cursor:pointer;
    }
  }
  @media screen and (max-width:320px) {.vertical_nav .bottom-menu-fixed {  top: 79.2%!important;} }
  @media only screen and (min-width:321px) and (max-width:360px) {.vertical_nav .bottom-menu-fixed {  top: 82.2%!important;}  }
  .vertical_nav__minify .menu--subitens__opened span {
    cursor:default;
  }
</style>    
		</style>
    </head>
    <body>								
     <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                  
                   
                <!-- PAGE CONTENT WRAPPER -->
             
             
               
				   
				         <div class="heading-h2 responsive-heading"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/city_master'; ?>" > Task </a>  &nbsp; &#10095; &nbsp; Task Details </div>
                  
				   

				  
                  <div class="page-content-wrap">
                 <div class="row main-wrapper">
				    <div class="main-container">           
                        <div class="box-shadow custom-padding"> 
  							<form id="task_detail" role="form" class="form-horizontal" action="https://www.pecanreams.com/app/index.php/Task/insertDetails" method="POST">
							   <div class="box-shadow-inside">
									<div class="col-md-12" style="padding:0;" >
										<div class="panel panel-default">
											<input type="hidden" name="task_id" id="task_id" value="">
											<div class= "panel-body panel-group accordion"     >
                      		   <div class="panel-primary"  >
                                                               
                                    <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                                        <div class="form-group" style="border-top:1px dotted #ddd;">
                                        	<div class="col-md-12">
												<label class="col-md-2 control-label">Subject <span  class="asterisk_sign prop_other_name"> * </span></label>
												<div class="col-md-9">
													<input type="text" class="form-control " name="subject_detail"  value=""placeholder="Your Task Subject Here..." required/>
												</div>
											</div>
                                        </div>

										<div class="form-group">
											<div class="col-md-12">
												<label class="col-md-2 control-label">Description <span  class="asterisk_sign prop_other_name"> * </span></label>
												<div class="col-md-9">
													<textarea class="form-control" name="description" rows="2" required></textarea>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="col-md-6 col-sm-6  ">													
												<label class="col-md-4 control-label">Status</label>
												<div class="col-md-6"> 
												    <select class="form-control" name="task_status" required>
													      <option value="Pending"  >Pending</option>
													      <option value="Completed"  >Completed</option>
											        </select>
												</div>
											</div>
                                            <div class="col-md-6 col-sm-6">
												<label class="col-md-4 control-label">Priority <span  class="asterisk_sign prop_other_name"> * </span></label>
												<div class="col-md-6"> 
												    <select class="form-control" name="priority" required>
														<option value="">Select</option>
														<option value="Low"  >Low</option>
														<option value="Medium"  > Medium</option>
														<option value="High"  >High</option>
														<option value="Very High"  >Very High</option>
											        </select>
												</div>
											</div>	
										</div>



										<div class="form-group">
                                        	  <div class="col-md-6 col-sm-6">
												<label class="col-md-4 col-sm-12 control-label" >From Date <span  class="asterisk_sign prop_other_name"> * </span></label>
												<div class="col-md-3 col-sm-6">
													<input type="text" class="form-control datepicker" name="from_date" value="" placeholder="From Date" required/>
												</div>
												<div class="col-md-3 col-sm-6">
													<input type="text" class="form-control  timepickermask " name="from_time" value="" placeholder="From Time"/>
												</div>
											</div>
											  <div class="col-md-6 col-sm-6">
												<label class="col-md-4 col-sm-12 control-label">To Date</label>
												<div class="col-md-3 col-sm-6" >
													<input type="text" class="form-control datepicker" name="to_date" value="" placeholder="To Date"/>
												</div>
												<div class="col-md-3 col-sm-6">
													<input type="text" class="form-control timepickermask" name="to_time"  value="" placeholder="To Time"/>
												</div>
											</div>
										</div>

										<div class="form-group">
										  <div class="col-md-6 col-sm-6">
												<label class="col-md-4 control-label">Owner</label>
												<div class="col-md-6">
													<input type="hidden" id="owner_name_id" name="owner_name" data-error="#owner_error" class="form-control" value="" />
													<input type="text" id="owner_name" name="owner_contact_name" class="form-control auto_owner" value="" placeholder="Type to choose owner from database..." />
													<div id="owner_error"></div>
												</div>
											</div>
										  <div class="col-md-6 col-sm-6">													
												<label class="col-md-4 control-label">Frequency</label>
												<div class="col-md-6"> 
													    <select class="form-control" name="repeat" id="repeat">
													      <option value="Never"  >Never</option>
													      <option value="Daily"  >Daily</option>
                                                          <option value="Periodically"  >Periodically</option>
													      <option value="Weekly"  >Weekly</option>
													      <option value="Monthly"  >Monthly</option>
													      <option value="Yearly"  >Yearly</option>															      
												        </select>
												</div>
											</div>
										</div>
											
										<div class="form-group" id="repeat-periodically">
                                        	<div class="col-md-12">
												<label class="col-md-2 control-label"> Interval after </label>
												<div class="col-md-2">
												    <select class="form-control" name="periodic_interval">
												    	<option value="">Select</option>
												    	<option value="1"  >1</option><option value="2"  >2</option><option value="3"  >3</option><option value="4"  >4</option><option value="5"  >5</option><option value="6"  >6</option><option value="7"  >7</option><option value="8"  >8</option><option value="9"  >9</option><option value="10"  >10</option><option value="11"  >11</option><option value="12"  >12</option><option value="13"  >13</option><option value="14"  >14</option><option value="15"  >15</option><option value="16"  >16</option><option value="17"  >17</option><option value="18"  >18</option><option value="19"  >19</option><option value="20"  >20</option><option value="21"  >21</option><option value="22"  >22</option><option value="23"  >23</option><option value="24"  >24</option><option value="25"  >25</option><option value="26"  >26</option><option value="27"  >27</option><option value="28"  >28</option><option value="29"  >29</option><option value="30"  >30</option>											        </select>
												</div> 
												<label class="control-label">  Days </label>
											</div>
										</div>

										<div class="form-group" id="repeat-weekly">
                                        	<div class="col-md-12">
												<label class="col-md-2 control-label"> Interval</label>
												<div class="col-md-8">  
												<div style="padding-top:8px;">
													
													<input type="hidden" name="weekday" value="" data-error="#weekday_error" />
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Mon" />&nbsp;Mon&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Tue" />&nbsp;Tue&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Wed" />&nbsp;Wed&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Thu" />&nbsp;Thu&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Fri" />&nbsp;Fri&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Sat" />&nbsp;Sat&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Sun" />&nbsp;Sun&nbsp;&nbsp;
													</div>
													<div id="weekday_error"></div>
												</div>
											</div>
										</div>

										<div class="form-group" id="repeat-monthly">
                                        	<div class="col-md-12">
												<label class="col-md-2 control-label"> Interval</label>
												<div class="col-md-2" style="margin-right:0;">
												    <select class="form-control " name="monthly_interval">
												    	<option value="">Select</option>
														<option value="1" >1</option> <option value="2" >2</option> <option value="3" >3</option> <option value="4" >4</option> <option value="5" >5</option> <option value="6" >6</option> <option value="7" >7</option> <option value="8" >8</option> <option value="9" >9</option> <option value="10" >10</option> <option value="11" >11</option> <option value="12" >12</option> 											        </select>
												</div>
												<label class=" control-label col-md-2 " style="padding-left:0px; margin-left:0px;" >  every month ON</label>
												<div class="col-md-2"> 
												    <select class="form-control" name="monthly_interval2">
												    	<option value="">Select</option>
														<option value="1" >1</option> <option value="2" >2</option> <option value="3" >3</option> <option value="4" >4</option> <option value="5" >5</option> <option value="6" >6</option> <option value="7" >7</option> <option value="8" >8</option> <option value="9" >9</option> <option value="10" >10</option> <option value="11" >11</option> <option value="12" >12</option> <option value="13" >13</option> <option value="14" >14</option> <option value="15" >15</option> <option value="16" >16</option> <option value="17" >17</option> <option value="18" >18</option> <option value="19" >19</option> <option value="20" >20</option> <option value="21" >21</option> <option value="22" >22</option> <option value="23" >23</option> <option value="24" >24</option> <option value="25" >25</option> <option value="26" >26</option> <option value="27" >27</option> <option value="28" >28</option> <option value="29" >29</option> <option value="30" >30</option> 											        </select>
												</div>
												<label class=" control-label">  day of the month</label>
											</div>
										</div>

                                        <div class="">

                                        	<!-- <div class="col-md-6" style="border-top: 1px dotted #ddd;">
												<label class="col-md-4 control-label">Assigned to</label>
												<div class="col-md-5">
												 	<input type="hidden" id="txtname_id" name="assigned" class="form-control" value="" />
                                                    <input type="text" id="txtname" name="assigned_name" class="form-control auto_client"  value="" placeholder="Type to choose contact..."  required/>
												</div>  
												<div class="col-md-3"> 
													<label class="control-label"> OR &nbsp;&nbsp;&nbsp;</label> <input type="checkbox" name="self_assigned" id="self_assigned" value="self" onclick="getselfContactId(this.value)" /> <label> Self </label>
												</div>
											</div> -->

                                        	<div class="form-group">
												<div class="col-md-6">
													<label class="col-md-4 col-sm-2 control-label">Assigned to</label>
													<div class="col-md-8 col-sm-8"> 
													<div style="padding-top:8px;">
														<input type="checkbox" name="self_assigned" id="self_assigned" value="self" /> <label> Self </label>
														</div>
													</div>
												</div>
											</div>

											<div class="repeatcontact">
											     <?php $i=0; 
                                                 for($i=0; $i<count(10); $i++) { ?>
												<div class="form-group" id="repeat_contact_<?php echo $i; ?>">
	                                                <div class="col-md-6">
	                                                    <div class="">
	                                                        <label class="col-md-4 control-label" style="padding-left: 0;">Assigned to</label>
	                                                        <div class="col-md-8">
	                                                            <input type="hidden" id="contact_<?php echo $i; ?>_id" name="contact[]" class="form-control" />
	                                                            <input type="text" id="contact_<?php echo $i; ?>" name="contact_name[]" class="form-control auto_client" placeholder="Type to choose contact..." />
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                                <?php } ?>
	                                            
	                                        </div>
	                                        <div class="form-group" style="background:#fff;">
	                                            <div class="col-md-6">
	                                                <button class="btn btn-success repeat-contact" style="margin-left: 10px;">+</button>
            										<button type="button" class="btn btn-success reverse-contact" style="margin-left: 10px;">-</button>
	                                            </div>
	                                        </div>
	                                        <!-- <div class="">
	                                       <div class="form-group">
												<div class="col-md-6">
													<label class="col-md-4 control-label">Follower</label>
													<div class="col-md-8"> 
														 <input type="hidden" id="follower_1_id" name="follower[]" class="form-control" />
	                                                     <input type="text" id="follower_1" name="follower_name[]" class="form-control auto_client" placeholder="Type to choose contact..." />
	                                                 </div>
												</div>
											</div>
										</div> -->

											<div class="follower_div">
											     <?php $i=0; 
                                                for($i=0; $i<count(10); $i++) { ?>
	                                          <div class="form-group" id="repeat_follower_<?php echo $i; ?>">
	                                                <div class="col-md-6">
	                                                    <div class="">
	                                                        <label class="col-md-4 control-label" style="padding-left: 0;">Task Follower</label>
	                                                        <div class="col-md-8"> 
														 <input type="hidden" id="follower_<?php echo $i; ?>_id" name="follower[]" class="form-control" />
	                                                     <input type="text" id="follower_<?php echo $i; ?>" name="follower_name[]" class="form-control auto_client" placeholder="Type to choose contact..." />
	                                                 </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            
	                                           <?php } ?>
	                                        </div>
									   <div class="form-group" style="background:#fff;">
	                                            <div class="col-md-6">
	                                                <button class="btn btn-success repeat-follower" style="margin-left: 10px;">+</button>
            										<button type="button" class="btn btn-success reverse-follower" style="margin-left: 10px;">-</button>
	                                            </div>
	                                        </div>
										</div>
                                    </div>

                             




 
                      		  	<div class="panel-primary"   >
                                  	<a href="javascript:void(0);" style="cursor:text;">   
                                  	<div class="panel-heading">
              							<h4 class="panel-title"> <span class="fa fa-tasks"> </span>  Remark </h4>
                                    </div>  
                                 	</a>                
                                         <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                                                <div class="form-group" style="background: none;border:none">
                                                <div class="col-md-12 ">
													<div class="remark-container">
                                                        <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ></textarea>
                                                      <!--  <label style="margin-top: 5px;">Remark </label> -->
                                               
													</div>
                                                </div>
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
								<div class="panel-footer">
									<a class="btn btn-danger" href="https://www.pecanreams.com/app/index.php/task">Cancel</a>
									<button class="btn  pull-right btn-success" type="submit">Save</button>
								</div>
							</form>
						</div>
						
                    </div>
                    
                 </div>
                <!-- END PAGE CONTENT WRAPPER -->
             </div>  
           
              
            </div>
            <!-- END PAGE CONTENT WRAPPER -->     
        </div>
        <!-- END PAGE CONTENT -->

        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
		      <script type="text/javascript" src="https://www.pecanreams.com/app/assets/plugins/wickedpicker/src/wickedpicker.js"></script>
			       <script type="text/javascript" src="https://www.pecanreams.com/app/js/load_autocomplete.js"></script>
			          <script type="text/javascript" src="<?php echo base_url(); ?>js/tasks.js"></script>
       		<script>
			$(function(){
				$('.timepickermask').wickedpicker();						
			});
			$(function(){
				if($('#repeat').val() != 'Never' || $('#repeat').val() != 'Daily' || $('#repeat').val() != 'Yearly'){
					var divId=$('#repeat').val();
					$('#repeat-'+divId.toLowerCase()).show(); 
				}
			});
			jQuery(function(){
				var counter = 1;
				$('.repeat-contact').click(function(event){
					event.preventDefault();
					counter++;
					var newRow = jQuery('<div class="form-group" id="repeat_contact_' + counter + '"> <div class="col-md-6"> <div class=""> <label class="col-md-4 control-label" style="padding-left: 0;" >Assigned To</label> <div class="col-md-8"> <input type="hidden" id="contact_' + counter + '_id" name="contact[]" class="form-control" /> <input type="text" id="contact_' + counter + '" name="contact_name[]" class="form-control auto_client" placeholder="Type to choose contact..." /> </div> </div> </div> </div>');
					$('.auto_client', newRow).autocomplete(autocomp_opt);
                    $('.repeatcontact').append(newRow);
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
				});
			    $('.reverse-contact').click(function(event){
			    	if((counter)!=1){
				        var id="#repeat_contact_"+(counter).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
			    	}
			    });
			});

			jQuery(function(){
				var counter = 1;
				$('.repeat-follower').click(function(event){
					event.preventDefault();
					counter++;
					var newRow = jQuery('<div class="form-group" id="repeat_follower_' + counter + '"> <div class="col-md-6"> <div class=""> <label class="col-md-4 control-label" style="padding-left: 0;" >Task Follower</label> <div class="col-md-8"> <input type="hidden" id="follower_' + counter + '_id" name="follower[]" class="form-control" /> <input type="text" id="follower_' + counter + '" name="follower_name[]" class="form-control auto_client" placeholder="Type to choose contact..." /> </div> </div> </div> </div>');
					$('.auto_client', newRow).autocomplete(autocomp_opt);
                    $('.follower_div').append(newRow);
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
				});
			    $('.reverse-follower').click(function(event){
			    	if((counter)!=1){
				        var id="#repeat_follower_"+(counter).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
			    	}
			    });
			});
		</script>
	
        <!-- END SCRIPTS -->
    </body>
</html>