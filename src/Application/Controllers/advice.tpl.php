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

<pre><?php print_r($res); ?></pre>


<script>
    let fs = document.getElementById('fs');
    fs.addEventListener('change', () => {
        window.location.href = '/advice/' + fs.value;
    });
</script>
