<?php


use common\models\GeneralModel;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'Article Source';
$this->params['breadcrumbs'][] = "Create";
if (isset($model->article_model->id)) {
    $this->params['breadcrumbs'][] = "Update";
}
$this->params['title'] = $this->title;
?>


<?php $form = ActiveForm::begin([
    'id' => 'tag-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],


]); ?>



<div class="card-body">
    <?= $form->errorSummary($model) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'article_source')->textInput(['maxlength' => true, 'placeholder' => 'Enter Article Source']) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'publisher')->textInput(['maxlength' => true, 'placeholder' => 'Enter Publisher']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'category_id')->dropDownList(GeneralModel::categoryoption(), ['prompt' => '-----Select Article Category------'])->label('Article Category') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'frequency_id')->dropDownList(GeneralModel::frequencyoption(), ['prompt' => '-----Select Article Frequency------'])->label('Article Frequency') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'web_link')->textInput(['maxlength' => true, 'placeholder' => 'Enter Web Links']) ?>
        </div>

            <?php
            if (!empty($model->article_source_model->id)) { ?>
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

<?php ActiveForm::end(); ?>