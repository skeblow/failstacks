<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Services\AdviceService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CookingController extends BaseController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        

        return $this->render($response, TPL_DIR . '/cooking.tpl.php', [
          
        ]);
    }
}