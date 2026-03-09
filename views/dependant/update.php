<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Dependant $model */

$this->title = 'Badili Taarifa: ' . ucfirst($model->first_name) . " " . ucfirst($model->last_name);
$this->params['breadcrumbs'][] = ['label' => 'Mtoto', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dependant-update col-md-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
