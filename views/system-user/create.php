<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models/SystemUser $model */

$this->title = 'Create System User';
$this->params['breadcrumbs'][] = ['label' => 'System Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-user-create">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
