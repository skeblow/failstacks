<?php

/** @var int $totalQuantity */
/** @var float $avgCook */

$printRecipe = function (array $recipe) use ($names): string {
    $html = '<ul class=\'mb-0\'>';

    foreach ($recipe as $ingredient => $quantity) {
        $html .= sprintf('<li>%sx %s</li>', $quantity, $names[$ingredient]);
    }

    $html .= '</ul>';

    return $html;
};

?>

<div class="row mb-4">
    <div class="col-9">
        <h1 class="h2">
            <?= $totalQuantity * $avgCook ?>x Valencia meal
            <span class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="<?= $printRecipe($recipes['valencia']) ?>">i</span>
        </h1>

        

        <div class="card col-6">
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

<h2 class="h4 border-bottom mb-3">Preparation <small class="text-muted">(~15 min)</small></h2>

<div class="row">
    <?php foreach ($preparation as $prepared => $preparedQuantity): ?>
        <?php if (! isset($recipes[$prepared])) continue ?>

        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <?= $preparedQuantity / $avgCook ?>x 
                    <?= $names[$prepared] ?>
                    <small>(<?= $preparedQuantity ?>)</small>
                    <span class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="<?= $printRecipe($recipes[$prepared]) ?>">i</span>
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

<h2 class="h4 border-bottom mb-3">Main <small class="text-muted">(~45 min)</small></h2>

<div class="row">
    <?php foreach ($recipes['valencia'] as $meal => $mealQuantity): ?>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <?= $totalQuantity * $mealQuantity / $avgCook ?>x 
                    <?= $names[$meal] ?>
                    <small>(<?= $totalQuantity * $mealQuantity ?>)</small>
                    <span class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="<?= $printRecipe($recipes[$meal]) ?>">i</span>
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

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>