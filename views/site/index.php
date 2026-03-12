<?php
use app\models\Contribution;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Dashibodi';
$this->params['breadcrumbs'][] = $this->title;

$metrics = [
    [
        'label' => 'Washarika',
        'value' => (int) $washarika,
        'icon' => 'ti ti-users',
        'tone' => 'primary',
        'note' => 'Jumla ya washarika waliosajiliwa',
    ],
    [
        'label' => 'Matoleo',
        'value' => (int) $matoleo,
        'icon' => 'ti ti-report-money',
        'tone' => 'success',
        'note' => 'Michango yote iliyorekodiwa',
    ],
    [
        'label' => 'Tegemezi',
        'value' => (int) $tegemezi,
        'icon' => 'ti ti-heart-handshake',
        'tone' => 'warning',
        'note' => 'Watoto/tegemezi walioorodheshwa',
    ],
    [
        'label' => 'Aina za Matoleo',
        'value' => (int) $ainamatoleo,
        'icon' => 'ti ti-list-details',
        'tone' => 'danger',
        'note' => 'Aina zinazotumika kwenye mfumo',
    ],
];
?>


<div class="row">
    <?php foreach ($metrics as $metric): ?>
    <div class="col-sm-6 col-xl-3">
        <div class="card dashboard-metric-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                    <div>
                        <div class="text-muted small mb-1"><?= Html::encode($metric['label']) ?></div>
                        <div class="h3 mb-0"><?= Yii::$app->formatter->asInteger($metric['value']) ?></div>
                    </div>
                    <span class="metric-icon metric-icon-<?= Html::encode($metric['tone']) ?>">
                        <i class="<?= Html::encode($metric['icon']) ?>"></i>
                    </span>
                </div>
                <p class="mb-0 text-muted small"><?= Html::encode($metric['note']) ?></p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="col-md-12 col-xl-8">
        <div class="card dashboard-panel-card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Idadi ya Washarika Katika Usajili</h5>
                    <span class="badge bg-light-primary text-primary border border-primary-subtle">Mwaka</span>
                </div>
            </div>
            <div class="card-body">
                <div id="visitor-chart-1"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-4">
        <div class="card dashboard-panel-card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="mb-0">Mapato Kiujumla</h5>
            </div>
            <div class="card-body">
                <h6 class="mb-2 text-muted">Kwa Mwaka</h6>
                <h3 class="mb-3"><?= Yii::$app->formatter->asCurrency((float) ($mapatoKwaMwaka ?? 0), 'TZS') ?></h3>
                <div id="income-overview-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card table-card dashboard-table-card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-1">Matoleo ya Hivi Karibuni</h5>
                <p class="mb-0 text-muted small">Muhtasari wa miamala ya mwisho iliyowekwa kwenye mfumo.</p>
            </div>
            <div class="card-body pt-0">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n<div class=\"dashboard-grid-footer d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3\">{summary}{pager}</div>",
                    'options' => ['class' => 'grid-view mb-0'],
                    'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                    'summaryOptions' => ['class' => 'text-muted small mb-0'],
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
                            'value' => static function ($data) {
                                if ($data->user) {
                                    return trim($data->user->first_name . ' ' . $data->user->last_name);
                                }

                                return 'Michango ya Jumla';
                            },
                        ],
                        [
                            'label' => 'Aina ya Toleo',
                            'value' => static fn($data) => $data->contributionsType->name ?? '-',
                        ],
                        [
                            'attribute' => 'amount',
                            'label' => 'Kiasi',
                            'format' => ['decimal', 0],
                            'contentOptions' => ['class' => 'text-end fw-semibold'],
                            'headerOptions' => ['class' => 'text-end'],
                        ],
                        [
                            'attribute' => 'date_of_payment',
                            'label' => 'Tarehe',
                            'format' => ['date', 'php:d M Y'],
                        ],
                        [
                            'attribute' => 'payment_mode',
                            'label' => 'Njia',
                            'value' => static fn($data) => Contribution::paymentModeLabel($data->payment_mode),
                        ],
                        [
                            'attribute' => 'reference_no',
                            'label' => 'Rejea',
                            'value' => static fn($data) => $data->reference_no ?: '-',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
