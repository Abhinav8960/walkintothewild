<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;



?>

<div class="container-fluid py-4">
    <div class="mb-4">
        <h4 class="section-title text-secondary">Bank Details</h4>
    </div>

    <div class="row g-4 info-section">
        <div class="col-md-6">
            <div class="info-line">
                <strong>Bank Name:</strong><span><?= Html::encode($model->bank_name) ?></span>
            </div>
        </div>



        <div class="col-md-6">
            <div class="info-line">
                <strong>Account Holder's Name:</strong>
                <span><?= Html::encode($model->account_holder_name) ?></span>
            </div>
        </div>



        <div class="col-md-6">
            <div class="info-line">
                <strong>Account Number:</strong>
                <span><?= Html::encode($model->account_number) ?></span>
            </div>
        </div>



        <div class="col-md-6">
            <div class="info-line">
                <strong>IFSC :</strong>
                <span><?= Html::encode($model->ifsc_number) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Cancel Check Upload :</strong>
                <span>
                <?php if (!empty($model->cancel_check_upload_path)){?>
                        <a href="<?= $model->cancel_check_upload_path ?>" target="_blank">
                            <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                        </a>
                    <?php } else{ ?>
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