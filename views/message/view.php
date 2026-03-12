<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Messages $model */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Ujumbe', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="messages-view">

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
            'subject',
            'content:ntext',
            [
                'label' => 'Imetumwa na',
                'value' => static fn($model) => $model->createdBy->username ?? $model->createdBy->email ?? '-',
            ],
            'center_at',
        ],
    ]) ?>

</div>
