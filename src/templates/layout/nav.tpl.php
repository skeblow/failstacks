<?php

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';

$pages = [
    [
        'name' => 'advice calculator',
        'url' => '/advice/20',
        'isActive' => isUrlActive($pathInfo, '/advice/'),
    ],
    [
        'name' => 'silver embro',
        'url' => '/silver/1',
        'isActive' => isUrlActive($pathInfo, '/silver'),
    ],
    [
        'name' => 'manos tool',
        'url' => '/manos/16',
        'isActive' => isUrlActive($pathInfo, '/manos/'),
    ], 
    [
        'name' => 'horse gear',
        'url' => '/horse/8',
        'isActive' => isUrlActive($pathInfo, '/horse/'),
    ],
    [
        'name' => 'gathering result',
        'url' => '/gather',
        'isActive' => isUrlActive($pathInfo, '/gather'),
    ],
    [
        'name' => 'prices',
        'url' => '/prices',
        'isActive' => isUrlActive($pathInfo, '/prices'),
    ],
];

function isUrlActive($pathInfo, $url): bool
{
    return str_starts_with($pathInfo, $url);
}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">FS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach($pages as $page): ?>
                    <li class="nav-item">
                    <a class="nav-link<?= $page['isActive'] ? ' active' : '' ?>" href="<?= $page['url'] ?>"><?= $page['name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
