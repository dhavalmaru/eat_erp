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
.sign td,.name td

{
  padding:20px 20px 10px 20px;
  text-align:left;
  font-weight:bold;
  border-right:1px solid #666;
}
.name1 td

{
  padding:40px 20px;
  text-align:left;
  font-weight:bold;
  border-right:1px solid #666;
}
.jv td
{
	padding:20px 5px;
	text-align:left;
	font-weight:bold;
	border-right:1px solid #666;
}
.heading
{
  background: #ececec;
    font-size: 12px;
    font-weight: bold;
}
.payment_head td
{
  font-weight:bold;
  border-bottom:1px solid #666;
  border-right:1px solid #666;
}
.payment_head1 td
{
   border-right:1px solid #666;
  border-bottom:1px solid #666;
}
.payment_dtl td
{
	 padding: 10px;
}
hr
{ margin-left: 40px;}
input[type=checkbox] {
         position: relative;
	       cursor: pointer;
    }
    input[type=checkbox]:before {
         content: "";
         display: block;
         position: absolute;
         width: 12px;
         height: 12px;
         top: 0;
         left: 0;
         border: 2px solid #555555;
         border-radius: 3px;
         background-color: white;
}
    input[type=checkbox]:checked:after {
         content: "";
         display: block;
         width: 3px;
         height: 8px;
         border: solid black;
         border-width: 0 2px 2px 0;
         -webkit-transform: rotate(45deg);
         -ms-transform: rotate(45deg);
         transform: rotate(45deg);
         position: absolute;
         top: 2px;
         left: 6px;
}
</style>
</head>

<body>

