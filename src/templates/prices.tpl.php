<?php
use App\Application\Items\ItemInterface;

/** @var array<ItemInterface> $items */

?>

<form action="/prices" method="post">
    <?php foreach ($items as $item): ?>
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

    <button type="submit" class="btn btn-primary">Save</button>
</form>
