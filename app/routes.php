<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Controllers\AdviceController;
use App\Application\Controllers\IndexController;
use App\Application\Controllers\EnhaController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

function getPrices(): array
{
    return [
        'bs' => 280,
        'hardCrystal' => 1_500,
        'grunil' => 300,
        'rebla' => 13,
        'penGrunil' => 1_800_000,
        'mem' => 2_700,
    ];
}

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', IndexController::class);
    $app->get('/advice/{fs}', AdviceController::class);
    $app->get('/{item}/{level}', EnhaController::class);
};

function calculateChance(float $baseChance, int $failstacks): float
{
    return $baseChance + $baseChance / 10 * $failstacks;
}

function calculateAdvicePrice(int $desiredFs, array $prices): array
{
    $items = [
        14 => [
            'baseChance' => 2.0,
            'gain' => 1,
            'name' => '+14 rebla',
        ],
        17 => [
            'baseChance' => 7.69,
            'gain' => 3,
            'name' => 'PRI grunil',
        ],
        18 => [
            'baseChance' => 6.25,
            'gain' => 4,
            'name' => 'DUO grunil',
        ],
        19 => [
            'baseChance' => 2.0,
            'gain' => 5,
            'name' => 'TRI grunil',
        ],
        20 => [
            'baseChance' => 0.3,
            'gain' => 6,
            'name' => 'TET grunil',
        ],
    ];

    $res = [
        'fs' => 0,
        'used' => [
            'bs' => 0,
            'hardCrystal' => 0,
            'rebla' => 0,
            'grunil' => 0,
            'grunil_PRI' => 0,
            'grunil_DUO' => 0,
            'grunil_TRI' => 0,
            'grunil_TET' => 0,
        ],
        'totalPrice' => 0,
        'totalGain' => 0,
        'progress' => [],
    ];

    $fs = 0;

    while ($fs < $desiredFs) {
        if ($fs < 22) {
            $item = 14;
        } elseif ($fs < 28) {
            $item = 17;
        } elseif ($fs < 43) {
            $item = 18;
        } elseif ($fs < 88) {
            $item = 19;
        } else {
            $item = 20;
        }

        $usedItem = $items[$item];
        $enchantChance = calculateChance($usedItem['baseChance'], $fs);

        $res['progress'][] = [
            'fs' => $fs,
            'item' => $usedItem['name'],
            'baseChance' => $usedItem['baseChance'],
            'chance' => $enchantChance,
            'gain' => $usedItem['gain'],
        ];

        $clickPrice = 0;

        if ($item < 17) {
            $usedBs = 1;
            $usedRebla = 0.5;
            $usedGrunil = 0;
            $usedHardCrystal = 0;
        } else {
            $usedBs = 2;
            $usedRebla = 0;
            $usedGrunil = 1;
            $usedHardCrystal = 1;
        }

        $res['used']['bs'] += $usedBs;
        $res['used']['hardCrystal'] += $usedHardCrystal;
        $res['used']['rebla'] += $usedRebla;

        if ($item > 14) {
            $res['used']['grunil'] += 1;
            $res['used'][sprintf('grunil_%s', enhaLevel($item - 1))] += $usedGrunil;
        }
    
        $clickPrice
            = $usedBs * $prices['bs']
            + $usedHardCrystal * $prices['hardCrystal']
            + $usedRebla * $prices['rebla']
            + $usedGrunil * $prices['grunil'];

        $failPrice = (100 / (100 - $enchantChance) - 1) * $res['totalPrice'];

        $res['totalPrice'] += $clickPrice + $failPrice;

        if ($item === 20) {
            $res['totalGain'] += $prices['penGrunil'] * $enchantChance / 100;
        }

        $fs += $usedItem['gain'];
    }

    $res['fs'] = $fs;
    $res['totalPrice'] = round($res['totalPrice']);
    $res['totalGain'] = round($res['totalGain']);
    // $res['totalPrice'] = number_format($res['totalPrice'], 0, '.', '_');
    // $res['totalGain'] = number_format($res['totalGain'], 0, '.', '_');

    return $res;
}

function enhaLevel(int $level): string {
    if ($level <= 15) {
        return "{$level}";
    }

    switch ($level) {
        case 16: return 'PRI';
        case 17: return 'DUO';
        case 18: return 'TRI';
        case 19: return 'TET';
        case 20: return 'PEN';
    }

    throw new Exception('ass level');
}