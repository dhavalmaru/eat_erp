<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Test extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->database();
    }

    public function php_pdf() {
        echo 'Php Pdf';
        echo '<br/><br/>';

        php_pdf(2);
    }

    public function test_location_api() {
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        echo var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_address)));
        echo '<br/><br/>';

        $new_arr[]= unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip_address));
        echo "Latitude:".$new_arr[0]['geoplugin_latitude']." and Longitude:".$new_arr[0]['geoplugin_longitude'];
        echo '<br/><br/>';

        $lat = 0;
        $lng = 0;

        if(count($new_arr)>0){
            if(isset($new_arr[0]['geoplugin_latitude'])){
                $lat = $new_arr[0]['geoplugin_latitude'];
            }
            if(isset($new_arr[0]['geoplugin_longitude'])){
                $lng = $new_arr[0]['geoplugin_longitude'];
            }
        }

        echo $lat;
        echo '<br/><br/>';
        echo $lng;
    }

    public function testabc(){
        $result = $this->db->query("SELECT * FROM `distributor_master` Where id= '1319' ORDER By id desc")->result();
        echo strlen($result[0]->distributor_name);
        echo strlen(ltrim($result[0]->distributor_name));
        echo "distributor_name".$result[0]->distributor_name;
    }

    public function amazon_api(){
        // load_view_without_data('distributor_out/amazon_api');

        $private_key = "Eb/EPobLoX8fgQyYNbDv6Hqt4G5VFtuRgd66Zg2N";
        $params = array();
        // $method = "POST";
        $method = "GET";
        // $host = "cloudformation.eu-west-1.amazonaws.com";
        $host = "elasticmapreduce.amazonaws.com";
        $uri = "/onca/xml";

        // // additional parameters
        // $params["Service"] = "AWSCloudFormation";
        // $params["Operation"] = "ListOrders";
        // $params["AWSAccessKeyId"] = "AKIAJV7CG53CERMI53NA";
        // // GMT timestamp
        // $params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z");
        // // API version
        // $params["Version"] = "2010-05-15";


        $date = new DateTime("now", new DateTimeZone('UTC') );
        $datetime = str_replace(':','%3A',str_replace(' ','T',$date->format('Y-m-d H:i:s')));


        $params["AWSAccessKeyId"] = "AKIAJV7CG53CERMI53NA";
        $params["Action"] = "ListOrders";
        $params["SignatureMethod"] = "HmacSHA256";
        $params["SignatureVersion"] = "2";
        $params["Timestamp"] = $datetime;
        $params["Version"] = "2009-03-31";


        // sort the parameters
        // create the canonicalized query
        $canonicalized_query = array();
        foreach ($params as $param => $value) {
            $param = str_replace("%7E", "~", rawurlencode($param));
            $value = str_replace("%7E", "~", rawurlencode($value));
            $canonicalized_query[] = $param . "=" . $value;
        }
        $canonicalized_query = implode("&", $canonicalized_query);

        // create the string to sign
        // $string_to_sign = $method . "\n" . $host . "\n" . $uri . "\n" . $canonicalized_query;

        $string_to_sign = $method . "\n" . $host . "\n/\n" . $canonicalized_query;

        // calculate HMAC with SHA256 and base64-encoding
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $private_key, True));

        // encode the signature for the request
        $signature = str_replace("%7E", "~", rawurlencode($signature));

        // echo $signature;

        $data['datetime'] = $datetime;
        $data['signature'] = $signature;

        load_view('distributor_out/amazon_api', $data);

        // the url I am using is 

        // 'https://cloudformation.us-east-1.amazonaws.com/
        // ?Action=DeleteStack
        // &StackName=MyStack
        // &Version=2010-05-15
        // &SignatureVersion=2
        // &Timestamp=2012-09-05T06:32:19Z
        // &AWSAccessKeyId=[AccessKeyId]
        // &Signature=[Signature]
        // &SignatureMethod=HmacSHA256'
    }

    private function signRequest(){
        $method ='GET';
        $uri = '/dev';
        $json = file_get_contents('php://input');
        $obj = json_decode($json);


        if(isset($obj->method))
        {
            $m = explode("|", $obj->method);
            $method = $m[0];
            $uri .= $m[1];
        }


        $secretKey = $this->session->data['aws_secret'];
        $access_key = $this->session->data['aws_key'];
        $token = $this->session->data['aws_token'];
        $region = 'ap-southeast-1';
        $service = 'execute-api';

        $options = array(); $headers = array();
        $host = "YOUR-API-HOST.execute-api.ap-southeast-1.amazonaws.com";
        //Or you can define your host here.. I am using API gateway.


        $alg = 'sha256';

        $date = new DateTime( 'UTC' );

        $dd = $date->format( 'Ymd\THis\Z' );

        $amzdate2 = new DateTime( 'UTC' );
        $amzdate2 = $amzdate2->format( 'Ymd' );
        $amzdate = $dd;

        $algorithm = 'AWS4-HMAC-SHA256';


        $parameters = (array) $obj->data;

           if($obj->data == null || empty($obj->data)) 
        {
            $obj->data = "";
        }else{
            $param = json_encode($obj->data);
            if($param == "{}")
            {
                $param = "";

            }

            $requestPayload = strtolower($param);
            $hashedPayload = hash($alg, $requestPayload);

            $canonical_uri = $uri;
            $canonical_querystring = '';

            $canonical_headers = "content-type:"."application/json"."\n"."host:".$host."\n"."x-amz-date:".$amzdate."\n"."x-amz-security-token:".$token."\n";
            $signed_headers = 'content-type;host;x-amz-date;x-amz-security-token';
            $canonical_request = "".$method."\n".$canonical_uri."\n".$canonical_querystring."\n".$canonical_headers."\n".$signed_headers."\n".$hashedPayload;


            $credential_scope = $amzdate2 . '/' . $region . '/' . $service . '/' . 'aws4_request';
            $string_to_sign  = "".$algorithm."\n".$amzdate ."\n".$credential_scope."\n".hash('sha256', $canonical_request)."";
           //string_to_sign is the answer..hash('sha256', $canonical_request)//

            $kSecret = 'AWS4' . $secretKey;
            $kDate = hash_hmac( $alg, $amzdate2, $kSecret, true );
            $kRegion = hash_hmac( $alg, $region, $kDate, true );
            $kService = hash_hmac( $alg, $service, $kRegion, true );
            $kSigning = hash_hmac( $alg, 'aws4_request', $kService, true );     
            $signature = hash_hmac( $alg, $string_to_sign, $kSigning ); 
            $authorization_header = $algorithm . ' ' . 'Credential=' . $access_key . '/' . $credential_scope . ', ' .  'SignedHeaders=' . $signed_headers . ', ' . 'Signature=' . $signature;

            $headers = [
                        'content-type'=>'application/json', 
                        'x-amz-security-token'=>$token, 
                        'x-amz-date'=>$amzdate, 
                        'Authorization'=>$authorization_header];
            return $headers;

        }
    }

    public function test_redirect(){
        load_view_without_data('area/test');
    }

    public function test11(){
        // echo 'hello';
        $islogin = $_GET['islogin'];
        echo $islogin;
    }
}