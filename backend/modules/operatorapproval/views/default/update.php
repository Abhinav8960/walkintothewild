<?php

use common\models\partnerregistration\PartnerRegistration;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Operator Approval';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Update', 'url' => '#'];
$this->params['title'] = $this->title;
$this->params['businessDomain'] = Yii::$app->params['businessDomain'];
?>

<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Legal Entity
                <?php
                if ($model->form1_status == PartnerRegistration :: FORM_APPROVED) {  ?>
                    ( Approved)
                <?php } elseif ($model->form1_status == PartnerRegistration :: FORM_REJECTED) { ?>
                    ( Reject)
                <?php } ?>
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name :</strong> <?= $model->legal_entity_name ?></p>
                                        <p><strong>Brand Name :</strong> <?= $model->brand_name ?></p>
                                        <p><strong>Email : </strong><?= $model->legal_entity_email ?></p>
                                        <p><strong>Logo : </strong><img src="<?= $this->params['businessDomain'].'/storage/Uploads/'. $model->id . '/' . basename($model->logo)?>" alt="Logo" style="width:100px; height:auto;"></p>
                                        <p><strong>Email : </strong><?= $model->legal_entity_whatsapp ?></p>
                                        <p><strong>Phone No :</strong><?= $model->legal_entity_phone ?></p>
                                        <p><strong>Address :</strong><?= $model->address ?></p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form1_status == PartnerRegistration :: FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 1]) ?>" class="btn btn-success">Approved</a>
                                                <button value="<?= Url::toRoute(['step-reject', 'id' => $model->id, 'step' => 1]) ?>" class="btn btn-danger reject-action">Reject</button>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Business Detail
                <?php
                if ($model->form2_status == PartnerRegistration :: FORM_APPROVED) {  ?>
                    ( Approved)
                <?php } elseif ($model->form2_status == PartnerRegistration :: FORM_REJECTED) { ?>
                    ( Reject)
                <?php } ?>
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Registration Number :</strong> <?= $model->registration_number ?></p>
                                        <p><strong>PAN Number : </strong><?= $model->pan_number ?></p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form2_status == PartnerRegistration:: FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 2]) ?>" class="btn btn-success">Approved</a>
                                                <button value="<?= Url::toRoute(['step-reject', 'id' => $model->id, 'step' => 2]) ?>" class="btn btn-danger reject-action">Reject</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Bank Detail
                <?php
                if ($model->form3_status == PartnerRegistration :: FORM_APPROVED) {  ?>
                    ( Approved)
                <?php } elseif ($model->form3_status == PartnerRegistration :: FORM_REJECTED) { ?>
                    ( Reject)
                <?php } ?>
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Bank Name :</strong> <?= $model->bank_name ?></p>
                                        <p><strong>Account Holder Name : </strong><?= $model->account_holder_name ?></p>
                                        <p><strong>Account No :</strong><?= $model->account_number ?></p>
                                        <p><strong>Ifsc Code :</strong><?= $model->ifsc_number?></p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form3_status == PartnerRegistration :: FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 3]) ?>" class="btn btn-success">Approved</a>
                                                <button value="<?= Url::toRoute(['step-reject', 'id' => $model->id, 'step' => 3]) ?>" class="btn btn-danger reject-action">Reject</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Personal Detail
                <?php
                if ($model->form4_status == PartnerRegistration :: FORM_APPROVED) {  ?>
                    ( Approved)
                <?php } elseif ($model->form4_status == PartnerRegistration::FORM_REJECTED) { ?>
                    ( Reject)
                <?php } ?>
            </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Adhaar Number :</strong> <?= $model->aadhar_number ?></p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form4_status == PartnerRegistration :: FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 4]) ?>" class="btn btn-success">Approved</a>
                                                <button value="<?= Url::toRoute(['step-reject', 'id' => $model->id, 'step' => 4]) ?>" class="btn btn-danger reject-action">Reject</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                User KYC Detail
                <?php
                if ($model->form5_status == PartnerRegistration :: FORM_APPROVED) {  ?>
                    ( Approved)
                <?php } elseif ($model->form5_status == PartnerRegistration :: FORM_REJECTED) { ?>
                    ( Reject)
                <?php } ?>
            </button>
        </h2>
        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong> Number :</strong> <?= $model->kyc_phone ?></p>
                                        <p><strong>PAN Number : </strong><?= $model->kyc_pan ?></p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form5_status == PartnerRegistration :: FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 5]) ?>" class="btn btn-success">Approved</a>
                                                <button value="<?= Url::toRoute(['step-reject', 'id' => $model->id, 'step' => 5]) ?>" class="btn btn-danger reject-action">Reject</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php if (($model->final_approved != 1) && ($model->form1_status == PartnerRegistration :: FORM_APPROVED) && ($model->form2_status == PartnerRegistration :: FORM_APPROVED) && ($model->form3_status == PartnerRegistration :: FORM_APPROVED) && ($model->form4_status == PartnerRegistration :: FORM_APPROVED) &&( $model->form5_status == PartnerRegistration :: FORM_APPROVED)) { ?>
    <a href="<?= Url::toRoute(['final-approved', 'id' => $model->id]) ?>" class="btn btn-success mt-2">Final Approved</a>
<?php } ?>

<div class="modal fade" id="modalReject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Reject Reason
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('.reject-action').on('click', function () {
        $('#modalReject').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>