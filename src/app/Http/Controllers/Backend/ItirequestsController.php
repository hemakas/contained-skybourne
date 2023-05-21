<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Validator;
use Hash;

use App\Itirequest;
use App\Itinerary;
use App\Client;
use App\Repositories\FilesRepository;

class ItirequestsController extends Controller
{
    /**
     * The Itirequest repository instance.
     *
     * @var ItirequestRepository
     */
    protected $itirequest;
    
    private $sourcetype = 'itineraries';
    
    /**
     * Create a new controller instance.
     *
     * @param  ItirequestRepository  $Itirequest
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
        $itirequests = Itirequest::orderBy('created_at', 'asc')->paginate($limit);
        return view('backend.itirequest.list', [
            'itirequests' => $itirequests
        ]);
    }
    
    
    // GET
    public function show($id, Request $request)//, AgentuserRepository $agtuserrepo, $id)
    {
        $fileRepo = new FilesRepository;
        
        $itinerary = $client = [];
        $itirequest = Itirequest::find($id);
        if (!$itirequest) {
            return view('backend.itirequest.list', [
                'error' => [
                    'message' => 'Itirequest does not exist'
                ]
            ], 404);
        }
        
        if (isset($itirequest['itinerary'])) {
            $itinerary = $itirequest['itinerary'];
        }
        if (isset($itirequest['client'])) {
            $client = $itirequest['client'];
        }
        return view('backend.itirequest.show', [
            'itirequest' => $itirequest,
            'itinerary' => $itinerary,
            'client' => $client,
            'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
            'resource_dir' => $fileRepo->getResourcesDirectory('images'),
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
                return view('backend.itirequest.store', [
                    'errors'=>$validator->errors(),
                ]);
            }

            $id = 0;
            DB::transaction(function () use ($request, &$id) {
                $itirequest = new Itirequest;
                $itirequest->title = (isset($request->title)?$request->title:'');
                $itirequest->firstname = (isset($request->firstname)?$request->firstname:'');
                $itirequest->lastname = (isset($request->lastname)?$request->lastname:'');
                $itirequest->adrsline1 = (isset($request->adrsline1)?$request->adrsline1:'');
                $itirequest->adrsline2 = (isset($request->adrsline2)?$request->adrsline2:'');
                $itirequest->town = (isset($request->town)?$request->town:'');
                $itirequest->postcode = (isset($request->postcode)?$request->postcode:'');
                $itirequest->county = (isset($request->county)?$request->county:'');
                $itirequest->country = (isset($request->country)?$request->country:'');
                
                $itirequest->telephone = (isset($request->telephone)?$request->telephone:'');
                $itirequest->mobile = (isset($request->mobile)?$request->mobile:'');
                $itirequest->email = (isset($request->email)?$request->email:'');
                $itirequest->status = (isset($request->status)?$request->status:'0');
                $itirequest->save();
                $id = $itirequest->id;
                $request->password = Hash::make($request->password);

                $user = User::create([
                                        'username'  => $request->email,
                                        'password'  => $request->password,
                                        'usertype' => "CLIENT",
                                        'email' => $request->email
                                    ]);
                $user->itirequest()->save($itirequest);
            });
        
            return redirect('/admin/itirequests/'.$id)->with('success', 'Itirequest profile created!');
        } else {
            return view('backend.itirequest.store');
        }
    }
        
    
    // PATCH/PUT
    public function update($id, Request $request)
    {
        $request->flash();
        $itirequest = Itirequest::find($id);
        if ($request->has('firstname') || $request->has('lastname')) {
            $rules = [
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'adrsline1' => 'required',
                        'email' => 'required|email|unique:users,email,'.$itirequest->user_id
                    ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.itirequest.update', [
                    'itirequest' => $itirequest,
                    'errors'=>$validator->errors(),
                ]);
            }


            try {
                if ($itirequest->email != $request->email) {
                    $user = User::find($itirequest->user_id);
                    $user->email = $request->email;
                    $user->username = $request->email;
                    $user->save();
                }
                    
                $itirequest->title = (isset($request->title)?$request->title:$itirequest->title);
                $itirequest->firstname = (isset($request->firstname)?$request->firstname:$itirequest->firstname);
                $itirequest->lastname = (isset($request->lastname)?$request->lastname:$itirequest->lastname);
                $itirequest->adrsline1 = (isset($request->adrsline1)?$request->adrsline1:$itirequest->adrsline1);
                $itirequest->adrsline2 = (isset($request->adrsline2)?$request->adrsline2:$itirequest->adrsline2);
                
                $itirequest->town = (isset($request->town)?$request->town:$itirequest->town);
                $itirequest->postcode = (isset($request->postcode)?$request->postcode:$itirequest->postcode);
                $itirequest->country = (isset($request->country)?$request->country:$itirequest->country);
                
                $itirequest->telephone = (isset($request->telephone)?$request->telephone:$itirequest->telephone);
                $itirequest->mobile = (isset($request->mobile)?$request->mobile:$itirequest->mobile);
                $itirequest->email = (isset($request->email)?$request->email:$itirequest->email);
                $itirequest->status = (isset($request->status)?$request->status:$itirequest->status);
                $itirequest->save();

                return redirect('/admin/itirequests/'.$itirequest->id)->with('success', 'Itirequest profile updated!');
            } catch (Exception $e) {
                return view('backend.itirequest.update', [
                    'itirequest' => $itirequest,
                    'error' => [
                        'message' => 'Faliure in save [Exception]'
                    ]
                ]);
            }
        } else {
            return view('backend.itirequest.update', [
                'itirequest' => $itirequest
            ]);
        }
    }
    
    
    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $itirequest = Itirequest::find($id);
            $itirequest->status = $request->input('active');
            $itirequest->save();
            return Response::json([
                        'data' => $request->input('active')
                    ], 200);
        }
    }

    
    // DELETE
    public function destroy($id, Request $request)
    {
        Itirequest::findOrFail($id)->delete();
        return redirect('/admin/itirequests')->with('success', 'Itirequest profile removed!');
    }
}
