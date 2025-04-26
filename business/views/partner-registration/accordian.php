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
                    <?= $this->render('legalentity', ['currentStep' => 1, 'model' => $model]) ?>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
