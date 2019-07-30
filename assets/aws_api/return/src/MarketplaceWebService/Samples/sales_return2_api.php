<?php
/** 
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     MarketplaceWebService
 *  @copyright   Copyright 2009 Amazon Technologies, Inc.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2009-01-01
 */
/******************************************************************************* 

 *  Marketplace Web Service PHP5 Library
 *  Generated: Thu May 07 13:07:36 PDT 2009
 * 
 */

/**
 * Report  Sample
 */

include_once ('.config.inc.php'); 

/************************************************************************
* Uncomment to configure the client instance. Configuration settings
* are:
*
* - MWS endpoint URL
* - Proxy host and port.
* - MaxErrorRetry.
***********************************************************************/
// IMPORTANT: Uncomment the approiate line for the country you wish to
// sell in:
// United States:
//$serviceUrl = "https://mws.amazonservices.com";
// United Kingdom
//$serviceUrl = "https://mws.amazonservices.co.uk";
// Germany
//$serviceUrl = "https://mws.amazonservices.de";
// France
//$serviceUrl = "https://mws.amazonservices.fr";
// Italy
//$serviceUrl = "https://mws.amazonservices.it";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn";
// Canada
//$serviceUrl = "https://mws.amazonservices.ca";
// India
$serviceUrl = "https://mws.amazonservices.in";

$config = array (
  'ServiceURL' => $serviceUrl,
  'ProxyHost' => null,
  'ProxyPort' => -1,
  'MaxErrorRetry' => 3,
);

/************************************************************************
 * Instantiate Implementation of MarketplaceWebService
 * 
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
 * are defined in the .config.inc.php located in the same 
 * directory as this sample
 ***********************************************************************/
 $service = new MarketplaceWebService_Client(
     AWS_ACCESS_KEY_ID, 
     AWS_SECRET_ACCESS_KEY, 
     $config,
     APPLICATION_NAME,
     APPLICATION_VERSION);
 
/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebService
 * responses without calling MarketplaceWebService service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebService/Mock tree
 *
 ***********************************************************************/
 // $service = new MarketplaceWebService_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out 
 * sample for Report Action
 ***********************************************************************/
// Constructing the MarketplaceId array which will be passed in as the the MarketplaceIdList 
// parameter to the RequestReportRequest object.
$marketplaceIdArray = array("Id" => array('A21TJRUUN4KGV'));

 // @TODO: set request. Action can be passed as MarketplaceWebService_Model_ReportRequest
 // object or array of parameters
 
// $parameters = array (
//   'Merchant' => MERCHANT_ID,
//   'MarketplaceIdList' => $marketplaceIdArray,
//   'ReportType' => '_GET_MERCHANT_LISTINGS_DATA_',
//   'ReportOptions' => 'ShowSalesChannel=true',
//   'MWSAuthToken' => '<MWS Auth Token>', // Optional
// );

$request2 = new MarketplaceWebService_Model_GetReportListRequest();
$request2->setMerchant(MERCHANT_ID);
$request2->setAvailableToDate(new DateTime('now', new DateTimeZone('UTC')));
$request2->setAvailableFromDate(new DateTime('-3 months', new DateTimeZone('UTC')));
$request2->setAcknowledged(false);
$request2->setMWSAuthToken('529421203372');
  
$ReportId = 0;
invokeGetReportList($service, $request2);

sleep(10);

$request3 = new MarketplaceWebService_Model_GetReportRequest();
$request3->setMerchant(MERCHANT_ID);
$request3->setReport(@fopen('php://memory', 'rw+'));
$request3->setReportId($ReportId);
$request3->setMWSAuthToken('529421203372'); // Optional

