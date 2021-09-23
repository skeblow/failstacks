<?php
declare(strict_types=1);

namespace App\Application\Items;

class YellowAccessoryItem implements ItemInterface, BreakingItemInterface
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
            1 => 25.0,
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
        return 1;
    }
}
