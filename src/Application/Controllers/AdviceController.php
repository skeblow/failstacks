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

        for ($i = (int)($fs * 0.75); $i < (int)($fs * 1.25); $i++) {
        // for ($i = 1; $i < 110; $i++) {
            $adviceResult = $this->adviceService->getAdviceProgressForFailStack($i);

            if ($adviceResult['fs'] !== $i) {
                continue;
            }

            $allAdvices[] = [
                'fs' => $i,
                'totalPrice' => round($adviceResult['totalPrice']),
            ];
        }

        $res = $this->adviceService->getAdviceProgressForFailStack($fs);

        return $this->render($response, TPL_DIR . '/advice.tpl.php', [
            'fs' => $fs,
            'res' => $res,
            'allAdvices' => $allAdvices,
        ]);
    }
}
