<?php

use app\models\Center;
use app\models\District;
use app\models\Region;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$today = date('Y-m-d');
$isEditing = !$model->isNewRecord;
$genderOptions = $gender;
if (!empty($model->gender) && !isset($genderOptions[$model->gender])) {
    $genderOptions = [$model->gender => User::genderLabel($model->gender)] + $genderOptions;
}
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card ui-section-card border-0">
        <div class="card-body">
            <div class="ui-section-eyebrow">Hatua ya 1</div>
            <h2 class="ui-section-title">Taarifa za Msingi</h2>
            <p class="ui-section-copy">Jaza majina, jinsia, dhehebu, na taarifa za kuzaliwa za msharika kabla ya kuendelea na sehemu nyingine.</p>

            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'gender')->dropDownList($genderOptions) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'denomination')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'dob')->input('date', [
                        'class' => 'form-control',
                        'value' => $model->dob ?: $today,
                    ]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'dob_region')->dropDownList(
                        ArrayHelper::map(Region::find()->orderBy('name')->all(), 'id', 'name'),
                        ['prompt' => 'Chagua Mkoa']
                    ) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'dob_district')->dropDownList(
                        ArrayHelper::map(District::find()->orderBy('name')->all(), 'id', 'name'),
                        ['prompt' => 'Chagua Wilaya']
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card ui-section-card border-0">
        <div class="card-body">
            <div class="ui-section-eyebrow">Hatua ya 2</div>
            <h2 class="ui-section-title">Imani na Hali ya Ndoa</h2>
            <p class="ui-section-copy">Taarifa hizi zinasaidia kufuatilia hali ya ushiriki wa msharika ndani ya kanisa na familia yake.</p>

            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'is_baptized')->dropDownList($trueFalse, ['prompt' => 'Amebatizwa?']) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'confirmation')->dropDownList($trueFalse, ['prompt' => 'Amepata Kipaimara?']) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'is_join_table')->dropDownList($trueFalse, ['prompt' => 'Unashiriki Jumuiya?']) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'marital_status')->dropDownList($maritalStatus, ['prompt' => 'Hali ya Ndoa']) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'marriage_type')->dropDownList($mariageType, ['prompt' => 'Aina ya Ndoa']) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'spouse_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'street_join')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'church_elder')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card ui-section-card border-0">
        <div class="card-body">
            <div class="ui-section-eyebrow">Hatua ya 3</div>
            <h2 class="ui-section-title">Kazi na Mawasiliano</h2>
            <p class="ui-section-copy">Weka taarifa za kazi, bahasha, na mawasiliano ili wasifu wa msharika uwe kamili na rahisi kufuatilia.</p>

            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'occupation')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'designation')->textInput(['maxlength' => true])->label('Cheo') ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'designation_designation')->textInput(['maxlength' => true])->label('Bahasha') ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'occupation_place')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'next_of_kin_phone')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'home_congregation')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card ui-section-card border-0">
        <div class="card-body">
            <div class="ui-section-eyebrow">Hatua ya 4</div>
            <h2 class="ui-section-title">Usimamizi wa Usharika</h2>
            <p class="ui-section-copy">Hii ndiyo sehemu ya mwisho ya kumhusisha msharika na sharika pamoja na kudhibiti hali yake ya usajili.</p>

            <div class="row g-3">
                <div class="col-lg-6 col-md-6">
                    <?= $form->field($model, 'center_id')->dropDownList(
                        ArrayHelper::map(Center::find()->orderBy('name')->all(), 'id', 'name'),
                        ['prompt' => 'Chagua Sharika']
                    ) ?>
                </div>
                <?php if ($isEditing): ?>
                    <div class="col-lg-6 col-md-6">
                        <?= $form->field($model, 'status')->dropDownList(User::memberStatusOptions()) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="form-actions-bar">
        <div>
            <div class="fw-semibold"><?= $isEditing ? 'Hifadhi mabadiliko ya taarifa za msharika' : 'Kagua taarifa zote kabla ya kusajili' ?></div>
            <div class="text-muted small"><?= $isEditing ? 'Mabadiliko yatatumika mara moja kwenye wasifu wa msharika.' : 'Baada ya kusajili, utaelekezwa moja kwa moja kwenye wasifu wa msharika.' ?></div>
        </div>
        <?= Html::submitButton($isEditing ? 'Hifadhi Mabadiliko' : 'Sajili Msharika', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
