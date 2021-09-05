<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProcessingController extends BaseController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $query = $request->getQueryParams();
        $cereal = (int)($quantity['cereal'] ?? 0);
        $flour = (int)($quantity['flour'] ?? 0);
        $water = (int)($quantity['water'] ?? 0);

        $avgRate = 2.5;
        $massProcess = 42;
        $weightLimit = 1100;
        $weights = [
            'cereal' => 0.1,
            'flour' => 0.1,
            'dough' => 0.1,
            'water' => 0.01,
        ];
        $prices = [
            'cereal' => 1500,
            'flour' => 1400,
            'dough' => 1300,
            'water' => 60,
        ];

        $res = [
            'input' => [
                'cereal' => $cereal,
                'flour' => $flour,
                'water' => $water,
            ],
            'result' => [],
            'weight' => 0,
            'maxWeight' => 0,
            'processingTime' => 0,
            'totalCost' => 0,
            'totalPrice' => 0,
            'totalProfit' => 0,
            'profitPerH' => 0,
        ];

        foreach ($res['input'] as $ingredient => $quantity) {
            $res['totalCost'] += $quantity * $prices[$ingredient];
            $res['result'][$ingredient] = $quantity; 
        }

        $res['totalCost'] /= 1000;

        $recipes = ['cereal', 'flour'];

        foreach ($recipes as $input) {
            do {
                if ($input === 'cereal') {
                    $batchSize = min($massProcess, $res['result']['cereal']);
                    $res['result']['cereal'] -= $batchSize;
                    $res['result']['flour'] ??= 0;
                    $res['result']['flour'] += $batchSize * $avgRate;
                } elseif ($input === 'flour') {
                    $batchSize = min($massProcess, $res['result']['flour'], $res['result']['water']);
                    $res['result']['flour'] -= $batchSize;
                    $res['result']['water'] -= $batchSize;
                    $res['result']['dough'] ??= 0;
                    $res['result']['dough'] += $batchSize * $avgRate;
                } else {
                    throw new Exception('Unknown input');
                }
    
                $weight = 0;
    
                foreach ($res['result'] as $ingredient => $count) {
                    $weight += $count * $weights[$ingredient];
                }
    
                $res['maxWeight'] = max($weight, $res['maxWeight']);
    
                if ($weight > $weightLimit) {
                    break;
                }
                
                $res['processingTime'] += 1.2;
            } while ($res['result'][$input] ?? 0 > 0);
        }

        $totalPrice = 0;

        foreach ($res['result'] as $ingredient => $quantity) {
            $totalPrice += $quantity * $prices[$ingredient];
        }
        
        $totalPrice /= 1000;

        $res['totalPrice'] = $totalPrice;
        $res['totalProfit'] = $res['totalPrice'] - $res['totalCost'];
        $res['profitPerH'] = $res['totalProfit'] / ($res['processingTime'] / 60);
        $res['weight'] = $weight;

        // 4x 1_330_000
        // 8389 flour


        return $this->render($response, TPL_DIR . '/processing.tpl.php', [
            'res' => $res,
        ]);
    }
}
