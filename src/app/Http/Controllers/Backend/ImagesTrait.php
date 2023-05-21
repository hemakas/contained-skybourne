<?php
namespace App\Http\Controllers\Backend;

use Storage;
use App\Repositories\FilesRepository;

trait ImagesTrait
{
    
    /**
     * Remove image from physical location
     * @param string $path_to_image: real image path with image name
     * @param ImagesRepository $oImgRepo
     * @return type
     */
    public function removeImage($sourcetype, $directory, $image_name)
    {
        try {
            $fileRepo = new FilesRepository;
            return Storage::disk('resources')->delete($fileRepo->file_paths[$sourcetype]['img_dir'].rtrim($directory, '/').'/'.$image_name);
        } catch (\Exception $ex) {
            return false;
        }
    }
}
