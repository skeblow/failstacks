<?php

/** @var int $totalQuantity */
/** @var float $avgCook */
?>

<div class="row mb-4">
    <div class="col-9">
        <h1 class="h2"><?= $totalQuantity * $avgCook ?>x Valencia meal</h1>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <form method="get">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Craft quantity</span>
                        <input type="text" class="form-control" name="quantity" value="<?= $totalQuantity ?>">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Avg rate</span>
                        <input type="text" class="form-control" name="avg" value="<?= $avgCook ?>">
                    </div>
                    <!-- <div class="input-group mb-3">
                        <span class="input-group-text">Spec rate</span>
                        <input type="text" class="form-control" name="avg" value="0.3">
                    </div> -->
                    <div class="d-grid">
                        <button class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-4 mb-4">
        <div class="card">
            <div class="card-header">preparation</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php $totalWeight = 0 ?>
                    <?php foreach ($preparation as $prepared => $preparedQuantity): ?>
                        <?php if (isset($recipes[$prepared])) continue ?>
                        <?php $totalWeight += $weights[$prepared] * $preparedQuantity ?>
                        <li class="list-group-item">
                            <span class="badge bg-info rounded-pill"><?= $preparedQuantity ?></span>
                            <?= $names[$prepared] ?>
                        </li>
                    <?php endforeach ?>
                    <li class="list-group-item">
                        Total weight:
                        <strong><?= $totalWeight ?></strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php foreach ($preparation as $prepared => $preparedQuantity): ?>
        <?php if (! isset($recipes[$prepared])) continue ?>

        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <?= $preparedQuantity / $avgCook ?>x 
                    <?= $names[$prepared] ?>
                    <small>(<?= $preparedQuantity ?>)</small>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php $qMultiplier = $preparedQuantity / $avgCook ?>
                        <?php $totalWeight = 0 ?>
                        <?php foreach ($recipes[$prepared] as $ingredient => $quantity): ?>
                            <?php if (isset ($preparation[$ingredient])) continue ?>
                            <?php $ingredientQuantity = $qMultiplier * $quantity ?>
                            <?php $totalWeight += $weights[$ingredient] * $ingredientQuantity ?>
                            <li class="list-group-item">
                                <span class="badge bg-info rounded-pill"><?= $ingredientQuantity ?></span>
                                <?= $names[$ingredient] ?>
                            </li>
                        <?php endforeach ?>
                        <li class="list-group-item">
                            Total weight:
                            <strong><?= $totalWeight ?></strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    <?php endforeach ?>
</div>
<hr>
<div class="row">
    <?php foreach ($recipes['valencia'] as $meal => $mealQuantity): ?>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <?= $totalQuantity * $mealQuantity / $avgCook ?>x 
                    <?= $names[$meal] ?>
                    <small>(<?= $totalQuantity * $mealQuantity ?>)</small>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php $qMultiplier = $totalQuantity * $mealQuantity / $avgCook ?>
                        <?php $totalWeight = 0 ?>
                        <?php foreach ($recipes[$meal] as $ingredient => $quantity): ?>
                            <?php if (isset ($preparation[$ingredient])) continue ?>
                            <?php $ingredientQuantity = $qMultiplier * $quantity ?>
                            <?php $totalWeight += $weights[$ingredient] * $ingredientQuantity ?>
                            <li class="list-group-item">
                                <span class="badge bg-info rounded-pill"><?= $ingredientQuantity ?></span>
                                <?= $names[$ingredient] ?>
                            </li>
                        <?php endforeach ?>
                        <li class="list-group-item">
                            Total weight:
                            <strong><?= $totalWeight ?></strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
