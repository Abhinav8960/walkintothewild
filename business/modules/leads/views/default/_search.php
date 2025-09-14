<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;

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


                <!-- <div class="filterItem position-relative">
                    <label>Month:</label>
                    <?= $form->field($model, 'lead_month')->dropDownList(
                        GeneralModel::monthoption(),
                        [
                            'prompt' => 'All Month',
                            'class' => 'search-border'

                        ],
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div> -->


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

                <div class="filterItem position-relative">
                    <label>Lead Category:</label>
                    <?= $form->field($model, 'lead_category')->dropDownList(
                        [
                            '0' => 'Not in Use',
                            '1' => 'Hot Lead',
                            '-1' => 'Cold Lead',
                        ],
                        [
                            'prompt' => 'Select Lead Category',
                            'class' => 'search-border'
                        ],
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>
            </div>
        </div>

        <div class="filterBar">
            <div class="filters">
                <div class="filterItem position-relative">
                    <label>User:</label>
                    <?= $form->field($model, 'user_name')->textInput(['placeholder' => 'Enter User Name', 'class' => 'custom_input'])->label(false); ?>
                </div>

                <div class="filterItem position-relative">
                    <label>Travel Date:</label>

                    <div class="filter-one d-flex gap-2">
                        <!-- <span>From:</span> -->
                        <?= $form->field($model, 'from_date')->input('date')->label(false) ?>
                    </div>

                    <div class="filter-one d-flex gap-2">
                        <!-- <span>To:</span> -->
                        <?= $form->field($model, 'to_date')->input('date')->label(false) ?>
                    </div>
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
    .custom_input {
        border: 1px solid #e7eaedff;
        border-radius: 0.25rem;
        height: 38px;
        padding: 6px 12px;
        width: 300px;
        outline: none;
        background: #00000000;
        color: #44444F;
        cursor: pointer;
        padding: 4px 50px 4px 8px;
        font-weight: 600;
        font-size: 16px;
    }
</style>