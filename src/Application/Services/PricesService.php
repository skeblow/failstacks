<?php
declare(strict_types=1);

namespace App\Application\Services;

class PricesService
{
    public function getPrice(string $productId): int
    {
        $prices = [
            'bs' => 280,
            'hardCrystal' => 1_500,
            'sharpCrystal' => 1_600,
            'caphras' => 2_500,
            'grunil' => 300,
            'gemFragment' => 237,
            'rebla' => 13,
            'meat' => 10,
            'penGrunil' => 1_800_000,
            'mem' => 2_700,
            'horseShoe' => 500,
            'hoofRoot' => 2_300,
            'kzarka' => 160,
        ];
        $prices['spiritDust'] = ($prices['caphras'] - $prices['bs']) / 5;
    
        if (! isset($prices[$productId])) {
            throw new \Exception(sprintf('Price for product %s not found!', $productId));
        }
    
        return $prices[$productId];
    }

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
