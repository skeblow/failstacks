<?php
declare(strict_types=1);

namespace App\Application\Items;

class BlueAccessoryItem implements ItemInterface, BreakingItemInterface
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
        if ($level > 5) {
            throw new \Exception('Too high level');
        }

        $chances = [
            1 => 30.0,
            2 => 10.0,
            3 => 7.5,
            4 => 2.5,
            5 => 0.5,
        ];

        return $chances[$level];
    }

    public function getEnchantItemId(int $level): string
    {
        return $this->id;   
    }

    public function getLevelPriceMultiplier(int $level): float
    {
        $multipliers = [
            0 => 1,
            1 => 5.3,
            2 => 21.5,
            3 => 174.4,
            4 => 1500, 
            5 => 6857,
        ];

        return $multipliers[$level];
    }
}
