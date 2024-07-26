<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<div class="modal-body modal_form">
    <?php $form = ActiveForm::begin(['id' => 'report-form']); ?>
    <div class="row">
        <div class="col-12">
            <div class="selects w-100 d-flex align-items-center gap-3">
                <label for="" class="Modal_label">Reason</label>
                <?= $form->field($model, 'reason_id')->dropDownList(
                    [
                        '1' => 'Scam,Fraud, or False Information',
                        'spam' => [
                            '21' => 'Me',
                            '22' => 'A business',
                            '23' => 'Else',
                        ],
                        '3' => 'Fake Page',
                        '4' => 'Other Form'
                    ],
                    [
                        'class' => "form-select form-select-lg",
                        'aria-label' => "Large select example",
                        'prompt' => 'Select Reason'
                    ]
                )->label(false) ?>
            </div>
        </div>
        <div class="col-lg-12 mb-2 mt-2">
            <label for="" class="Modal_label">Details</label>
            <div class="textarea">
                <?= $form->field($model, 'reason')->textInput(['placeholder' => 'Write Reason', 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="col-12">
            <div class="btn_report float-end">
                <div class="btn_report_cance">
                    <button data-bs-dismiss="modal" aria-label="Close" class="close_btns ">Cancel</button>
                    <?= Html::submitButton('Submit', ['class' => 'btns_submit']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>