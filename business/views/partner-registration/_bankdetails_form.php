<?php

use common\models\partnerregistration\PartnerRegistration;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'bank-details', 
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'enableClientScript' => true,
    'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
     'enctype' => 'multipart/form-data']
]); ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'bank_name')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Bank Name',
            'readonly' => $readOnly,
        ]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'account_holder_name')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Account Holder`s Name',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'account_number')->textInput([
            'class' => 'form-control',
            'maxlength' => 18,
            'pattern' => '[0-9]{9,18}',
            'title' => 'Enter a valid account number (9–18 digits)',
            'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
            'placeholder' => 'Enter Account Number',
            'readonly' => $readOnly,
        ]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'ifsc_number')->textInput([
            'class' => 'form-control',
            'maxlength' => 11,
            'pattern' => '[A-Z]{4}0[A-Z0-9]{6}',
            'title' => 'IFSC should be 11 characters: 4 letters, 0, then 6 alphanumeric (e.g., HDFC0001234)',
            'oninput' => "this.value = this.value.toUpperCase();",
            'placeholder' => 'Enter IFSC',
            'readonly' => $readOnly,
        ]) ?>
    </div>


    <div class="col-md-5">
            <div class="d-flex align-items-center gap-3">
                <div class="flex-grow-1">
                    <?= $form->field($model, 'cancel_check_file_upload')->fileInput([
                        'class' => 'form-control',
                        'disabled' => $readOnly,
                    ]) ?>
                </div>

                <?php if (!empty($model->cancel_check_upload_path)) { ?>
                    <?= $form->field($model, 'cancel_check_upload')->hiddenInput(['id' => 'cancel_check_upload'])->label(false); ?>
                    <a href="<?= $model->cancel_check_upload_path ?>" target="_blank">
                        <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="40" height="40">
                    </a>
                <?php } ?>
            </div>
    </div>
</div>

<div class="d-flex justify-content-end mt-3">
    <?= Html::hiddenInput('step', $currentStep) ?>
    <?= $form->field($model, 'form4_status')->hiddenInput(['value' => 1])->label(false) ?>
    <?php if($model->is_sendforapproval != 1 && ($model->form1_status == PartnerRegistration :: FORM_FILLED && $model->form2_status == PartnerRegistration :: FORM_FILLED && $model->form3_status == PartnerRegistration :: FORM_FILLED && $model->form4_status == PartnerRegistration :: FORM_FILLED && $model->form5_status == PartnerRegistration :: FORM_FILLED)){ ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
    <?php }elseif($model->form1_status == PartnerRegistration :: FORM_REJECTED || $model->form2_status == PartnerRegistration :: FORM_REJECTED || $model->form3_status == PartnerRegistration :: FORM_REJECTED || $model->form4_status == PartnerRegistration :: FORM_REJECTED || $model->form5_status == PartnerRegistration :: FORM_REJECTED){?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
    <?php }else{?>
    <?= Html::submitButton('Save & Next', ['class' => 'btn btn-orange']) ?>
    <?php }?>

</div>

<?php ActiveForm::end(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>