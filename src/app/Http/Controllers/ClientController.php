<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use DB;
use Validator;

use App\Client;
use App\User;

class ClientController extends Controller
{
    /**
     * The Client repository instance.
     *
     * @var ClientRepository
     */
    protected $client;
    
    /**
     * Create a new controller instance.
     *
     * @param  ClientRepository  $Client
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
    public function index()
    {
        $clients = Client::orderBy('created_at', 'asc')->get();
        return view('client.index', [
            'clients' => $clients
        ]);
    }
    
    public static function all()
    {
        $clients = Client::all();
        return $clients;
    }
    
    
    public static function getClient($id)
    {
        $client = Client::find($id);
        return $client;
    }
    
    
    // GET
    public function show($id, Request $request)//, AgentuserRepository $agtuserrepo, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return Response::json([
                'error' => [
                    'message' => 'Client does not exist'
                ]
            ], 404);
        }
        return view('client.show', [
            'client' => $client
        ]);
    }
    
    // POST
    public function store(Request $request)
    {
        if ($request->full_name) {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|max:255',
                'address' => 'required',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                $validator->errors()->add('full_name', 'Enter full name');
                $validator->errors()->add('address', 'Enter address');
                $validator->errors()->add('email', 'Enter email');
                return view('client.store');
            }

            DB::transaction(function () use ($request) {
                $client = new Client;
                $client->title = (isset($request->title)?$request->title:'');
                $client->full_name = (isset($request->full_name)?$request->full_name:'');
                $client->address = (isset($request->address)?$request->address:'');
                $client->telephone = (isset($request->telephone)?$request->telephone:'');
                $client->mobile = (isset($request->mobile)?$request->mobile:'');
                $client->email = (isset($request->email)?$request->email:'');
                $client->status = (isset($request->status)?$request->status:'1');
                $client->save();

                $request->password = Hash::make($request->password);

                $user = User::create([
                                        'username'  => $request->username,
                                        'password'  => $request->password,
                                        'usertype' => "CLIENT",
                                        'email' => $request->email
                                    ]);
                $user->client()->save($client);
            });
        
            return redirect('/clients');
        } else {
            return view('client.store');
        }
    }
    
    
    // POST
    public function store_user(Request $request)
    {
        if (!trim($request->password) or !trim($request->firstname) or !trim($request->lastname) or !$request->email) { // or ! $request->user_id
            return Response::json([
                'error' => [
                    'message' => 'Please provide all the requiered fields'
                ]
            ], 422);
        }
        
        if (User::where('email', $request->email)->first()) {
            return Response::json([
                'error' => [
                    'message' => 'This email already exists! If you forgot the password, please <a link="'.Config::get('app.url').'/recovery">recover password.</a>'
                ]
            ], 422);
        }
        
        // Set email as username
        $request->username = $request->email;
        
        // Validate input feilds
        $validator = Validator::make($request->all(), [
                        'email' => 'required|email',
                        'password' => 'required|max:20',
                        'firstname' => 'required|max:20',
                        'lastname' => 'required|max:20',
                        'mobile' => 'required'
                    ]);

        if ($validator->fails()) {
            return Response::json([
                'error' => [
                    'message' => 'Fields validation fail'
                ]
            ], 422);
        }
        
        
        $request->usertype = "CUSTOMER";
        DB::transaction(function () use ($request) {
            $customer = new Customer(
                $request->only(['firstname', 'lastname', 'email', 'mobile', 'address', 'postcode', 'location', 'interestareas', 'filters', 'searches', 'gender'])
            );
            $request->password = Hash::make($request->password);
            
            $user = User::create([
                                    'username'  => $request->username,
                                    'password'  => $request->password,
                                    'usertype' => $request->usertype,
                                    'email' => $request->email
                                ]);
            $user->customers()->save($customer);
        });

        return Response::json([
                'message' => 'Customer Created Succesfully',
        ]);
    }
    
    
    
    // PATCH/PUT
    public function update($id, Request $request)
    {
            
        $client = Client::find($id);
        if ($request->full_name) {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|max:255',
                'address' => 'required',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                $validator->errors()->add('full_name', 'Enter full name');
                $validator->errors()->add('address', 'Enter address');
                $validator->errors()->add('email', 'Enter email');
                
                return view('client.update', [
                    'client' => $client
                ]);
            }

            try {
                $client = Client::find($id);
                $client->title = (isset($request->title)?$request->title:$client->title);
                $client->full_name = (isset($request->full_name)?$request->full_name:$client->full_name);
                $client->address = (isset($request->address)?$request->address:$client->address);
                $client->telephone = (isset($request->telephone)?$request->telephone:$client->telephone);
                $client->mobile = (isset($request->mobile)?$request->mobile:$client->mobile);
                $client->email = (isset($request->email)?$request->email:$client->email);
                $client->status = (isset($request->status)?$request->status:$client->status);
                $client->save();

                return redirect('/clients');
            } catch (Exception $e) {
                return view('client.update', [
                    'client' => $client,
                    'error' => [
                        'message' => 'Faliure in save [Exception]'
                    ]
                ]);
            }
        } else {
            return view('client.update', [
                'client' => $client
            ]);
        }
    }
    
    
    // DELETE
    public function destroy($id, Request $request)
    {
        Client::findOrFail($id)->delete();
        return redirect('/clients');
    }
    
    private function transform($client)
    {
        
        return [
                'id' => $client['id'],
                'name' => $client['full_name'],
        ];
    }
}
