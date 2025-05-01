<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'user-kyc',
        'enableClientValidation' => true, // Enable JavaScript validation
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
        <?= $form->field($model, 'kyc_phone')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Phone Number',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'kyc_whatsapp')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Whatsapp Number',
            'readonly' => $readOnly,
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
            'placeholder' => 'Enter PAN',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'aadhar_number')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Aadhar',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'kyc_pan_file_upload')->fileInput([
            'class' => 'form-control',
            'disabled' => $readOnly,
        ]) ?>

        <?php
        if (!empty($model->kyc_pan_upload)) {
        ?>
            <img src="<?=  Yii::$app->params['s3_endpoint'] .'/'.$model->kyc_pan_upload ?>" alt="kyc_pan_upload" style="max-height:50px;max-width:100px;">
            <?= $form->field($model, 'kyc_pan_upload')->hiddenInput(['id' => 'kyc_pan_upload'])->label(false); ?>
        <?php
        }
        ?>
    </div>


    <div class="col-md-4 mt-5">
        <!-- <?= Html::checkbox('same_as_previous', false, [
                    'label' => 'Same as previous PAN details',
                    'id' => 'same-as-previous',
                ]) ?>
        <input type="hidden" id="prev-pan" value="<?= Html::encode($model->pan_number) ?>">
        <input type="hidden" id="prev-pan-upload" value="<?= Html::encode($model->pan_upload) ?>"> -->
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'aadhar_front_file_upload')->fileInput([
            'class' => 'form-control',
            'disabled' => $readOnly,
        ]) ?>


        <?php
        if (!empty($model->aadhar_front_upload)) {
        ?>
            <img src="<?=  Yii::$app->params['s3_endpoint'] .'/'.$model->aadhar_front_upload?>" alt="aadhar_front_upload" style="max-height:50px;max-width:100px;">
            <?= $form->field($model, 'aadhar_front_upload')->hiddenInput(['id' => 'aadhar_front_upload'])->label(false); ?>
        <?php
        }
        ?>
    </div>


    <div class="col-md-3">
        <?= $form->field($model, 'aadhar_back_file_upload')->fileInput([
            'class' => 'form-control',
            'disabled' => $readOnly,
        ]) ?>
    
    <?php
    if (!empty($model->aadhar_back_upload)) {
    ?>
        <img src="<?= Yii::$app->params['s3_endpoint'] .'/'.$model->aadhar_back_upload ?>" alt="aadhar_back_upload" style="max-height:50px;max-width:100px;">
        <?= $form->field($model, 'aadhar_back_upload')->hiddenInput(['id' => 'aadhar_back_upload'])->label(false); ?>
    <?php
    }
    ?>
    </div>


</div>

<div class="d-flex justify-content-end mt-3">
    <?= Html::hiddenInput('step', $currentStep) ?>
    <?= $form->field($model, 'form5_status')->hiddenInput(['value' => 1])->label(false) ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-info']) ?>
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