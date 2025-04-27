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
                <strong class="form-label me-2 text-danger">Registration Number :</strong>
                <span><?= Html::encode($model->registration_number) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">Registration Copy:</strong>
                <span>
                <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->registration_copy_upload) ?>" alt="Logo" style="max-height:100px;">
                </span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">PAN Number:</strong>
                <span><?= Html::encode($model->pan_number) ?></span>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <strong class="form-label me-2 text-danger">PAN Upload:</strong>
                <span>
                <img src="<?= $this->params['baseurl'] . '/storage/Uploads/' . $model->partner_model->id . '/' . basename($model->pan_upload) ?>" alt="Logo" style="max-height:100px;">
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
