<?php
/**
 *	Name	: FilesRepository Class
 *	Project	: Property EAT Digi
 *	Creator	: S. Kaushalye
 *	Date	: 14-12-2016
 *	Desc	: This class consits of utility functions handle files
 *	Version	: 01.00
 */

namespace App\Repositories;
use File;
use Storage;
use Image;
use App\Repositories\ImagesRepository;

class FilesRepository
{

    public $file_paths =    [
                                'resource_url' => "http://skywings.local/public/images/",
                                'resource_dir' => "uploaded/images/",
                                'directory_paths' => [ 
                                                    'images' => "upload/images/",
                                                    ],
                                'file_upload_path' => "/storage/app/public/uploaded/",
                                'msgattachements' => [
                                    'upload_dir' => 'uploaded/attachments/',
                                    'upload_path' => '/uploaded/attachments/', 
                                    'url' => 'http://skywings.local/uploaded/attachments/',
                                ],
                                
                            ];
    
    public $min_width = 400;
    public $min_height = 300;
    public $max_width = 1024;
    public $max_height = 1024;
    public $jpegQuality = 80;
    public $pngQuality = 9;
    public $genfilekey = false;
    
    private $oImageRepo = null;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $oImgRepo = new ImagesRepository;
        $this->oImageRepo = $oImgRepo;
        $this->file_paths = array_merge_recursive($this->file_paths, $oImgRepo->image_path);
        //echo '<pre>'; print_r($this->file_paths);echo '</pre>'; dd();
    }
    
    
    /**
     * Get file server type
     * @return string
     */
    public function getStorageType()
    {
        return 'static';
    }
    
    /**
     * URL of resources (images, files, ...)
     * @return string url
     */
    public function getResourcesUrl()
    {
        return $this->file_paths['resource_url'];
    }
    
    
    /**
     * Root path of resources (images, files, ...)
     * @return string url
     */
    public function getResourcesDirectory($resource_type = 'images')
    {
        return $this->file_paths['directory_paths'][$resource_type];
    }
    
    
    /**
     * Root directory path of resources (images, files, ...)
     * aws - s3://bucketname/
     * @return string url
     */
    public function getResourcesRootPath()
    {
        return $this->file_paths['file_resource_path'];
    }
    
    
    /**
     * URL of property images (images, files, ...)
     * @return string url
     */
    public function getSourceImagesUrl($sourcetype)
    {
        return rtrim($this->file_paths['resource_url'], '/').'/'.$this->file_paths[$sourcetype]['img_dir'];
    }
    
    
    /**
     * URL of agent images (logo)
     * @return string url
     */
    public function getAgentImagesUrl()
    {
        return rtrim($this->file_paths['resource_url'], '/').'/'.$this->oImageRepo->property_image_path['agent']['img_agents_dir'];
    }
    
    
    /**
     * URL of agent-user profile images
     * @return string url
     */
    public function getProfileAgentuserImagesUrl()
    {
        return rtrim($this->file_paths['resource_url'], '/').'/'.$this->oImageRepo->property_image_path['agentusers']['profile']['profilepic_dir'];
    }
    
    
    /**
     * URL of customer profile images
     * @return string url
     */
    public function getProfileCustomerImagesUrl()
    {
        return rtrim($this->file_paths['resource_url'], '/').'/'.$this->oImageRepo->property_image_path['customers']['profile']['profilepic_dir'];
    }
    
    
    /**
     * URL of cms-user profile images
     * @return string url
     */
    public function getProfileCmsuserImagesUrl()
    {
        return rtrim($this->file_paths['resource_url'], '/').'/'.$this->oImageRepo->property_image_path['cmsusers']['profile']['profilepic_dir'];
    }
    
    
    /**
     * 
     * @param string $oldfilepath
     * @param string $newfilepath 
     * @return boolean/array
     */
    public function moveFile($oldfilepath, $newfilepath){
        if ( ! File::move($oldfilepath, $newfilepath))
        {
            return [false, 'message' => 'Unable to move file to given location.'];
        } else {
            return true;
        }
    }
    
    /**
     * Delete file/s from resources
     * @param string $files
     */
    public function deleteFile($files) {
        if(!is_array($files)){
            $files = [$files];
        }
        Storage::disk('resources')->delete($files);
    }
    
    
    /**
     * Create a directory with predecesor directories if not exists
     * @param string $path_to_directory
     * @return boolean
     */
    public function createDirectory($path_to_directory){
        if (!File::exists($path_to_directory)){  
            //return File::makeDirectory(rtrim($path_to_directory, '/'), 0755, true);
            Storage::makeDirectory($path_to_directory);
        }
        Storage::disk('resources')->makeDirectory($directory);
        return true;
    }
    
    
    public function getUniqueKeyOfFile($srcImagePath){
        try {            
            if($srcImagePath != ''){
                return @md5_file($srcImagePath);
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }

    }

    
    /**
     * Get generic name for file
     * @param string $srcImagePath
     * @param int $prefix ($propertyId for property images)
     * @return string
     */
    public function getRenameFile($srcImagePath, $prefix){
        $path_parts = pathinfo($srcImagePath);
        if(strlen($path_parts['extension']) > 4){
            $ext = strtolower($path_parts['extension']);
            if(substr($ext, 0, 4) == 'jpeg'){
                $extension = 'jpeg';
            } elseif(substr($ext, 0, 4) == 'docx'){
                $extension = 'docx';
            } elseif(substr($ext, 0, 4) == 'tiff'){
                $extension = 'tiff';
            } elseif(substr($ext, 0, 3) == 'jpg'){
                $extension = 'jpg';
            } elseif(substr($ext, 0, 3) == 'png'){
                $extension = 'png';
            } elseif(substr($ext, 0, 3) == 'gif'){
                $extension = 'gif';
            } elseif(substr($ext, 0, 3) == 'pdf'){
                $extension = 'pdf';
            } elseif(substr($ext, 0, 3) == 'doc'){
                $extension = 'doc';
            }
        } else {
            $extension = $path_parts['extension'];
        }
        return $prefix.'_'.strtotime('NOW').'_'.rand(0,99).'.'.$extension;
    }
    
    /**
     * Get file size by Kb
     * @param string $pathtoimage
     * @return int
     */
    public function getFileSize($pathtofile = '', $size = ''){
        try {
            
            if($size == ''){
                $size = @filesize($pathtofile);
            }
            $sizekb = (int)($size/1000);
            return $sizekb;
        
        } catch (Exception $ex) {
            return (-1);
        }
    }
    
    
    /**
     * Save base64 encoded string into a file in given path
     * @param string $base64_string
     * @param string $output_file
     * @return String file path or false in fail
     */
    public function base64ToFile($base64_string, $output_file) {
        try {
            $ifp = fopen($output_file, "wb"); 

            $data = explode(',', $base64_string);

            fwrite($ifp, base64_decode(isset($data[1])?$data[1]:$data[0])); 
            fclose($ifp); 

            return $output_file; 
            
        } catch (Exception $ex) {
            return false;
        }
    }
    
    
    /**
     * Create a file from given base64 encoded bytecode in temporary location and move to given path [with rename]
     * @param string $base64_string : base64_encode(file_content);
     * @param string $filename : uploading file name
     * @param string $tmp_filepath : path to uploaded/ directory (or other temporary file uploading path)
     * @param string $saveto_filepath : final file saving path
     * @param boolean $rename : true - rename, false - don't rename
     * @param string $prefix : prefix to rename
     * @return string : new_file_path.renamed_file.ext
     */
    public function saveFile($base64_string,  $filename, $tmp_filepath, $saveto_filepath, $rename = true, $prefix = ''){
        try {
            
            $path = Storage::disk('resources')->url($tmp_filepath.$filename);
            
            $ext = pathinfo($path, PATHINFO_EXTENSION);
        
            if($rename == true){
                $rename = $prefix.date('Ymdhis').rand(0, 999).'.'.$ext;
            } else {
                $rename = pathinfo($path, PATHINFO_BASENAME);
            }
            
            // If send 64encoded byte stream
            if($base64_string != ''){
                if(!Storage::disk('resources')->exists($saveto_filepath.$rename)){
                //if (File::exists($saveto_filepath.$request->document)){
                    Storage::disk('resources')->delete($saveto_filepath.$rename);
                }

                // Upload file to temp directory
                $data = explode(',', $base64_string);
                $file_bytes = base64_decode(isset($data[1])?$data[1]:$data[0]);
                Storage::disk('resources')->put($saveto_filepath.$rename, $file_bytes);
            } else {
                // File uploaded, not byte stream
                Storage::disk('resources')->put($saveto_filepath.$rename, $tmp_filepath.$filename);
            }
            

            unset($file_bytes);
            return $saveto_filepath.$rename;
        } catch (Exception $ex) {
            return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
        }
    }
    
    
    /**
     * Save image
     * 
     * @param string $sourcetype :  Hotel | Itinerary
     * @param string $sourcefilename
     * @param string $uploadfilerealpath
     * @return boolean|string
     */
    public function saveImageInTemporaryLocation($sourcetype, $sourcefilename, $uploadfilerealpath){
        try {
            $return = ['error'=>false, 'message'=>"", 'size'=>"", 'uploadname'=>$sourcefilename, 'tempname'=>"", 'key'=>"" ];
            $tempname = strtotime('NOW').'_'.rand(0, 999).'_'.$sourcefilename;
            
            $img_upload_dir = (isset($this->file_paths[$sourcetype]['img_upload_dir'])?$this->file_paths[$sourcetype]['img_upload_dir']:$this->oImageRepo->image_path[$sourcetype]['img_upload_dir']);
            Storage::disk('resources')->put($img_upload_dir.$tempname, File::get($uploadfilerealpath));
            
            $image_bytes = Storage::disk('resources')->get($img_upload_dir.$tempname);
            $min_width = $this->oImageRepo->image_settings[$sourcetype]['min_width'];
            $min_height = $this->oImageRepo->image_settings[$sourcetype]['min_height'];
            
            $image_normal = Image::make($image_bytes);
            $img_width = $image_normal->width();
            $img_height = $image_normal->height();
            if($img_width < $min_width || $img_height < $min_height){
                Storage::disk('resources')->delete($img_upload_dir.$tempname);
                unset($image_bytes);
                unset($image_normal);
                $return['error'] = true;
                $return['message'] = 'Image too small. Requirement min width:'.$min_width.' min height:'.$min_height.'  - '.$sourcefilename;
                return $return;
            }
                    
            // If more than max w & h, fit it to given max dimensions 
            $max_width = $this->oImageRepo->image_settings[$sourcetype]['max_width'];
            $max_height = $this->oImageRepo->image_settings[$sourcetype]['max_height'];
            if($img_width > $max_width || $img_height > $max_height){
                
                $ratio = $img_width/$img_height;
                // for widen image 4:3
                if($ratio > 1)
                {
                    // Fit the img to ratio of 4:3, based on the height
                    $image_normal = Image::make($image_bytes)->resize($max_width,null, function ($constraint) {
                                                        $constraint->aspectRatio();
                                                        $constraint->upsize();});
                } 
                else
                {
                    // For highten image 3:4
                    // Fit the img to ratio of 4:3, based on the height
                    $image_normal = Image::make($image_bytes)->resize(null, $max_height, function ($constraint) {
                                                        $constraint->aspectRatio();
                                                        $constraint->upsize();});
                }
            }
                        
            $image_normal = $image_normal->stream();
            Storage::disk('resources')->put($img_upload_dir.$tempname, $image_normal->__toString());
            
            // Get file size after resize
            $size = Storage::disk('resources')->size($img_upload_dir.$tempname);
            $return['size'] = $size;
            if($size > $this->oImageRepo->image_settings[$sourcetype]['max_filesize']){
                // If image greater than 2Mb, remove it
                Storage::disk('resources')->delete($img_upload_dir.$tempname);
                unset($image_bytes);
                unset($image_normal);
                $return['error'] = true;
                $return['message'] = 'Image too heavy. Maximum image capacity would be 2Mb. - '.$sourcefilename;
                return $return;
            }
            $return['tempname'] = $tempname;
            
            // Get file key
            if($this->genfilekey === true && $return['error'] === false){
                $key = $this->oImageRepo->getUniqueKeyOfFile($this->file_paths[$sourcetype]['image_upload_path'].$tempname);
                $return['key'] = $key;
            }
            
            unset($image_bytes);
            unset($image_normal);
            return $return;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    
    /**
     * Save file in given path [with resizing][with renaming][with thumb]
     * @param string $base64_string : base64_encode(file_content);
     * @param string $filename : uploading file name
     * @param string $tmp_imagepath : path to uploaded/ directory (or other temporary file uploading path)
     * @param string $saveto_filepath : final file saving path
     * @param boolean $rename : true - rename, false - don't rename
     * @param string $prefix : prefix to rename
     * @param int $width : resize width 
     * @param int $height : resize height
     * @param array $thumb : $thumb = [path = $this->file_paths['agentusers']['profile']['profilepic_dir'].'thumbnails/', 
    //          width = 100
    //          height = 100
     *          crop = [width, height, (x), (y)] ]
     * @param array $crop : [width, height, (x), (y)]
     * @return string
     */
    public function saveImageFile($base64_string,  $filename, $tmp_imagepath, $saveto_filepath, $rename = true, $prefix = '', $width = null, $height = null, $thumb = array(), $crop = array() )
    {
        try {
            //dd($tmp_imagepath.$filename.' >> '.$saveto_filepath);
            $path = Storage::disk('resources')->url($tmp_imagepath.$filename);
            
            $ext = pathinfo($path, PATHINFO_EXTENSION);
          
            if($rename == true){
                $rename = $prefix.date('Ymdhis').rand(0, 999).'.'.$ext;
            } else {
                $rename = pathinfo($path, PATHINFO_BASENAME);
            }
            
            // If send 64encoded byte stream
            if($base64_string != ''){
                if(!Storage::disk('resources')->exists($tmp_imagepath.$filename)){
                //if (File::exists($this->file_paths['agentusers']['profile']['image_upload_path'].$request->profilepic)){
                    Storage::disk('resources')->delete($tmp_imagepath.$filename);
                }

                // Upload file to temp directory
                $data = explode(',', $base64_string);

                $image_bytes = base64_decode(isset($data[1])?$data[1]:$data[0]);
                //Storage::disk('resources')->put($tmp_imagepath, $image_bytes );
            } else {
                // File uploaded, not byte stream
                $image_bytes = Storage::disk('resources')->get($tmp_imagepath.$filename);
            }

            if($width > 0 && $height > 0){
                // Create & resize the image to given fixed width & height
                $image_normal = Image::make($image_bytes)->resize($width,$height);
            } elseif($width > 0 && $height == null) {
                // Resize image proportionally to given width
                $image_normal = Image::make($image_bytes)->widen($width);
            } elseif($width == null && $height > 0) {
                // Resize image proportionally to given height
                $image_normal = Image::make($image_bytes)->heighten($height);
            } else {
                $image_normal = Image::make($image_bytes);
            }
            
            // Crop
            if(isset($crop['width']) && $crop['width'] > 0 && isset($crop['height']) && $crop['height'] > 0){
                if(isset($crop['x']) && $crop['x'] > 0 && isset($crop['y']) && $crop['y'] > 0){
                    $image_normal = $image_normal->crop($crop['width'],$crop['height'], $crop['x'], $crop['y']);
                } else {
                    $image_normal = $image_normal->crop($crop['width'],$crop['height']);
                }
            }
             
            /*
            // create instance
            $img = Image::make($image_bytes);
            $img->resize(300, 300);
            
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }); */

            $image_normal = $image_normal->stream();

            // if set $thumb[path] to create thumb 
            if(isset($thumb['path'])){
                if(isset($thumb['width']) && $thumb['width'] > 0 && isset($thumb['height']) && $thumb['height'] != null){
                    $image_thumb = Image::make($image_bytes)->resize($thumb['width'],$thumb['height']);
                    $image_thumb = $image_thumb->stream();
                } elseif(isset($thumb['width']) && $thumb['width'] > 0 && 
                        (!isset($thumb['height']) || $thumb['height'] == null)){
                    $image_thumb = Image::make($image_bytes)->widen($thumb['width']);
                } elseif(isset($thumb['height']) && $thumb['height'] > 0 && 
                        (!isset($thumb['width']) || $thumb['width'] == null)){
                    $image_thumb = Image::make($image_bytes)->heighten($thumb['height']);
                } else {
                    $image_thumb = Image::make($image_bytes);
                }
                
                // Crop thumb
                if(isset($thumb['crop']['width']) && $thumb['crop']['width'] > 0 && isset($thumb['crop']['height']) && $thumb['crop']['height'] > 0){
                    if(isset($thumb['crop']['x']) && $thumb['crop']['x'] > 0 && isset($thumb['crop']['y']) && $thumb['crop']['y'] > 0){
                        $image_thumb = $image_thumb->crop($thumb['crop']['width'],$thumb['crop']['height'], $thumb['crop']['x'], $thumb['crop']['y']);
                    } else {
                        $image_thumb = $image_thumb->crop($thumb['crop']['width'],$thumb['crop']['height']);
                    }
                }

                $image_thumb = $image_thumb->stream();
                Storage::disk('resources')->put($thumb['path'].$rename, $image_thumb->__toString());

                unset($image_thumb);
            }
            
            Storage::disk('resources')->put($saveto_filepath.$rename, $image_normal->__toString());

            unset($image_bytes);
            unset($image_normal);
            
            return $saveto_filepath.$rename;
        } catch (Exception $ex) {
            return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
        }
    }
    
    
    /**
     * Move property images to actual directory
     * @param string $tempfilename: file name in temp directory
     * @param string $newfilename: renamed name
     * @param string $destinationPath: path to image destination folder from images/properties/. Ex: 17889/32
     * @return string : renamed image name
     */
    public function saveSourceImage($sourcetype, $tempfilename, $newfilename, $destinationPath){
        try {
            $destinationPath = rtrim($destinationPath, '/').'/';
            if(!Storage::disk('resources')->has($this->file_paths[$sourcetype]['img_dir'].rtrim($destinationPath, '/').'/')){
                Storage::disk('resources')->makeDirectory($this->file_paths[$sourcetype]['img_dir'].rtrim($destinationPath, '/').'/');
            }
            $exists = Storage::disk('resources')->has($this->file_paths[$sourcetype]['img_dir'].rtrim($destinationPath, '/').'/'.$newfilename);
            if($exists){
                Storage::disk('resources')->delete($this->file_paths[$sourcetype]['img_dir'].rtrim($destinationPath, '/').'/'.$newfilename);
            }

            Storage::disk('resources')->move($this->file_paths[$sourcetype]['img_upload_dir'].$tempfilename, 
                                            $this->file_paths[$sourcetype]['img_dir'].rtrim($destinationPath, '/').'/'.$newfilename);
            return $newfilename;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    public function resizeImage($sourcetype, $imagepath)
    {
        $img_width = $this->oImageRepo->image_settings[$sourcetype]['img_width'];
        $img_height = $this->oImageRepo->image_settings[$sourcetype]['img_height'];
        Image::make($imagepath)->resize($img_width, $img_height)->save($imagepath);
    }
    
    
    public function deleteTempImage($sourcetype, $tempfilename){
        Storage::disk('resources')->delete($this->file_paths[$sourcetype]['img_upload_dir'].$tempfilename);
    }
    
    
    /**
     * ========================================
     * ===== AGENTUSER SPECIAL FUNCTIONS ======
     * ========================================
     */
    
    public function saveFacilitiesImage($picture_location, $picture_save)
    {
        try {
            $imgWidth = $this->oImageRepo->image_settings['facilities']['min_width'];
            $imgHeight = $this->oImageRepo->image_settings['facilities']['min_height'];
            
        $this->oImageRepo->imageMoveAndResize($picture_location, $picture_save, $imgWidth, $imgHeight, true);
        } catch (Exception $ex) {
            return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
        }
    }
    
    /**
     * Upload Agents' profile picture
     * @param base64 encoded byte stream $base64_string
     * @param string $filename
     * @param string $prefix
     * @param string $uploadingtmpfilepath: File::get($file->getRealPath())
     * @return type
     */
    public function saveUserPic($base64_string, $filename, $prefix = '', $uploadingtmpfilepath = '')
    {
        try {
            $imgWidth = $this->oImageRepo->image_settings['agentusers']['profile']['max_width'];
            $imgHeight = $this->oImageRepo->image_settings['agentusers']['profile']['max_height'];
            
            // if file uploading 
            if($uploadingtmpfilepath != ''){
                $filename = date('Ymdhis').$filename;
                Storage::disk('upload')->put($this->file_paths['agentusers']['profile']['upload_dir'].$filename, $uploadingtmpfilepath);
                $base64_string = '';
            }
            
            $newfilepath = $this->saveImageFile($base64_string, $filename, $this->file_paths['agentusers']['profile']['upload_dir'], 
                                                $this->file_paths['agentusers']['profile']['profilepic_dir'], 
                                                true, $prefix, $imgWidth, $imgHeight, array(), array() );
            return pathinfo($newfilepath, PATHINFO_BASENAME);
        } catch (Exception $ex) {
            return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
        }
    }
    
    
    /**
     * Upload Agents' profile proof id document
     * @param type $base64_string
     * @param type $filename
     * @param type $prefix
     * @return type
     */
    public function saveAgentProofIdDoc($base64_string, $filename, $prefix = '', $uploadingtmpfilepath = '')
    {
        try {
            
            // if file uploading 
            if($uploadingtmpfilepath != ''){
                $filename = date('Ymdhis').$filename;
                Storage::disk('upload')->put($this->file_paths['agentusers']['profile']['upload_dir'].$filename, $uploadingtmpfilepath);
                $base64_string = '';
            }
            $newfilepath = $this->saveFile($base64_string,  $filename, $this->file_paths['agentusers']['profile']['upload_dir'], 
                    $this->file_paths['agentusers']['profile']['idproof_dir'], 
                    true, $prefix);
            return pathinfo($newfilepath, PATHINFO_BASENAME);
        } catch (Exception $ex) {
            return false;
            //return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
        }
    }
    
    
    
    /**
     * =========================================
     * ====== CMSUSERS SPECIAL FUNCTIONS =======
     * =========================================
     */
    /**
     * Upload Cmsuser's profile picture
     * @param base64 encoded byte stream $base64_string
     * @param string $filename
     * @param string $prefix
     * @param string $uploadingtmpfilepath: File::get($file->getRealPath())
     * @return type
     */
    public function saveCmsuserProfilePic($base64_string, $filename, $prefix = '', $uploadingtmpfilepath = '')
    {
        try {
            $imgWidth = $this->oImageRepo->image_settings['cmsusers']['profile']['max_width'];
            $imgHeight = $this->oImageRepo->image_settings['cmsusers']['profile']['max_height'];
            
            // if file uploading 
            if($uploadingtmpfilepath != ''){
                $filename = date('Ymdhis').$filename;
                Storage::disk('upload')->put($this->file_paths['cmsusers']['profile']['upload_dir'].$filename, $uploadingtmpfilepath);
                $base64_string = '';
            }
            
            $newfilepath = $this->saveImageFile($base64_string, $filename, $this->file_paths['cmsusers']['profile']['upload_dir'], 
                                                $this->file_paths['cmsusers']['profile']['profilepic_dir'], 
                                                true, $prefix, $imgWidth, $imgHeight, array(), array() );
            return pathinfo($newfilepath, PATHINFO_BASENAME);
        } catch (Exception $ex) {
            return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
        }
    }
    
    
    /**
     * Upload Cmsusers' profile proof id document
     * @param type $base64_string
     * @param type $filename
     * @param type $prefix
     * @return type
     */
    public function saveCmsuserProofIdDoc($base64_string, $filename, $prefix = '', $uploadingtmpfilepath = '')
    {
        try {
            
            // if file uploading 
            if($uploadingtmpfilepath != ''){
                $filename = date('Ymdhis').$filename;
                Storage::disk('upload')->put($this->file_paths['cmsusers']['profile']['upload_dir'].$filename, $uploadingtmpfilepath);
                $base64_string = '';
            }
            $newfilepath = $this->saveFile($base64_string,  $filename, $this->file_paths['cmsusers']['profile']['upload_dir'], 
                    $this->file_paths['cmsusers']['profile']['idproof_dir'], 
                    true, $prefix);
            return pathinfo($newfilepath, PATHINFO_BASENAME);
        } catch (Exception $ex) {
            return false;
            //return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
        }
    }
    
    
    
    /**
     * =========================================
     * ====== CUSTOMER SPECIAL FUNCTIONS =======
     * =========================================
     */    
    // CUSTOMER
    /**
     * Upload Customer' profile picture
     * @param type $base64_string
     * @param type $filename
     * @param type $prefix
     * @return type
     */
    public function saveCustomerProfilePic($base64_string, $filename, $prefix = '')
    {
        try {
            $imgWidth = $this->oImageRepo->image_settings['customers']['profile']['max_width'];
            $imgHeight = $this->oImageRepo->image_settings['customers']['profile']['max_height'];
            $newfilepath = $this->saveImageFile($base64_string,  $filename, $this->file_paths['customers']['profile']['upload_dir'], 
                                                $this->file_paths['customers']['profile']['profilepic_dir'], 
                                                true, $prefix, $imgWidth, $imgHeight, array(), array() );
            return pathinfo($newfilepath, PATHINFO_BASENAME);
        } catch (Exception $ex) {
            return 'Error:'.$ex->getMessage()." File: ".$ex->getFile()." Line: ".$ex->getLine();
        }
    }
    
    // AGENT logo
    /**
     * Save agent logo
     * @param type $sourcefilename: $file->getClientOriginalName()
     * @param type $uploadfilerealpath : $file->getRealPath()
     * @param type $newfilename
     * @return boolean
     */
    public function saveAgentLogo($sourcefilename, $uploadfilerealpath, $newfilename){
        try {
            
            
            Storage::disk('resources')->put($this->file_paths['agent']['img_upload_dir'].$sourcefilename, File::get($uploadfilerealpath));
            
            $image_bytes = Storage::disk('resources')->get($this->file_paths['agent']['img_upload_dir'].$sourcefilename);
            $width = $this->oImageRepo->image_settings['agents']['logo']['min_width'];
            $height = $this->oImageRepo->image_settings['agents']['logo']['min_height'];
            
            if($width > 0 && $height > 0){
                // Create & resize the image to given fixed width & height
                //$image_normal = Image::make($image_bytes)->resize($width,$height);
                $image_normal = Image::make($image_bytes)->resize($width,null, function ($constraint) {
                                                        $constraint->aspectRatio();
                                                        $constraint->upsize();
                                                    });
            } elseif($width > 0 && $height == null) {
                // Resize image proportionally to given width
                $image_normal = Image::make($image_bytes)->widen($width);
            } elseif($width == null && $height > 0) {
                // Resize image proportionally to given height
                $image_normal = Image::make($image_bytes)->heighten($height);
            } else {
                $image_normal = Image::make($image_bytes);
            }
            $image_normal = $image_normal->stream();
            Storage::disk('resources')->put($this->file_paths['agent']['img_upload_dir'].$sourcefilename, $image_normal->__toString());
            unset($image_bytes);
            unset($image_normal);
            
            $exists = Storage::disk('resources')->has($this->file_paths['agent']['img_agents_dir'].$newfilename);
            if($exists){
                Storage::disk('resources')->delete($this->file_paths['agent']['img_agents_dir'].$newfilename);
            }
            
            Storage::disk('resources')->move($this->file_paths['agent']['img_upload_dir'].$sourcefilename, 
                                            $this->file_paths['agent']['img_agents_dir'].$newfilename);
            return $newfilename;
        } catch (Exception $ex) {
            return false;
        }
    }
    
}