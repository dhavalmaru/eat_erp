<?php
/*******************************************************************************
 * Copyright 2009-2018 Amazon Services. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License"); 
 *
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at: http://aws.amazon.com/apache2.0
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR 
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the 
 * specific language governing permissions and limitations under the License.
 *******************************************************************************
 * PHP Version 5
 * @category Amazon
 * @package  Marketplace Web Service Orders
 * @version  2013-09-01
 * Library Version: 2018-10-31
 * Generated: Mon Oct 22 22:40:38 UTC 2018
 */

/**
 * List Orders Sample
 */

require_once('.config.inc.php');
// require_once('PHPMailer3/PHPMailerAutoload.php');

/************************************************************************
 * Instantiate Implementation of MarketplaceWebServiceOrders
 *
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants
 * are defined in the .config.inc.php located in the same
 * directory as this sample
 ***********************************************************************/
// More endpoints are listed in the MWS Developer Guide
// North America:
//$serviceUrl = "https://mws.amazonservices.com/Orders/2013-09-01";
// Europe
//$serviceUrl = "https://mws-eu.amazonservices.com/Orders/2013-09-01";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp/Orders/2013-09-01";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn/Orders/2013-09-01";
// India:
$serviceUrl = "https://mws.amazonservices.in/Orders/2013-09-01";


 $config = array (
   'ServiceURL' => $serviceUrl,
   'ProxyHost' => null,
   'ProxyPort' => -1,
   'ProxyUsername' => null,
   'ProxyPassword' => null,
   'MaxErrorRetry' => 3,
 );

 $service = new MarketplaceWebServiceOrders_Client(
        AWS_ACCESS_KEY_ID,
        AWS_SECRET_ACCESS_KEY,
        APPLICATION_NAME,
        APPLICATION_VERSION,
        $config);



$service2Url2 = "https://mws.amazonservices.in";

$config2 = array (
  'ServiceURL' => $service2Url2,
  'ProxyHost' => null,
  'ProxyPort' => -1,
  'MaxErrorRetry' => 3,
);

$service2 = new MarketplaceWebService_Client(
     AWS_ACCESS_KEY_ID, 
     AWS_SECRET_ACCESS_KEY, 
     $config2,
     APPLICATION_NAME,
     APPLICATION_VERSION);

$marketplaceIdArray2 = array("Id" => array('A21TJRUUN4KGV'));

$request4 = new MarketplaceWebService_Model_GetReportListRequest();
$request4->setMerchant(MERCHANT_ID);
$request4->setAvailableToDate(new DateTime('now', new DateTimeZone('UTC')));
$request4->setAvailableFromDate(new DateTime('-3 months', new DateTimeZone('UTC')));
$request4->setAcknowledged(false);
$request4->setMWSAuthToken('529421203372');
  
$ReportId = 0;
invokeGetReportList($service2, $request4);

sleep(10);

$request5 = new MarketplaceWebService_Model_GetReportRequest();
$request5->setMerchant(MERCHANT_ID);
$request5->setReport(@fopen('php://memory', 'rw+'));
$request5->setReportId($ReportId);
$request5->setMWSAuthToken('529421203372'); // Optional

$fulfillment_data = invokeGetReport($service2, $request5);


/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebServiceOrders
 * responses without calling MarketplaceWebServiceOrders service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebServiceOrders/Mock tree
 *
 ***********************************************************************/
 // $service = new MarketplaceWebServiceOrders_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out
 * sample for List Orders Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebServiceOrders_Model_ListOrders
 $request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
 $request->setSellerId(MERCHANT_ID);
 $request->setMarketplaceId(MARKETPLACE_ID);

 // $request->setFulfillmentChannel("MFN");
 // $request->setOrderStatus("Shipped");
 $request->setMaxResultsPerPage(100);

 $request2 = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
 $request2->setSellerId(MERCHANT_ID);
 // $request2->setAmazonOrderId("408-1055488-9217907");

 // echo "Date Time: ".date('Y-m-d H:i:s')."<br/><br/>";
 // echo time()."<br/><br/>";
 // echo date('H:i:s', time() - 3600)."<br/><br/>";

 // object or array of parameters

 // $date = date('Y-m-d', strtotime('-15 days'));
 // $time = date('H:i:s', time() - 3600);
 // echo "Time: ".$date."T".$time."Z<br/><br/>";
 // $request->setLastUpdatedAfter($date."T".$time."Z");
 // invokeListOrders($service, $request, $request2);

 // sleep(3);

 // $date = date('Y-m-d', strtotime('-10 days'));
 // $time = date('H:i:s', time() - 3600);
 // echo "Time: ".$date."T".$time."Z<br/><br/>";
 // $request->setLastUpdatedAfter($date."T".$time."Z");
 // invokeListOrders($service, $request, $request2);

 // sleep(3);

 // $date = date('Y-m-d', strtotime('-3 days'));
 // $time = date('H:i:s', time() - 3600);
 // echo "Time: ".$date."T".$time."Z<br/><br/>";
 // $request->setLastUpdatedAfter($date."T".$time."Z");
 // invokeListOrders($service, $request, $request2);

 // sleep(3);

 // $date = date('Y-m-d', strtotime('-2 days'));
 // $time = date('H:i:s', time() - 3600);
 // echo "Time: ".$date."T".$time."Z<br/><br/>";
 // $request->setLastUpdatedAfter($date."T".$time."Z");
 // invokeListOrders($service, $request, $request2);

 // sleep(3);

 // $date = date('Y-m-d', strtotime('-1 days'));
 // $time = date('H:i:s', time() - 3600);
 // echo "Time: ".$date."T".$time."Z<br/><br/>";
 // $request->setLastUpdatedAfter($date."T".$time."Z");
 // invokeListOrders($service, $request, $request2);

