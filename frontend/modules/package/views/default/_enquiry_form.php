<?php

use kartik\datetime\DateTimePicker;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'id' => 'package-enquiry-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],
]); ?>
<div class="row ">
    <div class="col-lg-4 mb-3">
        <div class="form-wrapper d-flex gap-3">
            <div class="input-group2">
                <label for="travelers">Travelers</label>
                <div class="number-input position-relative">
                    <?= $form->field($model, 'no_of_travelers')->textInput(['type' => 'number', 'min' => 1, 'class' => 'form-control'])->label(false); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-3">
        <div class="form-wrapper">
            <label for="">Start Date</label>
            <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label(false); ?>
        </div>
    </div>
    <div class="col-lg-4 mb-3">
        <div class="form-wrapper">
            <label for="">End Date</label>
            <?= $form->field($model, 'end_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label(false); ?>
        </div>
    </div>
    <div class="col-lg-12 mb">
        <div class="form-wrapper mb-3">
            <label for="">Full Name</label>
            <?= $form->field($model, 'name')->textInput(['placeholder' => 'xyz', 'class' => 'form-control'])->label(false); ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-wrapper mb-3">
            <label for="">Email Address</label>
            <?= $form->field($model, 'email_address')->textInput(['placeholder' => 'xyz@abc.com', 'class' => 'form-control'])->label(false); ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-wrapper mb-3">
            <label for="">Phone Number</label>
            <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Enter Number', 'class' => 'form-control'])->label(false); ?>
        </div>
    </div>
</div>
<div class="row align-items-center">
    <div class="col-md-7">
        <div class="text_get termsConditioncheck d-flex gap-2">
            <input type="checkbox" id="chekcs" required>
            <label for="chekcs">I agree to the terms and conditions.</label>
        </div>
    </div>
    <div class="col-md-5  pt-lg-0 pt-3">
        <?= Html::submitButton('Send Request', ['class' => 'sent_btn']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>