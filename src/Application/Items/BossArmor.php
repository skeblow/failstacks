<?php
declare(strict_types=1);

namespace App\Application\Items;

class BossArmor extends BossItem
{
    public function getEnhaChance(int $level): float
    {
        if ($level < 7) {
            return 100;
        }

        if ($level > 20) {
            return 0;
        }

        $chances = [
            7 => 25.65,
            8 => 17.25,
            9 => 11.77,
            10 => 7.695,
            11 => 6.255,
            12 => 5.0,
            13 => 4.0,
            14 => 2.5,
            15 => 2.0,
            16 => 11.76,
            17 => 7.69,
            18 => 6.25,
            19 => 2.0,
            20 => 0.3,
        ];

        return $chances[$level];
    }

    public function getRepairItemId(): string
    {
        return 'mem';
    }
}
