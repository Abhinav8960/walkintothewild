<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['id' => 'action-form']); ?>
<div class="row">
    <div class="col-md-12 d-flex gap-2">
        <div class="col-md-6">
            <?= $form->field($model, 'payment_received_at_bank')->checkbox()->label('Payment Received At Bank') ?>
        </div>
    </div>


    <div class="col-md-12 d-flex gap-2">
        <div class="col-md-6">
            <?= $form->field($model, 'amount_received_at_bank')->textInput(['type' => 'number', 'placeholder' => 'Enter Amount Received At Bank'])->label('Amount Received At Bank') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'payu_charges')->textInput(['type' => 'number', 'placeholder' => 'Enter PayU Charges'])->label('PayU Charges') ?>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-info text-white']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
