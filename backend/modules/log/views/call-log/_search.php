<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirportSearch $model */
/** @var yii\widgets\ActiveForm $form */
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
<!-- 
    <div class="col-md-2">
        <?= $form->field($model, 'request_caller_1_no')->textInput(['placeholder' => 'Caller Number 1']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'request_caller_2_no')->textInput(['placeholder' => 'Caller Number 2']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'dial_status')->textInput(['placeholder' => 'Enter Dial Status']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'call_type')->textInput(['placeholder' => 'Enter Call Type']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'call_status')->textInput(['placeholder' => 'Enter Call Status']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'call_request_status')->textInput(['placeholder' => 'Enter Call Request Status']) ?>
    </div>

    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div> -->
</div>
<?php ActiveForm::end(); ?>