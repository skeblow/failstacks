<?php
declare(strict_types=1);

namespace App\Application\Items;

interface EnchantableItemIterface
{
    public function getEnhaChance(int $level): float;
}
