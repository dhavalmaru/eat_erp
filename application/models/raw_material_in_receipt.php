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
                                
                                                    <?php echo $data[0]->po_no?>                     </p>
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
                              <br /> <?php if(isset($depot[0]->depot_name)) echo $depot[0]->depot_name; ?>
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
			<td colspan="6" style="text-align: center;">As per PO					</td></tr>
			<tr>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="15%">Qty</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="17%">Rate</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="17%">Amount</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="17%">CGST</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="17%">SGST</td>
			<td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="17%">Total</td>
			</tr>
			</tbody>
			</table>
			</td>
			<td width="300" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
			<table style="width: 100%;border-spacing: 0;height: 36px;">
			<tbody>
			<tr>
			<td colspan="6" width="500" style="text-align: center;">As per RIN</td></tr>
			<tr>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="15%">Qty</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="17%">Rate</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="17%">Amount</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="17%">CGST</td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="17%">SGST</td>
			<td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: 	center;" width="17%">Total</td>
			</tr>
			</tbody>
			</table>
			</td>
				
			
		</tr>	
		 <?php  $i=0; if(isset($raw_material_stock)) {for($i=0; $i<count($raw_material_stock); $i++){ ?>
		<tr>	

		<td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $i+1; ?></p></td>
		 <td valign="top" align="left" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666border:none;border-right:1px solid #666;"><p style="margin:0; ">  <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                <?php if($raw_material[$k]->id==$raw_material_stock[$i]->raw_material_id) { echo $raw_material[$k]->rm_name; } ?>
                                                        <?php }} ?></p></td>
		 <td valign="top" align="left" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $raw_material_stock[$i]->hsn_code; ?></p></td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr>
		  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="15%"><?php echo $raw_material_stock[$i]->po_quantity; ?></td>
		   <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->po_rate; ?></td></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->po_amount; ?></td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->po_cgst_amt; ?></td>
			 <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->po_sgst_amt; ?></td>
		  <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->po_total_amt; ?></td></tr></table>
		</td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr>
		  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="15%"><?php echo $raw_material_stock[$i]->qty; ?></td>
		   <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->rate; ?></td></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->amount; ?></td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->cgst_amt; ?></td>
			 <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->sgst_amt; ?></td>
		  <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[$i]->total_amt; ?></td></tr></table>
		</td>
      
            
        </tr>
		 
      	<tr>	

		<td valign="top" align="center" colspan="2" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666;border-right:1px solid #666;"><p style="margin:0; ">Other Charges</p></td>
	
		 <td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:1px solid #666;border-right:1px solid #666;"><p style="margin:0; "></p></td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr>
		  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="15%"></td>
		   <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
			 <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
		  <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo $raw_material_stock[0]->po_other_charges_amount; ?></td></tr></table>
		</td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="15%"></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
			  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
			    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
				  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php echo   $raw_material_stock[0]->other_charges_amt; ?></td></tr></table>
		</td>
      
            
        </tr>
		<?php } }?>
		  	<tr>	

		<td valign="top" align="center"  style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; ">Total</p></td>
	
		 <td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>
		  <td valign="top" align="center" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr>
		  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="15%"></td>
		   <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
			<td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
			 <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
		  <td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php if(isset($data)) { echo $data[0]->final_amount; } ?></td></tr></table>
		</td>
		<td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
		  <table style="width: 100%;border-spacing: 0; height: 36px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="15%"></td>
		    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
			  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
			    <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td>
				  <td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: center;" width="17%"><?php if(isset($data)) { echo $data[0]->final_amount; } ?></td></tr></table>
		</td>
      
            
        </tr>
            
            
       

	   </tr>
		
		
		
		    
        </tr>

		
      
        <tr>
              
           
			<td colspan="3" valign="top"><p style="margin:0;"><span style=" font-size:13px; font-weight:500;" >Remarks:</span> </p> </td>
           <td colspan="2" align="center" valign="top" style=" font-size:8px; font-weight:500;"> For Wholsome Habits Pvt Ltd <br/> <img src="<?php echo base_url().'/assets/invoice/'; ?>stamp.jpg" height="120"  alt="Sign3 Rishit" /> <br/>Authorised Signatory</td>
		</tr>
		
		
		
		
		
		
		
		
		
		
	

		
    </table>
</div>






		
		
		<?php } ?>	
		
		
		
		
		
		


</body>
</html>
