<?php

use app\models\Center;
use app\models\SystemUser;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models/SystemUser $model */
?>

<div class="system-user-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'password')->passwordInput([
                'maxlength' => true,
                'placeholder' => $model->isNewRecord ? 'Set password' : 'Leave empty to keep current password',
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'role')->dropDownList(SystemUser::roleOptions(), ['prompt' => 'Select role']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'center_id')->dropDownList(
                ArrayHelper::map(Center::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
                ['prompt' => 'Select center']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(SystemUser::statusOptions()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create User' : 'Update User', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
