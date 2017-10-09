<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Cheque </title>
<style>
@font-face {
    font-family: "OpenSans-Regular";
    src: url("<?php echo base_url().'/assets/invoice/'; ?>OpenSans-Regular.ttf") format("truetype");
}
*{margin:0; padding:0;		}
 img { }
  @media print{@page {size: landscape}}
  body { font-family: "verdana"; font-size:13px; font-weight:500; margin:0; padding:0;		}
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    width: 1330px;
    margin-left: 5px;
    margin-top: 10px;
    padding:6px 10px;
}
th { font-size:15px; padding:5px 10px; font-weight:400; }
</style>
</head>

<body>

<div style="width:1349px; height:550px; " >
 <img src="<?php echo base_url().'/assets/invoice/'; ?>cheque.png " style="width:100%; overflow:auto;"/>
 <!--Date Left Side  Start-->
<div  style="position: absolute;  top:48px;   left:18.6%;  font-size: 22px; font-weight:600; "> <?php if (isset($d1)) echo $d1; ?> </div> 
<div  style="position: absolute;  top:48px;   left: 20.6%;  font-size: 22px; font-weight:600; "> <?php if (isset($d2)) echo $d2; ?> </div> 
<div  style="position: absolute;  top:48px;   left: 23.2%;  font-size: 22px; font-weight:600; "> <?php if (isset($m1)) echo $m1; ?> </div> 
<div  style="position: absolute;  top:48px;   left: 25.3%;  font-size: 22px; font-weight:600; "> <?php if (isset($m2)) echo $m2; ?> </div> 
<div  style="position: absolute;  top:48px;   left: 27.9%;  font-size: 22px; font-weight:600; "> <?php if (isset($y1)) echo $y1; ?> </div> 
<div  style="position: absolute;   top:48px;   left: 30%;  font-size: 22px; font-weight:600; "> <?php if (isset($y2)) echo $y2; ?> </div> 
<div  style="position: absolute; top:48px;  left: 32.1%;  font-size: 22px; font-weight:600; "> <?php if (isset($y3)) echo $y3; ?> </div> 
<div  style="position: absolute;  top:48px;   left: 34.2%;  font-size: 22px; font-weight:600; "> <?php if (isset($y4)) echo $y4; ?> </div> 
 <!--Date Left Side  End-->
 
  <!--Date Right Side  Start-->
 <div  style="position: absolute;  top:45px;   right:2.1%;  font-size: 22px; font-weight:600; "> <?php if (isset($y4)) echo $y4; ?> </div> 
<div  style="position: absolute;   top:45px;   right:4.3%;   font-size: 22px; font-weight:600; "> <?php if (isset($y3)) echo $y3; ?> </div> 
<div  style="position: absolute;   top:45px;   right:6.4%;   font-size: 22px; font-weight:600; "> <?php if (isset($y2)) echo $y2; ?> </div> 
<div  style="position: absolute;   top:45px;    right:8.5%;   font-size: 22px; font-weight:600; "> <?php if (isset($y1)) echo $y1; ?> </div> 
<div  style="position: absolute;   top:45px;   right:11%;   font-size: 22px; font-weight:600; "> <?php if (isset($m2)) echo $m2; ?> </div> 
<div  style="position: absolute;   top:45px;   right:13.1%;  font-size: 22px; font-weight:600; "> <?php if (isset($m1)) echo $m1; ?> </div> 
<div  style="position: absolute;  top:45px;   right:15.7%;  font-size: 22px; font-weight:600; "> <?php if (isset($d2)) echo $d2; ?> </div> 
<div  style="position: absolute;  top:45px;   right:17.8%;  font-size: 22px; font-weight:600; "> <?php if (isset($d1)) echo $d1; ?> </div> 
  <!--Date Right Side  End-->


<!--cheque Details Left Side Start-->

