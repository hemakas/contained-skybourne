<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use DB;
use Validator;

use App\Courier;
use App\Couriercharges;
use App\Country;
use App\Port;

//use App\Repositories\TaskRepository;

class QuoteController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    /**
     * Display a list of all couries.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $couriers = Courier::all();
        $countries = Country::all();
        
        //$ports = Port::with('country')->orderBy('country_id', 'asc')->get();
        $width = '';
        $height = '';
        $depth = '';
        $fromcountry = '';
        $tocountry = '';
        
        if ($request->width) {
            $width = $request->width;
            $height = $request->height;
            $depth = $request->depth;
            $fromcountry = $request->fromcountry;
            $tocountry = $request->tocountry;

                    
            $validator = Validator::make($request->all(), [
                'width' => 'required|numeric',
                'height' => 'required|numeric',
                'depth' => 'required|numeric',
                'fromcountry' => 'required|numeric',
                'tocountry' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                $validator->errors()->add('fromcountry', 'Pleaase select the country from');
                $validator->errors()->add('tocountry', 'Pleaase select the country to');
                $validator->errors()->add('width', 'Pleaase enter the width of the parcel in centimeters [cm]');
                $validator->errors()->add('height', 'Pleaase enter the height of the parcel in centimeters [cm]');
                $validator->errors()->add('depth', 'Pleaase enter the depth/length of the parcel in centimeters [cm]');
                return view('quote.index', [
                                    'couriers' => $couriers,
                                    'countries' => $countries,
                                    'width' => $width,
                                    'height' => $height,
                                    'depth' => $depth,
                                    'fromcountry' => $fromcountry,
                                    'tocountry' => $tocountry,
                                ]);
                //return redirect('/couriers/create')->withInput()->withErrors($validator);
            }
        }
        
        //VOLUMETRIC WEIGHT: LEGNTH (CM) X HIGHT (CM) X WIDTH (CM)= VOLUMETRIC WEIGHT(KG)/50000
        $volumetric = $request->depth * $request->height * $request->width/50000;
        
        //DB::enableQueryLog();
        $couriercharges = Couriercharges::with('courier', 'fromcountry', 'tocountry')
                ->select('ticker', 'name')
                ->whereHas(
                    'fromcountry',
                    function ($query) use ($fromcountry) {
                            $query->where('id', '=', $fromcountry);
                    }
                )
                ->whereHas(
                    'tocountry',
                    function ($query) use ($tocountry) {
                            $query->where('id', '=', $tocountry);
                    }
                )
                ->orderBy('charge', 'asc')->get();
        //dd(DB::getQueryLog());
        // print_r($couriercharges);
        return view('quote.index', [
                                    'couriercharges' => $couriercharges,
                                    'volumetric' => $volumetric,
                                    'couriers' => $couriers,
                                    'countries' => $countries,
                                    'width' => $width,
                                    'height' => $height,
                                    'depth' => $depth,
                                    'fromcountry' => $fromcountry,
                                    'tocountry' => $tocountry,
        ]);
    }
}
