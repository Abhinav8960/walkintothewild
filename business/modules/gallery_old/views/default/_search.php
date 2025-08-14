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

<div class="filter-areaParent">
    <div class="shortList-wrapper">
        <div class="shortList d-flex gap-5 align-items-center border">
            <span id="dropdown-selected-text">
                <?= isset($model->custom_filter) && $model->custom_filter == 1 ? "Created Recently" : ($model->custom_filter == 2 ? "Most Images" : "Sort") ?>
            </span>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
        </div>

        <div class="shortList-dropdown dropdown" style="display: none;">
            <p data-value="1">Created Recently</p>
            <p data-value="2">Most Images</p>
        </div>

        
        <?= $form->field($model, 'custom_filter')->dropDownList(
            ['1' => 'Created Recently', '2' => 'Most Images'],
            [
                'prompt' => 'Select Status',
                'class' => 'search-border d-none',
                'id' => 'real-status-select'
            ]
        )->label(false) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$js = <<<JS

$('.shortList').on('click', function() {
    $('.shortList-dropdown').toggle();
});


$('.shortList-dropdown p').on('click', function() {
    var selectedText = $(this).text();
    var selectedValue = $(this).data('value');

    $('#dropdown-selected-text').text(selectedText);
    $('#real-status-select').val(selectedValue).trigger('change');
    $('.shortList-dropdown').hide();
});


$('#real-status-select').on('change', function() {
    $('#Searchform').submit();
});
JS;

$this->registerJs($js);
?>
