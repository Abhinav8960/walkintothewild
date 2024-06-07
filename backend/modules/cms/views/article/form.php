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

<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'id' => 'author-form',
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
                    <div class="col-md-6">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Article Title']) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'sub_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Sub Title']) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'article_author_id')->dropDownList(GeneralModel::authoroption(), ['prompt' => '--Select Author Name--']) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'Enter Slug', 'readonly' => isset($model->article_model->id) ? true : false]) ?>
                    </div>



                    <?php
                    if ($model->article_model->banner_image) { ?>
                        <div class="col-md-5">
                            <?= $form->field($model, 'banner_image')->fileInput()->label('Banner Image (JPEG / JPG / PNG / 1286px * 588px / 250kb)') ?>
                        </div>
                        <div class="col-md-1">
                            <?php echo '<img src="' . $model->article_model->bannerimagepath . '" width="75" height="75"></img>'; ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-6">
                            <?= $form->field($model, 'banner_image')->fileInput()->label('Banner Image (JPEG / JPG / PNG / 1286px * 588px / 250kb)') ?>
                        </div>
                    <?php  } ?>

                    <?php
                    if ($model->article_model->feature_image) { ?>
                        <div class="col-md-5">
                            <?= $form->field($model, 'feature_image')->fileInput()->label('Feature Image (JPEG / JPG / PNG / 397px * 386px / 250kb)') ?>
                        </div>
                        <div class="col-md-1">
                            <?php echo '<img src="' . $model->article_model->featureimagepath . '" width="75" height="75"></img>'; ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-6">
                            <?= $form->field($model, 'feature_image')->fileInput()->label('Feature Image (JPEG / JPG / PNG / 397px * 386px / 250kb)') ?>
                        </div>
                    <?php  } ?>

                    <div class="col-md-12">
                        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                            'options' => ['rows' => 4],
                            'preset' => 'full',

                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'article_date')->input('date', ['class' => 'form-control']) ?>
                    </div>


                    <div class="col-md-6">
                        <?= $form->field($model, 'article_tag_id')->dropDownList(GeneralModel::tagoption(), ['prompt' => '--Select Article Tag--']) ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'comment_allowed')->dropDownList(GeneralModel::yesnooption(), ['prompt' => '--Select --']) ?>
                        </div>
                        <div class="col-md-6" <?php if ($model->comment_allowed == 0) { ?>style="display:none!important;" <?php } ?> id="approval_required">
                            <?= $form->field($model, 'approval_required')->dropDownList(GeneralModel::yesnooption(), ['prompt' => '--Select --']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'is_schedule')->dropDownList(GeneralModel::yesnooption(), ['prompt' => '--Select --']) ?>
                        </div>
                        <div class="col-md-6" <?php if ($model->is_schedule == 0) { ?>style="display:none!important;" <?php } ?> id="datetime">
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
                        <div class="col-md-6">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Meta Title']) ?>
                    </div>

                    <div class="col-md-12">
                        <?= $form->field($model, 'meta_description')->textarea() ?>
                    </div>

                    <div class="col-md-12">
                        <div class="formInput mb-3">
                            <div class="d-md-flex  gap-3">
                                <div class="checkbb mt-md-0 mt-3">
                                    <div class="input_check d-flex gap-3 align-items-center">
                                        <?= $form->field($model, 'article_topics')->checkboxList(
                                            GeneralModel::topicoption(),
                                            [
                                                'itemOptions' => ['class' => 'checkbox_design'],
                                            ]
                                        ); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php
                    if (!empty($model->article_model->id)) { ?>
                        <div class="col-md-6">
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
        $('#articleform-comment_allowed').change(function(){
            var comment_allowed=$("#articleform-comment_allowed").val();
            if(comment_allowed ==1){
                document.getElementById("approval_required").style.display= "block";
            }else{
                document.getElementById("approval_required").style.display= "none";
            }
        });

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