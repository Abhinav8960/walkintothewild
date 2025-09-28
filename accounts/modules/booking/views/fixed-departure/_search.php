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

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'request_type')->dropDownList(['1' => 'Web', '2' => 'Mobile'], ['prompt' => 'Search by Request Type'])->label(false) ?>
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