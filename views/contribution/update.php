<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Contribution $model */
/** @var array $paymentType */
/** @var array $paymentChannel */
/** @var array $userOptions */
/** @var array $userDesignations */
/** @var bool $lockUser */
/** @var string|null $selectedUserName */

$this->title = 'Badili Matoleo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Matoleo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Badili';
?>
<div class="contribution-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'paymentType' => $paymentType,
        'paymentChannel' => $paymentChannel,
        'userOptions' => $userOptions,
        'userDesignations' => $userDesignations,
        'lockUser' => $lockUser,
        'selectedUserName' => $selectedUserName,
    ]) ?>

</div>
