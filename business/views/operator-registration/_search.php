<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\OperatorFormSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone_no') ?>

    <?= $form->field($model, 'whatsap_no') ?>

    <?php // echo $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'kyc_detail') ?>

    <?php // echo $form->field($model, 'business_registration_name') ?>

    <?php // echo $form->field($model, 'business_brand_name') ?>

    <?php // echo $form->field($model, 'business_full_name') ?>

    <?php // echo $form->field($model, 'business_phone_no') ?>

    <?php // echo $form->field($model, 'business_whatsap_no') ?>

    <?php // echo $form->field($model, 'business_email_id') ?>

    <?php // echo $form->field($model, 'business_logo_upload') ?>

    <?php // echo $form->field($model, 'type_of_business') ?>

    <?php // echo $form->field($model, 'business_doc_reg_no') ?>

    <?php // echo $form->field($model, 'business_kyc_detail') ?>

    <?php // echo $form->field($model, 'business_operated_park') ?>

    <?php // echo $form->field($model, 'business_detail') ?>

    <?php // echo $form->field($model, 'gst') ?>

    <?php // echo $form->field($model, 'bank_name') ?>

    <?php // echo $form->field($model, 'account_holder_name') ?>

    <?php // echo $form->field($model, 'account_no') ?>

    <?php // echo $form->field($model, 'ifsc_code') ?>

    <?php // echo $form->field($model, 'cancle_check') ?>

    <?php // echo $form->field($model, 'upload_adhar_no') ?>

    <?php // echo $form->field($model, 'upload_aadhar_front') ?>

    <?php // echo $form->field($model, 'upload_aadhar_back') ?>

    <?php // echo $form->field($model, 'pan_no') ?>

    <?php // echo $form->field($model, 'pan_upload') ?>

    <?php // echo $form->field($model, 'upload_registration_number') ?>

    <?php // echo $form->field($model, 'upload_registartion_cert') ?>

    <?php // echo $form->field($model, 'upload_document') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
