<?php

use app\models\Center;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $model */
/** @var yii\widgets\ActiveForm $form */

$identity = Yii::$app->user->identity;
$centerQuery = Center::find()->orderBy('name');
if ($identity !== null && ($identity->role ?? null) !== 'admin' && !empty($identity->center_id)) {
    $centerQuery->andWhere(['id' => (int) $identity->center_id]);
}
$centerOptions = ArrayHelper::map($centerQuery->all(), 'id', 'name');
?>

<div class="user-search filter-toolbar">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'row g-3 align-items-end',
        ],
    ]); ?>

    <div class="col-xl-3 col-md-6">
        <?= $form->field($model, 'first_name')->textInput([
            'maxlength' => true,
            'placeholder' => 'Jina la kwanza',
        ]) ?>
    </div>
    <div class="col-xl-3 col-md-6">
        <?= $form->field($model, 'last_name')->textInput([
            'maxlength' => true,
            'placeholder' => 'Jina la mwisho',
        ]) ?>
    </div>
    <div class="col-xl-2 col-md-6">
        <?= $form->field($model, 'designation_designation')->textInput([
            'maxlength' => true,
            'placeholder' => 'Bahasha',
        ])->label('Bahasha') ?>
    </div>
    <div class="col-xl-2 col-md-6">
        <?= $form->field($model, 'center_id')->dropDownList($centerOptions, [
            'prompt' => 'Sharika zote',
        ]) ?>
    </div>
    <div class="col-xl-2 col-md-6">
        <?= $form->field($model, 'status')->dropDownList(User::memberStatusOptions(), [
            'prompt' => 'Hali zote',
        ]) ?>
    </div>
    <div class="col-xl-3 col-md-6">
        <?= $form->field($model, 'created_at')->input('date') ?>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="d-grid d-md-flex gap-2">
            <?= Html::submitButton('Tafuta', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Weka Upya', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
