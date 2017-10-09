<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>EAT ERP</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                     
    </head>
    <body>
        
        <div class="login-container lightmode">
        
            <div class="login-box animated fadeInDown">
                <div class="login-logo" style="height: 70px; text-align:center; background:#fff; margin:0;"><img src="<?php echo base_url().'img/logo.png'; ?>"/></div>
                <div class="login-body">
                    <div class="login-title"><strong>Log In</strong> to your account</div>
                    <form id="form_login" action="<?php echo base_url().'index.php/login/check_credentials'; ?>" class="form-horizontal" method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="E-mail" name="email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Password" name="password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <!-- <a href="<?php //echo base_url().'index.php/login/password_email'; ?>" class="btn btn-link btn-block">Forgot your password?</a> -->
                                <span class="btn btn-link btn-block" id="forgot_password">Forgot your password?</span>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-info btn-block">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        &copy; 2016 Wholesome Habits Pvt Ltd
                    </div>
                    <!-- <div class="pull-right">
                        <a href="#">About</a> |
                        <a href="#">Privacy</a> |
                        <a href="#">Contact Us</a>
                    </div> -->
                </div>
            </div>
            
        </div>
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS-->
        
        <script>
            $("#forgot_password").click(function(){
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/Login/forgot_password_email' ?>",
                    data: $("#form_login").serialize(),
                    cache: false,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                       alert(data);
                    },
                    error: function (data) {
                       alert(data);
                    }
                });
            });
        </script>
    </body>
</html>






