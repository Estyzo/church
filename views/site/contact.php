<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Wasiliana Nasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Asante kwa kuwasiliana nasi. Tutakujibu haraka iwezekanavyo.
        </div>

        <p>
            Ukifungua Yii debugger, utaweza kuona ujumbe wa barua pepe kwenye sehemu ya barua ndani ya debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Kwa sababu mfumo uko kwenye hali ya maendeleo, barua pepe haitumwi moja kwa moja bali huhifadhiwa kama faili ndani ya
                <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Weka kipengele cha <code>useFileTransport</code> kwenye sehemu ya <code>mail</code> kuwa `false` ili kuruhusu kutuma barua pepe.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            Ikiwa una swali au taarifa yoyote, tafadhali jaza fomu ifuatayo ili kuwasiliana nasi.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Tuma', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
