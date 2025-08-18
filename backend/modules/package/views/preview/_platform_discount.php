<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>
<?php
$form = ActiveForm::begin(['id' => 'platform-discount-form']);
?>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'discount_type')->dropDownList(
            ['1' => 'In Percentage', '2' => 'In Value'],
            ['prompt' => 'Select Platform Discount Type', 'id' => 'discount_type']
        ) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'discount_in_percentage')->textInput([
            'id' => 'percentage_input',
            'placeholder' => 'Enter Percentage'
        ]) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'discount_in_value')->textInput([
            'id' => 'value_input',
            'placeholder' => 'Enter Value'
        ]) ?>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$script = <<<JS
    function toggleDiscountInputs() {
    var selected = $('#discount_type').val();
    if (selected == '1') {
        $('#percentage_input').closest('.mb-3').show();
        $('#value_input').closest('.mb-3').hide();
    } else if (selected == '2') {
        $('#percentage_input').closest('.mb-3').hide();
        $('#value_input').closest('.mb-3').show();
    } else {
        $('#percentage_input').closest('.mb-3').hide();
        $('#value_input').closest('.mb-3').hide();
    }
}

$('#discount_type').on('change', toggleDiscountInputs);
$(document).ready(function () {
    toggleDiscountInputs();
});
JS;
$this->registerJs($script);
?>
