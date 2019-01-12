<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales Return Receipt</title>
<style>
@font-face {
    font-family: "OpenSans-Regular";
    src: url("<?php echo base_url().'/assets/invoice/'; ?>OpenSans-Regular.ttf") format("truetype");
}
.user_data tr, .user_data td
		{
			border:none!important;
			padding:5px!important;
		}
</style>
</head>

<body>
<?php if(count($data)>0){ ?>
<div>
    <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:12px; font-weight:400; border:1px solid #666; "    >
        <tr>
            <td colspan="10" align="left" valign="top" style="padding:0;">
            <table width="100%" border="0" cellspacing="0">
                <tr>
                    <td width="30%"><img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt="" width=" " height="50" /></td>
                    <td width="70%" style="color:#808080; text-align:left;">
                        <h1 style="padding:0; margin:0; font-size:22px;"> Sales Return Receipt </h1>
                    </td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td colspan="10" valign="top" style="line-height:20px; padding:0; border:0;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                    <tr style="border-bottom:1px solid #666;">
                        <td width="39%" rowspan="3" style="line-height:20px; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;">
                                <span style=" font-size:13px; font-weight:500;" >Distributor Name</span>
                                <br /> <?php if(isset($data[0]->distributor_name)) echo $data[0]->distributor_name; ?>
                            </p> 
                        </td>
                        <td width="32%" valign="top" style="line-height:20px;  border-right:1px solid #666;  border-bottom:1px solid #666; border-left:1px solid #666; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" > Sales Return No.</span> <br /> 
                            <?php if(isset($data[0]->sales_return_no)) echo $data[0]->sales_return_no; ?>
                            </p>
                        </td>
						
						  
                     
                    <td width="30%" valign="top" style="line-height:20px; padding-top: 0px; padding-bottom: 0px;border-bottom:1px solid #666;">
                            <p style="margin: 0px;">  <span style=" font-size:12px; font-weight:500;" >Expired </span>  <br />
                            <?php  if(isset($data[0]->is_expired)) echo $data[0]->is_expired; ?>
                            </p>
                        </td>
					  <td width="30%" valign="top" style="line-height:20px; padding-top: 0px; padding-bottom: 0px;border-bottom:1px solid #666;" >
                            <p style="margin: 0px;">  <span style=" font-size:12px; font-weight:500;" >Exchanged </span>  <br />
                            <?php  if(isset($data[0]->is_exchanged)) echo $data[0]->is_exchanged; ?>
                            </p>
                        </td>
						
                      
                    </tr>
                    <tr style="border-bottom:0px solid #666;">
                        <td valign="top" style="line-height:20px; border-bottom:1px solid #666; border-right:1px solid #666;  border-left:1px solid #666; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" >Location  </span> <br /> 
                            <?php if(isset($data[0]->depot_name)) echo $data[0]->depot_name; ?>
                            </p>
                        </td>
                        <td  valign="top" style="line-height:20px; padding-top: 0px; border-bottom:1px solid #666; padding-bottom: 1px;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" >Prepare By</span> <br /> 
                            <?php if(isset($data[0]->first_name)) echo $data[0]->first_name.' '.$data[0]->last_name; ?>
                            </p>
                        </td>
						  <td width="30%" valign="top" style="line-height:20px; border-bottom:1px solid #666; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;">  <span style=" font-size:12px; font-weight:500;" >Dated </span>  <br />
                            <?php echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):''); ?>
                            </p>
                        </td>
                    </tr>
                    <tr style="border-bottom:0px solid #666;">
                        <td valign="top" style="line-height:20px; border-bottom:0px solid #666; border-right:1px solid #666;  border-left:1px solid #666; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" >Sales Type  </span> <br /> 
                            <?=($data[0]->sales_type=='Invoice' || $data[0]->sales_type=='Adhoc'?$data[0]->sales_type:'Adhoc')?>
                            </p>
                        </td>
                        <td  valign="top" style="line-height:20px; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" >
                            <?=($data[0]->sales_type=='Invoice'?$data[0]->sales_type:'')?>
                            </span> <br /> 
                            <?=($data[0]->sales_type=='Invoice'?$data[0]->invoice_nos:'')?>
                            </p>
                        </td>
                          <td width="30%" valign="top" style="line-height:20px; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;">  <span style=" font-size:12px; font-weight:500;" > </span>  <br />
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="font-size:12px; font-weight:500; ">
            <td width="61" align="center" valign="top"> Sr. No. </td>
            <td width="285" align="center" valign="top"> Description </td>
            <td width="125" align="center" valign="top"> Quantity </td>
            <td width="115" align="center" valign="top"> Rate </td>
            <td width="138" align="center" valign="top"> Amount </td>
            <td width="115" align="center" valign="top"> Cgst </td>
            <td width="115" align="center" valign="top"> Sgst </td>
            <td width="115" align="center" valign="top"> Igst </td>
            <td width="115" align="center" valign="top"> Batch no </td>
            <td width="138" align="center" valign="top"> Total Amount </td>
        </tr>
		       
        <?php if(isset($distributor_in_items)) { for($i=0; $i<count($distributor_in_items); $i++){ ?>
        <tr valign="top" style="border: none;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $i+1; ?></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $distributor_in_items[$i]->description; ?></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $distributor_in_items[$i]->qty; ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $distributor_in_items[$i]->rate; ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round( $distributor_in_items[$i]->amount,2); ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($distributor_in_items[$i]->cgst_amt,2); ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($distributor_in_items[$i]->sgst_amt,2); ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($distributor_in_items[$i]->igst_amt,2); ?></p></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $distributor_in_items[$i]->batch_no; ?></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($distributor_in_items[$i]->total_amt,2); ?></p></td>
        </tr>
      
        <?php }} ?>
		
        <tr>
		
            <td colspan="3" valign="top"> <p style="margin:0;"><span style=" font-size:13px; font-weight:500;" >Amount in Words: <?php if (isset($data['total_amount_in_words'])) echo $data['total_amount_in_words']; ?></span> </p> </td>
            <td colspan="6" valign="middle" align="right" style="font-size:12px; font-weight:500;"><p style="margin:0;"><span style=" font-size:13px; font-weight:500;" >Total</span></p></td>
            
		              <td  style=" font-size:12px; font-weight:500;" >  <span style="text-align:left; float:left"> &#8377; </span> <span style="text-align:right; float:right"><?php if (isset($data[0]->final_amount)) echo $data[0]->final_amount; ?></span> </td>
		</tr>
        <tr>
            <td colspan="3" valign="middle"><span style=" font-size:13px; font-weight:500;" ><?php if (isset($data[0]->final_amount)) echo convert_number_to_words($data[0]->final_amount) . ' Only'; ?> </span></td>
           
			<td colspan="7" valign="middle"><p style="margin:0;"><span style=" font-size:13px; font-weight:500;" >Remarks:</span> </p> <?php if(isset($data[0]->distributor_name)) echo $data[0]->remarks; ?></td>
           
		</tr>
		
		
		
		
		
		
		
		
		
		
		

		
    </table>
