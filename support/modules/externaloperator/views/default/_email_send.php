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

    <?php if ($model->id){ ?>
        <div class="col-md-6">
            <?= $form->field($model, 'is_mail_send')->dropDownList(
                ExternalOperator::emailstatusoption(),
                ['prompt' => 'Select Email Status', 'class' => 'form-select']
            )->label('Edit Email Status') ?>
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
