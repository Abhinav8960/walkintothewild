<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use yii\helpers\Html;

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
<div class="row">
    <div class="col-12 mb-3">
        <div class="filterBar">
            <div class="filters">
                <div class="filterItem">
                    <label>Source:</label>
                    <?= $form->field($model, 'source')->dropDownList(
                        GeneralModel::leadSource(),
                        [
                            'prompt' => 'All Source',
                        ],
                    ) ?>
                </div>
                <div class="filterItem">
                    <label>Park:</label>
                    <?= $form->field($model, 'park_id')->dropDownList(
                        GeneralModel::operatorpark($safari_operator->id),
                        [
                            'prompt' => 'All Park',
                        ],
                    ) ?>
                </div>
                <div class="filterItem">
                    <label>Month:</label>
                    <?= $form->field($model, 'lead_month')->dropDownList(
                        GeneralModel::monthoption(),
                        [
                            'prompt' => 'All Month',
                        ],
                    ) ?>
                </div>
            </div>
        </div>
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