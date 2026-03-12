<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DependantSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="dependant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'dependant_type') ?>

    <?php // echo $form->field($model, 'is_budtized') ?>

    <?php // echo $form->field($model, 'occupation') ?>

    <div class="form-group">
        <?= Html::submitButton('Tafuta', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Weka Upya', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
