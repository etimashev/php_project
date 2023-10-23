<?php

namespace Utility;

use Controllers\GetUserController;

class Router
{
    public static function init(string $method, string $uri, array $request)
    {
        if ($method === 'GET') {
            echo static::get(uri: $uri, request: $request);
        }

        if ($method === 'POST') {
            echo static::post(uri: $uri, request: $request);
        }
    }

    protected static function get(string $uri, array $request)
    {
        switch ($uri) {
            case '/getUser':
                return (new GetUserController())($request);
                break;
            default:
                phpinfo();
                break;
        }
    }

    protected static function post(string $uri, array $request)
    {
        switch ($uri) {
            default:
                break;
        }
    }
}