</div>
<?php } ?>




<?php if(count($data)>0){ ?>

<div style="<?php if(isset($data[0]->is_exchanged)) {if($data[0]->is_exchanged=='yes') echo ''; else  echo 'display: none;';} else echo 'display: none;'; ?>"> 
   <h3 style="font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif;">Exchange of stock </h3>
   <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:12px; font-weight:400; border:1px solid #666; "    >

        <tr style="font-size:12px; font-weight:500; ">
            <td width="61" align="center" valign="top"> Sr. No. </td>
            <td width="285" align="center" valign="top"> Description </td>
            <td width="125" align="center" valign="top"> Quantity </td>
            <td width="115" align="center" valign="top"> Rate </td>
            <td width="138" align="center" valign="top"> Amount </td>
            <td width="115" align="center" valign="top"> Cgst </td>
            <td width="115" align="center" valign="top"> Sgst </td>
            <td width="115" align="center" valign="top"> Igst </td>
          
        </tr>
       <?php  if(isset($distributor_exchange_items)) {for($i=0; $i<count($distributor_exchange_items); $i++){ ?>
        <tr valign="top" style="border: none;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $i+1; ?></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $distributor_exchange_items[$i]->description; ?></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $distributor_exchange_items[$i]->qty; ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $distributor_exchange_items[$i]->rate; ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round( $distributor_exchange_items[$i]->amount,2); ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($distributor_exchange_items[$i]->cgst_amount,2); ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($distributor_exchange_items[$i]->sgst_amount,2); ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($distributor_exchange_items[$i]->igst_amount,2); ?></p></td>
   
        </tr>
        <?php }} ?>
       
		
		
		
		
		
		
		
		
		
		

		
    </table>
	
	<table class="user_data" border="0" width="925px" style="border-collapse:collapse;margin-top:30px " class="table" cellspacing="10">
					<tr valign="center" >
						   <td style="font-weight:bold">Created By:</td>
						   <td><?php if(isset($data[0]->createdby)) echo $data[0]->createdby; ?></td>
						   
						    <td style="font-weight:bold">Created On:</td>
						    <td><?php if(isset($data[0]->created_on)) echo $data[0]->created_on?></td>
						  
						  
					</tr>
					<tr valign="center" >
					    <td style="font-weight:bold">Modified By:</td>
						   <td><?php if(isset($data[0]->modifiedby)) echo $data[0]->modifiedby; ?></td>
						   <td style="font-weight:bold">Modified On:</td>
						     <td><?php if(isset($data[0]->modified_on)) echo $data[0]->modified_on?></td>
						   
					</tr>
					
					<tr valign="center" >
					  <td style="font-weight:bold">Approved By:</td>
						   <td><?php if(isset($data[0]->approvedby)) echo $data[0]->approvedby; ?></td>
						   <td style="font-weight:bold">Approved On:</td>
						     <td><?php if(isset($data[0]->approved_on))echo $data[0]->approved_on ?>
							</td>
					</tr>
	</table>
	
</div>
<?php } ?>

    


</body>
</html>
