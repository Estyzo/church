<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ChangePasswordForm $model */

$this->title = 'Badili Nenosiri';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-user-change-password">
    <h4><?= Html::encode($this->title) ?></h4>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'current_password')->passwordInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'new_password')->passwordInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'confirm_password')->passwordInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Badili Nenosiri', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
