<?php
declare(strict_types=1);

namespace App\Application\Items;

class GreenItem implements ItemInterface, NonBreakingItemInterface, RepairableItemInterface
{
    public function __construct(
        private string $id,
        private string $name,
        private int $basePrice,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBasePrice(): int
    {
        return $this->basePrice;
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
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
            14 => 5,
            15 => 0,
            16 => 0,
            17 => 0,
            18 => 0,
            19 => 0,
            20 => 0,
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

    public function getRepairItemId(): string
    {
        return $this->id;
    }

    public function getEnchantItemId(int $level): string
    {
        if ($level > 15) {
            return 'concentratedBs';
        }

        return 'bs';
    }
}
