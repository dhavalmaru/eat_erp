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
		
    </head>
    <body>								
         <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2">
				   <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Emp_master'; ?>" > Employee List </a>  &nbsp; &#10095; &nbsp; Employee Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">
                
                    <div class="row main-wrapper">
					<div class="main-container">           
                         <div class="box-shadow"> 
							
                            <form id="form_emp_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/Emp_master/update/' . $data[0]->id; else echo base_url().'index.php/Emp_master/save'; ?>">	
							<div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">							
								
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Offer_letter_id </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control" name="offer_letter_id" id="offer_letter_id" placeholder="offer_letter_id" value="<?php if(isset($data)) echo $data[0]->offer_letter_id;?>"/>
                                            </div>
                                             <label class="col-md-2 col-sm-2 col-xs-12 control-label">acceptance_id</label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="acceptance_id" placeholder="acceptance_id" value="<?php if(isset($data)) echo $data[0]->acceptance_id;?>"/>
                                            </div>
										</div>
									</div>
                                    <div class="form-group" >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">emp_id </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="emp_id" id="emp_id" placeholder="emp_id" value="<?php if(isset($data)) { echo  $data[0]->emp_id; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">emp_code </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="emp_code" id="emp_code" placeholder="emp_code" value="<?php if(isset($data)) { echo $data[0]->emp_code; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">salutation </label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="salutation" placeholder="salutation" value="<?php if (isset($data)) { echo $data[0]->salutation; } ?>"/>
                                            </div>
                                             <label class="col-md-2 col-sm-2 col-xs-12 control-label">first_name </label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="first_name" placeholder="first_name" value="<?php if (isset($data)) { echo $data[0]->first_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">middle_name </label>
                                              <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="middle_name" placeholder="middle_name" value="<?php if (isset($data)) { echo $data[0]->middle_name; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">last_name</label>
                                              <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="last_name" placeholder="last_name" value="<?php if (isset($data)) { echo $data[0]->last_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">gender </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="gender" placeholder="gender" value="<?php if (isset($data)) { echo $data[0]->gender; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">blood_group </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="blood_group" placeholder="blood_group" value="<?php if (isset($data)) { echo $data[0]->blood_group; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">marital_status </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="marital_status" placeholder="marital_status" value="<?php if (isset($data)) { echo $data[0]->marital_status; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">date_of_birth </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control datepicker" name="date_of_birth" placeholder="date_of_birth" value="<?php if (isset($data)) { echo $data[0]->date_of_birth; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">dob_as_per_aadhar </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control datepicker" name="dob_as_per_aadhar" placeholder="dob_as_per_aadhar" value="<?php if (isset($data)) { echo $data[0]->dob_as_per_aadhar; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">pan_no </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="pan_no" placeholder="pan_no" value="<?php if (isset($data)) { echo $data[0]->pan_no; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">aadhar_card_no </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="aadhar_card_no" placeholder="aadhar_card_no" value="<?php if (isset($data)) { echo $data[0]->aadhar_card_no; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">permanant_address1 </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="permanant_address1" placeholder="permanant_address1" value="<?php if (isset($data)) { echo $data[0]->permanant_address1; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">permanant_address2 </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="permanant_address2" placeholder="permanant_address2" value="<?php if (isset($data)) { echo $data[0]->permanant_address2; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">permanant_address3 </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="permanant_address3" placeholder="permanant_address3" value="<?php if (isset($data)) { echo $data[0]->permanant_address3; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">station </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="station" placeholder="station" value="<?php if (isset($data)) { echo $data[0]->station; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">city </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="city" placeholder="city" value="<?php if (isset($data)) { echo $data[0]->city; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">pincode </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="pincode" placeholder="pincode" value="<?php if (isset($data)) { echo $data[0]->pincode; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">state </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="state" placeholder="state" value="<?php if (isset($data)) { echo $data[0]->state; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">country </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="country" placeholder="country" value="<?php if (isset($data)) { echo $data[0]->country; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">mobile_no </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="mobile_no" placeholder="mobile_no" value="<?php if (isset($data)) { echo $data[0]->mobile_no; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">personal_email_id </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="personal_email_id" placeholder="personal_email_id" value="<?php if (isset($data)) { echo $data[0]->personal_email_id; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">present_address1 </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="present_address1" placeholder="present_address1" value="<?php if (isset($data)) { echo $data[0]->present_address1; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">present_address2 </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="present_address2" placeholder="present_address2" value="<?php if (isset($data)) { echo $data[0]->present_address2; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">present_address3 </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="present_address3" placeholder="present_address3" value="<?php if (isset($data)) { echo $data[0]->present_address3; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">present_station </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="present_station" placeholder="present_station" value="<?php if (isset($data)) { echo $data[0]->present_station; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">present_city </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="present_city" placeholder="present_city" value="<?php if (isset($data)) { echo $data[0]->present_city; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">present_state </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="present_state" placeholder="present_state" value="<?php if (isset($data)) { echo $data[0]->present_state; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">present_country </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="present_country" placeholder="present_country" value="<?php if (isset($data)) { echo $data[0]->present_country; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">present_pincode </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="present_pincode" placeholder="present_pincode" value="<?php if (isset($data)) { echo $data[0]->present_pincode; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">father_title </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="father_title" placeholder="father_title" value="<?php if (isset($data)) { echo $data[0]->father_title; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">father_name </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="father_name" placeholder="father_name" value="<?php if (isset($data)) { echo $data[0]->father_name; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">spouse_title </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="spouse_title" placeholder="spouse_title" value="<?php if (isset($data)) { echo $data[0]->spouse_title; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">spouse_name </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="spouse_name" placeholder="spouse_name" value="<?php if (isset($data)) { echo $data[0]->spouse_name; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">dob_of_spouse </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control datepicker" name="dob_of_spouse" placeholder="dob_of_spouse" value="<?php if (isset($data)) { echo $data[0]->dob_of_spouse; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">kids_name </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="kids_name" placeholder="kids_name" value="<?php if (isset($data)) { echo $data[0]->kids_name; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">dob_of_kids </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control datepicker" name="dob_of_kids" placeholder="dob_of_kids" value="<?php if (isset($data)) { echo $data[0]->dob_of_kids; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">ctc </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="ctc" placeholder="ctc" value="<?php if (isset($data)) { echo $data[0]->ctc; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">basic </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="basic" placeholder="basic" value="<?php if (isset($data)) { echo $data[0]->basic; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">hra </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="hra" placeholder="hra" value="<?php if (isset($data)) { echo $data[0]->hra; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">conveyance </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="conveyance" placeholder="conveyance" value="<?php if (isset($data)) { echo $data[0]->conveyance; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">medical_reimb </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="medical_reimb" placeholder="medical_reimb" value="<?php if (isset($data)) { echo $data[0]->medical_reimb; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">vehicle_reimb </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="vehicle_reimb" placeholder="vehicle_reimb" value="<?php if (isset($data)) { echo $data[0]->vehicle_reimb; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">city_comp </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="city_comp" placeholder="city_comp" value="<?php if (isset($data)) { echo $data[0]->city_comp; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">employee_pf </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="employee_pf" placeholder="employee_pf" value="<?php if (isset($data)) { echo $data[0]->employee_pf; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">employee_esic </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="employee_esic" placeholder="employee_esic" value="<?php if (isset($data)) { echo $data[0]->employee_esic; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">date_of_joining </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control datepicker" name="date_of_joining" placeholder="date_of_joining" value="<?php if (isset($data)) { echo $data[0]->date_of_joining; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">months </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="months" placeholder="months" value="<?php if (isset($data)) { echo $data[0]->months; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">reporting_manager </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="reporting_manager" placeholder="reporting_manager" value="<?php if (isset($data)) { echo $data[0]->reporting_manager; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">emp_no_of_reporting_manager </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="emp_no_of_reporting_manager" placeholder="emp_no_of_reporting_manager" value="<?php if (isset($data)) { echo $data[0]->emp_no_of_reporting_manager; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">official_email </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="official_email" placeholder="official_email" value="<?php if (isset($data)) { echo $data[0]->official_email; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">hod </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="hod" placeholder="hod" value="<?php if (isset($data)) { echo $data[0]->hod; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">division </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="division" placeholder="division" value="<?php if (isset($data)) { echo $data[0]->division; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">location </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="location" placeholder="location" value="<?php if (isset($data)) { echo $data[0]->location; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">branch </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="branch" placeholder="branch" value="<?php if (isset($data)) { echo $data[0]->branch; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">grade </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="grade" placeholder="grade" value="<?php if (isset($data)) { echo $data[0]->grade; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">designation </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="designation" placeholder="designation" value="<?php if (isset($data)) { echo $data[0]->designation; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">department </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="department" placeholder="department" value="<?php if (isset($data)) { echo $data[0]->department; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">sub_department </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="sub_department" placeholder="sub_department" value="<?php if (isset($data)) { echo $data[0]->sub_department; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">esic_med </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="esic_med" placeholder="esic_med" value="<?php if (isset($data)) { echo $data[0]->esic_med; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">esic_med_no </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="esic_med_no" placeholder="esic_med_no" value="<?php if (isset($data)) { echo $data[0]->esic_med_no; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">pf_no </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="pf_no" placeholder="pf_no" value="<?php if (isset($data)) { echo $data[0]->pf_no; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">uan </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="uan" placeholder="uan" value="<?php if (isset($data)) { echo $data[0]->uan; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">confirmation_date </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control datepicker" name="confirmation_date" placeholder="confirmation_date" value="<?php if (isset($data)) { echo $data[0]->confirmation_date; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">date_of_resignation </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control datepicker" name="date_of_resignation" placeholder="date_of_resignation" value="<?php if (isset($data)) { echo $data[0]->date_of_resignation; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">last_working_date </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control datepicker" name="last_working_date" placeholder="last_working_date" value="<?php if (isset($data)) { echo $data[0]->last_working_date; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">ta_ra </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="ta_ra" placeholder="ta_ra" value="<?php if (isset($data)) { echo $data[0]->ta_ra; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <div style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                                 <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status </label>
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
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                            <div class="col-md-10 col-sm-10 col-xs-12">
                                              <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                            </div>
                                        </div>
                                    </div>
									
                                </div>
                                  </div>
									<br clear="all"/>
									</div>
									</div>
								
								
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/emp_master" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
							</form>
							
						</div>
						</div>
						
					 </div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
           
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

    <!-- END SCRIPTS -->      
    </body>
</html>