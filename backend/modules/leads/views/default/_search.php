<?php

use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use common\models\User;
use kartik\typeahead\Typeahead;
use yii\helpers\ArrayHelper;

$names = ArrayHelper::getColumn(
    User::find()->select('name')->where(['status' => User::STATUS_ACTIVE])->asArray()->all(),
    'name'
);

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
        <?= $form->field($model, 'source')->dropDownList(
            GeneralModel::leadSource(),
            [
                'prompt' => 'Select Source',
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'safari_operator_id')->dropDownList(
            GeneralModel::operatorslist(),
            [
                'prompt' => 'Select Operator',
            ]
        ) ?>
    </div>

    

    <div class="col-md-2">
        <?= $form->field($model, 'quotation_count')->textInput(['placeholder' => 'Enter Quotation Count']) ?>
    </div>

      <div class="col-md-2">
        <?= $form->field($model, 'is_payment_link_send')->dropDownList(
            [
                '1' => 'Payment Link Send',
                '0' => 'Payment Link Not Send'
            ],
            [
                'prompt' => 'Select Payment Status',
            ]
        ) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'quotation_count')->textInput(['placeholder' => 'Enter Quotation Count']) ?>
    </div>

    <div class="col-md-2">
        <?= $form->field($model, 'is_chat_started')->dropDownList(
            [
                '1' => 'Yes',
                '0' => 'No'
            ],
            [
                'prompt' => 'Select Chat Status',
            ]
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'park_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(SafariPark::find()->orderby(['safari_park.title' => SORT_ASC])->all(), 'id', 'title'),
            [
                'prompt' => 'Select Park',
            ]
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(
            GeneralModel::newstatusoption(),
            [
                'prompt' => 'Select Status',
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