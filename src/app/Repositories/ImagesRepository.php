<?php
/**
 *	Name	: ImagesRepository Class
 *	Project	: Property EAT Digi
 *	Creator	: S. Kaushalye
 *	Date	: 23-08-2016
 *	Desc	: This class consits of utility functions for all images
 *	Version	: 01.00
 */

namespace App\Repositories;
use File;

class ImagesRepository
{

    public $image_path =    [
                            
                            'facilities' => [
                                'img_upload_dir' => 'uploaded/facilities/',
                                'img_dir' => 'facilities/', 
                            ],
                            'msgattachements' => [
                                'upload_dir' => 'uploaded/', 
                            ],
                            'hotels' => [
                                'img_upload_dir' => 'uploaded/hotels/', 
                                'img_dir' => 'hotels/', 
                            ],
                            'itineraries' => [
                                'img_upload_dir' => 'uploaded/itineraries/', 
                                'img_dir' => 'itineraries/', 
                            ],
                            'carousels' => [
                                'img_upload_dir' => 'uploaded/carousels/', 
                                'img_dir' => 'carousels/', 
                            ],
                        ];
    
    public $image_settings = [
                        'hotels' => ['img_width'=>400, 'img_height' => 300, 'min_width'=>400, 'min_height' => 300, 'max_width'=>1024, 'max_height' => 1024, 'jpeg_quality'=>80, 'png_quality'=>9, 'max_filesize'=>2097152], // 2Mb = 2097152bytes
                        'itineraries' => ['img_width'=>400, 'img_height' => 300, 'min_width'=>400, 'min_height' => 300, 'max_width'=>1024, 'max_height' => 1024, 'jpeg_quality'=>80, 'png_quality'=>9, 'max_filesize'=>2097152],
                        'carousels' => ['img_width'=>400, 'img_height' => 300, 'min_width'=>400, 'min_height' => 300, 'max_width'=>1024, 'max_height' => 1024, 'jpeg_quality'=>80, 'png_quality'=>9, 'max_filesize'=>2097152], 
                        'facilities' => ['img_width'=>25, 'img_height' => 25, 'min_width'=>25, 'min_height' => 25, 'max_width'=>1024, 'max_height' => 1024, 'jpeg_quality'=>80, 'png_quality'=>9, 'max_filesize'=>2097152], 
                    ];
    public $min_width = 400;
    public $min_height = 300;
    public $max_width = 1024;
    public $max_height = 1024;
    public $jpegQuality = 80;
    public $pngQuality = 9;

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * Collect image
     * @param string $srcImagePath
     * @param int $propertyId
     * @param string $customImageName
     * @return array
     */
    public function collectImage($srcImagePath, $propertyId, $checkimagesize = true){
        // collect image details without save image
        if(trim($srcImagePath) != ''){
                if (strpos($srcImagePath,'noimage') !== false) { 
                    return [false, 'error'=>"Invalid image"];
                } elseif($checkimagesize === true && $this->checkMinimumSize($srcImagePath) === false) {
                    return [false, 'error'=>"Image too small"];
                } else {
                    $imagename = $this->getRenameImage($srcImagePath, $propertyId);
                    return array('path' => $srcImagePath, 'key' => $this->getUniqueKeyOfFile($srcImagePath), 'rename'=>$imagename);
                }           
        } else {
            return [false, 'error'=>"Image path not found"];
        }
    }

    /**
     * 
     * @param string $oldfilepath
     * @param string $newfilepath 
     * @return boolean/array
     */
    public function moveImage($oldfilepath, $newfilepath){
        if ( ! File::move($oldfilepath, $newfilepath))
        {
            return [false, 'message' => 'Unable to move image to resources.'];
        } else {
            return true;
        }
    }
    
    /**
     * Delete images from resources
     * @param string $ilepath
     */
    public function deleteImage($filepath) {
        File::delete($filepath);
    }
    
    
    /**
     * Create a directory with predecesor directories if not exists
     * @param string $path_to_directory
     * @return boolean
     */
    public function createDirectory($path_to_directory){
        if (!File::exists($path_to_directory)){  
            return File::makeDirectory(rtrim($path_to_directory, '/'), 0755, true);
        }
        return true;
    }
    
