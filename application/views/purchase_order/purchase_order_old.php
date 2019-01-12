<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order</title>
<style>
@font-face {
    font-family: "OpenSans-Regular";
    src: url( OpenSans-Regular.ttf) format("truetype");
}

 
</style>
</head>

<body>
<table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; margin:auto; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:14px; font-weight:400; border:1px solid #666;"    >
  <col width="43" />
  <col width="115" />
  <col width="110" />
  <col width="112" />
  <col width="83" />
  <col width="92" />
  <col width="95" />
  <col width="64" />
  <tr>
    <td colspan="6" align="left" valign="top" style="padding:0;"><table width="100%" border="0">
      <tr>
        <td width="40%"><img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt="" width="247" height="68" /></td>
          <td width="60%" style="color:#808080;"   ><h1 style="padding:0; margin:0; font-size:40px;">Purchase Order</h1></td>
        </tr>
    </table></td>
  </tr>
   <tr>
     <td colspan="6" valign="top" style="line-height:20px; padding:0;"> <table width="100%"  border="0" cellspacing="0" cellpadding="5"  style="border-collapse: collapse;    ">
  <tr style="border-bottom:1px solid #666;"  >
    <td width="40%" style="line-height:20px; border-bottom:1px solid #666; "><p style="margin:0;"><span style=" font-size:15px; font-weight:500;" >Wholesome Habits Pvt Ltd</span><br />B-505, Veena sur, Mahavir<br /> NagarKandivali-West,<br /> 
      Mumbai - 67 <br /> +91 8268000456 <br /> VAT/TIN: 27351176608V/27351176608C <br /> <a href="mailto:cs@eatanytime.in">cs@eatanytime.in</a> </p>
    </td>
    <td width="30%" valign="top" style="line-height:20px;  border-right:1px solid #666; border-left:1px solid  ">
      <p style="margin:0;"> <span style=" font-size:14px; font-weight:500;" > P.O. No.</span> <br /> 
        <?php if (isset($order_no)) echo $order_no; ?>
      </p>
    </td>
    <td width="30%" valign="top" style="line-height:20px;">
      <p style="margin:0;">  <span style=" font-size:14px; font-weight:500;" >Dated </span><br /> 
        <?php if (isset($order_date)) echo (($order_date!=null && $order_date!='')?date('d-M-y',strtotime($order_date)):''); ?>
      </p>
    </td>
  </tr>
  <tr >
    <td   valign="top" style="line-height:20px; height:100px; border-bottom:0; border-right:1px solid #666; word-wrap: break-word;">
      <p style="margin:0;"><span style="font-size:15px; font-weight:500;" > Vendor </span> <br />
        <span style=" font-size:14px; font-weight:500;" > <?php if (isset($vendor_name)) echo $vendor_name; ?>	</span><br /> 
        <?php if (isset($vendor_address)) echo $vendor_address; ?>
      </p>
    </td>
    <td colspan="2" rowspan="2"   valign="top" style="line-height:18px; border-bottom:0px solid #666; border-right:1px solid #666;">
      <p style="margin:0;"> <span style="font-size:14px; font-weight:500;" >Ship To </span><br />
        <?php if (isset($depot_contact_person)) echo $depot_contact_person; ?><br />
        <?php if (isset($depot_name)) echo $depot_name; ?><br />
        <?php if (isset($depot_address)) echo $depot_address; ?>
      </p>      
      <p style="margin:0;"> <span style="font-size:14px; font-weight:500;" > </span></p>    </td>
  </tr>
  
  <tr>
    <td  valign="top" style="border:none;" >
      <p style="margin:0;" ><span style=" font-size:15px; font-weight:500;" >VAT/TIN:</span> 
        <?php if (isset($vendor_tin_number)) echo $vendor_tin_number; ?>
      </p>
    </td>
  </tr>
  
</table>  </td>
  </tr>
   <tr style="font-size:14px; font-weight:500;  " >
     <td colspan="6" align="center" valign="top">&nbsp;</td>
   </tr>
   <tr style="font-size:14px; font-weight:500; ">
     <td colspan="6" align="center" valign="top"   style="margin:0; padding:0;   "> <table width="100%" border="1" cellspacing="0" cellpadding="5"  style=" border-collapse:collapse;border:none;">
  <tr style="font-size:14px; font-weight:500;"  >
    <td align="center" style="    border-color:#666; border-top: none;    border-left: none;" > Shipping Method</td>
    <td align="center" style="    border-color:#666;  border-top: none;   border-left: none;"> Shipping Terms</td>
    <td align="center" style="    border-color: #666; border-top: none;    border-right: none;">Delivery Date</td>
  </tr>
  <tr style=" " >
    <td align="center" style="    border-color:#666;  border-bottom: none;    border-left: none;" ><?php if (isset($shipping_method)) echo $shipping_method; ?></td>
    <td align="center" style="    border-color:#666;   border-bottom: none;    border-left: none;"><?php if (isset($shipping_term)) echo $shipping_term; ?></td>
    <td align="center" style="    border-color: #666;   border-bottom: none;    border-right: none;"><?php if (isset($delivery_date)) echo (($delivery_date!=null && $delivery_date!='')?date('d-M-y',strtotime($delivery_date)):''); ?></td>
  </tr>
 
