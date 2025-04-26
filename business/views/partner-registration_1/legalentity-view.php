<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

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
                <span><?= Html::encode($model->logo) ?></span>
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
