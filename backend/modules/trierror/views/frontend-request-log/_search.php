<?php

use common\models\GeneralModel;
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
    <div class="col-md-3">
        <?= $form->field($model, 'user_id')->dropDownList(
            yii\helpers\ArrayHelper::map(common\models\User::find()->orderBy('name', 'asc')->all(), 'id', 'name'),
            [
                'prompt' => 'Select User',
            ]
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'request_group')->dropDownList(
            $request_group_type,
            [
                'prompt' => 'Select Request Group',
            ]
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'request_code')->dropDownList(
            $request_codes_list,
            [
                'prompt' => 'Select Response Code',
            ]
        ) ?>
    </div><?php /*
        <div class="col-md-3">
            <?php  echo $form->field($model, 'request_code') ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'request_code') ?>
        </div> */ ?>
    <div class="col-md-3">
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