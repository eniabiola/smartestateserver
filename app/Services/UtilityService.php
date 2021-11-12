<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UtilityService {

    public function generateCode($length_of_string)
    {
        return substr(sha1(time()), 0, $length_of_string);
    }

}
