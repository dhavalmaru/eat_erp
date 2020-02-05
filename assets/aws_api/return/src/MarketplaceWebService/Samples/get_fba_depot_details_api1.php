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

$request = new MarketplaceWebService_Model_GetReportListRequest();
$request->setMerchant(MERCHANT_ID);
$request->setAvailableToDate(new DateTime('now', new DateTimeZone('UTC')));
$request->setAvailableFromDate(new DateTime('-3 months', new DateTimeZone('UTC')));
$request->setAcknowledged(false);
$request->setMWSAuthToken('529421203372');
  
$ReportId = 0;
invokeGetReportList($service, $request);

sleep(10);

$request2 = new MarketplaceWebService_Model_GetReportRequest();
$request2->setMerchant(MERCHANT_ID);
$request2->setReport(@fopen('php://memory', 'rw+'));
$request2->setReportId($ReportId);
$request2->setMWSAuthToken('529421203372'); // Optional

invokeGetReport($service, $request2);

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

                        // if($report_type=='_GET_AMAZON_FULFILLED_SHIPMENTS_DATA_' && $report_request_id==$ReportRequestId) {
                        if($report_type=='_GET_AMAZON_FULFILLED_SHIPMENTS_DATA_') {
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

              // echo json_encode($arr);
              // echo '<br/><br/>';

              $order_data = array();

              for($i=1; $i<count($arr); $i++) {
                  // $return_date = $arr[$i][0];
                  // $order_no = $arr[$i][1];
                  // $asin = $arr[$i][3];
                  // $qty = intval(trim($arr[$i][6]));
                  $order_no = $arr[$i][0];
                  $fulfillment_center_id = $arr[$i][46];

                  $index = '';
                  for($j=0; $j<count($order_data); $j++) {
                      if($order_data[$j]['order_no']==$order_no) {
                          $index = $j;
                          break;
                      }
                  }
                  if($index===''){
                      $index = count($order_data);
                      // $order_data[$index]['order_no']=$order_no;
                      // $order_data[$index]['return_date']=$return_date;
                      // $order_data[$index]['sku_data']=array();
                      $order_data[$index]['order_no']=$order_no;
                      $order_data[$index]['fulfillment_center_id']=$fulfillment_center_id;
                  }

                  // $sku_data = $order_data[$index]['sku_data'];
                  // $index2 = '';
                  // for($k=0; $k<count($sku_data); $k++) {
                  //     if($sku_data[$k]['asin']==$asin) {
                  //         $index2 = $k;
                  //         break;
                  //     }
                  // }
                  // if($index2===''){
                  //     $index2 = count($sku_data);
                  //     $sku_data[$index2]['asin']=$asin;
                  //     $sku_data[$index2]['qty']=$qty;
                  // } else {
                  //     $sku_data[$index2]['qty'] = $sku_data[$index2]['qty'] + $qty;
                  // }

                  // $order_data[$index]['sku_data'] = $sku_data;
              }

              echo json_encode($order_data);
              echo '<br/><br/>';
              // echo json_encode($sku_data);

              // $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
              // if ($conn->connect_error) {
              //     die("Connection failed: " . $conn->connect_error);
              // }

              // for($i=0; $i<count($order_data); $i++) {
              //     $order_no = $order_data[$i]['order_no'];
              //     $fulfillment_center_id = $order_data[$i]['fulfillment_center_id'];

              //     $sql = "select * from fc_details where order_no='".$order_no."'";
              //     $result = $conn->query($sql);
              //     if ($result->num_rows > 0) {
              //       $row_arr = $result->fetch_all(MYSQLI_ASSOC);
              //       if(count($row_arr)>0) {
              //         $result->free();
              //         echo 'order_no '.$order_no.' already exist.<br/><br/>';
              //         continue;
              //       }
              //     }

              //     $sql = "insert into fc_details (order_no, fulfillment_center_id, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on) VALUES ('".$order_no."', '".$fulfillment_center_id."', 'Approved', 'This is system generated entry.', '".$curusr."', '".$now."', '".$curusr."', '".$now."', Null, Null, Null, Null)";
              //     $conn->query($sql);
              //     echo $sql.'<br/><br/>';
              //     echo '<br/><br/>';
              // }

      } catch (MarketplaceWebService_Exception $ex) {
          // echo json_encode($ex);
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

                                                                                
