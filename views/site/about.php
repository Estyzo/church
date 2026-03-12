<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Kuhusu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Huu ni ukurasa wa kuhusu. Unaweza kubadili faili ifuatayo ili kurekebisha maudhui yake:
    </p>

    <code><?= __FILE__ ?></code>
</div>
