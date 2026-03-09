<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$this->beginPage();

?>
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <!-- [Meta] -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <?= Html::csrfMetaTags() ?>
    <link rel="icon" type="image/x-icon" href="<?= Yii::getAlias('@web/images') ?>/favicon.ico">
    <title><?= Html::encode($this->title ?: 'KKKT') ?></title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?= Url::to('@web/newassets/fonts/tabler-icons.min.css') ?>">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?= Url::to('@web/newassets/fonts/feather.css') ?>">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="<?= Url::to('@web/newassets/fonts/fontawesome.css') ?>">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?= Url::to('@web/newassets/fonts/material.css') ?>">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?= Url::to('@web/newassets/css/style.css') ?>" id="main-style-link">
    <link rel="stylesheet" href="<?= Url::to('@web/newassets/css/style-preset.css') ?>">

    <?php $this->head() ?>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <?php $this->beginBody() ?>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <?= $this->render("sidebar.php"); ?>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->


    <?= $this->render("header.php"); ?>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div id="breadcrumb" style="">
                                <?= Breadcrumbs::widget([
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <?= $content ?>
            <!-- [ Main Content ] end -->

        </div>

        <!----Footer---->
        <?= $this->render("footer.php"); ?>
        <!-----End Footer ---->

        <!-- [Page Specific JS] start -->
        <script src="<?= Url::to('@web/newassets/js/plugins/apexcharts.min.js') ?>"></script>
        <script src="<?= Url::to('@web/newassets/js/pages/dashboard-default.js') ?>"></script>
        <!-- [Page Specific JS] end -->
        <!-- Required Js -->
        <script src="<?= Url::to('@web/newassets/js/plugins/popper.min.js') ?>"></script>
        <script src="<?= Url::to('@web/newassets/js/plugins/simplebar.min.js') ?>"></script>
        <script src="<?= Url::to('@web/newassets/js/plugins/bootstrap.min.js') ?>"></script>
        <script src="<?= Url::to('@web/newassets/js/fonts/custom-font.js') ?>"></script>
        <script src="<?= Url::to('@web/newassets/js/pcoded.js') ?>"></script>
        <script src="<?= Url::to('@web/newassets/js/plugins/feather.min.js') ?>"></script>




        <script>layout_change('light');</script>




        <script>change_box_container('false');</script>



        <script>layout_rtl_change('false');</script>


        <script>preset_change("preset-1");</script>


        <script>font_change("Public-Sans");</script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var sidebar = document.querySelector('.pc-sidebar');
                if (!sidebar) {
                    return;
                }

                var closeMobileSidebar = function () {
                    if (window.innerWidth > 1024) {
                        return;
                    }

                    sidebar.classList.remove('mob-sidebar-active');
                    var overlay = sidebar.querySelector('.pc-menu-overlay');
                    if (overlay) {
                        overlay.remove();
                    }
                };

                sidebar.querySelectorAll('.pc-navbar .pc-link').forEach(function (link) {
                    link.addEventListener('click', function () {
                        var parent = link.parentElement;
                        var href = link.getAttribute('href') || '';
                        if ((parent && parent.classList.contains('pc-hasmenu')) || href === '#' || href === '#!' || href === 'javascript:void(0)') {
                            return;
                        }

                        window.setTimeout(closeMobileSidebar, 120);
                    });
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeMobileSidebar();
                    }
                });
            });
        </script>


        <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage(); ?>
