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
    <div class="col-md-9 order-2 order-lg-1">
        <h1 class="h2">
            <?= $totalQuantity * $avgCook ?>x <?= $names[$main] ?>
            <span class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="<?= $printRecipe($recipes[$main]) ?>">i</span>
        </h1>

        <div class="card col-md-6">
            <div class="card-header">Grab</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php $totalWeight = 0 ?>
                    <?php foreach ($preparation as $prepared => $preparedQuantity): ?>
                        <?php if (isset($recipes[$prepared])) continue ?>
                        <?php $totalWeight += $weights[$prepared] * $preparedQuantity ?>
                        <li class="list-group-item js-complete">
                            <i class="bi bi-check d-none"></i>
                            <span class="badge bg-primary rounded-pill"><?= $preparedQuantity ?></span>
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
    <div class="col-md-3 order-1 order-lg-2 mb-4">
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

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header js-complete">
                    <i class="bi bi-check d-none"></i>
                    <?= $preparedQuantity / $avgCook ?>x 
                    <strong>(<?= $preparedQuantity ?>)</strong>
                    <?= $names[$prepared] ?>
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
                            <li class="list-group-item js-complete">
                                <i class="bi bi-check d-none"></i>
                                <span class="badge bg-primary rounded-pill"><?= $ingredientQuantity ?></span>
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
    <?php foreach ($recipes[$main] as $meal => $mealQuantity): ?>
        <?php if (! isset($recipes[$meal])) continue ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header js-complete">
                    <i class="bi bi-check d-none"></i>
                    <?= $totalQuantity * $mealQuantity / $avgCook ?>x 
                    <strong>(<?= $totalQuantity * $mealQuantity ?>)</strong>
                    <?= $names[$meal] ?>
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
                            <li class="list-group-item js-complete">
                                <i class="bi bi-check d-none"></i>
                                <span class="badge bg-primary rounded-pill"><?= $ingredientQuantity ?></span>
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
<script>
    document.querySelectorAll('.js-complete').forEach(el => {
        el.addEventListener('click', () => {
            const icon = el.querySelector('i.bi');
            icon.classList.toggle('d-inline-block');
            icon.classList.toggle('d-none');
        });
    });
</script>
