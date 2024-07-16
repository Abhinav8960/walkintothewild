<?php


use common\models\GeneralModel;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

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
            'id' => 'tag-form',
            'method' => 'POST',
            'fieldConfig' => [
                'template' => '<div class="form-group">{label}{input}{error}</div>',
            ],


        ]); ?>


        <div class="card">
            <div class="card-body">
                <?= $form->errorSummary($model) ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'article_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Article Title']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'writer')->textInput(['maxlength' => true, 'placeholder' => 'Select Writer']) ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'source')->dropDownList(GeneralModel::sourceoption(), ['prompt' => '-----Select Article Source------'])->label('Article Source') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'post_date')->widget(\kartik\datetime\DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Enter Published Date'],
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
                    <div class="col-md-12">
                        <?= $form->field($model, 'key_point')->widget(CKEditor::className(), [
                            'options' => ['rows' => 4],
                            'preset' => 'full',
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'placeholder' => 'Enter Link']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'image')->fileInput() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'video')->fileInput() ?>
                    </div>
                    <div class="col-md-6 select_width">
                        <?= $form->field($model, 'tag_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => GeneralModel::articletagoption(),
                            // 'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                            'options' => ['placeholder' => 'Select', 'multiple' => true],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Article Tag') ?>
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
                            <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>