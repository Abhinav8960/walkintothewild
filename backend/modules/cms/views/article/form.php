<?php


use common\models\GeneralModel;
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
                    <div class="col-md-4">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Article Title']) ?>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Article Meta Title']) ?>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'Enter Slug', 'readonly' => isset($model->article_model->id) ? true : false]) ?>
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