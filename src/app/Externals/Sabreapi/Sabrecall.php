<?php
namespace App\Externals\Sabreapi;

//use App\Externals\Sabreapi\Workflow\Workflows;

use App\Externals\Sabreapi\Restcall;

use Storage;
use DateTime;

class Sabrecall {

    public function getAirlineName($airlineCode){
        try {
            $oRestC = new Restcall();
            $request = array();
            $response = $oRestC->executeGetCall('/airlinename/'.$airlineCode, $request);
            if(isset($response['data'])){
                return $response['data'];
            } else {
                return [];
            }
        } catch (Exception $ex) {
            return [false, 'message' => $ex->getMessage()];
        }
    }
    
    public function bargainMaxFlightSearch($originPort, $destinationPort, $departureDate, $returnDate, $multiCity,
            $passengers = [], $limit = 50, $offset = 1, $directFlightsOnly = false, $flexiDays = false,
            $onlyThisAirline = "", $class = "", $transferTime = ["min"=>'', "max"=>''], $poscountrycode = "GB", $currencycode = "GBP")
    {
        try {
            $params = [
                "origin" => $originPort,
                "destination" => $destinationPort,
                "departuredate" => $departureDate,
                "returndate" => $returnDate,
                "multicity" => $multiCity,
                "passengers" => $passengers,
                "limit" => $limit,
                "offset" => $offset,
                "directflightsonly" => $directFlightsOnly,
                "flexidays" => $flexiDays,
                "onlythisairline" => $onlyThisAirline,
                "class" => $class,
                "transfertime" => $transferTime,
                "poscountrycode" => $poscountrycode,
            ];
            //echo "<pre>";print_r($params);echo "</pre>";die();
            $oRestC = new Restcall();
            $response = $oRestC->executePostCall('/search', $params);
            if(isset($response['data'])){
                $data = $response['data'];
                //Storage::disk('upload')->put('response.txt', json_encode($data));
                return $data;
            } else {
                return [];
            }
        } catch (Exception $ex) {
            return [false, 'message' => $ex->getMessage()];
        }
    }

    public function createPNR($customerId, $transactionId, $agencyInfo, $flightJournies, $ticketType, $passengers, $passengersData, $status, $currency)
    {
        try {
            $params = [
                'customerId'     => $customerId,
                'agencyInfo'   => $agencyInfo,
                'flightBookingId' => $transactionId,
                'flightJournies' => $flightJournies, // without ['flightJournies'], only inside array
                'ticketType' => $ticketType, // eTicket
                'EndTransactionReceivedFrom' => "Skywings",
                'status' => $status,
                'passengers' => $passengers,
                'passengersData' => $passengersData,
                'currency' => $currency,
                'breakInContinuity' => "",
                'issetMiscSegment' => false,
                'issetSpecialReqDetails' => false,
                'QueueIdentifierNumber' => 100,
                'QueueIdentifierRefacInsCode' => 11,
                'companyRef' => "Skywings",
                'Misc' => [
                    'DepartureDate' => null,
                    "noofseats" => null,
                    "status" => null,
                    "type" => null,
                    "originCityCode" => null,
                    "airlineCode" => null,
                ]
            ];
            $oRestC = new Restcall();
            $response = $oRestC->executePostCall('/createpnr', $params);
            if(isset($response['data'])){
                $data = $response['data'];
                //Storage::disk('upload')->put('response.txt', json_encode($data));
                return $data;
            } else {
                return [];
            }
        } catch (Exception $ex) {
            return [false, 'message' => $ex->getMessage()];
        }
    }

    public function airlineLookup($airlineCode)
    {
        try {
            $oRestC = new Restcall();
            $request = array();
            $response = $oRestC->executeGetCall('/airlinelookup/'.$airlineCode, $request);
            if(isset($response['data'])){
                return $response['data'];
            } else {
                return [];
            }
        } catch (Exception $ex) {
            return [false, 'message' => $ex->getMessage()];
        }
    }


    public function aircraftLookup($aircraftCode)
    {
        try {
            $oRestC = new Restcall();
            $request = array();
            $response = $oRestC->executeGetCall('/aircraftlookup/'.$aircraftCode, $request);
            if(isset($response['data'])){
                return $response['data'];
            } else {
                return [];
            }
        } catch (Exception $ex) {
            return [false, 'message' => $ex->getMessage()];
        }
    }

    public function geoAutocomplete($locationstring)
    {
        try {
            $oRestC = new Restcall();
            $request = array();
            $response = $oRestC->executeGetCall('/geo/'.$locationstring, $request);
            if(isset($response['data'])){
                return $response['data'];
            } else {
                return [];
            }
        } catch (Exception $ex) {
            return [false, 'message' => $ex->getMessage()];
        }
    }

    public function getMultiairportCitiesByCountry()
    {
        try {
            
        } catch (Exception $ex) {

        }
    }

    public function findMultiairportCities($countrycode){
        try {
            $oRestC = new Restcall();
            $request = array();
            $response = $oRestC->executeGetCall('/multiportcities/'.$countrycode, $request);
            if(isset($response['data'])){
                return $response['data'];
            } else {
                return [];
            }
        } catch (Exception $ex) {
            return [false, 'message' => $ex->getMessage()];
        }
    }


}
