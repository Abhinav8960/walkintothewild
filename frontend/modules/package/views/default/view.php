<?php

use common\models\GeneralModel;
use common\models\package\PackageIncluded;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Package : ' . $package->package_name;
$this->params['title'] = $this->title;
?>


<div class="fixedbanner">
    <section class="banner_section-inner  position-relative">
        <picture class="position-relative">
            <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" media="(max-width:576px)" type="image/webp">
            <img src=" <?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" class="d-block w-100 banner_search" alt="banner">
        </picture>
        <div class="banner_searchBox">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="headingBnner_inner">
                            <h1><?= $package->package_name ?></h1>
                            <p class="text-center text-white">Organized by <?= isset($package->user) ? $package->user->name : '' ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>



<section class="safari_wrapper margin-setposi py-3 py-3 mb-5">
    <div class="container-lg">
        <div class="row my-4 packageSfari">
            <div class="col-12">
                <div class="imagesSafari">
                    <img src="<?= $this->params['baseurl'] ?>/img/FESHwr.jpg" alt="" class="w-100">
                </div>
                <div class="wrapper-skybgsafri">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-7 col-md-8 border-right">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="images_tour select_safrai">
                                        <img src="<?= $package->imagepath ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-8 pt-sm-0 pt-3">
                                    <div class="safrititles">
                                        <h5 class="fs-4"><a href="/park/satpura-tiger-reserve">Satpura Tiger Reserve </a></h5>
                                        <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($package->start_date)) ?> - <?= date('d M y', strtotime($package->end_date)) ?></h6>
                                        </div>
                                        <p class="mb-0 pt-2">Organized by <a href="https:/adasdsad.asdp" target="_blank"><strong><?= isset($package->user) ? $package->user->name : '' ?></strong></a></p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-lg-none mobile_didplay_none">
                            <div class="btn_wrap d-flex flex-column ">

                                <a class="join_btn text-center mt-sm-0 mt-2" href="/sharedsafari/default/join?slug=vikas-chaudhary-8eb1ec-251720186292-shared-safari">Join Safari</a>

                            </div>
                        </div>
                        <div class="col-lg-5 pt-lg-0 pt-4">
                            <div class="row px-sm-4 px-0">
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="http://app.walkintothewild.io/assets/5a869828/img/hotel_forest_location.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $package->no_of_night ?> Nights , <?= $package->no_of_day ?> Days</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="http://app.walkintothewild.io/assets/5a869828/img/gypsycanter.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            $pick_drop_includes = PackageIncluded::find()->where(['package_id' => $package->id, 'include_id' => 6, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($pick_drop_includes) ? 'Pick & Drop' : '';
                                                            ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="http://app.walkintothewild.io/assets/5a869828/img/railway.png" alt="">
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
                                            <img src="http://app.walkintothewild.io/assets/5a869828/img/railway.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            $package_includes = PackageIncluded::find()->where(['package_id' => $package->id, 'include_id' => 2, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($package_includes) ? 'All meals' : '';
                                                            ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="http://app.walkintothewild.io/assets/5a869828/img/railway.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">Vlogging</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="http://app.walkintothewild.io/assets/5a869828/img/railway.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= isset($package->stay_category_id) ? GeneralModel::packageoption()[$package->stay_category_id] : '' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-md-4 align-items-center gx-4">

                        <div class="col-lg-7">
                            <div class="social-share d-flex gap-2 align-items-center justify-content-lg-start justify-content-between  ">
                                <p>Share this event with your friends:</p>
                                <div class="sociel_icons ps-3">
                                    <ul>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fstaging.walkintothewild.in%2Fsharedsafari%2Fvikas-chaudhary-8eb1ec-251720186292-shared-safari" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                                        </li>
                                        <li><a href="https://wa.me/?text=http%3A%2F%2Fstaging.walkintothewild.in%2Fsharedsafari%2Fvikas-chaudhary-8eb1ec-251720186292-shared-safari" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                                        </li>
                                        <li><a href="https://twitter.com/intent/tweet?url=http%3A%2F%2Fstaging.walkintothewild.in%2Fsharedsafari%2Fvikas-chaudhary-8eb1ec-251720186292-shared-safari" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                                        </li>
                                        <li><a href="https://www.instagram.com/?url=http%253A%252F%252Fstaging.walkintothewild.in%252Fsharedsafari%252Fvikas-chaudhary-8eb1ec-251720186292-shared-safari" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 d-lg-block  mobile_didplay_block">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="pakageCost">
                                    <h6 class="fs-4 mb-0"><?= $package->cost_per_person ?> +GST</h6>
                                </div>
                                <div class="btn_wrap float-lg-end pt-lg-0 pt-3">
                                    <a class="join_btn  mt-sm-0 mt-2" href="#">Book Now</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4 mt-5 justify-content-center mt-4 itenary_tabs">
            <div class="col-lg-12 col-xl-11 safartabs position-relative">
                <ul class="nav nav-tabs d-none d-lg-flex gap-2" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">ITINERARY</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" tabindex="-1">INCLUSIONS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" tabindex="-1">EXCLUSIONS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="howto-reach" data-bs-toggle="tab" data-bs-target="#howto-reach-pan" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false" tabindex="-1">TERMS & CONDITIONS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq-tab-pane" type="button" role="tab" aria-controls="faq-tab-pane" aria-selected="false" tabindex="-1">FAQ</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="accomodation-tab" data-bs-toggle="tab" data-bs-target="#accomodation-tab-pane" type="button" role="tab" aria-controls="accomodation-tab-pane" aria-selected="false" tabindex="-1">ACCOMODATION</button>
                    </li>
                </ul>
                <div class="tab-content accordion" id="myTabContent">
                    <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Overview</button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show  d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
                            <div class="accordion-body p-3">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="itenary-title">
                                            <h6 class="fs-5 pb-2">ABOUT TRIP / OVERVIEW</h6>
                                        </div>
                                        <div class="itenary_text">

                                            <p><?= $package->package_description ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="itenary-title">
                                            <h6 class="fs-5 pb-2">LOCATION</h6>
                                        </div>
                                        <div class="itenary_text">
                                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.627337221733!2d77.36012777632219!3d28.61095457567664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d054809ac1cc3%3A0xf081c1e27610b8f2!2sTriline%20Infotech%20Pvt.%20Ltd.!5e0!3m2!1sen!2sin!4v1720531973102!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <div class="col-12 inner_accordion">
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <?php if ($package->packagedays) {
                                                $packagedays = $package->packagedays;
                                                foreach ($packagedays as $packageday) { ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="flush-heading<?= $packageday->day ?>">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $packageday->day ?>" aria-expanded="false" aria-controls="flush-collapse<?= $packageday->day ?>">
                                                                DAY <?= $packageday->day ?> - <?= $packageday->day_title ?>
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapse<?= $packageday->day ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $packageday->day ?>" data-bs-parent="#accordionFlushExample">
                                                            <div class="accordion-body">
                                                                <div class="wrap_days">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="days_title">
                                                                                <h4 class="fs-5">Nights jim corbett tiger</h4>
                                                                            </div>
                                                                            <div class="text_wrapperite">
                                                                                <p><?= $packageday->day_description ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-4 mb-3">
                                                                            <div class="titles_locations">
                                                                                <h6 class="fs-5">Start Location</h6>
                                                                                <p><?= $packageday->start_location ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 mb-3">
                                                                            <div class="titles_locations">
                                                                                <h6 class="fs-5">End Location</h6>
                                                                                <p><?= $packageday->end_location ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 mb-3">
                                                                            <div class="titles_locations">
                                                                                <h6 class="fs-5">Hotel Stay Home</h6>
                                                                                <p><?= $packageday->hotel_name ?></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="titles_locations">
                                                                                <h6 class="fs-5">Meal</h6>
                                                                                <div class="mealchecks d-flex gap-4 align-items-center">
                                                                                    <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                                                                        <input type="checkbox" id="check" <?= ($packageday->meal_breakfast == 1) ? 'checked' : '' ?>>
                                                                                        <label for="check">Breackfast</label>
                                                                                    </div>
                                                                                    <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                                                                        <input type="checkbox" id="check2" <?= ($packageday->meal_lunch == 1) ? 'checked' : '' ?>>
                                                                                        <label for="check2">Lunch</label>
                                                                                    </div>
                                                                                    <div class="inputsCheck mb-2 d-flex  align-items-center gap-2 ">
                                                                                        <input type="checkbox" id="check3" <?= ($packageday->meal_dinner == 1) ? 'checked' : '' ?>>
                                                                                        <label for="check3">Dinner</label>
                                                                                    </div>
                                                                                    <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                                                                        <input type="checkbox" id="check4" <?= ($packageday->meal_breakfast == 1 && $packageday->meal_lunch == 1 && $packageday->meal_dinner == 1) ? 'checked' : '' ?>>
                                                                                        <label for="check4">All</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="titles_locations pt-4">
                                                                        <h6 class="fs-5">Images</h6>
                                                                    </div>

                                                                    <div class="row pt-2">
                                                                        <div class="col-lg-4 mb-2">
                                                                            <div class="hotelImages">
                                                                                <img src="<?= isset($packageday->day_image) ? $packageday->imagepath : $this->params['baseurl'] . '/img/FESHwr.jpg' ?>" alt="" class="w-100">
                                                                            </div>
                                                                        </div>
                                                                        <?php

                                                                        $latitude = $packageday->latitude;
                                                                        $longitude = $packageday->longitude;

                                                                        $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es;z=14&output=embed";

                                                                        if (!empty($latitude) && !empty($longitude)) {
                                                                        ?>
                                                                            <div class="col-lg-4 mb-2">
                                                                                <div class="hotelImages">

                                                                                    <iframe width="400" height="200" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
                                                                                    </iframe>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                About Park
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingTwo" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">
                                <div class="itenary_text">
                                    <p><?= $package->package_inclusion ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                FLORA &amp; FAUNA
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingThree" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">
                                <div class="itenary_text">
                                    <p><?= $package->package_exclusion ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item" id="howto-reach-pan" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                HOW TO REACH
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">
                                <?php if ($package->package_terms_condtition) { ?>
                                    <div class="itenary-title">
                                        <h6 class="fs-5 pb-2">Terms <Cc:ie></Cc:ie>ondtition</h6>
                                    </div>
                                <?php } ?>
                                <div class="itenary_text">
                                    <p><?= $package->package_terms_condtition ?></p>
                                </div>

                                <?php if ($package->privacy_policy) { ?>
                                    <div class="itenary-title">
                                        <h6 class="fs-5 pb-2">Privacy Policy</h6>
                                    </div>
                                <?php } ?>
                                <div class="itenary_text">
                                    <p><?= $package->privacy_policy ?></p>
                                </div>
                                <?php if ($package->change_policy) { ?>
                                    <div class="itenary-title">
                                        <h6 class="fs-5 pb-2">Change Policy</h6>
                                    </div>
                                <?php } ?>
                                <div class="itenary_text">
                                    <p><?= $package->change_policy ?></p>
                                </div>
                                <?php if ($package->what_you_must_carry) { ?>
                                    <div class="itenary-title">
                                        <h6 class="fs-5 pb-2">What You Must Carry</h6>
                                    </div>
                                <?php } ?>
                                <div class="itenary_text">
                                    <p><?= $package->what_you_must_carry ?></p>
                                </div>
                                <?php if ($package->date_change_policy) { ?>
                                    <div class="itenary-title">
                                        <h6 class="fs-5 pb-2">Date Change Policy</h6>
                                    </div>
                                <?php } ?>
                                <div class="itenary_text">
                                    <p><?= $package->date_change_policy ?></p>
                                </div>
                                <?php if ($package->refund_policy) { ?>
                                    <div class="itenary-title">
                                        <h6 class="fs-5 pb-2">Refund Policy</h6>
                                    </div>
                                <?php } ?>
                                <div class="itenary_text">
                                    <p><?= $package->refund_policy ?></p>
                                </div>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item" id="faq-tab-pane" role="tabpanel" aria-labelledby="faq-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                FAQ
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingFive" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">

                                <?php if ($faqs) {
                                    $i = 1;
                                    foreach ($faqs as $faq) {
                                ?>
                                        <div class="itenary-title">
                                            <h6 class="fs-5 pb-2"><?= $i . '. ' ?> <?= $faq->question ?></h6>
                                        </div>
                                        <div class="itenary_text">
                                            <p><?= $faq->answer ?></p>
                                        </div>
                                <?php
                                        $i++;
                                    }
                                } ?>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                    <div class="tab-pane fade accordion-item" id="accomodation-tab-pane" role="tabpanel" aria-labelledby="accomodation-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                ACCOMODATION
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingFive" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">


                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                </div>


            </div>
        </div>
        <div class="row mb-4 mt-5 justify-content-center mt-4 itenary_tabs">

            <?= $this->render('_comment', ['package' => $package, 'model' => $model, 'replymodel' => $replymodel]) ?>

            <div class="col-lg-3 order-lg-2 order-1 mb-lg-0 mb-3">
                <?php if (Yii::$app->user->identity) { ?>

                    <button class="intested_btn interestBtn " value="#" style="background-color: var(--background-primary) !important;">
                        Request Quote</button>
                    <div class="interst_wrapper">
                        <div class="users_profile d-flex gap-3 align-items-center flex-wrap">
                            <?= $this->render('_quote', ['packagemodel' => $packagemodel]) ?>

                        </div>
                    </div>
                    <div class="right_button py-lg-5 py-3 d-lg-block d-none">
                        <a class="btn_newsafari organizeBtn w-100" href="/package/profile/<?= $package->id ?>"><i class="fas fa-edit me-1"></i>Update Package</a>
                    </div>
                <?php } else { ?>
                    <p>Please Login to Request Quote</p>
                <?php } ?>
            </div>

        </div>
        <div class="row mb-4 mt-5 justify-content-center mt-4 itenary_tabs">
            <div class="col-lg-9 mb-3 mt-5">
                <div class="itenary-title">
                    <h6 class="fs-5 pb-2">Disclaimer</h6>
                </div>
                <div class="itenary_text">
                    <ul>
                        <li>This tour is operated by Eagle Safaris and not by Walk Into The Wild.</li>
                        <li>Eagle Safaris reserves the right to adjust the rates advertised by Walk Into The Wild.</li>
                        <li>The specific itinerary, inclusions, and pricing of this tour are dependent on availability.</li>
                        <li>In the event that accommodations are fully booked, Eagle Safaris will propose a suitable alternative.</li>
                        <li>This tour is governed by the terms and conditions set forth by Walk Into The Wild.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


</section>

<?php
$script = <<< JS

       
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