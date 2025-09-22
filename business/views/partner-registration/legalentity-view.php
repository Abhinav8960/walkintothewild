<?php

use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;


$webasset = Yii::$app->getUrlManager();
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="container-fluid py-4">



    <div class="mb-4">
        <h4 class="section-title text-secondary">Legal Entity Details</h4>
    </div>

    <div class="row g-4 info-section">
        <div class="col-md-6">
            <div class="info-line">
                <strong>Legal Name:</strong>
                <span><?= Html::encode($model->legal_entity_name) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Legal Entity Type:</strong>
                <span><?= $model->legal_entity_type ? GeneralModel::operatortype($model->legal_entity_type) : '' ; ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Brand Name:</strong>
                <span><?= Html::encode($model->brand_name) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Logo:</strong>
                <span>
                    <?php if (isset($model->logo_path)) { ?>
                        <img src="<?= $model->logo_path ?>" alt="Logo" class="key-img">
                    <?php } else {
                        echo '<span class="text-muted">No file uploaded</span>';
                    } ?>
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Legal Entity Phone:</strong>
                <span><?= Html::encode($model->legal_entity_phone) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Legal Entity Whatsapp:</strong>
                <span><?= Html::encode($model->legal_entity_whatsapp) ?></span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-line">
                <strong>Legal Entity Email:</strong>
                <span><?= Html::encode($model->legal_entity_email) ?></span>
            </div>
        </div>

        <div class="col-md-12">
            <div class="info-line">
                <strong>Address:</strong>
                <span><?= Html::encode($model->address) ?></span>
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
        max-height: 100px;
        margin-top: 0.5rem;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
</style>