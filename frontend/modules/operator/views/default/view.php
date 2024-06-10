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
                                    <p style="font-size: 14px;"><?= GeneralModel::get_substring($operator->about_business); ?> <a href="" data-bs-toggle="modal" data-bs-target="#modalSeeMore" class="seemoreBtn">See more</a></p>
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
            <div class="col-lg-12 col-xl-9">
                <div class="get_free_title">
                    <h4>Get a FREE quote</h4>
                </div>
                <div class="getquote_box">
                    <div class="row ">
                        <div class="col-lg-3">
                            <div class="form-wrapper">
                                <label for="">Safari Park</label>
                                <select class="form-select mb-3" aria-label="Default select example">
                                    <option selected="">Jim Corbett</option>
                                    <option value="1">January</option>
                                    <option value="2">Febraury</option>
                                    <option value="3">March</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-wrapper d-flex gap-3">
                                <div class="input-group2 mb-3">
                                    <label for="safaris">Safaris</label>
                                    <div class="number-input position-relative">
                                        <input type="number" id="safaris" value="6" class="form-control">
                                        <div class="bton_updown">
                                            <button onclick="increment('safaris')"><i class="fa-solid fa-chevron-up"></i></button>
                                            <button onclick="decrement('safaris')"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>

                                </div>
                                <div class="input-group2">
                                    <label for="travelers">Travelers</label>
                                    <div class="number-input position-relative">
                                        <input type="number" id="travelers" value="6" class="form-control">
                                        <div class="bton_updown">
                                            <button onclick="decrement('travelers')"><i class="fa-solid fa-chevron-up"></i></button>
                                            <button onclick="decrement('travelers')"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-wrapper">
                                <label for="">Stay Category</label>
                                <select class="form-select mb-3" aria-label="Default select example">
                                    <option selected="">Standard</option>
                                    <option value="1">January</option>
                                    <option value="2">Febraury</option>
                                    <option value="3">March</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-wrapper">
                                <label for="">Start Date</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-wrapper">
                                <label for="">End Date</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-wrapper mb-3">
                                <label for="">Full Name</label>
                                <input type="text" class="form-control" placeholder="Your name">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-wrapper mb-3">
                                <label for="">Email Address</label>
                                <input type="text" class="form-control" placeholder="xyz@abc.com">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-wrapper mb-3">
                                <label for="">Email Address</label>
                                <input type="text" class="form-control" placeholder="+91">
                            </div>
                        </div>
                        <div class="col-lg-3 margi_top pt-lg-0 pb-3">
                            <button class="sent_btn">Send Request</button>
                        </div>
                        <div class="col-12">
                            <div class="text_get">
                                <p><span>*</span>Your request will be sent directly to the operator, but you can
                                    also contact them directly if you prefer.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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



