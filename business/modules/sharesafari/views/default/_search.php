<?php


use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row mt-3">
    <div class="col-12">
        <div class="filterBar">
            <div class="filters">
                <div class="filterItem position-relative">
                    <label>Start Date:</label>
                    <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'class' => 'form-control search-border']); ?>
                </div>
                <div class="filterItem position-relative">
                    <label>End Date:</label>
                    <?= $form->field($model, 'end_date')->textInput(['type' => 'date', 'class' => 'form-control search-border']); ?>
                </div>
                <div class="filterItem position-relative">
                    <label>Cut off Date:</label>
                    <?= $form->field($model, 'cut_off_date')->textInput(['type' => 'date', 'class' => 'form-control search-border']); ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
    $('form') . on('change', function() {
        $(this) . closest('form') . submit();
    });  
JS;
$this->registerJs($js);
?>