<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Operator Approval';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Update', 'url' => '#'];
$this->params['title'] = $this->title;

?>

<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Legal Entity
                <?php
                if ($model->is_step_1_approved == 1) {  ?>
                    ( Approved)
                <?php } elseif ($model->is_step_1_approved == 2) { ?>
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
                                        <p><strong>Name :</strong> <?= $model->name ?></p>
                                        <p><strong>Email : </strong><?= $model->email ?></p>
                                        <p><strong>Phone No :</strong><?= $model->phone_no ?></p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->is_step_1_approved == 0) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 1]) ?>" class="btn btn-success">Approved</a>
                                                <a href="<?= Url::toRoute(['step-reject', 'id' => $model->id, 'step' => 1]) ?>" class="btn btn-danger">Reject</a>
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
                if ($model->is_step_2_approved == 1) {  ?>
                    ( Approved)
                <?php } elseif ($model->is_step_2_approved == 2) { ?>
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
                                        <p><strong>Business Registration Name :</strong> <?= $model->business_registration_name ?></p>
                                        <p><strong>Brand Name : </strong><?= $model->business_brand_name ?></p>
                                        <p><strong>Business Whatsapp No :</strong><?= $model->business_whatsap_no ?></p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->is_step_2_approved == 0) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 2]) ?>" class="btn btn-success">Approved</a>
                                                <a href="<?= Url::toRoute(['step-reject', 'id' => $model->id, 'step' => 2]) ?>" class="btn btn-danger">Reject</a>
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
                if ($model->is_step_3_approved == 1) {  ?>
                    ( Approved)
                <?php } elseif ($model->is_step_3_approved == 2) { ?>
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
                                        <p><strong>Account No :</strong><?= $model->account_no ?></p>
                                        <p><strong>Ifsc Code :</strong><?= $model->ifsc_code ?></p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->is_step_3_approved == 0) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 3]) ?>" class="btn btn-success">Approved</a>
                                                <a href="<?= Url::toRoute(['step-reject', 'id' => $model->id, 'step' => 3]) ?>" class="btn btn-danger">Reject</a>
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
                if ($model->is_step_4_approved == 1) {  ?>
                    ( Approved)
                <?php } elseif ($model->is_step_4_approved == 2) { ?>
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
                                        <p><strong>Adhar Number :</strong> <?= $model->upload_adhar_no ?></p>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="float-start">
                                        <div class="d-flex gap-2">
                                            <?php if ($model->is_step_4_approved == 0) { ?>
                                                <a href="<?= Url::toRoute(['step-approved', 'id' => $model->id, 'step' => 4]) ?>" class="btn btn-success">Approved</a>
                                                <a href="<?= Url::toRoute(['step-reject', 'id' => $model->id, 'step' => 4]) ?>" class="btn btn-danger">Reject</a>
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

    <?php if ($model->final_approved != 1 && $model->is_step_1_approved == 1 && $model->is_step_2_approved == 1 && $model->is_step_3_approved == 1 && $model->is_step_4_approved == 1) { ?>
        <a href="<?= Url::toRoute(['final-approved', 'id' => $model->id]) ?>" class="btn btn-success mt-2">Final Approved</a>
    <?php } ?>