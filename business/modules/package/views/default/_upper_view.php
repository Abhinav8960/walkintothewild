<?php

use common\models\GeneralModel;
use common\models\package\PackageVersion;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>
<section class="topHead mx-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="topParent d-flex justify-content-between align-items-center">
                    <div class="packageTitle">
                        <h2>Package : <?= mb_strimwidth($package->package_name, 0, 40, "...") ?>
                            <?php if (!empty($package->cancellation_reason)) { ?>
                                <span style='color:red'>
                                    <?= '(' . $package->cancellation_reason . ')' ?>
                                </span>
                            <?php } ?>
                        </h2>
                    </div>
                    <div class="butonsParent d-flex align-items-center gap-3">
                        <?php if ($var = $package->package) { ?>
                            <?php if ($var->edit_status == 1) { ?>
                                <div class="col-lg-2">
                                    <div class="editBtn float-end">
                                        <?= Html::a('Edit', [Url::toRoute(['update', 'id' => $package->package_id])], ['title' => 'Edit']) ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($var->status != 1 && $var->pending_status != 1) { ?>
                                <div class="edinBtn">
                                    <?= Html::a('Send For Approval', [Url::toRoute(['send-for-approval', 'id' => $package->id])], ['title' => 'Send For Approval']) ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="listCard mx-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="iconsDiv d-flex justify-content-center align-items-center">
                                <img src="<?= $this->params['baseurl'] ?>/images/whislist.svg" alt="Wishlist">
                            </div>
                            <div class="text-card">
                                <p>Wishlist</p>
                            </div>
                        </div>
                        <?php if ($package->live_version) { ?>
                            <div class="numbwrCount">
                                <h3><?= $package->whislistCount ?></h3>
                            </div>
                        <?php } else {  ?>
                            <div class="numbwrCount">
                                <h3>0</h3>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="iconsDiv d-flex justify-content-center align-items-center">
                                <img src="<?= $this->params['baseurl'] ?>/images/quote_request.svg" alt="Quotes">
                            </div>
                            <div class="text-card">
                                <p>Quote Requests</p>
                            </div>
                        </div>

                        <?php if ($package->live_version) { ?>
                            <div class="numbwrCount">
                                <h3><?= $package->leadCount ?></h3>
                            </div>
                        <?php } else {  ?>
                            <div class="numbwrCount">
                                <h3>0</h3>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if (false) { ?>
                <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                    <div class="mainCard py-3 px-3">
                        <div class="cardChild d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="iconsDiv d-flex justify-content-center align-items-center">
                                    <img src="<?= $this->params['baseurl'] ?>/images/Icon material-twotone-currency-rupee.svg" alt="Quotes">
                                </div>
                                <div class="text-card">
                                    <p>Bookings</p>
                                </div>
                            </div>

                            <?php if ($package->live_version) { ?>
                                <div class="numbwrCount">
                                    <h3>300</h3>
                                </div>
                            <?php } else {  ?>
                                <div class="numbwrCount">
                                    <h3>0</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="iconsDiv d-flex justify-content-center align-items-center">
                                <img src="<?= $this->params['baseurl'] ?>/images/package_comment.svg" alt="Comment">
                            </div>
                            <div class="text-card">
                                <p>Comments</p>
                            </div>
                        </div>

                        <?php if ($package->live_version) { ?>
                            <div class="numbwrCount">
                                <h3><?= $package->commentCount ?></h3>
                            </div>
                        <?php } else {  ?>
                            <div class="numbwrCount">
                                <h3>0</h3>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="row packageSfari mx-3">
    <div class="col-12 mt-4">
        <div class="imagesSafari d-sm-block d-none">
            <!-- <div class="package-banner-dummy">
                <img src="<?= isset($package->imagebannerpath) ? $package->imagebannerpath : $this->params['baseurl'] . '/images/Bandhavgarhsmall.jpg' ?>" alt="" class="w-100 h-100">
            </div> -->
        </div>
        <div class="wrapper-skybgsafri pb-0">
            <div class="row pb-4">
                <div class="border-right col-lg-8 col-md-12 col-sm-12">
                    <div class="row h-100">
                        <div
                            class="maxWidth pb-md-3 pb-lg-0 col-lg-3 col-md-12 col-sm-12 col-12">
                            <div class="images_tour select_safrai ">
                                <img class="w-100 h-100" alt="Partner"
                                    src="<?= isset($package->imagepath) ? $package->imagepath : $this->params['baseurl'] . '/images/Bandhavgarhsmall.jpg' ?>">
                            </div>
                        </div>
                        <div class="d-flex flex-column pt-3 col-lg-8 col-md-9">
                            <div class="safrititles ">
                                <h2 class="m-0 lh-1 d-inline font-devator"><?= $package->package_name ?></h2>

                                <?php
                                $package_parks = $package->getPackagepark()->andWhere(['status' => 1])->all();
                                if ($package_parks) {
                                    echo '<h6 class="titler_safari my-3">';
                                    foreach ($package_parks as $package_park) {
                                        if (!$package_park->park) {
                                            continue;
                                        }
                                ?>
                                        <i class="fa-solid fa-location-dot me-1"></i> <?= $package_park->park->title ?><br>
                                <?php }
                                    echo '</h6>';
                                }
                                ?>
                                <p class="mb-0 ">Organized by <a href=""
                                        data-discover="true"><strong><?= isset($package->safarioperator->business_name) ? $package->safarioperator->business_name : '' ?></strong></a></p>

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
                <!-- <div class="d-md-block d-lg-none d-none col-md-4"><div class="text-left"><div class="pakageCost "><h6 class="fs-4 mb-0 fw-bold "><img alt="" width="20px" class="me-1 mb-1" src="/static/media/rupees.72fb50562ebb2f51b1e6.png">27000 /<span class="perpersonText">Per Person</span></h6></div><div class="btn_wrap float-lg-end pt-lg-0 pt-3"><div class="message"></div></div></div></div> -->
                <div class="pt-lg-0 pt-4 col-lg-4">
                    <div class="ps-1 row">
                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg"><img src="<?= $this->params['baseurl'] ?>/images/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Trip Duration"></div>
                                <div class="text-form">
                                    <!-- <span class="mark_area">Trip
                                                                Duration</span> -->
                                    <p class="mb-0"><?= $package->no_of_night ?> Nights , <?= $package->no_of_day ?> Days</p>
                                </div>
                            </div>
                        </div>
                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg"> <img src="<?= $this->params['baseurl'] ?>/images/Icon fa-solid-taxi.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pick & Drop">
                                </div>
                                <div class="text-form">
                                    <!-- <span class="mark_area">Trip
                                                                Duration</span> -->
                                    <p class="mb-0"><?= $package->pickanddrop ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg"> <img src="<?= $this->params['baseurl'] ?>/images/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safaris">
                                </div>
                                <div class="text-form">
                                    <!-- <p class="mb-0"><?= $package->custom_message_details ?>
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
                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg"><img
                                        src="<?= $this->params['baseurl'] ?>/images/path.png" alt=""></div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $package->meals ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg">
                                    <?php if ($package->package_agenda_id && $package->package_agenda_id == 1) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/images/camera.png" alt="">
                                    <?php } else if ($package->package_agenda_id && $package->package_agenda_id == 3) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/images/elephant.png" alt="">
                                    <?php } else { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/images/camera.png" alt="">
                                    <?php } ?>
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"> <?= isset(GeneralModel::agendaoption()[$package->package_agenda_id]) ? GeneralModel::agendaoption()[$package->package_agenda_id] : 'Not Included' ?></p>
                                </div>
                            </div>

                        </div>
                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg"> <img src="<?= $this->params['baseurl'] ?>/images/Icon fa-solid-hotel.png">
                                </div>
                                <div class="text-form">

                                    <p class="mb-0"><?= isset(GeneralModel::packageStayOption()[$package->stay_category_id]) ? GeneralModel::packageStayOption()[$package->stay_category_id] : 'Not Included' ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 pt-md-3 align-items-center justify-content-end border-top border-bottom gx-4 pb-3">
                    <?php if (false) { ?>
                        <div class="col-lg-8">
                            <div
                                class="social-share d-flex  flex-wrap gap-2 align-items-center justify-content-lg-start justify-content-between">
                                <p>Share this package with your friends:</p>
                                <div class="sociel_icons ps-xl-3">
                                    <ul>
                                        <ul class="list-unstyled d-flex gap-2">
                                            <li><a rel="noopener noreferrer" class="iconSize" href=""
                                                    target="_blank"><i
                                                        class="fa-brands fa-facebook-f"></i></a></li>
                                            <!-- <li><a rel="noopener noreferrer" class="iconSize" href=""
                                                                    target="_blank"><i
                                                                        class="fa-brands fa-x-twitter"></i></a></li> -->
                                            <li><a rel="noopener noreferrer" class="iconSize" href=""
                                                    target="_blank"><i
                                                        class="fa-brands fa-instagram"></i></a></li>
                                            <li><a rel="noopener noreferrer" class="iconSize" href=""
                                                    target="_blank"><i
                                                        class="fa-brands fa-whatsapp"></i></a></li>
                                            <!-- <li><a rel="noopener noreferrer" class="iconSize" href=""
                                                                    target="_blank"><i
                                                                        class="fa-brands fa-linkedin-in"></i></a></li> -->
                                            <li><a rel="noopener noreferrer" class="iconSize" href=""><i
                                                        class="fa-solid fa-paper-plane pe-1"></i></a>
                                            </li>
                                            <li><span class="iconSize copytoclipboard"><i
                                                        class="fa-solid fa-link"></i></span></li>
                                        </ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- <div class=" pakageCost d-lg-block  mobile_didplay_block col-lg-4 ">
                        <?php if ($package->cost_per_person_strike_off > 0) { ?>
                            <h6 class="mb-0 text-muted">
                                <del>
                                    <img src="<?= $this->params['baseurl'] ?>/images/rupees.png" width="20" height="20" class="me-1">
                                    <?= GeneralModel::number_format_indian($package->cost_per_person_strike_off) ?> /-
                                    <span class="perpersonText"></span>
                                </del>
                            </h6>
                        <?php } ?>
                        <div>
                            <h6 class="fs-4 fw-bold mb-1">
                                <img src="<?= $this->params['baseurl'] ?>/images/rupees.png" width="20" height="20" class="me-1">
                                <?= number_format($package->cost_per_person) ?> /-
                                <span class="perpersonText">1 Person</span>
                            </h6>

                            <h6 class="fs-4 fw-bold mb-1">
                                <span class="text-danger">Total Price: </span>
                                <img src="<?= $this->params['baseurl'] ?>/images/rupees.png" width="20" height="20" class="me-1">
                                <?= number_format($package->total_price) ?>
                            </h6>
                        </div>

                        <?php if ($package->cost_per_two_person > 0) { ?>
                            <div class="vr"></div>
                            <h6 class="fs-4 fw-bold mb-1">
                                <img src="<?= $this->params['baseurl'] ?>/images/rupees.png" width="20" height="20" class="me-1">
                                <?= number_format($package->cost_per_two_person) ?> /-
                                <span class="perpersonText">2 Person</span>
                            </h6>
                        <?php } ?>

                    </div>
                    <?php if ($package->custom_price_message != null && $package->custom_price_message != '') { ?>
                        <hr>
                        <p class="fs-6 mb-0">
                            <span class=""><?= $package->custom_price_message ?? '' ?></span>
                        </p>
                    <?php } ?>
                    
                </div> -->



                    <div class="d-lg-block  mobile_didplay_block col-lg-4 ">
                        <!-- <del>
                            <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/images/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->cost_per_person_strike_off) ?>/-</h6>
                        </del> -->
                        <div
                            class="d-flex justify-content-md-start align-items-center flex-wrap pt-lg-0 pt-sm-3 pt-3">

                            <div class="pakageCost mb-xxl-0 mb-2 gap-2 d-flex">

                                <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/images/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->cost_per_person) ?>/- 1 Person
                                </h6>
                                <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/images/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->cost_per_two_person) ?>/- 2 Person
                                </h6>
                            </div>
                        </div>
                    </div>
                    <p class="fs-6 mb-0">
                        <span class=""><?= $package->custom_price_message ?? '' ?></span>
                    </p>

                </div>
            </div>
            <div class="col-12 pt-3">
                <div class="row">
                    <div class="col-6">
                        <div class="packageTabMain">
                            <ul class="nav-tabs flex-row d-flex justify-content-between p-0 m-0" id="myTab"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#Overview" type="button" role="tab"
                                        aria-controls="home" aria-selected="true">Overview</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="itinerary-tab" data-bs-toggle="tab"
                                        data-bs-target="#Itinerary" type="button" role="tab"
                                        aria-controls="itinerary" aria-selected="true">Itinerary</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#Inclusions" type="button" role="tab"
                                        aria-controls="profile"
                                        aria-selected="false">Inclusions</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#Exclusions" type="button" role="tab"
                                        aria-controls="contact"
                                        aria-selected="false" style="white-space: nowrap;">Getting There</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#common" type="button" role="tab"
                                        aria-controls="contact" aria-selected="false">T&C</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#FAQ" type="button" role="tab"
                                        aria-controls="contact" aria-selected="false">FAQ</button>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .editBtn a {
            background-color: #237F40;
            color: #ffffff;
            border: 0;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 700;
            padding: 10px 50px;
        }
    </style>