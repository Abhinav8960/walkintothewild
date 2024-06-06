<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\animal\MasterAnimal $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'animal_type_id', ['inputOptions' => ['id' => 'title']])->dropDownList(
            GeneralModel::animaltypeoption(),
            [
                'prompt' => 'Select Animal Type',
            ]
        ); ?>
    </div>


    <div class="col-md-6">
        <?= $form->field($model, 'know_as')->textInput(['maxlength' => true, 'placeholder' => 'Enter']) ?>
    </div>

    <div class="col-md-5">
        <?= $form->field($model, 'image')->fileInput() ?>
    </div>
    <?php
    if ($model->animal_model->image) { ?>
        <div class="col-md-1">
            <?php echo '<img src="' . $model->animal_model->imagepath . '" width="50" height="50"></img>'; ?>
        </div>
    <?php } ?>

    <?php
    if ($model->article_model->banner_image) { ?>
        <div class="col-md-3">
            <?= $form->field($model, 'banner_image')->fileInput()->label('Banner Image (JPEG / JPG / PNG / 350px * 350px / 100kb)') ?>
        </div>
        <div class="col-md-1">
            <?php echo '<img src="' . $model->article_model->bannerimagepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-4">
            <?= $form->field($model, 'banner_image')->fileInput()->label('Banner Image (JPEG / JPG / PNG / 350px * 350px / 100kb)') ?>
        </div>
    <?php  } ?>


    <?php if ($model->animal_model->id) { ?>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>

    <div class="col-md-12">
        <?= $form->field($model, 'short_description')->textarea() ?>
    </div>


    <div class="col-md-12">
        <?= $form->field($model, 'long_description')->widget(CKEditor::className(), [
            'options' => ['rows' => 4],
            'preset' => 'full',

        ]) ?>
    </div>
    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>