<?php


use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\datetime\DateTimePicker;

?>

<?php $form = ActiveForm::begin([
    'id' => 'package-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="row">
    <?php
    if ($model->user_image_model->filepath) { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'file')->fileInput()->label('POST (JPEG / JPG / PNG / 250kb)') ?>
        </div>
        <div class="col-md-1">
            <?php echo '<img src="' . Yii::$app->params['s3_endpoint'] .'/'. $model->user_image_model->filepath . '" width="75" height="75"></img>'; ?>
        </div>
    <?php } else { ?>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'file')->fileInput()->label('POST (JPEG / JPG / PNG / 250kb)') ?>
        </div>
    <?php  } ?>
</div>

<div class="row">
    <?= $form->field($model, 'caption')->textarea()->label('Caption') ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="creat-safri float-start w-auto gap-2">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-info']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


