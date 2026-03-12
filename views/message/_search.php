<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MessageSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="messages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'subject') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'center_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Tafuta', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Weka Upya', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
