<?php


namespace App\Libraries\Helpers;

use Illuminate\Support\Str;

class RouteHelper
{
    public static function ImageUrlToDb($value)
    {
        return !Str::contains($value, request()->getHost()) ?
            $value :
            substr($value, strpos($value, "storage/") + 8, Str::length($value));
    }
}
