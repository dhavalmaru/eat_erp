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
.user_data tr, .user_data td
		{
			border:none!important;
			padding:5px!important;
		}
</style>
</head>

<body>
<?php if(count($data)>0) {


	?>
<div>
    <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:1250px; margin: 0 auto; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:12px; font-weight:400; border:1px solid #666; "    >
        <tr>
            <td colspan="5" align="center" valign="top" style="padding:0;">
            <table width="100%" border="0" cellspacing="0">
                <tr>
                    <td style="text-align:center;" width="30%"><img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" alt="" width=" " height="50" /></td>
                    <td width="70%" style="color:#808080; text-align:center;">
                        <h1 style="padding:0; margin:0; font-size:22px;"> Raw Material In Note </h1>
                    </td>
                </tr>
            </table>
            </td>
        </tr>
      
		
		  <tr>
            <td colspan="5" valign="top" style="line-height:20px; padding:0;"> 
                <table width="100%"  border="0" cellspacing="0" cellpadding="5"  style="border-collapse: collapse;">
                    <tr style=""  >
                        <td width="40%" rowspan="2" style="line-height:20px; border-bottom:1px solid #666; ">
                            <p style="margin:0;">
                                <span style=" font-size:15px; font-weight:700;" >Wholesome Habits Pvt Ltd</span><br />
                                C/109, Hind Saurashtra Ind. Estate. 85/86, <br />
                                Andheri Kurla Road, Marol Naka, <br />
                                Andheri East. Mumbai 400059 <br /> 
                                +91 8268000456 <br /> GSTIN: 27AABCW7811R1ZN <br /> 
                                <a href="mailto:cs@eatanytime.in">cs@eatanytime.in</a> 
                            </p>
                        </td>
                        <td width="30%" valign="top" style="line-height:20px;  border-right:1px solid #666; border-left:1px solid  ">
                            <p style="margin:0;"> 
                                <span style=" font-size:14px; font-weight:700;" > RIN no</span> <br /> 
                                <?php if(isset($data[0]->row_material_in_no)) echo $data[0]->row_material_in_no; ?> </p>
                        </td>
                        <td width="30%" valign="top" style="line-height:20px;">
                            <p style="margin:0;">  
                                <span style=" font-size:14px; font-weight:700;" >Dated </span><br /> 
                           <?php if(isset($data[0]->approved_on)) echo date('d-F-Y',strtotime($data[0]->approved_on)); ?>                    
							   </p>
                        </td>
					</tr>
					<tr  style="line-height:20px; border-bottom:1px solid #666; ">
						   <td width="30%" valign="top" style="line-height:20px;  border-right:1px solid #666; border-left:1px solid  ">
                            <p style="margin:0;"> 
                                <span style=" font-size:14px; font-weight:700;" > P.O. No.</span> <br /> 
                                
                                                    <?php echo $data[0]->po_no; ?>                     </p>
                        </td>
                        <td width="30%" valign="top" style="line-height:20px;">
                            <p style="margin:0;">  
                                <span style=" font-size:14px; font-weight:700;" >Dated </span><br /> 
                                  <?php if(isset($data[0]->raw_approved)) echo date('d-F-Y',strtotime($data[0]->raw_approved)); ?>             </p>
                        </td>
					</tr>
                    <tr>
                        <td   valign="top" style="line-height:20px; height:100px; border-bottom:0; border-right:1px solid #666; word-wrap: break-word;">
                            <p style="margin:0;"><span style="font-size:15px; font-weight:700;" > Vendor </span> <br />
                               
									<?php if(isset($data[0]->vendor_name)) echo $data[0]->vendor_name; ?>
									<br /><?php if(isset($vendor[0]->address)) echo $vendor[0]->address; ?><br />
									GSTIN:<?php if(isset($vendor[0]->gst_number)) echo $vendor[0]->gst_number; ?>                        </p>
                        </td>
                        <td colspan="2" rowspan="2"   valign="top" style="line-height:18px; border-bottom:0px solid #666; border-right:1px solid #666;">
                            <p style="margin:0;"> <span style="font-size:14px; font-weight:700;" >Ship To </span>
                           <br /> <?php //echo "<pre>";
								// print_r($depot[0]);
								// echo "<pre>";
								
								//die();
							  
							  if(isset($depot[0]->depot_name)) echo $depot[0]->depot_name; ?>
								</br> <?php if(isset($depot[0]->address)){
											 $address = get_address($depot[0]->address, "", $depot[0]->city, $depot[0]->pincode, $depot[0]->state, $depot[0]->country);
											 echo $address; 
									} ?>

                        </td>
                    </tr>
                   <!-- <tr>
                        <td  valign="top" style="border:none;" >
                            <p style="margin:0;" ><span style=" font-size:15px; font-weight:500;" >GSTIN:</span> 
                                27ACFFS8544N1ZD                            </p>
                        </td>
                    </tr>-->
                </table>
            </td>
        </tr>
		
		
        <tr style="font-size:12px; font-weight:700; ">
            <td width="40" align="center" valign="top"> Sr. No. </td>
            <td width="252" align="center" valign="top"> Item </td>
            <td width="80" align="center" valign="top"> HSN Code </td>

			<td width="300" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
			<table style="width: 100%;border-spacing: 0;height: 36px;">
			<tbody>
			<tr>
			<td colspan="7" style="text-align: center;">As per PO					</td></tr>
			<tr>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="14%">Qty</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="14%">Rate</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="14%">Amount</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="14%">CGST</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="14%">SGST</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="14%">IGST</td>
			<td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="16%">Total</td>
			</tr>
			</tbody>
			</table>
			</td>
			<td width="300" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
			<table style="width: 100%;border-spacing: 0;height: 36px;">
			<tbody>
			<tr>
			<td colspan="7" width="500" style="text-align: center;">As per RIN</td></tr>
			<tr>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="14%">Qty</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="14%">Rate</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="14%">Amount</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="14%">CGST</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="14%">SGST</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="14%">IGST</td>
			<td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="16%">Total</td>
			</tr>
			</tbody>
			</table>
			</td>
				
			
		</tr>	
		 <?php  $i=0; $po_final_amt = 0 ; if(isset($raw_material_stock)) {for($i=0; $i<count($raw_material_stock); $i++){ 
		 	$po_final_amt = $po_final_amt+$raw_material_stock[$i]->po_total_amt;
		 ?>
		<tr>	

		<td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $i+1; ?></p></td>
		 <td valign="top" align="left" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666border:none;border-right:1px solid #666;"><p style="margin:0; ">  <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                <?php if($raw_material[$k]->id==$raw_material_stock[$i]->raw_material_id) { echo $raw_material[$k]->rm_name; } ?>
                                                        <?php }} ?></p></td>
		 <td valign="top" align="left" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo ($raw_material_stock[$i]->hsn_code==0?'':$raw_material_stock[$i]->hsn_code); ?></p></td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr>
		  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"><?php echo format_money($raw_material_stock[$i]->po_quantity,2); ?></td>
		   <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"><?php echo format_money($raw_material_stock[$i]->po_rate,2); ?></td></td>
		    <td class="po_amount" style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"><?php echo format_money ($raw_material_stock[$i]->po_amount,2); ?></td>
			<td class="po_cgst_amt" id="po_cgst_amount"  style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"><?php echo format_money($raw_material_stock[$i]->po_cgst_amt,2); ?></td>
			 <td class="po_sgst_amt"  id="po_sgst_amount"  style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"><?php echo format_money($raw_material_stock[$i]->po_sgst_amt,2); ?></td>
			  <td class="po_igst_amt" id="po_igst_amount" style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"><?php echo format_money($raw_material_stock[$i]->po_igst_amt,2); ?></td>
		  <td class="po_total_amt" id="po_total_amount"  style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="16%"><?php echo format_money($raw_material_stock[$i]->po_total_amt,2); ?></td></tr></table>
		</td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr>
		  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center; <?php if($raw_material_stock[$i]->po_quantity!=$raw_material_stock[$i]->qty) echo 'color: #F44336';?>" width="14%"><?php echo format_money($raw_material_stock[$i]->qty,2); ?></td>
		   <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center; <?php if($raw_material_stock[$i]->po_rate!=$raw_material_stock[$i]->rate) echo 'color: #F44336';?>" width="14%"><?php echo format_money($raw_material_stock[$i]->rate,2); ?></td></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center; <?php if($raw_material_stock[$i]->po_amount!=$raw_material_stock[$i]->amount) echo 'color: #F44336';?>" width="14%"><?php echo format_money($raw_material_stock[$i]->amount,2); ?></td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center; <?php if($raw_material_stock[$i]->po_cgst_amt!=$raw_material_stock[$i]->cgst_amt) echo 'color: #F44336';?>" width="14%"><?php echo format_money($raw_material_stock[$i]->cgst_amt,2); ?></td>
			 <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center; <?php if($raw_material_stock[$i]->po_sgst_amt!=$raw_material_stock[$i]->sgst_amt) echo 'color: #F44336';?>" width="14%"><?php echo format_money($raw_material_stock[$i]->sgst_amt,2); ?></td>
			  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center; <?php if($raw_material_stock[$i]->po_igst_amt!=$raw_material_stock[$i]->igst_amt) echo 'color: #F44336';?>" width="14%"><?php echo format_money($raw_material_stock[$i]->igst_amt,2); ?></td>
		  <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center; <?php if($raw_material_stock[$i]->po_total_amt!=$raw_material_stock[$i]->total_amt) echo 'color: #F44336';?>" width="16%"><?php echo format_money($raw_material_stock[$i]->total_amt,2); ?></td></tr></table>
		</td>
      
            
        </tr>
		 
      	
		<?php } }?>
		<tr>	

		<td valign="top" align="center" colspan="2" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666;border-right:1px solid #666;"><p style="margin:0; ">Other Charges</p></td>
	
		 <td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666;border-right:1px solid #666;"><p style="margin:0; "></p></td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr>
		  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
		   <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			 <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
		  <td class="po_other_charges_amount"  id="po_other_charges_amount" style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="16%"><?php echo format_money($raw_material_stock[0]->po_other_charges_amount,2); ?></td></tr></table>
		</td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="14%"></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
				  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
				   <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
				  <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center; <?php if($raw_material_stock[0]->po_other_charges_amount!=$raw_material_stock[0]->other_charges_amt) echo 'color: #F44336';?>" width="16%"><?php echo  format_money( $raw_material_stock[0]->other_charges_amt,2); ?></td></tr></table>
		</td>
      
            
        </tr>

        <?php if(isset($raw_material_stock[0]->po_other_charges_amount) && $raw_material_stock[0]->po_other_charges_amount!='') $po_final_amt = $po_final_amt+$raw_material_stock[0]->po_other_charges_amount; ?>
		<tr>	

		<td valign="top" align="center"  style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; ">Total</p></td>
	
		 <td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>
		  <td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr>
		  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
		   <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			 <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
		  <td class="po_final_amt" id="po_final_amount" style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="16%"> <?php echo format_money($po_final_amt,2);?></td></tr></table>
		</td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="14%"></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
			    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
				  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
				    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="14%"></td>
				  <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center; <?php if($po_final_amt!=$data[0]->final_amount) echo 'color: #F44336';?>" width="16%"><?php if(isset($data)) { echo format_money($data[0]->final_amount,2); } ?></td></tr></table>
		</td>
      
            
        </tr>
            
            
       

	   </tr>
		
		
		
		    
        </tr>

		
      
        <tr>
              
           
			<td colspan="3" valign="top"><p style="margin:0;"><span style=" font-size:13px; font-weight:500;" >Remarks: <?php echo $data[0]->remarks; ?></span> </p> </td>
           <td colspan="2" align="center" valign="top" style=" font-size:8px; font-weight:500;"> For Wholsome Habits Pvt Ltd <br/> <img src="<?php echo base_url().'/assets/invoice/'; ?>stamp.jpg" height="120"  alt="Sign3 Rishit" /> <br/>Authorised Signatory</td>
		</tr>
		
		
		
		
		
		
		
		
		
		
	

		
    </table>
	
	 <table class="user_data" border="0" width="100%" style="border-collapse:collapse;margin-top:20px;font-size:12px " class="table" cellspacing="10">
					<tr valign="center" >
						  <td width="100%" align="center"><b>Created By:</b>
						 <?php if(isset($data[0]->createdby)) echo $data[0]->createdby; ?>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
						  <span style="<?php if(isset($data[0]->created_on)) 
						if($data[0]->created_on <> $data[0]->modified_on)
						echo ' '; else echo 'display:none;';?>">
						 <b> Modified By:</b>
						  <?php if(isset($data[0]->modifiedby)) echo $data[0]->modifiedby; ?>  &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </span>
						  <b> Approved By:</b>
						  <?php if(isset($data[0]->approvedby)) echo $data[0]->approvedby; ?></td>
						  
					</tr>
					<tr valign="center" >
					      <td width="100%" align="center"><b>Created On:</b>
						    <?php if(isset($data[0]->created_on)) echo date("d-m-Y h:m:i", strtotime($data[0]->created_on)) ?>&nbsp &nbsp &nbsp &nbsp
							<span style="<?php if(isset($data[0]->created_on)) 
						if($data[0]->created_on <> $data[0]->modified_on)
						echo ' ';else echo 'display:none;';?>">
						  <b> Modified On:</b>
						     <?php if(isset($data[0]->modified_on)) echo date("d-m-Y h:m:i", strtotime($data[0]->modified_on)) ?>&nbsp &nbsp &nbsp &nbsp </span>
						   <b> Approved On:</b>
						    <?php if(isset($data[0]->approved_on))echo  date("d-m-Y h:m:i", strtotime($data[0]->approved_on)) ?>
							</td>
					</tr>
					
					
	</table>
	
