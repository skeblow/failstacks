<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Services\ItemService;
use App\Application\Services\PricesService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PricesController extends BaseController
{
    public function __construct(
        private ItemService $itemService,
        private PricesService $pricesService,
    ) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, TPL_DIR . '/prices.tpl.php', [
            'items' => $this->itemService->getAllItems(),
        ]);
    }

    public function post(Request $request, Response $response, array $args): Response
    {
        $prices = $request->getParsedBody();

        foreach ($prices as $key => $value) {
            $prices[$key] = (int) $value;
        }

        $this->pricesService->savePrices($prices);
        
        return $response->withHeader('Location', '/prices');
    }
}