    /**
     * Download image from given URL and saving in given location
     * @param string $srcImagePath
     * @param id $propertyId
     * @param string $customImageName
     * @return array
     */
    public function downloadImageFromUrl($srcImagePath, $saveImagePath = '', $propertyId = '', $customImageName = '_CURRENT_'){

        // Save  image

        if (strpos($srcImagePath,'noimage') !== false) { 
            return [false, 'error'=>"Invalid image"];
        } elseif($this->checkMinimumSize($srcImagePath) === false) {
            return [false, 'error'=>"Image too small"];
        } else {

            if($customImageName == '_CURRENT_'){
                $path_parts = pathinfo($srcImagePath);
                $imagename = $path_parts['filename'].'.'.$path_parts['extension'];
            } elseif($customImageName == '_GENERIC_'){
                $path_parts = pathinfo($srcImagePath);
                $imagename = $this->getRenameImage($srcImagePath, $propertyId);
            } elseif($customImageName != '') {
                $path_parts = pathinfo($customImageName);
                $imagename = $path_parts['filename'].'_'.($propertyId != ''?$propertyId.'_':'').strtotime('NOW').'.'.$path_parts['extension'];
            } else {
                $path_parts = pathinfo($srcImagePath);
                $imagename = $path_parts['filename'].'_'.($propertyId != ''?$propertyId.'_':'').strtotime('NOW').'.'.$path_parts['extension'];
            }

            //echo 'Saving img:'.$imagename.'<br/>';

            $ch = curl_init($srcImagePath);
            $fp = fopen($saveImagePath.$imagename, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);

            //echo "<br/>From: $srcImagePath <br/>  -  ".$this->_imagePath.$imagename." ";
            return array($imagename);
        }
    }

    
    public function saveAgentImage($srcImagePath, $customImageName = ''){
        // Save  image
        if (strpos($srcImagePath,'noimage') !== false) { 
            $imagename = 'noimage.png';
        } else {
            if($customImageName != '') {
                $imagename = $customImageName;
            } else {
                $path_parts = pathinfo($srcImagePath);
                $imagename = $path_parts['filename'].'_'.strtotime('NOW').'.'.$path_parts['extension'];
            }
            //echo 'Saving img:'.$imagename.'<br/>';
            $ch = curl_init($srcImagePath);
            $fp = fopen($this->_imagePathAgent.$imagename, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            //echo "<br/>From: $srcImagePath <br/>  -  ".$this->_imagePath.$imagename." ";
        }
        return array($imagename, $this->getUniqueKeyOfFile($this->_imagePathAgent.$imagename));
    }

    
    
    /**
     * Save image in given path
     * @param string $pathToSave : path/to/save/
     * @param type $srcImagePath    : original image src
     * @param type $customImageName : if rename to given string
     * @return imagename
     */
    public function saveImageInGivenLocation($pathToSave, $srcImagePath, $customImageName = ''){
        // Save  image
        if (strpos($srcImagePath,'noimage') !== false) { 
            $imagename = 'noimage.png';
        } else {
            if($customImageName != '') {
                $imagename = $customImageName;
            } else {
                $path_parts = pathinfo($srcImagePath);
                $imagename = $path_parts['filename'].'_'.strtotime('NOW').'.'.$path_parts['extension'];
            }
            //echo 'Saving img:'.$imagename.'<br/>';
            $ch = curl_init($srcImagePath);
            $fp = fopen($pathToSave.$imagename, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            //echo "<br/>From: $srcImagePath <br/>  -  ".$this->_imagePath.$imagename." ";
        }
        return array('imagename'=>$imagename);
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

    
    public function grabImages($srcImagePath, $newImageName, $newImageSavePath = ''){
        try {
           
            $_imagePath = ($newImageSavePath != '')?$newImageSavePath:$this->_imagePath; // Saving image path
            //echo 'Saving img:'.$imagename.'<br/>';
            $ch = curl_init($srcImagePath);
            $fp = fopen($_imagePath.$newImageName, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    

    public function restoreMissingImages($srcImagePath, $newImageName){
        $_imagePath = 'images/restore/'; // Saving image path
        //echo 'Saving img:'.$imagename.'<br/>';
        $ch = curl_init($srcImagePath);
        $fp = fopen($_imagePath.$newImageName, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

    

    /**
     *	This function for handle resize the uploaded image
     *	@param $picture_location string: path of file existing
     *	@param $picture_save string: path of resized file to be on
     * 	@param $max_width int
     * 	@param $max_height int
     * 	@param $fixeddimension boolean
     */
    public function imageMoveAndResize($picture_location, $picture_save, $max_width, $max_height, $fixeddimension = false) {
        try {
         
            //echo "Loc: $picture_location, Save: $picture_save, $max_width, $max_height";
            list($imageWidth, $imageHeight) = getimagesize ( $picture_location);

            // IF need to image size exactly as given. Image can be changed
            if(!$fixeddimension && ($imageWidth > 0 && $imageHeight > 0) ){

                    if ( ($imageWidth <= $max_width) && ($imageHeight <= $max_height) ) {
                            $max_width = $imageWidth;
                            $max_height = $imageHeight;
                    }
                    $x_ratio = $max_width / $imageWidth;
                    $y_ratio = $max_height / $imageHeight;
                    if (($x_ratio * $imageHeight) < $max_height) {
                            $max_height = ceil($x_ratio * $imageHeight);
                    }
                    else {
                            $max_width = ceil($y_ratio * $imageWidth);
                    }
            } // END if(!$fixeddimension)

            if(function_exists("imagecopyresampled")){
                    $im = imagecreatetruecolor( $max_width, $max_height );
                    imagealphablending( $im, false );
                    imagesavealpha( $im, true );
            }else{
                    $im = imagecreate( $max_width, $max_height );
                    imagealphablending( $im, false );
                    imagesavealpha( $im, true );
            }
            // $im : Target Image
            // imagealphablending & imagesavealpha functions are essentials in both places to keep "transperency" of image


            $lower_pic_location = strtolower($picture_location);
            if (strpos($lower_pic_location, '.jpg') !== false || strpos($lower_pic_location, '.jpeg') !== false) {
                    $im2 = imagecreatefromjpeg($picture_location);
            } elseif (strpos($lower_pic_location, '.gif') !== false) {
                    $im2 = imagecreatefromgif($picture_location);
            } elseif (strpos($lower_pic_location, '.png') !== false) {
                    $im2 = imagecreatefrompng($picture_location);
            }
            
            
            // Error on image creation
            if(!$im2){ 
                imagedestroy($im);
                return false; 
            }
            
            if(function_exists("imagecopyresampled")){
                    imagecopyresampled ($im,$im2, 0, 0, 0, 0, $max_width, $max_height,$imageWidth, $imageHeight);			
                    imagealphablending( $im, false );
                    imagesavealpha( $im, true );
            }else{
                    imagecopyresampled ($im,$im2, 0, 0, 0, 0, $max_width, $max_height,$imageWidth, $imageHeight);
                    imagealphablending( $im, false );
                    imagesavealpha( $im, true );
            }
            // imagealphablending & imagesavealpha functions are essentials in both places to keep "transperency" of image

            if (file_exists($picture_save))
                    unlink($picture_save);

            if (strpos($lower_pic_location, '.jpg') !== false || strpos($lower_pic_location, '.jpeg') !== false) {
                imagejpeg($im,$picture_save, $this->jpegQuality);
            } elseif (strpos($lower_pic_location, '.gif') !== false) {
                    imagegif($im,$picture_save);
            } elseif (strpos($lower_pic_location, '.png') !== false) {
                    imagepng($im,$picture_save, $this->pngQuality);
            }

            imagedestroy($im);
            imagedestroy($im2);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    } 


    /**
     * Check given image size has at least minimum size
     * @param string $imageSrc
     * @return boolean
     */
    public function checkMinimumSize($imageSrc){
        $return = false;
        list($width, $height) = @getimagesize($imageSrc);
        //echo "<be/>$width, $height<br/>";
        if($width >= $this->min_width){
            if($height >= $this->min_height){
                $return = true;
            }
        }
        return $return;
    }
    
    
    /**
     * Check given image is within given max width & height
     * @param string $imageSrc
     * @return boolean
     */
    public function checkMaximumSize($imageSrc, $maxWidth, $maxHeight){
        $return = false;
        list($width, $height) = @getimagesize($imageSrc);
        if($width <= $maxWidth){
            if($height <= $maxHeight){
                $return = true;
            }
        }
        return $return;
    }
    
    
    /**
     * Check the given image is under the max width & height, if not resize it to max dimensions
     * @param string $imageSrc
     * @param int $maxWidth
     * @param int $maxHeight
     */
    public function checkAndResizeImageToMaxDimensions($imageSrc, $maxWidth, $maxHeight){
        if($this->checkMaximumSize($imageSrc, $maxWidth, $maxHeight) === false){
            $this->imageMoveAndResize($imageSrc, $imageSrc, $maxWidth, $maxHeight);
        }
    }
    
    /**
     * Get image width n height
     * @param string $imageSrc : path-to-image/imagename.ext
     * @return array : array('width'=>"", 'height'=>"")
     */
    public function getImageDimensions($imageSrc){
        $aReturn = array('width'=>"", 'height'=>"");
        list($width, $height) = @getimagesize($imageSrc);
        $aReturn['width'] = $width;
        $aReturn['height'] = $height;
        return $aReturn;
    }
    
    /**
     * Get generic name for image
     * @param string $srcImagePath
     * @param int $prefix ($propertyId for property images)
     * @return string
     */
    public function getRenameImage($srcImagePath, $prefix){
        $path_parts = pathinfo($srcImagePath);
        if(strlen($path_parts['extension']) > 4){
            $ext = strtolower($path_parts['extension']);
            if(substr($ext, 0, 4) == 'jpeg'){
                $extension = 'jpeg';
            } elseif(substr($ext, 0, 4) == 'tiff'){
                $extension = 'tiff';
            } elseif(substr($ext, 0, 3) == 'jpg'){
                $extension = 'jpg';
            } elseif(substr($ext, 0, 3) == 'png'){
                $extension = 'png';
            } elseif(substr($ext, 0, 3) == 'gif'){
                $extension = 'gif';
            }
        } else {
            $extension = $path_parts['extension'];
        }
        return $prefix.'_'.strtotime('NOW').'_'.rand(0,99).'.'.$extension;
    }
    
    /**
     * Get directory name from image size
     * @param string $pathtoimage
     * @return int
     */
    public function getImageSubDirectory($pathtoimage = '', $size = ''){
        try {
            
            if($size == ''){
                $size = @filesize($pathtoimage);
            }
            $directory = (int)($size/1000);
            if($directory > 1000){ $directory = 1001;}
            return $directory;
        
        } catch (Exception $ex) {
            return (-1);
        }
    }
    
    
}