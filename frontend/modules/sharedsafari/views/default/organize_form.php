<?php

use common\interfaces\StatusInterface;
use common\models\meta\MetaStayCategory;
use common\models\park\SafariPark;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'id' => 'organize-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'enableClientScript' => true,
    'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
]); ?>
<div class="modal-body modal_form">

    <div class="row">
        <div class="col-12 mb-2">
            <label for="" class="Modal_label">Select a Safari Park</label>
            <?= $form->field($model, 'park_id')->dropDownList(ArrayHelper::map(SafariPark::find()->where(['status' => StatusInterface::STATUS_ACTIVE, 'is_shared_safari' => 1])->all(), 'id', 'title'), ['prompt' => 'Select a Safari Park', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
        </div>
        <div class="col-md-6 mb-2">
            <label for="" class="Modal_label">Agenda</label>
            <?= $form->field($model, 'share_safari_agenda_id')->dropDownList(['1' => 'Photography', '2' => 'Vlogging', '3' => 'Safari Experience'], ['prompt' => 'Select Agenda', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>

        </div>

        <div class="col-md-6 mb-2">
            <label for="" class="Modal_label">Number of Safaris</label>
            <?= $form->field($model, 'no_of_safari')->dropDownList([1, 2, 3, 4, 5, 6], ['prompt' => 'Select No of Safari', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
        </div>

        <div class="col-md-12 mb-2">
            <div class="d-flex  gap-3 align-items-center w-100 mb-3">
                <div class="start w-100">
                    <label for="" class="Modal_label">Start Date</label>
                    <?= $form->field($model, 'start_date')->textInput(['type' => 'date'])->label(false) ?>
                </div>
                <span class="pt-4">-</span>
                <div class="start w-100">
                    <label for="" class="Modal_label">End Date</label>
                    <?= $form->field($model, 'end_date')->textInput(['type' => 'date'])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <label for="" class="Modal_label">Stay Category</label>
            <?= $form->field($model, 'stay_category_id')->dropDownList(['1' => 'Premium', '2' => 'Budget', '3' => 'Economical'], ['prompt' => 'Stay Category', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
        </div>
        <div class="col-lg-6 mb-2">
            <label for="" class="Modal_label">Estimate Price Per Person</label>
            <div class="d-flex gap-3 align-items-center">
                <?= $form->field($model, 'estimate_price_min')->textInput(['type' => 'number', 'min' => 0, 'class' => 'form-control', 'placeholder' => 1000])->label(false) ?>
                <span>-</span>
                <?= $form->field($model, 'estimate_price_max')->textInput(['type' => 'number', 'min' => 0, 'class' => 'form-control', 'placeholder' => 2000])->label(false) ?>
            </div>

        </div>
        <div class="col-lg-12 mb-2 mt-2">
            <div class="textarea">
                <?= $form->field($model, 'safari_plan')->textInput(['placeholder' => 'Write about your plan'])->label(false) ?>
            </div>

        </div>

    </div>
    <div class="row mt-2 pe-0">
        <div class="col-lg-8">
            <label for="" class="Modal_label">You Are?</label>
            <?= $form->field($model, 'host_type')->dropDownList(['1' => 'Individual', '2' => 'Wildlife Photographer', '3' => 'Wildlife Influencer', '4' => 'Safari Tour Operator'], ['prompt' => 'Select Who you Are?', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>

            <div class="d-flex align-items-center gap-2">
                <div class="selects w-100">
                    <label for="" class="Modal_label">Total Seat</label>
                    <?= $form->field($model, 'total_seat')->dropDownList([2, 3, 4, 5, 6], ['prompt' => 'Total Seat', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
                </div>
                <div class="selects w-100">
                    <label for="" class="Modal_label">Share Seats</label>
                    <?= $form->field($model, 'share_seat')->dropDownList([1, 2, 3, 4, 5], ['prompt' => 'Share Seats', 'class' => 'form-select form-select-lg mb-3'])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pt-4">
            <div class="creat-safri">
                <?= Html::submitButton('Submit', ['class' => 'safari_create font_set']) ?>
            </div>
        </div>
    </div>

</div>
<?php ActiveForm::end() ?>
<style>
    .creat-safri .safari_create {
        height: 33% !important;
    }

    button.safari_create {
        margin-top: 80px !important;
    }
</style>