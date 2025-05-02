<?php

use common\models\partnerregistration\PartnerRegistration;
use yii\bootstrap5\Html;
use yii\helpers\Url;

?>

<?php if ($model->partner_model->final_approved != 1) { ?>

    <?= $this->render('card', ['currentStep' => 3]) ?>

    <div class="container mt-5">
        <div class="accordion" id="formAccordion">


            <!-- Legal Entity -->
            <div class="accordion-item mb-3">
                <?php if ($partner_model->form1_status == PartnerRegistration::FORM_REJECTED) { ?>
                    <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading1">
                        <button class="accordion-button collapsed flex-grow-1 text-start background-danger text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse1"
                            aria-expanded="false" aria-controls="collapse1">
                            Legal Entity
                            <a href="<?= Url::toRoute(['create']) ?>" class="text-decoration-none px-3">
                                <i class="bi bi-pencil text-white fs-5"></i>
                            </a>
                            <span id="form_1_rejectedTooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $partner_model->form1_reject_reason ?>">
                            <i class="bi bi-info text-white fs-5"></i>
                        </span>
                        </button>

                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#formAccordion">
                        <div class="accordion-body">
                            <?= $this->render('legalentity-view', ['currentStep' => 1, 'model' => $model]) ?>
                        </div>
                    </div>
                <?php ;
                } elseif ($partner_model->form1_status == PartnerRegistration::FORM_FILLED) { ?>
                    <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading1">
                        <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse1"
                            aria-expanded="false" aria-controls="collapse1">
                            Legal Entity
                            <a href="<?= Url::toRoute(['create']) ?>" class="text-decoration-none px-3">
                                <i class="bi bi-pencil text-white fs-5"></i>
                            </a>
                        </button>

                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#formAccordion">
                        <div class="accordion-body">
                            <?= $this->render('legalentity-view', ['currentStep' => 1, 'model' => $model]) ?>
                        </div>
                    </div>
                <?php ;
                } elseif ($partner_model->form1_status == PartnerRegistration::FORM_APPROVED) { ?>
                    <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading1">
                        <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse1"
                            aria-expanded="false" aria-controls="collapse1">
                            Legal Entity
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#formAccordion">
                        <div class="accordion-body">
                            <?= $this->render('legalentity-view', ['currentStep' => 1, 'model' => $model]) ?>
                        </div>
                    </div>
                <?php ;
                } else { ?>
                    <h2 class="accordion-header" id="heading1">
                        <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse1"
                            aria-expanded="false" aria-controls="collapse1">
                            Legal Entity
                            <span class="ms-auto">
                                <a href="<?= Url::toRoute(['create']) ?>" class="text-decoration-none">
                                </a>
                            </span>
                        </button>
                    </h2>
                <?php ;
                } ?>
            </div>

            <!-- Registration Proof -->


            <div class="accordion-item mb-3">
                <?php if ($partner_model->form2_status == PartnerRegistration::FORM_REJECTED) { ?>
                    <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading2">
                        <button class="accordion-button collapsed flex-grow-1 text-start background-danger text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse2"
                            aria-expanded="false" aria-controls="collapse2" data-bs-toggle="tooltip"
                            data-bs-placement="right"
                            title="<?= $partner_model->form2_reject_reason ?>">
                            Registration Proof
                            <a href="<?= Url::toRoute(['step-2']) ?>" class="text-decoration-none px-3">
                                <i class="bi bi-pencil text-white fs-5"></i>
                            </a>
                            <span id="form_2_rejectedTooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $partner_model->form2_reject_reason ?>">
                            <i class="bi bi-info text-white fs-5"></i>
                        </span>
                        </button>

                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#formAccordion">
                        <div class="accordion-body">
                            <?= $this->render('registrationproof-view', ['currentStep' => 2, 'model' => $model]) ?>
                        </div>
                    </div>
                <?php ;
                } elseif ($partner_model->form2_status == PartnerRegistration::FORM_FILLED) { ?>
                    <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading2">
                        <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse2"
                            aria-expanded="false" aria-controls="collapse2">
                            Registration Proof
                            <a href="<?= Url::toRoute(['step-2']) ?>" class="text-decoration-none px-3">
                                <i class="bi bi-pencil text-white fs-5"></i>
                            </a>
                        </button>

                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#formAccordion">
                        <div class="accordion-body">
                            <?= $this->render('registrationproof-view', ['currentStep' => 2, 'model' => $model]) ?>
                        </div>
                    </div>
                <?php ;
                } elseif ($partner_model->form2_status == PartnerRegistration::FORM_APPROVED) { ?>
                    <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading2">
                        <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse2"
                            aria-expanded="false" aria-controls="collapse2">
                            Registration Proof
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#formAccordion">
                        <div class="accordion-body">
                            <?= $this->render('registrationproof-view', ['currentStep' => 2, 'model' => $model]) ?>
                        </div>
                    </div>
                <?php ;
                } else { ?>
                    <h2 class="accordion-header" id="heading2">
                        <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse2"
                            aria-expanded="false" aria-controls="collapse2">
                            Registration Proof
                            <span class="ms-auto">
                                <a href="<?= Url::toRoute(['step-2']) ?>" class="text-decoration-none">
                                </a>
                            </span>
                        </button>
                    </h2>
                <?php ;
                } ?>
            </div>








            <!-- Business Details -->


            <div class="accordion-item mb-3">
                <?php if ($partner_model->form3_status == PartnerRegistration::FORM_REJECTED) { ?>
                    <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading3">
                        <button class="accordion-button collapsed flex-grow-1 text-start background-danger text-white" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse3"
                            aria-expanded="false" aria-controls="collapse3">
                            Business Details
                            <span id="form_3_rejectedTooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $partner_model->form3_reject_reason ?>">
                            <i class="bi bi-info text-white fs-5"></i>
                        </span>
                        </button>
                    </h2>
                <?php ;
                } else { ?>
            <h2 class="accordion-header" id="heading3">
                <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse3"
                    aria-expanded="false" aria-controls="collapse3">
                    Business Details
                    <span class="ms-auto">
                        <a href="<?= Url::toRoute(['step-3']) ?>" class="text-decoration-none">
                        </a>
                    </span>
                </button>
            </h2>
        <?php ;
                } ?>
        <div id="collapse3" class="accordion-collapse collapse show" aria-labelledby="heading3" data-bs-parent="#formAccordion">
            <div class="accordion-body">
                <?= $this->render('_businessdetails_form', ['currentStep' => 3, 'model' => $model, 'gst_model' => $gst_model]) ?>
            </div>
        </div>
        </div>




        <!-- Bank Details -->



        <div class="accordion-item mb-3">
            <?php if ($partner_model->form4_status == PartnerRegistration::FORM_REJECTED) { ?>
                <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading4">
                    <button  class="accordion-button collapsed flex-grow-1 text-start background-danger text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse4"
                        aria-expanded="false" aria-controls="collapse4">
                        Bank Details
                        <a href="<?= Url::toRoute(['step-4']) ?>" class="text-decoration-none px-3">
                            <i class="bi bi-pencil text-white fs-5"></i>
                        </a>
                        <span id="form_4_rejectedTooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $partner_model->form4_reject_reason ?>">
                            <i class="bi bi-info text-white fs-5"></i>
                        </span>
                    </button>

                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <?= $this->render('bankdetails-view', ['currentStep' => 4, 'model' => $model]) ?>
                    </div>
                </div>
            <?php ;
            } elseif ($partner_model->form4_status == PartnerRegistration::FORM_FILLED) { ?>
                <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading4">
                    <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse4"
                        aria-expanded="false" aria-controls="collapse4">
                        Bank Details
                        <a href="<?= Url::toRoute(['step-4']) ?>" class="text-decoration-none px-3">
                            <i class="bi bi-pencil text-white fs-5"></i>
                        </a>
                    </button>

                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <?= $this->render('bankdetails-view', ['currentStep' => 4, 'model' => $model]) ?>
                    </div>
                </div>
            <?php ;
            } elseif ($partner_model->form4_status == PartnerRegistration::FORM_APPROVED) { ?>
                <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading4">
                    <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse4"
                        aria-expanded="false" aria-controls="collapse4">
                        Bank Details
                    </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <?= $this->render('bankdetails-view', ['currentStep' => 4, 'model' => $model]) ?>
                    </div>
                </div>
            <?php ;
            } else { ?>
                <h2 class="accordion-header" id="heading4">
                    <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse4"
                        aria-expanded="false" aria-controls="collapse4">
                        Bank Details
                        <span class="ms-auto">
                            <a href="<?= Url::toRoute(['step-4']) ?>" class="text-decoration-none">
                            </a>
                        </span>
                    </button>
                </h2>
            <?php ;
            } ?>
        </div>



        <!-- User KYC -->

        <div class="accordion-item mb-3">
            <?php if ($partner_model->form5_status == PartnerRegistration::FORM_REJECTED) { ?>
                <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading5">
                    <button class="accordion-button collapsed flex-grow-1 text-start background-danger text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse5"
                        aria-expanded="false" aria-controls="collapse5">
                        User KYC
                        <a href="<?= Url::toRoute(['step-5']) ?>" class="text-decoration-none px-3">
                            <i class="bi bi-pencil text-white fs-5"></i>
                        </a>
                        <span id="form_5_rejectedTooltip" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $partner_model->form5_reject_reason ?>">
                            <i class="bi bi-info text-white fs-5"></i>
                        </span>
                    </button>

                </h2>
                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <?= $this->render('userkyc-view', ['currentStep' => 5, 'model' => $model]) ?>
                    </div>
                </div>
            <?php ;
            } elseif ($partner_model->form5_status == PartnerRegistration::FORM_FILLED) { ?>
                <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading5">
                    <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse5"
                        aria-expanded="false" aria-controls="collapse5">
                        User KYC
                        <a href="<?= Url::toRoute(['step-5']) ?>" class="text-decoration-none px-3">
                            <i class="bi bi-pencil text-white fs-5"></i>
                        </a>
                    </button>
                </h2>
                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <?= $this->render('userkyc-view', ['currentStep' => 5, 'model' => $model]) ?>
                    </div>
                </div>
            <?php ;
            } elseif ($partner_model->form5_status == PartnerRegistration::FORM_APPROVED) { ?>
                <h2 class="accordion-header d-flex align-items-stretch justify-content-between" id="heading5">
                    <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse5"
                        aria-expanded="false" aria-controls="collapse5">
                        User KYC
                    </button>
                </h2>
                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <?= $this->render('userkyc-view', ['currentStep' => 5, 'model' => $model]) ?>
                    </div>
                </div>
        </div>
            <?php ;
            } else { ?>
                <h2 class="accordion-header" id="heading5">
                    <button class="accordion-button collapsed flex-grow-1 text-start background-success text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse5"
                        aria-expanded="false" aria-controls="collapse5">
                        User KYC
                        <span class="ms-auto">
                            <a href="<?= Url::toRoute(['step-5']) ?>" class="text-decoration-none">
                            </a>
                        </span>
                    </button>
                </h2>
            <?php ;
            } ?>
        </div>


    </div>
    </div>

<?php ;
} else {
?>

    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="text-center p-5 border rounded-4 shadow bg-light" style="border-left: 6px solid #28a745; max-width: 600px;">
            <div class="mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.08-.02l3.992-4.99a.75.75 0 1 0-1.15-.96L7.525 9.507 5.384 7.384a.75.75 0 1 0-1.06 1.06l2.646 2.586z" />
                </svg>
            </div>
            <h2 class="text-success fw-bold mb-2">Approved</h2>
            <p class="mb-4 text-muted" style="font-size: 1.1rem;">Your form has been successfully Approved!</p>
            <?= Html::a('Go to Your Dashboard', ['/'], [
                'class' => 'btn btn-success fw-bold px-5 py-2',
                'style' => 'font-size: 16px; letter-spacing: 0.5px; color: white;',
            ]) ?>
        </div>
    </div>
<?php ;
}
?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        for (let i = 1; i <= 5; i++) {
            let element = document.getElementById(`form_${i}_rejectedTooltip`);
            if (element) {
                new bootstrap.Tooltip(element, {
                    delay: {
                        show: 700,
                        hide: 300
                    },
                    customClass: 'custom-tooltip-box'
                });
            }
        }
    });
</script>
<style>
    .custom-tooltip-box .tooltip-inner {
        background-color: #f8d7da;
        /* light red background */
        color: rgb(12, 8, 9);
        /* dark red text */
        border: 1px solidrgb(161, 22, 36);
        padding: 15px 20px;
        font-size: 16px;
        border-radius: 8px;
        min-width: 250px;
        max-width: 400px;
        text-align: left;
        white-space: normal;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>