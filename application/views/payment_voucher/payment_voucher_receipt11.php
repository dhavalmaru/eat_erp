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
</style>
</head>

<body>

<div>
    <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:12px; font-weight:400; border:1px solid #666; "    >
        <tr>
            <td colspan="10" align="left" valign="top" style="padding:0;">
            <table width="100%" border="0" cellspacing="0">
                <tr>
                    <td width="30%"><img src="../../../assets/invoice/logo.png" alt="" width=" " height="50" /></td>
                    <td width="70%" style="color:#808080; text-align:left;">
                        <h1 style="padding:0; margin:0; font-size:22px;">Payment Voucher </h1>
                    </td>
                </tr>
        
            </table>
            </td>
        </tr>
      <tr>
                   
          <td colspan="3"  align="center" valign="top" style="border-right:0px; font-weight:bold">
           <input type="checkbox" name="Purchase" value="Purchase" <?php if (isset($data[0]->type)) { if($data[0]->type=='Purchase') echo 'checked'; } ?> disabled>Purchase  
          </td>
          <td colspan="3"  align="center" valign="top" style="border-right:0px;font-weight:bold">
            <input type="checkbox" name="Fixed Asset" value="Fixed Asset" <?php if (isset($data[0]->type)) { if($data[0]->type=='Fixed Asset') echo 'checked'; } ?> disabled> Fixed Asset</td>
          <td colspan="4"  align="center" valign="top" style="font-weight:bold">
            <input type="checkbox" name="Expense" value="Expense" <?php if (isset($data[0]->type)) { if($data[0]->type=='Expense') echo 'checked'; } ?> disabled>Expense
                    </td>
       </tr>
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
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none; border-bottom:none;width:40%"> <?=$data[0]->total_payable?> </td>
                      <td valign="top" align="left" style=" border-right:1px solid #666; border-top: none; border-bottom:none;width:15%;font-weight:bold">Attached(Y/N):</td>
                      <td valign="top" align="left" style="border-top: none; border-bottom:none;width:30%"><?=$data[0]->attached?> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
        <td colspan="10" class="heading"   style="background:#ececec" align="center"> Accounts ( To be filled  by Accountant )</td>
        </tr>
        <tr>
         <td width="1" align="center" valign="center" style="font-weight:bold"> Invoice Date: </td>
         <td colspan="1" align="center" valign="center" ><?= date('d-m-Y' ,strtotime($data[0]->invoice_date)) ?> </td>
         <td colspan="1" align="center" valign="center" style="font-weight:bold">Invoice No: </td>
         <td colspan="4" align="center" valign="center" ><?=$data[0]->invoice_no?></td>
         <td colspan="1" align="center" valign="center" style="font-weight:bold"> Type Of Use:</td>
         <td colspan="2" align="center" valign="center"><?=$data[0]->type_use?></td>
        </tr>
      
      <tr>
        <td colspan="10"   class="heading" style="background:#ececec" align="center">&nbsp </td>
      </tr> 
        <tr style="font-size:12px; font-weight:500; ">
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
            <td width="125" align="center" valign="top"><?=$payment_voucher[$i]->qty?></td>
            <td width="115" align="center" valign="top"><?=$payment_voucher[$i]->rate?></td>
            <td width="138" align="center" valign="top"><?=$payment_voucher[$i]->amount?></td>
          <td width="115" align="center" valign="top"><?=$payment_voucher[$i]->tax_per?></td>
            <td width="115" align="center" valign="top"><?=$payment_voucher[$i]->cgst_amt?></td>
        
            <td width="115" align="center" valign="top"><?=$payment_voucher[$i]->sgst_amt?></td>
            <td width="115" align="center" valign="top"><?=$payment_voucher[$i]->igst_amt?></td>

            <td width="138" align="center" valign="top"><?=$payment_voucher[$i]->total_amt?></td>
        </tr>
        <?php } ?>
		<tr style="font-size:12px; font-weight:500; background:#ececec ">
            <td width="61" align="center" valign="top"></td>
            <td width="285" align="center" valign="top"> Total </td>
            <td width="125" align="center" valign="top">  </td>
            <td width="115" align="center" valign="top">  </td>
            <td width="138" align="center" valign="top"></td>
          <td width="115" align="center" valign="top">  </td>
            <td width="115" align="center" valign="top">  </td>
        
            <td width="115" align="center" valign="top">  </td>
            <td width="115" align="center" valign="top">  </td>

            <td width="138" align="center" valign="top"><?=$data[0]->final_amount?></td>
        </tr>   
      
      
     
    <tr style="border-top: 1px solid #666;">
          <td colspan="5" rowspan="3" valign="top">
            
              <p style="margin:0;text-align:left;line:height:22px;font-size:22px;"><span style="  font-size:14px; font-weight:bold;    margin-top: 5px;display: block;" >Remarks:</p> 
            
          </td>

          <td colspan="4" valign="top" style="font-size:10px; font-weight:900;">Invoice Amount</td>
          <td style=" font-size:10px; font-weight:900"   >  
            <span style="text-align:left; float:left"><?=$data[0]->final_amount?></span> 
            <span style="text-align:right; float:right"> </span> 
          </td>
    </tr>
    <tr>
       <td colspan="4" valign="top" style="font-size:10px; font-weight:500;">(-) TDS <?=$data[0]->tds_per?> %</td>
          <td style=" font-size:10px; font-weight:500;"  >  
            <span style="text-align:left; float:left"><?=$data[0]->tdsamount ?> </span> 
            <span style="text-align:right; float:right"></span> 
          </td>
    </tr>
    <tr>
        <td colspan="4" valign="top" style="font-size:10px; font-weight:900;">Total Payable</td>
        <td style=" font-size:10px; font-weight:500;"  >  
          <span style="text-align:left; float:left"><?=$data[0]->total_payable?></span> 
          <span style="text-align:right; float:right"></span> 
        </td>
    </tr>

    <tr style="border-top: 1px solid #666;">
      <td colspan="2" rowspan="2" valign="center">
             <p style="margin:0;text-align:left;line:height:22px;font-weight:bold; ">Journal Voucher No</p> 
            
      </td>   
      <td colspan="3" rowspan="2" valign="top" style="padding:0;">
             <p style="margin:0;text-align:left;line:height:22px;font-size:22px;"><span style="  font-size:18px; font-weight:bold;    margin-top: 5px;display: block;" ></p> 
            
      </td>         
      <td colspan="6" valign="top" style="font-size:10px; font-weight:500;"> &nbsp </td>
      
  </tr>
  <tr>
    <td colspan="6" valign="top" style="font-size:10px; font-weight:500;"> &nbsp </td>
  </tr>
  <tr>
        <td colspan="10"   class="heading" style="background:#ececec" align="center"> Payment Details</td>
  </tr> 
  
   <tr>
   <td colspan="10" valign="top" style="line-height:20px; padding:0;"> 
		<table width="100%"  border="0" cellspacing="0" style="border-color:#666" >
                    
					
  
    
				  <tr class="payment_head">
						<td  align="center"> Payment Mode</td>
						<td  align="center"> Cheque No </td>
						<td  align="center"> Payment Date</td>
						<td  align="center" style="border-right:none"> Payment Voucher No</td>
				  </tr>   
					
				  <tr class="payment_head1">
						<td  align="center"><input type="checkbox" name="Online" value="Online" disabled > Online &nbsp  &nbsp <input type="checkbox" name="Cheque" value="Cheque" disabled > Cheque </td>
						<td  align="center">  </td>
						<td   align="center"> </td>
						<td   align="center" style="border-right:none"> </td>
				  </tr> 
					
				  <tr  style="background:#ececec " class="heading payment_head1 ">
						<td   align="center"> Prepared By </td>
						<td   align="center"> Checked By </td>
						<td   align="center"> Verified By</td>
						<td   align="center" style="border-right:none"> Approved By</td>
				  </tr> 
					
					
				  <tr style="" class="name">
						<td  align="center">Name:  <?=$data[0]->user_name?></td>
						<td  align="center">Name:  ___________________________</td>
						<td  align="center">Name:  ___________________________</td>
						<td  align="center" style="border-right:none">Name:  ___________________________</td>
				  </tr> 
				  <tr style="" class="sign">
						<td  align="center">Sign:  _____________________________</td>
						<td  align="center">Sign:  _____________________________</td>
						<td  align="center">Sign:  _____________________________</td>
						<td  align="center" style="border-right:none">Sign: _____________________________</td>
				  </tr> 
				   
		</table> </td></tr>
    </table>
</div>
</body>
</html>
