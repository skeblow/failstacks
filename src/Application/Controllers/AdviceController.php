<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Services\AdviceService;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdviceController extends BaseController
{
    public function __construct(
        private AdviceService $adviceService,
    ) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $fs = (int) $args['fs'];

        if ($fs < 1 || $fs > 200) {
            throw new Exception('fu');
        }

        $allAdvices = [];

        for ($i = 0; $i < 150; $i++) {
            $allAdvices[] = [
                'fs' => $i,
                'totalPrice' => $this->adviceService->getAdviceTotalPrice($i),
            ];
        }

        $res = $this->adviceService->getAdviceProgressForFailStack($fs);

        var_dump(calculateAdvicePrice($fs, getPrices())['totalPrice']);
        //var_dump($res); exit;

        return $this->render($response, TPL_DIR . '/advice.tpl.php', [
            'fs' => $fs,
            'res' => $res,
            'allAdvices' => $allAdvices,
        ]);
    }
}
