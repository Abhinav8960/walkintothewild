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
    </div>
</div>
