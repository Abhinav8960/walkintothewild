<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Student */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="">
    <?php $form = ActiveForm::begin(
        [
            'id' => 'parkfile-form',
            'method' => 'POST',
        ]
    ); ?>
    <div class="form row text-centerd-flex justify-content-center">
        <div class="col-md-12">
            <label for="name">Upload CSV File <span class="required">*</span></label>
            <?= $form->field($model, 'uploadfile')->fileInput()->label(false) ?>

        </div>

        <div class="col-md-12">
            <div class="form-group mt-5 text-center">
                <?= Html::submitButton('Upload', ['class' => 'btn btn-outline-success']) ?>
                <?php echo Html::a('Cancel', ['/master/railway-station'], ['class' => 'btn btn-outline-danger']) ?>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>
</div>