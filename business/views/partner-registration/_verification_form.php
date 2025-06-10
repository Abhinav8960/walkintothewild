<?php

use common\models\MobileVerification;
use common\models\partnerregistration\PartnerRegistration;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'mobile-verification',
        'enctype' => 'multipart/form-data',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'enableClientScript' => true,
    ]
]); ?>

<?php
$sendOtpButton = Html::button('Send OTP', ['class' => 'btn btn-light text-success', 'id' => 'send-otp-btn']);
$verifyOtpButton = Html::button('Verify OTP', ['class' => 'btn btn-orange', 'id' => 'verify-otp-btn']);
?>

<div id="flash-message-container"></div>


<div class="row">

    <div class="col-md-6">
        <?= $form->field($verification_model, 'mobile_no', [
            'template' =>
            '<label class="form-label">{label}</label>
         <div class="input-group">
             {input}' .
                $sendOtpButton .
                '</div>
         {error}',
            'errorOptions' => ['class' => 'invalid-feedback d-block text-danger'],
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter',
            'readonly' => $readOnly,
            'onkeypress' => 'return /[0-9]/i.test(event.key)',
            'maxlength' => 10
        ])->label('Phone Number') ?>
    </div>


    <!-- OTP section (initially hidden) -->
    <div class="row mt-3" id="otp-section" style="display: none;">
        <div class="col-md-6">
            <?= $form->field($verification_model, 'otp_by_user', [
                'template' =>
                '<label class="form-label">{label}</label>
         <div class="input-group">
             {input}' .
                    $verifyOtpButton .
                    '</div>
         {error}',
                'errorOptions' => ['class' => 'invalid-feedback d-block text-danger'],
            ])->textInput([
                'id' => 'mobileverification-otp_by_user',
                'class' => 'form-control',
                'placeholder' => 'Enter OTP',
                'readonly' => $readOnly,
                'onkeypress' => 'return /[0-9]/i.test(event.key)',
                'maxlength' => 6
            ]) ?>
        </div>
        <input type="hidden" id="hidden-mobile-no" value="<?= Html::encode($verification_model->mobile_no) ?>">
        <input type="hidden" name="hidden-source-type" value="<?= Html::encode($verification_model->source_type) ?>">
    </div>
</div>

<?php ActiveForm::end(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
$sendotpurl = \yii\helpers\Url::to(['partner-registration/send-otp-mobile']);
$verifyOtpUrl = \yii\helpers\Url::to(['partner-registration/otp-verification-mobile']);
$csrfToken = \Yii::$app->request->csrfToken;

$this->registerJs(<<<JS

$('#send-otp-btn').on('click', function(e) {
    e.preventDefault();

    let mobileNo = $('#mobileverification-mobile_no').val();
    if (!/^[6-9]\d{9}$/.test(mobileNo)) {
        alert('Please enter a valid 10-digit mobile number!');
        return;
    }
    
    $('#send-otp-btn').prop('disabled',true);

    $.ajax({
        url: '$sendotpurl',
        type: 'POST',
        dataType: 'json',
        data: {
            'mobile_no': mobileNo,
            _csrf: '$csrfToken'
        },
        success: function(response) {
            if (!response.success) {
            // Show flash message without reload
                \$('#flash-message-container').html(`
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert">
                        <div>
                            <span><i class="bi bi-exclamation-triangle-fill me-2"></i></span> 
                            <strong>Error : </strong>`+response.message +`
                        </div>
                        <button type="button" class="btn btn-sm text-dark fs-2 fw-bold border-0 bg-transparent" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                    </div>
                `);

                $('#send-otp-btn').prop('disabled', false);
                
            } else if (response.success) {

            // Show flash message without reload
                \$('#flash-message-container').html(`
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert">
                        <div>
                            <strong>`+response.message +`</strong>
                        </div>
                        <button type="button" class="btn btn-sm text-dark fs-2 fw-bold border-0 bg-transparent" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                    </div>
                `);
           

                $('#otp-section').slideDown();
                $('#send-otp-btn').text('Resend OTP');
                $('#send-otp-btn').prop('disabled', false);
            } else {
                alert(response.message || 'Something went wrong');
                $('#send-otp-btn').prop('disabled', false);
            }
        },
        // error: function(xhr) {
        //     alert('Error: ' + xhr.responseText);
        // }
    });
});

let otpVerified = false;

$('#verify-otp-btn').on('click', function(e) {
    e.preventDefault();

    let otp_by_user = $('#mobileverification-otp_by_user').val();
    let mobileNo = $('#mobileverification-mobile_no').val();

    if (!otp_by_user) {
        alert('Please enter OTP.');
        return;
    }

    $.ajax({
        url: '$verifyOtpUrl',
        type: 'POST',
        dataType: 'json',
        data: {
            otp_by_user: otp_by_user,
            mobile_no: mobileNo,
            _csrf: '$csrfToken'
        },
        success: function(response) {
            if (!response.success) {
            // Show flash message without reload
                \$('#flash-message-container').html(`
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert">
                        <div>
                            <span><i class="bi bi-exclamation-triangle-fill me-2"></i></span> 
                            <strong>Error : </strong>`+response.message +`
                        </div>
                        <button type="button" class="btn btn-sm text-dark fs-2 fw-bold border-0 bg-transparent" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                    </div>
                `);

            } else if(response.success) {
                alert(response.message || 'OTP Verified');
                otpVerified = true;

                // Disable input after successful verification
                $('#mobileverification-otp_by_user').prop('readonly', true);
                $('#verify-otp-btn').prop('disabled', true);
                $('#send-otp-btn').prop('disabled', true);
            } else {
                alert(response.message || 'Invalid OTP');
            }
        },
        // error: function(xhr) {
        //     alert('Error: ' + xhr.responseText);
        // }
    });
});

JS);
?>

<?php
$this->registerJs(<<<JS
$('#mobile-verification').on('submit', function(e) {
    if (!otpVerified) {
        alert('Please verify your mobile number before submitting.');
        e.preventDefault();
    }
});
JS);
?>