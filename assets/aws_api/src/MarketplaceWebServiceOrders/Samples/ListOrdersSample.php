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
// require_once('E:/wamp64/www/eat_erp/application/models/Distributor_out_model.php');
// require_once('../../../../../application/models/Distributor_out_model.php');

// $distributor_out_model = new Distributor_out_model;

// require_once('E:/wamp64/www/eat_erp/index.php');

// define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

// $application_folder = 'E:/wamp64/www/eat_erp/application';
// $system_path = 'E:/wamp64/www/eat_erp/system';
// if (($_temp = realpath($system_path)) !== FALSE)
// {
//   $system_path = $_temp.'/';
// }
// else
// {
//   // Ensure there's a trailing slash
//   $system_path = rtrim($system_path, '/').'/';
// }
// define('BASEPATH', str_replace('\\', '/', $system_path));
// define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

// if (is_dir($application_folder))
// {
//   if (($_temp = realpath($application_folder)) !== FALSE)
//   {
//     $application_folder = $_temp;
//   }

//   define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);
// }
// else
// {
//   if ( ! is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
//   {
//     header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
//     echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
//     exit(3); // EXIT_CONFIG
//   }

//   define('APPPATH', BASEPATH.$application_folder.DIRECTORY_SEPARATOR);
// }

// $view_folder = '';
// if ( ! is_dir($view_folder))
// {
//   if ( ! empty($view_folder) && is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
//   {
//     $view_folder = APPPATH.$view_folder;
//   }
//   elseif ( ! is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
//   {
//     header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
//     echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
//     exit(3); // EXIT_CONFIG
//   }
//   else
//   {
//     $view_folder = APPPATH.'views';
//   }
// }

// if (($_temp = realpath($view_folder)) !== FALSE)
// {
//   $view_folder = $_temp.DIRECTORY_SEPARATOR;
// }
// else
// {
//   $view_folder = rtrim($view_folder, '/\\').DIRECTORY_SEPARATOR;
// }

// define('VIEWPATH', $view_folder);

// require_once BASEPATH.'core/CodeIgniter.php';

// require_once('../../../../../system/core/CodeIgniter.php');
// require_once('E:/wamp64/www/eat_erp/system/core/CodeIgniter.php');
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
// 1hr = 3600 sec

// $request->setSellerOrderId("408-5824084-9615543");


$date = date('Y-m-d');
$time = date('H:i:s', time() - 5400);
echo "Time: ".$date."T".$time."Z<br/><br/>";
$request->setLastUpdatedAfter($date."T".$time."Z");
invokeListOrders($service, $request, $request2);

sleep(3);

$date = date('Y-m-d');
$time = date('H:i:s', time() - 32400);
echo "Time: ".$date."T".$time."Z<br/><br/>";
$request->setLastUpdatedAfter($date."T".$time."Z");
invokeListOrders($service, $request, $request2);

sleep(3);

$date = date('Y-m-d');
$time = date('H:i:s', time() - 44100);
echo "Time: ".$date."T".$time."Z<br/><br/>";
$request->setLastUpdatedAfter($date."T".$time."Z");
invokeListOrders($service, $request, $request2);

sleep(3);

$date = date('Y-m-d', strtotime('-1 days'));
$time = date('H:i:s', time() - 23400);
echo "Time: ".$date."T".$time."Z<br/><br/>";
$request->setLastUpdatedAfter($date."T".$time."Z");
invokeListOrders($service, $request, $request2);

sleep(3);

$date = date('Y-m-d', strtotime('-1 days'));
$time = date('H:i:s', time() - 44100);
echo "Time: ".$date."T".$time."Z<br/><br/>";
$request->setLastUpdatedAfter($date."T".$time."Z");
invokeListOrders($service, $request, $request2);

sleep(3);

$date = date('Y-m-d', strtotime('-2 days'));
$time = date('H:i:s', time() - 23400);
echo "Time: ".$date."T".$time."Z<br/><br/>";
$request->setLastUpdatedAfter($date."T".$time."Z");
invokeListOrders($service, $request, $request2);

sleep(3);

