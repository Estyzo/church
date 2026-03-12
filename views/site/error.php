<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Hitilafu hapo juu imetokea wakati seva ya tovuti ilipokuwa ikishughulikia ombi lako.
    </p>
    <p>
        Tafadhali wasiliana nasi ikiwa unaamini hii ni hitilafu ya seva.
    </p>

</div>
