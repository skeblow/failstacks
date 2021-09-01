<?php
declare(strict_types=1);

namespace App\Application\Items;

class BossItem extends Item implements ItemInterface, NonBreakingItemInterface, RepairableItemInterface
{
    public function getRepairItemId(): string
    {
        return 'mem';
    }

    public function getEnhaChance(int $level): float
    {
        if ($level < 8) {
            return 100;
        }

        if ($level > 20) {
            return 0;
        }

        $chances = [
            8 => 90.0,
            9 => 20.4,
            10 => 14.28,
            11 => 10.0,
            12 => 6.66,
            13 => 4.0,
            14 => 2.5,
            15 => 2.0,
            16 => 11.76,
            17 => 7.69,
            18 => 6.25,
            19 => 2.0,
            20 => 0.3,
        ];

        return $chances[$level];
    }

    public function getDurabilityRestored(): int
    {
        return 10;
    }

    public function getDurabilityLost(int $enhaLevel): int
    {
        return $enhaLevel < 16 
            ? 5
            : 10;
    }

    public function getEnchantItemId(int $level): string
    {
        if ($level > 15) {
            return 'concentratedBs';
        }

        return 'bs';
    }
}
