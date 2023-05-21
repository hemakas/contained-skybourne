<?php
namespace App\Externals\Sabreapi\Utilities;

use App\Externals\Sabreapi\Workflow\Activity;
use App\Externals\Sabreapi\Rest\RestClient;

/**
 * Get multi airports city codes in given country (3 chars)
 *
 * @author skaushalye
 */
class MultiAirportCityLookupActivity implements Activity {
    
    private $countrycode;
    
    public function __construct($countrycode) {
        $this->countrycode = $countrycode;
    }
    
    public function run(&$sharedContext) {

        $call = new RestClient();
        $result = $call->executeGetCall("/v1/lists/supported/cities", $this->getRequest($this->countrycode));
        $sharedContext->addResult("MultiAirportCityLookup", $result);
        return null;
    }
    
    private function getRequest($countrycode) {
        $request = array(
                "country" => $countrycode
        );
        return $request;
    }
    
    public function getCities(&$result){
        $return = [];
        $array = json_decode(json_encode($result->getResult("MultiAirportCityLookup")), true);
        if (isset($array['Cities'][0]['code'])) {
            foreach($array['Cities'] as $r){
                $return[] = ["code"=>$r['code'],"name"=>$r['name']];
            }
        }
        return $return;
    }
}