<div>
    <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:12px; font-weight:400; border:1px solid #666; "    >
        <tr>
            <td colspan="10" align="left" valign="top" style="padding:0;">
            <table width="100%" border="0" cellspacing="0">
                <tr>
                    <td width="20%"><img src="../../../assets/invoice/logo.png" alt="" width=" " height="50" /></td>
                    <td width="60%" style="color:#808080; text-align:center;">
                        <h1 style="padding:0; margin:0;text-align: center; font-size:22px;">Payment Voucher - <span><?=$data[0]->po_status?></span> </h1>
                    </td>
					<td width="20%" style="text-align:center;"><img src="../../../img/eat-blue.png" alt="" width=" " height="50" /></td>
                </tr>
        
            </table>
            </td>
        </tr>
  
        <td colspan="10" align="left" valign="top" style="padding:0;">
            <table width="100%" border="0" cellspacing="0">      
				<tr>			
					<td  align="center" valign="top" style="border-right:1px solid #666;font-weight:bold;padding: 6px;">
					<input type="checkbox" name="Purchase" value="Purchase" <?php if (isset($data[0]->type)) { if($data[0]->type=='Purchase') echo 'checked'; } ?> disabled>  &nbsp;&nbsp; Purchase  
					</td>
					<td  align="center" valign="top" style="border-right:1px solid #666;font-weight:bold;padding: 6px;">
					<input type="checkbox" name="Fixed Asset" value="Fixed Asset" <?php if (isset($data[0]->type)) { if($data[0]->type=='Fixed Asset') echo 'checked'; } ?> disabled> &nbsp;&nbsp; Fixed Asset</td>
					<td   align="center" valign="top" style="font-weight:bold;padding: 6px;">
					<input type="checkbox" name="Expense" value="Expense" <?php if (isset($data[0]->type)) { if($data[0]->type=='Expense') echo 'checked'; } ?> disabled> &nbsp;&nbsp; Expense
					</td>
				</tr>
			</table>
        </td>
		
        <tr>
          <td colspan="10"   style="background:#ececec" class="heading" align="center"> To be filled  by requestor</td>
        </tr>
		
        <tr>
            <td colspan="10" valign="top" style="line-height:20px; padding:0;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="5" >
                    <tr>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none; border-bottom:1px solid #666;width:15%;font-weight:bold">Requestor Name</td>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none; border-bottom:1px solid #666;width:40%"><?=$data[0]->user_name?></td>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none; border-bottom:1px solid #666;width:15%;font-weight:bold" >Voucher No:</td>
                      <td valign="top" align="left" style="border-top: none; border-bottom:1px solid #666;width:30%"><?=$data[0]->voucher_no?></td>
                    </tr>
                      <tr>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none;  border-bottom:1px solid #666;width:15%;font-weight:bold">Party Name </td>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none;  border-bottom:1px solid #666;width:40%"> <?=$data[0]->vendor_name?></td>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none;  border-bottom:1px solid #666;width:15%;font-weight:bold">Voucher Date:</td>
                      <td valign="top" align="left" style="border-top: none;  border-bottom:1px solid #666;width:30%"><?= date('d-m-Y' ,strtotime($data[0]->created_on)) ?></td>
                    </tr>
                     <tr>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none;  border-bottom:1px solid #666;width:15%;font-weight:bold">GSTIN </td>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none;  border-bottom:1px solid #666;width:40%"> <?=$data[0]->gst_number?>    </td>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none;  border-bottom:1px solid #666;width:15%;font-weight:bold">P.O.No #:</td>
                      <td valign="top" align="left" style="border-top: none;  border-bottom:1px solid #666;width:30%"><?=$data[0]->po_no?> </td>
                    </tr>
                      <tr>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none; border-bottom:none;width:15%;font-weight:bold">Amount </td>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none; border-bottom:none;width:40%"> <?=format_money($data[0]->total_payable,2)?> </td>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none; border-bottom:none;width:15%;font-weight:bold">Attached(Y/N):</td>
                      <td valign="top" align="left" style="border-top: none; border-bottom:none;width:30%"><?=$data[0]->attached?> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        <td colspan="10" class="heading"   style="background:#ececec" align="center"> Accounts ( To be filled  by Accountant )</td>
        </tr>
       
		
		<td colspan="10" align="left" valign="top" style="padding:0;">
            <table width="100%" border="0" cellspacing="0">      
				<tr>			
					<td  width="25%" align="left" valign="top" style="border-right:1px solid #666;font-weight:bold;padding: 6px;">
						Invoice Date: 
					</td>
					<td width="25%" align="left" valign="top" style="border-right:1px solid #666;font-weight:normal;padding: 6px;">
					<?= date('d-m-Y' ,strtotime($data[0]->invoice_date)) ?>
					</td>
					<td  width="25%" align="left" valign="top" style="border-right:1px solid #666;font-weight:bold;padding: 6px;">
						Invoice No: 
					</td>
					<td  width="25%" align="left" valign="top" style="font-weight:normal;padding: 6px;">
					<?=$data[0]->invoice_no?>
					</td>
				</tr>
			</table>
        </td>
      
      <tr>
        <td colspan="10"   class="heading" style="background:#ececec" align="center">&nbsp </td>
      </tr> 
        <tr style="font-size:12px; font-weight:500;font-weight:bold ">
            <td width="61" align="center" valign="top"> Sr. No. </td>
            <td width="285" align="center" valign="top"> Particular </td>
            <td width="125" align="center" valign="top"> Qty </td>
            <td width="115" align="center" valign="top"> Rate </td>
            <td width="138" align="center" valign="top"> Amount </td>
          <td width="115" align="center" valign="top"> Tax% </td>
            <td width="115" align="center" valign="top"> CGST </td>
        
            <td width="115" align="center" valign="top"> SGST </td>
            <td width="115" align="center" valign="top"> IGST </td>

            <td width="138" align="center" valign="top"> Total Amount </td>
        </tr>
        <?php 
           for ($i=0; $i <count($payment_voucher) ; $i++) { ?> 
      <tr style="font-size:12px; font-weight:500; ">
            <td width="61" align="center" valign="top"><?=$i+1;?></td>
            <td width="285" align="center" valign="top"><?=$payment_voucher[$i]->particulars?></td>
            <td width="125" align="center" valign="top"><?=format_money($payment_voucher[$i]->qty,2)?></td>
            <td width="115" align="center" valign="top"><?=format_money($payment_voucher[$i]->rate,2)?></td>
            <td width="138" align="center" valign="top"><?=format_money($payment_voucher[$i]->amount,2)?></td>
          <td width="115" align="center" valign="top"><?=format_money($payment_voucher[$i]->tax_per,2)?></td>
            <td width="115" align="center" valign="top"><?=format_money($payment_voucher[$i]->cgst_amt,2)?></td>
        
            <td width="115" align="center" valign="top"><?=format_money($payment_voucher[$i]->sgst_amt,2)?></td>
            <td width="115" align="center" valign="top"><?=format_money($payment_voucher[$i]->igst_amt,2)?></td>

            <td width="138" align="center" valign="top"><?=format_money($payment_voucher[$i]->total_amt,2)?></td>
        </tr>
        <?php } ?>
		 <?php if($data[0]->other_charges_amount!=0 && $data[0]->other_charges_amount!=''){
        ?>
        <tr style="font-size:12px; font-weight:500; ">
            <td width="61" align="center" valign="top"></td>
            <td width="285" align="center" valign="top"> Other Charges - <?=$data[0]->other_charges;?> </td>
            <td width="125" align="center" valign="top">  </td>
            <td width="115" align="center" valign="top">  </td>
            <td width="138" align="center" valign="top"></td>
          <td width="115" align="center" valign="top">  </td>
            <td width="115" align="center" valign="top">  </td>
        
            <td width="115" align="center" valign="top">  </td>
            <td width="115" align="center" valign="top">  </td>

            <td width="138" align="center" valign="top"><?=format_money($data[0]->other_charges_amount,2)?></td>
        </tr> 
        <?php } ?>
		<tr style="font-size:12px; font-weight:500; background:#ececec ">
            <td width="61" align="center" valign="top"></td>
            <td width="285" align="center" valign="top"><b> Total </b></td>
            <td width="125" align="center" valign="top">  </td>
            <td width="115" align="center" valign="top">  </td>
            <td width="138" align="center" valign="top"></td>
          <td width="115" align="center" valign="top">  </td>
            <td width="115" align="center" valign="top">  </td>
        
            <td width="115" align="center" valign="top">  </td>
            <td width="115" align="center" valign="top">  </td>

            <td width="138" align="center" valign="top"><?=format_money($data[0]->final_amount,2)?></td>
        </tr>   
      
      
     
    <tr style="border-top: 1px solid #666;">
          <td colspan="5" rowspan="3" valign="top">
            
              <p style="margin:0;text-align:left;line:height:22px;font-size:22px;"><span style="  font-size:14px; font-weight:bold;    margin-top: 5px;display: block;" >Remarks: <span style="  font-size:12px; font-weight:normal; margin-top: 5px;display: block;" ><?=$data[0]->remark ?> </span> </p> 
            
          </td>

          <td colspan="4" valign="top" style=" font-weight:900;">Invoice Amount</td>
          <td align="center"  style="font-weight:900"   >  
            <span style="text-align:center;"><?=format_money($data[0]->final_amount,2)?></span> 
          
          </td>
    </tr>
    <tr>
       <td colspan="4" valign="top" style=" font-weight:500;">(-) TDS <?=$data[0]->tds_per?> %</td>
          <td align="center" style="  font-weight:500;"  >  
            <span style="text-align:center;"><?=format_money($data[0]->tdsamount,2) ?> </span> 

          </td>
    </tr>
    <tr>
        <td colspan="4" valign="top" style="font-weight:900;">Total Payable</td>
        <td align="center" style="font-weight:900;"  >  
          <span style="text-align:center;"><?=format_money($data[0]->total_payable,2)?></span> 
         
        </td>
    </tr>

  
  
  
    </table><br><br>
	<table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:12px; font-weight:400; border:1px solid #666; "    >
	

  
   <tr>
		<td colspan="10" valign="top" style="line-height:20px; padding:0;"> 
			<table width="100%"  border="0" cellspacing="0" style="border-color:#666" >
                    
					
  
    
				 
					
				  <tr  style="background:#ececec " class="heading payment_head1 ">
						<td width="50%"  align="center"> Prepared By </td>
					
						<td  width="50%"  align="center" style="border-right:none"> Checked By</td>
				  </tr> 
					
					
				  <tr style="" class="name1">
				 
						<td  width="50%"  align="center">Name:&nbsp;&nbsp;<?=$data[0]->user_name?> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<span class="sign_1">Sign: _______________________________</span> </td>
					
						
						<td  width="50%" style="border-right:none;" align="center"> <span class="name_1">Name:_______________________________</span>&nbsp;&nbsp; <span class="sign_2">Sign:_______________________________</span></td>
					
		
				  </tr> 
				
				
				   
			</table> 
		</td>
	</tr>   

       
	<tr>
		<td colspan="10" valign="top" style="line-height:20px; padding:0;"> 
			<table width="100%"  border="0" cellspacing="0" style="border-color:#666" >
                    
					
  
    
					
				
					
				  <tr  style="background:#ececec " class="heading payment_head1 ">
						<td  width="50%"  align="center"> Verified By </td>
					
						<td  width="50%"  align="center" style="border-right:none"> Approved By</td>
				  </tr> 
					
					
				   <tr style="" class="name1">
				 
						<td width="50%" align="center">Name:_______________________________ &nbsp;&nbsp;  <span class="sign_1">Sign: _______________________________</span> </td>
					
						
						<td width="50%"  style="border-right:none;" align="center"> <span class="name_1">Name:_______________________________</span>&nbsp;&nbsp; <span class="sign_2">Sign:_______________________________</span></td>
					
		
				  </tr> 
				   
			</table>
		</td>
	</tr>


	</table>
		  <!--<tr>
        <td colspan="10" class="heading"   style="background:#ececec" align="center">&nbsp </td>
        </tr>-->
