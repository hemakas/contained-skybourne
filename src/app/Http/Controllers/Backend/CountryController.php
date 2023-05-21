<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use DB;
use Validator;

use App\Country;

class CountryController extends Controller
{
    /**
     * The Country repository instance.
     *
     * @var CountryRepository
     */
    protected $country;
    
    /**
     * Create a new controller instance.
     *
     * @param  CountryRepository  $country
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Display a list of all Countries.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $limit = ($request->has('limit')?$request->limit:$this->_limit);
        $countries = Country::orderBy('created_at', 'asc')->paginate($limit);
        return view('backend.country.list', [
            'countries' => $countries,
            'limit' => $limit
        ]);
    }
    
    
    // GET
    public function show($id, Request $request)//, AgentuserRepository $agtuserrepo, $id)
    {
        $country = Country::find($id);
        if (!$country) {
            return view('backend.country.list', [
                'errors' => ['message' => 'Country does not exist']
            ], 404);
        }
        return view('backend.country.show', [
            'country' => $country,
        ]);
    }
    
    // POST
    public function store(Request $request)
    {
        $request->flash();
        if ($request->name) {
            $rules = [  'name' => 'required|max:255|unique:countries,name',
                        'description' => 'required'];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.country.store', [
                    'errors'=>$validator->errors(),
                ]);
            }
            
            $country = new Country;
            $country->name = $request->name;
            $country->url = preg_replace("/[^A-Za-z0-9]/", "", strtolower($request->name));
            $country->description = $request->description;
            $country->title = $request->title;
            $country->title2 = $request->title2;
            $country->active = 1;
            $country->save();

            return redirect('/admin/countries')->with('success', 'New country successfully created!');
        } else {
            return view('backend.country.store');
        }
    }
    
    
    // PATCH/PUT
    public function update($id, Request $request)
    {
        $request->flash();
        $country = Country::find($id);
        if ($request->isMethod('PATCH')) {
            $rules = [  'name' => 'required|max:255|unique:countries,name,'.$id,
                        'description' => 'required'];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.country.update', [
                    'country' => $country,
                    'errors'=>$validator->errors(),
                ]);
            }

            try {
                if (!$country) {
                    return view('backend.country.list', [
                        'errors' => ['message' => 'Country does not exist']
                    ], 404);
                }
                $country->name = ($request->name?$request->name:$country->name);
                $country->url = preg_replace("/[^A-Za-z0-9]/", "", strtolower($country->name));
                $country->description = ($request->description?$request->description:$country->description);
                $country->title = ($request->title?$request->title:$country->title);
                $country->title2 = ($request->title2?$request->title2:$country->title2);
                $country->active = (isset($request->active)?$request->active:0);
                $country->save();

                
                return redirect('/admin/countries/'.$id)->with('success', 'Country details updated!');
            } catch (Exception $e) {
                return view('backend.country.update', [
                    'country' => $country,
                    'errors' => [
                        'message' => 'Faliure in update [Exception]'
                    ]
                ]);
            }
        } else {
            return view('backend.country.update', [
                'country' => $country,
            ]);
        }
    }
    
    
    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $courier = Country::find($id);
            $courier->active = $request->input('active');
            $courier->save();
            return Response::json([
                        'data' => $request->input('active')
                    ], 200);
        }
    }

    
    // DELETE
    public function destroy($id, Request $request)
    {
        Country::findOrFail($id)->delete();
        return redirect('/admin/countries')->with('success', 'Country details deleted!');
    }
}
