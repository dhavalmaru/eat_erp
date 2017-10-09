
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gate Pass</title>
<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/fontawesome/font-awesome.min.css'; ?>"/>
<style>
    /*@import "fontawesome/font-awesome.min.css";*/

    @font-face {
        font-family: "OpenSans-Regular";
        src: url("<?php echo base_url().'/assets/invoice/'; ?>OpenSans-Regular.ttf") format("truetype");
    }
    @media print{@page {size: portrait}}
    /*@media all {
        .page-break { display: none; }
    }*/
    @media print {
        .page-break { display: block; page-break-after: always; }
    }
    body { font-family: "verdana"; font-size:8px; font-weight:500; margin:0; line-height:11px;}

    .gate_pass_details { font-family: verdana; font-size:13px; }
    .gate_pass_details table {border-collapse:collapse; border-color:#333;}
    .gate_pass_details table th {font-size:15px; background:#f1f1f1; padding:8px 5px;}
    .gate_pass_details h1 {padding:3px; margin:0; font-size:20px; padding:10px; background:#f1f1f1; margin-bottom:5px}
    .gate_pass_details h2 {padding:3px; margin:0; font-size:16px; padding:8px 0; text-align:center;}

    .payment_details { font-family: verdana; font-size:13px; padding:0; }
    .payment_details table{ border-collapse:collapse; border-color:#333;  }
    .payment_details table td { padding:4px;}
    .payment_details table th { font-size:15px; background:#f1f1f1; padding:8px 5px;}
    .payment_details h1 { padding:3px; margin:0; font-size:20px; padding:10px; background:#f1f1f1; margin-bottom:5px}
</style>
</head>

<body style="margin: 1px;">
    <?php if(count($sku_details)>0){ ?>
    <div class="gate_pass_details">
        <div style="width:1000px;">
            <div align="center" style="background:#f00;"><strong><h1>Gate Pass</h1></strong></div>
            <div style="width:400px;  ">
                <table cellspacing="0" cellpadding="5" border="1"> 
                    <tr>
                        <td width="185">Location</td>
                        <td width="189" colspan="5"><div align="right"><?php if(isset($voucher_details[0]['depot_name'])) echo $voucher_details[0]['depot_name']; else if(isset($invoice_details[0]['depot_name'])) echo $invoice_details[0]['depot_name']; ?></div></td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td colspan="5"><div align="right"><?php echo date('d-M-y'); ?></div></td>
                    </tr>
                    <tr>
                        <td>Delivery Person</td>
                        <td colspan="5"><div align="right"><?php if(isset($sales_rep_details[0]->sales_rep_name)) echo $sales_rep_details[0]->sales_rep_name; ?></div></td>
                    </tr>
                    <tr>
                        <td>Created by</td>
                        <td colspan="5"><div align="right"><?php echo $this->session->userdata('login_name'); ?></div></td>
                    </tr>
                </table>
            </div><br />
            <div style=""> 
                <table cellspacing="0" cellpadding="5" border="1" width="100%">
                    <tr>
                        <td width="54"><div align="center"><strong>Sr. No.</strong></div></td>
                        <td width="227"><div align="center"><strong>SKU Name</strong></div></td>
                        <td width="117"><div align="center"><strong>Type</strong></div></td>
                        <td width="102"><div align="center"><strong>Quantity</strong></div></td>
                    </tr>
                    <?php for($i=0; $i<count($sku_details); $i++){ ?>
                        <tr>
                            <td><div><?php echo $i+1; ?></div></td>
                            <td><?php echo $sku_details[$i]->sku_name; ?></td>
                            <td><div><?php echo $sku_details[$i]->type; ?></div></td>
                            <td><div align="right"><?php echo $sku_details[$i]->total_qty; ?></div></td>
                        </tr>
                    <?php } ?>
                </table>
            </div><br />
            <div style="">  
                <h2>  Delivery for  </h2>
                <table cellspacing="0" cellpadding="5" border="1" width="100%">
                    <tr>
                        <td width="60"><div align="center"><strong>Sr. No.</strong></div></td>
                        <td width="238"><div align="center"><strong>Distributor Name</strong></div></td>
                        <td width="125"><div align="center"><strong>Invoice Date</strong></div></td>
                        <td width="128"><div align="center"><strong>Invoice Number</strong></div></td>
                        <td width="187"><div align="center"><strong>Days from Invoice</strong></div></td>
                    </tr>
                    <?php for($i=0; $i<count($delivery_for); $i++){ ?>
                        <tr>
                            <td><div><?php echo $i+1; ?></div></td>
                            <td><?php echo $delivery_for[$i]->distributor_name; ?></td>
                            <td><div><?php if(isset($delivery_for)) echo (($delivery_for[$i]->date_of_processing!=null && $delivery_for[$i]->date_of_processing!='')?date('d-M-Y',strtotime($delivery_for[$i]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?></div></td>
                            <td><div><?php if(isset($delivery_for[$i]->invoice_no) && $delivery_for[$i]->voucher_no!='') echo $delivery_for[$i]->voucher_no; else echo $delivery_for[$i]->invoice_no; ?></div></td>
                            <td><div align="right"><?php echo $delivery_for[$i]->days; ?></div></td>
                        </tr>
                    <?php } ?>
                </table>
            </div><br />
            <div style="">  
                <h2> Pending Payments </h2>
                <table cellspacing="0" cellpadding="5" border="1" width="100%">
                    <tr>
                        <td width="45"><div align="center"><strong>Sr. No.</strong></div></td>
                        <td width="185"><div align="center"><strong>Distributor Name</strong></div></td>
                        <td width="160"><div align="center"><strong>Total Pending Amount</strong></div></td>
                        <td width="100"><div align="center"><strong>Invoice Date</strong></div></td>
                        <td width="140"><div align="center"><strong>Invoice Number</strong></div></td>
                        <td width="120"><div align="center"><strong>Invoice Amount</strong></div></td>
                        <td width="120"><div align="center"><strong>Invoice Handover</strong></div></td>
                        <td width="120"><div align="center"><strong>Payment/Invoice Return</strong></div></td>
                    </tr>
                    <?php for($i=0; $i<count($pending_payments); $i++){ ?>
                        <tr>
                            <td><div><?php echo $i+1; ?></div></td>
                            <td><?php echo $pending_payments[$i]->distributor_name; ?></td>
                            <td><div align="right"><?php echo $pending_payments[$i]->total_pending_amount; ?></div></td>
                            <td><div><?php if(isset($pending_payments)) echo (($pending_payments[$i]->invoice_date!=null && $pending_payments[$i]->invoice_date!='')?date('d-M-Y',strtotime($pending_payments[$i]->invoice_date)):date('d/m/Y')); else echo date('d/m/Y'); ?></div></td>
                            <td><div><?php if(isset($pending_payments[$i]->invoice_no) && $pending_payments[$i]->voucher_no!='') echo $pending_payments[$i]->voucher_no; else echo $pending_payments[$i]->invoice_no; ?></div></td>
                            <td><div align="right"><?php echo $pending_payments[$i]->invoice_amount; ?></div></td>
                            <td width="100"><div align="right"></div></td>
                            <td width="100"><div align="right"></div></td>
                        </tr>
                    <?php } ?>
                </table>
            </div><br />
            <table cellspacing="0" cellpadding="5" border="0" width="100%">
                <tr>
                    <td width="53%" style="padding:0;"><strong>Removed By</strong></td>
                    <td width="47%"><strong>Checked By</strong></td>
                </tr>
                <tr>
                    <td style="padding:0;">Name</td>
                    <td>Name</td>
                </tr>
                <tr>
                    <td style="padding:0;">Sign</td>
                    <td>Sign</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="page-break"><span>&nbsp;</span></div>
    <?php } ?>




    <?php for($inv_cnt=0; $inv_cnt<count($invoice_details); $inv_cnt++){ ?>
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
                                    <td>Invoice Date: </td><td><?php if (isset($invoice_details[$inv_cnt]['date_of_processing'])) echo (($invoice_details[$inv_cnt]['date_of_processing']!=null && $invoice_details[$inv_cnt]['date_of_processing']!='')?date('d-M-y',strtotime($invoice_details[$inv_cnt]['date_of_processing'])):''); ?></td>
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
                                    <td>Vehicle Number: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['vehicle_number'])) echo $invoice_details[$inv_cnt]['vehicle_number']; ?></td>
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
            <td colspan="3" rowspan="8" valign="top" style="padding:0;">
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
                                    <td>Invoice Date: </td><td><?php if (isset($invoice_details[$inv_cnt]['date_of_processing'])) echo (($invoice_details[$inv_cnt]['date_of_processing']!=null && $invoice_details[$inv_cnt]['date_of_processing']!='')?date('d-M-y',strtotime($invoice_details[$inv_cnt]['date_of_processing'])):''); ?></td>
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
                                    <td>Vehicle Number: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['vehicle_number'])) echo $invoice_details[$inv_cnt]['vehicle_number']; ?></td>
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
            <td colspan="3" rowspan="8" valign="top" style="padding:0;">
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
                                    <td>Invoice Date: </td><td><?php if (isset($invoice_details[$inv_cnt]['date_of_processing'])) echo (($invoice_details[$inv_cnt]['date_of_processing']!=null && $invoice_details[$inv_cnt]['date_of_processing']!='')?date('d-M-y',strtotime($invoice_details[$inv_cnt]['date_of_processing'])):''); ?></td>
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
                                    <td>Vehicle Number: </td>
                                    <td><?php if (isset($invoice_details[$inv_cnt]['vehicle_number'])) echo $invoice_details[$inv_cnt]['vehicle_number']; ?></td>
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
            <td colspan="3" rowspan="8" valign="top" style="padding:0;">
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
    <?php } ?>




    <?php for($vou_cnt=0; $vou_cnt<count($voucher_details); $vou_cnt++){ ?>
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

        <div class="page-break"><span>&nbsp;</span></div>
    <?php } ?>




    <?php for($dst_cnt=0; $dst_cnt<count($distributor_details); $dst_cnt++){ ?>
        <div class="payment_details" style="width:500px; float:left; margin:10px;">
            <div style="width:500px;  ">
            <div align="center"><strong><h1>Pending Payment Ledger</h1></strong></div>
                <table cellspacing="0" cellpadding="5" border="0" width="87%"> 
                    <tr>
                        <td style="padding:0;" width="185">Distributor Name</td>
                        <td width="189" colspan="5"><div align="left"><?php echo $distributor_details[$dst_cnt][0]->distributor_name; ?></div></td>
                    </tr>
                    <tr>
                        <td style="padding:0;">Sales Representative</td>
                        <td colspan="5"><div align="left"><?php echo $distributor_details[$dst_cnt][0]->sales_rep_name; ?></div></td>
                    </tr>
                    <tr>
                        <td style="padding:0;"><strong>Total Payable</strong></td>
                        <td colspan="5"><div align="left"><strong><?php echo $total_amount[$dst_cnt]; ?></strong></div></td>
                    </tr>
                </table>
            </div>

            <br/>

            <div style="width:500px;">
                <table cellspacing="0" cellpadding="5" border="1">
                    <tr>
                        <td width="139"><div align="center"><strong>Ageing</strong></div></td>
                        <td width="132"><div align="center"><strong>0-30</strong></div></td>
                        <td width="107"><div align="center"><strong>30-60</strong></div></td>
                        <td width="123"><div align="center"><strong>60-90</strong></div></td>
                        <td width="64"><div align="center"><strong>90+</strong></div></td>
                    </tr>
                    <tr>
                        <td><div align="center"></div></td>
                        <td><div align="center"><?php if(isset($distributor_payments_ageing[$dst_cnt][0]->days_0_30)) echo $distributor_payments_ageing[$dst_cnt][0]->days_0_30; ?></div></td>
                        <td><div align="center"><?php if(isset($distributor_payments_ageing[$dst_cnt][0]->days_30_60)) echo $distributor_payments_ageing[$dst_cnt][0]->days_30_60; ?></div></td>
                        <td><div align="center"><?php if(isset($distributor_payments_ageing[$dst_cnt][0]->days_61_90)) echo $distributor_payments_ageing[$dst_cnt][0]->days_61_90; ?></div></td>
                        <td><div align="center"><?php if(isset($distributor_payments_ageing[$dst_cnt][0]->days_91_above)) echo $distributor_payments_ageing[$dst_cnt][0]->days_91_above; ?></div></td>
                    </tr>
                </table>
            </div>

            <br/>

            <div style="width:500px; ">  
                <table cellspacing="0" cellpadding="5" border="1">
                    <tr>
                        <td width="60"><div align="center"><strong>Sr. No.</strong></div></td>
                        <td width="132"><div align="center"><strong>Date of Invoice</strong></div></td>
                        <td width="128"><div align="center"><strong>Invoice Number</strong></div></td>
                        <td width="187"><div align="center"><strong>Amount of Invoice</strong></div></td>
                    </tr>
                    <?php for($i=0; $i<count($distributor_payments[$dst_cnt]); $i++){ ?>
                    <tr>
                        <td><div align="left"><?php echo $i+1; ?></div></td>
                        <td width="132"><div align="left"><?php if(isset($distributor_payments[$dst_cnt][$i]->invoice_date)) echo (($distributor_payments[$dst_cnt][$i]->invoice_date!=null && $distributor_payments[$dst_cnt][$i]->invoice_date!='')?date('d-M-Y',strtotime($distributor_payments[$dst_cnt][$i]->invoice_date)):date('d/m/Y')); else echo date('d/m/Y'); ?></div></td>
                        <td width="128"><div align="left"><?php echo $distributor_payments[$dst_cnt][$i]->invoice_no; ?></div></td>
                        <td width="187"><div align="right"><?php echo $distributor_payments[$dst_cnt][$i]->invoice_amount; ?></div></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2" style="border:0;">&nbsp;</td>
                        <td ><div align="center"><strong>Total</strong></div></td>
                        <td style="border:0;"><div align="right"><strong><?php echo $total_amount[$dst_cnt]; ?></strong></div></td>
                    </tr>
                </table>
            </div>

            <P>Please remove all the bills along with this summary</P>
            <div style="width:500px; ">   
                <table cellspacing="0" cellpadding="0" border="0" width="100%" >
                    <tr>
                        <td style="padding:0;"><strong>Removed By</strong></td>
                        <td><strong>Checked By</strong></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php //if($dst_cnt!=0 && $dst_cnt%3==0) { ?>
            <div class="page-break"><span>&nbsp;</span></div>
        <?php //} ?>
    <?php } ?>
</body>
</html>
