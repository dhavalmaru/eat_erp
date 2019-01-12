<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Portfolio Management</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
           <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>    
        <!-- EOF CSS INCLUDE -->            
    </head>
    <body>								
         <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                   <div class="heading-h3"> 
                   <div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Bank Details List  </div>	 
					 
					  <div class="heading-h3-heading">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                    	<div class="pull-right btn-margin"  >
							<?php if(isset($access)) { if($access[0]->r_insert == 1) { ?>
							<a class="btn btn-success btn-block btn-padding" href="<?php echo base_url().'index.php/bank/add'; ?>">
										<span class="fa fa-plus"></span> Add Bank Details</a>
										<?php } } ?>
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
                        <!-- <table id="example" class="table table-bordered display"> -->
                        <table id="customers2" class="table datatable table-bordered">
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
                              <td>1</td>
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
                              <td>2</td>
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
                                  $i = 0;
                                  
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
                                                          <td>'.($i+3).'</td>
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
                                            <td><?php echo $i+3; ?></td>
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
                                            <td><?php echo $i+4; ?></td>
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
                                            <td><?php echo $i+5; ?></td>
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
                                            <td><?php echo $i+6; ?></td>
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
                                            <td><?php echo $i+7; ?></td>
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
                                            <td><?php echo $i+8; ?></td>
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