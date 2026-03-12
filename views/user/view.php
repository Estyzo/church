<?php

use app\models\Contribution;
use app\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$fullName = trim(implode(' ', array_filter([
    $model->first_name,
    $model->middle_name,
    $model->last_name,
])));
$this->title = $fullName !== '' ? $fullName : ('Msharika #' . $model->id);
$this->params['breadcrumbs'][] = ['label' => 'Washarika', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$statusToneMap = [
    1 => 'success',
    2 => 'warning',
    3 => 'info',
    4 => 'danger',
];
$statusTone = $statusToneMap[(int) $model->status] ?? 'neutral';
$dependantCount = (int) $dataProvider->getTotalCount();
$contributionCount = (int) $dataProviderPayment->getTotalCount();
$contributionTotal = (float) ((clone $dataProviderPayment->query)->sum('amount') ?? 0);
?>

<div class="user-view">
    <div class="card member-hero-card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex flex-column flex-xl-row justify-content-between gap-4 align-items-xl-start">
                <div>
                    <div class="page-kicker">Wasifu wa Msharika</div>
                    <h1 class="member-hero-title"><?= Html::encode($this->title) ?></h1>
                    <div class="member-meta-list">
                        <span><i class="ti ti-building-warehouse"></i><?= Html::encode($model->center->name ?? 'Sharika halijawekwa') ?></span>
                        <span><i class="ti ti-ticket"></i><?= Html::encode($model->designation_designation ?: 'Bahasha haijawekwa') ?></span>
                        <span><i class="ti ti-phone"></i><?= Html::encode($model->phone ?: 'Hakuna simu') ?></span>
                        <span><i class="ti ti-mail"></i><?= Html::encode($model->email ?: 'Hakuna barua pepe') ?></span>
                    </div>
                    <div class="page-toolbar-meta mt-3">
                        <span class="stat-pill"><strong><?= Html::encode(User::memberStatusLabel((int) $model->status)) ?></strong> hali ya sasa</span>
                        <span class="stat-pill"><strong><?= Yii::$app->formatter->asInteger($dependantCount) ?></strong> tegemezi</span>
                        <span class="stat-pill"><strong><?= Yii::$app->formatter->asInteger($contributionCount) ?></strong> matoleo</span>
                        <span class="stat-pill"><strong><?= Yii::$app->formatter->asCurrency($contributionTotal, 'TZS') ?></strong> jumla ya michango</span>
                    </div>
                </div>
                <div class="action-cluster justify-content-xl-end">
                    <?= Html::a('<i class="ti ti-cash-banknote me-1"></i>Sajili Matoleo', ['contribution/contribution', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                    <?= Html::a('<i class="ti ti-user-plus me-1"></i>Sajili Tegemezi', ['dependant/dependant', 'id' => $model->id], ['class' => 'btn btn-outline-success']) ?>
                    <?= Html::a('<i class="ti ti-edit me-1"></i>Badili Taarifa', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
                    <?= Html::a('<i class="ti ti-trash me-1"></i>Futa', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-outline-danger',
                        'data' => [
                            'confirm' => 'Una uhakika unataka kufuta taarifa hii?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card table-shell-card border-0">
        <div class="card-body">
            <ul class="nav nav-pills member-tabs gap-2 mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true">
                        Taarifa za Msharika
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">
                        Tegemezi (<?= Yii::$app->formatter->asInteger($dependantCount) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                        role="tab" aria-controls="contact" aria-selected="false">
                        Matoleo (<?= Yii::$app->formatter->asInteger($contributionCount) ?>)
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="mb-3">
                        <div class="page-kicker">Maelezo ya Usajili</div>
                        <h5 class="mb-1">Taarifa za Kina za Msharika</h5>
                        <p class="text-muted mb-0">Taarifa binafsi, mahali pa kuzaliwa, hali ya ushiriki wa kanisa, na mawasiliano ya msharika.</p>
                    </div>

                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-striped detail-view mb-0'],
                        'attributes' => [
                            [
                                'label' => 'Jina Kamili',
                                'value' => $fullName,
                            ],
                            [
                                'attribute' => 'gender',
                                'value' => static fn(User $member) => User::genderLabel($member->gender),
                            ],
                            [
                                'attribute' => 'dob',
                                'value' => static fn(User $member) => $member->dob ? Yii::$app->formatter->asDate($member->dob, 'php:d M Y') : 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'dob_region',
                                'value' => static fn(User $member) => $member->dobRegion?->name ?? 'Haipo',
                            ],
                            [
                                'attribute' => 'dob_district',
                                'value' => static fn(User $member) => $member->dobDistrict?->name ?? 'Haipo',
                            ],
                            [
                                'attribute' => 'is_baptized',
                                'value' => static fn(User $member) => User::yesNoLabel($member->is_baptized),
                            ],
                            [
                                'attribute' => 'marital_status',
                                'value' => static fn(User $member) => User::maritalStatusLabel($member->marital_status),
                            ],
                            [
                                'attribute' => 'confirmation',
                                'value' => static fn(User $member) => User::yesNoLabel($member->confirmation),
                            ],
                            [
                                'attribute' => 'marriage_type',
                                'value' => static fn(User $member) => User::marriageTypeLabel($member->marriage_type),
                            ],
                            [
                                'attribute' => 'spouse_name',
                                'value' => static fn(User $member) => $member->spouse_name ?: 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'is_join_table',
                                'value' => static fn(User $member) => User::yesNoLabel($member->is_join_table),
                            ],
                            [
                                'attribute' => 'street_join',
                                'value' => static fn(User $member) => $member->street_join ?: 'Haipo',
                            ],
                            [
                                'attribute' => 'church_elder',
                                'value' => static fn(User $member) => $member->church_elder ?: 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'occupation',
                                'value' => static fn(User $member) => $member->occupation ?: 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'occupation_place',
                                'value' => static fn(User $member) => $member->occupation_place ?: 'Haijawekwa',
                            ],
                            [
                                'label' => 'Bahasha',
                                'value' => $model->designation_designation ?: 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'designation',
                                'label' => 'Cheo',
                                'value' => static fn(User $member) => $member->designation ?: 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'phone',
                                'value' => static fn(User $member) => $member->phone ?: 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'email',
                                'value' => static fn(User $member) => $member->email ?: 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'next_of_kin_phone',
                                'value' => static fn(User $member) => $member->next_of_kin_phone ?: 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'home_congregation',
                                'value' => static fn(User $member) => $member->home_congregation ?: 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'center.name',
                                'label' => 'Sharika',
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => Html::tag('span', Html::encode(User::memberStatusLabel((int) $model->status)), ['class' => 'soft-pill soft-pill-' . $statusTone]),
                            ],
                            [
                                'attribute' => 'created_at',
                                'label' => 'Tarehe ya Usajili',
                                'value' => $model->created_at ? Yii::$app->formatter->asDatetime($model->created_at, 'php:d M Y H:i') : 'Haijawekwa',
                            ],
                            [
                                'label' => 'Amesajiliwa Na',
                                'value' => static function (User $member) {
                                    if (!$member->createdBy) {
                                        return 'Haipo';
                                    }

                                    return $member->createdBy->username . ' (' . $member->createdBy->email . ')';
                                },
                            ],
                        ],
                    ]) ?>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="mb-3">
                        <div class="page-kicker">Watu Wanaomtegemea</div>
                        <h5 class="mb-1">Taarifa za Tegemezi</h5>
                        <p class="text-muted mb-0">Orodha ya watoto na tegemezi wengine waliosajiliwa chini ya msharika huyu.</p>
                    </div>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n<div class=\"dashboard-grid-footer d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3\">{summary}{pager}</div>",
                        'options' => ['class' => 'grid-view mb-0'],
                        'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                        'summaryOptions' => ['class' => 'text-muted small mb-0'],
                        'emptyText' => '<div class="table-empty-state"><i class="ti ti-users-group"></i><div class="fw-semibold mb-1">Hakuna tegemezi waliosajiliwa</div><div>Tumia kitufe cha "Sajili Tegemezi" juu ya ukurasa huu kuongeza taarifa mpya.</div></div>',
                        'pager' => [
                            'options' => ['class' => 'pagination pagination-sm mb-0'],
                            'prevPageLabel' => 'Iliyopita',
                            'nextPageLabel' => 'Inayofuata',
                            'maxButtonCount' => 5,
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Jina Kamili',
                                'value' => static function ($dependant) {
                                    return trim(implode(' ', array_filter([
                                        $dependant->first_name,
                                        $dependant->middle_name,
                                        $dependant->last_name,
                                    ])));
                                },
                            ],
                            [
                                'attribute' => 'dob',
                                'label' => 'Tarehe ya Kuzaliwa',
                                'value' => static fn($dependant) => $dependant->dob ? Yii::$app->formatter->asDate($dependant->dob, 'php:d M Y') : 'Haijawekwa',
                            ],
                            [
                                'attribute' => 'dependant_type',
                                'label' => 'Aina',
                                'format' => 'raw',
                                'value' => static fn($dependant) => Html::tag('span', Html::encode($dependant->dependant_type), ['class' => 'soft-pill soft-pill-neutral']),
                            ],
                            [
                                'attribute' => 'is_budtized',
                                'label' => 'Amebatizwa',
                                'value' => static fn($dependant) => $dependant->is_budtized ? 'Ndiyo' : 'Hapana',
                            ],
                            [
                                'attribute' => 'occupation',
                                'label' => 'Shughuli',
                                'value' => static fn($dependant) => $dependant->occupation ?: 'Haijawekwa',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['class' => 'text-nowrap'],
                                'template' => '{view} {update}',
                                'buttons' => [
                                    'view' => static function ($url, $dependant) {
                                        return Html::a(
                                            '<i class="ti ti-eye me-1"></i>Onyesha',
                                            ['dependant/view', 'id' => $dependant->id],
                                            [
                                                'title' => 'Onyesha',
                                                'class' => 'btn btn-light btn-sm border',
                                            ]
                                        );
                                    },
                                    'update' => static function ($url, $dependant) {
                                        return Html::a(
                                            '<i class="ti ti-edit me-1"></i>Badili',
                                            ['dependant/update', 'id' => $dependant->id],
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

                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="mb-3">
                        <div class="page-kicker">Miamala ya Msharika</div>
                        <h5 class="mb-1">Taarifa za Matoleo</h5>
                        <p class="text-muted mb-0">Muhtasari wa malipo yote yaliyowekewa msharika huyu pamoja na aina ya toleo na rejea zake.</p>
                    </div>

                    <?= GridView::widget([
                        'dataProvider' => $dataProviderPayment,
                        'layout' => "{items}\n<div class=\"dashboard-grid-footer d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3\">{summary}{pager}</div>",
                        'options' => ['class' => 'grid-view mb-0'],
                        'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
                        'summaryOptions' => ['class' => 'text-muted small mb-0'],
                        'emptyText' => '<div class="table-empty-state"><i class="ti ti-report-money"></i><div class="fw-semibold mb-1">Hakuna matoleo ya msharika huyu</div><div>Tumia kitufe cha "Sajili Matoleo" juu ya ukurasa huu kuongeza malipo mapya.</div></div>',
                        'pager' => [
                            'options' => ['class' => 'pagination pagination-sm mb-0'],
                            'prevPageLabel' => 'Iliyopita',
                            'nextPageLabel' => 'Inayofuata',
                            'maxButtonCount' => 5,
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Aina ya Toleo',
                                'format' => 'raw',
                                'value' => static fn(Contribution $payment) => Html::tag('span', Html::encode($payment->contributionsType->name ?? 'Haijulikani'), ['class' => 'soft-pill soft-pill-info']),
                            ],
                            [
                                'attribute' => 'amount',
                                'label' => 'Kiasi',
                                'value' => static fn(Contribution $payment) => Yii::$app->formatter->asCurrency((float) $payment->amount, 'TZS'),
                            ],
                            [
                                'attribute' => 'date_of_payment',
                                'label' => 'Tarehe',
                                'value' => static fn(Contribution $payment) => Yii::$app->formatter->asDate($payment->date_of_payment, 'php:d M Y'),
                            ],
                            [
                                'attribute' => 'payment_mode',
                                'label' => 'Njia',
                                'value' => static fn(Contribution $payment) => Contribution::paymentModeLabel($payment->payment_mode),
                            ],
                            [
                                'attribute' => 'reference_no',
                                'label' => 'Rejea',
                                'value' => static fn(Contribution $payment) => $payment->reference_no ?: 'Hakuna',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['class' => 'text-nowrap'],
                                'template' => '{view} {update}',
                                'buttons' => [
                                    'view' => static function ($url, $payment) {
                                        return Html::a(
                                            '<i class="ti ti-eye me-1"></i>Onyesha',
                                            ['contribution/view', 'id' => $payment->id],
                                            [
                                                'title' => 'Onyesha',
                                                'class' => 'btn btn-light btn-sm border',
                                            ]
                                        );
                                    },
                                    'update' => static function ($url, $payment) {
                                        return Html::a(
                                            '<i class="ti ti-edit me-1"></i>Badili',
                                            ['contribution/update', 'id' => $payment->id],
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
        </div>
    </div>

</div>
