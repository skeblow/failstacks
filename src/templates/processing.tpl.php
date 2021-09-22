<h1 class="h2">Processing calculator</h1>

<div class="row">
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <form method="get">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Cereal</span>
                        <input type="text" class="form-control" name="cereal" value="<?= $res['input']['cereal'] ?>">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Flour</span>
                        <input type="text" class="form-control" name="flour" value="<?= $res['input']['flour'] ?>">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Water</span>
                        <input type="text" class="form-control" name="water" value="<?= $res['input']['water'] ?>">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Weght limit</span>
                        <input type="text" class="form-control" name="weight" value="<?= $res['weightLimit'] ?>">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary">
                            Calculate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <table class="table">
            <tbody>

                <?php foreach ($res['result'] as $ingredient => $quantity): ?>
                    <tr>
                        <th><?= $ingredient ?></th>
                        <td><?= $quantity ?>x</td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <th>Weight</th>
                    <td><?= $res['weight'] ?></td>
                </tr>
                <tr>
                    <th>Total cost</th>
                    <td><?= formatMoney($res['totalCost']) ?></td>
                </tr>
                <tr>
                    <th>Total price</th>
                    <td><?= formatMoney($res['totalPrice']) ?></td>
                </tr>
                <tr>
                    <th>Total profit</th>
                    <td><?= formatMoney($res['totalProfit']) ?></td>
                </tr>
                <tr>
                    <th>Processing time</th>
                    <td><?= $res['processingTime'] ?> <small>(<?= round($res['processingTime'] / 60, 2) ?>h)</small></td>
                </tr>
                <tr>
                    <th>Profit per h</th>
                    <td><?= formatMoney($res['profitPerH']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
