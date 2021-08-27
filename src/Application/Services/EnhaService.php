<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Items\BreakingItemInterface;
use App\Application\Items\EnchantableItemIterface;
use App\Application\Items\NonBreakingItemInterface;

class EnhaService
{
    public function __construct(
        private ItemService $itemService,
        private AdviceService $adviceService,
    ) {}

    public function getEnhaResult(string $itemId, int $level): array
    {
        $permaChance = 1;
        $item = $this->itemService->getItem($itemId);

        $res = [
            'targetLevel' => enhaLevel($level),
            'item' => $item,
            'optimal' => null,
            'progress' => [],
        ];

        if (! $item instanceof EnchantableItemIterface) {
            throw new \Exception('Item cannot be enhanced!');
        }

        $optimal = null;

        if ($item instanceof NonBreakingItemInterface) {
            $dropLevelPrice = $this->canLevelDrop($level)
                ? $this->getEnhaResult($item->getId(), $level - 1)['optimal']['totalPrice']
                : 0;
        } else {
            $dropLevelPrice = 0;
        }

        for ($i = 1; $i < 150; $i++) {
            $baseChance = $item->getEnhaChance($level);

            if ($baseChance === 0.0) {
                throw new \Exception(sprintf('Enhachance is 0 for +%s %s!', $level, $item->getId()));
            }

            $enhaChance = calculateChance($baseChance, $i);
            $adviceResult = $this->adviceService->getAdviceProgressForFailStack($i - $permaChance, getPrices());

            if ($adviceResult['fs'] !== $i - $permaChance) {
                continue;
            }

            $advicePrice = round($adviceResult['totalPrice']);

            if ($item instanceof NonBreakingItemInterface) {
                $duraLost = $item->getDurabilityLost($level);
                $repairItem = $this->itemService->getRepairItem($item->getRepairItemId());
                $enchantItem = $this->itemService->getItem($item->getEnchantItemId($level));

                $repairPrice = $duraLost
                    * $repairItem->getBasePrice() 
                    / $repairItem->getDurabilityRestored();

                $enchantItemPrice = $enchantItem->getBasePrice();
            } elseif ($item instanceof BreakingItemInterface) {
                $repairItem = $this->itemService->getBreakingItem($item->getId());

                $repairPrice = $repairItem->getBasePrice() * $repairItem->getLevelPriceMultiplier($level - 1);
                $enchantItemPrice = $item->getBasePrice();
                $levelDecreasePrice = 0;
            } else {
                throw new \Exception('Not enchantable item!');
            }

            $totalPrice = $advicePrice
                + $repairPrice * 100 / $enhaChance
                + $enchantItemPrice * 100 / $enhaChance
                + $dropLevelPrice * 100 / $enhaChance
            ;

            $totalPrice = round($totalPrice);

            $trial = [
                'fs' => $i,
                'baseChance' => $baseChance,
                'enhaChance' => $enhaChance,
                'advicePrice' => $advicePrice,
                'durabilityLost' => $duraLost ?? 0,
                'repairPrice' => $repairPrice,
                'enchantItem' => $item->getEnchantItemId($level),
                'enchantItemPrice' => $enchantItemPrice,
                'dropLevelPrice' => $dropLevelPrice,
                'totalPrice' => $totalPrice,
            ];

            $res['progress'][] = $trial;

            $optimal ??= $trial;

            if ($totalPrice < $optimal['totalPrice']) {
                $optimal = $trial;
            }

            if ($enhaChance > 70) {
                break;
            }
        }

        $res['optimal'] = $optimal;

        return $res;
    }

    private function canLevelDrop(int $level): bool
    {
        return $level >= 18;
    }
}
