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
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
        ];

        return $chances[$level];
    }
}
