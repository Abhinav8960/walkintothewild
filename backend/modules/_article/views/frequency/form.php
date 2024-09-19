<?php


use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'Frequency';
$this->params['breadcrumbs'][] = "Create";
if (isset($model->category_model->id)) {
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
                        <?= $form->field($model, 'frequency')->textInput(['maxlength' => true, 'placeholder' => 'Enter Frequency']) ?>
                    </div>

                </div>

                <div class="row">
                    <?php
                    if (!empty($model->frequency_model->id)) { ?>
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