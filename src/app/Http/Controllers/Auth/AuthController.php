<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Hash;
use DB;
use Response;
use Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Client;
use App\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $loginPath = '/login';
    protected $redirectAfterLogout = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['name'],
            'email' => $data['email'],
            //'password' => bcrypt($data['password']),
            'password' => Hash::make($data['password'])
        ]);
    }
    
    public function showLoginForm()
    {
        //if (view()->exists('auth.authenticate')) {return view('auth.authenticate');}

        return view('auth.login');
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
     
    
    public function register(Request $request)
    {
        $request->flash();
        if ($request->isMethod('post')) {
            $rules = [
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'mobile' => 'required|min:10|max:50',
                'adrsline1' => 'required|min:1',
                'town' => 'required|min:3',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return view('auth.register', ['errors'=>$validator->errors()]);
            }

            DB::transaction(function () use ($request) {
                $client = new Client;
                $client->title = (isset($request->title)?$request->title:'');
                $client->firstname = (isset($request->firstname)?$request->firstname:'');
                $client->lastname = (isset($request->lastname)?$request->lastname:'');
                $client->adrsline1 = (isset($request->adrsline1)?$request->adrsline1:'');
                $client->adrsline2 = (isset($request->adrsline2)?$request->adrsline2:'');
                $client->town = (isset($request->town)?$request->town:'');
                $client->postcode = (isset($request->postcode)?$request->postcode:'');
                $client->county = (isset($request->county)?$request->county:'');
                $client->telephone = (isset($request->telephone)?$request->telephone:'');
                $client->mobile = (isset($request->mobile)?$request->mobile:'');
                $client->email = (isset($request->email)?$request->email:'');
                $client->status = (isset($request->status)?$request->status:'1');
                $client->save();

                //$password = Hash::make($request->password);
                //$password = md5($request->password);
                $password = bcrypt($request->password);
        
                $user = User::create([
                                        'username'  => (isset($request->firstname)?$request->firstname:(isset($request->lastname)?$request->lastname:'')),
                                        'password'  => $password,
                                        'usertype' => "CLIENT",
                                        'email' => $request->email
                                    ]);
                $user->client()->save($client);
            });
            if ($request->session()->has('delivery')) {
                return redirect('/deliverydetails');
            } else {
                return redirect('/');
            }
        } else {
            return view('auth.register');
        }
    }
    
    
    protected function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect('/login');
    }
    
    /*
    public function userlogin(Request $request){ //dd('-call-');

        //$post = $request->all();
        if (Auth::attempt(['email' => $request->email, 'password'=>md5($request->password)])){
           //return 'loginSuccess';
            dd('-success-');
        } else {
            //return 'loginFailed';
            dd('-loginFailed-:'.md5($request->password));
        }
    }*/
}
