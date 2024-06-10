<?php

use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\GeneralModel;
use frontend\models\ArticleSearch;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'Operator  ' . $operator->register_comapany_name;
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::OPERATOR_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
$recentposts = ArticleSearch::recentpost();

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
                                <div class="title_tours d-flex align-items-center gap-md-3">
                                    <h3>Pugdundee Safaris</h3>
                                    <!-- <span class="d-sm-block d-none">|</span> -->
                                    <div class="follow">
                                        <button class="follow_btn"><i class="fa-regular fa-heart me-1"></i> FOLLOW</button>
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
                                        <p class="mb-0"><?= isset($operator->google_review_count) ? $operator->google_review_count . 'Google Reviews' : '0 Google Reviews' ?></p>
                                    </div>
                                </div>
                                <div class="detailsText pb-3">
                                    <p style="font-size: 14px;"><?= GeneralModel::get_substring($operator->about_business); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 px-lg-4 px-xl-5 px-2 px-1 pt-lg-0 pt-3">
                            <div class="contact_p">
                                <p>Contact</p>
                            </div>
                            <div class="d-flex gap-md-5 gap-2">
                                <div class="phone">
                                    <a href="tel:<?= $operator->phone_no ?>"><i class="fa-solid fa-phone me-2"></i> <span>Call</span></a>
                                </div>
                                <div class="phone">
                                    <a href="mailto:<?= $operator->email ?>"><i class="fa-solid fa-envelope me-2"></i> <span> Email</span></a>
                                </div>
                            </div>
                            <div class="socil-links d-flex gap-md-4 gap-2 my-3 flex-wrap">
                                <div class="fs">
                                    <a href="<?= $operator->facebook_url ?>"><i class="fa-brands fa-facebook-f"></i></a>
                                </div>
                                <div class="fs">
                                    <a href="<?= $operator->instagram_url ?>"> <i class="fa-brands fa-instagram"></i></a>
                                </div>
                                <div class="fs">
                                    <a href="<?= $operator->youtube_link ?>"> <i class="fa-brands fa-youtube"></i></a>
                                </div>
                            </div>
                            <div class="websitebtn pt-3">
                                <a href="<?= $operator->website ?>">OFFICIAL WEBSITE</a>
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
                    <div class="titlerescent ">
                        <h3>Pugdundee Safaris</h3>
                    </div>
                    <div class="topics_listing">
                        <ul id="tabList">
                            <li><a class="tab-items active_safri" data-tab="safariParks">
                                    <div class="numparks">Safari Parks <span>6</span></div><i class="fa-solid fa-chevron-right"></i>
                                </a></li>
                            <li><a class="tab-items " data-tab="resort">
                                    <div class="numparks">Resort <span>7</span></div><i class="fa-solid fa-chevron-right"></i>
                                </a></li>
                            <li><a class="tab-items" data-tab="sharedSafari">
                                    <div class="numparks">Shared Safari <span>17</span></div><i class="fa-solid fa-chevron-right"></i>
                                </a></li>
                            <li><a class="tab-items " data-tab="review">
                                    <div class="numparks">Review <span>59</span></div><i class="fa-solid fa-chevron-right"></i>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xxl-10 col-xl-9">
                <div class="tab-content_tour active " id="safariParks">
                    <!-- Safari Parks content goes here -->
                    <div class="searchSafari_parks mb-4">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="parksImg h-100">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" class="w-100 h-100">
                                </div>
                            </div>
                            <div class="col-xl-9 ">
                                <div class="parks_body">
                                    <div class="safrititles pt-md-0 pt-3">
                                        <h6 class="">Bandhavgarh National Park</h6>
                                    </div>
                                    <div class="seelctes_text pt-2 pb-3 ">
                                        <p>Bandhavgarh National Park is spread over the Vindhya hills in Madhya
                                            Pradesh. The national park consists of a core area of 105 sq km and a
                                            buffer area of approximately 400 sq km. The topography of the whole area
                                            varies between steep ridges, undulating forest and open meadows.
                                            Bandhavgarh National Park is known for the Royal Bengal Tigers. The
                                            density of the tiger population at Bandhavgarh is the highest known in
                                            India as well as in the world. The national park was the former hunting
                                            preserve of the Maharaja of Rewa and at present is a famous natural hub
                                            for White Tigers. White Tigers, now a major attraction around the
                                            world’s zoos, were first discovered in Rewa, not far from here. It is
                                            also believed that all the white tigers across the globe trace their
                                            roots to Bandhavgarh.</p>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/hotel_forest_location.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Madhya Pradesh, Central India</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Gypsy and Canter</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Umaria Railway Station, Katni Railway Station
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Morning, Evening, Night</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/airport.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Jabalpur Airport</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/pawprint_3175935.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Tiger, Leopard, Wolf, Chital, Black Buck</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="searchSafari_parks mb-4">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="parksImg h-100">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Kazirangasmall.jpg" alt="" class="w-100 h-100">
                                </div>
                            </div>
                            <div class="col-xl-9 ">
                                <div class="parks_body">
                                    <div class="safrititles pt-md-0 pt-3">
                                        <h6 class="">Jim Corbett National Park</h6>
                                    </div>
                                    <div class="seelctes_text pt-2 pb-3 ">
                                        <p>Bandhavgarh National Park is spread over the Vindhya hills in Madhya
                                            Pradesh. The national park consists of a core area of 105 sq km and a
                                            buffer area of approximately 400 sq km. The topography of the whole area
                                            varies between steep ridges, undulating forest and open meadows.
                                            Bandhavgarh National Park is known for the Royal Bengal Tigers. The
                                            density of the tiger population at Bandhavgarh is the highest known in
                                            India as well as in the world. The national park was the former hunting
                                            preserve of the Maharaja of Rewa and at present is a famous natural hub
                                            for White Tigers. White Tigers, now a major attraction around the
                                            world’s zoos, were first discovered in Rewa, not far from here. It is
                                            also believed that all the white tigers across the globe trace their
                                            roots to Bandhavgarh.</p>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/hotel_forest_location.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Madhya Pradesh, Central India</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Gypsy and Canter</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Umaria Railway Station, Katni Railway Station
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Morning, Evening, Night</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/airport.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Jabalpur Airport</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/pawprint_3175935.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Tiger, Leopard, Wolf, Chital, Black Buck</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="searchSafari_parks mb-4">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="parksImg h-100">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Kanhasmall.jpg" alt="" class="w-100 h-100">
                                </div>
                            </div>
                            <div class="col-xl-9 ">
                                <div class="parks_body">
                                    <div class="safrititles pt-md-0 pt-3">
                                        <h6 class="">Kanha National Park</h6>
                                    </div>
                                    <div class="seelctes_text pt-2 pb-3 ">
                                        <p>Bandhavgarh National Park is spread over the Vindhya hills in Madhya
                                            Pradesh. The national park consists of a core area of 105 sq km and a
                                            buffer area of approximately 400 sq km. The topography of the whole area
                                            varies between steep ridges, undulating forest and open meadows.
                                            Bandhavgarh National Park is known for the Royal Bengal Tigers. The
                                            density of the tiger population at Bandhavgarh is the highest known in
                                            India as well as in the world. The national park was the former hunting
                                            preserve of the Maharaja of Rewa and at present is a famous natural hub
                                            for White Tigers. White Tigers, now a major attraction around the
                                            world’s zoos, were first discovered in Rewa, not far from here. It is
                                            also believed that all the white tigers across the globe trace their
                                            roots to Bandhavgarh.</p>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/hotel_forest_location.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Madhya Pradesh, Central India</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Gypsy and Canter</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Umaria Railway Station, Katni Railway Station
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Morning, Evening, Night</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/airport.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Jabalpur Airport</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/pawprint_3175935.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Tiger, Leopard, Wolf, Chital, Black Buck</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-content_tour " id="resort">
                    <div class="searchSafari_parks mb-4">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="slider_resorts resort owl-carousel owl-theme position-relative h-100">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" class="w-100  h-100">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" class="w-100 ">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" class="w-100">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" class="w-100">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" class="w-100">
                                </div>
                                <!-- <div class="parksImg h-100">
                                    <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" class="w-100 h-100">
                                </div> -->
                            </div>
                            <div class="col-lg-8 position-relative">
                                <div class="parks_body">
                                    <div class="safrititles pt-md-0 pt-3">
                                        <h6 class="">Bandhavgarh National Park</h6>
                                    </div>
                                    <div class="seelctes_text pt-2 pb-3 ">
                                        <p>One of the most popular wildlife sanctuaries of Madhya Pradesh with one
                                            of
                                            the highest densities of tigers in India. This biodiverse park is known
                                            for
                                            its large population of royal Bengal tigers, especially in the central
                                            Tala
                                            zone. Other animals include white tigers, leopards and deer. The mix of
                                            tropical forest, Sal trees and grassland is home to scores of bird
                                            species,
                                            including eagles.</p>
                                    </div>
                                    <div class="row pb-5">
                                        <div class="col-sm-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/safari_4391688.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">4 Safaris</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/car-seat_5102816.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Available Seats - 4/6</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/camera.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Photography</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="safridetails_form d-flex gap-3 align-items-center">
                                                <div class="iconImg">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/car-seat_5102816.png" alt="">
                                                </div>
                                                <div class="text-form">
                                                    <p class="mb-0">Premium</p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="resort_booking">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="reosrtBook">
                                                <h3>Book Now</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>

                <div class="tab-content_tour" id="sharedSafari">
                    <!-- Shared Safari content goes here -->
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-3 gx-lg-5">
                        <div class="col mb-4">
                            <div class="sharesafri-card">
                                <div class="flotingdate">
                                    <div class="icons text-center">
                                        <p class="mb-0">OCT</p>
                                        <p class="mb-0">3</p>
                                    </div>
                                </div>
                                <div class="shareimg">
                                    <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                                </div>
                                <div class="card_body">
                                    <div class="top_seats">
                                        <div class="safari d-flex justify-content-between ">
                                            <div class="safarinum d-flex gap-2 align-items-center ">
                                                <p class="text_safari">SAFARI</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                            <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                <p class="text_safari">SEATS</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="titleDate">
                                        <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
                                        <div class="orgnizer">
                                            <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                        </div>
                                    </div>
                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                        <div class="col-6">
                                            <div class="users">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <div class="roundes_countuser">
                                                    15+
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="safari text-center">
                                                <div class="joinsafari">
                                                    <a href="share-safari.html">Join Safari</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="sharesafri-card">
                                <div class="flotingdate">
                                    <div class="icons text-center">
                                        <p class="mb-0">OCT</p>
                                        <p class="mb-0">3</p>
                                    </div>
                                </div>
                                <div class="shareimg">
                                    <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                                </div>
                                <div class="card_body">
                                    <div class="top_seats">
                                        <div class="safari d-flex justify-content-between ">
                                            <div class="safarinum d-flex gap-2 align-items-center ">
                                                <p class="text_safari">SAFARI</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                            <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                <p class="text_safari">SEATS</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="titleDate">
                                        <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
                                        <div class="orgnizer">
                                            <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                        </div>
                                    </div>
                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                        <div class="col-6">
                                            <div class="users">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <div class="roundes_countuser">
                                                    15+
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="safari text-center">
                                                <div class="joinsafari">
                                                    <a href="share-safari.html">Join Safari</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="sharesafri-card">
                                <div class="flotingdate">
                                    <div class="icons text-center">
                                        <p class="mb-0">OCT</p>
                                        <p class="mb-0">3</p>
                                    </div>
                                </div>
                                <div class="shareimg">
                                    <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                                </div>
                                <div class="card_body">
                                    <div class="top_seats">
                                        <div class="safari d-flex justify-content-between ">
                                            <div class="safarinum d-flex gap-2 align-items-center ">
                                                <p class="text_safari">SAFARI</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                            <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                <p class="text_safari">SEATS</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="titleDate">
                                        <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
                                        <div class="orgnizer">
                                            <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                        </div>
                                    </div>
                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                        <div class="col-6">
                                            <div class="users">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <div class="roundes_countuser">
                                                    15+
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="safari text-center">
                                                <div class="joinsafari">
                                                    <a href="share-safari.html">Join Safari</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="sharesafri-card">
                                <div class="flotingdate">
                                    <div class="icons text-center">
                                        <p class="mb-0">OCT</p>
                                        <p class="mb-0">3</p>
                                    </div>
                                </div>
                                <div class="shareimg">
                                    <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                                </div>
                                <div class="card_body">
                                    <div class="top_seats">
                                        <div class="safari d-flex justify-content-between ">
                                            <div class="safarinum d-flex gap-2 align-items-center ">
                                                <p class="text_safari">SAFARI</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                            <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                <p class="text_safari">SEATS</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="titleDate">
                                        <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
                                        <div class="orgnizer">
                                            <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                        </div>
                                    </div>
                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                        <div class="col-6">
                                            <div class="users">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <div class="roundes_countuser">
                                                    15+
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="safari text-center">
                                                <div class="joinsafari">
                                                    <a href="share-safari.html">Join Safari</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="sharesafri-card">
                                <div class="flotingdate">
                                    <div class="icons text-center">
                                        <p class="mb-0">OCT</p>
                                        <p class="mb-0">3</p>
                                    </div>
                                </div>
                                <div class="shareimg">
                                    <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                                </div>
                                <div class="card_body">
                                    <div class="top_seats">
                                        <div class="safari d-flex justify-content-between ">
                                            <div class="safarinum d-flex gap-2 align-items-center ">
                                                <p class="text_safari">SAFARI</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                            <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                <p class="text_safari">SEATS</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="titleDate">
                                        <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
                                        <div class="orgnizer">
                                            <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                        </div>
                                    </div>
                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                        <div class="col-6">
                                            <div class="users">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <div class="roundes_countuser">
                                                    15+
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="safari text-center">
                                                <div class="joinsafari">
                                                    <a href="share-safari.html">Join Safari</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="sharesafri-card">
                                <div class="flotingdate">
                                    <div class="icons text-center">
                                        <p class="mb-0">OCT</p>
                                        <p class="mb-0">3</p>
                                    </div>
                                </div>
                                <div class="shareimg">
                                    <a href="share-safari.html"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhsmall.jpg" alt=""></a>
                                </div>
                                <div class="card_body">
                                    <div class="top_seats">
                                        <div class="safari d-flex justify-content-between ">
                                            <div class="safarinum d-flex gap-2 align-items-center ">
                                                <p class="text_safari">SAFARI</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                            <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                <p class="text_safari">SEATS</p>
                                                <h6 class="number-safari">5</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="titleDate">
                                        <h6><a href="share-safari.html">Bandhavgarh Tiger Reserve</a></h6>
                                        <div class="orgnizer">
                                            <p>Organized by: <strong>Dhawal Bharija</strong></p>
                                        </div>
                                    </div>
                                    <div class="footer_card row pb-2 px-2 align-items-center">
                                        <div class="col-6">
                                            <div class="users">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                <div class="roundes_countuser">
                                                    15+
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="safari text-center">
                                                <div class="joinsafari">
                                                    <a href="share-safari.html">Join Safari</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-content_tour mb-4" id="review">
                    <div class="row">
                        <div class="col-12">
                            <div class="comments_safari operator_comment">
                                <div class="commentsOther  position-relative">
                                    <div class=" d-flex justify-content-between flex-wrap">
                                        <div class="userRatingTitle">
                                            <h6 class="nameRating">Avarage User Rating</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">
                                                <div class="ratings">
                                                    <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">54 Google Reviews</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="whiteReview">
                                            <button class="btn_review" data-bs-toggle="modal" data-bs-target="#exampleModal2">+ Write a Review</button>
                                        </div>
                                    </div>
                                    <div class="sort_wrapper py-3">
                                        <div class="sortBy">Sort by</div>
                                        <button class="btn_sort active">Newest</button>
                                        <button class="btn_sort">Highest</button>
                                        <button class="btn_sort">Lowest</button>
                                    </div>
                                </div>
                                <div class="commentsOther  position-relative">
                                    <div class="objec-flgs">
                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                                    </div>
                                    <div class="postcomment  pt-3">
                                        <div class="text_com">
                                            <h6 class="nameavatr">Jim cobbert National Park</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-2">
                                                <div class="ratings">
                                                    <p class="mb-0"> <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">Rahul</p>
                                                </div>
                                            </div>
                                            <p>Oh, that sounds amazing! I've always wanted to experience the thrill
                                                of seeing
                                                wild animals up close.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="commentsOther position-relative">
                                    <div class="objec-flgs">
                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                                    </div>
                                    <div class="postcomment  pt-3">
                                        <div class="text_com">
                                            <h6 class="nameavatr">Jim cobbert National Park</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-2">
                                                <div class="ratings">
                                                    <p class="mb-0"> <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">Rahul</p>
                                                </div>
                                            </div>
                                            <p>Oh, that sounds amazing! I've always wanted to experience the thrill
                                                of seeing
                                                wild animals up close.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="commentsOther position-relative">
                                    <div class="objec-flgs">
                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                                    </div>
                                    <div class="postcomment  pt-3">
                                        <div class="text_com">
                                            <h6 class="nameavatr">Jim cobbert National Park</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-2">
                                                <div class="ratings">
                                                    <p class="mb-0"> <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">Rahul</p>
                                                </div>
                                            </div>
                                            <p>Oh, that sounds amazing! I've always wanted to experience the thrill
                                                of seeing
                                                wild animals up close.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="commentsOther position-relative">
                                    <div class="objec-flgs">
                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                                    </div>
                                    <div class="postcomment  pt-3">
                                        <div class="text_com">
                                            <h6 class="nameavatr">Jim cobbert National Park</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-2">
                                                <div class="ratings">
                                                    <p class="mb-0"> <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">Rahul</p>
                                                </div>
                                            </div>
                                            <p>Oh, that sounds amazing! I've always wanted to experience the thrill
                                                of seeing
                                                wild animals up close.</p>
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
</section>


<section class="safariduring_sesons innerpage">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="title_web">
                    <h2>BEST SAFARIS DURING <br>MONSOON SEASON</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="safari-carousel owl-carousel owl-theme">
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Jim Corbett.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">JIM CORBETT</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">JIM CORBETT</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
                        its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Gir.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">GIR NATIONAL PARK</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">GIR NATIONAL PARK</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
                        its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Kanha.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">KANHA NATIONAL PARK</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">KANHA NATIONAL PARK</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
                        its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarh.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">BANDHAVGARH</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">BANDHAVGARH</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
                        its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
        <div class="safari-box">
            <figure class="image-box"><img src="<?= $this->params['baseurl'] ?>/img/Kaziranga.jpg" alt=""></figure>
            <div class="content-box">
                <h3><a href="deer.html">KAZIRANGA</a></h3>
            </div>
            <div class="overlay-content d-flex align-items-center justify-content-between">
                <div class="content_o pe-2">
                    <h3><a href="deer.html">KAZIRANGA</a></h3>
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in
                        its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
    </div>
</section>