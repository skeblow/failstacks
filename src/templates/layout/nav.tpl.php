<?php

use App\Application\Services\ItemService;

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';

$pages = [
    [
        'name' => 'prices',
        'url' => '/prices',
        'isActive' => isUrlActive($pathInfo, '/prices'),
    ],
    [
        'name' => 'advice calculator',
        'url' => '/advice/20',
        'isActive' => isUrlActive($pathInfo, '/advice/'),
    ],
    [
        'name' => 'silver embro',
        'isActive' => isUrlActive($pathInfo, '/silver'),
        'items' => [
            '/silverCook/3' => '+3 cook'
        ],
    ],
    [
        'name' => 'manos',
        'isActive' => isUrlActive($pathInfo, '/manos'),
        'items' => [
            '/manosTool/19' => 'TET tool'
        ],
    ], 
    [
        'name' => 'horse',
        'isActive' => isUrlActive($pathInfo, '/horse/'),
        'items' => [        
            '/horseShoe/5' => 'horse shoe',
            '/horseSaddle/5' => 'horse saddle',
            '/horseStirrups/5' => 'horse stirrups',
            '/horseArmor/5' => 'horse armor',
        ],
    ],
    [
        'name' => 'boss',
        'isActive' => isUrlActive($pathInfo, '/boss'),
        'items' => [
            '/bossUrugon/19' => 'TET urugon',
            '/bossKzarka/19' => 'TET kzarka',
            '/bossDimTree/19' => 'TET dimTree',
        ],
    ],
    [
        'name' => 'accessories',
        'isActive' => isUrlActive($pathInfo, '/accessory'),
        'items' => (function () {
            $items = [];

            foreach (ItemService::YELLOW_ACCESSORIES as $id => $name) {
                $items[sprintf('/%s/1', $id)] = sprintf('PRI %s', $name);
            }

            return $items;
        })(),
    ],
    [
        'name' => 'processing stone',
        'url' => '/procStone/10',
        'isActive' => isUrlActive($pathInfo, '/procStone'),
    ],
    [
        'name' => 'gathering result',
        'url' => '/gather',
        'isActive' => isUrlActive($pathInfo, '/gather'),
    ],
    [
        'name' => 'cooking',
        'url' => '/cooking',
        'isActive' => isUrlActive($pathInfo, '/cooking'),
    ],
    [
        'name' => 'alchemy',
        'url' => '/alchemy',
        'items' => [
            '/alchemy/beast' => 'beast draght',
            '/alchemy/verdure' => 'verdure draught',
            '/alchemy/frenzy' => 'TODO frenzy draught',
        ],
        'isActive' => isUrlActive($pathInfo, '/alchemy'),
    ],
    [
        'name' => 'processing',
        'url' => '/processing',
        'isActive' => isUrlActive($pathInfo, '/processing'),
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
