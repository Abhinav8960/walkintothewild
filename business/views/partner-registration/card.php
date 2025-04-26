<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .stepper {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-top: 2rem;
        gap: 0.5rem;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        flex: 1;
        text-align: center;
    }

    .step:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 18px;
        right: -50%;
        height: 2px;
        width: 100%;
        background-color: #dee2e6;
        z-index: 1;
    }

    .step.completed:not(:last-child)::after {
        background-color: rgb(178, 199, 182);
    }

    .circle {
        border: 2px solid rgb(4, 86, 19);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        color: #6c757d;
        z-index: 2;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .step.completed .circle {
        background-color: #198754;
        border-color: #198754;
        color: #fff;
    }

    .label {
        margin-top: 0.5rem;
        font-size: 0.9rem;
        color: #343a40;
    }

    .step.active .circle {
        background-color: rgb(4, 86, 19);
        color: #fff;
    }
</style>

<div class="card shadow-sm border-0 rounded-4 mt-5">
    <div class="card-body p-4 bg-light">
        <div class="row text-center">
            <div class="col-12 mb-3">
                <h4 class="fw-bold">Activate Your Account</h4>
            </div>
            <div class="col-12 mb-2">
                <p class="text-secondary fs-5">
                    Follow these <strong>5 simple steps</strong> to complete your partner account setup.
                </p>
            </div>
            <div class="col-12">
                <p class="text-dark fs-6 fst-italic">
                    “Complete your KYC to activate your business account.”
                </p>
            </div>

            <div class="col-12 stepper mt-4">
                <div class="step <?= $currentStep > 1 ? 'completed' : '' ?> <?= $currentStep == 1 ? 'active' : '' ?>" data-step="1">
                    <div class="circle">1</div>
                    <div class="label">Legal Entity</div>
                </div>
                <div class="step <?= $currentStep > 2 ? 'completed' : '' ?> <?= $currentStep == 2 ? 'active' : '' ?>" data-step="2">
                    <div class="circle">2</div>
                    <div class="label">Registration Proof</div>
                </div>
                <div class="step <?= $currentStep > 3 ? 'completed' : '' ?> <?= $currentStep == 3 ? 'active' : '' ?>" data-step="3">
                    <div class="circle">3</div>
                    <div class="label">Business Details</div>
                </div>
                <div class="step <?= $currentStep > 4 ? 'completed' : '' ?> <?= $currentStep == 4 ? 'active' : '' ?>" data-step="4">
                    <div class="circle">4</div>
                    <div class="label">Bank Details</div>
                </div>
                <div class="step <?= $currentStep > 5 ? 'completed' : '' ?> <?= $currentStep == 5 ? 'active' : '' ?>" data-step="5">
                    <div class="circle">5</div>
                    <div class="label">User KYC</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="accordion" id="formAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading1">
                <button class="accordion-button <?= $currentStep > 1 ? 'bg-success text-white' : ($currentStep == 1 ? '' : 'collapsed') ?>" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse1"
                        aria-expanded="<?= $currentStep == 1 ? 'true' : 'false' ?>" aria-controls="collapse1">
                    Legal Entity
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse <?= $currentStep == 1 ? 'show' : '' ?>"
                 aria-labelledby="heading1" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('legalentity', ['currentStep' => 1, 'model' => $model, 'gst_model' => $gst_model]) ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading2">
                <button class="accordion-button <?= $currentStep > 2 ? 'bg-success text-white' : ($currentStep == 2 ? '' : 'collapsed') ?>" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse2"
                        aria-expanded="<?= $currentStep == 2 ? 'true' : 'false' ?>" aria-controls="collapse2">
                    Registration Proof
                </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse <?= $currentStep == 2 ? 'show' : '' ?>"
                 aria-labelledby="heading2" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('registrationproof', ['currentStep' => 2, 'model' => $model, 'gst_model' => $gst_model]) ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading3">
                <button class="accordion-button <?= $currentStep > 3 ? 'bg-success text-white' : ($currentStep == 3 ? '' : 'collapsed') ?>" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse3"
                        aria-expanded="<?= $currentStep == 3 ? 'true' : 'false' ?>" aria-controls="collapse3">
                    Business Details
                </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse <?= $currentStep == 3 ? 'show' : '' ?>"
                 aria-labelledby="heading3" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('businessdetails', ['currentStep' => 3, 'model' => $model, 'gst_model' => $gst_model]) ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading4">
                <button class="accordion-button <?= $currentStep > 4 ? 'bg-success text-white' : ($currentStep == 4 ? '' : 'collapsed') ?>" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse4"
                        aria-expanded="<?= $currentStep == 4 ? 'true' : 'false' ?>" aria-controls="collapse4">
                    Bank Details
                </button>
            </h2>
            <div id="collapse4" class="accordion-collapse collapse <?= $currentStep == 4 ? 'show' : '' ?>"
                 aria-labelledby="heading4" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('bankdetails', ['currentStep' => 4, 'model' => $model, 'gst_model' => $gst_model]) ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading5">
                <button class="accordion-button <?= $currentStep > 5 ? 'bg-success text-white' : ($currentStep == 5 ? '' : 'collapsed') ?>" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse5"
                        aria-expanded="<?= $currentStep == 5 ? 'true' : 'false' ?>" aria-controls="collapse5">
                    User KYC
                </button>
            </h2>
            <div id="collapse5" class="accordion-collapse collapse <?= $currentStep == 5 ? 'show' : '' ?>"
                 aria-labelledby="heading5" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('userkyc', ['currentStep' => 5, 'model' => $model, 'gst_model' => $gst_model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 

<div class="d-flex justify-content-start mt-3">
    <?= Html::a('<i class="bi bi-send me-2"></i> Send For Approval', Url::to(['partner/send-for-approval']), ['class' => 'btn btn-orange text-black']) ?>
</div> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
