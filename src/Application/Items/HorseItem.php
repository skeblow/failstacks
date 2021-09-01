<?php
declare(strict_types=1);

namespace App\Application\Items;

class HorseItem extends Item implements ItemInterface, NonBreakingItemInterface, RepairableItemInterface
{
    public function getEnhaChance(int $level): float
    {
        if ($level > 10) {
            return 0;
        }

        $chances = [
            1 => 70.0,
            2 => 44.4,
            3 => 29.6,
            4 => 19.7,
            5 => 13.2,
            6 => 8.79,
            7 => 0.1,
            8 => 0.1,
            9 => 0.1,
            10 => 0.1,
        ];

        return $chances[$level];
    }

    public function getDurabilityRestored(): int
    {
        return 10;
    }

    public function getDurabilityLost(int $enhaLevel): int
    {
        return 5;
    }

    public function getRepairItemId(): string
    {
        return $this->id;
    }

    public function getEnchantItemId(int $level): string
    {
        return 'bs';
    }
}
