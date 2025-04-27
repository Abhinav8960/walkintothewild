<?php


use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\datetime\DateTimePicker;

?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<?php $form = ActiveForm::begin([
    'id' => 'author-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>


<div class="card">
    <div class="card-body">

        <div class="row">
            <?php
            if ((!$model->package_version_model->id)) { ?>

                <div class="col-md-3">
                    <?= $form->field($model, 'owned_by_id')->dropDownList(GeneralModel::safariparkoperatoroption(), ['prompt' => 'Select person who owns the package'])->label('Person who owns the package') ?>
                </div>
            <?php } ?>
            <div class="col-md-3">
                <?= $form->field($model, 'package_name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Package Name',
                    'id' => 'PackageVersionForm-package_name', // Add an ID for JavaScript targeting
                ]) ?>
            </div>


            <div class="col-md-3">
                <?= $form->field($model, 'no_of_day')->dropDownList(GeneralModel::packagedayoption(), ['prompt' => 'Select Day/Night'])->label('Day/Night') ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'safari_type')->dropDownList(['1' => 'Shared Safari', '2' => 'Private Safari'], ['prompt' => 'Select Safrai Type']) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'no_of_safari')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Number of Safaries',
                ]) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'start_location')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Start Location',
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'end_location')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter End Location',
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'start_date')->widget(\kartik\datetime\DateTimePicker::classname(), [
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
            <div class="col-md-3">
                <?= $form->field($model, 'end_date')->widget(\kartik\datetime\DateTimePicker::classname(), [
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
            if ($model->package_version_model->package_image) { ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'package_image')->fileInput()->label('Package Image (JPEG / JPG / PNG  / 250kb)') ?>
                </div>
                <div class="col-md-1">
                    <?php echo '<img src="' . $model->package_version_model->imagepath . '" width="75" height="75"></img>'; ?>
                </div>
            <?php } else { ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'package_image')->fileInput()->label('Package Image (JPEG / JPG / PNG  / 250kb)') ?>
                </div>
            <?php  } ?>


            <?php
            if ($model->package_version_model->package_banner_image) { ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'package_banner_image')->fileInput()->label('Package Banner Image (JPEG / JPG / PNG  / 250kb)') ?>
                </div>
                <div class="col-md-1">
                    <?php echo '<img src="' . $model->package_version_model->imagebannerpath . '" width="75" height="75"></img>'; ?>
                </div>
            <?php } else { ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'package_banner_image')->fileInput()->label('Package Banner Image (JPEG / JPG / PNG  / 250kb)') ?>
                </div>
            <?php  } ?>


            <div class="col-md-3">
                <?= $form->field($model, 'package_park')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::safariparklist(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Safari Park') ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::packageoption(), ['prompt' => 'Select Accommodation']) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'cost_per_person')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Cost Per Person',
                ]) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'type')->dropDownList(['0' => 'Exclusion', '1' => 'Inclusion']) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'master_vehicle_id', [
                    // 'labelOptions' => ['class' => 'Modal_label']
                ])->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::vehicleoption(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select Vehicle', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'package_agenda_id')->dropDownList(['1' => 'Photography', '3' => 'Safari Experience'], ['prompt' => 'Select Theme']) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'gst_percentage')->textInput([
                    'placeholder' => 'GST (%)',
                ]) ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'package_feature')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::packagefeatureoption(),
                    // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Select', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Package Feature') ?>
            </div>

            <?php
            if (!empty($model->package_version_model->id)) { ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'status')->dropDownList(GeneralModel::statusoption(), ['prompt' => '--Select Status--']) ?>
                </div>
            <?php } ?>
            <div class="col-md-12">
                <?= $form->field($model, 'package_description')->textarea(['rows' => '2', 'placeholder' => 'Description Detail '])->label('Description') ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'package_itinerary_overview')->textarea(['rows' => '2', 'placeholder' => 'Itinerary Detail '])->label('Overview') ?>
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


<?php
// $script = <<< JS
//     $(function(){
//         // Function to generate slug from title
//         function slugify(text) {
//             return text.toString().toLowerCase()
//                 .replace(/\s+/g, '-')           // Replace spaces with -
//                 .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
//                 .replace(/\-\-+/g, '-')         // Replace multiple - with single -
//                 .replace(/^-+/, '')             // Trim - from start of text
//                 .replace(/-+$/, '');            // Trim - from end of text
//         }

//         // Handle title change to update slug
//         $('#PackageVersionForm-package_name').on('input', function() {
//             var package_name = $(this).val();
//             var package_slug = slugify(package_name);
//             $('#PackageVersionForm-package_slug').val(package_slug);
//         });

//         // Initialize slug when editing existing record
//         if (!$('#PackageVersionForm-slug').val() && $('#PackageVersionForm-package_name').val()) {
//             var package_name = $('#PackageVersionForm-package_name').val();
//             var package_slug = slugify(package_name);
//             $('#PackageVersionForm-package_slug').val(package_slug);
//         }
//     });
// JS;
// $this->registerJs($script);
?>