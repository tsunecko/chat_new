<?php

namespace App\Helpers;

class Helper
{

    /**
     * Get auth token from header request
     *
     * @param $request
     * @return string
     */
    public static function getToken($request) :string
    {
//        return substr($request->header('Authorization'), 5);
        return $request->header('Authorization');
    }
}
