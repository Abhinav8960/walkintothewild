<?php

use common\models\GeneralModel;
use Google\Service\CloudSearch\DateTimePicker;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'email-form',
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<div class="row g-3">

    <?php if ($model->id) { ?>
        <div class="col-md-12">
            <div class="form_boxes mb-3"> 
                <label for="">Reminder Note</label>
                <?= $form->field($reminderModel, 'reminder_note')->textarea([
                    'row' => 2,
                    'placeholder' => 'Add Reminder Note',
                    'style'=>'height:100px;'
                ])->label(false) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form_boxes mb-3">
                <label for="">Reminder Status</label>
                <?= $form->field($reminderModel, 'reminder_status')->dropDownList(
                    GeneralModel::reminderstatusoption(),
                    ['prompt' => 'Select Reminder Status', 'class' => 'form-select']
                )->label(false) ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form_boxes mb-3">
                <label for="">Reminder Datetime</label>
                <?= $form->field($reminderModel, 'reminder_datetime')->textInput(['type' => 'date', 'min' => date('Y-m-d'), 'class' => 'form-control'])->label(false) ?>
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