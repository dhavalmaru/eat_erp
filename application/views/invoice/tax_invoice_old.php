<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tax Invoice</title>
<style>
@font-face {
    font-family: "OpenSans-Regular";
    src: url("<?php echo base_url().'/assets/invoice/'; ?>OpenSans-Regular.ttf") format("truetype");
}
 
  @media print{@page {size: landscape}}
  body { font-family: "verdana"; font-size:8px; font-weight:500; margin:0; line-height:11px;}
 
</style>

</head>

<body style="margin: 1px;">
<div style="width:512px;  float:left; margin-right:20px;   ">
<table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:512px; margin:auto; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:8px; font-weight:400; border:1px solid #666;"    >

  <col width="43" />
  <col width="115" />
  <col width="110" />
  <col width="112" />
  <col width="83" />
  <col width="92" />
  <col width="95" />
  <col width="64" />
  <tr>
    <td colspan="6" align="left" valign="top" style="padding:0;">
      <table width="100%" border="0">
      <tr>
        <td width="40%"><img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt=""  height="42" /></td>
          <td width="60%" style="color:#808080;"   ><h1 style="padding:0; margin:0; font-size:20px;">Tax Invoice</h1></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="6" valign="top" style="line-height:12px; padding:0;"> 
    <table width="100%"  border="0" cellspacing="0" cellpadding="5"  style="border-collapse: collapse;    ">
      <tr style="border-bottom:1px solid #666; height: 30px;"  >
        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:1px solid #666; ">
          <p style="margin:0;">
            <span style="  font-size:8px; font-weight:500;" >Wholesome Habits Pvt Ltd</span>
            <br />B-505, Veena sur, Mahavir
            <br /> Nagar Kandivali-West,
            <br /> Mumbai - 67 
            <br /> +91 8268000456 
          </p>
          <p><a href="mailto:cs@eatanytime.in">cs@eatanytime.in</a></p>
        </td>
        <td width="25%" valign="top" style="line-height:12px;  border-right:1px solid #666; border-left:1px solid #666; border-bottom:1px solid #666; ">
          <p style="margin:0;"> 
            <span style=" font-size:8px; font-weight:500;" > Invoice No.</span> 
            <br /> <?php if (isset($invoice_no)) echo $invoice_no; ?>
          </p>
        </td>
        <td width="25%" valign="top" style="line-height:12px; border-bottom:1px solid #666; ">
          <p style="margin:0;">  
            <span style=" font-size:8px; font-weight:500;" >Dated </span> <br /> 
            <?php if (isset($date_of_processing)) echo (($date_of_processing!=null && $date_of_processing!='')?date('d-M-y',strtotime($date_of_processing)):''); ?>
          </p>
        </td>
      </tr>
      <tr style="border-bottom:1px solid #666; height: 30px;">
        <td  valign="top" style="line-height:12px;  border-right:1px solid #666;  border-left:1px solid #666; border-bottom:1px solid #666; ">
          <p style="margin:0;">  <span style=" font-size:8px; font-weight:500;" >Buyer Order No.</span> <br /> 
            <?php if (isset($order_no)) echo $order_no; ?>
          </p>
        </td>
        <td valign="top" style="line-height:12px;">
          <p style="margin:0;">  <span style=" font-size:8px; font-weight:500;" >Dated </span> <br /> 
            <?php if (isset($order_date)) echo (($order_date!=null && $order_date!='')?date('d-M-y',strtotime($order_date)):''); ?>
          </p>
        </td>
      </tr>
  <tr style="border-bottom:1px solid #666; height: 30px;">
    <td valign="top" style="line-height:12px; border-bottom:1px solid #666; border-right:1px solid #666;  border-left:1px solid #666;">
      <p style="margin:0;"> <span style=" font-size:8px; font-weight:500;" >Supplier's Ref.</span> <br /> 
            <?php if (isset($supplier_ref)) echo $supplier_ref; ?>
          </p>
    </td>
    <td  valign="top" style="line-height:12px;">
      <p style="margin:0;"> <span style=" font-size:8px; font-weight:500;" >Despatch Document No.</span> <br /> 
            <?php if (isset($despatch_doc_no)) echo $despatch_doc_no; ?>
          </p>
    </td>
  </tr>
  <tr >
    <td rowspan="2"   valign="top" style="line-height:12px; height:50px; border-bottom:0; border-right:1px solid #666;">
      <p style="margin:0;"><span style="  font-size:8px; font-weight:500;" > Buyer </span> <br />
      <span style=" font-size:8px; font-weight:500;" > <?php if (isset($distributor_name)) echo $distributor_name; ?>	</span>
      <br /> <?php if (isset($address)) echo $address; ?>	</p>
    </td>
    <td   valign="top" style="line-height:12px; border-bottom:1px solid #666; border-left:1px solid #666; border-right:1px solid #666;">
      <p style="margin:0;"> <span style=" font-size:8px; font-weight:500;" >Despatched Through </span> <br /> 
            <?php if (isset($despatch_through)) echo $despatch_through; ?>
          </p>
    </td>
    <td   valign="top" style="line-height:12px;  border-bottom:1px solid #666;  ">
      <p style="margin:0;"> <span style=" font-size:8px; font-weight:500;" >Destination</span> <br /> 
            <?php if (isset($destination)) echo $destination; ?>
          </p>
    </td>
  </tr>
 
  <tr>
    <td colspan="2" rowspan="2"  >&nbsp;    </td>
  </tr>
  <tr>
    <td  valign="top" style="border:none;" >
      <p style="margin:0;" >
        <span style="  font-size:8px; font-weight:500;" >VAT/TIN: <?php if (isset($tin_number)) echo $tin_number; ?></span>
      </p>
    </td>
  </tr>
  
