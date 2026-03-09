<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Badili Taarifa', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Sajiri Tegemezi', ['dependant/dependant', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Sajiri Matoleo', ['contribution/contribution', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Futa', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">

        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true">
                    Taarifa za Msharika
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">
                    Taarifa za Tegemezi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                        role="tab" aria-controls="contact" aria-selected="false">
                    Taarifa za Matoleo
                </button>
            </li>
        </ul>

        <div class="tab-content mt-2" id="myTabContent">

            <div class="tab-pane show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="col-md-10">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'label' => 'Jina Kamili',
                                'value' => $model->first_name . " " . $model->middle_name . " " . $model->last_name,
                            ],
                            ['attribute' => 'gender'],
                            ['attribute' => 'dob'],
                            [
                                'attribute' => 'dob_region',
                                'value' => function ($model) {
                                    return $model->dobRegion?->name ?? 'N/A';
                                }
                            ],
                            [
                                'attribute' => 'dob_district',
                                'value' => function ($model) {
                                    return $model->dobDistrict?->name ?? 'N/A';
                                }
                            ],
                            [
                                'attribute' => 'is_baptized',
                                'value' => function ($model) {
                                    return $model->is_baptized ? 'Ndio' : 'Hapana';
                                }
                            ],
                            ['attribute' => 'marital_status'],
                            [
                                'attribute' => 'confirmation',
                                'value' => function ($model) {
                                    return $model->confirmation ? 'Ndio' : 'Hapana';
                                }
                            ],
                            ['attribute' => 'marriage_type'],
                            ['attribute' => 'spouse_name'],
                            [
                                'attribute' => 'is_join_table',
                                'value' => function ($model) {
                                    return $model->is_join_table ? 'Ndio' : 'Hapana';
                                }
                            ],
                            [
                                'attribute' => 'street_join',
                                'value' => function ($model) {
                                    // street_join is a text field, so show the value (not Yes/No)
                                    return $model->street_join ?: 'N/A';
                                }
                            ],
                            ['attribute' => 'church_elder'],
                            ['attribute' => 'occupation'],
                            ['attribute' => 'occupation_place'],
                            ['attribute' => 'designation'],
                            ['attribute' => 'phone'],
                            ['attribute' => 'email'],
                            ['attribute' => 'next_of_kin_phone'],
                            ['attribute' => 'home_congregation'],
                            ['attribute' => 'center.name'],
                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return $model->status ? 'Hai' : 'Si Hai';
                                }
                            ],
                            ['attribute' => 'created_at'],
                            [
                                'label' => 'Amesajiliwa Na',
                                'value' => function ($model) {
                                    if (!$model->createdBy) return 'N/A';
                                    // createdBy is SystemUser (users table) => show username/email
                                    return $model->createdBy->username . ' (' . $model->createdBy->email . ')';
                                }
                            ],
                        ],
                    ]) ?>
                </div>
            </div>

            <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="col-md-10">
                    <h5>Tegemezi</h5>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Jina Kamili',
                                'value' => function ($dataa) {
                                    return $dataa->first_name . " " . $dataa->middle_name . " " . $dataa->last_name;
                                },
                            ],
                            'dob',
                            'dependant_type',
                            [
                                'attribute' => 'is_budtized',
                                'value' => function ($data) {
                                    return $data->is_budtized ? "YES" : "NO";
                                },
                            ],
                            'occupation',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a(
                                            '<span class="glyphicon glyphicon-eye-open">Onesha</span>',
                                            ['dependant/view', 'id' => $model->id],
                                            [
                                                'title' => 'Onyesha',
                                                'class' => 'btn btn-primary btn-xs',
                                            ]
                                        );
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a(
                                            '<span class="glyphicon glyphicon-pencil">Badili</span>',
                                            ['dependant/view', 'id' => $model->id],
                                            [
                                                'title' => 'Badilisha',
                                                'class' => 'btn btn-info btn-xs',
                                            ]
                                        );
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>

            <div class="tab-pane" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="col-md-10">
                    <h5>Matoleo</h5>

                    <?= GridView::widget([
                        'dataProvider' => $dataProviderPayment,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Msharika',
                                'value' => function ($data) {
                                    return $data->user->first_name . " " . $data->user->last_name;
                                }
                            ],
                            'contributionsType.name',
                            'amount',
                            'date_of_payment',
                            'reference_no',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a(
                                            '<span class="glyphicon glyphicon-eye-open">Onesha</span>',
                                            ['contribution/view', 'id' => $model->id],
                                            [
                                                'title' => 'Angalia',
                                                'class' => 'btn btn-primary btn-xs',
                                            ]
                                        );
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a(
                                            '<span class="glyphicon glyphicon-pencil">Badili</span>',
                                            ['contribution/view', 'id' => $model->id],
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
            </div>

        </div>

    </div>

</div>