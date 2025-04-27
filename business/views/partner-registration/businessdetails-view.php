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

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Gst State:</strong>
                <span><?= Html::encode($model->partner_model->gstDetails->stateRelation->state_name ?? '') ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Gst Number:</strong>
                <span><?= Html::encode($model->partner_model->gstDetails->gst_number ?? '') ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Gst Image:</strong>
                <span>
                    <img src="<?= $this->params['baseurl'] . '/storage/' . $model->partner_model->gstDetails->filepath ?? ''?>" alt="GST Image" style="max-height:100px;">
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