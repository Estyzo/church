<?php

use app\models\District;
use app\models\Region;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Center;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

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
            <?= $form->field($model, 'gender')->dropDownList(
                ['Me' => 'Me', 'Ke' => 'Ke'],
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'denomination')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'dob')->input('date', [
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-md-4">
            <?=
                $form->field($model, 'dob_region')
                    ->dropDownList(
                        ArrayHelper::map(Region::find()->all(), 'id', 'name', ['class' => "mt-3"])
                    );
            ?>
        </div>
        <div class="col-md-4">
            <?=
                $form->field($model, 'dob_district')
                    ->dropDownList(
                        ArrayHelper::map(District::find()->all(), 'id', 'name', ['class' => "mt-3"])
                    );
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'is_baptized')->dropDownList(
                $trueFalse,
                ['prompt' => 'Amebatizwa?']
            ) ?>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-md-4">
            <?= $form->field($model, 'marital_status')->dropDownList(
                $maritalStatus,
                ['prompt' => 'Hali ya Ndoa']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'marriage_type')->dropDownList(
                $mariageType,
                ['prompt' => 'Aina ya Ndoa']
            ) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'spouse_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div class="mb-3 row">


        <div class="col-md-4">

            <?= $form->field($model, 'confirmation')->dropDownList(
                $trueFalse,
                ['prompt' => 'Amepata Kipaimara?']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'is_join_table')->dropDownList(
                $trueFalse,
                ['prompt' => 'Unashiriki Jumuiya?']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'street_join')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div class="mb-3 row">
        <div class="col-md-4">
            <?= $form->field($model, 'occupation')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'designation')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'occupation_place')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="mb-3 row">

        <div class="col-md-4">

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">

            <?= $form->field($model, 'next_of_kin_phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-md-4">
            <?= $form->field($model, 'church_elder')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'home_congregation')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <?=
                $form->field($model, 'center_id')
                    ->dropDownList(
                        ArrayHelper::map(Center::find()->all(), 'id', 'name', ['class' => "mt-3"])
                    );
            ?>
        </div>

        <?php
        if (!$model->isNewRecord) {
            ?>
            <div class="col-md-4">
                <?= $form->field($model, 'status')->dropDownList(
                    [
                        1 => 'Hai',
                        2 => 'Si Hai',
                        3 => 'Amehama',
                        4 => 'Amefariki'
                    ],
                ) ?>
            </div>
            <?php
        }
        ?>

    </div>




    <div class="row">
        <div class="form-group">
            <?= Html::submitButton('Sajiri', ['class' => 'btn btn-success pull-right']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
