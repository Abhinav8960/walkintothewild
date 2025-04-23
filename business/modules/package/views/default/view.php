<?php

use business\assets\AppAsset;
use common\models\GeneralModel;
use frontend\assets\FrontAppAsset;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
FrontAppAsset::register($this);
AppAsset::register($this);

$this->title = 'Package : ' . $package->package_name;
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <div class="btn-delet float-end" style="position: relative;">
            <a href="<?= Url::toRoute(['copy-package', 'id' => $package->id]) ?>" style="background:#4287f5 !important;color:white !important;padding: 10px 16px !important; border:0; border-radius:10px;  margin-right:6px;">
                <i class="fa-solid fa-copy" style="margin-right: 6px;"></i> Copy
            </a>

        </div>

        <section class="bg-white pt-4">
            <div class="container-lg">
                <div class="row my-4 packageSfari">
                    <div class="col-12">
                        <div class="imagesSafari">
                            <img src="<?= isset($package->imagebannerpath) ? $package->imagebannerpath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" alt="" class="w-100">
                        </div>
                        <div class="wrapper-skybgsafri pb-0" style="background-color: #F5F5F5 !important;">
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
                                                <p class="mb-0 ">Organized by <strong><?= isset($package->safarioperator->business_name) ? $package->safarioperator->business_name : '' ?></strong></p>
                                            </div>

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
                                                        <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                                    <?php } else if ($package->package_agenda_id && $package->package_agenda_id == 3) { ?>
                                                        <img src="<?= $this->params['baseurl'] ?>/img/elephant.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                                    <?php } else { ?>
                                                        <img src="<?= $this->params['baseurl'] ?>/img/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
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


                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 m-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap pt-lg-0 pt-sm-3 pt-3">
                                        <div class="pakageCost mb-xxl-0 mb-2">
                                            <h6 class="fs-4 mb-0 fw-bold"><img src="<?= $this->params['baseurl'] ?>/img/rupees.png" alt="" width="20px" class="me-1 mb-1"><?= number_format($package->total_price) ?> / <span class="perpersonText">Per Person</span></h6>
                                        </div>
                                        <div class="btn-delet float-end py-2">
                                            <!-- <a style="background:#F7BF39 !important;color:black !important;padding: 10px 16px !important; border:0; border-radius:10px" href="<?= \yii\helpers\Url::toRoute(['/package/preview/update', 'id' => $package->id]) ?>"><i class="fas fa-check me-1"></i>Mark Package As Pouplar</a>
                                    <button class="btn_userarticle" style="background:red !important;color:black !important;padding: 10px 16px !important; border:0; border-radius:10px" value="<?= \yii\helpers\Url::toRoute(['/package/preview/delete', 'id' => $package->id]) ?>"><i class="fas fa-trash me-1"></i>Delete</button> -->
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
                                    <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq-tab-pane" type="button" role="tab" aria-controls="faq-tab-pane" aria-selected="false" tabindex="-1">FAQ</button>
                            </li> -->
                                </ul>

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

                        </div>


                    </div>

                    <div class="col-lg-3 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4>Versions</h4>
                                <hr>
                                <div>
                                    <?php if ($package->versions) {
                                        foreach ($package->versions as $v) { ?>
                                            <a href="<?= Url::toRoute(['view', 'id' => $v->id]) ?>">
                                                <h5><?= $v->version ?>-<?= $v->statusLabel ?></h5>
                                            </a>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        </section>
    </div>
</div>

<div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail for Delete</h1>

            </div>
            <div class="modal-body px-2 pt-0">
                <div id='userstatusmodalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS

function organizefunction() {
	$('.btn_userarticle').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#userstatusmodalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();
JS;
$this->registerJs($script);
?>
<style>
    .disclaimer {
        top: 2375px;
        left: 303px;
        width: 687px;
        height: 148px;
        text-align: left;
        font: normal normal normal 16px/25px Roboto;
        letter-spacing: 0px;
        color: #151C2C;
        opacity: 1;


    }
</style>