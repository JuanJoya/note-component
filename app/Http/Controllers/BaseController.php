<?php

namespace Note\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController
{
    /**
     * @var Request
     */
    protected static $request;

    /**
     * @param Request $request
     */
    public static function setRequest(Request $request)
    {
        self::$request = $request;
    }
}
