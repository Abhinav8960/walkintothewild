<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\models\UserWishlist;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\package\PackageIncluded;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Package : ' . $package->package_name;
$this->params['title'] = $this->title;

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
                        <h1 class="mb-0"><?= $package->package_name ?></h1>
                        <!-- <p class="text-center text-white mb-0">Organized by <?= isset($package->safarioperator) ? $package->safarioperator->businessname : '' ?></p> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="safari_wrapper  bg-white pt-4">
    <div class="container-lg">
        <div class="row my-4 packageSfari">
            <div class="col-12">
                <div class="imagesSafari">
                    <img src="<?= isset($package->imagepath) ? $package->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="" class="w-100">
                </div>
                <div class="wrapper-skybgsafri pb-0">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-7 col-md-8 border-right">
                            <div class="row">
                                <div class="col-lg-4 col-md-3">
                                    <div class="images_tour select_safrai ">
                                        <img src="<?= isset($package->safarioperator->imagepath) ? $package->safarioperator->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-9 pt-sm-3 pt-md-0 pt-3">
                                    <div class="safrititles">
                                        <h5 class="fs-4"><?= $package->package_name ?>
                                            <?php
                                            if (Yii::$app->user->identity) { ?>
                                                <?php
                                                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE, 'status' => 1])->limit(1)->one();
                                                if ($wishlist) {
                                                ?>
                                                    <a href="/package/unwishlist/<?= $package->package_slug ?>" data-method="post" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist"><i class="fa-solid fa-heart"></i></a>
                                                <?php } else { ?>
                                                    <a href="/package/wishlist/<?= $package->package_slug ?>" data-method="post" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to watchlist"><i class="fa-regular fa-heart"></i></a>
                                                <?php }
                                                ?>
                                            <?php } ?>
                                        </h5>
                                        <!-- <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($package->start_date)) ?> - <?= date('d M y', strtotime($package->end_date)) ?></h6>
                                        </div> -->
                                        <p class="mb-0 ">Organized by <a href="<?= Url::toRoute(['/operator/default/sharedsafari',  'slug' => $package->safarioperator ? $package->safarioperator->slug : '']) ?>"><strong><?= isset($package->safarioperator) ? $package->safarioperator->businessname : '' ?></strong></a></p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-md-block d-lg-none d-none">
                            <div class="text-left">
                                <div class="pakageCost">
                                    <h6 class="fs-3 mb-0 fw-bold text-center"><img src="/assets/f9595a2a/img/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->total_price) ?></h6>
                                </div>
                                <div class="btn_wrap float-lg-end pt-lg-0 pt-3">
                                    <div class="message">
                                        <a href="" class="follow_massge d-block w-100 text-center">Message</a>
                                    </div>
                                    <!-- <button class="join_btn  mt-sm-0 mt-2 enquiryBtn w-100" value="/package/default/enquiry?slug=adventures-park">Book Now</button> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 pt-lg-0 pt-4">
                            <div class="row px-lg-4 px-0">
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safari Seasion">
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
                                            <p class="mb-0"><?= $package->mastervehicle ? $package->mastervehicle->vehicle_name : 'N/A' ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Shared Safari">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $package->no_of_safari ?> Shared Safari
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/path.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Meal">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            $package_includes = PackageIncluded::find()->where(['package_id' => $package->id, 'include_id' => 2, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($package_includes) ? 'All meals' : 'N/A';
                                                            ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Photography Special">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            $package_includes = PackageIncluded::find()->where(['package_id' => $package->id, 'include_id' => 4, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($package_includes) ? 'Camera Fee' : 'N/A';
                                                            ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-hotel.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Stay Category">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= isset(GeneralModel::packageoption()[$package->stay_category_id]) ? GeneralModel::packageoption()[$package->stay_category_id] : 'N/A' ?></p>
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
                        <div class="col-lg-7">
                            <div class="social-share d-flex  flex-wrap gap-2 align-items-center justify-content-lg-start justify-content-between  ">
                                <p>Share this event with your friends:</p>
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
                        <div class="col-lg-5 d-lg-block  mobile_didplay_block">
                            <div class="d-flex justify-content-between align-items-center pt-lg-0 pt-sm-3 pt-3">
                                <div class="pakageCost">
                                    <h6 class="fs-3 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->total_price) ?></h6>
                                </div>
                                <div class="btn_wrap float-lg-end pt-sm-3 pt-lg-0">
                                    <!-- <button class="join_btn  mt-sm-0 mt-2 enquiryBtn" value="<?= Url::toRoute(['/package/default/enquiry', 'slug' => $package->package_slug]) ?>">Book Now</button> -->
                                    <div class="message">
                                        <a href="" class="follow_massge">Message</a>
                                    </div>
                                </div>
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
        <div class="row mb-5  mt-4 mobileAccordion itenary_tabs px-md-3">
            <div class="col-lg-9 col-xl-9 safartabs position-relative">
                <div class="tab-content accordion " id="myTabContent">
                    <div class="tab-pane fade show active accordion-item mb-3" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">ITENARY</button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse bg-set collapse show card_bodyPadding  d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
                            <div class="accordion-body card-body p-3">
                                <div class="col-lg-12 mb-3">
                                    <div class="itenary-title">
                                        <h6 class="fs-6 fw-bold mb-4">ABOUT TRIP / OVERVIEW</h6>
                                    </div>
                                    <div class="itenary_text">
                                        <p><?= isset($package->package_itinerary_overview) ? $package->package_itinerary_overview : '' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $this->render('_overview', ['package' => $package]) ?>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>

                    <div class="tab-pane fade accordion-item mb-3" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                INCLUSION
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse card_bodyPadding   bg-set d-lg-block" aria-labelledby="headingTwo" data-bs-parent="#myTabContent">
                            <div class="accordion-body  card-body">
                                <?= $this->render('_inclusion', ['package' => $package]) ?>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="getting-there" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingGetting">
                            <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseGetting" aria-expanded="false" aria-controls="collapseGetting">
                                GETTING THERE
                            </button>
                        </h2>
                        <div id="collapseGetting" class="accordion-collapse bg-set card_bodyPadding  collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                            <div class="accordion-body card-body ">
                                <?= $this->render('_getting_there', ['package' => $package]) ?>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="policy" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                POLICY INFO
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse   card_bodyPadding  collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set px-0 py-0">
                                <?= $this->render('_policy', ['package' => $package]) ?>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="faq-tab-pane" role="tabpanel" aria-labelledby="faq-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                FAQ
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse bg-set collapse card_bodyPadding  d-lg-block" aria-labelledby="headingFive" data-bs-parent="#myTabContent">
                            <div class="accordion-body card-body height_set">
                                <?= $this->render('_faq', ['faqs' => $faqs]) ?>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                </div>

                <?= $this->render('_comment', ['package' => $package, 'model' => $model, 'replymodel' => $replymodel]) ?>
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
            </div>
            <div class="col-xl-3 col-lg-3 mb-5 pb-4">
                <?php if (Yii::$app->user->identity) { ?>
                    <div class="request_quote">
                        <button class="intested_btn interestBtn " value="#" style="background-color: var(--background-primary) !important;">
                            Request Quote</button>
                        <div class="interst_wrapper p-0 bg-white">
                            <div class="users_profile d-flex gap-3 align-items-center flex-wrap">
                                <?= $this->render('_quote', ['packagemodel' => $packagemodel]) ?>

                            </div>
                        </div>

                        <?php
                        if (Yii::$app->user->identity->is_safari_operator == 1 && Yii::$app->user->identity->account_type == 3) {
                            if (true || Yii::$app->user->identity->id == $package->owned_by_id) {
                        ?>

                                <!-- <div class="right_button py-lg-5 py-3 d-lg-block d-none">
                                <a class="btn_newsafari organizeBtn w-100" href="/package/profile/<?= $package->id ?>"><i class="fas fa-edit me-1"></i>Update Package</a>
                            </div> -->
                        <?php }
                        } ?>
                    <?php } else { ?>
                        <!-- <p>Please Login to Request Quote</p> -->
                    <?php } ?>
                    <?php if ($package->packagegallery) {
                        $galleries = $package->packagegallery;
                    ?>
                        <div class="request_quote mt-4">
                            <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;">
                                Photo Gallery <span><?= count($galleries) ?></span></button>
                            <div class="interst_wrapper p-0 bg-white">
                                <div class="photoSlider owl-carousel owl-theme">
                                    <?php foreach ($galleries as $gallery) { ?>
                                        <div class="items_img">
                                            <img src="<?= isset($gallery->image) ? $gallery->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" width="100%">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

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
</style>