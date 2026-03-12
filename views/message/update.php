<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Messages $model */

$this->title = 'Badili Ujumbe: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ujumbe', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Badili';
?>
<div class="messages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
