<?php

use business\assets\AppAsset;
use common\models\partnerregistration\PartnerRegistration;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;

?>


<?php
$form = ActiveForm::begin([
    'id' => 'registration-proof',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'enableClientScript' => true,
    'options' => ['enctype' => 'multipart/form-data'],
    'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
]);
?>

<div class="row">
    <div class="col-md-5">
        <?= $form->field($model, 'registration_number')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Registration Number',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-5">
    <div class="d-flex align-items-center gap-3">
        <div class="flex-grow-1">
            <?= $form->field($model, 'registration_copy_file_upload')->fileInput([
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]) ?>
        </div>

        <?php if (!empty($model->registration_copy_upload)) { ?>
            <?= $form->field($model, 'registration_copy_upload')->hiddenInput(['id' => 'registration_copy_upload'])->label(false); ?>
            <a href="<?= Yii::$app->params['s3_endpoint'] . '/' . ltrim($model->registration_copy_upload, '/') ?>" target="_blank">
                <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="40" height="40">
            </a>
        <?php } ?>
    </div>
</div>



    <div class="col-md-5">
        <?= $form->field($model, 'pan_number')->textInput([
            'class' => 'form-control',
            'maxlength' => 10,
            'pattern' => '[A-Z]{5}[0-9]{4}[A-Z]',
            'title' => 'PAN must be in format AAAAA9999A',
            'oninput' => 'this.value = this.value.toUpperCase();',
            'placeholder' => 'Enter PAN number',
            'readonly' => $readOnly,
        ]) ?>
    </div>

  
    <div class="col-md-5">
        <div class="d-flex align-items-center gap-3">
            <div class="flex-grow-1">
                <?= $form->field($model, 'pan_file_upload')->fileInput([
                    'class' => 'form-control',
                    'disabled' => $readOnly,
                ]) ?>
            </div>
            <?php if (!empty($model->pan_upload)) { ?>
                <?= $form->field($model, 'pan_upload')->hiddenInput(['id' => 'pan_upload'])->label(false); ?>
                <a href="<?= Yii::$app->params['s3_endpoint'] . '/' . ltrim($model->pan_upload, '/') ?>" target="_blank">
                    <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="40" height="40">
                </a>
            <?php } ?>
        </div>
    </div>



</div>



<div class="d-flex justify-content-end mt-3">
    <?= Html::hiddenInput('step', $currentStep) ?>
    <?= $form->field($model, 'form2_status')->hiddenInput(['value' => 1])->label(false) ?>
    <?php if ($model->is_sendforapproval != 1 && ($model->form1_status == PartnerRegistration::FORM_FILLED && $model->form2_status == PartnerRegistration::FORM_FILLED && $model->form3_status == PartnerRegistration::FORM_FILLED && $model->form4_status == PartnerRegistration::FORM_FILLED && $model->form5_status == PartnerRegistration::FORM_FILLED)) { ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
    <?php } elseif ($model->form1_status == PartnerRegistration::FORM_REJECTED || $model->form2_status == PartnerRegistration::FORM_REJECTED || $model->form3_status == PartnerRegistration::FORM_REJECTED || $model->form4_status == PartnerRegistration::FORM_REJECTED || $model->form5_status == PartnerRegistration::FORM_REJECTED) { ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
    <?php } else { ?>
    <?= Html::submitButton('Save & Next', ['class' => 'btn btn-orange']) ?>
    <?php } ?>
</div>

<?php
ActiveForm::end();
?>