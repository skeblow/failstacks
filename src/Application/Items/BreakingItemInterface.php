<?php
declare(strict_types=1);

namespace App\Application\Items;

interface BreakingItemInterface extends EnchantableItemIterface
{
    public function getId(): string;
    public function getLevelPriceMultiplier(int $level): float;
}
