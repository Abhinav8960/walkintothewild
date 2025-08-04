<?php
use common\models\externaloperator\ExternalOperator;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'id' => 'call-form',
]); ?>

<div class="row g-3">

    <?php if ($model->id){ ?>
        <div class="col-md-6">
            <?= $form->field($model, 'is_call_done')->dropDownList(
                ExternalOperator::callstatusoption(),
                ['prompt' => 'Select Call Status', 'class' => 'form-select']
            )->label('Edit Call Status') ?>
        </div>
    <?php } ?>

    <hr>

    <div class="col-12">
        <?= Html::submitButton('Save', [
            'class' => 'btn btn-success text-white px-4',
        ]) ?>
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
