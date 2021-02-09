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
 * Get Report List  Sample
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
 * sample for Get Report List Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebService_Model_GetReportListRequest
 // object or array of parameters
// $parameters = array (
//   'Merchant' => MERCHANT_ID,
//   'AvailableToDate' => new DateTime('now', new DateTimeZone('UTC')),
//   'AvailableFromDate' => new DateTime('-6 months', new DateTimeZone('UTC')),
//   'Acknowledged' => false, 
//   'MWSAuthToken' => '<MWS Auth Token>', // Optional
// );
// 
// $request = new MarketplaceWebService_Model_GetReportListRequest($parameters);
 
$request = new MarketplaceWebService_Model_GetReportListRequest();
$request->setMerchant(MERCHANT_ID);
$request->setAvailableToDate(new DateTime('now', new DateTimeZone('UTC')));
$request->setAvailableFromDate(new DateTime('-8 months', new DateTimeZone('UTC')));
// $request->setAvailableToDate(new DateTime('2019-08-05'));
// $request->setAvailableFromDate(new DateTime('2019-07-14'));
$request->setAcknowledged(false);
$request->setMWSAuthToken('529421203372'); // Optional
$request->setMaxCount('100000');
// $request->setReportTypeList('_GET_FBA_FULFILLMENT_CUSTOMER_RETURNS_DATA_');
// $request->setReportRequestIdList('113078018102');

$ReportId = 0;
invokeGetReportList($service, $request);


// $request2 = new MarketplaceWebService_Model_GetReportRequest();
// $request2->setMerchant(MERCHANT_ID);
// $request2->setReport(@fopen('php://memory', 'rw+'));
// $ReportId = '16858160182018080';
// $request2->setReportId($ReportId);
// $request2->setMWSAuthToken('529421203372'); // Optional

