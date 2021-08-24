<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Items\BreakingItemInterface;
use App\Application\Items\EnchantableItemIterface;
use App\Application\Items\NonBreakingItemInterface;
use App\Application\Services\AdviceService;
use App\Application\Services\EnhaService;
use App\Application\Services\ItemService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EnhaController extends BaseController
{
    public function __construct(
        private ItemService $itemService,
        private AdviceService $adviceService,
        private EnhaService $enhaService,
    ) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $item = $args['item'];
        $level = (int) $args['level'];
        $permaChance = 1;

        $item = $this->itemService->getItem($item);

        $res = $this->enhaService->getEnhaResult($item->getId(), $level);

        return $this->render($response, TPL_DIR . '/enha.tpl.php', [
            'level' => $level,
            'item' => $item,
            'res' => $res,
        ]);
    }
}
