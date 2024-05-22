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
<h5>Basic Detail</h5>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Title']) ?>
    </div>

    <?php if ($model->park_model->id) { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'Enter Slug']) ?>
        </div>
    <?php } ?>

    <div class="col-md-6">
        <?= $form->field($model, 'vehicle_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::vehicleoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select Vehicles', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'avg_safari_price')->textInput(['maxlength' => true, 'placeholder' => 'Enter Avg Safari Price']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'master_animal_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::animaloption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select Animal', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'short_description')->textarea() ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'long_description')->widget(CKEditor::className(), [
            'options' => ['rows' => 4],
            'preset' => 'full',

        ]) ?>
    </div>
</div>
<hr>

<h5>Address</h5>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'country_id', ['inputOptions' => ['id' => 'country']])->dropDownList(
            GeneralModel::countryoption(),
            [
                'prompt' => 'Select Country',
                'onchange' => '
                $.get( "' . Yii::$app->urlManager->createUrl('/dropdown/getstate?country_id=') . '"+$(this).val(), function( data ) {
                    $( "select#state" ).html( data );
                    $("select#city").html("<option value>Select City</option>");
                    $("select#railway_station").html("<option value>Select Railway Station</option>");
                    $("select#airport").html("<option value>Select Airport</option>");
                    })'
            ]
        ); ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'state_id', ['inputOptions' => ['id' => 'state']])->dropDownList(
            GeneralModel::getAllState($model->country_id),
            [
                'prompt' => 'Select State',
                'onchange' => '
                $.get( "' . Yii::$app->urlManager->createUrl('/dropdown/getcity?master_state_id=') . '"+$(this).val(), function( data ) {
                    $( "select#city" ).html( data );
                    $("select#railway_station").html("<option value>Select Railway Station</option>");
                    $("select#airport").html("<option value>Select Airport</option>");
                    })'
            ]
        ); ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'city_id', ['inputOptions' => ['id' => 'city']])->dropDownList(
            GeneralModel::getAllCity($model->state_id),
            [
                'prompt' => 'Select City',
                'onchange' => '
                $.get("' . Yii::$app->urlManager->createUrl('/dropdown/getrailway?master_city_id=') . '"+$(this).val(), function(data) {
                    $("select#railway_station").html(data);
                });
                $.get("' . Yii::$app->urlManager->createUrl('/dropdown/getairport?master_city_id=') . '"+$(this).val(), function(data) {
                    $("select#airport").html(data);
                });'
            ]
        ); ?>


    </div>


    <div class="col-md-6">
        <?= $form->field($model, 'master_location_id')->dropDownList(GeneralModel::locationoption(), ['prompt' => 'Select Location'])->label('Location') ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'nearest_railway_station', ['inputOptions' => ['id' => 'railway_station']])->dropDownList(GeneralModel::getAllRailwayStation($model->city_id), ['prompt' => 'Select Railway Station'])->label('Railway Station') ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'nearest_airport', ['inputOptions' => ['id' => 'airport']])->dropDownList(GeneralModel::getAllAirport($model->city_id), ['prompt' => 'Select Airport'])->label('Airport') ?>
    </div>

</div>
<hr>

<h5>Meta</h5>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Meta Title']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => 'Enter Meta Keywords']) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'meta_description')->textarea() ?>
    </div>
</div>
<hr>

<h5>Other</h5>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'official_website')->textInput(['maxlength' => true, 'placeholder' => 'Enter Offical Website']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Latitude']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Longitude']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'master_bonus_experience_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::bonusexperienceoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select Animal', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
    </div>

</div>


<?php if ($model->park_model->id) { ?>
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
    </div>

<?php } ?>



<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>