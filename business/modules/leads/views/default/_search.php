<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;


?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'lead-search-form'
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row mb-2">
    <div class="col-md-2">
        <?= $form->field($model, 'source')->dropDownList(
            GeneralModel::leadSource(),
            [
                'prompt' => 'All Source',
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'park_id')->dropDownList(
            GeneralModel::safariparkoption(),
            [
                'prompt' => 'All Park',
            ]
        ) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>

<?php
$searchjs = <<<JS
$('#lead-search-form').on('change', function() {
    $(this).submit();
});
JS;
$this->registerJs($searchjs);
?>