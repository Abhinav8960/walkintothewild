<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'action' => ['index'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'type')->dropDownList(
            ['1' => 'Blog Flag', '2' => 'Operator Flag', '3' => 'Package Flag', '4' => 'Shared Safari Flag', '5' => 'Article Flag'],
            [
                'prompt' => 'Select Option',
            ]
        ) ?>
    </div>
    <!-- <div class="col-md-2">
        <?= $form->field($model, 'comment')->textInput(['placeholder' => 'Search by Comments']) ?>
    </div> -->
   
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