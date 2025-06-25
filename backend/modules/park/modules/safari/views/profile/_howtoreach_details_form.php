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
        <h5>How To Reach</h5>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'module_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Module Title']) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'module_description')->textarea() ?>
            </div>
        </div>
        <hr>
        <h5>Basic Detail</h5>
        <div class="row row-cols-xl-5  row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
            <div class="col change_css">
                <?= $form->field($model, 'nearest_railway_station')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllRailwayStation(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Nearest Railway 1')  ?>
            </div>

            <div class="col change_css">
                <?= $form->field($model, 'nearest_railway_station_two')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllRailwayStation(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Nearest Railway 2')  ?>
            </div>

            <div class="col change_css">
                <?= $form->field($model, 'nearest_railway_station_three')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllRailwayStation(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Nearest Railway 3')  ?>
            </div>

            <div class="col change_css">
                <?= $form->field($model, 'nearest_railway_station_four')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllRailwayStation(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Nearest Railway 4')  ?>
            </div>

            <div class="col change_css">
                <?= $form->field($model, 'nearest_railway_station_five')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllRailwayStation(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Nearest Railway 5')  ?>
            </div>

            <div class="col">
                <?= $form->field($model, 'nearest_railway_station_distance')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Railway Station Distance (in km) 1') ?>
            </div>

            <div class="col ">
                <?= $form->field($model, 'nearest_railway_station_distance_two')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Railway Station Distance (in km) 2') ?>
            </div>

            <div class="col ">
                <?= $form->field($model, 'nearest_railway_station_distance_three')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Railway Station Distance (in km) 3') ?>
            </div>

            <div class="col ">
                <?= $form->field($model, 'nearest_railway_station_distance_four')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Railway Station Distance (in km) 4') ?>
            </div>

            <div class="col ">
                <?= $form->field($model, 'nearest_railway_station_distance_five')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Railway Station Distance (in km) 5') ?>
            </div>


            <div class="col change_css">
                <?= $form->field($model, 'nearest_airport')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllAirport(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Airport 1')  ?>
            </div>

            <div class="col change_css">
                <?= $form->field($model, 'nearest_airport_two')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllAirport(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Airport 2')  ?>
            </div>

            <div class="col change_css">
                <?= $form->field($model, 'nearest_airport_three')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllAirport(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Airport 3')  ?>
            </div>

            <div class="col change_css">
                <?= $form->field($model, 'nearest_airport_four')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllAirport(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Airport 4')  ?>
            </div>

            <div class="col change_css">
                <?= $form->field($model, 'nearest_airport_five')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::getAllAirport(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Airport 5')  ?>
            </div>


            <div class="col">
                <?= $form->field($model, 'nearest_airport_distance')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Airport Distance (in km) 1') ?>
            </div>

            <div class="col ">
                <?= $form->field($model, 'nearest_airport_distance_two')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Airport Distance (in km) 2') ?>
            </div>

            <div class="col ">
                <?= $form->field($model, 'nearest_airport_distance_three')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Airport Distance (in km) 3') ?>
            </div>

            <div class="col ">
                <?= $form->field($model, 'nearest_airport_distance_four')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Airport Distance (in km) 4') ?>
            </div>

            <div class="col ">
                <?= $form->field($model, 'nearest_airport_distance_five')->textInput(['maxlength' => true, 'placeholder' => 'Enter'])->label('Nearest Airport Distance (in km) 5') ?>
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

<?php
$script = <<< JS
editor('safariparkform-module_description');
JS;
$this->registerJs($script);
?>