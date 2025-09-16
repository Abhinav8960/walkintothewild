<?php

use common\models\GeneralModel;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'email-form',
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<div class="row g-3">

    <div class="col-md-12">
        <div class="form_boxes mb-3">
            <label for="">Reminder Note</label>
            <?= $form->field($model, 'reminder_note')->textarea([
                'row' => 2,
                'placeholder' => 'Add Reminder Note',
                'style' => 'height:100px;'
            ])->label(false) ?>
        </div>
    </div>

    <!-- <div class="col-md-3">
            <div class="form_boxes mb-3">
                <label for="">Reminder Datetime</label>
                <?= $form->field($model, 'reminder_datetime')->textInput(['type' => 'date', 'min' => date('Y-m-d'), 'class' => 'form-control'])->label(false) ?>
            </div>
        </div> -->


    <div class="col-md-3">
        <div class="form_boxes mb-3">
            <label for="">Reminder DateTime</label>
            <?= $form->field($model, 'reminder_datetime')->widget(DatePicker::class, [
                'options' => [
                    'placeholder' => 'Select reminder date',
                    'class' => 'form-control'
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'startDate' => date('Y-m-d'),
                ],
            ])->label(false) ?>
        </div>
    </div>


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