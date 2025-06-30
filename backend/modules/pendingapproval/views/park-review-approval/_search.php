<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GeneralModel;
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


    <div class="col-md-2">
        <?= $form->field($model, 'park_id')->dropDownList(
            GeneralModel::safariparkoption(),
            [
                'prompt' => 'Select Park',
            ]
        ) ?>
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