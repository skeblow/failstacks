<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{
    public function render(Response $response, string $template, array $data): Response
    {
        ob_start();

        $data['template'] = $template;
        extract($data);
        require __DIR__ . '/layout.tpl.php';

        $res = ob_get_clean();

        $response->getBody()->write($res);

        return $response;
    }
}
