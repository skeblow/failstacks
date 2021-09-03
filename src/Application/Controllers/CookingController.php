<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CookingController extends BaseController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $query = $request->getQueryParams();
        $totalQuantity = (int)($query['quantity'] ?? 800);
        $avgCook = (float)($query['avg'] ?? 2.5);

        $recipes = [
            'valencia' => [
                'teffSandwich' => 1,
                'couscous' => 1,
                'hamburg' => 1,
                'datePalmWine' => 2,
                'figPie' => 2,
            ],
            'couscous' => [
                'freekehSnake' => 1,
                'nutmeg' => 3,
                'teffDough' => 6,
                'paprika' => 4, 
            ],
            'freekehSnake' => [
                'freekeh' => 6,
                'water' => 5,
                'snake' => 3,
                'anise' => 2,
            ],
            'datePalmWine' => [
                'datePalm' => 5,
                'liquor' => 2,
                'leavening' => 4,
                'sugar' => 1,
            ],
            'figPie' => [
                'dough' => 3,
                'fig' => 5,
                'oliveOil' => 2,
                'sugar' => 3,
            ],
            'hamburg' => [
                'lion' => 4,
                'nutmeg' => 3,
                'pickled' => 2,
                'teffBread' => 4,
            ],
            'teffSandwich' => [
                'grilledScorpion' => 1,
                'freekehSnake' => 1,
                'redSauce' => 3,
                'teffBread' => 1,
            ],
            'teffBread' => [
                'leavening' => 2,
                'water' => 3,
                'salt' => 2,
                'teffFlour' => 5,
            ],
            'grilledScorpion' => [
                'butter' => 2,
                'hotPepper' => 1,
                'nutmeg' => 3,
                'scorpion' => 3,
            ],
        ];

        $weights = [
            'valencia' => 0.1,
            'couscous' => 0.1,
            'datePalmWine' => 0.1,
            'figPie' => 0.1,
            'hamburg' => 0.1,
            'teffSandwich' => 0.1,
            'freekehSnake' => 0.1,
            'nutmeg' => 0.1,
            'teffDough' => 0.1,
            'paprika' => 0.1,
            'datePalm' => 0.1,
            'liquor' => 0.01,
            'leavening' => 0.01,
            'sugar' => 0.01,
            'dough' => 0.1,
            'fig' => 0.1,
            'oliveOil' => 0.01,
            'lion' => 0.03,
            'pickled' => 0.1,
            'teffBread' => 0.1,
            'grilledScorpion' => 0.1,
            'redSauce' => 0.01,
            'freekeh' => 0.1,
            'water' => 0.01,
            'snake' => 0.03,
            'anise' => 0.1,
            'salt' => 0.01,
            'teffFlour' => 0.1,
            'butter' => 0.01,
            'hotPepper' => 0.1,
            'scorpion' => 0.03,
        ];

        $names = [
            'valencia' => 'Valencia meal',
            'couscous' => 'Couscous',
            'datePalmWine' => 'Date palm wine',
            'figPie' => 'Fig pie',
            'hamburg' => 'King of jungle hamburg',
            'teffSandwich' => 'Teff sandwich',
            'freekehSnake' => 'Freekeh snake stew',
            'nutmeg' => 'Nutmeg',
            'teffDough' => 'Teff dough',
            'paprika' => 'Paprika',
            'datePalm' => 'Date palm',
            'liquor' => 'Essence of liquor',
            'leavening' => 'Leavening agent',
            'sugar' => 'Sugar',
            'dough' => 'Dough',
            'fig' => 'Fig',
            'oliveOil' => 'Olive oil',
            'lion' => 'Lion meat',
            'pickled' => 'Pickled vegetable',
            'teffBread' => 'Teff bread',
            'grilledScorpion' => 'Grilled scorpion',
            'redSauce' => 'Red sauce',
            'freekeh' => 'Freekeh',
            'water' => 'Mineral water',
            'snake' => 'Snake meat',
            'anise' => 'Star anise',
            'salt' => 'Salt',
            'teffFlour' => 'Teff flour',
            'butter' => 'Butter',
            'hotPepper' => 'Special hot pepper',
            'scorpion' => 'Scorpion meat',
        ];

        $forPreparation = [
           // 'teffDough',
            'liquor',
            'butter',
            'pickled',
            'redSauce',
            'paprika',
            'leavening',
            'sugar',
            'oliveOil',
            'water',
            'salt',
            'hotPepper',
            'nutmeg',
            'grilledScorpion',
            'freekehSnake',
            'teffBread',
        ];

        $prepared = [];

        foreach ($recipes['valencia'] as $meal => $mealQuantity) {
            $qMultiplier = $totalQuantity * $mealQuantity / $avgCook;

            foreach ($recipes[$meal] as $ingredient => $quantity) {
                $ingredientQuantity = $qMultiplier * $quantity;

                if (! in_array($ingredient, $forPreparation, true)) {
                    continue;
                }

                $prepared[$ingredient] ??= 0;
                $prepared[$ingredient] += $ingredientQuantity;
            }
        }

        foreach ($prepared as $ingredient => $ingredientQuantity) {
            if (! isset($recipes[$ingredient])) {
                continue;
            }

            foreach ($recipes[$ingredient] as $ingredient => $quantity) {
                if (! in_array($ingredient, $forPreparation, true)) {
                    continue;
                }

               $prepared[$ingredient] ??= 0;
               $prepared[$ingredient] += $ingredientQuantity / $avgCook * $quantity;
            }
        }

        uksort($prepared, static fn ($v1, $v2) => (array_flip($forPreparation)[$v1] ?? 0) <=> (array_flip($forPreparation)[$v2] ?? 0));

        return $this->render($response, TPL_DIR . '/cooking.tpl.php', [
            'totalQuantity' => $totalQuantity,
            'avgCook' => $avgCook,
            'names' => $names,
            'recipes' => $recipes,
            'weights' => $weights,
            'preparation' => $prepared,
        ]);
    }
}