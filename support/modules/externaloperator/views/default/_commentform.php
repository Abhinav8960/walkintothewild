<?php

use common\models\externaloperator\ExternalOperator;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'email-form',
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<div class="row g-3">

    <?php if ($model->externaloperator_model->id) { ?>
        <div class="col-md-12">
            <div class="form_boxes mb-3">
                <label for="">Comment<span>*</span></label>
                <?= $form->field($model, 'comment')->textInput(['maxlength' => true, 'placeholder' => 'Enter your Comment'])->label(false) ?>
            </div>
        </div>
    <?php } ?>
    <hr>
    <div class="col-12">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success text-white px-4']) ?>
    </div>

</div>

<?php ActiveForm::end(); ?>

<style>
    .ck-editor__editable {
        min-height: 450px;
    }
</style>

<?php
$script = <<<JS
editor('compliancedocumentsform-description');
JS;
$this->registerJs($script);
?>