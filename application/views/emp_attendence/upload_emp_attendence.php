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
        <!-- START PAGE CONTAINER -->
           <div class="page-container page-navigation-top">            
              <!-- PAGE CONTENT -->
           <?php $this->load->view('templates/menus');?>
                <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Eat_Attendence'; ?>" > Attendence List </a>  &nbsp; &#10095; &nbsp; Attendence List</div>
                  
                  <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">
                      <div class="row main-wrapper">
                <div class="main-container">           
                 <div class="box-shadow">
                 
                      <div class="box-shadow-inside">
                        <div class="col-md-12 custom-padding" style="padding:0;" >
                        <form id="form_area_details" role="form" 
                            class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url().'index.php/Eat_Attendence/update/' ?>" enctype="multipart/form-data">
                            <div class="panel panel-default">
                              <div class="panel-body">
                                  <div class="form-group">
                                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">Add Excel <span class="asterisk_sign"></span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                      <input type="file" class="fileinput btn btn-info btn-small  bar_image" name="upload" id="image" placeholder="image" value="" style="left: -235.656px; top: 8px;">
                                    </div>
                                 </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                  <div class="form-group">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Select Year <span class="asterisk_sign">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                       <select name="freezed_year" class="form-control" id="freezed_year" onchange="get_data(this)" >
                                         <option value="">Select</option>
                                          <?php 
                                            $date = date("Y");
                                            echo '<option value="'.$date.'" selected>'.$date.'</option>';
                                          ?>
                                      </select>
                                    </div>
                                 </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                  <div class="form-group">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Select Month <span class="asterisk_sign">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                       <select name="month" class="form-control" id="month" onchange="get_data(this)" >
                                         <option value="">Select</option>
                                         <?php
                                          for ($m=1; $m<=12; $m++) {
                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));

                                            echo '<option value="'.$month.'" >'.$month.'</option>';
                                          }
         
                                        ?>
                                      </select>
                                    </div>
                                 </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                  <div class="form-group">
                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Select Employee <span class="asterisk_sign">*</span></label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                       <select name="employee" class="form-control" id="employee" >
                                        <option value="">Select</option>
                                        <?php 
                                          foreach ($employee as $emp) {
                                            echo "<option value=".$emp->emp_code.">".$emp->first_name.'-'.$emp->last_name."</option>";
                                          }
                                        ?>
                                      </select>
                                    </div>
                                 </div>
                                </div>
                              </div>
                            </div>
                            <div class="panel-footer">
                              <a href="<?php echo base_url(); ?>index.php/Eat_Attendence" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                              <button class="btn btn-success pull-right" >Save</button>
                            </div>
                        </form>
                        </div>
            
                      </div>
                  <!-- END PAGE CONTENT WRAPPER -->
                 </div>            
              <!-- END PAGE CONTENT -->
              </div>
          <!-- END PAGE CONTAINER -->
       </div> 
  </div>     
          <?php $this->load->view('templates/footer');?>
          <script type="text/javascript">
              var BASE_URL="<?php echo base_url()?>";
          </script>
          <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
          <script type="text/javascript">
      var Base_url = '<?=base_url();?>';
      const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                  ];

      var d = new Date();
      var current_month = monthNames[d.getMonth()];
      var current_year = d.getFullYear();
      $(document).ready(function()
      {
        get_data();
        /*$('#copy').on('click',function(){         
          var r = confirm("Do you want ot change the sequence permenant??");
          if (r == true) {
            var  mer = $('#merchendizer_route_plan').html();
            $('#admin_route_plan').html('');
            $('#admin_route_plan').html(mer);
             var ispermenant = "Yes";
            $('#ispermenant').val(ispermenant);
          } else {
            
          }
        });*/
       });

      function get_data() {
        var frezval = $('#freezed_year').val();
        if(frezval!="")
        {
            var length = $('#month > option').length;
            var month = document.getElementById('month');
            if(frezval=='2018')
            {
              var getid;
              for (var i = 0; i < length; i++) {
                months = month[i];

                console.log('months-value'+months.value);
                if(months.value==current_month)
                {
                   getid = i;
                   $("#month option[value='"+months.value+"']").hide();
                }
                if(getid<i)
                {
                  $("#month option[value='"+months.value+"']").hide();
                }
              }
            }
            else
            {
              for (var i = 0; i < length; i++) {
                months = month[i];
                $("#month option[value='"+months.value+"']").show();
              }
            }
        }
        
      }
    </script>
  </html>