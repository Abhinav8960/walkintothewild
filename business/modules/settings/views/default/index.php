<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="d-flex justify-content-between align-items-center mt-5">
    <h3 class="mt-5">Profile</h3>
</div>

<div class="row d-flex justify-content-center">
    <div class="col col-md-12 col-lg-12 col-xl-12">
        <div class="card" style="border-radius: 15px;">
            <div class="card-content p-4">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img src="<?= $safari_operator_model->imagepath ?>" alt="Operator placeholder image" class="img-fluid" style="width: 180px; border-radius: 10px;">
                    </div>
                    <div class="flex-grow-1 ps-4">
                        <h3 class="mb-2"><?= $safari_operator_model->operator_name ?></h3>
                        <div class="justify-content-start rounded-3 mb-2 bg-body-tertiary">
                            <div>
                                <p><span style="color: red;">Name :</span> <?= $safari_operator_model->operator_name ?></p>
                            </div>
                            <div>
                                <p><span style="color: red;">Partner Phone No :</span> <?= $safari_operator_model->operator_phone_no ?></p>
                            </div>
                            <div>
                                <p><span style="color: red;">Partner Email :</span> <?= $safari_operator_model->operator_email ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="border: 1px solid red;">

                <div class="flex-grow-1">
                    <h3 class="mb-1">Legal Entity</h3>
                    <div class="justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <div>
                            <p><span style="color: red;">Legal Entity Whatsapp No :</span> <?= $safari_operator_model->legal_entity_whatsapp ?></p>
                        </div>
                        <div>
                            <p><span style="color: red;">Address :</span> <?= $safari_operator_model->address ?></p>
                        </div>
                    </div>
                </div>

                <hr style="border: 1px solid red;">

                <div class="flex-grow-1">
                    <h3 class="mb-1">Registration Details</h3>
                    <div class="justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <p><span style="color: red;">Registration Number :</span> <?= $safari_operator_model->registration_number ?></p>
                        <p><span style="color: red;">Registration File :</span>
                            <?php if (!empty($safari_operator_model->registration_copy_upload)) { ?>
                                <a href="<?= $safari_operator_model->registration_copy_upload_path ?>" target="_blank">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                </a>
                            <?php } else { ?>
                                <span class="text-muted">No file uploaded</span>
                            <?php } ?>
                        </p>
                        <p><span style="color: red;">PAN Number :</span> <?= $safari_operator_model->pan_number ?></p>
                        <p><span style="color: red;">PAN File :</span>
                            <?php if (!empty($safari_operator_model->pan_upload)) { ?>
                                <a href="<?= $safari_operator_model->pan_upload_path ?>" target="_blank">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                </a>
                            <?php } else { ?>
                                <span class="text-muted">No file uploaded</span>
                            <?php } ?>
                        </p>
                    </div>
                </div>

                <hr style="border: 1px solid red;">

                <div class="flex-grow-1">
                    <h3 class="mb-1">Business Details</h3>
                    <div class="justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <div style="display: flex; align-items: flex-start; gap: 10px;">
                            <span style="color: red; min-width: 150px;">Operated Park :</span>
                            <div style="flex: 1; background: #f9f9f9; padding: 10px 15px; border-radius: 6px; border: 1px solid #ddd;">
                                <ul style="margin: 0; padding-left: 20px; list-style: disc;">
                                    <?php
                                    foreach ($safari_operator_model->park as $parkList) {
                                        echo '<li>' . htmlspecialchars($parkList->park->title) . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div>
                            <p><span style="color: red;">About Business :</span> <?= $safari_operator_model->about_business ?></p>
                            <p><span style="color: red;">Billing Mail :</span> <?= $safari_operator_model->billing_mail ?></p>
                            <p><span style="color: red;">Billing Phone :</span> <?= $safari_operator_model->billing_phone ?></p>
                            <p><span style="color: red;">State Name : </span><?= $safari_operator_model->gstDetail->stateRelation->state_name ?? '' ?></p>
                            <p><span style="color: red;">GST Number : </span><?= $safari_operator_model->gstDetail->gst_number ?? '' ?></p>
                            <p><span style="color: red;">GST Image : </span>
                                <?php if (!empty($safari_operator_model->gstDetail->gst_upload_path)) { ?>
                                    <a href="<?= $safari_operator_model->gstDetail->gst_upload_path ?>" target="_blank">
                                        <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                    </a>
                                <?php } else { ?>
                                    <span class="text-muted">No file uploaded</span>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>

                <hr style="border: 1px solid red;">

                <div class="flex-grow-1">
                    <h3 class="mb-1">Bank Details</h3>
                    <div class="justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <p><span style="color: red; min-width: 150px;">Bank Name :</span> <?= $safari_operator_model->bank_name ?></p>
                        <p><span style="color: red; min-width: 150px;">Account Holder Name : </span><?= $safari_operator_model->account_holder_name ?></p>
                        <p><span style="color: red; min-width: 150px;">Account No :</span><?= $safari_operator_model->account_number ?></p>
                        <p><span style="color: red; min-width: 150px;">Ifsc Code :</span><?= $safari_operator_model->ifsc_number ?></p>
                        <p><span style="color: red; min-width: 150px;">Cancel Check : </span>
                            <?php if (!empty($safari_operator_model->cancel_check_upload_path)) { ?>
                                <a href="<?= $safari_operator_model->cancel_check_upload_path ?>" target="_blank">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                </a>
                            <?php } else { ?>
                                <span class="text-muted">No file uploaded</span>
                            <?php } ?>
                        </p>
                    </div>
                </div>

                <hr style="border: 1px solid red;">

                <div class="flex-grow-1">
                    <h3 class="mb-1">User KYC Details</h3>
                    <div class="justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <p><span style="color: red; min-width: 150px;">Phone Number :</span> <?= $safari_operator_model->kyc_phone ?></p>
                        <p><span style="color: red; min-width: 150px;">WhatsApp Number :</span> <?= $safari_operator_model->kyc_whatsapp ?></p>
                        <p><span style="color: red; min-width: 150px;">Email :</span> <?= $safari_operator_model->kyc_email ?></p>
                        <p><span style="color: red; min-width: 150px;">Adhaar Number :</span> <?= $safari_operator_model->aadhar_number ?></p>
                        <p><span style="color: red; min-width: 150px;">Aadhar Front : </span>
                            <?php if (!empty($safari_operator_model->aadhar_front_upload_path)) { ?>
                                <a href="<?= $safari_operator_model->aadhar_front_upload_path ?>" target="_blank">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                </a>
                            <?php } else { ?>
                                <span class="text-muted">No file uploaded</span>
                            <?php } ?>
                        </p>
                        <p><span style="color: red; min-width: 150px;">Aadhar Back : </span>
                            <?php if (!empty($safari_operator_model->aadhar_back_upload_path)) { ?>
                                <a href="<?= $safari_operator_model->aadhar_back_upload_path ?>" target="_blank">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                </a>
                            <?php } else { ?>
                                <span class="text-muted">No file uploaded</span>
                            <?php } ?>
                        </p>
                        <p><span style="color: red; min-width: 150px;">PAN Number : </span><?= $safari_operator_model->kyc_pan ?></p>
                        <p><span style="color: red; min-width: 150px;">PAN Card : </span>
                            <?php if (!empty($safari_operator_model->kyc_pan_upload_path)) { ?>
                                <a href="<?= $safari_operator_model->kyc_pan_upload_path ?>" target="_blank">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                </a>
                            <?php } else { ?>
                                <span class="text-muted">No file uploaded</span>
                            <?php } ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>