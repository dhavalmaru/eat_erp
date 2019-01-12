<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Receipt Voucher</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->

    <style>
        body {  margin:0; padding:0; letter-spacing: 0.5px; font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;}
        .debit_note {  margin:20px auto; border:0px solid #ddd; max-width:800px; }
        .header-section {text-align:center;}
        h1 { font-size:23px; font-weight:600!important; margin:0; padding:0; text-align:center; }
        h2 { font-size:23px; font-weight:600!important; margin:0; padding:0; text-align:center; padding-bottom:5px; }
        p{ padding:0; margin:0; font-size:13px; line-height:21px; }
        table  { margin:10px 0;   }
        table tr td  { border:1px solid #999; padding:3px 10px;  }
        .table-bordered { font-size:13px;  border-collapse:collapse; width:100%;}
        .table {   border-collapse:collapse; width:100%;}
        .table-bordered tr th{ border:1px solid #999; padding:3px 7px; border-collapse:collapse;  }
        .modal-body-inside { padding:10px; }
        @media print{@page {size: portrait}}
        /*.modal-body-inside table { font-size: 14px; }*/
		.user_data tr, .user_data td
		{
			border:none!important;
			padding:5px!important;
		}
    </style>
</head>

<body class="hold-transition">
<div class="debit_note">
    <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:150px;" />
            <p style="font-size:12px;line-height:18px;margin:0;margin-bottom:10px;">
                C/109, Hind Saurashtra Ind. Estate. 85/86, Andheri Kurla Road, Marol Naka, Andheri East. Mumbai 400059
                <br /> +91 8268000456 
                <br><a href="mailto:cs@eatanytime.in">cs@eatanytime.in</a><br>
                GSTIN: 27AABCW7811R1ZN
            </p>
        </center>
    </div>

    <table width="100%" border="0" cellspacing="0" class="table" style="border-collapse:collapse;  ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="center"><h2><b>Receipt Voucher</b></h2></td>
        </tr>
        <tr style="border:none;">
            <td width="17%" style="border:none;"><p> Ref.</p></td>
            <td width="3%" style="border:none;">:</td>
            <td width="40%" style="border:none;"><p><b> WHPL/RECEIPT/<?php echo calculateFiscalYearForDate($date_of_deposit)?>/<?php if(isset($id)) echo $id; ?> </b></p></td>
            <td width="22%" style="border:none;"><p>Transaction Date</p></td>
            <td width="4%" style="border:none;">:</td>
            <td width="14%" style="border:none;">
                <p>
                    <b> 
                        <?php if (isset($date_of_deposit)) echo date('d/m/Y',strtotime($date_of_deposit)); ?>
                             
                    </b>
                </p>
            </td>
        </tr>
        <!-- <tr style="border:none;">
            <td width="17%" style="border:none;"><p>Invoice No.</p></td>
            <td width="3%" height="25" style="border:none;">:</td>
            <td width="40%" style="border:none;"><p><b> <?php //if(isset($debit_note[0]['invoice_no'])) echo $debit_note[0]['invoice_no']; ?></b></p></td>
            <td width="22%" style="border:none;"><p>Invoice Date</p></td>
            <td width="4%" style="border:none;">:</td>
            <td width="14%" style="border:none;">
                <p>
                    <b> 
                        <?php //if(isset($debit_note[0]['invoice_date'])) 
                                //echo (($debit_note[0]['invoice_date']!=null && $debit_note[0]['invoice_date']!='')?
                                //date('d/m/Y',strtotime($debit_note[0]['invoice_date'])):''); ?> 
                    </b>
                </p>
            </td>
        </tr> -->
		 <tr style="border:none;">
            <td width="17%" style="border:none;"><p> Bank name</p></td>
            <td width="3%" style="border:none;">:</td>
            <td width="80%" style="border:none;" colspan="3">
                <p><b> <?php if (isset($b_name)) echo $b_name; ?> </b></p>
            </td>
            <!-- <td width="22%" style="border:none;"><p>Warehouse GSTIN</p></td>
            <td width="4%" style="border:none;">:</td>
            <td width="14%" style="border:none;">
                <p>
                    <b> 
                        <?php //if(isset($grn_details[0]['gst_id'])) echo $grn_details[0]['gst_id']; ?>
                    </b>
                </p>
            </td> -->
        </tr>
        <tr style="border:none;">
            <td  width="17%" style="border:none; vertical-align:top;"><p>Deposit Mode: </p></td>
            <td  width="3%" style="border:none; vertical-align:top;">:</td>
            <td  width="80%" style="border:none; vertical-align:top;" colspan="3">
                <p>
                    <b> <?php if (isset($items['0']->payment_mode)) echo $items['0']->payment_mode; ?>
                </p>
            </td>
            <!-- <td width="22%" style="border:none; vertical-align:top;"><p>Warehouse</p></td>
            <td width="4%" style="border:none; vertical-align:top;">:</td>
            <td width="14%" style="border:none; vertical-align:top;">
                <p>
                    <b> 
                        <?php //if(isset($grn_details[0]['warehouse_name'])) echo $grn_details[0]['warehouse_name']; ?>
                    </b>
                </p>
            </td> -->
        </tr>
       
		
		 
        <tr>
            <td colspan="<?=($items['0']->payment_mode=='Cheque'?'7':'6')?>" height="10" style="border:none;">&nbsp;</td>
        </tr>
		 <tr>
            <td colspan="3"  style="border-left:none;"><p><b>Distributor Name</b></p></td>
            <td colspan="1" align="center"  style="border-right:none;"><p><b>Invoice No.</b></p></td>
            <?php
             if($items['0']->payment_mode=='Cheque')
             {
                echo '<td colspan="1" align="center"  style="border-right:none;"><p><b>Cheque No.</b></p></td>';
             }
            ?>
            <td colspan="2" align="center"  style="border-right:none;"><p><b>Amount</b></p></td>
        </tr>
			<?php if(isset($distributor)) { for($i=0;$i<count($distributor);$i++) {?>
       
        <tr valign="top"  style="border:none; ">
            <td colspan="3"   style="border-left:none; border-bottom:none; ">
                <p>
                   <?php if(isset($distributor[$i]->distributor_name)) echo $distributor[$i]->distributor_name; ?>
                </p>
            </td>            
            <td colspan="1" align="center" valign="top" style="border-right:none;border-bottom:none; "><p><b><?php if(isset($distributor[$i]->invoice_no)) echo $distributor[$i]->invoice_no; ?></b></p></td>
            <?php
             if($items['0']->payment_mode=='Cheque')
             {
                echo '<td colspan="1" align="center" valign="top" style="border-right:none;border-bottom:none; ">
                    <p><b>'.$distributor[$i]->ref_no.'</b></p></td>';
             }
            ?>
		 <td colspan="<?=($items['0']->payment_mode=='Cheque'?'3':'2')?>" align="center" valign="top" style="border-right:none;border-bottom:none; "><p><b>Rs. <?php if(isset($distributor[$i]->payment_amount)) echo format_money($distributor[$i]->payment_amount,2); ?></b></p></td>
        </tr>
      	<?php }} ?>
    
        <tr valign="top"  style="border:none; ">
            <td colspan="<?=($items['0']->payment_mode=='Cheque'?'5':'4')?>"   style="border-left: none; " >
                <p><b>
                    Total Amount
                </b></p>
            </td>
            <td colspan="<?=($items['0']->payment_mode=='Cheque'?'3':'2')?>" align="center" valign="top" style="border-right:none; "><p><b>Rs. <?php if (isset($total_amount)) echo format_money($total_amount,2); ?></b></p></td>
        </tr>
       
        <tr>
            <td height="40" colspan="<?=($items['0']->payment_mode=='Cheque'?'3':'3')?>" valign="top" style="border:none; border-bottom:1px solid #999; border-right:1px solid #999;"> 
                <p><b><?php if(isset($total_amount_in_words)) echo $total_amount_in_words; ?></b></p>
            </td>
            <td colspan="<?=($items['0']->payment_mode=='Cheque'?'2':'3')?>" style="border:none; border-bottom:1px solid #999">
                <p>Remarks: <?=$items[0]->remarks;?></p>
            </td>
            
        </tr>
        <!-- <tr valign="bottom" >
            <td colspan="6" style="border:none;">&nbsp;   </td>
            <td colspan="3" style="border:none;"></td>
        </tr> -->
        <tr valign="bottom" >
            <td colspan="6" style="border:none;"><p style="text-align: center;">This is a computer generated. No signature required. &nbsp;</p></td>
            <!-- <td colspan="2" style="border:none;"> &nbsp; </td>
            <td valign="bottom" colspan="2" style="border:none; text-align:center "><p> <b>Authorised Signatory</b></p></td> -->
        </tr>
        
    </table>
    <table class="user_data" border="0" width="100%" style="border-collapse:collapse;margin-top:20px;font-size:12px " class="table" 	cellspacing="10">
				<tr valign="center" >
						  <td width="100%" align="center"><b>Created By:</b>
						 <?php if(isset($createdby)) echo $createdby; ?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
						  <span style="<?php if(isset($created_on)) 
						if(date("d-m-Y h:m:i", strtotime($created_on)) <> date("d-m-Y h:m:i", strtotime($modified_on)))
						echo ' ';else echo 'display:none;';?>">
						 <b> Modified By:</b>
						  <?php if(isset($modifiedby)) echo $modifiedby; ?>  &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp </span>
						  <b> Approved By:</b>
						  <?php if(isset($approvedby)) echo $approvedby; ?></td>
						  
				</tr>
				<tr valign="center" >
					    <td width="100%" align="center"><b>Created On:</b>
						    <?php if(isset($created_on)) echo date("d-m-Y h:m:i", strtotime($created_on))?>&nbsp &nbsp &nbsp &nbsp
						<span style="<?php if(isset($created_on)) 
						if(date("d-m-Y h:m:i", strtotime($created_on)) <> date("d-m-Y h:m:i", strtotime($modified_on)))
						echo ' ';else echo 'display:none;';?>">
						  <b> Modified On:</b>
						     <?php if(isset($modified_on)) echo date("d-m-Y h:m:i", strtotime($modified_on)) ?>&nbsp &nbsp &nbsp &nbsp </span>
						   <b> Approved On:</b>
						    <?php if(isset($approved_on))echo date("d-m-Y h:m:i", strtotime($approved_on)) ?>
							</td>
				</tr>
					
	</table>

</div>
</body>
</html>
