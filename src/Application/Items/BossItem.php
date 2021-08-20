<?php
declare(strict_types=1);

namespace App\Application\Items;

class BossItem implements ItemInterface, NonBreakingItemInterface
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
            8 => 1.0,
            9 => 1.0,
            10 => 1.0,
            11 => 1.0,
            12 => 1.0,
            13 => 1.0,
            14 => 1.0,
            15 => 1.0,
            16 => 1.0,
            17 => 1.0,
            18 => 1.0,
            19 => 1.0,
            20 => 1.0,
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
        return 'mem';
    }
}
