<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Production Report <?php if(isset($data)) echo $data[0]->id; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->

    <style>
    	@media print{@page {size: portrait}}
        @media print {
            .page-break { display: block; page-break-after: always; }
        }
        body {  margin:0; padding:0;  font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;}
        .debit_note {  margin:20px auto; border:0px solid #ddd; max-width:800px; }
        .header-section {text-align:center;}
        h1 { font-size:45px; font-weight:600!important; margin:0; padding:0; text-align:center; }
        h2 { font-size:23px; font-weight:600!important; margin: 0px; padding:0; text-align:center; padding-bottom:5px; }
        p{ padding:0; margin:0; font-size:13px; line-height:21px; }
        table  { margin:10px 0;   }
        table tr td  { border:1px solid #999;padding: 4px 7px;font-size: 15px;  }
       .main_table tr td  { border:1px solid #999; padding:15px 10px;  }
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
		.producion_report tr td 
		{
			font-size: 14px!important;
		}
		.rm_purchased,.pr_report
		{
			background: #245478!important;
			color: #fff!important;
		}
		.orange_bg {
			/*background: #F79646!important;*/
		}
		.orange_light_bg {
			/*background: #efaa2c94!important;*/
		}
        .blue_light_bg {
            /*background: #B7DEE8!important;*/
        }
        .blue_bg {
            /*background: #4F81BD!important;*/
        }
        .pink_bg {
            /*background: #FF66FF!important;*/
        }
    </style>
</head>

<body class="hold-transition">
<div class="debit_note">
    <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div>

    <h1><b><u>Production Report</u></b></h1>
				
    <table width="100%" border="0" cellspacing="0" class="table main_table" style="border-collapse:collapse;margin-top:80px  ">
		<tr style="font-size:15px; font-weight:500; margin-top:50px;">
            <td width="285" align="center" valign="top">  </td>
            <td width="285" align="center" valign="top"> Name </td>
            <td width="125" align="center" valign="top"> Date </td>
            <td width="285" align="center" valign="top"> Sign </td>
        </tr>
		<tr style="border-bottom:1px solid #666; font-size:15px; font-weight:500;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:18px;font-weight:700;">Prepared By</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php if(isset($data)) echo ucwords(strtolower($data[0]->modifiedby)); ?></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php if(isset($data)) echo (($data[0]->modified_on!=null && $data[0]->modified_on!='')?date('d-m-Y',strtotime($data[0]->modified_on)):''); ?></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"></td>
        </tr>
        <tr style="border-bottom:1px solid #666; font-size:15px; font-weight:500;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:18px;font-weight:700;">Checked By</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"></td>
        </tr>
		<tr style="border-bottom:1px solid #666; font-size:15px; font-weight:500;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:18px;font-weight:700;">Approved By</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php if(isset($data)) echo ucwords(strtolower($data[0]->approvedby)); ?></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php if(isset($data)) echo (($data[0]->approved_on!=null && $data[0]->approved_on!='')?date('d-m-Y',strtotime($data[0]->approved_on)):''); ?></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"></td>
        </tr>
    </table>

	<table width="100%" border="0" cellspacing="0" class="table main_table" style="border-collapse:collapse;width:300px;margin: 0 auto;margin-top:80px ">
		<tr style="border-bottom:1px solid #666;">
            <td valign="center" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-bottom:none;font-size:18px;font-weight:700;">MFG Date</td>
            <td valign="center" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-bottom:none;">
                <?php if(isset($batch_master)) { if(count($batch_master)>0) echo (($batch_master[0]->date_of_processing!=null && $batch_master[0]->date_of_processing!='')?date('d-m-Y',strtotime($batch_master[0]->date_of_processing)):''); } ?>
            </td>
		</tr>
		<tr style="border-bottom:1px solid #666;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:18px;font-weight:700;">Batch No</td>
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">
                <?php 
                if(isset($batch_master)) {
                    for($i=0; $i<count($batch_master); $i++) {
                        echo $batch_master[$i]->batch_no.'<br/>';
                    }
                }
                ?>
            </td>
		</tr>
    </table>

    <div class="page-break"><span>&nbsp;</span></div>
	
    <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div>

	<table width="100%" border="0" cellspacing="0" class="table" style="border-collapse:collapse;  ">
		<tr style="border:none;">
			<td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>1. <u>Production Date Confirmation</u></b></h2></td>
		</tr>
		<tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;"> &nbsp </tr>
        <tr style="font-size:15px; font-weight:700; ">
            <td width="50" align="left" valign="top">  </td>
            <td width="285" align="left" valign="top"> Scheduled / Not Scheduled </td>
            <td width="125" align="left" valign="top"> Scheduled </td>
        </tr>
        <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15px;font-weight:700;">1</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15px;font-weight:700;">Date Of Request For Production</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php if(isset($data)) echo (($data[0]->created_on!=null && $data[0]->created_on!='')?date('d-m-Y',strtotime($data[0]->created_on)):''); ?></td>
        </tr>
        <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15px;font-weight:700;">2</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15px;font-weight:700;">Date Of Requested For Production</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">
                <?php if(isset($data)) echo (($data[0]->from_date!=null && $data[0]->from_date!='')?date('d-m-Y',strtotime($data[0]->from_date)):''); ?>
                &nbsp; to &nbsp;
                <?php if(isset($data)) echo (($data[0]->to_date!=null && $data[0]->to_date!='')?date('d-m-Y',strtotime($data[0]->to_date)):''); ?>
            </td>
        </tr>
		<tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15px;font-weight:700;">3</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15px;font-weight:700;">Date Confirmed by MFU</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">
                <?php if(isset($data)) echo (($data[0]->confirm_from_date!=null && $data[0]->confirm_from_date!='')?date('d-m-Y',strtotime($data[0]->confirm_from_date)):''); ?>
                &nbsp; to &nbsp;
                <?php if(isset($data)) echo (($data[0]->confirm_to_date!=null && $data[0]->confirm_to_date!='')?date('d-m-Y',strtotime($data[0]->confirm_to_date)):''); ?>
            </td>
        </tr>
    </table>
	<br>
	<b><u>Remarks </u>:-</b> <span><?php if(isset($data)) { echo $data[0]->remarks; } ?></span>
	

	<table width="100%" border="0" cellspacing="0" class="table" style="border-collapse:collapse;  ">
		<tr style="border:none;">
			<td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>2. <u>Raw Material Purchased</u></b></h2></td>
		</tr>
        <tr style="border-bottom:1px solid #666; font-size:15px; font-weight:500;"> &nbsp </tr>
        <tr style="font-size:15px; font-weight:700; " class="rm_purchased">
            <td width="50" align="left" valign="top"> Sr No </td>
            <td width="285" align="center" valign="top"> Raw Material Purchased</td>
            <td width="90" align="center" valign="top"> Kg </td>
            <td width="140" align="center" valign="top"> Date Receiving by MFU </td>
            <td width="140" align="center" valign="top"> In Time or Late </td>
        </tr>
        <?php 
            if(isset($purchased_rm)){
                if(count($purchased_rm)>0){
                    for($i=0; $i<count($purchased_rm); $i++){
        ?>
            <tr style="border-bottom:1px solid #666; font-size:15px; font-weight:500;">
                <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15px;"><?php echo ($i+1); ?></td>
                <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15px;"><?php echo ucwords(strtolower($purchased_rm[$i]->rm_name)); ?></td>
                <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo format_money($purchased_rm[$i]->qty, 2); ?></td>
                <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo (($purchased_rm[$i]->date_of_receipt!=null && $purchased_rm[$i]->date_of_receipt!='')?date('d-m-Y',strtotime($purchased_rm[$i]->date_of_receipt)):''); ?></td>
                <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $purchased_rm[$i]->rm_status; ?></td>
            </tr>
        <?php 
                    }
                }
            }
        ?>
    </table>
	<table width="100%" border="0" cellspacing="0" class="table" style="border-collapse:collapse;  ">
		<tr style="border:none;">
			<td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>3. <u>Batch Wise Production Plan</u></b></h2></td>
		</tr>
		<tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;"> &nbsp </tr>
        <tr>
            <td width="285" align="center" valign="top" style="font-size:15px; font-weight:700;"> Date Of Sending </td>
            <td width="125" align="center" valign="top" style="font-size:15px; font-weight:700;"> <?php if(isset($data)) echo (($data[0]->batch_confirm_date!=null && $data[0]->batch_confirm_date!='')?date('d-m-Y',strtotime($data[0]->batch_confirm_date)):''); ?> (In Time) </td>
        </tr>
		<tr>
            <td width="285" align="center" valign="top" style="font-size:18px; font-weight:700; text-decoration: underline;"> SKU </td>
            <td width="125" align="center" valign="top" style="font-size:18px; font-weight:700; text-decoration: underline;"> No Of Batch </td>
        </tr>
        <?php 
            if(isset($batch_processing)){
                if(count($batch_processing)>0){
                    for($i=0; $i<count($batch_processing); $i++){
        ?>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15px;font-weight:700;"><?php echo $batch_processing[$i]->short_name; ?></td>
                <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php echo $batch_processing[$i]->no_of_batch; ?></td>
            </tr>
        <?php 
                    }
                }
            }
        ?>
    </table>
	<br>
	<b><u>Remarks </u>:-</b> <span><?php if(isset($batch_processing)){ if(isset($batch_processing[0]->remarks)) echo $batch_processing[0]->remarks; } ?></span>
	
    <div class="page-break"><span>&nbsp;</span></div>

 	<div class="header-section">
		<center style="width:100%;display:inline-block;margin:0 auto;">
			<img src="<?php echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
			<img src="<?php echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
		</center>
	</div>

	<h2 style="text-align:left"><b>4. <u>Raw Material Checking</u></b> <span style="text-align: right; float: right; ">Annexture A </span></h2>
	<b><u>Remarks </u>:-</b> 
    <span>
        <?php 
            $remarks = '';
            if(isset($raw_material_check_doc)) { 
                if(count($raw_material_check_doc)>0) $remarks = $raw_material_check_doc[0]->remarks;
            } 
            if($remarks==''){
                $remarks = 'There was no issue in raw material. All raw materials were in good condition.';
            }
            echo $remarks;
        ?>
    </span>
    <br/><br>

    <h2 style="text-align:left"><b>5. <u>Sorting </u></b> <span style="text-align: right; float: right; ">Annexture B </span></h2>
	<b><u>Remarks </u>:-</b> 
    <span>
        <?php 
            $remarks = '';
            if(isset($sorting_doc)) { 
                if(count($sorting_doc)>0) $remarks = $sorting_doc[0]->remarks;
            } 
            if($remarks==''){
                $remarks = 'No problem in sorting of raw material.';
            }
            echo $remarks;
        ?>
    </span>
	<br><br>

	<h2 style="text-align:left"><b>6. <u>Production Processing </u></b> <span style="text-align: right; float: right; ">Annexture C </span></h2>
	<b><u>Remarks </u>:-</b> 
    <span>
        <?php 
            $remarks = '';
            if(isset($processing_doc)) { 
                if(count($processing_doc)>0) $remarks = $processing_doc[0]->remarks;
            } 
            if($remarks==''){
                $remarks = 'There was no problem during the production process.';
            }
            echo $remarks;
        ?>
    </span>
	<br><br>

	<h2 style="text-align:left"><b>7. <u>Quality Control </u></b></h2>
    <ul>
        <li><h3 style="text-align:left"><b><u>Weight & Measure </u></b> <span style="text-align: right; float: right; ">Annexture D </span></h3>   
            <b><u>Remarks </u>:-</b> 
            <span>
                <?php 
                    $remarks = '';
                    if(isset($quality_control_doc)) { 
                        if(count($quality_control_doc)>0) $remarks = $quality_control_doc[0]->remarks;
                    } 
                    if($remarks==''){
                        $remarks = '';
                    }
                    echo $remarks;
                ?>
            </span>
        </li>
        <li><h3 style="text-align:left"><b><u>Shaping/Cutting & PVC Tray Filling </u></b> <span style="text-align: right; float: right; ">Annexture D<sub>1</sub> </span></h3> 
            <b><u>Remarks </u>:-</b> 
            <span>
                <?php 
                    $remarks = '';
                    if(isset($quality_control_doc)) { 
                        if(count($quality_control_doc)>0) $remarks = $quality_control_doc[0]->remarks2;
                    } 
                    if($remarks==''){
                        $remarks = 'There was no problem in shaping/cutting & PVC Tray filling. We reused damaged or break product to mixing.';
                    }
                    echo $remarks;
                ?>
            </span>
        </li>
    </ul>
	<br>

    <h2 style="text-align:left"><b>8. <u>Packaging </u></b></h2>
	<ul>
    	<li><h3 style="text-align:left"><b><u>Dummy Sample Test </u></b> <span style="text-align: right; float: right; ">Annexture E </span></h3>	
    		<b><u>Remarks </u>:-</b> 
            <span>
                <?php 
                    $remarks = '';
                    if(isset($packaging_doc)) { 
                        if(count($packaging_doc)>0) $remarks = $packaging_doc[0]->remarks;
                    } 
                    if($remarks==''){
                        $remarks = 'We packed 40 dummy sample and done water leak test. When we found least leakage,  i.e. 0 out of 40 dummy samples then we proceed for actual product packaging.';
                    }
                    echo $remarks;
                ?>
            </span>
    	</li>
    	<li><h3 style="text-align:left"><b><u>Wrapper Packaging & Double Seal Packaging </u></b> <span style="text-align: right; float: right; ">Annexture E<sub>1</sub> </span></h3>	
    		<b><u>Remarks </u>:-</b> 
            <span>
                <?php 
                    $remarks = '';
                    if(isset($packaging_doc)) { 
                        if(count($packaging_doc)>0) $remarks = $packaging_doc[0]->remarks2;
                    } 
                    if($remarks==''){
                        $remarks = 'Wrapper packaging done for all SKU. Wrapper packed product collected in corrugated box. After Water Leak test it proceeds for double seal packaging. Punctured products, after double seal packaging, return to wrapper packaging and same process as above.';
                    }
                    echo $remarks;
                ?>
            </span>
    	</li>
        <!-- <li><h3 style="text-align:left"><b><u>Water Leak Test </u></b> <span style="text-align: right; float: right; ">Annexture F </span></h3> 
            <b><u>Remarks </u>:-</b> <span>Water leak test was done.</span>
        </li> -->
	</ul>
	<br>

    <h2 style="text-align:left"><b>9. <u>QC Report of Sarjena </u></b> <span style="text-align: right; float: right; ">Annexture G </span></h2>
    <b><u>Remarks </u>:-</b> 
    <span>
        <?php 
            $remarks = '';
            if(isset($qc_report_doc)) { 
                if(count($qc_report_doc)>0) $remarks = $qc_report_doc[0]->remarks;
            } 
            echo $remarks;
        ?>
    </span>

	<div class="page-break"><span>&nbsp;</span></div>
	
    <div class="header-section">
		<center style="width:100%;display:inline-block;margin:0 auto;">
			<img src="<?php echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
			<img src="<?php echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
		</center>
	</div>

	<table width="100%" border="0" cellspacing="0" class="table producion_report" style="border-collapse:collapse;">
		<tr style="border:none;">
			<td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>10. <u>Production Report </u></b> <span style="text-align: right; float: right; ">Annexture H </span></h2></td>
		</tr>
    </table>
    <b><u>Remarks </u>:-</b> 
    <span><?php if(isset($data)) echo $data[0]->report_remarks;?></span>
    <br><br>

	<table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
		<tr style="border:none;">
			<td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>11. <u>ERP Updating </u></b> <span style="text-align: right; float: right; ">Annexture I </span></h2></td>
        </tr>
	</table>
	<table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse;">
        <tr style="font-size:15px; font-weight:500; ">
            <td width="285" align="center" valign="top">  </td>
            <td width="125" align="center" valign="top"> Date </td>
            <td width="115" align="center" valign="top"> Sign Of Operation Team </td>
        </tr>
        <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15x;font-weight:700;">Batch Process</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php if(isset($batch_processing[0]->date_of_processing)) { echo (($batch_processing[0]->date_of_processing!=null && $batch_processing[0]->date_of_processing!='')?date('d-m-Y',strtotime($batch_processing[0]->date_of_processing)):''); } ?></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"></td>
        </tr>
        <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
            <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;font-size:15x;font-weight:700;width:80px">Move MFU to Warehouse</td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><?php if(isset($depot_transfer[0]->date_of_processing)) { if(count($depot_transfer)>0) { echo (($depot_transfer[0]->date_of_transfer!=null && $depot_transfer[0]->date_of_transfer!='')?date('d-m-Y',strtotime($depot_transfer[0]->date_of_transfer)):''); }} ?></td>
            <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"></td>
        </tr>
    </table>
		
	<b><u>Remarks </u>:-</b> 
    <span>
        <?php 
            $remarks = '';
            if(isset($erp_updating_doc)) { 
                if(count($erp_updating_doc)>0) $remarks = $erp_updating_doc[0]->remarks;
            } 
            echo $remarks;
        ?>
    </span>
    <br><br>

 	<table width="100%" border="0" cellspacing="0" class="table" style="border-collapse:collapse;  ">
		<tr style="border:none;">
			<td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>12. <u>Physical Raw Material Test</u></b> <span style="text-align: right; float: right; ">Annexture J </span></h2></td>
		</tr>
	</table>
	<b><u>Remarks </u>:-</b> 
    <span>
        <?php 
            $remarks = '';
            if(isset($physical_rm_doc)) { 
                if(count($physical_rm_doc)>0) $remarks = $physical_rm_doc[0]->remarks;
            } 
            echo $remarks;
        ?>
    </span>
    <br><br>

	<table width="100%" border="0" cellspacing="0" class="table" style="border-collapse:collapse;  ">
		<tr style="border:none;">
			<td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>13. <u>Recon Of Raw Material With ERP </u></b> <span style="text-align: right; float: right; ">Annexture K </span></h2></td>
		</tr>
	</table>
	<b><u>Remarks </u>:-</b> 
    <span>
        <?php 
            $remarks = '';
            if(isset($recon_of_rm_doc)) { 
                if(count($recon_of_rm_doc)>0) $remarks = $recon_of_rm_doc[0]->remarks;
            } 
            echo $remarks;
        ?>
    </span>
    <br><br>
	
	<div class="page-break"><span>&nbsp;</span></div>

    
    <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div>
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>4. <u>Raw Material Checking </u></b> <span style="text-align: right; float: right; ">Annexture A </span></h2></td>
        </tr>
    </table>
    <?php 
        $bl_image_uploaded = false;
        if(isset($raw_material_check_doc)){
            if(count($raw_material_check_doc)>0){
                for($i=0; $i<count($raw_material_check_doc); $i++){
                    if($raw_material_check_doc[$i]->doc_path!='' && $raw_material_check_doc[$i]->doc_path!=null){ 
                        $bl_image_uploaded = true;
    ?>
        <img src="<?php echo base_url().$raw_material_check_doc[$i]->doc_path; ?>" style="height: 50px; width: 50px;" alt="Image Not Found" />
    <?php 
                    }
                }
            }
        }

        if($bl_image_uploaded==false) {
            echo 'Documents not uploaded.';
        }
    ?>
    <!-- <div class="page-break"><span>&nbsp;</span></div> -->

    <!-- <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php //echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php //echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div> -->
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>5. <u>Sorting </u></b> <span style="text-align: right; float: right; ">Annexture B </span></h2></td>
        </tr>
    </table>
    <?php 
        $bl_image_uploaded = false;
        if(isset($sorting_doc)){
            if(count($sorting_doc)>0){
                for($i=0; $i<count($sorting_doc); $i++){
                    if($sorting_doc[$i]->doc_path!='' && $sorting_doc[$i]->doc_path!=null){
                        $bl_image_uploaded = true;
    ?>
        <img src="<?php echo base_url().$sorting_doc[$i]->doc_path; ?>" style="height: 50px; width: 50px;" alt="Image Not Found" />
    <?php 
                    }
                }
            }
        }

        if($bl_image_uploaded==false) {
            echo 'Documents not uploaded.';
        }
    ?>
    <!-- <div class="page-break"><span>&nbsp;</span></div> -->
    
    <!-- <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php //echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php //echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div> -->
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>6. <u>Production Processing </u></b> <span style="text-align: right; float: right; ">Annexture C </span></h2></td>
        </tr>
    </table>
    <?php 
        $bl_image_uploaded = false;
        if(isset($processing_doc)){
            if(count($processing_doc)>0){
                for($i=0; $i<count($processing_doc); $i++){
                    if($processing_doc[$i]->doc_path!='' && $processing_doc[$i]->doc_path!=null){ 
                        $bl_image_uploaded = true;
    ?>
    <img src="<?php echo base_url().$processing_doc[$i]->doc_path; ?>" style="height: 50px; width: 50px;" alt="Image Not Found" />
    <?php 
                    }
                }
            }
        }

        if($bl_image_uploaded==false) {
            echo 'Documents not uploaded.';
        }
    ?>
    <!-- <div class="page-break"><span>&nbsp;</span></div> -->
    
    <!-- <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php //echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php //echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div> -->
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>7. <u>Quality Control </u></b> <span style="text-align: right; float: right; ">Annexture D </span></h2></td>
        </tr>
    </table>
    <?php 
        $bl_image_uploaded = false;
        if(isset($quality_control_doc)){
            if(count($quality_control_doc)>0){
                for($i=0; $i<count($quality_control_doc); $i++){
                    if($quality_control_doc[$i]->doc_path!='' && $quality_control_doc[$i]->doc_path!=null){ 
                        $bl_image_uploaded = true;
    ?>
        <img src="<?php echo base_url().$quality_control_doc[$i]->doc_path; ?>" style="height: 50px; width: 50px;" alt="Image Not Found" />
    <?php 
                    }
                }
            }
        }

        if($bl_image_uploaded==false) {
            echo 'Documents not uploaded.';
        }
    ?>
    <!-- <div class="page-break"><span>&nbsp;</span></div> -->
    
    <!-- <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php //echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php //echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div> -->
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>8. <u>Packaging </u></b> <span style="text-align: right; float: right; ">Annexture E </span></h2></td>
        </tr>
    </table>
    <?php 
        $bl_image_uploaded = false;
        if(isset($packaging_doc)){
            if(count($packaging_doc)>0){
                for($i=0; $i<count($packaging_doc); $i++){
                    if($packaging_doc[$i]->doc_path!='' && $packaging_doc[$i]->doc_path!=null){ 
                        $bl_image_uploaded = true;
    ?>
        <img src="<?php echo base_url().$packaging_doc[$i]->doc_path; ?>" style="height: 50px; width: 50px;" alt="Image Not Found" />
    <?php 
                    }
                }
            }
        }

        if($bl_image_uploaded==false) {
            echo 'Documents not uploaded.';
        }
    ?>
    <div class="page-break"><span>&nbsp;</span></div>
    
    <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div>
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>9. <u>QC Report of Sarjena </u></b> <span style="text-align: right; float: right; ">Annexture G </span></h2></td>
        </tr>
    </table>
    <?php 
        $bl_image_uploaded = false;
        if(isset($qc_report_doc)){
            if(count($qc_report_doc)>0){
                for($i=0; $i<count($qc_report_doc); $i++){
                    if($qc_report_doc[$i]->doc_path!='' && $qc_report_doc[$i]->doc_path!=null){ 
                        $bl_image_uploaded = true;
    ?>
        <img src="<?php echo base_url().$qc_report_doc[$i]->doc_path; ?>" style="height: 50px; width: 50px;" alt="Image Not Found" />
    <?php 
                    }
                }
            }
        }

        if($bl_image_uploaded==false) {
            echo 'Documents not uploaded.';
        }
    ?>
    <!-- <div class="page-break"><span>&nbsp;</span></div> -->
    
    <!-- <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php //echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php //echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div> -->
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>11. <u>ERP Updating </u></b> <span style="text-align: right; float: right; ">Annexture I </span></h2></td>
        </tr>
    </table>
    <?php 
        $bl_image_uploaded = false;
        if(isset($erp_updating_doc)){
            if(count($erp_updating_doc)>0){
                for($i=0; $i<count($erp_updating_doc); $i++){
                    if($erp_updating_doc[$i]->doc_path!='' && $erp_updating_doc[$i]->doc_path!=null){ 
                        $bl_image_uploaded = true;
    ?>
        <img src="<?php echo base_url().$erp_updating_doc[$i]->doc_path; ?>" style="height: 50px; width: 50px;" alt="Image Not Found" />
    <?php 
                    }
                }
            }
        }

        if($bl_image_uploaded==false) {
            echo 'Documents not uploaded.';
        }
    ?>
    <!-- <div class="page-break"><span>&nbsp;</span></div> -->

    <!-- <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php //echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php //echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div> -->
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>12. <u>Physical Raw Material Test </u></b> <span style="text-align: right; float: right; ">Annexture J </span></h2></td>
        </tr>
    </table>
    <?php 
        $bl_image_uploaded = false;
        if(isset($physical_rm_doc)){
            if(count($physical_rm_doc)>0){
                for($i=0; $i<count($physical_rm_doc); $i++){
                    if($physical_rm_doc[$i]->doc_path!='' && $physical_rm_doc[$i]->doc_path!=null){ 
                        $bl_image_uploaded = true;
    ?>
        <img src="<?php echo base_url().$physical_rm_doc[$i]->doc_path; ?>" style="height: 50px; width: 50px;" alt="Image Not Found" />
    <?php 
                    }
                }
            }
        }

        if($bl_image_uploaded==false) {
            echo 'Documents not uploaded.';
        }
    ?>
    <!-- <div class="page-break"><span>&nbsp;</span></div> -->

    <!-- <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php //echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php //echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div> -->
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>13. <u>Recon Of Raw Material With ERP </u></b> <span style="text-align: right; float: right; ">Annexture K </span></h2></td>
        </tr>
    </table>
    <?php 
        $bl_image_uploaded = false;
        if(isset($recon_of_rm_doc)){
            if(count($recon_of_rm_doc)>0){
                for($i=0; $i<count($recon_of_rm_doc); $i++){
                    if($recon_of_rm_doc[$i]->doc_path!='' && $recon_of_rm_doc[$i]->doc_path!=null){ 
                        $bl_image_uploaded = true;
    ?>
        <img src="<?php echo base_url().$recon_of_rm_doc[$i]->doc_path; ?>" style="height: 50px; width: 50px;" alt="Image Not Found" />
    <?php 
                    }
                }
            }
        }

        if($bl_image_uploaded==false) {
            echo 'Documents not uploaded.';
        }
    ?>
    <div class="page-break"><span>&nbsp;</span></div>

    
    <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div>
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>10. <u>Production Report </u></b> <span style="text-align: right; float: right; ">Annexture H </span></h2></td>
        </tr>
    </table>

    <?php 
        $total_no_of_batch = 0;
        $total_qty_in_bar = 0;
        $total_diff_in_bar = 0;
        $total_wastage_in_kg = 0;
        $short_name_td = '';
        $no_of_batch_td = '';
        $per_batch_kg_td = '';
        $blank_td = '';
        $total_kg_td = '';
        $anti_wl_td = '';
        $anti_wg_td = '';
        $anti_opkg_td = '';
        $anti_opgm_td = '';
        $anti_opbr_td = '';
        $qty_in_bar_td = '';
        $avg_gm_td = '';
        $diff_in_bar_td = '';
        $act_wg_td = '';
        $tot_wg_td = '';
        $act_wg_per_td = '';

        if(isset($batch_processing)){
            if(count($batch_processing)>0){
                for($i=0; $i<count($batch_processing); $i++){
                    $total_no_of_batch = $total_no_of_batch + $batch_processing[$i]->no_of_batch;
                    $total_qty_in_bar = $total_qty_in_bar + $batch_processing[$i]->qty_in_bar;
                    $total_diff_in_bar = $total_diff_in_bar + $batch_processing[$i]->difference_in_bars;
                    $total_wastage_in_kg = $total_wastage_in_kg + $batch_processing[$i]->actual_wastage;

                    $short_name_td = $short_name_td.'<td align="center">'.$batch_processing[$i]->short_name.'</td>';
                    $no_of_batch_td = $no_of_batch_td.'<td align="center" class="orange_bg">'.$batch_processing[$i]->no_of_batch.'</td>';
                    $per_batch_kg_td = $per_batch_kg_td.'<td align="center">'.round(($batch_processing[$i]->total_kg/$batch_processing[$i]->no_of_batch),2).'</td>';
                    $blank_td = $blank_td.'<td align="center" class="blue_light_bg">&nbsp;</td>';
                    $total_kg_td = $total_kg_td.'<td align="center">'.$batch_processing[$i]->total_kg.'</td>';
                    $anti_wl_td = $anti_wl_td.'<td align="center">'.(($batch_processing[$i]->anticipated_water_loss!='')?$batch_processing[$i]->anticipated_water_loss.' %':'').'</td>';
                    $anti_wg_td = $anti_wg_td.'<td align="center" class="orange_light_bg">'.(($batch_processing[$i]->anticipated_wastage!='')?$batch_processing[$i]->anticipated_wastage.' %':'').'</td>';
                    $anti_opkg_td = $anti_opkg_td.'<td align="center" class="orange_light_bg">'.$batch_processing[$i]->anticipated_output_in_kg.'</td>';
                    $anti_opgm_td = $anti_opgm_td.'<td align="center" class="blue_light_bg">'.$batch_processing[$i]->anticipated_grams.'</td>';
                    $anti_opbr_td = $anti_opbr_td.'<td align="center">'.$batch_processing[$i]->anticipated_output_in_bars.'</td>';
                    $qty_in_bar_td = $qty_in_bar_td.'<td align="center" class="orange_bg">'.$batch_processing[$i]->qty_in_bar.'</td>';
                    $avg_gm_td = $avg_gm_td.'<td align="center" class="orange_bg">'.$batch_processing[$i]->avg_grams.'</td>';
                    $diff_in_bar_td = $diff_in_bar_td.'<td align="center" class="blue_light_bg">'.$batch_processing[$i]->difference_in_bars.'</td>';
                    $act_wg_td = $act_wg_td.'<td align="center" class="orange_bg">'.$batch_processing[$i]->actual_wastage.'</td>';
                    $tot_wg_td = $tot_wg_td.'<td align="center" class="blue_light_bg">'.$batch_processing[$i]->total_wastage.'</td>';
                    $act_wg_per_td = $act_wg_per_td.'<td align="center"'.(($batch_processing[$i]->actual_wastage_percent<0)?'class="pink_bg"':'').'>'.(($batch_processing[$i]->actual_wastage_percent!='')?$batch_processing[$i]->actual_wastage_percent.' %':'').'</td>';
                }
            }
        }

        $pack_of_20_td = '';
        $variety_pack_td = '';
        $pack_of_6_td = '';
        $single_bars_td = '';
        $serjana_bars_td = '';
        $total_bars_td = '';
        $gate_pass_in_td = '';
        $difference_bars_td = '';
        $pack_of_20_qty = 0;
        $variety_pack_qty = 0;
        $pack_of_6_qty = 0;
        if(isset($batch_processing_qty)){
            if(count($batch_processing_qty)>0){
                for($i=0; $i<count($batch_processing_qty); $i++){
                    if($batch_processing_qty[$i]['pack_of_20']!=null && $batch_processing_qty[$i]['pack_of_20']!=''){
                        $pack_of_20_qty = $pack_of_20_qty + intval($batch_processing_qty[$i]['pack_of_20']);
                    }
                    if($batch_processing_qty[$i]['variety_pack']!=null && $batch_processing_qty[$i]['variety_pack']!=''){
                        $variety_pack_qty = $variety_pack_qty + intval($batch_processing_qty[$i]['variety_pack']);
                    }
                    if($batch_processing_qty[$i]['pack_of_6']!=null && $batch_processing_qty[$i]['pack_of_6']!=''){
                        $pack_of_6_qty = $pack_of_6_qty + intval($batch_processing_qty[$i]['pack_of_6']);
                    }
                    
                    $pack_of_20_td = $pack_of_20_td.'<td align="center" class="orange_bg">'.$batch_processing_qty[$i]['pack_of_20'].'</td>';
                    $variety_pack_td = $variety_pack_td.'<td align="center" class="orange_bg">'.$batch_processing_qty[$i]['variety_pack'].'</td>';
                    $pack_of_6_td = $pack_of_6_td.'<td align="center" class="orange_bg">'.$batch_processing_qty[$i]['pack_of_6'].'</td>';
                    $single_bars_td = $single_bars_td.'<td align="center" class="orange_bg">'.$batch_processing_qty[$i]['single_bars'].'</td>';
                    $serjana_bars_td = $serjana_bars_td.'<td align="center" class="orange_bg">'.$batch_processing_qty[$i]['serjana_bars'].'</td>';
                    $total_bars_td = $total_bars_td.'<td align="center" class="orange_bg">'.$batch_processing_qty[$i]['total_bars'].'</td>';
                    $gate_pass_in_td = $gate_pass_in_td.'<td align="center" class="blue_bg">'.$batch_processing_qty[$i]['gate_pass_in'].'</td>';
                    $difference_bars_td = $difference_bars_td.'<td align="center" class="orange_light_bg">'.$batch_processing_qty[$i]['difference_bars'].'</td>';
                }
            }
        }
    ?>
	<table width="100%" border="0" cellspacing="0" class="table producion_report" style="border-collapse:collapse;">
		<thead>
        	<tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;" class="pr_report">
        		<td>Particulars </td>
        		<td align="left">Ref</td>
                <?php echo $short_name_td; ?>
        		<td>Total</td>
        	</tr>
        </thead>
		<tbody>
    		<tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">No Of Batches</td>
                <td class="blue_light_bg"></td>
                <?php echo $no_of_batch_td; ?>
                <td align="center" class="blue_light_bg"><?php echo $total_no_of_batch; ?></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>Per Batch</td>
                <td></td>
                <?php echo $per_batch_kg_td; ?>
                <td align="center"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">&nbsp;</td>
                <td class="blue_light_bg"></td>
                <?php echo $blank_td; ?>
                <td align="center" class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>Total Batch Produced</td>
                <td></td>
                <?php echo $total_kg_td; ?>
                <td align="center"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">Anticipated Water Loss</td>
                <td class="blue_light_bg"></td>
                <?php echo $anti_wl_td; ?>
                <td align="center" class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>Anticipated Wastage</td>
                <td></td>
                <?php echo $anti_wg_td; ?>
                <td align="center"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">Anticipated Output</td>
                <td class="blue_light_bg">KG</td>
                <?php echo $anti_opkg_td; ?>
                <td align="center" class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>Anticipated Gramage</td>
                <td></td>
                <?php echo $anti_opgm_td; ?>
                <td align="center"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">Anticipated Output</td>
                <td class="blue_light_bg">Product</td>
                <?php echo $anti_opbr_td; ?>
                <td align="center" class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>&nbsp;</td>
                <td></td>
                <?php echo $blank_td; ?>
                <td align="center"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">Actual Products</td>
                <td class="blue_light_bg">Product</td>
                <?php echo $qty_in_bar_td; ?>
                <td align="center" class="blue_light_bg"><?php echo $total_qty_in_bar; ?></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>Actual grams per Product</td>
                <td></td>
                <?php echo $avg_gm_td; ?>
                <td align="center"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">Difference in Products</td>
                <td class="blue_light_bg">Product</td>
                <?php echo $diff_in_bar_td; ?>
                <td align="center" class="blue_light_bg"><?php echo $total_diff_in_bar; ?></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>Wastage in KG</td>
                <td>KG</td>
                <?php echo $act_wg_td; ?>
                <td align="center"><?php echo $total_wastage_in_kg; ?></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">Total Wastage in KG</td>
                <td class="blue_light_bg">KG</td>
                <?php echo $tot_wg_td; ?>
                <td align="center" class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>Actual % Wastage/ Output</td>
                <td></td>
                <?php echo $act_wg_per_td; ?>
                <td align="center"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">&nbsp;</td>
                <td class="blue_light_bg"></td>
                <?php echo $blank_td; ?>
                <td class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td><strong>Packaging</strong></th>
                <td></td>
                <?php echo $blank_td; ?>
                <td></td>
            </tr>

            <tr style="border-bottom:1px solid #666; font-size:15px; font-weight:500; <?php if($pack_of_20_qty==0) echo 'display:none;'; ?>">
                <td class="blue_light_bg"><strong>Pack of 20</strong> </td>
                <td class="blue_light_bg"><strong>20</strong></td>
                <?php echo $pack_of_20_td; ?>
                <td class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666; font-size:15px; font-weight:500;  <?php if($variety_pack_qty==0) echo 'display:none;'; ?>">
                <td><strong>Variety Pack </strong></td>
                <td><strong>1 </strong></td>
                <?php echo $variety_pack_td; ?>
                <td></td>
            </tr>
            <tr style="border-bottom:1px solid #666; font-size:15px; font-weight:500;  <?php if($pack_of_6_qty==0) echo 'display:none;'; ?>">
                <td class="blue_light_bg"><strong>Pack of 6</strong> </td>
                <td class="blue_light_bg"><strong>6</strong></td>
                <?php echo $pack_of_6_td; ?>
                <td class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td><strong>Single</strong></th>
                <td><strong>1</strong></td>
                <?php echo $single_bars_td; ?>
                <td></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg"><strong>Testing products @ MFU</strong></th>
                <td class="blue_light_bg"><strong>1</strong></td>
                <?php echo $serjana_bars_td; ?>
                <td class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>Difference</td>
                <td>1</td>
                <?php echo $total_bars_td; ?>
                <td></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">&nbsp;</td>
                <td class="blue_light_bg"></td>
                <?php echo $blank_td; ?>
                <td class="blue_light_bg"></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td>Gate Pass In by EAT</td>
                <td>1</td>
                <?php echo $gate_pass_in_td; ?>
                <td></td>
            </tr>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td class="blue_light_bg">Difference</td>
                <td class="blue_light_bg">1</td>
                <?php echo $difference_bars_td; ?>
                <td class="blue_light_bg"></td>
            </tr>
		<tbody>																									
	</table>
	
    <div class="page-break"><span>&nbsp;</span></div>
	
    <div class="header-section">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <img src="<?php echo base_url().'assets/invoice/'; ?>logo.png" alt=""  style="vertical-align: top;margin-top: 0px;width:200px;float:right" />
            <img src="<?php echo base_url().'img/'; ?>eat-blue.png" alt=""  style="vertical-align: top;margin-top: 0px;width:100px;float:left" />
        </center>
    </div>
    <table width="100%" border="0" cellspacing="0" class="table " style="border-collapse:collapse; ">
        <tr style="border:none;">
            <td style="border:none;" colspan="6" align="left"><h2 style="text-align:left"><b>11. <u>ERP Updating </u></b> <span style="text-align: right; float: right; ">Annexture I </span></h2></td>
        </tr>
    </table>
    <?php
        $ann1_colspan = 9;
        $erp_upd_span = 7;
        $sign_of_span = 6;
        if($pack_of_20_qty==0) { $ann1_colspan=$ann1_colspan-1; $erp_upd_span=$erp_upd_span-1; $sign_of_span=$sign_of_span-1; }
        if($variety_pack_qty==0) { $ann1_colspan=$ann1_colspan-1; $erp_upd_span=$erp_upd_span-1; $sign_of_span=$sign_of_span-1; }
        if($pack_of_6_qty==0) { $ann1_colspan=$ann1_colspan-1; $erp_upd_span=$erp_upd_span-1; $sign_of_span=$sign_of_span-1; }
    ?>
	<table width="100%" border="0" cellspacing="0" class="table" style="border-collapse:collapse;">
        <tr style="background:#b3e0f3">
            <td colspan="<?php echo $ann1_colspan; ?>" style="text-align: center; font-size:24px;">ANNEXURE I</td>
        </tr>
        <tr style="background:#b3e0f3">
            <td colspan="<?php echo $erp_upd_span; ?>" style="text-align: center;font-size:20px;">ERP Updating </td>
            <td colspan="2" style="text-align: center;"> <img src="<?php echo base_url().'assets/invoice/'; ?>logo.png" style="width:160px;position: relative;" /></td>
        </tr>										
        <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
            <td style="text-align: center;">SKU </td>
            <td style="text-align: center;">Batch Number</td>
            <td style="text-align: center; <?php if($pack_of_20_qty==0) echo 'display:none;'; ?>">Pack Of 20</td>
            <td style="text-align: center; <?php if($variety_pack_qty==0) echo 'display:none;'; ?>">Variety Pack</th>
            <td style="text-align: center; <?php if($pack_of_6_qty==0) echo 'display:none;'; ?>">Pack Of 6</th>
            <td style="text-align: center;">Products transfer to Warehouse</th>
            <td style="text-align: center;">Products at MFU</th>
            <td style="text-align: center;">Products transfer to Office</th>
            <td style="text-align: center;">Total Products in Production</th>
        </tr>
        <?php 
                if(isset($batch_processing_qty)){
                    if(count($batch_processing_qty)>0){
                        for($i=0; $i<count($batch_processing_qty); $i++){
        ?>
            <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">
                <td align="center"><?php echo $batch_processing_qty[$i]['short_name']; ?></td>
                <td align="center"><?php echo $batch_processing_qty[$i]['batch_no']; ?></td>
                <td align="center" style="<?php if($pack_of_20_qty==0) echo 'display:none;'; ?>"><?php echo $batch_processing_qty[$i]['pack_of_20']; ?></td>
                <td align="center" style="<?php if($variety_pack_qty==0) echo 'display:none;'; ?>"><?php echo $batch_processing_qty[$i]['variety_pack']; ?></td>
                <td align="center" style="<?php if($pack_of_6_qty==0) echo 'display:none;'; ?>"><?php echo $batch_processing_qty[$i]['pack_of_6']; ?></td>
                <td align="center"><?php echo $batch_processing_qty[$i]['transfer_to_warehouse']; ?></td>
                <td align="center"><?php echo $batch_processing_qty[$i]['serjana_bars']; ?></td>
                <td align="center"><?php echo $batch_processing_qty[$i]['transfer_to_ho']; ?></td>
                <td align="center"><?php echo $batch_processing_qty[$i]['total_bars']; ?></td>
            </tr>
        <?php 
                    }
                }
            }
        ?>
        <tr style="border-bottom:1px solid #666;font-size:15px; font-weight:500;">	
            <td colspan="<?php echo $sign_of_span; ?>" style="padding:20px" align="center">Sign Of Product Team</td>
            <td align="center" style="padding:20px">Date:-</td>
            <td colspan="3" style="padding:20px"align="center">Sign Of Operation Team</td>
        </tr>
	</table>

    <div style="<?php if($approve=='' || $approve==null) echo 'display: none;'; ?>">
        <form id="form_production_report_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($id)) echo base_url(). 'index.php/production/update_report/' . $id; ?>" enctype="multipart/form-data" >
        <div class="panel-footer">
            <br/><br/>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks:- </label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <input type="hidden" name="report_status" id="report_status" value="<?php if(isset($data)) echo $data[0]->report_status;?>" />
                        <textarea class="form-control" name="report_remarks" cols="100" rows="5"><?php if(isset($data)) echo $data[0]->report_remarks;?></textarea>
                    </div>
                </div>
            </div>

            <?php 
                $action = base_url().'index.php/production/post_details/'.$id;
            ?>
            <br/>
            <a href="<?php echo $action; ?>" class="btn btn-danger btn-sm pull-right" type="reset" id="reset" style="float: left;">Cancel</a>
            <?php $curusr=$this->session->userdata('session_id'); ?>
            <input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Submit For Approval" style="float: right; <?php if(isset($access)) {if(isset($data)) {if($access[0]->r_edit=='1' && ($data[0]->modified_by==$curusr || $data[0]->report_status==null || $data[0]->report_status=='Approved' || $data[0]->report_status=='InActive')) echo ''; else echo 'display: none;';} else if($access[0]->r_insert=='1') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>" />
            <input type="submit" class="btn btn-danger btn-sm" id="btn_reject" name="btn_reject" value="Reject" style="float: right; margin-left: 10px; <?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->report_status!=null && $data[0]->report_status!='Approved' && $data[0]->report_status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
            <input type="submit" class="btn btn-success btn-sm" id="btn_approve" name="btn_approve" value="Approve" style="float: right; <?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->report_status!=null && $data[0]->report_status!='Approved' && $data[0]->report_status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
            <br/><br/><br/>
        </div>
        </form>
    </div>
</div>
</body>
</html>