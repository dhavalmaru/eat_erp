<!DOCTYPE html>
<html lang="en">
  <head>
    <title>EAT ERP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>
    <style> 
      @media only screen and  (min-width:645px)  and (max-width:718px) { 
        .heading-h3-heading:first-child {     width: 44%!important;}
        .heading-h3-heading:last-child {     width: 56%!important;}		
        .heading-h3-heading .btn-margin{ margin-bottom:0px!important; }
      }
      @media only screen and  (min-width:709px)  and (max-width:718px) { 			 
        .heading-h3-heading .btn-margin{   }
      }
      .alert {
        padding:5px;
        border-radius:0px;
      }
      .alert-dismissable .close, .alert-dismissible .close {
        position: relative;
        top: -2px;
        right: 0px;
        color: #fff;
        opacity: 1!important;
      }
    </style>	
  </head>
  <body>
    <div class="page-container page-navigation-top">
      <?php $this->load->view('templates/menus');?>
      <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
        <div class="heading-h3">
          <div class="heading-h3-heading mobile-head">
            <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; PDF Upload
          </div>
				  <div class="heading-h3-heading mobile-head">
					  <div class="pull-right btn-margin">
              <div class="btn-group pull-right">
                  <?php if(isset($access)) { if($access[0]->r_export == 1) { ?>
                      <button class="btn btn-danger btn-padding dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> &nbsp;Download</button>
                      <ul class="dropdown-menu">
                          <li><a href="#" onClick ="$('#customers10').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                          <li><a href="#" onClick ="$('#customers10').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                      </ul>
                  <?php } } ?>
              </div>
              <a class="btn btn-success m-r-5" data-toggle="modal" href="#myModal">
                <span class="fa fa-file-pdf-o"></span> Upload PDF
              </a>
						</div>
          </div>	      
        </div>
        <div class="container">
          <?php if($this->session->flashdata('error')){?>
          <div class="alert alert-danger alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong style="display: block;">Error! </strong>
            <?php echo rtrim($this->session->flashdata('error'),',');?>
          </div>
          <?php } ?>
          <?php if($this->session->flashdata('success')){?>
          <div class="alert alert-success alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong style="display: block;">Success! </strong>
            <?php echo rtrim($this->session->flashdata('success'),',');?>
          </div>
          <?php } ?>
        </div>
        <div class="modal fade" id="myModal" role="dialog" style="">
          <div class="modal-dialog">
            <div class="modal-content" style="">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                  Upload PDF File
                </h4>
              </div>
              <form method="POST" action="<?php echo base_url();?>index.php/Pdf_upload/upload_file" class="form-horizontal excelform" enctype="multipart/form-data">
                <div class="modal-body">
                  <div class="form-group">

                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">Add PDF <span class="asterisk_sign"></span></label>

                    <input type="file" class="fileinput btn btn-info btn-small  bar_image" name="upload" id="image" placeholder="image" value=""/>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-success pull-right" id="btn_upload" value="Upload" style="display: none;" />
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
          <div class="row">
            <div class="page-width">
              <div class="col-md-12">
                <div class="panel panel-default">   
                  <div class="panel-body">
                    <div class="table-responsive">
                      <table id="customers10" class="table datatable table-bordered" style="width: 1300px;">
                        <thead>
                          <tr>
                            <th width="50" style="text-align:center;">Sr No</th>
                            <th width="50">Upload Date</th>
                            <th width="50">File Name</th>
                            <th width="35">Status</th>
                            <th width="35">Remarks</th>
                            <th width="50">Original File</th>
                            <th width="50">Check File</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          if(isset($data)) {
                            for ($i=0; $i < count($data); $i++) { 
                          ?>
                            <tr>
                              <td style="text-align:center;"><?php echo $i+1; ?></td>
                              <td>
                                <span style="display:none;">
                                  <?php echo (($data[$i]->upload_date!=null && $data[$i]->upload_date!='')?date('Ymd',strtotime($data[$i]->upload_date)):''); ?>
                                </span>
                                <?php echo (($data[$i]->upload_date!=null && $data[$i]->upload_date!='')?date('d/m/Y',strtotime($data[$i]->upload_date)):''); ?>
                              </td>
                              <td><?php echo $data[$i]->file_name; ?></td>
                              <td><?php echo $data[$i]->status; ?></td>
                              <td><?php echo $data[$i]->remarks; ?></td>
                              <td>
                                <a href="<?php echo base_url().'assets/uploads/pdf_upload/'.$data[$i]->file_name;?>" target="_blank">
                                  <span class="fa fa-download" style="font-size:20px;"></span>
                                </a>
                              </td>
                              <td>
                                <?php if($data[$i]->check_file_name!=null && $data[$i]->check_file_name!=''){ ?>
                                <a href="<?php echo base_url().'assets/uploads/pdf_upload/'.$data[$i]->check_file_name;?>" target="_blank">
                                  <span class="fa fa-download" style="font-size:20px;"></span>
                                </a>
                                <?php } ?>
                              </td>
                            </tr>
                          <?php }} ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
      </div>
    </div>
						
    <?php $this->load->view('templates/footer');?>

    <script type="text/javascript">
      // $(document).on('submit','form.excelform',function(){
      //   setTimeout(function(){ 
      //     document.location.reload();
      //   }, 5000);
      // });
    </script>
		<script>
      $('#image').change(function(){
        setTimeout(function(){ $('#btn_upload').show(); }, 3000);
      });

      $(document).ready(function() {
        var BASE_URL = "<?php echo base_url()?>";
        var url = window.location.href;
        
        var len = 10;
        var columnDefs = [];

        
        columnDefs = [    
                        // {
                        //     "targets": [0],
                        //     "searchable": false
                        // }, 
                        { className: "dt-body-center", targets: [ 0,5,6 ] },
                        // { className: "text-right", targets: [ 7 ] }
                    ];

        $('#customers10').DataTable({
            // "pageLength" : 10,
            "bProcessing": true,
            "searchDelay": 3000,
            "serverSide": true,
            "columnDefs": columnDefs,
            "iDisplayLength": len,
            aLengthMenu: [
                            [10,25, 50, 100, 200, -1],
                            [10,25, 50, 100, 200, "All"]
                        ],
            "ajax":{
                    url : BASE_URL+'index.php/Pdf_upload/get_data/'+status,
                    type: "post",
                    async: false,
                    data: function(data) {       
                        data.status = status;
                    },
                    "dataSrc": function ( json ) {
                        return json.data;
                    },
                    // error: function() {
                    //     $(table+"_processing").css("display","none");
                    // }
                }
        });
        
        $("#csv").click(function(){
            table.DataTable().destroy();
            tableOptions.bPaginate = false;
            table.DataTable(tableOptions);
            table.tableExport({type:'csv',escape:'false'});
            table.DataTable().destroy();
            tableOptions.bPaginate = true;
            table.DataTable(tableOptions);
        });
        $("#xls").click(function(){
            table.DataTable().destroy();
            tableOptions.bPaginate = false;
            table.DataTable(tableOptions);
            table.tableExport({type:'excel',escape:'false'});
            table.DataTable().destroy();
            tableOptions.bPaginate = true;
            table.DataTable(tableOptions);
        });
        $("#txt").click(function(){
            table.DataTable().destroy();
            tableOptions.bPaginate = false;
            table.DataTable(tableOptions);
            table.tableExport({type:'txt',escape:'false'});
            table.DataTable().destroy();
            tableOptions.bPaginate = true;
            table.DataTable(tableOptions);
        });
        $("#doc").click(function(){
            table.DataTable().destroy();
            tableOptions.bPaginate = false;
            table.DataTable(tableOptions);
            table.tableExport({type:'doc',escape:'false'});
            table.DataTable().destroy();
            tableOptions.bPaginate = true;
            table.DataTable(tableOptions);
        });
        $("#powerpoint").click(function(){
            table.DataTable().destroy();
            tableOptions.bPaginate = false;
            table.DataTable(tableOptions);
            table.tableExport({type:'powerpoint',escape:'false'});
            table.DataTable().destroy();
            tableOptions.bPaginate = true;
            table.DataTable(tableOptions);
        });
        $("#png").click(function(){
            table.DataTable().destroy();
            tableOptions.bPaginate = false;
            table.DataTable(tableOptions);
            table.tableExport({type:'png',escape:'false'});
            table.DataTable().destroy();
            tableOptions.bPaginate = true;
            table.DataTable(tableOptions);
        });
        $("#pdf").click(function(){
            table.DataTable().destroy();
            tableOptions.bPaginate = false;
            table.DataTable(tableOptions);
            table.tableExport({type:'pdf',escape:'false'});
            table.DataTable().destroy();
            tableOptions.bPaginate = true;
            table.DataTable(tableOptions);
        });
      });
    </script>
  </body>
</html>