<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models/SystemUser $model */

$this->title = 'Badili Mtumiaji wa Mfumo: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Watumiaji wa Mfumo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-user-update">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
