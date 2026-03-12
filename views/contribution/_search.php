<?php

use app\models\Contribution;
use app\models\ContributionsType;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ContributionSearch $model */
/** @var yii\widgets\ActiveForm $form */

$memberOptions = ArrayHelper::map(
    User::find()->orderBy([
        'first_name' => SORT_ASC,
        'middle_name' => SORT_ASC,
        'last_name' => SORT_ASC,
    ])->all(),
    'id',
    static function (User $member): string {
        $fullName = trim(implode(' ', array_filter([
            $member->first_name,
            $member->middle_name,
            $member->last_name,
        ])));

        return $fullName !== '' ? $fullName : ('Msharika #' . $member->id);
    }
);
$typeOptions = ArrayHelper::map(ContributionsType::find()->orderBy('name')->all(), 'id', 'name');
?>

<div class="contribution-search filter-toolbar">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'row g-3 align-items-end',
        ],
    ]); ?>

    <div class="col-xl-3 col-md-6">
        <?= $form->field($model, 'user_id')->dropDownList($memberOptions, [
            'prompt' => 'Washarika wote',
        ])->label('Msharika') ?>
    </div>
    <div class="col-xl-3 col-md-6">
        <?= $form->field($model, 'contribution_type_id')->dropDownList($typeOptions, [
            'prompt' => 'Aina zote za matoleo',
        ])->label('Aina ya Matoleo') ?>
    </div>
    <div class="col-xl-2 col-md-6">
        <?= $form->field($model, 'payment_mode')->dropDownList(Contribution::paymentModeOptions(), [
            'prompt' => 'Njia zote',
        ])->label('Njia ya Malipo') ?>
    </div>
    <div class="col-xl-2 col-md-6">
        <?= $form->field($model, 'date_of_payment')->input('date')->label('Tarehe ya Malipo') ?>
    </div>
    <div class="col-xl-2 col-md-6">
        <?= $form->field($model, 'reference_no')->textInput([
            'maxlength' => true,
            'placeholder' => 'Namba ya rejea',
        ])->label('Rejea') ?>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="d-grid d-md-flex gap-2">
            <?= Html::submitButton('Tafuta', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Weka Upya', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
