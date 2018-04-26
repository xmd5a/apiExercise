<?php

namespace Phprestful\Controllers;

use Silex\Application;
use Phprestful\Models\Message;
use Symfony\Component\HttpFoundation\Response;

class Messages
{
    public static function getAll()
    {
        $_message = new Message();

        $messages = $_message->all();

        $payload = [];
        foreach ($messages as $_msg) {
            $payload[$_msg->id] = $_msg->display();
        }

        return new Response(json_encode($payload), 200);
    }
}
