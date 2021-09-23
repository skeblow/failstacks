<?php

use App\Application\Items\BasicItem;
use App\Application\Items\BlueAccessoryItem;
use App\Application\Items\BlueItem;
use App\Application\Items\BossItem;
use App\Application\Items\GreenItem;
use App\Application\Items\HorseItem;
use App\Application\Items\ItemInterface;
use App\Application\Items\YellowAccessoryItem;

/** @var array<ItemInterface> $items */

$itemTypes = [
    [
        'name' => 'basic items',
        'type' => BasicItem::class,
    ],
    [
        'name' => 'green items',
        'type' => GreenItem::class,
    ],
    [
        'name' => 'blue items',
        'type' => BlueItem::class,
    ],
    [
        'name' => 'blue accessory items',
        'type' => BlueAccessoryItem::class,
    ],
    [
        'name' => 'yellow accessory items',
        'type' => YellowAccessoryItem::class,
    ],
    [
        'name' => 'boss items',
        'type' => BossItem::class,
    ],
    [
        'name' => 'horse items',
        'type' => HorseItem::class,
    ],

];

?>

<?php // var_dump($items); ?>

<form action="/prices" method="post">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php foreach($itemTypes as $itemType): ?>
            <?php $id = str_replace(' ', '_', $itemType['name']); ?>
            <?php $isActive = $id === 'basic_items'; ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link<?= $isActive ? ' active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#<?=$id ?>" type="button"><?= $itemType['name']; ?></button>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content mt-4" id="myTabContent">
        <?php foreach($itemTypes as $itemType): ?>
            <?php $id = str_replace(' ', '_', $itemType['name']); ?>
            <?php $isActive = $id === 'basic_items'; ?>

            <div class="tab-pane <?= $isActive ? ' fade show active' : '' ?>" id="<?= $id ?>">
            
            <?php foreach ($items as $item): ?>
                <?php if (! is_a($item, $itemType['type'])) continue; ?>

                <div class="form-group mb-3">
                    <label for="<?= $item->getId(); ?>" class="form-label">
                        <?= $item->getName(); ?>
                    </label>
                    <input
                            type="number"
                            class="form-control"
                            id="<?= $item->getId(); ?>"
                            name="<?= $item->getId(); ?>"
                            value="<?= $item->getBasePrice(); ?>"
                    >
                </div>
            <?php endforeach; ?>

            </div>
        <?php endforeach; ?>        
    </div>


    <button type="submit" class="btn btn-primary">Save</button>
</form>
