<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use DB;
use Validator;
use Hash;

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
        $this->middleware('admin');
    }
    
    /**
     * Display a list of all couries.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $limit = ($request->has('limit')?$request->limit:$this->_limit);
        $clients = Client::orderBy('created_at', 'asc')->paginate($limit);
        return view('backend.client.list', [
            'clients' => $clients
        ]);
    }
    
    
    // GET
    public function show($id, Request $request)//, AgentuserRepository $agtuserrepo, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return view('backend.client.list', [
                'error' => [
                    'message' => 'Client does not exist'
                ]
            ], 404);
        }
        return view('backend.client.show', [
            'client' => $client
        ]);
    }
    
    // POST
    public function store(Request $request)
    {
        $request->flash();
        if ($request->has('firstname') || $request->has('lastname')) {
            $rules = [
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'adrsline1' => 'required',
                        'email' => 'required|email|unique:users,email',
                        'password' => 'required|min:6|confirmed'
                    ];
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return view('backend.client.store', [
                    'errors'=>$validator->errors(),
                ]);
            }

            $id = 0;
            DB::transaction(function () use ($request, &$id) {
                $client = new Client;
                $client->title = (isset($request->title)?$request->title:'');
                $client->firstname = (isset($request->firstname)?$request->firstname:'');
                $client->lastname = (isset($request->lastname)?$request->lastname:'');
                $client->adrsline1 = (isset($request->adrsline1)?$request->adrsline1:'');
                $client->adrsline2 = (isset($request->adrsline2)?$request->adrsline2:'');
                $client->town = (isset($request->town)?$request->town:'');
                $client->postcode = (isset($request->postcode)?$request->postcode:'');
                $client->county = (isset($request->county)?$request->county:'');
                $client->country = (isset($request->country)?$request->country:'');
                
                $client->telephone = (isset($request->telephone)?$request->telephone:'');
                $client->mobile = (isset($request->mobile)?$request->mobile:'');
                $client->email = (isset($request->email)?$request->email:'');
                $client->status = (isset($request->status)?$request->status:'0');
                $client->save();
                $id = $client->id;
                $request->password = Hash::make($request->password);

                $user = User::create([
                                        'username'  => $request->email,
                                        'password'  => $request->password,
                                        'usertype' => "CLIENT",
                                        'email' => $request->email
                                    ]);
                $user->client()->save($client);
            });
        
            return redirect('/admin/clients/'.$id)->with('success', 'Client profile created!');
        } else {
            return view('backend.client.store');
        }
    }
        
    
    // PATCH/PUT
    public function update($id, Request $request)
    {
        $request->flash();
        $client = Client::find($id);
        if ($request->has('firstname') || $request->has('lastname')) {
            $rules = [
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'adrsline1' => 'required',
                        'email' => 'required|email|unique:users,email,'.$client->user_id
                    ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.client.update', [
                    'client' => $client,
                    'errors'=>$validator->errors(),
                ]);
            }


            try {
                if ($client->email != $request->email) {
                    $user = User::find($client->user_id);
                    $user->email = $request->email;
                    $user->username = $request->email;
                    $user->save();
                }
                    
                $client->title = (isset($request->title)?$request->title:$client->title);
                $client->firstname = (isset($request->firstname)?$request->firstname:$client->firstname);
                $client->lastname = (isset($request->lastname)?$request->lastname:$client->lastname);
                $client->adrsline1 = (isset($request->adrsline1)?$request->adrsline1:$client->adrsline1);
                $client->adrsline2 = (isset($request->adrsline2)?$request->adrsline2:$client->adrsline2);
                
                $client->town = (isset($request->town)?$request->town:$client->town);
                $client->postcode = (isset($request->postcode)?$request->postcode:$client->postcode);
                $client->country = (isset($request->country)?$request->country:$client->country);
                
                $client->telephone = (isset($request->telephone)?$request->telephone:$client->telephone);
                $client->mobile = (isset($request->mobile)?$request->mobile:$client->mobile);
                $client->email = (isset($request->email)?$request->email:$client->email);
                $client->status = (isset($request->status)?$request->status:$client->status);
                $client->save();

                return redirect('/admin/clients/'.$client->id)->with('success', 'Client profile updated!');
            } catch (Exception $e) {
                return view('backend.client.update', [
                    'client' => $client,
                    'error' => [
                        'message' => 'Faliure in save [Exception]'
                    ]
                ]);
            }
        } else {
            return view('backend.client.update', [
                'client' => $client
            ]);
        }
    }
    
    
    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $client = Client::find($id);
            $client->status = $request->input('active');
            $client->save();
            return Response::json([
                        'data' => $request->input('active')
                    ], 200);
        }
    }

    
    // DELETE
    public function destroy($id, Request $request)
    {
        Client::findOrFail($id)->delete();
        return redirect('/admin/clients')->with('success', 'Client profile removed!');
    }
}
