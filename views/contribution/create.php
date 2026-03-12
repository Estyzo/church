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

$this->title = 'Sajili Matoleo';
$this->params['breadcrumbs'][] = ['label' => 'Matoleo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contribution-create">

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
