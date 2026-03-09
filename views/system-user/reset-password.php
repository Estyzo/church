<?php

use app\models\SystemUser;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ResetPasswordForm $model */
/** @var SystemUser $user */

$this->title = 'Reset Password: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'System Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-user-reset-password">
    <h4><?= Html::encode($this->title) ?></h4>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'new_password')->passwordInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'confirm_password')->passwordInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Reset Password', ['class' => 'btn btn-warning']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
