<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'master_zone_type_id')->dropDownList(GeneralModel::zonetypeoption(), ['prompt' => 'Select']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'zone_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'entry_gate_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'entry_gate_latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'entry_gate_longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?>
            </div>
            <?php if ($model->safari_park_zone_model->id) { ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
                </div>

            <?php } ?>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>