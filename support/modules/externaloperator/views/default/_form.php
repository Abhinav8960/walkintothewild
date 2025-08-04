<?php

use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <h5>Basic Details</h5>


    <div class="col-md-4">
        <?= $form->field($model, 'operator_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Operator Name'])->label('Operator Name <span class="necessary">*</span>') ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'park_list')->widget(Select2 :: class,
            [
                'data' => GeneralModel::safariparklist(),
                'options' => ['placeholder' => 'Select Park', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'class' => 'form-control',
            ]
        )->label('Operator Name <span class="necessary">*</span>') ?>
    </div>


    <div class="col-md-3">
        <?= $form->field($model, 'phone_no')->textInput(['maxlength' => 10, 'placeholder' => 'Enter Operator Phone Number'])->label('Operator Phone <span class="necessary">*</span>') ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Enter Operator Email'])->label('Operator Email <span class="necessary">*</span>') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'placeholder' => 'Enter Operator Website'])->label('Website <span class="necessary">*</span>') ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'address')->textarea(['rows' => '4', 'placeholder' => 'Enter Address'])->label('Address <span class="necessary">*</span>') ?>
    </div>

    <hr>

    <h5>Owner Details</h5>


    <div class="col-md-4">
        <?= $form->field($model, 'owner_name')->textarea(['placeholder' => 'Owner Name'])->label('Owner Name <span class="necessary">*</span>') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'owner_email')->textarea(['placeholder' => 'Owner Email'])->label('Owner Email  <span class="necessary">*</span>') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'owner_phone_no')->textarea(['placeholder' => 'Owner Phone Number'])->label('Owner Phone Number  <span class="necessary">*</span>') ?>
    </div>


    <hr>

    <h5>Other Details</h5>


    <div class="col-md-3">
        <?= $form->field($model, 'traffic')->textarea(['placeholder' => 'Traffic'])->label('Traffic <span class="necessary">*</span>') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'engagement')->textarea(['placeholder' => 'Engagement'])->label('Engagement <span class="necessary">*</span>') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'seo_performance')->textarea(['placeholder' => 'SEO Performance'])->label('SEO Performance <span class="necessary">*</span>') ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'google_rating')->textarea(['placeholder' => 'Google Rating'])->label('Google Rating <span class="necessary">*</span>') ?>
    </div>


    <?php if ($model->externaloperator_model->id) { ?>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(GeneralModel::newstatusoption(), ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>


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
</style>
<?php
$script = <<< JS
editor('compliancedocumentsform-description');
JS;
$this->registerJs($script);
?>