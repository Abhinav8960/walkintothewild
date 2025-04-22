<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<?= $this->render('stepper', ['currentStep' => 1]) ?>

<?php $form = ActiveForm::begin(
    ['options' => [
        'id' => 'step-1',
        'enctype' => 'multipart/form-data'
    ]]
); ?>
<div class="row">
    <div class="col-md-6"><?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
    <div class="col-md-6"><?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
    <div class="col-md-6"><?= $form->field($model, 'phone_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
    <div class="col-md-6"><?= $form->field($model, 'whatsap_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>
    <div class="col-md-6"><?= $form->field($model, 'dob',)->input('date',) ?></div>
    <div class="row">
        <div class="col-md-12">
            <div class="float-end w-auto gap-2">
                <?= Html::submitButton('Next', ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>