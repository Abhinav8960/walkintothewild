<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$webasset = Yii::$app->getUrlManager();
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="container-fluid py-4">

    <div class="mb-4">
        <h4 class="section-title text-secondary">Business Details</h4>
    </div>


    <div class="row g-4 info-section">
    <div class="col-md-6">
            <div class="info-line">
                <strong>Operated Park:</strong>
                <span><?= $model->partner_model->park->title ?? ''?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>About Business</strong>
                <span><?= Html::encode($model->about_business) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Billing Mail :</strong>
                <span><?= Html::encode($model->billing_mail) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Billing Phone:</strong>
                <span><?= Html::encode($model->billing_phone) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Gst State:</strong>
                <span><?= $model->partner_model->gstDetails->stateRelation->state_name ?? '' ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Gst Number:</strong>
                <span><?= Html::encode($model->partner_model->gstDetails->gst_number ?? '') ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Gst Image:</strong><br>
                <span>
                    <img src="<?=  Yii::$app->params['s3_endpoint'] .'/'.$model->partner_model->gstDetails->filepath ?>" alt="GSTfile" class="key-img">
                </span>
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