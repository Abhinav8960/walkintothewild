<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>

<?php
if ($model->form5_status == 1 || $model->form5_status == 2) {
    $this->title = 'User KYC';
    $this->params['title'] = $this->title;
?>
    <div class="card">
        <?= $this->render('userkyc-view', ['model' => $model]) ?>
    </div>

<?php
} elseif ($model->form5_status == 0 || $model->form5_status == 3) {
    $this->title = 'User KYC';
    $this->params['title'] = $this->title;
?>
    <?php $form = ActiveForm::begin([
        'options' => ['id' => 'user-kyc', 'action' => ['partner-registration/create'], 'enctype' => 'multipart/form-data']
    ]); ?>


    <div class="row">

        <div class="col-md-3">
            <?= $form->field($model, 'owner_name', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Owner Name',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'kyc_phone', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Phone Number',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'kyc_whatsapp', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Whatsapp Number',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'kyc_email', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Email',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'kyc_pan', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter PAN',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'kyc_pan_upload', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->fileInput([
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4 mt-5">
            <?= Html::checkbox('same_as_previous', false, [
                'label' => 'Same as previous PAN details',
                'id' => 'same-as-previous',
            ]) ?>
             <input type="hidden" id="prev-pan" value="<?= Html::encode($model->pan_number) ?>">
             <input type="hidden" id="prev-pan-upload" value="<?= Html::encode($model->pan_upload) ?>">
        </div>
       



        <div class="col-md-4">
            <?= $form->field($model, 'aadhar_number', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Aadhar',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'aadhar_front_upload', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->fileInput([
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'aadhar_back_upload', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->fileInput([
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]) ?>
        </div>



    </div>


    <div class="d-flex justify-content-end mt-3">
        <?= Html::hiddenInput('step', $currentStep) ?>
        <?= $form->field($model, 'form5_status')->hiddenInput(['value' => 1])->label(false) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-info']) ?>
    </div>

<?php ActiveForm::end();
} ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
$js = <<<JS
$('#same-as-previous').on('change', function() {
    if ($(this).is(':checked')) {
        let prevPan = $('#prev-pan').val();
        let prevPanUpload = $('#prev-pan-upload').val();
        $('#partnerregistrationform-kyc_pan').val(prevPan).prop('readonly', true);        
        $('#partnerregistrationform-kyc_pan_upload').prop('disabled', true);
        $('#partnerregistrationform-kyc_pan_upload').after('<div class="text-muted mt-1">Previous file will be reused.</div>');
    } else {
        $('#partnerregistrationform-kyc_pan').val('').prop('readonly', false);
        $('#partnerregistrationform-kyc_pan_upload').prop('disabled', false);
        $('.text-muted').remove();
    }
});
JS;

$this->registerJs($js);
?>
