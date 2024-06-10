<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="card">
    <div class="card-body">
        <h5>Meta</h5>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Meta Title']) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => 'Enter Meta Keywords']) ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($model, 'meta_description')->textarea() ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'animal_text')->textarea(['maxlength' => true, 'placeholder' => 'Enter Animals']) ?>
            </div>
            <?php if ($model->safari_park_model->id) { ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => 'Enter Slug']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
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
<style>
    .select_width .select2.select2-container {

        width: 100% !important;
        display: block !important;
    }
</style>