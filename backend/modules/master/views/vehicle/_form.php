<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\vehicle\MasterVehicle $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-6">
        <?= $form->field($model, 'vehicle_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Vehicle Name']) ?>
    </div>


    <div class="col-md-5">
        <?= $form->field($model, 'icon')->fileInput() ?>
    </div>
    <?php
    if ($model->vehicle_model->icon) { ?>
        <div class="col-md-1">
            <?php echo '<img src="' . $model->vehicle_model->imagepath . '" width="50" height="50"></img>'; ?>
        </div>
    <?php } ?>


    <?php if ($model->vehicle_model->id) { ?>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>

    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>