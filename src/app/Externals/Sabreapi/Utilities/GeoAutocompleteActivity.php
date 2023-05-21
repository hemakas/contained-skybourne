<?php
namespace App\Externals\Sabreapi\Utilities;

use App\Externals\Sabreapi\Workflow\Activity;
use App\Externals\Sabreapi\Rest\RestClient;

/**
 * Get the possible airport list for given string to from/to locations autocomplete
 *
 * @author skaushalye
 */
class GeoAutocompleteActivity implements Activity {
    
    private $locationstring;
    private $category;
    private $limit;
    
    public function __construct($locationstring, $category, $limit) {
        $this->locationstring = $locationstring;
        $this->category = $category;
        $this->limit = $limit;
    }
    
    public function run(&$sharedContext) {

        $call = new RestClient();
        $result = $call->executeGetCall("/v1/lists/utilities/geoservices/autocomplete", $this->getRequest($this->locationstring, $this->category, $this->limit));
        $sharedContext->addResult("GeoAutocomplete", $result);
        return null;
    }
    
    private function getRequest($locationstring, $category, $limit) {
        $request = array(
                "query" => $locationstring,
                "category" => $category,
                "limit" => $limit
        );
        return $request;
    }
    
    public function getAirports(&$result){
        $return = [];
        $array = json_decode(json_encode($result->getResult("GeoAutocomplete")), true);
        //var_dump($array['Response']['grouped']['category:'.$this->category]['doclist']);
        if (isset($array['Response']['grouped']['category:'.$this->category]['doclist']['docs'])) {
            $resultPorts = $array['Response']['grouped']['category:'.$this->category]['doclist']['docs'];
            foreach ($resultPorts as $ele) {
                $return[] = ['id' => $ele['id'], 'airport' => $ele['name'], 'city' => $ele['city'].', '.$ele['countryName']];
            }
        }
        return $return;
    }
}
