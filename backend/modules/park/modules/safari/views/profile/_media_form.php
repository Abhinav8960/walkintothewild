<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="card">
    <div class="card-body">
        <h5>Media</h5>
        <div class="row">
            <?php
            if ($model->safari_park_model->logo) { ?>
                <div class="col-md-5">
                    <?= $form->field($model, 'logo')->fileInput() ?>
                </div>
                <div class="col-md-1">
                    <?php echo '<img src="' . $model->safari_park_model->logoimagepath . '" width="50" height="50"></img>'; ?>
                </div>
            <?php } else { ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'logo')->fileInput() ?>
                </div>
            <?php  } ?>

            <?php
            if ($model->safari_park_model->feature_image) { ?>
                <div class="col-md-5">
                    <?= $form->field($model, 'feature_image')->fileInput() ?>
                </div>
                <div class="col-md-1">
                    <?php echo '<img src="' . $model->safari_park_model->featureimagepath . '" width="50" height="50"></img>'; ?>
                </div>
            <?php } else { ?>
                <div class="col-md-6">
                    <?= $form->field($model, 'feature_image')->fileInput() ?>
                </div>
            <?php } ?>
        </div>
        <hr>

        <div class="d-flex justify-content-between align-items-center">
            <?php if ($model->safari_park_model->id) { ?>
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