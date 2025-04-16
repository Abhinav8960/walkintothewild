<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\GeneralModel;
use common\models\UserWishlist;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\package\PackageIncluded;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIncluded;
use common\models\sharesafari\ShareSafariIntrested;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Shared Safari';
$this->params['title'] = $this->title;

$page_constant = Constants::SHARE_SAFARI;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $page_constant])->limit(1)->one();
?>



<section class="banner_section-inner   packagebnner  position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src=" <?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Shared Safari</h1>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="safari_wrapper  bg-white pt-4">
    <div class="container-lg">
        <div class="row packageSfari">
            <div class="col-12">
                <div class="wrapper-skybgsafri pb-0">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-8 col-md-8 border-right">
                            <div class="row">
                                <div class="col-3 col-sm-3 col-md-3 col-lg-2 maxWidth">
                                    <div class="safritimg innerImg">
                                        <img src="<?= isset($share_safari->safarioperator->imagepath) ? $share_safari->safarioperator->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="Operator Image" class="w-100">
                                    </div>
                                </div>
                                <div class="col-9 col-sm-9 col-md-9 col-lg-10 pt-sm-0 pt-3 maxWidth">
                                    <div class="safrititles">
                                        <h5><?= $share_safari->share_safari_title ?>
                                            <?php if ($share_safari->fixedDepartureHistory) { ?>
                                                <span class="history">
                                                    <button value="<?= Url::toRoute(['/sharedsafari/default/fixed-history', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" class="history_btn bg-sethistory" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View History"><i class="fas fa-history" style="color: #000;"></i></button>
                                                </span>
                                            <?php } ?>
                                        </h5>

                                        <div class="date_bx">
                                            <h6><span style="color:black;">Fixed Departure</span> <?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?> <?= isset($share_safari->cut_off_date) ? ' | <span style="color:black;">Cut off Date</span> ' . date('d M y', strtotime($share_safari->cut_off_date)) : '' ?> </h6>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-lg-none mobile_didplay_none">
                            <div class="pakageCost text-center mb-3">
                                <h6 class="fs-5 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="Rupees" width="20px"><?= number_format($share_safari->cost_per_person) ?> / <span class="perpersonText">Per Person</span></h6>
                            </div>
                        </div>
                        <div class="col-lg-4 pt-lg-0 pt-4">
                            <div class="row ps-1">
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="Night Mode" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Trip Duration">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $share_safari->tour_duration - 1 ?> Nights , <?= $share_safari->tour_duration ?> Days</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/newicon.png" alt="Icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safaris">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $share_safari->no_of_safari ?> Shared Safari
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/car-seat_5102816.png" alt="Seat" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Seats">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">Available Seats - <?php if ($share_safari->status == ShareSafari::STATUS_FULL_SEAT) {
                                                                                    echo '0';
                                                                                } else {
                                                                                    echo $share_safari->share_seat;
                                                                                } ?>/<?= $share_safari->total_seat ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-taxi.png" alt="Taxi" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Pick & Drop">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            $pick_drop_includes = ShareSafariIncluded::find()->where(['share_safari_id' => $share_safari->id, 'include_id' => 3, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($pick_drop_includes) ? 'Included' : 'Not Included';
                                                            ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/path.png" alt="Meal" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Meals">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">
                                            <p class="mb-0"><?= $share_safari->meals ?></p>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <?php if ($share_safari->share_safari_agenda_id && $share_safari->share_safari_agenda_id == 1) { ?>
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/camera.png" alt="Camera" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                            <?php } else if ($share_safari->share_safari_agenda_id && $share_safari->share_safari_agenda_id == 3) { ?>
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/elephant.png" alt="Elephant" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                            <?php } ?>
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">
                                                <?= isset(GeneralModel::agendaoption()[$share_safari->share_safari_agenda_id]) ? GeneralModel::agendaoption()[$share_safari->share_safari_agenda_id] : 'Not Included' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-hotel.png" alt="Hotel" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Accommodation">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= isset(GeneralModel::budgetoption()[$share_safari->stay_category_id]) ?  GeneralModel::budgetoption()[$share_safari->stay_category_id] : 'Not Included'  ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-md-4 align-items-center gx-4 border_bottom2 pb-4">

                        <div class="col-lg-4 d-lg-block  mobile_didplay_block">
                            <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center mt-lg-0 mt-3">
                                <div class="pakageCost mb-2 mb-md-2 mb-xxl-0">
                                    <h6 class="fs-5 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="Rupees" width="20px"><?= number_format($share_safari->cost_per_person) ?> / <span class="perpersonText">Per Person</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>

<section class="safari_wrapper margin_bottomfooter pt-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-10 col-lg-12">
                <div class="card card_bodyPadding mt-2">
                    <div class="card-body">
                        <h5 class="text-danger text-center">This Fixed Departure has been Expired</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>