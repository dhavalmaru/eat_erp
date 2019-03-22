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
        <style>
            #document_details { padding:0;}
            .lineheight { line-height:30px}
            @media only screen and (max-width:767px) { .btn-margin {    padding:15px 15px!important; }}
            @media only screen and (min-width: 767px) and (max-width: 1020px)  {
                .col-md-2 .col-md-3 {   }
            }
        </style>
    </head>
    <body>
        <div class="page-container page-navigation-top">            
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Upload Details </div>
                <div class="container">
                    <?php if($this->session->flashdata('error')){ ?>
                    <div class="alert alert-danger alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error On Line! </strong> 
                        <?php echo rtrim($this->session->flashdata('error'),',');?>
                    </div>  
                    <?php } ?>
                </div>
                <div class="page-content-wrap">
                <div class="row main-wrapper">
				<div class="main-container">           
                <div class="box-shadow">
                    <form id="form_attendance_upload" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/attendance/upload_file'; ?>">
                    <div class="box-shadow-inside">
                    <div class="col-md-12 custom-padding" style="padding:0;" >
                    <div class="panel panel-default">								
					<div class="panel-body">
                        <div class="form-group"  >
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="col-md-4 col-sm-4 col-xs-12 control-label">Select File <span class="asterisk_sign"></span></label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <input type="file" class="fileinput btn btn-info btn-small  bar_image" name="upload" id="image" placeholder="image" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
					<br clear="all"/> 
					</div>
					</div>
                    <div class="panel-footer">
                        <a href="<?php echo base_url(); ?>index.php/sales_rep" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                        <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
    </body>
</html>