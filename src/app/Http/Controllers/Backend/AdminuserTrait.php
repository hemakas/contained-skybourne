<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Admin;
use App\User;
use App\Client;

trait AdminuserTrait
{
  
    
    /**
     * Get logged user type
     * @param Request $request
     * @return int
     */
    public function getUserType()
    {
        try {
            if (auth()->guard('user')->check()) {
                return 'client';
            } elseif (auth()->guard('admin')->check()) {
                $a = auth()->guard('admin')->user()->toArray();
                return (isset($a['type'])?$a['type']:false);
            }
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    
    /**
     * Get logged user id
     * @param Request $request
     * @return int
     */
    public function getUserId()
    {
        try {
            if (auth()->guard('user')->check()) {
                $a = auth()->guard('user')->user()->toArray();
                return (isset($a['id'])?$a['id']:false);
            } elseif (auth()->guard('admin')->check()) {
                $a = auth()->guard('admin')->user()->toArray();
                return (isset($a['id'])?$a['id']:false);
            }
            return false;
        } catch (Exception $ex) {
            return false;
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
     * Get the logged user's firstname + lastname
     * @return string
     */
    public function getUserFullname()
    {
        if (auth()->guard('user')->check()) {
            $a = auth()->guard('user')->user()->toArray();
            $fullname = (isset($a['firstname'])?$a['firstname']:"");
            $fullname .= " ".(isset($a['laststname'])?$a['laststname']:"");
            return trim($fullname);
        } elseif (auth()->guard('admin')->check()) {
            $a = auth()->guard('admin')->user()->toArray();
            $fullname = (isset($a['firstname'])?$a['firstname']:"");
            $fullname .= " ".(isset($a['laststname'])?$a['laststname']:"");
            return trim($fullname);
        }
        return false;
    }
    
    
    /**
     * Get the given user's name
     * @param int $user_id
     * @return string
     */
    public function getUserProfile()
    {
        if (auth()->guard('user')->check()) {
            return (auth()->guard('user')->user()->toArray());
        } elseif (auth()->guard('admin')->check()) {
            return (auth()->guard('admin')->user()->toArray());
        }
        return false;
    }
}
