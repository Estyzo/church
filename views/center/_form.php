<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\District;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Center $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="center-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        <?=
            $form->field($model, 'district_id')
                ->dropDownList(
                    ArrayHelper::map(District::find()->all(), 'id', 'name', ['class' => "mt-3"])
                );
        ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Sajili', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
