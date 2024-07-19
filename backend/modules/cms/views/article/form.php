<?php


use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\datetime\DateTimePicker;

/** @var yii\web\View $this */

$this->title = 'Article';
$this->params['breadcrumbs'][] = "Create";
if (isset($model->article_model->id)) {
    $this->params['breadcrumbs'][] = "Update";
}
$this->params['title'] = $this->title;
?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<div class="card">
    <div class="card-body">
        <?php
        // $form = ActiveForm::begin([
        //     'id' => 'author-form',
        //     'method' => 'POST',
        //     'fieldConfig' => [
        //         'template' => '<div class="form-group">{label}{input}{error}</div>',
        //     ],
        //     'enableAjaxValidation' => true,
        //     'enableClientValidation' => false,
        //     'enableClientScript' => true,
        //     'action' => $model->action_url,
        //     'validationUrl' => $model->action_validate_url

        // ]);
        ?>
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
                    <div class="col-md-4">
                        <?= $form->field($model, 'title')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Enter Article Title',
                            'id' => 'articleform-title', // Add an ID for JavaScript targeting
                        ]) ?>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($model, 'slug')->textInput([
                            'maxlength' => true,
                            'placeholder' => 'Enter Slug',
                            'readonly' => isset($model->article_model->id) ? true : false, // Make it readonly for existing records
                            'id' => 'articleform-slug', // Add an ID for JavaScript targeting
                        ]) ?>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($model, 'article_author_id')->dropDownList(GeneralModel::authoroption(), ['prompt' => '--Select Author Name--']) ?>
                    </div>


                    <div class="col-md-4 select_width">
                        <?= $form->field($model, 'article_tags')->widget(\kartik\select2\Select2::classname(), [
                            'data' => GeneralModel::tagoption(),
                            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'options' => ['placeholder' => 'Select', 'multiple' => true],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Article Tag') ?>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($model, 'article_topics')->widget(\kartik\select2\Select2::classname(), [
                            'data' => GeneralModel::topicoption(),
                            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'options' => ['placeholder' => 'Select', 'multiple' => true],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Article Topics') ?>
                    </div>

                    <?php
                    if ($model->article_model->banner_image) { ?>
                        <div class="col-md-3">
                            <?= $form->field($model, 'banner_image')->fileInput()->label('Article Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                        </div>
                        <div class="col-md-1">
                            <?php echo '<img src="' . $model->article_model->bannerimagepath . '" width="75" height="75"></img>'; ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-4">
                            <?= $form->field($model, 'banner_image')->fileInput()->label('Article Image (JPEG / JPG / PNG / 940px * 430px / 250kb)') ?>
                        </div>
                    <?php  } ?>


                    <div class="col-md-12">
                        <?= $form->field($model, 'description')->textarea(['rows' => '2', 'placeholder' => 'Description Detail '])->label('Description') ?>
                    </div>




                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'article_date')->input('date', ['class' => 'form-control']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'is_schedule')->dropDownList(GeneralModel::yesnooption(), ['prompt' => '--Select --']) ?>
                        </div>
                        <div class="col-md-4" <?php if ($model->is_schedule == 0) { ?>style="display:none!important;" <?php } ?> id="datetime">
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
                        <div class="col-md-4">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'comment_allowed')->dropDownList(GeneralModel::yesnooption(), ['prompt' => '--Select --']) ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Meta Title']) ?>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => 'Enter Meta Keyword']) ?>
                    </div>


                    <div class="col-md-12">
                        <?= $form->field($model, 'meta_description')->textarea() ?>
                    </div>
                </div>

                <div class="row">
                    <?php
                    if (!empty($model->article_model->id)) { ?>
                        <div class="col-md-4">
                            <?= $form->field($model, 'status')->dropDownList(GeneralModel::statusoption(), ['prompt' => '--Select Status--']) ?>
                        </div>
                    <?php } ?>
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
    </div>
</div>
<?php
$script = <<< JS
    $(function(){
        $('#articleform-is_schedule').change(function(){
            var comment_allowed=$("#articleform-is_schedule").val();
            if(comment_allowed ==1){
                document.getElementById("datetime").style.display= "block";
            }else{
                document.getElementById("datetime").style.display= "none";
            }
        });

    });
JS;
$this->registerJs($script);
?>
<style>
    .ck-editor__editable {
        min-height: 350px;
    }
</style>
<?php
$script = <<< JS
editor('articleform-description');
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