/**
  * Get List Orders Action Sample
  * Gets competitive pricing and related information for a product identified by
  * the MarketplaceId and ASIN.
  *
  * @param MarketplaceWebServiceOrders_Interface $service instance of MarketplaceWebServiceOrders_Interface
  * @param mixed $request MarketplaceWebServiceOrders_Model_ListOrders or array of parameters
  */

  function invokeListOrders(MarketplaceWebServiceOrders_Interface $service, $request, $request2)
  {
      try {
        $response = $service->ListOrders($request);

        // echo ("Service Response\n");
        // echo ("=============================================================================\n");

        // $dom = new DOMDocument();
        // $dom->loadXML($response->toXML());

        // $x = $dom->documentElement;
        // foreach ($x->childNodes AS $item) {
        //   print $item->nodeName . " = " . $item->nodeValue . "<br>";
        // }

        // $dom->preserveWhiteSpace = false;
        // $dom->formatOutput = true;
        // echo $dom->saveXML();

        $xml = simplexml_load_string($response->toXML());

        $ListOrdersResult = $xml->ListOrdersResult;
        $Orders = $ListOrdersResult->Orders;
        $Order = $Orders->Order;

        date_default_timezone_set('Asia/Kolkata');

        $now=date('Y-m-d H:i:s');
        $curdate=date('Y-m-d');
        $curusr='191';

        // Create connection
        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        for($i=0; $i<count($Order); $i++) {
          try {
            $row = $Order[$i];

            echo json_encode($row);
            echo '<br/><br/>';
            // $AmazonOrderId = $row->AmazonOrderId;
            // echo $AmazonOrderId;
            // echo '<br/>';
            // $PurchaseDate = $row->PurchaseDate;
            // $date = new DateTime($PurchaseDate, new DateTimeZone('UTC'));
            // echo $date->format('Y-m-d H:i:s');
            // echo '<br/>';
            // $OrderTotal = $row->OrderTotal;
            // echo json_encode($OrderTotal);
            // echo '<br/>';
            // $OrderAmt = $OrderTotal[0]->Amount;
            // echo $OrderAmt;
            // echo '<br/>';
            // $ShippingAddress = $row->ShippingAddress;
            // echo json_encode($ShippingAddress);
            // echo '<br/>';

            $AmazonOrderId = $row->AmazonOrderId;
            $OrderStatus = $row->OrderStatus;
            $FulfillmentChannel = $row->FulfillmentChannel;

            $bl_place_order = false;

            if(strtoupper(trim($FulfillmentChannel))=='AFN' && strtoupper(trim($OrderStatus))=='SHIPPED') {
              $bl_place_order = true;
            }
            if(strtoupper(trim($FulfillmentChannel))=='MFN' && (strtoupper(trim($OrderStatus))=='UNSHIPPED' || strtoupper(trim($OrderStatus))=='SHIPPED')) {
              $bl_place_order = true;
            }

            if($bl_place_order==false) {
              echo 'FulfillmentChannel is '.$FulfillmentChannel.' & OrderStatus is '.$OrderStatus.'.<br/><br/>';
              continue;
            }

            // if(strtoupper(trim($FulfillmentChannel))!='AFN' && strtoupper(trim($FulfillmentChannel))!='MFN') {
            //   echo 'FulfillmentChannel is '.$FulfillmentChannel.'.<br/><br/>';
            //   continue;
            // }
            // if(strtoupper(trim($OrderStatus))!='SHIPPED') {
            //   echo 'OrderStatus is '.$OrderStatus.'.<br/><br/>';
            //   continue;
            // }

            $sql = "select * from distributor_out where order_no='".$AmazonOrderId."'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              $row_arr = $result->fetch_all(MYSQLI_ASSOC);
              if(count($row_arr)>0) {
                $result->free();
                echo 'Order No '.$AmazonOrderId.' already exist.<br/><br/>';
                continue;
              }
            }

            $PurchaseDate = $row->PurchaseDate;
            $date = new DateTime($PurchaseDate, new DateTimeZone('UTC'));
            $order_date = $date->format('Y-m-d');

            $OrderTotal = $row->OrderTotal;
            $OrderAmt = 0;
            if(count($OrderTotal)>0) {
              if(isset($OrderTotal[0]->Amount)) {
                $OrderAmt = doubleval($OrderTotal[0]->Amount);
              }
            }

            $ShippingAddress = $row->ShippingAddress;

            $client_name = '';
            $address = '';
            $city = '';
            $pincode = '';
            $state = 'Maharashtra';
            $state_code = '27';
            $phone = '';
            if(count($ShippingAddress)>0) {
              $client_name = ucwords(strtolower(trim($conn->real_escape_string($ShippingAddress[0]->Name))));
              $address = trim($conn->real_escape_string($ShippingAddress[0]->AddressLine1))
                          .' '.
                          trim($conn->real_escape_string($ShippingAddress[0]->AddressLine2));
              $city = ucwords(strtolower(trim($conn->real_escape_string($ShippingAddress[0]->City))));
              $pincode = $conn->real_escape_string($ShippingAddress[0]->PostalCode);
              $state = ucwords(strtolower(trim($conn->real_escape_string($ShippingAddress[0]->StateOrRegion))));
              $CountryCode = $conn->real_escape_string($ShippingAddress[0]->CountryCode);
              if(isset($ShippingAddress[0]->Phone)) {
                $phone = $conn->real_escape_string($ShippingAddress[0]->Phone);
              }

              $sql = "select * from country_master where country_code='".$CountryCode."'";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                if(count($row_arr)>0) {
                  if(isset($row_arr[0]['country_name'])) {
                    $country = ucwords(strtolower(trim($row_arr[0]['country_name'])));
                  }
                }
                $result->free();
              }

              $sql = "select * from state_master where state_name='".$state."'";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                if(count($row_arr)>0) {
                  if(isset($row_arr[0]['state_code'])) {
                    $state_code = $row_arr[0]['state_code'];
                  }
                }
                $result->free();
              }
            }

            $tax_type = 'Intra';
            if(strtoupper(trim($state))!='MAHARASHTRA') {
              $tax_type = 'Inter';
            }

            $total_order_amt = 0;
            $item_data = array();

            sleep(3);

            $request2->setAmazonOrderId($AmazonOrderId);
            $xml2=invokeListOrderItems($service, $request2);
            $ListOrderItemsResult = $xml2->ListOrderItemsResult;
            $OrderItems = $ListOrderItemsResult->OrderItems;
            $OrderItem = $OrderItems->OrderItem;
            for($j=0; $j<count($OrderItem); $j++) {
              $row2 = $OrderItem[$j];

              echo json_encode($row2);
              echo '<br/><br/>';

              $ASIN = '';
              $Title = '';
              $QuantityOrdered = 0;
              $QuantityShipped = 0;
              $ItemPrice = array();
              $ItemAmt = 0;
              $PromotionDiscount = array();
              $PromotionAmt = 0;

              if(count($row2)>0) {
                if(isset($row2[0]->ASIN)) {
                  $ASIN = $conn->real_escape_string($row2[0]->ASIN);
                }
                if(isset($row2[0]->Title)) {
                  $Title = $conn->real_escape_string($row2[0]->Title);
                }
                if(isset($row2[0]->QuantityOrdered)) {
                  $QuantityOrdered = doubleval($conn->real_escape_string($row2[0]->QuantityOrdered));
                }
                if(isset($row2[0]->QuantityShipped)) {
                  $QuantityShipped = doubleval($conn->real_escape_string($row2[0]->QuantityShipped));
                }
                if(isset($row2[0]->ItemPrice)) {
                  $ItemPrice = $row2[0]->ItemPrice;
                }
                if(isset($ItemPrice[0]->Amount)) {
                  $ItemAmt = doubleval($conn->real_escape_string($ItemPrice[0]->Amount));
                }
                if(isset($row2[0]->PromotionDiscount)) {
                  $PromotionDiscount = $row2[0]->PromotionDiscount;
                }
                if(isset($PromotionDiscount[0]->Amount)) {
                  $PromotionAmt = doubleval($conn->real_escape_string($PromotionDiscount[0]->Amount));
                }
              }
              
              $item_id = 0;
              $item_grams = 0;
              $item_rate = 0;
              $item_tax_per = 0;

              $sql = "select * from box_master where asin ='".$ASIN."'";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                $row_arr = $result->fetch_all(MYSQLI_ASSOC);

                // echo json_encode($row_arr);
                // echo '<br/><br/>';

                if(count($row_arr)>0) {
                  if(isset($row_arr[0]['id'])) {
                    $item_id = $row_arr[0]['id'];
                  }
                  if(isset($row_arr[0]['grams'])) {
                    $item_grams = $row_arr[0]['grams'];
                  }
                  if(isset($row_arr[0]['rate'])) {
                    $item_rate = $row_arr[0]['rate'];
                  }
                  if(isset($row_arr[0]['tax_percentage'])) {
                    $item_tax_per = $row_arr[0]['tax_percentage'];
                  }
                }
                $result->free();
              }

              $total_amt = $ItemAmt - $PromotionAmt;
              $total_order_amt = $total_order_amt + ($QuantityShipped*$item_rate);

              $item_data[$j] = array(
                              'distributor_out_id' => 0,
                              'type' => 'Box',
                              'item_id' => $item_id,
                              'qty' => $QuantityShipped,
                              'sell_rate' => $item_rate,
                              'grams' => $item_grams,
                              'rate' => $item_rate,
                              'amount' => $total_amt,
                              'cgst_amt' => 0,
                              'sgst_amt' => 0,
                              'igst_amt' => 0,
                              'tax_amt' => 0,
                              'total_amt' => $total_amt,
                              'margin_per' => 0,
                              'promo_margin' => 0,
                              'tax_percentage' => $item_tax_per
                          );
            }

            $total_discount_amt = $total_order_amt - $OrderAmt;
            $discount_per = 0;
            if($total_order_amt!=0){
              $discount_per=round(($total_discount_amt/$total_order_amt)*100,2);
            }

            // echo 'OrderAmt: '.$OrderAmt;
            // echo '<br/>';
            // echo 'total_order_amt: '.$total_order_amt;
            // echo '<br/>';
            // echo 'total_discount_amt: '.$total_discount_amt;
            // echo '<br/>';
            // echo 'dicount_per: '.$dicount_per;
            // echo '<br/><br/><br/>';

            $tot_amount = 0;
            $tot_cgst_amount = 0;
            $tot_sgst_amount = 0;
            $tot_igst_amount = 0;
            $tot_tax_amount = 0;
            $tot_order_amount = 0;

            for($j=0; $j<count($item_data); $j++) {
              $distributor_out_id = $item_data[$j]['distributor_out_id'];
              $type = $item_data[$j]['type'];
              $item_id = $item_data[$j]['item_id'];
              $qty = $item_data[$j]['qty'];
              $sell_rate = $item_data[$j]['sell_rate'];
              $grams = $item_data[$j]['grams'];
              $rate = $item_data[$j]['rate'];
              $amount = $item_data[$j]['amount'];
              $cgst_amt = $item_data[$j]['cgst_amt'];
              $sgst_amt = $item_data[$j]['sgst_amt'];
              $igst_amt = $item_data[$j]['igst_amt'];
              $tax_amt = $item_data[$j]['tax_amt'];
              $total_amt = $item_data[$j]['total_amt'];
              $margin_per = $item_data[$j]['margin_per'];
              $promo_margin = $item_data[$j]['promo_margin'];
              $tax_per = $item_data[$j]['tax_percentage'];

              $sell_rate = $rate - (($rate*$discount_per)/100);
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

              $tot_amount = $tot_amount + $amount;
              $tot_tax_amount = $tot_tax_amount + $tax_amt;
              $tot_order_amount = $tot_order_amount + $total_amt;

              $tot_cgst_amount = $tot_cgst_amount + $cgst_amt;
              $tot_sgst_amount = $tot_sgst_amount + $sgst_amt;
              $tot_igst_amount = $tot_igst_amount + $igst_amt;

              $item_data[$j] = array(
                              'distributor_out_id' => $distributor_out_id,
                              'type' => $type,
                              'item_id' => $item_id,
                              'qty' => $qty,
                              'sell_rate' => $sell_rate,
                              'grams' => $grams,
                              'rate' => $rate,
                              'amount' => $amount,
                              'cgst_amt' => $cgst_amt,
                              'sgst_amt' => $sgst_amt,
                              'igst_amt' => $igst_amt,
                              'tax_amt' => $tax_amt,
                              'total_amt' => $total_amt,
                              'margin_per' => $margin_per,
                              'promo_margin' => $promo_margin,
                              'tax_percentage' => $tax_per
                          );
            }

            $distributor_id = '214';

            if(strtoupper(trim($FulfillmentChannel))=='MFN') {
              $depot_id = '2';
              $round_off_amt = 0;
              $invoice_amount = 0;
              $delivery_status='Pending';
              $delivery_date='Null';
            } else {
              $depot_id = '3';
              $round_off_amt = round(round($tot_order_amount,0) - round($tot_order_amount,2),2);
              $invoice_amount = round($tot_order_amount,0);
              $delivery_status='Delivered';
              $delivery_date="'".$curdate."'";
            }


            $sales_rep_id='104';

            // if($invoice_amount>0){


              $sql = "insert into distributor_out (date_of_processing, invoice_no, depot_id, distributor_id, sales_rep_id, amount, tax, tax_per, tax_amount, final_amount, due_date, order_no, order_date, supplier_ref, despatch_doc_no, despatch_through, destination, status, remarks, modified_by, modified_on, client_name, address, city, pincode, state, country, mobile_no, discount, sample_distributor_id, date_of_dispatch, delivery_status, delivery_date, delivery_sales_rep_id, transport_type, vehicle_number, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, reverse_charge, shipping_address, distributor_consignee_id, con_name, con_address, con_city, con_pincode, con_state, con_country, con_state_code, con_gst_number, state_code, round_off_amount, invoice_amount, ref_id, invoice_date, email_date_time, basis_of_sales, email_from, email_approved_by, gstin, created_by, created_on) VALUES ('".$curdate."', '', '".$depot_id."', '".$distributor_id."', Null, ".$tot_amount.", Null, 1, ".$tot_tax_amount.", ".$tot_order_amount.", '".$curdate."', '".$AmazonOrderId."', '".$order_date."', Null, Null, Null, Null, 'Pending', 'This is system generated entry.', '".$curusr."', '".$now."', '".$client_name."', '".$address."', '".$city."', '".$pincode."', '".$state."', '".$country."', '".$phone."', ".$discount_per.", Null, '".$curdate."', '".$delivery_status."', ".$delivery_date.", '".$sales_rep_id."', '', '', 1, 1, 1, ".$tot_cgst_amount.", ".$tot_sgst_amount.", ".$tot_igst_amount.", 'no', 'yes', Null, Null, Null, Null, Null, Null, Null, Null, Null, '".$state_code."', ".$round_off_amt.", ".$invoice_amount.", Null, Null, '".$now."', 'PO Number', '', '', '', '".$curusr."', '".$now."')";
              // if ($conn->query($sql) === TRUE) {
              //   $distributor_out_id = $conn->insert_id;

              //   for($j=0; $j<count($item_data); $j++) {
              //     $sql = "insert into distributor_out_items (distributor_out_id, type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, margin_per, promo_margin, tax_percentage, batch_no, batch_qty) VALUES ('".$distributor_out_id."', '".$item_data[$j]['type']."', '".$item_data[$j]['item_id']."', '".$item_data[$j]['qty']."', '".$item_data[$j]['sell_rate']."', '".$item_data[$j]['grams']."', '".$item_data[$j]['rate']."', '".$item_data[$j]['amount']."', '".$item_data[$j]['cgst_amt']."', '".$item_data[$j]['sgst_amt']."', '".$item_data[$j]['igst_amt']."', '".$item_data[$j]['tax_amt']."', '".$item_data[$j]['total_amt']."', '".$item_data[$j]['margin_per']."', '".$item_data[$j]['promo_margin']."', '".$item_data[$j]['tax_percentage']."', '182', '".$item_data[$j]['qty']."')";
              //     // $conn->query($sql);
              //   }

              //   $sql = "insert into user_access_log (user_id, module_name, controller_name, action, table_id, date) VALUES ('" . $curusr . "', 'Distributor_Out', 'Distributor_Out', 'System Generated Sales Entry created successfully.', '".$distributor_out_id."', '".$now."')";
              //   // $conn->query($sql);

              //   echo 'System Generated Sales Entry created successfully.<br/><br/>';
              // } else {
              //   echo "Error: " . $sql . "<br>" . $conn->error;
              // }



              // echo $sql;
              // echo '<br/><br/>';
              // echo json_encode($item_data);
              // echo '<br/><br/>';
              // echo 'System Generated Sales Entry created successfully.<br/><br/>';
            // } else {
            //   echo 'Invoice amount is zero.<br/><br/>';
            // }
            
          } catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
          }
        }

        // echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
      } catch (MarketplaceWebServiceOrders_Exception $ex) {
        echo("Caught Exception: " . $ex->getMessage() . "\n");
        echo("Response Status Code: " . $ex->getStatusCode() . "\n");
        echo("Error Code: " . $ex->getErrorCode() . "\n");
        echo("Error Type: " . $ex->getErrorType() . "\n");
        echo("Request ID: " . $ex->getRequestId() . "\n");
        echo("XML: " . $ex->getXML() . "\n");
        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
      }
  }

  function invokeListOrderItems(MarketplaceWebServiceOrders_Interface $service, $request)
  {
      try {

        $response = $service->ListOrderItems($request);

        $xml = simplexml_load_string($response->toXML());

        return $xml;

        // echo ("Service Response\n");
        // echo ("=============================================================================\n");

        // $dom = new DOMDocument();
        // $dom->loadXML($response->toXML());
        // $dom->preserveWhiteSpace = false;
        // $dom->formatOutput = true;
        // echo $dom->saveXML();
        // echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

     } catch (MarketplaceWebServiceOrders_Exception $ex) {
        // echo("Caught Exception: " . $ex->getMessage() . "\n");
        // echo("Response Status Code: " . $ex->getStatusCode() . "\n");
        // echo("Error Code: " . $ex->getErrorCode() . "\n");
        // echo("Error Type: " . $ex->getErrorType() . "\n");
        // echo("Request ID: " . $ex->getRequestId() . "\n");
        // echo("XML: " . $ex->getXML() . "\n");
        // echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
     }
  }

  function invokeGetReportList(MarketplaceWebService_Interface $service2, $request) 
  {
      try {
              $response = $service2->getReportList($request);
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

  function invokeGetReport(MarketplaceWebService_Interface $service2, $request) 
  {
      try {
              $response = $service2->getReport($request);

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

              //     $sql = "select * from distributor_in where order_no='".$order_no."' or remarks like '%".$order_no."%'";
              //     $result = $conn->query($sql);
              //     if ($result->num_rows > 0) {
              //       $row_arr = $result->fetch_all(MYSQLI_ASSOC);
              //       if(count($row_arr)>0) {
              //         $result->free();
              //         echo 'order_no '.$order_no.' already exist.<br/><br/>';
              //         continue;
              //       }
              //     }

              //     $return_date = $order_data[$i]['return_date'];
              //     $date = new DateTime($return_date, new DateTimeZone('UTC'));
              //     $return_date = $date->format('Y-m-d');

              //     $sku_data = $order_data[$i]['sku_data'];

              //     $discount = 0;
              //     $distributor_out_id = 0;
              //     $invoice_no = '';
              //     $tax_type = 'Intra';
              //     $sql = "select * from distributor_out where order_no='".$order_no."'";
              //     $result = $conn->query($sql);
              //     if ($result->num_rows > 0) {
              //       $row_arr = $result->fetch_all(MYSQLI_ASSOC);
              //       if(count($row_arr)>0) {
              //         if(isset($row_arr[0]['discount'])) {
              //           $discount = $row_arr[0]['discount'];
              //         }
              //         if(isset($row_arr[0]['id'])) {
              //           $distributor_out_id = $row_arr[0]['id'];
              //         }
              //         if(isset($row_arr[0]['invoice_no'])) {
              //           $invoice_no = $row_arr[0]['invoice_no'];
              //         }
              //         if(isset($row_arr[0]['state'])) {
              //           if(strtoupper(trim($row_arr[0]['state']))!='MAHARASHTRA'){
              //             $tax_type = 'Inter';
              //           }
              //         }
              //       }
              //     }

              //     $tot_amount = 0;
              //     $tot_cgst_amount = 0;
              //     $tot_sgst_amount = 0;
              //     $tot_igst_amount = 0;
              //     $tot_tax_amount = 0;
              //     $tot_order_amount = 0;
              //     $final_cost_amount = 0;

              //     $item_data = array();

              //     echo print_r($sku_data);
              //     echo '<br/><br/>';

              //     echo count($sku_data);
              //     echo '<br/><br/>';

              //     echo $sku_data[0]['asin'];
              //     echo '<br/><br/>';

              //     for($k=0; $k<count($sku_data); $k++) {
              //       $asin = $sku_data[$k]['asin'];
              //       $qty = $sku_data[$k]['qty'];

              //       $item_id = 0;
              //       $item_grams = 0;
              //       $rate = 0;
              //       $cost = 0;
              //       $tax_per = 0;

              //       $sql = "select * from box_master where asin ='".$asin."'";
              //       $result = $conn->query($sql);
              //       if ($result->num_rows > 0) {
              //         $row_arr = $result->fetch_all(MYSQLI_ASSOC);

              //         if(count($row_arr)>0) {
              //           if(isset($row_arr[0]['id'])) {
              //             $item_id = $row_arr[0]['id'];
              //           }
              //           if(isset($row_arr[0]['grams'])) {
              //             $item_grams = $row_arr[0]['grams'];
              //           }
              //           if(isset($row_arr[0]['rate'])) {
              //             $rate = $row_arr[0]['rate'];
              //           }
              //           if(isset($row_arr[0]['cost'])) {
              //             $cost = $row_arr[0]['cost'];
              //           }
              //           if(isset($row_arr[0]['tax_percentage'])) {
              //             $tax_per = $row_arr[0]['tax_percentage'];
              //           }
              //         }
              //         $result->free();
              //       }

              //       $batch_no = 0;
              //       $sql = "select * from distributor_out_items where distributor_out_id ='".$distributor_out_id."' and 
              //               type='Box' and item_id = '".$item_id."'";
              //       $result = $conn->query($sql);
              //       if ($result->num_rows > 0) {
              //         $row_arr = $result->fetch_all(MYSQLI_ASSOC);

              //         if(count($row_arr)>0) {
              //           if(isset($row_arr[0]['batch_no'])) {
              //             $batch_no = $row_arr[0]['batch_no'];
              //           }
              //         }
              //       }

              //       $sell_rate = $rate - (($rate*$discount)/100);
              //       if($tax_per!=0){
              //         $sell_rate = $sell_rate/(100+$tax_per)*100;
              //       }
                    
              //       if($tax_type=='Intra'){
              //         $cgst=$tax_per/2;
              //         $sgst=$tax_per/2;
              //         $igst=0;
              //       } else {
              //         $cgst=0;
              //         $sgst=0;
              //         $igst=$tax_per;
              //       }
                    
              //       $cgst_amt = round($qty*(($sell_rate*$cgst)/100),2);
              //       $sgst_amt = round($qty*(($sell_rate*$sgst)/100),2);
              //       $igst_amt = round($qty*(($sell_rate*$igst)/100),2);
              //       // $tax_amt = round($qty*(($sell_rate*$tax_per)/100),2);
              //       $tax_amt = $cgst_amt+$sgst_amt+$igst_amt;
                    
              //       $amount = round(($qty*$sell_rate),2);
              //       $total_amt = round((round($amount,2) + round($tax_amt,2)),2);
              //       $cost_amount = round(($qty*$cost),2);

              //       $tot_amount = $tot_amount + $amount;
              //       $tot_tax_amount = $tot_tax_amount + $tax_amt;
              //       $tot_order_amount = $tot_order_amount + $total_amt;

              //       $final_cost_amount = $final_cost_amount + $cost_amount;

              //       $tot_cgst_amount = $tot_cgst_amount + $cgst_amt;
              //       $tot_sgst_amount = $tot_sgst_amount + $sgst_amt;
              //       $tot_igst_amount = $tot_igst_amount + $igst_amt;

              //       $item_data[$k] = array(
              //                         'distributor_in_id' => 0,
              //                         'type' => 'Box',
              //                         'item_id' => $item_id,
              //                         'qty' => $qty,
              //                         'sell_rate' => $sell_rate,
              //                         'grams' => $item_grams,
              //                         'rate' => $rate,
              //                         'amount' => $amount,
              //                         'cost_rate' => $cost,
              //                         'cost_amount' => $cost_amount,
              //                         'cgst_amt' => $cgst_amt,
              //                         'sgst_amt' => $sgst_amt,
              //                         'igst_amt' => $igst_amt,
              //                         'tax_amt' => $tax_amt,
              //                         'total_amt' => $total_amt,
              //                         'batch_no' =>$batch_no,
              //                         'margin_per' => 0,
              //                         'promo_margin' => 0,
              //                         'tax_percentage' => $tax_per
              //                     );
              //     }

              //     $depot_id = '3';
              //     $distributor_id = '214';

              //     $round_off_amt = round(round($tot_order_amount,0) - round($tot_order_amount,2),2);
              //     $final_amount = round($tot_order_amount,0);

              //     if($final_amount>0){
              //         $sql = "insert into distributor_in (date_of_processing, depot_id, distributor_id, sales_rep_id, amount, tax, cst, tax_amount, final_amount, due_date, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, is_expired, is_exchanged, final_cost_amount, ref_id, sales_return_no, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, freezed, round_off_amount, sales_type, invoice_nos, modified_approved_date, discount, order_no) VALUES ('".$curdate."', '".$depot_id."', '".$distributor_id."', Null, ".$tot_amount.", Null, 1, ".$tot_tax_amount.", ".$tot_order_amount.", '".$curdate."', 'Pending', 'This is system generated entry.', '".$curusr."', '".$now."', '".$curusr."', '".$now."', Null, Null, Null, Null, 'no', 'no', ".$final_cost_amount.", Null, Null, 1, 1, 1, ".$tot_cgst_amount.", ".$tot_sgst_amount.", ".$tot_igst_amount.", 0, ".$round_off_amt.", 'Invoice', '".$invoice_no."', Null, ".$discount.", '".$order_no."')";
              //         echo $sql.'<br/><br/>';
              //         echo json_encode($item_data);
              //         echo '<br/><br/>';
              //         if ($conn->query($sql) === TRUE) {
              //           $distributor_in_id = $conn->insert_id;

              //           for($j=0; $j<count($item_data); $j++) {
              //             // sleep(2);

              //             $sql = "insert into distributor_in_items (distributor_in_id, type, item_id, qty, sell_rate, grams, rate, amount, cost_rate, cost_amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, batch_no, margin_per, tax_percentage, promo_margin) VALUES ('".$distributor_in_id."', '".$item_data[$j]['type']."', '".$item_data[$j]['item_id']."', '".$item_data[$j]['qty']."', '".$item_data[$j]['sell_rate']."', '".$item_data[$j]['grams']."', '".$item_data[$j]['rate']."', '".$item_data[$j]['amount']."', '".$item_data[$j]['cost_rate']."', '".$item_data[$j]['cost_amount']."', '".$item_data[$j]['cgst_amt']."', '".$item_data[$j]['sgst_amt']."', '".$item_data[$j]['igst_amt']."', '".$item_data[$j]['tax_amt']."', '".$item_data[$j]['total_amt']."', '".$item_data[$j]['batch_no']."', '".$item_data[$j]['margin_per']."', '".$item_data[$j]['tax_percentage']."', '".$item_data[$j]['promo_margin']."')";
              //             $conn->query($sql);
              //             echo $sql.'<br/><br/>';
              //           }

              //           $sql = "insert into user_access_log (user_id, module_name, controller_name, action, table_id, date) VALUES ('" . $curusr . "', 'Distributor_In', 'Distributor_In', 'System Generated Sales Return Entry created successfully.', '".$distributor_in_id."', '".$now."')";
              //           $conn->query($sql);

              //           echo 'System Generated Sales Return Entry created successfully.<br/><br/>';
              //         } else {
              //           echo "Error: " . $sql . "<br>" . $conn->error;
              //         }
              //     } else {
              //       echo 'Sales Return amount is zero.<br/><br/>';
              //     }
              // }

              return $order_data;

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

  // function send_exception_mail()
  // {
  //   $mail = new PHPMailer;
  //   $mail->isSMTP();
  //   $mail->Host = 'mail.eatanytime.co.in';  // Specify main and backup SMTP servers
  //   $mail->SMTPAuth = true;                               // Enable SMTP authentication
  //   $mail->Username = 'cs@eatanytime.co.in';                 // SMTP username
  //   $mail->Password = 'Customer@12345';                           // SMTP password
  //   $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
  //   $mail->Port = 587;                                    // TCP port to connect to

  //   $mail->setFrom('cs@eatanytime.co.in', 'EAT ERP');
  //   $mail->addAddress('cs@eatanytime.co.in', 'EAT ERP');     // Add a recipient $mail->addAddress('ellen@example.com');               // Name is optional
  //   $mail->addReplyTo('cs@eatanytime.co.in');
  //   // $mail->addCC('cc@example.com');
  //   // $mail->addBCC('bcc@example.com');


  //   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
  //   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
  //   $mail->isHTML(true);                                  // Set email format to HTML

  //   $mail->Subject = 'Here is the subject';
  //    $mail->Subject = 'Enquiry From Website';
  //       $mail->Body    = 'Hi,<br><br>Please find below the details of enquiry<br><br>Name: '.$name.'<br>Email: '.$email.'<br>Mobile no: '.$mob.'<br>Comments: '.$comments.'<br><br>Regards,<br>Team Eatanytime';

  //   if(!$mail->send()) {
  //       echo 'Message could not be sent.';
  //       echo 'Mailer Error: ' . $mail->ErrorInfo;
  //   } else {
  //     echo true;
        
  //   }
  // }