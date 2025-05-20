<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="container-fluid py-4">

    <div class="mb-4">
        <h4 class="section-title text-secondary">Registration Proof</h4>
    </div>

    <div class="row g-4 info-section">
        <div class="col-md-6">
            <div class="info-line">
                <strong>Registration Number :</strong>
                <span><?= Html::encode($model->registration_number) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Registration Copy:</strong>
                <span>
                    <?php if (!empty($model->registration_copy_upload_path) && !empty($model->registration_copy_upload_path)) { ?>
                        <a href="<?= $model->registration_copy_upload_path ?>" target="_blank">
                            <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                        </a>
                    <?php } else { ?>
                        <span class="text-muted">No file uploaded</span>
                    <?php } ?>
                </span>
            </div>
        </div>



        <div class="col-md-6">
            <div class="info-line">
                <strong>PAN Number:</strong>
                <span><?= Html::encode($model->pan_number) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>PAN CARD :</strong>
                <span>
                    <?php if (!empty($model->pan_upload)) { ?>
                        <a href="<?= Yii::$app->params['s3_endpoint'] . '/' . $model->pan_upload ?>" target="_blank">
                            <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                        </a>
                    <?php } else { ?>
                        <span class="text-muted">No file uploaded</span>
                    <?php } ?>
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