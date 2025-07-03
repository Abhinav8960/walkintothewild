<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use kartik\daterange\DateRangePicker;

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
    <div class="col-12 mb-3">
        <div class="filterBar">
            <div class="filters">
                <!-- <div class="filterItem position-relative">
                    <label>Date:</label>
                    <?= $form->field($model, 'date_range', [
                        'template' => '{input}',
                    ])->widget(DateRangePicker::classname(), [
                        'options' => [
                            'placeholder' => 'Select Sighting Date',
                            'class' => 'search-border'
                        ],
                    ]); ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div> -->

                <div class="filterItem position-relative">
                    <label>Animal:</label>
                    <?= $form->field($model, 'master_animal_id')->dropDownList(
                        GeneralModel::animalfilteroption(),
                        [
                            'prompt' => 'Select Animal',
                            'class' => 'search-border'
                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

                <div class="filterItem position-relative">
                    <label>Session:</label>
                    <?= $form->field($model, 'safari_session_id')->dropDownList(
                        GeneralModel::safarisessionoption(),
                        [
                            'prompt' => 'Select Session',
                            'class' => 'search-border'
                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

                <div class="filterItem position-relative">
                    <label>Park:</label>
                    <?= $form->field($model, 'location')->dropDownList(
                        \yii\helpers\ArrayHelper::map(SafariPark::find()->orderby(['safari_park.title' => SORT_ASC])->all(), 'id', 'title'),
                        [
                            'prompt' => 'Select Park',
                            'class' => 'search-border'

                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

                <div class="filterItem position-relative">
                    <label>Status:</label>
                    <?= $form->field($model, 'status')->dropDownList(
                        GeneralModel::newstatusoption(),
                        [
                            'prompt' => 'Select Status',
                            'class' => 'search-border'
                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
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

<style>
    .filterItem input {
        border: none;
        outline: none;
        background: transparent;
        font-weight: 600;
        color: #44444F !important;
        cursor: pointer;
        padding: 4px 50px 4px 8px;
        font-size: 16px;
    }
</style>