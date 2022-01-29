<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            $extensions = array('png', 'gif', 'jpg', 'jpeg', 'pdf');

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

    public function uploadDocBase64($image, $folder)
    {
        try {
            $base64_string = $image;
            $base64_string_array = explode(';base64,', $base64_string);
            $base64_only = $base64_string_array[1];

            $bin = base64_decode($base64_only);
            $mime_array = explode('/', $base64_string_array[0]);
            $ext = $mime_array['1'];
            $size = getImageSizeFromString($bin);
            $filename = Str::random() . ".$ext";
            // Specify the location where you want to save the image
            $img_file = storage_path('app/public/document-files/' . $filename);
            // Save binary data as raw data (that is, it will not remove metadata or invalid contents)


//            $imagename = md5(uniqid(). time()) . '.'.$image_type;
            $destinationpath = $folder . $filename;
            Storage::put($destinationpath, $destinationpath);
            return ["status" => true, "data" => $filename];
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
