<?php

require_once('vendor/autoload.php');
include('bootstrap.php');

use Phprestful\Models\Message;
use Phprestful\Middleware\Logging as Logging;
use Phprestful\Middleware\Authentication as Authentication;
use \Symfony\Component\HttpFoundation\Request as Request;
use \Symfony\Component\HttpFoundation\Response as Response;

$app = new Silex\Application();
$app['debug'] = true;
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//middleware
$app->before(function($request, $app) {
    Logging::Log($request, $app);
    Authentication::authenticate($request, $app);
});

$app->get('/messages', function() use ($app) {
    $_message = new Message();

    $messages = $_message->all();

    $payload = [];
    foreach ($messages as $_msg) {
        $payload[$_msg->id] = [
            'body' => $_msg->body,
            'user_id' => $_msg->user_id,
            'created_at' => $_msg->created_at
        ];
    }

    return json_encode($payload);
});

$app->post('/message', function(Request $request) use ($app) {
    $_message = $request->get('message');

    $message = new Message();
    $message->body = $_message;
    $message->user_id = 1;
    $message->image_url = 'nothing';

    $message->save();

    if($message->id) {
        $code = 201;
        $payload = [
            'message_id' => $message->id,
            'message_uri' => '/message/' . $message->id
        ];
    } else {
        $code = 400;
        $payload = [];
    }

    return new Response('Message created at' . $message->created_at, $code);
});

$app->delete('/message/{message_id}', function($message_id) use($app) {
    $message = Message::find($message_id);

    if ($message !== null) {
        $message->delete();
    } else {
        return new Response('Message not found', 404);
    }

    if ($message->exists) {
        return new Response('', 400);
    } else {
        return new Response('', 204);
    }
});

$app->run();
