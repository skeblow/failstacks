<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdviceController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $fs = (int) $args['fs'];
        $prices = getPrices();

        if ($fs < 1 || $fs > 200) {
            throw new Exception('fu');
        }

        $res = calculateAdvicePrice($fs, $prices);

        ob_start();
        
        include __DIR__ . '/advice.tpl.php';

        $res = ob_get_clean();

        $response->getBody()->write($res);

        return $response;
    }
}