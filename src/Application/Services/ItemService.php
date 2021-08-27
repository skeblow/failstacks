<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Items\BasicItem;
use App\Application\Items\BlueAccessoryItem;
use App\Application\Items\BlueItem;
use App\Application\Items\ItemInterface;
use App\Application\Items\BossItem;
use App\Application\Items\BossArmorItem;
use App\Application\Items\BreakingItemInterface;
use App\Application\Items\GreenArmor;
use App\Application\Items\HorseItem;
use App\Application\Items\RepairableItemInterface;
use App\Application\Items\WhiteArmor;

class ItemService
{
    private const BASIC_ITEMS = [
        'bs' => 'black stone',
        'concentratedBs' => 'concentrated black stone',
        'mem' => 'memory fragment',
        'hardCrystal' => 'hard black crystal',
        'sharpCrystal' => 'sharp black crysyal',
        'caphras' => 'caphras stone',
        'hoofRoot' => 'deep blue hoof root',
        'spiritDust' => 'ancient spirit dust',
        'meat' => 'meat',
    ];

    private const GREEN_ITEMS = [
        'grunil' => 'grunil helmet',
    ];

    private const WHITE_ITEMS = [
        'rebla' => 'rebla gloves',
    ];

    private const BLUE_ITEMS = [
        'procStone' => 'processing stone'
    ];

    private const SILVER_ITEMS = [
        'silverCook' => 'silver embroidered cooks clothes'
    ];

    private const BOSS_WEAPONS = [
        'kzarka' => 'kzarka weapon',
        'manosTool' => 'manos tool',
    ];

    private const BOSS_ARMOR = [
        'bossUrugon' => 'urugon shoes',
    ];

    private const HORSE_ITEMS = [
        'horseShoe' => 'horse shoe',
        'horseSaddle' => 'horse saddle',
        'horseStirrups' => 'horse stirrups',
        'horseArmor' => 'horse armor',
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

        if (isset(self::WHITE_ITEMS[$id])) {
            return new WhiteArmor($id, self::WHITE_ITEMS[$id], $this->pricesService->getPrice($id));
        }

        if (isset(self::GREEN_ITEMS[$id])) {
            return new GreenArmor($id, self::GREEN_ITEMS[$id], $this->pricesService->getPrice($id));
        }

        if (isset(self::BLUE_ITEMS[$id])) {
            return new BlueItem($id, self::BLUE_ITEMS[$id], $this->pricesService->getPrice($id));
        }

        if (isset(self::BOSS_WEAPONS[$id])) {
            return new BossItem($id, self::BOSS_WEAPONS[$id], $basePrice);
        }

        if (isset(self::BOSS_ARMOR[$id])) {
            return new BossArmorItem($id, self::BOSS_ARMOR[$id], $basePrice);
        }

        if (isset(self::HORSE_ITEMS[$id])) {
            return new HorseItem($id, self::HORSE_ITEMS[$id], $basePrice);
        }

        if (isset(self::SILVER_ITEMS[$id])) {
            return new BlueAccessoryItem($id, self::SILVER_ITEMS[$id], $basePrice);
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

    public function getBreakingItem(string $id): BreakingItemInterface
    {
        $item = $this->getItem($id);

        if (! $item instanceof BreakingItemInterface) {
            throw new \Exception(sprintf('Breaking item %s not found!', $id));
        }

        return $item;
    }

    /** @return array<ItemInterface> */
    public function getAllItems(): array
    {
        $itemIds = array_merge(
            array_keys(self::BASIC_ITEMS),
            array_keys(self::WHITE_ITEMS),
            array_keys(self::GREEN_ITEMS),
            array_keys(self::BLUE_ITEMS),
            array_keys(self::BOSS_ARMOR),
            array_keys(self::BOSS_WEAPONS),
            array_keys(self::HORSE_ITEMS),
            array_keys(self::SILVER_ITEMS),
        );
        $items = [];

        foreach ($itemIds as $id) {
            $items[] = $this->getItem($id);
        }

        return $items;
    }
}