<!--cheque details-->
<div style="width: 226px; position: absolute;  top: 229px; left: 1%;"> <?php if (isset($items['0']->payment_mode)) echo $items['0']->payment_mode; ?><?php if (isset($items['0']->payment_mode) && isset($id)) echo ' - ' . $id; ?> </div> 
<div style="width: 226px; position: absolute;  top: 259px; left: 1%;"> <?php if (isset($items['1']->payment_mode)) echo $items['1']->payment_mode; ?><?php if (isset($items['1']->payment_mode) && isset($id)) echo ' - ' . $id; ?> </div> 
<div style="width: 226px; position: absolute;  top: 289px; left: 1%;"> <?php if (isset($items['2']->payment_mode)) echo $items['2']->payment_mode; ?><?php if (isset($items['2']->payment_mode) && isset($id)) echo ' - ' . $id; ?> </div> 
<div style="width: 226px; position: absolute;  top: 319px; left: 1%;"> <?php if (isset($items['3']->payment_mode)) echo $items['3']->payment_mode; ?><?php if (isset($items['3']->payment_mode) && isset($id)) echo ' - ' . $id; ?> </div> 
<div style="width: 226px; position: absolute;  top: 348px; left: 1%;"> <?php if (isset($items['4']->payment_mode)) echo $items['4']->payment_mode; ?><?php if (isset($items['4']->payment_mode) && isset($id)) echo ' - ' . $id; ?> </div> 
  <!--Cheque details End-->
 
 <!--Cheque No. Start-->
<div style="width:100px; position: absolute;  top: 229px;  left:18.5%;"> <?php if (isset($items['0']->cheque_no)) echo $items['0']->cheque_no; ?> </div> 
<div style="width:100px; position: absolute;  top: 259px;  left:18.5%;"> <?php if (isset($items['1']->cheque_no)) echo $items['1']->cheque_no; ?> </div> 
<div style="width:100px; position: absolute;  top: 289px;  left:18.5%;"> <?php if (isset($items['2']->cheque_no)) echo $items['2']->cheque_no; ?> </div> 
<div style="width:100px; position: absolute;  top: 319px;  left:18.5%;"> <?php if (isset($items['3']->cheque_no)) echo $items['3']->cheque_no; ?> </div> 
<div style="width:100px; position: absolute;  top: 348px;  left:18.5%;"> <?php if (isset($items['4']->cheque_no)) echo $items['4']->cheque_no; ?> </div> 
 <!--Cheque No. End-->

 <!--Rs. Start-->
<div style="width:118px; position: absolute;  top: 229px;  left:26.7%; text-align:right;"> <?php if (isset($items['0']->payment_amount)) echo $items['0']->payment_amount; ?> </div> 
<div style="width:118px; position: absolute;  top: 259px;   left:26.7%; text-align:right;"> <?php if (isset($items['1']->payment_amount)) echo $items['1']->payment_amount; ?> </div> 
<div style="width:118px; position: absolute;  top: 289px;  left:26.7%; text-align:right;"> <?php if (isset($items['2']->payment_amount)) echo $items['2']->payment_amount; ?> </div> 
<div style="width:118px; position: absolute;  top: 319px;  left:26.7%; text-align:right;"> <?php if (isset($items['3']->payment_amount)) echo $items['3']->payment_amount; ?> </div> 
<div style="width:118px; position: absolute;  top: 348px;   left:26.7%; text-align:right;"> <?php if (isset($items['4']->payment_amount)) echo $items['4']->payment_amount; ?> </div> 
<div style="width:118px; position: absolute;  top: 376px;   left:26.7%; text-align:right;"> <?php if (isset($total_amount)) echo $total_amount; ?> </div> 

<div style="width:350px; position: absolute;  top: 398px;   left:9.7%; line-height:20px;"> <?php if (isset($total_amount_in_words)) echo $total_amount_in_words; ?> </div> 
 
 <!--Rs. End-->
 <!--Cheque Details Left Sided End-->
 
 
 
 
