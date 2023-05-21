<?php
namespace App\Externals\Sabreapi\Utilities;

use App\Externals\Sabreapi\Workflow\Activity;
use App\Externals\Sabreapi\Rest\RestClient;

/**
 * Get Airline from Aircraft equipment code (3 chars)
 *
 * @author skaushalye
 */
class AircraftLookupActivity implements Activity {
    
    private $aircraftcode;
    
    public function __construct($aircraftcode) {
        $this->aircraftcode = $aircraftcode;
    }
    
    public function run(&$sharedContext) {

        $call = new RestClient();
        $result = $call->executeGetCall("/v1/lists/utilities/aircraft/equipment", $this->getRequest($this->aircraftcode));
        $sharedContext->addResult("AircraftLookup", $result);
        return null;
    }
    
    private function getRequest($aircraftcode) {
        $request = array(
                "aircraftcode" => $aircraftcode
        );
        return $request;
    }
    
    public function getAircraftName(&$result){
        $array = json_decode(json_encode($result->getResult("AircraftLookup")), true);
        if (isset($array['AircraftInfo'][0]['AircraftName'])) {
            return $array['AircraftInfo'][0]['AircraftName'];
        } else {
            return "";
        }
    }
}
