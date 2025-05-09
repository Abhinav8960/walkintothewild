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
                                <p> <span style="color: red;">Name :</span> <?= $safari_operator_model->operator_name ?></p>
                            </div>
                            <div>
                                <p> <span style="color: red;">Partner Phone No :</span> <?= $safari_operator_model->operator_phone_no ?></p>
                            </div>
                            <div>
                                <p> <span style="color: red;">Partner Email :</span> <?= $safari_operator_model->operator_email ?></p>
                            </div>
                        </div>

                    </div>

                </div>
                <hr style="border: 1px solid red;">
                <div class="flex-grow-1">
                    <h3 class="mb-1">Legal Entity</h3>
                    <div class="justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <div>
                            <p> <span style="color: red;">Legal Entity Whatsapp No :</span> <?= $safari_operator_model->legal_entity_whatsapp ?></p>
                        </div>
                        <div>
                            <p> <span style="color: red;">Address :</span> <?= $safari_operator_model->address ?></p>
                        </div>
                    </div>
                </div>
                <hr style="border: 1px solid red;">
                <div class="flex-grow-1">
                    <h3 class="mb-1">Registration Details</h3>
                    <div class="justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <div>
                            <p> <span style="color: red;">Registration Number :</span> <?= $safari_operator_model->registration_number ?></p>
                            <p><span style="color: red;">Registration File :</span>
                                <?php if (!empty($safari_operator_model->registration_copy_upload)) { ?>
                                    <a href="<?= Yii::$app->params['s3_endpoint'] . '/' . $safari_operator_model->registration_copy_upload ?>" target="_blank">
                                        <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" width="50">
                                    </a>
                                <?php } else { ?>
                                    <span class="text-muted">No file uploaded</span>
                                <?php } ?>
                            </p>
                            <p> <span style="color: red;">PAN Number :</span> <?= $safari_operator_model->pan_number ?></p>
                            <p> <span style="color: red;">PAN File :</span>
                                <?php if (!empty($safari_operator_model->pan_upload)) { ?>
                                    <a href="<?= Yii::$app->params['s3_endpoint'] . '/' . $safari_operator_model->pan_upload ?>" target="_blank">
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
                    <h3 class="mb-1">Business Details</h3>
                    <div class="justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                        <div>
                            <p> <span style="color: red;">About :</span> <?= $safari_operator_model->about_business ?></p>
                            <div style="display: flex; align-items: flex-start;">
                                <span style="color: red; min-width: 150px;">Operated Park :</span>
                                <ul style="margin: 0; padding-left: 20px;">
                                    <?php if ($operator_parks = $safari_operator_model->park) {
                                        foreach ($operator_parks as $operator_park) { ?>
                                            <li><?= isset($operator_park->park) ? $operator_park->park->title : '' ?></li>
                                    <?php }
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>