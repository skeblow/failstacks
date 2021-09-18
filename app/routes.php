<?php
declare(strict_types=1);

use App\Application\Controllers\AdviceController;
use App\Application\Controllers\AlchemyController;
use App\Application\Controllers\CookingController;
use App\Application\Controllers\GatherController;
use App\Application\Controllers\IndexController;
use App\Application\Controllers\EnhaController;
use App\Application\Controllers\PricesController;
use App\Application\Controllers\ProcessingController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', IndexController::class);
    $app->get('/advice/{fs}', AdviceController::class);
    $app->get('/gather', GatherController::class);
    $app->get('/prices', PricesController::class);
    $app->post('/prices', PricesController::class . ':post');
    $app->get('/cooking', CookingController::class);
    $app->get('/processing', ProcessingController::class);
    $app->get('/alchemy/{main}', AlchemyController::class);

    $app->get('/{item}/{level}', EnhaController::class);
};
