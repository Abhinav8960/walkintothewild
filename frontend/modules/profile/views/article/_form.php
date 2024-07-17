<?php

use common\models\GeneralModel;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'Create Article';
$this->params['title'] = $this->title;
?>

<div class="container">
    <div class="card m-5">
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'article-form',
                'method' => 'POST',
            ]); ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h1>Create Article</h1>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'title')->textInput([
                                'maxlength' => true,
                                'placeholder' => 'Enter Article Title',
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'slug')->textInput([
                                'maxlength' => true,
                                'placeholder' => 'Enter Slug',
                                'readonly' => isset($model->article_model->id) ? true : false,
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'article_tags')->widget(\kartik\select2\Select2::classname(), [
                                'data' => GeneralModel::tagoption(),
                                'options' => ['placeholder' => 'Select', 'multiple' => true],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Article Tag') ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'article_topics')->widget(\kartik\select2\Select2::classname(), [
                                'data' => GeneralModel::topicoption(),
                                'options' => ['placeholder' => 'Select', 'multiple' => true],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Article Topics') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'banner_image')->fileInput()->label('Article Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                        </div>
                    </div>

                    <div class="row">
                        <?= $form->field($model, 'description')->textarea(['rows' => '2', 'placeholder' => 'Description Detail '])->label('Description') ?>

                    </div>

                    <div class="row">
                        <?= $form->field($model, 'article_date')->input('date', ['class' => 'form-control']) ?>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'publish_date_time')->widget(DateTimePicker::classname(), [
                                'options' => ['placeholder' => 'Enter Start date ...',],
                                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                'pickerIcon' => '<i class="fa fa-calendar text-primary"></i>',
                                'removeIcon' => '<i class="fa fa-trash text-danger"></i>',
                                'pluginOptions' => [
                                    'startDate' => date('Y-m-d'),
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd hh:ii'
                                ]
                            ])->label('Start Date/Time'); ?>
                        </div>
                        <div class="col-6"><?= $form->field($model, 'comment_allowed')->dropDownList(GeneralModel::yesnooption(), ['prompt' => '--Select --']) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><?= $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Meta Title']) ?></div>
                        <div class="col-md-4"><?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => 'Enter Meta Keyword']) ?></div>
                        <div class="col-md-6"> <?= $form->field($model, 'meta_description')->textarea() ?></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= Html::submitButton('Save', ['class' => 'btn btn-info mb-2 ms-2']) ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

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
        $('#articleform-title').on('input', function() {
            var title = $(this).val();
            var slug = slugify(title);
            $('#articleform-slug').val(slug);
        });

        // Initialize slug when editing existing record
        if (!$('#articleform-slug').val() && $('#articleform-title').val()) {
            var title = $('#articleform-title').val();
            var slug = slugify(title);
            $('#articleform-slug').val(slug);
        }
    });
JS;
$this->registerJs($script);
?>