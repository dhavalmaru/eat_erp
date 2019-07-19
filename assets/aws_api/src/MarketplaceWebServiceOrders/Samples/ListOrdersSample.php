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

 $request->setLastUpdatedAfter("2019-07-18T18:30:00Z");

 $request2 = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
 $request2->setSellerId(MERCHANT_ID);
 // $request2->setAmazonOrderId("408-1055488-9217907");

 // object or array of parameters
 invokeListOrders($service, $request, $request2);

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
        // // echo $dom->saveXML();

        // // $conn = mysqli_connect("localhost", "root", "", "phpsamples");

        // $affectedRow = 0;

        $xml = simplexml_load_string($response->toXML());

        $ListOrdersResult = $xml->ListOrdersResult;
        $Orders = $ListOrdersResult->Orders;
        $Order = $Orders->Order;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "eat_erp";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        for($i=0; $i<count($Order); $i++) {
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

          // $AmazonOrderId = $row->AmazonOrderId;
          // $PurchaseDate = $row->PurchaseDate;
          // $date = new DateTime($PurchaseDate, new DateTimeZone('UTC'));
          // $date_of_processing = $date->format('Y-m-d H:i:s');
          // $OrderTotal = $row->OrderTotal;
          // $OrderAmt = $OrderTotal[0]->Amount;

          // $ShippingAddress = $row->ShippingAddress;

          // $client_name = '';
          // $address = '';
          // $city = '';
          // $pincode = '';
          // $state = 'Maharashtra';
          // $country = 'India';
          // if(count($ShippingAddress)>0) {
          //   $client_name = $conn->real_escape_string($ShippingAddress[0]->Name);
          //   $address = $conn->real_escape_string($ShippingAddress[0]->AddressLine1).' '.$conn->real_escape_string($ShippingAddress[0]->AddressLine2);
          //   $city = $conn->real_escape_string($ShippingAddress[0]->City);
          //   $pincode = $conn->real_escape_string($ShippingAddress[0]->StateOrRegion);
          //   $state = $conn->real_escape_string($ShippingAddress[0]->PostalCode);
          //   $CountryCode = $conn->real_escape_string($ShippingAddress[0]->CountryCode);
          //   $sql = "select * from country_master where country_code='".$CountryCode."'";
          //   $result = $conn->query($sql);
          //   if ($result->num_rows > 0) {
          //     $row = $result->fetch_all(MYSQLI_ASSOC);
          //     echo json_encode($row);
          //     // if()
          //     // $country = $row[0]->country_name;
          //     // $result->free();
          //   }
          // }

          // $request2->setAmazonOrderId($AmazonOrderId);
          // $xml2=invokeListOrderItems($service, $request2);
          // $ListOrderItemsResult = $xml2->ListOrderItemsResult;
          // $OrderItems = $ListOrderItemsResult->OrderItems;
          // $OrderItem = $OrderItems->OrderItem;
          // for($j=0; $j<count($OrderItem); $j++) {
          //   $row2 = $OrderItem[$j];
          //   $ASIN = $conn->real_escape_string($row2->ASIN);
          //   $Title = $conn->real_escape_string($row2->Title);
          //   $QuantityOrdered = $conn->real_escape_string($row2->QuantityOrdered);
          //   $QuantityShipped = $conn->real_escape_string($row2->QuantityShipped);
          //   $ItemPrice = $row2->ItemPrice;
          //   $ItemAmt = $conn->real_escape_string($ItemPrice[0]->Amount);
          //   $PromotionDiscount = $row2->PromotionDiscount;
          //   $PromotionAmt = $conn->real_escape_string($PromotionDiscount[0]->Amount);

          //   $total_amt = $ItemAmt - $PromotionAmt;
            

          //   $item_id = 'Null';
          //   $item_grams = 'Null';
          //   $item_rate = 0;
          //   $item_tax_per = 0;

          //   $sql = "select * from box_master where asin ='".$ASIN."'";
          //   $result = $conn->query($sql);
          //   if ($result->num_rows > 0) {
          //     $row = $result->fetch_all(MYSQLI_ASSOC);
          //     $item_id = $row[0]->id;
          //     $item_grams = $row[0]->grams;
          //     $item_rate = $row[0]->rate;
          //     $item_tax_per = $row[0]->tax_percentage;
          //     $result->free();
          //   }

          //   $sql = "select * from box_master where asin = '$ASIN'";
          //   $result = $this->db->query($sql)->result();
          //   if(count($result)>0) {
          //     $item_id = $result[0]->id;
          //     $item_grams = $result[0]->grams;
          //     $item_rate = $result[0]->rate;
          //     $item_tax_per = $result[0]->tax_percentage;
          //   }



          //   echo $ASIN.' '.$Title.' '.$QuantityOrdered.' '.$QuantityShipped.' '.$ItemAmt.' '.$PromotionAmt;
          //   echo '<br/>';
          // }




          // $OrderTotal = $row->OrderTotal;
          // $OrderAmt = 0;
          // if(count($OrderTotal)>0) {
          //   if(isset($OrderTotal[0]->Amount)) {
          //     if(is_numeric($OrderTotal[0]->Amount)) {
          //       $OrderAmt = $OrderTotal[0]->Amount;
          //     }
          //   }
          // }
          


          // $depot_id = '3';
          // $distributor_id = '214';
          // $sales_rep_id = 'Null';
          // $amount




          // $sql = "insert into distributor_out (date_of_processing, invoice_no, depot_id, distributor_id, sales_rep_id, amount, tax, tax_per, tax_amount, final_amount, due_date, order_no, order_date, supplier_ref, despatch_doc_no, despatch_through, destination, status, remarks, modified_by, modified_on, client_name, address, city, pincode, state, country, mobile_no, discount, sample_distributor_id, delivery_status, delivery_date, transport_type, vehicle_number, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, reverse_charge, shipping_address, distributor_consignee_id, con_name, con_address, con_city, con_pincode, con_state, con_country, con_state_code, con_gst_number, state_code, round_off_amount, invoice_amount, ref_id, invoice_date, email_date_time, basis_of_sales, email_from, email_approved_by, gstin, created_by, created_on) VALUES ('" . $title . "','" . $link . "','" . $description . "','" . $keywords . "')";
            
          //   $result = mysqli_query($conn, $sql);
            
          //   if (! empty($result)) {
          //       $affectedRow ++;
          //   } else {
          //       $error_message = mysqli_error($conn) . "\n";
          //   }

          

          // $request2->setAmazonOrderId($AmazonOrderId);
          // $xml2=invokeListOrderItems($service, $request2);
          // $ListOrderItemsResult = $xml2->ListOrderItemsResult;
          // $OrderItems = $ListOrderItemsResult->OrderItems;
          // $OrderItem = $OrderItems->OrderItem;
          // // echo json_encode($OrderItem);
          // // echo '<br/><br/>';
          // for($j=0; $j<count($OrderItem); $j++) {
          //   $row2 = $OrderItem[$j];
          //   $ASIN = $row2->ASIN;
          //   $Title = $row2->Title;
          //   $QuantityOrdered = $row2->QuantityOrdered;
          //   $QuantityShipped = $row2->QuantityShipped;
          //   $ItemPrice = $row2->ItemPrice;
          //   $ItemAmt = $ItemPrice[0]->Amount;
          //   $PromotionDiscount = $row2->PromotionDiscount;
          //   $PromotionAmt = $PromotionDiscount[0]->Amount;
          //   echo $ASIN.' '.$Title.' '.$QuantityOrdered.' '.$QuantityShipped.' '.$ItemAmt.' '.$PromotionAmt;
          //   echo '<br/>';
          // }
          // echo '<br/>';

          // echo json_encode($ShippingAddress);
          // break;

          // $ShippingAddress = $order[$i]->ShippingAddress;
          // echo $ShippingAddress['Name'];
          // echo '<br/><br/>';
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