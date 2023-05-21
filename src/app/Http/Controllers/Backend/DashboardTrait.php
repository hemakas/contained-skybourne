<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use App\Admin;
use App\User;
use App\Client;
use App\Message;
use App\Messagesinbox;

trait DashboardTrait
{
  
    
    /**
     * Get logged user id
     * @param Request $request
     * @return int
     */
    public function dashboardGetUserId()
    {
        $loggeduser = ['id'=>0, "type"=>""];
        try {
            if (auth()->guard('user')->check()) {
                $loggeduser['type'] = "CUSTOMER";
                $loggeduser['id'] = auth()->guard('user')->user()->id;
            } elseif (auth()->guard('admin')->check()) {
                $loggeduser['type'] = auth()->guard('admin')->user()->type;
                $loggeduser['id'] = auth()->guard('admin')->user()->id;
            }
            return $loggeduser;
        } catch (Exception $ex) {
            return $loggeduser;
        }
    }
    
    
    /**
     * Get the logged user's username
     * @return string
     */
    public function getUsername()
    {
        if (auth()->guard('user')->check()) {
            $a = auth()->guard('user')->user()->toArray();
            return (isset($a['username'])?$a['username']:"");
        } elseif (auth()->guard('admin')->check()) {
            $a = auth()->guard('admin')->user()->toArray();
            return (isset($a['username'])?$a['username']:"");
        }
        return false;
    }
    
    
    /**
     * Get the logged user's type: 'ADMIN', 'CUSTOMER', 'CMSUSER', 'CLUSER'
     * @return string
     */
    public function getUserType()
    {
        if (auth()->guard('user')->check()) {
            $a = auth()->guard('user')->user()->toArray();
            return (isset($a['type'])?$a['type']:"");
        } elseif (auth()->guard('admin')->check()) {
            $a = auth()->guard('admin')->user()->toArray();
            return (isset($a['type'])?$a['type']:"");
        }
        return false;
    }
    
    
    /**
     * Get logged user new messages
     * @return array
     */
    public function dashboardNewMessages()
    {
        try {
            $loggeduser = $this->dashboardGetUserId();
            $newmsgs = [];
            if ($loggeduser['type'] != "CUSTOMER") {
                $newmessages = Messagesinbox::with('message', 'fromuser', 'fromuser.client', 'fromauser')->where('auser_id', '=', $loggeduser['id'])->where('markasread', '=', 0)->orderBy('updated_at', 'desc')->get();
            } else {
                $newmessages = Messagesinbox::with('message', 'fromuser', 'fromuser.client', 'fromauser')->where('user_id', '=', $loggeduser['id'])->where('markasread', '=', 0)->orderBy('updated_at', 'desc')->get();
            }
            //dd($newmsgs->toArray());
            $newmessages = $newmessages->toArray();
            $i = 0;
            foreach ($newmessages as $msg) {
                $newmessages[$i]['days'] = Carbon::now()->diffForHumans(new Carbon($msg['created_at']));
                $i++;
            }
            return $newmessages;
        } catch (Exception $ex) {
            return [];
        }
    }
    
    
    /**
     * Get logged user new messages
     * @return array
     */
    public function dashboardAlerts()
    {
        try {
            $loggeduser = $this->dashboardGetUserId();
            $alerts = $newmessages = $delicounters = [];
            if ($loggeduser['type'] != "CUSTOMER") {
                $newmessages = Messagesinbox::with('message')->where('auser_id', '=', $loggeduser['id'])->where('markasread', '=', 0)->orderBy('created_at', 'asc')->first();
            } else {
                $newmessages = Messagesinbox::with('message')->where('user_id', '=', $loggeduser['id'])->where('markasread', '=', 0)->orderBy('created_at', 'asc')->first();
            }
            if (!empty($newmessages)) {
                $alerts[] = ['type'=>"Message", 'days'=>Carbon::now()->diffForHumans(new Carbon($newmessages->created_at))];
            }
            
            //dd($alerts);
            return $alerts;
        } catch (Exception $ex) {
            return [];
        }
    }
}
