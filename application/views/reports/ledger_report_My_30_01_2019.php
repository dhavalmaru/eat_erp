<!DOCTYPE html>
<html lang="en">
<head>        
  <!-- META SECTION -->
  <title>EAT ERP</title>            
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- END META SECTION -->
  <!-- CSS INCLUDE -->        
  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
  <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
  <!-- EOF CSS INCLUDE -->    
  <style type="text/css">
  body {background:none!important;}
  .bootstrap-select.btn-group .dropdown-menu li > a {
    cursor: pointer;
    width: 100%;
  }
  .btn.btn-sm, .btn-group-sm > .btn {padding:0px 10px;}
  .panel-heading{ background: #fff!important;  padding:8px  10px!important;  }
  .panel  span { margin:0;}
  @media only screen and  (min-width:250px)  and (max-width:480px) {
  .custom-padding  .panel-heading .pull-right {/* margin:5px 20px; */}
  .panel-heading { min-height:60px;}

}
@media only screen and (min-width: 260px) and (max-width:767px) { 
  .custom-padding .col-md-6 .control-label {
    margin-top:10px;
    } }

    @media only screen and (min-width:768px) and (max-width: 1020px) { 
      .custom-padding .col-md-6 .control-label {
        margin-top:0;
        } }

        table {
          width: 80%;
        }

        caption {
          text-align: left;
          color: silver;
          font-weight: bold;
          text-transform: uppercase;
          padding: 5px;
        }

        thead {
          background: SteelBlue !important;
          color: white;
        }

        th{
          background: SteelBlue !important;
        }

        th,
        td {
          padding: 5px 10px;
          border: 1px solid #e2e2e2;
          text-align: left;
        }

        tbody tr:nth-child(even) {
          background: WhiteSmoke;
        }



        tbody tr td:nth-child(3),
        tbody tr td:nth-child(4) {
          text-align: right;
          font-family: monospace;
        }

        tfoot {
          background: SeaGreen;
          color: white;
          text-align: right;
        }

        tfoot tr th:last-child {
          font-family: monospace;
        }


        </style>
      </head>
      <body>								
       <!-- START PAGE CONTAINER -->
       <div class="page-container page-navigation-top">   
        <?php $this->load->view('templates/menus');?>         		
        <!-- PAGE CONTENT -->
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">


         <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Reports/view_reports'; ?>" >  Report List  </a>   &nbsp; &#10095; &nbsp; Report Details   </div>               

         <!-- PAGE CONTENT WRAPPER -->
         <div class="page-content-wrap" >
          <div class="row main-wrapper">                  
           <div class="main-container">           
             <div class="box-shadow custom-padding">
              <!-- <form id="form_download_report" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php //if(isset($report_id)) { echo base_url().'index.php/export/generate_report/'.$report_id; } ?>"> -->
                <form id="form_download_report" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url().'index.php/export/getledgerreport'; ?>">

                <div class="col-md-12" style="padding:0;">
                  <div class="box-shadow-inside">  
                    <div class="panel panel-default">
                     <div class="panel-body panel-group accordion" >
                       <div class="panel-primary"   >
                         <div class="panel-heading" style="display:inline-block;">

                           <h4 class="panel-title">  <span class="fa fa-file-text-o"> </span>  <?php if(isset($report_name)) echo $report_name; ?>  </h4>
                           <input type="hidden" name="txn_type" id="txn_type" value="<?php if(isset($txn_type)) echo $txn_type; ?>" />
                           <a class="pull-right" href="<?php echo base_url() . '/assets/reports_sample/' . (isset($sample_report_name)?$sample_report_name:'') ;?>" target="_blank"> <span class="btn btn-danger pull-right btn-sm "><span class="fa fa-file-pdf-o"> </span>  View Sample </span>  </a>
                         </div>

                         <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                          <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php //if($report_id !='16') echo 'display:none;';?>">
                           <div class="col-md-6  col-sm-6 col-xs-12">
                            <div class="">
                              <label class="col-md-4 col-sm-4 col-xs-12  control-label">Select Ledger</label>
                              <div class="col-md-6 col-sm-6  col-xs-12">
                                <select class="form-control" name="ledger_id" id="ledger_id">
                                  <option value="">Select Ledger </option>
                                  <?php if(isset($ledger)){
                                    foreach($ledger as $row){
                                      echo '<option value="'.$row->id.'" '.(($row->id==$ledger_id)?"selected":"").'>'.$row->ledger_name.'</option>';                                                        	
                                    }
                                  } 
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>


                            <div class="form-group" style="border-top:1px solid #ddd; <?php //if($report_type=='Aging Wise') echo 'display:none;';?>">
                              <div class="col-md-6  col-sm-6 col-xs-12">
                               <label class="col-md-4  col-sm-4 col-xs-12 control-label" >From</label>
                               <div class="col-md-6  col-sm-6 col-xs-12">                                                                  
                                <div class="input-group" style="display:block">
                                  <input type="text" class="form-control datepicker" id="from_date" name="from_date" value="<?php if(isset($from_date)) echo (($from_date!=null && $from_date!='')?date('d/m/Y',strtotime($from_date)):''); ?>">
                                  <!--<span class="input-group-addon"><span class="fa fa-calendar"></span></span>-->
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6  col-sm-6 col-xs-12">
                             <label class="col-md-4  col-sm-4 col-xs-12 control-label">To</label>
                             <div class="col-md-6  col-sm-6 col-xs-12">
                               <div class="input-group" style="display:block" >
                                <input type="text" class="form-control datepicker" id="to_date" name="to_date" value="<?php if(isset($to_date)) echo (($to_date!=null && $to_date!='')?date('d/m/Y',strtotime($to_date)):''); ?>">
                                <!--<span class="input-group-addon"><span class="fa fa-calendar"></span></span>-->
                              </div>
                            </div>
                          </div>
                        </div>




                        <div class="row" style="text-align:center; margin:15px 0;">
                          <input type="submit" name="download" class="btn btn-danger" value="Download Report" />
                          <!--<span class="fa fa-download"> </span>-->

                          <input type="submit" name="download" id="view_report" class="btn btn-danger" value="View Report" />
                          <input type="submit" name="download" id="print_report" class="btn btn-danger" value="Print Report" style="<?php if(isset($data)) {if(count($data)>0) echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>" />

                          <!-- <a id="view_report" name="view" class="btn btn-danger" style="<?php //if($report_id !='5') echo 'display:none;';?>">View Report</a>
                          <a id="print_report" name="print" class="btn btn-danger" style="<?php //if($report_id !='5') echo 'display:none;';?>">Print Report</a> -->

                          <!--<span class="fa fa-eye"> </span> -->
                        </div>


                        <div class="form-group" style="border-top:1px solid #ddd; border-bottom:none; <?php //if($report_id !='5') echo 'display:none;';?>">
                             <div class="col-md-12  col-sm-12 col-xs-12">
                                <div class="">
                                    <div class="col-md-12 col-sm-12  col-xs-12 ledger_table datatable">
                                        <table id="printTable" border="1" cellpadding="3" style="border-collapse: collapse;">
                                            <thead>
                                              <tr>
                                                <th class="text-center"> Sr No </th>
                                                <th class="text-center"> Ref ID (Voucher No) </th>
                                                <th class="text-center"> Date </th>
                                                <th class="text-center"> Ledger Code </th>
                                                <th class="text-center"> Ledger Name </th>
                                                <th class="text-center"> Ref 1 </th>
                                                <th class="text-center"> Ref 2 </th>
                                                <th class="text-center"> Debit </th>
                                                <th class="text-center"> Credit </th>
                                                <th class="text-center"> Balance </th>
                                                <th class="text-center"> DB/CR </th>
                                                <th class="text-center"> Knock Off Ref </th>
                                                <th class="text-center show_narration"> Narration </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php 
                                                if(isset($opening_bal)){
                                                  if($opening_bal<0){
                                                          $opening_bal = $opening_bal*-1;
                                                          $opening_bal_type = 'Dr';
                                                      } else {
                                                          $opening_bal_type = 'Cr';
                                                      }
                                                } else {
                                                  $opening_bal = 0;
                                                  $opening_bal_type = 'Cr';
                                                }
                                                ?>
                                                  <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Start Date</td>
                                                <td>Opening Balance</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align:right;"><?php echo format_money($opening_bal,2); ?></td>
                                                <td><?php echo $opening_bal_type; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td class="show_narration"></td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="show_narration"></td>
                                              </tr>
                                                
                                              <?php
                                                $balance = $opening_bal;

                                                $debit_amt = 0;
                                                $credit_amt = 0;
                                                $cur_total = 0;
                                                
                                                if(isset($data)){
                                                  if(count($data)>0){
                                                      for($i=0; $i<count($data); $i++){
                                                          $ledger_code = '';
                                                          $ledger_name = '';

                                                          if($data[$i]['type']=='Debit'){
                                                              $entry_type = 'Dr';
                                                              $debit_amt = floatval($data[$i]['amount']);
                                                              $balance = round($balance - $debit_amt,2);
                                                              $credit_amt = '';
                                                              $cur_total = round($cur_total - $debit_amt,2);
                                                          } else {
                                                              $entry_type = 'Cr';
                                                              $credit_amt = floatval($data[$i]['amount']);
                                                              $balance = round($balance + $credit_amt,2);
                                                              $debit_amt = '';
                                                              $cur_total = round($cur_total + $credit_amt,2);
                                                          }
                                                          if($balance<0){
                                                              $balance_type = 'Dr';
                                                              $balance_val = $balance * -1;
                                                          } else {
                                                              $balance_type = 'Cr';
                                                              $balance_val = $balance;
                                                          }
                                                          if(isset($data[$i]['cp_acc_id'])){
                                                              if($data[$i]['cp_acc_id']!=$ledger_id){
                                                                  $ledger_code = $data[$i]['cp_ledger_code'];
                                                                  $ledger_name = $data[$i]['cp_ledger_name'];
                                                              }
                                                          }
                                                          if($ledger_code == ''){
                                                              $ledger_code = $data[$i]['ledger_code'];
                                                              $ledger_name = $data[$i]['ledger_name'];
                                                          }

                                                          echo '<tr>
                                                                        <td>'.($i+1).'</td>
                                                                        <td>'.$data[$i]['voucher_id'].'</td>
                                                                        <td>'.(($data[$i]['ref_date']!=null && $data[$i]['ref_date']!="")?date("d/m/Y",strtotime($data[$i]['ref_date'])):"").'</td>
                                                                        <td>'.$ledger_code.'</td>
                                                                        <td>'.$ledger_name.'</td>
                                                                        <td>'.$data[$i]['ref_id'].'</td>
                                                                        <td>'.$data[$i]['invoice_no'].'</td>
                                                                        <td style="text-align:right;">'.format_money($debit_amt,2).'</td>
                                                                        <td style="text-align:right;">'.format_money($credit_amt,2).'</td>
                                                                        <td style="text-align:right;">'.format_money($balance_val,2).'</td>
                                                                        <td>'.$balance_type.'</td>
                                                                        <td>'.$data[$i]['payment_ref'].'</td>
                                                                        <td class="show_narration">'.$data[$i]['narration'].'</td>
                                                                      </tr>';
                                                      }
                                                  }
                                              }

                                                if($balance<0){
                                                    $balance_type = 'Dr';
                                                    $balance_val = $balance * -1;
                                                } else {
                                                    $balance_type = 'Cr';
                                                    $balance_val = $balance;
                                                }

                                                if($cur_total<0){
                                                    $cur_total_type = 'Dr';
                                                    $cur_total_val = $cur_total * -1;
                                                } else {
                                                    $cur_total_type = 'Cr';
                                                    $cur_total_val = $cur_total;
                                                }
                                              ?>

                                              <tr>
                                                <td>&nbsp;</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="show_narration"></td>
                                              </tr>
                                              <tr>
                                                <td></td>
                                                <td></td>
                                                <td>End Date</td>
                                                <td>Closing Balance</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align:right;"><?php echo format_money($balance_val,2); ?></td>
                                                <td><?php echo $balance_type; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td class="show_narration"></td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="show_narration"></td>
                                              </tr>
                                              <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Opening Balance</td>
                                                <td style="text-align:right;"><?php echo (($opening_bal_type == "Dr")?format_money($opening_bal,2):"0.00"); ?></td>
                                                <td style="text-align:right;"><?php echo (($opening_bal_type == "Cr")?format_money($opening_bal,2):"0.00"); ?></td>
                                                <td><?php echo $opening_bal_type; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td class="show_narration"></td>
                                              </tr>
                                              <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Current Total</td>
                                                <td style="text-align:right;"><?php echo (($cur_total < 0)?format_money($cur_total_val,2):"0.00"); ?></td>
                                                <td style="text-align:right;"><?php echo (($cur_total >= 0)?format_money($cur_total_val,2):"0.00"); ?></td>
                                                <td><?php echo $cur_total_type; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td class="show_narration"></td>
                                              </tr>
                                              <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>Closing Balance</td>
                                                <td style="text-align:right;"><?php echo (($balance < 0)?format_money($balance_val,2):"0.00"); ?></td>
                                                <td style="text-align:right;"><?php echo (($balance >= 0)?format_money($balance_val,2):"0.00"); ?></td>
                                                <td><?php echo $balance_type; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td class="show_narration"></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                         

                      </div>
                      <br clear="all">                              
                    </div>
                  </div>
                </div>
                <br clear="all"/>
              </div>	
            </div>
            <div class="panel-footer">

              <a href="<?php echo base_url(); ?>index.php/Reports/view_reports" class="btn btn-danger" type="reset" id="reset">Cancel</a>
            </div>
          </form>
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
<script type="text/javascript">
var BASE_URL="<?php echo base_url();?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

<script type="text/javascript">
$( "#property" ).change(function() {
getSubProperties();
});

function getSubProperties(){
var property=$("#property").val();
var txn_type=$("#txn_type").val();
if(property==''){
  $("#sub_property").html('');
  $("#sub_property_div").hide();
} else {
  // console.log(property);
  var status=$("#status").val();
  var dataString = 'property_id=' + property + '&txn_type=' + txn_type;

  $.ajax({
    type: "POST",
    url: "<?php echo base_url() . 'index.php/export/get_sub_property' ?>",
    data: dataString,
    // async: false,
    cache: false,
    success: function(html){
      $("#sub_property").html(html);

      if(html==""){
        $("#sub_property_div").hide();
      } else {
        $("#sub_property_div").show();
      }
    }
  });
}
}


function printData()
{
var divToPrint=document.getElementById("printTable");
newWin= window.open("");
newWin.document.write(divToPrint.outerHTML);
newWin.print();
newWin.close();
}

</script>
<!-- END SCRIPTS -->     
<script>
$(document).ready(function(){
$('#view_report').click(function(){
// alert($('#from_date').val());
$.ajax({
  type: 'post',
  url: '<?php echo base_url();?>index.php/Export/generate_ledger_report',
  data: {distributor_id: $('#distributor_id').val(), from_date: $('#from_date').val(), to_date: $('#to_date').val()},
  success: function (data) {
    // alert(data);
    var damt=0;
    var damttd=0;
    var camt=0;
    var camttd=0;
    var running_bal=0;
    var datatable='<table id="printTable" border="1" cellpadding="3" style="border-collapse: collapse;"><thead><th>Ref Date</th><th>Reference</th><th>Debit</th><th>Credit</th><th>Running Balance</th></thead><tbody>';
    $.each($.parseJSON(data), function(){
      var debit_amount=this.debit_amount;
      damttd=this.debit_amount;
      if(debit_amount==null){
        debit_amount="";
      }
      if(damttd==null){
        damttd=0;
      }

      var credit_amount=this.credit_amount;
      camttd=this.credit_amount;
      if(credit_amount==null) {
        credit_amount="";
      }
      if(camttd==null){
        camttd=0;
      }

      if(damttd!=null && damttd!=0) {
        running_bal = parseFloat(running_bal)+parseFloat(damttd);
      }
      else {
        running_bal = parseFloat(running_bal)-parseFloat(camttd);
      }
      // alert(this.ref_date);
      datatable=datatable+"<tr><td>"+this.ref_date+"</td><td>"+this.reference+"</td><td>"+debit_amount+"</td><td>"+credit_amount+"</td><td>"+(running_bal).toFixed(2)+"</td></tr>";
      damt=(parseFloat(damt)+parseFloat(damttd)).toFixed(2);
      camt=(parseFloat(camt)+parseFloat(camttd)).toFixed(2);

    });


datatable=datatable+"<tr><td></td><td></td><td>"+damt+"</td><td>"+camt+"</td><td></td></tr>";
var diff=0;
if(damt>camt) {
  diff=parseFloat(damt-camt).toFixed(2);
  datatable=datatable+"<tr><td></td><td></td><td></td><td>"+diff+"</td><td></td></tr>";
}
if(camt>damt) {
  diff=parseFloat(camt-damt).toFixed(2);
  datatable=datatable+"<tr><td></td><td></td><td>"+diff+"</td><td></td><td></td></tr>";
}
datatable=datatable+"</tbody></table>";

$(".ledger_table").html(datatable);

}
});
});

$('#print_report').click(function(){
  printData();
});
});
</script> 
</body>
</html>