<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\smstemplate\MasterSmsTemplate $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'template_id')->textInput(['maxlength' => true, 'placeholder' => 'Enter Template Id']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'route')->textInput(['maxlength' => true, 'placeholder' => 'Enter Route']) ?>
    </div>
    <div class="col-md-6">
       <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'placeholder' => 'Enter Description']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'message')->textarea(['maxlength' => true, 'placeholder' => 'Enter Message']) ?>
    </div>
    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>