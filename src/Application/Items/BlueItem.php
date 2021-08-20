<?php
declare(strict_types=1);

namespace App\Application\Items;

class BlueItem implements ItemInterface, NonBreakingItemInterface, RepairableItemInterface
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

    public function getRepairItemId(): string
    {
        return $this->id;
    }
}
