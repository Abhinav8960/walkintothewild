<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\GeneralModel;
use app\models\MasterState;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\budgets\BudgetsParliamentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="Error-log-search">
    <?php
    $form = ActiveForm::begin([
                'options' => ['class' => 'form-inline', 'data-pjax' => true],
                'fieldConfig' => [
                    'template' => "<div>{input}</div>",
                ],
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>
    <?= $form->field($model, 'ip_address')->textInput(['placeholder' => 'IP Address']) ?>
    <?= $form->field($model, 'error_type')->textInput(['placeholder' => 'Enter Error Type']) ?>
    <?= $form->field($model, 'request_type')->textInput(['placeholder' => 'Enter Request Type']) ?>
    <?= $form->field($model, 'request_url')->textInput(['placeholder' => 'Request URL']) ?>
    <?= $form->field($model, 'reference_url')->textInput(['placeholder' => 'Reference URL']) ?>
    <?= $form->field($model, 'distinct')->dropDownList(['distinct'=>'Distinct'], ['prompt' => 'Select Type']) ?>



    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
