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
                <div class="pull-right btn-top-margin responsive-margin">
                    <!--<a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> -->
                    <a class="btn-margin"  href="<?php echo base_url(); ?>index.php/task/task_edit/<?php echo $taskdetail->id;?>"  ><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>
                    <a class="btn-margin" href="<?php echo base_url()?>index.php/task"> <span class="btn btn-danger pull-right btn-font" style="margin-right: 10px;"> Cancel </span>  </a> 
                </div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">           
                    <div class="box-shadow custom-padding"> 
                    <!-- <form id="task_detail" role="form" class="form-horizontal" action="<?php //echo base_url();?>index.php/Task/insertDetails" method="POST"> -->
                    <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
                    <div class="box-shadow-inside">
                    <div class="col-md-12" style="padding:0;" >
                    <div class="panel panel-default">
                        <input type="hidden" name="task_id" id="task_id" value="<?php if(isset($taskdetail->task_id))echo $taskdetail->task_id;?>">

                        <div class= "panel-body panel-group accordion">
                        <div class="panel-primary">

                        <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                            <?php if(count($taskdetail) > 0 ){?>
                            <div class="form-group" style="border-top:0px dotted #ddd;">
                                <div class="col-md-12" >
                                    <label class="col-md-1 control-label"><strong>Subject: </strong></label>
                                    <div class="col-md-11">
                                        <label class=" control-label box-border" style="text-align:left;"> <?php echo $taskdetail->subject_detail;?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="col-md-1 control-label"><strong>Description: </strong></label>
                                    <div class="col-md-11">
                                        <label class="col-md-12 control-label box-border" style="text-align:left;"><?php echo $taskdetail->message_detail;?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="col-md-2 col-sm-4 col-xs-12 col-sm-4 col-xs-12 control-label"><strong>Status: </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->task_status;?></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Priority: </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->priority;?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>From Date: </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <label class=" control-label box-border" style="text-align:left;"> <?php echo date('d/m/Y',strtotime($taskdetail->from_date)).'  '.$taskdetail->from_time;?></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>To Date: </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <label class=" control-label box-border" style="text-align:left;"> <?php echo date('d/m/Y',strtotime($taskdetail->to_date)).'  '.$taskdetail->to_time;?></label>
                                    </div>
                                </div>   
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Frequency: </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->repeat_status;?></label>
                                    </div>
                                </div>
                            </div>

                            <?php if($taskdetail->repeat_status=='Periodically'){?>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Interval: </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <label class="control-label box-border" style="text-align:left;"><?php echo $taskdetail->period_interval;?> <span>Days after completion</span></label>
                                    </div>
                                </div>
                            </div>
                            <?php } if($taskdetail->repeat_status=='Weekly'){?>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Interval: </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <label class=" control-label box-border" style="text-align:left;"> <?php echo $taskdetail->period_interval;?> </label>
                                    </div>
                                </div>
                            </div>
                            <?php } if($taskdetail->repeat_status=='Monthly'){?>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="col-md-1 control-label"><strong>Interval: </strong></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->period_interval;?><span> every month ON </span> <?php echo $taskdetail->monthly_repeat;?> <span> day of the month</span> </label>                         
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php if($taskdetail->follower == 'No'){ ?>
                                    <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Assigned to: </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <label class=" control-label box-border" style="text-align:left;"><?php if($taskdetail->name=='') { echo 'Self'; } else { echo $taskdetail->name; }?></label>
                                    </div>
                                    <?php } else { ?>
                                    <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Followed By : </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12">
                                        <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->name;?></label>
                                    </div>
                                   <?php  } ?>
                                </div>
                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Maker Remark: </strong></label>
                                    <div class="col-md-10 col-sm-8 col-xs-12"> 
                                        <label class="  control-label box-border" style="text-align:left;"><?php echo $taskdetail->maker_remark;?></label>
                                    </div>
                                </div> 
                            </div>

                            <?php if(isset($comment)) { 
                                 echo '<div class="form-group" style="padding:0; ">
                                      <div class="task-heading" > <label class="control-label "><strong>Task Comment : </strong></label></div>';

                                foreach($comment as $row){ ?>
                           
                                <div class="col-md-12" style="padding-bottom:10px;">
                                    <label class="col-md-1 control-label"><?php echo ucfirst($row->name);?>: </label>
                                    <div class="col-md-11">
                                        <label class=" control-label box-border" style="text-align:left;"><?php echo $row->comment;?></label>
                                    </div>
                                </div>
                            <?php } 
                                echo '</div>'; } ?>

                            <div class="form-group" style="border-top:0px dotted #ddd; padding:0;">
                                <div class="task-heading" > <label class="control-label " style="padding:0;"><strong>Comments: </strong></label></div>  
                                <!---   <label class="col-md-1 control-label"><strong> Comments </strong></label>-->
                                <div class="comment-section"  style="padding-bottom:10px; display:flex">
                                    <div class="col-md-12">
                                        <textarea id="follower_comment_id" name="follower_comment" class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="" >
                                <div class="col-md-12 btn-container"  style=" background: #fcfdfd;" >   
                                    <button id="cooment" class="btn btn-success pull-left" type="button"   onclick="addComment('<?php echo $taskdetail->id;?>')">Comment</button>                                           
                                    <button id="delete_btn" class="btn btn-danger pull-right" type="button" onclick="deleteRecord('<?php echo $taskdetail->id;?>')">Delete</button>
                                    <?php if($taskdetail->follower !='Yes'){?>  
                                    <button id="complete_btn" class="btn pull-right btn-success" type="button" onclick="completeTask('<?php echo $taskdetail->id;?>')" style="margin-right: 10px;">Complete</button>
                                    <?php } ?>  
                                </div>
                            </div>
                          
                            <?php } else {?>
                            <div class="form-group" style="border-top:1px dotted #ddd;">
                                <div class="col-md-12" style="text-align:center;" >
                                    <label class=" control-label"><strong>No Record Found </strong></label>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <br clear="all"/>

                        </div>
                        </div>
                    </div>
                    </div>
                    <br clear="all"/>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/tasks.js"></script>
    </body>
</html>