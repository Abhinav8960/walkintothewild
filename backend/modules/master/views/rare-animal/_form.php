<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterRareAnimal $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-6">
        <?= $form->field($model, 'animal_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'know_as')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?>
    </div>

    <?php
    if ($model->rare_animal_model->feature_image) { ?>
        <div class="col-md-5">
            <?= $form->field($model, 'feature_image')->fileInput()->label('Image (JPEG / JPG / PNG / 285px * 285px / 250kb)') ?>
        </div>

        <div class="col-md-1">
            <?php echo '<img src="' . $model->rare_animal_model->imagepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'feature_image')->fileInput()->label('Image (JPEG / JPG / PNG / 285px * 285px / 250kb)') ?>
        </div>
    <?php  } ?>


    <?php
    if ($model->rare_animal_model->banner) { ?>
        <div class="col-md-5">
            <?= $form->field($model, 'banner')->fileInput()->label('Banner Image (JPEG / JPG / PNG / 1920px * 220px / 250kb)') ?>
        </div>
        <div class="col-md-1">
            <?php echo '<img src="' . $model->rare_animal_model->bannerimagepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'banner')->fileInput()->label('Banner Image (JPEG / JPG / PNG / 1920px * 220px / 250kb)') ?>
        </div>
    <?php  } ?>

    <div class="col-md-12">
        <?= $form->field($model, 'short_description')->textarea() ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'assigned_park')->widget(\kartik\select2\Select2::classname(), [
            'data' => GeneralModel::safariparkoption(),
            'options' => ['placeholder' => 'Select Safari Park', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
    </div>

    <?php if ($model->rare_animal_model->id) { ?>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>



    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>