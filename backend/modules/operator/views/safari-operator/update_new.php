<?php

use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

// $webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
// $this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Update Safari Operator';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Update', 'url' => '#'];
$this->params['title'] = $this->title;

?>
<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'safariform',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'enableClientScript' => true,
            'action' => $model->action_url,
            'validationUrl' => $model->action_validate_url,
        ]); ?>
        <div class="row Modal_form">
            <div class="col-md-6">
                <?= $form->field($model, 'logo', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->fileInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'business_name', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput(['placeholder' => 'Search by Business Name']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'register_comapany_name', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput(['maxlength' => true, 'placeholder' => 'Enter Registered Company Name', 'data-label' => 'Registered Name']) ?>
            </div>
            <!-- <div class="col-md-6">
                            <?= $form->field($model, 'category_id', [
                                'labelOptions' => ['class' => 'Modal_label']
                            ])->dropDownList(GeneralModel::operatorcategory(), ['prompt' => 'Select Category', 'data-label' => 'Category']) ?>
                        </div> -->
            <div class="col-md-6">
                <?= $form->field($model, 'address', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput(['maxlength' => true, 'placeholder' => 'Enter Address', 'data-label' => 'Address']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'park_id', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->widget(Select2::classname(), [
                    'data' => GeneralModel::safariparklist(),
                    'options' => ['placeholder' => 'Select Parks', 'data-label' => 'Parks', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Operates in Parks') ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'about_business', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textarea() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'website', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput(['maxlength' => true, 'placeholder' => 'This website will be visible to clients']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'phone_no', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'operator_phone_no', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput()  ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'email', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput(['maxlength' => true, 'placeholder' => 'yourbusiness@domain.com']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'operator_email', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput(['maxlength' => true, 'placeholder' => 'yourbusiness@domain.com']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'instagram_url', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput(['maxlength' => true, 'placeholder' => 'Instagram Profile Link']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'facebook_url', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput(['maxlength' => true, 'placeholder' => 'Facebook Profile Link']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'youtube_link', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textInput(['maxlength' => true, 'placeholder' => 'Youtube Profile Link']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'has_cancellation_policy', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->dropDownList(GeneralModel::yesnooption(), ['prompt' => 'Select']) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'offers_other_wildlifeactivities', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->checkboxList(
                    GeneralModel::wildlifeactivities(),
                    [
                        'required' => true,
                        // 'separator' => '<br>',
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                ) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'budget_segment', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->checkboxList(
                    GeneralModel::packageoption(),
                    [
                        'required' => true,
                        // 'separator' => '<br>',
                        'itemOptions' => ['class' => 'checkbox_design'],
                    ]
                ) ?>
            </div>

            <div class="col-md-12 pb-4">
                <div class="creat-safri float-end d-flex justify-content-end">
                    <?= $form->field($model, 'reCaptcha')->widget(\kekaadrenalin\recaptcha3\ReCaptchaWidget::class)->label(false) ?>
                    <?= $form->field($model, 'referrer_url')->hiddenInput()->label(false) ?>

                    <?= Html::submitButton('Save', ['class' => 'safari_create font_set px-5 py-2 w-auto']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>