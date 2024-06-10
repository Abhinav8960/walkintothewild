<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<div class="col-lg-12 col-xl-9">
    <div class="get_free_title">
        <h4>Get a FREE quote</h4>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'reply-form']); ?>

    <div class="getquote_box">
        <div class="row ">
            <div class="col-lg-3">
                <div class="form-wrapper">
                    <label for="">Safari Park</label>
                    <?= $form->field($model, 'safari_park_id')->dropDownList(GeneralModel::operatorsafariparkoption($operator->id), ['class' => "form-select mb-3", 'aria-label' => "Default select example"])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-wrapper d-flex gap-3">
                    <div class="input-group2 mb-3">
                        <label for="safaris">Safaris</label>
                        <div class="number-input position-relative">
                            <input type="number" id="safaris" value="6" class="form-control">
                            <div class="bton_updown">
                                <button onclick="increment('safaris')"><i class="fa-solid fa-chevron-up"></i></button>
                                <button onclick="decrement('safaris')"><i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                        </div>

                    </div>
                    <div class="input-group2">
                        <label for="travelers">Travelers</label>
                        <div class="number-input position-relative">
                            <input type="number" id="travelers" value="6" class="form-control">
                            <div class="bton_updown">
                                <button onclick="decrement('travelers')"><i class="fa-solid fa-chevron-up"></i></button>
                                <button onclick="decrement('travelers')"><i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-wrapper">
                    <label for="">Stay Category</label>
                    <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::staycategoryoption(), ['class' => "form-select mb-3", 'aria-label' => "Default select example"])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-wrapper">
                    <label for="">Start Date</label>
                    <?= $form->field($model, 'start_date')->textInput(['class' => 'form-control'])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-wrapper">
                    <label for="">End Date</label>
                    <?= $form->field($model, 'end_date')->textInput(['class' => 'form-control'])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-wrapper mb-3">
                    <label for="">Full Name</label>
                    <?= $form->field($model, 'full_name')->textInput(['class' => 'form-control', 'placeholder' => 'Your name'])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-wrapper mb-3">
                    <label for="">Email Address</label>
                    <?= $form->field($model, 'email')->textInput(['class' => 'form-control', 'placeholder' => 'xyz@abc.com'])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-wrapper mb-3">
                    <label for="">Phone Number</label>
                    <?= $form->field($model, 'phone_no')->textInput(['class' => 'form-control', 'placeholder' => '+91'])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-3 margi_top pt-lg-0 pb-3">
                <?= Html::submitButton('Send Request', ['class' => 'sent_btn']) ?>
            </div>
            <div class="col-12">
                <div class="text_get">
                    <p><span>*</span>Your request will be sent directly to the operator, but you can
                        also contact them directly if you prefer.</p>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>