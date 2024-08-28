<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">

    <?php
    if ($model->frontend_banner_model->frontend_banner) { ?>
        <div class="col-md-5">
            <?= $form->field($model, 'file')->fileInput()->label('Image (JPEG / JPG / PNG / 250kb)') ?>
        </div>

        <div class="col-md-1">
            <?php echo '<img src="' . $model->frontend_banner_model->imagepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'file')->fileInput()->label('Image (JPEG / JPG / PNG / 250kb)') ?>
        </div>
    <?php  } ?>
    <div class="col-md-6">
        <?= $form->field($model, 'url')->textInput(['placeholder' => 'Enter Url']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'type')->dropDownList(GeneralModel::frontendbannertype(), ['prompt' => 'Select Type']) ?>
    </div>
    <?php if ($model->frontend_banner_model->id) { ?>
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

<?php ActiveForm::end(); ?>