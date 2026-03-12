<?php

use app\models\Contribution;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\ContributionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Matoleo';
$this->params['breadcrumbs'][] = $this->title;

$paymentToneMap = [
    'CASH' => 'success',
    'MOBILE' => 'info',
    'BANK' => 'primary',
    'CONTROLNO' => 'warning',
];
$paymentBadge = static function (?string $mode) use ($paymentToneMap): string {
    $tone = $paymentToneMap[$mode] ?? 'neutral';
    $label = Contribution::paymentModeLabel($mode);

    return Html::tag('span', Html::encode($label), ['class' => 'soft-pill soft-pill-' . $tone]);
};
?>
<div class="contribution-index">
    <div class="page-title-row">
        <div>
            <div class="page-kicker">Usimamizi wa Matoleo</div>
            <h1 class="mb-1"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Pitia miamala, tazama jumla ya makusanyo, na tumia vichujio ili kupata malipo unayoyahitaji haraka.</p>
        </div>
        <?= Html::a('<i class="ti ti-cash-banknote me-1"></i>Sajili Matoleo', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php Pjax::begin([
        'timeout' => 8000,
        'enablePushState' => true,
    ]); ?>

    <?php
    $contributionQuery = clone $dataProvider->query;
    $recordCount = (int) $dataProvider->getTotalCount();
    $totalAmount = (float) ((clone $contributionQuery)->sum('amount') ?? 0);
    $latestPaymentDate = (clone $contributionQuery)->max('date_of_payment');
    ?>

    <div class="card page-toolbar-card mb-3">
        <div class="card-body">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
                <div>
                    <div class="page-kicker">Muhtasari wa Matoleo</div>
                    <h5 class="mb-1">Miamala iliyo kwenye kichujio cha sasa</h5>
                    <p class="text-muted mb-0">Orodha hii inajirekebisha kulingana na msharika, aina ya toleo, njia ya malipo, au tarehe uliyochagua.</p>
                </div>
                <div class="page-toolbar-meta">
                    <span class="stat-pill"><strong><?= Yii::$app->formatter->asInteger($recordCount) ?></strong> rekodi</span>
                    <span class="stat-pill"><strong><?= Yii::$app->formatter->asCurrency($totalAmount, 'TZS') ?></strong> jumla ya kiasi</span>
                    <span class="stat-pill"><strong><?= $latestPaymentDate ? Yii::$app->formatter->asDate($latestPaymentDate, 'php:d M Y') : 'Hakuna' ?></strong> malipo ya mwisho</span>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <div class="card table-shell-card border-0">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-md-center">
                <div>
                    <h5 class="mb-1">Orodha ya Matoleo</h5>
                    <div class="table-meta">Msharika, aina ya toleo, njia ya malipo, rejea, na kiasi vimewekwa katika muonekano mmoja.</div>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'showFooter' => true,
                'layout' => "{items}\n<div class=\"dashboard-grid-footer d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3\">{summary}{pager}</div>",
                'options' => ['class' => 'grid-view mb-0'],
                'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                'summaryOptions' => ['class' => 'text-muted small mb-0'],
                'emptyText' => '<div class="table-empty-state"><i class="ti ti-report-money"></i><div class="fw-semibold mb-1">Hakuna matoleo yaliyoonekana</div><div>Badili vichujio vyako au sajili toleo jipya ili miamala ionekane hapa.</div></div>',
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
                        'value' => static function (Contribution $model) {
                            if (!$model->user) {
                                return Html::tag('div', 'Michango ya Jumla', ['class' => 'fw-semibold']) .
                                    Html::tag('div', 'Imehifadhiwa bila kumbukumbu ya msharika mmoja', ['class' => 'text-muted small']);
                            }

                            $memberName = trim(implode(' ', array_filter([
                                $model->user->first_name,
                                $model->user->middle_name,
                                $model->user->last_name,
                            ])));
                            if ($memberName === '') {
                                $memberName = 'Msharika #' . $model->user->id;
                            }
                            $envelope = $model->user->designation_designation ?: 'Bahasha haijawekwa';

                            return Html::tag('div', Html::encode($memberName), ['class' => 'fw-semibold']) .
                                Html::tag('div', Html::encode($envelope), ['class' => 'text-muted small']);
                        },
                    ],
                    [
                        'label' => 'Aina ya Toleo',
                        'format' => 'raw',
                        'value' => static function (Contribution $model) {
                            $type = $model->contributionsType->name ?? 'Haijulikani';

                            return Html::tag('span', Html::encode($type), ['class' => 'soft-pill soft-pill-info']);
                        },
                    ],
                    [
                        'attribute' => 'date_of_payment',
                        'label' => 'Tarehe',
                        'value' => static fn(Contribution $model) => Yii::$app->formatter->asDate($model->date_of_payment, 'php:d M Y'),
                    ],
                    [
                        'attribute' => 'payment_mode',
                        'label' => 'Njia',
                        'format' => 'raw',
                        'value' => static fn(Contribution $model) => $paymentBadge($model->payment_mode),
                    ],
                    [
                        'attribute' => 'reference_no',
                        'label' => 'Rejea',
                        'value' => static fn(Contribution $model) => $model->reference_no ?: 'Hakuna',
                    ],
                    [
                        'attribute' => 'amount',
                        'label' => 'Kiasi',
                        'format' => 'raw',
                        'value' => static fn(Contribution $model) => Html::tag(
                            'span',
                            Html::encode(Yii::$app->formatter->asCurrency((float) $model->amount, 'TZS')),
                            ['class' => 'fw-semibold text-nowrap']
                        ),
                        'footer' => Html::tag(
                            'span',
                            Html::encode(Yii::$app->formatter->asCurrency($totalAmount, 'TZS')),
                            ['class' => 'fw-bold text-nowrap']
                        ),
                        'contentOptions' => ['class' => 'text-end'],
                        'headerOptions' => ['class' => 'text-end'],
                        'footerOptions' => ['class' => 'text-end'],
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
