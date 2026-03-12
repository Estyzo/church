<?php

use app\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Washarika';
$this->params['breadcrumbs'][] = $this->title;

$statusToneMap = [
    1 => 'success',
    2 => 'warning',
    3 => 'info',
    4 => 'danger',
];
$statusBadge = static function (?int $status) use ($statusToneMap): string {
    $label = User::memberStatusLabel($status);
    $tone = $statusToneMap[$status] ?? 'neutral';

    return Html::tag('span', Html::encode($label), ['class' => 'soft-pill soft-pill-' . $tone]);
};
$memberName = static function (User $member): string {
    $fullName = trim(implode(' ', array_filter([
        $member->first_name,
        $member->middle_name,
        $member->last_name,
    ])));

    return $fullName !== '' ? $fullName : ('Msharika #' . $member->id);
};
?>
<div class="user-index">
    <div class="page-title-row">
        <div>
            <div class="page-kicker">Usimamizi wa Washarika</div>
            <h1 class="mb-1"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Fuatilia usajili, hali ya msharika, na taarifa za msingi kwa mwonekano unaosomwa haraka.</p>
        </div>
        <?= Html::a('<i class="ti ti-user-plus me-1"></i>Sajili Msharika', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php Pjax::begin([
        'timeout' => 8000,
        'enablePushState' => true,
    ]); ?>

    <?php
    $memberQuery = clone $dataProvider->query;
    $filteredMembers = (int) $dataProvider->getTotalCount();
    $activeMembers = (int) (clone $memberQuery)->andWhere(['status' => 1])->count();
    $membersWithEnvelope = (int) (clone $memberQuery)
        ->andWhere(['not', ['designation_designation' => null]])
        ->andWhere(['<>', 'designation_designation', ''])
        ->count();
    ?>

    <div class="card page-toolbar-card mb-3">
        <div class="card-body">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
                <div>
                    <div class="page-kicker">Muhtasari wa Orodha</div>
                    <h5 class="mb-1">Orodha ya Washarika</h5>
                    <p class="text-muted mb-0">Tumia kisanduku cha kutafuta hapa chini kupunguza orodha kabla ya kufungua wasifu wa msharika.</p>
                </div>
                <div class="page-toolbar-meta">
                    <span class="stat-pill"><strong><?= Yii::$app->formatter->asInteger($filteredMembers) ?></strong> waliosalia kwenye orodha</span>
                    <span class="stat-pill"><strong><?= Yii::$app->formatter->asInteger($activeMembers) ?></strong> wenye hali ya Hai</span>
                    <span class="stat-pill"><strong><?= Yii::$app->formatter->asInteger($membersWithEnvelope) ?></strong> wenye bahasha</span>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <div class="card table-shell-card border-0">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-md-center">
                <div>
                    <h5 class="mb-1">Orodha ya Washarika</h5>
                    <div class="table-meta">Majina, sharika, bahasha, na hali ya usajili kwa muonekano mmoja.</div>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n<div class=\"dashboard-grid-footer d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3\">{summary}{pager}</div>",
                'options' => ['class' => 'grid-view mb-0'],
                'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                'summaryOptions' => ['class' => 'text-muted small mb-0'],
                'emptyText' => '<div class="table-empty-state"><i class="ti ti-users"></i><div class="fw-semibold mb-1">Hakuna washarika waliopatikana</div><div>Badili vichujio vyako au sajili msharika mpya ili taarifa zionekane hapa.</div></div>',
                'pager' => [
                    'options' => ['class' => 'pagination pagination-sm mb-0'],
                    'prevPageLabel' => 'Iliyopita',
                    'nextPageLabel' => 'Inayofuata',
                    'maxButtonCount' => 5,
                ],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => '#',
                        'contentOptions' => ['class' => 'text-muted'],
                        'headerOptions' => ['class' => 'text-muted'],
                    ],
                    [
                        'label' => 'Msharika',
                        'format' => 'raw',
                        'value' => static function (User $model) use ($memberName) {
                            $phone = $model->phone ?: 'Hakuna simu';

                            return Html::tag('div', Html::encode($memberName($model)), ['class' => 'fw-semibold']) .
                                Html::tag('div', Html::encode($phone), ['class' => 'text-muted small']);
                        },
                    ],
                    [
                        'attribute' => 'designation_designation',
                        'label' => 'Bahasha',
                        'format' => 'raw',
                        'value' => static function (User $model) {
                            if (!$model->designation_designation) {
                                return Html::tag('span', 'Haijawekwa', ['class' => 'text-muted small']);
                            }

                            return Html::tag('span', Html::encode($model->designation_designation), ['class' => 'soft-pill soft-pill-neutral']);
                        },
                    ],
                    [
                        'attribute' => 'center_id',
                        'label' => 'Sharika',
                        'value' => static fn(User $model) => $model->center->name ?? 'Haijulikani',
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Tarehe ya Usajili',
                        'value' => static fn(User $model) => $model->created_at
                            ? Yii::$app->formatter->asDate($model->created_at, 'php:d M Y')
                            : 'Haijawekwa',
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Uhai',
                        'format' => 'raw',
                        'value' => static fn(User $model) => $statusBadge((int) $model->status),
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Kitendo',
                        'contentOptions' => ['class' => 'text-nowrap'],
                        'template' => '{view} {update}',
                        'buttons' => [
                            'view' => static function ($url) {
                                return Html::a(
                                    '<i class="ti ti-eye me-1"></i>Onyesha',
                                    $url,
                                    [
                                        'title' => 'Onyesha',
                                        'class' => 'btn btn-light btn-sm border',
                                    ]
                                );
                            },
                            'update' => static function ($url) {
                                return Html::a(
                                    '<i class="ti ti-edit me-1"></i>Badili',
                                    $url,
                                    [
                                        'title' => 'Badili',
                                        'class' => 'btn btn-outline-primary btn-sm',
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <?php Pjax::end(); ?>

</div>
