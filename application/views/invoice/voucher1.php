<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Business Promotion Voucher</title>
<style>
@font-face {
    font-family: "OpenSans-Regular";
    src: url("<?php echo base_url().'/assets/invoice/'; ?>OpenSans-Regular.ttf") format("truetype");
}
</style>
</head>

<body>
<?php $vou_cnt=0; ?>
<div>
    <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:12px; font-weight:400; border:1px solid #666; "    >
        <tr>
            <td colspan="6" align="left" valign="top" style="padding:0;">
            <table width="100%" border="0" cellspacing="0">
                <tr>
                    <td width="30%"><img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt="" width=" " height="50" /></td>
                    <td width="70%" style="color:#808080; text-align:left;">
                        <h1 style="padding:0; margin:0; font-size:22px;"> Business Promotion Voucher </h1>
                    </td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td colspan="6" valign="top" style="line-height:20px; padding:0; border:0;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="5"  style="border-collapse: collapse;">
                    <tr style="border-bottom:1px solid #666;">
                        <td width="39.765%" rowspan="2" style="line-height:20px; border-bottom:0px solid #666; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;">
                                <span style=" font-size:13px; font-weight:500;" >Distributor Name</span>
                                <br /> <?php if (isset($voucher_details[$vou_cnt]['distributor_name'])) echo $voucher_details[$vou_cnt]['distributor_name']; ?> 
                                <br /> <?php if (isset($voucher_details[$vou_cnt]['address'])) echo $voucher_details[$vou_cnt]['address']; ?> 
                            </p> 
                        </td>
                        <td width="30%" valign="top" style="line-height:20px;  border-right:1px solid #666;  border-bottom:1px solid #666; border-left:1px solid #666; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" > Voucher No.</span> <br /> 
                            <?php if (isset($voucher_details[$vou_cnt]['voucher_no'])) echo $voucher_details[$vou_cnt]['voucher_no']; ?>
                            </p>
                        </td>
                        <td width="30%" valign="top" style="line-height:20px; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;">  <span style=" font-size:12px; font-weight:500;" >Dated </span>  <br />
                            <?php if (isset($voucher_details[$vou_cnt]['date_of_processing'])) echo (($voucher_details[$vou_cnt]['date_of_processing']!=null && $voucher_details[$vou_cnt]['date_of_processing']!='')?date('d-M-y',strtotime($voucher_details[$vou_cnt]['date_of_processing'])):''); ?>
                            </p>
                        </td>
                    </tr>
                    <tr style="border-bottom:0px solid #666;">
                        <td valign="top" style="line-height:20px; border-bottom:0px solid #666; border-right:1px solid #666;  border-left:1px solid #666; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" >Relationship Manager  </span> <br /> 
                            <?php if (isset($voucher_details[$vou_cnt]['sales_rep_name'])) echo $voucher_details[$vou_cnt]['sales_rep_name']; ?>
                            </p>
                        </td>
                        <td  valign="top" style="line-height:20px; padding-top: 0px; padding-bottom: 0px;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" >Prepare By</span> <br /> 
                            <?php if (isset($voucher_details[$vou_cnt]['created_by'])) echo $voucher_details[$vou_cnt]['created_by']; ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="font-size:12px; font-weight:500; ">
            <td width="61" align="center" valign="top"> Sr. No. </td>
            <td width="285" align="center" valign="top"> Description </td>
            <td width="129" align="center" valign="top"> Weight (in Gram) </td>
            <td width="125" align="center" valign="top"> Quantity </td>
            <td width="115" align="center" valign="top"> Rate </td>
            <td width="138" align="center" valign="top"> Amount </td>
        </tr>
        <?php if(isset($voucher_details[$vou_cnt]['description'])) { for($i=0; $i<count($voucher_details[$vou_cnt]['description']); $i++) { ?>
        <tr valign="top" style="border: none;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $i+1; ?></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $voucher_details[$vou_cnt]['description'][$i]['description']; ?></td>
            <td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $voucher_details[$vou_cnt]['description'][$i]['grams']; ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $voucher_details[$vou_cnt]['description'][$i]['qty']; ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo $voucher_details[$vou_cnt]['description'][$i]['rate']; ?></p></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($voucher_details[$vou_cnt]['description'][$i]['amount'],2); ?></p></td>
        </tr>
        <?php }} ?>
        <tr>
            <td colspan="3" valign="top"> <p style="margin:0;"><span style=" font-size:13px; font-weight:500;" >Amount in Words: <?php if (isset($voucher_details[$vou_cnt]['total_amount_in_words'])) echo $voucher_details[$vou_cnt]['total_amount_in_words']; ?></span> </p> </td>
            <td colspan="2" valign="middle" align="right" style="font-size:12px; font-weight:500;"><p style="margin:0;"><span style=" font-size:13px; font-weight:500;" >Total</span></p></td>
            <td  style=" font-size:12px; font-weight:500;" >  <span style="text-align:left; float:left"> &#8377; </span> <span style="text-align:right; float:right"><?php if (isset($voucher_details[$vou_cnt]['total_amount'])) echo $voucher_details[$vou_cnt]['total_amount']; ?></span> </td>
        </tr>
        <tr>
            <td colspan="3" valign="middle" style="padding:0;">&nbsp;  </td>
            <td colspan="3" align="center" valign="top" style=" font-size:13px; font-weight:500;"> For WholsomeHabits Pvt Ltd <br/> <img src="<?php echo base_url().'/assets/invoice/'; ?>stamp.jpg" height="55"  alt="Sign3 Rishit" /> <br/>Authorised Signatory</td>
        </tr>
    </table><br />

    <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:12px; font-weight:400;   border:1px solid #666; "    >
        <tr style="padding:0; margin:0;">
            <td colspan="5" align="left" valign="top" style="padding:0; margin:0;">
                <table width="100%" border="0" style="padding:0; margin:0;">
                    <tr>
                        <td width="40%"><img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt="" width=" " height="50" /></td>
                        <td width="60%" style="color:#808080; text-align:left;">
                            <h1 style="padding:0; margin:0; font-size:22px;"> Gate Pass</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="5" valign="top" style="line-height:20px; padding:0; border:0;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="5"  style="border-collapse: collapse;">
                    <tr style="border-bottom:1px solid #666;"  >
                        <td width="40%" rowspan="2"  valign="top" style="line-height:20px; border-bottom:0px solid #666; ">
                            <p style="margin: 0px;"><span style=" font-size:13px; font-weight:500;" >Relationship Manager:</span> <br/>
                            <?php if (isset($voucher_details[$vou_cnt]['sales_rep_name'])) echo $voucher_details[$vou_cnt]['sales_rep_name']; ?>
                            </p>
                        </td>
                        <td width="60%" valign="top" style="line-height:20px;  border-right:0px solid #666;  border-bottom:1px solid #666; border-left:1px solid   #666;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" > Gate Pass No.</span> <br/>
                            <?php if (isset($voucher_details[$vou_cnt]['gate_pass_no'])) echo $voucher_details[$vou_cnt]['gate_pass_no']; ?>
                            </p>
                        </td>
                    </tr>
                    <tr style="border-bottom:0px solid #666;">
                        <td valign="top" style="line-height:20px; border-bottom:0px solid #666; border-right:0px solid #666;  border-left:1px solid  #666;">
                            <p style="margin: 0px;"> <span style=" font-size:12px; font-weight:500;" >Gate Pass Date.</span> <br/>
                            <?php if (isset($voucher_details[$vou_cnt]['date_of_processing'])) echo (($voucher_details[$vou_cnt]['date_of_processing']!=null && $voucher_details[$vou_cnt]['date_of_processing']!='')?date('d-M-y',strtotime($voucher_details[$vou_cnt]['date_of_processing'])):''); ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="font-size:12px; font-weight:500; border-top:1px solid #666; ">
            <td width="61" align="center" valign="top"> Sr. No. </td>
            <td colspan="3" align="center" valign="top"> Description </td>
            <td width="202" align="center" valign="top"> Amount </td>
        </tr>
        <?php if(isset($voucher_details[$vou_cnt]['description'])) { for($i=0; $i<count($voucher_details[$vou_cnt]['description']); $i++) { ?>
        <tr valign="top" style="border: none;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $i+1; ?></td>
            <td colspan="3" align="" valign="top" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $voucher_details[$vou_cnt]['description'][$i]['description']; ?></td>
            <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; "><?php echo round($voucher_details[$vou_cnt]['description'][$i]['amount'],2); ?></p></td>
        </tr>
        <?php }} ?>
        <tr valign="top">
            <td valign="top" align="center">&nbsp; </td>
            <td colspan="3" align="" valign="top"><p style="margin:0;"><span style=" font-size:13px; font-weight:500;" >Total</span></p></td>
            <td   valign="top" style=" font-size:12px; font-weight:500;" >  <span style="text-align:left; float:left"> &#8377; </span> <span style="text-align:right; float:right"><?php if (isset($voucher_details[$vou_cnt]['total_amount'])) echo $voucher_details[$vou_cnt]['total_amount']; ?></span> </td>
        </tr>
        <tr>
            <td colspan="5">
                <table width="100%">
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center">Prepared By:</td>
                        <td align="center">Received By:</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
