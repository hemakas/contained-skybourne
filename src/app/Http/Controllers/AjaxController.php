<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Response;
use Validator;
use App\Externals\Sabreapi\Sabrecall;
use App\Airportcode;

class AjaxController extends Controller
{

    protected $_limit = 10;
    
    
    /**
     * Function for facilitate ajax request for airports list in given city
     * @param Request $request
     * @return array
     */
    public function ajaxCityAirports(Request $request)
    {
        $aReturn = [];
        if ($request->has('city') && trim($request->city) != "") {
            $searchtext = trim($request->city);
            $airports = Airportcode::select(DB::raw("airportname AS airport, cityname AS city, code"))->where('code', 'LIKE', $searchtext."%")
                    ->orWhere('cityname', 'LIKE', $searchtext."%")
                    ->orWhere('airportname', 'LIKE', $searchtext."%")
                    ->orderBy('airportname', 'asc')->limit(5)->get();
            $aReturn = $airports->toArray();
        }
        return Response::json($aReturn);
    }
    

    /**
     * Function for facilitate ajax request for airports list in given city
     * @param Request $request
     * @return array
     */
    public function sabre_ajaxCityAirports(Request $request)
    {
        $aReturn = [];
        if ($request->has('city') && trim($request->city) != "") {
            $searchtext = trim($request->city);
            $oSabre = new Sabrecall();
            
            // Multiairport cities
            $aReturn = $oSabre->findMultiairportCities($searchtext);
            
            $aAirports = $oSabre->geoAutocomplete($searchtext);
            
            $aReturn = array_merge($aReturn, $aAirports);
        }
        
        return Response::json($aReturn);
    }
}
