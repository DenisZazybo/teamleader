<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/vendor/autoload.php';

$app = new App();

$app->get('/post-order', function(Request $request, Response $response) {
    $order = json_decode($request->getBody()->getContents(), true);
    $discountService = new DiscountService();
    return $response->withJson($discountService->calculateDiscounts($order), 200);
});
