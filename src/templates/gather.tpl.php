<?php
    /** @var array $prices */
    /** @var array $gathered */
    /** @var array $total */

    $items = [
        [
            'name' => 'Meat',
            'id' => 'meat',
        ],
        [
            'name' => 'Black gem fragment',
            'id' => 'gemFragment',
        ],
        [
            'name' => 'Hard black crystal',
            'id' => 'hardCrystal',
        ],
        [
            'name' => 'Caphras stone',
            'id' => 'caphras',
        ],
        [
            'name' => 'Ancient spirit dust',
            'id' => 'spiritDust',
        ],
    ];

?>

<form method="get">
    <?php foreach ($items as $item): ?>
        <div class="mb-3">
            <label for="<?= $item['id']; ?>" class="form-label">
                <?= $item['name']; ?>
                <small class="text-muted">
                    (<?= formatMoney($prices[$item['id']]); ?>)

                    <?php if (($total[$item['id']] ?? 0) > 0): ?>
                        total <?= formatMoney($total[$item['id']]); ?>
                    <?php endif; ?>
                </small>
            </label>
            <input
                    type="number"
                    class="form-control"
                    id="<?= $item['id']; ?>"
                    name="<?= $item['id']; ?>"
                    value="<?= ($gathered[$item['id']] ?? 0) ?: ''; ?>"
            >
        </div>
    <?php endforeach; ?>

    <div class="mb-3">
        <label for="time" class="form-label">Time in minutes</label>
        <input type="number" class="form-control" id="time" name="time" value="<?= $total['time'] ?: 0; ?>">
    </div>

    <div class="mb-4">
        Total:
        <span class="h3"><?= formatMoney($total['totalPrice']); ?></span>

        <small class="text-muted"><?= formatMoney($total['totalPerH']); ?>/h</small>
    </div>

    <button type="submit" class="btn btn-primary">Calculate</button>
</form>