<!--cheque Details Right Side Start-->
<div style="position:relative; margin-left:40.8%; margin-top:-540px;">
<!--Branch Name Start-->
		<div style="width: 190px;position: absolute;   top: 226px; left: 0%;"> <?php if (isset($items['0']->bank_name)) echo $items['0']->bank_name; ?> </div> 
		<div style="width: 190px; position: absolute;  top: 253px; left:0%;"> <?php if (isset($items['1']->bank_name)) echo $items['1']->bank_name; ?> </div> 
		<div style="width: 190px; position: absolute;  top: 279px; left: 0%;"> <?php if (isset($items['2']->bank_name)) echo $items['2']->bank_name; ?> </div> 
		<div style="width: 190px; position: absolute;  top: 305px; left:0%;"> <?php if (isset($items['3']->bank_name)) echo $items['3']->bank_name; ?> </div> 
		<div style="width: 190px; position: absolute;  top: 331px; left: 0%;"> <?php if (isset($items['4']->bank_name)) echo $items['4']->bank_name; ?> </div> 
		<div style="width: 190px; position: absolute;  top: 359px; left: 0%;"> <?php if (isset($items['5']->bank_name)) echo $items['5']->bank_name; ?> </div> 
		  <!--Branch Name End-->
		 
		 <!--City Start-->
		<div style="width:100px; position: absolute;  top: 226px;  left:25.1%; text-align:center;"> <?php if (isset($items['0']->bank_city)) echo $items['0']->bank_city; ?> </div> 
		<div style="width:100px; position: absolute;  top: 253px;  left:25.1%; text-align:center;"> <?php if (isset($items['1']->bank_city)) echo $items['1']->bank_city; ?> </div> 
		<div style="width:100px; position: absolute;  top: 279px;  left:25.1%; text-align:center;"> <?php if (isset($items['2']->bank_city)) echo $items['2']->bank_city; ?> </div> 
		<div style="width:100px; position: absolute;  top: 305px;  left:25.1%; text-align:center;"> <?php if (isset($items['3']->bank_city)) echo $items['3']->bank_city; ?> </div> 
		<div style="width:100px; position: absolute;  top: 331px;  left:25.1%; text-align:center;"> <?php if (isset($items['4']->bank_city)) echo $items['4']->bank_city; ?> </div> 
		<div style="width:100px; position: absolute;  top: 359px;  left:25.1%; text-align:center;"> <?php if (isset($items['5']->bank_city)) echo $items['5']->bank_city; ?> </div> 
		 <!--City End-->

		 <!--Cheque No Start-->
		<div style="width:130px; position: absolute;  top: 229px;  left:39.1%;"> <?php if (isset($items['0']->cheque_no)) echo $items['0']->cheque_no; ?> </div> 
		<div style="width:130px; position: absolute;  top: 256px;   left:39.1%;"> <?php if (isset($items['1']->cheque_no)) echo $items['1']->cheque_no; ?> </div> 
		<div style="width:130px; position: absolute;  top: 282px;  left:39.1%;"> <?php if (isset($items['2']->cheque_no)) echo $items['2']->cheque_no; ?>  </div> 
		<div style="width:130px; position: absolute;  top: 308px;  left:39.1%;"> <?php if (isset($items['3']->cheque_no)) echo $items['3']->cheque_no; ?> </div> 
		<div style="width:130px; position: absolute;  top: 334px;   left:39.1%;"> <?php if (isset($items['4']->cheque_no)) echo $items['4']->cheque_no; ?> </div>
		<div style="width:130px; position: absolute;  top: 362px;   left:39.1%;">  </div>
		<div style="width:340px; position: absolute;  top: 382px;   left:13.9%; line-height:30px;"> <?php if (isset($total_amount_in_words)) echo $total_amount_in_words; ?> </div> 
		 <!--Cheque No End-->


		 <!--Denomination. Start-->
		<div style="width:170px; position: absolute;  top: 227px;  left:74.8%; text-align:right;"> <?php //if (isset($denomination['0']->denomination_2000)) {if ($denomination['0']->denomination_2000>0) echo $denomination['0']->denomination_2000*2000;} ?> </div> 
		<div style="width:170px; position: absolute;  top: 254px;  left:74.8%; text-align:right;"> <?php if (isset($denomination['0']->denomination_1000)) {if ($denomination['0']->denomination_1000>0) echo $denomination['0']->denomination_1000*1000;} ?> </div> 
		<div style="width:170px; position: absolute;  top: 280px;  left:74.8%; text-align:right;"> <?php if (isset($denomination['0']->denomination_500)) {if ($denomination['0']->denomination_500>0) echo $denomination['0']->denomination_500*500;} ?> </div> 
		<div style="width:170px; position: absolute;  top: 306px;  left:74.8%; text-align:right;"> <?php if (isset($denomination['0']->denomination_100)) {if ($denomination['0']->denomination_100>0) echo $denomination['0']->denomination_100*100;} ?> </div> 
		<div style="width:170px; position: absolute;  top: 332px;  left:74.8%; text-align:right;"> <?php if (isset($denomination['0']->denomination_50)) {if ($denomination['0']->denomination_50>0) echo $denomination['0']->denomination_50*50;} ?> </div> 
		<div style="width:170px; position: absolute;  top: 360px;  left:74.8%; text-align:right;"> <?php if (isset($denomination['0']->denomination_20)) {if ($denomination['0']->denomination_20>0) echo $denomination['0']->denomination_20*20;} ?> </div> 
		<div style="width:170px; position: absolute;  top: 360px;  left:74.8%; text-align:right;"> <?php if (isset($denomination['0']->denomination_10)) {if ($denomination['0']->denomination_10>0) echo $denomination['0']->denomination_10*10;} ?> </div> 
		<div style="width:170px; position: absolute;  top: 386px;  left:74.8%; text-align:right;"> <?php if (isset($denomination['0']->denomination_other_amount)) {if ($denomination['0']->denomination_other_amount>0) echo $denomination['0']->denomination_other_amount;} ?> </div> 
		<div style="width:170px; position: absolute;  top: 415px;  left:74.8%; text-align:right;"> <?php if (isset($total_amount)) echo $total_amount; ?> </div> 
		 <!--Denomination. End-->
 </div>
 <!--Cheque Details Right Sided End-->
