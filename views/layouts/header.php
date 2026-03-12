<?php

use yii\helpers\Html;

$identity = Yii::$app->user->identity;
$displayName = 'Mgeni';
$displayRole = '';
$roleLabels = \app\models\SystemUser::roleOptions();
if ($identity !== null) {
    if (!empty($identity->username)) {
        $displayName = (string)$identity->username;
    } elseif (!empty($identity->email)) {
        $displayName = (string)$identity->email;
    }
    if (!empty($identity->role)) {
        $displayRole = (string)$identity->role;
    }
}
?>
<!--Header-part-->

<header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>

            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-mail"></i>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Ujumbe</h5>
                            <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-x text-danger"></i></a>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
                            style="max-height: calc(100vh - 215px)">
                            <div class="list-group list-group-flush w-100">
                                <a class="list-group-item list-group-item-action">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <?php echo Html::img('@web/images/logo_kkkt.jpeg', ['alt' => 'KKKT', 'class' => 'user-avtar']); ?>
                                        </div>
                                        <div class="flex-grow-1 ms-1">
                                            <span class="float-end text-muted">3:00 Asubuhi</span>
                                            <p class="text-body mb-1">Leo ni siku ya kuzaliwa ya <b>Cristina Danny</b>.</p>
                                            <span class="text-muted">Dakika 2 zilizopita</span>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="text-center py-2">
                            <a href="#!" class="link-primary">Tazama zote</a>
                        </div>
                    </div>
                </li>
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <?= Html::img('@web/images/logo_kkkt.jpeg', ['alt' => 'KKKT', 'class' => 'user-avtar']); ?>
<span>
    <?= Html::encode($displayName) ?>
</span>

                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex mb-1">
                                <div class="flex-shrink-0">
                                    <?= Html::img('@web/images/logo_kkkt.jpeg', ['alt' => 'KKKT', 'class' => 'user-avtar wid-35']); ?>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">
<span>
    <?= Html::encode($displayName) ?>
</span>

                                    <span><?= Html::encode($displayRole !== '' ? ($roleLabels[$displayRole] ?? $displayRole) : 'Mtumiaji') ?></span>
                                </div>
                                        
                                    <?= Html::beginForm(['/site/logout'], 'post', ['id' => 'logout-form-header']) ?>
                                    <?= Html::a('<i class="ti ti-power text-danger"></i>', '#', [
                                    'onclick' => "document.getElementById('logout-form-header').submit(); return false;",
                                    'class' => 'pc-head-link bg-transparent',
                                    ]) ?>
                                    <?= Html::endForm() ?>
                            </div>
                        </div>
                        <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="drp-t1" data-bs-toggle="tab"
                                    data-bs-target="#drp-tab-1" type="button" role="tab" aria-controls="drp-tab-1"
                                    aria-selected="true"><i class="ti ti-user"></i> Taarifa Binafsi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="drp-t2" data-bs-toggle="tab" data-bs-target="#drp-tab-2"
                                    type="button" role="tab" aria-controls="drp-tab-2" aria-selected="false"><i
                                        class="ti ti-settings"></i> Mipangilio</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="mysrpTabContent">
                            <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                aria-labelledby="drp-t1" tabindex="0">

                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-user"></i>
                                    <span>Taarifa Binafsi</span>
                                </a>
                                <?= Html::a(
                                    '<i class="ti ti-key"></i><span>Badili Nenosiri</span>',
                                    ['/system-user/change-password'],
                                    ['class' => 'dropdown-item']
                                ) ?>

                            </div>
                            <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2"
                                tabindex="0">
                                <a href="#!" class="dropdown-item">
                                    <i class="ti ti-help"></i>
                                    <span>Msaada</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
