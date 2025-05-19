<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<div class="container-lg" style="margin-top: 11%;">
    <div class="row margin_bottomfooter justify-content-center">
        <div class="col-6">
            <div class="getquote_box mt-2">
                <div class="get_free_title2 text-center pb-3">
                    <h4>User Delete Request</h4>
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'delete-request',
                    'method' => 'POST',
                    'fieldConfig' => [
                        'template' => '<div class="form-group">{label}{input}{error}</div>',
                    ],

                ]); ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-wrapper ">
                            <label for="">Email Address</label>
                            <?= $form->field($model, 'email')->textInput(['class' => 'form-control', 'placeholder' => 'Enter Your Email Address'])->label(false) ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <?= Html::submitButton('Send Request', ['class' => 'sent_btn mt-2']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>