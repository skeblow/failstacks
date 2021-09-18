<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlchemyController extends BaseController
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $query = $request->getQueryParams();
        $totalQuantity = (int)($query['quantity'] ?? 50);
        $avgCook = (float)($query['avg'] ?? 2.5);
        $main = $args['main'];

        $recipes = [
            'verdure' => [
                'workersElixir' => 3,
                'timeElixir' => 3,
                'swiftElixir' => 3,
                'fallingMoon' => 1,
            ],
            'workersElixir' => [
                'sinnersBlood' => 1,
                'azalea' => 6,
                'ashSap' => 4,
                'flamePowder' => 2,
            ],
            'timeElixir' => [
                'wiseBlood' => 1,
                'fireFlake' => 2,
                'timePowder' => 2,
                'mapleSap' => 5,
            ],
            'swiftElixir' => [
                'legendaryBlood' => 1,
                'arrowShroom' => 5,
                'birchSap' => 5,
                'darkPowder' => 2,
            ],
        
            'sinnersBlood' => [
                'bloodyKnot' => 1,
                'flamePowder' => 1,
                'clearReagent' => 1,
                'blood2' => 2,
            ],
            'wiseBlood' => [
                'monkBranch' => 1,
                'ascensionTrace' => 1,
                'clearReagent' => 1,
                'blood3' => 2,
            ],
            'legendaryBlood' => [
                'spiritsLeaf' => 1,
                'earthTrace' => 1,
                'powderReagent' => 1,
                'blood5' => 2,
            ],
        ];
        $names = [
            'verdure' => 'Verdure draught',
            'workersElixir' => 'Worker\'s elixir',
            'timeElixir' => 'Elixir of time',
            'swiftElixir' => 'Elixir of switfness',
            'fallingMoon' => 'Tear of the falling moon',
            'sinnersBlood' => 'Sinner\'s blood',
            'azalea' => 'Silver azalea',
            'ashSap' => 'Ash sap',
            'flamePowder' => 'Powder of flame',
            'wiseBlood' => 'Wise man\'s blood',
            'fireFlake' => 'Special fire flake flower',
            'timePowder' => 'Powder of time',
            'mapleSap' => 'Maple sap',
            'legendaryBlood' => 'Legendary beast\'s blood',
            'arrowShroom' => 'Arrow mushroom',
            'birchSap' => 'Birch sap',
            'darkPowder' => 'Powder of darkness',
            'bloodyKnot' => 'Bloody tree knot',
            'clearReagent' => 'Clear liquid reagent',
            'blood2' => 'Sheep blood',
            'monkBranch' => 'Monk\'s branch',
            'ascensionTrace' => 'Trace of ascension',
            'blood3' => 'Fox/weasel blood',
            'spiritsLeaf' => 'Spirit\'s leaf',
            'earthTrace' => 'Trace of the earth',
            'powderReagent' => 'Pure powder reagent',
            'blood5' => 'Kuku blood',
        ];
        $weights = [
            'verdure' => 0.5,
            'workersElixir' => 0.5,
            'timeElixir' => 0.5,
            'swiftElixir' => 0.5,
            'fallingMoon' => 0.1,
            'sinnersBlood' => 0.1,
            'azalea' => 0.1,
            'ashSap' => 0.1,
            'flamePowder' => 0.1,
            'wiseBlood' => 0.1,
            'fireFlake' => 0.1,
            'timePowder' => 0.1,
            'mapleSap' => 0.1,
            'legendaryBlood' => 0.1,
            'arrowShroom' => 0.1,
            'birchSap' => 0.1,
            'darkPowder' => 0.1,
            'bloodyKnot' => 0.1,
            'clearReagent' => 0.1,
            'blood2' => 0.1,
            'monkBranch' => 0.1,
            'ascensionTrace' => 0.1,
            'clearReagent' => 0.1,
            'blood3' => 0.1,
            'spiritsLeaf' => 0.1,
            'earthTrace' => 0.1,
            'powderReagent' => 0.1,
            'blood5' => 0.1,
        ];
        $forPreparation = [
            'fallingMoon',
            'sinnersBlood',
            'wiseBlood',
            'legendaryBlood',
            'ascensionTrace',
            'earthTrace',
            'blood2',
            'blood3',
            'blood5',
            'clearReagent',
            'powderReagent',
            'flamePowder',
            'darkPowder',
            'timePowder',
            'ashSap',
            'mapleSap',
            'birchSap',
        ];
        $prepared = [];

        foreach ($recipes[$main] as $meal => $mealQuantity) {
            $qMultiplier = $totalQuantity * $mealQuantity / $avgCook;

            if (! isset($recipes[$meal])) {
                $prepared[$meal] ??= 0;
                $prepared[$meal] += $mealQuantity * $qMultiplier * $avgCook;

                continue;
            }

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
            'main' => $main,
            'totalQuantity' => $totalQuantity,
            'avgCook' => $avgCook,
            'names' => $names,
            'recipes' => $recipes,
            'weights' => $weights,
            'preparation' => $prepared,
        ]);
    }
}