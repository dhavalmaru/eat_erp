<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 


  <style type="text/css">
  body {margin: 0; padding: 0; min-width: 100%!important;font-family 'Arial,Helvetica,sans-serif';}
  img {height: auto;}
  .content { max-width: 600px;}
  .header {padding:  20px;}
  .innerpadding {padding: 30px 30px 30px 30px;}
  .innerpadding1 {padding: 0px 30px 30px 30px;}
  
  .borderbottom {border-bottom: 1px solid #f2eeed;}
  .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
  .h1, .h2, .bodycopy {color: #fff; font-family: sans-serif;}
  .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
  .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
  .bodycopy {font-size: 16px; line-height: 22px;}
  .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
  .button a {color: #ffffff; text-decoration: none;}
  .footer {padding: 20px 30px 15px 30px;}
  .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
  .footercopy a {color: #ffffff; text-decoration: underline;}

  @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
  body[yahoo] .hide {display: none!important;}
  body[yahoo] .buttonwrapper {background-color: transparent!important;}
  body[yahoo] .button {padding: 0px!important;}
  body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
  body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
  }

  /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/
	table, th, td {
   
    border-collapse: collapse;
}
th, td {
      padding: 3px;
    text-align: left;
	
}
.total
	{
		color: #333333;
		font-size: 28px;
		font-family: Arial,Helvetica,sans-serif;
	}
	.used
	{
		color: #666666;
		font-size: 20px;
		font-family: Arial,Helvetica,sans-serif;
	}
	.team_head
	{
		font-size:36px;
		font-weight:normal;
		color:#fff;
		font-family: 'Arial,Helvetica,sans-serif';
	}
	.date
	{
		font-size:16px;
		color:#fff;
	}
	.upper_table td
	{
		border:1px solid #ddd;
		text-align:center;
		     padding: 10px;
		
	}
	.body_table tbody 
	{
		border:1px solid #ddd;
		background-color: #fdfbfb;
		color: #656d78;
	}
  </style>
</head>

<body yahoo bgcolor="#f6f8f1">
<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>
    <!--[if (gte mso 9)|(IE)]>
      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
    <![endif]-->     
    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td bgcolor="#0c2c4e" class="header"  colspan="20">
         
          <!--[if (gte mso 9)|(IE)]>
            <table width="425" align="left" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">  
            <tr>
              <td height="70">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr >
                    <td class="subhead" style="padding: 0 0 0 3px;width:30%">
                       <img class="fix" src="logo.png" width="100" height="100" border="0" alt="" />
					
                    </td>
               
                 
                    <td  style="width:70%;text-align:right">
						<span class="team_head">Team Activity report</span><br>
						<small class="date">25 Sep 2018</small>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
                </td>
              </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
      <tr>
        <td class="innerpadding ">
           <table class="table upper_table" style="width:765px">
          
           
            <tr>
                 <td align="center" valign="top" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase">ATTENDANCE</span> <br><br> <span class="total"><?php  echo $data2[0]->present_sales_rep;?></span><span class="used">/<?php echo $data1[0]->total_sales_rep;?></span></td>
				
              	       <td align="center" valign="top" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase">Visits</span> <br><br> <span class="total"><?php    echo $total_visits[2]->unplan; ?></span><span class="used">/<?php  echo $total_visits[1]->unplan; ?></span></td>
				  <td align="center" valign="top" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase">Unplanned Visits
</span>  <br><br> <span class="total"><?php  echo $total_visits[0]->unplan; ?></span></td>
				   <td align="center" valign="top" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase">Total Calls
</span>  <br><br> <span class="total">
<?php  $total_calls=$total_visits[0]->unplan + $total_visits[2]->unplan; ?>
<?php echo $total_calls;?></span></td>
  <td align="center" valign="top" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase">Total Order Units


</span>  <br><br> <span class="total"><?php if(isset($orders[0]->od_units)) echo $orders[0]->od_units; else echo "0" ;?></span></td>
  <td align="center" valign="top" ><span style="color:#333333;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;text-transform:Uppercase">Total Order Value


</span>  <br><br> <span class="total"><?php if(isset($orders[0]->od_value)) echo $orders[0]->od_value; else echo "0" ; ?></span></td>
    
            </tr>
           
            
          </table>
        </td>
	  </tr>
    
       <td class="innerpadding1 ">
           <table  class="body_table" style="width:100%">
			<thead>
				<tr style="    background-color: #f3f3f3 ;border-bottom: 1px solid #ddd;font-weight: bold;">
				  <th style="border-right: 1px solid #ddd;">Sr No</th>
				  <th style="border-right: 1px solid #ddd;">Name Of Employee</th>
				  <th style="border-right: 1px solid #ddd;">Beat Name</th>
				  <th style="border-right: 1px solid #ddd;">Deviation from Route Plan</th>
				  <th style="border-right: 1px solid #ddd;">Productive Calls</th>
				  <th style="border-right: 1px solid #ddd;">% Productivity</th>
			
				  
				  
				</tr>
			</thead>
			<tbody>
           <?php $i=0; if(isset($data)) {for($i=0; $i<count($data); $i++){ 
		      $deviation=(($data[$i]->planned_count)/($data[$i]->actual_count))*100;
				$single_total_calls=$data[$i]->planned_count + $data[$i]->unplanned_count;
				$productivity=($data[$i]->p_call/$single_total_calls)*100;
		   ?>
		
               <tr>
					<td><?php echo $i+1 ?></td>
					<td><?php  echo $data[$i]->sales_rep_name; ?></td>
					<td><?php  echo $data[$i]->frequency; ?></td>
					<td><?php  echo  round($deviation,2) ?>%</td>
					<td><?php if(isset($data[$i]->p_call)) echo $data[$i]->p_call; else echo "0" ;?></td>
				
				<td><?php  echo  $productivity; ?></td>
					
				</tr>
				
		   <?php }}?>
    
            
           </tbody>
          </table>
        </td>
	  </tr>
   
   
    </table>
    <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
    </td>
  </tr>
</table>

<!--analytics-->

</body>
</html>