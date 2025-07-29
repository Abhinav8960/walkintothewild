<?php

use common\models\GeneralModel;
use common\models\sharesafari\ShareSafariIncluded;

?>

<div class="row">
    <div class="col-12">
        <div class="wrapper-skybgsafri pb-0" style="background-color: #F5F5F5 !important;">
            <div class="row border-bottom border-dark pb-4">
                <div class="col-lg-7 col-md-8 border-right">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="images_tour select_safrai">
                                <img src="<?= isset($share_safari->sharedimagepath) ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="">
                            </div>
                        </div>
                        <div class="col-lg-8 pt-sm-0 pt-3">
                            <div class="safrititles">
                                <h2 class="m-0 lh-1 d-inline font-devator"><?= $share_safari->share_safari_title ?></h2>
                                <h6 class="titler_safari my-3"><span style="color:#4b4b4b;">Fixed Departure</span> <?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?> <?= isset($share_safari->cut_off_date) ? ' | <span style="color:#4b4b4b;">Cut off Date</span> ' . date('d M y', strtotime($share_safari->cut_off_date)) : '' ?> </h6>
                                <h6 class="titler_safari my-3"><i class="fa-solid fa-location-dot me-1"></i> <?= $share_safari->park->title ?><br></h6>
                                <p class="mb-0 ">Organized by <strong><?= $share_safari->organizedbyname ?></strong></p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 pt-lg-0 pt-4 border-start border-dark">
                    <div class="row ps-1">
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg"><img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Trip Duration"></div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $share_safari->tour_duration - 1 ?> Nights , <?= $share_safari->tour_duration ?> Days</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-taxi.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pick & Drop">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?php
                                                    $pick_drop_includes = ShareSafariIncluded::find()->where(['share_safari_id' => $share_safari->share_safari_id, 'include_id' => 3, 'selection' => 1, 'status' => 1, 'version' => $share_safari->version])->limit(1)->one();

                                                    echo ($pick_drop_includes) ? 'Included' : 'Not Included';
                                                    ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safaris">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $share_safari->no_of_safari ?> Shared Safari
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
                                    <p class="mb-0"><?= $share_safari->meals ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <?php if ($share_safari->share_safari_agenda_id && $share_safari->share_safari_agenda_id == 1) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="">
                                    <?php  } else if ($share_safari->share_safari_agenda_id && $share_safari->share_safari_agenda_id == 3) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/elephant.png" alt="">
                                    <?php } else { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="">
                                    <?php } ?>
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"> <?= isset(GeneralModel::agendaoption()[$share_safari->share_safari_agenda_id]) ? GeneralModel::agendaoption()[$share_safari->share_safari_agenda_id] : 'Not Included' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  mb-3">
                            <div class="safridetails_form d-flex gap-3 ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-hotel.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Accommodation">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= isset(GeneralModel::fdStayOption()[$share_safari->stay_category_id]) ? GeneralModel::fdStayOption()[$share_safari->stay_category_id] : 'Not Included' ?>
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 m-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap pt-lg-0 pt-sm-3 pt-3">
                        <div class="pakageCost mb-xxl-0 mb-2">
                            <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($share_safari->cost_per_person) ?>/- Per Person</span></h6>
                        </div>
                        

                    </div>
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