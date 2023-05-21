<?php
namespace App\Externals\Sabreapi;

use App\Externals\Sabreapi\configuration\SKYConfig;
use Storage;

define("GET", "GET");
define("POST", "POST");
define("PUT", "PUT");
define("DELETE", "DELETE");

class Restcall {
    
    private static $token;
    private static $config;
    private static $instance = null;
    
    public function __construct() {
        self::getToken();
    }
    
    public static function getToken() {
        if (self::$token == null || time() > self::$expirationDate) {
            self::$config = SKYConfig::getInstance();
            self::$token = self::callForToken();             
        }
    }
    
    
    public static function callForToken() 
    {
        $url = self::$config->getRestProperty("environment").self::$config->getRestProperty("apiVersion")."/authenticate";
        $ch = curl_init($url);
        //$vars = "grant_type=client_credentials";
        $vars = "secret=".self::buildSecret();
        $headers = array(
            //'Authorization: Basic '.$this->buildCredentials(),
            'Accept: */*',
            'Content-Type: application/x-www-form-urlencoded'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        $result = curl_exec($ch);

        curl_close($ch);
        $jsond = json_decode($result, true);
        if(isset($jsond['token'])) {
            return $jsond['token'];
        }
        return null;
    }
    
    private static function buildSecret()
    {
        $secretsrt = base64_encode(base64_encode(self::$config->getRestProperty("userId")).":".base64_encode(self::$config->getRestProperty("password")));
        //echo $secretsrt."<br/>";
        return $secretsrt;
    }
    
    private function buildCredentials() {
        $credentials = self::$config->getRestProperty("formatVersion").":".
                self::$config->getRestProperty("userId").":".
                self::$config->getRestProperty("domain");
        $secret = base64_encode(self::$config->getRestProperty("password"));
        return base64_encode(base64_encode($credentials).":".$secret);
    }
    
    public function executeGetCall($path, $request) {
        $result = curl_exec($this->prepareCall(GET, $path, $request));
        return json_decode($result, true);
    }
    
    public function executePostCall($path, $request) {
        //echo "<br/>Request:<pre>";print_r($request);echo "</pre>";
        if(is_array($request)){
            //$request = http_build_query($request);
            $request = json_encode($request);
        }        
        //echo "<br/>Parse:<pre>";print_r($a);echo "</pre>";die();
        //echo "<br/>Parse:<pre>";echo "Path:".($request);echo "</pre>";
        $ch = $this->prepareCall(POST, $path, $request);
        //echo "<br/><pre>Request:";var_dump($ch);echo "</pre><br/>"; die();
        $result = curl_exec($ch);  
        
        return json_decode($result, true);
    }
    
    private function buildHeaders() {
        $headers = array(
            'Authorization: Bearer '.self::$token,
            'Accept: */*'
        );
        return $headers;
    }
    
    private function prepareCall($callType, $path, $request) {
        $ch = curl_init();
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $callType);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = $this->buildHeaders();
        switch ($callType) {
        case GET:
            $url = self::$config->getRestProperty("environment").self::$config->getRestProperty("apiVersion").'/'.
                    self::$config->getRestProperty("scope").'/'.ltrim($path, '/');
            if ($request != null) {
                $url .= '?'.http_build_query($request);                
            }
            curl_setopt($ch, CURLOPT_URL, $url);
            array_push($headers, 'Content-Type: application/json');
            break;
        case POST:
            $url = self::$config->getRestProperty("environment").self::$config->getRestProperty("apiVersion").'/'.
                    self::$config->getRestProperty("scope").'/'.ltrim($path, '/');
            //$request = "origin=LHR&destination=CMB&departuredate=2018-10-14";
                        //echo "<br/>url: $url<br/>Req:$request<br/>";

            //$request = "origin=LHR&destination=CMB&departuredate=2018-05-05&returndate=&passengers[adult]=1";
            
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);            
            array_push($headers, 'Content-Type: application/json');
            break;       
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //echo "<br/><pre>Request:";print_r($headers);echo "</pre><br/>";
        return $ch;
    }
    
}