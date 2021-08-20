

<a href="<?= sprintf('/%s/%s', $item->getId(), $level - 1); ?>" class="btn btn-primary"><?= enhaLevel($level - 1); ?></a>
<strong><?= $item->getName(); ?> <?= enhaLevel($level); ?></strong>
<a href="<?= sprintf('/%s/%s', $item->getId(), $level + 1); ?>" class="btn btn-primary"><?= enhaLevel($level + 1) ?></a>

<div id="chartContainer" style="height: 370px; width: 100%; margin-top: 2em"></div>

<script src="/js/canvasjs.min.js"></script>

<pre><?php print_r($res); ?></pre>

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
