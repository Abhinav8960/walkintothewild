<?php

use common\models\GeneralModel;
use common\models\package\PackageIncluded;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Package : ' . $package->package_name;
$this->params['title'] = $this->title;
?>



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
<section class="safari_wrapper  bg-white pt-4">
    <div class="container-lg">
        <div class="row my-4 packageSfari">
            <div class="col-12">
                <div class="imagesSafari">
                    <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" class="w-100">
                </div>
                <div class="wrapper-skybgsafri pb-0">
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
                                        <!-- <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($package->start_date)) ?> - <?= date('d M y', strtotime($package->end_date)) ?></h6>
                                        </div> -->
                                        <p class="mb-0 ">Organized by <a href="https:/adasdsad.asdp" target="_blank"><strong><?= isset($package->user) ? $package->user->name : '' ?></strong></a></p>

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
                                            <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Vechile">
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
                                            <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Vechile">
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
                                            <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="">
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
                                            <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Photography Special">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">Photography Special</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= isset($package->stay_category_id) ? GeneralModel::packageoption()[$package->stay_category_id] : '' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-md-4 align-items-center gx-4 border_bottom2 pb-4">
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
                                    <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px"><?= $package->cost_per_person ?> +GST</h6>
                                </div>
                                <div class="btn_wrap float-lg-end pt-lg-0 pt-3">
                                    <a class="join_btn  mt-sm-0 mt-2" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalenquiry" data-bs-whatever="@mdo">Book Now</a>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="row">
                        <div class="col-12 pt-4">
                            <div class="text_safaripackage">
                                <p>Five Tiger Reserve Tour covers all the tiger reserves of Madhya Pradesh and is ideal for a wildlife enthusiast not wanting to miss out anything. This tour covers Panna - Bandhavgarh - Kanha - Pench – Satpura national parks spreading across the complete length & breadth of the state. This is a holistic wildlife experience offering the very best of Central India. Trip not only offers high chance of Royal Bengal Tiger but also provides with an opportunity to explore the diverse flora & fauna of Central India with each park offering a unique habitat.</p>
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

<section class="safari_wrapper mb-5">
    <div class="container-lg">
        <div class="row mb-5  mt-4 itenary_tabs">
            <div class="col-lg-9 col-xl-9 safartabs position-relative">
                <div class="tab-content accordion" id="myTabContent">
                    <div class="tab-pane fade show active accordion-item mb-3" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <h2 class="accordion-header d-lg-none" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">ITENARY</button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse bg-set collapse show  d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
                            <div class="accordion-body p-3">
                                <div class="col-lg-12 mb-3">
                                    <div class="itenary-title">
                                        <h6 class="fs-6 fw-bold pb-2">ABOUT TRIP / OVERVIEW</h6>
                                    </div>
                                    <div class="itenary_text">
                                        <p><?= $package->package_description ?></p>
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
                        <div id="collapseTwo" class="accordion-collapse collapse  bg-set d-lg-block" aria-labelledby="headingTwo" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">
                                <?= $this->render('_inclusion', ['package' => $package]) ?>
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
                        <div id="collapseFour" class="accordion-collapse bg-set collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">
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
                        <div id="collapseFour" class="accordion-collapse  bg-set collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">
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
                        <div id="collapseFive" class="accordion-collapse bg-set collapse d-lg-block" aria-labelledby="headingFive" data-bs-parent="#myTabContent">
                            <div class="accordion-body height_set">
                                <?= $this->render('_faq', ['faqs' => $faqs]) ?>
                            </div>
                        </div>
                        <!-- Rendered on 2024-07-09 13:16:37 -->
                    </div>
                </div>
                <div class="desclaimers pb-3">
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
                <?= $this->render('_comment', ['package' => $package, 'model' => $model, 'replymodel' => $replymodel]) ?>
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

                            <div class="right_button py-lg-5 py-3 d-lg-block d-none">
                                <a class="btn_newsafari organizeBtn w-100" href="/package/profile/<?= $package->id ?>"><i class="fas fa-edit me-1"></i>Update Package</a>
                            </div>
                    <?php }
                    } ?>
                <?php } else { ?>
                    <p>Please Login to Request Quote</p>
                <?php } ?>

                <div class="request_quote mt-4">
                        <button class="intested_btn interestBtn " value="#" style="background-color: var(--background-primary) !important;">
                        Photo Gallery 10</button>
                        <div class="interst_wrapper p-0 bg-white">
                            <div class="photoSlider owl-carousel owl-theme">
                                <div class="items_img">
                                <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" width="100%">
                                </div>
                                <div class="items_img">
                                <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" width="100%">
                                </div>
                                <div class="items_img">
                                <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" width="100%">
                                </div>
                                <div class="items_img">
                                <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" width="100%">
                                </div>
                                <div class="items_img">
                                <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" width="100%">
                                </div>
                                <div class="items_img">
                                <img src="<?= $this->params['baseurl'] ?>/img/Bandhavgarhbig.jpg" alt="" width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade modal_enquiry" id="exampleModalenquiry" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-md">
        <div class="modal-content">
            <!-- <div class="modal-header justify-content-center">
      
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
            <div class="modal-body">
                <h1 class="modal-title fs-5 text-center pb-3" id="exampleModalLabel">Enquire</h1>
                <form>
                    <div class="row ">
                        <div class="col-lg-4 mb-3">
                            <div class="form-wrapper d-flex gap-3">
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
                        <div class="col-lg-4 mb-3">
                            <div class="form-wrapper">
                                <label for="">Start Date</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <div class="form-wrapper">
                                <label for="">End Date</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12 mb">
                            <div class="form-wrapper mb-3">
                                <label for="">Full Name</label>
                                <input type="text" class="form-control" placeholder="Your name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-wrapper mb-3">
                                <label for="">Email Address</label>
                                <input type="text" class="form-control" placeholder="xyz@abc.com">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-wrapper mb-3">
                                <label for="">Phone Number</label>
                                <input type="text" class="form-control" placeholder="+91">
                            </div>
                        </div>
                    
                      
                    </div>
                    <div class="row align-items-center">
                    <div class="col-md-7">
                            <div class="text_get termsConditioncheck d-flex gap-2">
                                <input type="checkbox" id="chekcs">
                                <label for="chekcs">I agree to the terms and conditions.</label>
                            </div>
                        </div>
                        <div class="col-md-5  pt-lg-0 pt-3">
                            <button class="sent_btn">Send Request</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div> -->
        </div>
    </div>
</div>

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