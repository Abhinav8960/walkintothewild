<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\models\UserWishlist;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\package\PackageIncluded;
use yii\web\View;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Package : ' . ucwords($package->packagename);
$this->params['title'] = ucfirst($this->title);

$page_constant = Constants::PACKAGE_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $page_constant])->limit(1)->one();
?>



<section class="banner_section-inner packagebnner  position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src=" <?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1 class="mb-0"><?= $package->packagename ?></h1>
                        <!-- <p class="text-center text-white mb-0">Organized by <?= isset($package->safarioperator) ? $package->safarioperator->businessname : '' ?></p> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="safari_wrapper  bg-white pt-sm-4 pt-0">
    <div class="container-lg">
        <div class="row my-sm-4 mb-4 packageSfari">
            <div class="col-12">
                <div class="imagesSafari d-sm-block d-none">
                    <img src="<?= $package->imagebannerpath ? $package->imagebannerpath : $this->params['baseurl'] . '/img/thumbnailpakage.jpg' ?>" alt="" class="w-100">
                </div>
                <div class="wrapper-skybgsafri pb-0">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-8 col-md-8 border-right">
                            <div class="row">
                                <div class="col-lg-4 col-md-3">
                                    <div class="images_tour select_safrai ">
                                        <img src="<?= isset($package->safarioperator->imagepath) ? $package->safarioperator->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-9 pt-sm-3 pt-md-0 pt-3">
                                    <div class="safrititles">
                                        <h5 class="fs-4"><?= $package->packagename ?>
                                            <?php
                                            if (Yii::$app->user->identity) { ?>
                                                <?php
                                                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE, 'status' => 1])->limit(1)->one();
                                                if ($wishlist) {
                                                ?>
                                                    <a href="<?= Url::toRoute(['/package/default/unwishlist', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']) ?>" data-method="post" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist" data-pjax="0"><i class="fa-solid fa-heart"></i></a>
                                                <?php } else { ?>
                                                    <a href="<?= Url::toRoute(['/package/default/wishlist', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']) ?>" data-method="post" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to watchlist" data-pjax="0"><i class="fa-regular fa-heart"></i></a>
                                                <?php }
                                                ?>
                                            <?php } ?>
                                        </h5>
                                        <!-- <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($package->start_date)) ?> - <?= date('d M y', strtotime($package->end_date)) ?></h6>
                                        </div> -->
                                        <?php
                                        $package_parks = $package->getPackagepark()->where(['status' => 1])->all();
                                        if ($package_parks) {
                                            echo '<h6 class="titler_safari">';
                                            foreach ($package_parks as $package_park) {
                                                if (!$package_park->park) {
                                                    continue;
                                                }
                                        ?>
                                                <a href="<?= Url::toRoute(['/park/default/view', 'slug' => $package_park->park->slug]) ?>" data-pjax="0"><i class="fa-solid fa-location-dot me-1"></i> <?= $package_park->park->title ?></a>
                                        <?php }
                                            echo '</h6>';
                                        }
                                        ?>

                                        <p class="mb-0 ">Organized by <a href="<?= Url::toRoute(['/operator/default/sharedsafari',  'slug' => $package->safarioperator ? $package->safarioperator->slug : '']) ?>" data-pjax="0"><strong><?= isset($package->safarioperator) ? $package->safarioperator->businessname : '' ?></strong></a></p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-md-block d-lg-none d-none">
                            <div class="text-left">
                                <div class="pakageCost ">
                                    <h6 class="fs-4 mb-0 fw-bold "><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->total_price) ?> /<span class="perpersonText">Per Person</span></h6>

                                </div>
                                <div class="btn_wrap float-lg-end pt-lg-0 pt-3">
                                    <div class="message">
                                        <a href="<?= Url::toRoute(['/operator/default/sharedsafari',  'slug' => $package->safarioperator ? $package->safarioperator->slug : '']) ?>" data-pjax="0" class="parkrevieBtn d-block w-100 text-center">View Operator</a>
                                    </div>
                                    <!-- <button class="join_btn  mt-sm-0 mt-2 enquiryBtn w-100" value="/package/default/enquiry?slug=adventures-park">Book Now</button> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 pt-lg-0 pt-4">
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
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                            <?php } else if ($package->package_agenda_id && $package->package_agenda_id == 3) { ?>
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/elephant.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                            <?php } else { ?>
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
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
                                            <p class="mb-0"><?= isset(GeneralModel::packageoption()[$package->stay_category_id]) ? GeneralModel::packageoption()[$package->stay_category_id] : 'Not Included' ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-12 col-sm-12  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="d-flex w-100 flex-wrap gap-2">
                                            <?php if ($package->packagefeatures) {
                                                foreach ($package->packagefeatures as $features) { ?>

                                                    <div class="text-form ">
                                                        <p class="mb-0"><?= $features->featurename->title ?></p>
                                                    </div>


                                            <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div> -->

                            </div>
                        </div>
                    </div>
                    <div class="row pt-md-4 align-items-center gx-4 border_bottom2 pb-4">
                        <div class="col-lg-8">
                            <div class="social-share d-flex  flex-wrap gap-2 align-items-center justify-content-lg-start justify-content-between  ">
                                <p>Share this package with your friends:</p>
                                <div class="sociel_icons ps-xl-3">
                                    <?php
                                    $shared_url = urlencode(Url::to('', true));
                                    ?>
                                    <ul>
                                        <?= \frontend\widgets\ShareButton::widget([
                                            'style' => 'horizontal',
                                            'networks' => ['facebook', 'twitter', 'instagram', 'whatsapp', 'linkedin', 'telegram', 'clipboard'],
                                        ]); ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-lg-block  mobile_didplay_block">
                            <div class="d-flex justify-content-between align-items-center flex-wrap pt-lg-0 pt-sm-3 pt-3">
                                <div class="pakageCost mb-xxl-0 mb-2">
                                    <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->total_price) ?> / <span class="perpersonText">Per Person</span></h6>


                                </div>
                                <div class="btn_wrap float-lg-end pt-sm-3 pt-lg-0">
                                    <!-- <button class="join_btn  mt-sm-0 mt-2 enquiryBtn" value="<?= Url::toRoute(['/package/default/enquiry', 'slug' => $package->package_slug]) ?>">Book Now</button> -->
                                    <div class="message">
                                        <a href="<?= Url::toRoute(['/operator/default/sharedsafari',  'slug' => $package->safarioperator ? $package->safarioperator->slug : '']) ?>" data-pjax="0" class="parkrevieBtn">View Operator</a>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- <div class="row">
                        <div class="col-12 pt-4">
                            <div class="text_safaripackage package_description profile-description">
                                <div class="text show-more-height">
                                    <p>
                                        <?= $package->package_description  ?>
                                    </p>
                                </div>
                                <div class="package-show-more show-more">See More</div>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="advertisment mt-4 mb-5" style="display:none">
                        <div class="google-ad-box ">

                        </div>
                    </div> -->
                    <div class="row  mt-4 itenary_tabs">
                        <div class="col-lg-12 col-xl-11 safartabs position-relative">
                            <ul class="nav nav-tabs slider_packagemobile d-flex gap-2" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">OVERVIEW</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="itenery-tab" data-bs-toggle="tab" data-bs-target="#itenery-tab-pane" type="button" role="tab" aria-controls="itenery-tab-pane" aria-selected="true">ITINERARY</button>
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
                                    <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq-tab-pane" type="button" role="tab" aria-controls="faq-tab-pane" aria-selected="false" tabindex="-1">FAQ</button>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="safari_wrapper margin_bottomfooter ">
    <div class="container-lg">
        <div class="row mb-5  mt-4 itenary_tabs px-md-3">
            <div class="col-lg-9 col-xl-9 safartabs position-relative">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active accordion-item mb-3" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab">
                        <div class="accordion_disscutions">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Overview
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">

                                        <div class="accordion-body profile-description package_itinerary_overview">

                                            <div class="text show-more-height">
                                                <p>
                                                    <?= $package->package_description  ?>
                                                </p>
                                            </div>
                                            <div class="package-show-more show-more">See More</div>

                                            <?php if ($package->package_itinerary_overview <> '') { ?>
                                                <div class="text show-more-height">
                                                    <?= isset($package->package_itinerary_overview) ? $package->package_itinerary_overview : '' ?>
                                                </div>
                                                <div class="description-show-more show-more">See More</div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- <div class="card bg-set accordion-collapse  card_bodyPadding">
                            <div class="card-body p-3">
                                <div class="itenary-title">
                                    <h6 class="fs-6 fw-bold mb-4">OVERVIEW</h6>
                                </div>
                                <div class="itenary_text">
                                    <p><?= isset($package->package_itinerary_overview) ? $package->package_itinerary_overview : '' ?></p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="itenery-tab-pane" role="tabpanel" aria-labelledby="itenery-tab">
                        <div class="card bg-set accordion-collapse  card_bodyPadding">
                            <div class="card-body p-3">
                                <div class="itenary-title">
                                    <h6 class="fs-6 fw-bold mb-4">ITINERARY</h6>
                                </div>
                                <div class="itenary_text">
                                </div>
                            </div>
                        </div>
                        <?= $this->render('_overview', ['package' => $package]) ?>

                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card bg-set accordion-collapse  card_bodyPadding">
                            <div class="card-body p-3">
                                <?= $this->render('_inclusion', ['package' => $package]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="getting-there" role="tabpanel" aria-labelledby="howto-reach">
                        <div class="card bg-set accordion-collapse  card_bodyPadding">
                            <div class="card-body p-3">
                                <?= $this->render('_getting_there', ['package' => $package]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade  accordion-item mb-3" id="policy" role="tabpanel" aria-labelledby="policy-tab">
                        <div class="policytabs">

                            <?= $this->render('_policy', ['package' => $package]) ?>

                        </div>
                    </div>
                    <div class="tab-pane fade  accordion-item mb-3" id="faq-tab-pane" role="tabpanel" aria-labelledby="faq-tab">
                        <div class="card bg-set accordion-collapse  card_bodyPadding">
                            <div class="card-body p-3">
                                <?= $this->render('_faq', ['faqs' => $faqs, 'package' => $package]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?= $this->render('_comment', ['package' => $package, 'model' => $model, 'login_safarioperator' => $login_safarioperator]) ?>
                <div class="desclaimers pb-3">
                    <div class="itenary-title">
                        <h6 class="fs-5 pb-2">Disclaimer</h6>
                    </div>
                    <div class="itenary_text">
                        <ul>
                            <li>This tour is operated by <strong><?= isset($package->safarioperator) ? $package->safarioperator->businessname : '' ?></strong> and not by Walk Into The Wild.</li>
                            <li><strong><?= isset($package->safarioperator) ? $package->safarioperator->businessname : '' ?></strong> reserves the right to adjust the rates advertised by Walk Into The Wild.</li>
                            <li>The specific itinerary, inclusions, and pricing of this tour are dependent on availability.</li>
                            <li>In the event that accommodations are fully booked, <strong><?= isset($package->safarioperator) ? $package->safarioperator->businessname : '' ?></strong> will propose a suitable alternative.</li>
                            <li>This tour is governed by the terms and conditions set forth by Walk Into The Wild.</li>
                        </ul>
                    </div>
                </div>

                <!-- <div class="advertisment pt-md-2 pt-5" style="display: none !important">
                    <div class="google-ad-box  mb-5" style="border:none">

                    </div>
                </div> -->

            </div>

            <div class="col-xl-3 col-lg-3 mb-5 pb-4">
                <?php if (Yii::$app->user->identity && isset($package->safarioperator) && Yii::$app->user->identity->id != $package->safarioperator->user_id) { ?>
                    <div class="request_quote mb-4">
                        <button class="intested_btn interestBtn " value="#" style="background-color: var(--background-primary) !important;cursor: default;">
                            Request Quote</button>
                        <div class="interst_wrapper p-0 bg-white">
                            <div class="users_profile d-flex gap-3 align-items-center flex-wrap">
                                <?= $this->render('_quote', ['packagemodel' => $packagemodel, 'disabled' => false]) ?>

                            </div>
                        </div>

                    </div>
                <?php } else {  ?>

                    <div class="request_quote mb-4 position-relative galssset">
                        <button class="intested_btn interestBtn " value="#" style="background-color: var(--background-primary) !important;cursor: default;">
                            Request Quote</button>
                        <div class="interst_wrapper p-0 bg-white">
                            <svg class="form-lock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#02690e" d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
                            </svg>
                            <div class="users_profile d-flex gap-3 align-items-center flex-wrap">
                                <?= $this->render('_quote', ['packagemodel' => $packagemodel, 'disabled' => true]) ?>

                            </div>
                        </div>

                    </div>
                <?php } ?>

                <!-- <?php if ($package->packagegallery) {
                    $galleries = $package->packagegallery;
                ?>
                    <div class="request_quote photoGallry mb-4">
                        <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;">
                            Photo Gallery <span><?= count($galleries) ?></span>
                        </button>
                        <div class="interst_wrapper p-0 bg-white">
                            <div class="photoSlider owl-carousel owl-theme">
                                <?php foreach ($galleries as $gallery) { ?>
                                    <div class="items_img">
                                        <a href="<?= isset($gallery->image) ? $gallery->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" data-fancybox="gallery" data-caption="No caption available" class="gallery-item">
                                            <img src="<?= isset($gallery->image) ? $gallery->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" width="100%">
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?> -->

                <div class="">
                    <?php
                    if ($package->safarioperator) {
                        echo $this->render('@frontend/modules/operator/views/default/_operator_rating_sidebar', ['operator' => $package->safarioperator]);
                    } ?>
                </div>

                <!-- <div class="advertisment mt-5" style="display: none">
                    <div class="google-ad300  mb-5" style="border:none">

                    </div>
                </div>
                <div class="advertisment" style="display:none !important;">
                    <div class="google-add600hight  mb-5">

                    </div>
                </div> -->

            </div>


        </div>
    </div>


</section>

<div class="modal fade modal_enquiry" id="exampleModalenquiry" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="modal-title fs-5 text-center pb-3" id="exampleModalLabel">Enquire</h1>
            </div>
            <div class="modal-body px-4 pt-2 pb-4">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalFlag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Report Content
                    <br>
                    <p>Please report inappropriate members and/or content to help our Trust & Safety team keep our Community safe for everyone.</p>
                </h6>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt=""></button>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>


<?php
$script = <<< JS
function enquiryfunction() {
	$('.enquiryBtn').on('click', function () {
        $('#exampleModalenquiry').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
enquiryfunction();


var textContainer = $(".package_description .text");
    var showMoreButton = $(".package_description .package-show-more");
    var lineHeight = parseInt(textContainer.css('line-height'));

    var threeLinesHeight = lineHeight * 3;

    if (textContainer[0].scrollHeight > threeLinesHeight) {
        showMoreButton.show();
    }

    showMoreButton.click(function () {
        textContainer.toggleClass("show-more-height");
        if (textContainer.hasClass("show-more-height")) {
            $(this).text("See More");
        } else {
            $(this).text("See Less");
        }
    });

    var textContainer_itineary = $(".package_itinerary_overview .text");
    var showMoreButton_itinerary = $(".package_itinerary_overview .description-show-more");
    var lineHeight_iteneary = parseInt(textContainer_itineary.css('line-height'));

    if (textContainer_itineary.length) { 
        var threeLinesHeight_itenary = lineHeight_iteneary * 3;

        if (textContainer_itineary[0].scrollHeight > threeLinesHeight_itenary) {
            showMoreButton_itinerary.show();
        }
    }

    $(".description-show-more").click(function () {
        textContainer_itineary.toggleClass("show-more-height");
        if (textContainer_itineary.hasClass("show-more-height")) {
            $(this).text("See More");
        } else {
            $(this).text("See Less");
        }
    });
JS;
$this->registerJs($script);
?>
<style>
    .disclaimer {
        top: 2375px;
        left: 303px;
        width: 687px;
        height: 148px;
        /* UI Properties */
        text-align: left;
        font: normal normal normal 16px/25px Roboto;
        letter-spacing: 0px;
        color: #151C2C;
        opacity: 1;


    }

    .tab-content {
        >.tab-pane {
            display: none;
        }

        >.active {
            display: block;
        }
    }
</style>