<?php

use business\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

FrontAppAsset::register($this);
AppAsset::register($this);
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Bussiness Request | Walk Into the Wild';
$this->params['title'] = $this->title;
?>
<div class="card">
    <div class="text-center" style="background-color:#09422d;">
        <h1 class="text-white mt-4">Business Request</h1>
    </div>
    <div class="card-body">
        <div class="row py-4">
            <div class="col-12 logindesign">
                <div class="content_terms">
                    <?php $form = ActiveForm::begin([
                        'id' => 'businessrequestform'
                    ]); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'business_name')->textInput(['placeholder' => 'Enter Business Name']) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'about_business')->textarea(['rows' => 6, 'placeholder' => 'Write About Business']) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Enter Address', 'data-label' => 'Address']) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'phone_no')->textInput() ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'alternate_phone_no')->textInput() ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'yourbusiness@domain.com']) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'alternate_email')->textInput(['maxlength' => true, 'placeholder' => 'alternateemail@domain.com']) ?>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $form->field($model, 'reCaptcha')->widget(\kekaadrenalin\recaptcha3\ReCaptchaWidget::class)->label(false) ?>
                                <?= Html::submitButton('Save', ['class' => 'justify-content-center btn btn-success']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>