</table>  </td>

  </tr>
  <tr style="font-size:8px; font-weight:500;">
    <td width="75" align="center" valign="top">Sr No.</td>
    <td width="269" align="center" valign="top">Description</td>
    <td width="130" align="center" valign="top">MRP</td>
    <td width="122" align="center" valign="top">Quantity</td>
    <td width="130" align="center" valign="top">Selling Price</td>
    <td width="132" align="center" valign="top"> Amount </td>
  </tr>
  <?php if(isset($description)) { for($i=0; $i<count($description); $i++) { ?>
    <tr valign="top" style="border: none;">
      <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $i+1; ?></td>
      <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $description[$i]->description; ?></td>
      <td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $description[$i]->rate; ?></p></td>
      <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $description[$i]->qty; ?></p></td>
      <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $description[$i]->sell_rate; ?></p></td>
      <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($description[$i]->amount,2); ?></p></td>
    </tr>
  <?php }} ?>
  <!-- <tr valign="top" style="border: none;">
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
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
  </tr> -->
  <tr style="border-top: 1px solid #666;">
    <td colspan="3" rowspan="3" valign="top" style="padding:0;">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr style="font-size:8px; font-weight:500;">
          <td width="43%"> Company's VAT TIN </td>
          <td width="57%">: 27351176608V/27351176608C</td>
        </tr>
        <tr style="font-size:8px; font-weight:500;">
          <td>Company's Service Tax No</td>
          <td>:</td>
        </tr>
        <tr style="font-size:8px; font-weight:500;">
          <td>Company's    PAN</td>
          <td>: AABCW7811R</td>
        </tr>
      </table>
    </td>
    <td colspan="2" valign="top" style="border:0!important; font-size:8px; font-weight:500;">SUBTOTAL</td>
    <td style=" font-size:8px; font-weight:500;"   >  
      <span style="text-align:left; float:left"> &#8377; </span> 
      <span style="text-align:right; float:right"><?php if (isset($total_amount)) echo $total_amount; ?></span> 
    </td>
  </tr>
  <tr>
    <td colspan="2" valign="top" style="border:0!important; font-size:8px; font-weight:500;">DISCOUNT</td>
    <td style=" font-size:8px; font-weight:500;" >  
      <span style="text-align:left; float:left"> &#8377; </span> 
      <span style="text-align:right; float:right">-  </span> 
    </td>
  </tr>
  <tr>
    <td valign="top" style="border:0!important; font-size:8px; font-weight:500;">CST/VAT</td>
    <td valign="top" style="border:0!important; font-size:8px; font-weight:500; text-align:right;"><?php if (isset($tax_per)) echo strval($tax_per) . '%'; ?></td>
    <td style=" font-size:8px; font-weight:500;"  >  
      <span style="text-align:left; float:left"> &#8377; </span> 
      <span style="text-align:right; float:right"><?php if (isset($tax_amount)) echo $tax_amount; ?></span> 
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top"> 
      <p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >Amount in words: <br/> </span> <?php if (isset($total_amount_in_words)) echo $total_amount_in_words; ?></p> 
    </td>
    <td colspan="2" valign="middle" style="border:0!important; font-size:8px; font-weight:500;">
      <p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >Total</span></p>
    </td>
    <td  style=" font-size:8px; font-weight:500;" >  
      <span style="text-align:left; float:left"> &#8377; </span> 
      <span style="text-align:right; float:right"><?php if (isset($invoice_amount)) echo $invoice_amount; ?></span> 
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="middle" style="padding:0;">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        
        <tr>
          <td width="42%"><p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >Bank Name </span></td>
          <td width="58%"><span style=" font-size:8px; font-weight:500;" >: HDFC Bank </span></td>
        </tr>
          <tr>
            <td><p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >Branch  </span></p></td>
            <td><span style=" font-size:8px; font-weight:500;" >: Kandivali(w)</span></td>
          </tr>
          <tr>
            <td><p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >A/C No. </span></p></td>
            <td><span style=" font-size:8px; font-weight:500;" >: 50200018195231</span></td>
          </tr>
          <tr>
            <td><p style="margin:0;"><span style="  font-size:8px; font-weight:500;" > IFSC Code </span></p></td>
            <td><span style=" font-size:8px; font-weight:500;" >: HDFC0000288</span></td>
          </tr>
      </table>
     
  
  
      
      </td>
    <td colspan="3" align="center" valign="top" style=" font-size:8px; font-weight:500;"> For Wholsome Habits Pvt Ltd <br/> <img src="<?php echo base_url().'/assets/invoice/'; ?>stamp.jpg" height="50"  alt="Sign3 Rishit" /> <br/>Authorised Signatory</td>
  </tr>
  <tr>
    <td colspan="6" valign="top"><p style="line-height:11px; text-align:justify;   margin: 0; "> <span style="  font-size:8px; font-weight:500;" >Declaration:</span><br />
      I /We hereby certify that Registration Certificate under Maharashtra VAT    Act 2002(Act No. IX of 2005) (as amended by Maharashtra Ordinance no.1 of    2005 dated 09-03-2005) is in force on the date on which the sale of goods    specified in this bill/cash Memorandum has been effected by Me/Us in the    regular course of our business. It shall be accounted for in the turnover of    sales while filing return and the due tax, if any Payable on the sales has    been paid or shall be paid. I /We hereby certify that Registration    Certificate under Maharashtra VAT Act 2002(Act No. IX of 2005) (as amended by    Maharashtra Ordinance no.1 of 2005 dated 09-03-2005) is in force on the date    on which the sale of goods specified in this bill/cash Memorandum has been    effected by Me/Us in the regular course of our business. It shall be    accounted for in the turnover of sales while filing return and the due tax,    if any Payable on the sales has been paid or shall be paid. </p></td>
  </tr>
