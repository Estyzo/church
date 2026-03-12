<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\ContributionsType;
use app\models\User;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Contribution $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $paymentType */
/** @var array $paymentChannel */
/** @var array $userOptions */
/** @var array $userDesignations */
/** @var bool $lockUser */
/** @var string|null $selectedUserName */

$today = date('Y-m-d');
$selectedDesignation = 'Haijawekwa';
if (!empty($model->user_id) && isset($userDesignations[$model->user_id])) {
    $selectedDesignation = $userDesignations[$model->user_id];
}

$designationLabel = (new User())->getAttributeLabel('designation_designation');
?>

<div class="contribution-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card ui-section-card border-0">
        <div class="card-body">
            <div class="ui-section-eyebrow">Hatua ya 1</div>
            <h2 class="ui-section-title">Muktadha wa Msharika</h2>
            <p class="ui-section-copy">Chagua msharika au hakiki aliyefunguliwa tayari, kisha thibitisha bahasha kabla ya kuendelea na taarifa za toleo.</p>

            <div class="row g-3">
                <div class="col-lg-6">
                    <?php if ($lockUser): ?>
                        <?= Html::label($model->getAttributeLabel('user_id'), 'contribution-member-name', ['class' => 'form-label']) ?>
                        <?= Html::textInput('contribution-member-name', $selectedUserName, [
                            'class' => 'form-control',
                            'id' => 'contribution-member-name',
                            'readonly' => true,
                        ]) ?>
                        <?= Html::activeHiddenInput($model, 'user_id') ?>
                    <?php else: ?>
                        <?= $form->field($model, 'user_id')->dropDownList($userOptions, [
                            'prompt' => 'Chagua Msharika',
                            'id' => 'contribution-user-id',
                        ]) ?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6">
                    <?= Html::label($designationLabel, 'member-designation-display', ['class' => 'form-label']) ?>
                    <?= Html::textInput('member-designation-display', $selectedDesignation, [
                        'class' => 'form-control',
                        'id' => 'member-designation-display',
                        'readonly' => true,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card ui-section-card border-0">
        <div class="card-body">
            <div class="ui-section-eyebrow">Hatua ya 2</div>
            <h2 class="ui-section-title">Taarifa za Toleo</h2>
            <p class="ui-section-copy">Jaza aina ya toleo, kiasi, tarehe ya malipo, na taarifa za rejea kwa usahihi.</p>

            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'contribution_type_id')->dropDownList(
                        ArrayHelper::map(ContributionsType::find()->orderBy('name')->all(), 'id', 'name'),
                        ['prompt' => 'Chagua aina ya toleo']
                    ) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'date_of_payment')->input('date', [
                        'class' => 'form-control',
                        'value' => $model->date_of_payment ?: $today,
                    ]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'payment_mode')->dropDownList($paymentType, ['prompt' => 'Chagua njia ya malipo']) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'reference_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <?= $form->field($model, 'channel_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'payment_desc')->textarea(['rows' => 2]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions-bar">
        <div>
            <div class="fw-semibold">Kagua taarifa za msharika na malipo kabla ya kuhifadhi</div>
            <div class="text-muted small">Rejea, kiasi, na tarehe ya malipo ndivyo vinavyotumika sana kwenye ripoti.</div>
        </div>
        <?= Html::submitButton($model->isNewRecord ? 'Sajili Toleo' : 'Hifadhi Mabadiliko', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php if (!$lockUser): ?>
<?php
$designationMapJson = Json::htmlEncode($userDesignations);
$emptyDesignationJson = Json::htmlEncode('Haijawekwa');
$this->registerJs(<<<JS
(() => {
    const userSelect = document.getElementById('contribution-user-id');
    const designationField = document.getElementById('member-designation-display');

    if (!userSelect || !designationField) {
        return;
    }

    const designationMap = $designationMapJson;
    const emptyDesignation = $emptyDesignationJson;

    const syncDesignation = () => {
        designationField.value = designationMap[userSelect.value] || emptyDesignation;
    };

    syncDesignation();
    userSelect.addEventListener('change', syncDesignation);
})();
JS);
?>
<?php endif; ?>
