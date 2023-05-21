<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use Illuminate\Support\Str;
use DB;
use Validator;

use App\Testimonial;

class TestimonialController extends Controller
{
    /**
     * The Testimonial repository instance.
     *
     * @var TestimonialRepository
     */
    protected $testimonial;
    
    /**
     * Create a new controller instance.
     *
     * @param  TestimonialRepository  $Testimonial
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Display a list of all Testimonials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $limit = ($request->has('limit')?$request->limit:$this->_limit);
        $testimonials = Testimonial::orderBy('created_at', 'asc')->paginate($limit);
        return view('backend.testimonial.list', [
            'testimonials' => $testimonials,
            'limit' => $limit
        ]);
    }
    
    
    // GET
    public function show($id, Request $request)
    {
        $testimonial = Testimonial::find($id);
        //dd($testimonial);
        if (!$testimonial) {
            return view('backend.testimonial.list', [
                'errors' => ['message' => 'Testimonial does not exist']
            ], 404);
        }
        return view('backend.testimonial.show', [
            'testimonial' => $testimonial,
        ]);
    }
    
    // POST
    public function store(Request $request)
    {
        $request->flash();
        if ($request->name) {
            $rules = [  'content' => 'required',
                        'name' => 'required|max:255',
                        'stars' => 'required|numeric|max:5|min:1'];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.testimonial.store', [
                    'errors'=>$validator->errors(),
                ]);
            }
            
            $testimonial = new Testimonial;
            $testimonial->name = $request->name;
            $testimonial->content = $request->content;
            $testimonial->stars = $request->stars;
            $testimonial->active = 1;
            $testimonial->save();

            return redirect('/admin/testimonials')->with('success', 'New testimonial successfully created!');
        } else {
            return view('backend.testimonial.store');
        }
    }
    
    
    // PATCH/PUT
    public function update($id, Request $request)
    {
        $request->flash();
        $testimonial = Testimonial::find($id);
        if ($request->isMethod('PATCH')) {
            $rules = [  'content' => 'required',
                        'name' => 'required|max:255',
                        'stars' => 'required|numeric|max:5|min:1'];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.testimonial.update', [
                    'testimonial' => $testimonial,
                    'errors'=>$validator->errors(),
                ]);
            }

            try {
                if (!$testimonial) {
                    return view('backend.testimonial.list', [
                        'errors' => ['message' => 'Testimonial does not exist']
                    ], 404);
                }
                $testimonial->name = ($request->name?$request->name:$testimonial->name);
                $testimonial->content = ($request->content?$request->content:$testimonial->content);
                $testimonial->stars = ($request->stars?$request->stars:$testimonial->stars);
                $testimonial->active = (isset($request->active)?$request->active:0);
                $testimonial->save();

                
                return redirect('/admin/testimonials/'.$id)->with('success', 'Testimonial details updated!');
            } catch (Exception $e) {
                return view('backend.testimonial.update', [
                    'testimonial' => $testimonial,
                    'errors' => [
                        'message' => 'Faliure in update [Exception]'
                    ]
                ]);
            }
        } else {
            return view('backend.testimonial.update', [
                'testimonial' => $testimonial,
            ]);
        }
    }
    
    
    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $courier = Testimonial::find($id);
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
        Testimonial::findOrFail($id)->delete();
        return redirect('/admin/testimonials')->with('success', 'Testimonial details deleted!');
    }
}
