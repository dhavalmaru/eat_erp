<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Test extends CI_Controller{

	public function testfun()
	{
		require_once(APPPATH.'third_party/pdf/html2pdf.class.php');
		try
	    {
	    	$content = '
					<html>
					<body>
					<p>Test567</p>
					</body>
					</html>';
	        ob_end_clean();
	        $html2pdf = new HTML2PDF('P', 'A6', 'en',true,'UTF-8', $marges = array(5, 5, 5, 8));
	        $html2pdf->writeHTML($content);
	        $html2pdf->Output("test.pdf");
	    }
	    catch(HTML2PDF_exception $e) {
	        echo $e;
	        exit;
	    }
  
	}

function multi_array_search($array, $search){
    $result = 0;
    foreach ($array as $key => $value)
    {
      foreach ($search as $k => $v)
      {

        if (!isset($value[$k]) || $value[$k] != $v)
        {
          continue 2;
        }

      }

      $result= $key;

    }
    return $result;
}


public function check_array($value=''){
	$list_of_phones = array(
		array("Manufacturer"=>"Apple","Model"=>"iPhone 3G 8GB"),
		array("Manufacturer"=>"Apple","Model"=>"iPhone 4G 8GB"),
		);

	$this->multi_array_search($list_of_phones, array('Manufacturer' => 'Apple1', 'Model' => 'iPhone 4G 8GB'));
}

public function check_days()
{
	

	$day = date('l', strtotime('2018-10-23'));
    $m = date('m',   strtotime('2018-10-23'));
    $year = date('Y', strtotime('2018-10-23'));
    echo $date1 = date('d-m-Y', strtotime('second '.$day.' of '.$m.' '.$year));
}

 public function get_alternate($day,$m,$year)
    {
        
        $date1 = date('d-m-Y', strtotime('second '.$day.' of '.$m.' '.$year));
        $date2 = date('d-m-Y', strtotime('fourth '.$day.' of '.$m.' '.$year));

        $todaysdate = date('d-m-Y');
        if($date1==$todaysdate) 
        {
            return true;
        }
        elseif($date2==$todaysdate)
        {
            return true;
        }
        else
        {
           return false;
        }
    }


    public function testdate()
    {
       
        $tendays = date('Y-m-d', strtotime("-10 days"));
        $twentydays  = date('Y-m-d', strtotime('-10 day', strtotime($tendays)));
        $thirtydays =date('Y-m-d', strtotime('-10 day', strtotime($twentydays)));
    }

    public function testtime($value='')
    {
        $this->load->library('session');
        $bool = 0;

        if($this->session->userdata('posttimer')=='')
        {
           $this->session->set_userdata('posttimer',time());
           $bool = 1;
        }
        else
        {
         if ((time() - $this->session->userdata('posttimer'))>5)
         {
            $this->session->set_userdata('posttimer',time());
            $bool = 1;
         }
         else
         {
            $bool = 0;
         }
        }

        if($bool==1)
        {
            echo 'entered true';
        }
        else
        {
            echo 'entered false';
        }
    }

    public function download_pdf(){
      $html = '
              <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
              <html xmlns="http://www.w3.org/1999/xhtml">
              <head>
                  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                  <title>Purchase Order</title>
                  <style>
                  @font-face {
                      font-family: "OpenSans-Regular";
                      src: url( OpenSans-Regular.ttf) format("truetype");
                  }
                  </style>
              </head>

              <body>
                  <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:925px; margin:auto; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:14px; font-weight:400; border:1px solid #666;"    >
                      <col width="43" />
                      <col width="115" />
                      <col width="110" />
                      <col width="112" />
                      <col width="83" />
                      <col width="92" />
                      <col width="95" />
                      <col width="64" />
                      <tr>
                          <td colspan="9" align="left" valign="top" style="padding:0;">
                              <table width="100%" border="0">
                                  <tr>
                                      <td width="40%"><img src="http://localhost/eat_erp_new_30//assets/invoice/logo.png" alt="" width="247" height="68" /></td>
                                      <td width="60%" style="color:#808080;"   ><h1 style="padding:0; margin:0; font-size:40px;">Purchase Order</h1></td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="9" valign="top" style="line-height:20px; padding:0;"> 
                              <table width="100%"  border="0" cellspacing="0" cellpadding="5"  style="border-collapse: collapse;">
                                  <tr style="border-bottom:1px solid #666;"  >
                                      <td width="40%" style="line-height:20px; border-bottom:1px solid #666; ">
                                          <p style="margin:0;">
                                              <span style=" font-size:15px; font-weight:500;" >Wholesome Habits Pvt Ltd</span><br />
                                              C/109, Hind Saurashtra Ind. Estate. 85/86, <br />
                                              Andheri Kurla Road, Marol Naka, <br />
                                              Andheri East. Mumbai 400059 <br /> 
                                              +91 8268000456 <br /> GSTIN: 27AABCW7811R1ZN <br /> 
                                              <a href="mailto:cs@eatanytime.in">cs@eatanytime.in</a> 
                                          </p>
                                      </td>
                                      <td width="30%" valign="top" style="line-height:20px;  border-right:1px solid #666; border-left:1px solid  ">
                                          <p style="margin:0;"> 
                                              <span style=" font-size:14px; font-weight:500;" > P.O. No.</span> <br /> 
                                              WHPL/18-19/5                            </p>
                                      </td>
                                      <td width="30%" valign="top" style="line-height:20px;">
                                          <p style="margin:0;">  
                                              <span style=" font-size:14px; font-weight:500;" >Dated </span><br /> 
                                              24-Sep-18                            </p>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td   valign="top" style="line-height:20px; height:100px; border-bottom:0; border-right:1px solid #666; word-wrap: break-word;">
                                          <p style="margin:0;"><span style="font-size:15px; font-weight:500;" > Vendor </span> <br />
                                              <span style=" font-size:14px; font-weight:500;" > BLISS LIFESCIENCES LLP  </span><br /> 
                                              15, MANGAL COMPOUND DEWAS NAKA, INDORE, Indore  Madhya Pradesh, India                            </p>
                                      </td>
                                      <td colspan="2" rowspan="2"   valign="top" style="line-height:18px; border-bottom:0px solid #666; border-right:1px solid #666;">
                                          <p style="margin:0;"> <span style="font-size:14px; font-weight:500;" >Ship To </span><br />
                                              <br />
                                              Primarc Warehouse<br />
                                              , Mumbai  Maharashtra, India                            </p>      
                                          <p style="margin:0;"> <span style="font-size:14px; font-weight:500;" > </span></p>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td  valign="top" style="border:none;" >
                                          <p style="margin:0;" ><span style=" font-size:15px; font-weight:500;" >GSTIN:</span> 
                                              23AAPFB8482L1ZV                            </p>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                      <tr style="font-size:14px; font-weight:500;  " >
                          <td colspan="9" align="center" valign="top">&nbsp;</td>
                      </tr>
                      <tr style="font-size:14px; font-weight:500; ">
                          <td colspan="9" align="center" valign="top"   style="margin:0; padding:0;">
                              <table width="100%" border="1" cellspacing="0" cellpadding="5"  style=" border-collapse:collapse;border:none;">
                                  <tr style="font-size:14px; font-weight:500;"  >
                                      <td align="center" style="    border-color:#666; border-top: none;    border-left: none;" > Shipping Method</td>
                                      <td align="center" style="    border-color:#666;  border-top: none;   border-left: none;"> Shipping Terms</td>
                                      <td align="center" style="    border-color: #666; border-top: none;    border-right: none;">Delivery Date</td>
                                  </tr>
                                  <tr style=" " >
                                      <td align="center" style="    border-color:#666;  border-bottom: none;    border-left: none;" ></td>
                                      <td align="center" style="    border-color:#666;   border-bottom: none;    border-left: none;"></td>
                                      <td align="center" style="    border-color: #666;   border-bottom: none;    border-right: none;"></td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                      <tr style="font-size:14px; font-weight:500;">
                          <td colspan="9" align="center" valign="top">&nbsp; </td>
                      </tr>
                      <tr style="font-size:14px; font-weight:500;">
                          <td width="60" align="center" valign="top">Sr. No.</td>
                          <td width="278" align="center" valign="top">Item</td>
                          <td width="130" align="center" valign="top">Quantity</td>
                          <td width="116" align="center" valign="top">Rate</td>
                          <td width="132" align="center" valign="top">Amount </td>
                          <td width="113" align="center" valign="top">CGST</td>
                          <td width="113" align="center" valign="top">SGST</td>
                          <td width="113" align="center" valign="top">IGST</td>
                          <td width="132" align="center" valign="top">Total Amount </td>
                      </tr>
                              <tr valign="top" style="border: none;">
                          <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">1</td>
                          <td valign="top" align="left" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">
              <div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">
                

              </div>Peppermint Flavour</td>
                          <td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">234</p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">12</p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">2,808</p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">0</p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">0</p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">0</p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">2,808</p></td>
                      </tr>
                             
                      <tr valign="top" style="border: none;">
                          <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
                          <td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
                          <td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
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
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
                          <td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:1px solid #666;"><p style="margin:0; ">  </p></td>
                      </tr>
                              <tr>
                          <!-- <td colspan="3" valign="top" style="padding:0;">&nbsp;</td> -->
                          <td colspan="8" valign="top" style="font-size:14px; font-weight:500;"> TOTAL</td>
                          <td style=" font-size:14px; font-weight:500;"   >  <span style="text-align:left; float:left"> &#8377; </span> <span style="text-align:right; float:right">2,808</span> </td>
                      </tr>
                      <tr>
                          <td colspan="9" valign="top" style="font-size:14px; font-weight:500;"> Remarks: </td>
                      </tr>
                      <tr>
                          <td colspan="6" valign="middle" style="padding:0;">
                              <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                  <tr>
                                      <td width="7%" align="center" valign="top"><p style="margin:0;">1.</p></td>
                                      <td width="93%" valign="top"><strong><span style="font-size:14px; font-weight:500;" >Please send two copies of your invoice </span></strong></td>
                                  </tr>
                                  <tr>
                                      <td align="center" valign="top"><p style="margin:0;">2.</p></td>
                                      <td valign="top"><strong><span style="font-size:14px; font-weight:500;" >Enter this order in accordance with the price, terms, delivery method, and specifications listed above.</span></strong></td>
                                  </tr>
                                  <tr>
                                      <td align="center" valign="top"><p style="margin:0;">3.</p></td>
                                      <td valign="top"><strong><span style=" font-size:14px; font-weight:500;" >Please notify us immediately if you are unable to ship as specified.</span></strong></td>
                                  </tr>
                                  <tr>
                                      <td align="center" valign="top"><p style="margin:0;">4.</p></td>
                                      <td valign="top">
                                          <p style="font-size:14px; font-weight:500; margin:0;">
                                              <span style="margin:0;">Wholesome Habits Pvt Ltd<br />B-505, Veena sur, Mahavir<br />
                                              NagarKandivali-West,<br />
                                              Mumbai - 67 <br />
                                              +91 8268000456 
                                              </span>
                                          </p>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                          <td colspan="3" align="center" valign="middle" style=" font-size:14px; font-weight:500;"> For Wholsome Habits Pvt Ltd <br/> 
                              <img src="http://localhost/eat_erp_new_30//assets/invoice/stamp.jpg" height="95"  alt="Sign3 Rishit" /> <br/>Authorised Signatory
                          </td>
                      </tr>
                  </table>
                 
                <table class="user_data" border="0" width="100%" style="border-collapse:collapse;margin-top:20px;font-size:12px " class="table" cellspacing="10">
                        <tr valign="center" >
                          <td width="100%" align="center"><b>Created By:</b>
                           &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                            <span style="">
                           <b> Modified By:</b>
                              &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp </span>
                            <b> Approved By:</b>
                                          
                            
                          </td>
                            
                        </tr>
                        <tr valign="center" >
                            <td width="100%" align="center"><b>Created On:</b>
                              &nbsp &nbsp &nbsp &nbsp
                          <span style="">
                            <b> Modified On:</b>
                               &nbsp &nbsp &nbsp &nbsp </span>
                             <b> Approved On:</b>
                                          </td>
                        </tr>
                        
                        
                </table>
              </body>
              </html>';
      $pdfFilePath = "output_pdf_name.pdf";
      $this->load->library('m_pdf');
      $this->m_pdf->pdf->WriteHTML($html);
      $this->m_pdf->pdf->Output($pdfFilePath, "D");   
    }

    public function testdate1()
    {
      echo $this->getWeeks("2018-11-24", "Saturday");
    }


    function getWeeks($date, $rollover)
    {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $weeks = 1;

        for ($i = 1; $i <= $elapsed; $i++)
        {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));

            if($day == strtolower($rollover))  $weeks ++;
        }

        return $weeks;
    }

    function sendMail()
    {
      

      $config = Array(
      'protocol'  => 'smtp',
      'smtp_host' => 'smtp.gmail.com',
      'smtp_port' => '465',
      'smtp_user' => 'verve.php@gmail.com',
      'smtp_pass' => 'Re@ltime007',
      'mailtype'  => 'html',
      'starttls'  => true,
      'newline'   => "\r\n"
      );


      $message = 'Test Mail';
      $this->load->library('email', $config);

      $this->email->initialize();
      $this->email->set_newline("\r\n");
      $this->email->from('yadavsangeeta521@gmail.com'); // change it to yours
      $this->email->to('ashwini.patil@peacanreams.com');// change it to yours
      $this->email->subject('Test');
      $this->email->message($message);
      if($this->email->send())
       {
        echo 'Email sent.';
       }
       else
      {
       show_error($this->email->print_debugger());
      }

    }
}
?>