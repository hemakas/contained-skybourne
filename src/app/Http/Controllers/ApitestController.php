<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Externals\Sabreapi\Sabrecall;
use Storage;

class ApitestController extends BaseController
{
    /**
     * TESTING
     * @return type
     */
    public function testapi()
    {
        $o = new Sabrecall();
        
        /*
        $originPort = "LHR";
        $destinationPort = "CMB";
        $departureDate = "2018-10-14";
        $returnDate = ""; //2017-10-21
        /*$multiCity = [0=>['origin'=>"LHR",'destination'=>"CDG",'departureDate'=>"2018-10-22"],
                        1=>['origin'=>"CDG",'destination'=>"LIS",'departureDate'=>"2018-10-25"],
                        2=>['origin'=>"LIS",'destination'=>"MAN",'departureDate'=>"2018-10-28"]];*/
        /*
        $multiCity = [];
        $passengers = ['adult' => 1, 'child'=>1]; //, 'child'=>1, 'infant'=>1
        $limit = 10;
        $offset = 1;
        $directFlightsOnly = false;
        $flexiDays = false;
        $onlyThisAirline = "";
        $class = "";
        $transferTime = ["min"=>'', "max"=>''];
        $poscountrycode = "GB";
        $currencycode = "GBP";
        $return = $o->bargainMaxFlightSearch($originPort, $destinationPort, $departureDate, $returnDate, $multiCity,
            $passengers, $limit, $offset, $directFlightsOnly, $flexiDays,
            $onlyThisAirline, $class, $transferTime, $poscountrycode, $currencycode);
        */

        /*
        $airlineCode = "KL";
        $return = $o->airlineLookup($airlineCode);
        */

        /*
        $aircraftCode = "318";
        $return = $o->aircraftLookup($aircraftCode);
        */

        /*
        $location = "london";
        $return = $o->geoAutocomplete($location);
        */

        //$return = $o->findMultiairportCities('Chi');

        
        $customerId = 88;
        $transactionId = 'FB1712040088';
        $agencyInfo =
                        [
                            'StreetNmbr' => '119 Tooting High Street',
                            'AddressLine' => 'Skywings Limited',
                            'CityName' => 'London',
                            'CountryCode' => 'GB',
                            'PostalCode' => 'SW17 0SY',
                            'StateCode' => '',
                        ];

        $ticketType = '7TAW';
        $status = 'NN';
        $currency = 'GBP';
        $passengers =   [
                            'adult'  => '2',
                            'child'  => '1',
                            'infant' => '1',
                        ];
        $passengersData =
                        [
                            0 =>
                                [
                                    'id' => '26',
                                    'flightbookingrequests_id' => '88',
                                    'type' => 'adult',
                                    'title' => 'Mr',
                                    'firstname' => 'Chathura',
                                    'lastname' => 'Kannangara',
                                    'email' => 'hello@webgeniusonline.co.uk',
                                    'gender' => 'Male',
                                    'phone' => '075800834967',
                                    'dob' => '1987-12-28',
                                    'passportno' => '',
                                    'issuecountry' => '',
                                    'expiredate' => '12-14T12:05',
                                    'nationality' => '',
                                    'created_at' => '2017-12-14 23:30:14',
                                    'updated_at' => '2017-12-14 23:30:14',
                                    'deleted_at' => '',
                                ],

                              1 =>
                                [
                                    'id' => '27',
                                    'flightbookingrequests_id' => '88',
                                    'type' => 'adult',
                                    'title' => 'Mrs',
                                    'firstname' => 'Ishaka',
                                    'lastname' => 'Kannangara',
                                    'email' => 'qw@qw.qw',
                                    'gender' => 'Female',
                                    'phone' => '075800834967',
                                    'dob' => '1987-04-30',
                                    'passportno' => '',
                                    'issuecountry' => '',
                                    'expiredate' => '12-14T12:05',
                                    'nationality' => '',
                                    'created_at' => '2017-12-14 23:30:14',
                                    'updated_at' => '2017-12-14 23:30:14',
                                    'deleted_at' => '',
                                ],
                            2 =>
                                [
                                    'id' => '28',
                                    'flightbookingrequests_id' => '88',
                                    'type' => 'child',
                                    'title' => 'Mr',
                                    'firstname' => 'Son',
                                    'lastname' => 'Chat',
                                    'email' => 'qw@qw.qw',
                                    'gender' => 'Male',
                                    'phone' => '075800834967',
                                    'dob' => '2002-06-05',
                                    'passportno' => '',
                                    'issuecountry' => '',
                                    'expiredate' => '12-14T12:05',
                                    'nationality' => '',
                                    'created_at' => '2017-12-14 23:30:14',
                                    'updated_at' => '2017-12-14 23:30:14',
                                    'deleted_at' => '',
                                ],
                            3 =>
                                [
                                    'id' => '29',
                                    'flightbookingrequests_id' => '88',
                                    'type' => 'infant',
                                    'title' => 'Miss',
                                    'firstname' => 'Amelia',
                                    'lastname' => 'Kenolee',
                                    'email' => 'chatura20@gmail.com',
                                    'gender' => 'Female',
                                    'phone' => '07444123456',
                                    'dob' => '2017-06-05',
                                    'passportno' => '',
                                    'issuecountry' => '',
                                    'expiredate' => '12-14T12:05',
                                    'nationality' => '',
                                    'created_at' => '2017-12-14 23:30:14',
                                    'updated_at' => '2017-12-14 23:30:14',
                                    'deleted_at' => '',
                                ]
                        ];
        $flightJournies =
                        [
                            0 =>
                                [
                                    'origin' => 'LHR',
                                    'originAirport' => '',
                                    'destination' => 'CMB',
                                    'destinationAirport' => '',
                                    'departureTime' => '2018-02-16 13:40:00',
                                    'arrivalTime' => '2018-02-17 16:25:00',
                                    'flyingDuration' => '21h 15m',
                                    'totalTransitTime' => '09h 55m',
                                    'stops' => '1',
                                    'flights' =>
                                        [
                                            0 =>
                                                [
                                                    'airlineCode' => 'EK',
                                                    'airlineName' => 'Emirates',
                                                    'origin' => 'LHR',
                                                    'originTerminal' => '',
                                                    'originAirport' => '',
                                                    'destination' => 'DXB',
                                                    'destinationTerminal' => '',
                                                    'destinationAirport' => '',
                                                    'departureTime' => '2018-02-16 13:40:00',
                                                    'arrivalTime' => '2018-02-17 00:40:00',
                                                    'flyingDuration' => '07h 00m',
                                                    'flightstops' => '0',
                                                    'flightType' => '388',
                                                    'flightNumber' => '2',
                                                    'resBookDesigCode' => 'X',
                                                    'marriageGrp' => '',
                                                    'marketingAirline' => 'EK',
                                                ],
                                              1 =>
                                                    [
                                                        'airlineCode' => 'EK',
                                                        'airlineName' => 'Emirates',
                                                        'origin' => 'DXB',
                                                        'originTerminal' => '',
                                                        'originAirport' => '',
                                                        'destination' => 'CMB',
                                                        'destinationTerminal' => '',
                                                        'destinationAirport' => '',
                                                        'departureTime' => '2018-02-17 10:35:00',
                                                        'arrivalTime' => '2018-02-17 16:25:00',
                                                        'flyingDuration' => '04h 20m',
                                                        'flightstops' => '0',
                                                        'flightType' => '77W',
                                                        'flightNumber' => '654',
                                                        'resBookDesigCode' => 'X',
                                                        'marriageGrp' => '',
                                                        'marketingAirline' => 'EK',
                                                    ]


                                        ],

                                    1 =>
                                    [
                                    'origin' => 'CMB',
                                    'originAirport' => '',
                                    'destination' => 'LHR',
                                    'destinationAirport' => '',
                                    'departureTime' => '2018-02-23 06:20:00',
                                    'arrivalTime' => '2018-02-23 20:00:00',
                                    'flyingDuration' => '19h 10m',
                                    'totalTransitTime' => '06h 20m',
                                    'stops' => '1',
                                    'flights' =>
                                        [
                                            0 =>
                                                [
                                                    'airlineCode' => 'FZ',
                                                    'airlineName' => 'Flydubai',
                                                    'origin' => 'CMB',
                                                    'originTerminal' => '',
                                                    'originAirport' => '',
                                                    'destination' => 'DXB',
                                                    'destinationTerminal' => 'M',
                                                    'destinationAirport' => '',
                                                    'departureTime' => '2018-02-23 06:20:00',
                                                    'arrivalTime' => '2018-02-23 09:45:00',
                                                    'flyingDuration' => '04h 55m',
                                                    'flightstops' => '0',
                                                    'flightType' => '737',
                                                    'flightNumber' => '2145',
                                                    'resBookDesigCode' => 'X',
                                                    'marriageGrp' => '',
                                                    'marketingAirline' => 'EK'
                                                ],
                                            1 =>
                                                  [
                                                      'airlineCode' => 'EK',
                                                      'airlineName' => 'Emirates',
                                                      'origin' => 'DXB',
                                                      'originTerminal' => '',
                                                      'originAirport' => '',
                                                      'destination' => 'LHR',
                                                      'destinationTerminal' => '',
                                                      'destinationAirport' => '',
                                                      'departureTime' => '2018-02-23 16:05:00',
                                                      'arrivalTime' => '2018-02-23 20:00:00',
                                                      'flyingDuration' => '07h 55m',
                                                      'flightstops' => '0',
                                                      'flightType' => '388',
                                                      'flightNumber' => '5',
                                                      'resBookDesigCode' => 'X',
                                                      'marriageGrp' => '',
                                                      'marketingAirline' => 'EK',
                                                  ]
                                            ]
                                    ]

                                ]

                        ];
        $return = $o->createPNR($customerId, $transactionId, $agencyInfo, $flightJournies, $ticketType, $passengers, $passengersData, $status, $currency);
        
        
        /*
        $airlineCode = "UL";
        $return = $o->getAirlineName($airlineCode);
        */
        
        echo '<pre>';
        var_dump($return);
        echo "</pre><br/>--DONE--";
        die();
    }
}
