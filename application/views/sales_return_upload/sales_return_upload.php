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
            <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Sales Return Upload
          </div>
				  <div class="heading-h3-heading mobile-head">
					  <div class="pull-right btn-margin">
              <?php $this->load->view('templates/download');?>
              <a class="btn btn-default-danger pull-right " style="margin:0px 8px!important;" href="<?php echo base_url().'index.php/Sales_return_upload/download_upload_format'; ?>" >
                <i class="fa fa-file-excel-o "></i> Download Sample
              </a>
              <a class="btn btn-success" data-toggle="modal" href="#myModal">
                <span class="fa fa-file-excel-o"></span> Upload Excel
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
                  Upload Sales Return Entries
                </h4>
              </div>
              <form method="POST" action="<?php echo base_url();?>index.php/Sales_return_upload/upload_file" class="form-horizontal excelform" enctype="multipart/form-data">
                <div class="modal-body">
                  <div class="form-group">

                    <label class="col-md-4 col-sm-4 col-xs-12 control-label">Add Excel <span class="asterisk_sign"></span></label>

                    <input type="file" class="fileinput btn btn-info btn-small  bar_image" name="upload" id="image" placeholder="image" value=""/>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-success pull-right" value="Upload" />
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
                      <table id="customers2" class="table datatable table-bordered"  >
                        <thead>
                          <tr>
                            <th width="50" style="text-align:center;">Sr No</th>
                            <th width="75">Upload Date</th>
                            <th width="120">File Name</th>
                            <th width="35">Status</th>
                            <th width="350">Remarks</th>
                            <th width="75">Original File</th>
                            <th width="50">Error File</th>
                            <th width="75">Check File</th>
                            <th width="250">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0; $i < count($data); $i++) { ?>
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
                                <a href="<?php echo base_url().'assets/uploads/sales_return_upload/'.$data[$i]->file_name;?>">
                                  <span class="fa fa-download" style="font-size:20px;"></span>
                                </a>
                              </td>
                              <td>
                                <?php if($data[$i]->error_file_name!=null && $data[$i]->error_file_name!=''){ ?>
                                <a href="<?php echo base_url().'assets/uploads/sales_return_upload/'.$data[$i]->error_file_name;?>">
                                  <span class="fa fa-download" style="font-size:20px;"></span>
                                </a>
                                <?php } ?>
                              </td>
                              <td>
                                <?php if($data[$i]->check_file_name!=null && $data[$i]->check_file_name!=''){ ?>
                                <a href="<?php echo base_url().'assets/uploads/sales_return_upload/'.$data[$i]->check_file_name;?>">
                                  <span class="fa fa-download" style="font-size:20px;"></span>
                                </a>
                                <?php } ?>
                              </td>
                              <td>
                                <?php if($data[$i]->status=='Uploading'){ ?>
                                  <a href="<?php echo base_url();?>index.php/Sales_return_upload/upload_file_data/<?php echo $data[$i]->id;?>">
                                    <button type="button" class="btn btn-default">Upload Data</button>
                                  </a>
                                <?php } else if($data[$i]->status=='Pending') { ?>
                                  <a href="<?php echo base_url();?>index.php/Sales_return_upload/approve_file_data/<?php echo $data[$i]->id;?>" style="margin-right: 5px;">
                                    <button type="button" class="btn btn-success">Approve File</button>
                                  </a>
                                  <a href="<?php echo base_url();?>index.php/Sales_return_upload/reject_file_data/<?php echo $data[$i]->id;?>">
                                    <button type="button" class="btn btn-danger">Reject File</button>
                                  </a>
                                <?php } else if($data[$i]->status=='Approved') { ?>
                                  <a href="<?php echo base_url();?>index.php/Sales_return_upload/get_file_invoices/<?php echo $data[$i]->id;?>" style="margin-right: 5px; display: none;" target="_blank">
                                    <button type="button" class="btn btn-success">Get Invoices</button>
                                  </a>
                                <?php } ?>
                              </td>
                            </tr>
                          <?php } ?>
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
      $(document).on('submit','form.excelform',function(){
        setTimeout(function(){ 
          document.location.reload();
        }, 1000);
      });
    </script>
		<!-- <script>
      var get_batch_details = function() {
        $('#myModal').modal('show');
      }
		</script> -->
  </body>
</html>