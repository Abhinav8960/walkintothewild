<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<div class="col-lg-12 col-xxl-7 col-xl-10" id="memberview">
    <div class="get_free_title">
        <h4>Get a FREE quote</h4>
    </div>
    <div class="getquote_box">
        <?php
        // $form = ActiveForm::begin([
        //     'id' => 'quoteform',
        //     'enableAjaxValidation' => true,
        //     'enableClientValidation' => false,
        //     'enableClientScript' => true,
        //     'action' => $model->action_url,
        //     'validationUrl' => $model->action_validate_url,
        // ]); 
        ?>

        <?php $form = ActiveForm::begin([
            'id' => 'quoteform',
            'method' => 'POST',
            'fieldConfig' => [
                'template' => '<div class="form-group">{label}{input}{error}</div>',
            ],

        ]); ?>
        <div class="row ">
            <div class="col-lg-3">
                <div class="form-wrapper">
                    <label for="">Safari Park</label>
                    <?= $form->field($model, 'safari_park_id')->dropDownList(GeneralModel::operatorsafariparkoption($operator->id), ['prompt' => 'Select', 'class' => "form-select mb-3", 'aria-label' => "Default select example"])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-wrapper d-flex gap-3">
                    <div class="input-group2 mb-3">
                        <label for="safaris">Safaris</label>
                        <div class="number-input position-relative">
                            <?= $form->field($model, 'safaris')->textInput(['class' => 'form-control', 'id' => "safaris", 'value' => 0])->label(false) ?>
                            <div class="bton_updown">
                                <button onclick="increment('safaris')"><i class="fa-solid fa-chevron-up"></i></button>
                                <button onclick="decrement('safaris')"><i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                        </div>

                    </div>
                    <div class="input-group2">
                        <label for="travelers">Travelers</label>
                        <div class="number-input position-relative">
                            <?= $form->field($model, 'travelers')->textInput(['class' => 'form-control', 'id' => "travelers", 'value' => 0])->label(false) ?>
                            <div class="bton_updown">
                                <button onclick="increment('travelers')"><i class="fa-solid fa-chevron-up"></i></button>
                                <button onclick="decrement('travelers')"><i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-wrapper">
                    <label for="">Stay Category</label>
                    <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::staycategoryoption(), ['prompt' => 'Select', 'class' => "form-select mb-3", 'aria-label' => "Default select example"])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-wrapper">
                    <label for="start-date">Start Date</label>
                    <?= $form->field($model, 'start_date')->input('date', ['class' => 'form-control'])->label(false) ?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-wrapper">
                    <label for="end-date">End Date</label>
                    <?= $form->field($model, 'end_date')->input('date', ['class' => 'form-control'])->label(false) ?>
                </div>
            </div>

            <?php if (empty(Yii::$app->user->identity)) { ?>
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
                        <?= $form->field($model, 'phone_no')->textInput(['class' => 'form-control', 'placeholder' => '0000000000'])->label(false) ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (!empty(Yii::$app->user->identity)) {
                $class = "col-lg-4 order-2 pt-lg-0  content-center";
            } else {
                $class = "col-lg-3 margi_top pt-lg-0 pb-3";
            } ?>
            <div class="<?= $class ?>">
                <?= Html::submitButton('Send Request', ['class' => 'sent_btn w-auto float-end']) ?>
            </div>
            <div class="col-8 order-1">
                <div class="text_get">
                    <p class=""><span>*</span>Your request will be sent directly to the operator, but you can
                        also contact them directly if you prefer.</p>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>