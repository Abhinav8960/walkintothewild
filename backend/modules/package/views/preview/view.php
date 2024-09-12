<?php

use common\models\GeneralModel;
use common\models\package\PackageIncluded;
use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\backend\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
FrontAppAsset::register($this);
AppAsset::register($this);

$this->title = 'Package : ' . $package->package_name;
$this->params['title'] = $this->title;
?>
<section class="safari_wrapper  bg-white pt-4">
    <div class="container-lg">
        <div class="row my-4 packageSfari">
            <div class="col-12">
                <div class="imagesSafari">
                    <img src="<?= isset($package->imagebannerpath) ? $package->imagebannerpath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="" class="w-100">
                </div>
                <div class="wrapper-skybgsafri pb-0">
                    <div class="row border_bottom2 pb-4">
                        <div class="col-lg-7 col-md-8 border-right">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="images_tour select_safrai">
                                        <img src="<?= isset($package->safarioperator->imagepath) ? $package->safarioperator->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-8 pt-sm-0 pt-3">
                                    <div class="safrititles">
                                        <h5 class="fs-4"><?= $package->package_name ?></h5>
                                        <!-- <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($package->start_date)) ?> - <?= date('d M y', strtotime($package->end_date)) ?></h6>
                                        </div> -->
                                        <p class="mb-0 ">Organized by <strong><?= isset($package->safarioperator->business_name) ? $package->safarioperator->business_name : '' ?></strong></p>

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
                                            <img src="<?= $this->params['baseurl'] ?>/img/path.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            $package_includes = PackageIncluded::find()->where(['package_id' => $package->id, 'include_id' => 2, 'selection' => 1, 'status' => 1])->limit(1)->one();

                                                            echo ($package_includes) ? 'Meals' : '';
                                                            ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 ">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Photography Special">
                                        </div>
                                        <?php if ($package->packagefeatures) {
                                            foreach ($package->packagefeatures as $features) { ?>
                                                <div class="text-form">
                                                    <p class="mb-0"><?= $features->featurename->title ?></p>
                                                </div>
                                        <?php }
                                        } ?>
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


            </div>
            <?php if ($package->packagegallery) {
                $galleries = $package->packagegallery;
            ?>
                <div class="col-xl-3 col-lg-3 mb-5 pb-4">
                    <div class="request_quote">
                        <div class="request_quote mt-4">
                            <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;">
                                Photo Gallery <span>10</span></button>
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
                    </div>
                </div>
            <?php } ?>
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