<?php


use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'quotation-form',
    'method' => 'POST',
    'enableAjaxValidation' => true,
    // 'enableClientValidation' => false,
    // 'enableClientScript' => true,
    // 'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{hint}{error}</div>',
    ],

]); ?>
<div class="row">

    <!-- <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'name')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Travelers name',
        ])->label('Enter Travelers name') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'email')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Email',
        ])->label('Enter Email') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'phone')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter phone',
        ])->label('Enter Phone') ?>
    </div> -->

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'safaris')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Number of Safaris',
        ])->label('Number of Safaris') ?>
    </div>



    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'travelers')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Number of travelers',
        ])->label('Number of travelers') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::packageoption(), ['prompt' => 'Select'])->label('Accomodation') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'park_id')->dropDownList(
            GeneralModel::operatorsafariparkoption($model->partner_id),
            [
                'prompt' => 'Select Park',
            ]
        )->label('Park') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label('Start date') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'end_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label('End date') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'validity_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label('Validity date') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'permit_booking_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label('Permit Booking date') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'installment')->textInput([
            'maxlength' => true,
            'disabled' => true,
            'placeholder' => 'Enter Number of installment',
        ])->label('Number of Installment') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'partner_selling_price')->textInput(['placeholder' => 'Enter selling price', 'id' => 'partner_selling_price'])->hint('<div class="text-muted">Platform fees in percentage: ' . $model->plateform_partner_fees_percentage . ' %</div>') ?>
    </div>


    <table id="calculation-table" class="table table-responsive d-none text-center">
        <thead>
            <th>Plateform Partner Fees Percentage</th>
            <th>Plateform Partner Fees</th>
            <th>Partner net selling Price</th>
            <th>Plateform customer Discount</th>
            <th>Net Payment Price</th>
        </thead>
        <tbody>
            <tr>
                <td id="plateform_partner_fees_percentage"><?= $model->plateform_partner_fees_percentage ?>%</td>
                <td id="plateform_partner_fees"></td>
                <td id="partner_net_selling_price"></td>
                <td id="plateform_customer_discount">₹<?= $model->plateform_customer_discount  ?></td>
                <td id="net_payment_price"></td>
            </tr>
        </tbody>
    </table>








</div>
<div class="row">
    <div class="col-md-12">
        <div class="float-start santBtn w-auto gap-2">
            <?= Html::submitButton('Submit') ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
$('#quotation-form').on('input', '#partner_selling_price', function() {
    var sellingPrice = parseFloat($(this).val());
    var feesPercentage = parseFloat($('#plateform_partner_fees_percentage').text().replace('%', ''));

    if (!isNaN(sellingPrice) && sellingPrice > 0 && !isNaN(feesPercentage)) {
        // Calculate platform fees
        var platformFees = (sellingPrice * feesPercentage) / 100;
        $('#plateform_partner_fees').text('₹'+platformFees.toFixed(2)); // Display calculated fees

        // Calculate partner net selling price
        var netSellingPrice = sellingPrice + platformFees;
        $('#partner_net_selling_price').text('₹'+netSellingPrice.toFixed(2)); // Display net selling price
        $('#net_payment_price').text('₹'+netSellingPrice.toFixed(2)); // Display net selling price
        $('#calculation-table').removeClass('d-none');
    } else {
        // Clear values if input is invalid
        $('#plateform_partner_fees').text('');
        $('#partner_net_selling_price').text('');
        $('#net_payment_price').text('');
        $('#calculation-table').addClass('d-none');

    }
});
JS;
$this->registerJs($script);
?>



<style>
    .santBtn button {
        border: 1px solid #000;
        padding: 8px 20px;
        background-color: #09422d;
        border-radius: 4px;
        color: #fff;
    }
</style>