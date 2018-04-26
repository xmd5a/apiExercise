<?php

namespace Phprestful\Middleware;

use Phprestful\Models\User as User;

class Authentication
{
    public static function authenticate($request, $app)
    {
        $auth = $request->headers->get('Authorization');
        $apikey = trim(substr($auth, strpos($auth, ' ')));

        $user = new User();

        if (!$user->authenticate($apikey)) {
            $app->abort(401);
        }
    }
}