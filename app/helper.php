<?php

use App\Models\User;
use Illuminate\Support\Facades\App;

if (!function_exists('setting')) {
    /**
     * @param $key
     * @param null $default
     * @return \App\Models\Setting|bool|int|mixed
     */
    function setting($key = null, $default = null)
    {

        if (is_null($key)) {
            return new \App\Models\Setting();
        }

        if (is_array($key)) {
            return \App\Models\Setting::set($key[0], $key[1]);
        }

        $value = \App\Models\Setting::where('name', $key)->first();

        return is_null($value) ? value($default) : $value;
    }
}


