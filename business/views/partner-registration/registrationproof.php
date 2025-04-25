<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>

<?php
if ($model->form2_status == 1 || $model->form2_status == 2) {
    $this->title = 'Registration Proof';
    $this->params['title'] = $this->title;
?>

    <div class="card">
        <?= $this->render('registrationproof-view', ['model' => $model]) ?>
    </div>

<?php
} elseif ($model->form2_status == 0 || $model->form2_status == 3) {
    $this->title = 'Registration Proof';
    $this->params['title'] = $this->title;
?>

    <?php $form = ActiveForm::begin([
        'options' => ['id' => 'registration-proof', 'action' => ['partner-registration/create'], 'enctype' => 'multipart/form-data']
    ]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'registration_number', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Registration Number',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'registration_copy_upload', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->fileInput([
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'pan_number', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter PAN number',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'pan_upload', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->fileInput([
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]) ?>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-3">
        <?= Html::hiddenInput('step', $currentStep) ?>
        <?= $form->field($model, 'form2_status')->hiddenInput(['value' => 1])->label(false) ?>
        <?= Html::submitButton('Next', ['class' => 'btn btn-info']) ?>
    </div>

<?php ActiveForm::end();
} ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>