<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tax Invoice</title>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/fontawesome/font-awesome.min.css'; ?>"/>
<style>
    @font-face {
        font-family: "OpenSans-Regular";
        src: url("<?php echo base_url().'/assets/invoice/'; ?>OpenSans-Regular.ttf") format("truetype");
    }
    @media print{@page {size: portrait}}
    @media print {
        .page-break { display: block; page-break-after: always; }
    }
    body { font-family: "verdana"; font-size:8px; font-weight:500; margin:0; line-height:11px;}
</style>
</head>

<body style="margin: 1px;">
    <?php $inv_cnt=0; ?>
    <div style="width:100%;  float:left; margin-right:20px;   ">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:150px;" />
            <p style="font-size:12px;line-height:18px;margin:0;margin-bottom:10px;">
                C/109, Hind Saurashtra Ind. Estate. 85/86, Andheri Kurla Road, Marol Naka, Andheri East. Mumbai 400059
                <br /> +91 8268000456 
                <br><a href="mailto:cs@eatanytime.in">cs@eatanytime.in</a><br>
                GSTIN: 27AABCW7811R1ZN
            </p>
        </center>
        <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:100%; margin:auto; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:8px; font-weight:400; border:1px solid #666;"    >

        <col width="43" />
        <col width="115" />
        <col width="110" />
        <col width="112" />
        <col width="83" />
        <col width="92" />
        <col width="95" />
        <col width="64" />
        <tr>
            <td colspan="6" align="left" valign="top" style="padding:0;border-spacing: 0;">
                <table width="100%" border="0" style="border-spacing: 0;">
                    <tr>
                        <td width="60%" style="color:#808080;margin:0 auto;text-align:center;"   ><h1 style="padding:0; margin:0; font-size:20px;">Tax Invoice</h1></td>
                        <td width="2%">
                            <table style="width:115%;border-collapse: collapse;height: 30px;border-spacing: 0;">
                                <tr><td style="border: 1px solid #666;width:100%;border-top:none;border-right:none;border-bottom:none;">&nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-check"></span><td></tr>
                                <tr><td style="border: 1px solid #666;width:100%;border-right:none;">&nbsp;<td></tr>
                                <tr><td style="border: 1px solid #666;width:100%;border-bottom:none;border-right:none;border-top:none;">&nbsp;<td></tr>
                            </table>
                        </td>
                        <td width="20%">
                            <table style="width:101%;border-collapse: collapse;height: 30px;border-spacing: 0;">
                                <tr><td style="border:1px solid #666;width:100%;border-top:none;border-right:none;border-bottom:none;">Accounts<td></tr>
                                <tr><td style="border:1px solid #666;width:100%;border-right:none;">Retailer<td></tr>
                                <tr><td style="border:1px solid #666;width:100%;border-bottom:none;border-right:none;border-top:none;">Acknowledgement<td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="6" valign="top" style="line-height:12px; padding:0;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                    <tr style="border-bottom:0px solid #666; height: 30px;"  >
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; ">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Reverse Charge:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['reverse_charge'])) echo $invoice_details[$inv_cnt]['reverse_charge']; ?></td>
                                </tr>
                                <tr>
                                    <td>Invoice No: </td><td><?php if (isset($invoice_details[$inv_cnt]['invoice_no'])) echo $invoice_details[$inv_cnt]['invoice_no']; ?></td>
                                </tr>
                                <tr>
                                    <td>Invoice Date: </td><td><?php if (isset($invoice_details[$inv_cnt]['invoice_date'])) echo (($invoice_details[$inv_cnt]['invoice_date']!=null && $invoice_details[$inv_cnt]['invoice_date']!='')?date('d-M-y',strtotime($invoice_details[$inv_cnt]['invoice_date'])):''); ?></td>
                                </tr>
                                <tr >
                                    <td>State: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['depot_state'])) echo $invoice_details[$inv_cnt]['depot_state']; ?>
                                        <table style="float: right;border-collapse:collapse;margin-right:10px;">
                                            <tr style="border-top:1px solid #666;">
                                                <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px;" align="right">State Code: &nbsp;</td>
                                                <td style="border-right:1px solid #666;width:20px;text-align:center;"><?php if (isset($invoice_details[$inv_cnt]['depot_state_code'])) echo $invoice_details[$inv_cnt]['depot_state_code']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top" style="line-height:12px;  border-right:1px solid #666; border-left:1px solid #666; border-bottom:1px solid #666; border-right:none;">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Transporter Mode:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['transport_type'])) echo $invoice_details[$inv_cnt]['transport_type']; ?></td>
                                </tr>
                               
								 <tr>
                                    <td>PO Number: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['order_no'])) echo $invoice_details[$inv_cnt]['order_no']; ?></td>
                                </tr>
                                <tr>
                                    <td>Date of Supply: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['date_of_processing'])) echo (($invoice_details[$inv_cnt]['date_of_processing']!=null && $invoice_details[$inv_cnt]['date_of_processing']!='')?date('d-M-y',strtotime($invoice_details[$inv_cnt]['date_of_processing'])):''); ?></td>
                                </tr>
                                <tr >
                                    <td>Place of Supply: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['depot_state'])) echo $invoice_details[$inv_cnt]['depot_state']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr><td colspan="6"></td></tr>
        <tr>
            <td colspan="6" valign="top" style="line-height:12px; padding:0;border-bottom:none;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                    <tr style="border-bottom:0px solid #666; height: 20px;"  >
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; text-align:center;border-right:1px solid #666;font-weight:bolder;">
                            Details of Receiver | Billed to:
                        </td>
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666;text-align:center; font-weight:bolder;">
                            Details of Consignee | Shipped to:
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="6" valign="top" style="line-height:12px; padding:0;border-bottom:none;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                    <tr style="border-bottom:0px solid #666; height: 30px;"  >
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; ">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Name:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['distributor_name'])) echo $invoice_details[$inv_cnt]['distributor_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Address: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['address'])) echo $invoice_details[$inv_cnt]['address']; ?></td>
                                </tr>
                                <tr>
                                    <td>GSTIN: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['gst_number'])) echo $invoice_details[$inv_cnt]['gst_number']; ?></td>
                                </tr>
                                <tr >
                                    <td>State: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['state'])) echo $invoice_details[$inv_cnt]['state']; ?>
                                        <table style="float: right;border-collapse:collapse;margin-right:10px;">
                                            <tr style="border-top:1px solid #666;">
                                                <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px;" align="right">State Code: &nbsp;</td>
                                                <td style="border-right:1px solid #666;width:20px;text-align:center;"><?php if (isset($invoice_details[$inv_cnt]['state_code'])) echo $invoice_details[$inv_cnt]['state_code']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top" style="line-height:12px;  border-right:1px solid #666; border-left:1px solid #666; border-bottom:1px solid #666;border-right:none; ">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Name:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_name'])) echo $invoice_details[$inv_cnt]['con_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Address: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_address'])) echo $invoice_details[$inv_cnt]['con_address']; ?></td>
                                </tr>
                                <tr>
                                    <td>GSTIN: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_gst_number'])) echo $invoice_details[$inv_cnt]['con_gst_number']; ?></td>
                                </tr>
                                <tr >
                                    <td>State: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_state'])) echo $invoice_details[$inv_cnt]['con_state']; ?>
                                        <table style="float: right;border-collapse:collapse;margin-right:10px;">
                                            <tr style="border-top:1px solid #666;">
                                                <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px;" align="right">State Code: &nbsp;</td>
                                                <td style="border-right:1px solid #666;width:20px;text-align:center;"><?php if (isset($invoice_details[$inv_cnt]['con_state_code'])) echo $invoice_details[$inv_cnt]['con_state_code']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>

        <tr style="font-size:8px; font-weight:500;">
        <td colspan="6" style="padding: 0;">
        <table style="width:100%;" width="100%"  border="0" cellspacing="0" cellpadding="2" style="border-collapse: collapse;">
            <tr style="background:#ececec;">
                <td width="20" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Sr No.</td>
                <td width="600" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Name of Product / Service</td>
                <td width="50" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">HSN ACS</td>
                <td width="50" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">UOM</td>
                <td width="20" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Qty</td>
                <td width="60"  align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Rate</td>
                <td width="60" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;"> Amount </td>
                <td width="60" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Less Discount</td>
                <td width="60" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Taxable Value</td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;"><tr><td colspan="2" style="text-align: center;">CGST</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td>
                        </tr>
                    </table>
                </td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;">
                        <tr>
                            <td colspan="2" style="text-align: center;">SGST</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td>
                        </tr>
                    </table>
                </td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;">
                        <tr>
                            <td colspan="2" style="text-align: center;">IGST</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td>
                        </tr>
                    </table>
                </td>
                <td width="60" align="center" valign="middle" style="border-right:none;border-bottom:1px solid #666;">Total</td>
            </tr>

            <?php if(isset($invoice_details[$inv_cnt]['description'])) { 
                $total_gram = 0;
                for($i=0; $i<count($invoice_details[$inv_cnt]['description']); $i++) { ?>
            <tr valign="top" style="border: none;">
                <td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666; "><?php echo $i+1; ?></td>
                <td valign="top" align="left" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><?php echo $invoice_details[$inv_cnt]['description'][$i]['description']; ?></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['hsn_code']; ?></p></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php
                $total_gram = ($invoice_details[$inv_cnt]['description'][$i]['grams']*$invoice_details[$inv_cnt]['description'][$i]['qty']); 
                 echo $invoice_details[$inv_cnt]['description'][$i]['grams'] . 'gm'; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666; "><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['qty']; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['rate']; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['amount']; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo round($invoice_details[$inv_cnt]['description'][$i]['discount'],2); ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['taxable_value']; ?></p></td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;">
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['cgst_rate']; ?></td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['cgst_amount']; ?></td>
                        </tr>
                    </table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;">
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['sgst_rate']; ?></td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['sgst_amount']; ?></td>
                        </tr>
                    </table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;">
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['igst_rate']; ?></td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['igst_amount']; ?></td>
                        </tr>
                    </table>
                </td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['total_amount']; ?></p></td>
            </tr>
            <?php }} ?>

        </table>
        </td>
        </tr>

        <tr>
          <td colspan="6"></td>
        </tr>

        <tr style="border-top: 1px solid #666;">
            <td colspan="3" rowspan="7" valign="top" style="padding:0;">
                <p style="margin:0;text-align:center;font-size:22px;">
                    <span style="font-size:18px; font-weight:500; margin-top: 5px;display: block;" >Amount in words: <br/><br><br><br><br></span> 
                    <span style="line-height:25px;">
                    <?php if (isset($invoice_details[$inv_cnt]['total_amount_in_words'])) echo $invoice_details[$inv_cnt]['total_amount_in_words']; ?>
                    </span>
                </p>
            </td>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:900;background:#ececec;">Total amount before Tax</td>
            <td style=" font-size:10px; font-weight:900;background:#ececec;"   >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['total_amount'])) echo $invoice_details[$inv_cnt]['total_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Add: CGST</td>
            <td style=" font-size:10px; font-weight:500;" >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['cgst_amount'])) echo $invoice_details[$inv_cnt]['cgst_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Add: SGST</td>
            <td style=" font-size:10px; font-weight:500;"  >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['sgst_amount'])) echo $invoice_details[$inv_cnt]['sgst_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Add: IGST</td>
            <td style=" font-size:10px; font-weight:500;"  >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['igst_amount'])) echo $invoice_details[$inv_cnt]['igst_amount']; ?></span> 
            </td>
        </tr>
        <tr style="background:#ececec;"> 
            <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >Total Amount: GST</span></p>
            </td>
            <td  style=" font-size:10px; font-weight:900;">  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['tax_amount'])) echo $invoice_details[$inv_cnt]['tax_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Round Off Amount</td>
            <td style=" font-size:10px; font-weight:500;"  >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['round_off_amount'])) echo $invoice_details[$inv_cnt]['round_off_amount']; ?></span> 
            </td>
        </tr>
        <tr style="background:#ececec;"> 
            <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >Total Amount After Tax</span></p>
            </td>
            <td  style=" font-size:10px; font-weight:900;" >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['invoice_amount'])) echo $invoice_details[$inv_cnt]['invoice_amount']; ?></span> 
            </td>
        </tr>
        <tr> 
            <?php
             $total_gram = 0;
                for($j=0; $j<count($invoice_details[$inv_cnt]['description']); $j++) {
                        $total_gram = $total_gram+($invoice_details[$inv_cnt]['description'][$j]['grams']*$invoice_details[$inv_cnt]['description'][$j]['qty']);
                    }
            ?>
            <td colspan="3" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" > Total weight in Kg  :-  <?=($total_gram/1000).'Kg';?></span></p>
            </td>
            <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >GST Payable on Reverse Charge</span></p>
            </td>
            <td  style=" font-size:10px; font-weight:900;background:#ececec;" >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['gst_reverse_charge'])) echo $invoice_details[$inv_cnt]['gst_reverse_charge']; ?></span> 
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
            <td colspan="6" valign="top">
                <p style="line-height:11px; text-align:justify;   margin: 0; "> 
                    <span style="  font-size:8px; font-weight:500;" >Declaration:</span><br />
                    I /We hereby certify that Registration Certificate under Maharashtra VAT    Act 2002(Act No. IX of 2005) (as amended by Maharashtra Ordinance no.1 of    2005 dated 09-03-2005) is in force on the date on which the sale of goods    specified in this bill/cash Memorandum has been effected by Me/Us in the    regular course of our business. It shall be accounted for in the turnover of    sales while filing return and the due tax, if any Payable on the sales has    been paid or shall be paid. I /We hereby certify that Registration    Certificate under Maharashtra VAT Act 2002(Act No. IX of 2005) (as amended by    Maharashtra Ordinance no.1 of 2005 dated 09-03-2005) is in force on the date    on which the sale of goods specified in this bill/cash Memorandum has been    effected by Me/Us in the regular course of our business. It shall be    accounted for in the turnover of sales while filing return and the due tax,    if any Payable on the sales has been paid or shall be paid. 
                </p>
            </td>
        </tr>

        </table>
        <p style="text-align:center; font-family:OpenSans-Regular, Arcon,Verdana, Geneva, sans-serif; font-size:8px; line-height:11px; margin-top:3px; margin-bottom:0;  ">SUBJECT TO MUMBAI JURISDICTION <br />
            This is a Computer Generated Invoice
        </p>
    </div>

    <div class="page-break"><span>&nbsp;</span></div>

    <div style="width:100%;  float:left; margin-right:20px;   ">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:150px;" />
            <p style="font-size:12px;line-height:18px;margin:0;margin-bottom:10px;">
                B-505, Veena sur, Mahavir Nagar Kandivali-West,Mumbai - 67 
                <br /> +91 8268000456 
                <br><a href="mailto:cs@eatanytime.in">cs@eatanytime.in</a><br>
                GSTIN: 27AABCW7811R1ZN
            </p>
        </center>
        <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:100%; margin:auto; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:8px; font-weight:400; border:1px solid #666;"    >

        <col width="43" />
        <col width="115" />
        <col width="110" />
        <col width="112" />
        <col width="83" />
        <col width="92" />
        <col width="95" />
        <col width="64" />
        <tr>
            <td colspan="6" align="left" valign="top" style="padding:0;border-spacing: 0;">
                <table width="100%" border="0" style="border-spacing: 0;">
                    <tr>
                        <td width="60%" style="color:#808080;margin:0 auto;text-align:center;"   ><h1 style="padding:0; margin:0; font-size:20px;">Tax Invoice</h1></td>
                        <td width="2%">
                            <table style="width:115%;border-collapse: collapse;height: 30px;border-spacing: 0;">
                                <tr><td style="border: 1px solid #666;width:100%;border-top:none;border-right:none;border-bottom:none;">&nbsp;<td></tr>
                                <tr><td style="border: 1px solid #666;width:100%;border-right:none;">&nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-check"></span><td></tr>
                                <tr><td style="border: 1px solid #666;width:100%;border-bottom:none;border-right:none;border-top:none;">&nbsp;<td></tr>
                            </table>
                        </td>
                        <td width="20%">
                            <table style="width:101%;border-collapse: collapse;height: 30px;border-spacing: 0;">
                                <tr><td style="border:1px solid #666;width:100%;border-top:none;border-right:none;border-bottom:none;">Accounts<td></tr>
                                <tr><td style="border:1px solid #666;width:100%;border-right:none;">Retailer<td></tr>
                                <tr><td style="border:1px solid #666;width:100%;border-bottom:none;border-right:none;border-top:none;">Acknowledgement<td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="6" valign="top" style="line-height:12px; padding:0;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                    <tr style="border-bottom:0px solid #666; height: 30px;"  >
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; ">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Reverse Charge:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['reverse_charge'])) echo $invoice_details[$inv_cnt]['reverse_charge']; ?></td>
                                </tr>
                                <tr>
                                    <td>Invoice No: </td><td><?php if (isset($invoice_details[$inv_cnt]['invoice_no'])) echo $invoice_details[$inv_cnt]['invoice_no']; ?></td>
                                </tr>
                                <tr>
                                    <td>Invoice Date: </td><td><?php if (isset($invoice_details[$inv_cnt]['invoice_date'])) echo (($invoice_details[$inv_cnt]['invoice_date']!=null && $invoice_details[$inv_cnt]['invoice_date']!='')?date('d-M-y',strtotime($invoice_details[$inv_cnt]['invoice_date'])):''); ?></td>
                                </tr>
                                <tr >
                                    <td>State: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['depot_state'])) echo $invoice_details[$inv_cnt]['depot_state']; ?>
                                        <table style="float: right;border-collapse:collapse;margin-right:10px;">
                                            <tr style="border-top:1px solid #666;">
                                                <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px;" align="right">State Code: &nbsp;</td>
                                                <td style="border-right:1px solid #666;width:20px;text-align:center;"><?php if (isset($invoice_details[$inv_cnt]['depot_state_code'])) echo $invoice_details[$inv_cnt]['depot_state_code']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top" style="line-height:12px;  border-right:1px solid #666; border-left:1px solid #666; border-bottom:1px solid #666; border-right:none;">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Transporter Mode:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['transport_type'])) echo $invoice_details[$inv_cnt]['transport_type']; ?></td>
                                </tr>
                                
								
								
								<tr>
                                    <td>PO Number: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['order_no'])) echo $invoice_details[$inv_cnt]['order_no']; ?></td>
                                </tr>
								
								
                                <tr>
								
                                    <td>Date of Supply: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['date_of_processing'])) echo (($invoice_details[$inv_cnt]['date_of_processing']!=null && $invoice_details[$inv_cnt]['date_of_processing']!='')?date('d-M-y',strtotime($invoice_details[$inv_cnt]['date_of_processing'])):''); ?></td>
                                </tr>
                                <tr >
                                    <td>Place of Supply: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['depot_state'])) echo $invoice_details[$inv_cnt]['depot_state']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr><td colspan="6"></td></tr>
        <tr>
            <td colspan="6" valign="top" style="line-height:12px; padding:0;border-bottom:none;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                    <tr style="border-bottom:0px solid #666; height: 20px;"  >
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; text-align:center;border-right:1px solid #666;font-weight:bolder;">
                            Details of Receiver | Billed to:
                        </td>
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666;text-align:center; font-weight:bolder;">
                            Details of Consignee | Shipped to:
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="6" valign="top" style="line-height:12px; padding:0;border-bottom:none;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                    <tr style="border-bottom:0px solid #666; height: 30px;"  >
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; ">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Name:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['distributor_name'])) echo $invoice_details[$inv_cnt]['distributor_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Address: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['address'])) echo $invoice_details[$inv_cnt]['address']; ?></td>
                                </tr>
                                <tr>
                                    <td>GSTIN: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['gst_number'])) echo $invoice_details[$inv_cnt]['gst_number']; ?></td>
                                </tr>
                                <tr >
                                    <td>State: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['state'])) echo $invoice_details[$inv_cnt]['state']; ?>
                                        <table style="float: right;border-collapse:collapse;margin-right:10px;">
                                            <tr style="border-top:1px solid #666;">
                                                <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px;" align="right">State Code: &nbsp;</td>
                                                <td style="border-right:1px solid #666;width:20px;text-align:center;"><?php if (isset($invoice_details[$inv_cnt]['state_code'])) echo $invoice_details[$inv_cnt]['state_code']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top" style="line-height:12px;  border-right:1px solid #666; border-left:1px solid #666; border-bottom:1px solid #666;border-right:none; ">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Name:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_name'])) echo $invoice_details[$inv_cnt]['con_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Address: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_address'])) echo $invoice_details[$inv_cnt]['con_address']; ?></td>
                                </tr>
                                <tr>
                                    <td>GSTIN: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_gst_number'])) echo $invoice_details[$inv_cnt]['con_gst_number']; ?></td>
                                </tr>
                                <tr >
                                    <td>State: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_state'])) echo $invoice_details[$inv_cnt]['con_state']; ?>
                                        <table style="float: right;border-collapse:collapse;margin-right:10px;">
                                            <tr style="border-top:1px solid #666;">
                                                <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px;" align="right">State Code: &nbsp;</td>
                                                <td style="border-right:1px solid #666;width:20px;text-align:center;"><?php if (isset($invoice_details[$inv_cnt]['con_state_code'])) echo $invoice_details[$inv_cnt]['con_state_code']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>

        <tr style="font-size:8px; font-weight:500;">
        <td colspan="6" style="padding: 0;">
        <table style="width:100%;" width="100%"  border="0" cellspacing="0" cellpadding="2" style="border-collapse: collapse;">
            <tr style="background:#ececec;">
                <td width="20" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Sr No.</td>
                <td width="600" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Name of Product / Service</td>
                <td width="50" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">HSN ACS</td>
                <td width="50" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">UOM</td>
                <td width="20" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Qty</td>
                <td width="60"  align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Rate</td>
                <td width="60" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;"> Amount </td>
                <td width="60" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Less Discount</td>
                <td width="60" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Taxable Value</td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;"><tr><td colspan="2" style="text-align: center;">CGST</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td>
                        </tr>
                    </table>
                </td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;">
                        <tr>
                            <td colspan="2" style="text-align: center;">SGST</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td>
                        </tr>
                    </table>
                </td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;">
                        <tr>
                            <td colspan="2" style="text-align: center;">IGST</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td>
                        </tr>
                    </table>
                </td>
                <td width="60" align="center" valign="middle" style="border-right:none;border-bottom:1px solid #666;">Total</td>
            </tr>

            <?php if(isset($invoice_details[$inv_cnt]['description'])) { 
                $total_gram = 0;
                for($i=0; $i<count($invoice_details[$inv_cnt]['description']); $i++) {
                        $total_gram = $total_gram+($invoice_details[$inv_cnt]['description'][$i]['grams']*$invoice_details[$inv_cnt]['description'][$i]['qty']);

                    ?>
            <tr valign="top" style="border: none;">
                <td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666; "><?php echo $i+1; ?></td>
                <td valign="top" align="left" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><?php echo $invoice_details[$inv_cnt]['description'][$i]['description']; ?></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['hsn_code']; ?></p></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['grams'] . 'gm'; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666; "><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['qty']; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['rate']; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['amount']; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo round($invoice_details[$inv_cnt]['description'][$i]['discount'],2); ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['taxable_value']; ?></p></td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;">
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['cgst_rate']; ?></td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['cgst_amount']; ?></td>
                        </tr>
                    </table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;">
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['sgst_rate']; ?></td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['sgst_amount']; ?></td>
                        </tr>
                    </table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;">
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['igst_rate']; ?></td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['igst_amount']; ?></td>
                        </tr>
                    </table>
                </td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['total_amount']; ?></p></td>
            </tr>
            <?php }} ?>

        </table>
        </td>
        </tr>

        <tr>
          <td colspan="6"></td>
        </tr>

        <tr style="border-top: 1px solid #666;">
            <td colspan="3" rowspan="7" valign="top" style="padding:0;">
                <p style="margin:0;text-align:center;line:height:20px;font-size:22px;">
                    <span style="font-size:18px; font-weight:500; margin-top: 5px;display: block;" >Amount in words: <br/><br><br><br><br></span> 
                    <span style="line-height:25px;">
                    <?php if (isset($invoice_details[$inv_cnt]['total_amount_in_words'])) echo $invoice_details[$inv_cnt]['total_amount_in_words']; ?>
                    </span>
                </p>
            </td>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:900;background:#ececec;">Total amount before Tax</td>
            <td style=" font-size:10px; font-weight:900;background:#ececec;"   >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['total_amount'])) echo $invoice_details[$inv_cnt]['total_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Add: CGST</td>
            <td style=" font-size:10px; font-weight:500;" >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['cgst_amount'])) echo $invoice_details[$inv_cnt]['cgst_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Add: SGST</td>
            <td style=" font-size:10px; font-weight:500;"  >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['sgst_amount'])) echo $invoice_details[$inv_cnt]['sgst_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Add: IGST</td>
            <td style=" font-size:10px; font-weight:500;"  >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['igst_amount'])) echo $invoice_details[$inv_cnt]['igst_amount']; ?></span> 
            </td>
        </tr>
        <tr style="background:#ececec;"> 
            <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >Total Amount: GST</span></p>
            </td>
            <td  style=" font-size:10px; font-weight:900;">  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['tax_amount'])) echo $invoice_details[$inv_cnt]['tax_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Round Off Amount</td>
            <td style=" font-size:10px; font-weight:500;"  >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['round_off_amount'])) echo $invoice_details[$inv_cnt]['round_off_amount']; ?></span> 
            </td>
        </tr>
        <tr style="background:#ececec;"> 
            <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >Total Amount After Tax</span></p>
            </td>
            <td  style=" font-size:10px; font-weight:900;" >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['invoice_amount'])) echo $invoice_details[$inv_cnt]['invoice_amount']; ?></span> 
            </td>
        </tr>
        <tr> 
            <?php
             $total_gram = 0;
                for($j=0; $j<count($invoice_details[$inv_cnt]['description']); $j++) {
                        $total_gram = $total_gram+($invoice_details[$inv_cnt]['description'][$j]['grams']*$invoice_details[$inv_cnt]['description'][$j]['qty']);
                    }
            ?>
            <td colspan="3" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" > Total weight in Kg  :-  <?=($total_gram/1000).'Kg';?></span></p>
            </td>
            <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >GST Payable on Reverse Charge</span></p>
            </td>
            <td  style=" font-size:10px; font-weight:900;background:#ececec;" >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['gst_reverse_charge'])) echo $invoice_details[$inv_cnt]['gst_reverse_charge']; ?></span> 
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
            <td colspan="6" valign="top">
                <p style="line-height:11px; text-align:justify;   margin: 0; "> 
                    <span style="  font-size:8px; font-weight:500;" >Declaration:</span><br />
                    I /We hereby certify that Registration Certificate under Maharashtra VAT    Act 2002(Act No. IX of 2005) (as amended by Maharashtra Ordinance no.1 of    2005 dated 09-03-2005) is in force on the date on which the sale of goods    specified in this bill/cash Memorandum has been effected by Me/Us in the    regular course of our business. It shall be accounted for in the turnover of    sales while filing return and the due tax, if any Payable on the sales has    been paid or shall be paid. I /We hereby certify that Registration    Certificate under Maharashtra VAT Act 2002(Act No. IX of 2005) (as amended by    Maharashtra Ordinance no.1 of 2005 dated 09-03-2005) is in force on the date    on which the sale of goods specified in this bill/cash Memorandum has been    effected by Me/Us in the regular course of our business. It shall be    accounted for in the turnover of sales while filing return and the due tax,    if any Payable on the sales has been paid or shall be paid. 
                </p>
            </td>
        </tr>

        </table>
        <p style="text-align:center; font-family:OpenSans-Regular, Arcon,Verdana, Geneva, sans-serif; font-size:8px; line-height:11px; margin-top:3px; margin-bottom:0;  ">SUBJECT TO MUMBAI JURISDICTION <br />
            This is a Computer Generated Invoice
        </p>
    </div>

    <div class="page-break"><span>&nbsp;</span></div>

    <div style="width:100%;  float:left; margin-right:20px;   ">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:150px;" />
            <p style="font-size:12px;line-height:18px;margin:0;margin-bottom:10px;">
                B-505, Veena sur, Mahavir Nagar Kandivali-West,Mumbai - 67 
                <br /> +91 8268000456 
                <br><a href="mailto:cs@eatanytime.in">cs@eatanytime.in</a><br>
                GSTIN: 27AABCW7811R1ZN
            </p>
        </center>
        <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:100%; margin:auto; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:8px; font-weight:400; border:1px solid #666;"    >

        <col width="43" />
        <col width="115" />
        <col width="110" />
        <col width="112" />
        <col width="83" />
        <col width="92" />
        <col width="95" />
        <col width="64" />
        <tr>
            <td colspan="6" align="left" valign="top" style="padding:0;border-spacing: 0;">
                <table width="100%" border="0" style="border-spacing: 0;">
                    <tr>
                        <td width="60%" style="color:#808080;margin:0 auto;text-align:center;"   ><h1 style="padding:0; margin:0; font-size:20px;">Tax Invoice</h1></td>
                        <td width="2%">
                            <table style="width:115%;border-collapse: collapse;height: 30px;border-spacing: 0;">
                                <tr><td style="border: 1px solid #666;width:100%;border-top:none;border-right:none;border-bottom:none;">&nbsp;<td></tr>
                                <tr><td style="border: 1px solid #666;width:100%;border-right:none;">&nbsp;<td></tr>
                                <tr><td style="border: 1px solid #666;width:100%;border-bottom:none;border-right:none;border-top:none;">&nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-check"></span><td></tr>
                            </table>
                        </td>
                        <td width="20%">
                            <table style="width:101%;border-collapse: collapse;height: 30px;border-spacing: 0;">
                                <tr><td style="border:1px solid #666;width:100%;border-top:none;border-right:none;border-bottom:none;">Accounts<td></tr>
                                <tr><td style="border:1px solid #666;width:100%;border-right:none;">Retailer<td></tr>
                                <tr><td style="border:1px solid #666;width:100%;border-bottom:none;border-right:none;border-top:none;">Acknowledgement<td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="6" valign="top" style="line-height:12px; padding:0;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                    <tr style="border-bottom:0px solid #666; height: 30px;"  >
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; ">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Reverse Charge:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['reverse_charge'])) echo $invoice_details[$inv_cnt]['reverse_charge']; ?></td>
                                </tr>
                                <tr>
                                    <td>Invoice No: </td><td><?php if (isset($invoice_details[$inv_cnt]['invoice_no'])) echo $invoice_details[$inv_cnt]['invoice_no']; ?></td>
                                </tr>
                                <tr>
                                    <td>Invoice Date: </td><td><?php if (isset($invoice_details[$inv_cnt]['invoice_date'])) echo (($invoice_details[$inv_cnt]['invoice_date']!=null && $invoice_details[$inv_cnt]['invoice_date']!='')?date('d-M-y',strtotime($invoice_details[$inv_cnt]['invoice_date'])):''); ?></td>
                                </tr>
                                <tr >
                                    <td>State: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['depot_state'])) echo $invoice_details[$inv_cnt]['depot_state']; ?>
                                        <table style="float: right;border-collapse:collapse;margin-right:10px;">
                                            <tr style="border-top:1px solid #666;">
                                                <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px;" align="right">State Code: &nbsp;</td>
                                                <td style="border-right:1px solid #666;width:20px;text-align:center;"><?php if (isset($invoice_details[$inv_cnt]['depot_state_code'])) echo $invoice_details[$inv_cnt]['depot_state_code']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top" style="line-height:12px;  border-right:1px solid #666; border-left:1px solid #666; border-bottom:1px solid #666; border-right:none;">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Transporter Mode:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['transport_type'])) echo $invoice_details[$inv_cnt]['transport_type']; ?></td>
                                </tr>
                               
								
								
								
								<tr>
                                    <td>PO Number: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['order_no'])) echo $invoice_details[$inv_cnt]['order_no']; ?></td>
                                </tr>
								
								
                                <tr>
                                    <td>Date of Supply: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['date_of_processing'])) echo (($invoice_details[$inv_cnt]['date_of_processing']!=null && $invoice_details[$inv_cnt]['date_of_processing']!='')?date('d-M-y',strtotime($invoice_details[$inv_cnt]['date_of_processing'])):''); ?></td>
                                </tr>
                                <tr >
                                    <td>Place of Supply: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['depot_state'])) echo $invoice_details[$inv_cnt]['depot_state']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr><td colspan="6"></td></tr>
        <tr>
            <td colspan="6" valign="top" style="line-height:12px; padding:0;border-bottom:none;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                    <tr style="border-bottom:0px solid #666; height: 20px;"  >
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; text-align:center;border-right:1px solid #666;font-weight:bolder;">
                            Details of Receiver | Billed to:
                        </td>
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666;text-align:center; font-weight:bolder;">
                            Details of Consignee | Shipped to:
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="6" valign="top" style="line-height:12px; padding:0;border-bottom:none;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                    <tr style="border-bottom:0px solid #666; height: 30px;"  >
                        <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; ">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Name:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['distributor_name'])) echo $invoice_details[$inv_cnt]['distributor_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Address: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['address'])) echo $invoice_details[$inv_cnt]['address']; ?></td>
                                </tr>
                                <tr>
                                    <td>GSTIN: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['gst_number'])) echo $invoice_details[$inv_cnt]['gst_number']; ?></td>
                                </tr>
                                <tr >
                                    <td>State: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['state'])) echo $invoice_details[$inv_cnt]['state']; ?>
                                        <table style="float: right;border-collapse:collapse;margin-right:10px;">
                                            <tr style="border-top:1px solid #666;">
                                                <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px;" align="right">State Code: &nbsp;</td>
                                                <td style="border-right:1px solid #666;width:20px;text-align:center;"><?php if (isset($invoice_details[$inv_cnt]['state_code'])) echo $invoice_details[$inv_cnt]['state_code']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%" valign="top" style="line-height:12px;  border-right:1px solid #666; border-left:1px solid #666; border-bottom:1px solid #666;border-right:none; ">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                                <tr>
                                    <td width="30%">Name:</td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_name'])) echo $invoice_details[$inv_cnt]['con_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Address: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_address'])) echo $invoice_details[$inv_cnt]['con_address']; ?></td>
                                </tr>
                                <tr>
                                    <td>GSTIN: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_gst_number'])) echo $invoice_details[$inv_cnt]['con_gst_number']; ?></td>
                                </tr>
                                <tr >
                                    <td>State: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['con_state'])) echo $invoice_details[$inv_cnt]['con_state']; ?>
                                        <table style="float: right;border-collapse:collapse;margin-right:10px;">
                                            <tr style="border-top:1px solid #666;">
                                                <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px;" align="right">State Code: &nbsp;</td>
                                                <td style="border-right:1px solid #666;width:20px;text-align:center;"><?php if (isset($invoice_details[$inv_cnt]['con_state_code'])) echo $invoice_details[$inv_cnt]['con_state_code']; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>

        <tr style="font-size:8px; font-weight:500;">
        <td colspan="6" style="padding: 0;">
        <table style="width:100%;" width="100%"  border="0" cellspacing="0" cellpadding="2" style="border-collapse: collapse;">
            <tr style="background:#ececec;">
                <td width="20" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Sr No.</td>
                <td width="600" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Name of Product / Service</td>
                <td width="50" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">HSN ACS</td>
                <td width="50" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">UOM</td>
                <td width="20" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Qty</td>
                <td width="60"  align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Rate</td>
                <td width="60" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;"> Amount </td>
                <td width="60" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Less Discount</td>
                <td width="60" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Taxable Value</td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;"><tr><td colspan="2" style="text-align: center;">CGST</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td>
                        </tr>
                    </table>
                </td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;">
                        <tr>
                            <td colspan="2" style="text-align: center;">SGST</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td>
                        </tr>
                    </table>
                </td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;">
                        <tr>
                            <td colspan="2" style="text-align: center;">IGST</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td>
                        </tr>
                    </table>
                </td>
                <td width="60" align="center" valign="middle" style="border-right:none;border-bottom:1px solid #666;">Total</td>
            </tr>

            <?php if(isset($invoice_details[$inv_cnt]['description'])) { for($i=0; $i<count($invoice_details[$inv_cnt]['description']); $i++) { ?>
            <tr valign="top" style="border: none;">
                <td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666; "><?php echo $i+1; ?></td>
                <td valign="top" align="left" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><?php echo $invoice_details[$inv_cnt]['description'][$i]['description']; ?></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['hsn_code']; ?></p></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['grams'] . 'gm'; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666; "><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['qty']; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['rate']; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['amount']; ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo round($invoice_details[$inv_cnt]['description'][$i]['discount'],2); ?></p></td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['taxable_value']; ?></p></td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;">
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['cgst_rate']; ?></td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['cgst_amount']; ?></td>
                        </tr>
                    </table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;">
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['sgst_rate']; ?></td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['sgst_amount']; ?></td>
                        </tr>
                    </table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;">
                        <tr>
                            <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['igst_rate']; ?></td>
                            <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $invoice_details[$inv_cnt]['description'][$i]['igst_amount']; ?></td>
                        </tr>
                    </table>
                </td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;"><p style="margin:0; "><?php echo $invoice_details[$inv_cnt]['description'][$i]['total_amount']; ?></p></td>
            </tr>
            <?php }} ?>

        </table>
        </td>
        </tr>

        <tr>
          <td colspan="6"></td>
        </tr>

        <tr style="border-top: 1px solid #666;">
            <td colspan="3" rowspan="7" valign="top" style="padding:0;">
                <p style="margin:0;text-align:center;line:height:20px;font-size:22px;">
                    <span style="font-size:18px; font-weight:500; margin-top: 5px;display: block;" >Amount in words: <br/><br><br><br><br></span> 
                    <span style="line-height:25px;">
                    <?php if (isset($invoice_details[$inv_cnt]['total_amount_in_words'])) echo $invoice_details[$inv_cnt]['total_amount_in_words']; ?>
                    </span>
                </p>
            </td>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:900;background:#ececec;">Total amount before Tax</td>
            <td style=" font-size:10px; font-weight:900;background:#ececec;"   >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['total_amount'])) echo $invoice_details[$inv_cnt]['total_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Add: CGST</td>
            <td style=" font-size:10px; font-weight:500;" >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['cgst_amount'])) echo $invoice_details[$inv_cnt]['cgst_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Add: SGST</td>
            <td style=" font-size:10px; font-weight:500;"  >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['sgst_amount'])) echo $invoice_details[$inv_cnt]['sgst_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Add: IGST</td>
            <td style=" font-size:10px; font-weight:500;"  >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['igst_amount'])) echo $invoice_details[$inv_cnt]['igst_amount']; ?></span> 
            </td>
        </tr>
        <tr style="background:#ececec;"> 
            <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >Total Amount: GST</span></p>
            </td>
            <td  style=" font-size:10px; font-weight:900;">  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['tax_amount'])) echo $invoice_details[$inv_cnt]['tax_amount']; ?></span> 
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="font-size:10px; font-weight:500;">Round Off Amount</td>
            <td style=" font-size:10px; font-weight:500;"  >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['round_off_amount'])) echo $invoice_details[$inv_cnt]['round_off_amount']; ?></span> 
            </td>
        </tr>
        <tr style="background:#ececec;"> 
            <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >Total Amount After Tax</span></p>
            </td>
            <td  style=" font-size:10px; font-weight:900;" >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['invoice_amount'])) echo $invoice_details[$inv_cnt]['invoice_amount']; ?></span> 
            </td>
        </tr>
        <tr> 
            <?php
             $total_gram = 0;
                for($j=0; $j<count($invoice_details[$inv_cnt]['description']); $j++) {
                        $total_gram = $total_gram+($invoice_details[$inv_cnt]['description'][$j]['grams']*$invoice_details[$inv_cnt]['description'][$j]['qty']);
                    }
            ?>
            <td colspan="3" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" > Total weight in Kg  :-  <?=($total_gram/1000).'Kg';?></span></p>
            </td>
            <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
                <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >GST Payable on Reverse Charge</span></p>
            </td>
            <td  style=" font-size:10px; font-weight:900;background:#ececec;" >  
                <span style="text-align:left; float:left"> &#8377; </span> 
                <span style="text-align:right; float:right"><?php if (isset($invoice_details[$inv_cnt]['gst_reverse_charge'])) echo $invoice_details[$inv_cnt]['gst_reverse_charge']; ?></span> 
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
            <td colspan="6" valign="top">
                <p style="line-height:11px; text-align:justify;   margin: 0; "> 
                    <span style="  font-size:8px; font-weight:500;" >Declaration:</span><br />
                    I /We hereby certify that Registration Certificate under Maharashtra VAT    Act 2002(Act No. IX of 2005) (as amended by Maharashtra Ordinance no.1 of    2005 dated 09-03-2005) is in force on the date on which the sale of goods    specified in this bill/cash Memorandum has been effected by Me/Us in the    regular course of our business. It shall be accounted for in the turnover of    sales while filing return and the due tax, if any Payable on the sales has    been paid or shall be paid. I /We hereby certify that Registration    Certificate under Maharashtra VAT Act 2002(Act No. IX of 2005) (as amended by    Maharashtra Ordinance no.1 of 2005 dated 09-03-2005) is in force on the date    on which the sale of goods specified in this bill/cash Memorandum has been    effected by Me/Us in the regular course of our business. It shall be    accounted for in the turnover of sales while filing return and the due tax,    if any Payable on the sales has been paid or shall be paid. 
                </p>
            </td>
        </tr>

        </table>
        <p style="text-align:center; font-family:OpenSans-Regular, Arcon,Verdana, Geneva, sans-serif; font-size:8px; line-height:11px; margin-top:3px; margin-bottom:0;  ">SUBJECT TO MUMBAI JURISDICTION <br />
            This is a Computer Generated Invoice
        </p>
    </div>
</body>
</html>