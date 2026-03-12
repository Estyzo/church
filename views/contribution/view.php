<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Contribution $model */

$this->title = "Malipo ya " . $model->contributionsType->name;
$this->params['breadcrumbs'][] = ['label' => 'Matoleo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contribution-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Badili', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Futa', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Una uhakika unataka kufuta taarifa hii?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'label' => 'Aliyechangia',
                'value' => function ($data) {
                if ($data->user) {
                    return $data->user->first_name . " " . $data->user->last_name;
                } else {
                    return "Mkusanyiko siku Husika";
                }
            }
            ],
            'contributionsType.name',
            'amount',
            'date_of_payment',
            [
                'attribute' => 'payment_mode',
                'value' => static fn($data) => \app\models\Contribution::paymentModeLabel($data->payment_mode),
            ],
            'reference_no',
            'payment_desc:ntext',
            'channel_name',
            [
                'label' => 'Imesajiliwa Na',
                'value' => function ($data) {
                if ($data->createdBy) {
                    $username = $data->createdBy->username ?? '';
                    $email = $data->createdBy->email ?? '-';
                    return trim($username . ' (' . $email . ')');
                } else {
                    return "Hakuna";
                }
            }
            ],
        ],
    ]) ?>

</div>
