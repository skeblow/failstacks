<?php
declare(strict_types=1);

namespace App\Application\Services;

use function PHPUnit\Framework\directoryExists;

class PricesService
{
    public function getPrice(string $productId): int
    {
        $prices = $this->getPrices();

        if ($productId === 'spiritDust') {
            if (! isset($prices['caphras'], $prices['bs'])) {
                return 0;
            }

            return ($prices['caphras'] - $prices['bs']) / 5;
        }

        if (! isset($prices[$productId])) {
            return 0;
            // throw new \Exception(sprintf('Price for product %s not found!', $productId));
        }
    
        return $prices[$productId];
    }

    public function getPrices(): array
    {
        $dataFile = DATA_DIR . 'prices.json';

        if (! file_exists($dataFile)) {
            return [];
        }

        return json_decode(file_get_contents($dataFile), true);
    }

    public function savePrices(array $data): void
    {
        $dataFile = DATA_DIR . 'prices.json';
        
        if (! directoryExists(DATA_DIR)) {
            mkdir(DATA_DIR);
        }

        if (file_exists($dataFile)) {
            unlink($dataFile);
        }

        file_put_contents($dataFile, json_encode($data));
    }
}
