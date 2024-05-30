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
        <h5>Basic Detail</h5>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'nearest_railway_station', ['inputOptions' => ['id' => 'railway_station']])->dropDownList(GeneralModel::getAllRailwayStation(), ['prompt' => 'Select Railway Station'])->label('Railway Station') ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'nearest_railway_station_distance')->textInput(['maxlength' => true, 'placeholder' => 'Enter Nearest Railway Station Distance']) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'nearest_airport', ['inputOptions' => ['id' => 'airport']])->dropDownList(GeneralModel::getAllAirport(), ['prompt' => 'Select Airport'])->label('Airport') ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'nearest_airport_distance')->textInput(['maxlength' => true, 'placeholder' => 'Enter Nearest Airport Distance']) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'nearest_railway_station_two', ['inputOptions' => ['id' => 'railway_station']])->dropDownList(GeneralModel::getAllRailwayStation(), ['prompt' => 'Select Railway Station'])->label('Railway Station') ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'nearest_railway_station_distance_two')->textInput(['maxlength' => true, 'placeholder' => 'Enter Nearest Railway Station Distance']) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'nearest_airport_two', ['inputOptions' => ['id' => 'airport']])->dropDownList(GeneralModel::getAllAirport(), ['prompt' => 'Select Airport'])->label('Airport') ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'nearest_airport_distance_two')->textInput(['maxlength' => true, 'placeholder' => 'Enter Nearest Airport Distance']) ?>
            </div>
        </div>
        <hr>

        <h5>How To Reach</h5>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'module_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Module Title']) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'module_description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 4],
                    'preset' => 'full',

                ]) ?>
            </div>
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
<style>
    .select_width .select2.select2-container {

        width: 100% !important;
        display: block !important;
    }
</style>