<?php

use common\models\GeneralModel;
use common\models\package\PackageVersion;
use common\models\sharesafari\ShareSafariIncluded;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>
<section class="topHead mx-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="topParent d-flex justify-content-between align-items-center">
                    <div class="packageTitle">
                        <h2>Fixed Departure : <?= $share_safari->share_safari_title ?></h2>
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
                        <?php if ($share_safari->version) { ?>
                            <div class="numbwrCount">
                                <h3><?= $share_safari->commentCount ?></h3>
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

                        <?php if ($share_safari->version) { ?>
                            <div class="numbwrCount">
                                <h3><?= $share_safari->commentCount ?></h3>
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

                            <?php if ($share_safari->version) { ?>
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

                        <?php if ($share_safari->version) { ?>
                            <div class="numbwrCount">
                                <h3><?= $share_safari->commentCount ?></h3>
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
        <div class="wrapper-skybgsafri pb-0">
            <div class="row pb-4">
                <div class="border-right col-lg-8 col-md-12 col-sm-12">
                    <div class="row h-100">
                        <div
                            class="maxWidth pb-md-3 pb-lg-0 col-lg-3 col-md-12 col-sm-12 col-12">
                            <div class="images_tour select_safrai ">
                                <img class="w-100 h-100" alt="Partner"
                                    src="<?= isset($share_safari->sharedimagepath) ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/images/Bandhavgarhsmall.jpg' ?>">
                            </div>
                        </div>
                        <div class="d-flex flex-column pt-3 col-lg-8 col-md-9">
                            <div class="safrititles ">
                                <a href="<?= Yii::$app->params['frontend_url'] . '/sharedsafari/' . $share_safari->organizedslug . '/' . $share_safari->slug  ?>">
                                    <h5><?= $share_safari->share_safari_title ?></h5>
                                </a>
                                <div class="date_bx">
                                    <h6><span style="color:black;">Fixed Departure</span> <?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?> <?= isset($share_safari->cut_off_date) ? ' | <span style="color:black;">Cut off Date</span> ' . date('d M y', strtotime($share_safari->cut_off_date)) : '' ?> </h6>
                                </div>
                                <h6 class="titler_safari"><i class="fa-solid fa-location-dot me-1"></i><?= $share_safari->park->title ?></h6>
                                <p class="mb-0 ">Organized by <a href=""
                                        data-discover="true"><strong><?= isset($share_safari->safarioperator->business_name) ? $share_safari->safarioperator->business_name : '' ?></strong></a></p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="pt-lg-0 pt-4 col-lg-4">
                    <div class="ps-1 row">
                        <div class="mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg"><img src="<?= $this->params['baseurl'] ?>/images/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Trip Duration"></div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $share_safari->tour_duration - 1 ?> Nights , <?= $share_safari->tour_duration ?> Days</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4  ">
                                <div class="iconImg">
                                    <img src="<?= $this->params['baseurl'] ?>/images/Icon fa-solid-taxi.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pick & Drop">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?php
                                                    $pick_drop_includes = ShareSafariIncluded::find()->where(['share_safari_id' => $share_safari->id, 'include_id' => 3, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                    echo ($pick_drop_includes) ? 'Included' : 'Not Included';
                                                    ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg"> <img src="<?= $this->params['baseurl'] ?>/images/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safaris">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $share_safari->no_of_safari ?> Shared Safari
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg"><img
                                        src="<?= $this->params['baseurl'] ?>/images/path.png" alt=""></div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $share_safari->meals ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg">
                                    <?php if ($share_safari->share_safari_agenda_id && $share_safari->share_safari_agenda_id == 1) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/images/camera.png" alt="">
                                    <?php } else if ($share_safari->share_safari_agenda_id && $share_safari->share_safari_agenda_id == 3) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/images/elephant.png" alt="">
                                    <?php } else { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/images/camera.png" alt="">
                                    <?php } ?>
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"> <?= isset(GeneralModel::agendaoption()[$share_safari->share_safari_agenda_id]) ? GeneralModel::agendaoption()[$share_safari->share_safari_agenda_id] : 'Not Included' ?></p>
                                </div>
                            </div>

                        </div>
                        <div class="  mb-3 col-sm-6 col-12">
                            <div class="safridetails_form d-flex align-items-center gap-4 ">
                                <div class="iconImg"> <img src="<?= $this->params['baseurl'] ?>/images/Icon fa-solid-hotel.png">
                                </div>
                                <div class="text-form">

                                    <p class="mb-0"><?= isset(GeneralModel::packageStayOption()[$share_safari->stay_category_id]) ? GeneralModel::packageStayOption()[$share_safari->stay_category_id] : 'Not Included' ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 pt-md-3 align-items-center justify-content-end border-top border-bottom gx-4 pb-3">
                    <div class="d-lg-block  mobile_didplay_block col-lg-4 ">
                        <div
                            class="d-flex justify-content-md-start align-items-center flex-wrap pt-lg-0 pt-sm-3 pt-3">
                            <div class="pakageCost mb-xxl-0 mb-2">
                                <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/images/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($share_safari->cost_per_person) ?>/ Person
                                </h6>
                            </div>
                        </div>
                    </div>

                </div>

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
                                    data-bs-target="#Overview" type="button" role="tab"
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