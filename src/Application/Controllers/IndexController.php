<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndexController
{
    public function __invoke(Request $request, Response $response): Response
    {
        ob_start();
        
        include __DIR__ . '/index.tpl.php';

        $res = ob_get_clean();

        $response->getBody()->write($res);

        return $response;
    }
}