</table>
<p style="text-align:center; font-family:OpenSans-Regular, Arcon,Verdana, Geneva, sans-serif; font-size:8px; line-height:11px; margin-top:3px; margin-bottom:0;  ">SUBJECT TO MUMBAI JURISDICTION <br />
This is a Computer Generated Invoice</p>
</div>




<div style="width:512px;  float:left;   ">
<table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:512px; margin:auto; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:8px; font-weight:400; border:1px solid #666;"    >

  <col width="43" />
  <col width="115" />
  <col width="110" />
  <col width="112" />
  <col width="83" />
  <col width="92" />
  <col width="95" />
  <col width="64" />
  <tr>
    <td colspan="6" align="left" valign="top" style="padding:0;">
      <table width="100%" border="0">
      <tr>
        <td width="40%"><img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt=""  height="42" /></td>
          <td width="60%" style="color:#808080;"   ><h1 style="padding:0; margin:0; font-size:20px;">Tax Invoice</h1></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="6" valign="top" style="line-height:12px; padding:0;"> 
    <table width="100%"  border="0" cellspacing="0" cellpadding="5"  style="border-collapse: collapse;    ">
      <tr style="border-bottom:1px solid #666; height: 30px;"  >
        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:1px solid #666; ">
          <p style="margin:0;">
            <span style="  font-size:8px; font-weight:500;" >Wholesome Habits Pvt Ltd</span>
            <br />B-505, Veena sur, Mahavir
            <br /> Nagar Kandivali-West,
            <br /> Mumbai - 67 
            <br /> +91 8268000456 
          </p>
          <p><a href="mailto:cs@eatanytime.in">cs@eatanytime.in</a></p>
        </td>
        <td width="25%" valign="top" style="line-height:12px;  border-right:1px solid #666; border-left:1px solid #666; border-bottom:1px solid #666; ">
          <p style="margin:0;"> 
            <span style=" font-size:8px; font-weight:500;" > Invoice No.</span> 
            <br /> <?php if (isset($invoice_no)) echo $invoice_no; ?>
          </p>
        </td>
        <td width="25%" valign="top" style="line-height:12px; border-bottom:1px solid #666; ">
          <p style="margin:0;">  
            <span style=" font-size:8px; font-weight:500;" >Dated </span> <br /> 
            <?php if (isset($date_of_processing)) echo (($date_of_processing!=null && $date_of_processing!='')?date('d-M-y',strtotime($date_of_processing)):''); ?>
          </p>
        </td>
      </tr>
      <tr style="border-bottom:1px solid #666; height: 30px;">
        <td  valign="top" style="line-height:12px;  border-right:1px solid #666;  border-left:1px solid #666; border-bottom:1px solid #666; ">
          <p style="margin:0;">  <span style=" font-size:8px; font-weight:500;" >Buyer Order No.</span> <br /> 
            <?php if (isset($order_no)) echo $order_no; ?>
          </p>
        </td>
        <td valign="top" style="line-height:12px;">
          <p style="margin:0;">  <span style=" font-size:8px; font-weight:500;" >Dated </span> <br /> 
            <?php if (isset($order_date)) echo (($order_date!=null && $order_date!='')?date('d-M-y',strtotime($order_date)):''); ?>
          </p>
        </td>
      </tr>
  <tr style="border-bottom:1px solid #666; height: 30px;">
    <td valign="top" style="line-height:12px; border-bottom:1px solid #666; border-right:1px solid #666;  border-left:1px solid #666;">
      <p style="margin:0;"> <span style=" font-size:8px; font-weight:500;" >Supplier's Ref.</span> <br /> 
            <?php if (isset($supplier_ref)) echo $supplier_ref; ?>
          </p>
    </td>
    <td  valign="top" style="line-height:12px;">
      <p style="margin:0;"> <span style=" font-size:8px; font-weight:500;" >Despatch Document No.</span> <br /> 
            <?php if (isset($despatch_doc_no)) echo $despatch_doc_no; ?>
          </p>
    </td>
  </tr>
  <tr >
    <td rowspan="2"   valign="top" style="line-height:12px; height:50px; border-bottom:0; border-right:1px solid #666;">
      <p style="margin:0;"><span style="  font-size:8px; font-weight:500;" > Buyer </span> <br />
      <span style=" font-size:8px; font-weight:500;" > <?php if (isset($distributor_name)) echo $distributor_name; ?>	</span>
      <br /> <?php if (isset($address)) echo $address; ?>	</p>
    </td>
    <td   valign="top" style="line-height:12px; border-bottom:1px solid #666; border-left:1px solid #666; border-right:1px solid #666;">
      <p style="margin:0;"> <span style=" font-size:8px; font-weight:500;" >Despatched Through </span> <br /> 
            <?php if (isset($despatch_through)) echo $despatch_through; ?>
          </p>
    </td>
    <td   valign="top" style="line-height:12px;  border-bottom:1px solid #666;  ">
      <p style="margin:0;"> <span style=" font-size:8px; font-weight:500;" >Destination</span> <br /> 
            <?php if (isset($destination)) echo $destination; ?>
          </p>
    </td>
  </tr>
 
  <tr>
    <td colspan="2" rowspan="2"  >&nbsp;    </td>
  </tr>
  <tr>
    <td  valign="top" style="border:none;" >
      <p style="margin:0;" >
        <span style="  font-size:8px; font-weight:500;" >VAT/TIN: <?php if (isset($tin_number)) echo $tin_number; ?></span>
      </p>
    </td>
  </tr>
  
