<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GatherController extends BaseController
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $query = $request->getQueryParams();
        $prices = getPrices();
        $total = [];
        $gathered = [];

        foreach ($query as $item => $amount) {
            if ($item === 'time') {
                continue;
            }

            $amount = (int) $amount;
            $item = html_entity_decode($item);
            $gathered[$item] = $amount;

            $total[$item] = $prices[$item] * $amount;
        }

        $total['totalPrice'] = array_sum($total);

        $query['time'] = (int) $query['time'];

        $total['totalPerH'] = $query['time'] > 0
            ? $total['totalPrice'] / ($query['time'] ?: 60) * 60
            : 0;

        return $this->render(
            $response,
            TPL_DIR . '/gather.tpl.php',
            [
                'prices' => $prices,
                'total' => $total,
                'gathered' => $gathered,
            ],
        );
    }
}
