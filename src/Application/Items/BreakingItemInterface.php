<?php
declare(strict_types=1);

namespace App\Application\Items;

interface BreakingItemInterface
{
    public function getItemId(): string;
}
