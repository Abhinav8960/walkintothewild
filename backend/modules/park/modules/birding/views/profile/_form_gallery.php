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
        <div class="row">
            <?php
            if ($model->birding_park_gallery_model->image) { ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'image')->fileInput() ?>
                </div>
                <div class="col-md-1">
                    <?php echo '<img src="' . $model->birding_park_gallery_model->imagepath . '" width="50" height="50"></img>'; ?>
                </div>
            <?php } else { ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'image')->fileInput() ?>
                </div>
            <?php  } ?>
            <div class="col-md-12">
                <?= $form->field($model, 'image_caption')->textarea(['maxlength' => true, 'placeholder' => 'Enter Caption']) ?>
            </div>
            <?php if ($model->birding_park_gallery_model->id) { ?>
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