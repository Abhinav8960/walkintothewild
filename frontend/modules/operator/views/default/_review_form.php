<?php

use common\models\park\SafariPark;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="modal-body modal_form">
    <?php $form = ActiveForm::begin(['id' => 'review-form']); ?>
    <div class="row">
        <div class="col-12 mb-2">
            <label for="" class="label_modal">Where did you go?</label>
            <?= $form->field($modal, 'park_id')->dropDownList(ArrayHelper::map(SafariPark::find()->asArray()->all(), 'id', 'title'), ['prompt' => 'Select a Safari park', 'class' => 'form-select form-select-lg'])->label(false) ?>
        </div>
        <div class="col-12 my-4">
            <div class="stars d-flex gap-4 justify-content-center">
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
                <i class="fa-regular fa-star"></i>
            </div>
        </div>
        <div class="col-lg-12 mb-2 ">
            <div class="textarea">
                <?= $form->field($modal, 'review')->textarea(['placeholder' => 'Write your review about Pugdundee Safaris', 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="col-12 py-2">
            <div class="submir_review">
                <?= Html::submitButton('Submit Review', ['name' => 'submit-button']) ?>
            </div>
        </div>
    </div>
</div>