<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\ContributionsType;
use app\models\User;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Contribution $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contribution-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="mb-3 row">
        <div class="col-md-3">
            <?=
                $form->field($model, 'contribution_type_id')
                    ->dropDownList(
                        ArrayHelper::map(ContributionsType::find()->all(), 'id', 'name', ['class' => "mt-3"])
                    );
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'reference_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'date_of_payment')->input('date', [
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="col-md-3">

            <?=
                $form->field($model, 'payment_mode')
                    ->dropDownList($paymentType, ['prompt' => 'Aina ya Malipo']);
            ?>



        </div>
      

        <div class="col-md-6">
            <?= $form->field($model, 'payment_desc')->textarea(['rows' => 1]) ?>
        </div>

    </div>
    <div class="mb-3 row">
        <div class="form-group">
            <?= Html::submitButton('Sajiri', ['class' => 'btn btn-success pull-right']) ?>
        </div>
    </div>
</div>

</div>
<?php ActiveForm::end(); ?>

</div>