<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Dependant $model */
/** @var yii\widgets\ActiveForm $form */

$today = date('Y-m-d');
?>

<div class="dependant-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3 row">
        <div class="col-md-4">

            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-md-4">
            <?= $form->field($model, 'dob')->input('date', [
                'class' => 'form-control',
                'value' => $model->dob ?: $today,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'dependant_type')->dropDownList(
                [
                    'MTOTO' => 'MTOTO',
                    'BABA' => 'BABA',
                    'WAJIKUU' => 'WAJIKUU',
                ],
                ['prompt' => 'Aina ya Uhusiano?']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'is_budtized')->dropDownList(
                [
                    0 => 'HAPANA',
                    1 => 'NDIO'
                ],
                ['prompt' => 'Amebatizwa?']
            ) ?>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-md-4">
            <?= $form->field($model, 'occupation')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="form-group">
            <?= Html::submitButton('Sajili', ['class' => 'btn btn-success pull-right']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
