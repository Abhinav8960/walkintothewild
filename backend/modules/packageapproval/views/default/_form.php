<?php


use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\datetime\DateTimePicker;

?>

<?php $form = ActiveForm::begin([
    'id' => 'package-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="row">

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'package_name')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Package Name',
        ])->label('PACKAGE NAME <span class="necessary">*</span>') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'no_of_day')->dropDownList(GeneralModel::packagedayoption(), ['prompt' => 'Select'])->label('DAY/NIGHT <span class="necessary">*</span>') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'safari_type')->dropDownList(['1' => 'Shared Safari', '2' => 'Private Safari'], ['prompt' => 'Select'])->label('SAFARI TYPE <span class="necessary">*</span>') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'no_of_safari')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Number of Safaris',
        ])->label('NUMBER OF SAFARIS') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'start_location')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Start Location',
        ])->label('TOUR START') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'end_location')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter End Location',
        ])->label('TOUR END') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label('START DATE') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'end_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label('END DATE') ?>
    </div>


    <?php
    if ($model->package_version_model->package_image) { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'package_image')->fileInput()->label('PACKAGE IMAGE (JPEG / JPG / PNG / 250kb)') ?>
        </div>
        <div class="col-md-1">
            <?php echo '<img src="' . $model->package_version_model->imagepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'package_image')->fileInput()->label('PACKAGE IMAGE (JPEG / JPG / PNG / 250kb)') ?>
        </div>
    <?php  } ?>


    <?php
    if ($model->package_version_model->package_banner_image) { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'package_banner_image')->fileInput()->label('BANNER IMAGE (JPEG / JPG / PNG / 250kb)') ?>
        </div>
        <div class="col-md-1">
            <?php echo '<img src="' . $model->package_version_model->imagebannerpath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'package_banner_image')->fileInput()->label('BANNER IMAGE (JPEG / JPG / PNG / 250kb)') ?>
        </div>
    <?php  } ?>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'package_park')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::safariparklist(),
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('SAFARI PARK') ?>
    </div>

    
    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::packageoption(), ['prompt' => 'Select'])->label('ACCOMDATION') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'cost_per_person')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Cost Per Person',
        ])->label('COST PER PERSON') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'type')->dropDownList(['0' => 'Exclusion', '1' => 'Inclusion'], ['prompt' => 'Select']) ?>
    </div>


    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'gst_percentage')->textInput([
            'placeholder' => 'GST (%)',
        ]) ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'package_feature')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::packagefeatureoption(),
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Package Feature') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'master_vehicle_id')->dropDownList(GeneralModel::vehicleoption(), ['prompt' => 'Select'])->label('VEHICLE') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'package_agenda_id')->dropDownList(['1' => 'Photography', '3' => 'Safari Experience'], ['prompt' => 'Select'])->label('THEME') ?>
    </div>


    <div class="col-md-12">
        <?= $form->field($model, 'package_description')->textarea(['rows' => '1', 'placeholder' => 'Description Detail '])->label('Description') ?>
    </div>


    <div class="col-md-12">
        <?= $form->field($model, 'package_itinerary_overview')->textarea(['rows' => '1', 'placeholder' => 'Itinerary Detail '])->label('Overview') ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="creat-safri float-start w-auto gap-2">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-info']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
editor('PackageVersionForm-package_description');
editor('PackageVersionForm-package_itinerary_overview');
JS;
$this->registerJs($script);
?>


<?php
$gst_script = <<< JS
    $(function() {
        $('.field-PackageVersionForm-gst_percentage').hide();
        var gst_type =$("#PackageVersionForm-type").val();
            
        if(gst_type == 1){
            $('.field-PackageVersionForm-gst_percentage').show();
        }
       
        $('#PackageVersionForm-type').on('change', function() {
            var selectValue = $(this).val();
            if (selectValue == 1) {
                $('.field-PackageVersionForm-gst_percentage').show();
            } else {
                $('.field-PackageVersionForm-gst_percentage').hide();
            }
        });
    });
JS;
$this->registerJs($gst_script);
?>