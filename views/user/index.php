<?php

use app\models\Center;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Washarika';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Sajiri Msharika', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],

            // 'id',
            'first_name',
            // 'middle_name',
            'last_name',
            // 'designation',
            //'denomination',
            // 'dob',
            //'dob_region',
            //'dob_district',
            //'is_baptized',
            //'marital_status',
            //'confirmation',
            //'marriage_type',
            //'spouse_name',
            //'is_join_table',
            //'street_join',
            //'church_elder',
            //'occupation',
            //'occupation_place',
            'designation_designation',
            //'phone',
            // 'email:email',
            //'next_of_kin_phone',
            //'home_congregation',
            [
                'attribute' => 'center_id',
                'filter' => ArrayHelper::map(Center::find()->all(), 'id', 'name'),
                'value' => 'center.name',
            ],

            // [
            //     'attribute' => 'created_at',
            //     'value' => 'formattedDate',
            //     'format' => 'raw'
            // ],
    
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                        return $model->created_at
                            ? Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d')
                            : '(not set)';
                    },
                'filter' => Html::input('date', 'UserSearch[created_at]', $searchModel->created_at, [
                    'class' => 'form-control',
                ]),
            ],

            [
                'label' => 'Uhai',
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {

                        if ($model->status == 1) {
                            return "<span class='text-success'>Hai</span>";
                        }
                        if ($model->status == 2) {
                            return "<span class='text-warning'>Si Hai</span>";
                        }
                        if ($model->status == 3) {
                            return "<span class='text-info'>Amehama</span>";
                        }
                        if ($model->status == 4) {
                            return "<span class='text-danger'>Amefariki</span>";
                        }

                    },
                'filter' => [
                    1 => 'Hai',
                    2 => 'Si Hai',
                    3 => 'Amehama',
                    4 => 'Amefariki',
                ],
            ],


            //'status',
            //'updated_at',
            //'created_at',
            //'created_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Kitendo', // ← This sets the label
                'headerOptions' => ['style' => 'text-align: center;'], // optional
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-eye-open">Onesha</span>',
                                $url,
                                [
                                    'title' => 'View',
                                    'class' => 'btn btn-primary btn-xs',
                                ]
                            );
                        },
                    'update' => function ($url, $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil">Badili</span>',
                                $url,
                                [
                                    'title' => 'Update',
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