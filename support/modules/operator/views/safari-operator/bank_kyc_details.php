<?php

use common\models\GeneralModel;
use yii\helpers\Url;

$this->title = 'Safari Tour Operator : ' . $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'User Kyc Details';
$this->params['title'] = $this->title;

$budget = [];
if ($model->is_offer_premium_budget == 1) {
    $budget[] = "Premium";
}
if ($model->is_offer_standard_budget == 1) {
    $budget[] = "Standard";
}
if ($model->is_offer_economical_budget == 1) {
    $budget[] = "Economical";
}

$html = '';
$activies = GeneralModel::operatorresquestactivties($model->id);
foreach ($activies as $key => $role) {
    if (isset(GeneralModel::wildlifeactivities()[$key])) {
        $html .= GeneralModel::wildlifeactivities()[$key] . ', ';
    }
}

$html_park = '';
$park = GeneralModel::operatorpark($model->id);
foreach ($park as $key => $role) {
    if (isset(GeneralModel::safariparkoption()[$key])) {
        $html_park .= GeneralModel::safariparkoption()[$key] . ', ';
    }
}
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@support/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'bank-and-kyc-details']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-box">
                                <div class="d-flex align-items-center mb-3">
                                    <strong class="fs-5">Bank Details</strong>
                                </div>
                                <p>
                                    <span>Bank Name :</span> <?= $model->bank_name ?? 'N/A'?>
                                </p>
                                <p>
                                    <span>Account Holder Name : </span><?= $model->account_holder_name ?? 'N/A' ?>
                                </p>
                                <p>
                                    <span>Account No :</span><?= $model->account_number ?? 'N/A'?>
                                </p>
                                <p>
                                    <span>Ifsc Code :</span><?= $model->ifsc_number ?? 'N/A' ?>
                                </p>
                                <p>
                                    <span>Cancel Check : </span>
                                    <?php if (!empty($model->cancel_check_upload) && strtolower(pathinfo($model->cancel_check_upload, PATHINFO_EXTENSION)) === 'pdf'){?>
                                        <button value="<?= Url::to(['file-view', 'filepath' => $model->cancel_check_upload]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                            <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" style = "width : 40px ; height : 40px;">
                                        </button>
                                    <?php } else{ ?>
                                        <span class="text-muted" style="color: #6c757d !important;">No file uploaded</span>
                                    <?php } ?>
                                </p>

                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="text-box">
                               
 
                                    <div class="d-flex align-items-center mb-3">
                                        <strong class="fs-5">User KYC Details</strong>
                                    </div>
                                    <p><span>KYC Phone Number :</span> <?= $model->kyc_phone ?? 'N/A'?></p>
                                    <p><span>KYC WhatsApp Number :</span> <?= $model->kyc_whatsapp ?? 'N/A'?></p>
                                    <p><span>KYC  Email :</span> <?= $model->kyc_email ?? 'N/A'?></p>
                                    <p><span>KYC Adhaar Number :</span> <?= $model->aadhar_number ?? 'N/A'?></p>
                                    <p><span>KYC Aadhar Front : </span>
                                    <?php if (!empty($model->aadhar_front_upload)&& strtolower(pathinfo($model->aadhar_front_upload, PATHINFO_EXTENSION)) === 'pdf'){?>
                                        <button value="<?= Url::to(['file-view', 'filepath' => $model->aadhar_front_upload]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                            <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" style = "width : 40px ; height : 40px;">
                                        </button>
                                    <?php } else{ ?>
                                        <span class="text-muted" style="color: #6c757d !important;">No file uploaded</span>
                                    <?php } ?>
                                    </p>
                                    <p><span>KYC Aadhar Back : </span>
                                    <?php if (!empty($model->aadhar_back_upload) && strtolower(pathinfo($model->aadhar_back_upload, PATHINFO_EXTENSION)) === 'pdf'){?>
                                        <button value="<?= Url::to(['file-view', 'filepath' => $model->aadhar_back_upload]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                            <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" style = "width : 40px ; height : 40px;">
                                        </button>
                                    <?php } else{ ?>
                                        <span class="text-muted" style="color: #6c757d !important;">No file uploaded</span>
                                    <?php } ?>
                                    </p>
                                    <p><span>KYC PAN Number : </span><?= $model->kyc_pan ?? 'N/A'?></p>
                                    <p><span>KYC PAN Card : </span>
                                    <?php if (!empty($model->kyc_pan_upload) && strtolower(pathinfo($model->kyc_pan_upload, PATHINFO_EXTENSION)) === 'pdf'){?>
                                        <button value="<?= Url::to(['file-view', 'filepath' => $model->kyc_pan_upload]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                            <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" style = "width : 40px ; height : 40px;">
                                        </button>
                                    <?php } else{ ?>
                                        <span class="text-muted" style="color: #6c757d !important;">No file uploaded</span>
                                    <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
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



<style>
    .text-box p span {
        color: brown !important;
    }
</style>

<?php
$script = <<< JS

    \$('.file-view').on('click', function () {
            \$('#modalfileview').modal('show')
    \t\t.find('#modalContent')
    \t\t.load(\$(this).attr('value'));
    \t});

JS;
$this->registerJs($script);
?>