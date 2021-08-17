<?php
declare(strict_types=1);

namespace Application\Services;

class PricesService
{
    public function getPrices(): array
    {
        $dataFile = DATA_DIR . 'prices.json';

        if (! file_exists($dataFile)) {
            return [];
        }

        return json_decode(file_get_contents($dataFile));
    }

    public function savePrices(array $data): void
    {
        $dataFile = DATA_DIR . 'prices.json';
        
        if (file_exists($dataFile)) {
            unlink($dataFile);
        }

        file_put_contents($dataFile, json_encode($data));
    }
}