</div>


<div style=" border-top:1px dashed #999; padding-top:10px;">
<table>

	<thead>
		<tr><th colspan="9"><h4>PIS Report</h4></th></tr>
	</thead>
	<tbody>
		<tr style="padding-bottom:0!important;">
			<td style="font-weight:bold; text-decoration:none; border:none;"> <span style="border-bottom:0px solid #666; padding-bottom:5px;"> Deposit Slip:</span></td>
			<td style="border:none;"><?php if (isset($id)) echo $id; ?></td>
			 <td style="font-weight:bold; text-decoration:none; border:none;"> <span style="border-bottom:0px solid #666; padding-bottom:5px;">Deposit Date:</span></td>
			<td style="border:none;"><?php if (isset($date_of_deposit)) echo date('d/m/Y',strtotime($date_of_deposit)); ?></td>
				<td style="font-weight:bold; text-decoration:none; border:none;"> <span style="border-bottom:0px solid #666; padding-bottom:5px;"> Deposit Mode: </span></td>
			<td style="border:none;"><?php if (isset($items['0']->payment_mode)) echo $items['0']->payment_mode; ?></td>
			<td style="font-weight:bold; text-decoration:none; border:none;"> <span style="border-bottom:0px solid #666; padding-bottom:5px;">Deposit Amount:</span></td>
			<td colspan="2" style="border:none;"><?php if (isset($total_amount)) echo $total_amount; ?></td>
		</tr>
	 
		<tr>
			<td style="font-weight:bold; text-decoration:none; border:none;"> <span style="border-bottom:0px solid #666; padding-bottom:8px;"> Bank Name:</span></td>
			<td style="border:none;"><?php if (isset($b_name)) echo $b_name; ?></td>
			<td style="font-weight:bold; text-decoration:none; border:none;"> <span style="border-bottom:0px solid #666; padding-bottom:8px;">Bank Branch:</span></td>
			<td colspan="6" style="border:none;"><?php if (isset($b_branch)) echo $b_branch; ?></td>
		</tr> 
		<tr><td colspan="9" style="font-weight:bold; text-align:center;">Denomination</td></tr>
		<tr>
			<td style="font-weight:bold; text-align:center;">1000</td>
			<td style="font-weight:bold; text-align:center;">500</td>
			<td style="font-weight:bold; text-align:center;">100</td>
			<td style="font-weight:bold; text-align:center;">50</td>
			<td style="font-weight:bold; text-align:center;">20</td>
			<td style="font-weight:bold; text-align:center;">10</td>
			<td style="font-weight:bold; text-align:center;">5</td>
			<td style="font-weight:bold; text-align:center;">1</td>
			<td style="font-weight:bold; text-align:center;">Total</td>
		</tr>
		<tr>
			<td style="text-align:center;"><?php if (isset($denomination['0']->denomination_1000)) {if ($denomination['0']->denomination_1000>0) echo $denomination['0']->denomination_1000;} ?></td>
			<td style="text-align:center;"><?php if (isset($denomination['0']->denomination_500)) {if ($denomination['0']->denomination_500>0) echo $denomination['0']->denomination_500;} ?></td>
			<td style="text-align:center;"><?php if (isset($denomination['0']->denomination_100)) {if ($denomination['0']->denomination_100>0) echo $denomination['0']->denomination_100;} ?></td>
			<td style="text-align:center;"><?php if (isset($denomination['0']->denomination_50)) {if ($denomination['0']->denomination_50>0) echo $denomination['0']->denomination_50;} ?></td>
			<td style="text-align:center;"><?php if (isset($denomination['0']->denomination_20)) {if ($denomination['0']->denomination_20>0) echo $denomination['0']->denomination_20;} ?></td>
			<td style="text-align:center;"><?php if (isset($denomination['0']->denomination_10)) {if ($denomination['0']->denomination_10>0) echo $denomination['0']->denomination_10;} ?></td>
			<td style="text-align:center;"><?php if (isset($denomination['0']->denomination_5)) {if ($denomination['0']->denomination_5>0) echo $denomination['0']->denomination_5;} ?></td>
			<td style="text-align:center;"><?php if (isset($denomination['0']->denomination_1)) {if ($denomination['0']->denomination_1>0) echo $denomination['0']->denomination_1;} ?></td>
			<td style="text-align:center;"><?php echo intval((isset($denomination['0']->denomination_1000)?$denomination['0']->denomination_1000:0))+
						  intval((isset($denomination['0']->denomination_500)?$denomination['0']->denomination_500:0))+
						  intval((isset($denomination['0']->denomination_100)?$denomination['0']->denomination_100:0))+
						  intval((isset($denomination['0']->denomination_50)?$denomination['0']->denomination_50:0))+
						  intval((isset($denomination['0']->denomination_20)?$denomination['0']->denomination_20:0))+
						  intval((isset($denomination['0']->denomination_10)?$denomination['0']->denomination_10:0))+
						  intval((isset($denomination['0']->denomination_5)?$denomination['0']->denomination_5:0))+
						  intval((isset($denomination['0']->denomination_1)?$denomination['0']->denomination_1:0)); ?></td>
		</tr>
	</tbody>
