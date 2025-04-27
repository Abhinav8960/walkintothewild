<?php


use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\datetime\DateTimePicker;

?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<?php $form = ActiveForm::begin([
    'id' => 'package-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'package_name')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Package Name',
            'id' => 'PackageVersionForm-package_name', // Add an ID for JavaScript targeting
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'package_slug')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Slug',
            'readonly' => isset($model->package_version_model->id) ? true : false, // Make it readonly for existing records
            'id' => 'PackageVersionForm-package_slug', // Add an ID for JavaScript targeting
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'no_of_day')->dropDownList(GeneralModel::packagedayoption(), ['class' => 'form-select form-select-lg mb-3', 'prompt' => 'Select Day/Night'])->label('Day/Night') ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'no_of_safari')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Number of Safaries',
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'start_location')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Start Location',
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'end_location')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter End Location',
        ]) ?>
    </div>
    <div class="col-md-6">
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
    <div class="col-md-6">
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
        <div class="col-md-6">
            <?= $form->field($model, 'package_image')->fileInput()->label('Package Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
        </div>
        <div class="col-md-1">
            <?php echo '<img src="' . $model->package_version_model->imagepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'package_image')->fileInput()->label('Package Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
        </div>
    <?php  } ?>



    <div class="col-md-6">
        <?= $form->field($model, 'package_park')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::safariparkoption(),
            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Safari Park') ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::packageoption(), ['class' => 'form-select form-select-lg mb-3', 'prompt' => 'Select Category']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'cost_per_person')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Cost Per Person',
        ]) ?>
    </div>

    <div class="col-md-6">
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
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(GeneralModel::statusoption(), ['class' => 'form-select form-select-lg mb-3', 'prompt' => '--Select Status--']) ?>
        </div>
    <?php } ?>
    <div class="col-md-12">
        <?= $form->field($model, 'package_description')->textarea(['rows' => '2', 'placeholder' => 'Description Detail '])->label('Description') ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'submit-btn submit-button next-btn']) ?>
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
JS;
$this->registerJs($script);
?>

<?php
$script = <<< JS
    $(function(){
        // Function to generate slug from title
        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }

        // Handle title change to update slug
        $('#PackageVersionForm-package_name').on('input', function() {
            var package_name = $(this).val();
            var package_slug = slugify(package_name);
            $('#PackageVersionForm-package_slug').val(package_slug);
        });

        // Initialize slug when editing existing record
        if (!$('#PackageVersionForm-slug').val() && $('#PackageVersionForm-package_name').val()) {
            var package_name = $('#PackageVersionForm-package_name').val();
            var package_slug = slugify(package_name);
            $('#PackageVersionForm-package_slug').val(package_slug);
        }
    });
JS;
$this->registerJs($script);
?>