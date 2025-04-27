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
                <strong class="form-label me-2 text-danger">Legal Name:</strong>
                <span><?= Html::encode($model->legal_entity_name) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Legal Entity Type:</strong>
                <span><?= Html::encode($model->legal_entity_type) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Brand Name:</strong>
                <span><?= Html::encode($model->brand_name) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
    <div class="col-md-6">
        <div class="d-flex align-items-center">
            <strong class="form-label me-2 text-danger">Logo:</strong>
            <span>
            <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->logo) ?>" alt="Logo" style="max-height:100px;">
            </span>
        </div>
    </div>
</div>



    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Legal Entity Phone:</strong>
                <span><?= Html::encode($model->legal_entity_phone) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Legal Entity Whatsapp:</strong>
                <span><?= Html::encode($model->legal_entity_whatsapp) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Legal Entity Email:</strong>
                <span><?= Html::encode($model->legal_entity_email) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Address:</strong>
                <span><?= Html::encode($model->address) ?></span>
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