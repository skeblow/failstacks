<h1 class="h2">Advice of valks calculator</h1>

<a href="/advice/<?= $fs - 5; ?>" class="btn btn-primary">-5</a>
<a href="/advice/<?= $fs - 1; ?>" class="btn btn-primary">-1</a>

<input
        type="number"
        value="<?= $fs; ?>"
        min="1"
        max="200"
        id="fs"
        class="form-control"
        style="display: inline-block; width: 5em;"
>

<a href="/advice/<?= $fs + 1; ?>" class="btn btn-primary">+1</a>
<a href="/advice/<?= $fs + 5; ?>" class="btn btn-primary">+5</a>

<div id="chartContainer" style="height: 370px; width: 100%; margin-top: 2em"></div>

<script src="/js/canvasjs.min.js"></script>

<div class="card mb-4 mt-4 col-6">
	<div class="card-header">Result</div>
  	<div class="card-body">
        <table class="table">
            <tr>
                <th>fs</th>
                <td><?= $res['fs'] ?></td>
            </tr>
            <tr>
                <th>total price</th>
                <td><?= formatMoney($res['totalPrice']) ?></td>
            </tr>
            <tr>
                <th>used bs</th>
                <td><?= $res['used']['bs'] ?></td>
            </tr>
            <tr>
                <th>used cbs</th>
                <td><?= $res['used']['concentratedBs'] ?? 0 ?></td>
            </tr>
            <tr>
                <th>used rebla <small>(repair)</small></th>
                <td><?= $res['used'][14] ?? 0 ?></td>
            </tr>
            <tr>
                <th>used grunil <small>(repair)</small></th>
                <td><?= ($res['used'][16] ?? 0) + ($res['used'][17] ?? 0) + ($res['used'][18] ?? 0) + ($res['used'][19] ?? 0) ?></td>
            </tr>
            <tr>
                <th>used PRI grunil</th>
                <td><?= $res['used'][16] ?? 0 ?></td>
            </tr>
            <tr>
                <th>used DUO grunil</th>
                <td><?= $res['used'][17] ?? 0 ?></td>
            </tr>
            <tr>
                <th>used TRI grunil</th>
                <td><?= $res['used'][18] ?? 0 ?></td>
            </tr>
            <tr>
                <th>used TET grunil</th>
                <td><?= $res['used'][19] ?? 0 ?></td>
            </tr>
        </table>
  	</div>
</div>

<h2 class="h5">Progress:</h2>

<div class="row">
    <?php foreach($res['progress'] as $click): ?>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <strong><?= $click['fs'] ?></strong> -> <strong><?= $click['fs'] + $click['fsGain'] ?></strong> fs
                        </div>
                        <div class="col text-end"><?= formatMoney($click['totalPrice']) ?></div>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-6">clicked item</dt>
                        <dd class="col-sm-6"><?= enhaLevel($click['clickedItemLevel']) ?> <?= $click['clickedItem'] ?></dd>
                        <dt class="col-sm-6">drop level price</dt>
                        <dd class="col-sm-6"><?= formatMoney($click['clickedItemLevelDropPrice']) ?></dd>
                        <dt class="col-sm-6">increase level price</dt>
                        <dd class="col-sm-6"><?= formatMoney($click['clickedItemLevelIncreasePrice']) ?></dd>
                        <dt class="col-sm-6">durability lost</dt>
                        <dd class="col-sm-6"><?= $click['clickedItemDuraLost'] ?> <small>repair</small> <?= formatMoney($click['repairPrice']) ?></dd>
                        <dt class="col-sm-6">enha chance</dt>
                        <dd class="col-sm-6"><?= round($click['enhaChance'], 2) ?>%</dd>
                        <dt class="col-sm-6">enchanted with</dt>
                        <dd class="col-sm-6"><?= $click['enhaItem'] ?> <small>for</small> <?= formatMoney($click['enhaItemPrice']) ?></dd>
                        <dt class="col-sm-6">failed stack price</dt>
                        <dd class="col-sm-6"><?= formatMoney($click['failPrice']) ?></dd>
                        <dt class="col-sm-6">click price</dt>
                        <dd class="col-sm-6"><?= formatMoney($click['clickPrice']) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<pre><?php // print_r($res); ?></pre>

<script>
    let fs = document.getElementById('fs');
    fs.addEventListener('change', () => {
        window.location.href = '/advice/' + fs.value;
    });
</script>

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"

	axisY:{
		includeZero: true
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: <?= json_encode(array_map(
            static fn (array $row): array => ['x' => $row['fs'], 'y' => $row['totalPrice']],
            $allAdvices,
        )) ?>
	}]
});
chart.render();
 
}
</script>