<?php
declare(strict_types=1);

namespace App\Application\Items;

interface NonBreakingItemInterface extends EnchantableItemIterface
{
    public function getDurabilityRestored(): int;
    public function getDurabilityLost(int $enhaLevel): int;
    public function getRepairItemId(): string;
}
