<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\District $model */

$this->title = 'Sajili Wilaya';
$this->params['breadcrumbs'][] = ['label' => 'Wilaya', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
