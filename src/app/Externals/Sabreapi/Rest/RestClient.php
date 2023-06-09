<?php
namespace App\Externals\Sabreapi\Rest;

use App\Externals\Sabreapi\configuration\SKYConfig;
use App\Externals\Sabreapi\Rest\TokenHolder;

define("GET", "GET");
define("POST", "POST");
define("PUT", "PUT");
define("DELETE", "DELETE");

class RestClient {
    
    private $config;
    
    public function __construct() {
        $this->config = SKYConfig::getInstance();
    }
    
    public function executeGetCall($path, $request) {
        $result = curl_exec($this->prepareCall(GET, $path, $request));
        return json_decode($result);
    }
    
    public function executePostCall($path, $request) {
        $result = curl_exec($this->prepareCall(POST, $path, $request));        
        return json_decode($result);
    }
    
    private function buildHeaders() {
        $headers = array(
            'Authorization: Bearer '.TokenHolder::getToken()->access_token,
            'Accept: */*'
        );
        return $headers;
    }
    
    private function prepareCall($callType, $path, $request) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $callType);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = $this->buildHeaders();
        switch ($callType) {
        case GET:
            $url = $path;
            if ($request != null) {
                $url = $this->config->getRestProperty("environment").$this->config->getRestProperty("apiVersion").'/'
                        .ltrim($path, '/').'?'.http_build_query($request);
                //var_dump($url);
            }
            curl_setopt($ch, CURLOPT_URL, $url);
            break;
        case POST:
            curl_setopt($ch, CURLOPT_URL, $this->config->getRestProperty("environment").$this->config->getRestProperty("apiVersion").'/'.$path);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            array_push($headers, 'Content-Type: application/json');
            break;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //echo "<br/><pre>Request:";print_r($headers);echo "</pre><br/>";
        return $ch;
    }
}
