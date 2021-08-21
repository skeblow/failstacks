<?php

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';

$pages = [
    [
        'name' => 'advice calculator',
        'url' => '/advice/20',
        'isActive' => isUrlActive($pathInfo, '/advice/'),
    ],
    [
        'name' => 'silver cook armor',
        'url' => '/silverCook/1',
        'isActive' => isUrlActive($pathInfo, '/silver'),
    ],
    [
        'name' => 'manos tool',
        'url' => '/manos/16',
        'isActive' => isUrlActive($pathInfo, '/manos/'),
    ], 
    [
        'name' => 'horse gear',
        'isActive' => isUrlActive($pathInfo, '/horse/'),
        'items' => [        
            'horse shoe' => '/horseShoe/1',
            'horse saddle' => '/horseSaddle/1',
            'horse stirrups' => '/horseStirrups/1',
        ],
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
    [
        'name' => 'processing stone',
        'url' => '/procStone/10',
        'isActive' => isUrlActive($pathInfo, '/procStone'),
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
                    <?php $hasDropdown = isset($page['items']); ?>
                    <li class="nav-item<?= $hasDropdown ? ' dropdown' : ''; ?>">
                        <a 
                            class="nav-link<?= $page['isActive'] ? ' active' : '' ?><?= $hasDropdown ? ' dropdown-toggle' : '' ?>" 
                            href="<?= $page['url'] ?? '#' ?>"
                            <?= $hasDropdown ? 'data-toggle="dropdown"' : '' ?>
                        ><?= $page['name']; ?></a>
                        <?php if ($hasDropdown): ?>
                            <div class="dropdown-menu">
                                <?php foreach ($page['items'] as $name => $url): ?>
                                    <a class="dropdown-item" href="<?= $url ?>"><?= $name ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
