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
use App\Facility;

class FacilityController extends Controller
{
    /**
     *
     * @var FacilityRepository
     */
    protected $facility;
    
    private $sourcetype = 'facilities';
    
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
     * Display a list of all facilities.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $limit = ($request->has('limit')?$request->limit:$this->_limit);
        $facilities = Facility::orderBy('name', 'asc')->paginate($limit);
        $oImgRepo = new ImagesRepository;
        return view('backend.facility.list', [
            'facilities' => $facilities,
            'imagepath' => $oImgRepo->image_path['facilities']
        ]);
    }
        
    
    // GET
    public function show($id, Request $request)//, AgentuserRepository $agtuserrepo, $id)
    {
        $facility = Facility::find($id);
        if (!$facility) {
            return view('backend.facility.list', [
                'error' => [
                    'message' => 'Facility does not exist'
                ]
            ], 404);
        }
        $oImgRepo = new ImagesRepository;
        return view('backend.facility.show', [
            'facility' => $facility,
            'imagepath' => $oImgRepo->image_path['facilities']
        ]);
    }
    
    // POST
    public function store(Request $request)
    {
        $request->flash();
        if ($request->name) {
            $fileRepo = new FilesRepository;
            $oImgRepo = new ImagesRepository;
            $uploadImgOk = true;
                
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'icon' => 'required_without:boostrapicon',
                'order' => 'numeric',
            ]);

            if ($validator->fails()) {
                return view('backend.facility.store', [
                    'errors'=>$validator->errors(),
                    'imagepath' => $fileRepo->file_paths['facilities']
                ]);
            }

            $facility = new Facility;
            $facility->name = $request->name;
            $facility->boostrapicon = ($request->has('boostrapicon')?$request->boostrapicon:'');
            $facility->order = ($request->has('order')?$request->order:1);
            $facility->active = ($request->has('active')?$request->active:1);
            if ($facility->boostrapicon == '' && $request->icon != null) {
                    //$file = Input::file('icon');
                    $file = $request->file('icon');
                    
                    $newfilename = '';

                    $filename = $file->getClientOriginalName();

                    $tmpimage = $fileRepo->saveImageInTemporaryLocation($this->sourcetype, $filename, $file->getRealPath());

                if ($tmpimage['error'] !== false) {
                    $return['errors'][] = $tmpimage['message'];
                }
                if ($tmpimage['error'] === false && $tmpimage['tempname'] != '') {
                    $newfilename = $fileRepo->saveSourceImage($this->sourcetype, $tmpimage['tempname'], $tmpimage['tempname'], "");
                    $fileRepo->resizeImage($this->sourcetype, storage_path('app/public/facilities/').$newfilename);
                    $facility->icon = $newfilename;
                        
                    $fileRepo->deleteTempImage($this->sourcetype, $tmpimage['tempname']);
                } else {
                    $uploadImgOk = false;
                }
                    
                    
                    $facility->icon = $newfilename;
                    //Storage::move(storage_path('app/public/uploaded/').$filename, $oImgRepo->image_path['facilities']['img_dir'].$newfilename);
            } else {
                $facility->icon = '';
            }
            
            if ($uploadImgOk === false) {
                return view('backend.facility.update', [
                    'facility' => $facility,
                    'imagepath' => $fileRepo->file_paths['facilities'],
                    'errors' => [
                        'message' => 'Error on Icon image upload!'
                    ]
                ]);
            }
            $facility->save();

            return redirect('/admin/facilities')->with('success', 'New facility created successfully!');
        } else {
            return view('backend.facility.store');
        }
    }
    
    
    // POST/PATCH
    public function update($id, Request $request)
    {
        $request->flash();
        $oImgRepo = new ImagesRepository;
        $fileRepo = new FilesRepository;
        $facility = Facility::findOrFail($id);
        //if($request->name){
        if ($request->isMethod('PATCH')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'icon' => 'required_without:boostrapicon',
                'order' => 'numeric',
            ]);

            if ($validator->fails()) {
                return view('backend.facility.update', [
                    'facility' => $facility,
                    'errors'=>$validator->errors(),
                    'imagepath' => $fileRepo->file_paths['facilities']
                ]);
            }


            try {
                $facility = Facility::find($id);
                $facility->name = ($request->has('name')?$request->name:$facility->name);
                //$facility->icon = ($request->has('exticon')?$request->exticon:$facility->icon);
                $facility->boostrapicon = ($request->has('boostrapicon')?$request->boostrapicon:'');
                $facility->order = ($request->has('order')?$request->order:1);
                $facility->active = ($request->has('active')?$request->active:1);
                $uploadImgOk = true;
                
                if ($facility->boostrapicon == '' && $request->icon != null) {
                    //$file = Input::file('icon');
                    $file = $request->file('icon');
                    /*
                    $filename = $file->getClientOriginalName();

                    $p = explode('app', $fileRepo->file_paths['file_upload_path']); // $oImgRepo->image_path['facilities']['image_real_path']

                    $facilitypath = (isset($p[1])?trim($p[1],'/'):'');

                    $path = $facilitypath."/".$filename;
                    //dd($path);
                    $extension = File::extension($filename);
                    $newfilename = $facility->id."_".$facility->name.".".$extension;
                    Storage::disk('upload')->put($filename, File::get($file->getRealPath()));
                    $exists = Storage::disk('public')->has($fileRepo->file_paths['facilities']['img_dir'].$newfilename);

                    if($exists){
                        Storage::disk('public')->delete($fileRepo->file_paths['facilities']['img_dir'].$newfilename);
                    }
                    Storage::disk('public')->move('uploaded/'.$filename, 'facilities/'.$newfilename);
                    //$fileRepo->saveFacilitiesImage('uploaded/'.$filename, 'facilities/123_'.$newfilename);
                    $facility->icon = $newfilename;
                    //Storage::move(storage_path('app/public/uploaded/').$filename, $oImgRepo->image_path['facilities']['img_dir'].$newfilename);
                    */
                    //=====================================
                    
                    $newfilename = '';

                    $filename = $file->getClientOriginalName();

                    $tmpimage = $fileRepo->saveImageInTemporaryLocation($this->sourcetype, $filename, $file->getRealPath());

                    if ($tmpimage['error'] !== false) {
                        $return['errors'][] = $tmpimage['message'];
                    }
                    if ($tmpimage['error'] === false && $tmpimage['tempname'] != '') {
                        $newfilename = $fileRepo->saveSourceImage($this->sourcetype, $tmpimage['tempname'], $tmpimage['tempname'], "");
                        $fileRepo->resizeImage($this->sourcetype, storage_path('app/public/facilities/').$newfilename);
                        $facility->icon = $newfilename;
                        
                        $fileRepo->deleteTempImage($this->sourcetype, $tmpimage['tempname']);
                    } else {
                        $uploadImgOk = false;
                    }
                    //======================================
                } else {
                    $facility->icon = ($request->has('exticon')?$request->exticon:'');
                }
                
                if ($uploadImgOk === false) {
                    return view('backend.facility.update', [
                        'facility' => $facility,
                        'imagepath' => $fileRepo->file_paths['facilities'],
                        'errors' => [
                            'message' => 'Error on Icon image upload!'
                        ]
                    ]);
                }
                $facility->save();

                return redirect('/admin/facilities');
            } catch (Exception $e) {
                return view('backend.facility.update', [
                    'facility' => $facility,
                    'imagepath' => $fileRepo->file_paths['facilities'],
                    'errors' => [
                        'message' => 'Faliure in save [Exception]'
                    ]
                ]);
            }
        } else {
            return view('backend.facility.update', [
                'facility' => $facility,
                'imagepath' => $fileRepo->file_paths['facilities']
            ]);
        }
    }
    
    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $facility = Facility::find($id);
            $facility->active = $request->input('active');
            $facility->save();
            return Response::json([
                        'data' => $request->input('active')
                    ], 200);
        }
    }


    // DELETE
    public function destroy($id, Request $request)
    {
        Facility::findOrFail($id)->delete();
        return redirect('admin/facilities');
    }
    
    private function transform($facility)
    {
        
        return [
                'id' => $facility['id'],
                'name' => $facility['name'],
                'icon' => $facility['icon'],
        ];
    }
}
