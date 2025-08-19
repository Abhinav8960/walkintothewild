<?php

use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],
]); ?>

<div class="row">

    <h5>Basic Details</h5>

    <div class="col-md-6">
        <div class="form_boxes mb-3">
        <label for="">Operator Name<span>*</span></label>
            <?= $form->field($model, 'operator_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Operator Name'])->label(false) ?>
        </div>
    </div>


    <div class="col-md-6">
        <div class="form_boxes mb-3">
            <label for="">Select Park<span>*</span></label>
            <div class="select2-angle-wrapper position-relative">
                <?= $form->field($model, 'park_list')->widget(\kartik\select2\Select2::classname(), [
                    'theme' => \kartik\select2\Select2::THEME_KRAJEE,
                    'data' => GeneralModel::safariparklist(),
                    'options' => [
                        'multiple' => true,
                        'autocomplete' => 'off',
                    ],
                    'pluginOptions' => [
                        'placeholder' => 'Open this select menu',

                    ],
                ])->label(false) ?>
                <i class="fa fa-angle-down select2-angle-icon"></i>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="form_boxes mb-3">
        <label for="">Phone Number<span>*</span></label>
            <?= $form->field($model, 'phone_no')->textInput(['maxlength' => 10, 'placeholder' => 'Enter Operator Phone Number'])->label(false) ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form_boxes mb-3">
        <label for="">Email<span>*</span></label>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Enter Operator Email'])->label(false) ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form_boxes mb-3">
        <label for="">Website<span></span></label>
            <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'placeholder' => 'Enter Operator Website'])->label(false) ?>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form_boxes mb-3">
        <label for="">Address<span>*</span></label>
            <?= $form->field($model, 'address')->textarea(['placeholder' => 'Enter Address'])->label(false) ?>
        </div>
    </div>

    <hr>

    <h5>Owner Details</h5>

    <div class="col-md-4">
        <div class="form_boxes mb-3">
        <label for="">Owner Name<span>*</span></label>
            <?= $form->field($model, 'owner_name')->textInput(['placeholder' => 'Owner Name'])->label(false) ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form_boxes mb-3">
        <label for="">Owner Email<span>*</span></label>
            <?= $form->field($model, 'owner_email')->textInput(['placeholder' => 'Owner Email'])->label(false) ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form_boxes mb-3">
        <label for="">Owner Phone Number<span>*</span></label>
            <?= $form->field($model, 'owner_phone_no')->textInput(['placeholder' => 'Owner Phone Number'])->label(false) ?>
        </div>
    </div>

    <hr>

    <h5>Other Details</h5>

    <div class="col-md-3">
        <div class="form_boxes mb-3">
        <label for="">Traffic<span></span></label>
            <?= $form->field($model, 'traffic')->textInput(['placeholder' => 'Traffic'])->label(false) ?>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form_boxes mb-3">
        <label for="">Engagement<span></span></label>
            <?= $form->field($model, 'engagement')->textInput(['placeholder' => 'Engagement'])->label(false) ?>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form_boxes mb-3">
        <label for="">SEO Performance<span></span></label>
            <?= $form->field($model, 'seo_performance')->textInput(['placeholder' => 'SEO Performance'])->label(false) ?>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form_boxes mb-3">
        <label for="">Google Rating<span></span></label>
            <?= $form->field($model, 'google_rating')->textInput(['placeholder' => 'Google Rating'])->label(false) ?>
        </div>
    </div>


    <?php if ($model->externaloperator_model->id) { ?>
        <div class="col-md-4">
            <div class="form_boxes mb-3">
            <label for="">Status<span>*</span></label>
                <?= $form->field($model, 'status')->dropDownList(GeneralModel::newstatusoption(), ['prompt' => 'Select Status']) ?>
            </div>
        </div>
    <?php } ?>

    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>
<style>
    .ck-editor__editable {
        min-height: 450px;
    }


    .select2-angle-wrapper {
        position: relative;
    }

    .select2-angle-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #888;
        font-size: 16px;
    }
</style>
<?php
$script = <<< JS
editor('compliancedocumentsform-description');
JS;
$this->registerJs($script);
?>