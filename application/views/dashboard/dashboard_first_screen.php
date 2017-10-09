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
            #map {
                height: 100%;
            }
        </style>
    </head>
    <body>

        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
        <!-- PAGE CONTENT -->
        <?php $this->load->view('templates/menus');?>
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
        <div class="heading-h2">  Dashboard </div>
        
        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="row main-wrapper">
                <div class="main-container">           
                    <div class="box-shadow">
                        <div class="box-shadow-inside">
                        <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                    <div class="col-md-4 col-sm-4 col-xs-4"></div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <span class="fa fa-retweet fa-5x"></span>
                                        </div>
                                        <span class="col-md-8 col-sm-8 col-xs-12">Dashboard </span>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4"></div>
                            </div>
                            </div>
                            <br clear="all"/>
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
        <!-- END SCRIPTS -->      
    </body>
</html>