// invokeGetReport($service, $request2);



                                                                    
/**
  * Get Report List Action Sample
  * returns a list of reports; by default the most recent ten reports,
  * regardless of their acknowledgement status
  *   
  * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
  * @param mixed $request MarketplaceWebService_Model_GetReportList or array of parameters
  */
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

                    $arrReportId = array();
                    $i = 0;

                    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    foreach ($reportInfoList as $reportInfo) {
                        $report_type = $reportInfo->getReportType();
                        $report_request_id = $reportInfo->getReportRequestId();

                        // echo $report_type;
                        // echo '<br/><br/>';
                        // echo $report_request_id;
                        // echo '<br/><br/>';

                        // if($report_type=='_GET_FBA_FULFILLMENT_CUSTOMER_RETURNS_DATA_' && $report_request_id==$ReportRequestId) {
                        // if($report_type=='_GET_V2_SETTLEMENT_REPORT_DATA_XML_' && $report_request_id=='113068018101') {

                        if($report_type=='_GET_V2_SETTLEMENT_REPORT_DATA_FLAT_FILE_V2_') {
                            if ($reportInfo->isSetReportId()) {
                                // echo("                    ReportId<br/>");
                                // echo("                        " . $reportInfo->getReportId() . "<br/>");

                                global $ReportId;
                                $ReportId = $reportInfo->getReportId();

                                $sql = "select * from payment_settlement_reports where report_id='".$ReportId."'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                  $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                                  if(count($row_arr)>0) {
                                    $result->free();
                                    echo 'ReportId '.$ReportId.' already imported.<br/><br/>';
                                    continue;
                                  }
                                }

                                $arrReportId[$i++] = $ReportId;

                                // echo '<br/><br/>';

                                // break;
                            }
                        }
                    }

                    // $request2 = new MarketplaceWebService_Model_GetReportRequest();
                    // $request2->setMerchant(MERCHANT_ID);
                    // $request2->setReport(@fopen('php://memory', 'rw+'));
                    // $ReportId = '16858160182018080';
                    // $request2->setReportId($ReportId);
                    // $request2->setMWSAuthToken('529421203372'); // Optional

                    // echo 'ReportId'.$ReportId;
                    // echo '<br/><br/>';
                    // invokeGetReport($service, $request2);

                    for($i=count($arrReportId)-1; $i>=0; $i--) {
                        $request2 = new MarketplaceWebService_Model_GetReportRequest();
                        $request2->setMerchant(MERCHANT_ID);
                        $request2->setReport(@fopen('php://memory', 'rw+'));
                        global $ReportId;
                        $ReportId = $arrReportId[$i];
                        $request2->setReportId($ReportId);
                        $request2->setMWSAuthToken('529421203372'); // Optional

                        echo 'ReportId '.$ReportId;
                        echo '<br/><br/>';
                        invokeGetReport($service, $request2);
                    }
                }
      } catch (MarketplaceWebService_Exception $ex) {
          echo("Caught Exception: " . $ex->getMessage() . "<br/>");
          echo("Response Status Code: " . $ex->getStatusCode() . "<br/>");
          echo("Error Code: " . $ex->getErrorCode() . "<br/>");
          echo("Error Type: " . $ex->getErrorType() . "<br/>");
          echo("Request ID: " . $ex->getRequestId() . "<br/>");
          echo("XML: " . $ex->getXML() . "<br/>");
          echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "<br/><br/>");
      }
  }

  function format_date($date='', $format = 'd.m.Y H:i:s')
  {
      if($date!='') {
          // echo $date . "<br/>";
          $date = str_replace('UTC', '', $date);
          // echo $date . "<br/>";
          $date = trim($date);
          // echo $date . "<br/>";

          $date = DateTime::createFromFormat($format, $date);
          // echo $date . "<br/>";

          $date = new DateTime($date->format('Y-m-d H:i:s'), new DateTimeZone('UTC'));
          // echo $date->format('Y-m-d H:i:s') . "<br/>";

          $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
          // echo $date->format('Y-m-d H:i:s') . "<br/>";

          $date = $date->format('Y-m-d H:i:s');
          // echo $date . "<br/>";
      } else {
          $date = null;
      }

      return $date;
  }

  function invokeGetReport(MarketplaceWebService_Interface $service, $request) 
  {
      try {
              $response = $service->getReport($request);

              date_default_timezone_set('Asia/Kolkata');

              $now=date('Y-m-d H:i:s');
              $curdate=date('Y-m-d');
              $curusr='148';

              global $ReportId;

              $result = stream_get_contents($request->getReport());

              // echo $result;
              // echo '<br/><br/>';

              $x=explode("\n",$result);
              $arr = array();

              foreach($x as $line){
                  // echo $line;
                  // echo '<br/><br/>';

                  $arr[]=explode("\t",$line);
              }

              // echo json_encode($arr);
              // echo '<br/><br/>';

              $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }

              if(count($arr)>0) {
                  $i = 1;

                  // echo json_encode($arr[$i]);
                  // echo '<br/><br/>';

                  if(isset($arr[$i])) {
                      $settlement_id = $conn->real_escape_string($arr[$i][0]);
                      $settlement_start_date = $conn->real_escape_string($arr[$i][1]);
                      $settlement_end_date = $conn->real_escape_string($arr[$i][2]);
                      $deposit_date = $conn->real_escape_string($arr[$i][3]);
                      $total_amount = $conn->real_escape_string($arr[$i][4]);
                      $currency = $conn->real_escape_string($arr[$i][5]);
                      $transaction_type = $conn->real_escape_string($arr[$i][6]);
                      $order_id = $conn->real_escape_string($arr[$i][7]);
                      $merchant_order_id = $conn->real_escape_string($arr[$i][8]);
                      $adjustment_id = $conn->real_escape_string($arr[$i][9]);
                      $shipment_id = $conn->real_escape_string($arr[$i][10]);
                      $marketplace_name = $conn->real_escape_string($arr[$i][11]);
                      $amount_type = $conn->real_escape_string($arr[$i][12]);
                      $amount_description = $conn->real_escape_string($arr[$i][13]);
                      $amount = $conn->real_escape_string($arr[$i][14]);
                      $fulfillment_id = $conn->real_escape_string($arr[$i][15]);
                      $posted_date = $conn->real_escape_string($arr[$i][16]);
                      $posted_date_time = $conn->real_escape_string($arr[$i][17]);
                      $order_item_code = $conn->real_escape_string($arr[$i][18]);
                      $merchant_order_item_id = $conn->real_escape_string($arr[$i][19]);
                      $merchant_adjustment_item_id = $conn->real_escape_string($arr[$i][20]);
                      $sku = $conn->real_escape_string($arr[$i][21]);
                      $quantity_purchased = $conn->real_escape_string($arr[$i][22]);
                      $promotion_id = $conn->real_escape_string($arr[$i][23]);

                      $sql = "select * from payment_settlement_reports where settlement_id='".$settlement_id."'";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                        if(count($row_arr)>0) {
                          $result->free();
                          echo 'settlement_id '.$settlement_id.' already imported.<br/><br/>';
                          goto ExitGetReport;
                        }
                      }

                      $settlement_start_date = format_date($settlement_start_date, 'd.m.Y H:i:s');
                      $settlement_end_date = format_date($settlement_end_date, 'd.m.Y H:i:s');
                      $deposit_date = format_date($deposit_date, 'd.m.Y H:i:s');
                      $posted_date = format_date($posted_date, 'd.m.Y');
                      $posted_date_time = format_date($posted_date_time, 'd.m.Y H:i:s');

                      if(isset($settlement_start_date)){
                          $settlement_start_date = "'".$settlement_start_date."'";
                      } else {
                          $settlement_start_date = "Null";
                      }
                      if(isset($settlement_end_date)){
                          $settlement_end_date = "'".$settlement_end_date."'";
                      } else {
                          $settlement_end_date = "Null";
                      }
                      if(isset($deposit_date)){
                          $deposit_date = "'".$deposit_date."'";
                      } else {
                          $deposit_date = "Null";
                      }
                      if(isset($posted_date)){
                          $posted_date = "'".$posted_date."'";
                      } else {
                          $posted_date = "Null";
                      }
                      if(isset($posted_date_time)){
                          $posted_date_time = "'".$posted_date_time."'";
                      } else {
                          $posted_date_time = "Null";
                      }
                      if($total_amount==''){
                          $total_amount = 0;
                      }

                      $total_amount = floatval($total_amount);

                      if($total_amount!=0) {
                          $sql = "insert into payment_details (date_of_deposit, bank_id, payment_mode, total_amount, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, distributor_out_id, ref_id, modified_approved_date) values ($deposit_date, '1', 'NEFT', '$total_amount', 'Pending', 'This is system generated entry.', '$curusr', '$now', '$curusr', '$now', null, null, null, null, null, null, null)";
                          echo $sql.'<br/><br/>';
                          if ($conn->query($sql) === TRUE) {
                              $payment_id = $conn->insert_id;
                              $distributor_id = '214';

                              $sql = "insert into payment_details_items (payment_id, distributor_id, ref_no, invoice_no, bank_name, bank_city, payment_amount, settlement_id, settlement_start_date, settlement_end_date) VALUES ('$payment_id', '$distributor_id', 'NEFT', 'On Account', '', '', '$total_amount', '$settlement_id', $settlement_start_date, $settlement_end_date)";
                              $conn->query($sql);
                              echo $sql.'<br/><br/>';

                              $sql = "insert into payment_settlement_reports (report_id, settlement_id, settlement_start_date, settlement_end_date, deposit_date, total_amount, currency) VALUES ('$ReportId', '$settlement_id', $settlement_start_date, $settlement_end_date, $deposit_date, '$total_amount', '$currency')";
                              $conn->query($sql);
                              echo $sql.'<br/><br/>';

                              $sql = "insert into user_access_log (user_id, module_name, controller_name, action, table_id, date) VALUES ('$curusr', 'Payment', 'Payment', 'System Generated Payment Entry created successfully.', '$payment_id', '$now')";
                              $conn->query($sql);

                              echo 'System Generated Payment created successfully.<br/><br/>';
                          } else {
                              echo "Error: " . $sql . "<br>" . $conn->error;
                          }
                      }
                  }

                  if(count($arr)>1) {
                      for($i=2; $i<count($arr); $i++) {
                          // echo json_encode($arr[$i]);
                          // echo '<br/><br/>';
                          // echo count($arr[$i]);
                          // echo '<br/><br/>';

                          if(count($arr[$i])==24) {
                              $settlement_id = $conn->real_escape_string($arr[$i][0]);
                              $settlement_start_date = $conn->real_escape_string($arr[$i][1]);
                              $settlement_end_date = $conn->real_escape_string($arr[$i][2]);
                              $deposit_date = $conn->real_escape_string($arr[$i][3]);
                              $total_amount = $conn->real_escape_string($arr[$i][4]);
                              $currency = $conn->real_escape_string($arr[$i][5]);
                              $transaction_type = $conn->real_escape_string($arr[$i][6]);
                              $order_id = $conn->real_escape_string($arr[$i][7]);
                              $merchant_order_id = $conn->real_escape_string($arr[$i][8]);
                              $adjustment_id = $conn->real_escape_string($arr[$i][9]);
                              $shipment_id = $conn->real_escape_string($arr[$i][10]);
                              $marketplace_name = $conn->real_escape_string($arr[$i][11]);
                              $amount_type = $conn->real_escape_string($arr[$i][12]);
                              $amount_description = $conn->real_escape_string($arr[$i][13]);
                              $amount = $conn->real_escape_string($arr[$i][14]);
                              $fulfillment_id = $conn->real_escape_string($arr[$i][15]);
                              $posted_date = $conn->real_escape_string($arr[$i][16]);
                              $posted_date_time = $conn->real_escape_string($arr[$i][17]);
                              $order_item_code = $conn->real_escape_string($arr[$i][18]);
                              $merchant_order_item_id = $conn->real_escape_string($arr[$i][19]);
                              $merchant_adjustment_item_id = $conn->real_escape_string($arr[$i][20]);
                              $sku = $conn->real_escape_string($arr[$i][21]);
                              $quantity_purchased = $conn->real_escape_string($arr[$i][22]);
                              $promotion_id = $conn->real_escape_string($arr[$i][23]);

                              $settlement_start_date = format_date($settlement_start_date, 'd.m.Y H:i:s');
                              $settlement_end_date = format_date($settlement_end_date, 'd.m.Y H:i:s');
                              $deposit_date = format_date($deposit_date, 'd.m.Y H:i:s');
                              $posted_date = format_date($posted_date, 'd.m.Y');
                              $posted_date_time = format_date($posted_date_time, 'd.m.Y H:i:s');

                              if(isset($settlement_start_date)){
                                  $settlement_start_date = "'".$settlement_start_date."'";
                              } else {
                                  $settlement_start_date = "Null";
                              }
                              if(isset($settlement_end_date)){
                                  $settlement_end_date = "'".$settlement_end_date."'";
                              } else {
                                  $settlement_end_date = "Null";
                              }
                              if(isset($deposit_date)){
                                  $deposit_date = "'".$deposit_date."'";
                              } else {
                                  $deposit_date = "Null";
                              }
                              if(isset($posted_date)){
                                  $posted_date = "'".$posted_date."'";
                              } else {
                                  $posted_date = "Null";
                              }
                              if(isset($posted_date_time)){
                                  $posted_date_time = "'".$posted_date_time."'";
                              } else {
                                  $posted_date_time = "Null";
                              }
                              if($total_amount==''){
                                  $total_amount = 0;
                              }
                              if($quantity_purchased==''){
                                  $quantity_purchased = 0;
                              }

                              $total_amount = floatval($total_amount);

                              $sql = "insert into payment_settlement_details (settlement_id, settlement_start_date, settlement_end_date, deposit_date, total_amount, currency, transaction_type, order_id, merchant_order_id, adjustment_id, shipment_id, marketplace_name, amount_type, amount_description, amount, fulfillment_id, posted_date, posted_date_time, order_item_code, merchant_order_item_id, merchant_adjustment_item_id, sku, quantity_purchased, promotion_id) VALUES ('$settlement_id', $settlement_start_date, $settlement_end_date, $deposit_date, '$total_amount', '$currency', '$transaction_type', '$order_id', '$merchant_order_id', '$adjustment_id', '$shipment_id', '$marketplace_name', '$amount_type', '$amount_description', '$amount', '$fulfillment_id', $posted_date, $posted_date_time, '$order_item_code', '$merchant_order_item_id', '$merchant_adjustment_item_id', '$sku', '$quantity_purchased', '$promotion_id')";
                              $conn->query($sql);
                              echo $sql.'<br/><br/>';
                          }
                      }
                  }
              }

              ExitGetReport:

      } catch (MarketplaceWebService_Exception $ex) {
          echo("Caught Exception: " . $ex->getMessage() . "<br/>");
          echo("Response Status Code: " . $ex->getStatusCode() . "<br/>");
          echo("Error Code: " . $ex->getErrorCode() . "<br/>");
          echo("Error Type: " . $ex->getErrorType() . "<br/>");
          echo("Request ID: " . $ex->getRequestId() . "<br/>");
          echo("XML: " . $ex->getXML() . "<br/>");
          echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "<br/><br/>");
      }
  }
?>
