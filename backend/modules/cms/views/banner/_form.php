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
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'page_id')->dropDownList(GeneralModel::pages(), ['prompt' => 'Select Page']) ?>
    </div>
    <?php
    if ($model->banner_model->image) { ?>
        <div class="col-md-5">
            <?= $form->field($model, 'image')->fileInput()->label('Image (JPEG / JPG / PNG / 250kb)') ?>
        </div>

        <div class="col-md-1">
            <?php echo '<img src="' . $model->banner_model->imagepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'image')->fileInput()->label('Image (JPEG / JPG / PNG / 250kb)') ?>
        </div>
    <?php  } ?>
    <?php if ($model->banner_model->id) { ?>
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