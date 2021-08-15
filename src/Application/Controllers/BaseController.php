<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class BaseController
{
    abstract public function __invoke(Request $request, Response $response, array $args): Response;

    public function render(Response $response, string $template, array $data): Response
    {
        ob_start();

        $data['template'] = $template;
        extract($data);
        require TPL_DIR . 'layout/layout.tpl.php';

        $res = ob_get_clean();

        $response->getBody()->write($res);

        return $response;
    }
}