<div class="modal fade" id="modalSeeMore" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Pugdundee Safaris</h1>
        <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body modal_form">
        <div class="terms_details">
          <h6 class=" pb-3">By accessing, using, or signing up for this website, newsletters, or any services, you enter into a legally binding agreement with Walk Into The Wild based on these terms.</h6>

          <h6>Introduction</h6>
          <p>Welcome to the <a href="https://www.walkintothewild.in/" target="_blank">www.walkintothewild.in</a> website ("Website", "website", "Site" or "site"). This website, its pages, the content, services, and infrastructure are owned, operated, and provided by Walk Into The Wild ("Walk Into The Wild", "Us", "us", "We" or "we") or other parties. The website and its content are provided for your personal, non-commercial use only, subject to the terms of use as set out below. These terms of use (this "Agreement") set forth the terms and conditions governing your use of this website.</p>
          <h6>Modifications to this Agreement</h6>
          <p>We reserve the right to modify this Agreement at our sole discretion. Changes are effective immediately upon updating this page. Please review this Agreement periodically. By continuing to use our website after changes are made, you accept those changes.</p>
          <h6>Privacy</h6>
          <p>We outline our current practices regarding personally identifiable and other information collected through our website in our Privacy Policy. We reserve the right to update our policies and practices at our sole discretion. By using our website, you acknowledge that you have read and agree to our privacy policy.</p>
          <h6>Your use of content and information (disclaimer)</h6>
          <p>We offer a diverse range of content on our website, including information, advice, recommendations, messages, comments, posts, text, graphics, software, music, sound, photographs, videos, data, and other materials ("Content" or "content"). Some content is provided by us or our suppliers, while other content is contributed by users of our website ("Users" or "users"), such as opinions and views shared via reviews, chat rooms, blogs, or message boards. While we strive to ensure the accuracy, completeness, and timeliness of the content on our website, we cannot guarantee it and are not responsible for any inaccuracies, omissions, or delays, whether in content provided by us, our suppliers, or users. Any opinions, advice, statements, or other information expressed by users or third parties are solely their own and do not represent our views.</p>
          <p>We are not obligated to prescreen, edit, or remove any user-provided content posted on or available through our website. However, we reserve the right (but not the obligation), at our sole discretion and for any reason, to prescreen, edit, refuse, remove, or relocate any such content.</p>
          <h6>User generated content</h6>
          <p>User-generated content ("User Content" or "user content") refers to information provided by our users with the intention of being published on our website (e.g., writing a review or posting on our boards). As a user of our website, you assume responsibility for all user content that you submit, post, or otherwise make available through our platform.</p>
          <p>While we do not claim ownership of user content, by submitting, posting, or otherwise making content available through our website, you automatically grant us the right to utilize your user content as we see fit. This includes the non-exclusive, perpetual, transferable, irrevocable right, with the right of sublicensing, and without any royalty or compensation in return, to use, reproduce, modify, translate, distribute, publish, create derivative works, disclose, and duplicate the content across all known and future media. You acknowledge that we may determine how your user content is credited and accept that the content provided may be indexed by search engines such as Google. Additionally, you grant us and any third party appointed by us the right to take legal actions deemed necessary for the protection of the rights of your user content, including, but not limited to, taking legal action on your behalf.</p>
          <p>You agree not to submit, post, or otherwise make available through our website any personally identifiable information about other people or any abusive, obscene, vulgar, slanderous, hateful, threatening, sexually-oriented user content, or any other material that may violate any laws, whether of your country, the Indian, any other country, or international law. You confirm that such user content is not confidential and that you have all necessary permissions to submit, post, and otherwise make available such user content. Moreover, you undertake not to submit, post, or otherwise make available through our website any commercial, advertising, promotional, or spam-like user content. Violation of any of these conditions may lead to immediate and permanent banning, with notification to your Internet Service Provider if deemed necessary by us, and we reserve the right to take other legal action. You agree that we have the discretion to remove, edit, move, or close your account and/or any user content at any time as we deem appropriate.</p>

          <h6>Ownership and Intellectual property rights</h6>
          <p>This website is owned by Walk Into The Wild. All rights and interest in the content available via the website, the website's look and feel, the designs, trademarks, service marks, and trade names displayed on the website, and the website URL are the property of Walk Into The Wild or its licensors, and are protected by copyrights, trademarks, patents, or other proprietary rights and laws. You may not use any content available via the website in any manner or for any purpose without the prior written permission of us or, if applicable, our licensors. All rights not expressly granted in this Agreement are expressly reserved to Walk Into The Wild and its licensors.</p>
          <h6>Your contact with advertisers or other third parties</h6>
          <p>Your interactions with advertisers or other third parties found on or accessible through our website are exclusively between you and the third party. These interactions encompass, but are not limited to, your engagement in promotions, the payment for and receipt of items such as safari tours, if any, and any terms, conditions, warranties, or representations associated with such transactions. Your access and use of such sites, including the content, items, or services offered on those sites, is solely at your own risk. We do not provide any assurances or guarantees regarding the content or privacy practices of such third parties, or otherwise concerning the services or items provided by them. By using our website, you acknowledge and agree that we bear no responsibility for any loss or damage of any nature arising from your dealings with any third party or their presence on our website.</p>
          <h6>Disclaimer of warranties</h6>
          <p>THE WEBSITE IS PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS. WALK INTO THE WILD EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, WITHOUT LIMITATION, ANY WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NONINFRINGEMENT. WALK INTO THE WILD DOES NOT MAKE ANY WARRANTY THAT THE WEBSITE WILL MEET YOUR REQUIREMENTS, OR THAT ACCESS TO THE WEBSITE WILL BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR-FREE, OR THAT DEFECTS, IF ANY, WILL BE CORRECTED. WALK INTO THE WILD MAKES NO WARRANTIES AS TO THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF THE WEBSITE OR AS TO THE ACCURACY, QUALITY, OR RELIABILITY OF ANY INFORMATION OBTAINED THROUGH THE WEBSITE.</p>
          <h6>Disclaimer of warranties</h6>
          <p>WALK INTO THE WILD AND ITS AFFILIATES ASSUME NO RESPONSIBILITY FOR ANY CONSEQUENCES DIRECTLY OR INDIRECTLY RELATED TO ANY ACTION OR INACTION YOU TAKE BASED ON THE CONTENT AVAILABLE VIA THE WEBSITE. YOU MUST ASSESS AND BEAR ALL RISKS ASSOCIATED WITH THE USE OF ANY CONTENT, INCLUDING ANY RELIANCE ON THE ACCURACY, COMPLETENESS, OR USEFULNESS OF SUCH CONTENT. YOU SPECIFICALLY ACKNOWLEDGE THAT WALK INTO THE WILD IS NOT LIABLE FOR THE DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF USERS OR THIRD PARTIES.</p>
          <p>ADDITIONALLY, IN NO EVENT WILL WALK INTO THE WILD OR ITS AFFILIATES BE LIABLE FOR ANY SPECIAL, INDIRECT, INCIDENTAL, PUNITIVE, OR CONSEQUENTIAL DAMAGES, INCLUDING, WITHOUT LIMITATION, ANY LOSS OF USE, LOSS OF PROFITS, LOSS OF DATA, COST OF PROCUREMENT OF SUBSTITUTE PRODUCTS OR SERVICES, OR ANY OTHER SUCH DAMAGES, HOWSOEVER CAUSED, AND ON ANY THEORY OF LIABILITY, WHETHER FOR BREACH OF CONTRACT, TORT (INCLUDING NEGLIGENCE AND STRICT LIABILITY), OR OTHERWISE RESULTING FROM (1) THE USE OF, OR THE INABILITY TO USE THE WEBSITE; (2) THE COST OF PROCUREMENT OF SUBSTITUTE SERVICES, ITEMS, OR WEBSITES; (3) UNAUTHORIZED ACCESS TO OR ALTERATION OF YOUR TRANSMISSIONS OR DATA; (4) THE STATEMENTS OR CONDUCT OF ANY THIRD PARTY ON THE WEBSITE; OR (5) ANY OTHER MATTER RELATING TO THE WEBSITE. THESE LIMITATIONS WILL APPLY WHETHER OR NOT WALK INTO THE WILD HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES AND NOTWITHSTANDING ANY FAILURE OF THE ESSENTIAL PURPOSE OF ANY LIMITED REMEDY.</p>
          </p>
          <h6>Indemnification</h6>
          <p>You agree to indemnify and hold harmless Walk Into The Wild, its directors, officers, employees, owners, agents, and affiliates, from and against any and all liability, damages, losses, claims, and expenses of any kind (including, without limitation, reasonable attorneys' fees) directly or indirectly related to (1) your breach of the Agreement; or (2) the user content you submit, post, or transmit through the website.</p>

          <h6>Your account</h6>
          <p>You are accountable for safeguarding the confidentiality of any passwords linked to your account on our website, monitoring all activity under the account, and taking full responsibility for all actions occurring under your account.</p>

          <h6>Modification or suspension of our website</h6>
          <p>We may at any time modify, discontinue, or suspend the operation of our website, or any part thereof, temporarily or permanently, without notice to you. </p>

          <h6>Change of ownership</h6>
          <p>If we are in the process of selling Walk Into The Wild, our website, or substantial parts of our business, you agree we may disclose and/or transfer your personally identifiable information as well as other information to the (potential) new owner so they can better value our business and, if sold, continue to operate the service this website provides. This will also be the case if the new owner is a non-EU company, organization, or individual.</p>
          <p>You also agree that in the event of a change in ownership of Walk Into The Wild or our website, the rights, obligations, and restrictions you have towards us, as outlined in this agreement, will be transferred to the new owner without notice to you, and you accept the new owner as your new counterparty in this Agreement.</p>
          <h6>Termination of this Agreement</h6>
          <p>Either party may terminate the Agreement for any reason or without cause, at any time, by notice, which shall be effective immediately or as specified in the notice. After termination, you shall no longer access Walk Into The Wild's website. The provisions of this Agreement which, by their intent or meaning, are intended to survive such termination shall continue to apply indefinitely.</p>
          <h6>Severability of Agreement</h6>
          <p>If any provision of the Agreement is deemed invalid by a court or other binding authority, you agree that every effort shall be made to uphold the parties' intentions as reflected in that provision. The remaining provisions of the Agreement, which are not affected by such invalidity, shall remain in full force and effect.</p>
          <h6>Complaints regarding content</h6>
          <p>For making complaints regarding copyright infringement of our content or regarding our content in general, please send an email to <a href="mailto:contact@walkintothewild.in">contact@walkintothewild.in</a></p>


        </div>
      </div>

    </div>
  </div>
</div>