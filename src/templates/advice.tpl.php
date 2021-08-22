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

<pre><?php print_r($allAdvices); ?></pre>

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