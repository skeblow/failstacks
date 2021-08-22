<?php
declare(strict_types=1);

namespace App\Application\Items;

class WhiteArmor extends GreenItem
{
    public function getEnhaChance(int $level): float
    {
        return 2.0;
    }
}
