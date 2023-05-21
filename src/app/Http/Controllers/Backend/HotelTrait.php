<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Hotel;

trait HotelTrait
{
        
    public function checkHotelExist($hotelname = '')
    {
        $possibles = array();
        
        //DB::enableQueryLog();
        if ($hotelname != '') { // Only when store data
            $hotels = Hotel::with('country', 'hotelimages')->where('hotelname', $hotelname)->get();
            //dd(DB::getQueryLog());
            
            if (!empty($hotels)) {
                foreach ($hotels as $hotel) {
                    $possibles[] = $hotel->toArray();
                }
            }
        }
 
        return $possibles;
    }
}
