<?php

namespace Phprestful\Middleware;

class Logging
{
    public static function Log($request, $app)
    {
        error_log($request->getMethod() . ' -- ' . $request->getUri());
    }
}