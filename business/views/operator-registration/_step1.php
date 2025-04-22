<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = isset($operator_model) && in_array($operator_model->is_step_1_approved, [1, 2]);

?>

<?= $this->render('stepper', ['currentStep' => 1]) ?>

<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(
            ['options' => [
                'id' => 'step-1',
                'enctype' => 'multipart/form-data'
            ]]
        ); ?>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'phone_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'whatsap_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>
            <div class="col-md-6">
                <?= $form->field($model, 'dob')->input('date', ['readOnly' => $readOnly]) ?>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="float-end w-auto gap-2">
                        <?= Html::submitButton('Next', ['class' => 'btn btn-info']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>