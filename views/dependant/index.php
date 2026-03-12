<?php

use app\models\Dependant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\DependantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Watoto';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dependant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'first_name',
            'last_name',
            'dob',
            //'user_id',
           // 'dependant_type',
            [
                'attribute' => 'is_budtized',
                'value' => function ($data) {
                        if ($data->is_budtized) {
                            return 'Ndiyo';
                        }
                        return 'Hapana';
                    }

            ],


            //'occupation',
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

    <?php Pjax::end(); ?>

</div>
