<?php

use common\models\GeneralModel;

?>

<div class="row">
    <div class="col-12">
        <div class="wrapper-skybgsafri pb-0" style="background-color: #F5F5F5 !important;">
            <div class="row border-bottom border-dark pb-4">
                <div class="col-lg-7 col-md-8 border-right">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="images_tour select_safrai">
                                <img src="<?= isset($package->safarioperator->imagepath) ? $package->safarioperator->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8 pt-sm-0 pt-3">
                            <div class="safrititles">
                                <h5 class="fs-4"><?= $package->package_name ?></h5>
                                <p class="mb-0 ">Organized by <strong><?= isset($package->safarioperator->business_name) ? $package->safarioperator->business_name : '' ?></strong></p>

                                <?php if ($package->master_package_tag_id != null) { ?>
                                    <h5><span class="badge badge-pill" style="background-color: <?= $package->master_package_tag->tag_color ?>;"><?= $package->master_package_tag->tag_name ?></span></h5>
                                <?php } else { ?>
                                    <h5><span class="badge badge-pill" style="background-color: <?= $package->custom_package_tag_color ?>;"><?= $package->custom_package_tag ?></span></h5>
                                <?php } ?>

                            </div>

                            <p class="fs-6 mb-0">
                                <span class=""><?= $package->custom_activity_message ?? '' ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pt-lg-0 pt-4 border-start border-dark">
                    <div class="row ps-1">
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Trip Duration">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $package->no_of_night ?> Nights , <?= $package->no_of_day ?> Days</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-taxi.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pick & Drop">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $package->pickanddrop ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safaris">
                                </div>
                                <div class="text-form">
                                    <!-- <p class="mb-0"><?php
                                                            if ($package->safari_type == 1) {
                                                                echo $package->no_of_safari . ' Shared Safari';
                                                            } elseif ($package->safari_type == 2) {
                                                                echo $package->no_of_safari . ' Private Safari';
                                                            } else if ($package->custom_activity_message) {
                                                                echo $package->custom_activity_message;
                                                            } else {
                                                                echo $package->no_of_safari . ' Shared Safari';
                                                            } ?>
                                    </p> -->
                                    <p class="mb-0"><?= $package->no_of_safari ?> <?php
                                                                                    if ($package->safari_type == 1) {
                                                                                        echo 'Shared Safari';
                                                                                    } elseif ($package->safari_type == 2) {
                                                                                        echo 'Private Safari';
                                                                                    } else {
                                                                                        echo 'Shared Safari';
                                                                                    } ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/path.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Meals">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $package->meals ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <?php if ($package->package_agenda_id && $package->package_agenda_id == 1) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                    <?php } else if ($package->package_agenda_id && $package->package_agenda_id == 3) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/elephant.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                    <?php } else { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                    <?php } ?>
                                </div>
                                <div class="text-form">
                                    <p class="mb-0">
                                        <?= isset(GeneralModel::agendaoption()[$package->package_agenda_id]) ? GeneralModel::agendaoption()[$package->package_agenda_id] : 'Not Included' ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-hotel.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Accommodation">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= isset(GeneralModel::packagemetastaycategory()[$package->stay_category_id]) ? GeneralModel::packagemetastaycategory()[$package->stay_category_id] : 'Not Included' ?></p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-12 m-3">
                    <div class="d-flex align-items-start gap-3">
                        <?php if ($package->cost_per_person_strike_off > 0) { ?>
                            <p class="mb-0 text-muted">
                                <del>
                                    <img src="<?= $this->params['baseurl'] ?>/img/rupees.png" width="16" height="16" class="me-1">
                                    <?= GeneralModel::number_format_indian($package->cost_per_person_strike_off) ?> /-
                                    <span class="perpersonText"></span>
                                </del>
                            </p>
                        <?php } ?>

                        <div>
                            <p class="mb-1">
                                <img src="<?= $this->params['baseurl'] ?>/img/rupees.png" width="16" height="16" class="me-1">
                                <?= number_format($package->cost_per_person) ?> /-
                                <span class="perpersonText">1 Person</span>
                            </p>

                            <p class="mb-1">
                                <span class="text-danger">Total Price: </span>
                                <img src="<?= $this->params['baseurl'] ?>/img/rupees.png" width="16" height="16" class="me-1">
                                <?= number_format($package->total_price) ?>
                            </p>
                        </div>

                        <?php if ($package->cost_per_two_person > 0) { ?>
                            <div class="vr"></div>
                            <p class="mb-0">
                                <img src="<?= $this->params['baseurl'] ?>/img/rupees.png" width="16" height="16" class="me-1">
                                <?= number_format($package->cost_per_two_person) ?> /-
                                <span class="perpersonText">2 Person</span>
                            </p>
                        <?php } ?>
                    </div>
                </div>

                <?php if ($package->custom_price_message != null && $package->custom_price_message != '') { ?>
                    <hr>
                    <p class="fs-6 mb-0">
                        <span class=""><?= $package->custom_price_message ?? '' ?></span>
                    </p>
                <?php } ?>


            </div> -->
            <div class="row">
                <div class="col-12 m-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap pt-lg-0 pt-sm-3 pt-3">

                        <div class="pakageCost mb-xxl-0 mb-2 d-flex">
                            <!-- <del>
                                <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="16px" class="me-1 mb-1">
                                    <?= GeneralModel::number_format_indian($package->cost_per_person_strike_off) ?> /- <span class="perpersonText"></span></h6>
                            </del> -->
                            <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->cost_per_person) ?> / <span class="perpersonText">Per 1 Person</span></h6>
                            <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->cost_per_two_person) ?> / <span class="perpersonText">Per 2 Person</span></h6>
                        </div>
                        <div class="btn-delet float-end py-2">
                            <!-- <a style="background:#F7BF39 !important;color:black !important;padding: 10px 16px !important; border:0; border-radius:10px" href="<?= \yii\helpers\Url::toRoute(['/package/preview/update', 'id' => $package->id]) ?>"><i class="fas fa-check me-1"></i>Mark Package As Pouplar</a>
                                    <button class="btn_userarticle" style="background:red !important;color:black !important;padding: 10px 16px !important; border:0; border-radius:10px" value="<?= \yii\helpers\Url::toRoute(['/package/preview/delete', 'id' => $package->id]) ?>"><i class="fas fa-trash me-1"></i>Delete</button> -->
                        </div>

                    </div>
                    <p class="fs-6 mb-0">
                        <span class=""><?= $package->custom_price_message ?? '' ?></span>
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 pt-4">
                <div class="text_safaripackage">
                    <p><?= $package->package_description ?></p>
                </div>
            </div>
        </div>
        <div class="row  mt-4 itenary_tabs">
            <div class="col-lg-12 col-xl-11 safartabs position-relative">
                <ul class="nav nav-tabs d-none d-lg-flex gap-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">ITINERARY</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" tabindex="-1">INCLUSIONS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="howto-reach" data-bs-toggle="tab" data-bs-target="#getting-there" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" tabindex="-1">GETTING THERE</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="howto-reach" data-bs-toggle="tab" data-bs-target="#policy" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" tabindex="-1">POLICY INFO</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="howto-reach" data-bs-toggle="tab" data-bs-target="#faq" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" tabindex="-1">FAQs</button>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>

<style>
    .banner_image {
        height: 220px !important;
        object-fit: cover !important;
    }
</style>