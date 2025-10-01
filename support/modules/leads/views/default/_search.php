<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use yii\helpers\Html;
use yii\web\JsExpression;
use kartik\select2\Select2;


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


                <div class="filterItem position-relative bg-transparent">
                    <label>User:</label>
                    <?= $form->field($model, 'user_id')->widget(Select2::class, [
                        'initValueText' => $model->user_id ? GeneralModel::name_with_email($model->user_id) : '',
                        'options' => ['placeholder' => 'Select User', 'multiple' => false],
                        'pluginOptions' => [
                            'width' => '300px',
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'containerCssClass' => 'custom-select2', //adding custom css to select2 wigdet 
                            'ajax' => [
                                'url' => \yii\helpers\Url::toRoute(['user-list']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                                'processResults' => new JsExpression('function(data) { return { results: data.results }; }'),
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        ],
                    ]); ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

                <div class="filterItem position-relative">
                    <label>Operator:</label>
                    <?= $form->field($model, 'safari_operator_id')->dropDownList(
                        GeneralModel::operatorslist(),
                        [
                            'prompt' => 'Select Operator',
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

<style>
    .custom-select2 {
    border: none !important;
    outline: none !important;
    background: transparent !important;
    font-weight: 700 !important;
    color: #44444F !important;
    cursor: pointer !important;
    padding: 4px 50px 4px 8px !important;
    font-size: 16px !important;
}
.custom-select2 .select2-selection__placeholder {
    color: #44444F !important;
    font-weight: 600 !important;
    font-size: 16px !important;
}


</style>