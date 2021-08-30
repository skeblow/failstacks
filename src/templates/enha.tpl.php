

<?php if ($level > 1): ?>
	<a href="<?= sprintf('/%s/%s', $item->getId(), $level - 1); ?>" class="btn btn-primary"><?= enhaLevel($level - 1); ?></a>
<?php endif; ?>
<strong><?= $item->getName(); ?> <?= enhaLevel($level); ?></strong>
<?php if ($level < 20): ?>
	<a href="<?= sprintf('/%s/%s', $item->getId(), $level + 1); ?>" class="btn btn-primary"><?= enhaLevel($level + 1) ?></a>
<?php endif; ?>

<div id="chartContainer" style="height: 370px; width: 100%; margin-top: 2em"></div>

<script src="/js/canvasjs.min.js"></script>

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
            $res['progress'],
        )) ?>
	}]
});
chart.render();
}
</script>

<pre><?= print_r($res['optimal'], true); ?></pre>

<div class="card mb-4 mt-4">
	<div class="card-header">Optimal</div>
  	<div class="card-body">
  		<dl class="row mb-0">
			<dt class="col-sm-3">fs</dt>
	  		<dd class="col-sm-9"><?= $res['optimal']['fs']; ?></dd>
			<dt class="col-sm-3">total price</dt>
	  		<dd class="col-sm-9"><?= formatMoney($res['optimal']['totalPrice']); ?></dd>
		</dl>
  	</div>
</div>

<div class="card">
  	<div class="card-body">
  		<dl class="row mb-0">
			<dt class="col-sm-3">durability lost</dt>
	  		<dd class="col-sm-9"><?= $res['progress'][0]['durabilityLost']; ?></dd>
			<dt class="col-sm-3">repair item</dt>
	  		<dd class="col-sm-9"><?= $res['progress'][0]['repairItem']; ?></dd>
			<dt class="col-sm-3">repair price</dt>
	  		<dd class="col-sm-9"><?= formatMoney($res['progress'][0]['repairPrice']); ?></dd>
			<dt class="col-sm-3">enchant item</dt>
	  		<dd class="col-sm-9"><?= $res['progress'][0]['enchantItem']; ?></dd>
			<dt class="col-sm-3">enchant item price</dt>
	  		<dd class="col-sm-9"><?= formatMoney($res['progress'][0]['enchantItemPrice']); ?></dd>
			<dt class="col-sm-3">drop level price</dt>
	  		<dd class="col-sm-9"><?= formatMoney($res['progress'][0]['dropLevelPrice']); ?></dd>
		</dl>
  	</div>
</div>

<table class="table">
	<thead>
		<tr>
			<th>fs</th>
			<th>enha chance</th>
			<th>advice price</th>
			<th>total price</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($res['progress'] as $row): ?>
			<?php $isOptimal = $row['fs'] === $res['optimal']['fs']; ?>
			<?php $isNearOptimal = ! $isOptimal 
				&& floor($row['fs'] * 0.75) <= $res['optimal']['fs']
				&& ceil($row['fs'] * 1.25) >= $res['optimal']['fs']
			?>
			<tr class="<?= $isOptimal ? ' table-primary fw-bold' : '' ?><?= $isNearOptimal ? ' table-secondary' : '' ?>">
				<td><?= $row['fs']; ?></td>
				<td><?= round($row['enhaChance'], 1); ?>%</td>
				<td><?= formatMoney($row['advicePrice']); ?></td>
				<td><?= formatMoney($row['totalPrice']); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
