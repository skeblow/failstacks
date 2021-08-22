<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Items\NonBreakingItemInterface;

class AdviceService
{
    public function __construct(
        private ItemService $itemService,
        private PricesService $pricesService,
    ) {}

    public function getAdviceTotalPrice(int $targetFs): int
    {
        return (int)$this->getAdviceProgressForFailStack($targetFs)['totalPrice'];
    }

    public function getAdviceProgressForFailStack(int $targetFs): array
    {
        $fs = 0;

        $progress = [];
        $totalPrice = 0;

        while ($fs < $targetFs) {
            $clickedItem = $this->getClickedItem($fs);
            $clickedItemLevel = $this->getClickedItemLevel($fs);
            $duraLost = $clickedItem->getDurabilityLost($clickedItemLevel);
            $repairPrice = $duraLost
                    * $clickedItem->getBasePrice() 
                    / $clickedItem->getDurabilityRestored();

            $fsGain = $this->getFailedEnchantFsGain($clickedItemLevel);
            $baseEnhaChance = $clickedItem->getEnhaChance($clickedItemLevel + 1);
            $enhaItem = $this->itemService->getItem($clickedItem->getEnchantItemId($clickedItemLevel));
            $enhaChance = $this->calculateEnhaChance($baseEnhaChance, $fs);
            $enhaItemPrice = $this->pricesService->getPrice($enhaItem->getId());
            $dropLevelPrice = $this->getDropLevelPrice($clickedItemLevel);

            $clickPrice = $enhaItemPrice + $repairPrice + $dropLevelPrice;
            $totalPrice += $clickPrice;
            $failPrice = (100 / (100 - $enhaChance) - 1) * $totalPrice;
            $totalPrice += $failPrice;

            $progress[] = [
                'fs' => $fs,
                'clickedItem' => $clickedItem->getId(),
                'clickedItemLevel' => $clickedItemLevel,
                'clickedItemDropLevelPrice' => $dropLevelPrice,
                'clickedItemDuraLost' => $duraLost,
                'repairPrice' => $repairPrice,
                'fsGain' => $fsGain,
                'baseChance' => $baseEnhaChance,
                'enhaChance' => $enhaChance,
                'enhaItem' => $enhaItem->getId(),
                'enhaItemPrice' => $enhaItemPrice,
                'failPrice' => round($failPrice),
                'clickPrice' => round($clickPrice),
                'totalPrice' => round($totalPrice),
            ];

            $fs += $fsGain;
        }

        return [
            'totalPrice' => $totalPrice,
            'progress' => $progress,
        ];
    }

    private function getDropLevelPrice(int $level): int
    {
        $map = [
            17 => 15_412,
            18 => 17_800,
            19 => 41_028,
        ];

        if (isset($map[$level])) {
            return $map[$level];
        }

        return 0;
    }

    private function getClickedItem(int $fs): NonBreakingItemInterface
    {
        if ($fs < 22) {
            return $this->itemService->getItem('rebla');
        }

        return $this->itemService->getItem('grunil');
    }

    private function calculateEnhaChance(float $baseChance, int $failstacks): float
    {
        return min($baseChance + $baseChance / 10 * $failstacks, 100);
    }

    private function getClickedItemLevel(int $fs)
    {
        if ($fs < 22) {
            return 14;
        }

        if ($fs < 28) {
            return 16;
        }

        if ($fs < 43) {
            return 17;
        }

        if ($fs < 88) {
            return 18;
        }

        return 19;
    }

    private function getFailedEnchantFsGain(int $level): int
    {
        if ($level < 16) {
            return 1;
        }

        if ($level === 16) {
            return 2;
        }

        if ($level === 17) {
            return 3;
        }

        if ($level === 17) {
            return 3;
        }

        if ($level === 18) {
            return 4;
        }

        if ($level === 19) {
            return 5;
        }

        if ($level === 20) {
            return 6;
        }

        throw new \Exception(sprintf('Level %s is too high!', $level));
    }
}
