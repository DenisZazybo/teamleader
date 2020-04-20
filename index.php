<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/vendor/autoload.php';

$app = new App();

// todo
// very dirty decision -  implemented handling routes into index.php file, as you desided use slim framework you should be
// use addRoutingMiddleware() or something like that;

// todo
// skipped implementation error handling $app->addErrorMiddleware(true, false, false);

$app->get('/post-order', function(Request $request, Response $response) {
    // todo
    //'ext-json' is missing in composer.json
    $order = json_decode($request->getBody()->getContents(), true);

    // todo
    // you should use a factory pattern for receive services  and factory mast be injected via dependency injection mechanism
    $discountService = new DiscountService();

    // todo
    // the application can only generate a response with a status of 200, there is no error handling
    // for preparing response also will be better create some response building service and get it from service factory
    // current implementation not flexible
    return $response->withJson($discountService->calculateDiscounts($order), 200);
});


// todo
// Run application $app->run();
