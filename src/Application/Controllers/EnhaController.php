<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use function FastRoute\cachedDispatcher;

class EnhaController extends BaseController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $item = $args['item'];
        $level = (int) $args['level'];
        $permaChance = 1;

        $items = [
            'boss' => [
                'chances' => [
                    6,
                    7,
                    8,
                    9,
                    10,
                    11,
                    12,
                    13,
                    14,
                    15,
                    16,
                    17,
                    18,
                    19,
                    20,
                ],
                'repairItem' => 'mem',
            ],
            'access' => [
                'chances' => [
                    1 => 30.0,
                    2 => 10.0,
                    3 => 7.5,
                    4 => 2.5,
                    5 => 0.5,
                ],
                'prices' => [
                    1 => 60_000,
                    2 => 150_000,
                    3 => 600_000,
                    4 => 2_000_000,
                    5 => 4_800_000,
                ],
            ],
            'silver' => [
                'name' => 'silver embro',
                'chances' => [
                    1 => 30.0,
                    2 => 10.0,
                    3 => 7.5,
                    4 => 2.5,
                    5 => 0.5,
                ],
                'isDestroyed' => true,
                'prices' => [
                    0 => 494,
                    1 => 3_900,
                    2 => 14_300,
                    3 => 101_000,
                    4 => 895_000,
                    5 => 4_560_000,
                ],
            ],
            'manos' => [
                'name' => 'manos tool',
                'isDestroyed' => false,
                'duraLost' => [
                    0 => 5,
                    1 => 10,
                ],
                'chances' => [
                    8 => 70.0,
                    9 => 20.0,
                    10 => 14.2,
                    11 => 10.0,
                    12 => 6.66,
                    13 => 4.0,
                    14 => 2.5,
                    15 => 2.0,
                    16 => 11.6,
                    17 => 7.69,
                    18 => 6.25,
                    19 => 2.0,
                    20 => 0.3,
                ],
                'repairItem' => 'mem',
            ],
            'horse' => [
                'name' => 'horse gear',
                'isDestroyed' => false,
                'duraLost' => [
                    0 => 5,
                ],
                'chances' => [
                    1 => 73,
                    2 => 48,
                    3 => 30,
                    4 => 20,
                    5 => 13,
                    6 => 8.8,
                    7 => 5.85,
                    8 => 3.9,
                    9 => 10,
                    10 => 10,
                ],
                'repairItem' => 'horseShoe'
            ],
        ];

        $selectedItem = $items[$item];

        $res = [
            'targetLevel' => enhaLevel($level),
            'item' => $selectedItem,
            'optimal' => null,
            'progress' => [],
        ];

        for ($i = 1; $i < 150; $i++) {
            $baseChance = $selectedItem['chances'][$level];

            $enhaChance = calculateChance($baseChance, $i);
            $advice = calculateAdvicePrice($i - 1, getPrices());

            if ($advice['fs'] !== $i - 1) {
                continue;
            } 

            $advicePrice = $advice['totalPrice'];

            if ($selectedItem['isDestroyed']) {
                $itemsPrice = $selectedItem['prices'][0] + $selectedItem['prices'][$level - 1];
                $repairPrice = 0;
                $duraLost = 0;
            } else {
                $duraLost = $selectedItem['duraLost'][$level < 16 ? 0 : 1];

                if ($selectedItem['repairItem'] !== 'mem') {
                    $duraLost /= 10;
                }

                $itemsPrice = $level < 16
                    ? getPrices()['bs']
                    : getPrices()['bs'] * 2 + getPrices()['sharpCrystal'];

                $repairPrice = $duraLost * getPrices()[$selectedItem['repairItem']];
            }

            $totalPrice = ($itemsPrice + $repairPrice) * (100 / $enhaChance) + $advicePrice;
            $totalPrice = round($totalPrice);

            $res['progress'][] = [
                'fs' => $i,
                'actualChance' => $enhaChance,
                'advice' => $advice['fs'],
                'advicePrice' => $advicePrice,
                'duraLost' => $duraLost,
                'itemsPrice' => $itemsPrice,
                'repairPrice' => $repairPrice,
                'totalPrice' => $totalPrice,
            ];

            if ($enhaChance > 70) {
                break;
            }
        }

        $minStacks = 0;
        $minPrice = $res['progress'][0]['totalPrice'];

        foreach ($res['progress'] as $i => $prog) {
            if ($prog['totalPrice'] < $minPrice) {
                $minStacks = $i;
                $minPrice = $prog['totalPrice'];
            }
        }

        $res['optimal'] = $res['progress'][$minStacks];

        return $this->render($response, TPL_DIR . '/enha.tpl.php', [
            'level' => $level,
            'item' => $item,
            'res' => $res,
        ]);
    }
}