</table>

<table>

	<tbody>
		<tr>
			<td>Distributor Name</td>
			<td>Invoice No</td>
			<td>Receipt Date</td>
			<td>Mode</td>
			<td>Instrument #</td>
			<td colspan="3">Bank Name</td>
			<td>Amount</td>
		</tr>
		<?php if(isset($distributor)) { for($i=0;$i<count($distributor);$i++) {?>
		<tr>
			<td><?php if(isset($distributor[$i]->distributor_name)) echo $distributor[$i]->distributor_name; ?></td>
			<td><?php if(isset($distributor[$i]->invoice_no)) echo $distributor[$i]->invoice_no; ?></td>
			<td><?php if (isset($date_of_deposit)) echo date('d/m/Y',strtotime($date_of_deposit)); ?></td>
			<td><?php if (isset($items['0']->payment_mode)) echo $items['0']->payment_mode; ?></td>
			<td><?php if(isset($distributor[$i]->ref_no)) echo $distributor[$i]->ref_no; ?></td>
			<td colspan="3"><?php if(isset($distributor[$i]->bank_name)) echo $distributor[$i]->bank_name; ?><?php if(isset($distributor[$i]->bank_city)) echo ' ' . $distributor[$i]->bank_city; ?></td>
			<td><?php if(isset($distributor[$i]->payment_amount)) echo $distributor[$i]->payment_amount; ?></td>
		</tr>
		<?php }} ?>
		<tr>
			<td colspan="7" style="border:none;">&nbsp;</td>
			<td style="border:none;">Total</td>
			<td><?php if (isset($total_amount)) echo $total_amount; ?></td>
		</tr>
	</tbody>
</table>
</div>

</body>
</html>
