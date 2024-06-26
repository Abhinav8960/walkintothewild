<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->params['active_link'] = 'contact';
$this->title = 'Contact';
?>

<div class="row flex-row-reverse gap-20 mb-5">
    <div class="col-lg-8">
        <div class="contact__form">
            <h2>Have A Query! Please Leave Your Contact Details.</h2>
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <?= $form->field($model, 'name')->textInput(['class' => 'form-control', 'placeholder' => 'Name*'])->label(false) ?>
                </div>
                <div class="col-md-6 mb-4">
                    <?= $form->field($model, 'phone')->textInput(['class' => 'form-control', 'type' => 'text', 'onkeypress' => 'return /[0-9]/i.test(event.key)', 'placeholder' => 'Phone*'])->label(false) ?>
                </div>
                <div class="col-md-6 mb-4">
                    <?= $form->field($model, 'email')->textInput(['class' => 'form-control', 'placeholder' => 'Email*'])->label(false) ?>
                </div>
                <div class="col-12 mb-4">
                    <?= $form->field($model, 'message')->textarea(['class' => 'form-control', 'rows' => 8, 'placeholder' => 'Message*'])->label(false)  ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="btn-wrapper justify-content-center justify-content-lg-start mt-0">
                        <?= $form->field($model, 'reCaptcha')->widget(\kekaadrenalin\recaptcha3\ReCaptchaWidget::class)->label(false) ?>
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'register-button']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>