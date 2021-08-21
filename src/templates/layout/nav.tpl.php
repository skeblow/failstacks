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
        'isActive' => isUrlActive($pathInfo, '/silver'),
        'items' => [
            '/silverCook/1' => '+1 cook'
        ],
    ],
    [
        'name' => 'manos',
        'isActive' => isUrlActive($pathInfo, '/manos'),
        'items' => [
            '/manosTool/16' => 'tool'
        ],
    ], 
    [
        'name' => 'horse',
        'isActive' => isUrlActive($pathInfo, '/horse/'),
        'items' => [        
            '/horseShoe/1' => 'horse shoe',
            '/horseSaddle/1' => 'horse saddle',
            '/horseStirrups/1' => 'horse stirrups',
            '/horseArmor/1' => 'horse armor',
        ],
    ],
    [
        'name' => 'boss',
        'isActive' => isUrlActive($pathInfo, '/boss'),
        'items' => [
            '/bossUrugon/16' => 'urugon +16',
            '/bossKzarka/16' => 'kzarka +16',
            '/bossDimTree/20' => 'dimTree +20',
        ],
    ],
    [
        'name' => 'processing stone',
        'url' => '/procStone/10',
        'isActive' => isUrlActive($pathInfo, '/procStone'),
    ],
    [
        'name' => 'prices',
        'url' => '/prices',
        'isActive' => isUrlActive($pathInfo, '/prices'),
    ],
    [
        'name' => 'gathering result',
        'url' => '/gather',
        'isActive' => isUrlActive($pathInfo, '/gather'),
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
                            <?= $hasDropdown ? 'data-bs-toggle="dropdown"' : '' ?>
                        ><?= $page['name']; ?></a>
                        <?php if ($hasDropdown): ?>
                            <div class="dropdown-menu">
                                <?php foreach ($page['items'] as $url => $name): ?>
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
