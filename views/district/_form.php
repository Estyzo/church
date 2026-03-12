<?php

use app\models\Region;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\District $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="district-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?=
            $form->field($model, 'region_id')
                ->dropDownList(
                    ArrayHelper::map(Region::find()->all(), 'id', 'name', ['class' => "mt-3"])
                );
        ?>

        <div class="form-group">
            <?= Html::submitButton('Sajili', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
