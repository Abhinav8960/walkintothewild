<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$reasons = GeneralModel::getFlagreasons();

?>
<div class="modal-body modal_form">
    <?php $form = ActiveForm::begin(['id' => 'flag-form']); ?>
    <div class="row">
        <div class="col-12">
            <div class="selects w-100 d-flex align-items-center gap-3">
                <label for="" class="Modal_label">Reason</label>
                <?= $form->field($model, 'report_reason_id')->dropDownList(
                    $reasons,
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
                <?= $form->field($model, 'report_detail')->textarea(['class' => "form-control", 'placeholder' => "Write....."])->label(false) ?>
            </div>
        </div>
        <div class="col-12">
            <div class="btn_report float-end">
                <div class="btn_report_cance">
                    <button data-bs-dismiss="modal" aria-label="Close" class="close_btns ">Cancel</button>
                    <?= Html::submitButton('Report', ['class' => 'btns_submit']) ?>

                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>