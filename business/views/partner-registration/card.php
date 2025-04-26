<?php

use yii\bootstrap5\Html;

$steps = [
    1 => 'Legal Entity',
    2 => 'Registration Proof',
    3 => 'Business Details',
    4 => 'Bank Details',
    5 => 'User KYC'
];
?>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->

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
                <?php foreach ($steps as $step => $label): ?>
                    <div class="step <?= $currentStep > $step ? 'completed' : '' ?> <?= $currentStep == $step ? 'active' : '' ?>" data-step="<?= $step ?>">
                        <div class="circle"><?= $step ?></div>
                        <div class="label"><?= $label ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>


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