</table>
</td>
   </tr>
   <tr style="font-size:14px; font-weight:500;">
    <td colspan="6" align="center" valign="top">&nbsp; </td>
  </tr>
  
  <tr style="font-size:14px; font-weight:500;">
    <td width="60" align="center" valign="top">Sr. No.</td>
    <td width="278" align="center" valign="top">Item</td>
    <td width="130" align="center" valign="top">Quantity</td>
    <td width="116" align="center" valign="top">Rate</td>
    <td width="113" align="center" valign="top">Tax</td>
    <td width="132" align="center" valign="top"> Amount </td>
  </tr>
  <?php if(isset($items)) { for($i=0; $i<count($items); $i++) { ?>
    <tr valign="top" style="border: none;">
      <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $i+1; ?></td>
      <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $items[$i]->rm_name; ?></td>
      <td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $items[$i]->qty; ?></p></td>
      <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $items[$i]->rate; ?></p></td>
      <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $items[$i]->tax_per; ?></p></td>
      <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($items[$i]->amount,2); ?></p></td>
    </tr>
  <?php }} ?>
  <tr valign="top" style="border: none;">
    <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
    <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
    <td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
  </tr>
  <tr valign="top" style="border: none;">
    <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
    <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
    <td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
  </tr>
  <tr valign="top" style="border: none;">
    <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
    <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
    <td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:1px solid #666;"><p style="margin:0; ">  </p></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" style="padding:0;">&nbsp;</td>
    <td colspan="2" valign="top" style="font-size:14px; font-weight:500;"> TOTAL</td>
    <td style=" font-size:14px; font-weight:500;"   >  <span style="text-align:left; float:left"> &#8377; </span> <span style="text-align:right; float:right"><?php if (isset($total_amount)) echo round($total_amount,2); ?></span> </td>
  </tr>
  <tr>
      <td colspan="6" valign="top" style="font-size:14px; font-weight:500;"> Remarks: <?php if (isset($remarks)) echo $remarks; ?></td>
  </tr>
  <tr>
    <td colspan="3" valign="middle" style="padding:0;">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        
        <tr>
          <td width="7%" align="center" valign="top"><p style="margin:0;">1.</td>
          <td width="93%" valign="top"><strong><span style="font-size:14px; font-weight:500;" >Please send two copies of your invoice </span></strong></td>
        </tr>
          <tr>
            <td align="center" valign="top"><p style="margin:0;">2.</p></td>
            <td valign="top"><strong><span style="font-size:14px; font-weight:500;" >Enter this order in accordance with the price, terms, delivery method, and specifications listed above.</span></strong></td>
          </tr>
          <tr>
            <td align="center" valign="top"><p style="margin:0;">3.</p></td>
            <td valign="top"><strong><span style=" font-size:14px; font-weight:500;" >Please notify us immediately if you are unable to ship as specified.</span></strong></td>
          </tr>
          <tr>
            <td align="center" valign="top"><p style="margin:0;">4.</p></td>
            <td valign="top"><p style="font-size:14px; font-weight:500; margin:0;"><span style="margin:0;">Wholesome Habits Pvt Ltd<br />
              B-505, Veena sur, Mahavir<br />
NagarKandivali-West,<br />
Mumbai - 67 <br />
+91 8268000456 </span></p></td>
          </tr>
      </table>
     
  
  
      
    </td>
    <td colspan="3" align="center" valign="middle" style=" font-size:14px; font-weight:500;"> For Wholsome Habits Pvt Ltd <br/> <img src="<?php echo base_url().'/assets/invoice/'; ?>stamp.jpg" height="95"  alt="Sign3 Rishit" /> <br/>Authorised Signatory</td>
  </tr>
</table>
<p style="text-align:center; font-family:OpenSans-Regular, Arcon,Verdana, Geneva, sans-serif; font-size:12px; line-height:18px;">&nbsp;</p>
</body>
</html>
