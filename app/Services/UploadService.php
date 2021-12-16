<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UploadService {

    public function uploadImageBase64($image, $folder)
    {
        try {
            $folderPath = $folder;
            $image_parts =  explode(";base64,", $image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type_new = explode(";base64,", $image_type_aux[1]);
            $image_type = $image_type_new[0];
            //specify the extensions allowed
            $extensions = array('png', 'gif', 'jpg', 'jpeg');

            if (in_array($image_type, $extensions) === false) {
                // $error = $this->failedResponse($message, $status);
                return ["status" => false];
            }
            $image_base64 = base64_decode($image_parts[1]);
            $imagename = md5(uniqid(). time()) . '.'.$image_type;
            $destinationpath = $folderPath . $imagename;
            Storage::put($destinationpath, $image_base64);
            return ["status" => true, "data" => $imagename];
        } catch (\Error $e){
            return ["status" => true, "data" => $image];
        }
    }

    public function deleteImage($deleteImage, $folder)
    {
        $destinationPath = public_path('/'.$folder);
        $oldImage = $destinationPath."/".$deleteImage;
        if (file_exists($oldImage)) {
            Storage::delete($oldImage);
        }
    }
}
