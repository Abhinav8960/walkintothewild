<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = $operator_model->is_step_3_approved == 1 || $operator_model->is_step_3_approved == 2
?>
<?= $this->render('stepper', ['currentStep' => 3]) ?>
<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(
            ['options' => ['enctype' => 'multipart/form-data']]
        ); ?>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'bank_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'account_holder_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'account_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'ifsc_code')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="float-end w-auto gap-2">
                        <?= Html::a('Previous', ['step-2'], ['class' => 'btn btn-secondary']) ?>
                        <?= Html::submitButton('Next', ['class' => 'btn btn-info']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>