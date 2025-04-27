<?php


use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'Blog Tag';
$this->params['breadcrumbs'][] = "Create";
if (isset($model->master_blog_tag_model->id)) {
    $this->params['breadcrumbs'][] = "Update";
}
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'tag-form',
            'method' => 'POST',
            'fieldConfig' => [
                'template' => '<div class="form-group">{label}{input}{error}</div>',
            ],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'enableClientScript' => true,
            'action' => $model->action_url,
            'validationUrl' => $model->action_validate_url

        ]); ?>


        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Blog Category Name']) ?>
                    </div>
                    <!-- <div class="col-md-4">
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'Enter Slug', 'readonly' => isset($model->master_blog_tag_model->id) ? true : false]) ?>
                    </div> -->
                </div>


                <div class="row">
                    <?php
                    if (!empty($model->master_tag_model->id)) { ?>
                        <div class="col-md-6">
                            <?= $form->field($model, 'status')->dropDownList(GeneralModel::newstatusoption(), ['prompt' => '--Select Status--']) ?>
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
        $('#masterblogtagform-title').on('input', function() {
            var tag_name = $(this).val();
            var tag_slug = slugify(tag_name);
            $('#masterblogtagform-slug').val(tag_slug);
        });

        // Initialize slug when editing existing record
        if (!$('#PackageVersionForm-slug').val() && $('#masterblogtagform-title').val()) {
            var tag_name = $('#masterblogtagform-title').val();
            var tag_slug = slugify(tag_name);
            $('#masterblogtagform-slug').val(tag_slug);
        }
    });
JS;
$this->registerJs($script);
?>