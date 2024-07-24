<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;

?>


<?php
$this->title = $safari_operator->business_name . ' | Manage Operator Business';

?>

<div class="container-fluid mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h5><?= $this->title ?></h5>
        </div>
        <div class="col-md-2">
            <?= $this->render('_sidebar', ['active' => 'profile']); ?>
        </div>
        <div class="col-md-10">
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
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'logo')->fileInput() ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'business_name')->textInput(['placeholder' => 'Search by Business Name']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'register_comapany_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Registered Company Name', 'data-label' => 'Registered Name']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'category_id')->dropDownList(GeneralModel::operatorcategory(), ['prompt' => 'Select Category', 'data-label' => 'Category']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Enter Address', 'data-label' => 'Address']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'park_id')->widget(Select2::classname(), [
                                'data' => GeneralModel::safariparkoption(),
                                'options' => ['placeholder' => 'Safari Tour Operator, Wildlife Photographer...', 'data-label' => 'Parks', 'multiple' => true],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'about_business')->textarea() ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'placeholder' => 'This website will be visible to clients']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'phone_no')->textInput() ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'operator_phone_no')->textInput()  ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'yourbusiness@domain.com']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'operator_email')->textInput(['maxlength' => true, 'placeholder' => 'yourbusiness@domain.com']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'instagram_url')->textInput(['maxlength' => true, 'placeholder' => 'Instagram Profile Link']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'facebook_url')->textInput(['maxlength' => true, 'placeholder' => 'Facebook Profile Link']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'youtube_link')->textInput(['maxlength' => true, 'placeholder' => 'Youtube Profile Link']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'has_cancellation_policy')->dropDownList(GeneralModel::yesnooption(), ['prompt' => 'Select']) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'offers_other_wildlifeactivities')->checkboxList(
                                GeneralModel::wildlifeactivities(),
                                [
                                    'required' => true,
                                    // 'separator' => '<br>',
                                    'itemOptions' => ['class' => 'checkbox_design'],
                                ]
                            ) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'budget_segment')->checkboxList(
                                GeneralModel::packageoption(),
                                [
                                    'required' => true,
                                    // 'separator' => '<br>',
                                    'itemOptions' => ['class' => 'checkbox_design'],
                                ]
                            ) ?>
                        </div>




                    </div>
                    <br>
                    <div class="row">


                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $form->field($model, 'reCaptcha')->widget(\kekaadrenalin\recaptcha3\ReCaptchaWidget::class)->label(false) ?>
                                <?= $form->field($model, 'referrer_url')->hiddenInput()->label(false) ?>

                                <?= Html::submitButton('Save', ['class' => 'btn btn_newsafari organizeBtn']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <?= $this->render('_previous_request', ['dataProvider' => $dataProvider]) ?>
        </div>
    </div>
</div>