<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>
<?= $this->render('stepper', ['currentStep' => 4]) ?>

<?php $form = ActiveForm::begin(
    ['options' => ['enctype' => 'multipart/form-data']]
); ?>
<div class="row">
    <div class="col-md-6"><?= $form->field($model, 'upload_adhar_no')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?></div>

    <div class="row">
        <div class="col-md-12">
            <div class="float-end w-auto gap-2">
                <?= Html::a('Previous', ['step-3'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton('Submit Form', ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>