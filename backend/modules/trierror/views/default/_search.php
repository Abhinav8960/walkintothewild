<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\budgets\BudgetsParliamentSearch */
/* @var $form yii\widgets\ActiveForm */
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
        <?= $form->field($model, 'panel_type_id')->dropDownList(
            GeneralModel::paneloption(),
            [
                'prompt' => 'Select Panel Type',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'ip_address')->textInput(['placeholder' => 'IP Address']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'error_type')->textInput(['placeholder' => 'Enter Error Type']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'request_type')->textInput(['placeholder' => 'Enter Request Type']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'request_url')->textInput(['placeholder' => 'Request URL']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'reference_url')->textInput(['placeholder' => 'Reference URL']) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'distinct')->dropDownList(['distinct' => 'Distinct'], ['prompt' => 'Select Type']) ?>
    </div>

    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>