</table>  </td>

  </tr>
  <tr style="font-size:8px; font-weight:500;">
    <td width="75" align="center" valign="top">Sr No.</td>
    <td width="269" align="center" valign="top">Description</td>
    <td width="130" align="center" valign="top">MRP</td>
    <td width="122" align="center" valign="top">Quantity</td>
    <td width="130" align="center" valign="top">Selling Price</td>
    <td width="132" align="center" valign="top"> Amount </td>
  </tr>
  <?php if(isset($description)) { for($i=0; $i<count($description); $i++) { ?>
    <tr valign="top" style="border: none;">
      <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $i+1; ?></td>
      <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $description[$i]->description; ?></td>
      <td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $description[$i]->rate; ?></p></td>
      <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $description[$i]->qty; ?></p></td>
      <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $description[$i]->sell_rate; ?></p></td>
      <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($description[$i]->amount,2); ?></p></td>
    </tr>
  <?php }} ?>
  <!-- <tr valign="top" style="border: none;">
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
    <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
  </tr> -->
  <tr style="border-top: 1px solid #666;">
    <td colspan="3" rowspan="3" valign="top" style="padding:0;">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr style="font-size:8px; font-weight:500;">
          <td width="43%"> Company's VAT TIN </td>
          <td width="57%">: 27351176608V/27351176608C</td>
        </tr>
        <tr style="font-size:8px; font-weight:500;">
          <td>Company's Service Tax No</td>
          <td>:</td>
        </tr>
        <tr style="font-size:8px; font-weight:500;">
          <td>Company's    PAN</td>
          <td>: AABCW7811R</td>
        </tr>
      </table>
    </td>
    <td colspan="2" valign="top" style="border:0!important; font-size:8px; font-weight:500;">SUBTOTAL</td>
    <td style=" font-size:8px; font-weight:500;"   >  
      <span style="text-align:left; float:left"> &#8377; </span> 
      <span style="text-align:right; float:right"><?php if (isset($total_amount)) echo $total_amount; ?></span> 
    </td>
  </tr>
  <tr>
    <td colspan="2" valign="top" style="border:0!important; font-size:8px; font-weight:500;">DISCOUNT</td>
    <td style=" font-size:8px; font-weight:500;" >  
      <span style="text-align:left; float:left"> &#8377; </span> 
      <span style="text-align:right; float:right">-  </span> 
    </td>
  </tr>
  <tr>
    <td valign="top" style="border:0!important; font-size:8px; font-weight:500;">CST/VAT</td>
    <td valign="top" style="border:0!important; font-size:8px; font-weight:500; text-align:right;"><?php if (isset($tax_per)) echo strval($tax_per) . '%'; ?></td>
    <td style=" font-size:8px; font-weight:500;"  >  
      <span style="text-align:left; float:left"> &#8377; </span> 
      <span style="text-align:right; float:right"><?php if (isset($tax_amount)) echo $tax_amount; ?></span> 
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top"> 
      <p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >Amount in words: <br/> </span> <?php if (isset($total_amount_in_words)) echo $total_amount_in_words; ?></p> 
    </td>
    <td colspan="2" valign="middle" style="border:0!important; font-size:8px; font-weight:500;">
      <p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >Total</span></p>
    </td>
    <td  style=" font-size:8px; font-weight:500;" >  
      <span style="text-align:left; float:left"> &#8377; </span> 
      <span style="text-align:right; float:right"><?php if (isset($invoice_amount)) echo $invoice_amount; ?></span> 
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="middle" style="padding:0;">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        
        <tr>
          <td width="42%"><p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >Bank Name </span></td>
          <td width="58%"><span style=" font-size:8px; font-weight:500;" >: HDFC Bank </span></td>
        </tr>
          <tr>
            <td><p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >Branch  </span></p></td>
            <td><span style=" font-size:8px; font-weight:500;" >: Kandivali(w)</span></td>
          </tr>
          <tr>
            <td><p style="margin:0;"><span style="  font-size:8px; font-weight:500;" >A/C No. </span></p></td>
            <td><span style=" font-size:8px; font-weight:500;" >: 50200018195231</span></td>
          </tr>
          <tr>
            <td><p style="margin:0;"><span style="  font-size:8px; font-weight:500;" > IFSC Code </span></p></td>
            <td><span style=" font-size:8px; font-weight:500;" >: HDFC0000288</span></td>
          </tr>
      </table>
     
  
  
      
      </td>
    <td colspan="3" align="center" valign="top" style=" font-size:8px; font-weight:500;"> For Wholsome Habits Pvt Ltd <br/> <img src="<?php echo base_url().'/assets/invoice/'; ?>stamp.jpg" height="50"  alt="Sign3 Rishit" /> <br/>Authorised Signatory</td>
  </tr>
  <tr>
    <td colspan="6" valign="top"><p style="line-height:11px; text-align:justify;     margin: 0;"> <span style="  font-size:8px; font-weight:500;" >Declaration:</span><br />
      I /We hereby certify that Registration Certificate under Maharashtra VAT    Act 2002(Act No. IX of 2005) (as amended by Maharashtra Ordinance no.1 of    2005 dated 09-03-2005) is in force on the date on which the sale of goods    specified in this bill/cash Memorandum has been effected by Me/Us in the    regular course of our business. It shall be accounted for in the turnover of    sales while filing return and the due tax, if any Payable on the sales has    been paid or shall be paid. I /We hereby certify that Registration    Certificate under Maharashtra VAT Act 2002(Act No. IX of 2005) (as amended by    Maharashtra Ordinance no.1 of 2005 dated 09-03-2005) is in force on the date    on which the sale of goods specified in this bill/cash Memorandum has been    effected by Me/Us in the regular course of our business. It shall be    accounted for in the turnover of sales while filing return and the due tax,    if any Payable on the sales has been paid or shall be paid. </p></td>
  </tr>
</table>
<p style="text-align:center; font-family:OpenSans-Regular, Arcon,Verdana, Geneva, sans-serif; font-size:8px; line-height:11px;  margin-top:3px; margin-bottom:0;  ">SUBJECT TO MUMBAI JURISDICTION <br />
This is a Computer Generated Invoice</p>
</div>


 
 
</body>
</html>