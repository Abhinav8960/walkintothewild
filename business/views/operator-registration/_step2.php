<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
$readOnly = false;
if ($operator_model) {
    if ($operator_model->final == 1) {
        $readOnly = true;
    }
    if ($operator_model->final_approved == 2 && $operator_model->is_step_2_approved != 1) {
        $readOnly = false;
    } 
}
?>

<?= $this->render('stepper', ['currentStep' => 2]) ?>
<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(
            ['options' => ['enctype' => 'multipart/form-data']]
        ); ?>
        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'business_registration_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'business_brand_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'business_whatsap_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter', 'readOnly' => $readOnly]) ?></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="float-end w-auto gap-2">
                        <?= Html::a('Previous', ['create'], ['class' => 'btn btn-secondary']) ?>
                        <?= Html::submitButton('Next', ['class' => 'btn btn-info']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>