<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>

    <?php $form = ActiveForm::begin([
        'options' => ['id' => 'bank-details',  'enctype' => 'multipart/form-data']
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
                'placeholder' => 'Enter Account Number',
                'readonly' => $readOnly,
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ifsc_number')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter IFSC',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'cancel_check_upload')->fileInput([
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

<?php ActiveForm::end();?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>