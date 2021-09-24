<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Failstacks</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/style.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php require __DIR__ . '/nav.tpl.php'; ?>

    <div class="container">
        <?php require($template); ?>
    </div>
</body>
</html>
