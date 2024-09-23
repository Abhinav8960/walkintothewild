<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>


<div class="col-md-12">
    <div class="card card_bodyPadding">
        <div class="card-body p-4">
            <?php $form = ActiveForm::begin([
                'id' => 'blog-form',
                'method' => 'POST',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'enableClientScript' => true,
                'action' => $model->action_url,
                'validationUrl' => $model->action_validate_url,
            ]); ?>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'title', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Enter Blog Title',
                    ])->label('Title <span class="necessary">*</span>') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'blog_tags', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->widget(\kartik\select2\Select2::classname(), [
                        'data' => GeneralModel::tagoption(),
                        'options' => ['placeholder' => 'Select', 'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Blog Tag <span class="necessary">*</span>') ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'blog_topics', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->widget(\kartik\select2\Select2::classname(), [
                        'data' => GeneralModel::topicoption(),
                        'options' => ['placeholder' => 'Select', 'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Blog Topics <span class="necessary">*</span>') ?>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'banner_image', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->fileInput()->label('Blog Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                </div>
                <?php
                if ($model->blog_model->banner_image) { ?>
                    <div class="col-md-6">
                        <?php echo '<img src="' . $model->blog_model->bannerimagepath . '" width="75" height="75"></img>'; ?>
                    </div>
                <?php } ?>
            </div>

            <div class="row">
                <?= $form->field($model, 'description', [
                    'labelOptions' => ['class' => 'Modal_label']
                ])->textarea(['rows' => '6', 'placeholder' => 'Description Detail '])->label('Description <span class="necessary">*</span>') ?>
            </div>

            <div class="row">
               

                <!-- <?php if ($model->blog_model->id) { ?>
                    <div class="col-md-3">
                        <?= $form->field($model, 'status', [
                                'labelOptions' => ['class' => 'Modal_label']
                            ])->radioList(GeneralModel::statusoption(), ['prompt' => '--Select --'])->label('Blog Status <span class="necessary">*</span>') ?>

                    </div>
                <?php } ?> -->

                <div class="col-md-3">
                    <?= $form->field($model, 'status', [
                        'labelOptions' => ['class' => 'Modal_label']
                    ])->radioList(GeneralModel::userstatusoption(), ['prompt' => '--Select --'])->label('Blog Status <span class="necessary">*</span>') ?>

                </div>

            </div>
            <div class="row">
                <div class="col-md-12 pb-3">
                    <div class="creat-safri float-end w-auto">
                        <?= Html::submitButton('Save', ['class' => 'safari_create font_set px-5']) ?>
                    </div>
                </div>
            </div>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
editor('blogform-description');
JS;
$this->registerJs($script);
?>


<?php
// if (!isset($model->blog_model->id)) {
//     $script = <<< JS
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
//         $('#blogform-title').on('input', function() {
//             var title = $(this).val();
//             var slug = slugify(title);
//             $('#blogform-slug').val(slug);
//         });

//         // Initialize slug when editing existing record
//         if (!$('#blogform-slug').val() && $('#blogform-title').val()) {
//             var title = $('#blogform-title').val();
//             var slug = slugify(title);
//             $('#blogform-slug').val(slug);
//         }
//     });
// JS;
//     $this->registerJs($script);
// }
?>