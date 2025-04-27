<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;



$webasset = Yii::$app->getUrlManager();
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="container-fluid py-3">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Owner Name:</strong>
                <span><?= Html::encode($model->owner_name) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Phone Number :</strong>
                <span><?= Html::encode($model->kyc_phone) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger"> Whatsapp :</strong>
                <span><?= Html::encode($model->kyc_whatsapp) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Email :</strong>
                <span><?= Html::encode($model->kyc_email) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">PAN Number :</strong>
                <span><?= Html::encode($model->kyc_pan) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">PAN Uploaded File :</strong>
                <span>
                    <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->kyc_pan_upload) ?>" alt="Logo" style="max-height:100px;">
                </span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Aadhar :</strong>
                <span><?= Html::encode($model->aadhar_number) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Aadhar Front :</strong>
                <span>
                    <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->aadhar_front_upload) ?>" alt="Logo" style="max-height:100px;">
                </span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Aadhar Back :</strong>
                <span>
                    <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->aadhar_back_upload) ?>" alt="Logo" style="max-height:100px;">
                </span>
            </div>
        </div>
    </div>
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