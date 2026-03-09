<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Kuingia';
?>

<div class="auth-shell container py-4 py-md-5">
    <div class="auth-card card border-0 shadow-sm mx-auto">
        <div class="card-body p-4 p-md-5">
            <h1 class="h4 text-center mb-2">Karibu KKKT</h1>
            <p class="text-center text-muted mb-4">Ingia kuendelea kwenye mfumo</p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                ],
            ]); ?>

            <?= $form->field($model, 'username')
                ->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Barua pepe au jina la mtumiaji',
                ])
                ->label('Barua Pepe/Jina') ?>

            <?= $form->field($model, 'password')
                ->passwordInput([
                    'placeholder' => 'Nenosiri',
                ])
                ->label('Nenosiri') ?>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <?= $form->field($model, 'rememberMe', [
                    'options' => ['class' => 'form-check m-0'],
                    'template' => "{input} {label}\n{error}",
                    'labelOptions' => ['class' => 'form-check-label'],
                ])->checkbox(['class' => 'form-check-input'], false)->label('Kumbuka') ?>

                <a class="small text-decoration-none" href="#">Je, umesahau nenosiri?</a>
            </div>

            <?= Html::submitButton('Ingia', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
