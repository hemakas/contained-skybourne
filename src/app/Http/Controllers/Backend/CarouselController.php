<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\FilesRepository;

use Carbon\Carbon;
use Validator;
use Response;
use Storage;
use File;
use App\Carousel;
use App\Carouselplace;
use App\Http\Controllers\Backend\ImagesTrait;

class CarouselController extends Controller
{

    use ImagesTrait;
    
    private $sourcetype = 'carousels';
    
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
     * Display a list of all carousels.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $fileRepo = new FilesRepository;
        $limit = ($request->has('limit')?$request->limit:$this->_limit);
        $carouselplaces = Carouselplace::with('carouselfirstimage', 'carouselimages')->paginate($limit);
        return view('backend.carousel.list', [
            'carousels' => $carouselplaces,
            'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
            'resource_dir' => $fileRepo->getResourcesDirectory('images'),
        ]);
    }
        
    
    // GET
    public function show($id, Request $request)
    {
        $fileRepo = new FilesRepository;
        $carouselplaces = Carouselplace::with('carouselimages')->find($id);    //print_r($carousel->toArray());
        
        if (!$carouselplaces) {
            return view('backend.carousel.list', [
                'error' => [
                    'message' => 'Carousel does not exist'
                ]
            ], 404);
        }
        //dd($carousel->toArray());
        return view('backend.carousel.show', [
            'carousel' => $carouselplaces,
            'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
            'resource_dir' => $fileRepo->getResourcesDirectory('images'),
            //'imagepath' => $fileRepo->file_paths[$this->sourcetype], // $oImgRepo->image_path['carousels']
        ]);
    }
    
    // POST
    public function store(Request $request)
    {
        $request->flash();
        $fileRepo = new FilesRepository;
        $sourcetype = $this->sourcetype;
        
        if ($request->isMethod('POST') && $request->has('place')) {
            $validator = Validator::make($request->all(), [
                'images' => 'required',
                'place' => 'required|max:255|unique:carouselplaces,place'
            ]);

            if ($validator->fails()) {
                return view('backend.carousel.store', [
                    'errors'=>$validator->errors(),
                    'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                    'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                ]);
            }
 
            $carouselplace = new Carouselplace();
            $carouselplace->place = ($request->has('place')?$request->place:'');
            $carouselplace->active = 1;
            $carouselplace->save();
            
            // Save carousel images
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
                            $newfilename = $fileRepo->saveSourceImage($this->sourcetype, $tmpimage['tempname'], $tmpimage['tempname'], $carouselplace->place);
                            // Insert into DB
                            $carouselimg = Carousel::create([
                                            'place_id' => $carouselplace->id,
                                            'imagename' => $newfilename,
                                            'title' => ($request->has("imgtitle.$x")?$request->input("imgtitle.$x"):''),
                                            'order' => $x,
                                            'active' => 1,
                                        ]);
                            $carouselimg->save();
                            $fileRepo->deleteTempImage($this->sourcetype, $tmpimage['tempname']);
                        }
                    } //else {dd('--2--');}
                    $x++;
                }
            } //else {dd('--3--');}

            return redirect('/admin/carousels/'.$carouselplace->id)->with('success', 'New carousel created successfully!');
        } else {
            return view('backend.carousel.store', [
                    'imagepath' => $fileRepo->file_paths[$sourcetype],
                ]);
        }
    }
    
    
    // POST/PATCH
    public function update($id, Request $request)
    {
        $request->flash();
        $fileRepo = new FilesRepository;
        
        $carousel = Carouselplace::with(
            ['carouselimages' => function ($query) {
                            $query->orderBy('order', 'asc');
            }]
        )->find($id);
        if (!$carousel) {
            return redirect('/admin/carousels')->withErrors(["Unable to find this carousel images!"]);
        }

        if ($carousel->carouselimages != null) {
            $existingimgs = $carousel->carouselimages->toArray();
        }
        
        $max = Carousel::where('place_id', 5)->max('order');
        if ($max == null) {
            $max = 0;
        }
        
        try {
            if ($request->isMethod('PATCH')) {
                $validator = Validator::make($request->all(), [
                    'images' => 'required',
                    'place' => 'required|max:255|unique:carouselplaces,place,'.$id
                ]);

                if ($validator->fails()) {
                    return view('backend.carousel.update', [
                        'carousel' => $carousel,
                        'existingimgs' => $existingimgs,
                        'errors'=>$validator->errors(),
                        'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                        'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                    ]);
                }

                // updating place name
                $carousel->place = ($request->has('place')?$request->place:$carousel->place);
                $carousel->save();

                // Save carousel images
                if ($request->hasFile('images')) {
                    $files = $request->file('images');
                    //var_dump($files);
                    $x = $max;
                    foreach ($files as $file) {
                        $newfilename = '';
                        if ($file !== null) {
                            $filename = $file->getClientOriginalName();

                            $tmpimage = $fileRepo->saveImageInTemporaryLocation($this->sourcetype, $filename, $file->getRealPath());

                            if ($tmpimage['error'] !== false) {
                                $return['errors'][] = $tmpimage['message'];
                            }
                            if ($tmpimage['error'] === false && $tmpimage['tempname'] != '') {
                                $newfilename = $fileRepo->saveSourceImage($this->sourcetype, $tmpimage['tempname'], $tmpimage['tempname'], $carousel->place);
                                // Insert into DB
                                $carouselimg = Carousel::create([
                                                'place_id' => $carousel->id,
                                                'imagename' => $newfilename,
                                                'title' => ($request->has("imgtitle.$x")?$request->input("imgtitle.$x"):''),
                                                'order' => $x,
                                                'active' => 1,
                                            ]);
                                $carouselimg->save();
                                $fileRepo->deleteTempImage($this->sourcetype, $tmpimage['tempname']);
                            }
                        } //else {dd('--2--');}
                        $x++;
                    }
                } //else {dd('--3--');}

                // Remove images
                $removingimgs = ($request->has('hremimgs')?$request->hremimgs:[]);

                // Removing delete images
                if (!empty($removingimgs)) {
                    foreach ($removingimgs as $remimg) {
                            $carouselimg = Carousel::with('carouselplace')->find($remimg);

                        if ($carouselimg) {
                            $carouselimg->forceDelete();
                            //$oImgRepo->deleteImage($oImgRepo->property_image_path['property']['real_image_path'].$carouselimg->agent_id.'/'.$carouselimg->directory.'/'.$carouselimg->image_name);
                            $done = $this->removeImage($this->sourcetype, $carouselimg->carouselplace->place, $carouselimg->image_name);
                            $return['success'][] = 'Hotel image ['.$remimg.'] succesfully removed';
                        } else {
                            $return['errors'][] = 'Can not find given carousel image. Image Id:'.$remimg;
                        }
                    }
                }
                return redirect('/admin/carousels/'.$carousel->id)->with('success', 'New carousel images successfully updated!');
            }
            
            return view('backend.carousel.update', [
                'carousel' => $carousel,
                'existingimgs' => $existingimgs,
                'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                'resource_dir' => $fileRepo->getResourcesDirectory('images'),
            ]);
        } catch (Exception $e) {
            return view('backend.carousel.updateimages', [
                'carousel' => $carousel,
                'existingimgs' => $existingimgs,
                'image_dir' => $fileRepo->file_paths[$this->sourcetype]['img_dir'],
                'resource_dir' => $fileRepo->getResourcesDirectory('images'),
                'errors' => [
                    'message' => 'Faliure in save [Exception]'
                ]
            ]);
        }
    }
    
    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $carousel = Carouselplace::find($id);
            $carousel->active = $request->input('active');
            $carousel->save();
            return Response::json([
                        'data' => $request->input('active')
                    ], 200);
        }
    }


    // DELETE
    public function destroy($id, Request $request)
    {
        Carouselplace::findOrFail($id)->delete();
        return redirect('admin/carousels');
    }
}
