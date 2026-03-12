<?php

use app\models\Center;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CenterSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Masharika';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="center-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Sajili Sharika', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //   'id',
            'name',
            'address',
            'district.name',
            'email:email',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Kitendo', // ← This sets the label
                'headerOptions' => ['style' => 'text-align: center;'], // optional
                'template' => '{view} {update}',
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
                        },
                    'update' => function ($url, $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil">Badili</span>',
                                $url,
                                [
                                    'title' => 'Badili',
                                    'class' => 'btn btn-info btn-xs',
                                ]
                            );
                        },

                ],
            ],
        ],
    ]); ?>


</div>
