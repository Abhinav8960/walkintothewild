<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>


<?php $form = ActiveForm::begin([
    'id' => 'seat-update-form',
    'method' => 'POST',
    'enableAjaxValidation' => true,
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>

<div class="row">
    <div class="row">
        <div class="col-lg-12">
            <div class="form_boxes mb-3">
                <label for="">Total Seats<span>*</span></label>
                <?= $form->field($share_seat_model, 'total_seat')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Total Seat',
                    'class' => 'form-control'
                ])->label(false) ?>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form_boxes mb-3">
                <label for="">Self Occupied Seats<span>*</span></label>
                <?= $form->field($share_seat_model, 'self_occupied_seat')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Self Occupied Seat',
                    'class' => 'form-control'
                ])->label(false) ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'button-created create']) ?>
            </div>
        </div>
    </div>
</div>



<?php ActiveForm::end(); ?>