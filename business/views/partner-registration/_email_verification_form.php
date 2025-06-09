<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'email-verification',
        'enctype' => 'multipart/form-data',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'enableClientScript' => true,
    ]
]); ?>

<div class="row">

    <div class="col-md-6">
        <?php
        $sendOtpButton = Html::button('Send OTP', [
            'class' => 'btn btn-light',
            'id' => 'send-otp-btn'
        ]);
        ?>

        <?= $form->field($verification_model, 'email', [
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
        ])->label('Billing Mail') ?>


    </div>


    <!-- OTP section (initially hidden) -->
    <div class="row mt-3" id="otp-section" style="display: none;">
        <div class="col-md-3">
            <?= $form->field($verification_model, 'otp_by_user')->textInput([
                'id' => 'emailverification-otp_by_user',
                'class'=>'form-control',
                'placeholder' => 'Enter OTP',
                'readonly' => $readOnly,
                'onkeypress' => 'return /[0-9]/i.test(event.key)',
                'maxlength'=>6
            ]) ?>
        </div>
        <input type="hidden" id="hidden-email" value="<?= Html::encode($verification_model->email) ?>">
        <input type="hidden" name="hidden-source-type" value="<?= Html::encode($verification_model->source_type)?>">

        <div class="col-md-2 mt-4">
            <input type="hidden" id="otp-record-id" value="">
           <?= Html::button('Verify OTP', [
            'class' => 'btn btn-dark',
            'id' => 'verify-otp-btn'
        ]); ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
$sendotpurl = \yii\helpers\Url::to(['partner-registration/send-otp-email']);
$verifyOtpUrl = \yii\helpers\Url::to(['partner-registration/otp-verification-email']);
$csrfToken = \Yii::$app->request->csrfToken;

$this->registerJs(<<<JS

$('#send-otp-btn').on('click', function(e) {
    e.preventDefault();

    let email = $('#emailverification-email').val();
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert('Please enter a valid email address');
        return;
    }

    $('#send-otp-btn').prop('disabled',true);

    $.ajax({
        url: '$sendotpurl',
        type: 'POST',
        dataType: 'json',
        data: {
            'email': email,
            _csrf: '$csrfToken'
        },
        success: function(response) {
            if (response.success) {
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

    let otp_by_user = $('#emailverification-otp_by_user').val();
    let email = $('#emailverification-email').val();

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
            email: email,
            _csrf: '$csrfToken'
        },
        success: function(response) {
            if (response.success) {
                alert(response.message || 'OTP Verified');
                otpVerified = true;

                // Disable input after successful verification
                $('#emailverification-otp_by_user').prop('readonly', true);
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
$('#email-verification').on('submit', function(e) {
    if (!otpVerified) {
        alert('Please verify your email before submitting.');
        e.preventDefault();
    }
});
JS);
?>
