<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Admin;
use Response;
use Validator;
use App\Http\Controllers\Backend\AdminuserTrait;

class AdminuserController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * This is trait class to validate requesting user
     */
    use AdminuserTrait;
       
    public $_limit = 10;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    
    
    // GET
    public function showProfile()
    {
        //if (view()->exists('auth.authenticate')) {return view('auth.authenticate');}
        $user = Admin::find($this->getUserId()); //dd($user);
        return view('backend.auth.profile', ['user'=>$user]);
    }
    
    // PATCH
    public function editProfile(Request $request)
    {
        //if (view()->exists('auth.authenticate')) {return view('auth.authenticate');}
        
        $user = Admin::find($this->getUserId());
        $request->flash();
        if ($request->isMethod('PATCH')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|max:255',
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'email' => 'required|email|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id
            ]);

            if ($validator->fails()) {
                return view('backend.auth.profileedit', [
                    'user'=>$user,
                    'errors'=>$validator->errors(),
                ]);
            }
            $user->type = $request->has('type')?$request->type:$user->type;
            $user->username = $request->has('username')?$request->username:$user->username;
            $user->firstname = $request->has('firstname')?$request->firstname:$user->firstname;
            $user->lastname = $request->has('lastname')?$request->lastname:$user->lastname;
            $user->email = $request->has('email')?$request->email:$user->email;
            $user->mobile = $request->has('mobile')?$request->mobile:$user->mobile;
            $user->address = $request->has('address')?$request->address:$user->address;
            $user->save();
            return redirect('/admin/profile');
        }
        return view('backend.auth.profileedit', ['user'=>$user]);
    }
    
    
    
    public function showRegistrationForm()
    {
        return view('backend.auth.register');
    }
    
    
    public function register(Request $request)
    {
        $request->flash();
        if ($request->isMethod('post')) {
            $rules = [
                'type' => 'required|in:ADMIN,CMSUSER',
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'mobile' => 'required|min:10|max:50',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return view('backend.auth.register', ['errors'=>$validator->errors()]);
            }

                $password = bcrypt($request->password);
                $auser = new Admin;
                $auser->firstname = (isset($request->firstname)?$request->firstname:'');
                $auser->lastname = (isset($request->lastname)?$request->lastname:'');
                $auser->address = (isset($request->address)?$request->address:'');
                $auser->mobile = (isset($request->mobile)?$request->mobile:'');
                $auser->email = (isset($request->email)?$request->email:'');
                $auser->username = (isset($request->username)?$request->username:'');
                $auser->password = $password;
                $auser->type = (isset($request->type)?$request->type:'');
                $auser->active = (isset($request->active)?$request->active:'0');
                $auser->save();

                //$password = Hash::make($request->password);
                //$password = md5($request->password);
        
                $auser->save();
            return redirect('/admin')->withSuccess("Admin user created!");
        } else {
            return view('backend.auth.register');
        }
    }
}
