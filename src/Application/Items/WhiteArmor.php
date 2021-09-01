<?php
declare(strict_types=1);

namespace App\Application\Items;

class WhiteArmor extends Item implements ItemInterface, NonBreakingItemInterface, RepairableItemInterface
{
    public function getEnhaChance(int $level): float
    {
        return 2.0;
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

    public function getRepairItemId(): string
    {
        return $this->id;
    }

    public function getEnchantItemId(int $level): string
    {
        return 'bs';
    }
}
