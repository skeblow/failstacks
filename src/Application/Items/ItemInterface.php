<?php
declare(strict_types=1);

namespace App\Application\Items;

interface ItemInterface
{
    public function getId(): string;
    public function getName(): string;
    public function getBasePrice(): int;
}