invokeGetReport($service, $request3);

  function invokeGetReportList(MarketplaceWebService_Interface $service, $request) 
  {
      try {
              $response = $service->getReportList($request);
              // global $ReportRequestId;

              // echo $ReportRequestId.'<br/><br/>';
              
                if ($response->isSetGetReportListResult()) { 
                    $getReportListResult = $response->getGetReportListResult();
                    $reportInfoList = $getReportListResult->getReportInfoList();

                    // echo json_encode($reportInfoList);
                    // echo '<br/><br/>';

                    foreach ($reportInfoList as $reportInfo) {
                        $report_type = $reportInfo->getReportType();
                        $report_request_id = $reportInfo->getReportRequestId();

                        echo $report_type;
                        echo '<br/><br/>';
                        echo $report_request_id;
                        echo '<br/><br/>';

                        // if($report_type=='_GET_FBA_FULFILLMENT_CUSTOMER_RETURNS_DATA_' && $report_request_id==$ReportRequestId) {
                        if($report_type=='_GET_FBA_FULFILLMENT_CUSTOMER_RETURNS_DATA_') {
                            if ($reportInfo->isSetReportId()) {
                                echo("                    ReportId\n");
                                echo("                        " . $reportInfo->getReportId() . "\n");

                                global $ReportId;
                                $ReportId = $reportInfo->getReportId();

                                echo '<br/><br/>';

                                break;
                            }
                        }
                    }
                }
     } catch (MarketplaceWebService_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
         echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
     }
  }

  function invokeGetReport(MarketplaceWebService_Interface $service, $request) 
  {
      try {
              $response = $service->getReport($request);

              date_default_timezone_set('Asia/Kolkata');

              $now=date('Y-m-d H:i:s');
              $curdate=date('Y-m-d');
              $curusr='148';

              // echo $now;
              // echo '<br/><br/>';
              // echo $curdate;
              // echo '<br/><br/>';

              $result = stream_get_contents($request->getReport());

              $x=explode("\n",$result);
              $arr = array();

              foreach($x as $line){
                // echo $line;
                // echo '<br/><br/>';

                $arr[]=explode("\t",$line);
              }

              echo json_encode($arr);
              echo '<br/><br/>';

              $order_data = array();

              for($i=1; $i<count($arr); $i++) {
                  $return_date = $arr[$i][0];
                  $order_no = $arr[$i][1];
                  $asin = $arr[$i][3];
                  $qty = intval(trim($arr[$i][6]));

                  $index = '';
                  for($j=0; $j<count($order_data); $j++) {
                      if($order_data[$j]['order_no']==$order_no) {
                          $index = $j;
                          break;
                      }
                  }
                  if($index===''){
                      $index = count($order_data);
                      $order_data[$index]['order_no']=$order_no;
                      $order_data[$index]['return_date']=$return_date;
                      $order_data[$index]['sku_data']=array();
                  }

                  $sku_data = $order_data[$index]['sku_data'];
                  $index2 = '';
                  for($k=0; $k<count($sku_data); $k++) {
                      if($sku_data[$k]['asin']==$asin) {
                          $index2 = $k;
                          break;
                      }
                  }
                  if($index2===''){
                      $index2 = count($sku_data);
                      $sku_data[$index2]['asin']=$asin;
                      $sku_data[$index2]['qty']=$qty;
                  } else {
                      $sku_data[$index2]['qty'] = $sku_data[$index2]['qty'] + $qty;
                  }

                  $order_data[$index]['sku_data'] = $sku_data;
              }

              // echo json_encode($order_data);
              // echo '<br/><br/>';
              // echo json_encode($sku_data);

              $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }

              for($i=0; $i<count($order_data); $i++) {
                  $order_no = $order_data[$i]['order_no'];

                  $sql = "select * from distributor_in where order_no='".$order_no."' or remarks like '%".$order_no."%'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                    if(count($row_arr)>0) {
                      $result->free();
                      echo 'order_no '.$order_no.' already exist.<br/><br/>';
                      continue;
                    }
                  }

                  $return_date = $order_data[$i]['return_date'];
                  $date = new DateTime($return_date, new DateTimeZone('UTC'));
                  $return_date = $date->format('Y-m-d');

                  $sku_data = $order_data[$i]['sku_data'];

                  $discount = 0;
                  $distributor_out_id = 0;
                  $invoice_no = '';
                  $tax_type = 'Intra';
                  $sql = "select * from distributor_out where order_no='".$order_no."'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                    if(count($row_arr)>0) {
                      if(isset($row_arr[0]['discount'])) {
                        $discount = $row_arr[0]['discount'];
                      }
                      if(isset($row_arr[0]['id'])) {
                        $distributor_out_id = $row_arr[0]['id'];
                      }
                      if(isset($row_arr[0]['invoice_no'])) {
                        $invoice_no = $row_arr[0]['invoice_no'];
                      }
                      if(isset($row_arr[0]['state'])) {
                        if(strtoupper(trim($row_arr[0]['state']))!='MAHARASHTRA'){
                          $tax_type = 'Inter';
                        }
                      }
                    }
                  }

                  $tot_amount = 0;
                  $tot_cgst_amount = 0;
                  $tot_sgst_amount = 0;
                  $tot_igst_amount = 0;
                  $tot_tax_amount = 0;
                  $tot_order_amount = 0;
                  $final_cost_amount = 0;

                  $item_data = array();

                  echo print_r($sku_data);
                  echo '<br/><br/>';

                  echo count($sku_data);
                  echo '<br/><br/>';

                  echo $sku_data[0]['asin'];
                  echo '<br/><br/>';

                  for($k=0; $k<count($sku_data); $k++) {
                    $asin = $sku_data[$k]['asin'];
                    $qty = $sku_data[$k]['qty'];

                    $item_id = 0;
                    $item_grams = 0;
                    $rate = 0;
                    $cost = 0;
                    $tax_per = 0;

                    $sql = "select * from box_master where asin ='".$asin."'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                      $row_arr = $result->fetch_all(MYSQLI_ASSOC);

                      if(count($row_arr)>0) {
                        if(isset($row_arr[0]['id'])) {
                          $item_id = $row_arr[0]['id'];
                        }
                        if(isset($row_arr[0]['grams'])) {
                          $item_grams = $row_arr[0]['grams'];
                        }
                        if(isset($row_arr[0]['rate'])) {
                          $rate = $row_arr[0]['rate'];
                        }
                        if(isset($row_arr[0]['cost'])) {
                          $cost = $row_arr[0]['cost'];
                        }
                        if(isset($row_arr[0]['tax_percentage'])) {
                          $tax_per = $row_arr[0]['tax_percentage'];
                        }
                      }
                      $result->free();
                    }

                    $batch_no = 0;
                    $sql = "select * from distributor_out_items where distributor_out_id ='".$distributor_out_id."' and 
                            type='Box' and item_id = '".$item_id."'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                      $row_arr = $result->fetch_all(MYSQLI_ASSOC);

                      if(count($row_arr)>0) {
                        if(isset($row_arr[0]['batch_no'])) {
                          $batch_no = $row_arr[0]['batch_no'];
                        }
                      }
                    }

                    $sell_rate = $rate - (($rate*$discount)/100);
                    if($tax_per!=0){
                      $sell_rate = $sell_rate/(100+$tax_per)*100;
                    }
                    
                    if($tax_type=='Intra'){
                      $cgst=$tax_per/2;
                      $sgst=$tax_per/2;
                      $igst=0;
                    } else {
                      $cgst=0;
                      $sgst=0;
                      $igst=$tax_per;
                    }
                    
                    $cgst_amt = round($qty*(($sell_rate*$cgst)/100),2);
                    $sgst_amt = round($qty*(($sell_rate*$sgst)/100),2);
                    $igst_amt = round($qty*(($sell_rate*$igst)/100),2);
                    // $tax_amt = round($qty*(($sell_rate*$tax_per)/100),2);
                    $tax_amt = $cgst_amt+$sgst_amt+$igst_amt;
                    
                    $amount = round(($qty*$sell_rate),2);
                    $total_amt = round((round($amount,2) + round($tax_amt,2)),2);
                    $cost_amount = round(($qty*$cost),2);

                    $tot_amount = $tot_amount + $amount;
                    $tot_tax_amount = $tot_tax_amount + $tax_amt;
                    $tot_order_amount = $tot_order_amount + $total_amt;

                    $final_cost_amount = $final_cost_amount + $cost_amount;

                    $tot_cgst_amount = $tot_cgst_amount + $cgst_amt;
                    $tot_sgst_amount = $tot_sgst_amount + $sgst_amt;
                    $tot_igst_amount = $tot_igst_amount + $igst_amt;

                    $item_data[$k] = array(
                                      'distributor_in_id' => 0,
                                      'type' => 'Box',
                                      'item_id' => $item_id,
                                      'qty' => $qty,
                                      'sell_rate' => $sell_rate,
                                      'grams' => $item_grams,
                                      'rate' => $rate,
                                      'amount' => $amount,
                                      'cost_rate' => $cost,
                                      'cost_amount' => $cost_amount,
                                      'cgst_amt' => $cgst_amt,
                                      'sgst_amt' => $sgst_amt,
                                      'igst_amt' => $igst_amt,
                                      'tax_amt' => $tax_amt,
                                      'total_amt' => $total_amt,
                                      'batch_no' =>$batch_no,
                                      'margin_per' => 0,
                                      'promo_margin' => 0,
                                      'tax_percentage' => $tax_per
                                  );
                  }

                  $depot_id = '3';
                  $distributor_id = '214';

                  $round_off_amt = round(round($tot_order_amount,0) - round($tot_order_amount,2),2);
                  $final_amount = round($tot_order_amount,0);

                  if($final_amount>0){
                      $sql = "insert into distributor_in (date_of_processing, depot_id, distributor_id, sales_rep_id, amount, tax, cst, tax_amount, final_amount, due_date, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, is_expired, is_exchanged, final_cost_amount, ref_id, sales_return_no, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, freezed, round_off_amount, sales_type, invoice_nos, modified_approved_date, discount, order_no) VALUES ('".$curdate."', '".$depot_id."', '".$distributor_id."', Null, ".$tot_amount.", Null, 1, ".$tot_tax_amount.", ".$tot_order_amount.", '".$curdate."', 'Pending', 'This is system generated entry.', '".$curusr."', '".$now."', '".$curusr."', '".$now."', Null, Null, Null, Null, 'no', 'no', ".$final_cost_amount.", Null, Null, 1, 1, 1, ".$tot_cgst_amount.", ".$tot_sgst_amount.", ".$tot_igst_amount.", 0, ".$round_off_amt.", 'Invoice', '".$invoice_no."', Null, ".$discount.", '".$order_no."')";
                      echo $sql.'<br/><br/>';
                      echo json_encode($item_data);
                      echo '<br/><br/>';
                      if ($conn->query($sql) === TRUE) {
                        $distributor_in_id = $conn->insert_id;

                        for($j=0; $j<count($item_data); $j++) {
                          // sleep(2);

                          $sql = "insert into distributor_in_items (distributor_in_id, type, item_id, qty, sell_rate, grams, rate, amount, cost_rate, cost_amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, batch_no, margin_per, tax_percentage, promo_margin) VALUES ('".$distributor_in_id."', '".$item_data[$j]['type']."', '".$item_data[$j]['item_id']."', '".$item_data[$j]['qty']."', '".$item_data[$j]['sell_rate']."', '".$item_data[$j]['grams']."', '".$item_data[$j]['rate']."', '".$item_data[$j]['amount']."', '".$item_data[$j]['cost_rate']."', '".$item_data[$j]['cost_amount']."', '".$item_data[$j]['cgst_amt']."', '".$item_data[$j]['sgst_amt']."', '".$item_data[$j]['igst_amt']."', '".$item_data[$j]['tax_amt']."', '".$item_data[$j]['total_amt']."', '".$item_data[$j]['batch_no']."', '".$item_data[$j]['margin_per']."', '".$item_data[$j]['tax_percentage']."', '".$item_data[$j]['promo_margin']."')";
                          $conn->query($sql);
                          echo $sql.'<br/><br/>';
                        }

                        $sql = "insert into user_access_log (user_id, module_name, controller_name, action, table_id, date) VALUES ('" . $curusr . "', 'Distributor_In', 'Distributor_In', 'System Generated Sales Return Entry created successfully.', '".$distributor_in_id."', '".$now."')";
                        $conn->query($sql);

                        echo 'System Generated Sales Return Entry created successfully.<br/><br/>';
                      } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                      }
                  } else {
                    echo 'Sales Return amount is zero.<br/><br/>';
                  }
              }

      } catch (MarketplaceWebService_Exception $ex) {
          echo("Caught Exception: " . $ex->getMessage() . "\n");
          echo("Response Status Code: " . $ex->getStatusCode() . "\n");
          echo("Error Code: " . $ex->getErrorCode() . "\n");
          echo("Error Type: " . $ex->getErrorType() . "\n");
          echo("Request ID: " . $ex->getRequestId() . "\n");
          echo("XML: " . $ex->getXML() . "\n");
          echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
      }
  }
?>

                                                                                
