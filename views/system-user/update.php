<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models/SystemUser $model */

$this->title = 'Update System User: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'System Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-user-update">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
