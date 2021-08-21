<?php
declare(strict_types=1);

namespace App\Application\Items;

interface EnchantableItemIterface extends ItemInterface
{
    public function getEnhaChance(int $level): float;
    public function getEnchantItemId(int $level): string;
}
