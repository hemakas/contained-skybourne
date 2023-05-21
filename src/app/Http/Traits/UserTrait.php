<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Admin;
use App\User;
use App\Client;

trait UserTrait {
  
    public function getClientFromUser(Request $request) {
        // Get Client
        $client = array('id'=>"",'title'=>"",'firstname'=>"",'lastname'=>"",'adrsline1'=>"",'adrsline2'=>"",'town'=>"",'postcode'=>"",'county'=>"",'telephone'=>"",'mobile'=>"",'email'=>"");
        if(Auth::guard('user')->user() && (isset($request->user()->id)) ){
            $client = Client::where('user_id', '=', $request->user()->id)->first();
            if($client){
                $client = $client->toArray(); 
            }
        }
	return $client;
    }
    
    
}
