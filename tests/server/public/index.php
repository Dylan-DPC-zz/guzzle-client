<?php

require_once __DIR__.'/../../../vendor/autoload.php';

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

function build_response($request)
{
    return response()->json([
        'headers' => $request->header(),
        'query' => $request->query(),
        'json' => $request->json()->all(),
        'form_params' => $request->request->all(),
    ], $request->header('Status', 200));
}

$app->router->get('/get', function () {
    return build_response(app('request'));
});

$app->router->post('/post', function () {
    return build_response(app('request'));
});

$app->router->put('/put', function () {
    return build_response(app('request'));
});

$app->router->patch('/patch', function () {
    return build_response(app('request'));
});

$app->router->delete('/delete', function () {
    return build_response(app('request'));
});

$app->router->get('/simple-response', function () {
    return "A simple string response";
});

$app->run();
