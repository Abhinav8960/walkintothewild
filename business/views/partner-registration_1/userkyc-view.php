<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="card-body">
        <div class="row mb-3">
            <div class="col-md-5">
                <div class="text-box">
                    <p>
                    <span>USER KYC : </span><?= Html::encode($model->owner_name) ?>
                    </p>
                </div>
            </div>
        </div>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">
            <div class="col-md-12">
                <?= Html::a('Close', ['partner-registration/create'], ['class' => 'btn btn-orange text-white']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <style>
        .text-box p span {
            color: brown !important;
        }
    </style>
