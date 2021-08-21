<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Items\BreakingItemInterface;
use App\Application\Items\EnchantableItemIterface;
use App\Application\Items\NonBreakingItemInterface;
use App\Application\Services\ItemService;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EnhaController extends BaseController
{
    public function __construct(private ItemService $itemService) {}


    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $item = $args['item'];
        $level = (int) $args['level'];
        $permaChance = 1;

        $item = $this->itemService->getItem($item);

        $res = [
            'targetLevel' => enhaLevel($level),
            'item' => $item,
            'optimal' => null,
            'progress' => [],
        ];

        if (! $item instanceof EnchantableItemIterface) {
            throw new \Exception('Item cannot be enhanced!');
        }

        $optimal = null;

        for ($i = 1; $i < 150; $i++) {
            $baseChance = $item->getEnhaChance($level);

            if ($baseChance === 0.0) {
                throw new \Exception(sprintf('Enhachance is 0 for +%s %s!', $level, $item->getId()));
            }

            $enhaChance = calculateChance($baseChance, $i);
            $adviceResult = calculateAdvicePrice($i - $permaChance, getPrices());

            if ($adviceResult['fs'] !== $i - $permaChance) {
                continue;
            }

            $advicePrice = $adviceResult['totalPrice'];

            if ($item instanceof NonBreakingItemInterface) {
                $duraLost = $item->getDurabilityLost($level);
                $repairItem = $this->itemService->getRepairItem($item->getRepairItemId());

                $repairPrice = $duraLost
                    * $repairItem->getBasePrice() 
                    / $repairItem->getDurabilityRestored();

            } elseif ($item instanceof BreakingItemInterface) {
                throw new \Exception('Not yet implemented!');
            } else {
                throw new \Exception('Not enchantable item!');
            }

            $totalPrice = (100 / $enhaChance) * $repairPrice + $advicePrice;
            $totalPrice = round($totalPrice);

            $trial = [
                'fs' => $i,
                'baseChance' => $baseChance,
                'enhaChance' => $enhaChance,
                'advicePrice' => $advicePrice,
                'durabilityLost' => $duraLost,
                'repairPrice' => $repairPrice,
                'totalPrice' => $totalPrice,
            ];

            $res['progress'][] = $trial;

            $optimal ??= $trial;

            if ($totalPrice < $optimal['totalPrice']) {
                $optimal = $trial;
            }

            if ($enhaChance > 70) {
                break;
            }
        }

        $res['optimal'] = $optimal;

        return $this->render($response, TPL_DIR . '/enha.tpl.php', [
            'level' => $level,
            'item' => $item,
            'res' => $res,
        ]);
    }
}
