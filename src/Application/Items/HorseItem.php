<?php
declare(strict_types=1);

namespace App\Application\Items;

class HorseItem extends GreenItem
{
    public function getEnhaChance(int $level): float
    {
        if ($level > 10) {
            return 0;
        }

        $chances = [
            1 => 70.0,
            2 => 44.4,
            3 => 29.6,
            4 => 19.7,
            5 => 13.2,
            6 => 8.79,
            7 => 0.1,
            8 => 0.1,
            9 => 0.1,
            10 => 0.1,
        ];

        return $chances[$level];
    }
}
