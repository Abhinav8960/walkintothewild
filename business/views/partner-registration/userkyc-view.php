<?php

use yii\bootstrap5\Html;

$webasset = Yii::$app->getUrlManager();
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="container-fluid py-4">
    <div class="mb-4">
        <h4 class="section-title text-secondary">KYC Details</h4>
    </div>

    <div class="row g-4 info-section">
        <div class="col-md-6">
            <div class="info-line"><strong>Owner Name:</strong> <?= Html::encode($model->owner_name) ?></div>
        </div>
        <div class="col-md-6">
            <div class="info-line"><strong>Phone Number:</strong> <?= Html::encode($model->kyc_phone) ?></div>
        </div>
        <div class="col-md-6">
            <div class="info-line"><strong>Whatsapp:</strong> <?= Html::encode($model->kyc_whatsapp) ?></div>
        </div>
        <div class="col-md-6">
            <div class="info-line"><strong>Email:</strong> <?= Html::encode($model->kyc_email) ?></div>
        </div>
        <div class="col-md-6">
            <div class="info-line"><strong>PAN Number:</strong> <?= Html::encode($model->kyc_pan) ?></div>
        </div>
        <div class="col-md-6">
            <div class="info-line"><strong>Aadhar Number:</strong> <?= Html::encode($model->aadhar_number) ?></div>
        </div>
        <div class="col-md-6">
            <div class="info-line"><strong>PAN Uploaded File:</strong><br>
                <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->kyc_pan_upload) ?>" alt="PAN" class="kyc-img">
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-line"><strong>Aadhar Front:</strong><br>
                <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->aadhar_front_upload) ?>" alt="Aadhar Front" class="kyc-img">
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-line"><strong>Aadhar Back:</strong><br>
                <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->aadhar_back_upload) ?>" alt="Aadhar Back" class="kyc-img">
            </div>
        </div>
    </div>
</div>

<style>
    .section-title {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        color: #2c3e50;
    }

    .info-section {
        font-size: 1rem;
        color: #333;
        padding: 1.5rem;
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .info-line {
        font-size: 1rem;
        font-weight: 500;
        color: #2c3e50;
    }

    .info-line strong {
        margin-right: 5px;
    }

    .kyc-img {
        max-height: 200px;
        margin-top: 0.5rem;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
</style>
