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
    <div class="col-md-4">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Title']) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'short_description')->textInput(['maxlength' => true, 'placeholder' => 'Enter Avg Safari Price']) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'logo')->fileInput() ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'long_description')->widget(CKEditor::className(), [
            'options' => ['rows' => 4],
            'preset' => 'full',

        ]) ?>
    </div>

    <?php if ($model->safari_park_model->id) { ?>
        <div class="col-md-3">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'Enter Slug']) ?>
        </div>
    <?php } ?>

    <div class="col-md-3">
        <?= $form->field($model, 'avg_safari_price_min')->textInput(['maxlength' => true, 'placeholder' => 'Enter Avg Safari Price Min'])->label('Average Safri Cost (Min)') ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'avg_safari_price_max')->textInput(['maxlength' => true, 'placeholder' => 'Enter Avg Safari Price Max'])->label('Average Safri Cost (Max)') ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'official_website')->textInput(['maxlength' => true, 'placeholder' => 'Enter Offical Website']) ?>
    </div>

    <div class="col-md-3 select_width">
        <?= $form->field($model, 'master_bonus_experience_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::bonusexperienceoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Bonus Experience') ?>
    </div>
    <div class="col-md-3 select_width">
        <?= $form->field($model, 'accomodation')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::accomodationoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Accomodation') ?>
    </div>
    <div class="col-md-3 select_width">
        <?= $form->field($model, 'safari_session')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::safarisessionoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Safari Session') ?>
    </div>
    <div class="col-md-3 select_width">
        <?= $form->field($model, 'month')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::monthoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Month') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'feature_image')->fileInput() ?>
    </div>
</div>
<hr>

<h5>Address</h5>
<div class="row">


    <div class="col-md-3">
        <?= $form->field($model, 'state_id', ['inputOptions' => ['id' => 'state']])->dropDownList(
            GeneralModel::getAllState(1),
            [
                'prompt' => 'Select State',
                'onchange' => '
                $.get( "' . Yii::$app->urlManager->createUrl('/dropdown/getcity?master_state_id=') . '"+$(this).val(), function( data ) {
                    $( "select#city" ).html( data );
                    $("select#railway_station").html("<option value>Select Railway Station</option>");
                    $("select#airport").html("<option value>Select Airport</option>");
                    $("select#location").html("<option value>Select Location</option>");
                    })'
            ]
        ); ?>
    </div>

    <div class="col-md-3">
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
                });
                $.get("' . Yii::$app->urlManager->createUrl('/dropdown/getlocation?master_city_id=') . '"+$(this).val(), function(data) {
                    $("select#location").html(data);
                });'
            ]
        ); ?>


    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'master_location_id', ['inputOptions' => ['id' => 'location']])->dropDownList(GeneralModel::getAllLocation(), ['prompt' => 'Select Location'])->label('Location') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'pincode')->textInput(['maxlength' => true, 'placeholder' => 'Enter Pincode']) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Latitude']) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Longitude']) ?>
    </div>

</div>
<hr>
<?php if ($model->safari_park_model->id) { ?>
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

<style>
    .select_width .select2.select2-container {

        width: 100% !important;
        display: block !important;
    }
</style>
<?php ActiveForm::end(); ?>