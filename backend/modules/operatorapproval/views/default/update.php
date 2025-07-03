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
            <button class="accordion-button <?= ($model->form1_status == PartnerRegistration::FORM_FILLED && $model->resent_after_rejection) ? 'bg-dark text-light': '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Legal Entity
                <?php
                if ($model->form1_status == PartnerRegistration::FORM_APPROVED) {
                    ?>
                    ( Approved)
                <?php } elseif ($model->form1_status == PartnerRegistration::FORM_REJECTED) { ?>
                    ( Rejected )
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
                                        <p><strong>Logo : </strong>
                                        <?php if(isset($model->logo)){?>
                                        <img src="<?= $model->logo_path ?>" alt="Logo" style="width:100px; height:auto;">
                                        <?php }else{ 
                                        echo '<span class="text-muted">No file uploaded</span>';
                                        }?>
                                        </p>
                                        <p><strong>Email : </strong><?= $model->legal_entity_whatsapp ?></p>
                                        <p><strong>Phone No :</strong><?= $model->legal_entity_phone ?></p>
                                        <p><strong>Address :</strong><?= $model->address ?></p>
                                    </div>
                                    <?php if ($model->form1_status == PartnerRegistration::FORM_REJECTED) { ?>
                                        <div class="col-md-6">
                                            <p><strong>Rejected Reason :</strong> <?= $partner_model->form1_reject_reason ?></p>
                                        </div>
                                    <?php
    ;
}
?>
                                </div>



                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form1_status == PartnerRegistration::FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 1]) ?>" class="btn btn-success">Approve</a>
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
            <button class="accordion-button collapsed <?= ($model->form2_status == PartnerRegistration::FORM_FILLED && $model->resent_after_rejection) ? 'bg-dark text-light' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Registration Details
                <?php
                if ($model->form2_status == PartnerRegistration::FORM_APPROVED) {
                    ?>
                    ( Approved)
                <?php } elseif ($model->form2_status == PartnerRegistration::FORM_REJECTED) { ?>
                    ( Rejected )
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
                                        <p><strong>Registration File : </strong>
                                        <?php if (!empty($model->registration_copy_upload_path)){?>
                                            <button value="<?= Url::to(['file-view', 'filepath' => $model->registration_copy_upload_path]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                            </button>
                                        <?php } else{ ?>
                                            <span class="text-muted">No file uploaded</span>
                                        <?php } ?>
                                        </p>
                                        <p><strong>PAN Number : </strong><?= $model->pan_number ?></p>
                                        <p><strong>PAN Card : </strong>
                                        <?php if (!empty($model->pan_upload_path)){?>
                                            <button value="<?= Url::to(['file-view', 'filepath' => $model->pan_upload_path]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                            </button>
                                        <?php } else{ ?>
                                            <span class="text-muted">No file uploaded</span>
                                        <?php } ?>
                                        </p>
                                    </div>

                                    <?php if ($model->form2_status == PartnerRegistration::FORM_REJECTED) { ?>
                                        <div class="col-md-6">
                                            <p><strong>Rejected Reason :</strong> <?= $partner_model->form2_reject_reason ?></p>
                                        </div>
                                    <?php
    ;
}
?>
                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form2_status == PartnerRegistration::FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 2]) ?>" class="btn btn-success">Approve</a>
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
            <button class="accordion-button collapsed <?= ($model->form3_status == PartnerRegistration::FORM_FILLED && $model->resent_after_rejection) ? 'bg-dark text-light' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Business Details
                <?php
                if ($model->form3_status == PartnerRegistration::FORM_APPROVED) {
                    ?>
                    ( Approved)
                <?php } elseif ($model->form3_status == PartnerRegistration::FORM_REJECTED) { ?>
                    ( Rejected )
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
                                        <p><strong>Park to Operate :</strong>  
                                            <?php
                                            $park_names = [];
                                            foreach ($model->partner_model->parkList as $parkList) {
                                                 $park_names[] = $parkList->park->title;
                                            }
                                            echo implode(', ', $park_names);
                                            ?>
                                        </p>
                                        <p><strong>About Business :</strong> <?= $model->about_business ?></p>
                                        <p><strong>Billing Mail :</strong> <?= $model->billing_mail ?></p>
                                        <p><strong>Billing Phone :</strong> <?= $model->billing_phone ?></p>
                                        <p><strong>State Name : </strong><?= $model->partner_model->gstDetail->stateRelation->state_name ?? '' ?></p>
                                        <p><strong>GST Number : </strong><?= $model->partner_model->gstDetail->gst_number ?? '' ?></p>
                                        <p><strong>GST Image : </strong>
                                            <?php if (!empty($model->partner_model->gstDetail->gst_upload_path)){?>
                                                <button value="<?= Url::to(['file-view', 'filepath' => $model->partner_model->gstDetail->gst_upload_path]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                    <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                                </button>
                                            <?php } else{ ?>
                                                <span class="text-muted">No file uploaded</span>
                                            <?php } ?>
                                        </p>
                                    </div>
                                    <?php if ($model->form3_status == PartnerRegistration::FORM_REJECTED) { ?>
                                        <div class="col-md-6">
                                            <p><strong>Rejected Reason :</strong> <?= $partner_model->form3_reject_reason ?></p>
                                        </div>
                                    <?php
    ;
}
?>
                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form3_status == PartnerRegistration::FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 3]) ?>" class="btn btn-success">Approve</a>
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
            <button class="accordion-button collapsed <?= ($model->form4_status == PartnerRegistration::FORM_FILLED && $model->resent_after_rejection) ? 'bg-dark text-light' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Bank Details
                <?php
                if ($model->form4_status == PartnerRegistration::FORM_APPROVED) {
                    ?>
                    ( Approved)
                <?php } elseif ($model->form4_status == PartnerRegistration::FORM_REJECTED) { ?>
                    ( Rejected )
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
                                        <p><strong>Bank Name :</strong> <?= $model->bank_name ?></p>
                                        <p><strong>Account Holder Name : </strong><?= $model->account_holder_name ?></p>
                                        <p><strong>Account No :</strong><?= $model->account_number ?></p>
                                        <p><strong>Ifsc Code :</strong><?= $model->ifsc_number ?></p>
                                        <p><strong>Cancel Check : </strong>
                                        <?php if (!empty($model->cancel_check_upload_path)){?>
                                            <button value="<?= Url::to(['file-view', 'filepath' => $model->cancel_check_upload_path]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                            </button>
                                        <?php } else{ ?>
                                            <span class="text-muted">No file uploaded</span>
                                        <?php } ?>
                                        </p>
                                    </div>
                                    <?php if ($model->form4_status == PartnerRegistration::FORM_REJECTED) { ?>
                                        <div class="col-md-6">
                                            <p><strong>Rejected Reason :</strong> <?= $partner_model->form4_reject_reason ?></p>
                                        </div>
                                    <?php
    ;
}
?>
                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form4_status == PartnerRegistration::FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 4]) ?>" class="btn btn-success">Approve</a>
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
            <button class="accordion-button collapsed <?= ($model->form5_status == PartnerRegistration::FORM_FILLED && $model->resent_after_rejection) ? 'bg-dark text-light' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                Personal Details
                <?php
                if ($model->form5_status == PartnerRegistration::FORM_APPROVED) {
                    ?>
                    (Approved)
                <?php } elseif ($model->form5_status == PartnerRegistration::FORM_REJECTED) { ?>
                    (Rejected )
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
                                        <p><strong>Phone Number :</strong> <?= $model->kyc_phone ?></p>
                                        <p><strong>WhatsApp Number :</strong> <?= $model->kyc_whatsapp ?></p>
                                        <p><strong> Email :</strong> <?= $model->kyc_email ?></p>
                                        <p><strong>Adhaar Number :</strong> <?= $model->aadhar_number ?></p>
                                        <p><strong>Aadhar Front : </strong>
                                        <?php if (!empty($model->aadhar_front_upload_path)){?>
                                            <button value="<?= Url::to(['file-view', 'filepath' => $model->aadhar_front_upload_path]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                            </button>
                                        <?php } else{ ?>
                                            <span class="text-muted">No file uploaded</span>
                                        <?php } ?>
                                        </p>
                                        <p><strong>Aadhar Back : </strong>
                                        <?php if (!empty($model->aadhar_back_upload_path)){?>
                                            <button value="<?= Url::to(['file-view', 'filepath' => $model->aadhar_back_upload_path]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                            </button>
                                        <?php } else{ ?>
                                            <span class="text-muted">No file uploaded</span>
                                        <?php } ?>
                                        </p>
                                        <p><strong>PAN Number : </strong><?= $model->kyc_pan ?></p>
                                        <p><strong>PAN Card : </strong>
                                        <?php if (!empty($model->kyc_pan_upload_path)){?>
                                            <button value="<?= Url::to(['file-view', 'filepath' => $model->kyc_pan_upload_path]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                            </button>
                                        <?php } else{ ?>
                                            <span class="text-muted">No file uploaded</span>
                                        <?php } ?>
                                        </p>
                                    
                                    </div>
                                    <?php if ($model->form5_status == PartnerRegistration::FORM_REJECTED) { ?>
                                        <div class="col-md-6">
                                            <p><strong>Rejected Reason :</strong> <?= $partner_model->form5_reject_reason ?></p>
                                        </div>
                                    <?php ;}?>
                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->form5_status == PartnerRegistration::FORM_FILLED) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 5]) ?>" class="btn btn-success">Approve</a>
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



<?php if (($partner_model->final_approved != 1) && ($partner_model->form1_status == PartnerRegistration::FORM_APPROVED) && ($partner_model->form2_status == PartnerRegistration::FORM_APPROVED) && ($partner_model->form3_status == PartnerRegistration::FORM_APPROVED) && ($partner_model->form4_status == PartnerRegistration::FORM_APPROVED) && ($partner_model->form5_status == PartnerRegistration::FORM_APPROVED)) { ?>
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

<div class="modal fade" id="modalfileview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Document Preview
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<<JS

        \$('.reject-action').on('click', function () {
            \$('#modalReject').modal('show')
    \t\t.find('#modalContent')
    \t\t.load(\$(this).attr('value'));
    \t});
     
    \$('.file-view').on('click', function () {
            \$('#modalfileview').modal('show')
    \t\t.find('#modalContent')
    \t\t.load(\$(this).attr('value'));
    \t});

    JS;
$this->registerJs($script);
?>