<br><br>
	<table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:12px; font-weight:400; border:1px solid #666; "    >
	
		<tr>
			<td colspan="10" valign="top" style="line-height:20px; padding:0;"> 
				<table width="100%"  border="0" cellspacing="0" style="border-color:#666" >
                    
					

					
					<tr style="" class="jv">
				 
						<td  valign="top">Journal Voucher No:-  <br><br></td>
						<td  valign="top">Payment Date:-  </td>
						<td   style="border-right:none;" valign="top">Payment Voucher No:-  </td>
					
						
			
					</tr> 
				</table>
			</td>
		</tr>
		<tr>
						<td colspan="10"   class="heading" style="background:#ececec" align="center"> Payment Details</td>
		</tr> 
		<tr>
			<td colspan="10" valign="top" style="line-height:20px; padding:0;"> 
			<table width="100%"  border="0" cellspacing="0" style="border-color:#666" >						
					<tr class="payment_head">
						<td  width="50%" align="center"> Payment Mode</td>
						<td   width="50%"  align="center" style="border-right:none"> Cheque No </td>
						
					</tr>   
				    <tr class=" payment_dtl">
						<td  width="50%"  style="border-right:1px solid #666;" align="center"><input type="checkbox" name="Online" value="Online" disabled> &nbsp; Online &nbsp  &nbsp <input type="checkbox" name="Cheque" value="Cheque" disabled > &nbsp; Cheque </td>
					
						<td   width="50%"  align="center" style="border-right:none;"> </td>
					</tr> 
				   
			</table>
			</td>
		</tr>	
 </table>
</div>
</body>
</html>
