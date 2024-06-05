<?php


/* @var $this yii\web\View */

$this->title = 'Safari ' . $model->title;
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/articlebanner.png" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/banner-share.png" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 ">
                    <div class="tab-block" id="tab-block">
                        <ul class="tab-mnu">
                            <li class="active"> <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="" width="26" class="me-2">Safari</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="" width="26" class="me-2">Birding</li>
                            <li> <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="" width="26" class="me-2"> Resort</li>
                        </ul>

                        <div class="tab-cont">
                            <div class="tab-pane">
                                <div class="row gx-0">
                                    <div class="col-lg-10 col-xl-11">
                                        <div class="select_searcjBox d-md-flex flex-wrap align-items-center gap-1 w-100">
                                            <div class="select_boxes position-relative">
                                                <select class="form-select form-select-lg" aria-label="Large select example">
                                                    <option selected>North india, South...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                                <div class="placeholder_select">
                                                    <p>Location</p>
                                                </div>
                                                <div class="icons_select">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/location_7508941.png" alt="">
                                                </div>
                                            </div>
                                            <div class="select_boxes position-relative">
                                                <select class="form-select form-select-lg " aria-label="Large select example">
                                                    <option selected>May,june,July..</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                                <div class="placeholder_select">
                                                    <p>Month</p>
                                                </div>
                                                <div class="icons_select">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/calendar_747310.png" alt="">
                                                </div>
                                            </div>
                                            <div class="select_boxes position-relative">
                                                <select class="form-select form-select-lg " aria-label="Large select example">
                                                    <option selected>Tiger Elephent..</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                                <div class="placeholder_select">
                                                    <p>Animal</p>
                                                </div>
                                                <div class="icons_select">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/safaritigericon.png" alt="">
                                                </div>
                                            </div>
                                            <div class="select_boxes position-relative">
                                                <select class="form-select form-select-lg " aria-label="Large select example">
                                                    <option selected>Gypsy,Bus...</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                                <div class="placeholder_select">
                                                    <p>Vehicel</p>
                                                </div>
                                                <div class="icons_select">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/safari_4391688.png" alt="">
                                                </div>
                                            </div>
                                            <div class="advanceSearch " id="advanceSearchBox">
                                                <div class="d-md-flex gap-1">
                                                    <div class="select_boxes position-relative">
                                                        <select class="form-select form-select-lg " aria-label="Large select example">
                                                            <option selected>Tiger Elephent..</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                        <div class="placeholder_select">
                                                            <p>Accommodation</p>
                                                        </div>
                                                        <div class="icons_select">
                                                            <img src="<?= $this->params['baseurl'] ?>/img/resort_11834952.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="select_boxes position-relative">
                                                        <select class="form-select form-select-lg " aria-label="Large select example">
                                                            <option selected>Gypsy,Bus...</option>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                        <div class="placeholder_select">
                                                            <p>Safari seasion</p>
                                                        </div>
                                                        <div class="icons_select">
                                                            <img src="<?= $this->params['baseurl'] ?>/img/day-night_8776508.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-xl-1">
                                        <div class="search">
                                            <div class="serch_btn">
                                                <button>Search</button>
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
<section class="articals_wrapper py-3">
    <div class="container-fluid">
        <div class="row mb-5 pb-4">
            <div class="col-lg-12 safartabs">
                <ul class="nav nav-tabs d-none d-lg-flex gap-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">OVERVIEW</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">ABOUT PARK</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">FLORA & FAUNA</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="howto-reach" data-bs-toggle="tab" data-bs-target="#howto-reach-pan" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">HOW TO REACH</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="map-tab" data-bs-toggle="tab" data-bs-target="#map-tab-pane" type="button" role="tab" aria-controls="map-tab-pane" aria-selected="false">MAP</button>
                    </li>
                </ul>
                <div class="tab-content accordion" id="myTabContent">
                    <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <?= $this->render('_overview', [
                            'model' => $model,
                        ]) ?>
                    </div>
                    <div class="tab-pane fade accordion-item" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <?= $this->render('_about', [
                            'model' => $model,
                        ]) ?>
                    </div>
                    <div class="tab-pane fade accordion-item" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <?= $this->render('_florafauna', [
                            'model' => $model,
                        ]) ?>
                    </div>
                    <div class="tab-pane fade accordion-item" id="howto-reach-pan" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
                        <?= $this->render('_howtoreach', [
                            'model' => $model,
                        ]) ?>
                    </div>
                    <div class="tab-pane fade accordion-item" id="map-tab-pane" role="tabpanel" aria-labelledby="map-tab" tabindex="0">
                        <?= $this->render('_map', [
                            'model' => $model,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7 mb-4">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-lg-4 col-xl-3 col-xxl-2 mb-4">
                <div class="filter-wrapper">
                    <div class="title_top pb-4">
                        <h4>Select Filters</h4>
                    </div>
                    <div class="title_filter mb-4">
                        <h6>Operator Rating</h6>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <div class="start d-flex gap-2">
                                <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                                <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                                <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                                <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                            </div>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <div class="start d-flex gap-2">
                                <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                                <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                                <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>

                            </div>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <div class="start d-flex gap-2">
                                <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>
                                <label for="text" class=" text_check"><i class="fa-solid fa-star"></i></label>

                            </div>

                        </div>
                    </div>
                    <div class="title_filter mb-4">
                        <h6>Operator Credibility</h6>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Registered Company</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Has a Website</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Offers Other Wildlife Activities</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Has Cancellation Policy</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Wildlife Photographer</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Wildlife Influencer</label>

                        </div>
                    </div>
                    <div class="title_filter mb-4">
                        <h6>Budget</h6>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Premium</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Standard</label>

                        </div>
                        <div class="input_check d-flex gap-3 align-items-center">
                            <input type="checkbox" name="" id="text" class="checkbox_design">
                            <label for="text" class=" text_check">Economical</label>

                        </div>

                    </div>

                </div>
                <div class="advertisment pt-5">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box-2">

                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9 col-xxl-10">
                <div class="col-12">
                    <div class="topfilter d-md-flex justify-content-between align-items-center w-100">
                        <div class="left_text">
                            <p class="">There are currently <strong>121</strong> active shared safaris created by individuals</p>
                        </div>
                        <div class="right-select d-flex gap-2 align-items-center">
                            <div class="input_check pb-0">

                                <select class="form-select mb-2" aria-label="Default select example">
                                    <option selected>Sort By: Created Recently</option>
                                    <option value="1">January</option>
                                    <option value="2">Febraury</option>
                                    <option value="3">March</option>
                                </select>
                            </div>
                            <!-- <div class="gridListview">
                  <a href="#" id="toggleViewBtn"><i class="fas fa-list"></i></a>
                </div> -->
                        </div>
                    </div>
                    <div class="gridview mt-4">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-4 gx-xxl-5 g-xl-4 gx-lg-4">
                            <div class="col-lg-6 col-xl-3 mb-3">
                                <div class="listingSafari ">
                                    <div class="higlighted">
                                        <p>Highlighted</p>
                                    </div>
                                    <div class="card-body px-2">
                                        <div class="logo_provide2  p-3 border_bottom2">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                                        </div>
                                        <div class="provider_details">
                                            <h6 class="pname py-3">Pugdundee Safaris</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                                <div class="ratings">
                                                    <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">54 Google Reviews</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="footer_provider ">
                                        <div class="slect_safricound d-flex justify-content-around">
                                            <div class="parks_text text-center">
                                                <p>6</p>
                                                <p>Parks</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>7</p>
                                                <p>Resorts</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>15</p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-3">
                                <div class="listingSafari ">
                                    <div class="card-body px-2">
                                        <div class="logo_provide2  p-3 border_bottom2">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                                        </div>
                                        <div class="provider_details">
                                            <h6 class="pname py-3">Pugdundee Safaris</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                                <div class="ratings">
                                                    <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">54 Google Reviews</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="footer_provider ">
                                        <div class="slect_safricound d-flex justify-content-around">
                                            <div class="parks_text text-center">
                                                <p>6</p>
                                                <p>Parks</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>7</p>
                                                <p>Resorts</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>15</p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-3">
                                <div class="listingSafari ">
                                    <div class="card-body px-2">
                                        <div class="logo_provide2  p-3 border_bottom2">
                                            <img src="<?= $this->params['baseurl'] ?>/img/asian-adventures.jpg" alt="" class="w-100">
                                        </div>
                                        <div class="provider_details">
                                            <h6 class="pname py-3">Pugdundee Safaris</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                                <div class="ratings">
                                                    <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">54 Google Reviews</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="footer_provider ">
                                        <div class="slect_safricound d-flex justify-content-around">
                                            <div class="parks_text text-center">
                                                <p>6</p>
                                                <p>Parks</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>7</p>
                                                <p>Resorts</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>15</p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-3">
                                <div class="listingSafari ">
                                    <div class="card-body px-2">
                                        <div class="logo_provide2  p-3 border_bottom2">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                                        </div>
                                        <div class="provider_details">
                                            <h6 class="pname py-3">Pugdundee Safaris</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                                <div class="ratings">
                                                    <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">54 Google Reviews</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="footer_provider ">
                                        <div class="slect_safricound d-flex justify-content-around">
                                            <div class="parks_text text-center">
                                                <p>6</p>
                                                <p>Parks</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>7</p>
                                                <p>Resorts</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>15</p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-3">
                                <div class="listingSafari ">
                                    <div class="card-body px-2">
                                        <div class="logo_provide2  p-3 border_bottom2">
                                            <img src="<?= $this->params['baseurl'] ?>/img/asian-adventures.jpg" alt="" class="w-100">
                                        </div>
                                        <div class="provider_details">
                                            <h6 class="pname py-3">Pugdundee Safaris</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                                <div class="ratings">
                                                    <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">54 Google Reviews</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="footer_provider ">
                                        <div class="slect_safricound d-flex justify-content-around">
                                            <div class="parks_text text-center">
                                                <p>6</p>
                                                <p>Parks</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>7</p>
                                                <p>Resorts</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>15</p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-3">
                                <div class="listingSafari ">
                                    <div class="card-body px-2">
                                        <div class="logo_provide2  p-3 border_bottom2">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                                        </div>
                                        <div class="provider_details">
                                            <h6 class="pname py-3">Pugdundee Safaris</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                                <div class="ratings">
                                                    <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">54 Google Reviews</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="footer_provider ">
                                        <div class="slect_safricound d-flex justify-content-around">
                                            <div class="parks_text text-center">
                                                <p>6</p>
                                                <p>Parks</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>7</p>
                                                <p>Resorts</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>15</p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-3">
                                <div class="listingSafari ">
                                    <div class="card-body px-2">
                                        <div class="logo_provide2  p-3 border_bottom2">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100">
                                        </div>
                                        <div class="provider_details">
                                            <h6 class="pname py-3">Pugdundee Safaris</h6>
                                            <div class="providerNamerating d-flex gap-4 align-items-center pb-3">

                                                <div class="ratings">
                                                    <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                                                </div>
                                                <div class="googlerating">
                                                    <p class="mb-0">54 Google Reviews</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="footer_provider ">
                                        <div class="slect_safricound d-flex justify-content-around">
                                            <div class="parks_text text-center">
                                                <p>6</p>
                                                <p>Parks</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>7</p>
                                                <p>Resorts</p>
                                            </div>
                                            <div class="parks_text text-center">
                                                <p>15</p>
                                                <p>Shared Safari</p>
                                            </div>
                                        </div>
                                        <div class="get_quote text-center">
                                            <a href="tour-oprators.html" class="get_quote_btn">GET A FREE QUOTE</a>
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
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
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
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
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
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
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
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
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
                    <p>Gir National Park is the only place in the world outside Africa where a lion can be seen in its natural
                        habitat.</p>
                </div>
                <div class="link"><a href="deer.html"><i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
    </div>
</section>