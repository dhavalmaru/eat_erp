<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Batch Processing Receipt</title>
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
    <?php if(count($data)>0){ ?>
    <div class="gate_pass_details">
        <div>
            <div align="center" style="background:#f00;"><strong><h1>Batch Processing Receipt</h1></strong></div>
            <div style="width:400px;  ">
                <table cellspacing="0" cellpadding="5" border="1"> 
                    <tr>
                        <td width="185">Location</td>
                        <td width="189" colspan="5"><div align="right"><?php if(isset($data[0]->depot_name)) echo $data[0]->depot_name; ?></div></td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td colspan="5"><div align="right"><?php echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):''); ?></div></td>
                    </tr>
                    <tr>
                        <td>Batch No</td>
                        <td colspan="5"><div align="right"><?php if(isset($data[0]->batch_id_as_per_fssai)) echo $data[0]->batch_id_as_per_fssai; ?></div></td>
                    </tr>
                    <tr>
                        <td>Product Name</td>
                        <td colspan="5"><div align="right"><?php if(isset($data[0]->product_name)) echo $data[0]->product_name; ?></div></td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td colspan="5"><div align="right"><?php if(isset($data[0]->qty_in_bar)) echo $data[0]->qty_in_bar; ?></div></td>
                    </tr>
                    <tr>
                        <td>Wastage</td>
                        <td colspan="5"><div align="right"><?php if(isset($data[0]->actual_wastage)) echo $data[0]->actual_wastage; ?></div></td>
                    </tr>
                    <tr>
                        <td>Created by</td>
                        <td colspan="5"><div align="right"><?php if(isset($data[0]->first_name)) echo $data[0]->first_name.' '.$data[0]->last_name; ?></div></td>
                    </tr>
                </table>
            </div><br />
            <div style=""> 
                <table cellspacing="0" cellpadding="5" border="1" width="100%">
                    <tr>
                        <td width="54"><div align="center"><strong>Sr. No.</strong></div></td>
                        <td width="227"><div align="center"><strong>Raw Material Name</strong></div></td>
                        <td width="102"><div align="center"><strong>Quantity</strong></div></td>
                    </tr>
                    <?php for($i=0; $i<count($batch_processing_items); $i++){ ?>
                        <tr>
                            <td><div><?php echo $i+1; ?></div></td>
                            <td><?php echo $batch_processing_items[$i]->rm_name; ?></td>
                            <td><div align="right"><?php echo $batch_processing_items[$i]->qty; ?></div></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>
</body>
</html>
