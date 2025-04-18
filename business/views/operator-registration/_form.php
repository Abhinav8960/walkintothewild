<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\OperatorForm $model */

$this->registerCss(
    <<<CSS
.stepper {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}
.stepper-item {
    position: relative;
    width: 2.5rem;
    height: 2.5rem;
    line-height: 2.5rem;
    border-radius: 50%;
    background: #e0e0e0;
    text-align: center;
    font-weight: bold;
    z-index: 1;
    color: #555;
}
.stepper-item.active {
    background:rgb(4, 29, 10);
    color: #fff;
}
.stepper-item.completed {
    background:rgb(4, 29, 10);
    color: #fff;
    font-size: 1rem;
}
.stepper-line {
    flex: 1;
    height: 4px;
    background: #e0e0e0;
    margin: 0 -1px;
}
.stepper-line.filled {
    background:rgb(4, 29, 10);
}
.card-header {
    background: #f0f4f8;
    font-weight: bold;
}
CSS
);

$this->registerJs(
    <<<JS
function updateStepper(stepId) {
    $('.step').hide();
    $('#' + stepId).show();
    var current = parseInt(stepId.split('-')[1]);
    $('.stepper-item').each(function() {
        var idx = parseInt(this.id.split('-')[1]);
        $(this).removeClass('active completed').text(idx);
        if (idx < current) {
            $(this).addClass('completed').html('✔');
        } else if (idx === current) {
            $(this).addClass('active');
        }
    });
    $('.stepper-line').each(function(i) {
        if (i < current - 1) $(this).addClass('filled');
        else $(this).removeClass('filled');
    });
    $('#step-text').text('Step ' + current + '/4');
}

document.getElementById('kyc_detail').addEventListener('change', function() {
  const fileName = this.files[0] ? this.files[0].name : '';
  document.getElementById('kyc_detail_name').value = fileName;
});

$(document).ready(function() {
    updateStepper('step-1');
    $('.next-step').click(function(){ updateStepper($(this).data('next')); });
    $('.prev-step').click(function(){ updateStepper($(this).data('prev')); });
});
JS
);


?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<br>
<br>


<!-- Stepper -->
<div class="stepper">
    <div class="stepper-item" id="stepper-1"></div>
    <div class="stepper-line"></div>
    <div class="stepper-item" id="stepper-2"></div>
    <div class="stepper-line"></div>
    <div class="stepper-item" id="stepper-3"></div>
    <div class="stepper-line"></div>
    <div class="stepper-item" id="stepper-4"></div>
</div>
<p id="step-text" class="mb-4"></p>

<!-- Step 1 -->
<div id="step-1" class="step card mb-4">
    <div class="card-header">PERSONAL DETAILS</div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-6"><?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'phone_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'whatsap_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'dob')->input('date') ?></div>
            <div class="col-md-6"><?= $form->field($model, 'gender')->dropDownList(['Male' => 'Male', 'Female' => 'Female'], ['prompt' => 'Select']) ?></div>
            <div class="col-md-4">
                <label for="kyc_detail" class="form-label">KYC DETAILS</label>
                <div class="input-group">
                    <label class="btn btn-primary mb-0">
                        <i class="fas fa-cloud-upload-alt"></i> Choose
                        <input type="file"
                            id="kyc_detail"
                            name="OperatorForm[kyc_detail]"
                            class="d-none">
                    </label>
                    <input type="text"
                        id="kyc_detail_name"
                        class="form-control"
                        readonly
                        placeholder="No file chosen">
                </div>
                <div class="help-block text-danger"><?= Html::error($model, 'kyc_detail') ?></div>
            </div>

        </div>
        <div class="mt-4 d-flex justify-content-front">
            <?= Html::button('Next', ['class' => 'btn btn-primary next-step', 'data-next' => 'step-2']) ?>
        </div>
    </div>
</div>

<!-- Step 2 -->
<div id="step-2" class="step card mb-4">
    <div class="card-header">BUSINESS DETAILS</div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-4"><?= $form->field($model, 'business_registration_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'business_brand_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'business_full_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'business_phone_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'business_whatsap_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'business_email_id')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'business_logo_upload')->fileInput() ?></div>


            
            <div class="col-md-4"><?= $form->field($model, 'type_of_business')->dropDownList(['Manufacturing' => 'Manufacturing', 'Retail' => 'Retail', 'Service' => 'Service'], ['prompt' => 'Select']) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'business_doc_reg_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'business_kyc_detail')->fileInput() ?></div>

            <div class="col-md-4"><?= $form->field($model, 'business_operated_park')->dropDownList(['Park A' => 'Park A', 'Park B' => 'Park B'], ['prompt' => 'Select']) ?></div>
            <div class="col-md-12"><?= $form->field($model, 'business_detail')->textarea(['rows' => 3, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-4 d-flex align-items-center">
                <?= $form->field($model, 'gst')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])?>
                <?= Html::button('Add', ['class' => 'btn btn-warning ms-2']) ?>
            </div>
            
        </div>
        <div class="mt-4 d-flex justify-content-front">
            <?= Html::button('Previous', ['class' => 'btn btn-secondary prev-step', 'data-prev' => 'step-1']) ?>
            <?= Html::button('Next', ['class' => 'btn btn-primary ms-2 next-step', 'data-next' => 'step-3']) ?>
        </div>
    </div>
</div>

<!-- Step 3 -->
<div id="step-3" class="step card mb-4">
    <div class="card-header">BANK DETAILS</div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-6"><?= $form->field($model, 'bank_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'account_holder_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'account_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'ifsc_code')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'cancle_check')->fileInput() ?></div>

        </div>
        <div class="mt-4 d-flex justify-content-front">
            <?= Html::button('Previous', ['class' => 'btn btn-secondary prev-step', 'data-prev' => 'step-2']) ?>
            <?= Html::button('Next', ['class' => 'btn btn-primary ms-2 next-step', 'data-next' => 'step-4']) ?>
        </div>
    </div>
</div>

<!-- Step 4 -->
<div id="step-4" class="step card mb-4">
    <div class="card-header">UPLOAD DOCUMENTS</div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-6"><?= $form->field($model, 'upload_adhar_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>

            <div class="col-md-6"><?= $form->field($model, 'upload_aadhar_front')->fileInput() ?></div>


            <div class="col-md-6"><?= $form->field($model, 'upload_aadhar_back')->fileInput() ?></div>


            <div class="col-md-6"><?= $form->field($model, 'pan_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>

            <div class="col-md-6"><?= $form->field($model, 'pan_upload')->fileInput() ?></div>

            <div class="col-md-6"><?= $form->field($model, 'upload_registration_number')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>


            <!-- <div class="col-md-6"><?= $form->field($model, 'upload_registration_cert')->fileInput() ?></div> -->


            <div class="col-md-6"><?= $form->field($model, 'upload_document')->fileInput() ?></div>




        </div>
        <div class="mt-4 d-flex justify-content-front">
            <?= Html::button('Previous', ['class' => 'btn btn-secondary prev-step', 'data-prev' => 'step-3']) ?>
            <?= Html::submitButton('Submit All', ['class' => 'btn btn-success ms-2']) ?>
        </div>
    </div>
</div>

<!-- Step 5 -->


<?php ActiveForm::end(); ?>