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
        $used = [];
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
            $increaseLevelPrice = $this->getLevelIncreasePrice($clickedItemLevel);

            $failChance = 100 - $enhaChance;

            $failPrice = $totalPrice * ($enhaChance / 100);

            $clickPrice = $enhaItemPrice
                + $repairPrice * ($failChance / 100)
                + $increaseLevelPrice * ($enhaChance / 100)
                + $dropLevelPrice * ($failChance / 100) 
            ;
            // $totalPrice += $clickPrice;
            // $failPrice = (100 / (100 - $enhaChance) - 1) * $totalPrice;
            $totalPrice += $clickPrice;

            $totalPrice += $failPrice;
            // $totalPrice -= $increaseLevelPrice * ($enhaChance / 100);

            $progress[] = [
                'fs' => $fs,
                'clickedItem' => $clickedItem->getId(),
                'clickedItemLevel' => $clickedItemLevel,
                'clickedItemDuraLost' => $duraLost,
                'repairPrice' => $repairPrice,
                'fsGain' => $fsGain,
                'baseChance' => $baseEnhaChance,
                'enhaChance' => $enhaChance,
                'failChance' => $failChance,
                'enhaItem' => $enhaItem->getId(),
                'enhaItemPrice' => $enhaItemPrice,
                'clickedItemLevelDropPrice' => $dropLevelPrice,
                'clickedItemLevelIncreasePrice' => $increaseLevelPrice,
                'failPrice' => round($failPrice),
                'clickPrice' => round($clickPrice),
                'totalPrice' => round($totalPrice),
            ];

            $used[$enhaItem->getId()] ??= 0;
            $used[$enhaItem->getId()]++;
            $used[$clickedItemLevel] ??= 0;
            $used[$clickedItemLevel]++;

            $fs += $fsGain;
        }

        return [
            'totalPrice' => $totalPrice,
            'fs' => $fs,
            'used' => $used,
            'progress' => $progress,
        ];
    }

    private function getDropLevelPrice(int $level): int
    {
        $map = [
            17 => 17_800,
            18 => 55_000,
            19 => 350_000,
        ];

        if (isset($map[$level])) {
            return $map[$level];
        }

        return 0;
    }

    private function getLevelIncreasePrice(int $level): int
    {
        $map = [
            14 => 100,
            16 => -17_000,
            17 => -41_000,
            18 => -350_000,
            19 => -1_407_000,
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
