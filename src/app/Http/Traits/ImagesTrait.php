<?php
namespace App\Http\Controllers;

use App\Repositories\ImagesRepository;

trait ImagesTrait {
    
    /**
     * Remove image from physical location
     * @param string $path_to_image: real image path with image name
     * @param ImagesRepository $oImgRepo
     * @return type
     */
    public function removeImage($agent_id, $directory, $image_name) {
        try {
            
        $oImgRepo = new ImagesRepository();
        $path_to_image = $oImgRepo->property_image_path['property']['real_image_path'].$agent_id.'/'.$directory.'/'.$image_name;
        return $oImgRepo->deleteImage($path_to_image);
        
        } catch (\Exception $ex) {
            return Response::json(parent::$_apierrormsg, 500);
        }
    }
}