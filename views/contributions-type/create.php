<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ContributionsType $model */

$this->title = 'Sajili Aina ya Matoleo';
$this->params['breadcrumbs'][] = ['label' => 'Aina za Matoleo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contributions-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
