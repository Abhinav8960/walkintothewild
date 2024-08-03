<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\GeneralModel;
use common\models\UserWishlist;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\package\PackageIncluded;
use common\models\sharesafari\ShareSafariIncluded;
use common\models\sharesafari\ShareSafariIntrested;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Safari Tour Operator Registration';
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
                        <h1>Join or Organize a Sharing Safari</h1>
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
                    <img src="<?= isset($package->package_image) ? $package->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="" class="w-100">
                </div>
                <div class="wrapper-skybgsafri pb-0">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-7 col-md-8 border-right">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="safritimg innerImg">
                                        <img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100">
                                    </div>
                                </div>
                                <div class="col-sm-10 pt-sm-0 pt-3">
                                    <div class="safrititles">
                                        <h5><a href="<?= Url::toRoute(['/park/default/view', 'slug' => $share_safari->park->slug]) ?>"><?= $share_safari->park->title ?></a>
                                            <?php
                                            if (Yii::$app->user->identity) { ?>
                                                <?php
                                                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $share_safari->id, 'item_type_id' => UserWishlist::SHARED_SAFARI, 'status' => 1])->limit(1)->one();
                                                if ($wishlist) {
                                                ?>
                                                    <a href="/sharedsafari/unwishlist/<?= $share_safari->slug ?>" data-method="POST" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist"><i class="fa-solid fa-heart"></i></a>
                                                <?php } else { ?>
                                                    <a href="/sharedsafari/wishlist/<?= $share_safari->slug ?>" data-method="POST" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add to watchlist"><i class="fa-regular fa-heart"></i></a>
                                                <?php }
                                                ?>
                                            <?php } ?>
                                        </h5>
                                        <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                        </div>
                                        <p class="mb-0 pt-2">Organized by <a href="<?= $share_safari->organizedbyprofileurl <> '' ? $share_safari->organizedbyprofileurl : '#' ?>"><strong><?= $share_safari->organizedbyname ?></strong></a></p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 pt-lg-0 pt-4">
                            <div class="row px-sm-4 px-0">
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safari Seasion">
                                        </div>
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
                                                            $pick_drop_includes = ShareSafariIncluded::find()->where(['share_safari_id' => $share_safari->id, 'include_id' => 3, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($pick_drop_includes) ? 'Pick & Drop' : 'N/A';
                                                            ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Shared Safari">
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
                                            <img src="<?= $this->params['baseurl'] ?>/img/path.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Meal">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            $share_safari_includes = ShareSafariIncluded::find()->where(['share_safari_id' => $share_safari->id, 'include_id' => 2, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($share_safari_includes) ? 'All meals' : 'N/A';
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
                                                            $share_safari_includes = ShareSafariIncluded::find()->where(['share_safari_id' => $share_safari->id, 'include_id' => 4, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($share_safari_includes) ? 'Camera Fee' : 'N/A';
                                                            ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Icon fa-solid-hotel.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hotel Category">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= isset(GeneralModel::packageoption()[$share_safari->stay_category_id]) ? GeneralModel::packageoption()[$share_safari->stay_category_id] : 'N/A' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-md-4 align-items-center gx-4 border_bottom2 pb-4">
                        <div class="col-lg-6">
                            <div class="social-share d-flex gap-2 align-items-center justify-content-lg-start justify-content-between  ">
                                <p>Share this event with your friends:</p>
                                <div class="sociel_icons ps-3">
                                    <?php
                                    $shared_url = urlencode(Url::to('', true));
                                    ?>
                                    <ul>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                                        </li>
                                        <li><a href="https://wa.me/?text=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                                        </li>
                                        <li><a href="https://twitter.com/intent/tweet?url=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                                        </li>
                                        <li><a href="https://www.instagram.com/?url=<?= urlencode($shared_url) ?>" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                                        </li>
                                        <li><a href="https://www.instagram.com/?url=<?= urlencode($shared_url) ?>" target="_blank" class="iconSize"><i class="fa-brands fa-linkedin-in"></i></a>
                                        </li>
                                        <li><a href="https://www.instagram.com/?url=<?= urlencode($shared_url) ?>" target="_blank" class="iconSize"><i class="fa-solid fa-paper-plane"></i></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="pakageCost text-center">
                                <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px"><?= $share_safari->cost_per_person ?></h6>
                            </div>
                        </div>
                        <div class="col-lg-4 d-lg-block  mobile_didplay_block">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn_wrap float-lg-end pt-lg-0 pt-3">
                                    <?php if ($share_safari->host_user_id == Yii::$app->user->id && $share_safari->status != 2) { ?>
                                        <?= Html::a('Mark as Completed', ['completed', 'slug' => $share_safari->slug], [
                                            'class' => 'join_btn text-center mt-sm-0 mt-2 d-block',
                                            'style' => 'background-color:green; color:white;',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to Completed this Safari?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    <?php } ?>
                                </div>
                                <div class="right_button ">

                                    <?php if ($share_safari->host_user_id == $login_safarioperator->id) { ?>
                                        <a class="btn_newsafari" href="<?= Url::toRoute(['/manage/sharedsafari/update-fixed-departure', 'slug' => $share_safari->slug]) ?>"><i class="fas fa-edit me-1"></i>Update
                                            Fixed Departure</a>
                                    <?php } ?>

                                </div>
                                <div class="btns-safaries">
                                    <?php if ($share_safari->status == 2) { ?>
                                        <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="#">Closed Safari</a>
                                        <?php } else {
                                        if (Yii::$app->user->identity) {
                                            $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                            if ($share_safari_intrested) { ?>
                                                <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="/sharedsafari/default/unjoin?slug=<?= $share_safari->slug ?>" data-method="POST"> Leave Safari</a>
                                            <?php } else if ($share_safari->host_user_id != $login_safarioperator->id) { ?>
                                                <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=<?= $share_safari->slug ?>" data-method="POST">Join Safari</a>
                                            <?php }
                                        } else { ?>
                                            <a class="join_btn newbgjoin text-center mt-sm-0 mt-2" href="/site/auth?authclient=google"> Join Safari</a>
                                    <?php }
                                    } ?>
                                </div>


                            </div>

                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pt-4">
                        <div class="text_safaripackage">
                            <p><?= $share_safari->safari_plan ?></p>
                        </div>
                    </div>
                </div>
                <div class="row  mt-4 itenary_tabs">
                    <div class="col-lg-12 col-xl-11 safartabs position-relative">
                        <ul class="nav nav-tabs d-none d-lg-flex gap-2" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="discussion-tab" data-bs-toggle="tab" data-bs-target="#discussion-tab-pane" type="button" role="tab" aria-controls="discussion-tab-pane" aria-selected="true">Discussion</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">ITINERARY</button>
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

<section class="safari_wrapper mb-5 margin_bottomfooter">
    <div class="container-lg">
        <div class="row mb-5  mt-5 itenary_tabs">
            <div class="col-lg-9 col-xl-9 safartabs position-relative">
                <div class="tab-content accordion" id="myTabContent">
                    <div class="tab-pane fade show active accordion-item mb-3" id="discussion-tab-pane" role="tabpanel" aria-labelledby="discussion-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">ITENARY</button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse bg-set card_bodyPadding collapse show mb-3 d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
                            <div class="accordion-body p-3 card-body">
                                <div class="col-lg-12 mb-3">
                                    <div class="itenary-title">
                                        <h6 class="fs-6 fw-bold pb-2">Discussion</h6>
                                    </div>
                                    <div class="itenary_text">
                                        <p><?= $share_safari->safari_plan ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $this->render('_comment', ['colsize' => 'col-md-12', 'share_safari' => $share_safari, 'model' => $model, 'replymodel' => $replymodel, 'login_safarioperator' => $login_safarioperator]) ?>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">ITENARY</button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse bg-set card_bodyPadding collapse show  d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
                            <div class="accordion-body card-body p-3">
                                <div class="col-lg-12 mb-3">
                                    <div class="itenary-title">
                                        <h6 class="fs-6 fw-bold pb-2">ABOUT TRIP / OVERVIEW</h6>
                                    </div>
                                    <div class="itenary_text">
                                        <p><?= $share_safari->safari_plan ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $this->render('_overview', ['share_safari' => $share_safari]) ?>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>

                    <div class="tab-pane fade accordion-item mb-3" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                INCLUSION
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse card_bodyPadding bg-set d-lg-block" aria-labelledby="headingTwo" data-bs-parent="#myTabContent">
                            <div class="accordion-body  card-body">
                                <?= $this->render('_inclusion', ['share_safari' => $share_safari]) ?>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item mb-3" id="getting-there" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingFour">
                            <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                GETTING THERE
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse bg-set card_bodyPadding collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                            <div class="accordion-body  card-body">
                                <?= $this->render('_getting_there', ['share_safari' => $share_safari]) ?>
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
                        <div id="collapseFour" class="accordion-collapse  collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set pt-0">
                                <?= $this->render('_policy', ['share_safari' => $share_safari]) ?>
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
                        <div id="collapseFive" class="accordion-collapse bg-set card_bodyPadding collapse d-lg-block" aria-labelledby="headingFive" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">
                                <?= $this->render('_faq', ['faqs' => $faqs]) ?>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 mb-5 pb-4">
                <button class="intested_btn interestBtn " style="background-color: var(--background-primary) !important;" value="<?= Url::toRoute(['/sharedsafari/default/interestview', 'share_safari_id' => $share_safari->id]) ?>"><i class="fa-solid fa-user-group"></i>
                    Interested - <?= $share_safari->getIntrested()->where(['status' => 1])->count() ?></button>
                <div class="interst_wrapper bg-white " style="min-height: 200px;">
                    <!-- <div class="titlerescent pb-3">
                        <h3>Intrested</h3>
                    </div> -->
                    <div class="users_profile d-flex gap-3 align-items-center flex-wrap">
                        <?php if ($intrested_users = $share_safari->getIntrested()->where(['status' => 1])->all()) {
                            foreach ($intrested_users as $intrested_user) {
                        ?>
                                <div class="profileavtar">
                                    <img src="<?= $intrested_user->user && $intrested_user->user->avatar <> '' ? $intrested_user->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpinterested.png' ?>" alt="" class="rounded-circle" title="<?= $intrested_user->user ? $intrested_user->user->name : '' ?>">
                                </div>

                        <?php }
                        } ?>
                    </div>
                </div>
                <?php if ($share_safari->sharesafarigallery) {
                    $galleries = $share_safari->sharesafarigallery;
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
</section>

<div class="modal fade modal_enquiry" id="exampleModalenquiry" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="modal-title fs-5 text-center pb-3" id="exampleModalLabel">Enquire</h1>
            </div>
            <div class="modal-body px-2 pt-0">
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