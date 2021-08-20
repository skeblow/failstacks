<?php
declare(strict_types=1);

namespace App\Application\Items;

class BasicItem implements RepairableItemInterface
{
    public function __construct(
        private string $id,
        private string $name,
        private int $basePrice,
        private int $durabilityRestored,
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

    public function getDurabilityRestored(): int
    {
        return $this->durabilityRestored;
    }
}
