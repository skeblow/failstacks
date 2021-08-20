<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Items\BasicItem;
use App\Application\Items\BlueItem;
use App\Application\Items\ItemInterface;
use App\Application\Items\BossItem;
use App\Application\Items\RepairableItemInterface;
use PHPUnit\Framework\MockObject\MatchBuilderNotFoundException;

class ItemService
{
    private const BASIC_ITEMS = [
        'bs' => 'black stone',
        'mem' => 'memory fragment',
        'hardCrystal' => 'hard black crystal',
        'sharpCrystal' => 'sharp black crysyal',
        'caphras' => 'caphras stone',
        'hoofRoot' => 'deep blue hoof root',
        'spiritDust' => 'ancient spirit dust',
        'meat' => 'meat',
    ];

    private const GREEN_GEAR = [
        'grunil' => 'grunil helmet',
    ];

    private const BLUE_ITEMS = [
        'procStone' => 'processing stone'
    ];

    private const SILVER = [
        'silverCook' => 'silver embroidered cooks clothes'
    ];

    private const BOSS_GEAR = [
        'kzarka' => 'kzarka weapon',
    ];

    public function __construct(
        private PricesService $pricesService,
    ) {}

    public function getItem(string $id): ItemInterface
    {
        $basePrice = $this->pricesService->getPrice($id);

        if (isset(self::BASIC_ITEMS[$id])) {
            return new BasicItem(
                $id,
                self::BASIC_ITEMS[$id],
                $this->pricesService->getPrice($id),
                1,
            );
        }

        if (isset(self::BLUE_ITEMS[$id])) {
            return new BlueItem(
                $id,
                self::BLUE_ITEMS[$id],
                $this->pricesService->getPrice($id),
            );
        }

        if (isset(self::BOSS_GEAR[$id]))
        {
            return new BossItem($id, self::BOSS_GEAR[$id], $basePrice);
        }

        throw new \Exception(sprintf('Item %s not found!', $id));
    }

    public function getRepairItem(string $id): RepairableItemInterface
    {
        if ($id === 'mem') {
            return $this->getItem($id);
        }

        $item = $this->getItem($id);

        if (! $item instanceof RepairableItemInterface) {
            throw new \Exception(sprintf('Repair item %s not found!', $id));
        }

        return $item;
    }

    /** @return array<ItemInterface> */
    public function getAllItems(): array
    {
        $itemIds = array_merge(
            array_keys(self::BASIC_ITEMS),
            array_keys(self::BLUE_ITEMS),
        );
        $items = [];

        foreach ($itemIds as $id) {
            $items[] = $this->getItem($id);
        }

        return $items;
    }
}
