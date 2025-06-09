<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'user-kyc',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'enableClientScript' => true,
        'action' => $model->action_url,
        'validationUrl' => $model->action_validate_url,
        'enctype' => 'multipart/form-data'
    ]
]); ?>


<div class="row">

    <div class="col-md-3">
        <?= $form->field($model, 'owner_name')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Owner Name',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?php $verificationIcon = $model->is_kyc_phone_verified ? ' <i class="bi bi-patch-check-fill text-success fs-6 ms-2"></i>' : ''; ?>
        <?= $form->field($model, 'kyc_phone')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Phone Number',
            'readonly' => $readOnly,
            'onkeypress' => 'return /[0-9]/i.test(event.key)',
        ])->label('Phone Number'.$verificationIcon) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'kyc_whatsapp')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Whatsapp Number',
            'readonly' => $readOnly,
            'onkeypress' => 'return /[0-9]/i.test(event.key)',
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'kyc_email')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Email',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'kyc_pan')->textInput([
            'class' => 'form-control',
            'maxlength' => 10,
            'oninput' => "this.value = this.value.toUpperCase();",
            'placeholder' => 'Enter PAN',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'aadhar_number')->textInput([
            'class' => 'form-control',
            'maxlength' => 12,
            'minlength' => 12,
            'pattern' => '[2-9]{1}[0-9]{11}',
            'title' => 'Aadhaar number must be 12 digits and start with 2–9',
            'oninput' => "this.value = this.value.replace(/[^0-9]/g, '');",
            'placeholder' => 'Enter Aadhaar',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-6">
        <div class="d-flex align-items-center gap-3">
            <div class="flex-grow-1">
                <?= $form->field($model, 'kyc_pan_file_upload')->fileInput([
                    'class' => 'form-control',
                    'disabled' => $readOnly,
                ]) ?>
            </div>
                <?php if (!empty($model->kyc_pan_upload)) { ?>
                    <?= $form->field($model, 'kyc_pan_upload')->hiddenInput(['id' => 'kyc_pan_upload'])->label(false); ?>
                    <a href="<?= $model->kyc_pan_upload_path ?>" target="_blank">
                        <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="40" height="40">
                    </a>
                <?php } ?>
        </div>
    </div>


    <div class="col-md-4 mt-5">
        <!-- <?= Html::checkbox('same_as_previous', false, [
                    'label' => 'Same as previous PAN details',
                    'id' => 'same-as-previous',
                ]) ?>
        <input type="hidden" id="prev-pan" value="<?= Html::encode($model->pan_number) ?>">
        <input type="hidden" id="prev-pan-upload" value="<?= Html::encode($model->pan_upload) ?>"> -->
    </div>

    <div class="col-md-6">
        <div class="d-flex align-items-center gap-3">
            <div class="flex-grow-1">
                <?= $form->field($model, 'aadhar_front_file_upload')->fileInput([
                    'class' => 'form-control',
                    'disabled' => $readOnly,
                ]) ?>

            </div>
            <?php if (!empty($model->aadhar_front_upload)) { ?>
                <?= $form->field($model, 'aadhar_front_upload')->hiddenInput(['id' => 'aadhar_front_upload'])->label(false); ?>
                    <a href="<?= $model->aadhar_front_upload_path ?>" target="_blank">
                        <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="40" height="40">
                    </a>
                <?php } ?>
        </div>
    </div>


    <div class="col-md-6">
        <div class="d-flex align-items-center gap-3">
            <div class="flex-grow-1">
                <?= $form->field($model, 'aadhar_back_file_upload')->fileInput([
                    'class' => 'form-control',
                    'disabled' => $readOnly,
                ]) ?>

            </div>
            <?php if (!empty($model->aadhar_back_upload)) { ?>
                <?= $form->field($model, 'aadhar_back_upload')->hiddenInput(['id' => 'aadhar_back_upload'])->label(false); ?>
                    <a href="<?= $model->aadhar_back_upload_path ?>" target="_blank">
                        <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="40" height="40">
                    </a>
                <?php } ?>
        </div>
    </div>


</div>

<div class="d-flex justify-content-end mt-3">
    <?= Html::hiddenInput('step', $currentStep) ?>
    <?= $form->field($model, 'form5_status')->hiddenInput(['value' => 1])->label(false) ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
</div>

<?php ActiveForm::end(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
// $js = <<<JS
// $('#same-as-previous').on('change', function() {
//     if ($(this).is(':checked')) {
//         let prevPan = $('#prev-pan').val();
//         let prevPanUpload = $('#prev-pan-upload').val();
//         $('#partnerregistrationform-kyc_pan').val(prevPan).prop('readonly', true);        
//         $('#partnerregistrationform-kyc_pan_upload').prop('disabled', true);
//         $('#partnerregistrationform-kyc_pan_upload').after('<div class="text-muted mt-1">Previous file will be reused.</div>');
//     } else {
//         $('#partnerregistrationform-kyc_pan').val('').prop('readonly', false);
//         $('#partnerregistrationform-kyc_pan_upload').prop('disabled', false);
//         $('.text-muted').remove();
//     }
// });
// JS;

// $this->registerJs($js);
// 
?>