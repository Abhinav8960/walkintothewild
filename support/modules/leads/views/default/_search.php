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
                <div class="filterItem position-relative">
                    <label>Source:</label>
                    <?= $form->field($model, 'source')->dropDownList(
                        GeneralModel::leadSource(),
                        [
                            'prompt' => 'All Source',
                            'class' => 'search-border'
                        ],
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>
                <div class="filterItem position-relative">
                    <label>Month:</label>
                    <?= $form->field($model, 'lead_month')->dropDownList(
                        GeneralModel::monthoption(),
                        [
                            'prompt' => 'All Month',
                            'class' => 'search-border'

                        ],
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>
                <div class="filterItem position-relative">
                    <label>Park:</label>
                    <?= $form->field($model, 'park_id')->dropDownList(
                        GeneralModel::operatorpark($safari_operator->id),
                        [
                            'prompt' => 'All Park',
                            'class' => 'search-border'

                        ],
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

                <div class="filterItem position-relative">
                    <label>Quotes Status:</label>
                    <?= $form->field($model, 'custom_status')->dropDownList(
                        [
                            '1' => 'Active',
                            '2' => 'Expired',
                        ],
                        [
                            // 'prompt' => 'Select Status',
                            'class' => 'search-border'

                        ],
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
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