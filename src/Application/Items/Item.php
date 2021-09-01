<?php
declare(strict_types=1);

namespace App\Application\Items;

abstract class Item implements ItemInterface
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected int $basePrice,
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
}
