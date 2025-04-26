<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="container-fluid py-3">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Operated Park:</strong>
                <span><?= Html::encode($model->operated_park) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">About Business</strong>
                <span><?= Html::encode($model->about_business) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Billing Mail :</strong>
                <span><?= Html::encode($model->billing_mail) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Billing Phone:</strong>
                <span><?= Html::encode($model->billing_phone) ?></span>
            </div>
        </div>
    </div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row mt-4">
        <div class="col-md-12 d-flex justify-content-end">
            <?= Html::a('Close', ['partner-registration/create'], ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<style>
    .form-label {
        font-weight: 600;
        font-size: 1rem;
    }

    .container-fluid span {
        font-size: 1rem;
        color: #444;
    }
</style>
