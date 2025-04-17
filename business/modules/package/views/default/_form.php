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
        <?= $form->field($model, 'package_name', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Package Name',
            'id' => 'packageform-package_name', // Add an ID for JavaScript targeting
        ])->label('Package Name <span class="necessary">*</span>') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'no_of_day', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::packagedayoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select Day/Night', 'multiple' => false],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Day/Night <span class="necessary">*</span>') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'safari_type', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->widget(\kartik\select2\Select2::classname(), [
            'data' => ['1' => 'Shared Safari', '2' => 'Private Safari'],
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select Safari Type', 'multiple' => false],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Safari Type <span class="necessary">*</span>') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'no_of_safari', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Number of Safaris',
        ]) ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'start_location', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Start Location',
        ]) ?>
    </div>
    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'end_location', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter End Location',
        ]) ?>
    </div>
    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'start_date', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->widget(\kartik\datetime\DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Enter Start Date'],
            'pluginOptions' => [

                'type' => DateTimePicker::TYPE_BUTTON,
                'format' => 'yyyy-mm-dd',
                'startDate' => 'today',
                'minView' => 'month',
                'maxView' => 'decade',
                'autoclose' => true,
            ]
        ]); ?>
    </div>
    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'end_date', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->widget(\kartik\datetime\DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Enter End Date'],
            'pluginOptions' => [

                'type' => DateTimePicker::TYPE_BUTTON,
                'format' => 'yyyy-mm-dd',
                'startDate' => 'today',
                'minView' => 'month',
                'maxView' => 'decade',
                'autoclose' => true,
            ]
        ]); ?>
    </div>

    <?php
    if ($model->package_model->package_image) { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'package_image', [
                'labelOptions' => ['class' => 'Modal_label']
            ])->fileInput()->label('Package Image (JPEG / JPG / PNG / 250kb)') ?>
        </div>
        <div class="col-md-1">
            <?php echo '<img src="' . $model->package_model->imagepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'package_image', [
                'labelOptions' => ['class' => 'Modal_label']
            ])->fileInput()->label('Package Image (JPEG / JPG / PNG / 250kb)') ?>
        </div>
    <?php  } ?>

    <?php
    if ($model->package_model->package_banner_image) { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'package_banner_image', [
                'labelOptions' => ['class' => 'Modal_label']
            ])->fileInput()->label('Banner Image (JPEG / JPG / PNG / 250kb)') ?>
        </div>
        <div class="col-md-1">
            <?php echo '<img src="' . $model->package_model->imagebannerpath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'package_banner_image', [
                'labelOptions' => ['class' => 'Modal_label']
            ])->fileInput()->label('Banner Image (JPEG / JPG / PNG / 250kb)') ?>
        </div>
    <?php  } ?>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'package_park', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::safariparklist(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Safari Park') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'stay_category_id', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::packageoption(),
            'options' => ['placeholder' => 'Not Included', 'multiple' => false],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Accomodation') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'cost_per_person', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Cost Per Person',
        ]) ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'type', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->dropDownList(['0' => 'Exclusion', '1' => 'Inclusion']) ?>
    </div>

    <div class="col-lg-3 col-md-6">
        <?= $form->field($model, 'gst_percentage', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->textInput([
            'placeholder' => 'GST (%)',
        ]) ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'package_feature', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::packagefeatureoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Package Feature') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'master_vehicle_id', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::vehicleoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select Vehicle', 'multiple' => false],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Select Vehicle') ?>
    </div>
    

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'package_agenda_id', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->widget(\kartik\select2\Select2::classname(), [
            'data' => ['1' => 'Photography', '3' => 'Safari Experience'],
            'options' => ['placeholder' => 'Select Theme', 'multiple' => false],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Theme') ?>
    </div>
    
    <div class="col-md-12">
        <?= $form->field($model, 'package_description', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->textarea(['rows' => '2', 'placeholder' => 'Description Detail '])->label('Description') ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'package_itinerary_overview', [
            'labelOptions' => ['class' => 'Modal_label']
        ])->textarea(['rows' => '2', 'placeholder' => 'Itinerary Detail '])->label('Overview') ?>
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
editor('packageform-package_description');
editor('packageform-package_itinerary_overview');
JS;
$this->registerJs($script);
?>


<?php
$gst_script = <<< JS
    $(function() {
        $('.field-packageform-gst_percentage').hide();
        var gst_type =$("#packageform-type").val();
            
        if(gst_type == 1){
            $('.field-packageform-gst_percentage').show();
        }
       
        $('#packageform-type').on('change', function() {
            var selectValue = $(this).val();
            if (selectValue == 1) {
                $('.field-packageform-gst_percentage').show();
            } else {
                $('.field-packageform-gst_percentage').hide();
            }
        });
    });
JS;
$this->registerJs($gst_script);
?>