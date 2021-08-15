<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndexController extends BaseController
{
    public function __invoke(Request $request, Response $response): Response
    {
        return $this->render($response, TPL_DIR . '/index.tpl.php', []);
    }
}
