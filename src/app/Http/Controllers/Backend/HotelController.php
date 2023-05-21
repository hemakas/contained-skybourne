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
use App\Specialoffer;
use App\Http\Controllers\Backend\HotelTrait;
use App\Http\Controllers\Backend\ImagesTrait;

class HotelController extends Controller
{

    
    use HotelTrait;
    
    use ImagesTrait;
    
    private $sourcetype = 'hotels';
    
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
        $hotels = Hotel::with('hotelimage')->orderBy('hotelname', 'asc')->paginate($limit);
        return view('backend.hotel.list', [
            'hotels' => $hotels,
            'imagepath' => $fileRepo->file_paths[$this->sourcetype]
        ]);
    }
        
    
    // GET
    public function show($id, Request $request)//, AgentuserRepository $agtuserrepo, $id)
    {
        $fileRepo = new FilesRepository;
        $hotel = Hotel::with('country', 'facilities', 'hotelimages')->find($id);
        if (!$hotel) {
            return view('backend.hotel.list', [
                'error' => [
                    'message' => 'Hotel does not exist'
                ]
            ], 404);
        }
        //dd($hotel->toArray());
        return view('backend.hotel.show', [
            'hotel' => $hotel,
            'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
            'resource_dir' => $fileRepo->getResourcesDirectory('images'),
            //'imagepath' => $fileRepo->file_paths[$this->sourcetype], // $oImgRepo->image_path['hotels']
        ]);
    }
    
    // POST
    public function store(Request $request)
    {
        $request->flash();
        $facilities = Facility::where('active', 1)->get();
        $countries = Country::where('active', 1)->get();
        $specialoffers = Specialoffer::where('type', "hotel")->where('active', 1)->get();
        $fileRepo = new FilesRepository;
        $sourcetype = $this->sourcetype;
        
        if ($request->isMethod('POST') && $request->hotelname) {
            //dd($request);
            $validator = Validator::make($request->all(), [
                'country_id' => 'required|numeric',
                'hotelname' => 'required|max:255',
                'title' => 'required|max:255',
                'description' => 'required',
                'summary' => 'required',
                'price' => 'numeric',
                'nights' => 'numeric',
            ]);

            if ($validator->fails()) {
                return view('backend.hotel.store', [
                    'errors'=>$validator->errors(),
                    'imagepath' => $fileRepo->file_paths[$sourcetype], // $oImgRepo->image_path['hotels'],
                    'facilities' => $facilities,
                    'countries' => $countries,
                    'specialoffers' => $specialoffers,
                ]);
            }
            
            
            $similar = $this->checkHotelExist($request->agent_id, '', $request->adunique, $request->reference, '', '');
            //     echo '<pre>'; print_r($similar); dd();
            if (is_array($similar) && !empty($similar)) {
                return view('backend.hotel.store', [
                    'errors'=>$validator->errors(),
                    'similars' => $similar,
                    'imagepath' => $fileRepo->file_paths[$sourcetype], // $oImgRepo->image_path['hotels'],
                    'facilities' => $facilities,
                    'countries' => $countries,
                ])->withErrors(['There are similar hotels already existing in the system.']);
            }
                
            $hotel = new Hotel;
            $hotel->country_id = ($request->has('country_id')?$request->country_id:'0');
            $hotel->hotelname = $request->hotelname;
            $hotel->url = str_replace(" ", "-", preg_replace("/[^A-Za-z0-9\s]/", "", strtolower($request->hotelname)));
            $hotel->title = ($request->has('title')?$request->title:'');
            $hotel->description = ($request->has('description')?$request->description:'');
            $hotel->summary = ($request->has('summary')?$request->summary:'');
            $hotel->nights = ($request->has('nights')?$request->nights:'');
            $hotel->price = ($request->has('price')?$request->price:'');
            $hotel->pricestring = ($request->has('pricestring')?$request->pricestring:'');
            $hotel->specialstring = ($request->has('specialstring')?$request->specialstring:'');
            $hotel->active = ($request->has('active')?$request->active:1);
            
            $hotel->save();
            
            // Save hotel facilities
            if ($request->has('facility') && count($request->facility) > 0) {
                foreach ($request->facility as $facility) {
                    $hotel->facilities()->attach($facility);
                }
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

                        $tmpimage = $fileRepo->saveImageInTemporaryLocation($sourcetype, $filename, $file->getRealPath());

                        if ($tmpimage['error'] !== false) {
                            $return['errors'][] = $tmpimage['message'];
                        }
                        if ($tmpimage['error'] === false && $tmpimage['tempname'] != '') {
                            $newfilename = $fileRepo->saveSourceImage($sourcetype, $tmpimage['tempname'], $tmpimage['tempname'], $hotel->id);
                            // Insert into DB
                            $hotelimg = Hotelimage::create([
                                            'hotel_id' => $hotel->id,
                                            'imagename' => $newfilename,
                                            'title' => ($request->has("imgtitle.$x")?$request->input("imgtitle.$x"):''),
                                            'order' => $x,
                                            'active' => 1,
                                        ]);
                            $hotelimg->save();
                            $fileRepo->deleteTempImage($sourcetype, $tmpimage['tempname']);
                        }
                        
                        
                        /*
                        //$file = $request->file('icon');
                        $filename = $file->getClientOriginalName();echo('--f--'.$filename);
                        $extension = File::extension($filename);
                        $current_time = Carbon::now()->timestamp;
                        $newfilename = $current_time."_".rand(0, 999)."_".$hotel->id.".".$extension;
                        Storage::disk('upload')->put($filename, File::get($file->getRealPath()));
                        if($newfilename !== ''){
                            //if(!File::isDirectory(public_path().$oImgRepo->image_path['hotels']['img_dir'].$hotel->id.'/')){
                            if(!Storage::disk('public')->has($oImgRepo->image_path['hotels']['img_dir'].$hotel->id.'/')){
                                Storage::disk('public')->makeDirectory($oImgRepo->image_path['hotels']['img_dir'].$hotel->id.'/');
                            }
                            $exists = Storage::disk('public')->has($oImgRepo->image_path['hotels']['img_dir'].$hotel->id.'/'.$newfilename);
                            if($exists){
                                Storage::disk('public')->delete($oImgRepo->image_path['hotels']['img_dir'].$hotel->id.'/'.$newfilename);
                            }
                            Storage::disk('public')->move('uploaded/'.$filename, 'hotels/'.$hotel->id.'/'.$newfilename);
                            //Storage::move(storage_path('app/public/uploaded/').$filename, $oImgRepo->image_path['facilities']['img_dir'].$newfilename);

                            // Insert into DB
                            $hotelimg = Hotelimage::create([
                                            'hotel_id' => $hotel->id,
                                            'imagename' => $newfilename,
                                            'title' => ($request->has("imgtitle.$x")?$request->input("imgtitle.$x"):''),
                                            'order' => $x,
                                            'active' => 1,
                                        ]);
                            $hotelimg->save();
                        }
                        */
                    } //else {dd('--2--');}
                    $x++;
                }
            } //else {dd('--3--');}

            return redirect('/admin/hotels/'.$hotel->id)->with('success', 'New hotel created successfully!');
        } else {
            return view('backend.hotel.store', [
                    'imagepath' => $fileRepo->file_paths[$sourcetype], // $oImgRepo->image_path['hotels'],
                    'facilities' => $facilities,
                    'countries' => $countries,
                    'specialoffers' => $specialoffers,
                ]);
        }
    }
    
    
    // POST/PATCH
    public function update($id, Request $request)
    {
        $request->flash();
        $facilities = Facility::where('active', 1)->get();
        $countries = Country::where('active', 1)->get();
        $specialoffers = Specialoffer::where('type', "hotel")->where('active', 1)->get();
        $fileRepo = new FilesRepository;
        $sourcetype = $this->sourcetype;
        
        $hotel = Hotel::findOrFail($id);
        //if($request->hotelname){
        if ($request->isMethod('PATCH')) {
            $validator = Validator::make($request->all(), [
                'hotelname' => 'required|max:255',
                'title' => 'required|max:255',
                'description' => 'required',
                'summary' => 'required',
                'price' => 'numeric',
                'nights' => 'numeric',
            ]);

            if ($validator->fails()) {
                return view('backend.hotel.update', [
                    'hotel' => $hotel,
                    'errors'=>$validator->errors(),
                    'imagepath' => $fileRepo->file_paths[$this->sourcetype],
                    'facilities' => $facilities,
                    'countries' => $countries,
                    'specialoffers' => $specialoffers,
                ]);
            }

            try {
                $hotel = Hotel::find($id);
                $hotel->country_id = ($request->has('country_id')?$request->country_id:$hotel->country_id);
                $hotel->hotelname = ($request->has('hotelname')?$request->hotelname:$hotel->hotelname);
                $hotel->url = str_replace(" ", "-", preg_replace("/[^A-Za-z0-9\s]/", "", strtolower($request->hotelname)));
                $hotel->title = ($request->has('title')?$request->title:$hotel->title);
                $hotel->description = ($request->has('description')?$request->description:$hotel->description);
                $hotel->summary = ($request->has('summary')?$request->summary:$hotel->summary);
                $hotel->price = ($request->has('price')?$request->price:$hotel->price);
                $hotel->pricestring = ($request->has('pricestring')?$request->pricestring:$hotel->pricestring);
                $hotel->nights = ($request->has('nights')?$request->nights:$hotel->nights);
                $hotel->specialstring = ($request->has('specialstring')?$request->specialstring:$hotel->specialstring);
                $hotel->active = ($request->has('active')?$request->active:0);
                                

                // Save hotel facilities
                if ($request->has('facility') && count($request->facility) > 0) {
                    $hotel->facilities()->sync($request->facility);
                }
                $hotel->save();


                return redirect('/admin/hotels/'.$id)->with('success', 'Hotel details updated successfully!');
            } catch (Exception $e) {
                return view('backend.hotel.update', [
                    'hotel' => $hotel,
                    'imagepath' => $fileRepo->file_paths[$this->sourcetype],
                    'facilities' => $facilities,
                    'countries' => $countries,
                    'specialoffers' => $specialoffers,
                    'errors' => [
                        'message' => 'Faliure in save [Exception]'
                    ]
                ]);
            }
        } else {
            return view('backend.hotel.update', [
                'hotel' => $hotel,
                    'imagepath' => $fileRepo->file_paths[$this->sourcetype],
                    'facilities' => $facilities,
                    'countries' => $countries,
                    'specialoffers' => $specialoffers,
            ]);
        }
    }
    
    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $hotel = Hotel::find($id);
            $hotel->active = $request->input('active');
            $hotel->save();
            return Response::json([
                        'data' => $request->input('active')
                    ], 200);
        }
    }


    // DELETE
    public function destroy($id, Request $request)
    {
        Hotel::findOrFail($id)->delete();
        return redirect('admin/hotels');
    }
    
    
    // IMAGES UPDATE
    public function images($id, Request $request)
    {
        $request->flash();
        $fileRepo = new FilesRepository;
        
        $hotel = Hotel::with(
            ['hotelimages' => function ($query) {
                            $query->orderBy('order', 'asc');
            }]
        )->find($id);
        if (!$hotel) {
            return redirect('/admin/hotels')->withErrors(["Unable to find this hotel images!"]);
        }

        if ($hotel->hotelimages != null) {
            $existingimgs = $hotel->hotelimages->toArray();
        }
        try {
            //if($request->hotelname){
            if ($request->isMethod('PATCH')) {
                $validator = Validator::make($request->all(), [
                    'images' => 'required',
                ]);

                if ($validator->fails()) {
                    return view('backend.hotel.update', [
                        'hotel' => $hotel,
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
                                $newfilename = $fileRepo->saveSourceImage($this->sourcetype, $tmpimage['tempname'], $tmpimage['tempname'], $hotel->id);
                                // Insert into DB
                                $hotelimg = Hotelimage::create([
                                                'hotel_id' => $hotel->id,
                                                'imagename' => $newfilename,
                                                'title' => ($request->has("imgtitle.$x")?$request->input("imgtitle.$x"):''),
                                                'order' => $x,
                                                'active' => 1,
                                            ]);
                                $hotelimg->save();
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
                            $hotelimg = Hotelimage::find($remimg);

                        if ($hotelimg) {
                            $hotelimg->forceDelete();
                            //$oImgRepo->deleteImage($oImgRepo->property_image_path['property']['real_image_path'].$hotelimg->agent_id.'/'.$hotelimg->directory.'/'.$hotelimg->image_name);
                            $done = $this->removeImage($this->sourcetype, $hotelimg->hotel_id, $hotelimg->image_name);
                            $return['success'][] = 'Hotel image ['.$remimg.'] succesfully removed';
                        } else {
                            $return['errors'][] = 'Can not find given hotel image. Image Id:'.$remimg;
                        }
                    }
                }
                return redirect('/admin/hotels/'.$hotel->id)->with('success', 'New hotel images successfully updated!');
            }
            
            return view('backend.hotel.updateimages', [
                'hotel' => $hotel,
                'existingimgs' => $existingimgs,
                'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                'resource_dir' => $fileRepo->getResourcesDirectory('images'),
            ]);
        } catch (Exception $e) {
            return view('backend.hotel.updateimages', [
                'hotel' => $hotel,
                'existingimgs' => $existingimgs,
                'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                'errors' => [
                    'message' => 'Faliure in save [Exception]'
                ]
            ]);
        }
    }
    
    
    
    
    private function transform($hotel)
    {
        
        return [
                'id' => $hotel['id'],
                'hotelname' => $hotel['hotelname'],
                'icon' => $hotel['icon'],
        ];
    }
}