</div>






		
		
		<?php } ?>	
		
		<script>
			/*$(document).ready(function(){ 
				get_po_total();
			});
		   function get_po_total(){
                var total_amt = 0;
                $('.po_amount').each(function(){
                    amount = parseFloat(get_number($(this).text(),2));
                    if (isNaN(amount)) amount=0;
                    total_amt = total_amt + amount;
                });
                
                
                 var cgst_amount = 0;
                 $('.po_cgst_amt').each(function(){
                    cgst_amt = parseFloat(get_number($(this).text(),2));
                    if (isNaN(cgst_amt)) cgst_amt=0;
                    cgst_amount = cgst_amount + cgst_amt;
                });
                
                 var sgst_amount = 0;
                 $('.po_sgst_amt').each(function(){
                    sgst_amt = parseFloat(get_number($(this).text(),2));
                    if (isNaN(sgst_amt)) sgst_amt=0;
                    sgst_amount = sgst_amount + sgst_amt;
                });

                 var igst_amount = 0;
                 $('.po_igst_amt').each(function(){
                    igst_amt = parseFloat(get_number($(this).text(),2));
                    if (isNaN(igst_amt)) igst_amt=0;
                    igst_amount = igst_amount + igst_amt;
                });
                
                var tax_amt=0;
                $('.po_tax_amt').each(function(){
                    taxamt = parseFloat(get_number($(this).text(),2));
                    if (isNaN(taxamt)) taxamt=0;
                    tax_amt = tax_amt + taxamt;
                });

                var final_amt=0;
                $('.po_final_amt').each(function(){
                    finalamt = parseFloat(get_number($(this).text(),2));
                    if (isNaN(finalamt)) finalamt=0;
                    final_amt = final_amt + finalamt;
                });
                $("#po_final_amt").text(final_amt.toFixed(2));
                final_amount = total_amt + cgst_amount + sgst_amount + igst_amount;

                var po_other_charges_amount = 0;
                if($('#po_other_charges_amount').text()!='')
                {
                    po_other_charges_amount = parseFloat(get_number($('#po_other_charges_amount').text(),2));
                }

                final_amount = po_other_charges_amount+final_amount;

                $("#po_final_amount").text(format_money(Math.round(final_amount*100)/100,2));
                $("#po_total_amount").text(format_money(Math.round(total_amt*100)/100,2));
                $("#po_cgst_amount").text(format_money(Math.round(cgst_amount*100)/100,2));
                $("#po_sgst_amount").text(format_money(Math.round(sgst_amount*100)/100,2));
                $("#po_igst_amount").text(format_money(Math.round(igst_amount*100)/100,2));
            }*/
		
		</script>


</body>
</html>
