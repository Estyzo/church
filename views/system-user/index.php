<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Watumiaji wa Mfumo';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="system-user-index">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
        <?= Html::a('Sajili Mtumiaji', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'value' => static fn($model) => \app\models\SystemUser::roleLabel($model->role),
            ],
            [
                'attribute' => 'center_id',
                'label' => 'Sharika',
                'value' => static fn($model) => $model->center ? $model->center->name : null,
            ],
            [
                'attribute' => 'status',
                'value' => static fn($model) => \app\models\SystemUser::statusLabel((int) $model->status),
            ],
            [
                'class' => ActionColumn::class,
                'header' => 'Kitendo',
                'template' => '{update} {reset-password} {delete}',
                'buttons' => [
                    'update' => static function ($url, $model) {
                        return Html::a('Badili', ['update', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-outline-primary',
                            'title' => 'Badili taarifa za mtumiaji',
                        ]);
                    },
                    'reset-password' => static function ($url, $model) {
                        return Html::a('Weka Upya Nenosiri', ['reset-password', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-outline-warning',
                            'title' => 'Weka upya nenosiri',
                        ]);
                    },
                    'delete' => static function ($url, $model) {
                        return Html::a('Futa', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-outline-danger',
                            'title' => 'Futa mtumiaji',
                            'data' => [
                                'confirm' => 'Una uhakika unataka kufuta taarifa hii?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
