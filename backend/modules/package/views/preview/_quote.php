<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="col-lg-12">
    <div class="getquote_box">
        <?php
        $form = ActiveForm::begin([
            'id' => 'quoteform',
            'method' => 'POST',
            'fieldConfig' => [
                'template' => '<div class="form-group">{label}{input}{error}</div>',
            ],

        ]);
        ?>

        <div class="row ">
            <div class="col-lg-12">
                <div class="form-wrapper d-flex gap-3">
                    <div class="input-group2">
                        <label for="travelers">Travelers</label>
                        <div class="number-input position-relative">
                            <?= $form->field($packagemodel, 'travelers')->textInput(['class' => 'form-control', 'id' => "travelers", 'value' => 0])->label(false) ?>
                            <div class="bton_updown">
                                <button onclick="increment('travelers')"><i class="fa-solid fa-chevron-up"></i></button>
                                <button onclick="decrement('travelers')"><i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-wrapper">
                    <label for="start-date">Start Date</label>
                    <?= $form->field($packagemodel, 'pack_start_date')->input('date', ['class' => 'form-control'])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                <?= Html::submitButton('Send Request', ['class' => 'sent_btn']) ?>
            </div>
            <div class="col-12">
                <div class="text_get">
                    <p><span>*</span>Your request will be sent directly to the operator, but you can also contact them directly if you prefer.</p>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

</div>