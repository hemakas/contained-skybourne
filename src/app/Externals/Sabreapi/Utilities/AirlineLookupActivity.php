<?php
namespace App\Externals\Sabreapi\Utilities;

use App\Externals\Sabreapi\Workflow\Activity;
use App\Externals\Sabreapi\Rest\RestClient;

/**
 * Get Airline from Ariline code (2 chars)
 *
 * @author skaushalye
 */
class AirlineLookupActivity implements Activity {
    
    private $airlinecode;
    
    public function __construct($airlinecode) {
        $this->airlinecode = $airlinecode;
    }
    
    public function run(&$sharedContext) {

        $call = new RestClient();
        $result = $call->executeGetCall("/v1/lists/utilities/airlines", $this->getRequest($this->airlinecode));
        $sharedContext->addResult("AirlineLookup", $result);
        return null;
    }
    
    private function getRequest($airlinecode) {
        $request = array(
                "airlinecode" => $airlinecode
        );
        return $request;
    }
    
    public function getAirlineName(&$result){
        $array = json_decode(json_encode($result->getResult("AirlineLookup")), true);
        if (isset($array['AirlineInfo'][0]['AirlineName'])) {
            return $array['AirlineInfo'][0]['AirlineName'];
        } else {
            return "";
        }
    }
}
