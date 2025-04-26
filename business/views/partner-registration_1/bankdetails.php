<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>



<?php
if ($model->form4_status == 1 || $model->form4_status == 2) {
    $this->title = 'Bank Details';
    $this->params['title'] = $this->title;
?>

    <div class="card">
        <?= $this->render('bankdetails-view', ['model' => $model]) ?>
    </div>

<?php
} elseif ($model->form4_status == 0 || $model->form4_status == 3) {
    $this->title = 'Bank Details';
    $this->params['title'] = $this->title;
?>
    <?php $form = ActiveForm::begin([
        'options' => ['id' => 'bank-details', 'action' => ['partner-registration/create'], 'enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'bank_name', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Bank Name',
                'readonly' => $readOnly,
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'account_holder_name', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Account Holder`s Name',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'account_number', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Account Number',
                'readonly' => $readOnly,
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ifsc_number', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter IFSC',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'cancel_check_upload', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->fileInput([
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]) ?>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <?= Html::hiddenInput('step', $currentStep) ?>
        <?= $form->field($model, 'form4_status')->hiddenInput(['value' => 1])->label(false) ?>
        <?= Html::submitButton('Next', ['class' => 'btn btn-info']) ?>
    </div>

<?php ActiveForm::end();
} ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>