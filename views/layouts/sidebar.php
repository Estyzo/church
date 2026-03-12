<?php

use yii\helpers\Html;

$currentRoute = Yii::$app->controller ? Yii::$app->controller->getRoute() : '';

$isActive = static function (string $routePattern) use ($currentRoute): bool {
    if (substr($routePattern, -2) === '/*') {
        $prefix = substr($routePattern, 0, -1);
        return strpos($currentRoute, $prefix) === 0;
    }

    return $currentRoute === $routePattern;
};

$linkOptions = static function (string $routePattern, array $options = []) use ($isActive): array {
    $active = $isActive($routePattern);
    $defaults = [
        'class' => 'pc-link' . ($active ? ' active' : ''),
    ];

    if ($active) {
        $defaults['aria-current'] = 'page';
    }

    return array_merge($defaults, $options);
};

$itemClass = static function (string $routePattern, string $baseClass = 'pc-item') use ($isActive): string {
    return $baseClass . ($isActive($routePattern) ? ' active' : '');
};

$isAreaMenuActive = $isActive('district/*') || $isActive('region/*');
?>

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header" style="padding-left:32%;">
            <?= Html::a(
                Html::img('@web/images/logo_kkkt.jpeg', ['class' => 'img-fluid', 'style' => 'height:50px']),
                ['site/index'],
                ['class' => 'b-brand text-primary']
            ) ?>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="<?= Html::encode($itemClass('site/index')) ?>">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-dashboard"></i></span> <span class="pc-mtext">Dashibodi</span>',
                        ['site/index'],
                        $linkOptions('site/index')
                    ) ?>
                </li>

                <li class="<?= Html::encode($itemClass('user/*')) ?>">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-user"></i></span> <span class="pc-mtext">Washarika</span>',
                        ['user/index'],
                        $linkOptions('user/*')
                    ) ?>
                </li>

                <li class="<?= Html::encode($itemClass('contribution/*')) ?>">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-report-money"></i></span> <span class="pc-mtext">Matoleo</span>',
                        ['contribution/index'],
                        $linkOptions('contribution/*')
                    ) ?>
                </li>

                <li class="<?= Html::encode($itemClass('dependant/*')) ?>">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-growth"></i></span> <span class="pc-mtext">Watoto</span>',
                        ['dependant/index'],
                        $linkOptions('dependant/*')
                    ) ?>
                </li>

                <li class="<?= Html::encode($itemClass('center/*')) ?>">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-building-warehouse"></i></span> <span class="pc-mtext">Sharika</span>',
                        ['center/index'],
                        $linkOptions('center/*')
                    ) ?>
                </li>

                <li class="<?= Html::encode($itemClass('message/*')) ?>">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-speakerphone"></i></span> <span class="pc-mtext">Ujumbe</span>',
                        ['message/index'],
                        $linkOptions('message/*')
                    ) ?>
                </li>

                <li class="<?= Html::encode($itemClass('contributions-type/*')) ?>">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-currency-dollar"></i></span> <span class="pc-mtext">Aina za Matoleo</span>',
                        ['contributions-type/index'],
                        $linkOptions('contributions-type/*')
                    ) ?>
                </li>

                <li class="pc-item">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-user"></i></span> <span class="pc-mtext">Waliofariki</span>',
                        '#',
                        ['class' => 'pc-link disabled', 'aria-disabled' => 'true', 'tabindex' => '-1']
                    ) ?>
                </li>

                <li class="pc-item">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-user"></i></span> <span class="pc-mtext">Waliohama</span>',
                        '#',
                        ['class' => 'pc-link disabled', 'aria-disabled' => 'true', 'tabindex' => '-1']
                    ) ?>
                </li>

                <li class="pc-item pc-hasmenu<?= $isAreaMenuActive ? ' pc-trigger active' : '' ?>">
                    <a href="#!" class="pc-link<?= $isAreaMenuActive ? ' active' : '' ?>">
                        <span class="pc-micon"><i class="ti ti-map"></i></span>
                        <span class="pc-mtext">Maeneo</span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="<?= Html::encode($itemClass('district/*')) ?>">
                            <?= Html::a(
                                '<span class="pc-micon"><i class="ti ti-letter-w"></i></span> <span class="pc-mtext">Wilaya</span>',
                                ['district/index'],
                                $linkOptions('district/*')
                            ) ?>
                        </li>
                        <li class="<?= Html::encode($itemClass('region/*')) ?>">
                            <?= Html::a(
                                '<span class="pc-micon"><i class="ti ti-letter-m"></i></span> <span class="pc-mtext">Mikoa</span>',
                                ['region/index'],
                                $linkOptions('region/*')
                            ) ?>
                        </li>
                    </ul>
                </li>

                <li class="<?= Html::encode($itemClass('site/report')) ?>">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-list"></i></span> <span class="pc-mtext">Ripoti</span>',
                        ['site/report'],
                        $linkOptions('site/report')
                    ) ?>
                </li>

                <?php if (!Yii::$app->user->isGuest && isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role === 'admin'): ?>
                <li class="<?= Html::encode($itemClass('system-user/*')) ?>">
                    <?= Html::a(
                        '<span class="pc-micon"><i class="ti ti-shield-lock"></i></span> <span class="pc-mtext">Watumiaji wa Mfumo</span>',
                        ['system-user/index'],
                        $linkOptions('system-user/*')
                    ) ?>
                </li>
                <?php endif; ?>

                <hr class="sidebar-divider">
                <li class="pc-item">
                    <?= Html::beginForm(['/site/logout'], 'post', ['id' => 'logout-form-sidebar']) ?>
                    <?= Html::a('<span class="pc-micon"><i class="ti ti-logout"></i></span> <span class="pc-mtext">Kutoka</span>', '#', [
                        'onclick' => "document.getElementById('logout-form-sidebar').submit(); return false;",
                        'class' => 'pc-link',
                    ]) ?>
                    <?= Html::endForm() ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
