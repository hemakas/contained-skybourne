<?php
namespace App\Http\Traits;

use DB;
use App\Country;
use App\Facility;
use App\Carousel;

trait PagesTrait {
  
    /**
     * Get all countries
     * @return array
     */
    public function getCountries() {
        $countries = Country::where('active', 1)->get();
	return $countries;
    }
    
    /**
     * Get all country
     * @return array
     */
    public function getCountry($countryUrl = "", $countryId = "") {
        if ($countryUrl != "") {
            $country = Country::where('active', 1)->where('url', $countryUrl)->first();
        } elseif($countryId > 0) { 
            $country = Country::where('active', 1)->find($countryId);
        } else {
            $country = '';
        }
	return $country;
    }
    
    /**
     * Get all facilities
     * @return array
     */
    public function getHotelFacilities() {
        $facilities = Facility::where('active', 1)->get();
	return $facilities;
    }
    
    /**
     * Get all Carousel
     * @return array
     */
    public function getCarousel($place = "") {
        //DB::enableQueryLog();
        $carousels = Carousel::with('carouselplace')
                ->whereHas('carouselplace', function ($query) use ($place){
                    if($place != ""){ $query->where('place', "=", $place); }
                })
                ->where('active', 1)->get();
        //dd(DB::getQueryLog());
	return $carousels;
    }
    
    /**
     * Check is request coming from restricted ip
     * @param \App\Http\Traits\Request $request
     * @return boolean
     */
    public function isRestrictedIp($request)
    {
        $reqip = $request->ip();
        if(!($reqip == "82.31.135.239" || $reqip == "79.67.198.187")){
            return true;
        } else {
            return false;
        }
    }
    
}