$date = date('Y-m-d', strtotime('-2 days'));
$time = date('H:i:s', time() - 44100);
echo "Time: ".$date."T".$time."Z<br/><br/>";
$request->setLastUpdatedAfter($date."T".$time."Z");
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

            $AmazonOrderId = $row->AmazonOrderId;
            $OrderStatus = $row->OrderStatus;
            $FulfillmentChannel = $row->FulfillmentChannel;

            // if($AmazonOrderId!='408-3029702-8198761'){
            //   continue;
            // }

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

            $sales_rep_id = 104;

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
              } else {
                $sql = "select A.pincode, B.state_name, B.state_code 
                        from pincode_master A left join state_master B on(A.state_id=B.id) 
                        where A.pincode='".$pincode."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                  if(count($row_arr)>0) {
                    if(isset($row_arr[0]['state_name'])) {
                      $state = $row_arr[0]['state_name'];
                    }
                    if(isset($row_arr[0]['state_code'])) {
                      $state_code = $row_arr[0]['state_code'];
                    }
                  }
                  $result->free();
                }
              }
            }

            sleep(3);

            $total_order_amt = 0;
            $item_data = array();
            $order_data = array();
          
            $request2->setAmazonOrderId($AmazonOrderId);
            $xml2=invokeListOrderItems($service, $request2);
            $ListOrderItemsResult = $xml2->ListOrderItemsResult;
            $OrderItems = $ListOrderItemsResult->OrderItems;
            $OrderItem = $OrderItems->OrderItem;
            for($j=0; $j<count($OrderItem); $j++) {
              $row2 = $OrderItem[$j];

              // echo json_encode($row2);
              // echo '<br/><br/>';

              $ASIN = '';
              $OrderItemId = '';
              $Title = '';
              $QuantityOrdered = 0;
              $QuantityShipped = 0;
              $ItemPrice = array();
              $ItemAmt = 0;
              $PromotionDiscount = array();
              $PromotionAmt = 0;
              $a = 0;

              if(count($row2)>0) {
                if(isset($row2[0]->ASIN)) {
                  $ASIN = $conn->real_escape_string($row2[0]->ASIN);
                }
                if(isset($row2[0]->OrderItemId)) {
                  $OrderItemId = $conn->real_escape_string($row2[0]->OrderItemId);
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
              

              $fc_id = '';
              $depot_state = '';
              $depot_id = '';

              if(strtoupper(trim($FulfillmentChannel))=='AFN') {
                $sql = "select * from fc_details where order_id='".$AmazonOrderId."' and order_item_id='".$OrderItemId."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                  if(count($row_arr)>0) {
                    if(isset($row_arr[0]['fc_id'])) {
                      $fc_id = strtoupper(trim($row_arr[0]['fc_id']));
                    }
                  } else {
                    $result->free();
                    echo 'Order No '.$AmazonOrderId.' & Order Item Id '.$OrderItemId.' fulfillment details not found.<br/><br/>';
                    continue;
                  }
                }

                $sql = "select * from depot_master where depot_fc_id='".$fc_id."'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                  if(count($row_arr)>0) {
                    if(isset($row_arr[0]['state'])) {
                      $depot_state = strtoupper(trim($row_arr[0]['state']));
                      $depot_id = $row_arr[0]['id'];
                    }
                  } else {
                    $result->free();
                    echo 'Order No '.$AmazonOrderId.' & Order Item Id '.$OrderItemId.' depot state not found.<br/><br/>';
                    continue;
                  }
                }

                if($fc_id=='') {
                  echo 'Order No '.$AmazonOrderId.' & Order Item Id '.$OrderItemId.' fulfillment details not found.<br/><br/>';
                  continue;
                }
                if($depot_id=='') {
                  echo 'Order No '.$AmazonOrderId.' & Order Item Id '.$OrderItemId.' depot state not found.<br/><br/>';
                  continue;
                }
              } else {
                $depot_state = 'MAHARASHTRA';
                $depot_id = '2';
              }

              $tax_type = 'Intra';
              if(strtoupper(trim($state))!=strtoupper(trim($depot_state))) {
                $tax_type = 'Inter';
              }

              if(strtoupper(trim($FulfillmentChannel))=='MFN'){
                $qty = $QuantityOrdered;
              } else {
                $qty = $QuantityShipped;
              }
              
              $item_id = 0;
              $item_qty = 0;
              $item_grams = 0;
              $item_rate = 0;
              $item_tax_per = 0;

              $sql = "select * from combo_box_master where asin ='".$ASIN."'";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                $row_arr = $result->fetch_all(MYSQLI_ASSOC);

                // echo json_encode($row_arr);
                // echo '<br/><br/>';

                $combo_box_id = 0;
                if(count($row_arr)>0) {
                  $combo_box_id = $row_arr[0]['id'];

                  $sql = "select A.item_id, A.qty as item_qty, 
                        case when A.type='Bar' then B.product_name else C.box_name end as item_name, 
                        case when A.type='Bar' then B.grams else C.grams end as item_grams, 
                        case when A.type='Bar' then B.rate else C.rate end as item_rate, 
                        case when A.type='Bar' then B.tax_percentage else C.tax_percentage end as item_tax_per from 
                        (select * from combo_box_items where combo_box_id = '$combo_box_id') A 
                        left join 
                        (select * from product_master) B 
                        on (A.type='Bar' and A.item_id=B.id) 
                        left join 
                        (select * from box_master) C 
                        on (A.type='Box' and A.item_id=C.id)";
                  $result2 = $conn->query($sql);
                  if ($result2->num_rows > 0) {
                    $row_arr2 = $result2->fetch_all(MYSQLI_ASSOC);

                    // echo json_encode($row_arr2);
                    // echo '<br/><br/>';

                    $item_id = 0;
                    $item_qty = 0;
                    $item_grams = 0;
                    $item_rate = 0;
                    $item_tax_per = 0;

                    if(count($row_arr2)>0) {
                      if(isset($row_arr2[0]['item_id'])) {
                        $item_id = $row_arr2[0]['item_id'];
                      }
                      if(isset($row_arr2[0]['item_qty'])) {
                        $item_qty = $row_arr2[0]['item_qty'];
                      }
                      if(isset($row_arr2[0]['item_grams'])) {
                        $item_grams = $row_arr2[0]['item_grams'];
                      }
                      if(isset($row_arr2[0]['item_rate'])) {
                        $item_rate = $row_arr2[0]['item_rate'];
                      }
                      if(isset($row_arr2[0]['item_tax_per'])) {
                        $item_tax_per = $row_arr2[0]['item_tax_per'];
                      }
                    }

                    $item_qty = $item_qty * $qty;

                    $total_amt = ($item_qty*$item_rate);

                    $total_order_amt = $total_order_amt + $total_amt;

                    $item_data[$a++] = array(
                                    'distributor_out_id' => 0,
                                    'type' => 'Box',
                                    'item_id' => $item_id,
                                    'qty' => $item_qty,
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
                                    'tax_percentage' => $item_tax_per,
                                    'fc_id' => $fc_id,
                                    'depot_state' => $depot_state,
                                    'depot_id' => $depot_id,
                                    'tax_type' => $tax_type,
                                    'combo_box_id' => $combo_box_id
                                );

                    $result2->free();
                  }
                }

                $result->free();
              } else {
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
              }

              $total_amt = $ItemAmt - $PromotionAmt;

              $total_order_amt = $total_order_amt + ($qty*$item_rate);

              $item_data[$a++] = array(
                              'distributor_out_id' => 0,
                              'type' => 'Box',
                              'item_id' => $item_id,
                              'qty' => $qty,
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
                              'tax_percentage' => $item_tax_per,
                              'fc_id' => $fc_id,
                              'depot_state' => $depot_state,
                              'depot_id' => $depot_id,
                              'tax_type' => $tax_type,
                              'combo_box_id' => 0
                          );
            }

            // echo json_encode($item_data);
            // echo '<br/><br/>';

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
            // echo 'discount_per: '.$discount_per;
            // echo '<br/><br/><br/>';

            $status = 'Approved';
            $tot_amount = 0;
            $tot_cgst_amount = 0;
            $tot_sgst_amount = 0;
            $tot_igst_amount = 0;
            $tot_tax_amount = 0;
            $tot_order_amount = 0;
            $k = 0;

            $order_item_data = array();

            for($j=0; $j<count($item_data); $j++) {
              // echo json_encode($item_data[$j]);
              // echo '<br/><br/>';

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
              $fc_id = $item_data[$j]['fc_id'];
              $depot_state = $item_data[$j]['depot_state'];
              $depot_id = $item_data[$j]['depot_id'];
              $tax_type = $item_data[$j]['tax_type'];
              $combo_box_id = $item_data[$j]['combo_box_id'];

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

              // $tot_amount = $tot_amount + $amount;
              // $tot_tax_amount = $tot_tax_amount + $tax_amt;
              // $tot_order_amount = $tot_order_amount + $total_amt;

              // $tot_cgst_amount = $tot_cgst_amount + $cgst_amt;
              // $tot_sgst_amount = $tot_sgst_amount + $sgst_amt;
              // $tot_igst_amount = $tot_igst_amount + $igst_amt;

              $l=$j;

              $bl_flag = false;
              for($k=0; $k<count($order_data); $k++) {
                if($order_data[$k]['fc_id']==$fc_id) {
                  $bl_flag = true;

                  $k = $k;
                  $order_item_data = array();
                  $order_item_data = $order_data[$k]['item_data'];
                  $l = count($order_item_data);

                  $order_data[$k]['amount'] = $order_data[$k]['amount'] + $amount;
                  $order_data[$k]['tax_amount'] = $order_data[$k]['tax_amount'] + $tax_amt;
                  $order_data[$k]['final_amount'] = $order_data[$k]['final_amount'] + $total_amt;

                  $order_data[$k]['cgst_amount'] = $order_data[$k]['cgst_amount'] + $cgst_amt;
                  $order_data[$k]['sgst_amount'] = $order_data[$k]['sgst_amount'] + $sgst_amt;
                  $order_data[$k]['igst_amount'] = $order_data[$k]['igst_amount'] + $igst_amt;

                  break;
                }
              }

              if($bl_flag==false) {
                $k = count($order_data);
                $order_item_data = array();
                $l = 0;

                // echo $k;
                // echo '<br/><br/>';
                // echo $AmazonOrderId;
                // echo '<br/><br/>';

                if($k==0) {
                  $order_data[$k]['order_no'] = $AmazonOrderId;
                } else {
                  $order_data[$k]['order_no'] = $AmazonOrderId.'$'.$k;
                }
                
                $order_data[$k]['amount'] = $amount;
                $order_data[$k]['tax_amount'] = $tax_amt;
                $order_data[$k]['final_amount'] = $total_amt;

                $order_data[$k]['cgst_amount'] = $cgst_amt;
                $order_data[$k]['sgst_amount'] = $sgst_amt;
                $order_data[$k]['igst_amount'] = $igst_amt;

                $order_data[$k]['fc_id']=$fc_id;
              }

              $order_item_data[$l] = array(
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
                              'tax_percentage' => $tax_per,
                              'fc_id' => $fc_id,
                              'depot_state' => $depot_state,
                              'depot_id' => $depot_id,
                              'tax_type' => $tax_type,
                              'combo_box_id' => $combo_box_id
                          );

              $tot_order_amount = $order_data[$k]['final_amount'];

              $distributor_id = '214';

              if(strtoupper(trim($FulfillmentChannel))=='MFN') {
                $depot_id = '2';

                // $round_off_amt = 0;
                // $invoice_amount = 0;
                // $delivery_status='Pending';
                // $delivery_date='Null';

                $round_off_amt = round(round($tot_order_amount,0) - round($tot_order_amount,2),2);
                $invoice_amount = round($tot_order_amount,0);
                $delivery_status = 'Delivered';
                $delivery_date = "'".$curdate."'";
              } else {
                if($depot_id==''){
                  $depot_id = '3';
                }
                
                $round_off_amt = round(round($tot_order_amount,0) - round($tot_order_amount,2),2);
                $invoice_amount = round($tot_order_amount,0);
                $delivery_status = 'Delivered';
                $delivery_date = "'".$curdate."'";
              }

              // $round_off_amt = round(round($tot_order_amount,0) - round($tot_order_amount,2),2);
              // $invoice_amount = round($tot_order_amount,0);
              // $delivery_status='Delivered';
              // $delivery_date="'".$curdate."'";

              if($item_id==0){
                $status = 'Pending';
              }

              $order_data[$k]['date_of_processing'] = $curdate;
              $order_data[$k]['invoice_no'] = '';
              $order_data[$k]['depot_id'] = $depot_id;
              $order_data[$k]['distributor_id'] = $distributor_id;
              $order_data[$k]['sales_rep_id'] = Null;
              // $order_data[$k]['amount'] = $tot_amount;
              $order_data[$k]['tax'] = Null;
              $order_data[$k]['tax_per'] = 1;
              // $order_data[$k]['tax_amount'] = $tot_tax_amount;
              // $order_data[$k]['final_amount'] = $tot_order_amount;
              $order_data[$k]['due_date'] = $curdate;
              $order_data[$k]['order_date'] = $order_date;
              $order_data[$k]['supplier_ref'] = Null;
              $order_data[$k]['despatch_doc_no'] = Null;
              $order_data[$k]['despatch_through'] = Null;
              $order_data[$k]['destination'] = Null;
              $order_data[$k]['status'] = $status;
              $order_data[$k]['remarks'] = 'This is system generated entry.';
              $order_data[$k]['modified_by'] = $curusr;
              $order_data[$k]['modified_on'] = $now;
              $order_data[$k]['client_name'] = $client_name;
              $order_data[$k]['address'] = $address;
              $order_data[$k]['city'] = $city;
              $order_data[$k]['pincode'] = $pincode;
              $order_data[$k]['state'] = $state;
              $order_data[$k]['country'] = $country;
              $order_data[$k]['mobile_no'] = $phone;
              $order_data[$k]['discount'] = $discount_per;
              $order_data[$k]['sample_distributor_id'] = Null;
              $order_data[$k]['date_of_dispatch'] = $curdate;
              $order_data[$k]['delivery_status'] = $delivery_status;
              $order_data[$k]['delivery_date'] = $delivery_date;
              $order_data[$k]['delivery_sales_rep_id'] = $sales_rep_id;
              $order_data[$k]['transport_type'] = '';
              $order_data[$k]['vehicle_number'] = '';
              $order_data[$k]['cgst'] = 1;
              $order_data[$k]['sgst'] = 1;
              $order_data[$k]['igst'] = 1;
              // $order_data[$k]['cgst_amount'] = $tot_cgst_amount;
              // $order_data[$k]['sgst_amount'] = $tot_sgst_amount;
              // $order_data[$k]['igst_amount'] = $tot_igst_amount;
              $order_data[$k]['reverse_charge'] = 'no';
              $order_data[$k]['shipping_address'] = 'yes';
              $order_data[$k]['distributor_consignee_id'] = Null;
              $order_data[$k]['con_name'] = Null;
              $order_data[$k]['con_address'] = Null;
              $order_data[$k]['con_city'] = Null;
              $order_data[$k]['con_pincode'] = Null;
              $order_data[$k]['con_state'] = Null;
              $order_data[$k]['con_country'] = Null;
              $order_data[$k]['con_state_code'] = Null;
              $order_data[$k]['con_gst_number'] = Null;
              $order_data[$k]['state_code'] = $state_code;
              $order_data[$k]['round_off_amount'] = $round_off_amt;
              $order_data[$k]['invoice_amount'] = $invoice_amount;
              $order_data[$k]['ref_id'] = Null;
              $order_data[$k]['invoice_date'] = Null;
              $order_data[$k]['email_date_time'] = $now;
              $order_data[$k]['basis_of_sales'] = 'PO Number';
              $order_data[$k]['email_from'] = '';
              $order_data[$k]['email_approved_by'] = '';
              $order_data[$k]['gstin'] = '';
              $order_data[$k]['created_by'] = $curusr;
              $order_data[$k]['created_on'] = $now;

              $order_data[$k]['fc_id'] = $fc_id;
              $order_data[$k]['depot_state'] = $depot_state;

              $order_data[$k]['item_data'] = $order_item_data;
            }

            echo json_encode($order_data);
            echo '<br/><br/>';

            for($k=0; $k<count($order_data); $k++) {
              $status = $order_data[$k]['status'];
              $depot_id = $order_data[$k]['depot_id'];
              $distributor_id = $order_data[$k]['distributor_id'];
              $tot_amount = $order_data[$k]['amount'];
              $tot_tax_amount = $order_data[$k]['tax_amount'];
              $tot_order_amount = $order_data[$k]['final_amount'];
              $AmazonOrderId = $order_data[$k]['order_no'];
              $discount_per = $order_data[$k]['discount'];
              $tot_cgst_amount = $order_data[$k]['cgst_amount'];
              $tot_sgst_amount = $order_data[$k]['sgst_amount'];
              $tot_igst_amount = $order_data[$k]['igst_amount'];
              $round_off_amt = $order_data[$k]['round_off_amount'];
              $invoice_amount = $order_data[$k]['invoice_amount'];

              $item_data = $order_data[$k]['item_data'];

              if(strtoupper(trim($FulfillmentChannel))=='MFN' || $invoice_amount>0){
                $sql = "insert into distributor_out (date_of_processing, invoice_no, depot_id, distributor_id, sales_rep_id, amount, tax, tax_per, tax_amount, final_amount, due_date, order_no, order_date, supplier_ref, despatch_doc_no, despatch_through, destination, status, remarks, modified_by, modified_on, client_name, address, city, pincode, state, country, mobile_no, discount, sample_distributor_id, date_of_dispatch, delivery_status, delivery_date, delivery_sales_rep_id, transport_type, vehicle_number, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, reverse_charge, shipping_address, distributor_consignee_id, con_name, con_address, con_city, con_pincode, con_state, con_country, con_state_code, con_gst_number, state_code, round_off_amount, invoice_amount, ref_id, invoice_date, email_date_time, basis_of_sales, email_from, email_approved_by, gstin, created_by, created_on) VALUES ('".$curdate."', '', '".$depot_id."', '".$distributor_id."', Null, ".$tot_amount.", Null, 1, ".$tot_tax_amount.", ".$tot_order_amount.", '".$curdate."', '".$AmazonOrderId."', '".$order_date."', Null, Null, Null, Null, '".$status."', 'This is system generated entry.', '".$curusr."', '".$now."', '".$client_name."', '".$address."', '".$city."', '".$pincode."', '".$state."', '".$country."', '".$phone."', ".$discount_per.", Null, '".$curdate."', '".$delivery_status."', ".$delivery_date.", '".$sales_rep_id."', '', '', 1, 1, 1, ".$tot_cgst_amount.", ".$tot_sgst_amount.", ".$tot_igst_amount.", 'no', 'yes', Null, Null, Null, Null, Null, Null, Null, Null, Null, '".$state_code."', ".$round_off_amt.", ".$invoice_amount.", Null, Null, '".$now."', 'PO Number', '', '', '', '".$curusr."', '".$now."')";
                if ($conn->query($sql) === TRUE) {
                  $distributor_out_id = $conn->insert_id;

                  for($j=0; $j<count($item_data); $j++) {
                    $sql = "insert into distributor_out_items (distributor_out_id, type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, margin_per, promo_margin, tax_percentage, batch_no, batch_qty) VALUES ('".$distributor_out_id."', '".$item_data[$j]['type']."', '".$item_data[$j]['item_id']."', '".$item_data[$j]['qty']."', '".$item_data[$j]['sell_rate']."', '".$item_data[$j]['grams']."', '".$item_data[$j]['rate']."', '".$item_data[$j]['amount']."', '".$item_data[$j]['cgst_amt']."', '".$item_data[$j]['sgst_amt']."', '".$item_data[$j]['igst_amt']."', '".$item_data[$j]['tax_amt']."', '".$item_data[$j]['total_amt']."', '".$item_data[$j]['margin_per']."', '".$item_data[$j]['promo_margin']."', '".$item_data[$j]['tax_percentage']."', '182', '".$item_data[$j]['qty']."')";
                    $conn->query($sql);
                  }

                  if($status=='Approved') {
                    // ob_start();
                    // $CI =& get_instance();
                    // $CI->load->model('Distributor_out_model');
                    // $CI->Distributor_out_model->approve_pending_sales_data($distributor_out_id);
                    // ob_clean();
                    // ob_flush();
                    // ob_end_flush();

                    approve_pending_sales_data($distributor_out_id, $conn);
                  }

                  $sql = "insert into user_access_log (user_id, module_name, controller_name, action, table_id, date) VALUES ('" . $curusr . "', 'Distributor_Out', 'Distributor_Out', 'System Generated Sales Entry created successfully.', '".$distributor_out_id."', '".$now."')";
                  $conn->query($sql);

                  echo 'System Generated Sales Entry created successfully.<br/><br/>';
                } else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }

                // echo $sql;
                // echo '<br/><br/>';
                // echo json_encode($item_data);
                // echo '<br/><br/>';
                // echo 'System Generated Sales Entry created successfully.<br/><br/>';
              } else {
                echo 'Invoice amount is zero.<br/><br/>';
              }
            }
            
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

  function get_series($type, $conn){
      $series = 0;

      $sql="select * from series_master where type='$type'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          $row_arr = $result->fetch_all(MYSQLI_ASSOC);
          if(count($row_arr)>0) {
              $series=intval($row_arr[0]['series'])+1;

              $sql="update series_master set series = '$series' where type = '$type'";
              $conn->query($sql);
          }
      }

      if($series==0){
          $series=1;

          $sql="insert into series_master (type, series) values ('$type', '$series')";
          $conn->query($sql);
      }

      return $series;
  }

  function approve_pending_sales_data($id, $conn){
      $invoice_no = '';
      $invoice_date = '';

      // Create connection
      $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);

      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      $sql="select * from distributor_out where id='$id'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          $row_arr = $result->fetch_all(MYSQLI_ASSOC);
          if(count($row_arr)>0) {
              $invoice_no = $row_arr[0]['invoice_no'];
              $invoice_date = $row_arr[0]['invoice_date'];
          }
      }

      if($invoice_no==null || $invoice_no==''){
          $series = get_series('Tax_Invoice', $conn);

          if($invoice_date==null || $invoice_date==''){
              $invoice_date = date('Y-m-d');
          }

          if (isset($invoice_date)){
              if($invoice_date==''){
                  $financial_year="";
              } else {
                  $financial_year=calculateFiscalYearForDate($invoice_date);
              }
          } else {
              $financial_year="";
          }
          
          $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);

          $sql = "Update distributor_out A 
                  Set A.invoice_no = '$invoice_no', A.invoice_date = '$invoice_date' 
                  Where A.id = '$id'";
          $conn->query($sql);

          // echo $invoice_no;
          // echo '<br/><br/>';
      }

      set_ledger($id, $conn);
      set_credit_note($id, $conn);
  }

  function update_ledger($id, $entry_type, $data, $conn) {
      $amount = 'Null';
      if(isset($data['amount'])){
          if($data['amount']!=''){
              $amount = $data['amount'];
          }
      }

      $sql = "update account_ledger_entries set ref_id='".$data['ref_id']."', ref_type='".$data['ref_type']."', entry_type='".$data['entry_type']."', invoice_no='".$data['invoice_no']."', vendor_id='".$data['vendor_id']."', acc_id='".$data['acc_id']."', ledger_name='".$data['ledger_name']."', type='".$data['type']."', amount=".$amount.", status='".$data['status']."', is_active='".$data['is_active']."', ledger_type='".$data['ledger_type']."', narration='".$data['narration']."', ref_date='".$data['ref_date']."', modified_by='".$data['modified_by']."', modified_on='".$data['modified_on']."' where ref_id='".$id."' and ref_type='Distributor_Sales' and entry_type='".$entry_type."'";
      // echo $sql;
      // echo '<br/><br/>';
      $conn->query($sql);
  }

  function insert_ledger($data, $conn) {
      $amount = 'Null';
      if(isset($data['amount'])){
          if($data['amount']!=''){
              $amount = $data['amount'];
          }
      }

      $sql = "insert into account_ledger_entries (voucher_id, ref_id, ref_type, entry_type, invoice_no, vendor_id, acc_id, ledger_name, type, amount, status, is_active, ledger_type, narration, ref_date, created_by, created_on, modified_by, modified_on) values ('".$data['voucher_id']."', '".$data['ref_id']."', '".$data['ref_type']."', '".$data['entry_type']."', '".$data['invoice_no']."', '".$data['vendor_id']."', '".$data['acc_id']."', '".$data['ledger_name']."', '".$data['type']."', ".$amount.", '".$data['status']."', '".$data['is_active']."', '".$data['ledger_type']."', '".$data['narration']."', '".$data['ref_date']."', '".$data['created_by']."', '".$data['created_on']."', '".$data['modified_by']."', '".$data['modified_on']."')";
      // echo $sql;
      // echo '<br/><br/>';
      $conn->query($sql);
  }

  function set_ledger($id, $conn) {
      $now=date('Y-m-d H:i:s');
      $curusr='191';

      $sql = "select A.*, B.id as acc_id, B.ledger_name from distributor_out A left join account_ledger_master B 
                  on (A.distributor_id = B.ref_id and B.ref_type = 'Distributor') 
              where A.id = '$id' and B.status = 'Approved'";
      // echo $sql;
      // echo '<br/><br/>';

      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          $row_arr = $result->fetch_all(MYSQLI_ASSOC);

          // echo json_encode($row_arr);
          // echo '<br/><br/>';

          if(count($row_arr)>0) {
              if(isset($row_arr[0]['invoice_date']) && $row_arr[0]['invoice_date']!=''){
                  $ref_date = $row_arr[0]['invoice_date'];
              } else {
                  $ref_date = $row_arr[0]['date_of_processing'];
              }
          
              $data = array(
                          'ref_id' => $id,
                          'ref_type' => 'Distributor_Sales',
                          'entry_type' => 'Total Amount',
                          'invoice_no' => $row_arr[0]['invoice_no'],
                          'vendor_id' => $row_arr[0]['distributor_id'],
                          'acc_id' => $row_arr[0]['acc_id'],
                          'ledger_name' => $row_arr[0]['ledger_name'],
                          'type' => 'Debit',
                          // 'amount' => $row_arr[0]['final_amount'],
                          'amount' => $row_arr[0]['invoice_amount'],
                          'status' => $row_arr[0]['status'],
                          'is_active' => '1',
                          'ledger_type' => 'Main Entry',
                          'narration' => $row_arr[0]['remarks'],
                          'ref_date' => $ref_date,
                          'modified_by' => $curusr,
                          'modified_on' => $now
                      );

              $ledger_array[0] = $data;
              $ledger_array[1] = $data;
              $ledger_array[2] = $data;
              $ledger_array[3] = $data;

              // echo json_encode($ledger_array);
              // echo '<br/>';

              $ledger_array[1]['entry_type'] = 'Taxable Amount';
              $ledger_array[1]['acc_id'] = '1';
              $ledger_array[1]['ledger_name'] = 'Sales';
              $ledger_array[1]['type'] = 'Credit';
              $ledger_array[1]['amount'] = $row_arr[0]['amount'];
              $ledger_array[1]['ledger_type'] = 'Sub Entry';

              $ledger_array[2]['entry_type'] = 'Tax';
              $ledger_array[2]['acc_id'] = '2';
              $ledger_array[2]['ledger_name'] = 'GST';
              $ledger_array[2]['type'] = 'Credit';
              $ledger_array[2]['amount'] = $row_arr[0]['tax_amount'];
              $ledger_array[2]['ledger_type'] = 'Sub Entry';

              $ledger_array[3]['entry_type'] = 'Shipping Charges';
              $ledger_array[3]['acc_id'] = '2';
              $ledger_array[3]['ledger_name'] = 'Shipping Charges';
              $ledger_array[3]['type'] = 'Credit';
              $ledger_array[3]['amount'] = $row_arr[0]['shipping_charges'];
              $ledger_array[3]['ledger_type'] = 'Sub Entry';

              // echo json_encode($ledger_array);
              // echo '<br/>';

              $bl_flag = false;
              $sql = "select * from account_ledger_entries where ref_id = '$id' and 
                      ref_type = 'Distributor_Sales'";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                  $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                  if(count($row_arr)>0) {
                      $bl_flag = true;

                      // $this->db->where('ref_id', $id);
                      // $this->db->where('ref_type', 'Distributor_Sales');
                      // $this->db->where('entry_type', 'Total Amount');
                      // $this->db->update('account_ledger_entries', $ledger_array[0]);

                      // $this->db->where('ref_id', $id);
                      // $this->db->where('ref_type', 'Distributor_Sales');
                      // $this->db->where('entry_type', 'Taxable Amount');
                      // $this->db->update('account_ledger_entries', $ledger_array[1]);

                      // $this->db->where('ref_id', $id);
                      // $this->db->where('ref_type', 'Distributor_Sales');
                      // $this->db->where('entry_type', 'Tax');
                      // $this->db->update('account_ledger_entries', $ledger_array[2]);

                      // $this->db->where('ref_id', $id);
                      // $this->db->where('ref_type', 'Distributor_Sales');
                      // $this->db->where('entry_type', 'Shipping Charges');
                      // $this->db->update('account_ledger_entries', $ledger_array[3]);

                      update_ledger($id, 'Total Amount', $ledger_array[0], $conn);
                      update_ledger($id, 'Taxable Amount', $ledger_array[1], $conn);
                      update_ledger($id, 'Tax', $ledger_array[2], $conn);
                      update_ledger($id, 'Shipping Charges', $ledger_array[3], $conn);
                  }
              } 
              if($bl_flag==false) {
                  $series = get_series('Account_Voucher', $conn);

                  $voucher_id = $series;

                  $ledger_array[0]['voucher_id'] = $voucher_id;
                  $ledger_array[0]['created_by']=$curusr;
                  $ledger_array[0]['created_on']=$now;

                  $ledger_array[1]['voucher_id'] = $voucher_id;
                  $ledger_array[1]['created_by']=$curusr;
                  $ledger_array[1]['created_on']=$now;

                  $ledger_array[2]['voucher_id'] = $voucher_id;
                  $ledger_array[2]['created_by']=$curusr;
                  $ledger_array[2]['created_on']=$now;

                  $ledger_array[3]['voucher_id'] = $voucher_id;
                  $ledger_array[3]['created_by']=$curusr;
                  $ledger_array[3]['created_on']=$now;

                  // $this->db->insert('account_ledger_entries', $ledger_array[0]);
                  // $this->db->insert('account_ledger_entries', $ledger_array[1]);
                  // $this->db->insert('account_ledger_entries', $ledger_array[2]);
                  // $this->db->insert('account_ledger_entries', $ledger_array[3]);

                  insert_ledger($ledger_array[0], $conn);
                  insert_ledger($ledger_array[1], $conn);
                  insert_ledger($ledger_array[2], $conn);
                  insert_ledger($ledger_array[3], $conn);
              }

              // echo json_encode($ledger_array);
          }
      }
  }

  function set_credit_note($id='', $conn){
      $sql = "select * from distributor_out where id = '$id'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          $row_arr = $result->fetch_all(MYSQLI_ASSOC);
          if(count($row_arr)>0) {
              // $date_of_processing = $row_arr[0]['date_of_processing'];
              if(isset($row_arr[0]['invoice_date']) && $row_arr[0]['invoice_date']!=''){
                  $date_of_processing = $row_arr[0]['invoice_date'];
              } else {
                  $date_of_processing = $row_arr[0]['date_of_processing'];
              }
              $invoice_no = $row_arr[0]['invoice_no'];
              $distributor_id = $row_arr[0]['distributor_id'];
              $created_by = $row_arr[0]['created_by'];
              $created_on = $row_arr[0]['created_on'];
              $modified_by = $row_arr[0]['modified_by'];
              $modified_on = $row_arr[0]['modified_on'];
              $approved_by = $row_arr[0]['approved_by'];
              $approved_on = $row_arr[0]['approved_on'];
              $rejected_by = $row_arr[0]['rejected_by'];
              $rejected_on = $row_arr[0]['rejected_on'];
              $discount = $row_arr[0]['discount'];

              if($discount==null || $discount==''){
                  $discount = 0;
              } else {
                  $discount = doubleval($discount);
              }

              $total_inv_amount = 0;
              $total_amount = 0;
              $tax_type = 'Intra';
              $promo_margin = 0;
              $bal_amount = 0;

              $sql = "select * from distributor_out_items where distributor_out_id = '$id'";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                  $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                  if(count($row_arr)>0) {
                      // echo json_encode($row_arr);
                      // echo '<br/>';

                      for($i=0; $i<count($row_arr); $i++){
                          $qty = doubleval($row_arr[$i]['qty']);
                          $rate = doubleval($row_arr[$i]['rate']);
                          $total_amt = doubleval($row_arr[$i]['total_amt']);
                          $margin_per = doubleval($row_arr[$i]['margin_per']);
                          $tax_percentage = doubleval($row_arr[$i]['tax_percentage']);
                          $promo_margin = doubleval($row_arr[$i]['promo_margin']);
                          $cgst_amt = doubleval($row_arr[$i]['cgst_amt']);
                          $sgst_amt = doubleval($row_arr[$i]['sgst_amt']);
                          $igst_amt = doubleval($row_arr[$i]['igst_amt']);

                          if($igst_amt>0){
                              $tax_type = 'Inter';
                          }

                          $total_inv_amount = $total_inv_amount + $total_amt;

                          $total_margin = $margin_per + $promo_margin + $discount;
                          $sell_rate = $rate - (($rate*$total_margin)/100);
                          // $sell_rate = $sell_rate/(100+$tax_percentage)*100;

                          $tot_amt = $qty * $sell_rate;
                          $total_amount = $total_amount + $tot_amt;

                          // echo $total_margin.'<br/>';
                          // echo $rate.'<br/>';
                          // echo $sell_rate.'<br/>';
                          // echo $tot_amt.'<br/>';
                      }
                  }
              }

              $total_inv_amount = round($total_inv_amount, 2);
              $total_amount = round($total_amount, 2);

              $bal_amount = round($total_inv_amount - $total_amount, 0);

              $credit_debit_note_id = '';
              $ref_no = '';
              $ref_date = null;
              $modified_approved_date = null;
              $action = '';

              $sql = "select * from credit_debit_note where distributor_out_id = '$id'";
              $result = $conn->query($sql);
              if ($result->num_rows==0) {
                  if($bal_amount<=-1 && $bal_amount>=1){
                      $series = get_series('Credit_debit_note', $conn);

                      $ref_date = date('Y-m-d');

                      if (isset($ref_date)){
                          if($ref_date==''){
                              $financial_year="";
                          } else {
                              $financial_year=calculateFiscalYearForDate($ref_date);
                              if(strpos($financial_year,'-')!==false){
                                  $financial_year = substr($financial_year, 0, strpos($financial_year,'-'));
                              }
                          }
                      } else {
                          $financial_year="";
                      }
                      
                      // $ref_no = 'WHPL/exp/'.$financial_year.'/'.strval($series);
                      $ref_no = 'WHPL/'.$financial_year.'-EXP/'.strval($series);
                      $modified_approved_date = null;
                  }
              } else {
                  $row_arr = $result->fetch_all(MYSQLI_ASSOC);
                  if(count($row_arr)>0) {
                      $credit_debit_note_id = $row_arr[0]['id'];
                      $ref_no = $row_arr[0]['ref_no'];
                      $ref_date = $row_arr[0]['ref_date'];
                      $modified_approved_date = $row_arr[0]['modified_approved_date'];
                  }
              }

              if($bal_amount!=0){
                  $bal_amount = round($total_inv_amount - $total_amount, 0);

                  // echo $total_inv_amount.'<br/>';
                  // echo $total_amount.'<br/>';
                  // echo $bal_amount.'<br/>';

                  $tax_per = 18;
                  $amount_without_tax = round($bal_amount/(1+($tax_per/100)), 4);
                  $cgst_amt = 0;
                  $sgst_amt = 0;
                  $igst_amt = 0;
                  if($tax_type == 'Intra'){
                      $cgst_amt = round(($amount_without_tax*($tax_per/2))/100, 4);
                      $sgst_amt = round(($amount_without_tax*($tax_per/2))/100, 4);
                  } else {
                      $igst_amt = round(($amount_without_tax*$tax_per)/100, 4);
                  }

                  $amount = round(($amount_without_tax + $cgst_amt + $sgst_amt + $igst_amt), 0);

                  // echo $amount_without_tax.'<br/>';
                  // echo $cgst_amt.'<br/>';
                  // echo $sgst_amt.'<br/>';
                  // echo $igst_amt.'<br/>';
                  // echo $amount.'<br/>';

                  $data = array(
                      'date_of_transaction' => $date_of_processing,
                      'distributor_id' => $distributor_id,
                      'transaction' => 'Expense Voucher',
                      'invoice_no' => $invoice_no,
                      'distributor_type' => 'Invoice',
                      'amount' => $amount,
                      'tax' => $tax_per,
                      'igst' => $igst_amt,
                      'cgst' => $cgst_amt,
                      'sgst' => $sgst_amt,
                      'amount_without_tax' => $amount_without_tax,
                      'status' => 'Approved',
                      'remarks' => 'SG - Promotion Charges Expense Voucher against invoice no '.$invoice_no,
                      'created_by' => $created_by,
                      'created_on' => $created_on,
                      'modified_by' => $modified_by,
                      'modified_on' => $modified_on,
                      'approved_by' => $approved_by,
                      'approved_on' => $approved_on,
                      'rejected_by' => $rejected_by,
                      'rejected_on' => $rejected_on,
                      'ref_no' => $ref_no,
                      'ref_date' => $ref_date,
                      'modified_approved_date' => $modified_approved_date,
                      'distributor_out_id' => $id,
                      'exp_category_id' => '1'
                  );

                  if($credit_debit_note_id==''){
                      $sql = "insert into credit_debit_note (date_of_transaction, distributor_id, transaction, invoice_no, distributor_type, amount, tax, igst, cgst, sgst, amount_without_tax, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, ref_no, ref_date, modified_approved_date, distributor_out_id, exp_category_id) values ('$date_of_processing', '$distributor_id', 'Expense Voucher', '$invoice_no', 'Invoice', '$amount', '$tax_per', '$igst_amt', '$cgst_amt', '$sgst_amt', '$amount_without_tax', 'Approved', 'SG - Promotion Charges Expense Voucher against invoice no ".$invoice_no."', '$created_by', '$created_on', '$modified_by', '$modified_on', '$approved_by', '$approved_on', '$rejected_by', '$rejected_on', '$ref_no', '$ref_date', '$modified_approved_date', '$id', '1')";
                      if ($conn->query($sql) === TRUE) {
                          $credit_debit_note_id = $conn->insert_id;
                          $action='Credit_debit_note Entry Created.';
                      }
                  } else {
                      $sql = "update credit_debit_note set date_of_transaction='$date_of_processing', distributor_id='$distributor_id', transaction='Expense Voucher', invoice_no='$invoice_no', distributor_type='Invoice', amount='$amount', tax='$tax_per', igst='$igst_amt', cgst='$cgst_amt', sgst='$sgst_amt', amount_without_tax='$amount_without_tax', status='Approved', remarks='SG - Promotion Charges Expense Voucher against invoice no ".$invoice_no."', created_by='$created_by', created_on='$created_on', modified_by='$modified_by', modified_on='$modified_on', approved_by='$approved_by', approved_on='$approved_on', rejected_by='$rejected_by', rejected_on='$rejected_on', ref_no='$ref_no', ref_date='$ref_date', modified_approved_date='$modified_approved_date', distributor_out_id='$id', exp_category_id='1' where id='$credit_debit_note_id'";
                      if ($conn->query($sql) === TRUE) {
                          $action='Credit_debit_note Entry Modified.';
                      }
                  }

                  $sql = "insert into user_access_log (user_id, module_name, controller_name, action, table_id, date) values ('$curusr', 'Credit_debit_note', 'Credit_debit_note', '$action', '$credit_debit_note_id', '$now')";
                  $conn->query($sql);
              } else {
                  if($credit_debit_note_id!=''){
                      $sql = "update credit_debit_note set status='InActive' where id='$credit_debit_note_id'";
                      $conn->query($sql);
                  }
              }
          }
      }
  }

  function calculateFiscalYearForDate($inputDate){
      $year=substr($inputDate, 0, strpos($inputDate, "-"));
      $month=substr($inputDate, strpos($inputDate, "-")+1, strrpos($inputDate, "-")-1);

      $year=intval($year);
      $month=intval($month);

      if($month<4){
          $fyStart=$year-1;
          $fyEnd=$year;
      } else {
          $fyStart=$year;
          $fyEnd=$year+1;
      }

      $fyStart=substr(strval($fyStart),2);
      $fyEnd=substr(strval($fyEnd),2);

      $financial_year=$fyStart.'-'.$fyEnd;

      return $financial_year;
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