<?php

use common\models\operator\SafariOperator;
use common\models\GeneralModel;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirportSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'call-log-search-form'
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
                    <label>operator:</label>
                    <?= $form->field($model, 'call_initiated_partner_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE])->orderBy(['business_name' => SORT_ASC])->all(), 'id', 'business_name'),
                        [
                            'prompt' => 'Select Operator',
                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>



                <div class="filterItem position-relative">
                    <label>Date Range:</label>
                    <?= $form->field($model, 'date_range', [
                        'options' => ['class' => 'drp-container mb-2']
                    ])->widget(DateRangePicker::class, [
                        'convertFormat' => true,
                        'options' => ['placeholder' => 'Enter Date Range'],
                        'pluginOptions' => [
                            // 'singleDatePicker' => true,
                            'showDropdowns' => true,
                            // 'minDate' =>date('2024-01-01'),
                            'maxDate' => date('Y-m-d'),
                            'locale' => [
                                'format' => 'Y-m-d',
                            ],
                        ]
                    ]);
                    ?>
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