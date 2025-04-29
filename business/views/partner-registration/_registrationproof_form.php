<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>


<?php $form = ActiveForm::begin([
    'options' => ['id' => 'registration-proof',
    'enableClientValidation' => true, // Enable JavaScript validation
    'enctype' => 'multipart/form-data']
]); ?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'registration_number')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Registration Number',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?php
        if (!empty($model->registration_copy_upload)) {
        ?>
            <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->registration_copy_upload) ?>" alt="registration_copy_upload" style="max-height:50px; max-width:100px;">
            <?= $form->field($model, 'registration_copy_upload')->hiddenInput(['id' => 'registration_copy_upload'])->label(false); ?>
        <?php
        }
        ?>
        <?= $form->field($model,'registration_copy_file_upload')->fileInput([
            'class' => 'form-control',
            'disabled' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'pan_number')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter PAN number',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <?php
    if (!empty($model->pan_upload)) {
    ?>
        <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->logo) ?>" alt="Logo" style="max-height:100px;max-width:100px;">
        <?= $form->field($model, 'pan_upload')->hiddenInput(['id' => 'pan_upload'])->label(false); ?>
    <?php
    }
    ?>
    <div class="col-md-3">
        <?= $form->field($model, 'pan_file_upload')->fileInput([
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
?>