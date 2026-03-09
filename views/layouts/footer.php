<?php
use yii\helpers\Html;
?>
<!-- [ Main Content ] end -->
<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col-sm my-1">
                <p class="m-0">
                    <?= date('Y'); ?> &copy; KKKT MTWARA.
                </p>
            </div>
            <div class="col-auto my-1">
                <ul class="list-inline footer-link mb-0">
                    <li class="list-inline-item">
                        <?= Html::a('Mwanzo', ['site/index']) ?>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>