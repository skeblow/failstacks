<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Items\BasicItem;
use App\Application\Items\ItemInterface;
use App\Application\Items\BossItem;
use App\Application\Items\RepairableItemInterface;

class ItemService
{
    public function __construct(
        private PricesService $pricesService,
    ) {}

    public function getItem(string $id): ItemInterface
    {
        $basePrice = $this->pricesService->getPrice($id);

        if ($id === 'mem') {
            return new BasicItem(
                $id,
                'memory fragment',
                $this->pricesService->getPrice($id),
                1,
            );
        }

        return new BossItem($id, $id, $basePrice);
    }

    public function getRepairItem(string $id): RepairableItemInterface
    {
        if ($id === 'mem') {
            return $this->getItem($id);
        }

        throw new \Exception(sprintf('Repair item %s not found!', $id));
    }

    /** @return array<ItemInterface> */
    public function getAllItems(): array
    {
        $itemIds = [
            'mem',
            'kzarka',
        ];
        $items = [];

        foreach ($itemIds as $id) {
            $items[] = $this->getItem($id);
        }

        return $items;
    }
}
