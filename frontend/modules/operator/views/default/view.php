<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\interfaces\Constants;
use frontend\models\ArticleSearch;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;


/* @var $this yii\web\View */

$this->title = 'Safari Operator  | ' . $operator->register_comapany_name;
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::OPERATOR_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
$recentposts = ArticleSearch::recentpost();
// $reviews = SafariOperatorRating::find()->where(['safari_operator_id' => $operator->id])->all();

?>


<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 " alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Safari Tour Operator</h1>
                        <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                                Their Adventures</p> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="touroprator_section">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="top_opratorsBox">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="tourLogoes">
                                <div class="images_tour">
                                    <img src="<?= isset($operator->logo) ? $operator->imagepath : $this->params['baseurl'] . '/img/Pugdundee.jpg' ?>" alt="">
                                    <!-- <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100" loading="lazy"> -->
                                </div>
                                <div class="slect_safricound2 d-flex justify-content-around mt-4">
                                    <div class="parks_text text-center">
                                        <p><?= count($operator->park) ?></p>
                                        <p>Parks</p>
                                    </div>
                                    <div class="parks_text text-center">
                                        <p>0</p>
                                        <p>Resorts</p>
                                    </div>
                                    <div class="parks_text text-center">
                                        <p>0</p>
                                        <p>Shared Safari</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6  border-right  border_bottom_mobile pt-lg-0 pt-3">
                            <div class="provider_details">
                                <div class="title_tours d-flex flex-wrap align-items-center gap-md-2 gap-xxl-3">
                                    <h3><?= $operator->business_name ?></h3>
                                    <!-- <span class="d-sm-block d-none">|</span> -->
                                    <div class="follow mb-lg-2 mb-xxl-0 mb-2">

                                        <?php if (Yii::$app->user->identity) {
                                            $operator_follow = SafariOperatorFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'safari_operator_id' => $operator->id, 'status' => 1])->limit(1)->one();
                                            if ($operator_follow) { ?>
                                                <a class="follow_btn" href="/operator/default/unfollow?id=<?= $operator->id ?>"><i class="fa fa-heart me-1"></i> UNFOLLOW</a>
                                            <?php } else { ?>
                                                <a class="follow_btn" href="/operator/default/follow?id=<?= $operator->id ?>"><i class="fa-regular fa-heart me-1"></i> FOLLOW</a>
                                            <?php  }
                                        } else { ?>
                                            <a class="follow_btn" href="/site/auth?authclient=google"><i class="fa-regular fa-heart me-1"></i> FOLLOW</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="title_tours">
                                    <p class="pb-sm-0 "> Safari Tour Operator</p>
                                </div>

                                <div class="providerNamerating d-flex flex-wrap gap-4 align-items-center pb-3 pt-2">
                                    <div class="ratings">
                                        <p class="mb-0"><?= $operator->google_rating ?> <?= GeneralModel::ratiing_views($operator->google_rating); ?></p>
                                    </div>
                                    <div class="googlerating">
                                        <p class="mb-0"><?= isset($operator->google_review_count) ? $operator->google_review_count . ' Reviews' : '0 Reviews' ?></p>
                                    </div>
                                </div>
                                <div class="detailsText pb-3">
                                    <p style="font-size: 14px;"><?= GeneralModel::get_substring($operator->about_business); ?>
                                        <?php if (str_word_count($operator->about_business) >= 99) { ?>
                                            <a href="" data-bs-toggle="modal" data-bs-target="#modalSeeMore" class="seemoreBtn">See more</a>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 px-lg-4 px-xl-3 px-xxl-5 px-2  pt-lg-0 pt-3">
                            <div class="contact_p">
                                <p>Contact</p>
                            </div>
                            <div class="d-flex gap-md-5 gap-2">
                                <div class="phone">
                                    <a href="tel:<?= $operator->phone_no ?>">
                                        <i class="fa-solid fa-phone me-2"></i>
                                        <span>Call</span>
                                        <div class="phone-numbers">
                                            <a href="tel:<?= $operator->phone_no ?>"><?= $operator->phone_no ?></a>
                                            <a href="tel:<?= $operator->operator_phone_no ?>"><?= $operator->operator_phone_no ?></a>
                                        </div>
                                    </a>
                                </div>
                                <div class="phone email">
                                    <a href="mailto:<?= $operator->email ?>">
                                        <i class="fa-solid fa-envelope me-2"></i>
                                        <span>Email</span>
                                        <div class="email-addresses">
                                            <a href="mailto:<?= $operator->email ?>"><?= $operator->email ?></a>
                                            <a href="mailto:<?= $operator->operator_email ?>"><?= $operator->operator_email ?></a>
                                        </div>
                                    </a>
                                </div>

                            </div>
                            <div class="socil-links d-flex gap-md-4 gap-2 my-3 flex-wrap">
                                <div class="fs <?= $operator->facebook_url ? '' : 'no-link-found' ?>">
                                    <a href="<?= $operator->facebook_url ? $operator->facebook_url : '#' ?>"><i class="fa-brands fa-facebook-f"></i></a>
                                </div>
                                <div class="fs <?= $operator->instagram_url ? '' : 'no-link-found' ?>">
                                    <a href="<?= $operator->instagram_url ? $operator->instagram_url : '#' ?>"> <i class="fa-brands fa-instagram"></i></a>
                                </div>
                                <div class="fs <?= $operator->youtube_link ? '' : 'no-link-found' ?>">
                                    <a href="<?= $operator->youtube_link ? $operator->youtube_link : '#' ?>"> <i class="fa-brands fa-youtube"></i></a>
                                </div>
                            </div>
                            <div class="websitebtn pt-3 <?= $operator->website ? '' : 'no-link-found' ?>">
                                <a href="<?= $operator->website ? $operator->website : '#' ?>">OFFICIAL WEBSITE</a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center  mb-4">
            <?= $this->render('_free_quote', [
                'model' => $model,
                'operator' => $operator,
            ]) ?>
        </div>

    </div>
    <div class="container-fluid">
        <div class="row pt-5">
            <div class="col-lg-4 col-xl-3 col-xxl-2  mb-lg-0 mb-3">
                <div class="safri_tour">
                    <div class="titlerescent" style="justify-content:left !important;">
                        <h3 style="text-align:left !important;"><?= $operator->business_name ?></h3>
                    </div>
                    <div class="topics_listing">
                        <ul id="tabList">
                            <li><a class="tab-items active_safri" data-tab="safariParks">
                                    <div class="numparks">Safari Parks <span><?= count($operator->park) ?></span></div><i class="fa-solid fa-chevron-right"></i>
                                </a></li>
                            <!-- <li><a class="tab-items " data-tab="resort">
                                    <div class="numparks">Resort <span>0</span></div><i class="fa-solid fa-chevron-right"></i>
                                </a></li> -->
                            <li><a class="tab-items" data-tab="sharedSafari">
                                    <div class="numparks">Shared Safari <span><?= count($shared_safaries) ?></span></div><i class="fa-solid fa-chevron-right"></i>
                                </a></li>
                            <li><a class="tab-items " data-tab="review">
                                    <div class="numparks">Review <span><?= count($reviews) ?></span></div><i class="fa-solid fa-chevron-right"></i>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xxl-10 col-xl-9 paddingset_desktop">
                <div class="tab-content_tour active " id="safariParks">
                    <!-- Safari Parks content goes here -->
                    <?= $this->render('_operator_safari_park', [
                        'operator_parks' => $operator_parks,
                    ]) ?>
                </div>

                <div class="tab-content_tour " id="resort">
                    <?= $this->render('_resort') ?>
                </div>

                <div class="tab-content_tour" id="sharedSafari">
                    <!-- Shared Safari content goes here -->
                    <?= $this->render('_shared_safari', [
                        'shared_safaries' => $shared_safaries,
                    ]) ?>
                </div>

                <div class="tab-content_tour mb-4" id="review">
                    <?= $this->render('_review', [
                        'operator' => $operator,
                        'reviews' => $reviews,
                        'ratingsearchModel' => $ratingsearchModel
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="safariduring_sesons innerpage">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>



<div class="modal fade" id="modalSeeMore" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $operator->register_comapany_name ?></h1>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body modal_form">
                <div class="terms_details">
                    <p>
                        <?= $operator->about_business ?>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    /* Flex container styles */
    .d-flex {
        display: flex;
    }

    /* Gap between items on medium and larger screens */
    .gap-md-5 {
        gap: 20px;
        /* Adjust as needed */
    }

    /* Gap between items on smaller screens */
    .gap-2 {
        gap: 5px;
        /* Adjust as needed */
    }

    /* Phone and email container styles */
    .phone,
    .email {
        position: relative;
    }

    /* Styling for links (Call and Email) */
    .phone a,
    .email a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Hover effect for links */
    .phone a:hover,
    .email a:hover {
        background-color: #f0f0f0;
        /* Change background color on hover */
    }

    /* Styling for icons */
    .phone i,
    .email i {
        font-size: 1.2rem;
        /* Adjust icon size */
        margin-right: 8px;
        /* Space between icon and text */
    }

    /* Styling for dropdowns (phone numbers and email addresses) */
    .phone .phone-numbers,
    .email .email-addresses {
        display: none;
        position: absolute;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
        border-radius: 5px;
        z-index: 10;
    }

    /* Show dropdowns on hover */
    .phone:hover .phone-numbers,
    .email:hover .email-addresses {
        display: block;
    }

    /* Styling for links inside dropdowns */
    .phone .phone-numbers a,
    .email .email-addresses a {
        display: block;
        color: #333;
        text-decoration: none;
        margin-top: 5px;
        transition: color 0.3s ease;
    }

    /* Hover effect for links inside dropdowns */
    .phone .phone-numbers a:hover,
    .email .email-addresses a:hover {
        color: #007bff;
        /* Change color on hover */
    }
</style>