<?php

/** @var array $res */
$totalQuantity = $res['quantity'];
$avgCook = $res['avg'];
?>

<div class="row mb-4">
    <div class="col-9">
        <h1 class="h2"><?= $res['quantity'] * $res['avg'] ?>x Valencia meal</h1>
    
        <ul class="list-group col-6">
            <?php $totalWeight = 0 ?>
            <?php foreach ($recipes['valencia'] as $ingredient => $quantity): ?>
                <li class="list-group-item">
                    <span class="badge bg-info rounded-pill"><?= $res['quantity'] * $quantity ?></span>
                    <?= $names[$ingredient] ?>
                </li>
                <?php $totalWeight += $weights[$ingredient] * $res['quantity'] * $quantity ?>
            <?php endforeach; ?>
            <li class="list-group-item">
                Total weight:
                <strong><?= $totalWeight ?></strong>
            </li>
        </ul>
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

<div class="row mb-4">
    <div class="col-4">
        <div class="card">
            <div class="card-header">preparation</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">An item</li>
                    <li class="list-group-item">An item</li>
                </ul>
            </div>
        </div>
    </div>

    <?php foreach ($recipes['valencia'] as $meal => $mealQuantity): ?>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <?= $totalQuantity * $mealQuantity ?>x 
                    <?= $names[$meal] ?>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php $qMultiplier = $totalQuantity * $mealQuantity / $avgCook ?>
                        <?php $totalWeight = 0 ?>
                        <?php foreach ($recipes[$meal] as $ingredient => $quantity): ?>
                            <?php $ingredientQuantity = $qMultiplier * $quantity ?>
                            <?php $totalWeight += $weights[$ingredient] * $ingredientQuantity ?>
                            <li class="list-group-item">
                                <span class="badge bg-info rounded-pill"><?= $ingredientQuantity ?></span>
                                <?= $names[$ingredient] ?>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item">
                            Total weight:
                            <strong><?= $totalWeight ?></strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
