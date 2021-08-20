<?php
declare(strict_types=1);

namespace App\Application\Items;

interface RepairableItemInterface extends ItemInterface
{
    public function getDurabilityRestored(): int;
}
