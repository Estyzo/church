<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'System Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="system-user-index">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
        <?= Html::a('Register User', ['create'], ['class' => 'btn btn-success']) ?>
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
                'value' => static fn($model) => ucfirst((string)$model->role),
            ],
            [
                'attribute' => 'center_id',
                'label' => 'Center',
                'value' => static fn($model) => $model->center ? $model->center->name : null,
            ],
            [
                'attribute' => 'status',
                'value' => static fn($model) => (int)$model->status === 1 ? 'Active' : 'Inactive',
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{update} {reset-password} {delete}',
                'buttons' => [
                    'reset-password' => static function ($url, $model) {
                        return Html::a('Reset Password', ['reset-password', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-outline-warning',
                            'title' => 'Reset password',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
