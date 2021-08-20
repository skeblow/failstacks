<?php
declare(strict_types=1);

namespace App\Application\Items;

class BossItem extends BlueItem
{
    public function getRepairItemId(): string
    {
        return 'mem';
    }
}
