<?php

use app\models\Messages;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\MessageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ujumbe';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tuma Ujumbe', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'subject',
            // 'content:ntext',
            [
                'label' => 'Umetumwa Na',
                'value' => static fn($model) => $model->createdBy->username ?? $model->createdBy->email ?? '-',
            ],

            'center_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Kitendo', // ← This sets the label
                'headerOptions' => ['style' => 'text-align: center;'], // optional
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-eye-open">Onyesha</span>',
                                $url,
                                [
                                    'title' => 'Onyesha',
                                    'class' => 'btn btn-primary btn-xs',
                                ]
                            );
                        }
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
