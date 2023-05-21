<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FilesRepository;
use App\Repositories\ImagesRepository;

use Carbon\Carbon;
use Validator;
use Response;
use Storage;
use File;
use App\Hotel;
use App\Hotelimage;
use App\Facility;
use App\Country;
use App\Itinerary;
use App\Itineraryday;
use App\Itineraryimage;
use App\Specialoffer;
use App\Http\Controllers\Backend\ImagesTrait;

class ItineraryController extends Controller
{

    use ImagesTrait;

    private $sourcetype = 'itineraries';

    private $rules = [  'title' => 'required|max:255',
                        'price' => 'required|numeric',
                        'pricestring' => 'required',
                        'nights' => 'required|numeric',
                        'description' => 'required',];

    /**
     * Create a new controller instance.
     *
     * @param
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a list of all hotels.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $fileRepo = new FilesRepository;
        $limit = ($request->has('limit')?$request->limit:$this->_limit);
        $itineraries = Itinerary::with('itineraryimage', 'itinerarydays')->orderBy('created_at', 'desc')->paginate($limit);

        return view('backend.itinerary.list', [
            'itineraries' => $itineraries,
            'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
            'resource_dir' => $fileRepo->getResourcesDirectory('images'),
        ]);
    }


    // GET
    public function show($id, Request $request)//, AgentuserRepository $agtuserrepo, $id)
    {
        $fileRepo = new FilesRepository;
        $itinerary = Itinerary::with('itineraryimages', 'itinerarydays')->find($id);
        if (!$itinerary) {
            return view('backend.itinerary.list', [
                'error' => [
                    'message' => 'Itinerary does not exist'
                ]
            ], 404);
        }
        //dd($itinerary->toArray());
        return view('backend.itinerary.show', [
            'itinerary' => $itinerary,
            'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
            'resource_dir' => $fileRepo->getResourcesDirectory('images'),
        ]);
    }

    // POST
    public function store(Request $request)
    {
        //'title', 'title2', 'description', 'price', 'pricestring', 'nights', 'active'
        $request->flash();
        $fileRepo = new FilesRepository;
        $countries = Country::where('active', 1)->get();
        $specialoffers = Specialoffer::where('type', "itinerary")->where('active', 1)->get();

        if ($request->isMethod('POST')) {
            //dd($request);
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return view('backend.itinerary.store', [
                    'errors'=>$validator->errors(),
                    'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                    'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                    'countries' => $countries,
                ]);
            }

            $itinerary = new Itinerary;
            $itinerary->title = ($request->has('title')?$request->title:'');
            $itinerary->title2 = ($request->has('title2')?$request->title2:'');
            $itinerary->description = ($request->has('description')?$request->description:'');
            $itinerary->url = str_replace(" ", "-", preg_replace("/[^A-Za-z0-9\s]/", "", strtolower($request->title)));
            $itinerary->stars = ($request->has('stars')?$request->stars:'');
            $itinerary->summary = ($request->has('summary')?$request->summary:'');
            $itinerary->price = ($request->has('price')?$request->price:'0');
            $itinerary->pricestring = ($request->has('pricestring')?$request->pricestring:'');
            $itinerary->nights = ($request->has('nights')?$request->nights:'0');
            $itinerary->featured = ($request->has('featured')?$request->featured:0);
            $itinerary->active = ($request->has('active')?$request->active:1);
            $iticountries = ($request->has('country')?$request->country:[]);

            $itinerary->save();
            $itinerary->countries()->attach($iticountries);

            // Save hotel images
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                //var_dump($files);
                $x = 0;
                foreach ($files as $file) {
                    $newfilename = '';
                    if ($file !== null) {
                        $filename = $file->getClientOriginalName();

                        $tmpimage = $fileRepo->saveImageInTemporaryLocation($this->sourcetype, $filename, $file->getRealPath());

                        if ($tmpimage['error'] !== false) {
                            $return['errors'][] = $tmpimage['message'];
                        }
                        if ($tmpimage['error'] === false && $tmpimage['tempname'] != '') {
                            $newfilename = $fileRepo->saveSourceImage($this->sourcetype, $tmpimage['tempname'], $tmpimage['tempname'], $itinerary->id);
                            // Insert into DB
                            $itineraryimg = Itineraryimage::create([
                                            'itinerary_id' => $itinerary->id,
                                            'imagename' => $newfilename,
                                            'title' => ($request->has("imgtitle.$x")?$request->input("imgtitle.$x"):''),
                                            'order' => $x,
                                            'active' => 1,
                                        ]);
                            $itineraryimg->save();
                            $fileRepo->deleteTempImage($this->sourcetype, $tmpimage['tempname']);
                        }
                    } //else {dd('--2--');}
                    $x++;
                }
            } //else {dd('--3--');}

            return redirect('/admin/itineraries/'.$itinerary->id)->with('success', 'New itinerary successfully created!');
        } else {
            return view('backend.itinerary.store', [
                    'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                    'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                    'specialoffers' => $specialoffers,
                    'countries' => $countries,
                ]);
        }
    }


    // POST/PATCH
    public function update($id, Request $request)
    {
        //'title', 'title2', 'description', 'price', 'pricestring', 'nights', 'active'
        $request->flash();
        $fileRepo = new FilesRepository;
        $countries = Country::where('active', 1)->get();
        $specialoffers = Specialoffer::where('type', "itinerary")->where('active', 1)->get();

        $itinerary = Itinerary::with('itineraryimages', 'itinerarydays', 'countries')->find($id);
        if (!$itinerary) {
            return view('backend.itinerary.list', [
                'error' => [
                    'message' => 'Itinerary does not exist'
                ]
            ], 404);
        }

        //if($request->hotelname){
        if ($request->isMethod('PATCH')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails()) {
                return view('backend.hotel.update', [
                    'itinerary' => $itinerary,
                    'errors'=>$validator->errors(),
                    'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                    'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                    'countries' => $countries,
                    'specialoffers' => $specialoffers,
                ]);
            }

            try {
                $itinerary->title = ($request->has('title')?$request->title:$itinerary->title);
                $itinerary->title2 = ($request->has('title2')?$request->title2:$itinerary->title2);
                $itinerary->url = str_replace(" ", "-", preg_replace("/[^A-Za-z0-9\s]/", "", strtolower($itinerary->title)));
                $itinerary->stars = ($request->has('stars')?$request->stars:$itinerary->stars);
                $itinerary->summary = ($request->has('summary')?$request->summary:$itinerary->summary);
                $itinerary->description = ($request->has('description')?$request->description:$itinerary->description);
                $itinerary->price = ($request->has('price')?$request->price:$itinerary->price);
                $itinerary->pricestring = ($request->has('pricestring')?$request->pricestring:$itinerary->pricestring);
                $itinerary->nights = ($request->has('nights')?$request->nights:$itinerary->nights);
                $itinerary->featured = ($request->has('featured')?$request->featured:0);
                $itinerary->active = ($request->has('active')?$request->active:0);
                $iticountries = ($request->has('country')?(!is_array($request->country)?[$request->country]:$request->country):[]);

                $itinerary->save();
                $itinerary->countries()->sync($iticountries);
                

                return redirect('/admin/itineraries/'.$id)->with('success', 'Itinerary details successfully updated!');
            } catch (Exception $e) {
                return view('backend.itinerary.update', [
                    'itinerary' => $itinerary,
                    'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                    'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                    'countries' => $countries,
                    'specialoffers' => $specialoffers,
                    'errors' => [
                        'message' => 'Faliure in save [Exception]'
                    ]
                ]);
            }
        } else {
            return view('backend.itinerary.update', [
                    'itinerary' => $itinerary,
                    'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                    'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                    'specialoffers' => $specialoffers,
                    'countries' => $countries,
            ]);
        }
    }

    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $itinerary = Itinerary::find($id);
            $itinerary->active = $request->input('active');
            $itinerary->save();
            return Response::json([
                        'data' => $request->input('active')
                    ], 200);
        }
    }


    // DELETE
    public function destroy($id, Request $request)
    {
        Itinerary::findOrFail($id)->delete();
        return redirect('admin/itineraries');
    }


    // IMAGES UPDATE
    public function images($id, Request $request)
    {
        $request->flash();
        $fileRepo = new FilesRepository;

        $itinerary = Itinerary::with(
            ['itineraryimages' => function ($query) {
                            $query->orderBy('order', 'asc');
            }]
        )->find($id);
        if (!$itinerary) {
            return redirect('/admin/itineraries')->withErrors(["Unable to find this itinerary images!"]);
        }

        if ($itinerary->itineraryimages != null) {
            $existingimgs = $itinerary->itineraryimages->toArray();
        }
        try {
            //if($request->hotelname){
            if ($request->isMethod('PATCH')) {
                $validator = Validator::make($request->all(), [
                    'images' => 'required',
                ]);

                if ($validator->fails()) {
                    return view('backend.itinerary.update', [
                        'itinerary' => $itinerary,
                        'existingimgs' => $existingimgs,
                        'errors'=>$validator->errors(),
                        'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                        'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                    ]);
                }


                // Save hotel images
                if ($request->hasFile('images')) {
                    $files = $request->file('images');
                    //var_dump($files);
                    $x = 0;
                    foreach ($files as $file) {
                        $newfilename = '';
                        if ($file !== null) {
                            $filename = $file->getClientOriginalName();

                            $tmpimage = $fileRepo->saveImageInTemporaryLocation($this->sourcetype, $filename, $file->getRealPath());

                            if ($tmpimage['error'] !== false) {
                                $return['errors'][] = $tmpimage['message'];
                            }
                            if ($tmpimage['error'] === false && $tmpimage['tempname'] != '') {
                                $newfilename = $fileRepo->saveSourceImage($this->sourcetype, $tmpimage['tempname'], $tmpimage['tempname'], $itinerary->id);
                                // Insert into DB
                                $itineraryimg = Itineraryimage::create([
                                                'itinerary_id' => $itinerary->id,
                                                'imagename' => $newfilename,
                                                'title' => ($request->has("imgtitle.$x")?$request->input("imgtitle.$x"):''),
                                                'order' => $x,
                                                'active' => 1,
                                            ]);
                                $itineraryimg->save();
                                $fileRepo->deleteTempImage($this->sourcetype, $tmpimage['tempname']);
                            }
                        } //else {dd('--2--');}
                        $x++;
                    }
                } //else {dd('--3--');}


                $removingimgs = ($request->has('hremimgs')?$request->hremimgs:[]);

                // Remove images
                if (!empty($removingimgs)) {
                    foreach ($removingimgs as $remimg) {
                            $itineraryimg = Itineraryimage::find($remimg);

                        if ($itineraryimg) {
                            $itineraryimg->forceDelete();
                            //$oImgRepo->deleteImage($oImgRepo->property_image_path['property']['real_image_path'].$itineraryimg->agent_id.'/'.$itineraryimg->directory.'/'.$itineraryimg->image_name);
                            $done = $this->removeImage($this->sourcetype, $itineraryimg->itinerary_id, $itineraryimg->image_name);
                            $return['success'][] = 'Itinerary image ['.$remimg.'] succesfully removed';
                        } else {
                            $return['errors'][] = 'Can not find given Itinerary image. Image Id:'.$remimg;
                        }
                    }
                }
                return redirect('/admin/itineraries/'.$itinerary->id)->with('success', 'New itinerary images successfully updated!');
            }

            return view('backend.itinerary.updateimages', [
                'itinerary' => $itinerary,
                'existingimgs' => $existingimgs,
                'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                'resource_dir' => $fileRepo->getResourcesDirectory('images'),
            ]);
        } catch (Exception $e) {
            return view('backend.itinerary.updateimages', [
                'itinerary' => $itinerary,
                'existingimgs' => $existingimgs,
                'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                'errors' => [
                    'message' => 'Faliure in save [Exception]'
                ]
            ]);
        }
    }


    public function storeday($id, Request $request)
    {
        //'title', 'title2', 'description', 'price', 'pricestring', 'nights', 'active'
        $request->flash();
        $fileRepo = new FilesRepository;
        $itinerary = Itinerary::with('itineraryimages', 'itinerarydays')->find($id);
        if (!$itinerary) {
            return view('backend.itinerary.list', [
                'error' => [
                    'message' => 'Itinerary does not exist'
                ]
            ], 404);
        }

        if ($request->isMethod('POST')) {
            //dd($request);
            $validator = Validator::make($request->all(), [
                        'title' => 'required|max:255',
                        'description' => 'required',
            ]);

            if ($validator->fails()) {
                return view('backend.itinerary.show', [
                    'itinerary' => $itinerary,
                    'errors'=>$validator->errors(),
                    'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                    'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                ]);
            }

            $itineraryday = new Itineraryday;
            $itineraryday->itinerary_id = $id;
            $itineraryday->title = ($request->has('title')?$request->title:'');
            $itineraryday->description = ($request->has('description')?$request->description:'');
            $itineraryday->day = ($request->has('day')?$request->day:'');
            $itineraryday->active = ($request->has('active')?$request->active:1);

            $itineraryday->save();

            return redirect('/admin/itineraries/'.$id)->with('success', 'New itinerary day successfully created!');
        } else {
            return view('backend.itinerary.show', [
                    'itinerary' => $itinerary,
                    'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                    'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                ]);
        }
    }


    public function updateday($itinerary_id, $id, Request $request)
    {
        //'title', 'title2', 'description', 'price', 'pricestring', 'nights', 'active'
        $request->flash();
        $fileRepo = new FilesRepository;
        $itineraryday = Itineraryday::where('itinerary_id', '=', $itinerary_id)->where('id', '=', $id)->first();
        if (!$itineraryday) {
            return redirect('/admin/itineraries/'.$itinerary_id)->withErrors(['Unable to find given day!']);
        }

        if ($request->isMethod('PATCH')) {
            //dd($request);
            $validator = Validator::make($request->all(), [
                        'day_title' => 'required|max:255',
                        'day_description' => 'required',
            ]);

            if ($validator->fails()) {
                $itinerary = Itinerary::with('itineraryimages', 'itinerarydays')->find($itinerary_id);

                return view('backend.itinerary.show', [
                    'itinerary' => $itinerary,
                    'itiday_id' => $id,
                    'errors'=>$validator->errors(),
                    'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                    'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                ]);
            }
            $itineraryday->title = ($request->has('day_title')?$request->day_title:$itineraryday->title);
            $itineraryday->description = ($request->has('day_description')?$request->day_description:$itineraryday->description);
            $itineraryday->day = ($request->has('day_day')?$request->day_day:$itineraryday->day);
            $itineraryday->active = ($request->has('day_active')?$request->day_active:1);

            $itineraryday->save();

            return redirect('/admin/itineraries/'.$itinerary_id)->with('success', 'New itinerary day successfully updated!');
        } else {
            return redirect('/admin/itineraries/'.$itinerary_id);
        }
    }

    public function deleteday($itinerary_id, $id, Request $request)
    {
        $itineraryday = Itineraryday::where('itinerary_id', '=', $itinerary_id)->where('id', '=', $id)->first();
        if (!$itineraryday) {
            return redirect('/admin/itineraries/'.$itinerary_id)->withErrors(['Unable to find given day!']);
        }
        Itineraryday::findOrFail($id)->delete();
        return redirect('/admin/itineraries/'.$itinerary_id)->with('success', 'Itinerary day successfully deleted!');
    }
}
