<?= $this->render('card', ['currentStep' => 1]) ?>

<div class="container mt-5">
    <div class="accordion" id="formAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading1">
                <button class="accordion-button" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse1"
                    aria-expanded="true" aria-controls="collapse1">
                    Legal Entity
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show"
                aria-labelledby="heading1" data-bs-parent="#formAccordion">
                <div class="accordion-body">
                    <?= $this->render('_legalentity_form', ['currentStep' => 1, 'model' => $model]) ?>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading2">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse2"
                    aria-expanded="false" aria-controls="collapse2">
                    Registration Proof
                </button>
            </h2>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="heading3">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse3"
                    aria-expanded="false" aria-controls="collapse3">
                    Business Details
                </button>
            </h2>
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