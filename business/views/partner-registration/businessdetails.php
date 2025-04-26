<?php

use yii\helpers\Url;

?>
<?= $this->render('card', ['currentStep' => 3]) ?>

<div class="container mt-5">
    <div class="accordion" id="formAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading1">
                <button class="accordion-button d-flex align-items-center" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse1"
                    aria-expanded="true" aria-controls="collapse1">
                    Legal Entity
                    <span class="ms-auto">
                        <a href="<?= Url::toRoute(['create']) ?>"><i class="bi bi-pencil-square"></i></a>
                    </span>
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show"
                aria-labelledby="heading1" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('legalentity-view', ['currentStep' => 1, 'model' => $model]) ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading2">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse2"
                    aria-expanded="false" aria-controls="collapse2">
                    Registration Proof
                    <span class="ms-auto">
                        <a href="<?= Url::toRoute(['step-2']) ?>"><i class="bi bi-pencil-square"></i></a>
                    </span>
                </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse show"
                aria-labelledby="heading2" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('registrationproof-view', ['currentStep' => 2, 'model' => $model]) ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading3">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse3"
                    aria-expanded="false" aria-controls="collapse3">
                    Business Details
                    <span class="ms-auto">
                        <a href="<?= Url::toRoute(['step-3']) ?>"><i class="bi bi-pencil-square"></i></a>
                    </span>
                </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse show"
                aria-labelledby="heading3" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('_businessdetails_form', ['currentStep' => 3, 'model' => $model, 'gst_model' => $gst_model]) ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading4">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse4"
                    aria-expanded="false" aria-controls="collapse4">
                    Bank Details
                </button>
            </h2>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading5">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse5"
                    aria-expanded="false" aria-controls="collapse5">
                    User KYC
                </button>
            </h2>
        </div>
    </div>
</div>