<!DOCTYPE html>
<html lang="en">
    <head>
        <title>EAT ERP</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>assets/plugins/wickedpicker/stylesheets/wickedpicker.css"/>
        
        <style>
            @media only screen and  (min-width:240px)  and (max-width:441px) { 
                .btn-top-margin {   margin:10px 18px!important;     } 
            }

            @media only screen and  (min-width:442px)  and (max-width:575px) { 
                .btn-top-margin {   margin-top:-40px!important;     } 
            }
            .panel { box-shadow:none; border:1px dotted #e7e7e7; border-top:0px solid #33414e!important;}
            .input-padding { line-height:30px;}
            @media only screen and (max-width:780px) {.input-padding { line-height:15px;}}

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
                width: 240px; 
            }
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
                background: #072c48 url("<?php echo base_url(); ?>img/scrollbar_thumb_bg.png") no-repeat center;
            }
            ::-webkit-scrollbar-thumb:horizontal {
                -webkit-border-radius: 6px;
                background: #072c48 url("<?php echo base_url(); ?>img/scrollbar_thumb_bg.png") no-repeat center;
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
    </head>
    <body>
        <div class="page-container page-navigation-top">
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2 responsive-heading"><a href="<?php echo base_url().'index.php/dashboard'; ?>">  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Task'; ?>" > Task </a>  &nbsp; &#10095; &nbsp; Task Details </div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">           
                    <div class="box-shadow custom-padding"> 
                    <form id="task_detail" role="form" class="form-horizontal" action="<?php echo base_url();?>index.php/Task/insertDetails" method="POST">
                    <div class="box-shadow-inside">
                    <div class="col-md-12" style="padding:0;" >
                    <div class="panel panel-default">
                        <input type="hidden" name="task_id" id="task_id" value="<?php if(isset($taskdetail->task_id))echo $taskdetail->task_id;?>">

                        <div class= "panel-body panel-group accordion">
                        <div class="panel-primary">

                        <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                            <div class="form-group" style="border-top:1px dotted #ddd;">
                                <div class="col-md-12">
                                    <label class="col-md-2 control-label">Subject <span  class="asterisk_sign prop_other_name"> * </span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control " name="subject_detail"  value="<?php if(isset($taskdetail->subject_detail)) {echo $taskdetail->subject_detail;}?>"placeholder="Your Task Subject Here..." required/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="col-md-2 control-label">Description <span  class="asterisk_sign prop_other_name"> * </span></label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="description" rows="2" required><?php if(isset($taskdetail->message_detail))echo $taskdetail->message_detail;?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6">
                                    <label class="col-md-4 col-sm-12 control-label" >From Date <span  class="asterisk_sign prop_other_name"> * </span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control datepicker" name="from_date" value="<?php if(isset($taskdetail->from_date)) echo date('d/m/Y',strtotime($taskdetail->from_date));?>" placeholder="From Date" required/>
                                    </div>
                                    <div class="col-md-3 col-sm-6" style="display: none;">
                                        <input type="text" class="form-control  timepickermask " name="from_time" value="<?php if(isset($taskdetail->from_time)) echo $taskdetail->from_time;?>" placeholder="From Time"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label class="col-md-4 col-sm-12 control-label">To Date</label>
                                    <div class="col-md-6 col-sm-6" >
                                        <input type="text" class="form-control datepicker" name="to_date" value="<?php if(isset($taskdetail->to_date)) echo date('d/m/Y',strtotime($taskdetail->to_date));?>" placeholder="To Date"/>
                                    </div>
                                    <div class="col-md-3 col-sm-6" style="display: none;">
                                        <input type="text" class="form-control timepickermask" name="to_time"  value="<?php if(isset($taskdetail->to_time)) echo $taskdetail->to_time;?>" placeholder="To Time"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6">
                                    <label class="col-md-4 control-label">Priority <span  class="asterisk_sign prop_other_name"> * </span></label>
                                    <div class="col-md-6"> 
                                        <select class="form-control" name="priority" required>
                                            <option value="">Select</option>
                                            <option value="Low" <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='Low') echo "selected";}?> >Low</option>
                                            <option value="Medium" <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='Medium') echo "selected";}?> > Medium</option>
                                            <option value="High" <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='High') echo "selected";}?> >High</option>
                                            <option value="Very High" <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='Very High') echo "selected";}?> >Very High</option>
                                        </select>
                                    </div>
                                </div>  
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6">                                                   
                                    <label class="col-md-4 control-label">Frequency</label>
                                    <div class="col-md-6"> 
                                            <select class="form-control" name="repeat" id="repeat">
                                              <option value="Never" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Never') echo "selected";}?> >Never</option>
                                              <option value="Daily" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Daily') echo "selected";}?> >Daily</option>
                                              <option value="Periodically" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Periodically') echo "selected";}?> >Periodically</option>
                                              <option value="Weekly" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Weekly') echo "selected";}?> >Weekly</option>
                                              <option value="Monthly" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Monthly') echo "selected";}?> >Monthly</option>
                                              <option value="Yearly" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Yearly') echo "selected";}?> >Yearly</option>                                                               
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
                                            <?php for($i=1;$i<=30;$i++){
                                                $selected='';
                                                if(isset($taskdetail->period_interval)){
                                                    if($taskdetail->repeat_status=='Periodically' && $i==$taskdetail->period_interval){
                                                        $selected='selected';
                                                    }
                                                } else {
                                                    $selected='';
                                                }
                                                echo '<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
                                            } ?>
                                        </select>
                                    </div> 
                                    <label class="control-label">  Days </label>
                                </div>
                            </div>

                            <div class="form-group" id="repeat-weekly">
                                <div class="col-md-12">
                                    <label class="col-md-2 control-label"> Interval</label>
                                    <div class="col-md-8">  
                                    <div style="padding-top:8px;">
                                        <?php $week_days=array();
                                            if(isset($taskdetail->repeat_status)){
                                                if($taskdetail->repeat_status=='Weekly'){
                                                    if(isset($taskdetail->period_interval)){
                                                        $week_days=explode(',',$taskdetail->period_interval);
                                                    }
                                                }
                                            }
                                        ?>

                                        <input type="hidden" name="weekday" value="" data-error="#weekday_error" />
                                        <input type="checkbox" name="weekly_interval[]" class="weekday" value="Mon" <?php if(in_array('Mon',$week_days)) echo "checked='checked'";?>/>&nbsp;Mon&nbsp;&nbsp;
                                        <input type="checkbox" name="weekly_interval[]" class="weekday" value="Tue" <?php if(in_array('Tue',$week_days)) echo "checked='checked'";?>/>&nbsp;Tue&nbsp;&nbsp;
                                        <input type="checkbox" name="weekly_interval[]" class="weekday" value="Wed" <?php if(in_array('Wed',$week_days)) echo "checked='checked'";?>/>&nbsp;Wed&nbsp;&nbsp;
                                        <input type="checkbox" name="weekly_interval[]" class="weekday" value="Thu" <?php if(in_array('Thu',$week_days)) echo "checked='checked'";?>/>&nbsp;Thu&nbsp;&nbsp;
                                        <input type="checkbox" name="weekly_interval[]" class="weekday" value="Fri" <?php if(in_array('Fri',$week_days)) echo "checked='checked'";?>/>&nbsp;Fri&nbsp;&nbsp;
                                        <input type="checkbox" name="weekly_interval[]" class="weekday" value="Sat" <?php if(in_array('Sat',$week_days)) echo "checked='checked'";?>/>&nbsp;Sat&nbsp;&nbsp;
                                        <input type="checkbox" name="weekly_interval[]" class="weekday" value="Sun" <?php if(in_array('Sun',$week_days)) echo "checked='checked'";?>/>&nbsp;Sun&nbsp;&nbsp;
                                        </div>
                                        <div id="weekday_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="repeat-monthly">
                                <div class="col-md-12">
                                    <label class="col-md-2 control-label"> Interval</label>
                                    <div class="col-md-4" style="margin-right:0;">
                                        <div class="col-md-9" style="margin-right:0;">
                                        <select class="form-control" name="monthly_interval">
                                            <option value="">Select</option>
                                            <?php for($i=1;$i<=12;$i++){
                                                $selected='';
                                                if(isset($taskdetail->period_interval)){
                                                    if($taskdetail->repeat_status=='Monthly' && $i==$taskdetail->period_interval){
                                                        $selected='selected';
                                                    }
                                                } else {
                                                    $selected='';
                                                }
                                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option> ';
                                            } ?>
                                        </select>
                                        </div>
                                    </div>
                                    <label class=" control-label col-md-2 ">  every month ON</label>
                                    <div class="col-md-2"> 
                                        <select class="form-control" name="monthly_interval2">
                                            <option value="">Select</option>
                                            <?php for($i=1;$i<=30;$i++){
                                                $selected='';
                                                if(isset($taskdetail->monthly_repeat)){
                                                    if($taskdetail->repeat_status=='Monthly' && $i==$taskdetail->monthly_repeat){
                                                        $selected='selected';
                                                    }
                                                } else {
                                                    $selected='';
                                                }
                                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option> ';
                                            } ?>
                                        </select>
                                    </div>
                                    <label class=" control-label col-md-2">  day of the month</label>
                                </div>
                            </div>

                            <div class="form-group" style="<?php if(!isset($taskdetail)) echo 'display: none;' ?>">
                                <div class="col-md-6 col-sm-6  ">                                                   
                                    <label class="col-md-4 control-label">Status</label>
                                    <div class="col-md-6"> 
                                        <select class="form-control" name="task_status" required>
                                              <option value="Pending" <?php if(isset($taskdetail->task_status)){ if($taskdetail->task_status=='Pending') echo "selected";}?> >Pending</option>
                                              <option value="Completed" <?php if(isset($taskdetail->task_status)){ if($taskdetail->task_status=='Completed') echo "selected";}?> >Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="col-md-4 col-sm-2 control-label">Assigned to</label>
                                        <div class="col-md-8 col-sm-8"> 
                                            <div style="padding-top:8px;">
                                                <input type="checkbox" name="self_assigned" id="self_assigned" value="self" <?php if(isset($self)) {if(count($self)>0) echo 'checked';}?>/> <label> Self </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="repeatcontact">
                                    <?php 
                                        $j=0;
                                        if(isset($editcontact)) { 
                                        for ($j=0; $j < count($editcontact) ; $j++) { 
                                    ?>
                                    <div class="form-group" id="repeat_contact_<?php echo $j;?>">
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-4 control-label">Assigned to</label>
                                                <div class="col-md-8">
                                                    <!-- <input type="hidden" id="contact_<?php //echo $j;?>_id" name="contact[]" class="form-control" value="<?php //if(isset($editcontact[$j]->user_id)){ echo $editcontact[$j]->user_id; } else { echo ''; }?>" />
                                                    <input type="text" id="contact_<?php //echo $j;?>" name="contact_name[]" class="form-control auto_client" value="<?php //if(isset($editcontact[$j]->name)){ echo $editcontact[$j]->name; } else { echo ''; }?>" placeholder="Type to choose contact..." /> -->
                                                    <select name="contact[]" class="form-control select2 assigned_to" id="contact_<?php echo $j;?>_id" data-error="#err_contact_<?php echo $j;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($users)) { for ($k=0; $k < count($users) ; $k++) { ?>
                                                            <option value="<?php echo $users[$k]->id; ?>" <?php if($users[$k]->id==$editcontact[$j]->user_id) { echo 'selected'; } ?>><?php echo $users[$k]->first_name.' '.$users[$k]->last_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_contact_<?php echo $j;?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a id="repeat_contact_<?php echo $j; ?>_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>
                                        </div>
                                    </div>
                                    <?php } } else { ?>
                                    <div class="form-group" id="repeat_contact_<?php echo $j;?>">
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-4 control-label">Assigned to</label>
                                                <div class="col-md-8">
                                                    <!-- <input type="hidden" id="contact_<?php //echo $j+1;?>_id" name="contact[]" class="form-control" value="" />
                                                    <input type="text" id="contact_<?php //echo $j+1;?>" name="contact_name[]" class="form-control auto_client" value="" placeholder="Type to choose contact..." /> -->
                                                    <select name="contact[]" class="form-control select2 assigned_to" id="contact_<?php echo $j;?>_id" data-error="#err_contact_<?php echo $j;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($users)) { for ($k=0; $k < count($users) ; $k++) { ?>
                                                            <option value="<?php echo $users[$k]->id; ?>"><?php echo $users[$k]->first_name.' '.$users[$k]->last_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_contact_<?php echo $j;?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a id="repeat_contact_<?php echo $j; ?>_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group" style="background:#fff;">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success" id="repeat-contact" style="margin-left: 10px;">+</button>
                                        <!-- <button type="button" class="btn btn-success reverse-contact" style="margin-left: 10px;">-</button> -->
                                    </div>
                                </div>
                                <div id="repeatfollower">
                                    <?php 
                                        $j=0;
                                        if(isset($editfollower)) { 
                                        for ($j=0; $j < count($editfollower) ; $j++) { 
                                    ?>
                                    <div class="form-group" id="repeat_follower_<?php echo $j;?>">
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-4 control-label">Task Follower</label>
                                                <div class="col-md-8">
                                                    <!-- <input type="hidden" id="follower_<?php //echo $j;?>_id" name="follower[]" class="form-control" value="<?php //if(isset($editfollower[$j]->user_id)){ echo $editfollower[$j]->user_id; } else { echo ''; }?>" />
                                                    <input type="text" id="follower_<?php //echo $j;?>" name="follower_name[]" class="form-control auto_client" value="<?php //if(isset($editfollower[$j]->name)){ echo $editfollower[$j]->name; } else { echo ''; }?>" placeholder="Type to choose follower..." /> -->
                                                    <select name="follower[]" class="form-control select2 task_follower" id="follower_<?php echo $j;?>_id" data-error="#err_follower_<?php echo $j;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($users)) { for ($k=0; $k < count($users) ; $k++) { ?>
                                                            <option value="<?php echo $users[$k]->id; ?>" <?php if($users[$k]->id==$editfollower[$j]->user_id) { echo 'selected'; } ?>><?php echo $users[$k]->first_name.' '.$users[$k]->last_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_follower_<?php echo $j;?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a id="repeat_follower_<?php echo $j; ?>_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>
                                        </div>
                                    </div>
                                    <?php } } else { ?>
                                    <div class="form-group" id="repeat_follower_<?php echo $j;?>">
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-4 control-label">Task Follower</label>
                                                <div class="col-md-8">
                                                    <!-- <input type="hidden" id="follower_<?php //echo $j+1;?>_id" name="follower[]" class="form-control" value="" />
                                                    <input type="text" id="follower_<?php //echo $j+1;?>" name="follower_name[]" class="form-control auto_client" value="" placeholder="Type to choose follower..." /> -->
                                                    <select name="follower[]" class="form-control select2 task_follower" id="follower_<?php echo $j;?>_id" data-error="#err_follower_<?php echo $j;?>">
                                                        <option value="">Select</option>
                                                        <?php if(isset($users)) { for ($k=0; $k < count($users) ; $k++) { ?>
                                                            <option value="<?php echo $users[$k]->id; ?>"><?php echo $users[$k]->first_name.' '.$users[$k]->last_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_follower_<?php echo $j;?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a id="repeat_follower_<?php echo $j; ?>_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group" style="background:#fff;">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success" id="repeat-follower" style="margin-left: 10px;">+</button>
                                        <!-- <button type="button" class="btn btn-success reverse-follower" style="margin-left: 10px;">-</button> -->
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="col-md-2 control-label">Remark <span  class="asterisk_sign prop_other_name"> * </span></label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="maker_remark" name="maker_remark" rows="2"><?php if(isset($taskdetail->message_detail))echo $taskdetail->maker_remark;?></textarea>
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
                        <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/task">Cancel</a>
                        <button class="btn  pull-right btn-success" type="submit">Save</button>
                    </div>
                    </form>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/wickedpicker/src/wickedpicker.js"></script>
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
                var counter = $('.assigned_to').length;

                $('#repeat-contact').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<div class="form-group" id="repeat_contact_'+counter+'">'+
                                            '<div class="col-md-6">'+
                                                '<div class="">'+
                                                    '<label class="col-md-4 control-label">Assigned to</label>'+
                                                    '<div class="col-md-8">'+
                                                        '<select name="contact[]" class="form-control select2 assigned_to" id="contact_'+counter+'_id" data-error="#err_contact_'+counter+'">'+
                                                            '<option value="">Select</option>'+
                                                            '<?php if(isset($users)) { for ($k=0; $k < count($users) ; $k++) { ?>'+
                                                                '<option value="<?php echo $users[$k]->id; ?>"><?php echo $users[$k]->first_name.' '.$users[$k]->last_name; ?></option>'+
                                                            '<?php }} ?>'+
                                                        '</select>'+
                                                        '<div id="err_contact_'+counter+'"></div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="col-md-2">'+
                                                '<a id="repeat_contact_'+counter+'_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                            '</div>'+
                                        '</div>');
                    $('#repeatcontact').append(newRow);
                    $('.select2').select2();
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });

                    counter++;
                });
            });
            jQuery(function(){
                var counter = $('.task_follower').length;

                $('#repeat-follower').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<div class="form-group" id="repeat_follower_'+counter+'">'+
                                            '<div class="col-md-6">'+
                                                '<div class="">'+
                                                    '<label class="col-md-4 control-label">Task Follower</label>'+
                                                    '<div class="col-md-8">'+
                                                        '<select name="follower[]" class="form-control select2 task_follower" id="follower_'+counter+'_id" data-error="#err_follower_'+counter+'">'+
                                                            '<option value="">Select</option>'+
                                                            '<?php if(isset($users)) { for ($k=0; $k < count($users) ; $k++) { ?>'+
                                                                '<option value="<?php echo $users[$k]->id; ?>"><?php echo $users[$k]->first_name.' '.$users[$k]->last_name; ?></option>'+
                                                            '<?php }} ?>'+
                                                        '</select>'+
                                                        '<div id="err_follower_'+counter+'"></div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="col-md-2">'+
                                                '<a id="repeat_follower_'+counter+'_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>'+
                                            '</div>'+
                                        '</div>');
                    $('#repeatfollower').append(newRow);
                    $('.select2').select2();
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });

                    counter++;
                });
            });
        </script>
    </body>
</html>