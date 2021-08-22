<?php
declare(strict_types=1);

namespace App\Application\Items;

class GreenArmor extends GreenItem
{
    public function getEnhaChance(int $level): float
    {
        if ($level < 8) {
            return 100;
        }

        if ($level > 20) {
            return 0;
        }

        $chances = [
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
            14 => 0,
            15 => 0,
            16 => 0,
            17 => 7.69,
            18 => 6.25,
            19 => 2.0,
            20 => 0.3,
        ];

        return $chances[$level];
    }
}
