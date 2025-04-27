<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

?>
<?= $this->render('card', ['currentStep' => 5]) ?>

<div class="container mt-5">
    <div class="accordion" id="formAccordion">

        <!-- Legal Entity -->
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="heading1">
                <button class="accordion-button collapsed flex-grow-1 text-start" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse1"
                    aria-expanded="false" aria-controls="collapse1">
                    Legal Entity
                    <span class="ms-auto">
                        <a href="<?= Url::toRoute(['create']) ?>" class="text-decoration-none">
                            <i class="bi bi-pencil text-black"></i>
                        </a>
                    </span>
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('legalentity-view', ['currentStep' => 1, 'model' => $model]) ?>
                </div>
            </div>
        </div>

        <!-- Registration Proof -->
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="heading2">
                <button class="accordion-button collapsed d-flex align-items-center" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse2"
                    aria-expanded="false" aria-controls="collapse2">
                    Registration Proof
                    <span class="ms-auto">
                        <a href="<?= Url::toRoute(['step-2']) ?>" class="text-decoration-none">
                            <i class="bi bi-pencil text-black"></i>
                        </a>
                    </span>
                </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('registrationproof-view', ['currentStep' => 2, 'model' => $model]) ?>
                </div>
            </div>
        </div>

        <!-- Business Details -->
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="heading3">
                <button class="accordion-button collapsed d-flex align-items-center" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse3"
                    aria-expanded="false" aria-controls="collapse3">
                    Business Details
                    <span class="ms-auto">
                        <a href="<?= Url::toRoute(['step-3']) ?>" class="text-decoration-none">
                            <i class="bi bi-pencil text-black"></i>
                        </a>
                    </span>
                </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('businessdetails-view', ['currentStep' => 3, 'model' => $model]) ?>
                </div>
            </div>
        </div>

        <!-- Bank Details -->
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="heading4">
                <button class="accordion-button collapsed d-flex align-items-center" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse4"
                    aria-expanded="false" aria-controls="collapse4">
                    Bank Details
                    <span class="ms-auto">
                        <a href="<?= Url::toRoute(['step-4']) ?>" class="text-decoration-none">
                            <i class="bi bi-pencil text-black"></i>
                        </a>
                    </span>
                </button>
            </h2>
            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('bankdetails-view', ['currentStep' => 4, 'model' => $model]) ?>
                </div>
            </div>
        </div>

        <!-- User KYC -->
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="heading5">
                <button class="accordion-button collapsed d-flex align-items-center" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse5"
                    aria-expanded="false" aria-controls="collapse5">
                    User KYC
                    <span class="ms-auto">
                        <a href="<?= Url::toRoute(['step-5']) ?>" class="text-decoration-none">
                            <i class="bi bi-pencil text-black"></i>
                        </a>
                    </span>
                </button>
            </h2>
            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('userkyc-view', ['currentStep' => 5, 'model' => $model]) ?>
                </div>
            </div>
        </div>

    </div>

    <div class="text-start mt-4">
        <?= Html::a('<i class="fas fa-paper-plane"></i> Send For Approval', ['send-approval', 'id' => $partner_model->id], [
            'class' => 'btn btn-warning text-black fw-bold',
            'data' => [
                'method' => 'post',
                'confirm' => 'Are you sure you want to send for approval?',
            ],
        ]) ?>
    </div>
</div>
