<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirportSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $this->registerJsFile('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js'); ?>
<?php $this->registerCssFile('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css'); ?>

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
    <div class="col-md-2 select_width">
        <?= $form->field($model, 'user_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => yii\helpers\ArrayHelper::map(common\models\User::find()->orderBy('name', 'asc')->all(), 'id', 'name'),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => [
                'placeholder' => 'Select User',
                'multiple' => false
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false) ?>
    </div>

    <!-- <div class="col-md-2">
        <?= $form->field($model, 'request_group')->dropDownList(
            $request_group_type,
            [
                'prompt' => 'Select Request Group',
            ]
        ) ?>
    </div> -->

    <div class="col-md-2">
        <?= $form->field($model, 'isApi')->dropDownList(
            ['1' => 'Api Request'],
            [
                'prompt' => 'Select For Api Request Check',
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'request_code')->dropDownList(
            $request_codes_list,
            [
                'prompt' => 'Select Response Code',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'is_count')->dropDownList(
            ['' => "Select All", '1' => 'Count Done', '0' => 'Count Pending'],
            [
                'prompt' => 'Select Count Status',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'is_reqeust_trace')->dropDownList(
            ['' => "Select All", '1' => 'Traced', '0' => 'Not Traced'],
            [
                'prompt' => 'Select Trace Status',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<<JS
    /*
        $(document).ready(function() {
            $('#datetime_rate_picker').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                format: 'M/DD hh:mm A'
                }
            });
        });
    */
JS;
$this->registerJs($script);
?>