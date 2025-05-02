<?php

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
            <img src="<?=  Yii::$app->params['s3_endpoint'] .'/'.$model->registration_copy_upload  ?>" alt="registration_copy_upload" style="max-height:50px; max-width:100px;">
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
            'maxlength' => 10,
            'pattern' => '[A-Z]{5}[0-9]{4}[A-Z]',
            'title' => 'PAN must be in format AAAAA9999A',
            'oninput' => "this.value = this.value.toUpperCase();",
            'placeholder' => 'Enter PAN number',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <?php
    if (!empty($model->pan_upload)) {
    ?>
        <img src="<?= Yii::$app->params['s3_endpoint'] .'/'.$model->pan_upload ?>" alt="Logo" style="max-height:100px;max-width:100px;">
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