<?php

use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
?>

<div class="container-fluid">
    <div class="row mb-4 sticky_set e">
        <div class="col-xl-2 col-lg-3 col-12 mb-lg-0 mb-3 ps-xxl-5 pe-xl-2 pt-3">
            <div id="targetDiv">

            </div>
        </div>
        <div class="col-xl-10 col-lg-9 col-12 paddingset_desktop ">

            <?php

            $form = ActiveForm::begin([
                'id' => 'Quote-form',
                'method' => 'POST',
            ]); ?>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Enter Name']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Enter Email']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Enter phone no']) ?>
                </div>
            </div>
            <div class="row mt-2">

                <div class="col-md-3">
                    <?= $form->field($model, 'from_date')->textInput(['type' => 'date', 'min'=>date('Y-m-d'), 'placeholder' => 'Enter From date']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'to_date')->textInput(['type' => 'date', 'min'=>date('Y-m-d'), 'placeholder' => 'Enter To Date']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'is_date_flexible')->dropDownList([1 => 'Yes', 0 => 'No'], ['prompt' => 'Select', 'class' => 'form-select form-select-lg mb-3 w-100', 'aria-label' => "Large select example"]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'budget')->dropDownList(['Premium' => 'Premium', 'Standard' => 'Standard', 'Economical' => 'Economical'], ['prompt' => 'Select Budget', 'class' => 'form-select form-select-lg mb-3 w-100', 'aria-label' => "Large select example"]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'destination')->dropDownList(['Package' => 'Package', 'Fixed Depature Safari' => 'Fixed Depature Safari'], ['prompt' => 'Looking For', 'class' => 'form-select form-select-lg mb-3 w-100', 'aria-label' => "Large select example"])->label("Looking for") ?>

                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'travelers')->textInput(['type' => 'number', 'placeholder' => 'Total Traveler No']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'is_booking_for_login_user')->dropDownList([1 => 'Yes', 0 => 'No'], ['prompt' => 'Select', 'class' => 'form-select form-select-lg mb-3 w-100', 'aria-label' => "Large select example"])->label("Are you booking for Yourself?") ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'travelers_nationality')->dropDownList(GeneralModel::Countries(), ['placeholder' => 'Enter traveler nationality']) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'addional_notes')->textarea(['rows' => '4']) ?>
                </div>
            </div>

            <div class="col-md-12 mt-2">
                <div class="float-start">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-sm btn-outline-success']) ?>
                </div>

            </div>
            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>